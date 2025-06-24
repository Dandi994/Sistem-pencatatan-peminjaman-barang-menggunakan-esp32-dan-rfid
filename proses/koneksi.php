<?php
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "db_peminjaman";

$koneksi = mysqli_connect($host, $user, $pass, $db_name);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>