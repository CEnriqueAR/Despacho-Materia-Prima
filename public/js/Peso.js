$('#modalVistaPreviaCapaEntrega').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var src_imagen = button.data("src_img");

    var modal = $(this);
    modal.find('.modal-body #img').attr("src","/images/productos/"+src_imagen);
});
//Editar modal Producto
$('#modalEditarPeso').on('show.bs.modal',function (e) {
    var button = $(e.relatedTarget);
    var id_c = button.data('id');
    var PesoGrande = button.data('PesoGrande');
    var id_semillas = button.data('id_semillas');
    var PesoMediano = button.data('PesoMediano');
    var PesoPequeno = button.data('PesoPequeno');

    var modal = $(this);
    modal.find('.modal-footer #id_producto').val(id_c);
    modal.find('.modal-body #PesoGrande').val(PesoGrande);
    modal.find('.modal-body #PesoPequeno').val(PesoPequeno);
    modal.find('.modal-body #id_semillas').val(id_semillas).change();
    modal.find('.modal-body #PesoMediano').val(PesoMediano);
});
//Ver Producto

$('#modalBorrarPeso').on('show.bs.modal', function (e) {
    var button = $(e.relatedTarget);
    var id = button.data('id');

    var modal=$(this);
    modal.find('.modal-footer #id').val(id);
});








