<?php
include 'koneksi.php';

$idBarang = $_POST['kodeBarang'];
$namaBarang = $_POST['namaBarang'];
$jenisBarang = $_POST['jenisBarang'];
$stok_total_baru = intval($_POST['stok_total']);

// Ambil stok lama
$res = mysqli_query($koneksi, "SELECT stok_total, stok_tersedia FROM tb_barang WHERE id_barang = $idBarang");
$row = mysqli_fetch_assoc($res);

$stok_total_lama = $row['stok_total'];
$stok_tersedia_lama = $row['stok_tersedia'];

$selisih = $stok_total_baru - $stok_total_lama;
$stok_tersedia_baru = $stok_tersedia_lama + $selisih;

if ($stok_tersedia_baru < 0) $stok_tersedia_baru = 0;

$query = "UPDATE tb_barang SET 
            nama_barang = '$namaBarang', 
            jenis_barang = '$jenisBarang', 
            stok_total = $stok_total_baru, 
            stok_tersedia = $stok_tersedia_baru 
          WHERE id_barang = $idBarang";

mysqli_query($koneksi, $query);

header('Location: ../kelolaBarang.php');