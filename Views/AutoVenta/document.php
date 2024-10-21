<?php headerAdmin($data); ?>

<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-autoventa shadow-success border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3"> Cargas Realizadas. </h6>

                </div>
            </div>


            <div class="card-body px-3 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="table-odc">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Numero</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Vendedor</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Toneladas</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estatus</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody id="table-sale">


                            <?php foreach ($data['page_data'] as $details) {  
                                $status =  $details['DCL_ACTIVO'] == 1? 'FINALIZADO' : 'PROCESO';
                                $statusStyle =  $details['DCL_ACTIVO'] == 1? 'success' : 'warning';
                                ?>
                                <tr class="list-odc-style">
                                    <td>
                                        <a href="<?= base_url() ?>/AutoVenta/details?id=<?= $details['DCL_NUMERO'] ?>&cl=<?= $details['DCL_CLT_CODIGO'] ?>" class="text-decoration-none">
                                            <div class="d-flex px-2 py-1">
                                                <div class="p-2 btn btn-light rounded-circle d-flex me-2 m-0">
                                                    <i class="material-icons opacity-10">stream</i>
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"> <?= $details['DCL_NUMERO'] ?></h6>
                                                    <p class="text-xs text-secondary mb-0"><?= $details['DCL_NUMERO'] ?></p>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?= $details['VEN_NOMBRE'] ?></p>
                                        <p class="text-xs text-secondary mb-0"><?= $details['DCL_VEN_CODIGO'] ?></p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-green"><?= $details['PESO'] ?></span>
                                    </td>
                                    <!-- <?php //switch ($details['DPV_CERRADO']):
                                            //case '1': 
                                            ?>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-success">Cerrado</span>
                                            </td>
                                            <?php //break; 
                                            ?>

                                        <?php
                                        //case '0': 
                                        ?>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-warning">Proceso</span>
                                            </td>
                                            <?php //break; 
                                            ?>


                                        <?php
                                        //case '0': 
                                        ?>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-warning">Proceso</span>
                                            </td>
                                            <?php //break; 
                                            ?>
                                        <?php
                                        //default: 
                                        ?> -->
                                    <td class="align-middle text-center text-sm">

                                        <span class="badge badge-sm bg-<?= $statusStyle ?>"><?= $status ?></span>
                                    </td>
                                    <?php //break; 
                                    ?>
                                    <?php //endswitch 
                                    ?>

                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold"><?= $details['DCL_FECHA'] ?></span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a class="p-2 btn btn-danger rounded-1 d-flex  m-1 w-50 justify-content-center" onclick="ticket('<?= $details['DCL_NUMERO'] . '|' . $details['DCL_CLT_CODIGO'] . '|' . $details['DCL_SCS_CODIGO'] ?>')">
                                                    <i class="material-icons opacity-10">format_list_numbered</i>
                                                </a>
                                                <a class="p-2 btn btn-danger rounded-1 d-flex  m-1 w-50 justify-content-center" onclick="ticketGeneral('<?= $details['DCL_NUMERO'] . '|' . $details['DCL_CLT_CODIGO'] . '|' . $details['DCL_SCS_CODIGO'] ?>')">
                                                    <i class="material-icons opacity-10">picture_as_pdf</i>
                                                </a>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="align-middle text-center">
                                        <button class="btn btn-danger shadow-danger p-2 mb-0" onclick="sale(this)" data-scs="<?= $details['DCL_SCS_CODIGO'] ?>" data-clt="<?= $details['DCL_CLT_CODIGO'] ?>" data-number="<?= $details['DCL_NUMERO'] ?>"> <i class="material-icons  text-lg">delete_forever</i></button>
                                    </td>

                                </tr>

                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>





<?php footerAdmin($data); ?>