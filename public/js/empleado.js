$('#modalBorrarEmpleado').on('show.bs.modal', function (e) {
    var button = $(e.relatedTarget);
    var id = button.data('id');
    var codigo = button.data('codigo');
    var nombre= button.data('nombre');
    var puesto = button.data('puesto');

    var modal=$(this);
    modal.find('.modal-footer #id').val(id);
    modal.find('.modal-body #codigo').val(codigo);
    modal.find('.modal-body #nombre').val(nombre);
    modal.find('.modal-body #puesto').val(puesto);
});
$('#modalEditarEmpleado').on('show.bs.modal', function (e) {
    var button = $(e.relatedTarget);
    var id = button.data('id');
    var codigo = button.data('codigo');
    var nombre = button.data('nombre');
    var puesto = button.data('puesto');
    var modal=$(this);

    modal.find('.modal-footer #id_producto').val(id);
    modal.find('.modal-body #codigo').val(codigo);
    modal.find('.modal-body #nombre').val(nombre);
    modal.find('.modal-body #puesto').val(puesto);

});
