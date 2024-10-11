
var global = document.getElementById('myGlobal').getContext('2d');

var myChart3 = new Chart(global, {
  type: 'doughnut',
  data: {
    labels: ['Total', 'Sincronizado'],
    datasets: [{
      data: [20, 6], // Cajas compradas
      backgroundColor: ['rgb(255 0 0)', 'rgb(0 255 250)'],
      borderColor: 'rgba(54, 162, 235, 1)',
      hoverBackgroundColor: ['rgb(255 0 0)', 'rgb(0 255 250)'],
      borderWidth: 1
    }

    ]
  },
  options: {
    legend: {
      labels: {
        fontColor: "white",

      }
    }

  }
});

document.addEventListener('DOMContentLoaded', function () {

  graph();
});


function graph() {



  var request = (window.XMLHttpRequest) ?
    new XMLHttpRequest() :
    new ActiveXObject('Microsoft.XMLHTTP');

  var ajaxUrl = base_url + '/home/graph';



  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {

    if (request.readyState != 4) return;
    if (request.status == 200) {
      var objData = JSON.parse(request.responseText);

      console.log( objData);
      if(objData.TOTAL == 0  || objData.TRANSFERIDOS == 0){
        objData.TOTAL = 1;
        objData.TRANSFERIDOS =1;
      }

      var new_global = {
        datasets: [{
          data: [objData.TOTAL - objData.TRANSFERIDOS , objData.TRANSFERIDOS], 
          backgroundColor: ['rgb(255 0 0)', 'rgb(0 255 250)'],
          hoverBackgroundColor: ['rgb(255 0 0)', 'rgb(0 255 250)'],
          borderWidth: 1
        }]
      };

      myChart3.data.datasets = new_global.datasets;
      myChart3.update();


      console.log(objData);
    } else {
      Swal.fire("Atención", "Error en el proceso", "error");
    }

  }
}


