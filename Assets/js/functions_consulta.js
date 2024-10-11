var divLoading = document.querySelector(".divLoading");
let tableBills, facts;
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


	//=============selecion de facturas================

	var checkboxes = document.querySelectorAll('.select-checkbox');

	function actualizarSuma() {
		var sumaSaldos = 0;

		checkboxes.forEach(function (checkbox) {
			if (checkbox.checked) {
				var saldo = parseFloat(checkbox.getAttribute('data-saldo'));
				sumaSaldos += saldo;
			}
		});

		document.getElementById('totalSuma').innerText = '$' + sumaSaldos.toFixed(2);
		document.getElementById('totalUsd').innerText = '$' + sumaSaldos.toFixed(2);

		let totalBs = sumaSaldos.toFixed(2) * document.getElementById('tasa').value;

		document.getElementById('totalBs').innerText = 'Bs' + totalBs.toFixed(2);
		document.getElementById('amount').value = totalBs.toFixed(2);

	}

	checkboxes.forEach(function (checkbox) {
		checkbox.addEventListener('change', function () {
			actualizarSuma();
		});

		// Marcar todos los checkboxes por defecto
		checkbox.checked = true;

		// Obtener la fecha de vencimiento y convertirla a formato Date
		var fechaVencimiento = new Date(checkbox.getAttribute('data-fecha-vencimiento'));

		// Comparar con la fecha actual
		if (fechaVencimiento <= new Date()) {
			// Deshabilitar checkbox si la fecha de vencimiento es menor o igual a la fecha actual
			checkbox.disabled = true;
		}
	});

	actualizarSuma();




	if (document.querySelector("#formPago")) {
		let formPago = document.querySelector("#formPago");

		formPago.onsubmit = function (e) {
			e.preventDefault();


			// Obtener el formulario seleccionado
			let selectedForm = document.querySelector(
				'input[name="formaPago"]:checked'
			).value;

			console.log(selectedForm);

			// Crear un objeto FormData
			var formData = new FormData();

			// Agregar los inputs comunes a ambos formularios
			formData.append("tasa", document.querySelector("#tasa").value);
			formData.append("reference", document.querySelector("#reference").value);
			formData.append("title", document.querySelector("#title").value);
			formData.append("description", document.querySelector("#description").value);

			// Agregar inputs específicos según el formulario seleccionado
			if (selectedForm === "botonPagoBdv") {
				formData.append("currency", document.querySelector("#currency").value);
				formData.append("urlToReturn", document.querySelector("#urlToReturn").value);
				formData.append("formaPago", document.querySelector("#botonPagoBdv").value);
				formData.append("amount", document.querySelector("#amount").value);
				formData.append("idLetter", document.querySelector("#idLetter").value);
				formData.append("idLetterRif", document.querySelector("#idLetterRif").value);
				formData.append("idNumberRif", document.querySelector("#idNumberRif").value);
				formData.append("idNumber", document.querySelector("#idNumber").value);
				formData.append("email", document.querySelector("#email").value);
				formData.append("cellphone", document.querySelector("#cellphone").value);
				formData.append("linea", document.querySelector("#linea").value);
				formData.append("isRif", document.querySelector("#chkJuridicalPerson").checked);
				// Agregar otros campos específicos de este formulario
			} else if (selectedForm === "p2cBcv") {
				formData.append("formaPago", document.querySelector("#p2cBcv").value);
				formData.append("amount", document.querySelector("#amount").value);
				formData.append("idLetterP2c", document.querySelector("#idLetterP2c").value);
				formData.append("idNumberP2c", document.querySelector("#idNumberP2c").value);
				formData.append("cellphoneP2c", document.querySelector("#cellphoneP2c").value);
				formData.append("lineaP2c", document.querySelector("#lineaP2c").value);
			}
			// Agregar otros campos específicos de este formulario
			else if (selectedForm === "pagoBancoTesoro") {
				let data = (document.querySelector("#bancosBt").value).split('|');
				let bankCode, bankName = 0;
				bankCode = data[0];
				bankName = data[1];


				formData.append("formaPago", document.querySelector("#pagoBancoTesoro").value);
				formData.append("amount", document.querySelector("#amount").value);
				formData.append("idLetterBt", document.querySelector("#idLetterBt").value);
				formData.append("idNumberBt", document.querySelector("#idNumberBt").value);
				formData.append("cellphoneBt", document.querySelector("#cellphoneBt").value);
				formData.append("lineaBt", document.querySelector("#lineaBt").value);

				formData.append("bancosBt", bankCode);
				formData.append("bancosName", bankName);

				formData.append("token", document.querySelector("#token").value);
			}

			// Obtener los checkboxes seleccionados y agregarlos al FormData
			checkboxes.forEach(function (checkbox) {
				if (checkbox.checked) {
					var idFactura = checkbox.getAttribute("data-id");
					formData.append("selected_checks[]", idFactura);

					facts = idFactura;

					var amountFactura = checkbox.getAttribute("data-amount");
					formData.append("amount_cheks[]", amountFactura);
				}
			});

			// Validar los campos comunes para ambos formularios
			if (formData.get("email") === "" || formData.get("cellphone") === "") {
				Swal.fire("Por favor", "Todos los datos son requeridos.", "error");
				return false;
			} else {


				console.log(facts);
				if (facts !== undefined) {

					alert("Recuerda siempre consultar tú saldo de nuevo, luego de realizar los pagos. ");

					divLoading.style.display = "flex";

					console.log(formData);
					console.log((document.querySelector("#bancosBt").value).split('|'));

					var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
					var ajaxUrl = base_url + "/Consulta/payment";
					request.open("POST", ajaxUrl, true);
					request.send(formData);
					request.onreadystatechange = function () {
						if (request.readyState != 4) return;
						if (request.status == 200) {
							var responseText = request.responseText;

							console.log(request.responseText);
							responseText = responseText.replace(/^\s+/, '');
							var objData = JSON.parse(responseText);
							if (objData.status) {

								console.log();
								if (objData.url) {
									window.location = objData.url;
								} else {

									Swal.fire({
										title: "¡Exito!",
										html: objData.msg + '<br> REF: ' + objData.ref + '<br> MONTO: ' + objData.amount,
										icon: "success",
										showCancelButton: false,
										allowOutsideClick: false,
										confirmButtonColor: "#3085d6",
										cancelButtonColor: "#d33",
										confirmButtonText: "ok!"
									}).then((result) => {
										if (result.isConfirmed) {
											window.location = objData.url2;
										}
									});



									//Swal.fire('¡Exito!', objData.msg + '<br> Ref: ' + objData.ref + '<br> Monto : ' + objData.amount, 'success');


								}
							} else {
								Swal.fire("Atención", objData.msg, "error");
							}
						} else {
							Swal.fire("Atención", "Error en el proceso", "error");
						}
						divLoading.style.display = "none";
						return false;
					};

				} else {
					Swal.fire("Atención", "Debes seleccionar documentos.", "error");

				}




			}
		};
	}

}, false);




