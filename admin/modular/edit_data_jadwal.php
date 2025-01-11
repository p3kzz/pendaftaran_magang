<?php 
require '../koneksi.php';

if (isset($_GET['ubah'])) {
    $id = $_GET['ubah'];
    $query = mysqli_query($conn, "SELECT * FROM jadwal WHERE id = '$id'");

    if ($query && mysqli_num_rows($query) > 0) {
        $jadwal = mysqli_fetch_assoc($query);
    } else {
        echo "<script>alert('Data jadwal tidak ditemukan!'); window.location.href='index.php?data_jadwal';</script>";
        exit;
    }
} else {
    echo "<script>alert('Parameter ubah tidak ditemukan!'); window.location.href='index.php?data_jadwal';</script>";
    exit;
}

if (isset($_POST['EditJadwal'])) {
    $keterangan = trim($_POST['keterangan']);
    $tanggal = trim($_POST['tanggal']);
    $magang_id = trim($_POST['magang_id']);
    $mahasiswa_id = trim($_POST['mahasiswa_id']);
    $pembimbing_id = trim($_POST['pembimbing_id']);
    $penguji_id = trim($_POST['penguji_id']);

    if (!empty($keterangan) && !empty($tanggal) && !empty($magang_id) && !empty($mahasiswa_id) && !empty($pembimbing_id) && !empty($penguji_id)) {
        mysqli_begin_transaction($conn);
        try {
            $updateJadwal = mysqli_query($conn, "UPDATE jadwal SET 
                keterangan='$keterangan', 
                tanggal='$tanggal', 
                magang_id='$magang_id', 
                mahasiswa_id='$mahasiswa_id', 
                pembimbing_id='$pembimbing_id', 
                penguji_id='$penguji_id' 
                WHERE id='$id'");

            if (!$updateJadwal) {
                throw new Exception("Gagal update data jadwal: " . mysqli_error($conn));
            }

            mysqli_commit($conn);
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data jadwal berhasil diupdate!'
                    }).then(() => {
                        window.location.href='index.php?data_jadwal';
                    });
                </script>";
        } catch (Exception $e) {
            mysqli_rollback($conn);
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Gagal mengupdate data: " . $e->getMessage() . "'
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
$resultPenguji = mysqli_query($conn, $sqlPenguji);
?>

<section class="content-header">
    <h1> Edit Data Jadwal</h1>
    <ol class="breadcrumb">
        <li><a href="index.php?dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit Jadwal</li>
    </ol>
</section>

<section class="content">
    <div class="box box-info">
        <div class="box-header">
            <div class="row-fluid">
                <div class="col-md-8">
                    <form method="POST">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Keterangan</label>
                                <input type="text" class="form-control" name="keterangan" value="<?php echo $jadwal['keterangan']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" value="<?php echo $jadwal['tanggal']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Magang</label>
                                <select class="form-control" name="magang_id" required>
                                    <option value="">Pilih Magang</option>
                                    <?php foreach ($magangData as $row) { ?>
                                    <option value="<?php echo $row['magang_id']; ?>" <?php echo $row['magang_id'] == $jadwal['magang_id'] ? 'selected' : ''; ?>>
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
                                    <option value="<?php echo $row['mahasiswa_id']; ?>" <?php echo $row['mahasiswa_id'] == $jadwal['mahasiswa_id'] ? 'selected' : ''; ?>>
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
                                    <option value="<?php echo $row['id']; ?>" <?php echo $row['id'] == $jadwal['pembimbing_id'] ? 'selected' : ''; ?>>
                                        <?php echo $row['name']; ?> (<?php echo $row['nip']; ?>)
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Penguji</label>
                                <select class="form-control" name="penguji_id" required>
                                    <option value="">Pilih Penguji</option>
                                    <?php while ($data = mysqli_fetch_assoc($resultPenguji)) { ?>
                                    <option value="<?php echo $data['id']; ?>" <?php echo $data['id'] == $jadwal['penguji_id'] ? 'selected' : ''; ?>>
                                        <?php echo $data['name']; ?> (<?php echo $data['nip']; ?>)
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="EditJadwal"><i class="fa fa-check"></i> Simpan</button>
                            <a class="btn btn-primary" href="index.php?data_jadwal"><i class="fa fa-mail-reply"></i> Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
