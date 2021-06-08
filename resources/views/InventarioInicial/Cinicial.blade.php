@extends("layouts.Menu")
@section("content")
    <div class="container-fluid">
        <h1 class="mt-4">Inventario Inicial


        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page" ><a href="/">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Inventario Inicial</li>
            </ol>
            <div class="pagination pagination-sm">

                <form  class="d-none d-md-inline-block form-inline
                           ml-auto mr-0 mr-md-2 my-0 my-md-0 mb-md-2">
                    <div class="input-group" style="width: 300px">
                        <input class="form-control" name="search" type="search" placeholder="Search"
                               aria-label="Search">
                        <div class="input-group-append">
                            <a id="borrarBusqueda" class="btn btn-danger hideClearSearch" style="color: white"
                               href="{{route("InventarioInicialCapa")}}">&times;</a>
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>

        </nav>

        @if(session("exito"))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{session("exito")}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!--------------------------Reabrir modal si hay errror---------------------------->
        @if(session("errores"))
            <input id="id_M" name="id_M" value="{{session("id_M")}}" type="hidden" >

            <script>
                var id=document.getElementById("id_M").value;
                document.onreadystatechange = function () {
                    if (document.readyState) {
                        document.getElementById("editar_M"+id).click();
                    }
                }
            </script>
            @else
            @if($errors->any())
            <script>
                document.onreadystatechange = function () {
                    if (document.readyState) {
                        document.getElementById("botonAbrirModalNuevaMarca").click();
                    }
                }
            </script>
            @endif
    @endif

        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Semilla</th>
                <th>Calidad</th>
                <th>Tamaño</th>

                <th><span class="fas fa-info-circle"></span></th>
            </tr>
            </thead>
            <tbody>
            @if(!$cinicial)
                <tr>
                    <td colspan="4" style="align-items: center">No hay Marcas registradas</td>
                </tr>
            @endif
            @foreach($cinicial as $marca)
                <tr>
                    <td>{{$noPagina++}}</td>
                    <td>{{$marca->nombre_semillas}}</td>
                    <td>{{$marca->nombre_calidads}}</td>
                    <td>{{$marca->nombre_tamano}}</td>


                    <td>
                        <button class="btn btn-sm btn-danger"
                                title="Borrar"
                                data-toggle="modal"
                                data-target="#modalBorrarMarca"
                                data-id="{{$marca->id}}">
                            <span class="fas fa-trash"></span>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>


        <!--------------------------MODAL BORRAR MARCA----------------------------------->
        <div class="modal fade" id="modalBorrarMarca" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <form method="post" action="{{route("InventarioInicialcapaborrar")}}" enctype="multipart/form-data">
                        @method("DELETE")
                        @csrf
                        <div class="modal-header" style="background: #2a2a35">
                            <h5 class="modal-title" style="color: white"><span class="fas fa-trash"></span> Borrar
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span style="color: white" aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>¿Estás seguro que  lo deseas borrar  <label
                                    id="nombreMarca"></label>? </p>
                        </div>
                        <div class="modal-footer">
                            <input id="id" name="id" type="hidden" value="">
                            <button type="submit" class="btn btn-danger">Borrar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>


    </div>
    @endsection
