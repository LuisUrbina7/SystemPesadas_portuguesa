
var total_value, total_extra = 0;
var validaSave = 0;
var request = null;
var indType = 0;
document.addEventListener('DOMContentLoaded', function () {

	indType = Number(document.getElementById('indicadorType').value);
	var check = document.querySelector('#otros');
	var checkSausages = document.querySelector('#embutidos');


	var keyupOne = document.getElementById('weight-value');
	var keyupTwo = document.getElementById('weight-value-secondary');

	const socket = new WebSocket('ws://localhost:8080');

	socket.addEventListener('message', function (event) {

		let element = document.getElementById('weight-value');
		let checkOthers = document.getElementById('otros');


		let canxund = parseFloat(document.getElementById('canxund').value);
		let und = document.getElementById('codigo-und').textContent;


		if (und == 0) {
			return 0;
		}


		if (canxund >= 1 && und != 'KG' || indType) {

			return 0;
		}

		if (checkOthers.checked) {
			return 0;
		}

		let validaCanxund = document.getElementById('codigo-und').textContent;


		if (validaCanxund == 'KG' && !checkOthers.checked) {

			element.value = parseFloat(event.data);

		}



		console.log('Peso recibido: ' + event.data);


	});

	/*socket.addEventListener('open', function (event) {
		socket.send('Hola servidor!');
	});

	socket.addEventListener('close', function (event) {
		console.log('Conexión cerrada, intentando reconectar...');
		setTimeout(function () {
			socket = new WebSocket('ws://192.168.88.100:8080');  // Intenta reconectar
		}, 5000);  // Espera 5 segundos antes de intentar
	});*/








	keyupOne.addEventListener('keyup', function (element) {

		let amount = parseFloat(document.getElementById('valor').value) || 0;
		let canxund = parseFloat(document.getElementById('canxund').value) || 1;
		let secondaryValue = document.getElementById('weight-value-secondary').value ?? 0;
		let keyValue = parseFloat(element.target.value) || 0;
		let totalValidate = (keyValue + parseFloat(secondaryValue / canxund));
		let und = document.getElementById('codigo-und').textContent;

		if (und != 'KG' || indType) {


			if (totalValidate > amount) {
				Swal.fire("Atención", "Cantidad sobrepasada.", "error");
				document.getElementById('weight-value').value = amount;

				document.getElementById('weight-value-secondary').value = 0.00
			}
		}

	});


	keyupTwo.addEventListener('keyup', function (element) {

		let canxund = parseFloat(document.getElementById('canxund').value);
		let amount = parseFloat(document.getElementById('valor').value * canxund);

		let keyValue = parseFloat(element.target.value);

		let secondaryValue = parseFloat(document.getElementById('weight-value').value * canxund);

		let totalValidate = (keyValue + secondaryValue);


		if (totalValidate > amount) {
			Swal.fire("Atención", "Cantidad sobrepasada.", "error");
			document.getElementById('weight-value-secondary').value = amount;
			document.getElementById('weight-value').value = 0.00
		}

	});





	check.addEventListener('change', function () {

		document.getElementById('weight-value').value = '';

		document.getElementById('manual-label').style.display == 'none' ? document.getElementById('manual-label').style.display = 'inline-block' : document.getElementById('manual-label').style.display = 'none'; document.getElementById('weight-value').value = '0.00';

		document.getElementById('weight-value').style.border == '1px solid red' ? document.getElementById('weight-value').style.border = '0px solid red' : document.getElementById('weight-value').style.border = '1px solid red';

		document.getElementById('weight-value').readOnly == false ? document.getElementById('weight-value').readOnly = true : document.getElementById('weight-value').readOnly = false;

	});



	checkSausages.addEventListener('change', function () {

		if (checkSausages.checked) {

			document.getElementById('selectCanastas').style.display = 'none'; // document.getElementById('selectCanastas').style.display = 'inline-block' : document.getElementById('selectCanastas').style.display = 'none';
			document.getElementById('selectCantidad').style.display = 'none';//document.getElementById('selectCantidad').style.display = 'inline-block' : document.getElementById('selectCantidad').style.display = 'none';
			document.getElementById('buttonAddCanastas').style.display = 'none'; // document.getElementById('buttonAddCanastas').style.display = 'inline-block' : document.getElementById('buttonAddCanastas').style.display = 'none';

		} else {
			document.getElementById('selectCanastas').style.display = 'inline-block'; // document.getElementById('selectCanastas').style.display = 'inline-block' : document.getElementById('selectCanastas').style.display = 'none';
			document.getElementById('selectCantidad').style.display = 'inline-block';//document.getElementById('selectCantidad').style.display = 'inline-block' : document.getElementById('selectCantidad').style.display = 'none';
			document.getElementById('buttonAddCanastas').style.display = 'inline-block';
		};
	});









	function hora() {

		var element = document.getElementById('reloj');

		const horaActual = new Date();

		const hora = horaActual.getHours().toString().padStart(2, 0);

		const minutos = horaActual.getMinutes().toString().padStart(2, 0);

		const segundos = horaActual.getSeconds().toString().padStart(2, 0);

		element.value = hora + ":" + minutos + ":" + segundos;
	};


	document.querySelectorAll('.details-odc-style').forEach(function (item) {
		item.addEventListener('click', function () {

			if (!validaSave) {
				var selectedItem = document.querySelector('.details-odc-style.selected');
				if (selectedItem) {
					selectedItem.classList.remove('selected');
				}
				this.classList.add('selected');
			}
		});
	});



	setInterval(hora, 1000);

	//setInterval(getWeight, 500);


	eventPressEnter();

}, false);



function valueRandom() {

	return Math.floor((Math.random() * (100 - 1 + 1)) + 1);
}


