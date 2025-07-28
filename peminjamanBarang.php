<?php
include 'proses/koneksi.php';
mysqli_query($koneksi, "DELETE FROM card_temp");
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Peminjaman Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/peminjamanBarang.css">
</head>

<body>
    <!-- Top Bar -->
    <nav class="navbar navbar-expand-lg fixed-top" style="background-color:rgb(182, 147, 246);">
        <div class="container-fluid">
            <a class="navbar-brand text-white d-flex align-items-center" href="dashboardUser.php">
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
        <div class="form-container">
            <h5 class="text-center mb-4 fw-bold">Form Peminjaman Barang</h5>
            <form action="proses/insert_peminjaman.php" method="post" id="myForm">
                <div class="mb-3">
                    <label class="form-label">Tap Kartu RFID</label>
                    <input id="uid" name="uid" type="text" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <input id="kelas" type="text" name="kelas" class="form-control" placeholder="Kelas" readonly>
                </div>
                <div class="mb-3">
                    <input id="prodi" type="text" name="prodi" class="form-control" placeholder="Prodi" readonly>
                </div>

                <div class="mb-3">
                    <input id="semester" type="text" name="semester" class="form-control" placeholder="Semester" readonly>
                </div>

                <table class="table" id="tabel-barang">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="barang[]" class="form-control barang-select" required>
                                    <option disabled selected>Pilih Barang</option>
                                </select>
                            </td>
                            <td><input type="number" name="jumlah[]" class="form-control" min="1" required></td>
                            <td><button type="button" class="btn btn-danger hapus-baris">Hapus</button></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" id="tambah-baris" class="btn btn-secondary">+ Tambah Barang</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/peminjamanBarang.js"></script>
</body>

</html>