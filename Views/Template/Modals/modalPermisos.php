<div class="modal fade modalPermisos" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel4">Permisos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
            <?php 
                //dep($data);
             ?>
            <div class="col-md-12">
              <div class="tile">
                <form action="" id="formPermisos" name="formPermisos">
                  <input type="hidden" id="idrol" name="idrol" value="<?= $data['idrol']; ?>" required="">
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Módulo</th>
                            <th>Ver</th>
                            <th>Crear</th>
                            <th>Actualizar</th>
                            <th>Eliminar</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $no=1;
                                $modulos = $data['modulos'];
                                for ($i=0; $i < count($modulos); $i++) { 

                                    $permisos = $modulos[$i]['permisos'];
                                    $rCheck = $permisos['r'] == 1 ? " checked " : "";
                                    $wCheck = $permisos['w'] == 1 ? " checked " : "";
                                    $uCheck = $permisos['u'] == 1 ? " checked " : "";
                                    $dCheck = $permisos['d'] == 1 ? " checked " : "";

                                    $idmod = $modulos[$i]['id'];
                            ?>
                          <tr>
                            <td>
                                <?= $no; ?>
                                <input type="hidden" name="modulos[<?= $i; ?>][id]" value="<?= $idmod ?>" required >
                            </td>
                            <td>
                                <?= $modulos[$i]['title']; ?>
                            </td>
                            <td>

                                <div class="form-check form-switch">
                                  <label class="form-check-label" for="<?= $modulos[$i]['title'].'r' ?>">
                                    <input type="checkbox" id="<?= $modulos[$i]['title'].'r' ?>" name="modulos[<?= $i; ?>][r]" <?= $rCheck ?> class="form-check-input">
                                  </label>
                                </div>
                            </td>
                            <td>

                                <div class="form-check form-switch">
                                  <label class="form-check-label" for="<?= $modulos[$i]['title'].'w' ?>">
                                    <input type="checkbox" id="<?= $modulos[$i]['title'].'w' ?>" name="modulos[<?= $i; ?>][w]" <?= $wCheck ?> class="form-check-input">
                                  </label>
                                </div>

                            </td>
                            <td>

                                <div class="form-check form-switch">
                                  <label class="form-check-label" for="<?= $modulos[$i]['title'].'u' ?>">
                                    <input type="checkbox" id="<?= $modulos[$i]['title'].'u' ?>" name="modulos[<?= $i; ?>][u]" <?= $uCheck ?> class="form-check-input">
                                  </label>
                                </div>

                            </td>
                            <td>

                                <div class="form-check form-switch">
                                  <label class="form-check-label" for="<?= $modulos[$i]['title'].'d' ?>">
                                    <input type="checkbox" id="<?= $modulos[$i]['title'].'d' ?>" name="modulos[<?= $i; ?>][d]" <?= $dCheck ?> class="form-check-input">
                                  </label>
                                </div>


                            </td>
                          </tr>
                          <?php 
                                $no++;
                            }
                            ?>
                        </tbody>
                      </table>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle" aria-hidden="true"></i> Guardar</button>
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal" aria-label="Close"><i class="app-menu__icon fas fa-sign-out-alt" aria-hidden="true"></i> Salir</button>
                    </div>
                </form>
              </div>
            </div>
        </div>

    </div>
  </div>
</div>