<?php
include '../koneksi.php';

if (!isset($_SESSION['users']['id'])) {
    die('User tidak terdeteksi. Silakan login terlebih dahulu.');
}

$userID = $_SESSION['users']['id'];

$sqlData = "SELECT
    p.id AS penentuan_id,
    m.id AS mahasiswa_id,
    u.name AS nama_pembimbing,
    p.nip AS nip_pembimbing,
    u2.name AS nama_penguji,
    p2.nip AS nip_penguji,
    pb.pembimbing_id,
    j.id AS jadwal_id,
    j.tanggal_bimbingan,
    s.id AS mahasiswa_id,
    s.status
    FROM penentuan_pembimbing pb
    LEFT JOIN mahasiswa m ON pb.mahasiswa_id = m.id
    LEFT JOIN pembimbing p ON pb.pembimbing_id = p.id
    LEFT JOIN magang s ON pb.mahasiswa_id = m.id
    -- perubahan
    LEFT JOIN penguji p2 ON pb.penguji_id = p2.id
    LEFT JOIN jadwal j ON j.mahasiswa_id = m.id
    LEFT JOIN users u On p.pembimbing_id = u.id
    LEFT JOIN users u2 On p.pembimbing_id = u.id
    LEFT JOIN users u1 ON m.mahasiswa_id = u1.id
    WHERE u1.id = ?";

$queryData = $conn->prepare($sqlData);
$queryData->bind_param('i', $userID);
$queryData->execute();
$resultData = $queryData->get_result();

if ($resultData->num_rows > 0) {
    $data = $resultData->fetch_assoc();
} else {
    
}
?>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<section class="content-header">
    <h1> Dashboard </h1>
    <ol class="breadcrumb">
        <li class="active">Dashboard</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="alert alert-warning alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Selamat Datang <span class="username"><?php echo $nama; ?></span>,
            <br>Anda Berhasil Login sebagai <?php echo $_SESSION['users']['role']; ?></strong>
    </div>
    <!-- Sistem-->
    <div class="box box-info">
        <div class="box-header">
            <h1
                class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-500 via-green-500 to-purple-500 text-center my-6">
                SISTEM PENDAFTARAN MAGANG ONLINE
            </h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php if ($resultData->num_rows > 0) {?>
                <!-- Card 1 -->
                <div
                    class="bg-yellow-500 text-white shadow-lg rounded-lg p-12 transform hover:scale-105 transition duration-300 hover:bg-yellow-700 flex flex-col items-center justify-center h-64">
                    <h3 class="text-3xl font-bold mb-4 text-center">Dosen Pembimbing</h3>
                    <i class="bi bi-people-fill text-6xl mb-4"></i>
                    <p class="text-3xl"><?= $data['nama_pembimbing'] ?></p>
                </div>
                <!-- Card 2 -->
                <div
                    class="bg-blue-500 text-white shadow-lg rounded-lg p-12 transform hover:scale-105 transition duration-300 hover:bg-blue-700 flex flex-col items-center justify-center h-64">
                    <h3 class="text-3xl font-bold mb-4 text-center">Dosen Penguji</h3>
                    <i class="bi bi-people-fill text-6xl mb-4"></i>
                    <p class="text-3xl"><?= $data['nama_penguji'] ?></p>
                </div>
                <?php }else{?>
                <!-- Card 1 -->
                <div
                    class="bg-yellow-500 text-white shadow-lg rounded-lg p-12 transform hover:scale-105 transition duration-300 hover:bg-yellow-700 flex flex-col items-center justify-center h-64">
                    <h3 class="text-3xl font-bold mb-4 text-center">Dosen Pembimbing</h3>
                    <i class="bi bi-people-fill text-6xl mb-4"></i>
                    <p class="text-3xl">Belum ditentukan</p>
                </div>
                <!-- Card 2 -->
                <div
                    class="bg-blue-500 text-white shadow-lg rounded-lg p-12 transform hover:scale-105 transition duration-300 hover:bg-blue-700 flex flex-col items-center justify-center h-64">
                    <h3 class="text-3xl font-bold mb-4 text-center">Dosen Penguji</h3>
                    <i class="bi bi-people-fill text-6xl mb-4"></i>
                    <p class="text-3xl">Belum ditentukan</p>
                </div>
            </div>
            <?php }?>
            </div>

        </div>
    </div>
</section>