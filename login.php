<?php 
session_start();
require 'koneksi.php';

if (isset($_POST['Login'])) {
    $email = trim($_POST['email']);
    $password = md5($_POST['password']);
    
    // Validasi input tidak kosong
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        // Query untuk mengambil data pengguna berdasarkan email
        $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Verifikasi password
            if ($password == $row['password']) {
                // Simpan data user ke session
                $_SESSION['users'] = $row;
                $_SESSION['users'] = [
        'id' => $row['id'],
        'name' => $row['name'],
        'role' => $row['role']
    ];
                // Redirect berdasarkan role pengguna
                switch ($row['role']) {
                    case 'admin':
                        header("Location: admin/index.php");
                        break;
                    case 'dosen_pembimbing':
                        header("Location: admin/index.php");
                        break;
                    case 'dosen_penguji':
                        header("Location: admin/index.php");
                        break;
                    case 'mahasiswa':
                        header("Location: admin/index.php");
                        break;
                    default:
                        echo "<script>alert('Role tidak dikenali!')</script>";
                        break;
                }
                exit; 
            } else {
                echo "<script>alert('Password salah!'); window.location.href='index.php'</script>";
            }
        } else {
            $error = "Email atau password salah.";
        }
    } else {
        $error = "Email dan password tidak boleh kosong.";
    }
}
?>