
var divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function () {

	if (document.querySelector("#formAuthentication")) {
		let formAuthentication = document.querySelector("#formAuthentication");
		formAuthentication.onsubmit = function (e) {
			e.preventDefault();

			let strEmail = document.querySelector('#email').value;
			let strPassword = document.querySelector('#password').value;

			console.log(strEmail + strPassword);

			if (strEmail == "" || strPassword == "") {





				Swal.fire({
					title: "Error!",
					text: "Escribe usuario y contraseña.",
					icon: "error"
				});
				return false;
			} else {

				var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
				var ajaxUrl = base_url + '/Login/loginUser';


				var formData = new FormData(formAuthentication);
				request.open("POST", ajaxUrl, true);
				request.send(formData);
				request.onreadystatechange = function () {
					if (request.readyState != 4) return;
					if (request.status == 200) {
						var objData = JSON.parse(request.responseText);

						console.log(objData);
						if (objData.status) {

							window.location = base_url + '/home';


						} else {

							Swal.fire({
								title: "Atención!",
								text: objData.msg,
								icon: "error"
							});

						}
					} else {
						Swal.fire("Attention", "Error in the process", "error");
					}
					//divLoading.style.display = "none";
					return false;
				}
			}
		}
	}


	if (document.querySelector("#formResetPass")) {
		let formResetPass = document.querySelector("#formResetPass");
		formResetPass.onsubmit = function (e) {
			e.preventDefault();

			let email = document.querySelector('#emailReset').value;
			if (email == "") {
				Swal.fire("¡Por favor!", "Escribe tu correo electrónico.", "error");
				return false;
			} else {
				divLoading.style.display = "flex";
				var request = (window.XMLHttpRequest) ?
					new XMLHttpRequest() :
					new ActiveXObject('Microsoft.XMLHTTP');

				var ajaxUrl = base_url + '/Login/resetPass';
				var formData = new FormData(formResetPass);
				request.open("POST", ajaxUrl, true);
				request.send(formData);
				request.onreadystatechange = function () {
					if (request.readyState != 4) return;

					if (request.status == 200) {
						var objData = JSON.parse(request.responseText);
						if (objData.status) {
							const swalWithBootstrapButtons = Swal.mixin({
								customClass: {
									confirmButton: "btn btn-success",
								},
								buttonsStyling: false
							});
							swalWithBootstrapButtons.fire({
								title: "¡Exito!",
								text: "Se ha enviado a tu correo los pasos que debes seguir para cambiar tu contraseña",
								icon: "success",
								showCancelButton: false,
								confirmButtonText: "Ir a Inicio",
								reverseButtons: true
							}).then((result) => {
								if (result.isConfirmed) {
									window.location = base_url;
								}
							});
						} else {
							Swal.fire("Atención", objData.msg, "error");
						}
					} else {
						Swal.fire("Atención", "Error en el proceso", "error");
					}
					divLoading.style.display = "none";
					return false;
				}
			}
		}
	}

	if (document.querySelector("#formNewPass")) {
		let formNewPass = document.querySelector("#formNewPass");
		formNewPass.onsubmit = function (e) {
			e.preventDefault();

			let strPassword = document.querySelector('#newPassword').value;
			let strPasswordConfirm = document.querySelector('#confirmPassword').value;
			let idUsuario = document.querySelector('#idUser').value;

			if (strPassword == "" || strPasswordConfirm == "") {
				Swal.fire("Por favor", "Escribe la nueva contraseña.", "error");
				return false;
			} else {
				if (strPassword.length < 5) {
					Swal.fire("Atención", "La contraseña debe tener un mínimo de 5 caracteres.", "info");
					return false;
				}
				if (strPassword != strPasswordConfirm) {
					Swal.fire("Atención", "Las contraseñas no son iguales.", "error");
					return false;
				}
				divLoading.style.display = "flex";
				var request = (window.XMLHttpRequest) ?
					new XMLHttpRequest() :
					new ActiveXObject('Microsoft.XMLHTTP');
				var ajaxUrl = base_url + '/Login/setPassword';
				var formData = new FormData(formNewPass);
				request.open("POST", ajaxUrl, true);
				request.send(formData);
				request.onreadystatechange = function () {
					if (request.readyState != 4) return;
					if (request.status == 200) {
						var objData = JSON.parse(request.responseText);
						if (objData.status) {
							const swalWithBootstrapButtons = Swal.mixin({
								customClass: {
									confirmButton: "btn btn-success",
								},
								buttonsStyling: false
							});
							swalWithBootstrapButtons.fire({
								title: "¡Exito!",
								text: "Contraseña reestablecida!",
								icon: "success",
								showCancelButton: false,
								confirmButtonText: "Iniciar sesión",
								reverseButtons: true
							}).then((result) => {
								if (result.isConfirmed) {
									window.location = base_url;
								}
							});
						} else {
							Swal.fire("Atención", objData.msg, "error");
						}
					} else {
						Swal.fire("Atención", "Error en el proceso", "error");
					}
					divLoading.style.display = "none";
				}
			}
		}
	}



	if (document.querySelector("#formAccountSetings")) {
		let formNewPass = document.querySelector("#formAccountSetings");
		formAccountSetings.onsubmit = function (e) {
			e.preventDefault();

			let strPassword = document.querySelector('#newPassword').value;
			let strPasswordConfirm = document.querySelector('#confirmPassword').value;
			let idUsuario = document.querySelector('#idUser').value;

			if (strPassword == "" || strPasswordConfirm == "") {
				Swal.fire("Por favor", "Escribe la nueva contraseña.", "error");
				return false;
			} else {
				if (strPassword.length < 5) {
					Swal.fire("Atención", "La contraseña debe tener un mínimo de 5 caracteres.", "info");
					return false;
				}
				if (strPassword != strPasswordConfirm) {
					Swal.fire("Atención", "Las contraseñas no son iguales.", "error");
					return false;
				}
				divLoading.style.display = "flex";
				var request = (window.XMLHttpRequest) ?
					new XMLHttpRequest() :
					new ActiveXObject('Microsoft.XMLHTTP');
				var ajaxUrl = base_url + '/Users/setPassword';
				var formData = new FormData(formAccountSetings);
				request.open("POST", ajaxUrl, true);
				request.send(formData);
				request.onreadystatechange = function () {
					if (request.readyState != 4) return;
					if (request.status == 200) {
						var objData = JSON.parse(request.responseText);
						if (objData.status) {
							Swal.fire("Exito!", objData.msg, "success");
						} else {
							Swal.fire("Atención", objData.msg, "error");
						}
					} else {
						Swal.fire("Atención", "Error en el proceso", "error");
					}
					divLoading.style.display = "none";
				}
			}
		}
	}

}, false);