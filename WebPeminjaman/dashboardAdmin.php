<?php
session_start();

if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true){
    header('Location: login.php');
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/dashboardAdmin.css">
</head>

<body>
    <!-- Top Bar -->
    <nav class="navbar navbar-expand-lg fixed-top" style="background-color:rgb(182, 147, 246);">
        <div class="container-fluid">
            <a class="navbar-brand text-white d-flex align-items-center" href="dashboardAdmin.php">
                <img src="assets/img/tekkom.png" alt="Logo" width="50" height="50" class="d-inline-block align-text-top me-2">
                <span class="fs-5 fw-bold">Teknik Komputer</span>
            </a>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="nav flex-column ps-3">
            <li class="nav-item ">
                <a class="nav-link fw-bold text-white" href="kelolaUser.php" role="button" aria-expanded="false">
                    Kelola User
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-bold text-white" href="kelolaBarang.php">Kelola Barang</a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-bold text-white" href="riwayatPeminjaman.php">Riwayat Peminjaman</a>
            </li>
            <li class="nav-item mt-3 ms-3">
                <a class=" btn btn-danger fw-bold text-white" href="proses/proses_logout.php">Log Out</a>
            </li>
        </ul>
    </div>

    <!-- Content Area -->
    <div class="content">
        <div class="heading">
            <p class="h2">Selamat Datang Di Dashboard Admin</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