function getWeight() {

	let element = document.getElementById('weight-value');
	let checkOthers = document.getElementById('otros');


	let canxund = parseFloat(document.getElementById('canxund').value);
	let und = document.getElementById('codigo-und').textContent;


	if (und == 0) {
		return 0;
	}


	if (canxund >= 1 && und != 'KG') {

		return 0;
	}

	if (checkOthers.checked) {
		return 0;
	}



	var request = (window.XMLHttpRequest) ?
		new XMLHttpRequest() :
		new ActiveXObject('Microsoft.XMLHTTP');

	var ajaxUrl = base_url + '/PedidosPollo/getWeight';

	request.open("GET", ajaxUrl, true);
	request.send();
	request.onreadystatechange = function () {

		if (request.readyState != 4) return;
		if (request.status == 200) {
			var objData = JSON.parse(request.responseText);

			let validaCanxund = document.getElementById('codigo-und').textContent;


			if (validaCanxund == 'KG' && !checkOthers.checked) {

				element.value = parseFloat(objData);

			}


			/*
			if (objData.status) {
			} else {
			};*/

		} else {
			Swal.fire({
				title: "Error!",
				text: 'Conexion.',
				icon: "error"
			});
		}

	}

}

function aggRow() {

	let referenceKg = 0;
	let reference = document.getElementById('weight-value').value;

	let table = document.getElementById('table-date');
	let unit = document.getElementById('codigo-und').textContent;
	let canxund = document.getElementById('canxund').value;
	let dateStart = document.getElementById('relojStart').value;
	let dateEnd = document.getElementById('reloj').value;
	let check = document.getElementById('otros');
	let checkSausages = document.getElementById('embutidos');
	let amc = document.getElementById('amc').value;

	let weight = unit == 'UND' ? parseFloat(document.getElementById('weight-value').value * canxund) : parseFloat(document.getElementById('weight-value').value);

	let weightSecondary = parseFloat(document.getElementById('weight-value-secondary').value) == '' || isNaN(parseFloat(document.getElementById('weight-value-secondary').value)) ? 0 : parseFloat(document.getElementById('weight-value-secondary').value);


	if (unit == 0) {
		Swal.fire({
			position: "center",
			icon: "error",
			title: "Debes seleccionar un producto.",
			showConfirmButton: false,
			timer: 1000
		});
		return 0;
	}

	if (unit != 'UND' && !indType) {
		reference = document.getElementById('weight-value').value;
	} else if (indType && unit != 'UND') {

		reference = document.getElementById('weight-value').value;

		let valorUnd = parseFloat(document.getElementById('valor-und').value);
		let valorkg = parseFloat(document.getElementById('valor').value);
		let countWeight = parseFloat(document.getElementById('weight-bruto').innerText);
		let validaExis = 0;

		validaExis = valorkg + valorUnd;

		console.log("Entro Aqui " + validaExis);
		if ((countWeight + weight) > validaExis) {

			return 0;
		}

	} else {

		let valorUnd = parseFloat(document.getElementById('valor-und').value);
		let valorCj = parseFloat(document.getElementById('valor').value);
		let countWeight = parseFloat(parseFloat(document.getElementById('weight-bruto').innerText));
		let validaExis = 0;

		valorCj = valorCj * canxund;
		validaExis = valorCj + valorUnd;


		weight = weight + weightSecondary;

		let divisor = canxund || 1;

		let temp = weight / divisor;

		reference = (Math.floor(temp)).toFixed(2);

		referenceKg = ((temp - Math.floor(temp)) * divisor).toFixed(2);

		if ((countWeight + weight) > validaExis) {

			return 0;
		}

	}


	let arrival = '0000-00-00 00:00:00';


	let tk = 'POLLO';
	let ta = 'POLLO';

	let equivalent = 0;
	let extraAmount = 0;
	let extraTotal = 0;
	let json = [];



	if (amc == 0 || amc == '' || amc == null) {

		Swal.fire({
			title: "Error!",
			text: "Selecciona Almacén.",
			icon: "error"
		});

		return 0;

	}

	if (weight == 0 || weight == '' || weight == null) {

		Swal.fire({
			title: "Error!",
			text: "Realiza una captura de pesada",
			icon: "error"
		});

		return 0;

	}


	/*if (check.checked) {

		json = [];
		equivalent = 0;
		extraAmount = 0;
		extraTotal = 0;
		json[0] = { codigo: '0000', cantidad: 0, equivalente: 0 };

	} else {*/
	if (unit != 'UND') {


		var valuesExtraAmount = document.querySelectorAll('.cls-extra-amount');
		var valuesExtra = document.querySelectorAll('.cls-extra');


		valuesExtraAmount.forEach(function (element, index) {

			let aux = valuesExtra[index].value.split('|');
			if (element.value != '') {

				json[index] = { codigo: aux[0], cantidad: element.value, equivalente: aux[1] };


				extraAmount += parseFloat(element.value);
				extraTotal += parseFloat(aux[1]) * parseFloat(element.value);

			}


		});

		if (checkSausages.checked || indType) {


			json = [];
			equivalent = 0;
			extraAmount = 0;
			extraTotal = 0;
			json[0] = { codigo: '0000', cantidad: 0, equivalente: 0 };

		}

		if (check.checked && json == '') {
			json = [];
			equivalent = 0;
			extraAmount = 0;
			extraTotal = 0;
			json[0] = { codigo: '0000', cantidad: 0, equivalente: 0 };
		}

	} else {

		json[0] = { codigo: '0000', cantidad: 0, equivalente: 0 };
	}


	/*}*/


	if (check.checked) {

		if (weight != 0 && amc != '0') {


			let data = '<td> <button class="btn btn-danger shadow-danger p-2 mb-0" onclick="deleteRow(this)"> <i class="material-icons  text-lg">delete_forever</i></button></td>\
						<td>   <input type="time" class="form-control inputs-disable" name="dateStart[]" value="' + dateStart + '"  ></td>\
						<td> <input type="time"   class="form-control inputs-disable"  name="dateEnd[]" value="' + dateEnd + '"  ></td>\
						<td> <input type="number" class="form-control inputs-disable text-end"  value="' + (Number(extraAmount)).toFixed(2) + '"  ></td>\
						<td> <input type="number" class="form-control inputs-disable text-end"   value="' + (Number(extraTotal)).toFixed(2) + '"  ></td>\
						<td> <input type="number" class="form-control inputs-disable text-end"   value="0.00"  ></td>\
						<td> <div class="input-group input-group-dynamic mb-0"> <input type="number" class="form-control inputs-disable text-end" name="reference[]"  value="'+ (reference - extraTotal).toFixed(2) + '"  data-weight="' + weight + '" data-extra="' + extraTotal + '" data-cantextra="' + extraAmount + '"  data-arrival="' + arrival + '" data-tk ="' + tk + '" data-ta ="' + ta + '" data-json=' + JSON.stringify(json) + ' data-canxund="' + canxund + '"></div></td>';

			document.getElementById('relojStart').value = dateEnd;
			table.insertRow(-1).innerHTML = data;

			add();

			document.getElementById('weight-value').value = '0.00';

			cleanTable();
			validaSave = 1;

			// ------- RECALCULO DE PESADO----------
			recalculationHeavy();
			// ------- RECALCULO DE PESADO----------
		} else {


			Swal.fire({
				title: "Error!",
				text: "Datos o proceso incompleto.",
				icon: "error"
			});

		}

	} else {

		if (extraAmount != 0 && weight != 0 && extra != 0 && amc != '0') {
			let data = '<td> <button class="btn btn-danger shadow-danger p-2 mb-0" onclick="deleteRow(this)"> <i class="material-icons  text-lg">delete_forever</i></button></td>\
						<td>   <input type="time" class="form-control inputs-disable" name="dateStart[]" value="' + dateStart + '"  ></td>\
						<td> <input type="time"   class="form-control inputs-disable"  name="dateEnd[]" value="' + dateEnd + '"  ></td>\
						<td> <input type="number" class="form-control inputs-disable text-end"  value="' + (Number(extraAmount)).toFixed(2) + '"  ></td>\
						<td> <input type="number" class="form-control inputs-disable text-end"   value="' + (Number(extraTotal)).toFixed(2) + '"  ></td>\
						<td> <input type="number" class="form-control inputs-disable text-end"   value="0.00"  ></td>\
						<td> <div class="input-group input-group-dynamic mb-0"> <input type="number" class="form-control inputs-disable text-end" name="reference[]"  value="'+ (reference - extraTotal).toFixed(2) + '"  data-weight="' + weight + '" data-extra="' + extraTotal + '" data-cantextra="' + extraAmount + '"  data-arrival="' + arrival + '" data-tk ="' + tk + '" data-ta ="' + ta + '" data-json=' + JSON.stringify(json) + ' data-canxund="' + canxund + '"></div></td>';

			document.getElementById('relojStart').value = dateEnd;
			table.insertRow(-1).innerHTML = data;

			add();

			document.getElementById('weight-value').value = '0.00';

			cleanTable();
			validaSave = 1;

			// ------- RECALCULO DE PESADO----------
			recalculationHeavy();
			// ------- RECALCULO DE PESADO----------
		} else if (unit == 'UND' && (weight != 0 || weightSecondary != 0) && tk != '' && ta != '0°' || (checkSausages.checked || (indType && unit != 'UND'))) {

			if (checkSausages.checked || (indType && unit != 'UND')) {
				referenceKg = (Number(reference)).toFixed(2);
				reference = (Number(0)).toFixed(2);
			}

			let data = '<td> <button class="btn btn-danger shadow-danger p-2 mb-0" onclick="deleteRow(this)"> <i class="material-icons  text-lg">delete_forever</i></button></td>\
					<td>   <input type="time" class="form-control inputs-disable" name="dateStart[]" value="' + dateStart + '"  ></td>\
					<td> <input type="time"   class="form-control inputs-disable"  name="dateEnd[]" value="' + dateEnd + '"  ></td>\
					<td> <input type="number" class="form-control inputs-disable text-end"  value="' + (Number(extraAmount)).toFixed(2) + '"  ></td>\
					<td> <input type="number" class="form-control inputs-disable text-end"   value="' + (Number(extraTotal)).toFixed(2) + '"  ></td>\
					<td> <input type="number" class="form-control inputs-disable text-end"   value="' + (Number(reference)).toFixed(2) + '"  ></td>\
					<td> <div class="input-group input-group-dynamic mb-0"> <input type="number" class="form-control inputs-disable text-end" name="reference[]"  value="'+ (referenceKg - extraTotal).toFixed(2) + '"  data-weight="' + weight + '" data-extra="' + extraTotal + '" data-cantextra="' + extraAmount + '"  data-arrival="' + arrival + '" data-tk ="' + tk + '" data-ta ="' + ta + '" data-json=' + JSON.stringify(json) + ' data-canxund="' + canxund + '"></div></td>';


			document.getElementById('relojStart').value = dateEnd;
			table.insertRow(-1).innerHTML = data;

			add();

			document.getElementById('weight-value').value = '0.00';
			document.getElementById('weight-value-secondary').value = '0.00';

			cleanTable();

			validaSave = 1;

			// ------- RECALCULO DE PESADO----------
			recalculationHeavy();
			// ------- RECALCULO DE PESADO----------

		} else {
			Swal.fire({
				title: "Error!",
				text: "Validar los datos. 1",
				icon: "error"
			});
		}

	}


}

