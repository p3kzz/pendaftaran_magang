<?php include '../config/koneksi.php'; ?>
<?php session_start(); ?>

<?php  
    $ID = $_SESSION['username'];
    $sql = mysql_query("SELECT * FROM admin WHERE WHERE username = '$ID'");
    $data = mysql_fetch_array($sql);
?>

<section class="content-header">      
    <h1> Edit Admin</h1>
    <ol class="breadcrumb">
        <li><a href="homepage.php?p=dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit Admin</li>
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
                    <form method="POST" enctype="multipart/form-data">
                        <div class="box-body">
                            <!-- form nama lengkap-->
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" placeholder="masukkan nama" name="nama" value="<?php echo "$_SESSION[nama_adm]";?>" required>
                            </div>
                            <!-- form username-->
                            <div class="form-group">
                                <label>Username</label> 
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" placeholder="username" id="username" name="username" value="<?php echo "$ID";?>" readonly>
                                </div>
                            </div>
                            <!-- form password-->
                            <div class="form-group">
                                <label>Password Baru</label> 
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-key"></i>
                                    </div>
                                    <input type="password" class="form-control" placeholder="password" id="password" name="password" value="" >
                                </div>
                                <div class="form-group">
                                    <label for="repass" class="control-label">Konfirmasi Password</label>
                                    <input class="form-control" id="repass" name="repass" type="password" placeholder="Konfirmasi password">
                                </div>
                            </div>    
                            <!-- form foto-->
                            <div class="form-group">
                                <label>Foto</label>
                                <div><?php echo "<img src='foto/$_SESSION[foto_adm]' width='100' height='120'>" ?></div>
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="input-append">
                                        <div class="uneditable-input">
                                            <span class="fileupload-preview"></span>
                                        </div>
                                        <span class="btn btn-default btn-file">
                                            <span class="fileupload-exists">Change</span>
                                            <span class="fileupload-new">Select file</span>
                                            <input type="file" name="fupload" />
                                        </span>
                                        <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                                    </div>
                                </div>
                                <p class="help-block">Ukuran gambar jangan lebih dari 1 mb</p>
                            </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" name="simpan" class="btn btn-primary"><i class="fa fa-check"></i> simpan</button>
                        <a class="btn btn-primary" href="homepage.php?p=data_admin"><i class="fa fa-mail-reply"></i> batal </a>
                    </div>
                    </form>
                    <?php
                        $x1 = trim ($_POST['nama']);
                        $x2 = trim ($_POST['username']);
                        $lokasi_file    = $_FILES['fupload']['tmp_name'];
                        $nama_file      = $_FILES['fupload']['name'];
                        $pass = $_POST['password'];
                        $repass = $_POST['repass'];
                        if($pass==NULL)
                        {
                            $password=$passlama;
                            $flag="Password Tetap";
                        }
                        else if($pass==$repass)
                        {
                            $password = md5($pass);
                            $flag ="Password Diganti";
                        }
                        else{
                            $password=$passlama;
                            echo "<script language='javascript'>alert('password konfirmasi berbeda');document.location='homepage.php?p=data_admin';</script>"; 
                        }
                            
                        if (isset($_POST[simpan])) {
                                
                            if(!empty($lokasi_file))
                            {
                                    move_uploaded_file($lokasi_file,"foto/$nama_file");
                                    $q = mysql_query("UPDATE admin set nama_lengkap='$x1',username='$x2',password='$password',foto='$nama_file' WHERE username='$ID' ");
                                    if($q){
                                    echo "<script language='javascript'>alert('Data Berhasil Diubah');document.location='homepage.php?p=profile';</script>";
                                    }
                                    else{
                                    echo "<script language='javascript'>alert('Data Gagal Diubah');document.location='homepage.php?p=profile';</script>"; 
                                    }
                            }
                            else
                            {
                                $q = mysql_query("UPDATE admin set nama_lengkap='$x1',username='$x2',password='$password' WHERE username='$ID' ");
                                    if($q){
                                    echo "<script language='javascript'>alert('Data Berhasil Diubah');document.location='homepage.php?p=profile';</script>";
                                    }
                                    else{
                                    echo "<script language='javascript'>alert('Data Gagal Diubah');document.location='homepage.php?p=profile';</script>"; 
                                    }
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
<!-- /.row (main row) -->
</section> 