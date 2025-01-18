<?php
require '../koneksi.php';
$userId = $_SESSION['users']['id']; // Pastikan ID pengguna diperoleh dari session

// Query untuk menghitung jumlah jadwal sidang
$stmtJadwal = $conn->prepare("SELECT COUNT(*) AS total_jadwal 
    FROM jadwal j
    LEFT JOIN pembimbing g ON j.pembimbing_id = g.id
    LEFT JOIN users u2 ON g.pembimbing_id = u2.id
    WHERE u2.id = ?
");
$stmtJadwal->bind_param("i", $userId); 
$stmtJadwal->execute();
$resultJadwal = $stmtJadwal->get_result();
$rowJadwal = $resultJadwal->fetch_assoc();

$stmtCatatan = $conn->prepare("SELECT COUNT(*) AS total_Catatan 
    FROM laporan_bimbingan j
    LEFT JOIN pembimbing g ON j.pembimbing_id = g.id
    LEFT JOIN users u2 ON g.pembimbing_id = u2.id
    WHERE u2.id = ?
");
$stmtCatatan->bind_param("i", $userId); 
$stmtCatatan->execute();
$resultCatatan = $stmtCatatan->get_result();
$rowCatatan = $resultCatatan->fetch_assoc();



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
                    <h3 class="text-3xl font-bold mb-4 text-center">Laporan Bimbingan</h3>
                    <i class="fa fa-book text-6xl mb-4"></i>
                    <p class="text-3xl"><?= $totalLaporan = $rowCatatan['total_Catatan']; ?></p>
                </div>

            </div>
        </div>
    </div>
</section>