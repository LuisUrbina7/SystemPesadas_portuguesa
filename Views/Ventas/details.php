<?php headerAdmin($data);
$conteo = isset($data['page_data'][0]['DCL_PDA_CONTEO']) ? $data['page_data'][0]['DCL_PDA_CONTEO'] : 0;
?>

<!----------------- MODAL PARA IMPORTAR----------------->

<div class="modal fade" id="modalImport" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content dark-version">
            <div class="modal-header p-2 border-bottom-0">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-2">
                <div class="row">
                    <div class="col-md-4 d-flex align-items-center">
                        <ul class="list-group" id="listDoc">


                        </ul>
                    </div>
                    <div class="col-md-8 ps-0">
                        <div class="table-responsive w-100 ">

                            <table class="table table-hover m-0 p-0" id="table-import-details">
                                <thead>
                                    <tr>
                                        <th class="font-weight-light p-1 text-sm"></th>
                                        <th class="font-weight-light p-1 text-sm ">Numero</th>
                                        <th class="font-weight-light p-1 text-sm">Código</th>
                                        <th class="font-weight-light p-1 text-sm">Descripción</th>
                                        <!-- <th class="font-weight-light p-1 text-sm">Cajas</th> -->
                                        <th class="font-weight-light p-1 text-sm">Unidades</th>

                                    </tr>
                                </thead>
                                <tbody id="tableImport">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer p-2 border-top-0">

            <button type="button" class="btn btn-primary m-0 py-1" id="btn-savImport">Guardar</button>
            </div>
        </div>
    </div>
</div>



<!----------------- MODAL PARA LISTADO DE PRODUCTOS----------------->

<div class="modal fade" id="modalProducts" tabindex="-1" aria-modal="true" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content dark-version">
            <div class="modal-header p-2 justify-content-center">
                <!--    <h5 class="modal-title" id="exampleModalLabel"></h5>-->
                <button type="button" class="btn btn-primary m-0 px-5 " id="btn-saveDoc"> <i class="material-icons opacity-10">data_saver_on </i></button>
                <small class="position-absolute text-end d-none" style="left: 0px;" id="banner-load"> Cargando, por favor espere.....</small>
                <!--  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
            </div>
            <div class="modal-body p-2">

                <div class="table-responsive w-100 ">

                    <table class="table table-hover" id="tableProducts">
                        <thead>
                            <tr>
                                <th class="font-weight-light py-1">#</th>
                                <th class="font-weight-light py-1">Codigo</th>
                                <th class="font-weight-light py-1">Descripción</th>
                                <th class="font-weight-light py-1">Precio</th>
                                <th class="font-weight-light py-1">Tiv</th>
                                <th class="font-weight-light py-1">Exis</th>
                                <th class="font-weight-light py-1">Lista</th>

                            </tr>
                        </thead>
                        <tbody id="productsTableBody">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer p-2">

            </div>
        </div>
    </div>
</div>

<!----  MODAL PARA AGREGAR CANASTAS -------------->

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content dark-version">
            <div class="modal-header p-2">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-2">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th class="p-2 d-flex justify-content-center align-items-center"></th>
                            <th class="p-2"></th>
                            <th class="p-2"></th>
                            <th class="p-2 d-flex justify-content-center align-items-center"></th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer p-2">

                <button type="button" class="btn btn-primary m-0 py-1">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!----  MODAL PARA AGREGAR CANASTAS -------------->


