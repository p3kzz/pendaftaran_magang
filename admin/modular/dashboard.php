<?php
include "../koneksi.php";
$sql = mysqli_query($conn, "select * from magang ");
$cek = mysqli_num_rows($sql);

$MhsSql = mysqli_query($conn, "SELECT * from mahasiswa");
$Jmhs = mysqli_num_rows($MhsSql);

$jadwal = mysqli_query($conn, "SELECT * from jadwal");
$jdw = mysqli_num_rows($jadwal)
?>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<section class="content-header">
    <h1> Dashboard </h1>
    <ol class="breadcrumb">
        <!-- <li><a href="homepage.php?p=dashboard"><i class="fa fa-dashboard"></i> Home</a></li> -->
        <li class="active">Dashboard</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="alert alert-warning alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Selamat Datang <span class="username"><?php echo $nama ?></span>,
            <br>Anda Berhasil Login sebagai <?php echo $_SESSION['users']['role'] ?></strong>
    </div>

    <!-- Sistem-->
    <div class="box box-info">
        <div class="box-header">
            <h1
                class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-500 via-green-500 to-purple-500 text-center my-6">
                SISTEM PENDAFTARAN MAGANG ONLINE
            </h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div
                    class="bg-blue-500 text-white shadow-lg rounded-lg p-12 transform hover:scale-105 transition duration-300 hover:bg-blue-700 flex flex-col items-center justify-center h-64">
                    <h3 class="text-3xl font-bold mb-4 text-center">Daftar magang baru</h3>
                    <i class="bi bi-people-fill text-6xl mb-4"></i>
                    <p class="text-3xl"><?php echo $cek ?></p>
                </div>

                <!-- Card 2 -->
                <div
                    class="bg-yellow-500 text-white shadow-lg rounded-lg p-12 transform hover:scale-105 transition duration-300 hover:bg-yellow-700 flex flex-col items-center justify-center h-64">
                    <h3 class="text-3xl font-bold mb-4 text-center">Mahasiswa</h3>
                    <i class="bi bi-people-fill text-6xl mb-4"></i>
                    <p class="text-3xl"><?php echo $Jmhs ?></p>
                </div>

                <!-- Card 3 -->
                <div
                    class="bg-purple-500 text-white shadow-lg rounded-lg p-12 transform hover:scale-105 transition duration-300 hover:bg-purple-700 flex flex-col items-center justify-center h-64">
                    <h3 class="text-3xl font-bold mb-4 text-center">Jadwal sidang dan bimbingan</h3>
                    <i class="bi bi-people-fill text-6xl mb-4"></i>
                    <p class="text-3xl"><?php echo $jdw ?></p>
                </div>
            </div>
        </div>
    </div>
</section>