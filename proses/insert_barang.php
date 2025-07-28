<?php
include 'koneksi.php';

$namaBarang = $_POST['namaBarang'];
$jenisBarang = $_POST['jenisBarang'];
$stok_total = intval($_POST['stok_total']);

$stok_tersedia = $stok_total; 

$query = "INSERT INTO tb_barang (nama_barang, jenis_barang, stok_total, stok_tersedia)
          VALUES ('$namaBarang', '$jenisBarang', '$stok_total', '$stok_tersedia')";

mysqli_query($koneksi, $query);

header('Location: ../kelolaBarang.php');
?>
