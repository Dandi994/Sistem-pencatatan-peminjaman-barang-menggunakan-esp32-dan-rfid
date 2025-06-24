<?php
include 'koneksi.php';

$id = $_GET['id'];

$query = "DELETE FROM tb_card WHERE id='$id'";
mysqli_query($koneksi, $query);

header('Location: ../kelolaUser.php');
exit;
