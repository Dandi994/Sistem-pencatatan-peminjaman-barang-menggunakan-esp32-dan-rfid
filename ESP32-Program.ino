#include <HTTPClient.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include <SPI.h>
#include <MFRC522.h>
#include <WiFi.h>

// WiFi credentials
const char* ssid = "infinix";
const char* password = "Dandii09";

// URL endpoint PHP untuk menerima UID
const char* serverName = "http://192.168.180.245/webpeminjaman/proses/receiver_uid.php";

// Inisialisasi LCD (alamat 0x27, ukuran 16x2)
LiquidCrystal_I2C lcd(0x27, 16, 2);

// Konfigurasi pin RFID dan buzzer
#define SS_PIN 5
#define RST_PIN 4
#define BUZZER_PIN 15

MFRC522 rfid(SS_PIN, RST_PIN);  // RFID RC522

void setup() {
  Serial.begin(115200);

  // Inisialisasi LCD
  lcd.begin();
  lcd.backlight();
  lcd.setCursor(0, 0);
  lcd.print("Menghubungkan");

  // Inisialisasi WiFi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Menghubungkan ke WiFi...");
    lcd.setCursor(0, 1);
    lcd.print(".");
  }
  Serial.println("Terhubung ke WiFi!");
  Serial.print("IP ESP32: ");
  Serial.println(WiFi.localIP());
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("WiFi Terhubung!");
  delay(1000);

  // Inisialisasi SPI & RFID
  SPI.begin(18, 19, 23);  // SCK, MISO, MOSI
  rfid.PCD_Init();

  // Inisialisasi buzzer
  pinMode(BUZZER_PIN, OUTPUT);
  digitalWrite(BUZZER_PIN, LOW);

  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Tempelkan Kartu");
}

void loop() {
  lcd.setCursor(0, 0);
  lcd.print("Tempelkan Kartu");
  lcd.setCursor(0, 1);
  lcd.print("                "); 

  // Cek apakah ada kartu RFID
  if (!rfid.PICC_IsNewCardPresent() || !rfid.PICC_ReadCardSerial()) {
    delay(100);
    return;
  }

  // Baca UID RFID
  String uid = "";
  for (byte i = 0; i < rfid.uid.size; i++) {
    uid += String(rfid.uid.uidByte[i] < 0x10 ? "0" : "");
    uid += String(rfid.uid.uidByte[i], HEX);
  }
  uid.toUpperCase();

  Serial.println("Membaca UID: " + uid);

  // Kirim ke server
  bool success = sendUIDtoServer(uid);

  if (success) {
    Serial.println("UID terkirim: " + uid);
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("UID Terkirim!");
    lcd.setCursor(0, 1);
    lcd.print(uid);
  } else {
    Serial.println("Gagal mengirim UID");
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("Gagal Kirim UID");
  }

  delay(2000);  // Tampilkan hasil selama 2 detik

  // Bersihkan tampilan
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Tempelkan Kartu");

  rfid.PICC_HaltA();
  rfid.PCD_StopCrypto1();
  delay(1000);
}

bool sendUIDtoServer(String uid) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin(serverName);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    String postData = "uid=" + uid;
    Serial.println("Mengirim POST: " + postData);

    int httpResponseCode = http.POST(postData);
    String responsePayload = http.getString();

    Serial.println("HTTP Response code: " + String(httpResponseCode));
    Serial.println("Server response: " + responsePayload);

    http.end();

    if (httpResponseCode == 200) {
      // Bunyikan buzzer
      digitalWrite(BUZZER_PIN, HIGH);
      delay(500);
      digitalWrite(BUZZER_PIN, LOW);
      return true;
    } else {
      Serial.print("HTTP Error: ");
      Serial.println(httpResponseCode);
    }
  } else {
    Serial.println("WiFi tidak terhubung!");
  }
  return false;
}
