<?php
require '../koneksi.php';


$userId = $_SESSION['users']['id'];

$sqlMahasiswa = "SELECT m.id AS mahasiswa_id, m.nim, m.nama, m.angkatan 
                FROM mahasiswa m 
                JOIN users u ON m.mahasiswa_id = u.id 
                WHERE u.id = ?";
$queryMahasiswa = $conn->prepare($sqlMahasiswa);
$queryMahasiswa->bind_param("i", $userId);
$queryMahasiswa->execute();
$resultMahasiswa = $queryMahasiswa->get_result();

if ($resultMahasiswa->num_rows > 0) {
    $mahasiswa = $resultMahasiswa->fetch_assoc();
    $mahasiswaId = $mahasiswa['mahasiswa_id'];
} else {
    echo "Data mahasiswa tidak ditemukan.";
    exit;
}

$sqlCekMagang = "SELECT * FROM magang WHERE mahasiswa_id = ?";
$checkMagang = $conn->prepare($sqlCekMagang);
$checkMagang->bind_param("i", $mahasiswaId);
$checkMagang->execute();
$resultCekMagang = $checkMagang->get_result();

$pendaftaranMagang = $resultCekMagang->fetch_assoc();
$sudahDaftar = $pendaftaranMagang !== null;
?>

<section class="content">
    <div class="box box-info">
        <div class="box-header">
            <h1>Data Pendaftaran Magang</h1>
        </div>
        <div class="box-body">
            <?php if ($sudahDaftar): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Angkatan</th>
                        <th>Lokasi Magang</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                        <th>aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($mahasiswa['nim']); ?></td>
                        <td><?php echo htmlspecialchars($mahasiswa['nama']); ?></td>
                        <td><?php echo htmlspecialchars($mahasiswa['angkatan']); ?></td>
                        <td><?php echo htmlspecialchars($pendaftaranMagang['lokasi_magang']); ?></td>
                        <td><?php echo htmlspecialchars($pendaftaranMagang['tanggal_mulai']); ?></td>
                        <td><?php echo htmlspecialchars($pendaftaranMagang['tanggal_selesai']); ?></td>
                        <td><?php echo htmlspecialchars($pendaftaranMagang['status']); ?></td>
                        <td> <a href='index.php?detail_jadwal&detail=<?php echo $mahasiswa['nim'] ?>'>
                                <button id='btn_create' class='btn btn-xs btn-primary' data-toggle='tooltip'
                                    data-container='body' title='Ubah'><span class='glyphicon glyphicon-eye-open'
                                        aria-hidden='true'></span></button></a></td>
                    </tr>
                </tbody>
            </table>
            <?php else: ?>
            <div class="alert alert-warning">
                <strong>Perhatian!</strong> Anda belum mendaftar magang.
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>