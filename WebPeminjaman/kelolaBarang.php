<?php
include 'proses/koneksi.php';

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$no = 1;

$query = "SELECT * FROM tb_barang";
$hasil = mysqli_query($koneksi, $query);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/kelolaBarang.css">
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
            <li class="nav-item">
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

    <div class="content">
        <div class="form-container mb-4">
            <h5 class="fw-bold">Tambah Barang</h5>
            <form action="proses/insert_barang.php" method="post">
                <div class="mb-3">
                    <input type="text" name="kodeBarang" class="form-control" placeholder="Kode Barang">
                </div>
                <div class="mb-3">
                    <input type="text" name="namaBarang" class="form-control" placeholder="Nama Barang">
                </div>
                <div class="mb-3">
                    <select class="form-select" name="jenisBarang">
                        <option selected disabled>Pilih Jenis Barang</option>
                        <option>Proyektor</option>
                        <option>Remote Ac</option>
                        <option>Remote Tv</option>
                        <option>Kabel HDMI</option>
                        <option>Kabel VGA</option>
                        <option>Perkakas</option>
                    </select>
                </div>
                <input type="submit" class="btn btn-primary" value="Submit"></input>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jenis Barang</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($hasil)) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['id_barang']; ?></td>
                            <td><?= $row['nama_barang']; ?></td>
                            <td><?= $row['jenis_barang']; ?></td>
                            <td>
                                <a href="editBarang.php?id= <?= $row['id_barang']; ?>" class="btn btn-sm btn-success">Edit</a>
                                <a href="proses/hapus_barang.php?id= <?= $row['id_barang']; ?>" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>