<div class="container-fluid py-4">


    <div class="row">
        <div class="col-12 mb-2">

            <div class="row">
                <div class="col-8">
                    <div class="card">
                        <div class="card-header  py-2 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <small>N° </small><input type="number" class="form-control inputs-disable" value="<?= !empty($data['page_data'][0]['DCL_NUMERO']) ? $data['page_data'][0]['DCL_NUMERO'] : $data['page_correlative'] ?>" id="main-correlative">
                            </div>
                            <div class="w-50">
                                <select class="js-example-basic-single w-100" name="state" id="idClient">
                                    <option selected style="color:black;" value="<?= !empty($data['page_data'][0]['DCL_CLT_CODIGO']) ? $data['page_data'][0]['DCL_CLT_CODIGO'] : null ?>"><?= !empty($data['page_data'][0]['DCL_CLT_CODIGO']) ? $data['page_data'][0]['CLT_NOMBRE'] : '-- Seleccione --' ?></option>
                                    <?php foreach ($data['page_clients'] as $details) : ?>
                                        <option value="<?= $details['CLT_CODIGO'] ?>|<?= $details['CLT_VEN_CODIGO'] ?> " style="color:black;"><?= $details['CLT_NOMBRE'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <?php
                            if (empty($data['page_data'])) { ?>
                                <div class="btn-group">

                                    <button class="btn btn-light mb-0" type="button" id="saveDocument" onclick="saveDocument();"><i class="material-icons opacity-10">new_label</i></button>
                                    <button class="btn btn-success mb-0" type="button" id="Import" onclick="Import();"> <i class="material-icons opacity-10">import_export</i></button>

                                </div>
                            <?php }  ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>




        <div class="col-md-4 mt-4 px-2 ">
            <div class="card h-100 mb-4">
                <div class="card-header pb-0 px-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-0">Movimientos </h6>
                        </div>
                        <div class="col-md-6 d-flex justify-content-start justify-content-md-end align-items-center">
                            <button type="button" id="btnAggProducts" class="btn btn-secondary py-2 px-3 m-0 mx-3 justify-content-center d-flex d-none" onclick="aggProducts()">
                                +
                            </button>

                            <i class="material-icons me-2 text-lg">date_range</i>
                            <small><?= date('y-M-d') ?></small>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-4 p-2">
                    <div class="d-flex justify-content-between">
                        <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Detalles</h6>
                        <span class="text-uppercase text-xs font-weight-bolder"> CJ | UND </span>
                    </div>
                    <div id="container-items-details">

                        <ul class="list-group" id="list-items">

                            <?php

                            if ($data['page_data'] != '') {
                                foreach ($data['page_data'] as $details) {

                                    $styleClass =  $details['PESADO'] == 0 ? "details-odc-style" :   "details-odc-style-weight";
                                    $registerType = $details['DCL_DESCRIDOWN'] == 1 ? 'light' : 'success';
                            ?>
                                    <a href="<?= base_url() ?>/Ventas/content?id=<?= $details['DCL_NUMERO'] ?> &cl=<?= $details['DCL_CLT_CODIGO'] ?> &pdt=<?= $details['MCL_UPP_PDT_CODIGO'] ?>" data-pdt="<?= $details['MCL_UPP_PDT_CODIGO'] ?>" data-und="<?= $details['MCL_UPP_UND_ID'] ?>" data-exiscj="<?= number_format($details['CAJA'], 2) ?>" data-exisund="<?= number_format($details['UND_KG'], 2) ?>" data-canxund="<?= $details['PDT_LICLTSCAJA'] ?>" data-valor="<?= number_format($details['CAJA'], 2) ?>" data-number="<?= $details['DCL_NUMERO'] ?>" data-det="<?= $details['DCL_CLT_CODIGO'] ?>" onclick="setInfoDetails(this)">
                                        <li class="list-group-item  d-flex justify-content-between  mb-2 border-radius-lg <?= $styleClass ?> p-1">
                                            <div class="d-flex align-items-center">
                                                <button onclick="ignoreHeavy(this)" class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i class="material-icons text-lg">add_shopping_cart</i></button>
                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-1 text-dark text-sm"> <?= $details['MCL_UPP_PDT_CODIGO'] ?> <span class="mx-3 badge rounded-pill bg-warning text-light"> <?= $details['MCL_UPP_UND_ID'] ?></span></h6>
                                                    <span class="text-xs"><?= $details['PDT_DESCRIPCION'] ?></span>
                                                </div>
                                            </div>
                                            <div class="d-flex fs-6 align-items-center text-sm font-weight-bold">
                                                <span id="exis-cj" class="text-<?= $registerType ?>"> <?= number_format($details['CAJA'], 2) ?></span>
                                                |
                                                <span id="exis-und" class="text-<?= $registerType ?>"> <?= number_format($details['UND_KG'], 2) ?> </span>
                                                |
                                                <span id="exis-pesado" class="text-warning"> <?= number_format($details['PESADO'], 2) ?> </span>
                                            </div>
                                        </li>
                                    </a>
                            <?php }
                            } ?>

                        </ul>
                    </div>
                </div>

                <?php
                if ($conteo !=  1) { ?>
                    <div class="card-footer text-end d-flex justify-content-end">
                        <button class="btn btn-danger shadow-danger mb-0" onclick="closeCount()"> Cerrar Conteo</button>
                    </div>
                <?php }  ?>



            </div>
        </div>
        <div class="col-md-8 mt-4">

            <div class="row">
                <div class="col-12 mb-3 px-2">
                    <div class="row">
                        <div class="col-xl-12 mb-xl-0 mb-4">
                            <div class="card bg-transparent shadow-xl">
                                <div class="overflow-hidden position-relative border-radius-xl">
                                    <img src="https://png.pngtree.com/background/20230521/original/pngtree-wallpapers-of-black-shiny-cubic-pixels-picture-image_2682816.jpg" class="position-absolute opacity-2 start-0 top-0 w-100 z-index-1 h-100" alt="pattern-tree">
                                    <span class="mask bg-gradient-dark opacity-10"></span>
                                    <div class="card-body position-relative z-index-1 p-3">

                                        <div class="row">

                                            <div class="col-md-5">
                                                <div class="row">
                                                    <input type="hidden" value="<?= $data['page_pdc_numero'] ?>" id="pdc_numero">
                                                    <input type="hidden" value="<?= $data['page_clt_codigo'] ?>" id="pdc_clt">
                                                    <input type="hidden" value="<?= !empty($data['page_data'][0]['DCL_NUMERO']) ? $data['page_data'][0]['DCL_NUMERO'] : 1 ?>" id="correlative">
                                                    <input type="hidden" value="<?= $data['page_pdc_status'] ?>" id="pdc_status">

                                                    <input type="hidden" value="FAV" id="pdc_tdt">
                                                    <input type="hidden" value="0" id="canxund">
                                                    <input type="hidden" value="0" id="valor">
                                                    <input type="hidden" value="0" id="valor-und">


                                                    <div class="col-6">
                                                        <div class="input-group input-group-static mb-1 ">
                                                            <label>Inicio</label>
                                                            <input type="time" class="form-control" value="<?= date('H:i:s') ?>" id="relojStart">
                                                        </div>

                                                    </div>
                                                    <div class="col-6">
                                                        <div class="input-group input-group-static mb-1">
                                                            <label>Fin</label>
                                                            <input type="time" class="form-control" id="reloj">
                                                        </div>
                                                    </div>
                                                    <div class="col-6 mb-1 disguise py-2" id="selectCanastas" style="display:inline-block;">
                                                        <div class="input-group input-group-static m-1">
                                                            <div id="select-options" data-options='<?= json_encode($data['page_canastas']) ?>' style="display: none;"></div>
                                                            <select class="form-control cls-extra" id="extra">

                                                                <option disabled selected> --- Seleccione --- </option>>
                                                                <?php foreach ($data['page_canastas'] as $canasta) { ?>
                                                                    <option class="text-dark" value="<?= $canasta['CTA_CODIGO'] ?>|<?= $canasta['CTA_EQUIVALENCIA']   ?>"><?= $canasta['CTA_DESCRIPCION'] ?> - (<?= $canasta['CTA_EQUIVALENCIA']   ?>)</option>
                                                                <?php  }  ?>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-5 mb-1 p-2 disguise " id="selectCantidad" style="display:inline-block;">
                                                        <div class="input-group input-group-outline my-1">
                                                            <label class="form-label">Cantidad:</label>
                                                            <input type="number" onkeyup="" class="form-control cls-extra-amount" id="extra_amount">
                                                        </div>
                                                    </div>
                                                    <div class="col-1 p-0  disguise" id='buttonAddCanastas' style="display:inline-block;">
                                                        <div class="d-flex justify-content-center align-items-center h-100">

                                                            <button type="button" class="btn btn-primary py-2 px-3 m-0 justify-content-center d-flex" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="addRow()">
                                                                +
                                                            </button>

                                                        </div>
                                                    </div>
                                                    <div class="col-6 disguise">
                                                        <?php $checkOtros = $_SESSION['userData']['MANUAL_ODC'] ? '' : 'd-none'; ?>
                                                        <div class="form-check p-0  <?= $checkOtros ?>">
                                                            <input class="form-check-input" type="checkbox" value="" id="otros">
                                                            <label class="custom-control-label" for="otros">Otros .</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 disguise">
                                                        <div class="form-check p-0">
                                                            <input class="form-check-input" type="checkbox" value="" id="embutidos">
                                                            <label class="custom-control-label" for="embutidos">Sin Cesta.</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="btn-group w-100 mb-1 disguise-btn">

                                                    <button class="btn btn-success shadow-success p-1 mb-1" onclick="aggRow()"> <i class="material-icons opacity-10 fs-4">add_circle_outline</i></button>
                                                    <!--  <button class="btn btn-warning shadow-warning p-1 mb-1" onclick="getWeight()"> <i class="material-icons opacity-10 fs-4">save_alt</i></button> -->
                                                </div>
                                                <div class="w-100 my-2 show-fields d-none">
                                                    <button class="w-100 btn btn-success shadow-success p-2  px-3 mb-1 d-flex justify-content-center" onclick="aggRow()"> <i class="material-icons opacity-10 fs-4">add_circle_outline</i></button>

                                                </div>


                                            </div>
                                            <div class="col-md-7 text-end">
                                                <span class="text-danger shadow-danger" id="manual-label" style="display: none;">Asignación Manual</span>
                                                <i class="material-icons text-white p-2">single_bed</i>
                                                <div class="row text-white mt-1 mb-1 pb-2">
                                                    <div class="col-12">

                                                        <div class="row">

                                                            <div class="col-11 col-md-11 px-0">
                                                                <input class="weight" id="weight-value" readonly type="number" value="0.00" style="border:0px solid red" onkeyup="return validateAmountOne(this)">
                                                            </div>
                                                            <div class="col-1 col-md-1 px-0 text-center">
                                                                <span id="input-und"> kg</span>
                                                            </div>
                                                        </div>
                                                        <div class="row show-fields d-none">
                                                            <div class="col-11 col-md-11 px-0">
                                                                <input class="weight" id="weight-value-secondary" type="number" value="0.00" style="border:0px solid red">
                                                            </div>
                                                            <div class="col-1 col-md-1 px-0 text-center">
                                                                <span id="input-und"> UND</span>
                                                            </div>
                                                        </div>

                                                    </div>


                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <div class="d-flex">
                                                        <div class="me-4">
                                                            <p class="text-white text-sm opacity-8 mb-0">Encargado</p>
                                                            <h6 class="text-white mb-0"><?= $_SESSION['userData']['OPE_NOMBRE']; ?></h6>
                                                        </div>
                                                        <div class="me-4">
                                                            <p class="text-white text-sm opacity-8 mb-0">Unidad</p>
                                                            <h6 class="text-white mb-0" id="codigo-und">0000</h6>
                                                        </div>
                                                        <div class="me-4">
                                                            <p class="text-white text-sm opacity-8 mb-0">Codigo</p>
                                                            <h6 class="text-white mb-0" id="codigo-pdt">0000</h6>
                                                        </div>
                                                        <div class="me-4">
                                                            <p class="text-white text-sm opacity-8 mb-0">Neto</p>
                                                            <h6 class="text-white mb-0"> <span id="weight-total"> 0.00</span> <span class="symbol-und"> kg</span></h6>
                                                        </div>
                                                        <div class="me-4">
                                                            <p class="text-white text-sm opacity-8 mb-0">Bruto</p>
                                                            <h6 class="text-white mb-0"> <span id="weight-bruto"> 0.00</span> <span class="symbol-und"> kg</span></h6>
                                                        </div>
                                                        <div>
                                                            <p class="text-white text-sm opacity-8 mb-0">Extra</p>
                                                            <h6 class="text-white mb-0"> <span id="weight-extra"> 0.00</span> <span class="symbol-und"> kg</span></h6>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="d-flex justify-content-end d-none">


                                                    <div class="input-group input-group-static m-1 w-75">

                                                        <select class="form-control" id="amc">

                                                            <option selected value="001"> --- Almacén Destino --- </option>

                                                            <!--  <?php //foreach ($data['page_amc'] as $amc) { 
                                                                    ?>
                                                                    <option class="text-dark" value="<?= $amc['CODIGO'] ?>"><?= $amc['NOMBRE']   ?></option>

                                                                <?php //  }  
                                                                ?>-->

                                                        </select>
                                                    </div>


                                                </div>




                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>


                </div>


                <div class="col-12 px-2">

                    <div class="card">
                        <div class="card-header pb-0 px-3">
                            <div class="row">
                                <div class="col-6 d-flex align-items-center">
                                    <h6 class="mb-0">Listado</h6>
                                    <a href="#" class="btn btn-danger rounded-circle mx-3 m-0 p-2" id="label-spinner-save" onclick="ticketByHeavy()"> 
                                        <i class="material-icons opacity-10">picture_as_pdf</i>
                                    </a>
                                </div>


                                <?php if ($conteo != 1) {    ?>
                                    <div class="col-6 text-end">
                                        <a class="btn bg-gradient-dark mb-0" href="javascript:;" onclick="insertDetails()" id="save">
                                            <div class="text-primary" role="status" id="spinner-lots-save">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <div id="label-spinner-save"> <i class="material-icons text-sm">add</i> Guardar </div>
                                        </a>
                                    </div>
                                <?php   }    ?>

                            </div>
                        </div>
                        <div class="card-body pt-4 p-3">





                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-sm p-3 pb-1 text-center"> # </th>

                                        <th class="text-sm p-3 pb-1 text-center"> Inicio</th>
                                        <th class="text-sm p-3 pb-1 text-center"> Finalizado</th>
                                        <th class="text-sm p-3 pb-1 text-center"> Canasta</th>
                                        <th class="text-sm p-3 pb-1 text-center"> Extra</th>
                                        <th class="text-sm p-3 pb-1 text-center"> CJ </th>
                                        <th class="text-sm p-3 pb-1 text-center "> KG | UND </th>


                                    </tr>
                                </thead>


                                <tbody id="table-date">


                                </tbody>
                            </table>


                        </div>


                    </div>


                </div>
            </div>

        </div>







    </div>



</div>




<?php footerAdmin($data); ?>