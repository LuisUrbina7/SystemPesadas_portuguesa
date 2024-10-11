function view_edit_canasta(parametro){
	var codigo_canasta = parametro;
	Swal.fire({
		title: 'Editar Canasta!',
		text: 'Seguro que quieres editar?',
		icon: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, Editar',
		cancelButtonText: 'No, Cancelar'
	  }).then((result) => {
		if (result.isConfirmed) {
		
		  window.location.href = base_url + `/Canastas/view_update_canasta?canasta=${codigo_canasta}`;
		} else {
		
		  console.log('Editar canasta, cancelado!');
		}
	  });
		

}



function view_create_canasta(parametro){
	var codigo_canasta = parametro;
	Swal.fire({
		title: 'Crear Canasta!',
		text: 'Seguro que quieres crear?',
		icon: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, Crear',
		cancelButtonText: 'No, Cancelar'
	  }).then((result) => {
		if (result.isConfirmed) {
		
		  window.location.href = base_url + `/Canastas/view_create_canasta`;
		} else {
		
		  console.log('Editar canasta, cancelado!');
		}
	  });
		

}
function create_canasta(){
	
	let formHtml = new FormData();
	let codigo_canasta = document.getElementById('codigo_canasta').value;
	let descripcion_canasta = document.getElementById('descripcion_canasta').value;
	let equivalencia_canasta = document.getElementById('equivalencia_canasta').value;
	


	if(codigo_canasta == '' || descripcion_canasta == '' || equivalencia_canasta == ''){
		Swal.fire({
			title: 'Alerta!',
			text: 'No dejes campos vacios',
			confirmButtonColor: '#d33',
			confirmButtonText: 'Ok'
			
		  })

		  return false;
	} else {

		formHtml.append("CTA_CODIGO", codigo_canasta);
		formHtml.append("CTA_DESCRIPCION", descripcion_canasta);
		formHtml.append("CTA_EQUIVALENCIA", equivalencia_canasta);
		


		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = base_url + '/Canastas/insert_canasta';
	
		request.open("POST", ajaxUrl, true);
		request.send(formHtml);
		request.onreadystatechange = function () {
			if (request.readyState != 4) return;
			if (request.status == 200) {
				var objData = JSON.parse(request.responseText);

				console.log(objData);
				if (objData.status) {
					Swal.fire({
						title: "Canasta Creada!",
						text: objData.msg,
						icon: "success"
					}).then((result) => {
						if (result.isConfirmed) {
						  
						  window.location = base_url + '/Canastas';
						} else {
						
						  console.log('Basket editing canceled');
						}
					  });
					

				} else {

					

				}
			} else {
				Swal.fire("Attention", "Error in the process", "error");
			}
			//divLoading.style.display = "none";
			return false;
		}

	}

}


function update_canasta(){

	let formHtml = new FormData();
	let codigo_canasta = document.getElementById('codigo_canasta').value;
	let descripcion_canasta = document.getElementById('descripcion_canasta').value;
	let equivalencia_canasta = document.getElementById('equivalencia_canasta').value;
	let activo_canasta = document.getElementById('checkbox').checked;


	if(codigo_canasta == '' || descripcion_canasta == '' || equivalencia_canasta == ''){
		Swal.fire({
			title: 'Alerta!',
			text: 'No dejes campos vacios',
			confirmButtonColor: '#d33',
			confirmButtonText: 'Ok'
			
		  })

		  return false;
	} else {

		if(activo_canasta){
			activo_canasta = 1;
		} else {
			activo_canasta = 0;
		}


		formHtml.append("CTA_CODIGO", codigo_canasta);
		formHtml.append("CTA_DESCRIPCION", descripcion_canasta);
		formHtml.append("CTA_EQUIVALENCIA", equivalencia_canasta);
		formHtml.append("CTA_ACTIVO", activo_canasta);


		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = base_url + '/Canastas/update_canastas';
	
		request.open("POST", ajaxUrl, true);
		request.send(formHtml);
		request.onreadystatechange = function () {
			if (request.readyState != 4) return;
			if (request.status == 200) {
				var objData = JSON.parse(request.responseText);

				console.log(objData);
				if (objData.status) {
					Swal.fire({
						title: "Canasta Actualizada!",
						text: objData.msg,
						icon: "success"
					}).then((result) => {
						if (result.isConfirmed) {
						  
						  window.location = base_url + '/Canastas';
						} else {
						
						  console.log('Basket editing canceled');
						}
					  });
					

				} else {

					

				}
			} else {
				Swal.fire("Attention", "Error in the process", "error");
			}
			//divLoading.style.display = "none";
			return false;
		}

	}
}
	



	
function delete_canasta(codigo){
	


	let formHtml = new FormData();

	Swal.fire({
		title: 'Eliminar Canasta!',
		text: 'Seguro que quieres eliminar?',
		icon: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, Editar',
		cancelButtonText: 'No, Cancelar'
	  }).then((result) => {
		if (result.isConfirmed) {
		
						formHtml.append("CTA_CODIGO", codigo);
					
						var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
						var ajaxUrl = base_url + '/Canastas/delete_canasta';
					
						request.open("POST", ajaxUrl, true);
						request.send(formHtml);
						request.onreadystatechange = function () {
							if (request.readyState != 4) return;
							if (request.status == 200) {
								var objData = JSON.parse(request.responseText);
				
								console.log(objData);
								if (objData.status) {
				
									Swal.fire({
										title: "Canasta Eliminada",
										text: objData.msg,
										icon: "success"
									}).then(() => {
										window.location.reload();
									});
				
								}
									
							} else {
								Swal.fire("Atencion", "Hubo un error, no se pudo eliminar!", "error");
							}
							//divLoading.style.display = "none";
							return false;
			} 
		} else {
		
		  console.log('Editar canasta, cancelado!');

		  
		}
	  });
		

	

	}
