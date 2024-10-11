<div class="modal fade" id="modalViewTicket" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titleModal">Ticket</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div id="divLoading">
          <div>
            <img src="<?= media(); ?>/img/brand/loading.svg" alt="Loading">
          </div>
        </div>

        <section id="jsonData">

          <div class="row">
            <div class="col-md-3">
              <div class="mb-2">
                <label class="form-label"> Tickect: </label>
                <input type="text" class="form-control" id="tickect" readonly>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-2">
                <label class="form-label"> Asunto: </label>
                <input type="text" class="form-control" id="matter" readonly>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-2">

                <label class="form-label"> Fecha Emision: </label>
                <input type="text" class="form-control" id="creation" readonly>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-2">

                <label class="form-label"> Creado : </label>
                <input type="text" class="form-control" id="creator" readonly>

              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-2">

                <label class="form-label"> Prioridad: </label>
                <input type="text" class="form-control" id="priority" readonly>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-2">

                <label class="form-label"> Tecnico: </label>
                <input type="text" class="form-control" id="technical" readonly>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-2">

                <label class="form-label"> Departamento: </label>
                <input type="text" class="form-control" id="department" readonly>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-2">

                <label class="form-label"> Origen_reporte: </label>
                <input type="text" class="form-control" id="origin" readonly>
              </div>
            </div>
            <div class="col-md-12">
              <div class="mb-2">
                <label for="">Descripción</label>
                <textarea class="form-control"  name="" id="description"  rows="2" disabled></textarea>
              </div>
            </div>


            <div class="col-md-12">
              <hr>
              <label for="form-label"> DETALLES DE SERVICIO:</label>
              <hr>
              <table class="table table-sm table-striped" style="width: 100%;">
                <thead>
                  <tr>

                    <th>ID</th>
                    <th>NOMBRE</th>
                    <th> DIRECCION</th>

                  </tr>

                </thead>
                <tbody id="detailsInvoice">
                  <tr>
                  <td> <p class="text-muted" id="services"> servicio  </p></td>
                    <td> <p class="text-muted" id="name"> servicio  </p></td>
                    <td> <p  id="address">  descripcion   </p> </td>

                  </tr>
                </tbody>
              </table>
            </div>
          </div>

        </section>

      </div>

      <div class="modal-footer">
        <a class="btn btn-info text-white" data-bs-dismiss="modal">Cerrar.</a>
      </div>
    </div>
  </div>
</div>