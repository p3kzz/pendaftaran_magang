<?php
$conn = mysqli_connect('localhost','root','','pendaftaran_magang');


if (!$conn) {
    die('Koneksi Gagal: ' . mysqli_connect_error());
}
?>