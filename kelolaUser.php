<?php
include 'proses/koneksi.php';
mysqli_query($koneksi, "DELETE FROM card_temp");

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'get_users') {
    $sql = "SELECT * FROM tb_card ORDER BY id DESC";
    $result = mysqli_query($koneksi, $sql);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/kelolaUser.css">
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
            <h5 class="fw-bold">Tambah Kartu</h5>
            <form id="myForm" action="proses/update_user.php" method="post">
                <div class="mb-3">
                    <label class="form-label"><em>Tap kartu RFID</em></label>
                    <input type="text" id="uid" name="uid" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <select class="form-select" name="prodi">
                        <option selected disabled>Pilih Prodi</option>
                        <option>D3 Teknik Komputer</option>
                        <option>D4 Teknik Informatika Multimedia Digital</option>
                    </select>
                </div>
                <div class="mb-3">
                    <select class="form-select" name="kelas">
                        <option selected disabled>Pilih Kelas</option>
                        <option>CA</option>
                        <option>CB</option>
                        <option>CC</option>
                        <option>CD</option>
                        <option>CE</option>
                        <option>CF</option>
                        <option>CM</option>
                        <option>CN</option>
                        <option disabled>------------</option>
                        <option>TIA</option>
                        <option>TIB</option>
                        <option>TIC</option>
                        <option>TIM</option>
                        <option>TIN</option>
                    </select>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" name="angkatan" placeholder="Angkatan">
                </div>
                <input type="submit" id="submit-btn" class="btn btn-primary" value="Submit"></input>
            </form>
        </div>

        <!-- Tabel Data Kartu -->
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th><em>UID</em></th>
                        <th>Kelas</th>
                        <th>Prodi</th>
                        <th>Angkatan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="user-table-body">

                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/kelolaUser.js"></script>

</body>

</html>