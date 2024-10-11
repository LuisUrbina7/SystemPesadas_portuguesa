          <footer class="footer py-4  ">
            <div class="container-fluid">
              <div class="row align-items-center justify-content-lg-between">
                <div class="col-lg-6 mb-lg-0 mb-4">
                  <div class="copyright text-center text-sm text-muted text-lg-start">
                    © <script>
                      document.write(new Date().getFullYear())
                    </script>,
                    by
                    <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">ADN SOFTWARE</a>

                  </div>
                </div>

              </div>
            </div>
          </footer>
          </div>
          </main>



          <!--   Core JS Files   -->
          <script src="<?= media() ?>/js/core/popper.min.js"></script>
          <script src="<?= media() ?>/js/core/bootstrap.min.js"></script>
          <script src="<?= media() ?>/js/plugins/perfect-scrollbar.min.js"></script>
          <script src="<?= media() ?>/js/plugins/smooth-scrollbar.min.js"></script>
          <script src="<?= media() ?>/js/plugins/chartjs.min.js"></script>


          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

          <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
              var options = {
                damping: '0.5'
              }
              Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }


            function toggleMenu() {
              var elemento = document.getElementById("menuMain");
              var aside = document.getElementById("sidenav-main");
              elemento.classList.toggle("toggleDashboard");
              aside.classList.toggle("toggleSnider");

              //aside.classList.toggle("navbar-vertical navbar-expand-xs fixed-start");
            }
          </script>
          <!-- Github buttons -->
          <script async defer src="<?= media() ?>/js/buttons.js"></script>
          <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
          <script src="<?= media() ?>/js/material-dashboard.min.js?v=3.1.0"></script>


          <script>
            const base_url = "<?= base_url(); ?>";
          </script>

          <script src="<?=  media() ?>/dataTables/js/jquery-ui.js"></script>
          <script src="<?=  media() ?>/dataTables/js/dataTables.js"></script>
          <script src="<?=  media() ?>/dataTables/js/dataTables.jqueryui.js"></script>
          <script src="<?=  media() ?>/dataTables/js/chart.js"></script>

          <script src="<?= media() ?>/js/<?= $data['page_functions_js'] ?>"> </script>

          <script>
            $(document).ready(function() {
              var table = $('#table-odc').DataTable({
                "language": {
                  "lengthMenu": "Mostrar _MENU_ registros por página",
                  "zeroRecords": "No hay datos - Disculpa",
                  "info": "Página _PAGE_ de _PAGES_",
                  "infoEmpty": "No records available",
                  "infoFiltered": "(filtrado por _MAX_ registros totales)",
                  "search": "Buscar:",
                  "paginate": {
                    "next": ">",
                    "previous": "<"

                  }
                }
              });

              $('input[type=radio][name=statusFilter]').on('change', function() {
                var filterValue = this.value;

             
                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                  var status = $(table.row(dataIndex).node()).find('td:eq(3) span').text();



                  if (filterValue === 'all') {
                    return true;
                  } else {
                    return status === filterValue;
                  }
                });

                table.draw();

             
                $.fn.dataTable.ext.search.pop();
              });
            });

            $(document).ready(function() {
              var table = $('#table-guia').DataTable({
                "language": {
                  "lengthMenu": "Mostrar _MENU_ registros por página",
                  "zeroRecords": "No hay datos - Disculpa",
                  "info": "Página _PAGE_ de _PAGES_",
                  "infoEmpty": "No records available",
                  "infoFiltered": "(filtrado por _MAX_ registros totales)",
                  "search": "Buscar:",
                  "paginate": {
                    "next": ">",
                    "previous": "<"

                  }
                }
              });

              $('input[type=radio][name=statusFilter]').on('change', function() {
                var filterValue = this.value;

             
                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                  var status = $(table.row(dataIndex).node()).find('td:eq(3) span').text();



                  if (filterValue === 'all') {
                    return true;
                  } else {
                    return status === filterValue;
                  }
                });

                table.draw();

            
                $.fn.dataTable.ext.search.pop();
              });
            });
          </script>



          </body>

          </html>