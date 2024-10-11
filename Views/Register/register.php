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

  <title>Register - ANP Health Services, INC</title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="<?= media(); ?>/img/favicon/favicon.svg" />

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

    <div id="divLoading">
      <div>
        <img src="<?= media(); ?>/img/loading.svg" alt="Loading">
      </div>
    </div>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">

                    <img src="<?= media() ?>/img/logo.svg" width="80">

                  </span>
                  <span class="app-brand-text demo text-body fw-bolder"></span>
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-2">ANP Health Services, INC</h4>
              <p class="mb-4">* all fields are required</p>

              <form id="formRegister" class="mb-3">
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="text" class="form-control valid validText" id="email" name="email" placeholder="Enter your email" autofocus required>
                </div>
                <div class="mb-3 form-password-toggle">
                  <label class="form-label" for="password">Password</label>
                  <div class="input-group input-group-merge">
                    <input type="password" id="password" class="form-control valid validText" name="password" placeholder="············" aria-describedby="password" required>
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>

                <div class="mb-3">
                  <label for="first-name" class="form-label">First Name</label>
                  <input type="text" class="form-control valid validText" id="firstName" name="firstName" placeholder="Enter your first name"  required>
                  <div class="form-text"> Enter your first name exactly as it appears on your application for licensure</div>
                </div>

                <div class="mb-3">
                  <label for="last-name" class="form-label">Last Name</label>
                  <input type="text" class="form-control valid validText" id="lastName" name="lastName" placeholder="Enter your last name"  required>
                  <div class="form-text"> Enter your last name exactly as it appears on your application for licensure</div>
                </div>

                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control valid validText" id="username" name="username" placeholder="Enter your username"  required>
                  <div class="form-text"> This username is only a method to identify you within our platform, it is not part of any legal requirement for any process.</div>
                </div>

                <div class="mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" required>
                    <label class="form-check-label" for="terms-conditions">
                      I agree to
                      <a href="javascript:void(0);">privacy policy &amp; terms</a>
                    </label>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary d-grid w-100">
                  Sign up
                </button>
              </form>

              <p class="text-center">
                <span>Already have an account?</span>
                <a href="<?= base_url() ?>/login">
                  <span>Sign in</span>
                </a>
              </p>
            </div>
          </div>
          <!-- /Register -->
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
