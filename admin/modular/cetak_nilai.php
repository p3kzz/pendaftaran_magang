<?php
require '../koneksi.php';

$userId = $_SESSION['users']['id'];

// Query Data Laporan
$sqlData = "SELECT 
    l.nilai_laporan,
    l.laporan_id,
    l.mahasiswa_id, 
    l.penguji_id, 
    up.judul_laporan AS judul_laporan,
    m.nama AS nama_mahasiswa,
    m.nim AS nim_mahasiswa, 
    m.angkatan AS angkatan_mahasiswa
FROM penilaian l
LEFT JOIN upload_laporan up ON l.laporan_id = up.id 
LEFT JOIN mahasiswa m ON l.mahasiswa_id = m.id 
LEFT JOIN penguji pb ON l.penguji_id = pb.id
LEFT JOIN users u1 ON pb.penguji_id = u1.id
WHERE u1.id = ?";

$queryDataL = $conn->prepare($sqlData);
$queryDataL->bind_param("i", $userId);
$queryDataL->execute();
$result = $queryDataL->get_result();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan yang Sudah Dinilai</title>
    <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
    <script>
    function NewWindow(mypage, myname, w, h, scroll) {
        LeftPosition = (screen.width) ? (screen.width - w) / 2 : 0;
        TopPosition = (screen.height) ? 0 : 0;
        settings = 'height=' + h + ',width=' + w + ',top=' + TopPosition + ',left=' + LeftPosition +
            ',scrollbars=' + scroll + ',resizable';
        win = window.open(mypage, myname, settings);
        if (win.window.focus) {
            win.window.focus();
        }
    }
    </script>
</head>

<body>
    <section class="content-header">
        <h1>Laporan yang Sudah Dinilai</h1>
        <ol class="breadcrumb">
            <li><a href="index.php?dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="index.php?data_laporan_magang">Data Laporan</a></li>
            <li class="active">Laporan yang Sudah Dinilai</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <div class="col-md-8">
                    <!-- Tombol Cetak -->
                    <a onclick="frames['frame'].print();" id="btn_create" class='btn btn-success'>
                        <span class='glyphicon glyphicon-print'></span> Cetak
                    </a>
                    <!-- Iframe untuk mencetak laporan -->
                    <iframe src="modular/cetak_nilai_mhs.php" name="frame" style="display:none;"></iframe><br>
                </div><br />
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>NIM</th>
                            <th>Angkatan</th>
                            <th>Judul Laporan</th>
                            <th>Nilai Laporan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            $no = 1;
                            while ($laporan = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>" . $no++ . "</td>
                                    <td>" . htmlspecialchars($laporan['nama_mahasiswa']) . "</td>
                                    <td>" . htmlspecialchars($laporan['nim_mahasiswa']) . "</td>
                                    <td>" . htmlspecialchars($laporan['angkatan_mahasiswa']) . "</td>
                                    <td>" . htmlspecialchars($laporan['judul_laporan']) . "</td>
                                    <td>" . htmlspecialchars($laporan['nilai_laporan']) . "</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>Tidak ada laporan yang sudah dinilai.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>

</html>