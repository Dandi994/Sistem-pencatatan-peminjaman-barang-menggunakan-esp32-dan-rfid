<?php
include 'koneksi.php';

function redirectWithAlert($msg)
{
    echo "<script>alert('$msg'); window.location.href='../peminjamanBarang.php';</script>";
    exit();
}

// Ambil data dari form
$uid         = $_POST['uid'] ?? '';
$semester    = $_POST['semester'] ?? '';
$barang_ids  = $_POST['barang'] ?? [];     // array id_barang
$jumlahs     = $_POST['jumlah'] ?? [];     // array jumlah
$tanggal     = date("Y-m-d");
$status      = "Dipinjam";

// Validasi awal
if (!$uid || !$semester || empty($barang_ids) || empty($jumlahs)) {
    redirectWithAlert('Semua data harus diisi.');
}

// Ambil ID dari tb_card berdasarkan UID
$result = mysqli_query($koneksi, "SELECT id FROM tb_card WHERE uid='$uid'");
$data   = mysqli_fetch_assoc($result);

if (!$data) {
    redirectWithAlert('Kartu tidak terdaftar.');
}

$id_card = $data['id']; // nilai yang disimpan di tb_peminjaman.uid_peminjam

// Proses setiap barang yang dipinjam
for ($i = 0; $i < count($barang_ids); $i++) {
    $id_barang = intval($barang_ids[$i]);
    $jml       = intval($jumlahs[$i]);

    // Cek ketersediaan stok
    $cek = mysqli_query($koneksi, "SELECT stok_tersedia FROM tb_barang WHERE id_barang = $id_barang");
    $row = mysqli_fetch_assoc($cek);

    if (!$row || $row['stok_tersedia'] < $jml) {
        redirectWithAlert("Stok tidak cukup untuk barang ID $id_barang.");
    }

    // Simpan peminjaman (satu baris per barang)
    mysqli_query($koneksi, "
        INSERT INTO tb_peminjaman (uid_peminjam, semester, kode_barang, tgl_peminjaman, status, jumlah)
        VALUES ('$id_card', '$semester', '$id_barang', '$tanggal', '$status', '$jml')
    ");

    // Update stok
    mysqli_query($koneksi, "
        UPDATE tb_barang SET stok_tersedia = stok_tersedia - $jml
        WHERE id_barang = $id_barang
    ");
}

// Hapus dari card_temp
mysqli_query($koneksi, "DELETE FROM card_temp WHERE uid = '$uid'");

redirectWithAlert('Peminjaman berhasil disimpan.');
