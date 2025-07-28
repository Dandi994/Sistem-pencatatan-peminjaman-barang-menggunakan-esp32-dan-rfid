<?php 
include 'koneksi.php';

$tahun_sekarang = date('Y');
$query = "SELECT * FROM tb_card";
$result = mysqli_query($koneksi, $query);

$data = [];

while ($row = $result->fetch_assoc()) {
    $angkatan = $row['angkatan'];
    $jenjang = $row['prodi'];

    $selisih_tahun = $tahun_sekarang - $angkatan;
    $semester = $selisih_tahun * 2;

    // Batas semester
    $batas = $jenjang == 'D3 Teknik Komputer' ? 6 : 8;
    $semester = min($semester, $batas);

    $data[] = [
        'semester' => $semester
    ];
}

echo json_encode($data);
?>