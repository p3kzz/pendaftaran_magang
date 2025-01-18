<?php
require '../koneksi.php';

if (!isset($_SESSION['users']['id'])) {
    die("<div class='alert alert-danger'>Sesi telah berakhir. Silahkan login kembali.</div>");
}

$userID = $_SESSION['users']['id'];

$sqlData = "SELECT
    lb.id AS laporan_id,
    lb.laporan,
    lb.catatan,
    lb.status,
    m.id AS mahasiswa_id,
    m.nama AS nama_mahasiswa, 
    m.nim AS nim_mahasiswa,
    m.angkatan AS angkatan_mahasiswa,
    u.name AS nama_pembimbing,
    p.nip AS nip_pembimbing,
    lb.pembimbing_id,
    j.id AS jadwal_id,
    j.tanggal_bimbingan,
    pn.nilai_bimbingan
FROM laporan_bimbingan lb
INNER JOIN mahasiswa m ON lb.mahasiswa_id = m.id
INNER JOIN pembimbing p ON lb.pembimbing_id = p.id
LEFT JOIN jadwal j ON j.mahasiswa_id = m.id AND j.pembimbing_id = lb.pembimbing_id
LEFT JOIN users u ON p.pembimbing_id = u.id
INNER JOIN penilaian pn ON pn.mahasiswa_id = lb.mahasiswa_id
WHERE p.pembimbing_id = ? 
AND lb.status = 'acc'
AND pn.nilai_bimbingan IS NOT NULL
AND pn.nilai_bimbingan != ''
ORDER BY j.tanggal_bimbingan DESC";

try {
    $queryData = $conn->prepare($sqlData);
    if (!$queryData) {
        throw new Exception($conn->error);
    }

    $queryData->bind_param('i', $userID);
    if (!$queryData->execute()) {
        throw new Exception($queryData->error);
    }

    $resultData = $queryData->get_result();
    $hasData = $resultData->num_rows > 0;
} catch (Exception $e) {
    die("<div class='alert alert-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</div>");
}
?>

<section class="content">
    <div class="box box-info">
        <div class="box-header">
            <h1>Data Bimbingan Yang Sudah Dinilai</h1>
        </div>
        <div class="box-body">
            <?php if (!$hasData): ?>
                <div class='alert alert-info'>Tidak ada data bimbingan yang sudah dinilai.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Angkatan</th>
                                <th>Nama Pembimbing</th>
                                <th>NIP Pembimbing</th>
                                <th>Tanggal Bimbingan</th>
                                <th>File Laporan</th>
                                <th>Nilai Bimbingan</th>
                                <!-- <th>Aksi</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no_urut = 1;
                            while ($data = $resultData->fetch_assoc()):
                            ?>
                                <tr>
                                    <td><?php echo $no_urut++; ?></td>
                                    <td><?php echo htmlspecialchars($data['nama_mahasiswa']); ?></td>
                                    <td><?php echo htmlspecialchars($data['nim_mahasiswa']); ?></td>
                                    <td><?php echo htmlspecialchars($data['angkatan_mahasiswa']); ?></td>
                                    <td><?php echo htmlspecialchars($data['nama_pembimbing']); ?></td>
                                    <td><?php echo htmlspecialchars($data['nip_pembimbing']); ?></td>
                                    <td><?php echo $data['tanggal_bimbingan'] ? htmlspecialchars($data['tanggal_bimbingan']) : '<span class="text-muted">-</span>'; ?></td>
                                    <td>
                                        <?php if (!empty($data['laporan'])): ?>
                                            <a href="../dist/file_bimbingan/<?php echo htmlspecialchars($data['laporan']); ?>"
                                                target="_blank" class="btn btn-xs btn-info">
                                                <i class="glyphicon glyphicon-file"></i> Lihat Laporan
                                            </a>
                                        <?php else: ?>
                                            <span class="text-danger">Tidak ada file</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($data['nilai_bimbingan']); ?></td>

                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>