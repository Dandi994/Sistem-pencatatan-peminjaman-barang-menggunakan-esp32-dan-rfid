<?php  
include 'koneksi.php';

$id = $_POST['kodeBarang'];
$namaBarang = $_POST['namaBarang'];
$jenisBarang = $_POST['jenisBarang'];

$query = "UPDATE tb_barang SET nama_barang='$namaBarang', jenis_barang='$jenisBarang' WHERE id_barang='$id'";
mysqli_query($koneksi, $query);

header('Location: ../kelolaBarang.php');
?>