function deleteRow(index) {


	let row = index.parentNode.parentNode;
	let table = document.getElementById("table-date");
	let id = row.cells[6].querySelector('input').getAttribute('data-id') == '' ? false : row.cells[6].querySelector('input').getAttribute('data-id');

	//let amount = row.cells[6].querySelector('input').value;


	if (id) {

		Swal.fire({
			title: "Desear eliminar el registro?",
			text: "Presiona sí para continuar!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Sí, borrar!"
		}).then((result) => {
			if (result.isConfirmed) {



				var request = (window.XMLHttpRequest) ?
					new XMLHttpRequest() :
					new ActiveXObject('Microsoft.XMLHTTP');

				var ajaxUrl = base_url + '/PedidosPollo/delete?id=' + id;

				request.open("GET", ajaxUrl, true);
				request.send();
				request.onreadystatechange = function () {

					if (request.readyState != 4) return;
					if (request.status == 200) {
						var objData = JSON.parse(request.responseText);

						if (objData.status) {

							table.deleteRow(row.rowIndex - 1);
							Swal.fire({
								position: "center",
								icon: "success",
								title: objData.msg,
								showConfirmButton: false,
								timer: 1000
							});

							add();

							recalculationHeavy();

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

	} else {
		table.deleteRow(row.rowIndex - 1);
		add();
		recalculationHeavy();
	}


}



function add() {
	let und = document.getElementById('codigo-und').textContent;
	let canxund = parseFloat(document.getElementById('canxund').value);

	let table = document.getElementById('table-date');

	let total_value = 0;
	let total_bruto = 0;

	Array.from(table.rows).forEach(function (element, index) {
		let inputElement = element.cells[6].querySelector('input');

		if (inputElement) {
			if (canxund >= 1 && und != 'KG') {
				let dataWeight = parseFloat(inputElement.getAttribute('data-weight')) || 0;
				total_value += isNaN(dataWeight) ? 0 : dataWeight;
				total_bruto = isNaN(total_value) ? 0 : total_value;
			} else {
				let inputValue = parseFloat(inputElement.value) || 0;
				let dataExtra = parseFloat(inputElement.getAttribute('data-extra')) || 0;

				total_value += isNaN(inputValue) ? 0 : inputValue;
				total_bruto += inputValue + dataExtra;
			}
		}
	});

	document.getElementById('weight-total').textContent = total_value.toFixed(2);
	document.getElementById('weight-bruto').textContent = total_bruto.toFixed(2);

	addExtra();
}

function addExtra() {
	let table = document.getElementById('table-date');

	total_extra = 0;
	Array.from(table.rows).forEach(function (element, index) {

		let inputElement = element.cells[6].querySelector('input');

		if (inputElement) {
			let dataExtraAttribute = inputElement.getAttribute('data-extra');
			if (dataExtraAttribute) {
				let dataExtra = parseFloat(dataExtraAttribute);
				if (!isNaN(dataExtra)) {
					total_extra += dataExtra;
				}
			}
		}

	});

	document.getElementById('weight-extra').textContent = total_extra.toFixed(2);
}


function setInfoDetails(data) {
	event.preventDefault();

	if (validaSave != 0) {
		Swal.fire({
			title: "Advertencia, debes guardar las pesadas.",
			text: "Presiona sí para continuar!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Sí, continuar!"
		}).then((result) => {
			if (result.dismiss == 'cancel' || result.dismiss == 'backdrop') {
				console.log(result.dismiss);
				return 0;
			} else {

				validaSave = 0;
				setInfo(data);


			}
		});
	} else {
		setInfo(data);
	}

}

function setInfo(data) {


	//-----------------ABORTA LAS PETICION HTTP SI SE PRESIONA VARIAS VECES UN ITEM--------------------

	if (request) {
		request.abort();
	}
	//-----------------ABORTA LAS PETICION HTTP SI SE PRESIONA VARIAS VECES UN ITEM--------------------

	//-----------------DESHABILITA LOS CHECK--------------------

	document.getElementById("embutidos").checked = false;
	document.getElementById("otros").checked = false;


	//-----------------DESHABILITA LOS CHECK--------------------

	var ajaxUrl = '';


	let fields = document.querySelectorAll('.disguise');
	let showfields = document.querySelectorAll('.show-fields');
	let disguiseBtn = document.querySelectorAll('.disguise-btn');
	let styleFields = document.querySelectorAll('.weight');
	let closed = parseFloat(document.getElementById('dcg-pesadas').value);
	let aptionRow = '';

	/********* ACTIVA BOTON DE BORRA O NO SI UN DOCUMENTO ESTÁ CERRADO ************/
	if (!closed) {
		aptionRow = 'onclick="deleteRow(this)"';
	}
	/********* ACTIVA BOTON DE BORRA O NO SI UN DOCUMENTO ESTÁ CERRADO ************/



	document.getElementById('weight-value').value = 0.00;

	if (data != null) {

		ajaxUrl = data.getAttribute('href');

		document.getElementById('codigo-pdt').textContent = data.dataset.pdt;
		document.getElementById('codigo-und').textContent = data.dataset.und;
		document.getElementById('input-und').textContent = data.dataset.und;
		document.getElementById('canxund').value = data.dataset.canxund;
		document.getElementById('valor').value = parseFloat(data.dataset.valor.replace(",", ""));


		let spans = document.querySelectorAll('.symbol-und');


		spans.forEach((span) => {
			span.textContent = data.dataset.und;
		});


		document.getElementById('weight-value').focus();

		if (data.dataset.und == 'UND') {

			document.getElementById('input-und').textContent = 'CJ';
			document.getElementById('weight-value').value = parseFloat(data.dataset.exiscj.replace(",", ""));


			fields.forEach(function (element) {
				element.style.display = 'none';

			});


			disguiseBtn.forEach(function (element) {
				element.style.display = 'none';
			});

			showfields.forEach(function (element) {
				element.classList.remove('d-none');
				element.style.display = 'flex';

			});

			styleFields.forEach(function (element) {

				element.style.border = '1px solid red';
			});


			document.getElementById('manual-label').style.display = 'inline-block';


			document.getElementById('weight-value').readOnly = false;
			document.getElementById('weight-value-secondary').value = 0;



		} else {


			fields.forEach(function (element) {

				element.style.display = 'inline-block';

			});

			showfields.forEach(function (element) {
				element.style.display = 'none';

			});


			disguiseBtn.forEach(function (element) {
				element.style.display = 'flex';
			});


			document.getElementById('manual-label').style.display = 'none';
			document.getElementById('weight-value').readOnly = true;
			document.getElementById('weight-value').style.border = '0px solid red';

			if (indType) {
				document.getElementById('weight-value').value = document.getElementById('valor').value;
				document.getElementById('weight-value').readOnly = false;
			}


		}





	} else {


		let dpvNumber = document.getElementById('dpv_numero').value;
		let pdtCodigo = document.getElementById('codigo-pdt').textContent;
		let dpvProvider = document.getElementById('dpv_pvd').value;

		ajaxUrl = base_url + "/PedidosPollo/content?id=" + dpvNumber + "&vd=" + dpvProvider + "&pdt=" + pdtCodigo;


	};


	let table = document.getElementById('table-date');

	table.innerHTML = '';

	request = (window.XMLHttpRequest) ?
		new XMLHttpRequest() :
		new ActiveXObject('Microsoft.XMLHTTP');



	request.open("GET", ajaxUrl, true);
	request.send();
	request.onreadystatechange = function () {

		if (request.readyState != 4) return;
		if (request.status == 200) {
			var objData = JSON.parse(request.responseText);

			var indicador = 0;
			var saveElement = document.getElementById('save');
			if (saveElement) {
				document.getElementById('save').style.display = 'inline-block'
				console.log('El elemento "save" existe en el DOM.');
			}

			objData.forEach(function (element, index) {

				let divisor = element.PDA_CANXUND || 1;
				let referenceCj = element.PDA_UPP_UND_ID === 'UND' ? (Math.floor(element.PDA_CANTIDAD / divisor)).toFixed(2) : 0;
				let temp = element.PDA_CANTIDAD / divisor;
				let referenceKg = element.PDA_UPP_UND_ID === 'KG' ? (Number(element.PDA_CANTIDAD - element.PDA_EXTRA)).toFixed(2) : ((temp - Math.floor(temp)) * divisor).toFixed(2);

				let data = '<td> <button class="btn btn-danger shadow-danger p-2 mb-0" ' + aptionRow + '> <i class="material-icons  text-lg">delete_forever</i></button></td>\
							<td>   <input type="time" class="form-control inputs-disable" name="dateStart[]" value="' + element.PDA_INICIO + '"  ></td>\
							<td> <input type="time" class="form-control inputs-disable"  name="dateEnd[]" value="' + element.PDA_FIN + '"  ></td>\
							<td> <input type="number" class="form-control inputs-disable text-end"  value="' + element.PDA_CANASTA + '"  ></td>\
							<td> <input type="number" class="form-control inputs-disable text-end"  value="' + element.PDA_EXTRA + '"  ></td>\
							<td> <input type="number" class="form-control inputs-disable text-end"  value="' + (Number(referenceCj)).toFixed(2) + '"  ></td>\
							<td> <div class="input-group input-group-dynamic mb-0"> <input onkeypress="updateDetails(event)" type="number" class="form-control inputs-disable text-end" value="'+ referenceKg + '" name="reference[]" data-weight="' + element.PDA_CANTIDAD + '" data-extra="' + element.PDA_EXTRA + '" data-cantextra="' + element.PDA_CANASTA + '" data-canasta="' + element.PDA_CANASTA_TIPO + '" data-id="' + element.ID + '"  data-arrival="' + element.PDA_LLEGADA + '"  data-tk="' + element.PDA_TK + '"  data-ta="' + element.PDA_TA + '"  "></div></td>';



				if (element.PDA_MOTIVO != '') {
					indicador = 1;
					data = '<td> OMITIDO </td>\
									<td> OMITIDO </td>\
									<td> OMITIDO </td>\
									<td> OMITIDO </td>\
									<td> OMITIDO </td>\
									<td> OMITIDO </td>\
									<td> OMITIDO </td>';

					const saveButton = document.getElementById('save');
					if (saveButton) {
						saveButton.style.display = 'none';
					}
				}


				table.insertRow(-1).innerHTML = data;

			});


			if (indicador != 1) {
				add();
			}


		} else {
			//	Swal.fire("Atención", "Error en el proceso", "error");
		}

	}




}
function insertDetails() {


	var forData = new FormData();

	let dataDateStart = document.querySelectorAll('input[name="dateStart[]"]');
	let dataDateEnd = document.querySelectorAll('input[name="dateEnd[]"]');

	let data = document.querySelectorAll('input[name="reference[]"]');

	let dpvNumber = document.getElementById('dpv_numero').value;
	let pdtCodigo = document.getElementById('codigo-pdt').textContent;
	let undCodigo = document.getElementById('codigo-und').textContent;
	let dpvProvider = document.getElementById('dpv_pvd').value;
	let canxund = document.getElementById('canxund').value;

	let amc = document.getElementById('amc').value;
	let weightTotal = parseFloat(document.getElementById('weight-total').innerText);

	if (canxund >= 1 && undCodigo == 'UND') {
		weightTotal = parseFloat(weightTotal / canxund).toFixed(2);
	}





	if (pdtCodigo != '0000') {

		data.forEach(function (element, index) {

			forData.append("PDA_NUMERO", dpvNumber);
			forData.append("PDA_AMC_ORIGEN", '001');
			forData.append("PDA_AMC_DESTINO", amc);
			forData.append("PDA_SCS_CODIGO", '000001');
			forData.append("PDA_UPP_PDT_CODIGO", pdtCodigo);
			forData.append("PDA_DET_CODIGO", dpvProvider);
			forData.append("PDA_UPP_UND_ID", undCodigo);
			forData.append("PDA_CANXUND", canxund);
			forData.append("PDA_CANTIDAD[]", element.dataset.weight);
			forData.append("PDA_CANASTA_TIPO[]", element.dataset.json);
			forData.append("PDA_CANASTA[]", element.dataset.cantextra);
			forData.append("PDA_EXTRA[]", element.dataset.extra);
			forData.append("PDA_UBICA[]", '00001');
			forData.append("PDA_FECHA_INICIO[]", dataDateStart[index].value);
			forData.append("PDA_FECHA_FIN[]", dataDateEnd[index].value);
			forData.append("PDA_LLEGADA", '0000-00-00 00:00:00');
			forData.append("PDA_TK", element.dataset.tk);
			forData.append("PDA_TA", element.dataset.ta);

		});

		try {
			document.getElementById('spinner-lots-save').classList.add('spinner-border');
			document.getElementById('label-spinner-save').classList.add('d-none');
		} catch (error) {

		}

		var request = (window.XMLHttpRequest) ?
			new XMLHttpRequest() :
			new ActiveXObject('Microsoft.XMLHTTP');

		var ajaxUrl = base_url + '/PedidosPollo/insertDetails';



		request.open("POST", ajaxUrl, true);
		request.send(forData);
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
					validaSave = 0;
					setInfoDetails(null);
					setStyleWeight(pdtCodigo, weightTotal);
				} else {

					Swal.fire({
						title: "Error!",
						text: objData.msg,
						icon: "error"
					});
				};

				try {
					let spinner = document.getElementById('spinner-lots-save');
					let label = document.getElementById('label-spinner-save');
					if (spinner && label) {
						spinner.classList.remove('spinner-border');
						label.classList.remove('d-none');
					}
				} catch (error) {
					console.error('Error updating spinner elements:', error);
				}
			} else {
				Swal.fire("Atención", "Error en el proceso", "error");
				try {
					let spinner = document.getElementById('spinner-lots-save');
					let label = document.getElementById('label-spinner-save');
					if (spinner && label) {
						spinner.classList.remove('spinner-border');
						label.classList.remove('d-none');
					}
				} catch (error) {
					console.error('Error updating spinner elements:', error);
				}
			}

		}
	} else {

		Swal.fire("Atención", "Selecciona un sku", "error");

	}




}

function updateDetails(event) {

	if (event.keyCode == 13) {


		var forData = new FormData();

		let row = event.target.parentNode.parentNode
		let table = document.getElementById("table-date");
		let id = row.querySelector('input').getAttribute('data-id');
		let cantidad = row.querySelector('input').value;


		forData.append("PDA_ID", id);
		forData.append("PDA_CANTIDAD", cantidad);


		var request = (window.XMLHttpRequest) ?
			new XMLHttpRequest() :
			new ActiveXObject('Microsoft.XMLHTTP');

		var ajaxUrl = base_url + '/PedidosPollo/updateDetails';

		console.log(ajaxUrl);

		request.open("POST", ajaxUrl, true);
		request.send(forData);
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

					add();
				} else {

					Swal.fire({
						title: "Error!",
						text: objData.msg,
						icon: "error"
					});
				};

			} else {
				Swal.fire("Atención", "Error en el proceso", "error");
			}

		}



	}






}

