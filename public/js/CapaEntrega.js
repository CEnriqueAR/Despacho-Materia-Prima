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
    var libras = button.data('libras');
    var onzas = button.data('onzas');
    var onzasI = button.data('onzasI');
    var onzasE = button.data('onzasE');
    var onzasF = button.data('onzasF');
    var total = button.data('total');
    var totalinicial = button.data('totalinicial');
    var pesoinicial= button.data('pesoinicial');
    var totalentrada = button.data('totalentrada');
    var pesoentrada= button.data('pesoentrada');
    var totalfinal = button.data('totalfinal');
    var pesofinal= button.data('pesofinal');
    var totalconsumo = button.data('totalconsumo');
    var pesoconsumo= button.data('pesoconsumo');

    var modal = $(this);
    modal.find('.modal-footer #id_producto').val(id_c);
    modal.find('.modal-body #empleadoEditarcapaentrega').val(empleado).change();
    modal.find('.modal-body #vitolacapaentrega').val(vitola).change();
    modal.find('.modal-body #semillacapaentrega').val(semilla).change();
    modal.find('.modal-body #calidadcapaentrega').val(calidad).change();
    modal.find('.modal-body #totalcapaentrega').val(total);
    modal.find('.modal-body #onzasinicialcapaentrega').val(onzasI);
    modal.find('.modal-body #onzasentradacapaentrega').val(onzasE);
    modal.find('.modal-body #onzasfinalcapaentrega').val(onzasF);
    modal.find('.modal-body #onzascapaentrega').val(onzas);
    modal.find('.modal-body #librascapaentrega').val(libras);
    modal.find('.modal-body #marcacapaentrega').val(id_marca).change();
    modal.find('.modal-body #tamanocapaentrega').val(id_tamano).change();
    modal.find('.modal-body #totalinicialdiario').val(totalinicial);
    modal.find('.modal-body #pesoinicialdiario').val(pesoinicial);
    modal.find('.modal-body #totalentradadiario').val(totalentrada);
    modal.find('.modal-body #pesoentradadiario').val(pesoentrada);
    modal.find('.modal-body #totalfinaldiario').val(totalfinal);
    modal.find('.modal-body #pesofinaldiario').val(pesofinal);
    modal.find('.modal-body #totalconsumodiario').val(totalconsumo);
    modal.find('.modal-body #pesoconsumodiario').val(pesoconsumo);

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
    var onzas = button.data('onzas');
    var onzasI = button.data('onzasI');
    var onzasE = button.data('onzasE');
    var onzasF = button.data('onzasF');
    var libras= button.data('libras');
    var totalinicial = button.data('totalinicial');
    var pesoinicial= button.data('pesoinicial');
    var totalentrada = button.data('totalentrada');
    var pesoentrada= button.data('pesoentrada');
    var totalfinal = button.data('totalfinal');
    var pesofinal= button.data('pesofinal');
    var totalconsumo = button.data('totalconsumo');
    var pesoconsumo= button.data('pesoconsumo');
    var modal = $(this);
    modal.find('.modal-body #empleadoNuevocapaentrega').text(empleado);
    modal.find('.modal-body #vitolacapaentrega').text(vitola);
    modal.find('.modal-body #onzascapaentrega').val(onzas);
    modal.find('.modal-body #semillacapaentrega').text(semilla);
    modal.find('.modal-body #librascapaentrega').text(libras);
    modal.find('.modal-body #onzasicapaentrega').text(onzasI);
    modal.find('.modal-body #onzasecapaentrega').text(onzasE);
    modal.find('.modal-body #onzasfcapaentrega').text(onzasF);
    modal.find('.modal-body #calidadcapaentrega').text(calidad);
    modal.find('.modal-body #totalcapaentrega').text(total);
    modal.find('.modal-body #marcacapaentrega').text(id_marca);
    modal.find('.modal-body #totalinicialdiario').text(totalinicial);
    modal.find('.modal-body #pesoinicialdiario').text(pesoinicial);
    modal.find('.modal-body #totalentradadiario').text(totalentrada);
    modal.find('.modal-body #pesoentradadiario').text(pesoentrada);
    modal.find('.modal-body #totalfinaldiario').text(totalfinal);
    modal.find('.modal-body #pesofinaldiario').text(pesofinal);
    modal.find('.modal-body #totalconsumodiario').text(totalconsumo);
    modal.find('.modal-body #pesoconsumodiario').text(pesoconsumo);

});






