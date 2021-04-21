@section('title', 'Login')
@include('main')

    <title>Despacho de Materia Prima</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Course Project">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="styles/stylesindex/bootstrap4/bootstrap.min.css">
    <link href="plugins/fontawesome-free-5.0.1/css/fontawesome-all.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
    <link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">
    <link rel="stylesheet" type="text/css" href="styles/stylesindex/main_styles.css">
    <link rel="stylesheet" type="text/css" href="styles/stylesindex/responsive.css">

<link rel="stylesheet" type="text/css" href="css/cssLogin/util.css">
<link rel="stylesheet" type="text/css" href="css/cssLogin/main.css">

<!--===============================================================================================-->
<link href="{{asset("/vendor/bootstrap/css/bootstrap.min.css")}}" rel="stylesheet">

<!-- Custom fonts for this template -->
<link href="{{asset("/vendor/fontawesome-free/css/all.min.css")}}" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
<body >
<!-- START: pages/login -->

<div class="limiter">
    <div class="container-login100" style="background-image: url('imagen/Login.png');">

        <div class="wrap-login100 p-t-30 p-b-50"><br><br>


            <div class="col-xl-10">
                <div class="cat__pages__login__block__promo text-white text-center">
                    <h2 class="mb-3">
                        <strong>DESPACHO DE MATERIA PRIMA</strong>
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col">
                        <div class="col-lg-10 hero_box_col">
                            <a href="{{route('BultoSalida')}}" >
                                <div class="hero_box d-flex flex-row align-items-center ">
                                    <img src="images/earth-globe.svg" class="svg" alt="">
                                    <div class="hero_box_content">
                                        <h2 class="hero_box_title">Despacho de Tripa y Banda</h2>
                                    </div>
                                </div>
                            </a>
                        </div>
                </div>

<br> <br>
            <div class="col">

                <div class="col-lg-10 hero_box_col">
                            <a href="{{route('CapaEntrega')}}" >
                                <div class="hero_box d-flex flex-row align-items-center">
                                    <img src="images/books.svg" class="svg" alt="">
                                    <div class="hero_box_content">
                                        <h2 class="hero_box_title">Despacho de Capa</h2>
                                    </div>
                                </div>
                            </a>
                        </div>


                </div>
                <div class="col">

                    <div class="col-lg-10 hero_box_col">

                        <a href="/registro">
                            <div class="hero_box d-flex flex-row align-items-center">
                                <img src="images/books.svg" class="svg" alt="">
                                <div class="hero_box_content">
                                    <h2 class="hero_box_title">Registro</h2>
                                </div>
                            </div>
                        </a>

                    </div>



                </div>
            </div>


        </div>
    </div>
</div>
<!-- END: pages/login-alpha -->

<!-- START: page scripts -->
<script>
    $(function() {

        // Form Validation
        $('#form-validation').validate({
            submit: {
                settings: {
                    inputContainer: '.form-group',
                    errorListClass: 'form-control-error',
                    errorClass: 'has-danger'
                }
            }
        });

        // Show/Hide Password
        $('.password').password({
            eyeClass: '',
            eyeOpenClass: 'icmn-eye',
            eyeCloseClass: 'icmn-eye-blocked'
        });

        // Change BG
        var min = 1, max = 5,
            next = Math.floor(Math.random()*max) + min,
            final = next > max ? min : next;
        $('.random-bg-image').data('img', final);
        $('.cat__pages__login').data('img', final).css('backgroundImage', 'url(dist/modules/pages/common/img/login/' + final + '.jpg)');

    });
</script>

<!-- END: page scripts -->
</body>
