<?php
include 'koneksi.php';
$sql = "SELECT uid FROM card_temp LIMIT 1";
$result = $koneksi->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row['uid'];
}
