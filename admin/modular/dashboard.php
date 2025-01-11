<section class="content-header">
    <h1> Dashboard </h1>
    <ol class="breadcrumb">
        <!-- <li><a href="homepage.php?p=dashboard"><i class="fa fa-dashboard"></i> Home</a></li> -->
        <li class="active">Dashboard</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="alert alert-warning alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Selamat Datang <span class="username"><?php echo $nama ?></span>,
            <br>Anda Berhasil Login sebagai <?php echo $_SESSION['users']['role'] ?></strong>
    </div>

    <!-- Sistem-->
    <div class="box box-info">
        <div class="box-header">
            <h1>
                <center><b>SISTEM PENDAFTARAN MAGANG ONLINE</b></center>
            </h1>
            <center><img src="../dist/img/unibaDashboard.jpg" width="350" height="150" ></center>
            <center>
                <h2><b>UNIBA Copyright &copy; <?php echo date ('Y') ?></b></h2>
            </center>
            <center>
                <h4><b>Made with Team Student UNIBA in Sumenep, East Java Indonesia</b></h4>
            </center>
        </div>
    </div>
</section>