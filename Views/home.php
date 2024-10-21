<?php headerAdmin($data); ?>


<div class="container-fluid py-4">
  <div class="row">
    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
            <i class="material-icons opacity-10">weekend</i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0 text-capitalize">Total Registros</p>
            <h4 class="mb-0"><?= $data['page_data_total'][0]['CANTIDAD'] ?></h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
          <p class="mb-0"><span class="text-success text-sm font-weight-bolder">0% </span>Dato Anual</p>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
            <i class="material-icons opacity-10">grain</i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0 text-capitalize">Datos Anual</p>
            <h4 class="mb-0"><?= $data['page_data_total'][1]['CAJA_ONE'] ?> CJ | <?= $data['page_data_total'][1]['UND_KG_ONE'] ?> UND </h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
          <p class="mb-0"><span class="text-success text-sm font-weight-bolder">0% </span>Ordenes Pesadas.</p>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
            <i class="material-icons opacity-10">accessibility_new</i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0 text-capitalize">Clientes</p>
            <h4 class="mb-0"><?= $data['page_data_total'][2]['CAJA_TWO'] ?> CJ | <?= $data['page_data_total'][2]['UND_KG_TWO'] ?> UND </h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
          <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">%</span> Guias Pesadas.</p>
        </div>
      </div>
    </div>

  </div>

  <div class="row mt-4">

    <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
      <div class="card">
        <div class="card-header pb-0">
          <div class="row">
            <div class="col-lg-6 col-7">
              <h6>Por Transferir</h6>
              <p class="text-sm mb-0">
                <i class="fa fa-check text-info" aria-hidden="true"></i>
                <span class="font-weight-bold ms-1">Ultimos 30</span> dias.
              </p>
            </div>

          </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Descripcion</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Transportista</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tonelada</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($data['page_data_byTransfer'] as $byTransfer) {   ?>
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div>
                          <i class="material-icons opacity-10">add_alarm</i>
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-sm"> <?= $byTransfer['PDA_NUMERO'] ?></h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="avatar-group mt-2">
                        <p class="text-sm"> <?= $byTransfer['TRA_NOMBRE'] ?></p>
                      </div>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="text-xs font-weight-bold"> <?= $byTransfer['TONELADA'] ?> </span>
                    </td>
                    <td class="align-middle">
                      <div class="progress-wrapper w-75 mx-auto">
                        <div class="progress-info">
                          <div class="progress-percentage">
                            <?php if ($byTransfer['TRANSFERENCIA']) { ?>
                              <span class="badge badge-sm bg-gradient-danger">Transferido.</span>

                            <?php } else { ?>
                              <span class="badge badge-sm bg-gradient-success">Por Transferir.</span>
                            <?php } ?>
                          </div>
                        </div>

                      </div>
                    </td>
                  </tr>
                <?php }  ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 mt-4 mb-3">
      <div class="card z-index-2 ">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
          <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">
            <div class="chart">
              <canvas id="myGlobal" width="400" height="200"></canvas>
            </div>
          </div>
        </div>
        <div class="card-body">
          <h6 class="mb-0 "></h6>
          <p class="text-sm "></p>
          <hr class="dark horizontal">
          <div class="d-flex ">
            <i class="material-icons text-sm my-auto me-1"></i>
            <p class="mb-0 text-sm"></p>
          </div>
        </div>
      </div>
    </div>
  </div>


</div>



<?php footerAdmin($data); ?>