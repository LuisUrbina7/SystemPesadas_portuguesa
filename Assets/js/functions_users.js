let tableUsuarios;
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableUsuarios = $('#tableUsuarios').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
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
        "ajax":{
            "url": " "+base_url+"/Usuarios/getUsuarios",
            "dataSrc":""
        },
        "columns":[
            {"data":"id"},
            {"data":"name"},
            {"data":"username"},
            {"data":"rol"},
            {"data":"status"},
            {"data":"options"}
            ],
        'dom': 'lBfrtip',
        'buttons': [
        {
            "extend": "copyHtml5",
            "text": "<i class='far fa-copy'></i> Copiar",
            "titleAttr":"Copiar",
            "className": "btn btn-secondary"
        },{
            "extend": "excelHtml5",
            "text": "<i class='fas fa-file-excel'></i> Excel",
            "titleAttr":"Esportar a Excel",
            "className": "btn btn-success"
        },{
            "extend": "pdfHtml5",
            "text": "<i class='fas fa-file-pdf'></i> PDF",
            "titleAttr":"Esportar a PDF",
            "className": "btn btn-danger"
        },{
            "text": "<i class='bx bx-plus'></i> Crear",
            "titleAttr":"Crear Usuario",
            "className": "btn btn-info",
            action: function (){
                document.querySelector('#idUsuario').value ="";
                document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
                document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
                document.querySelector('#btnText').innerHTML ="Guardar";
                document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
                document.querySelector("#formUsuario").reset();
                $('#modalFormUsuario').modal('show');
            }

        }
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 100,
        "order":[[0,"asc"]]  
    });


    if(document.querySelector("#formUsuario")){
        let formUsuario = document.querySelector("#formUsuario");
        formUsuario.onsubmit = function(e) {
            e.preventDefault();
            let name = document.querySelector('#name').value;
            let username = document.querySelector('#username').value;
            let listRolid = document.querySelector('#listRolid').value;
            let listStatus = document.querySelector('#listStatus').value;
            let password = document.querySelector('#password').value;



            if(name == '' || username == '')
            {
                Swal.fire("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }

            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) { 
                if(elementsValid[i].classList.contains('is-invalid')) { 
                    Swal.fire("Atención", "Por favor verifique los campos en rojo." , "error");
                    return false;
                } 
            } 

            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Usuarios/setUsuario'; 
            let formData = new FormData(formUsuario);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        $('#modalFormUsuario').modal("hide");
                        formUsuario.reset();
                        Swal.fire("Usuarios", objData.msg ,"success");
                        tableUsuarios.api().ajax.reload();
                    }else{
                        Swal.fire("Error", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }


    if(document.querySelector("#formEdit")){
        let formEdit = document.querySelector("#formEdit");
        formEdit.onsubmit = function(e) {
            e.preventDefault();

           
            
            let password = document.querySelector('#password').value;
            let confirmPassword = document.querySelector('#confirmPassword').value;
            let email = document.querySelector('#email').value;



            if(password == '' || confirmPassword == '')
            {
                Swal.fire("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            } else if(password !=  confirmPassword){
                Swal.fire("Atención", "Las contraseñas no coinciden" , "error");
                return false;
            }

            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) { 
                if(elementsValid[i].classList.contains('is-invalid')) { 
                    Swal.fire("Atención", "Por favor verifique los campos en rojo." , "error");
                    return false;
                } 
            } 

            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Users/setPassword'; 
            let formData = new FormData(formEdit);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        Swal.fire("Usuarios", objData.msg ,"success");
                        //window.location = base_url+'/home';
                    }else{
                        Swal.fire("Error", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }


}, false);


window.addEventListener('load', function() {
        fntRolesUsuario();
}, false);

function fntRolesUsuario(){
    if(document.querySelector('#listRolid')){
        let ajaxUrl = base_url+'/Roles/getSelectRoles';
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                document.querySelector('#listRolid').innerHTML = request.responseText;
            }
        }
    }
}


