<?php
include 'koneksi.php';

date_default_timezone_set('Asia/Jakarta');

$jam_sekarang = date('H:i:s');

if ($jam_sekarang >= '21:00:00') {
    $query = "UPDATE tb_peminjaman 
              SET status = 'Belum Dikembalikan' 
              WHERE status = 'Dipinjam' 
              AND DATE(tgl_peminjaman) <= CURDATE()";

    mysqli_query($koneksi, $query);
}
