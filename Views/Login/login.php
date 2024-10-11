<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?php echo base_url() ?>/assets/img/logo.png">
  <title>
  Login
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="<?php echo base_url() ?>/assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. 

  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>-->
  
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  
</head>

<body class="bg-gray-200 dark-version">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <!-- Navbar -->

        <!-- End Navbar -->
      </div>
    </div>
  </div>
  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-100" >
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom bg-new-dark">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1 text-center">
                  <img src="<?= media()  ?>/img/adn.png" class="logo" alt="logo" width="140px">
              <em class="text-white  d-block mt-3 "> "Herramienta de Despacho y Carga"</em>
              
                  
                </div>
              </div>
              <div class="card-body">
                <form role="form" id="formAuthentication" class="text-start">
                  <div class="input-group input-group-outline my-3">
                    <label class="form-label"></label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Usuario">
                  </div>
                  <div class="input-group input-group-outline mb-3">
                    <label class="form-label"></label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña">
                  </div>
                  <div class="form-check form-switch d-flex align-items-center mb-3">
                    <input class="form-check-input" type="checkbox" id="rememberMe" checked>
                    <label class="form-check-label mb-0 ms-3" for="rememberMe">Recuerdame</label>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Iniciar</button>
                  </div>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer position-absolute bottom-2 py-2 w-100">
        <div class="container">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-12 col-md-6 my-auto">
              <div class="copyright text-center text-sm text-white text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>,
                , by
                <a href="https://www.creative-tim.com" class="font-weight-bold text-white" target="_blank">ADN SOFTWARE</a>

              </div>
            </div>

          </div>
        </div>
      </footer>
    </div>
  </main>



  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->

  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="<?= media(); ?>/vendor/libs/jquery/jquery.js"></script>
  <script src="<?= media(); ?>/vendor/libs/popper/popper.js"></script>
  <script src="<?= media(); ?>/vendor/js/bootstrap.js"></script>


  <script>const base_url = "<?= base_url(); ?>";</script>
  <script src="<?= media(); ?>/js/<?= $data['page_functions_js']; ?>"></script>




 
</body>

</html>