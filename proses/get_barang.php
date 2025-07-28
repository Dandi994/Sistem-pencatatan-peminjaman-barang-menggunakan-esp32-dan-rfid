<?php
include 'koneksi.php';

$query = "SELECT * FROM tb_barang WHERE stok_tersedia > 0";
$result = mysqli_query($koneksi, $query);

$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        'id_barang' => $row['id_barang'],
        'nama_barang' => $row['nama_barang'],
        'jenis_barang' => $row['jenis_barang']
    ];
}

echo json_encode($data);
