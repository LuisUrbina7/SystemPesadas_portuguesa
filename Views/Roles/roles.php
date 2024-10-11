<?php 
    headerAdmin($data); 
    //getModal('modalRoles',$data);
?>

<div class="container-xxl flex-grow-1 container-p-y">

  <div id="contentAjax"></div>

  <h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Home /</span> Roles
  </h4>

  <!-- Basic Bootstrap Table -->
  <div class="card">
    <div class="card-header"></div>
    <div class="table-responsive text-nowrap">
      <table class="table" id="tableRoles">
        <thead>
           <tr>
            <th>ID</th>
            <th>Rol</th>
            <th>Descripción</th>
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
    