function closeCount() {

	let indicador = 0;


	if (indType) {
		
		indicador = validatePresale();
	}

	Swal.fire({
		title: "Cerrar el conteo?",
		text: indicador ? " Verificar cantidades, existe un item con monto diferente a lo pesado." : "Presiona sí para continuar!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Sí, cerrar!",
		input: indicador ? 'password' : null,
		inputPlaceholder: 'Ingresa el número de verificación',
		inputAttributes: {
			style: 'color: white;'
		},
		inputValidator: (value) => {
			if (value != '0024') {
				return '¡Clave incorrecta!';
			}
		}
	}).then((result) => {
		if (result.isConfirmed) {
			let details = new FormData();
			
			let dpvNumber = document.getElementById('dpv_numero').value;
			let dpvProvider = document.getElementById('dpv_pvd').value;

			details.append('NUMBER', dpvNumber);

			details.append('PROVIDER', dpvProvider);

			var request = (window.XMLHttpRequest) ?
				new XMLHttpRequest() :
				new ActiveXObject('Microsoft.XMLHTTP');

			var ajaxUrl = base_url + '/PedidosPollo/getDetailsToEdit';

			request.open("POST", ajaxUrl, true);
			request.send(details);
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

						add();
						window.location.href = base_url + '/PedidosPollo/document';
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

function addRow() {

	let optionsData = document.getElementById('select-options').getAttribute('data-options');
	let options = JSON.parse(optionsData);
	let tableBody = document.getElementById('tableBody');
	let newRow = document.createElement('tr');


	row = `
	<tr><td> <div class="d-flex w-100">   <button type="button" class="btn btn-danger py-2 px-3 m-0 justify-content-center d-flex" onclick="clearRow(this)">-</button> </div> </td>
		<td>
		<div class="input-group input-group-static m-1">
		<select class="form-control cls-extra" >
		`;

	options.forEach(function (element, index) {

		row += '<option class="text-dark" value="' + element.CTA_CODIGO + '|' + element.CTA_EQUIVALENCIA + '">' + element.CTA_DESCRIPCION + ' - ' + element.CTA_EQUIVALENCIA + '</option>';

	});

	row += `
	</select>
	</div>
	</td>
	  	<td> 
			<div class="input-group input-group-outline my-1">
	  			<input type="number" onkeyup="" class="form-control cls-extra-amount">
  			</div>
		</td>
  		<td>
		  	<div class="d-flex w-100">
                <button type="button" class="btn btn-success py-2 px-3 m-0 justify-content-center d-flex" onclick="addRow()">+</button>
              
             </div>
		</td>
	  </tr>
	`;

	tableBody.insertRow(-1).innerHTML = row;

	//tableBody.append(row);
}

function clearRow(data) {

	let row = data.parentNode.parentNode.parentNode;
	let table = document.getElementById("tableBody");


	table.deleteRow(row.rowIndex - 1);

}

function cleanTable() {
	let table = document.getElementById("tableBody");
	let seleted = document.getElementById("extra");

	table.innerHTML = '';

	document.getElementById('extra_amount').value = '';

	seleted.options[1].setAttribute('selected', 'true');

}




function ignoreHeavy(data) {

	let node = data.parentNode.parentNode.parentNode;


	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: 'btn btn-success',
			cancelButton: 'btn btn-danger'
		},
		buttonsStyling: false
	})

	swalWithBootstrapButtons.fire({
		title: 'Introduce la clave y selecciona una opción',
		html:
			'<input type="password" id="swal-input1" class="swal2-input" placeholder="Clave">' +
			'<select id="swal-input2" class="swal2-input mt-3 select-control">' +
			'<option  selected value="0" > -- Selecciona una opción -- </option>' +
			'<option value="AUSENCIA"> - Ausencia.</option>' +
			'<option value="OTROS"> - Otros.</option>' +
			'</select>',
		focusConfirm: false,
		preConfirm: () => {
			return [
				document.getElementById('swal-input1').value,
				document.getElementById('swal-input2').value
			]
		}
	}).then((result) => {
		if (result.isConfirmed) {

			let password = result.value[0];
			let option = result.value[1];


			if (option == 0) {
				Swal.fire("Atención", "Seleccione motivo.", "error");
				return 0;
			}

			if (password != '0012') {
				Swal.fire("Atención", "Clave incorrecta.", "error");
				return 0;
			}


			var formSkip = new FormData();
			let dataDateStart = '00:00:00';
			let dataDateEnd = '00:00:00';

			let dpvNumber = node.getAttribute('data-number');
			let dpvProvider = node.getAttribute('data-det');
			let pdtCodigo = node.getAttribute('data-pdt');
			let undCodigo = node.getAttribute('data-und')
			let canxund = node.getAttribute('data-canxund');

			let json = { codigo: '0000', cantidad: 0, equivalente: 0 };


			let tk = '0';
			let ta = '0';


			formSkip.append("PDA_NUMERO", dpvNumber);
			formSkip.append("PDA_AMC_ORIGEN", '001');
			formSkip.append("PDA_AMC_DESTINO", '001');
			formSkip.append("PDA_SCS_CODIGO", '000001');
			formSkip.append("PDA_UPP_PDT_CODIGO", pdtCodigo);
			formSkip.append("PDA_DET_CODIGO", dpvProvider);
			formSkip.append("PDA_UPP_UND_ID", undCodigo);
			formSkip.append("PDA_CANXUND", canxund);
			formSkip.append("PDA_CANTIDAD", '0');
			formSkip.append("PDA_CANASTA_TIPO", JSON.stringify(json));
			formSkip.append("PDA_CANASTA", '0');
			formSkip.append("PDA_EXTRA", '0');
			formSkip.append("PDA_UBICA", '00001');
			formSkip.append("PDA_FECHA_INICIO", dataDateStart);
			formSkip.append("PDA_FECHA_FIN", dataDateEnd);
			formSkip.append("PDA_LLEGADA", '0000-00-00 00:00:00');
			formSkip.append("PDA_TK", tk);
			formSkip.append("PDA_TA", ta);
			formSkip.append("PDA_MOTIVO", option);



			var request = (window.XMLHttpRequest) ?
				new XMLHttpRequest() :
				new ActiveXObject('Microsoft.XMLHTTP');

			var ajaxUrl = base_url + '/PedidosPollo/insertSkip';

			console.log(ajaxUrl);

			request.open("POST", ajaxUrl, true);
			request.send(formSkip);
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
						data.classList.remove('btn-outline-success');
						data.classList.add('btn-danger')


						setInfoDetails(null);
					} else {

						Swal.fire({
							title: "Error!",
							text: objData.msg,
							icon: "error"
						});
					};

				} else {
					Swal.fire("Atención", "Error en el proceso", "error");
				}

			}


		}
	});

}

