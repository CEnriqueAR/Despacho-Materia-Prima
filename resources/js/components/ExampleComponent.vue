<template>
    <div class="card">
        <div class="card-header">
            Listado de usuarios
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" @click="abrirModalCrear">
                <i class="fa fa-user-plus"></i>
                Nuevo usuario
            </button>
            <!-- Modal formulario -->
            <div class="modal fade" id="modalForm">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title">
                                <i class="fa fa-user-plus"></i> {{titulo}}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nombre">Nombre del usuario</label>
                                    <input type="text" class="form-control" id="nombre" placeholder="Nombre. Ejemplo (Pepito Pérez)" required="" v-model="datoUsuario.name">
                                </div>
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input type="email" class="form-control" id="email" placeholder="Correo electrónico. Ejemplo (peperez@gmail.com)" required="" v-model="datoUsuario.email">
                                </div>
                                <div class="form-group">
                                    <label for="clave">Contraseña</label>
                                    <input type="password" class="form-control" id="clave" placeholder="Clave mínimo de 8 dígitos." v-model="datoUsuario.password" name="password">
                                </div>
                                <div class="form-group">
                                    <label for="clave">Confirmar contraseña</label>
                                    <input type="password" class="form-control" id="clave" placeholder="Clave mínimo de 8 dígitos." v-model="datoUsuario.password_confirmation" name="password_confirmation">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary" @click.prevent="crear" v-if="btnCrear">Crear usuario</button>
                                <button type="submit" class="btn btn-primary" @click.prevent="editar" v-if="btnEditar">Editar usuario</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal ver detalles -->
            <div class="modal fade" id="modalDetalle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h5 class="modal-title"><i class="fas fa-info-circle"></i> Detalles del usuario</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-striped">
                                    <tbody>
                                    <tr>
                                        <th scope="row">Nombre</th>
                                        <td>{{info.name}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">E-Mail</th>
                                        <td>{{info.email}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Fecha creación</th>
                                        <td>{{$fecha(info.created_at)}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Fecha actualización</th>
                                        <td>{{$fecha(info.updated_at)}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped" id="sampleTable">
                    <thead>
                    <tr>

                        <th>Nombre</th>
                        <th>codigo</th>
                        <th>Puesto</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in usuarios">
                        <td>{{user.id}}</td>
                        <td>{{user.name}}</td>
                        <td>{{user.email}}</td>
                        <td>{{$fecha(user.created_at)}}</td>
                        <td>
                            <button class="btn btn-info btn-sm" type="button" @click="detalles(user)"><i class="fas fa-info-circle"></i> </button>
                            <button class="btn btn-primary btn-sm" type="button" @click="abrirModalEditar(user)"><i class="fas fa-edit"></i> </button>
                            <button class="btn btn-danger btn-sm" type="button" @click="eliminar(user)"><i class="fas fa-trash"></i> </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        mounted() {
            this.getUser()
        },
        data(){
            return {
                usuarios: [],
                info: [],
                datoUsuario: {name:'', email:'', password:'', password_confirmation:''},
                titulo:'',
                btnCrear:false,
                btnEditar:false,
                idUser:''
            }
        },
        methods:{
            getUser(){
                axios.get('listar_usuarios').then(res=>{
                    $('#sampleTable').DataTable().destroy()
                    this.usuarios = res.data
                    this.$tablaGlobal('#sampleTable')
                });
            },
            crear(){
                axios.post('crear_usuarios',this.datoUsuario).then(res=>{
                    this.getUser()
                    $('#modalForm').modal('hide')
                    swal("Felicidades!", "Usuario creado correctamente!", "success");
                }).catch(function (error) {
                    var array = Object.values(error.response.data.errors)
                    array.forEach(element => swal(String(element)))
                });
            },
            abrirModalCrear(){
                this.datoUsuario= {name:'', email:'', password:''}
                this.titulo=' Crear usuario'
                this.btnCrear=true
                this.btnEditar=false
                $('#modalForm').modal('show')
            },
            abrirModalEditar(datos){
                this.datoUsuario= {name: datos.name, email:datos.email}
                this.titulo=' Editar usuario'
                this.btnCrear=false
                this.btnEditar=true
                this.idUser=datos.id
                $('#modalForm').modal('show')
            },
            detalles(datos){
                this.info=datos
                $('#modalDetalle').modal('show')
            },
            editar(){
                axios.put('editar_usuarios/'+this.idUser,this.datoUsuario).then(res=>{
                    this.idUser=''
                    this.getUser()
                    $('#modalForm').modal('hide')
                    swal("Felicidades!", "Usuario editado correctamente!", "success");
                }).catch(function (error) {
                    var array = Object.values(error.response.data.errors)
                    array.forEach(element => swal(String(element)))
                });
            },
            eliminar(datos){
                swal({
                    title: "¿Está seguro de eliminar "+datos.name+"?",
                    text: "Se eliminara permanentemente!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            axios.delete('eliminar_usuarios/'+datos.id).then(res=>{
                                this.getUser()
                                swal("Usuario eliminado correctamente!", {
                                    icon: "success",
                                });
                            }).catch(function (error) {
                                var array = Object.values(error.response.data.errors)
                                array.forEach(element => swal(String(element)))
                            });

                        }
                    });
            }
        }
    }
</script>