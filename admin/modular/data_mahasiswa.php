<?php
require '../koneksi.php';
?>
<?php
if (isset($_GET['hapus'])) {
    $nim = trim($_GET['hapus']);
    if (empty($nim)) {
        echo "<script>alert('Parameter NIM tidak valid!'); window.location.href='index.php?data_mahasiswa';</script>";
        exit;
    }

    mysqli_begin_transaction($conn);
    try {
        $getUserIdQuery = "SELECT mahasiswa_id FROM mahasiswa WHERE nim = ?";
        $stmtGetUserId = mysqli_prepare($conn, $getUserIdQuery);
        mysqli_stmt_bind_param($stmtGetUserId, 's', $nim);
        mysqli_stmt_execute($stmtGetUserId);
        $result = mysqli_stmt_get_result($stmtGetUserId);
        $user = mysqli_fetch_assoc($result);

        if (!$user) {
            throw new Exception("Data mahasiswa dengan NIM $nim tidak ditemukan.");
        }

        $userId = $user['mahasiswa_id'];

        // Hapus data mahasiswa
        $deleteMahasiswaQuery = "DELETE FROM mahasiswa WHERE nim = ?";
        $stmtMahasiswa = mysqli_prepare($conn, $deleteMahasiswaQuery);
        mysqli_stmt_bind_param($stmtMahasiswa, 's', $nim);
        if (!mysqli_stmt_execute($stmtMahasiswa)) {
            throw new Exception("Gagal menghapus data mahasiswa.");
        }

        // Hapus data user
        $deleteUserQuery = "DELETE FROM users WHERE id = ?";
        $stmtUser = mysqli_prepare($conn, $deleteUserQuery);
        mysqli_stmt_bind_param($stmtUser, 'i', $userId);
        if (!mysqli_stmt_execute($stmtUser)) {
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
                    window.location.href='index.php?data_mahasiswa';
                });
              </script>";
    } catch (Exception $e) {
        // Rollback jika terjadi error
        mysqli_rollback($conn);

        // Notifikasi error
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Gagal menghapus data: " . addslashes($e->getMessage()) . "'
                });
              </script>";
    } finally {
        // Tutup statement
        if (isset($stmtGetUserId)) mysqli_stmt_close($stmtGetUserId);
        if (isset($stmtMahasiswa)) mysqli_stmt_close($stmtMahasiswa);
        if (isset($stmtUser)) mysqli_stmt_close($stmtUser);
    }
}
?>

<section class="content-header">
    <h1> Data Mahasiswa </h1>
    <ol class="breadcrumb">
        <li><a href="index.php?dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Data Mahasiswa</li>
    </ol>
</section>

<section class="content">
    <div class="box box-info">
        <div class="box-header">
            <div class="row-fluid" style="overflow:auto">
                <div class="col-md-8">
                    <a href="index.php?add_mahasiswa" id="btn_create" class='btn btn-success'><span
                            class='glyphicon glyphicon-plus'></span> Tambah </a>

                    <!-- <a href="homepage.php?p=form_dbmahasiswa" id="btn_create" class='btn btn-primary'><span class='glyphicon glyphicon-upload'></span> Import Database </a> -->
                </div><br /><br /><br />

                <?php
                $sql = "SELECT * FROM mahasiswa";
                $result = mysqli_query($conn, $sql);
                $no_urut = 1;
                ?>

                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>NIM</th>
                            <th>Nama Lengkap</th>
                            <th>Jenis Kelamin</th>
                            <th>Program Studi</th>
                            <th>Fakultas</th>
                            <th>Angkatan</th>
                            <th>Alamat</th>
                            <th>No Hp</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($data = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td align="center"><?php echo $no_urut; ?>.</td>
                                <td><?php echo $data['nim']; ?></td>
                                <td><?php echo $data['nama']; ?></td>
                                <td>
                                    <?php
                                    if ($data["jenis_kelamin"] == "Laki-laki") {
                                        echo "Laki-laki";
                                    } else {
                                        echo "Perempuan";
                                    }
                                    ?>
                                </td>
                                <td><?php echo $data['jurusan']; ?></td>
                                <td><?php echo $data['fakultas']; ?></td>
                                <td><?php echo $data['angkatan']; ?></td>
                                <td><?php echo $data['alamat']; ?></td>
                                <td><?php echo $data['no_hp']; ?></td>
                                <td>
                                    <a href='index.php?edit_mahasiswa&ubah=<?php echo $data['nim']; ?>'>
                                        <button id='btn_create' class='btn btn-xs btn-primary' data-toggle='tooltip'
                                            data-container='body' title='Ubah'><span class='glyphicon glyphicon-pencil'
                                                aria-hidden='true'></span></button></a>

                                    <a
                                        onclick="confirmDelete(' <?= htmlspecialchars($data['nim']) ?>' )">
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
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(nim) {
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
                // Arahkan ke URL dengan parameter hapus
                window.location.href = `index.php?data_mahasiswa&hapus=${nim}`;
            }
        });
    }
</script>