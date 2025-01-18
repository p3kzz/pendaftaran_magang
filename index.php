<!DOCTYPE html>
<?php
include 'koneksi.php';
// include 'fungsi_indotgl.php';
$sql = mysqli_query($conn, "SELECT * FROM info_magang ORDER BY tanggal DESC");
?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Online Pendaftaran Magang</title>

    <link rel="icon" href="dist/img/uniba.png">
    <link rel="shortcut icon" href="dist/img/uniba.png">
    <!-- Normalize -->
    <link rel="stylesheet" type="text/css" href="dist/css/normalize.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="dist/css/bootstrap.css">
    <!-- Owl -->
    <link rel="stylesheet" type="text/css" href="dist/css/owl.css">
    <!-- Animate.css -->
    <link rel="stylesheet" type="text/css" href="dist/css/animate.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="dist/fonts/font-awesome-4.1.0/css/font-awesome.min.css">
    <!-- Elegant Icons -->
    <link rel="stylesheet" type="text/css" href="dist/fonts/eleganticons/et-icons.css">
    <!-- Main style -->
    <link rel="stylesheet" type="text/css" href="dist/css/cardio.css">
</head>

<body>

    <div class="preloader">
        <img src="dist/img/loader.gif" alt="Preloader image">
    </div>
    <nav class="navbar">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><img src="dist/img/uniba.png" data-active-url="dist/img/uniba.png"
                        alt="" style="height: 50px;"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right main-nav">
                    <li><a href="#intro">Beranda</a></li>
                    <li><a href="#services">Pengumuman</a></li>
                    <!-- <li><a href="#services">Pengumuman2</a></li> -->
                    <li><a href="#team">Team FTI</a></li>
                    <li><a href="#pricing">Tentang Kami</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#modal1" class="btn btn-blue">Login</a>
                    </li>
                    <li><a href="#" data-toggle="modal" data-target="#modal2" class="btn btn-blue">Register</a></li>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    <header id="intro">
        <div class="container">
            <div class="table">
                <div class="header-text">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <!-- <h3 class="light white">FAKULTAS TEKNIK DAN INFORMATIKA</h3> -->
                            <h1 class="white typed">Selamat Datang di Aplikasi Pendaftaran Magang.</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <section>
        <div class="cut cut-top"></div>
        <div class="container">
            <div class="col-md-4">
                <div class="service">
                    <div class="icon-holder">
                        <img src="dist/img/icons/guru-blue.png" alt="" class="icon">
                    </div>
                    <h4 class="heading">Syarat Pengajuan Magang</h4>
                    <a href="dist/file/syarat pengajuan magang.pdf" class="description">detail</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service">
                    <div class="icon-holder">
                        <img src="dist/img/icons/guru-blue.png" alt="" class="icon">
                    </div>
                    <h4 class="heading">Format Penulisan Proposal Magang</h4>
                    <a href="dist/file/format penulisan proposal magang.pdf" class="description">detail</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service">
                    <div class="icon-holder">
                        <img src="dist/img/icons/guru-blue.png" alt="" class="icon">
                    </div>
                    <h4 class="heading">Format Penulisan Laporan Akhir Magang</h4>
                    <a href="dist/file/format penulisan laporan magang.pdf" class="description">detail</a>
                </div>
            </div>
        </div>
    </section>
    <section id="services" class="section section-padded">
        <div class="container">
            <div class="row text-center title">
                <h2>PENGUMUMAN</h2>
                <h4 class="light muted">Pengumuman bisa berubah kapan saja, Aktif berkunjung ya... Terima kasih!</h4>
            </div>
            <div class="row services">
                <?php
            while ($data = mysqli_fetch_assoc($sql)) {
                // Ambil data dari tabel info_magang
                $judul = $data['judul_magang'];
                $tanggal = $data['tanggal'];
                $file = $data['file'];
            ?>
                <div class="col-md-4 col-sm-6">
                    <div class="intro-table intro-table-hover">
                        <div class="bottom">
                            <h4 class="white heading " align="center">
                                <?php echo $judul; ?>
                            </h4>
                            <h4 class="white hide-hover" style="margin-left: 15px;">
                                <?php 
        $tanggal;  // Contoh format tanggal, Anda bisa mengganti ini dengan variabel atau input lain
        echo date("j  F  Y", strtotime($tanggal)); 
    ?>
                            </h4>

                            <?php
                            if (!empty($file)) {
                                echo "<a href='dist/info_magang/$file' class='btn btn-white-fill expand'>Download File</a>";
                            } else {
                                echo "<p class='white'>Tidak ada file</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <section id="team" class="section gray-bg">
        <div class="container">
            <div class="row title text-center">
                <h2 class="margin-top">Team Fakultas Teknik</h2>
                <h4 class="light muted">We're a dream team!</h4>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="team text-center">
                        <div class="cover"
                            style="background:url('dist/img/team/team-cover1.jpg'); background-size:cover;">
                            <div class="overlay text-center">
                                <h3 class="white">Fakultas Teknik</h3>
                            </div>
                        </div>
                        <img src="dist/img/avatar5.png" alt="Team Image" class="avatar">
                        <div class="title">
                            <h4>Dekan<br>
                                Teknik Industri</h4>
                            <h5 class="muted regular">Agung Firdausi Ahsan S.T., M.T </h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team text-center">
                        <div class="cover"
                            style="background:url('dist/img/team/team-cover2.jpg'); background-size:cover;">
                            <div class="overlay text-center">
                                <h3 class="white">Fakultas Teknik</h3>
                            </div>
                        </div>
                        <img src="dist/img/avatar.png" alt="Team Image" class="avatar">
                        <div class="title">
                            <h4>Dekan<br>
                                Teknik Informatika
                            </h4>
                            <h5 class="muted regular">Zeinor Rahman, S.Pd., M.Pd.
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team text-center">
                        <div class="cover"
                            style="background:url('dist/img/team/team-cover3.jpg'); background-size:cover;">
                            <div class="overlay text-center">
                                <h3 class="white">Fakultas Sains</h3>
                            </div>
                        </div>
                        <img src="dist/img/avatar04.png" alt="Team Image" class="avatar">
                        <div class="title">
                            <h4>Dekan<br>
                                Sistem Informasi<br>
                            </h4>
                            <h5 class="muted regular">Rizki Anantama, S.Kom., M.T
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="pricing" class="section">
        <div class="container">
            <div class="row title text-center">
                <h2 class="margin-top white">Tentang Fakultas Teknik</h2>
                <h4 class="light white">Mengenal lebih dekat dengan Fakultas Teknik</h4>
                <h4 class="margin-top white">Visi Fakultas Teknik</h4>
                <h4 class="light white">Menjadi fakultas yang unggul melalui penguasaan teknologi informasi dan bisnis
                    sehingga memiliki daya saing dalam lingkup nasional dengan didasarkan atas keimanan pada Tuhan Yang
                    Maha Esa.</h4>
                <h4 class="margin-top white">Misi Fakultas Teknik</h4>
                <h4 class="light white">1. Menciptakan dan meningkatkan mutu pendidikan dan pengajaran fakultas untuk
                    berkinerja secara efisien dan efektif.<br>
                    2. Membangun kualitas sumber daya internal sebagai pelaku utama dalam implementasi ilmu pengetahuan
                    berbasis teknologi dan bisnis. <br>
                    3. Menerapkan dan mendayagunakan ilmu pengetahuan berbasis teknologi dan bisnis sesuai kebutuhan
                    masyarakat.
                </h4>
            </div>

        </div>
    </section>
    <section class="section section-padded blue-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="owl-twitter owl-carousel">
                        <div class="item text-center">
                            <i class="icon fa fa-yelp"></i>
                            <h4 class="white light">Program Studi Fakultas Teknik</h4>
                            <h4 class="light-white light">ada 3 program studi</h4>
                        </div>
                        <div class="item text-center">
                            <i class="icon fa fa-yelp"></i>
                            <h4 class="white light">Program Studi Teknik Informatika</h4>
                            <h4 class="light-white light">Pada Program Studi Teknik Informatika memiliki dua konsentrasi
                                dibidang <br> #web development #mobile development</h4>
                        </div>
                        <div class="item text-center">
                            <i class="icon fa fa-yelp"></i>
                            <h4 class="white light">Program Studi Sistem Informasi</h4>
                            <h4 class="light-white light">Pada Program Studi Teknik Informatika memiliki dua konsentrasi
                                dibidang <br> #Sistem Enterprise #Audit Sistem Informasi </h4>
                        </div>
                        <div class="item text-center">
                            <i class="icon fa fa-yelp"></i>
                            <h4 class="white light">Program Studi Teknik Industri</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-popup">
                <a href="#" class="close-link"><i class="icon_close_alt2"></i></a>
                <h3 class="white">Login</h3>
                <form method="POST" action="login.php" class="popup-form">
                    <input type="email" class="form-control form-white" placeholder="email" name="email" required>
                    <input type="password" class="form-control form-white" placeholder="Password" name="password"
                        required>
                    <button type="submit" class="btn btn-submit" name="Login">Login</button>
            </div>
            </form>
            <br>

        </div>
    </div>
    <div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-popup">
                <a href="#" class="close-link"><i class="icon_close_alt2"></i></a>
                <h3 class="white">Registrasi</h3>
                <form method="POST" action="registrasi.php" class="popup-form" id="registerForm">
                    <input type="text" class="form-control form-white" placeholder="Nama Lengkap" name="name" required>
                    <input type="email" class="form-control form-white" placeholder="Email" name="email" required>
                    <input type="password" class="form-control form-white" placeholder="Password" name="password"
                        required>
                    <input type="text" class="form-control form-white" placeholder="NIM" name="nim" required>
                    <input type="text" class="form-control form-white" placeholder="Jurusan" name="jurusan" required>
                    <input type="text" class="form-control form-white" placeholder="Fakultas" name="fakultas" required>
                    <input type="number" class="form-control form-white" placeholder="Angkatan" name="angkatan"
                        required>
                    <select class="form-control " name="jenis_kelamin" required>
                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                    <textarea class="form-control form-white" placeholder="Alamat" name="alamat" required></textarea>
                    <input type="text" class="form-control form-white" placeholder="Nomor HP" name="no_hp" required>
                    <button type="submit" class="btn btn-submit" name="register">Registrasi</button>
                </form>
            </div>
        </div>
    </div>

    </div>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 text-center-mobile">
                    <h3 class="white"></h3>
                    <h5 class="light regular light-white"></h5>

                </div>

            </div>
            <div class="row bottom-footer text-center-mobile">
                <div class="col-sm-8">
                    <p>&copy; 2020 All Rights Reserved. Powered by <a href="http://www.phir.co/">Uniba Madura</a></p>
                </div>
                <div class="col-sm-4 text-right text-center-mobile">
                    <ul class="social-footer">
                        <li><a href="http://www.facebook.com/pages/Codrops/159107397912"><i
                                    class="fa fa-facebook"></i></a></li>
                        <li><a href="http://www.twitter.com/codrops"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="https://plus.google.com/101095823814290637419"><i
                                    class="fa fa-google-plus"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- Holder for mobile navigation -->
    <div class="mobile-nav">
        <ul>
        </ul>
        <a href="#" class="close-link"><i class="arrow_up"></i></a>
    </div>
    <!-- Scripts -->
    <script src="dist/js/jquery-1.11.1.min.js"></script>
    <script src="dist/js/owl.carousel.min.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
    <script src="dist/js/wow.min.js"></script>
    <script src="dist/js/typewriter.js"></script>
    <script src="dist/js/jquery.onepagenav.js"></script>
    <script src="dist/js/main.js"></script>

    <!-- <script>
    // Event listener for the registration form submission
    document.getElementById('registerForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        // Hide the register modal
        $('#modal2').modal('hide');

        // Show the login modal
        $('#modal1').modal('show');
    });
    </script> -->
</body>

</html>