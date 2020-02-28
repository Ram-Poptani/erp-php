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

        <!-- 
            YOUR
            ACTUAL
            UI
            CODE
            GOES
            HERE
         -->

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




</body>

</html>
