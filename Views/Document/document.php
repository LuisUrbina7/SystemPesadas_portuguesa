<?php headerAdmin($data); ?>

<audio controls muted autoplay id="audio" style="display: none;">
    <source src="<?= base_url() ?>/boton.mp3" type="audio/mpeg">
    Tu navegador no es compatible para reproducir audio.
</audio>

<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3"> Ordenes de Compras. </h6>


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
                    <table class="table align-items-center mb-0" id="table-odc">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Numero</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Proveedor</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Toneladas</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estatus</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Intervalos</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Duracion</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>





                            <?php foreach ($data['page_data'] as $details) {    ?>
                                <tr class="list-odc-style">
                                    <td>
                                        <a href="<?= base_url() ?>/Document/details?id=<?= $details['DPV_NUMERO'] ?>&pv=<?= $details['DPV_PVD_CODIGO'] ?>" class="text-decoration-none">
                                            <div class="d-flex px-2 py-1">
                                                <div class="p-2 btn btn-light rounded-circle d-flex me-2 m-0">
                                                    <i class="material-icons opacity-10">stream</i>
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?php echo $details['DPV_NUMERO'] ?> </h6>
                                                    <p class="text-xs text-secondary mb-0"><?php echo $details['DPV_SCS_CODIGO'] ?></p>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?php echo $details['DPV_PVD_CODIGO'] ?></p>
                                        <p class="text-xs text-secondary mb-0"><?php echo $details['PVD_NOMBRE'] ?></p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-green"><?php echo $details['DPV_PESO'] ?></span>
                                    </td>
                                    <?php switch ($details['DPV_CERRADO']):
                                        case '1': ?>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-success">Cerrado</span>
                                            </td>
                                            <?php break; ?>

                                        <?php
                                        case '0': ?>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-warning">Proceso</span>
                                            </td>
                                            <?php break; ?>


                                        <?php
                                        case '0': ?>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-warning">Proceso</span>
                                            </td>
                                            <?php break; ?>
                                        <?php
                                        default: ?>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-warning">Proceso</span>
                                            </td>
                                            <?php break; ?>
                                    <?php endswitch ?>

                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold"><?php echo $details['DPV_FECHA'] ?></span>
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
                                            <a class="p-2 btn btn-danger rounded-1 d-flex  m-1 w-50 justify-content-center" onclick="ticket('<?= $details['DPV_NUMERO'].'|'.$details['DPV_PVD_CODIGO'].'|'.$details['DPV_SCS_CODIGO'] ?>')">
                                                <i class="material-icons opacity-10">format_list_numbered</i>
                                            </a>
                                            <a class="p-2 btn btn-danger rounded-1 d-flex  m-1 w-50 justify-content-center" onclick="ticketGeneral('<?= $details['DPV_NUMERO'].'|'.$details['DPV_PVD_CODIGO'].'|'.$details['DPV_SCS_CODIGO'] ?>')">
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