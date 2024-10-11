document.addEventListener('DOMContentLoaded', function () {

    
});

function fntViewTicket(objetoJSON) {

    var jsonString = JSON.stringify(objetoJSON);
    var dataTikect = {
		id_ticket: objetoJSON.ticket,
		fecha_creacion: objetoJSON.fechaCreacion,
		creador: objetoJSON.creador,
		prioridad: objetoJSON.prioridad,
		tecnico: objetoJSON.tecnico,
        departamento: objetoJSON.departamento,
        origen: objetoJSON.origen,
        descripcion: objetoJSON.descripcion,
        nombre:objetoJSON.nombre,
        servicio:objetoJSON.servicio,
        direccion:objetoJSON.direccion,
        asunto:objetoJSON.asunto
	};


    console.log(dataTikect);

	document.getElementById('tickect').value = dataTikect['id_ticket'];
	document.getElementById('creation').value = dataTikect['fecha_creacion'];
	document.getElementById('creator').value = dataTikect['creador'];
    document.getElementById('priority').value = dataTikect['prioridad'];
    document.getElementById('technical').value = dataTikect['tecnico'];
	document.getElementById('department').value = dataTikect['departamento'];
    document.getElementById('origin').value = dataTikect['origen'];
    document.getElementById('description').value = dataTikect['descripcion'];
    document.getElementById('matter').value = dataTikect['asunto'];

    document.getElementById('name').innerHTML = dataTikect['nombre'];
    document.getElementById('services').innerHTML = dataTikect['servicio'];
    document.getElementById('address').innerHTML = dataTikect['direccion'];

	$('#modalViewTicket').modal('show');
};