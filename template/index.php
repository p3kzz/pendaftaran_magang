<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Aplikasi Magang </title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('') }}assets_admin/img/logonew.png" rel="icon">
    <link href="{{ asset('') }}assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link rel="stylesheet" href="{{ asset('assets_admin/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_admin/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_admin/datatables/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700|Raleway:300,400,400i,500,500i,700,800,900"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('') }}assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('') }}assets/vendor/icofont/icofont.min.css" rel="stylesheet">
    <link href="{{ asset('') }}assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="{{ asset('') }}assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('') }}assets/vendor/nivo-slider/css/nivo-slider.css" rel="stylesheet">
    <link href="{{ asset('') }}assets/vendor/owl.carousel/assets_admin/owl.carousel.min.css" rel="stylesheet">
    <link href="{{ asset('') }}assets/vendor/venobox/venobox.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets_admin/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_admin/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_admin/datatables/buttons.dataTables.min.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- link boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Template Main CSS File -->
    <link href="{{ asset('') }}assets/css/style.css" rel="stylesheet">
</head>

<body data-spy="scroll" data-target="#navbar-example">

    @include('template.navbar')

    @yield('contents')

    @include('template.footer')


    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('') }}assets/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('') }}assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('') }}assets/vendor/jquery.easing/jquery.easing.min.js"></script>
    <script src="{{ asset('') }}assets/vendor/php-email-form/validate.js"></script>
    <script src="{{ asset('') }}assets/vendor/appear/jquery.appear.js"></script>
    <script src="{{ asset('') }}assets/vendor/knob/jquery.knob.js"></script>
    <script src="{{ asset('') }}assets/vendor/parallax/parallax.js"></script>
    <script src="{{ asset('') }}assets/vendor/wow/wow.min.js"></script>
    <script src="{{ asset('') }}assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="{{ asset('') }}assets/vendor/nivo-slider/js/jquery.nivo.slider.js"></script>
    <script src="{{ asset('') }}assets/vendor/owl.carousel/owl.carousel.min.js"></script>
    <script src="{{ asset('') }}assets/vendor/venobox/venobox.min.js"></script>
    <script src="{{ asset('') }}assets_admin/js/plugin/datatables/datatables.min.js"></script>


    <script src="{{ asset('assets_admin/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets_admin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets_admin/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets_admin/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets_admin/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('assets_admin/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets_admin/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets_admin/datatables/buttons.html5.min.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('') }}assets/js/main.js"></script>

    <script>
    $(document).ready(function() {
        $('.table').DataTable({
            dom: 'lBfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
        });
    });
    </script>


    <!-- js boocstrap -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>

</html>