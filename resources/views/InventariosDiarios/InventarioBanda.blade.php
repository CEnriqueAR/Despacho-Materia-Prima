@extends("layouts.MenuBanda")
@section("content")
    <div class="container-fluid">
        <h1 class="mt-4">Inventario Diario Banda
            <div class="btn-group" role="group">

                <button class="btn btn-sm btn-success"
                        id="botonAbrirModalNuevoI"
                        data-toggle="modal" data-target="#modalNuevoI">
                    <span class="fas fa-plus"></span> Nueva
                </button>
            </div>


        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page" ><a href="/">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Inventario Diario Banda</li>

                <form  class="d-none d-md-inline-block form-inline
                           ml-auto mr-0 mr-md-2 my-0 my-md-0 mb-md-2">
                    <div class="input-group" style="width: 300px">
                        <input class="form-control" name="fecha" type="date" placeholder="fecha"
                               aria-label="Search">
                        <div class="input-group-append">
                            <a id="borrarBusqueda" class="btn btn-danger hideClearSearch" style="color: white"
                               href="{{route("InventarioBanda")}}">&times;</a>
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </ol>

            <div class="pagination pagination-sm">

                <a class="btn btn-dark hideClearSearch" style="color: white"
                   id="botonAbrirModalNuevoRecepcionCapa"
                   data-toggle="modal" data-target="#modalfechacvs">CVS</a>

                <a class="btn btn-success hideClearSearch" style="color: white"
                   id="botonAbrirModalNuevoRecepcionCapa"
                   data-toggle="modal" data-target="#modalfecha">Excel</a>

                <a class="btn btn-danger hideClearSearch" style="color: white"
                   id="botonAbrirModalNuevoRecepcionCapa"
                   data-toggle="modal" data-target="#modalfechapdf">PDF</a>

                <form  class="d-none d-md-inline-block form-inline
                           ml-auto mr-0 mr-md-2 my-0 my-md-0 mb-md-2">
                    <div class="input-group" style="width: 300px">
                        <input class="form-control" name="search" type="search" placeholder="Search"
                               aria-label="Search">
                        <div class="input-group-append">
                            <a id="borrarBusqueda" class="btn btn-danger hideClearSearch" style="color: white"
                               href="{{route("InventarioBanda")}}">&times;</a>
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
        @if(session("error"))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <span class="fa fa-save"></span> {{session("error")}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>

        @endif

        @if(session("errores"))
            <input type="hidden" id="id_producto" name="id_producto" value="{{session("id_producto")}}">
            <script type="text/javascript">
                var id = document.getElementById("id_producto").value;
                document.onreadystatechange = function n(){
                    if (document.readyState){
                        document.getElementById("editarCapaEntrega"+id).click();
                    }
                }
            </script>
        @endif
        @if($errors->any())

            <script>
                document.onreadystatechange = function n(){
                    if (document.readyState){
                       document.getElementById("botonAbrirModalNuevoI").click();
                    }
                }
            </script>
        @endif

        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Semilla</th>
                <th>Tamanño</th>
                <th>variedad</th>
                <th>Inicial</th>
                <th>Peso</th>
                <th>Entradas</th>
                <th>Peso</th>
                <th>Final</th>
                <th>Peso</th>
                <th>Consumo</th>
                <th>Peso</th>


                <th><span class="fas fa-info-circle"></span></th>
            </tr>
            </thead>
            <tbody>
            @if(!$existenciaDiaria)
                <tr>
                    <td colspan="4" style="align-items: center">No hay productos</td>
                </tr>
            @endif
            @foreach($existenciaDiaria as $productos)
                <tr>
                    <td>{{$noPagina++}}</td>


                    <td>{{$productos->nombre_semillas}}</td>
                    <td>{{$productos->nombre_tamano}}</td>
                    <td>{{$productos->variedad}}</td>
                    <td>{{$productos->totalinicial}}</td>
                    <td>{{$productos->pesoinicial}}</td>
                    <td>{{$productos->totalentrada}}</td>
                    <td>{{$productos->pesoentrada}}</td>
                    <td>{{$productos->totalfinal}}</td>
                    <td>{{$productos->pesofinal}}</td>
                    <td>{{$productos->totalconsumo}}</td>
                    <td>{{$productos->pesoconsumo}}</td>
                    <td>



                        <button class="btn btn-sm btn-info"
                                title="Ver"
                                data-toggle="modal"
                                data-target="#modalVerCapaEntrega"
                                data-semilla="{{$productos->nombre_semillas}}"
                                data-id_tamano="{{$productos->nombre_tamano}}"
                                data-inicial="{{$productos->totalinicial}}"
                                data-pesoinicial="{{$productos->pesoinicial}}"
                                data-totalentrada="{{$productos->totalentrada}}"
                                data-pesoentrada="{{$productos->pesoentrada}}"
                                data-totalfinal="{{$productos->totalfinal}}"
                                data-pesofinal="{{$productos->pesofinal}}"
                                data-totalconsumo="{{$productos->totalconsumo}}"
                                data-pesoconsumo="{{$productos->pesoconsumo}}"
                                data-variedad="{{$productos->variedad}}"

                               >
                            <span class="fas fa-eye"></span>
                        </button>
                        <button class="btn btn-sm btn-success"
                                id="editarCapaEntrega{{$productos->id}}"
                                data-toggle="modal"
                                data-target="#modalEditarCapaEntrega"
                                data-id="{{$productos->id}}"
                                data-id_semilla="{{$productos->id_semillas}}"
                                data-id_tamano="{{$productos->id_tamano}}"
                                data-totalinicial="{{$productos->totalinicial}}"
                                data-totalentrada="{{$productos->totalentrada}}"
                                data-totalfinal="{{$productos->totalfinal}}"
                                data-pesoconsumo="{{$productos->pesoconsumo}}"
                                data-totalconsumo="{{$productos->totalconsumo}}"
                                data-pesoinicial="{{$productos->pesoinicial}}"
                                data-pesoentrada="{{$productos->pesoentrada}}"
                                data-pesofinal="{{$productos->pesofinal}}"
                                data-variedad="{{$productos->variedad}}"

                                title="Editar">
                            <span class="fas fa-pencil-alt"></span>
                        </button>
                        <button class="btn btn-sm btn-danger"
                                title="Borrar"
                                data-toggle="modal"
                                data-target="#modalBorrarReBulDiario"
                                data-id="{{$productos->id}}">
                            <span class="fas fa-trash"></span>
                        </button>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>

    </div>
    <!-----vista previa imagen------->
    <!----------------------------------------------------MODAL NUEVO PRODUCTO------------------------------------------------------->
    <div class="modal fade" id="modalNuevoI" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #2a2a35">
                    <h5 class="modal-title" style="color: white"><span class="fas fa-plus"></span> Agregar
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white">&times;</span>
                    </button>
                </div>
                <form id="nuevoP" method="POST" action="{{route("InventarioBandanuevo")}}" enctype="multipart/form-data">

                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <input class="form-control @error('onzas') is-invalid @enderror" name="fecha" id="fecha" maxlength="100"
                                   value="{{ old('fecha')}}" type="date" required="required">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="id_semillas">Seleccione la Semilla</label>
                            <br>
                            <select name="id_semillas"
                                    style="width: 85%" required="required"
                                    class="marca form-control @error('id_marca') is-invalid @enderror" id="id_semillas">
                                <option disabled selected value="s">Seleccione</option>
                                @foreach($semilla as $semillas)
                                    <option value="{{$semillas->id}}" @if(Request::old('id_semillas')==$semillas->id){{'selected'}}@endif
                                    @if(session("idMarca"))
                                        {{session("idMarca")==$semillas->id ? 'selected="selected"':''}}
                                        @endif>{{$semillas->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="variedadcapaentrega">variedad
                            </label>
                            <br>
                            <select name="variedad"
                                    required="required"
                                    style="width: 85%"
                                    class="disponible form-control
                            @error('disponible') is-invalid @enderror" id="variedadcapaentrega">
                                <option disabled selected value="s">Seleccione</option>
                                <option value="seco"@if(Request::old('variedad')=='seco'){{'selected'}}@endif>seco </option>
                                <option value="viso"@if(Request::old('variedad')=='viso'){{'selected'}}@endif>viso </option>
                            </select>
                            <!---- Boton para crear un nuevo tipo de categoria- -->
                        </div>
                        <div class="form-group">
                            <label for="id_calidad">Seleccione la Calidad</label>
                            <br>
                            <select name="id_calidad"
                                    style="width: 85%" required="required"
                                    class="marca form-control @error('id_marca') is-invalid @enderror" id="id_calidad">
                                <option disabled selected value="s">Seleccione</option>
                                @foreach($calidad as $calidades)
                                    <option value="{{$calidades->id}}" @if(Request::old('id_calidad')==$calidades->id){{'selected'}}@endif
                                    @if(session("idMarca"))
                                        {{session("idMarca")==$calidades->id ? 'selected="selected"':''}}
                                        @endif>{{$calidades->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_tamano">Seleccione el Tamaño</label>
                            <br>
                            <select name="id_tamano"
                                    style="width: 85%" required="required"
                                    class="marca form-control @error('id_marca') is-invalid @enderror" id="id_tamano">
                                <option disabled selected value="s">Seleccione</option>
                                @foreach($tamano as $tamanos)
                                    <option value="{{$tamanos->id}}" @if(Request::old('id_tamano')==$tamanos->id){{'selected'}}@endif
                                    @if(session("idMarca"))
                                        {{session("idMarca")==$tamanos->id ? 'selected="selected"':''}}
                                        @endif>{{$tamanos->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">

                        <label for="totalinicial">Inventario Inicial </label>
                        <input class="form-control @error('name') is-invalid @enderror" name="totalinicial" id="totalinicial" maxlength="100"
                               value="{{ old('totalinicial')}}" required="required">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                        </div>
                        <div class="form-group">
                            <label for="pesoinicialdiario">Peso Inicial </label>
                            <input class="form-control @error('name')
                                is-invalid @enderror" name="pesoinicial" id="pesoinicialdiario" maxlength="100"
                                   value="{{ old('pesoinicial')}}" required="required">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>


                        <div class="form-group">


                            <label for="totalentrada">Entradas </label>
                            <input class="form-control @error('name') is-invalid @enderror" name="totalentrada" id="totalentrada" maxlength="100"
                                   value="{{ old('totalentrada')}}" required="required">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">

                            <label for="pesoentradadiario">Peso Entrada </label>
                            <input class="form-control @error('name') is-invalid @enderror" name="pesoentrada" id="pesoentradadiario" maxlength="100"
                                   value="{{ old('pesoentrada')}}" required="required">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>


                        <div class="form-group">

                            <label for="totalfinal">Inventario Final </label>
                            <input class="form-control @error('name') is-invalid @enderror" name="totalfinal" id="totalfinal" maxlength="100"
                                   value="{{ old('totalfinal')}}" required="required">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">

                            <label for="pesofinaldiario">Peso Final </label>
                            <input class="form-control @error('name') is-invalid @enderror" name="pesofinal" id="pesofinaldiario" maxlength="100"
                                   value="{{ old('pesofinal')}}" required="required">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                    </div>


                    <div class="modal-footer">
                        <button type="submit" id="nuevoP" class="btn btn-success">Crear</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-----------------------------MODAL EDITAR PRODUCTO------------------------------->
    <div class="modal fade" id="modalEditarCapaEntrega" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #2a2a35">
                    <h5 class="modal-title" style="color: white"><span class="fas fa-plus"></span> Editar Entrega
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white">&times;</span>
                    </button>
                </div>
                <form id="nuevoP" method="POST" action="{{route("InventarioBandaeditar")}}" >
                    @method("PUT")

                    @csrf
                    <div class="modal-body">


                        <div class="form-group">
                            <label for="semillacapaentrega">Seleccione la Semilla</label>
                            <br>
                            <select name="id_semillas"
                                    required
                                    style="width: 85%"
                                    class="select2 form-control @error('id_empresa') is-invalid @enderror"
                                    id="semillacapaentrega" required="required">
                                <option disabled selected value="">Seleccione</option>
                                @foreach($semilla as $semillas)
                                    <option value="{{$semillas->id}}">{{$semillas->name}}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_empresa')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="variedadcapaentrega">variedad
                            </label>
                            <br>
                            <select name="variedad"
                                    required="required"
                                    style="width: 85%"
                                    class="disponible form-control
                            @error('disponible') is-invalid @enderror" id="variedadcapaentrega">
                                <option disabled selected value="s">Seleccione</option>
                                <option value="seco"@if(Request::old('variedad')=='seco'){{'selected'}}@endif>seco </option>
                                <option value="viso"@if(Request::old('variedad')=='viso'){{'selected'}}@endif>viso </option>
                            </select>
                            <!---- Boton para crear un nuevo tipo de categoria- -->
                        </div>



                        <div class="form-group">
                            <label for="tamanocapaentrega">Seleccione el tamaño </label>
                            <br>
                            <select name="id_tamano"
                                    style="width: 85%"
                                    class="TipoCategoria form-control @error('id_marca') is-invalid @enderror"
                                    id="tamanocapaentrega" required="required">
                                <option disabled selected value="">Seleccione</option>
                                @foreach($tamano as $tamanos)
                                    <option value="{{$tamanos->id}}">{{$tamanos->name}}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_marca')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-row">

                            <label for="totalinicialdiario">Inentario Inicial</label>
                            <input  class="form-control @error('name') is-invalid @enderror"
                                    name="totalinicial" id="totalinicialdiario" maxlength="100" value="{{old('totalinicial')}}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-row">

                            <label for="pesoinicialdiario">Peso Inicial</label>
                            <input  class="form-control @error('name') is-invalid @enderror"
                                    name="pesoinicial" id="pesoinicialdiario" maxlength="100" value="{{old('pesoinicial')}}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror

                        </div>

                        <div class="form-row">
                            <label for="totalentradadiario">Entradas</label>
                            <input  class="form-control @error('name') is-invalid @enderror"
                                    name="totalentrada" id="totalentradadiario" maxlength="100" value="{{old('totalentradaE')}}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror



                        </div>

                        <div class="form-row">

                            <label for="pesoentradadiario">Peso Entrada</label>
                            <input  class="form-control @error('name') is-invalid @enderror"
                                    name="pesoentrada" id="pesoentradadiario" maxlength="100" value="{{old('pesoentrada')}}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror

                        </div>
                        <div class="form-row">

                            <label for="totalfinaldiario">Inventario Final</label>
                            <input  class="form-control @error('name') is-invalid @enderror"
                                    name="totalfinal" id="totalfinaldiario" maxlength="100" value="{{old('totalfinal')}}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                    </div>

                        <div class="form-row">

                            <label for="pesofinaldiario">Peso Final</label>
                            <input  class="form-control @error('name') is-invalid @enderror"
                                    name="pesofinal" id="pesofinaldiario" maxlength="100" value="{{old('pesofinal')}}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror

                        </div>
                    </div>
                    <div class="modal-footer">
                        <input id="id_producto" name="id" type="hidden" >
                        <button type="submit" class="btn btn-success" id="id_producto" onclick="f()">Editar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>




    <!------------------MODAL BORRAR PRODUCTO---------------------------->
    <div class="modal fade" id="modalBorrarReBulDiario" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <form method="post" action="{{route("InventarioBandaborrar")}}" >
                    @method("DELETE")
                    @csrf
                    <div class="modal-header" style="background: #2a2a35">
                        <h5 class="modal-title" style="color: white"><span class="fas fa-trash"></span> Borrar Salida
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span style="color: white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro que deseas borrar esta entrads <label
                                id="nombreProducto"></label>?</p>

                    </div>
                    <div class="modal-footer">
                        <input id="id_capa_entrega" name="id" type="hidden" value="">
                        <button type="submit" class="btn btn-danger">Borrar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!----------------------------------------------------MODAL fecha Exportar Excel------------------------------------------------------->

    <div class="modal fade" id="modalfecha" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #2a2a35">
                    <h5 class="modal-title" style="color: white"><span class="fas fa-plus"></span> Exportar EXCEL
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white">&times;</span>
                    </button>
                </div>
                <form id="nuevoP" method="POST" action="{{route("exportarInventarioBanda")}}" enctype="multipart/form-data">

                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="fecha1">Fecha</label>
                            <input class="form-control @error('name') is-invalid @enderror" name="fecha1" id="fecha1"
                                   type="datetime-local"
                                   value="{{ old('fecha1')}}" >
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="nuevoP" class="btn btn-success">Exportar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!----------------------------------------------------MODAL fecha Exportar PDF------------------------------------------------------->

    <div class="modal fade" id="modalfechapdf" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #2a2a35">
                    <h5 class="modal-title" style="color: white"><span class="fas fa-plus"></span> Exportar PDF
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white">&times;</span>
                    </button>
                </div>
                <form id="nuevoP" method="POST" action="{{route("exportarInventarioBandapdf")}}" enctype="multipart/form-data">

                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="fecha1">Fecha</label>
                            <input class="form-control @error('name') is-invalid @enderror" name="fecha1" id="fecha1"
                                   type="datetime-local"
                                   value="{{ old('fecha1')}}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="nuevoP" class="btn btn-success">Exportar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!----------------------------------------------------MODAL fecha Exportar CVS------------------------------------------------------->
    <div class="modal fade" id="modalfechacvs" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #2a2a35">
                    <h5 class="modal-title" style="color: white"><span class="fas fa-plus"></span> Exportar CVS
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white">&times;</span>
                    </button>
                </div>
                <form id="nuevoP" method="POST" action="{{route("exportarInventarioBandacvs")}}" enctype="multipart/form-data">

                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="fecha1">Fecha</label>
                            <input class="form-control @error('name') is-invalid @enderror" name="fecha1" id="fecha1"
                                   type="datetime-local"
                                   value="{{ old('fecha1')}}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="nuevoP" class="btn btn-success">Exportar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-------------------MODAL sumar 75------------------------------>


    <!-------------------MODAL NUEVO CATEGORIA------------------------------>

    {{-- <div class="modal fade" id="modalNuevaCategoria" tabindex="-1" role="dialog">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header" style="background: #2a2a35">
                     <h5 class="modal-title" style="color: white"><span class="fas fa-plus"></span> Agregar Categoría
                     </h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true" style="color: white">&times;</span>
                     </button>
                 </div>
                 <form method="POST" action="{{route("CapaEntrega")}}" enctype="multipart/form-data">

                     @csrf
                     <div class="modal-body">
                         <div class="form-group">
                             <label for="nombreNuevaCategoria">Nombre de categoria</label>
                             <input required class="form-control" name="name"
                                    id="nombreNuevaCategoria" maxlength="100">
                         </div>
                         <div class="form-group">
                             <label for="tipoNuevaCategoria">Seleccione el tipo de Categoria

                             </label>
                             <br>
                             <select name="id_categoria"
                                     required
                                     style="width: 85%"
                                     class="empresa2 form-control" id="tipoNuevaCategoria">
                                 <option disabled selected value="">Seleccione</option>
                                 @foreach($calidad as $calidad)
                                     <option value="{{$calidad->id}}" @if(session("idNuevaCategoria"))
                                         {{session("idNuevaCategoria") == $tipoCategoria->id ? 'selected="selected"':''}}
                                         @endif>{{$calidad->name}}</option>
                                 @endforeach
                             </select>
                             <!---- Boton para crear un nuevo tipo de categoria- -->

                         </div>
                         <div class="form-group">
                             <label for="descripcionNuevaCategoria">Descripción de nueva categoria (Opcional):</label>
                             <textarea class="form-control"
                                       name="descripcion"
                                       id="descripcionNuevaCategoria"
                                       maxlength="192"></textarea>
                         </div>
                         <label for="imagenCategoria">Seleccione una imagen (opcional): </label>
                         <div class="input-group image-preview">

                             <input type="text" name="imagen_url" class="form-control image-preview-filename"
                                    disabled="disabled">
                             <!-- don't give a name === doesn't send on POST/GET -->
                             <span class="input-group-btn">
                                 <!-- image-preview-clear button -->
                                 <button type="button" class="btn btn-outline-danger image-preview-clear"
                                         style="display:none;">
                                     <span class="fas fa-times"></span> Clear
                                 </button>
                                 <!-- image-preview-input -->
                                 <div class="btn btn-default image-preview-input">
                                     <span class="fas fa-folder-open"></span>
                                     <span class="image-preview-input-title">Seleccionar</span>
                                     <input type="file" accept="image/png, image/jpeg, image/gif"
                                            name="imagen_url"/>
                                     <!-- rename it -->
                                 </div>
                             </span>
                         </div><!-- /input-group image-preview [TO HERE]-->
                     </div>
                     <div class="modal-footer">
                         <button type="submit" class="btn btn-success" >Crear</button>
                         <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                     </div>
                 </form>

             </div>
         </div>
     </div>




--}}


     <style>

         .image-preview-input {
             position: relative;
             overflow: hidden;
             margin: 0px;
             color: #333;
             background-color: #fff;
             border-color: #ccc;
         }
         .image-preview-input input[type=file] {
             position: absolute;
             top: 0;
             right: 0;
             margin: 0;
             padding: 0;
             font-size: 20px;
             cursor: pointer;
             opacity: 0;
             filter: alpha(opacity=0);
         }
         .image-preview-input-title {
             margin-left: 2px;
         }
         .image-border{
             border: black 1px solid;
             padding: 3px;
             justify-content: center;
             align-items: center;
         }
         .transparent-input{
             background-color:rgba(0,0,0,0) !important;
             border:none !important;
             padding-left: 5px;
         }
         .modal-lg {
             max-width: 45% !important;
         }

     </style>



 @endsection
