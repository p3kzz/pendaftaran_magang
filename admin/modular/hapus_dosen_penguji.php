<?php 
require "../koneksi.php";

if (isset($_GET['hapus'])) {
    $nip = $_GET['hapus'];

    mysqli_begin_transaction($conn);
    try {
        $getUserIdQuery = "SELECT user_id FROM penguji WHERE nip = ?";
        $stmtGetUserId = mysqli_prepare($conn, $getUserIdQuery);
        mysqli_stmt_bind_param($stmtGetUserId, "s", $nip);
        mysqli_stmt_execute($stmtGetUserId);
        $result = mysqli_stmt_get_result($stmtGetUserId);
        $userId = mysqli_fetch_assoc($result)['user_id'];

        if (!$userId) {
            throw new Exception("Data penguji dengan NIP $nip tidak ditemukan.");
        }

        $deletePengujiQuery = "DELETE FROM penguji WHERE nip = ?";
        $stmtPenguji = mysqli_prepare($conn, $deletePengujiQuery);
        mysqli_stmt_bind_param($stmtPenguji, "s", $nip);
        $deletePenguji = mysqli_stmt_execute($stmtPenguji);
        if (!$deletePenguji) {
            throw new Exception("Gagal menghapus data penguji.");
        }
        $deleteUserQuery = "DELETE FROM users WHERE id = ?";
        $stmtUser = mysqli_prepare($conn, $deleteUserQuery);
        mysqli_stmt_bind_param($stmtUser, "i", $userId);
        $deleteUser = mysqli_stmt_execute($stmtUser);
        if (!$deleteUser) {
            throw new Exception("Gagal menghapus data user.");
        }

        // Commit transaksi
        mysqli_commit($conn);
        echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data berhasil dihapus!'
                    }).then(() => {
                        window.location.href='index.php?data_dosen_penguji';
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
        if (isset($stmtPenguji)) mysqli_stmt_close($stmtPenguji);
        if (isset($stmtUser)) mysqli_stmt_close($stmtUser);
    }
} else {
    echo "<script>alert('Parameter hapus tidak ditemukan!'); window.location.href='index.php?data_dosen_penguji';</script>";
    exit;
}
?>