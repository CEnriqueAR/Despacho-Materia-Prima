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
                            <strong>REGISTRAR NUEVO USUARIO</strong>
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
                        <form id="form-validation" name="form-validation" method="POST" action="{{ route('registrarUsuario') }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label class="form-label">Nombre</label>
                                <input id="validation-email"
                                       class="form-control"
                                       placeholder="Nombre"
                                       name="name"
                                       type="text"
                                       data-validation="[NOTEMPTY]">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Correo Electronico</label>
                                <input id="validation-email"
                                       class="form-control"
                                       placeholder="Correo Electronico"
                                       name="email"
                                       type="text"
                                       data-validation="[NOTEMPTY]">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Contraseña</label>
                                <input id="validation-password"
                                       class="form-control password"
                                       name="password"
                                       type="password" data-validation="[L>=6]"
                                       data-validation-message="introduzca la contraseña"
                                       placeholder="Contraseña">
                            </div>
                            <div class="form-group">
                                <label for="password-confirm" class="labeltamaño">Confirmar contraseña</label>

                                <div class="inputtamaño">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="disponible">Seleccione Tipo De usuario
                                </label>
                                <br>
                                <select
                                    name="is_admin"
                                    required="required"
                                    style="width: 100%"
                                    class="disponible form-control @error('disponible') is-invalid @enderror" id="disponible">
                                    <option disabled selected value="">Seleccione</option>
                                    <option value="0"@if(Request::old('is_admin')==0){{'selected'}}@endif>Administrador </option>
                                    <option value="1"@if(Request::old('is_admin')==1){{'selected'}}@endif>Despacho De Capa </option>
                                    <option value="2"@if(Request::old('is_admin')==2){{'selected'}}@endif>Despacho De Banda Y Tripa </option>

                                </select>
                                <!---- Boton para crear un nuevo tipo de categoria- -->
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Registrar </button>
                                <a type="button" class="btn btn-danger" href="/">Cancelar</a>
                            </div>
                        </form>
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
