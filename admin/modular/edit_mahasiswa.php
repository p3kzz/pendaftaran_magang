<?php 
include '../koneksi.php'; 

if (isset($_GET['ubah'])) {
    $id = $_GET['ubah'];
    $query = mysqli_query($conn, "SELECT users.id as user_id, users.name, users.email, mahasiswa.* 
                            FROM users 
                            INNER JOIN mahasiswa ON users.id = mahasiswa.mahasiswa_id 
                            WHERE mahasiswa.nim = '$id'");

    if ($query && mysqli_num_rows($query) > 0) {
        $mahasiswa = mysqli_fetch_assoc($query);
    } else {
        echo "<script>alert('Data mahasiswa tidak ditemukan!'); window.location.href='index.php?p=data_mahasiswa';</script>";
        exit;
    }
} else {
    echo "<script>alert('Parameter ubah tidak ditemukan!'); window.location.href='index.php?p=data_mahasiswa';</script>";
    exit;
}



if (isset($_POST['EditM'])) {
    $id = trim($_POST['id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = !empty($_POST['password']) ? md5($_POST['password']) : null;
    $nim = trim($_POST['nim']);
    $jurusan = trim($_POST['jurusan']);
    $fakultas = trim($_POST['fakultas']);
    $angkatan = trim($_POST['angkatan']);
    $jenis_kelamin = trim($_POST['jenis_kelamin']);
    $alamat = trim($_POST['alamat']);
    $no_hp = trim($_POST['no_hp']);

    // Validasi
    if (!empty($id) && !empty($name) && !empty($email) && !empty($nim) && !empty($jurusan) && !empty($fakultas) && !empty($angkatan) && !empty($jenis_kelamin) && !empty($alamat) && !empty($no_hp)) {
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
            $checkEmail = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND id != '$id'");
            if (mysqli_num_rows($checkEmail) > 0) {
                throw new Exception("Email sudah digunakan oleh pengguna lain.");
            }
            if ($password) {
                $updateUser = mysqli_query($conn, "UPDATE users SET name='$name', email='$email', password='$password' WHERE id='$id'");
            } else {
                $updateUser = mysqli_query($conn, "UPDATE users SET name='$name', email='$email' WHERE id='$id'");
            }

            if (!$updateUser) {
                throw new Exception("Gagal memperbarui data pengguna.");
            }
            $updateMahasiswa = mysqli_query($conn, "UPDATE mahasiswa SET nim='$nim', nama='$name', jurusan='$jurusan', fakultas='$fakultas', angkatan='$angkatan', jenis_kelamin='$jenis_kelamin', alamat='$alamat', no_hp='$no_hp' WHERE mahasiswa_id='$id'");
            if (!$updateMahasiswa) {
                throw new Exception("Gagal memperbarui data mahasiswa.");
            }

            mysqli_commit($conn);
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data berhasil diupdate!'
                    }).then(() => {
                        window.location.href='index.php?data_mahasiswa';
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
        echo "<script>alert('Semua field wajib diisi!');</script>";
    }
    }
?>

<section class="content-header">
    <h1>Edit Mahasiswa</h1>
    <ol class="breadcrumb">
        <li class="active">Edit Mahasiswa</li>
    </ol>
</section>

<section class="content">
    <div class="box box-info">
        <div class="box-header">
            <div class="col-md-8">
                <form method="POST">
                    <div class="box-body">
                        <input type="hidden" name="id" value="<?php echo $mahasiswa['mahasiswa_id']; ?>">

                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control" name="name" placeholder="Masukkan Nama Lengkap"
                                value="<?php echo $mahasiswa['nama']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Masukkan Email"
                                value="<?php echo $mahasiswa['email']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Password (Kosongkan jika tidak ingin diubah)</label>
                            <input type="password" class="form-control" name="password" placeholder="Masukkan Password">
                        </div>
                        <div class="form-group">
                            <label>NIM</label>
                            <input type="text" class="form-control" name="nim" placeholder="Masukkan NIM"
                                value="<?php echo $mahasiswa['nim']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <div class="radio">
                                <label><input type="radio" name="jenis_kelamin" value="Laki-laki"
                                        <?php echo ($mahasiswa['jenis_kelamin'] == 'Laki-laki') ? 'checked' : ''; ?>
                                        required>
                                    Laki-laki</label>
                                <label><input type="radio" name="jenis_kelamin" value="Perempuan"
                                        <?php echo ($mahasiswa['jenis_kelamin'] == 'Perempuan') ? 'checked' : ''; ?>
                                        required>
                                    Perempuan</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Program Studi</label>
                            <input type="text" class="form-control" name="jurusan" placeholder="Masukkan Program Studi"
                                value="<?php echo $mahasiswa['jurusan']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Fakultas</label>
                            <input type="text" class="form-control" name="fakultas" placeholder="Masukkan Fakultas"
                                value="<?php echo $mahasiswa['fakultas']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Angkatan</label>
                            <input type="text" class="form-control" name="angkatan" placeholder="Masukkan Angkatan"
                                value="<?php echo $mahasiswa['angkatan']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" name="alamat" placeholder="Masukkan Alamat"
                                required><?php echo $mahasiswa['alamat']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>No HP</label>
                            <input type="text" class="form-control" name="no_hp" placeholder="Masukkan No HP"
                                value="<?php echo $mahasiswa['no_hp']; ?>" required>
                        </div>

                        <div class="box-footer">
                            <button type="submit" name="EditM" class="btn btn-primary"><i class="fa fa-check"></i>
                                simpan</button>
                            <a class="btn btn-primary" href="index.php?data_mahasiswa"><i class="fa fa-mail-reply"></i>
                                batal </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>