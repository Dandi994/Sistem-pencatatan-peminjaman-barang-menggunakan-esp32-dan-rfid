<?php
include 'koneksi.php';
header('Content-Type: application/json');

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $tgl_sekarang = date('Y-m-d H:i:s');

    // Ambil id_barang dan jumlah dari peminjaman
    $get_data = mysqli_query($koneksi, "SELECT kode_barang, jumlah FROM tb_peminjaman WHERE id = '$id'");
    $row = mysqli_fetch_assoc($get_data);

    $id_barang = $row['kode_barang'] ?? null;
    $jumlah = $row['jumlah'] ?? null;

    if (!$id_barang || !$jumlah) {
        echo json_encode(['status' => 'error', 'message' => 'Data barang tidak ditemukan.']);
        exit();
    }

    // Update status peminjaman ke 'Dikembalikan' + tanggal pengembalian
    $query = mysqli_query($koneksi, "
        UPDATE tb_peminjaman 
        SET status = 'Dikembalikan', tgl_pengembalian = '$tgl_sekarang' 
        WHERE id = '$id'
    ");

    // Jika berhasil, tambahkan stok_tersedia
    if ($query) {
        mysqli_query($koneksi, "
            UPDATE tb_barang 
            SET stok_tersedia = stok_tersedia + $jumlah 
            WHERE id_barang = $id_barang
        ");

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
