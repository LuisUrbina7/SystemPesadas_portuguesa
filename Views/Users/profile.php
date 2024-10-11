<?php headerAdmin($data); ?>

<div id="divLoading">
  <div>
      <img src="<?= media(); ?>/img/loading.svg" alt="Loading">
  </div>
</div>

<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Configuración de cuenta /</span> <?= $_SESSION['userData']['username'] ?></h4>

              <div class="row">
                <div class="col-md-12">
                  
                  <div class="card mb-4">
                    <h5 class="card-header">Cambiar contraseña</h5>
                    
                    <hr class="my-0" />
                    <div class="card-body">
                      <form id="formEdit" method="POST">
                        <div class="row">
                          
                          <input type="hidden" name="idUser" id="idUser" value="<?= $_SESSION['userData']['id'] ?>">

                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label">Nombre de usuario</label>
                            <input class="form-control" type="text" value="<?= $_SESSION['userData']['username'] ?>" readonly/>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="lastName" class="form-label">Email</label>
                            <input class="form-control" type="text" name="email" id="email" value="<?= $_SESSION['userData']['email'] ?>" />
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="lastName" class="form-label">Contraseña</label>
                            <input class="form-control" type="password" name="password" id="password" value="" />
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="lastName" class="form-label">Confirmar Contraseña</label>
                            <input class="form-control" type="password" name="confirmPassword" id="confirmPassword" value="" />
                          </div>
                          
                          
                        <div class="mt-2">
                          <input type="submit" class="btn btn-primary me-2" value="Guardar Cambios">
                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>
                  
                </div>
              </div>
            </div>
            <!-- / Content -->

            <!-- Footer -->
            
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>

<?php footerAdmin($data); ?>