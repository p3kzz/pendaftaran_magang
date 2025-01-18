<?php
require '../koneksi.php';

$userId = $_SESSION['users']['id'];

$sqlCekMahasiswa = "SELECT id FROM penentuan_pembimbing WHERE mahasiswa_id = ?";
$cekMahasiswaStmt = $conn->prepare($sqlCekMahasiswa);
$cekMahasiswaStmt->bind_param("i", $userId);
$cekMahasiswaStmt->execute();
$resultCekMahasiswa = $cekMahasiswaStmt->get_result();
$sudahDaftar = $resultCekMahasiswa->num_rows > 0;

$sqlData = "SELECT 
    p.id AS penentuan_id,
    m.id AS mahasiswa_id,
    m.nama AS nama_mahasiswa,
    m.nim AS nim_mahasiswa,
    m.angkatan AS angkatan_mahasiswa,
    u2.name AS nama_penguji,
    pb.nip AS nip_penguji,
    p.penguji_id,
    p.created_at,
    lb.status AS laporan_status
FROM penentuan_pembimbing p
LEFT JOIN mahasiswa m ON p.mahasiswa_id = m.id 
LEFT JOIN penguji pb ON p.penguji_id = pb.id
LEFT JOIN users u2 ON pb.penguji_id = u2.id 
LEFT JOIN users u1 ON m.mahasiswa_id = u1.id 
LEFT JOIN laporan_bimbingan lb ON lb.mahasiswa_id = m.id
WHERE u1.id = ?";

$queryData = $conn->prepare($sqlData);
$queryData->bind_param("i", $userId);
$queryData->execute();
$resultLaporan = $queryData->get_result();

if ($resultLaporan->num_rows === 0) {
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
// $laporan = $resultLaporan->fetch_assoc();

// if ($laporan['laporan_status'] !== 'acc') {
//     echo "<script>
//     document.addEventListener('DOMContentLoaded', function() {
//         Swal.fire({
//             icon: 'error',
//             title: 'Akses Ditolak',
//             text: 'Laporan Bimbingan Anda belum disetujui oleh Dosen Pembimbing.'
//         }).then((result) => {
//             if (result.isConfirmed) {
//                 window.location.href = 'index.php?dashboard'; 
//             }
//         });
//     });
//     </script>";
//     exit;
// }

if (isset($_POST['upload'])) {
    $judul_laporan = $_POST['judul_laporan'];
    $file_laporan = $_FILES['file_laporan']['name'];
    $file_tmp = $_FILES['file_laporan']['tmp_name'];
    $file_error = $_FILES['file_laporan']['error'];
    $file_size = $_FILES['file_laporan']['size'];
    $file_type = $_FILES['file_laporan']['type'];
    $target_dir = "../dist/file/";
    $target_file = $target_dir . basename($file_laporan);
    if ($file_type !== 'application/pdf') {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Tipe File Tidak Valid',
                    text: 'File yang diupload harus berformat PDF.'
                });
            });
        </script>";
    } elseif ($file_error !== UPLOAD_ERR_OK) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Upload Gagal',
                    text: 'Terjadi kesalahan saat mengupload file.'
                });
            });
        </script>";
    } elseif ($file_size > 10485760) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'File Terlalu Besar',
                    text: 'Ukuran file tidak boleh lebih dari 10MB.'
                });
            });
        </script>";
    } else {
        if (move_uploaded_file($file_tmp, $target_file)) {
            $sqlInsert = "INSERT INTO upload_laporan (judul_laporan, file_laporan, mahasiswa_id, penguji_id) VALUES (?, ?, ?, ?)";
            $stmtInsert = $conn->prepare($sqlInsert);
            $stmtInsert->bind_param("ssii", $judul_laporan, $file_laporan, $laporan['mahasiswa_id'], $laporan['penguji_id']);
            if ($stmtInsert->execute()) {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Laporan berhasil diupload.'
                        });
                    });
                </script>";
            } else {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Gagal menyimpan laporan ke database.'
                        });
                    });
                </script>";
            }
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal memindahkan file ke folder tujuan.'
                    });
                });
            </script>";
        }
    }
}
?>





<section class="content-header">
    <h1> Laporan Magang </h1>
    <ol class="breadcrumb">
        <li><a href="homepage.php?dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Laporan Magang</li>
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
                                <label for="judul_laporan">Judul Laporan</label>
                                <input type="text" class="form-control" name="judul_laporan"
                                    placeholder="masukkan Judul Laporan" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Berkas Laporan</label>
                                <input type="file" id="exampleInputFile" name="file_laporan" accept=".pdf" required>
                                <p class="help-block">
                                    *Format berkas : NamaMahasiswa_NIM.pdf
                                    <br>*Ukuran gambar jangan lebih dari 10mb
                                </p>
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama Lengkap</label>
                                <input type="text" class="form-control"
                                    value="<?php echo $laporan['nama_mahasiswa']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="nim">Nim</label>
                                <input type="text" class="form-control" value="<?php echo $laporan['nim_mahasiswa']; ?>"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="angkatan">Angkatan</label>
                                <input type="text" class="form-control"
                                    value="<?php echo $laporan['angkatan_mahasiswa']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="name">Nama penguji</label>
                                <input type="text" class="form-control" value="<?php echo $laporan['nama_penguji']; ?>"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="nip">Nip penguji</label>
                                <input type="text" class="form-control" value="<?php echo $laporan['nip_penguji']; ?>"
                                    readonly>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="upload">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row (main row) -->
</section>