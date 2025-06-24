<?php
header('Content-Type: application/json');
include 'koneksi.php';

// Ambil UID dari card_temp
$result = mysqli_query($koneksi, "SELECT uid FROM card_temp ORDER BY id DESC LIMIT 1");

if ($row = mysqli_fetch_assoc($result)) {
    $uid = $row['uid'];

    // Cek UID di tb_card
    $card_query = mysqli_query($koneksi, "SELECT * FROM tb_card WHERE uid = '$uid'");
    if ($card = mysqli_fetch_assoc($card_query)) {
        $id_card = $card['id'];
        $kelas = $card['kelas'];

        // Ambil data peminjaman berdasarkan id dari tb_card
        $peminjaman = [];
        $query = mysqli_query($koneksi, "
            SELECT 
                p.id,
                p.semester, 
                p.tgl_peminjaman, 
                p.tgl_pengembalian, 
                p.status, 
                b.id_barang AS kode_barang, 
                b.nama_barang
            FROM tb_peminjaman p
            JOIN tb_barang b ON p.kode_barang = b.id_barang
            WHERE p.uid_peminjam = '$id_card'
        ");

        while ($row = mysqli_fetch_assoc($query)) {
            $peminjaman[] = $row;
        }

        echo json_encode([
            'status' => 'found',
            'uid' => $uid,
            'kelas' => $kelas,
            'peminjaman' => $peminjaman
        ]);
    } else {
        echo json_encode([
            'status' => 'not_found',
            'uid' => $uid
        ]);
    }
} else {
    echo json_encode([
        'status' => 'no_uid'
    ]);
}