function efectSelected() {
	document.querySelectorAll('.details-odc-style').forEach(function (item) {
		item.addEventListener('click', function () {

			var selectedItem = document.querySelector('.details-odc-style.selected');
			if (selectedItem) {
				selectedItem.classList.remove('selected');
			}


			this.classList.add('selected');
		});
	});
}

function setStyleWeight(codigo, cantidad) {


	let anchors = document.querySelectorAll('.list-group a');
	let cantidadNew = parseFloat(cantidad).toFixed(2);
	console.log(cantidad);


	anchors.forEach(anchor => {

		let element = anchor.closest('a');


		if (anchor.getAttribute('data-pdt') === codigo && cantidadNew != 0) {

			element.querySelector('#exis-pesado').textContent = cantidadNew;
			element.querySelector('li').classList.remove('selected');
			element.querySelector('li').classList.remove('details-odc-style');
			element.querySelector('li').classList.remove('border', 'border-danger');
			element.querySelector('li').classList.add('details-odc-style-weight');

		}
		else if (anchor.getAttribute('data-pdt') === codigo) {

			element.querySelector('#exis-pesado').textContent = cantidadNew;
			element.querySelector('li').classList.add('details-odc-style');
			element.querySelector('li').classList.remove('details-odc-style-weight');

		}
	});
}

