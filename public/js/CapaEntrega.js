$('#modalVistaPreviaCapaEntrega').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var src_imagen = button.data("src_img");

    var modal = $(this);
    modal.find('.modal-body #img').attr("src","/images/productos/"+src_imagen);
});
//Editar modal Producto
$('#modalEditarCapaEntrega').on('show.bs.modal',function (e) {
    var button = $(e.relatedTarget);
    var id_c = button.data('id');
    var empleado = button.data('id_empleado');
    var vitola = button.data('id_vitolas');
    var semilla = button.data('id_semilla');
    var calidad = button.data('id_calidad');
    var id_marca = button.data('id_marca');
    var id_tamano= button.data('id_tamano');
    var total = button.data('total');

    var modal = $(this);
    modal.find('.modal-footer #id_producto').val(id_c);
    modal.find('.modal-body #empleadoEditarcapaentrega').val(empleado).change();
    modal.find('.modal-body #vitolacapaentrega').val(vitola).change();
    modal.find('.modal-body #semillacapaentrega').val(semilla).change();
    modal.find('.modal-body #calidadcapaentrega').val(calidad).change();
    modal.find('.modal-body #totalcapaentrega').val(total);
    modal.find('.modal-body #marcacapaentrega').val(id_marca).change();
    modal.find('.modal-body #tamanocapaentrega').val(id_tamano).change();

});
//Ver Producto
$('#modalVerCapaEntrega').on('show.bs.modal',function (e) {
    var button = $(e.relatedTarget);
    var empleado = button.data('id_empleado');
    var vitola = button.data('id_vitolas');
    var semilla = button.data('id_semillas');
    var calidad = button.data('id_calidad');
    var id_marca = button.data('id_marca');
    var total = button.data('total');

    var modal = $(this);
    modal.find('.modal-body #empleadoNuevocapaentrega').text(empleado);
    modal.find('.modal-body #vitolacapaentrega').text(vitola);
    modal.find('.modal-body #semillacapaentrega').text(semilla);
    modal.find('.modal-body #calidadcapaentrega').text(calidad);
    modal.find('.modal-body #totalcapaentrega').text(total);
    modal.find('.modal-body #marcacapaentrega').text(id_marca);
});

$('#modalBorrarCapaEntrega').on('show.bs.modal', function (e) {
    var button = $(e.relatedTarget);
    var id = button.data('id');

    var modal=$(this);
    modal.find('.modal-footer #id_capa_entrega').val(id);
});








