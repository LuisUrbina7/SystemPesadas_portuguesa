
var total_value, total_extra = 0;

document.addEventListener('DOMContentLoaded', function () {





}, false);


function generatePdfGeneral(data) {


  let values = data.split('|');
  let numero = values[0];
  let codigo = values[1];
  let sucursal = values[2];

  console.log(values);

  var ajaxUrl = base_url + '/AutoVenta/generatePdfGeneral?id=' + numero + '&clt=' + codigo + '&scs=' + sucursal;

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
    "/AutoVenta/viewPdf?id=" +
    numero +
    "&clt=" +
    codigo +
    "&scs=" +
    sucursal;

  //var ajaxUrl = base_url + '/Document/generatePdf?id=' + numero + '&pv=' + codigo + '&scs=' + sucursal;

  console.log(ajaxUrl);

  window.open(ajaxUrl);
}



function sale(data) {


  let number = data.getAttribute('data-number');
  let clt = data.getAttribute('data-clt');
  let scs = data.getAttribute('data-scs');
  let table = document.getElementById("table-sale");
  let row = data.parentNode.parentNode;



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

      var ajaxUrl = base_url + '/AutoVenta/deleteDocument?id=' + number + '&clt=' + clt + '&scs=' + scs + '&type=5';

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


function ticket(data) {
  let values = data.split("|");
  let numero = values[0];
  let codigo = values[1];
  let sucursal = values[2];

  console.log(values);



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

      var ajaxUrl = base_url + "/AutoVenta/ticket?id=" + numero + "&clt=" + codigo + "&scs=" + sucursal;

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
              icon: "Error",
              title: objData.msg,
              showConfirmButton: false,
              timer: 1000
            });
          };

        } else {
          Swal.fire({
            position: "center",
            icon: "Error",
            title: "Conexión.",
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

  console.log(values);



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

      var ajaxUrl = base_url + "/AutoVenta/ticketGeneral?id=" + numero + "&clt=" + codigo + "&scs=" + sucursal;

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
              icon: "Error",
              title: objData.msg,
              showConfirmButton: false,
              timer: 1000
            });
          };

        } else {
          Swal.fire({
            position: "center",
            icon: "Error",
            title: "Conexión.",
            showConfirmButton: false,
            timer: 1000
          });
        }

      }

    }
  });
}

