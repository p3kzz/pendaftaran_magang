<?php
require '../koneksi.php';
$userId = $_SESSION['users']['id']; 
$stmtJadwal = $conn->prepare("SELECT COUNT(*) AS total_jadwal 
    FROM jadwal j
    LEFT JOIN penguji g ON j.penguji_id = g.id
    LEFT JOIN users u2 ON g.penguji_id = u2.id
    WHERE u2.id = ?
");
$stmtJadwal->bind_param("i", $userId); 
$stmtJadwal->execute();
$resultJadwal = $stmtJadwal->get_result();
$rowJadwal = $resultJadwal->fetch_assoc();

$stmtMhsBimbing = $conn->prepare("SELECT COUNT(*) AS dibimbing 
    FROM penentuan_pembimbing pb
    LEFT JOIN penguji p ON pb.penguji_id = p.id
    LEFT JOIN users u ON p.penguji_id = u.id
    WHERE u.id = ?
");
$stmtMhsBimbing->bind_param("i", $userId); 
$stmtMhsBimbing->execute();
$resultMhsBimbing = $stmtMhsBimbing->get_result();
$rowMhsBimbing = $resultMhsBimbing->fetch_assoc();



$stmtlaporan = $conn->prepare("SELECT COUNT(*) AS laporan
    FROM upload_laporan ul
    LEFT JOIN penguji p ON ul.penguji_id = p.id
    LEFT JOIN users u ON p.penguji_id = u.id
    WHERE u.id = ?
");
$stmtlaporan->bind_param("i", $userId); 
$stmtlaporan->execute();
$resultlaporan = $stmtlaporan->get_result();
$rowlaporan = $resultlaporan->fetch_assoc();


$stmtpenilaian = $conn->prepare("SELECT COUNT(*) AS penilaian
    FROM penilaian l
    LEFT JOIN penguji p ON l.penguji_id = p.id
    LEFT JOIN users u ON p.penguji_id = u.id
    WHERE u.id = ?
");
$stmtpenilaian->bind_param("i", $userId); 
$stmtpenilaian->execute();
$resultpenilaian = $stmtpenilaian->get_result();
$rowpenilaian = $resultpenilaian->fetch_assoc();
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
        <strong>Selamat Datang <span class="username"><?php echo $_SESSION['users']['name']; ?></span>,
            <br>Anda Berhasil Login sebagai <?php echo $_SESSION['users']['role']; ?></strong>
    </div>

    <div class="box box-info">
        <div class="box-header">
            <h1
                class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-500 via-green-500 to-purple-500 text-center my-6">
                SISTEM PENDAFTARAN MAGANG ONLINE
            </h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    class="bg-blue-500 text-white shadow-lg rounded-lg p-12 transform hover:scale-105 transition duration-300 hover:bg-blue-700 flex flex-col items-center justify-center h-64">
                    <h3 class="text-3xl font-bold mb-4 text-center">Jadwal Sidang</h3>
                    <i class="bi bi-calendar-event text-6xl mb-4"></i>
                    <p class="text-3xl"><?= $totalJadwalSidang = $rowJadwal['total_jadwal']; ?></p>
                </div>
                <div
                    class="bg-green-500 text-white shadow-lg rounded-lg p-12 transform hover:scale-105 transition duration-300 hover:bg-green-700 flex flex-col items-center justify-center h-64">
                    <h3 class="text-3xl font-bold mb-4 text-center">Mahasiswa Dibimbing</h3>
                    <i class="bi bi-people-fill text-6xl mb-4"></i>
                    <p class="text-3xl"><?= $totalMhsBimbing = $rowMhsBimbing['dibimbing']; ?></p>
                </div>
                <div
                    class="bg-purple-500 text-white shadow-lg rounded-lg p-12 transform hover:scale-105 transition duration-300 hover:bg-purple-700 flex flex-col items-center justify-center h-64">
                    <h3 class="text-3xl font-bold mb-4 text-center">Laporan Akhir</h3>
                    <i class="bi bi-file-earmark-fill text-6xl mb-4"></i>
                    <p class="text-3xl"><?= $totallaporan = $rowlaporan['laporan']; ?></p>
                </div>
                <div
                    class="bg-red-500 text-white shadow-lg rounded-lg p-12 transform hover:scale-105 transition duration-300 hover:bg-red-700 flex flex-col items-center justify-center h-64">
                    <h3 class="text-3xl font-bold mb-4 text-center">Penilaian Laporan</h3>
                    <i class="bi bi-star-fill text-6xl mb-4 text-6xl mb-4"></i>
                    <p class="text-3xl"><?= $totalpenilaian= $rowpenilaian['penilaian']; ?></p>
                </div>

            </div>
        </div>
    </div>
</section>