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

$sqlCekMagang = "SELECT id FROM magang WHERE mahasiswa_id = ?";
$checkMagang = $conn->prepare($sqlCekMagang);
$checkMagang->bind_param("i", $mahasiswaId);
$checkMagang->execute();
$resultCekMagang = $checkMagang->get_result();

$sudahDaftar = $resultCekMagang->num_rows > 0;

if (isset($_POST['submit']) && !$sudahDaftar) {
    $lokasiMagang = $_POST['lokasi_magang'];
    $tanggalMulai = $_POST['tanggal_mulai'];
    $tanggalSelesai = $_POST['tanggal_selesai'];

    $sqlInsertMagang = "INSERT INTO magang (mahasiswa_id, lokasi_magang, tanggal_mulai, tanggal_selesai, status, created_at) 
                        VALUES (?, ?, ?, ?, 'menunggu', NOW())";
    $insertMagang = $conn->prepare($sqlInsertMagang);
    $insertMagang->bind_param("isss", $mahasiswaId, $lokasiMagang, $tanggalMulai, $tanggalSelesai);

    if ($insertMagang->execute()) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Pendaftaran magang berhasil!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'index.php?Pengumuman_magang';
                });
            });
        </script>";
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat mendaftar magang.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        </script>";
    }
} elseif ($sudahDaftar) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Peringatan!',
                text: 'Anda sudah mendaftar magang. Anda tidak dapat mendaftar lagi.',
                icon: 'warning',
                confirmButtonText: 'OK'
            }).then(() => {
                    window.location.href='index.php?Pengumuman_magang';
                });
        });
    </script>";
}
?>
<section class="content">
    <div class="box box-info">
        <div class="box-header">
            <h1>Pendaftaran Magang</h1>
        </div>
        <div class="box-body">
            <?php if (!$sudahDaftar): ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>NIM</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($mahasiswa['nim']); ?>"
                        readonly>
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($mahasiswa['nama']); ?>"
                        readonly>
                </div>
                <div class="form-group">
                    <label>Angkatan</label>
                    <input type="text" class="form-control"
                        value="<?php echo htmlspecialchars($mahasiswa['angkatan']); ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Lokasi Magang (Instansi)</label>
                    <input type="text" name="lokasi_magang" class="form-control" placeholder="Masukkan lokasi magang"
                        required>
                </div>
                <div class="form-group">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Kirim</button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</section>