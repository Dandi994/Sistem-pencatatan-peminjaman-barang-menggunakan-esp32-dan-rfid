<?php
include 'koneksi.php';

$uid = $_POST['uid'];
$kelas = $_POST['kelas'];
$prodi = $_POST['prodi'];
$angkatan = $_POST['angkatan'];


$query = "INSERT INTO tb_card (uid, kelas, prodi, angkatan) VALUES ('$uid', '$kelas', '$prodi', '$angkatan')";
if (mysqli_query($koneksi, $query)) {

    $deleteTemp = "DELETE FROM card_temp WHERE uid='$uid'";
    mysqli_query($koneksi, $deleteTemp);

    header('Location: ../kelolaUser.php');
    exit();
} else {
    echo "Gagal mengupdate data: " . mysqli_error($koneksi);
}
