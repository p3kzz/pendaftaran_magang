<?php 
require '../koneksi.php';

if (isset($_GET['ubah'])) {
    $id = $_GET['ubah'];
    $query = mysqli_query($conn, "SELECT users.id as user_id, users.name, users.email, pembimbing.* 
                            FROM users 
                            INNER JOIN pembimbing ON users.id = pembimbing.pembimbing_id 
                            WHERE pembimbing.nip = '$id'");

    if ($query && mysqli_num_rows($query) > 0) {
        $pembimbing = mysqli_fetch_assoc($query);
    } else {
        echo "<script>alert('Data pembimbing tidak ditemukan!'); window.location.href='index.php?p=data_dosen_pembimbing';</script>";
        exit;
    }
} else {
    echo "<script>alert('Parameter ubah tidak ditemukan!'); window.location.href='index.php?p=data_dosen_pembimbing';</script>";
    exit;
}



if (isset($_POST['EditP'])) {
    $id =trim($_POST['id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = !empty($_POST['password']) ? md5($_POST['password']) : null;
    $nip = trim($_POST['nip']);
    $fakultas = trim($_POST['fakultas']);

    if (!empty($id) && !empty($name) && !empty($email) && !empty($nip) && !empty($fakultas)) {
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
            if ($email !== $pembimbing['email']) {
                $checkEmail = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND id != '$id'");
                if (mysqli_num_rows($checkEmail) > 0) {
                    throw new Exception("Email sudah digunakan oleh pengguna lain.");
                }
            }

            $updateUser = $password
                ? mysqli_query($conn, "UPDATE users SET name='$name', email='$email', password='$password' WHERE id='$id'")
                : mysqli_query($conn, "UPDATE users SET name='$name', email='$email' WHERE id='$id'");

            if (!$updateUser) {
                throw new Exception("Gagal update tabel users. ");
            }

            $updatePembimbing = mysqli_query($conn, "UPDATE pembimbing 
                                                    SET nip='$nip', fakultas='$fakultas' 
                                                    WHERE pembimbing_id='$id'");
            if (!$updatePembimbing) {
                throw new Exception("Gagal update tabel pembimbing. " );
            }

            mysqli_commit($conn);
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data berhasil diupdate!'
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
                        text: 'Gagal mengupdate data: " . $e->getMessage() . "'
                    });
                </script>";
        }
    } else {
        echo "<script>alert('Semua field wajib diisi!');";
    }
}


?>

<section class="content-header">
    <h1> Edit Dosen Pembimbing</h1>
    <ol class="breadcrumb">
        <li><a href="index.php?dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit Dosen Pembimbing</li>
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
                    <form method="POST">
                        <div class="box-body">
                            <input type="hidden" name="id" value="<?php echo $pembimbing['pembimbing_id']; ?>">
                            <!-- form nama lengkap-->
                            <div class="form-group">
                                <label>Nama Dosen</label>
                                <input type="text" class="form-control" placeholder="masukkan nama" name="name"
                                    value="<?php echo $pembimbing['name'];?>" required>
                            </div>
                            <!-- form email-->
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" placeholder="masukkan email" name="email"
                                    value="<?php echo $pembimbing['email'];?>" required>
                            </div>
                            <!-- form password-->
                            <div class="form-group">
                                <label>Password (Kosongkan jika tidak ingin diubah)</label>
                                <input type="password" class="form-control" name="password"
                                    placeholder="Masukkan Password">
                            </div>
                            <!-- form NIM-->
                            <div class="form-group">
                                <label>NIP</label>
                                <input type="text" class="form-control" placeholder="0601067503" name="nip"
                                    value="<?php echo $pembimbing['nip']?>" readonly>
                            </div>
                            <!-- form jabatan fungsional-->
                            <div class="form-group">
                                <label>Fakultas</label>
                                <input type="text" class="form-control" placeholder="masukkan fakultas" name="fakultas"
                                    value="<?php echo $pembimbing['fakultas'];?>">
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" name="EditP" class="btn btn-primary"><i class="fa fa-check"></i>
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