function seeLots() {

	let pdtUnd = document.getElementById('codigo-und').textContent;
	let pdtCode = document.getElementById('codigo-pdt').textContent;

	document.getElementById('table-lotes').innerHTML = '';
	document.getElementById('spinner-lots').classList.add('spinner-border');

	var request = (window.XMLHttpRequest) ?
		new XMLHttpRequest() :
		new ActiveXObject('Microsoft.XMLHTTP');

	var ajaxUrl = base_url + '/PedidosPollo/seeLots?pdt=' + pdtCode + '&und=' + pdtUnd;

	request.open("GET", ajaxUrl, true);
	request.send();
	request.onreadystatechange = function () {

		if (request.readyState != 4) return;
		if (request.status == 200) {
			var objData = JSON.parse(request.responseText);
			let rows = '';





			objData.forEach(function (element, index) {

				rows += `<tr>
                               <td class="text-sm">${element.LOTE}</td>
                                <td class="text-sm">${element.DISPONIBLE}</td>
                                <td class="text-sm">${element.FECHALOTE}</td>
                           </tr>`;

			});

			document.getElementById('table-lotes').innerHTML = rows;

			console.log(objData);


			document.getElementById('spinner-lots').classList.remove('spinner-border');

		} else {
			Swal.fire({
				title: "Error!",
				text: 'Conexion.',
				icon: "error"
			});
		}

	}


}





