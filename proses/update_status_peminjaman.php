<?php
include 'koneksi.php';
header('Content-Type: application/json');

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $tgl_sekarang = date('Y-m-d H:i:s');

    // Ambil kode_barang untuk mengupdate tb_barang nanti
    $get_barang = mysqli_query($koneksi, "SELECT kode_barang FROM tb_peminjaman WHERE id = '$id'");
    $data_barang = mysqli_fetch_assoc($get_barang);
    $kode_barang = $data_barang['kode_barang'] ?? null;

    // Update status peminjaman ke 'Dikembalikan' + tanggal pengembalian
    $query = mysqli_query($koneksi, "
        UPDATE tb_peminjaman 
        SET status = 'Dikembalikan', tgl_pengembalian = '$tgl_sekarang' 
        WHERE id = '$id'
    ");

    // Jika berhasil, update status barang ke 'Tersedia'
    if ($query && $kode_barang) {
        mysqli_query($koneksi, "UPDATE tb_barang SET status = 'Tersedia' WHERE id_barang = '$kode_barang'");
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => mysqli_error($koneksi)
        ]);
    }
} else {
    echo json_encode(['status' => 'invalid_request']);
}
