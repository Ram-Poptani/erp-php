<?php
require_once __DIR__ . '/../../helper/init.php';
$pageTitle = "Quick ERP | Current Inventory";
$sidebarSection = "products";
$sidebarSubSection = "current_inventory";
Util::createCSRFToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php  require_once __DIR__ . "/../includes/head-section.php"; ?>
  <!--PLACE TO ADD YOUR CUSTOM CSS-->
  <link rel="stylesheet" href="<?=BASEASSETS;?>vendor/toastr/toastr.min.css">
  <!--DATATABLE BUTTONS CSS-->
  <link href="<?= BASEASSETS; ?>vendor/DataTables/Buttons-1.6.1/css/buttons.bootstrap4.min.css" rel="stylesheet">
  <!--DATATABLE CSS-->
  <link href="<?= BASEASSETS; ?>vendor/DataTables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>
<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php require_once(__DIR__. "/../includes/sidebar.php");?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <?php require_once(__DIR__. "/../includes/navbar.php");?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Inventory</h1>
            <div id="dt-buttons"></div>
            <!-- <a href="add-product.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
              <i class="fa fa-plus fa-sm text-white-75"></i> Add Product
            </a> -->
        </div>
          <!--
          
          YOUR
          ACTUAL
          UI
          CODE
          GOES
          HERE

          -->

          <!--MANAGE SUPPLIER DATATABLE-->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Products in low quantity</h6>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card-body">
                  <div class="chart-pie">
                    <canvas id="quantity-chart">
                    </canvas>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="low-quantity-products-datatable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Product Name</th>
                          <th>Quantity</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php require_once(__DIR__. "/../includes/footer.php");?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->






  <?php
  require_once(__DIR__ . "/../includes/scroll-to-top.php");
  ?>
  <?php require_once(__DIR__."/../includes/core-scripts.php");?>
  <!--PAGE LEVEL SCRIPTS-->
  <?php require_once(__DIR__."/../includes/page-level/product/check-current-inventory-scripts.php");?>


</body>

</html>
