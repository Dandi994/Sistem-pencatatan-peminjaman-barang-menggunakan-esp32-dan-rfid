<?php
include 'koneksi.php';
header('Content-Type: application/json');

$tgl_awal = $_GET['tgl_awal'] ?? '';
$tgl_akhir = $_GET['tgl_akhir'] ?? '';

$filter = "";
if ($tgl_awal && $tgl_akhir) {
    $filter = "WHERE p.tgl_peminjaman BETWEEN '$tgl_awal' AND '$tgl_akhir'";
}

$query = mysqli_query($koneksi, "
    SELECT p.id, c.uid, c.kelas, p.semester, b.id_barang AS kode_barang, b.nama_barang, 
           p.tgl_peminjaman, p.tgl_pengembalian, p.status
    FROM tb_peminjaman p
    JOIN tb_card c ON p.uid_peminjam = c.id
    JOIN tb_barang b ON p.kode_barang = b.id_barang
    $filter
");

$data = [];
while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

echo json_encode([
    'status' => 'success',
    'data' => $data
]);
