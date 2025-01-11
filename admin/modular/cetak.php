<?php include '../config/koneksi.php'; ?>
<script> function NewWindow(mypage,myname,w,h,scroll){
                LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
                TopPosition = (screen.height) ? 0 : 0;
                settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
                win = window.open(mypage,myname,settings)
                if(win.window.focus){
                    win.window.focus();
                }
            }
</script>

<?php
if (isset($_REQUEST['semester'])){
    $semester=$_REQUEST['semester'];
    $prodi=$_REQUEST['prodi'];
    $laporan=$_REQUEST['laporan'];
    $ajaran=$_REQUEST['ajaran'];
    echo ("<script>document.location='../cetak/laporan.php?prodi=$prodi&semester=$semester&ajaran=$ajaran&laporan=$laporan'</script>");
} else {
    $ID =$_GET['cetak'];
    $sql = mysql_query("SELECT * FROM surat_keputusan WHERE id_surat = '$ID'");
    $data=mysql_fetch_array($sql);

    $sk=$data['no_sk'];
    $kode=$data['fsop'];
    $prodi=$data['program_studi'];
?>

<section class="content-header">      
    <h1> Cetak Laporan </h1>
    <ol class="breadcrumb">
        <li><a href="homepage.php?p=dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Cetak Laporan</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- quick email widget -->
    <div class="box box-info">            
        <div class="box-header">
            <div class="row-fluid">
                <div class="col-md-8">
                    <!-- form start -->
                    <form method="POST" enctype="multipart/form-data" action="">
                        <div class="box-body">
                            <!-- form sk-->
                            <div class="form-group">
                                <label>No. Surat Keputusan</label>
                                <input type="text" class="form-control" id="sk" placeholder="masukkan nomor surat keputusan" name="sk" value="<?php echo "$sk";?>" required>
                            </div>
                            <!-- form fsop-->
                            <div class="form-group">
                                <label>Kode FSOP</label>
                                <input type="text" class="form-control" id="kode" placeholder="04-02-02/E.01R2" name="kode" value="<?php echo "$kode";?>" required>
                            </div>
                            <!-- form program studi-->
                            <div class="form-group">
                                <label>Program Studi</label>
                                <select class="form-control" name="prodi" required>
                                <option selected>Pilih Program Studi</option>
                                    <?php
                                        $qsp = mysql_query("SELECT * FROM prodi");
                                        while ($s=mysql_fetch_array($qsp)) {
                                            if ($s[pnama]==$data[program_studi]){
                                                echo "<option value='$s[pnama]' selected>$s[pnama]</option>";
                                            } else {
                                                echo "<option value='$s[pnama]'>$s[pnama]</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <!-- form laporan-->
                            <div class="form-group">
                                <label>Jenis Laporan</label>
                                <select class="form-control" name="laporan" required>
                                    <option selected>Pilih Jenis Laporan</option>
                                    <option value="kp">Kerja Praktek</option>
                                    <option value="skripsi">Skripsi</option>
                                </select>
                            </div>
                            <!-- form semester-->
                            <div class="form-group">
                                <label>Semester</label>
                                <select class="form-control" name="semester" required>
                                    <option selected>Pilih Semester</option>
                                    <option value="ganjil">Ganjil</option>
                                    <option value="genap">Genap</option>
                                </select>
                            </div>
                            <!-- form thn ajaran-->
                            <div class="form-group">
                                <label>Tahun Ajaran</label>
                                <select class="form-control" name="ajaran" required>
                                    <option selected>Pilih Tahun Ajaran</option>
                                    <option value="2012/2013">2012/2013</option>
                                    <option value="2013/2014">2013/2014</option>
                                    <option value="2014/2015">2014/2015</option>
                                    <option value="2015/2016">2015/2016</option>
                                    <option value="2016/2017">2016/2017</option>
                                    <option value="2017/2018">2017/2018</option>
                                    <option value="2018/2019">2018/2019</option>
                                    <option value="2019/2020">2019/2020</option>
                                    <option value="2020/2021">2020/2021</option>
                                    <option value="2021/2022">2021/2022</option>
                                    <option value="2022/2023">2022/2023</option>
                                    <option value="2023/2024">2023/2024</option>
                                </select>
                            </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            
                            <button type="submit" name="cetak" class="btn btn-primary"><i class="glyphicon glyphicon-print"></i> Cetak</button>

                            <button onclick="NewWindow('../cetak/laporanfak.php','ZoomIn','850','550','yes');return false" class="btn btn-primary">
                                <i class="glyphicon glyphicon-print"></i> Cetak Semua
                            </button>

                            <a class="btn btn-primary" href="homepage.php?p=cetak_laporan"><i class="fa fa-mail-reply"></i> batal </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- /.row (main row) -->
</section> 
<?php } ?>