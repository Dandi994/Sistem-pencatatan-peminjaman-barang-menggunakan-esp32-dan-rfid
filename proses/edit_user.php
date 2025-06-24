<?php
include 'koneksi.php';

$id = $_POST['id'];
$uid = $_POST['uid'];
$kelas = $_POST['kelas'];
$prodi = $_POST['prodi'];
$angkatan = $_POST['angkatan'];

// Update data user
$query = "UPDATE tb_card SET uid='$uid', kelas='$kelas', prodi='$prodi', angkatan='$angkatan' WHERE id='$id'";
mysqli_query($koneksi, $query);

// Kosongkan UID yang sementara disimpan sebelumnya (agar tidak ditampilkan terus-menerus)
mysqli_query($koneksi, "UPDATE tb_card SET uid='' WHERE uid='$uid' AND id != '$id'");

header('Location: ../kelolaUser.php');
