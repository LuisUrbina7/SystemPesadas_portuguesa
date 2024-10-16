<body class="g-sidenav-show  bg-gray-200 dark-version">
  <aside class="z-index-2 sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0 d-flex justify-content-center" href="https://sistemasadn.com/" target="_blank">
        <img src="<?php echo media() ?>/img/adn.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold text-white"></span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white active bg-gradient-primary" href="<?php echo base_url() ?>/home">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">addchart</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>

        <?php if ($_SESSION['userData']['ACCES_ODC']) { ?>
          <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Compras</h6>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white " href="<?php echo base_url() ?>/Document/document">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">receipt_long</i>
              </div>
              <span class="nav-link-text ms-1">Documentos ODC</span>
            </a>
          </li>
        <?php   } ?>

        <?php if ($_SESSION['userData']['ACCES_GUIA']) { ?>
          <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Guias</h6>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white " href="<?php echo base_url() ?>/DocumentGuia/document">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">checklist_rtl</i>
              </div>
              <span class="nav-link-text ms-1">Documentos Guia</span>
            </a>
          </li>

          <?php if ($_SESSION['userData']['INCLUIR_GUIA']) { ?>




            <li class="nav-item mt-3">
              <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Salidas</h6>
            </li>

            <li class="nav-item">
              <a class="nav-link text-white " href="<?php echo base_url() ?>/Ventas">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="material-icons opacity-10">list_alt</i>
                </div>
                <span class="nav-link-text ms-1">Listado</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link text-white " href="<?php echo base_url() ?>/Ventas/details" id="newDocument">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="material-icons opacity-10">point_of_sale</i>
                </div>
                <span class="nav-link-text ms-1">Directa e Importacion</span>
              </a>
            </li>

            <li class="nav-item mt-3">
              <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Otras Salidas</h6>
            </li>

            <li class="nav-item">
              <a class="nav-link text-white position-relative" href="<?php echo base_url() ?>/PedidosPollo/document" id="chicken-module">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="material-icons opacity-10">emoji_transportation</i>
                </div>
                <span class="nav-link-text ms-1">Ordenes Pollo</span>

                <div id="chicken-label" class="position-absolute">

                </div>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link text-white position-relative" href="<?php echo base_url() ?>/Transferencia/details" id="transfer">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="material-icons opacity-10">compare_arrows</i>
                </div>
                <span class="nav-link-text ms-1">Transferencias</span>

                <div id="transfer-label" class="position-absolute">

                </div>
              </a>
            </li>

          <?php   } ?>

        <?php   } ?>

        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">CONFIGURACION</h6>
        </li>

        <li class="nav-item">
          <a class="nav-link text-white " href="<?php echo base_url() ?>/Canastas">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">checklist_rtl</i>
            </div>
            <span class="nav-link-text ms-1">Canastas</span>
          </a>
        </li>

      </ul>
    </div>

  </aside>


  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg  " id="menuMain">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-0 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"> <a id="btnMenu" href="javascript:;" onclick="toggleMenu()" class="d-none d-lg-block"><i class="material-icons opacity-10">menu_open</i></a> <span class=" d-lg-none">Pagina</span> </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Dashboard</h6>
        </nav>
        <div class=" justify-content-end collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">

          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center mx-3">
              <a href="javascript:;" class="nav-link p-0 text-body" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
            <li class="nav-item d-flex align-items-center ml-2">
              <a href="<?= base_url() ?>/Logout" class="nav-link text-body font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">Salir</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>