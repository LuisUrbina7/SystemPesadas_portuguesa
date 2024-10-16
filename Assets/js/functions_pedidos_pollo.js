
var total_value, total_extra = 0;

document.addEventListener('DOMContentLoaded', function () {









}, false);


function activeTrans(data) {


	//console.log(data.getAttribute('data-number'));








	Swal.fire({
		title: "Desea realizar la transferencia?",
		text: "Presiona sí para continuar!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Sí, continuar!"
	}).then((result) => {
		if (result.isConfirmed) {

			let guia = data.getAttribute('data-number');
			let vnd = data.getAttribute('data-det');


			var request = (window.XMLHttpRequest) ?
				new XMLHttpRequest() :
				new ActiveXObject('Microsoft.XMLHTTP');

			var ajaxUrl = base_url + '/PedidosPollo/activeTrans?id=' + guia + '&vd=' + vnd;

			request.open("GET", ajaxUrl, true);
			request.send();
			request.onreadystatechange = function () {

				if (request.readyState != 4) return;
				if (request.status == 200) {
					var objData = JSON.parse(request.responseText);

					if (objData.status) {


						Swal.fire({
							title: "Excelente!",
							text: objData.msg,
							icon: "success"
						});

						data.classList.remove('btn-light');
						if (vnd == '052') {
							data.classList.add('btn-warning');
							data.onclick = null;


						} else {
							data.classList.add('btn-success');
							data.onclick = null;


							let btnSincro = data.parentNode.parentNode.parentNode.cells[5].querySelector('.btn-sincro');

							btnSincro.onclick = function () {
								sincroGuia(btnSincro);
							}
							btnSincro.classList.remove('btn-success-previo');
							btnSincro.classList.add('btn-light');
						}


					} else {

						Swal.fire({
							title: "Error!",
							text: objData.msg,
							icon: "error"
						});
					};

				} else {
					Swal.fire({
						title: "Error!",
						text: 'Conexion.',
						icon: "error"
					});
				}

			}





		}
	});





}

function sincroGuia(data) {





	Swal.fire({
		title: "Desea realizar la Sincronización?",
		text: "Presiona sí para continuar!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Sí, continuar!"
	}).then((result) => {
		if (result.isConfirmed) {

			let guia = data.getAttribute('data-number');
			let vnd = data.getAttribute('data-det');


			var request = (window.XMLHttpRequest) ?
				new XMLHttpRequest() :
				new ActiveXObject('Microsoft.XMLHTTP');

			var ajaxUrl = base_url + '/PedidosPollo/sincroGuia?id=' + guia + '&vd=' + vnd;

			request.open("GET", ajaxUrl, true);
			request.send();
			request.onreadystatechange = function () {

				if (request.readyState != 4) return;
				if (request.status == 200) {
					var objData = JSON.parse(request.responseText);

					if (objData.status) {


						Swal.fire({
							title: "Excelente!",
							text: objData.msg,
							icon: "success"
						});

						data.classList.remove('btn-light');
						data.classList.add('btn-success');
						data.onclick = null;


					} else {

						Swal.fire({
							title: "Error!",
							text: objData.msg,
							icon: "error"
						});
					};

				} else {
					Swal.fire({
						title: "Error!",
						text: 'Conexion.',
						icon: "error"
					});
				}

			}





		}
	});

}






function viewPdf(data) {
	let values = data.split("|");
	let numero = values[0];
	let codigo = values[1];
	let sucursal = values[2];

	console.log(values);

	var ajaxUrl =
		base_url +
		"/PedidosPollo/viewPdf?id=" +
		numero +
		"&pv=" +
		codigo +
		"&scs=" +
		sucursal;

	//var ajaxUrl = base_url + '/Document/generatePdf?id=' + numero + '&pv=' + codigo + '&scs=' + sucursal;

	console.log(ajaxUrl);

	window.open(ajaxUrl);
}


function ticket(data) {
	let values = data.split("|");
	let numero = values[0];
	let codigo = values[1];

	Swal.fire({
		title: "Desea imprimir?",
		text: "Presiona sí para continuar!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Sí, continuar!"
	}).then((result) => {
		if (result.isConfirmed) {

			var request = (window.XMLHttpRequest) ?
				new XMLHttpRequest() :
				new ActiveXObject('Microsoft.XMLHTTP');

			var ajaxUrl = base_url + '/PedidosPollo/ticket?id=' + numero + '&vd=' + codigo;

			request.open("GET", ajaxUrl, true);
			request.send();
			request.onreadystatechange = function () {

				if (request.readyState != 4) return;
				if (request.status == 200) {
					var objData = JSON.parse(request.responseText);

					if (objData.status) {

						Swal.fire({
							position: "center",
							icon: "success",
							title: objData.msg,
							showConfirmButton: false,
							timer: 1000
						});

					} else {

						Swal.fire({
							position: "center",
							icon: "error",
							title: objData.msg,
							showConfirmButton: false,
							timer: 1000
						});
					};

				} else {
					Swal.fire({
						position: "center",
						icon: "error",
						title: "Error, conexion.",
						showConfirmButton: false,
						timer: 1000
					});
				}

			}





		}
	});


}




function ticketGeneral(data) {
	let values = data.split("|");
	let numero = values[0];
	let codigo = values[1];
	let sucursal = values[2];

	Swal.fire({
		title: "Desea imprimir?",
		text: "Presiona sí para continuar!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Sí, continuar!"
	}).then((result) => {
		if (result.isConfirmed) {

			var request = (window.XMLHttpRequest) ?
				new XMLHttpRequest() :
				new ActiveXObject('Microsoft.XMLHTTP');

			var ajaxUrl = base_url + '/PedidosPollo/ticketGeneral?id=' + numero + '&vd=' + codigo + '&scs=' + sucursal;

			request.open("GET", ajaxUrl, true);
			request.send();
			request.onreadystatechange = function () {

				if (request.readyState != 4) return;
				if (request.status == 200) {
					var objData = JSON.parse(request.responseText);

					if (objData.status) {

						Swal.fire({
							position: "center",
							icon: "success",
							title: objData.msg,
							showConfirmButton: false,
							timer: 1000
						});

					} else {

						Swal.fire({
							position: "center",
							icon: "error",
							title: objData.msg,
							showConfirmButton: false,
							timer: 1000
						});
					};

				} else {
					Swal.fire({
						position: "center",
						icon: "error",
						title: "Error, conexion.",
						showConfirmButton: false,
						timer: 1000
					});
				}

			}
		}
	});


}




