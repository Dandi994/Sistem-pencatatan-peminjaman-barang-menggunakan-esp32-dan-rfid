<?php
include 'koneksi.php';

$uid = $_POST['uid'] ?? '';

if (!empty($uid)) {
    $uid = mysqli_real_escape_string($koneksi, $uid);

    $check = mysqli_query($koneksi, "SELECT * FROM card_temp WHERE uid = '$uid'");
    if (mysqli_num_rows($check) == 0) {
        $sql = "INSERT INTO card_temp (uid) VALUES ('$uid')";
        mysqli_query($koneksi, $sql);
    }

    echo "UID tersimpan";
} else {
    echo "UID kosong";
}
