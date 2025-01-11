<?php
require '../koneksi.php';

$sqlPendaftaran = "SELECT m.nim, m.nama, m.angkatan, mg.id AS magang_id, mg.lokasi_magang, mg.tanggal_mulai, mg.tanggal_selesai, mg.status
                FROM magang mg
                JOIN mahasiswa m ON mg.mahasiswa_id = m.id
                WHERE mg.status = 'ditolak'  
                ORDER BY mg.created_at DESC";
$queryPendaftaran = $conn->query($sqlPendaftaran);
?>

<section class="content-header">
    <h1> Data Magang Ditolak </h1>
    <ol class="breadcrumb">
        <li><a href="index.php?dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Data Magang DItolak</li>
    </ol>
</section>

<section class="content">
    <div class="box box-info">
        <div class="box-header">
            <div class="row-fluid" style="overflow:auto">
                <div class="col-md-8">
                    <!-- Jika ingin menambah tombol tambahan, bisa ditambahkan di sini -->
                </div>
                <br /><br /><br />

                <!-- Tabel Data Magang -->
                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Angkatan</th>
                            <th>Lokasi Magang</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($queryPendaftaran->num_rows > 0) {
                            $no_urut = 1;
                            while ($row = $queryPendaftaran->fetch_assoc()) {
                        ?>
                        <tr>
                            <td align="center"><?php echo $no_urut++; ?>.</td>
                            <td><?php echo htmlspecialchars($row['nim']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama']); ?></td>
                            <td><?php echo htmlspecialchars($row['angkatan']); ?></td>
                            <td><?php echo htmlspecialchars($row['lokasi_magang']); ?></td>
                            <td><?php echo htmlspecialchars($row['tanggal_mulai']); ?></td>
                            <td><?php echo htmlspecialchars($row['tanggal_selesai']); ?></td>
                            <td>
                                <span class="badge badge-success"><?php echo htmlspecialchars($row['status']); ?></span>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                            // Jika tidak ada data, tampilkan pesan
                            echo "<tr><td colspan='8' class='text-center'>Belum ada data ditolak</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>