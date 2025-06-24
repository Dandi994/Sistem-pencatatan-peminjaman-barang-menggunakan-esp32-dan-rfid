<?php
include 'koneksi.php';

$kodeBarang = $_POST['kodeBarang'];
$namaBarang = $_POST['namaBarang'];
$jenisBarang = $_POST['jenisBarang'];
$status = "Tersedia";

if (!is_numeric($kodeBarang) || empty($namaBarang) || empty($jenisBarang)) {
    echo "<script type='text/javascript'>alert('Periksa kembali data yang akan di input! Pastikan nama dan jenis barang tidak kosong dan kode barang adalah angka');</script>";
    exit;
}

$query = "INSERT INTO tb_barang (id_barang, nama_barang, jenis_barang, status) VALUES ('$kodeBarang', '$namaBarang', '$jenisBarang', '$status')";
mysqli_query($koneksi, $query);

header('Location: ../kelolaBarang.php');
exit;
