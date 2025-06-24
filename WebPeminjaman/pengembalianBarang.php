<?php
include 'proses/koneksi.php';
mysqli_query($koneksi, "DELETE FROM card_temp");
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengembalian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/pengembalianBarang.css">
</head>

<body>
    <!-- Top Bar -->
    <nav class="navbar navbar-expand-lg fixed-top" style="background-color:rgb(182, 147, 246);">
        <div class="container-fluid">
            <a class="navbar-brand text-white d-flex align-items-center" href="#">
                <img src="assets/img/tekkom.png" alt="Logo" width="50" height="50" class="d-inline-block align-text-top me-2">
                <span class="fs-5 fw-bold">Teknik Komputer</span>
            </a>
        </div>
    </nav>


    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="nav flex-column ps-3">
            <li class="nav-item">
                <a class="nav-link fw-bold text-white" href="peminjamanBarang.php">Pinjam Barang</a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-bold text-white" href="pengembalianBarang.php">Pengembalian Barang</a>
            </li>
        </ul>
    </div>

    <!-- Content Area -->
    <div class="content">
        <div class="search-bar d-flex align-items-center mb-3">
            <input type="text" id="uidInput" class="form-control" placeholder="Tempelkan Kartu RFID..." readonly>
        </div>
        <div class="table-responsive">
            <table class="table table-light table-striped-columns">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Id Peminjam</th>
                        <th>Kelas</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="dataBody">

                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/pengembalianBarang.js"></script>

</body>

</html>