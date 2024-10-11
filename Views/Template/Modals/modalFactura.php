<div class="modal fade" id="modalViewFactura" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titleModal">Factura</h5>
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
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label"> Factura: </label>
                <input type="text" class="form-control" id="invoice" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">

                <label class="form-label"> Fecha Emision: </label>
                <input type="date" class="form-control" id="date_issue" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">

                <label class="form-label"> Fecha de Vencimiento: </label>
                <input type="date" class="form-control" id="date_expiration" readonly>

              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">

                <label class="form-label"> Monto Total: </label>
                <input type="text" class="form-control" id="total_amount" readonly>
              </div>
            </div>


            <div class="col-md-12">
              <hr>
              <label for="form-label"> DETALLES DE SERVICIO:</label>
              <hr>
              <table class="table table-sm table-striped" style="width: 100%;" >
                <thead>
                  <tr>
                   
                    <th>Descripción</th>
                    <th> Cantidad</th>
                   
                  </tr>

                </thead>
                <tbody id="detailsInvoice">
                  <tr>
                 
                    <td>Descripción</td>
                    <td>00000</td>
                  
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