<?php
include '../koneksi.php'; 

$sqlJadwal = "SELECT 
    j.keterangan, 
    j.tanggal, 
    j.magang_id, 
    j.mahasiswa_id, 
    j.pembimbing_id, 
    j.penguji_id,
    m.nama AS nama_mahasiswa,
    m.nim AS nim_mahasiswa,
    u1.name AS nama_pembimbing,
    p.nip AS nip_pembimbing,
    u2.name AS nama_penguji,
    g.nip AS nip_penguji
FROM jadwal j
LEFT JOIN mahasiswa m ON j.mahasiswa_id = m.id
LEFT JOIN pembimbing p ON j.pembimbing_id = p.id
LEFT JOIN users u1 ON p.pembimbing_id = u1.id
LEFT JOIN penguji g ON j.penguji_id = g.id
LEFT JOIN users u2 ON g.penguji_id = u2.id
ORDER BY j.id ASC";

$queryjadwal = $conn->query($sqlJadwal);

if ($queryjadwal->num_rows > 0) {
    $no_urut = 1;
} else {
    echo "<div class='alert alert-danger'>Data jadwal tidak ditemukan.</div>";
    $queryjadwal = [];
}

?>

<section class="content-header">
    <h1>Data Jadwal Sidang</h1>
    <ol class="breadcrumb">
        <li><a href="index.php?dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Data Jadwal</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-info">
        <div class="box-header">
            <div class="row-fluid" style="overflow:auto">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Keterangan</th>
                            <th>Tanggal</th>
                            <th>Nama Mahasiswa</th>
                            <th>NIM Mahasiswa</th>
                            <th>Nama Pembimbing</th>
                            <th>NIP Pembimbing</th>
                            <th>Nama Penguji</th>
                            <th>NIP Penguji</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $queryjadwal->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $no_urut++; ?>.</td>
                            <td><?php echo htmlspecialchars($row['keterangan']); ?></td>
                            <td><?php echo htmlspecialchars($row['tanggal']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_mahasiswa']); ?></td>
                            <td><?php echo htmlspecialchars($row['nim_mahasiswa']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_pembimbing']); ?></td>
                            <td><?php echo htmlspecialchars($row['nip_pembimbing']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_penguji']); ?></td>
                            <td><?php echo htmlspecialchars($row['nip_penguji']); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>