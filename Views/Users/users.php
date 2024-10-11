<?php 
headerAdmin($data); 
getModal('modalUsuarios',$data);
?>


<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Home /</span> Usuarios
  </h4>

  <!-- Basic Bootstrap Table -->
  <div class="card">
    <div class="card-header"></div>
    <div class="table-responsive text-nowrap">
      <table class="table" id="tableUsuarios">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Rol</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
  <!--/ Basic Bootstrap Table -->

  <hr class="my-5">

</div>


<?php footerAdmin($data); ?>
