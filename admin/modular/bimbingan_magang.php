<?php
require '../koneksi.php';

$userID = $_SESSION['users']['id'];
$sqlData = "SELECT
    p.id AS penentuan_id,
    m.id AS mahasiswa_id,
    m.nama AS nama_mahasiswa,
    m.nim AS nim_mahasiswa,
    m.angkatan AS angkatan_mahasiswa,
    u.name AS nama_pembimbing,
    p.nip AS nip_pembimbing,
    pb.pembimbing_id,
    j.id AS jadwal_id,
    j.tanggal_bimbingan
    FROM penentuan_pembimbing pb
    LEFT JOIN mahasiswa m ON pb.mahasiswa_id = m.id
    LEFT JOIN pembimbing p ON pb.pembimbing_id = p.id
    LEFT JOIN jadwal j ON j.mahasiswa_id = m.id
    LEFT JOIN users u On p.pembimbing_id = u.id
    LEFT JOIN users u1 ON m.mahasiswa_id = u1.id
    WHERE u1.id = ?";

$queryData = $conn->prepare($sqlData);
$queryData->bind_param('i', $userID);
$queryData->execute();
$resultData = $queryData->get_result();
if ($resultData->num_rows === 0) {
     echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Akses Ditolak',
            text: 'Jadwal, dosen pembimbing, dan penguji belum ditentukan.'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'index.php?dashboard'; 
            }
        });
    });
    </script>";
    exit;
}

if (isset($_POST['submit'])) {
    $laporan = $_FILES['laporan']['name'];
    $file_tmp = $_FILES['laporan']['tmp_name'];
    $file_error = $_FILES['laporan']['error'];
    $file_type = $_FILES['laporan']['type'];
    $target_dir = "../dist/file_bimbingan/";
    $target_file = $target_dir . basename($laporan);
    
    if ($file_type !== 'application/pdf') {
        echo "<div class='alert alert-danger'>File yang diupload harus berformat PDF.</div>";
    } elseif ($file_error !== UPLOAD_ERR_OK) {
        echo "<div class='alert alert-danger'>Terjadi kesalahan saat mengupload file.</div>";
    } else {
        if (move_uploaded_file($file_tmp, $target_file)) {
            $sql = "INSERT INTO laporan_bimbingan ( mahasiswa_id, pembimbing_id, jadwal_id, laporan) VALUES (?, ?, ?, ? )";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiis",  $data['mahasiswa_id'], $data['pembimbing_id'], $data['jadwal_id'], $laporan);
            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Laporan berhasil diupload.</div>";
            } else {
                echo "<div class='alert alert-danger'>Gagal menyimpan laporan ke database.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Gagal memindahkan file ke folder tujuan.</div>";
        }
    }

}


?>


<section class="content-header">
    <h1> Laporan Bimbingan </h1>
    <ol class="breadcrumb">
        <li><a href="homepage.php?dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Laporan Bimbingan</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- quick email widget -->
    <div class="box box-info">
        <div class="box-header">
            <div class="row-fluid">
                <div class="col-md-8">
                    <!-- form start -->
                    <form role="form" method="POST" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="nama">Nama Lengkap</label>
                                <input type="text" class="form-control" value="<?php echo $data['nama_mahasiswa']; ?>"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="nim">Nim</label>
                                <input type="text" class="form-control" value="<?php echo $data['nim_mahasiswa']; ?>"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="angkatan">Angkatan</label>
                                <input type="text" class="form-control"
                                    value="<?php echo $data['angkatan_mahasiswa']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="name">Nama pembimbing</label>
                                <input type="text" class="form-control" value="<?php echo $data['nama_pembimbing']; ?>"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="nip">Nip pembimbing</label>
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
                                <p class="help-block">
                                    *Format berkas : NamaMahasiswa_NIM.pdf
                                    <br>*Ukuran gambar jangan lebih dari 10mb
                                </p>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="submit">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row (main row) -->
</section>