
<?php
include '../koneksi.php'; 

$sql = "SELECT * FROM info_magang";

$queryinfo = $conn->query(query: $sql);

if ($queryinfo->num_rows > 0) {
    $no_urut = 1;
} else {
    echo "<div class='alert alert-danger'>Data jadwal tidak ditemukan.</div>";
    $queryinfo = [];
}

?>

<section class="content-header">
    <h1>Data Jadwal Sidang</h1>
    <ol class="breadcrumb">
        <li><a href="index.php?dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Data Jadwal</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-info">
        <div class="box-header">
            <div class="row-fluid" style="overflow:auto">
                <div class="col-md-8">
                    <a href="index.php?add_info_magang" id="btn_create" class='btn btn-success'><span
                            class='glyphicon glyphicon-plus'></span> Tambah </a>

                    <!-- <a href="homepage.php?p=form_dbmahasiswa" id="btn_create" class='btn btn-primary'><span class='glyphicon glyphicon-upload'></span> Import Database </a> -->
                </div><br /><br /><br />
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>judul</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $queryinfo->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $no_urut++; ?>.</td>
                            <td><?php echo htmlspecialchars($row['judul_magang']); ?></td>
                            <td><?php echo htmlspecialchars($row['tanggal']); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>