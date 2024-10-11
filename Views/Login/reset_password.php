<!DOCTYPE html>

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

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="<?= media(); ?>/img/logointersat.png" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
  href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
  rel="stylesheet"
  />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="<?= media(); ?>/vendor/fonts/boxicons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="<?= media(); ?>/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="<?= media(); ?>/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="<?= media(); ?>/css/demo.css" />
  <link rel="stylesheet" href="<?= media(); ?>/css/styles.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="<?= media(); ?>/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <!-- Page CSS -->
  <!-- Page -->
  <link rel="stylesheet" href="<?= media(); ?>/vendor/css/pages/page-auth.css" />
  <!-- Helpers -->
  <script src="<?= media(); ?>/vendor/js/helpers.js"></script>

  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?= media(); ?>/js/config.js"></script>
  </head>

  <body>
    <!-- Content -->

    <div id="divLoading">
      <div>
        <img src="<?= media(); ?>/img/loading.svg" alt="Loading">
      </div>
    </div>

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
          <!-- Forgot Password -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                    <img src="<?= media()."/img/logo.png" ?>" width="120">
                  </span>
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-2">Restablecer la contraseña 🔒</h4>
              <p class="mb-4">para <strong><?= $data['email'] ?></strong></p>
              <form id="formNewPass" name="formNewPass" class="mb-3" action="" method="POST">
                <input type="hidden" name="idUser" id="idUser" value="<?= $data['idUser']; ?>">
                <input type="hidden" name="email" id="email" value="<?= $data['email']; ?>">
                <input type="hidden" name="token" id="token" value="<?= $data['token']; ?>">
                <div class="mb-3">
                  <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Nueva Contraseña</label>
                  </div>
                  <div class="input-group input-group-merge">
                    <input type="password" id="newPassword" class="form-control" name="newPassword" placeholder="············" aria-describedby="password">
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>

                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Confirmar Contraseña</label>
                  </div>
                  <div class="input-group input-group-merge">
                    <input type="password" id="confirmPassword" class="form-control" name="confirmPassword" placeholder="············" aria-describedby="password">
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                <button class="btn btn-primary d-grid w-100">Restablecer nueva contraseña</button>
              </form>
              <div class="text-center pt-4">
                <a href="<?= base_url()."/login" ?>" class="d-flex align-items-center justify-content-center">
                  <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                  Volver al login 
                </a>
              </div>
            </div>
          </div>
          <!-- /Forgot Password -->
        </div>
      </div>
    </div>

    <!-- / Content -->
   
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="<?= media(); ?>/vendor/libs/jquery/jquery.js"></script>
    <script src="<?= media(); ?>/vendor/libs/popper/popper.js"></script>
    <script src="<?= media(); ?>/vendor/js/bootstrap.js"></script>
    <script src="<?= media(); ?>/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="<?= media(); ?>/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="<?= media(); ?>/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Page JS -->
    <script>const base_url = "<?= base_url(); ?>";</script>
    <script src="<?= media(); ?>/js/<?= $data['page_functions_js']; ?>"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
  </html>
