<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>Despacho de Banda y Tripa</title>

    <link href="{{asset("css/menu/styles.css")}}" rel="stylesheet"/>
    <link href="{{asset("css/menu/file-input.css")}}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{asset("https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css")}}" rel="stylesheet" crossorigin="anonymous"/>
    <link href="{{asset("https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css")}}" rel="stylesheet"/>
    <link href="{{asset("css/menu/main.css")}}">
    <link href="{{asset("css/menu/bd-wizard.css")}}" rel="stylesheet">
    <link href='{{asset("https://api.mapbox.com/mapbox-gl-js/v1.11.1/mapbox-gl.css")}}' rel='stylesheet' />
    <link rel="stylesheet" href="{{asset("https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.css")}}" type="text/css"/>

</head>
<body id="body" class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <button class="btn btn-link order-1 order-lg-0 ml-4" id="sidebarToggle" href="#"><i class="fas fa-bars"></i>
    </button>
    <a class="navbar-brand" href="/">Despacho de Banda y Tripa</a>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">

    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <!--  <a class="dropdown-item" href="#">Settings</a>
                    <a class="dropdown-item" href="#">Activity Log</a>     -->

                <div class="dropdown-divider"></div>
                <div class="dropdown-item" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('Cerrar Sesión') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Inicio</div>
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseinicio"
                       aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                        Salida Y Entradas
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseinicio" aria-labelledby="headingOne"
                         data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{url('BultoSalida')}}">Despacho De Bulto</a>
                            <a class="nav-link" href="{{url('ConsumoBanda')}}">Salida De Banda</a>
                            <a class="nav-link" href="{{url('EntradaBanda')}}">Entrada Banda</a>


                        </nav>
                    </div>
                    <div class="sb-sidenav-menu-heading">Registros</div>
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseinicio2"
                       aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-pager"></i></div>
                        R. Diarios
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseinicio2" aria-labelledby="headingOne"
                         data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">

                            <a class="nav-link" href="{{url('InventarioDiario')}}"> Inventario De Bultos</a>
                            <a class="nav-link" href="{{url('BultoDevuelto')}}">Bultos Devueltos</a>
                            <a class="nav-link" href="{{url('InventarioBanda')}}"> Inventario De Banda</a>




                        </nav>
                    </div>
                    <div class="sb-sidenav-menu-heading"> Administracion General</div>

                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts"
                       aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-building"></i></div>
                        General
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                         data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{url('empleadosBanda')}}">Empleados</a>
                            <a class="nav-link" href="{{url('marcasBanda')}}">Marcas</a>
                            <a class="nav-link" href="{{url('semillasBanda')}}">Semilla</a>
                            <a class="nav-link" href="{{url('vitolaBanda')}}">Vitolas</a>
                            <a class="nav-link" href="{{url('Procedencia')}}">Procedencia</a>
                            <a class="nav-link" href="{{url('variedad')}}">Variedad</a>
                            <a class="nav-link" href="{{url('InventarioInicial')}}">Inventario Diario</a>




                        </nav>
                    </div>

                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logeado con:</div>
                {{ Auth::user()->name }}
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>

            @yield("content")
            <div class="modal fade" tabindex="-1" id="cerrarSesionModal" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Advertencia</h5>

                        </div>
                        <div class="modal-body">
                            <p>¿Estás seguro que deseas cerrar sesión?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary"   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Si</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
<script src="js/jsmenu/scripts.js"></script>
<script src="{{asset("js/jsmenu/bootstrap-fileinput.js")}}" type="text/javascript"></script>
<script src="{{asset("js/jsmenu/bootstrap-fileinput-theme.js")}}" type="text/javascript"></script>

<script src="{{asset("js/jsmenu/jquery.steps.min.js")}}"></script>
<script src="{{asset("js/jsmenu/bd-wizard.js")}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/chart-area-demo.js"></script>
<script src="assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/datatables-demo.js"></script>

<script src="{{asset("https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.min.js")}}"></script>
<script src='{{asset("https://api.mapbox.com/mapbox-gl-js/v1.11.1/mapbox-gl.js")}}'></script>
<script src="{{asset("js/jsmenu/mapbox-scripts.js")}}"></script>
<script src="{{asset("js/jsmenu/categorias.js")}}"></script>
<script src="{{asset("js/jsmenu/font-awesome.js")}}" crossorigin="anonymous"></script>
<script src="{{asset("js/marca.js")}}"></script>
<script src="{{asset("js/empleado.js")}}"></script>
<script src="{{asset("js/CapaEntrega.js")}}"></script>
<script src="{{asset("js/CapaRecibida.js")}}"></script>
<script src="{{asset("js/Peso.js")}}"></script>
<script src="{{asset("js/semilla.js")}}"></script>
<script src="{{asset("js/ReBulDiario.js")}}"></script>


<script>
    $(document).ready(function () {
        $(".tipoCategoria").select2({
            theme: "classic",
            placeholder: "Seleccione una opción"
        });
        $(".empresa").select2({
            theme: "classic",
            placeholder: "Seleccione una opción"
        });
        $(".disponible").select2({
            theme: "classic",
            placeholder: "Seleccione una opción"
        });
        $(".marca").select2({
            theme: "classic",
            placeholder: "Seleccione una opción"
        });
    });
</script>

</body>
</html>
