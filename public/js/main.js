(function () {
	"use strict";

	var treeviewMenu = $('.app-menu');

	// Toggle Sidebar
	$('[data-toggle="sidebar"]').click(function(event) {
		event.preventDefault();
		$('.app').toggleClass('sidenav-toggled');
	});

	// Activate sidebar treeview toggle
	$("[data-toggle='treeview']").click(function(event) {
		event.preventDefault();
		if(!$(this).parent().hasClass('is-expanded')) {
			treeviewMenu.find("[data-toggle='treeview']").parent().removeClass('is-expanded');
		}
		$(this).parent().toggleClass('is-expanded');
	});

	// Set initial active toggle
	$("[data-toggle='treeview.'].is-expanded").parent().toggleClass('is-expanded');

	//Activate bootstrip tooltips
	$("[data-toggle='tooltip']").tooltip();

})();
// <script>
//   require( 'datatables.net-buttons/js/dataTables.buttons' )
//   require( 'datatables.net-buttons/js/buttons.html5')
//   import print from 'datatables.net-buttons/js/buttons.print'
  
//   import datatable from 'datatables.net-bs4'
//   import jszip from 'jszip/dist/jszip'
//   import pdfMake from "pdfmake/build/pdfmake"
//   import pdfFonts from "pdfmake/build/vfs_fonts"

//   pdfMake.vfs = pdfFonts.pdfMake.vfs;
//   window.JSZip = jszip

//   export default {
//     mounted() {
//       this.tabla()
//     },
//     methods:{
//       tabla(){
//         this.$nextTick(() => {
//           $('#sampleTable').DataTable({
//             "aProcessing": true,
//             "aServerSide": true,
//             "language": {
//               "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
//             },
//             dom: "<'row'<'col-sm-12'B>>" +"<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>"+
										// "<'row'<'col-sm-12'tr>>" +
										// "<'row'<'col-sm-5'i><'col-sm-7'p>>",
//             buttons: [
//               {
//                 "extend": "copyHtml5",
//                 "text": " Copiar",
//                 "titleAttr": "Copiar",
//                 "className": "btn btn-secondary"
//               },
//               {
//                 "extend": "excelHtml5",
//                 "text": "<i class='fas fa-file-excel'></i> Excel",
//                 "titleAttr": "Esportar a Excel",
//                 "className": "btn btn-success"
//               },
//               {
//                 "extend": "pdfHtml5",
//                 "text": "<i class='fas fa-file-pdf'></i> PDF",
//                 "titleAttr": "Esportar a PDF",
//                 "className": "btn btn-danger"
//               },
//               {
//                 "extend": "csvHtml5",
//                 "text": "<i class='fas fa-file-csv'></i> CSV",
//                 "titleAttr": "Esportar a CSV",
//                 "className": "btn btn-info"
//               },
//               {
//                 "extend": "print",
//                 "text": "<i class='fas fa-file-csv'></i> Imprimir",
//                 "titleAttr": "Imprimir archivo",
//                 "className": "btn btn-secondary"
//               }
//             ],
//             "responsive": "true",
//             "bDestroy": true,
//             "iDisplayLength": 10,
//           });
//         });
//       }
//     }
//   }
// </script>


// en la carpeta app.sasss
// @import '~datatables.net-buttons-bs4/css/buttons
