<?php include '../koneksi.php';
?>
<?php
if (isset($_GET['hapus'])) {
    $nip = trim($_GET['hapus']);
    if (empty($nip)) {
        echo "<script>alert('Parameter nip tidak valid!'); window.location.href='index.php?data_dosen_penguji';</script>";
        exit;
    }
    mysqli_begin_transaction($conn);
    try {
        $getUserIdQuery = "SELECT penguji_id FROM penguji WHERE nip = ?";
        $stmtGetUserId = mysqli_prepare($conn, $getUserIdQuery);
        mysqli_stmt_bind_param($stmtGetUserId, "s", $nip);
        mysqli_stmt_execute($stmtGetUserId);
        $result = mysqli_stmt_get_result($stmtGetUserId);
        $user = mysqli_fetch_assoc($result);

        if (!$user) {
            throw new Exception("Data penguji dengan NIP $nip tidak ditemukan.");
        }
        $userId = $user['penguji_id'];
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
}
?>

<section class="content-header">
    <h1> Data Dosen Penguji</h1>
    <ol class="breadcrumb">
        <li><a href="index.php?p=dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Data Dosen Penguji</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- quick email widget -->
    <div class="box box-info">
        <div class="box-header">
            <div class="row-fluid" style="overflow:auto">
                <div class="col-md-8">
                    <a href="index.php?add_dosen_penguji" id="btn_create" class='btn btn-success'><span
                            class='glyphicon glyphicon-plus'></span> Tambah </a>
                </div> <br /><br /><br />

                <?php
                $sql =  "SELECT penguji.*, users.name 
                            FROM penguji 
                            INNER JOIN users ON penguji.penguji_id = users.id 
                            ORDER BY penguji.penguji_id ASC";
                $result = mysqli_query($conn, $sql);
                $no_urut = 1;
                ?>

                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Dosen</th>
                            <th>NIP</th>
                            <th>Fakultas</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($data = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td align="center"><?php echo $no_urut; ?>.</td>
                                <td><?php echo $data['name']; ?></td>
                                <td><?php echo $data['nip']; ?></td>
                                <td><?php echo $data['fakultas']; ?></td>
                                <td>
                                    <a href='index.php?edit_dosen_penguji&ubah=<?php echo $data['nip'] ?>'>
                                        <button id='btn_create' class='btn btn-xs btn-primary' data-toggle='tooltip'
                                            data-container='body' title='Ubah'><span class='glyphicon glyphicon-pencil'
                                                aria-hidden='true'></span></button></a>

                                    <a
                                        onclick="confirmDelete(' <?= htmlspecialchars($data['nip']) ?>' )">
                                        <button id='btn_create' class='btn btn-xs btn-danger' data-toggle='tooltip'
                                            data-container='body' title='Hapus'><span class='glyphicon glyphicon-trash'
                                                aria-hidden='true'></span></button></a>
                                </td>
                            </tr>
                        <?php
                            $no_urut++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.row (main row) -->
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(nip) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Arahkan ke hapus
                window.location.href = `index.php?data_dosen_penguji&hapus=${nip}`;
            }
        });
    }
</script>