<?php include '../koneksi.php'; ?>

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

<section class="content-header">
    <h1> Cetak Laporan Distribusi </h1>
    <ol class="breadcrumb">
        <li><a href="homepage.php?p=dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Cetak Laporan Distribusi</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- quick email widget -->
    <div class="box box-info">
        <div class="box-header">
            <div class="row-fluid" style="overflow:auto">
                <div class="col-md-8">
                    <a onclick="frames['frame'].print();" id="btn_create" class='btn btn-success'><span
                            class='glyphicon glyphicon-print'></span> cetak </a>
                    <iframe src="modular/print_jadwal_sidang.php" name="frame" style="display:none"> </iframe><br>
                </div><br /><br /><br />

                <?php
                $sql =  "SELECT   
                    j.id,
                    j.tanggal, 
                    j.tanggal_bimbingan, 
                    m.nama AS nama_mahasiswa,
                    m.nim AS nim_mahasiswa,
                    u2.name AS nama_penguji,
                    g.nip AS nip_penguji
                FROM jadwal j
                LEFT JOIN mahasiswa m ON j.mahasiswa_id = m.id
                LEFT JOIN pembimbing p ON j.pembimbing_id = p.id
                LEFT JOIN users u1 ON p.pembimbing_id = u1.id
                LEFT JOIN penguji g ON j.penguji_id = g.id
                LEFT JOIN users u2 ON g.penguji_id = u2.id
                ORDER BY j.id ASC";
                $result = mysqli_query($conn,  $sql);
                $no_urut = 1;
                ?>

                <table id=" myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama mahasiswa</th>
                            <th>NIM</th>
                            <th>tanggal sidang</th>
                            <th>Dosen Penguji</th>
                            <th>NIP Penguji</th>

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
                            <td><?php echo $data['tanggal']; ?></td>
                            <td><?php echo $data['nama_penguji']; ?></td>
                            <td><?php echo $data['nip_penguji']; ?></td>

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