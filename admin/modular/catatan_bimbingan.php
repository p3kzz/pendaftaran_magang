<?php
require '../koneksi.php';

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
    j.tanggal_bimbingan
    FROM laporan_bimbingan lb
    LEFT JOIN mahasiswa m ON lb.mahasiswa_id = m.id
    LEFT JOIN pembimbing p ON lb.pembimbing_id = p.id
    LEFT JOIN jadwal j ON j.mahasiswa_id = m.id
    LEFT JOIN users u1 ON m.mahasiswa_id = u1.id
    LEFT JOIN users u On p.pembimbing_id = u.id
    WHERE u.id = ? and lb.id = (SELECT max(lb1.id) FROM  laporan_bimbingan lb1
    LEFT JOIN jadwal j1 ON j1.mahasiswa_id = lb1.mahasiswa_id
     WHERE j1.tanggal_bimbingan = j.tanggal_bimbingan 
     and lb1.mahasiswa_id = m.id
     )";

$queryData = $conn->prepare($sqlData);
$queryData->bind_param('i', $userID);
$queryData->execute();
$resultData = $queryData->get_result();
if ($resultData->num_rows > 0) {
    $no_urut = 1;
} else {
    echo "<div class='alert alert-danger'>Data Mahasiswa Tidak ditemukan!</div>";
    $data = [];
}
?>


<section class="content">
    <div class="box box-info">
        <div class="box-header">
            <h1>Data Bimbingan</h1>
        </div>
        <div class="box-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Angkatan</th>
                        <th>Nama Pembimbing</th>
                        <th>NIP Pembimbing</th>
                        <th>Tanggal Bimbingan</th>
                        <th>FIle Laporan</th>
                        <th>Catatan Bimbingan</th>
                        <th>Status</th>
                        <th>aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($data = $resultData->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($no_urut++); ?></td>
                        <td><?php echo htmlspecialchars($data['nama_mahasiswa']); ?></td>
                        <td><?php echo htmlspecialchars($data['nim_mahasiswa']); ?></td>
                        <td><?php echo htmlspecialchars($data['angkatan_mahasiswa']); ?></td>
                        <td><?php echo htmlspecialchars($data['nama_pembimbing']); ?></td>
                        <td><?php echo htmlspecialchars($data['nip_pembimbing']); ?></td>
                        <td><?php echo htmlspecialchars($data['tanggal_bimbingan']); ?></td>
                        <td>
                            <?php if (!empty($data['laporan'])) { ?>
                            <a href="../dist/file_bimbingan/<?php echo htmlspecialchars($data['laporan']); ?>"
                                target="_blank">Lihat
                                Laporan</a>
                            <?php } else { ?>
                            <span class="text-danger">Tidak ada file</span>
                            <?php } ?>
                        </td>
                        <td><?php echo isset($data['catatan']) ? htmlspecialchars($data['catatan']) : '<span class="text-danger">Belum diisi</span>'; ?>
                        </td>

                        <td>
                            <span
                                class="label label-<?php echo $data['status'] === 'acc' ? 'success' : ($data['status'] === 'ditolak' ? 'danger' : 'warning'); ?>">
                                <?php echo htmlspecialchars($data['status']); ?>
                            </span>
                        </td>
                        <td> <a href='index.php?detail_catatan_bimbingan&detail=<?php echo $data['nim_mahasiswa'] ?>'>
                                <button id='btn_create' class='btn btn-xs btn-primary' data-toggle='tooltip'
                                    data-container='body' title='Ubah'><span class='glyphicon glyphicon-eye-open'
                                        aria-hidden='true'></span></button></a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
    </div>
</section>