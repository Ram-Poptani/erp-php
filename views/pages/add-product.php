<?php
require_once __DIR__ . '/../../helper/init.php';
$pageTitle = "Easy ERP | Add Product";
$sidebarSection = "products";
$sidebarSubSection = "add";
Util::createCSRFToken();
$errors = "";
if(Session::hasSession('errors'))
{
  $errors = unserialize(Session::getSession('errors'));
  Session::unsetSession('errors');
}
$old = "";
if(Session::hasSession('old'))
{
  $old = Session::getSession('old');
  Session::unsetSession('old');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  require_once __DIR__ . "/../includes/head-section.php";
  ?>

  <!--PLACE TO ADD YOUR CUSTOM CSS-->

</head>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php require_once(__DIR__ . "/../includes/sidebar.php"); ?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <?php require_once(__DIR__ . "/../includes/navbar.php"); ?>
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Product</h1>
            <a href="<?= BASEPAGES; ?>manage-products.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
              <i class="fa fa-list-ul fa-sm text-white-75"></i> Manage Product
            </a>
          </div>

          <div class="row">

            <div class="col-lg-12">

              <!-- Basic Card Example -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Add Product</h6>
                </div>
                <div class="card-body">
                  <div class="col-md-12">

<form action="<?=BASEURL;?>helper/routing.php" method="POST" id="add-product">
                      <input type="hidden" name="csrf_token" value="<?= Session::getSession('csrf_token');?>">

                      <div class="form-row">

                        <!--FORM GROUP name-->
                        <div class="form-group col-md-6">
                          <label for="name">Product Name</label>
                          <input  type="text" 
                                  name="name" 
                                  id="name" 
                                  class="form-control <?= $errors!='' && $errors->has('name') ? 'error' : '';?>"
                                  placeholder = "Enter Product Name"
                                  value="<?=$old != '' && isset($old['name']) ?$old['name']: '';?>"/>
                          <?php
                            if($errors!="" && $errors->has('name'))
                            {
                              echo "<span class='error'>{$errors->first('name')}</span>";
                            }
                          ?>
                        </div>
                        <!--/FORM GROUP name-->

                        <!--FORM GROUP category-->
                        <div class="form-group col-md-6">
                          <label for="category">Select Category</label>
                          <select class="custom-select <?= $errors!='' && $errors->has('category') ? 'error' : '';?>" id="category" name="category">
                            <option selected value ="">Select Category</option>
                          </select>
                          <?php
                            if($errors!="" && $errors->has('category'))
                            {
                              echo "<span class='error'>{$errors->first('category')}</span>";
                            }
                          ?>
                        </div>
                        <!--/FORM GROUP category-->
                      </div>

                      <div class="form-row">
                        <!--FORM GROUP hsn_code-->
                        <div class="form-group col-md-6">
                          <label for="hsn_code">HSN Code</label>
                          <input  type="text" 
                                  name="hsn_code" 
                                  id="hsn_code" 
                                  class="form-control <?= $errors!='' && $errors->has('hsn_code') ? 'error' : '';?>"
                                  placeholder = "Enter HSN Code"
                                  value="<?=$old != '' && isset($old['hsn_code']) ?$old['hsn_code']: '';?>"/>
                          <?php
                            if($errors!="" && $errors->has('hsn_code'))
                            {
                              echo "<span class='error'>{$errors->first('hsn_code')}</span>";
                            }
                          ?>
                        </div>
                        <!--/FORM GROUP hsn_code-->


                        <!--FORM GROUP quantity-->
                        <div class="form-group col-md-6">
                          <label for="quantity">Quantity</label>
                          <input  type="number" 
                                  min="0" 
                                  name="quantity" 
                                  id="quantity" 
                                  class="form-control <?= $errors!='' && $errors->has('quantity') ? 'error' : '';?>"
                                  placeholder = "Enter Quantity"
                                  value="<?=$old != '' && isset($old['quantity']) ?$old['quantity']: '';?>"/>
                          <?php
                            if($errors!="" && $errors->has('quantity'))
                            {
                              echo "<span class='error'>{$errors->first('quantity')}</span>";
                            }
                          ?>
                        </div>
                        <!--/FORM GROUP quantity-->
                      </div>

                      <div class="form-row">
                        <!--FORM GROUP eoq_level-->
                        <div class="form-group col-md-6">
                          <label for="eoq_level">EOQ Level</label>
                          <input  type="number" 
                                  min="0" 
                                  name="eoq_level" 
                                  id="eoq_level" 
                                  class="form-control <?= $errors!='' && $errors->has('eoq_level') ? 'error' : '';?>"
                                  placeholder = "Enter EOQ Level"
                                  value="<?=$old != '' && isset($old['eoq_level']) ?$old['eoq_level']: '';?>"/>
                          <?php
                            if($errors!="" && $errors->has('eoq_level'))
                            {
                              echo "<span class='error'>{$errors->first('eoq_level')}</span>";
                            }
                          ?>
                        </div>
                        <!--/FORM GROUP eoq_level-->


                        <!--FORM GROUP danger_level-->
                        <div class="form-group col-md-6">
                          <label for="danger_level">Danger Level</label>
                          <input  type="number" 
                                  min="0" 
                                  name="danger_level" 
                                  id="danger_level" 
                                  class="form-control <?= $errors!='' && $errors->has('danger_level') ? 'error' : '';?>"
                                  placeholder = "Enter Danger Level"
                                  value="<?=$old != '' && isset($old['danger_level']) ?$old['danger_level']: '';?>"/>
                          <?php
                            if($errors!="" && $errors->has('danger_level'))
                            {
                              echo "<span class='error'>{$errors->first('danger_level')}</span>";
                            }
                          ?>
                        </div>
                        <!--/FORM GROUP danger_level-->
                      </div>
                      <div class="form-row">
                        <!--FORM GROUP selling_rate-->
                        <div class="form-group col-md-6">
                            <label for="selling_rate">Selling Price</label>
                            <input  type="number" 
                                    min="0" 
                                    name="selling_rate" 
                                    id="selling_rate" 
                                    class="form-control <?= $errors!='' && $errors->has('selling_rate') ? 'error' : '';?>"
                                    placeholder = "Enter Selling Price"
                                    value="<?=$old != '' && isset($old['selling_rate']) ?$old['selling_rate']: '';?>"/>
                            <?php
                              if($errors!="" && $errors->has('selling_rate'))
                              {
                                echo "<span class='error'>{$errors->first('selling_rate')}</span>";
                              }
                            ?>
                          </div>
                          <!--/FORM GROUP selling_rate-->
                      </div>
                      <div class="form-row">
                      <label for="specification"> Specification </label>
                        <!--FORM GROUP specification-->
                        <div class="form-group col-md-12">
                          <textarea
                                  name="specification" 
                                  id="specification" 
                                  class="form-control <?= $errors!='' && $errors->has('specification') ? 'error' : '';?>"
                                  placeholder = "Enter Specification"
                                  value="<?=$old != '' && isset($old['specification']) ?$old['specification']: '';?>"
                                  ></textarea>
                          <?php
                            if($errors!="" && $errors->has('specification'))
                            {
                              echo "<span class='error'>{$errors->first('specification')}</span>";
                            }
                          ?>
                        </div>
                        <!--/FORM GROUP specification-->
                      </div>


                      <button type="submit" class="btn btn-primary" name="add_product" value="addProduct"><i class="fa fa-check"></i> Submit</button>
</form>

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
      <?php require_once(__DIR__ . "/../includes/footer.php"); ?>
      <!-- End of Footer -->
    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->
  <?php
  require_once(__DIR__ . "/../includes/scroll-to-top.php");
  ?>
  <?php require_once(__DIR__ . "/../includes/core-scripts.php"); ?>
  
  <!--PAGE LEVEL SCRIPTS-->
  <?php require_once(__DIR__ . "/../includes/page-level/product/add-product-scripts.php");?>
</body>

</html>