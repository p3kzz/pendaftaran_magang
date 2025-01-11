<?php 
require '../koneksi.php'; 
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

                                <a href='index.php?hapus_mahasiswa&hapus=<?php echo $data['nim']; ?>'
                                    onclick='checkDelete()'>
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