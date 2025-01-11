<?php
require '../koneksi.php';
$sqlPendaftaran = "SELECT m.nim, m.nama, m.angkatan, mg.id AS magang_id, mg.lokasi_magang, mg.tanggal_mulai, mg.tanggal_selesai, mg.status
                FROM magang mg
                JOIN mahasiswa m ON mg.mahasiswa_id = m.id
                ORDER BY mg.created_at DESC";
$queryPendaftaran = $conn->query($sqlPendaftaran);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['magang_id'], $_POST['status'])) {
    $magangId = $_POST['magang_id'];
    $status = $_POST['status'];

    if (in_array($status, ['diterima', 'ditolak'])) {
        $sqlUpdate = "UPDATE magang SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($sqlUpdate);
        $stmt->bind_param("si", $status, $magangId);

        if ($stmt->execute()) {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Verifikasi Berhasil.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = window.location.href;
                        });
                    });
                </script>";
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat mengubah status.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
            </script>";
        }
    }
}
?>

<body>
    <div class="content">
        <h1 class="text-center mb-4">Kelola Pendaftaran Magang</h1>

        <!-- Box for Styling -->
        <div class="box box-info">
            <div class="box-header">
                <div class="row-fluid" style="overflow:auto">
                    <table id="myTable" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Angkatan</th>
                                <th>Instansi</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                                <th>Aksi</th>
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
                                    <span
                                        class="label label-<?php echo $row['status'] === 'diterima' ? 'success' : ($row['status'] === 'ditolak' ? 'danger' : 'warning'); ?>">
                                        <?php echo htmlspecialchars($row['status']); ?>
                                    </span>

                                </td>
                                <td>
                                    <?php if ($row['status'] === 'menunggu'): ?>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="magang_id" value="<?php echo $row['magang_id']; ?>">
                                        <input type="hidden" name="status" value="diterima">
                                        <button type="submit" class="btn btn-success btn-sm">Terima</button>
                                    </form>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="magang_id" value="<?php echo $row['magang_id']; ?>">
                                        <input type="hidden" name="status" value="ditolak">
                                        <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                    </form>
                                    <?php else: ?>
                                    <span class="text-muted">Sudah di Verifikasi</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php
                                }
                            } else {
                                // Jika tidak ada data, tampilkan pesan
                                echo "<tr><td colspan='9' class='text-center'>Belum ada data</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>