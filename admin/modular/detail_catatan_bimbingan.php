<?php
require '../koneksi.php';

if (isset($_GET['detail'])) {
    $nim = $_GET['detail'];
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
    LEFT JOIN users u On p.pembimbing_id = u.id
    LEFT JOIN users u1 ON m.mahasiswa_id = u1.id
    WHERE m.nim = $nim";


    $resultData = mysqli_query($conn, $sqlData);
    if (!$resultData) {
        die("Query Error: " . mysqli_error($conn));
    }else{
        $data = mysqli_fetch_assoc($resultData);
    }
}
if (isset($_POST['submit_penilaian'])) {
    $catatan = $_POST['catatan'];
    $status = $_POST['status'];
    $tanggal_bimbingan = $_POST['tanggal_bimbingan'];
    $laporan_id = $data['laporan_id'];
    $jadwal_id = $data['jadwal_id']; 
    $updateLaporanQuery = "UPDATE laporan_bimbingan 
                            SET catatan = ?, 
                            status = ?
                            WHERE id = ?";
    $stmtLaporan = $conn->prepare($updateLaporanQuery);
    $stmtLaporan->bind_param("ssi", $catatan, $status, $laporan_id);

    $updateJadwalQuery = "UPDATE jadwal SET tanggal_bimbingan = ? WHERE id = ?";
    $stmtJadwal = $conn->prepare($updateJadwalQuery);
    $stmtJadwal->bind_param("si", $tanggal_bimbingan, $jadwal_id);

    if ($stmtLaporan->execute() && $stmtJadwal->execute()) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Catatan Berhasil dikirim.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'index.php?catatan_bimbingan';
                });
            });
        </script>";
    } else {
        echo "<div class='alert alert-danger'>Terjadi kesalahan saat mengupdate data!</div>";
    }
}

?>



<section class="content-header">
    <h1>Penilaian Mahasiswa</h1>
    <ol class="breadcrumb">
        <li><a href="index.php?dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php?data_laporan_magang">Data Laporan</a></li>
        <li class="active">Penilaian</li>
    </ol>
</section>

<section class="content">
    <div class="box box-info">
        <div class="box-header">
            <h3>Detail Mahasiswa</h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered">
                <tr>
                    <th>Nama Mahasiswa</th>
                    <td><?php echo isset($data['nama_mahasiswa']) ? htmlspecialchars($data['nama_mahasiswa']) : 'Tidak tersedia'; ?>
                    </td>
                </tr>
                <tr>
                    <th>NIM</th>
                    <td><?php echo isset($data['nim_mahasiswa']) ? htmlspecialchars($data['nim_mahasiswa']) : 'Tidak tersedia'; ?>
                    </td>
                </tr>
                <tr>
                    <th>Angkatan</th>
                    <td><?php echo isset($data['angkatan_mahasiswa']) ? htmlspecialchars($data['angkatan_mahasiswa']) : 'Tidak tersedia'; ?>
                    </td>
                </tr>
                <tr>
                    <th>Nama Pembimbing</th>
                    <td><?php echo isset($data['nama_pembimbing']) ? htmlspecialchars($data['nama_pembimbing']) : 'Tidak tersedia'; ?>
                    </td>
                </tr>
                <tr>
                    <th>NIP Pembimbing</th>
                    <td><?php echo isset($data['nip_pembimbing']) ? htmlspecialchars($data['nip_pembimbing']) : 'Tidak tersedia'; ?>
                    </td>
                </tr>
                <tr>
                    <th>Tanggal Bimbingan</th>
                    <td>
                        <?php echo isset($data['tanggal_bimbingan']) ? htmlspecialchars($data['tanggal_bimbingan']) : 'Tidak tersedia'; ?>
                    </td>
                </tr>
                <tr>
                    <th>File Laporan</th>
                    <td>
                        <?php if (!empty($data['laporan'])) { ?>
                        <a href="../dist/file_bimbingan/<?php echo htmlspecialchars($data['laporan']); ?>"
                            target="_blank">Lihat Laporan</a>
                        <?php } else { ?>
                        <span class="text-danger">Tidak ada file</span>
                        <?php } ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="box box-success">
        <div class="box-header">
            <h3>Form Catatan</h3>
        </div>
        <div class="box-body">
            <form method="post">
                <div class="form-group">
                    <label for="catatan">Catatan</label>
                    <textarea class="form-control" id="catatan" name="catatan"
                        required><?php echo $data['catatan']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="belumdicek" <?php echo $data['status'] === 'belumdicek' ? 'selected' : ''; ?>>
                            Belum Dicek</option>
                        <option value="acc" <?php echo $data['status'] === 'acc' ? 'selected' : ''; ?>>ACC</option>
                        <option value="revisi" <?php echo $data['status'] === 'revisi' ? 'selected' : ''; ?>>Revisi
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tanggal_bimbingan">Tanggal Bimbingan</label>
                    <input type="date" class="form-control" id="tanggal_bimbingan" name="tanggal_bimbingan"
                        value="<?php echo htmlspecialchars($data['tanggal_bimbingan']); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary" name="submit_penilaian">Simpan</button>
            </form>

        </div>
    </div>
</section>