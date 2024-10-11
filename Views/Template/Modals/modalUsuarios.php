<!-- Modal -->
<div class="modal fade" id="modalFormUsuario" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content">
       <div class="modal-header">
        <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div id="divLoading" >
          <div>
            <img src="<?= media(); ?>/img/brand/loading.svg" alt="Loading">
          </div>
        </div>

            <form id="formUsuario" name="formUsuario" class="form-horizontal">
              <input type="hidden" id="idUsuario" name="idUsuario" value="">
              <p class="text-primary">Todos los campos son obligatorios.</p>


             
                <div class="form-group col-md-12 mb-3">
                  <label for="txtNombre">Nombre</label>
                  <input type="text" class="form-control valid validText" id="name" name="name" required="">
                </div>

                <div class="form-group col-md-12 mb-3">
                  <label for="txtNombre">Usuario</label>
                  <input type="text" class="form-control valid validText" id="username" name="username" required="">
                </div>
               
              <div class="form-row">
                <div class="form-group col-md-12 mb-3">
                    <label for="listRolid">Rol usuario</label>
                    <select class="form-control selectpicker" data-live-search="true" id="listRolid" name="listRolid" required >
                    </select>
                </div>
                <div class="form-group col-md-12 mb-3">
                    <label for="listStatus">Status</label>
                    <select class="form-control selectpicker" id="listStatus" name="listStatus" required >
                        <option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                    </select>
                </div>
             </div>
             

             <div class="form-row">
                <div class="form-group col-md-12 mb-4">
                  <label for="txtPassword">Password</label>
                  <input type="password" class="form-control" id="password" name="password" >
                </div>
             </div>

              <div class="tile-footer">
                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
              </div>

            </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewUser" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Identificación:</td>
              <td id="celIdentificacion">654654654</td>
            </tr>
            <tr>
              <td>Nombres:</td>
              <td id="celNombre">Jacob</td>
            </tr>
            <tr>
              <td>Apellidos:</td>
              <td id="celApellido">Jacob</td>
            </tr>
            <tr>
              <td>Teléfono:</td>
              <td id="celTelefono">Larry</td>
            </tr>
            <tr>
              <td>Email (Usuario):</td>
              <td id="celEmail">Larry</td>
            </tr>
            <tr>
              <td>Tipo Usuario:</td>
              <td id="celTipoUsuario">Larry</td>
            </tr>
            <tr>
              <td>Estado:</td>
              <td id="celEstado">Larry</td>
            </tr>
            <tr>
              <td>Fecha registro:</td>
              <td id="celFechaRegistro">Larry</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

