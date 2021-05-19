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
    var id_tamano = button.data('id_tamano');
    var id_semillas = button.data('id_semillas');
    var id_calidad = button.data('id_calidad');
    var total = button.data('total');
    var variedad = button.data('id_variedad');
    var procedencia = button.data('id_procedencia');

    var modal = $(this);
    modal.find('.modal-footer #id_producto').val(id_c);
    modal.find('.modal-body #tamanocaparecibida').val(id_tamano).change();
    modal.find('.modal-body #totalcaparecibida').val(total);
    modal.find('.modal-body #variedadcapaentrega').val(variedad).change();
    modal.find('.modal-body #procedenciacapaentrega').val(procedencia).change();
    modal.find('.modal-body #semillacaparecibida').val(id_semillas).change();
    modal.find('.modal-body #calidadcaparecibida').val(id_calidad).change();
});
//Ver Producto
$('#modalVerCapaCapaRecibida').on('show.bs.modal',function (e) {
    var button = $(e.relatedTarget);
    var tamano = button.data('id_tamano');
    var id_semillas = button.data('id_semillas');
    var id_calidad = button.data('id_calidad');
    var total = button.data('total');

    var modal = $(this);
    modal.find('.modal-body #tamanocaparecibida').text(tamano);
    modal.find('.modal-body #totalcaparecibida').text(total);
    modal.find('.modal-body #semillacaparecibida').text(id_semillas);
    modal.find('.modal-body #calidadcaparecibida').text(id_calidad);

});

$('#modalBorrarCapaRecibida').on('show.bs.modal', function (e) {
    var button = $(e.relatedTarget);
    var id = button.data('id');

    var modal=$(this);
    modal.find('.modal-footer #id_capa_entrega').val(id);
});

$('#modalSumar50').on('show.bs.modal', function (e) {
    var button = $(e.relatedTarget);
    var id = button.data('id');

    var modal=$(this);
    modal.find('.modal-footer #id_capa_entrega').val(id);



});


$('#modalSumar200').on('show.bs.modal', function (e) {
    var button = $(e.relatedTarget);
    var id = button.data('id');

    var modal=$(this);
    modal.find('.modal-footer #id_capa_entrega').val(id);




});$('#modalSumar').on('show.bs.modal', function (e) {
    var button = $(e.relatedTarget);
    var id = button.data('id');

    var modal=$(this);
    modal.find('.modal-footer #id_capa_entrega').val(id);
});





$('#modalSumar75').on('show.bs.modal', function (e) {
    var button = $(e.relatedTarget);
    var id = button.data('id');

    var modal=$(this);
    modal.find('.modal-footer #id_capa_entrega').val(id);



});$('#modalSumar100').on('show.bs.modal', function (e) {
    var button = $(e.relatedTarget);
    var id = button.data('id');

    var modal=$(this);
    modal.find('.modal-footer #id_capa_entrega').val(id);

});

