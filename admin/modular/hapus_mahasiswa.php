<?php 
include "../koneksi.php";

if (isset($_GET['hapus'])) {
    $nim = $_GET['hapus'];

    mysqli_begin_transaction($conn);
    try {
        $getUserIdQuery = "SELECT mahasiswa_id FROM mahasiswa WHERE nim = ?";
        $stmtGetUserId = mysqli_prepare($conn, $getUserIdQuery);
        mysqli_stmt_bind_param($stmtGetUserId, 's', $nim);
        mysqli_stmt_execute($stmtGetUserId);
        $result = mysqli_stmt_get_result($stmtGetUserId);
        $userId = mysqli_fetch_assoc($result)['mahasiswa_id'];

        if (!$userId) {
            throw new Exception("Data mahasiswa dengan NIM $nim tidak ditemukan.");
        }

        $deleteMahasiswaQuery = "DELETE FROM mahasiswa WHERE nim = ?";
        $stmtMahasiswa = mysqli_prepare($conn, $deleteMahasiswaQuery);
        mysqli_stmt_bind_param($stmtMahasiswa, 's', $nim);
        $deleteMahasiswa = mysqli_stmt_execute($stmtMahasiswa);
        if (!$deleteMahasiswa) {
            throw new Exception("Gagal menghapus data mahasiswa.");
        }

        $deleteUserQuery = "DELETE FROM users WHERE id = ?";
        $stmtUser = mysqli_prepare($conn, $deleteUserQuery);
        mysqli_stmt_bind_param($stmtUser, 'i', $userId);
        $deleteUser = mysqli_stmt_execute($stmtUser);
        if (!$deleteUser) {
            throw new Exception("Gagal menghapus data pengguna.");
        }
        mysqli_commit($conn);
        echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data berhasil dihapus!'
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
                        text: 'Gagal menghapus data: " . $e->getMessage() . "'
                    });
                </script>";
    } finally {
        if (isset($stmtGetUserId)) mysqli_stmt_close($stmtGetUserId);
        if (isset($stmtMahasiswa)) mysqli_stmt_close($stmtMahasiswa);
        if (isset($stmtUser)) mysqli_stmt_close($stmtUser);
    }
} else {
    echo "<script>alert('Parameter hapus tidak ditemukan!'); window.location.href='index.php?data_mahasiswa';</script>";
    exit;
}
?>