function fntViewFactura(idFactura) {

	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	let ajaxUrl = base_url + '/Consulta/getFactura/' + idFactura;
	request.open("GET", ajaxUrl, true);
	request.send();
	request.onreadystatechange = function () {

		if (request.readyState == 4 && request.status == 200) {

			let objetoJSON = JSON.parse(request.responseText);

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
				data_list += '<tr><td>' + element.id + '</td><td>' + element.descripcion + '</td> <td>' + element.cantidad + '</td> <td>' + element.servicio.id_servicio + '</td> </tr>';

			});
			element_list.innerHTML = data_list;



			//document.querySelector('#jsonData').innerHTML = "<pre><code>" + JSON.stringify(objData, null, 2) + "</pre></code>";

		}

		$('#modalViewFactura').modal('show');
	}


}

function getBancosBancoDelTesoro() {

	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	let ajaxUrl = base_url + '/Consulta/getBancosBancoDelTesoro';
	request.open("POST", ajaxUrl, true);

	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			let objData = JSON.parse(request.responseText);

			// Obtener el elemento select
			let selectBancos = document.getElementById('bancosBt');

			// Limpiar opciones existentes
			selectBancos.innerHTML = '';

			// Iterar sobre el JSON y agregar opciones al select
			objData.forEach(function (banco) {
				let option = document.createElement('option');
				option.value = banco.codigo + '|' + banco.nombre;
				option.text = banco.codigo + ' - ' + banco.nombre;
				selectBancos.add(option);
			});

		}
	};

	request.send();
}






