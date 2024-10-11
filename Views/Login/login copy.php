<!--


<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
-->
<!-- beautify ignore:start -->


<!--
<html
lang="en"
class="light-style customizer-hide"
dir="ltr"
data-theme="theme-default"
data-assets-path="<?= media(); ?>/"
data-template="vertical-menu-template-free"
>
<head>
  <meta charset="utf-8" />
  <meta
  name="viewport"
  content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
  />

  <title>Intersat - Portal Clientes</title>

  <meta name="description" content="" />

  
 <!--  METAS PARA LA PWA -

 <meta name="theme-color" content="#fff">
  <meta name="MobileOptimized" content="width">
  <meta name="HandheldFriendly" content="true">

  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="apple-mobile-web-app-title" content="Intersat">
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="white">


  <link rel="apple-touch-icon" href="<?= media(); ?>/img/icon_2000.png">
  <link rel="apple-touch-icon" sizes="2000x2000" href="<?= media(); ?>/img/icon_2000.png">
  <link rel="apple-touch-icon" sizes="1000x1000" href="<?= media(); ?>/img/icon_1000.png">

  <link rel="shortcut icon" type="image/png" href="<?= media(); ?>/img/icon_1000.png">
  <link rel="manifest" href="./manifest.json">

  
  <!-- Favicon --
  <link rel="icon" type="image/x-icon" href="<?= media(); ?>/img/icon_1000.png" />

  <!-- Fonts --
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
  href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
  rel="stylesheet"
  />

  <!-- Icons. Uncomment required icon fonts --
  <link rel="stylesheet" href="<?= media(); ?>/vendor/fonts/boxicons.css" />

  <!-- Core CSS --
  <link rel="stylesheet" href="<?= media(); ?>/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="<?= media(); ?>/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="<?= media(); ?>/css/demo.css" />
  <link rel="stylesheet" href="<?= media(); ?>/css/styles.css" />

  <!-- Vendors CSS --
  <link rel="stylesheet" href="<?= media(); ?>/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <!-- Page CSS -->
  <!-- Page --
  <link rel="stylesheet" href="<?= media(); ?>/vendor/css/pages/page-auth.css" />
  <!-- Helpers --
  <script src="<?= media(); ?>/vendor/js/helpers.js"></script>

  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  --
    <script src="<?= media(); ?>/js/config.js"></script>
  </head>

  <body>

    <div id="divLoading">
      <div>
        <img src="<?= media(); ?>/img/loading.svg" alt="Loading">
      </div>
    </div>
    <!-- Content --

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register --
          <div class="card">
            <div class="card-body">
              <!-- Logo --
              <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">

                    <img src="<?= media() ?>/img/logo.png" width="120">

                  </span>
                  <span class="app-brand-text demo text-body fw-bolder"></span>
                </a>
              </div>
              <!-- /Logo --
              <h4 class="mb-2">Intersat Los Andes C.A.</h4>
              <p class="mb-4">¡Por favor ingresa con tus credenciales!</p>

              <form id="formAuthentication" class="mb-3">
                <div class="mb-3">
                  <label for="email" class="form-label">Usuario</label>
                  <input type="text" class="form-control" id="email" name="email" placeholder="Ingresa tu correo electronico o usuario" autofocus="">
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Contraseña</label>
                  </div>
                  <div class="input-group input-group-merge">
                    <input type="password" id="password" class="form-control" name="password" placeholder="············" aria-describedby="password">
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                    <a href="<?= base_url() . "/login/forgot_password" ?>" class="">
                      <small>¿Olvidaste tú contraseña?</small>
                    </a>
                </div>
                <div class="mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember-me">
                    <label class="form-check-label" for="remember-me">
                      Recuerdame
                    </label>
                  </div>
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">Ingresar</button>
                </div>

                <div class="alert alert-warning alert-dismissible fade show " role="alert" id="alert-hours">
                    <p class="text-sm mb-0">
                    <small><strong>Advertencia!</strong>, se recomienda mantener el navegador actualizado.</small>  <br>
                    <small class="text-danger"> <strong>Si es tu primera vez,</strong> recuerda ingresar como usuario y contraseña tu número de identidad. Ej: </small>
                    <ul class="mb-0 px-3 list-unstyled text-danger">
                      <li> <small class="fw-5"> - Usuario: <strong>28256156 </strong></small></li>
                      <li> <small class="fw-5"> - Contraseña:<strong>28256156</strong> </small></li>
                    </ul> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </p>   
                 </div>
              </form>

              <!-- <p class="text-center">
                <span>¿Nuevo en nuestra plataforma?</span>
                <a href="<?= base_url() ?>/register">
                  <span>Crear cuenta</span>
                </a>
              </p> --
            </div>
          </div>
          <!-- /Register --
        </div>
      </div>
    </div>

    <!-- / Content --


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js --
    <script src="<?= media(); ?>/vendor/libs/jquery/jquery.js"></script>
    <script src="<?= media(); ?>/vendor/libs/popper/popper.js"></script>
    <script src="<?= media(); ?>/vendor/js/bootstrap.js"></script>
    <script src="<?= media(); ?>/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="<?= media(); ?>/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS --
    <script src="<?= media(); ?>/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Page JS --
    <script>const base_url = "<?= base_url(); ?>";</script>
    <script src="<?= media(); ?>/js/<?= $data['page_functions_js']; ?>"></script>
    <script src="./script.js"></script>
    <!-- Place this tag in your head or just before your close body tag. --
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
  </html>