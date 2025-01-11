<?php
require '../koneksi.php';

$userId = $_SESSION['users']['id'];
$sqlData = "SELECT 
    l.nilai_laporan,
    l.laporan_id,
    l.mahasiswa_id, 
    l.penguji_id, 
    up.judul_laporan AS judul_laporan,
    up.file_laporan AS file_laporan,
    m.nama AS nama_mahasiswa, 
    m.nama AS nama_mahasiswa, 
    m.nama AS nama_mahasiswa, 
    m.nim AS nim_mahasiswa, 
    m.angkatan AS angkatan_mahasiswa, 
    u1.name AS nama_penguji, 
    pb.nip AS nip_penguji
FROM penilaian l
LEFT JOIN upload_laporan up ON l.laporan_id = up.id 
LEFT JOIN mahasiswa m ON l.mahasiswa_id = m.id 
LEFT JOIN penguji pb ON l.penguji_id = pb.id
LEFT JOIN users u1 ON pb.penguji_id = u1.id
LEFT JOIN users u2 ON m.mahasiswa_id = u2.id
WHERE u2.id = ?";

$queryDataL = $conn->prepare($sqlData);
$queryDataL->bind_param("i", $userId);
$queryDataL->execute();
$result = $queryDataL->get_result();

?>

<section class="content-header">
    <h1>Laporan yang Sudah Dinilai</h1>
    <ol class="breadcrumb">
        <li><a href="index.php?dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php?data_laporan_magang">Data Laporan</a></li>
        <li class="active">Laporan yang Sudah Dinilai</li>
    </ol>
</section>

<section class="content">
    <div class="box box-info">
        <div class="box-header">
            <h3>Laporan yang Sudah Dinilai oleh Anda</h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th>Angkatan</th>
                        <th>Judul Laporan</th>
                        <th>File Laporan</th>
                        <th>Nilai Laporan</th>
                        <th>Nama Penguji</th>
                        <th>NIP Penguji</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $no = 1;
                        while ($laporan = $result->fetch_assoc()) {
                            ?>
                    <tr>
                        <td><?php echo htmlspecialchars($no++); ?></td>
                        <td><?php echo htmlspecialchars($laporan['nama_mahasiswa']); ?></td>
                        <td><?php echo htmlspecialchars($laporan['nim_mahasiswa']); ?></td>
                        <td><?php echo htmlspecialchars($laporan['angkatan_mahasiswa']); ?></td>
                        <td><?php echo htmlspecialchars($laporan['judul_laporan']); ?></td>
                        <td>
                            <?php if (!empty($laporan['file_laporan'])) { ?>
                            <a href="../dist/file/<?php echo htmlspecialchars($laporan['file_laporan']); ?>"
                                target="_blank">Lihat Laporan</a>
                            <?php } else { ?>
                            <span class="text-danger">Tidak ada file</span>
                            <?php } ?>
                        </td>
                        <td><?php echo htmlspecialchars($laporan['nilai_laporan']); ?></td>
                        <td><?php echo htmlspecialchars($laporan['nama_penguji']); ?></td>
                        <td><?php echo htmlspecialchars($laporan['nip_penguji']); ?></td>
                    </tr>
                    <?php
                        }
                    } else {
                        ?>
                    <tr>
                        <td colspan="10" class="text-center">Laporan belum dinilai.</td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>