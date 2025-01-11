<?php 
require '../koneksi.php';

$sqlMagang = "SELECT m.id AS mahasiswa_id, m.nim, m.nama, mg.id AS magang_id, mg.lokasi_magang
                FROM magang mg
                JOIN mahasiswa m ON mg.mahasiswa_id = m.id
                WHERE mg.status = 'diterima'
                ORDER BY mg.created_at DESC";
$resultMagang = mysqli_query($conn, $sqlMagang);

$magangData = [];
while ($row = mysqli_fetch_assoc($resultMagang)) {
    $magangData[] = $row;
}

$sqlPembimbing = "SELECT pembimbing.*, users.name 
                FROM pembimbing 
                INNER JOIN users ON pembimbing.pembimbing_id = users.id 
                ORDER BY pembimbing.pembimbing_id ASC";
$resultPembimbing = mysqli_query($conn, $sqlPembimbing);

$sqlPenguji = "SELECT penguji.*, users.name 
                FROM penguji 
                INNER JOIN users ON penguji.penguji_id = users.id 
                ORDER BY penguji.penguji_id ASC";
$result = mysqli_query($conn, $sqlPenguji);

if (isset($_POST['submit'])) {
    $keterangan = trim($_POST['keterangan']);
    $tanggal = trim($_POST['tanggal']);
    $tanggal_bimbingan = trim($_POST['tanggal_bimbingan']);
    $magang_id = trim($_POST['magang_id']);
    $mahasiswa_id = trim($_POST['mahasiswa_id']);
    $pembimbing_id = trim($_POST['pembimbing_id']);
    $penguji_id = trim($_POST['penguji_id']);

    if (!empty($keterangan) && !empty($tanggal) && !empty($tanggal_bimbingan) && !empty($magang_id) && !empty($mahasiswa_id) && !empty($pembimbing_id) && !empty($penguji_id)) {
        mysqli_begin_transaction($conn);

        try {
            $insertPembimbingP = mysqli_query($conn, "INSERT INTO penentuan_pembimbing (mahasiswa_id, pembimbing_id, penguji_id) VALUES ('$mahasiswa_id', '$pembimbing_id', '$penguji_id')");
            if (!$insertPembimbingP) {
                throw new Exception("Gagal menambahkan data pembimbing: " . mysqli_error($conn));
            }

            $insertJadwal = mysqli_query($conn, "INSERT INTO jadwal (keterangan, tanggal, tanggal_bimbingan, magang_id, mahasiswa_id, pembimbing_id, penguji_id) VALUES ('$keterangan', '$tanggal','$tanggal_bimbingan', '$magang_id', '$mahasiswa_id', '$pembimbing_id', '$penguji_id')");
            if (!$insertJadwal) {
                throw new Exception("Gagal menambahkan data jadwal: " . mysqli_error($conn));
            }

            mysqli_commit($conn);

            // SweetAlert jika berhasil
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data jadwal berhasil disimpan!'
                    }).then(() => {
                        window.location.href = 'index.php?data_jadwal';
                    });
                </script>";
            exit;
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
    <h1> Kelola Jadwal & Dosen Penguji dan Pembimbing</h1>
    <ol class="breadcrumb">
        <li><a href="homepage.php?dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Bimbingan Kerja Praktek</li>
    </ol>
</section>

<section class="content">
    <div class="box box-info">
        <div class="box-header">
            <div class="row-fluid">
                <div class="col-md-8">
                    <form role="form" method="POST">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Keterangan</label>
                                <input type="text" class="form-control" name="keterangan"
                                    placeholder="Masukkan keterangan" required>
                            </div>
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" required>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Bimbingan</label>
                                <input type="date" class="form-control" name="tanggal_bimbingan" required>
                            </div>
                            <div class="form-group">
                                <label>Magang</label>
                                <select class="form-control" name="magang_id" required>
                                    <option value="">Pilih Magang</option>
                                    <?php foreach ($magangData as $row) { ?>
                                    <option value="<?php echo $row['magang_id']; ?>">
                                        <?php echo $row['lokasi_magang']; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Mahasiswa</label>
                                <select class="form-control" name="mahasiswa_id" required>
                                    <option value="">Pilih Mahasiswa</option>
                                    <?php foreach ($magangData as $row) { ?>
                                    <option value="<?php echo $row['mahasiswa_id']; ?>">
                                        <?php echo $row['nama']; ?> (<?php echo $row['nim']; ?>)
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Pembimbing</label>
                                <select class="form-control" name="pembimbing_id" required>
                                    <option value="">Pilih Pembimbing</option>
                                    <?php while ($row = mysqli_fetch_assoc($resultPembimbing)) { ?>
                                    <option value="<?php echo $row['id']; ?>">
                                        <?php echo $row['name']; ?> (<?php echo $row['nip']; ?>)
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Penguji</label>
                                <select class="form-control" name="penguji_id" required>
                                    <option value="">Pilih Penguji</option>
                                    <?php while ($data = mysqli_fetch_assoc($result)) { ?>
                                    <option value="<?php echo $data['id']; ?>">
                                        <?php echo $data['name']; ?> (<?php echo $data['nip']; ?>)
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="submit"><i class="fa fa-check"></i>
                                Simpan</button>
                            <a class="btn btn-primary" href="index.php?data_jadwal"><i class="fa fa-mail-reply"></i>
                                Batal </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>