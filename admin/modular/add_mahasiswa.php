<?php 
require '../koneksi.php'; 

if (isset($_POST['TambahM'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = md5($_POST['password']);
    $nim = trim($_POST['nim']);
    $jurusan = trim($_POST['jurusan']);
    $fakultas = trim($_POST['fakultas']);
    $angkatan = trim($_POST['angkatan']);
    $jenis_kelamin = trim($_POST['jenis_kelamin']);
    $alamat = trim($_POST['alamat']);
    $no_hp = trim($_POST['no_hp']);

    // Validasi 
    if (!empty($name) && !empty($email) && !empty($password) && !empty($nim) && !empty($jurusan) && !empty($fakultas) && !empty($angkatan) && !empty($jenis_kelamin) && !empty($alamat) && !empty($no_hp)) {
        // Validasi email
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
                throw new Exception("Email sudah digunakan.");
            }
            $checkNim = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim='$nim'");
            if (mysqli_num_rows($checkNim) > 0) {
                throw new Exception("NIM sudah digunakan.");
            }
            $insertUser = mysqli_query($conn, "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', 'mahasiswa')");
            if (!$insertUser) {
                throw new Exception("Gagal menyimpan data user.");
            }
            
            $userId = mysqli_insert_id($conn);

            $insertMahasiswa = mysqli_query($conn, "INSERT INTO mahasiswa (mahasiswa_id, nim, nama, jurusan, fakultas, angkatan, jenis_kelamin, alamat, no_hp) 
                VALUES ('$userId', '$nim', '$name', '$jurusan', '$fakultas', '$angkatan', '$jenis_kelamin', '$alamat', '$no_hp')");
            if (!$insertMahasiswa) {
                throw new Exception("Gagal menyimpan data mahasiswa.");
            }

            mysqli_commit($conn);
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data berhasil disimpan!'
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
        echo "<script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: 'Semua field wajib diisi!'
                });
              </script>";
    }
}
?>

<section class="content-header">
    <h1>Tambah Mahasiswa</h1>
    <ol class="breadcrumb">
        <li class="active">Tambah Mahasiswa</li>
    </ol>
</section>

<section class="content">
    <div class="box box-info">
        <div class="box-header">
            <div class="col-md-8">
                <form method="POST">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control" name="name" placeholder="Masukkan Nama Lengkap"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Masukkan Email" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Masukkan Password"
                                required>
                        </div>
                        <div class="form-group">
                            <label>NIM</label>
                            <input type="text" class="form-control" name="nim" placeholder="Masukkan NIM" required>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <div class="radio">
                                <label><input type="radio" name="jenis_kelamin" value="Laki-laki" required>
                                    Laki-laki</label>
                                <label><input type="radio" name="jenis_kelamin" value="Perempuan" required>
                                    Perempuan</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Program Studi</label>
                            <input type="text" class="form-control" name="jurusan" placeholder="Masukkan Program Studi"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Fakultas</label>
                            <input type="text" class="form-control" name="fakultas" placeholder="Masukkan Fakultas"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Angkatan</label>
                            <input type="text" class="form-control" name="angkatan" placeholder="Masukkan Angkatan"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" name="alamat" placeholder="Masukkan Alamat"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label>No HP</label>
                            <input type="text" class="form-control" name="no_hp" placeholder="Masukkan No HP" required>
                        </div>

                        <div class="box-footer">
                            <button type="submit" name="TambahM" class="btn btn-primary">Simpan</button>
                            <a href="index.php?data_mahasiswa" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>