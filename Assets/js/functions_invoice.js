var divLoading = document.querySelector(".divLoading");
let tableBills;
document.addEventListener('DOMContentLoaded', function () {

	tableBills = $('#tableBills').dataTable({
		"aProcessing": true,
		"aServerSide": true,
		"language": {
			"processing": "Procesando...",
			"lengthMenu": "Mostrar _MENU_ registros",
			"zeroRecords": "No se encontraron resultados",
			"emptyTable": "Ningún dato disponible en esta tabla",
			"infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
			"infoFiltered": "(filtrado de un total de _MAX_ registros)",
			"search": "Buscar:",
			"infoThousands": ",",
			"loadingRecords": "Cargando...",
			"paginate": {
				"first": "Primero",
				"last": "Último",
				"next": ">",
				"previous": "<"
			},
			"info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros"
		},
		"resonsieve": "true",
		"bDestroy": true,
		"iDisplayLength": 10,
		"order": [[0, "asc"]]
	});




}, false);




function fntViewFactura(objetoJSON) {

	var jsonString = JSON.stringify(objetoJSON);
	var data_list = '';
	var element_list = document.getElementById('detailsInvoice');
	var dataInvoice = {
		id_factura: objetoJSON.id_factura,
		fecha_emision: objetoJSON.fecha_emision,
		fecha_vencimiento: objetoJSON.fecha_vencimiento,
		total: objetoJSON.total,
		articulos: objetoJSON.articulos,
	};

	document.getElementById('invoice').value = dataInvoice['id_factura'];
	document.getElementById('date_issue').value = dataInvoice['fecha_emision'];
	document.getElementById('date_expiration').value = dataInvoice['fecha_vencimiento'];
	document.getElementById('total_amount').value = dataInvoice['total'];



	dataInvoice['articulos'].forEach(function (element) {
		data_list += '<tr><td>' + element.descripcion + '</td> <td>' + element.cantidad + '</td> </tr>';

	});
	element_list.innerHTML = data_list;


	$('#modalViewFactura').modal('show');
}













