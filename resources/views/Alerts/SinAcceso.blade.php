@section('title', 'Login')
@include('main')
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

            <div class="col-xl-12">
                <div class="cat__pages__login__block__promo text-white text-center">
                    <h2 class="mb-3">
                        <strong>DESPACHO DE MATERIA PRIMA</strong>
                    </h2>
                </div>
                <div class="cat__pages__login__block__inner">
                    <div class="cat__pages__login__block__form">
                        <h4 class="text-uppercase">
                            <strong>aCCESO RESTRINGIDO</strong>
                        </h4>
                        <br />
                        @if(isset(Auth::user()->email))
                        @endif
                        @if($message = Session::get('error'))
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">x</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        @if (count($errors)>0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <h6>Usted no tiene acceso </h6>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a class="btn btn-primary" href="/" >INICIO
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
