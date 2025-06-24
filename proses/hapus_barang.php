<?php 
include 'koneksi.php';

$id = $_GET['id'];
$query = "DELETE FROM tb_barang WHERE id_barang='$id'";
mysqli_query($koneksi, $query);

header('Location: ../kelolaBarang.php');
exit;
?>