<?php headerAdmin($data); ?>

<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3"> Guia de Carga </h6>
                </div>
            </div>

            <div class="form-check mt-3">
                <label>
                    <input class="form-check-input" type="radio" name="statusFilter" value="all" checked> Todos
                </label>
                <label>
                    <input class="form-check-input" type="radio" name="statusFilter" value="Proceso"> Proceso
                </label>
                <label>
                    <input class="form-check-input" type="radio" name="statusFilter" value="Cerrado"> Cerrado
                </label>
            </div>
            <div class="card-body px-3 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="table-guia">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Numero</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Transportista</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Toneladas</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estatus</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Intervalos</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Duracion</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>





                            <?php foreach ($data['page_data'] as $details) {  
                                $icon = $details['DCG_TRA_CODIGO'] == '052' ? 'import_export' : 'emoji_transportation';
                                $iconType = $details['INDICADOR'] == 0 ? '🐔' : '🚛';
                                ?>
                                <tr class="list-odc-style">
                                    <td>
                                        <a href="<?= base_url() ?>/DocumentGuia/details?id=<?= $details['DCG_NUMERO'] ?>&tr=<?= $details['DCG_TRA_CODIGO'] ?>&ind=<?=$details['INDICADOR'] ?>" class="text-decoration-none">
                                            <div class="d-flex px-2 py-1">
                                                <div class="p-2 btn btn-light rounded-circle d-flex me-2 m-0">
                                                    <i class="material-icons opacity-10"><?= $iconType ?></i>
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?php echo $details['DCG_NUMERO'] ?> </h6>
                                                    <p class="text-xs text-secondary mb-0"><?php echo $details['DCG_VEH_PLACA'] ?></p>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?php echo $details['DCG_TRA_CODIGO'] ?></p>
                                        <p class="text-xs text-secondary mb-0"><?php echo $details['TRA_NOMBRE'] ?></p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-green"><?php echo $details['DCG_PESO'] ?></span>
                                    </td>

                                    <?php switch ($details['DCG_PESADAS']):
                                        case '1': ?>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-success">Cerrado</span>
                                            </td>

                                            <td class="align-middle text-center">
                                                <div class="w-100 d-flex justify-content-center">

                                                    <?php if ($details['PDA_TRANF_ID'] <> 0) {   ?>
                                                        <a class="p-2 btn btn-success rounded-circle d-flex  m-0 w-50 justify-content-center">
                                                            <i class="material-icons opacity-10"><?=  $icon ?></i>
                                                        </a>
                                                    <?php   } else if ($details['INDICADOR'] <> 1 && $details['DCG_TRA_CODIGO'] != '052') { ?>
                                                        <a onclick="activeTrans(this)" data-number="<?= $details['DCG_NUMERO'] ?>" data-det="<?= $details['DCG_TRA_CODIGO'] ?>" class="p-2 btn btn-light rounded-circle d-flex  m-0 w-50 justify-content-center">
                                                            <i class="material-icons opacity-10"><?=  $icon ?></i>
                                                        </a>
                                                    <?php } else if ($details['DCG_TRA_CODIGO'] == '052'  && $details['DCG_IMPORT'] != 1) { ?>
                                                        <a onclick="activeTrans(this)" data-number="<?= $details['DCG_NUMERO'] ?>" data-det="<?= $details['DCG_TRA_CODIGO'] ?>" class="p-2 btn btn-light rounded-circle d-flex  m-0 w-50 justify-content-center">
                                                            <i class="material-icons opacity-10"><?=  $icon ?></i>
                                                        </a>
                                                    <?php } else if ($details['DCG_TRA_CODIGO'] == '052' && $details['DCG_IMPORT'] == 1) { ?>
                                                        <a data-number="<?= $details['DCG_NUMERO'] ?>" data-det="<?= $details['DCG_TRA_CODIGO'] ?>" class="p-2 btn btn-warning rounded-circle d-flex  m-0 w-50 justify-content-center">
                                                            <i class="material-icons opacity-10"><?=  $icon ?></i>
                                                        </a>

                                                    <?php } else { ?>
                                                        <a data-number="<?= $details['DCG_NUMERO'] ?>" data-det="<?= $details['DCG_TRA_CODIGO'] ?>" class="p-2 btn btn-light rounded-circle d-flex  m-0 w-50 justify-content-center">
                                                            <i class="material-icons opacity-10"><?=  $icon ?></i>
                                                        </a>
                                                    <?php   } ?>
                                                </div>
                                            </td>
                                            <?php break; ?>

                                        <?php
                                        case '0': ?>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-warning">Proceso</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="w-100 d-flex justify-content-center">

                                                    <a class="p-2 btn btn-light rounded-circle d-flex  m-0 w-50 justify-content-center">
                                                        <i class="material-icons opacity-10"><?=  $icon ?></i>
                                                    </a>
                                                </div>
                                            </td>
                                            <?php break; ?>
                                    <?php endswitch ?>

                                    <td class="align-middle text-center">
                                        <div class="w-100 d-flex justify-content-center">

                                            <?php if ($details['PDA_TRANF_ID'] <> 0  && $details['DCG_SINCRO'] <> 0) { ?>
                                                <a class="p-2 btn btn-success rounded-circle d-flex  m-0 w-50 justify-content-center btn-sincro" data-number="<?= $details['DCG_NUMERO'] ?>" data-det="<?= $details['DCG_TRA_CODIGO'] ?>">
                                                    <i class="material-icons opacity-10">sync</i>
                                                </a>
                                            <?php } else if ($details['PDA_TRANF_ID'] <> 0  && $details['DCG_SINCRO'] == 0) {  ?>
                                                <a onclick="sincroGuia(this)" class="p-2 btn btn-light rounded-circle d-flex  m-0 w-50 justify-content-center btn-sincro" data-number="<?= $details['DCG_NUMERO'] ?>" data-det="<?= $details['DCG_TRA_CODIGO'] ?>">
                                                    <i class="material-icons opacity-10">sync</i>
                                                </a>

                                            <?php } else {  ?>
                                                <a class="p-2 btn btn-success-previo rounded-circle d-flex  m-0 w-50 justify-content-center btn-sincro" data-number="<?= $details['DCG_NUMERO'] ?>" data-det="<?= $details['DCG_TRA_CODIGO'] ?>">
                                                    <i class="material-icons opacity-10">sync</i>
                                                </a>

                                            <?php }   ?>

                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold"><?php echo $details['DCG_FECHA'] ?></span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold"><?php echo $details['INICIO'] ?> | <?php echo $details['FIN'] ?> </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold"><?php echo $details['DURACION'] ?></span>
                                    </td>


                                    <td class="align-middle text-center">
                                        <div class="w-100 d-flex justify-content-center">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a class="p-2 btn btn-danger rounded-1 d-flex  m-1 w-50 justify-content-center" onclick="ticket('<?= $details['DCG_NUMERO'] . '|' . $details['DCG_TRA_CODIGO'] ?>|000001')">
                                                    <i class="material-icons opacity-10">format_list_numbered</i>
                                                </a>
                                                <a class="p-2 btn btn-danger rounded-1 d-flex  m-1 w-50 justify-content-center" onclick="ticketGeneral('<?= $details['DCG_NUMERO'] . '|' . $details['DCG_TRA_CODIGO'] ?>|000001')">
                                                    <i class="material-icons opacity-10">picture_as_pdf</i>
                                                </a>
                                            </div>
                                        </div>
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