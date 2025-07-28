<?php
include 'koneksi.php';

// Ambil UID terakhir dari card_temp
$uid_result = mysqli_query($koneksi, "SELECT uid FROM card_temp ORDER BY id DESC LIMIT 1");

if ($uid_result && mysqli_num_rows($uid_result) > 0) {
    $uid_row = mysqli_fetch_assoc($uid_result);
    $uid = $uid_row['uid'];

    // Ambil data lengkap dari tb_card, termasuk angkatan dan prodi
    $data_result = mysqli_query($koneksi, 
        "SELECT uid, kelas, prodi, angkatan FROM tb_card WHERE uid = '$uid'"
    );

    if ($data_result && mysqli_num_rows($data_result) > 0) {
        $data = mysqli_fetch_assoc($data_result);

        // Hitung semester
        $tahunSekarang = date('Y');
        $selisihTahun = $tahunSekarang - $data['angkatan'];
        $semester = $selisihTahun * 2;

        // Tentukan batas semester berdasarkan prodi
        $prodi = strtoupper($data['prodi']); // Ubah ke huruf besar agar mudah dibaca
        if (str_contains($prodi, 'D3 Teknik Komputer')) {
            $batasSemester = 6;
        } elseif (str_contains($prodi, 'D4 Teknik Informatika Multimedia Digital')) {
            $batasSemester = 8;
        } else {
            $batasSemester = 8; // Default jika tidak diketahui
        }

        $semester = min($semester, $batasSemester);

        echo json_encode([
            'status' => 'found',
            'uid' => $data['uid'],
            'kelas' => $data['kelas'],
            'prodi' => $data['prodi'],
            'angkatan' => $data['angkatan'],
            'semester' => $semester
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