function reportDetailsPesada() {

	let pdtCodigo = document.getElementById('codigo-pdt').innerText;
	let dclCodigo = document.getElementById('dpv_numero').value;
	let traCodigo = document.getElementById('dpv_pvd').value;

	var ajaxUrl =
		base_url +
		"/PedidosPollo/viewPdfDetailsPesada?id=" +
		dclCodigo +
		"&vd=" +
		traCodigo +
		"&pdt=" +
		pdtCodigo;

	window.open(ajaxUrl);
}


async function cut() {
	event.preventDefault();

	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: 'btn btn-success',
			cancelButton: 'btn btn-danger'
		},
		buttonsStyling: false
	});

	try {
		const result = await swalWithBootstrapButtons.fire({
			title: 'Advertencia, ésto cortará procesos en espera en Sistemas ADN.',
			html: '<input type="password" id="swal-input4" class="swal2-input" placeholder="Clave">',
			focusConfirm: false,
			preConfirm: () => {
				return document.getElementById('swal-input4').value;
			}
		});

		if (result.isConfirmed) {
			const password = result.value;

			if (password !== '159753') {
				Swal.fire("Atención", "Clave incorrecta.", "error");
				return;
			}

			const ajaxUrl = base_url + '/PedidosPollo/cut';
			const response = await fetch(ajaxUrl);

			if (!response.ok) {
				throw new Error('Error en la solicitud.');
			}

			const objData = await response.json();

			if (objData.status) {
				Swal.fire({
					title: "Excelente!",
					text: objData.msg,
					icon: "success"
				});
			} else {
				Swal.fire({
					title: "Error!",
					text: objData.msg,
					icon: "error"
				});
			}
		}
	} catch (error) {
		console.error('Error en la solicitud:', error);
		Swal.fire("Atención", "Error en el proceso", "error");
	}
}


