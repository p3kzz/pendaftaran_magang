<?php
require '../../koneksi.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Uniba Madura .: Dasboard :.</title>
    <link rel="icon" href="../../dist/img/uniba.png">
    <!-- Theme style -->
    <link rel="shortcut icon" href="../../dist/img/uniba.png">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="../../bower_components/morris.js/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="../../bower_components/jvectormap/jquery-jvectormap.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="../../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../../bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="../../plugins/pace/pace.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../bower_components/bootstrap-fileupload/bootstrap-fileupload.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">



    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<script>
function NewWindow(mypage, myname, w, h, scroll) {
    LeftPosition = (screen.width) ? (screen.width - w) / 2 : 0;
    TopPosition = (screen.height) ? 0 : 0;
    settings = 'height=' + h + ',width=' + w + ',top=' + TopPosition + ',left=' + LeftPosition + ',scrollbars=' +
        scroll + ',resizable'
    win = window.open(mypage, myname, settings)
    if (win.window.focus) {
        win.window.focus();
    }
}
</script>

<section>
    <img src=" ../../dist/img/uniba.png" alt="logo uniba" style="height: 100px; margin-top:20px; margin-left: 45%;">
    <h3 align=" center">UNIVERSITAS BAHAUDIN MUDHARY</h3>
    <h3 align="center"> Laporan jadwal sidang</h3>
</section>

<section class="content">
    <div class="box box-info">
        <div class="box-header">
            <div class="row-fluid" style="overflow:auto">
                <br />

                <?php
                $sql =  "SELECT   
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
                ORDER BY l.id ASC";
                $result = mysqli_query($conn,  $sql);
                $no_urut = 1;
                ?>
                <table id=" myTable" class="table table-striped table-bordered table-hover">
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
                        while ($data = mysqli_fetch_array($result)) {
                        ?>
                        <tr>
                            <td align="center"><?php echo $no_urut; ?>.</td>
                            <td><?php echo $data['nama_mahasiswa']; ?></td>
                            <td><?php echo $data['nim_mahasiswa']; ?></td>
                            <td><?php echo $data['angkatan_mahasiswa']; ?></td>
                            <td><?php echo $data['judul_laporan']; ?></td>
                            <td><?php echo $data['nilai_laporan']; ?></td>
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