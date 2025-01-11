<?php
require 'koneksi.php'; 

if (isset($_POST['register'])) {
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
    if (!empty($name) && !empty($email) && !empty($password) && !empty($nim) && !empty($jurusan) && !empty($fakultas) && !empty($angkatan) && !empty($jenis_kelamin) && !empty($alamat)) {
        // Validasi format email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Format email tidak valid!');</script>";
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

            // Commit transaksi jika semua berhasil
            mysqli_commit($conn);
            echo "<script>alert('Registrasi berhasil!'); window.location.href='index.php';</script>";
        } catch (Exception $e) {
            // Rollback jika ada kesalahan
            mysqli_rollback($conn);
            echo "<script>alert('Registrasi gagal: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('Semua field wajib diisi!');</script>";
    }
}
?>