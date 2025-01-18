<?php 
require '../koneksi.php';
if (isset($_POST['upload'])) {
    $judul_magang = $_POST['judul_magang'];
    $tanggal = $_POST['tanggal'];
    $file = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_error = $_FILES['file']['error'];
    $file_type = $_FILES['file']['type'];
    $target_dir = "../dist/info_magang/";
    $target_file = $target_dir . basename($file);

    if ($file_type !== 'application/pdf') {
        echo "<div class='alert alert-danger'>File yang diupload harus berformat PDF.</div>";
    } elseif ($file_error !== UPLOAD_ERR_OK) {
        echo "<div class='alert alert-danger'>Terjadi kesalahan saat mengupload file.</div>";
    } else {
        if (move_uploaded_file($file_tmp, $target_file)) {
            $sql = "INSERT INTO info_magang ( judul_magang, tanggal, file) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $judul_magang, $tanggal, $file);
            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Laporan magang berhasil diunggah.</div>";
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
    <h1> Profile Magang </h1>
    <ol class="breadcrumb">
        <li><a href="homepage.php?dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Profile Magang</li>
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
                                <label for="judul_magang">Judul Magang</label>
                                <input type="text" name="judul_magang" class="form-control"
                                    placeholder="Masukkan judul magang" required>
                            </div>
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Berkas Laporan</label>
                                <input type="file" id="exampleInputFile" name="file" accept=".pdf" required>
                                <p class="help-block">
                                    *Format berkas :.pdf
                                    <br>*Ukuran gambar jangan lebih dari 10mb
                                </p>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="upload">Kirim
                                
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row (main row) -->
</section>