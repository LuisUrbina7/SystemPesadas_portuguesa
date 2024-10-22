
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
			let trans = data.getAttribute('data-det');


			var request = (window.XMLHttpRequest) ?
				new XMLHttpRequest() :
				new ActiveXObject('Microsoft.XMLHTTP');

			var ajaxUrl = base_url + '/DocumentGuia/activeTrans?id=' + guia + '&tr=' + trans;

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
						if (trans == '052') {
							data.classList.add('btn-warning');
							data.onclick = null;

							let btnOpenGuia = data.parentNode.parentNode.parentNode.cells[4].querySelector('.btn-open-guia');

							if (btnOpenGuia) {

								btnOpenGuia.classList.add('d-none');
							}

						} else {
							data.classList.add('btn-success');
							data.onclick = null;


							let btnSincro = data.parentNode.parentNode.parentNode.cells[5].querySelector('.btn-sincro');
							let btnOpenGuia = data.parentNode.parentNode.parentNode.cells[4].querySelector('.btn-open-guia');

							btnSincro.onclick = function () {
								sincroGuia(btnSincro);
							}
							btnSincro.classList.remove('btn-success-previo');
							btnSincro.classList.add('btn-light');
							
							if (btnOpenGuia) {

								btnOpenGuia.classList.add('d-none');
							}
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
			let trans = data.getAttribute('data-det');


			var request = (window.XMLHttpRequest) ?
				new XMLHttpRequest() :
				new ActiveXObject('Microsoft.XMLHTTP');

			var ajaxUrl = base_url + '/DocumentGuia/sincroGuia?id=' + guia + '&tr=' + trans;

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



function generatePdfGeneral(data) {

	let values = data.split('|');
	let numero = values[0];
	let codigo = values[1];
	let sucursal = values[2];

	console.log(values);

	var ajaxUrl = base_url + '/DocumentGuia/generatePdfGeneral?id=' + numero + '&pv=' + codigo + '&scs=' + sucursal;

	console.log(ajaxUrl);

	window.open(ajaxUrl);


}



function viewPdf(data) {
	let values = data.split("|");
	let numero = values[0];
	let codigo = values[1];
	let sucursal = values[2];

	console.log(values);

	var ajaxUrl =
		base_url +
		"/DocumentGuia/viewPdf?id=" +
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

			var ajaxUrl = base_url + '/DocumentGuia/ticket?id=' + numero + '&tr=' + codigo;

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

			var ajaxUrl = base_url + '/DocumentGuia/ticketGeneral?id=' + numero + '&tr=' + codigo + '&scs=' + sucursal;

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



async function openGuia(data) {


	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: 'btn btn-success',
			cancelButton: 'btn btn-danger'
		},
		buttonsStyling: false
	});

	try {
		const result = await swalWithBootstrapButtons.fire({
			title: 'Por favor ingresa clave administrador. Para abrir la guia.',
			html: '<input type="password" id="swal-input" class="swal2-input" placeholder="Clave">',
			focusConfirm: false,
			preConfirm: () => {
				return document.getElementById('swal-input').value;
			}
		});

		if (result.isConfirmed) {
			const password = result.value;

			if (password !== '2525') {
				Swal.fire("Atención", "Clave incorrecta.", "error");
				return;
			}


			let guia = data.getAttribute('data-number');
			let trans = data.getAttribute('data-det');


			const ajaxUrl = base_url + '/DocumentGuia/openGuia?id=' + guia + '&tr=' + trans;
			const response = await fetch(ajaxUrl);

			if (!response.ok) {
				throw new Error('Error en la solicitud.');
			}

			const objData = await response.json();


			if (objData.status) {
				Swal.fire({
					position: "center",
					icon: "success",
					title: objData.msg,
					showConfirmButton: false,
					timer: 1000
				});

				let btnOpenGuia = data.parentNode.parentNode.parentNode.cells[4].querySelector('.btn-open-guia');
				let spnActiveTrans = data.parentNode.parentNode.parentNode.cells[3].querySelector('.span-active-trans');
				let btnActiveTrans = data.parentNode.parentNode.parentNode.cells[4].querySelector('.btn-active-trans');



				if (btnOpenGuia) {
					btnOpenGuia.classList.add('d-none');
				}

				if (btnActiveTrans) {
					btnActiveTrans.style.pointerEvents = "none";
				}

				if (spnActiveTrans) {
					spnActiveTrans.textContent = 'PROCESO';
					spnActiveTrans.classList.remove('bg-gradient-success');
					spnActiveTrans.classList.add('bg-gradient-warning');
				}


			} else {
				Swal.fire({
					position: "center",
					icon: "error",
					title: objData.msg,
					showConfirmButton: false,
					timer: 1000
				});
			}
		}
	} catch (error) {
		console.error('Error en la solicitud:', error);
		Swal.fire({
			position: "center",
			icon: "error",
			title: objData.msg,
			showConfirmButton: false,
			timer: 1000
		});
	}


}

