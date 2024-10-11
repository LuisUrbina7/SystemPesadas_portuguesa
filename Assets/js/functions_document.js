
var total_value, total_extra = 0;

document.addEventListener('DOMContentLoaded', function () {









}, false);


function generatePdfGeneral(data) {


  let values = data.split('|');
  let numero = values[0];
  let codigo = values[1];
  let sucursal = values[2];

  console.log(values);

  var ajaxUrl = base_url + '/Document/generatePdfGeneral?id=' + numero + '&pv=' + codigo + '&scs=' + sucursal;

  //var ajaxUrl = base_url + '/Document/generatePdf?id=' + numero + '&pv=' + codigo + '&scs=' + sucursal;

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
    "/Document/viewPdf?id=" +
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

      var ajaxUrl = base_url + "/Document/ticket?id=" + numero + "&pv=" + codigo + "&scs=" + sucursal;

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
            title: "Conexión",
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

      var ajaxUrl = base_url + "/Document/ticketGeneral?id=" + numero + "&pv=" + codigo + "&scs=" + sucursal;

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
            title: "Conexión.",
            showConfirmButton: false,
            timer: 1000
          });
        }

      }

    }
  });
}