$('#modalVerCapaEntreg').on('show.bs.modal',function (e) {
    var button = $(e.relatedTarget);
    var empleado = button.data('id_empleado');
    var vitola = button.data('id_vitolas');
    var semilla = button.data('id_semillas');
    var calidad = button.data('id_calidad');
    var tamano = button.data('id_tamano');

    var id_marca = button.data('id_marca');
    var total = button.data('total');
    var onzas = button.data('onzas');
    var libras= button.data('libras');
    var totalinicial = button.data('totalinicial');
    var pesoinicial= button.data('pesoinicial');
    var totalentrada = button.data('totalentrada');
    var pesoentrada= button.data('pesoentrada');
    var totalfinal = button.data('totalfinal');
    var pesofinal= button.data('pesofinal');
    var totalconsumo = button.data('totalconsumo');
    var pesoconsumo= button.data('pesoconsumo');
    var modal = $(this);
    modal.find('.modal-body #empleadoNuevocapaentrega').text(empleado);
    modal.find('.modal-body #vitolacapaentrega').text(vitola);
    modal.find('.modal-body #semillacapaentrega').text(semilla);
    modal.find('.modal-body #librascapaentrega').val(libras);
    modal.find('.modal-body #onzascapaentrega').text(onzas);
    modal.find('.modal-body #calidadcapaentrega').text(calidad);
    modal.find('.modal-body #tamanocapaentrega').text(tamano);

    modal.find('.modal-body #totalcapaentrega').text(total);
    modal.find('.modal-body #marcacapaentrega').text(id_marca);
    modal.find('.modal-body #totalinicialdiario').text(totalinicial);
    modal.find('.modal-body #pesoinicialdiario').text(pesoinicial);
    modal.find('.modal-body #totalentradadiario').text(totalentrada);
    modal.find('.modal-body #pesoentradadiario').text(pesoentrada);
    modal.find('.modal-body #totalfinaldiario').text(totalfinal);
    modal.find('.modal-body #pesofinaldiario').text(pesofinal);
    modal.find('.modal-body #totalconsumodiario').text(totalconsumo);
    modal.find('.modal-body #pesoconsumodiario').text(pesoconsumo);

});
$('#modalBorrarCapaEntrega').on('show.bs.modal', function (e) {
    var button = $(e.relatedTarget);
    var id = button.data('id');

    var modal=$(this);
    modal.find('.modal-footer #id_capa_entrega').val(id);
});
$('#modalEditarDiario').on('show.bs.modal',function (e) {
    var button = $(e.relatedTarget);
    var id_c = button.data('id');
    var empleado = button.data('id_empleado');
    var vitola = button.data('id_vitolas');
    var semilla = button.data('id_semilla');
    var calidad = button.data('id_calidad');
    var id_marca = button.data('id_marca');
    var id_tamano= button.data('id_tamano');
    var total = button.data('total');
    var totalinicial = button.data('totalinicial');
    var pesoinicial= button.data('pesoinicial');
    var onzas = button.data('onzas');
    var totalentrada = button.data('totalentrada');
    var pesoentrada= button.data('pesoentrada');
    var totalfinal = button.data('totalfinal');
    var pesofinal= button.data('pesofinal');
    var totalconsumo = button.data('totalconsumo');
    var pesoconsumo= button.data('pesoconsumo');

    var modal = $(this);
    modal.find('.modal-footer #id_producto').val(id_c);
    modal.find('.modal-body #empleadoEditarcapaentrega').val(empleado).change();
    modal.find('.modal-body #vitolacapaentrega').val(vitola).change();
    modal.find('.modal-body #semillacapaentrega').val(semilla).change();
    modal.find('.modal-body #calidadcapaentrega').val(calidad).change();
    modal.find('.modal-body #totalcapaentrega').val(total);
    modal.find('.modal-body #onzascapaentrega').val(onzas);
    modal.find('.modal-body #librascapaentrega').val(libras);
    modal.find('.modal-body #marcacapaentrega').val(id_marca).change();
    modal.find('.modal-body #tamanocapaentrega').val(id_tamano).change();
    modal.find('.modal-body #totalinicialdiario').text(totalinicial);
    modal.find('.modal-body #pesoinicialdiario').text(pesoinicial);
    modal.find('.modal-body #totalentradadiario').text(totalentrada);
    modal.find('.modal-body #pesoentradadiario').text(pesoentrada);
    modal.find('.modal-body #totalfinaldiario').text(totalfinal);
    modal.find('.modal-body #pesofinaldiario').text(pesofinal);
    modal.find('.modal-body #totalconsumodiario').text(totalconsumo);
    modal.find('.modal-body #pesoconsumodiario').text(pesoconsumo);

});
//Ver Producto
$('#modalVerReBulDiario').on('show.bs.modal',function (e) {
    var button = $(e.relatedTarget);
    var empleado = button.data('id_empleado');
    var vitola = button.data('id_vitolas');
    var semilla = button.data('id_semillas');
    var calidad = button.data('id_calidad');
    var id_marca = button.data('id_marca');
    var total = button.data('total');
    var totalinicial = button.data('totalinicial');
    var pesoinicial= button.data('pesoinicial');
    var onzas = button.data('onzas');
    var totalentrada = button.data('totalentrada');
    var pesoentrada= button.data('pesoentrada');
    var totalfinal = button.data('totalfinal');
    var pesofinal= button.data('pesofinal');
    var totalconsumo = button.data('totalconsumo');
    var pesoconsumo= button.data('pesoconsumo');


    var modal = $(this);
    modal.find('.modal-body #empleadoNuevocapaentrega').text(empleado);
    modal.find('.modal-body #vitolacapaentrega').text(vitola);
    modal.find('.modal-body #semillacapaentrega').text(semilla);
    modal.find('.modal-body #librascapaentrega').val(libras);
    modal.find('.modal-body #onzascapaentrega').text(onzas);
    modal.find('.modal-body #calidadcapaentrega').text(calidad);
    modal.find('.modal-body #totalcapaentrega').text(total);
    modal.find('.modal-body #marcacapaentrega').text(id_marca);
    modal.find('.modal-body #totalinicialdiario').text(totalinicial);
    modal.find('.modal-body #pesoinicialdiario').text(pesoinicial);
    modal.find('.modal-body #totalentradadiario').text(totalentrada);
    modal.find('.modal-body #pesoentradadiario').text(pesoentrada);
    modal.find('.modal-body #totalfinaldiario').text(totalfinal);
    modal.find('.modal-body #pesofinaldiario').text(pesofinal);
    modal.find('.modal-body #totalconsumodiario').text(totalconsumo);
    modal.find('.modal-body #pesoconsumodiario').text(pesoconsumo);
});







