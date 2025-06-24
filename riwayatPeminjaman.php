<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengembalian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/riwayatPeminjaman.css">
</head>

<body>

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
                <li class="nav-item">
                    <a class="nav-link fw-bold text-white" href="kelolaUser.php">Kelola User</a>
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
            <div class="bg-white p-4 shadow rounded">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0 fw-bold">Riwayat Peminjaman Barang</h4>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Awal</label>
                            <input type="date" id="tanggalAwal" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Akhir</label>
                            <input type="date" id="tanggalAkhir" class="form-control">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button class="btn btn-primary me-2" onclick="filterData()">Tampilkan</button>
                            <button class="btn btn-success" onclick="exportExcel()">Export</button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
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
        </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </body>
    <script src="assets/js/riwayat.js"></script>

</html>