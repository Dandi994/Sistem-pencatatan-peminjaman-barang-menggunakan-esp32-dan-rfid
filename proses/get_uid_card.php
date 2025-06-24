<?php
include 'koneksi.php';

// Ambil UID terakhir dari card_temp
$uid_result = mysqli_query($koneksi, "SELECT uid FROM card_temp ORDER BY id DESC LIMIT 1");

if ($uid_result && mysqli_num_rows($uid_result) > 0) {
    $uid_row = mysqli_fetch_assoc($uid_result);
    $uid = $uid_row['uid'];

    // Cek ke tb_card untuk data lengkap
    $data_result = mysqli_query($koneksi, "SELECT uid, kelas, prodi FROM tb_card WHERE uid = '$uid'");

    if ($data_result && mysqli_num_rows($data_result) > 0) {
        $data = mysqli_fetch_assoc($data_result);
        echo json_encode([
            'status' => 'found',
            'uid' => $data['uid'],
            'kelas' => $data['kelas'],
            'prodi' => $data['prodi']
        ]);
    } else {
        echo json_encode([
            'status' => 'not_found',
            'uid' => $uid
        ]);
    }
} else {
    // Tidak ada UID terdeteksi
    echo json_encode([
        'status' => 'no_uid'
    ]);
}