function ticketByHeavy(data) {
	let pdtCodigo = document.getElementById('codigo-pdt').innerText;
	let dclCodigo = document.getElementById('dpv_numero').value;
	let traCodigo = document.getElementById('dpv_pvd').value;

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

			var ajaxUrl = base_url + '/PedidosPollo/ticketByHeavy?id=' + dclCodigo + '&vd=' + traCodigo + '&pdt=' + pdtCodigo;

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
						title: "Conexión. Error",
						showConfirmButton: false,
						timer: 1000
					});
				}

			}





		}
	});


}

function validatePresale() {


	var interator = 0;
	let elemets = document.querySelectorAll('.list-group a');


	elemets.forEach(element => {
		let indicator = element.getAttribute('data-und');
		let exist = parseFloat(element.querySelector(indicator == 'KG' ? '#exis-und' : '#exis-cj').textContent);
		let heavy = parseFloat(element.querySelector('#exis-pesado').textContent);

		if (heavy != exist) {

			let parent = element.closest('a')
			interator = 1;
			parent.querySelector('li').classList.add('border', 'border-danger');

		}
	});








	if (interator) {




		//---------------------------------------------------------------
		Swal.fire({
			position: "center",
			icon: "warning",
			text: "Verificar cantidades, existe un item con monto diferente a lo pesado.",
			showConfirmButton: false,
			timer: 2000
		});

	}

	return interator;
}

function recalculationHeavy() {

	let pdtCodigo = document.getElementById('codigo-pdt').textContent;
	let undCodigo = document.getElementById('codigo-und').textContent;
	let canxund = document.getElementById('canxund').value;
	let weightTotal = 0;

	weightTotal = parseFloat(document.getElementById('weight-total').innerText);


	if (canxund >= 1 && undCodigo == 'UND') {
		weightTotal = parseFloat(weightTotal / canxund).toFixed(2);
	}


	setStyleWeight(pdtCodigo, weightTotal);

}

function eventPressEnter() {

	var pressInput = document.getElementById('weight-value');

	pressInput.addEventListener('keyup', function (event) {
		if (pressInput) {

			if (event.key == 'Enter') {
				aggRow();
			};
		}
	});
}
