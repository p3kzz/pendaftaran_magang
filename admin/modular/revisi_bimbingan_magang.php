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
    LEFT JOIN users u ON p.pembimbing_id = u.id
    LEFT JOIN users u1 ON m.mahasiswa_id = u1.id
    WHERE u1.id = ?";

$queryData = $conn->prepare($sqlData);
$queryData->bind_param('i', $userID);
$queryData->execute();
$resultData = $queryData->get_result();
if ($resultData->num_rows > 0) {
    $data = $resultData->fetch_assoc();
} else {
    echo "<div class='alert alert-danger'>Data Mahasiswa Tidak ditemukan!</div>";
    $data = [];
}

if (isset($_POST['submit'])) {
    $laporan = $_FILES['laporan']['name'];
    $file_tmp = $_FILES['laporan']['tmp_name'];
    $file_error = $_FILES['laporan']['error'];
    $file_type = $_FILES['laporan']['type'];
    $file_size = $_FILES['laporan']['size'];
    $target_dir = "../dist/file_bimbingan/";
    $target_file = $target_dir . basename($laporan);

    $maxFileSize = 10 * 1024 * 1024;
    // $checkRevisi = "SELECT jumlah_revisi FROM laporan_bimbingan WHERE id = ?";
    // $stmtCheck = $conn->prepare($checkRevisi);
    // $stmtCheck->bind_param("i", $data['laporan_id']);
    // $stmtCheck->execute();
    // $resultCheck = $stmtCheck->get_result();
    // $laporanData = $resultCheck->fetch_assoc();

    if ($file_type !== 'application/pdf') {
        echo "<div class='alert alert-danger'>File yang diupload harus berformat PDF.</div>";
    } elseif ($file_error !== UPLOAD_ERR_OK) {
        echo "<div class='alert alert-danger'>Terjadi kesalahan saat mengupload file.</div>";
    } elseif ($file_size > $maxFileSize) {
        echo "<div class='alert alert-danger'>Ukuran file tidak boleh lebih dari 10 MB.</div>";
    } else {
        $oldFileQuery = "SELECT laporan FROM laporan_bimbingan WHERE id = ?";
        $stmtOldFile = $conn->prepare($oldFileQuery);
        $stmtOldFile->bind_param("i", $data['laporan_id']);
        $stmtOldFile->execute();
        $resultOldFile = $stmtOldFile->get_result();
        $oldFile = $resultOldFile->fetch_assoc();

        if (!empty($oldFile['laporan'])) {
            $oldFilePath = $target_dir . $oldFile['laporan'];
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        if (move_uploaded_file($file_tmp, $target_file)) {
            $sql = "INSERT INTO laporan_bimbingan 
                    (mahasiswa_id, pembimbing_id, jadwal_id, laporan)
                    VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "iiis",
                $data['mahasiswa_id'],
                $data['pembimbing_id'],
                $data['jadwal_id'],
                $laporan
            );
            if ($stmt->execute()) {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Laporan berhasil dikirim.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = 'index.php?data_bimbingan'; // Redirect setelah sukses
                        });
                    });
                </script>";
            } else {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Laporan gagal dikirim.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
                </script>";
            }
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Laporan gagal diunggah.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
            </script>";
        }
    }
}
?>

<section class="content-header">
    <h1> Revisi Laporan </h1>
    <ol class="breadcrumb">
        <li><a href="homepage.php?dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Revisi Laporan</li>
    </ol>
</section>

<section class="content">
    <div class="box box-info">
        <div class="box-header">
            <div class="row-fluid">
                <div class="col-md-8">
                    <form role="form" method="POST" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="nama">Nama Lengkap</label>
                                <input type="text" class="form-control" value="<?php echo $data['nama_mahasiswa']; ?>"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="nim">NIM</label>
                                <input type="text" class="form-control" value="<?php echo $data['nim_mahasiswa']; ?>"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="angkatan">Angkatan</label>
                                <input type="text" class="form-control"
                                    value="<?php echo $data['angkatan_mahasiswa']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="name">Nama Pembimbing</label>
                                <input type="text" class="form-control" value="<?php echo $data['nama_pembimbing']; ?>"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="nip">NIP Pembimbing</label>
                                <input type="text" class="form-control" value="<?php echo $data['nip_pembimbing']; ?>"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_bimbingan">Tanggal Bimbingan</label>
                                <input type="text" class="form-control"
                                    value="<?php echo $data['tanggal_bimbingan']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Berkas Laporan</label>
                                <input type="file" id="exampleInputFile" name="laporan" accept=".pdf" required>
                                <p class="help-block">*Format berkas: NamaMahasiswa_NIM.pdf<br>*Ukuran file tidak boleh
                                    lebih dari 10 MB</p>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="submit">Kirim</button>
                            <a href="index.php?data_bimbingan" class="btn btn-danger">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>