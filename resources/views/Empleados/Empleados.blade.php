@extends("layouts.Menu")
@section("content")
    <div class="container-fluid">
        <h1 class="mt-4">Empleados
            <div class="btn-group" role="group">
                <button class="btn btn-sm btn-success"
                        id="botonAbrirModalNuevoEmpleado"
                        data-toggle="modal" data-target="#modalCrearEmpleado">
                    <span class="fas fa-plus"></span> Nueva
                </button>
            </div>

        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page" ><a href="/">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Empleados</li>
            </ol>
            <div class="pagination pagination-sm">



                <form  class="d-none d-md-inline-block form-inline
                           ml-auto mr-0 mr-md-2 my-0 my-md-0 mb-md-2">
                    <div class="input-group" style="width: 300px">
                        <input class="form-control" name="search" type="search" placeholder="Search"
                               aria-label="Search">
                        <div class="input-group-append">
                            <a id="borrarBusqueda" class="btn btn-danger hideClearSearch" style="color: white"
                               href="{{route("empleados")}}">&times;</a>
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
            <input id="id_producto" name="id_producto" value="{{session("id_producto")}}" type="hidden" >

            <script>
                var id=document.getElementById("id_producto").value;
                document.onreadystatechange = function () {
                    if (document.readyState) {
                        document.getElementById("editar"+id).click();
                    }
                }
            </script>
            @else
            @if($errors->any())
            <script>
                document.onreadystatechange = function () {
                    if (document.readyState) {
                        document.getElementById("botonAbrirModalNuevoEmpleado").click();
                    }
                }
            </script>
            @endif
    @endif

        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Codigo</th>
                <th>Nombre</th>

                <th><span class="fas fa-info-circle"></span></th>
            </tr>
            </thead>
            <tbody>
            @if(!$empleado)
                <tr>
                    <td colspan="4" style="align-items: center">No hay Empleados registradas</td>
                </tr>
            @endif
            @foreach($empleado as $empleado)
                <tr>
                    <td>{{$noPagina++}}</td>
                    <td>{{$empleado->codigo}}</td>
                    <td>{{$empleado->nombre}}</td>



                    <td>
                        <button class="btn btn-sm btn-success"
                                title="Editar"
                                id="editar{{$empleado->id}}"
                                data-toggle="modal"
                                data-target="#modalEditarEmpleado"
                                data-id="{{$empleado->id}}"
                                data-codigo="{{$empleado->codigo}}"
                                data-nombre="{{$empleado->nombre}}"
                        >
                            <span class="fas fa-pencil-alt"></span>
                        </button>
                        <button class="btn btn-sm btn-danger"
                                title="Borrar"
                                data-toggle="modal"
                                data-target="#modalBorrarEmpleado"
                                data-id="{{$empleado->id}}"
                                data-nombre="{{$empleado->nombre}}">
                            <span class="fas fa-trash"></span>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-----------------MODAL CREAR Empleado--------------------------------------->
        <div class="modal fade" id="modalCrearEmpleado" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background: #2a2a35">
                        <h5 class="modal-title" style="color: white"><span class="fas fa-pencil-alt"></span> Agregar Empleado
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span style="color: white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{route("nuevoEmpleado")}}" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-body" style="object-fit: fill">
                        <div class="form-group">
                            <label for="codigo">Codigo Empleado:</label>
                            <input type="number"
                                   class="form-control @error('unit_price') is-invalid @enderror"
                                   name="codigo" id="codigo" maxlength="30"
                                   value="{{old('codigo')}}" required>
                            @error('unit_price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre Empleado:</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="nombre" id="nombre" maxlength="100"
                                   value="{{old('nombre')}}" required>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" >Crear</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-----------------------------MODA EDITAR EMPLEADO------------------------------------>
        <div class="modal fade" id="modalEditarEmpleado" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background: #2a2a35">
                        <h5 class="modal-title" style="color: white"><span class="fas fa-pencil-alt"></span> Editar Empleado
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span style="color: white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{route("editarempleado")}}" >
                        @method('PUT');
                        @csrf
                        <div class="modal-body" style="object-fit: fill">
                            <div class="form-group">
                                <label for="codigo">codigo Empleado:</label>
                                <input required="required" type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       name="codigo" id="codigo" maxlength="30"
                                       value="{{old('codigo')}}">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message}}</strong>
                            </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="nombre">Nombre Empleado:</label>
                                <input required="required" type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       name="nombre" id="nombre" maxlength="30"
                                       value="{{old('nombre')}}">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message}}</strong>
                            </span>
                                @enderror
                            </div>

                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id" id="id_producto">
                            <button type="submit" class="btn btn-success" >Editar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!--------------------------MODAL BORRAR MARCA----------------------------------->
        <div class="modal fade" id="modalBorrarEmpleado" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <form method="post" action="{{route("borrarEmpleado")}}" enctype="multipart/form-data">
                        @method("DELETE")
                        @csrf
                        <div class="modal-header" style="background: #2a2a35">
                            <h5 class="modal-title" style="color: white"><span class="fas fa-trash"></span> Borrar Empleado
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span style="color: white" aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>¿Estás seguro que deseas borrar el empleado <label
                                    id="nombre"></label>? </p>
                            <p>¡¡¡Todas las entregas realizadas a este usuario seran borradas!!!</p>
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
    <script src="datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="datatables/JSZip-2.5.0/jszip.min.js"></script>
    <script src="datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
    <script src="datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
    <script src="datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="/resources/main.js"></script>

@endsection
