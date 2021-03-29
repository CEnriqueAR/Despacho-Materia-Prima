@extends("layouts.Menu")
@section("content")
    <div class="container-fluid">
        <h1 class="mt-4">Recepcion de Capa
            <div class="btn-group" role="group">

                <button class="btn btn-sm btn-success"
                        id="botonAbrirModalNuevoRecepcionCapa"
                        data-toggle="modal" data-target="#modalNuevoRecepcionCapa">
                    <span class="fas fa-plus"></span> Nueva
                </button>
            </div>

        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page" ><a href="/">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Recepcion De Capa</li>

                <form  class="d-none d-md-inline-block form-inline
                           ml-auto mr-0 mr-md-2 my-0 my-md-0 mb-md-2">
                    <div class="input-group" style="width: 300px">
                        <input class="form-control" name="fecha" type="date" placeholder="fecha"
                               aria-label="Search">
                        <div class="input-group-append">
                            <a id="borrarBusqueda" class="btn btn-danger hideClearSearch" style="color: white"
                               href="{{route("RecepcionCapa")}}">&times;</a>
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </ol>
            <div class="pagination pagination-sm">

                <form  class="d-none d-md-inline-block form-inline
                           ml-auto mr-0 mr-md-2 my-0 my-md-0 mb-md-2">
                    <div class="input-group" style="width: 300px">
                        <input class="form-control" name="search" type="search" placeholder="Search"
                               aria-label="Search">
                        <div class="input-group-append">
                            <a id="borrarBusqueda" class="btn btn-danger hideClearSearch" style="color: white"
                               href="{{route("RecepcionCapa")}}">&times;</a>
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
                        document.getElementById("editarRecepcionCapa"+id).click();
                    }
                }
            </script>
        @endif
        @if($errors->any())

            <script>
                document.onreadystatechange = function n(){
                    if (document.readyState){
                       document.getElementById("botonAbrirModalNuevoRecepcionCapa").click();
                    }
                }
            </script>
        @endif

        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Semilla</th>
                <th>Tamaño</th>
                <th>Calidad</th>
                <th>total</th>



                <th><span class="fas fa-info-circle"></span></th>
            </tr>
            </thead>
            <tbody>
            @if(!$recibirCapa)
                <tr>
                    <td colspan="4" style="align-items: center">No hay productos</td>
                </tr>
            @endif
            @foreach($recibirCapa as $productos)
                <tr>
                    <td>{{$noPagina++}}</td>
                    <td>{{$productos->nombre_semillas}}</td>
                    <td>{{$productos->nombre_tamano}}</td>
                    <td>{{$productos->nombre_calidad}}</td>

                    <td>{{$productos->total}}</td>
                    <td>
                        <button class="btn btn-sm btn-info"
                                title="Ver"
                                data-toggle="modal"
                                data-target="#modalVerCapaCapaRecibida"

                                data-id_semillas="{{$productos->nombre_semillas}}"
                                data-id_calidad="{{$productos->nombre_calidad}}"
                                data-id_tamano="{{$productos->nombre_tamano}}"

                                data-total="{{$productos->total}}">
                            <span class="fas fa-eye"></span>
                        </button>
                        <button class="btn btn-sm btn-success"
                                id="editarCapaEntrega{{$productos->id}}"
                                data-toggle="modal"
                                data-target="#modalEditarCapaRecibida"
                                data-id="{{$productos->id}}"
                                data-id_semilla="{{$productos->nombre_semillas}}"
                                data-id_calidad="{{$productos->nombre_calidad}}"
                                data-id_tamano="{{$productos->nombre_tamano}}"
                                data-total="{{$productos->total}}"
                                title="Editar">
                            <span class="fas fa-pencil-alt"></span>
                        </button>
                        <button class="btn btn-sm btn-danger"
                                title="Borrar"
                                data-toggle="modal"
                                data-target="#modalBorrarCapaEntrega"
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
    <div class="modal fade" id="modalNuevoRecepcionCapa" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #2a2a35">
                    <h5 class="modal-title" style="color: white"><span class="fas fa-plus"></span> Agregar Salida De Capa
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white">&times;</span>
                    </button>
                </div>
                <form id="nuevoP" method="POST" action="{{route("nuevaRecepcionCapa")}}" enctype="multipart/form-data">

                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombreNuevoProducto">Total</label>
                            <input class="form-control @error('name') is-invalid @enderror" name="total" id="nombreNuevoProducto" maxlength="100"
                                   value="{{ old('total')}}" required="required">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="id_tamano">Seleccione el tamaño</label>
                            <br>
                            <select name="id_tamano"
                                    style="width: 85%" required="required"
                                    class="marca form-control @error('id_marca') is-invalid @enderror" id="id_tamano">
                                <option disabled selected value="s">Seleccione</option>
                                @foreach($tamano as $tamanos)
                                    <option value="{{$tamanos->id}}" @if(Request::old('id_tamano')==$tamanos->id){{'selected'}}@endif
                                    @if(session("idMarca"))
                                        {{session("idSemilla")==$tamanos->id ? 'selected="selected"':''}}
                                            @endif>{{$tamanos->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">

                            <label for="id_semillas">Seleccione la Semilla</label>
                            <br>
                            <select name="id_semillas"
                                    style="width: 85%" required="required"
                                    class="marca form-control @error('id_marca') is-invalid @enderror" id="id_semillas">
                                <option disabled selected value="s">Seleccione</option>
                                @foreach($semillas as $semilla)
                                    <option value="{{$semilla->id}}" @if(Request::old('id_semillas')==$semilla->id){{'selected'}}@endif
                                    @if(session("idMarca"))
                                        {{session("id_semillas")==$semilla->id ? 'selected="selected"':''}}
                                            @endif>{{$semilla->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">

                            <label for="id_calidad">Seleccione la Semilla</label>
                            <br>
                            <select name="id_calidad"
                                    style="width: 85%" required="required"
                                    class="marca form-control @error('id_marca') is-invalid @enderror" id="id_calidad">
                                <option disabled selected value="s">Seleccione</option>
                                @foreach($calidad as $calidades)
                                    <option value="{{$calidades->id}}" @if(Request::old('id_calidad')==$calidades->id){{'selected'}}@endif
                                    @if(session("idMarca"))
                                        {{session("id_calidad")==$calidades->id ? 'selected="selected"':''}}
                                            @endif>{{$calidades->name}}
                                    </option>
                                @endforeach
                            </select>
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
    <div class="modal fade" id="modalEditarCapaRecibida" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #2a2a35">
                    <h5 class="modal-title" style="color: white"><span class="fas fa-pencil-alt"></span> Editar Capar Recibida
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span style="color: white" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{route("editarRecepcionCapa")}}">
                    @method('PUT');
                    @csrf
                    <div class="modal-body" style="object-fit: fill">


                        <div class="form-group">
                            <label for="totalcaparecibida">Total</label>
                            <input  class="form-control @error('name') is-invalid @enderror"
                                    name="total" id="totalcaparecibida" maxlength="100" value="{{old('total')}}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="semillacapaentrega">Seleccione la semilla</label>
                            <br>
                            <select name="id_semilla"
                                    required
                                    style="width: 85%"
                                    class="TipoCategoria form-control @error('id_semilla') is-invalid @enderror"
                                    id="semillacapaentrega" required="required">
                                <option disabled selected value="">Seleccione</option>
                                @foreach($semillas as $semillas)
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
                            <label for="calidadcaparecibida">Seleccione la calidad</label>
                            <br>
                            <select name="id_calidad"
                                    style="width: 85%"
                                    class=" empresa2 form-control @error('id_marca') is-invalid @enderror"
                                    id="calidadcaparecibida" required="required">
                                <option disabled selected value="">Seleccione</option>
                                @foreach($calidad as $calidades)
                                    <option value="{{$calidades->id}}">{{$calidades->name}}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_marca')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
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

    <!------------------MODAL VER PRODUCTO-------------------------------->
    <div class="modal fade" id="modalVerCapaCapaRecibida" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #2a2a35">
                    <h5 class="modal-title" style="color: white"><span class="fas fa-plus"></span> Detalle del Producto
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white">&times;</span>
                    </button>
                </div>
                    @include('Alerts.errors')

                    @csrf
                    <div class="modal-body row" >


                        <div class="col-sm-10 card">
                            <div class="form-group row">
                                <div class="col-sm-6"><label for="tamanocaparecibida"><strong>Tamaño:</strong></label></div>
                                <div class="col-sm-2"><label for="tamanocaparecibida" id="tamanocaparecibida"></label></div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6"><label for="semillacaparecibida"><strong>Semilla:</strong></label></div>
                                <div class="col-sm-2"><label for="semillacaparecibida" id="semillacaparecibida"></label></div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6"><label for="calidadcaparecibida"><strong>Calidad:</strong></label></div>
                                <div class="col-sm-4"><label for="empresa" id="calidadcaparecibida"></label></div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6"><label for="totalcaparecibida"><strong>Total Recibido:</strong></label></div>
                                <div class="col-sm-2"><label for="disponible" id="totalcaparecibida"></label></div>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-success">Aceptar</button>
                    </div>
            </div>
        </div>
    </div>


    <!------------------MODAL BORRAR PRODUCTO---------------------------->
    <div class="modal fade" id="modalBorrarCapaRecibida" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <form method="post" action="{{route("borrarRecepcionCapa")}}" >
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
