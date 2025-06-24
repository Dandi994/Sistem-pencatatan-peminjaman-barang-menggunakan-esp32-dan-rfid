<?php

use Dom\Mysql;

session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($koneksi, "SELECT*FROM tb_admin WHERE username='$username' AND password='$password'");

if (mysqli_num_rows($query) === 1) {
  $_SESSION['logged_in'] = true;
  $_SESSION['username'] = $username;
  header('Location: ../dashboardAdmin.php');
  exit;
} else {
  echo "<script>alert('Username atau Password salah');</script>";
}
