<?php
include 'proses/koneksi.php';

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['loggend_in'] !== true) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'];

$query = mysqli_query($koneksi, "SELECT * FROM tb_card WHERE id='$id'");
$data = mysqli_fetch_assoc($query);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .sidebar {
            color: white;
            width: 250px;
            height: 100vh;
            background-color: #372160;
            position: fixed;
            top: 75px;
            left: 0;
            padding-top: 20px;
        }

        .content {
            margin-left: 250px;
            margin-top: 55px;
            padding: 40px;
        }


        .form-container {
            background-color: #f8f9fa;
            padding: 40px;
            border: 1px solid #ccc;
            border-radius: 8px;
            max-width: 600px;
            margin: auto;
            position: relative;
        }

        .submit-btn {
            position: absolute;
            bottom: 10px;
            right: 40px;
        }

        .table-responsive {
            margin-top: 30px;
        }

        .form-container h5 {
            margin-bottom: 20px;
        }
    </style>
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

    <!-- Content Area -->
    <div class="content">
        <!-- Form Tambah Kartu -->
        <div class="form-container mb-4">
            <h5 class="fw-bold">Edit Data Kartu</h5>
            <form action="proses/edit_user.php" method="post">
                <div class="mb-3">
                    <input type="hidden" name="id" value="<?= $data['id']; ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label"><em>Tap kartu RFID</em></label>
                    <input type="text" value="<?= $data['uid']; ?>" name="uid" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <select class="form-select" name="prodi">
                        <option value="D3 Teknik Komputer" <?= $data['prodi'] == 'D3 Teknik Komputer' ? 'selected' : '' ?>>D3 Teknik Komputer</option>
                        <option value="D4 Teknik Informatika Multimedia Digital" <?= $data['prodi'] == 'D4 Teknik Informatika Multimedia Digital' ? 'selected' : '' ?>>D4 Teknik Informatika Multimedia Digital</option>
                    </select>
                </div>
                <div class="mb-3">
                    <select class="form-select" name="kelas">
                        <option value="CA" <?= $data['kelas'] == 'CA' ? 'selected' : '' ?>>CA</option>
                        <option value="CB" <?= $data['kelas'] == 'CB' ? 'selected' : '' ?>>CB</option>
                        <option value="CC" <?= $data['kelas'] == 'CC' ? 'selected' : '' ?>>CC</option>
                        <option value="CD" <?= $data['kelas'] == 'CD' ? 'selected' : '' ?>>CD</option>
                        <option value="CE" <?= $data['kelas'] == 'CE' ? 'selected' : '' ?>>CE</option>
                        <option value="CF" <?= $data['kelas'] == 'CF' ? 'selected' : '' ?>>CF</option>
                        <option value="CM" <?= $data['kelas'] == 'CM' ? 'selected' : '' ?>>CM</option>
                        <option value="CN" <?= $data['kelas'] == 'CN' ? 'selected' : '' ?>>CN</option>
                        <option disabled>------------</option>
                        <option value="TIA" <?= $data['kelas'] == 'TIA' ? 'selected' : '' ?>>TIA</option>
                        <option value="TIB" <?= $data['kelas'] == 'TIB' ? 'selected' : '' ?>>TIB</option>
                        <option value="TIC" <?= $data['kelas'] == 'TIC' ? 'selected' : '' ?>>TIC</option>
                        <option value="TIM" <?= $data['kelas'] == 'TIM' ? 'selected' : '' ?>>TIM</option>
                        <option value="TIN" <?= $data['kelas'] == 'TIN' ? 'selected' : '' ?>>TIN</option>
                    </select>
                </div>
                <div class="mb-3">
                    <input type="text" value="<?= $data['angkatan']; ?>" name="angkatan" class="form-control" placeholder="Angkatan">
                </div>
                <input type="submit" value="Submit" class="btn btn-primary"></input>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>