<?php 
require "../koneksi.php";

if (isset($_GET['hapus'])) {
    $nip = $_GET['hapus'];

    mysqli_begin_transaction($conn);
    try {
        $getUserIdQuery = "SELECT user_id FROM pembimbing WHERE nip = ?";
        $stmtGetUserId = mysqli_prepare($conn, $getUserIdQuery);
        mysqli_stmt_bind_param($stmtGetUserId, "s", $nip);
        mysqli_stmt_execute($stmtGetUserId);
        $result = mysqli_stmt_get_result($stmtGetUserId);
        $userId = mysqli_fetch_assoc($result)['user_id'];

        if (!$userId) {
            throw new Exception("Data pembimbing dengan NIP $nip tidak ditemukan.");
        }

        $deletePembimbingQuery = "DELETE FROM pembimbing WHERE nip = ?";
        $stmtPembimbing = mysqli_prepare($conn, $deletePembimbingQuery);
        mysqli_stmt_bind_param($stmtPembimbing, "s", $nip);
        $deletePembimbing = mysqli_stmt_execute($stmtPembimbing);
        if (!$deletePembimbing) {
            throw new Exception("Gagal menghapus data pembimbing.");
        }
        $deleteUserQuery = "DELETE FROM users WHERE id = ?";
        $stmtUser = mysqli_prepare($conn, $deleteUserQuery);
        mysqli_stmt_bind_param($stmtUser, "i", $userId); // Gunakan ID, bukan NIP
        $deleteUser = mysqli_stmt_execute($stmtUser);
        if (!$deleteUser) {
            throw new Exception("Gagal menghapus data user.");
        }
        mysqli_commit($conn);
        echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data berhasil dihapus!'
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
                        text: 'Gagal menghapus data: " . $e->getMessage() . "'
                    });
                  </script>";
    } finally {
        if (isset($stmtGetUserId)) mysqli_stmt_close($stmtGetUserId);
        if (isset($stmtPembimbing)) mysqli_stmt_close($stmtPembimbing);
        if (isset($stmtUser)) mysqli_stmt_close($stmtUser);
    }
} else {
    echo "<script>alert('Parameter hapus tidak ditemukan!'); window.location.href='index.php?data_dosen_pembimbing';</script>";
    exit;
}
?>