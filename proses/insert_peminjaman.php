<?php
include 'koneksi.php';

function redirectWithAlert($msg)
{
    echo "<script>alert('$msg'); window.location.href='../peminjamanBarang.php';</script>";
    exit();
}

$uid         = $_POST['uid'] ?? '';
$semester    = $_POST['semester'] ?? '';
$kode_barang = $_POST['kode_barang'] ?? '';
$tanggal     = date("Y-m-d");
$status      = "Dipinjam";

if (!$uid || !$semester || !$kode_barang) {
    redirectWithAlert('Semua data harus diisi.');
}

// Ambil ID (primary key) dari tb_card berdasarkan UID
$result = mysqli_query($koneksi, "SELECT id FROM tb_card WHERE uid='$uid'");
$data   = mysqli_fetch_assoc($result);

if (!$data) {
    redirectWithAlert('Kartu tidak terdaftar.');
}

$id_card = $data['id']; // ini adalah nilai yang direferensikan oleh tb_peminjaman.uid_peminjam

$cekBarang = mysqli_query($koneksi, "SELECT status FROM tb_barang WHERE id_barang = '$kode_barang'");
$barang = mysqli_fetch_assoc($cekBarang);

// Simpan peminjaman menggunakan id_card
if (!$barang || $barang['status'] !== 'Tersedia') {
    redirectWithAlert('Barang tidak tersedia atau tidak ditemukan.');
}

// Simpan data ke tb_peminjaman
$simpan = mysqli_query($koneksi, "
    INSERT INTO tb_peminjaman (uid_peminjam, semester, kode_barang, tgl_peminjaman, status)
    VALUES ('$id_card', '$semester', '$kode_barang', '$tanggal', '$status')
");

if ($simpan) {
    // Update status barang menjadi 'Dipinjam'
    mysqli_query($koneksi, "UPDATE tb_barang SET status = 'Dipinjam' WHERE id_barang = '$kode_barang'");

    // Hapus UID dari card_temp setelah sukses
    mysqli_query($koneksi, "DELETE FROM card_temp WHERE uid = '$uid'");

    redirectWithAlert('Peminjaman berhasil disimpan.');
} else {
    redirectWithAlert('Gagal menyimpan data peminjaman.');
}
