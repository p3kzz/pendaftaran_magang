<?php 
require '../koneksi.php';

if (isset($_POST['TambahP'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = md5(trim($_POST['password']));
    $nip = trim($_POST['nip']);
    $fakultas = trim($_POST['fakultas']);

    if (!empty($name) && !empty($email) && !empty($password) && !empty($nip) && !empty($fakultas)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Format email tidak valid!'
                    });
                </script>";
            exit;
        }

        mysqli_begin_transaction($conn);
        try {
            $checkEmail = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
            if (mysqli_num_rows($checkEmail) > 0) {
                throw new Exception("Email sudah terdaftar");
            }

            $chekNip = mysqli_query($conn, "SELECT * FROM pembimbing WHERE nip='$nip'");
            if (mysqli_num_rows($chekNip) > 0) {
                throw new Exception("NIP sudah terdaftar");
            }

            $insertUser = mysqli_query($conn, "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', 'dosen_pembimbing')");
            if (!$insertUser) {
                throw new Exception("Gagal menambahkan data user: " . mysqli_error($conn));
            }

            $userId = mysqli_insert_id($conn);

            $insertPembimbing = mysqli_query($conn, "INSERT INTO pembimbing (pembimbing_id, nip, fakultas) VALUES ('$userId', '$nip', '$fakultas')");
            if (!$insertPembimbing) {
                throw new Exception("Gagal menambahkan data pembimbing: " . mysqli_error($conn));
            }

            mysqli_commit($conn);
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data berhasil disimpan!'
                    }).then(() => {
                        window.location.href='index.php?data_dosen_pembimbing';
                    });
                  </script>";
        } catch (Exception $e) {
            mysqli_rollback($conn);
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Gagal menyimpan data: " . $e->getMessage() . "'
                    });
                  </script>";
        }
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: 'Semua field wajib diisi!'
                });
              </script>";
        exit;
    }
}
?>


<section class="content-header">
    <h1> Tambah Dosen Pembimbing</h1>
    <ol class="breadcrumb">
        <li><a href="index.php?dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Tambah Dosen Pembimbing</li>
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
                    <form method="POST" enctype="multipart/form-data">
                        <div class="box-body">
                            <!-- form nama lengkap-->
                            <div class="form-group">
                                <label>Nama Dosen</label>
                                <input type="text" class="form-control" placeholder="masukkan nama" name="name"
                                    required>
                            </div>
                            <!-- form email-->
                            <div class="form-group">
                                <label>Email</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <input type="email" class="form-control" placeholder="masukkan email" name="email"
                                        required>
                                </div>
                            </div>
                            <!-- form password-->
                            <div class="form-group">
                                <label>password</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-key"></i>
                                    </div>
                                    <input type="password" class="form-control" placeholder="password" name="password"
                                        required>
                                </div>
                            </div>
                            <!-- form jabatan fungsional-->
                            <div class="form-group">
                                <label>Nip</label>
                                <input type="text" class="form-control" placeholder="masukkan nip" name="nip">
                            </div>
                            <!-- form jabatan struktural-->
                            <div class="form-group">
                                <label>Fakultas</label>
                                <input type="text" class="form-control" placeholder="masukkan fakultas" name="fakultas">
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" name="TambahP" class="btn btn-primary"><i class="fa fa-check"></i>
                                    simpan</button>
                                <a class="btn btn-primary" href="index.php?data_dosen_pembimbing"><i
                                        class="fa fa-mail-reply"></i> batal </a>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row (main row) -->
</section>