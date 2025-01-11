<?php include '../config/koneksi.php'; ?>

<script> function NewWindow(mypage,myname,w,h,scroll){
            LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
            TopPosition = (screen.height) ? 0 : 0;
            settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
            win = window.open(mypage,myname,settings)                
                if(win.window.focus) {
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
                    <a href="homepage.php?p=add_surat" id="btn_create" class='btn btn-success'><span class='glyphicon glyphicon-plus'></span> Tambah </a>
                </div><br/><br/><br/>

                <?php
                    $sql =  "SELECT * FROM surat_keputusan";
                    $result = mysql_query($sql);
                    $no_urut=1;
                ?>

                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>No. Surat Keputusan</th>
                            <th>Kode FSOP</th>
                            <th>Tanggal</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while ($data = mysql_fetch_array($result)) {
                        ?>    
                        <tr>
                            <td align="center"><?php echo $no_urut; ?>.</td>
                            <td><?php echo $data ['no_sk']; ?></td>
                            <td><?php echo $data ['fsop']; ?></td>
                            <td><?php echo $data ['tanggal']; ?></td>
                            <td>
                                <a href='homepage.php?p=edit_surat&ubah=<?php echo $data[id_surat] ?>' >
                                <button id='btn_create' class='btn btn-xs btn-primary' data-toggle='tooltip' data-container='body' title='Ubah'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button></a>
                                
                                <a href='homepage.php?p=hapus_surat&hapus=<?php echo $data[id_surat] ?>' >
                                <button id='btn_create' class='btn btn-xs btn-danger' data-toggle='tooltip' data-container='body' title='Hapus'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></button></a>
                                
                                <a href='homepage.php?p=cetak&cetak=<?php echo $data[id_surat] ?>' >
                                <button id='btn_create' class='btn btn-xs btn-primary' data-toggle='tooltip' data-container='body' title='Cetak'><span class='glyphicon glyphicon-print' aria-hidden='true'></span></button></a>
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