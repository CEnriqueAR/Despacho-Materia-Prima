@extends("layouts.Menu")
@section("content")
    <div class="container-fluid">
        <h1 class="mt-4">Entrega De Capa A los Salones
            <div class="btn-group" role="group">

                <button class="btn btn-sm btn-success"
                        id="botonAbrirModalNuevoCapaEntrega"
                        data-toggle="modal" data-target="#modalNuevoCapaEntrega">
                    <span class="fas fa-plus"></span> Nueva
                </button>
            </div>

        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page" ><a href="/">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Entrega De Capa</li>

                <form  class="d-none d-md-inline-block form-inline
                           ml-auto mr-0 mr-md-2 my-0 my-md-0 mb-md-2">
                    <div class="input-group" style="width: 300px">
                        <input class="form-control" name="fecha" type="date" placeholder="fecha"
                               aria-label="Search">
                        <div class="input-group-append">
                            <a id="borrarBusqueda" class="btn btn-danger hideClearSearch" style="color: white"
                               href="{{route("CapaEntrega")}}">&times;</a>
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
                               href="{{route("CapaEntrega")}}">&times;</a>
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
                       document.getElementById("botonAbrirModalNuevoCapaEntrega").click();
                    }
                }
            </script>
        @endif

        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Empleado</th>
                <th>Marca</th>
                <th>Vitola</th>
                <th>Semilla</th>
                <th>Calidad</th>
                <th>Tamaño</th>
                <th>total</th>



                <th><span class="fas fa-info-circle"></span></th>
            </tr>
            </thead>
            <tbody>
            @if(!$entregaCapa)
                <tr>
                    <td colspan="4" style="align-items: center">No hay productos</td>
                </tr>
            @endif
            @foreach($entregaCapa as $productos)
                <tr>
                    <td>{{$noPagina++}}</td>


                    <td>{{$productos->nombre_empleado}}</td>
                    <td>{{$productos->nombre_marca}}</td>
                    <td>{{$productos->nombre_vitolas}}</td>
                    <td>{{$productos->nombre_semillas}}</td>
                    <td>{{$productos->nombre_calidads}}</td>
                    <td>{{$productos->nombre_tamano}}</td>
                    <td>{{$productos->total}}</td>
                    <td>
                        <button class="btn btn-sm btn-info"
                                title="Ver"
                                data-toggle="modal"
                                data-target="#modalVerCapaEntrega"
                                data-id_empleado="{{$productos->nombre_empleado}}"
                                data-id_marca="{{$productos->nombre_marca}}"
                                data-id_vitolas="{{$productos->nombre_vitolas}}"
                                data-id_semillas="{{$productos->nombre_semillas}}"
                                data-id_calidad="{{$productos->nombre_calidads}}"
                                data-id_tamano="{{$productos->nombre_tamano}}"
                                data-total="{{$productos->total}}">
                            <span class="fas fa-eye"></span>
                        </button>
                        <button class="btn btn-sm btn-success"
                                id="editarCapaEntrega{{$productos->id}}"
                                data-toggle="modal"
                                data-target="#modalEditarCapaEntrega"
                                data-id="{{$productos->id}}"
                                data-id_empleado="{{$productos->id_empleado}}"
                                data-id_marca="{{$productos->id_marca}}"
                                data-id_vitolas="{{$productos->id_vitolas}}"
                                data-id_semilla="{{$productos->id_semilla}}"
                                data-id_calidad="{{$productos->id_calidad}}"
                                data-id_tamano="{{$productos->id_tamano}}"
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
    <div class="modal fade" id="modalNuevoCapaEntrega" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #2a2a35">
                    <h5 class="modal-title" style="color: white"><span class="fas fa-plus"></span> Agregar Salida De Capa
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white">&times;</span>
                    </button>
                </div>
                <form id="nuevoP" method="POST" action="{{route("nuevoCapaEntrega")}}" enctype="multipart/form-data">

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
                            <label for="empleadoEditarcapaentrega">Seleccione Empleado</label>
                            <br>
                            <select name="id_empleado"
                                    style="width: 85%" required="required"
                                    class="marca form-control @error('id_marca') is-invalid @enderror" id="empleadoEditarcapaentrega">
                                <option disabled selected value="s">Seleccione</option>
                                @foreach($empleados as $empleado)
                                    <option value="{{$empleado->id}}" @if(Request::old('id_empleado')==$empleado->id){{'selected'}}@endif
                                    @if(session("idMarca"))
                                        {{session("idMarca")==$empleado->id ? 'selected="selected"':''}}
                                            @endif>{{$empleado->nombre}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="id_marca">Seleccione la marca</label>
                            <br>
                            <select name="id_marca"
                                    style="width: 85%" required="required"
                                    class="marca form-control @error('id_marca') is-invalid @enderror" id="marca">
                                <option disabled selected value="s">Seleccione</option>
                                @foreach($marca as $marcas)
                                    <option value="{{$marcas->id}}" @if(Request::old('id_marca')==$marcas->id){{'selected'}}@endif
                                    @if(session("idMarca"))
                                        {{session("idMarca")==$marcas->id ? 'selected="selected"':''}}
                                            @endif>{{$marcas->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="vitolacapaentrega">Seleccione la Vitola</label>
                            <br>
                            <select name="id_vitolas"
                                    style="width: 85%" required="required"
                                    class="marca form-control @error('id_marca') is-invalid @enderror" id="vitolacapaentrega">
                                <option disabled selected value="s">Seleccione</option>
                                @foreach($vitola as $vitolas)
                                    <option value="{{$vitolas->id}}" @if(Request::old('id_vitolas')==$vitolas->id){{'selected'}}@endif
                                    @if(session("idMarca"))
                                        {{session("idMarca")==$vitolas->id ? 'selected="selected"':''}}
                                            @endif>{{$vitolas->name}}
                                    </option>
                                @endforeach
                            </select>
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
                                        {{session("idMarca")==$tamanos->id ? 'selected="selected"':''}}
                                            @endif>{{$tamanos->name}}
                                    </option>
                                @endforeach
                            </select>
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
                            <label for="id_semilla">Seleccione la Semilla</label>
                            <br>
                            <select name="id_semilla"
                                    style="width: 85%" required="required"
                                    class="marca form-control @error('id_marca') is-invalid @enderror" id="id_semilla">
                                <option disabled selected value="s">Seleccione</option>
                                @foreach($semillas as $semilla)
                                    <option value="{{$semilla->id}}" @if(Request::old('id_semilla')==$semilla->id){{'selected'}}@endif
                                    @if(session("idMarca"))
                                        {{session("id_semilla")==$semilla->id ? 'selected="selected"':''}}
                                            @endif>{{$semilla->name}}
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
                <form id="nuevoP" method="POST" action="{{route("editarCapaEntrega")}}" >
                    @method("PUT")

                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="totalcapaentrega">Total</label>
                            <input  class="form-control @error('name') is-invalid @enderror"
                                    name="total" id="totalcapaentrega" maxlength="100" value="{{old('total')}}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="empleadoEditarcapaentrega">Seleccione el Empleado:
                            </label>
                            <br>
                            <select name="id_empleado"
                                    required="required"
                                    style="width: 85%"
                                    class="TipoCategoria form-control @error('id_categoria') is-invalid @enderror"
                                    id="empleadoEditarcapaentrega" >
                                <option disabled selected value="">Seleccione</option>
                                @foreach($empleados as $empleado)
                                    <option value="{{$empleado->id}}">{{$empleado->nombre}}</option>
                                @endforeach
                            </select>
                            <!---- Boton para crear un nuevo tipo de categoria- -->
                        </div>
                        <div class="form-group">
                            <label for="vitolacapaentrega">Seleccione la vitola</label>
                            <br>
                            <select name="id_vitolas"
                                    required
                                    style="width: 85%"
                                    class="select2 form-control @error('id_empresa') is-invalid @enderror"
                                    id="vitolacapaentrega" required="required">
                                <option disabled selected value="">Seleccione</option>
                                @foreach($vitola as $vitolas)
                                    <option value="{{$vitolas->id}}">{{$vitolas->name}}
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
                            <label for="calidadcapaentrega">Seleccione la calidad</label>
                            <br>
                            <select name="id_calidad"
                                    style="width: 85%"
                                    class=" TipoCategoria form-control @error('id_calidad') is-invalid @enderror"
                                    id="calidadcapaentrega" required="required">
                                <option disabled selected value="">Seleccione</option>
                                @foreach($calidad as $calidades)
                                    <option value="{{$calidades->id}}">{{$calidades->name}}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_calidad')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="id_tamano">Seleccione el Tamaño</label>
                            <br>
                            <select name="id_tamano"
                                    style="width: 85%"
                                    class=" TipoCategoria form-control @error('id_marca') is-invalid @enderror"
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

                        <div class="form-group">
                            <label for="marcacapaentrega">Seleccione la marca</label>
                            <br>
                            <select name="id_marca"
                                    style="width: 85%"
                                    class="TipoCategoria form-control @error('id_marca') is-invalid @enderror"
                                    id="marcacapaentrega" required="required">
                                <option disabled selected value="">Seleccione</option>
                                @foreach($marca as $marca)
                                    <option value="{{$marca->id}}">{{$marca->name}}
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
                        <input id="id_producto" name="id" type="hidden" >
                        <button type="submit" class="btn btn-success" id="id_producto" onclick="f()">Editar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!------------------MODAL VER PRODUCTO-------------------------------->
    <div class="modal fade" id="modalVerCapaEntrega" tabindex="-1" role="dialog">
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
                                <div class="col-sm-6"><label for="empleadoNuevocapaentrega"><strong>Empleado:</strong></label></div>
                                <div class="col-sm-2"><label for="marca" id="empleadoNuevocapaentrega"></label></div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6"><label for="marcacapaentrega"><strong>Marca:</strong></label></div>
                                <div class="col-sm-2"><label for="marca" id="marcacapaentrega"></label></div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6"><label for="vitolacapaentrega"><strong>Vitola:</strong></label></div>
                                <div class="col-sm-2"><label for="precioLoteProducto" id="vitolacapaentrega"></label></div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6"><label for="semillacapaentrega"><strong>Semilla:</strong></label></div>
                                <div class="col-sm-2"><label for="tipoNuevaCategoria" id="semillacapaentrega"></label></div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6"><label for="calidadcapaentrega"><strong>Calidad:</strong></label></div>
                                <div class="col-sm-4"><label for="empresa" id="calidadcapaentrega"></label></div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6"><label for="totalcapaentrega"><strong>Total Entregado:</strong></label></div>
                                <div class="col-sm-2"><label for="disponible" id="totalcapaentrega"></label></div>
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
    <div class="modal fade" id="modalBorrarCapaEntrega" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <form method="post" action="{{route("borrarCapaEntrega")}}" >
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
