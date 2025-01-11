<?php
require '../koneksi.php';
$userId = $_SESSION['users']['id']; 

$sqlData = "SELECT 
    l.id AS laporan_id, 
    l.judul_laporan, 
    l.file_laporan, 
    m.id AS mahasiswa_id, 
    m.nama AS nama_mahasiswa, 
    m.nim AS nim_mahasiswa, 
    m.angkatan AS angkatan_mahasiswa, 
    u2.name AS nama_penguji, 
    pb.nip AS nip_penguji, 
    pb.penguji_id, 
    l.created_at
FROM upload_laporan l
LEFT JOIN mahasiswa m ON l.mahasiswa_id = m.id 
LEFT JOIN penguji pb ON l.penguji_id = pb.id
LEFT JOIN users u2 ON pb.penguji_id = u2.id 
LEFT JOIN users u1 ON m.mahasiswa_id = u1.id 
WHERE u2.id = ?";

$queryDataL = $conn->prepare($sqlData);
$queryDataL->bind_param("i", $userId);
$queryDataL->execute();
$Laporan = $queryDataL->get_result();

if ($Laporan->num_rows > 0) {
    $no_urut = 1;
} else {
    echo "<div class='alert alert-danger'>Data laporan tidak ditemukan.</div>";
    $Laporan = [];
}
?>

<section class="content-header">
    <h1>Data Laporan</h1>
    <ol class="breadcrumb">
        <li><a href="index.php?dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Data Laporan</li>
    </ol>
</section>

<section class="content">
    <div class="box box-info">
        <div class="box-header">
            <div class="row-fluid" style="overflow:auto">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Laporan</th>
                            <th>File Laporan</th>
                            <th>Nama Mahasiswa</th>
                            <th>NIM Mahasiswa</th>
                            <th>Nama Penguji</th>
                            <th>NIP Penguji</th>
                            <th>Aksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $Laporan->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $no_urut++; ?>.</td>
                            <td><?php echo htmlspecialchars($row['judul_laporan']); ?></td>
                            <td>
                                <?php if (!empty($row['file_laporan'])) { ?>
                                <a href="../dist/file/<?php echo htmlspecialchars($row['file_laporan']); ?>"
                                    target="_blank">Lihat
                                    Laporan</a>
                                <?php } else { ?>
                                <span class="text-danger">Tidak ada file</span>
                                <?php } ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['nama_mahasiswa']); ?></td>
                            <td><?php echo htmlspecialchars($row['nim_mahasiswa']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_penguji']); ?></td>
                            <td><?php echo htmlspecialchars($row['nip_penguji']); ?></td>
                            <td> <a href='index.php?penilaian&detail=<?php echo $row['nim_mahasiswa'] ?>'>
                                    <button id='btn_create' class='btn btn-xs btn-primary' data-toggle='tooltip'
                                        data-container='body' title='Ubah'><span class='glyphicon glyphicon-eye-open'
                                            aria-hidden='true'></span></button></a></td>
                        </tr>
                        <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</section>