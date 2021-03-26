$('#modalVistaPreviaCapaEntrega').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var src_imagen = button.data("src_img");

    var modal = $(this);
    modal.find('.modal-body #img').attr("src","/images/productos/"+src_imagen);
});
//Editar modal Producto
$('#modalEditarCapaRecibida').on('show.bs.modal',function (e) {
    var button = $(e.relatedTarget);
    var id_c = button.data('id');
    var tamano = button.data('id_tamano');
    var id_marca = button.data('id_marca');
    var total = button.data('total');

    var modal = $(this);
    modal.find('.modal-footer #id_producto').val(id_c);
    modal.find('.modal-body #tamanocaparecibida').val(tamano).change();
    modal.find('.modal-body #totalcaparecibida').val(total);
    modal.find('.modal-body #marcacaparecibida').val(id_marca).change();
});
//Ver Producto
$('#modalVerCapaCapaRecibida').on('show.bs.modal',function (e) {
    var button = $(e.relatedTarget);
    var tamano = button.data('id_tamano');
    var id_marca = button.data('id_marca');
    var total = button.data('total');

    var modal = $(this);
    modal.find('.modal-body #tamanocaparecibida').text(tamano);
    modal.find('.modal-body #totalcaparecibida').text(total);
    modal.find('.modal-body #marcacaparecibida').text(id_marca);
});

$('#modalBorrarCapaRecibida').on('show.bs.modal', function (e) {
    var button = $(e.relatedTarget);
    var id = button.data('id');

    var modal=$(this);
    modal.find('.modal-footer #id_capa_entrega').val(id);
});








