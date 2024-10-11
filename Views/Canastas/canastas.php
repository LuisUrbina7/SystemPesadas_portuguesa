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
                    <h6 class="text-white text-capitalize ps-3"> CRUD DE CANASTAS. </h6>


                </div>
            </div>

            <div class="w-30 d-flex justify-content-center pt-4">
                <a class="p-2 btn btn-success rounded-1 d-flex  m-1 w-50 justify-content-center" onclick="view_create_canasta()">
                    <i class="material-icons opacity-10">add</i>
                </a>             
            </div>
            <div class="card-body px-3 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Codigo</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Descripcion</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Equivalencia</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estatus</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Accion</th>
                            </tr>
                        </thead>
                        <tbody>





                            <?php foreach ($data['page_data'] as $details) {    ?>
                                <tr class="list-odc-style">
                                    <td>
                                        <a href="<?= base_url() ?>" class="text-decoration-none">
                                            <div class="d-flex px-2 py-1">
                                                <div class="p-2 btn btn-light rounded-circle d-flex me-2 m-0">
                                                    <i class="material-icons opacity-10">stream</i>
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?= $details['CTA_CODIGO']?></h6>
                                                    <p class="text-xs text-secondary mb-0">codigo</p>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?= $details['CTA_DESCRIPCION']?></p>
                                        <p class="text-xs text-secondary mb-0">nombre</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-green"><?= $details['CTA_EQUIVALENCIA']?></span>
                                    </td>
                                   
                                           

                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold"><?= $details['CTA_ACTIVO']?></span>
                                    </td>

                                    <td class="align-middle text-center">
                                        <div class="w-100 d-flex justify-content-center">
                                            <a class="p-2 btn btn-info rounded-1 d-flex  m-1 w-50 justify-content-center"  onclick="view_edit_canasta('<?= $details['CTA_CODIGO']?>')">
                                                <i class="material-icons opacity-10">edit</i>
                                            </a>
                                           
                                            <a class="p-2 btn btn-danger rounded-1 d-flex  m-1 w-50 justify-content-center"  onclick="delete_canasta('<?= $details['CTA_CODIGO']?>')">
                                                <i class="material-icons opacity-10">delete</i>
                                            </a>
                                           
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