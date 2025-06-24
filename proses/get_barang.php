<?php
include 'koneksi.php';

$query = "SELECT * FROM tb_barang WHERE status = 'Tersedia'";
$result = mysqli_query($koneksi, $query);

$barang = [];

while ($row = mysqli_fetch_assoc($result)) {
    $barang[] = $row;
}

echo json_encode($barang);
