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
<?php
include '../koneksi.php'; 

// Pastikan $_SESSION['users']['id'] sudah di-set
if (!isset($_SESSION['users']['id'])) {
    die("User tidak terdeteksi. Silakan login terlebih dahulu.");
}

$userID = $_SESSION['users']['id'];

$sqlData = "SELECT
    p.id AS penentuan_id,
    m.id AS mahasiswa_id,
    u.name AS nama_pembimbing,
    p.nip AS nip_pembimbing,
    u2.name AS nama_penguji,
    p2.nip AS nip_penguji,
    pb.pembimbing_id,
    j.id AS jadwal_id,
    j.tanggal_bimbingan,
    s.id AS mahasiswa_id,
    s.status
    FROM penentuan_pembimbing pb
    LEFT JOIN mahasiswa m ON pb.mahasiswa_id = m.id
    LEFT JOIN pembimbing p ON pb.pembimbing_id = p.id
    LEFT JOIN magang s ON pb.mahasiswa_id = m.id
    LEFT JOIN penguji p2 ON pb.penguji_id = p.id
    LEFT JOIN jadwal j ON j.mahasiswa_id = m.id
    LEFT JOIN users u On p.pembimbing_id = u.id
    LEFT JOIN users u2 On p.pembimbing_id = u.id
    LEFT JOIN users u1 ON m.mahasiswa_id = u1.id
    WHERE u.id = ?";

$queryData = $conn->prepare($sqlData);
$queryData->bind_param('i', $userID);
$queryData->execute();
$resultData = $queryData->get_result();

if ($resultData->num_rows> 0) {
    $data = $resultData->fetch_assoc();
} else {
    echo "<div class='alert alert-danger'>Data laporan tidak ditemukan.</div>";
    $Laporan = [];
}


?>