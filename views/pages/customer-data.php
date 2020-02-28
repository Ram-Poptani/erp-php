<?php
require_once __DIR__ . '/../../helper/init.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
<?php require_once(__DIR__ . "/../includes/head-section.php"); ?>

<!-- ADD CUSTOM CSS HERE -->

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php require_once(__DIR__ . "/../includes/sidebar.php"); ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php require_once(__DIR__ . "/../includes/navbar.php"); ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
<?php
if (isset($_GET['customer_id'])):
    $customer_id = $_GET['customer_id'];
?>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Customer</h1>
            <a href="<?= BASEPAGES;?>edit-customer.php/?customer_id=<?=$customer_id?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
              <i class="fa fa-pencil-alt fa-sm text-white-75"></i> Edit Customer
            </a>
        </div>

        <!-- 
            YOUR
            ACTUAL
            UI
            CODE
            GOES
            HERE
         -->
         <!--CUSTOMER DETAILS-->

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">

                    </div>
                </div>
            </div>
        </div>
<?php
else:
    require_once(__DIR__ . "/../includes/404.php");
endif;
?>
         

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php require_once(__DIR__ . "/../includes/footer.php"); ?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <?php require_once(__DIR__ . "/../includes/scroll-to-top.php"); ?>
  <!-- /Scroll to Top Button-->
  
  <!-- SCRIPTS -->
  <?php require_once(__DIR__ . "/../includes/core-scripts.php"); ?>
  <!-- /SCRIPTS -->

  <!-- PAGE LEVEL SCRIPTS -->
  <?php require_once(__DIR__ . "/../includes/page-level/customer/customer-data-scripts.php"); ?>
  <!-- /PAGE LEVEL SCRIPTS -->




</body>

</html>
