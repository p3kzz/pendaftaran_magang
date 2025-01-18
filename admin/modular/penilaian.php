<?php
require '../koneksi.php';

if (isset($_GET['detail'])) {
    $nim = $_GET['detail'];
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
    pb.id AS penguji_id, 
    l.created_at
FROM upload_laporan l
LEFT JOIN mahasiswa m ON l.mahasiswa_id = m.id 
LEFT JOIN penguji pb ON l.penguji_id = pb.id
LEFT JOIN users u2 ON pb.penguji_id = u2.id 
WHERE m.nim = $nim";


    $result = mysqli_query($conn, $sqlData);

    if (!$result) {
        die("Query Error: " . mysqli_error($conn));
    } else {
        $laporan = mysqli_fetch_assoc($result);
    }
}
if (isset($_POST['nilai'])) {
    $nilai_laporan = trim($_POST['nilai']);
    $laporan_id = $laporan['laporan_id'];
    $mahasiswa_id = $laporan['mahasiswa_id']; 
    $penguji_id = $laporan['penguji_id']; 
    $checkNilai = $conn->prepare("SELECT id FROM penilaian WHERE laporan_id = ? AND penguji_id = ?");
    $checkNilai->bind_param("ii", $laporan_id, $penguji_id);
    $checkNilai->execute();
    $checkNilaiResult = $checkNilai->get_result();

    if ($checkNilaiResult->num_rows > 0) {
        echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'Laporan Sudah Dinilai!',
                text: 'Laporan ini sudah memiliki penilaian dari Anda!'
            }).then(() => {
                window.location.href = 'index.php?data_laporan_magang';
            });
        </script>";
        exit;
    }

    if (!empty($nilai_laporan)) {
        $conn->begin_transaction();

        try {
            $insertNilai = $conn->prepare("INSERT INTO penilaian (nilai_laporan, laporan_id, mahasiswa_id, penguji_id, created_at) VALUES (?, ?, ?, ?, NOW())");
            $insertNilai->bind_param("diii", $nilai_laporan, $laporan_id, $mahasiswa_id, $penguji_id);
            $insertNilai->execute();

            if ($insertNilai->affected_rows > 0) {
                $conn->commit();
                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Penilaian berhasil disimpan!'
                    }).then(() => {
                        window.location.href = 'index.php?data_laporan_magang';
                    });
                </script>";
                exit;
            } else {
                throw new Exception("Gagal menyimpan penilaian.");
            }
        } catch (Exception $e) {
            $conn->rollback();
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Gagal menyimpan data: {$e->getMessage()}'
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: 'Nilai wajib diisi!'
            });
        </script>";
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
                    <td><?php echo isset($laporan['nama_mahasiswa']) ? htmlspecialchars($laporan['nama_mahasiswa']) : 'Tidak tersedia'; ?>
                    </td>
                </tr>
                <tr>
                    <th>NIM</th>
                    <td><?php echo isset($laporan['nim_mahasiswa']) ? htmlspecialchars($laporan['nim_mahasiswa']) : 'Tidak tersedia'; ?>
                    </td>
                </tr>
                <tr>
                    <th>Angkatan</th>
                    <td><?php echo isset($laporan['angkatan_mahasiswa']) ? htmlspecialchars($laporan['angkatan_mahasiswa']) : 'Tidak tersedia'; ?>
                    </td>
                </tr>
                <tr>
                    <th>Judul Laporan</th>
                    <td><?php echo isset($laporan['judul_laporan']) ? htmlspecialchars($laporan['judul_laporan']) : 'Tidak tersedia'; ?>
                    </td>
                </tr>
                <tr>
                    <th>File Laporan</th>
                    <td>
                        <?php if (!empty($laporan['file_laporan'])) { ?>
                        <a href="../dist/file/<?php echo htmlspecialchars($laporan['file_laporan']); ?>"
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
            <h3>Form Penilaian</h3>
        </div>
        <div class="box-body">
            <form method="post">
                <div class="form-group">
                    <label for="nilai">Nilai</label>
                    <input type="number" class="form-control" id="nilai" name="nilai" min="0" max="100" required>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Kirim Penilaian</button>
                    <a href="index.php?data_laporan_magang" class="btn btn-danger">Batal</a>
                </div>
            </form>
        </div>
    </div>
</section>