<?php
require_once __DIR__ . '/../../helper/init.php';
$pageTitle = "Easy ERP | Add Customer";
$sidebarSection = "customer";
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
            <h1 class="h3 mb-0 text-gray-800">Customer</h1>
            <a href="<?= BASEPAGES; ?>manage-customers.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
              <i class="fa fa-list-ul fa-sm text-white-75"></i> Manage Customer
            </a>
          </div>

          <div class="row">

            <div class="col-lg-12">

              <!-- Basic Card Example -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Add Customer</h6>
                </div>
                <div class="card-body">
                  <div class="col-md-12">

                  <form action="<?=BASEURL;?>helper/routing.php" method="POST" id="add-customer">
                      <input type="hidden" name="csrf_token" value="<?= Session::getSession('csrf_token');?>">

                      <div class="form-row">

                        <!--FORM GROUP first_name-->
                        <div class="form-group col-md-6">
                          <label for="first_name">First Name</label>
                          <input  type="text" 
                                  name="first_name" 
                                  id="first_name" 
                                  class="form-control <?= $errors!='' && $errors->has('first_name') ? 'error' : '';?>"
                                  placeholder = "Enter First Name"
                                  value="<?=$old != '' && isset($old['first_name']) ?$old['first_name']: '';?>"/>
                          <?php
                            if($errors!="" && $errors->has('first_name'))
                            {
                              echo "<span class='error'>{$errors->first('first_name')}</span>";
                            }
                          ?>
                        </div>
                        <!--/FORM GROUP first_name-->

                        <!--FORM GROUP last_name-->
                        <div class="form-group col-md-6">
                          <label for="last_name">Last Name</label>
                          <input  type="text" 
                                  name="last_name" 
                                  id="last_name" 
                                  class="form-control <?= $errors!='' && $errors->has('last_name') ? 'error' : '';?>"
                                  placeholder = "Enter Last Name"
                                  value="<?=$old != '' && isset($old['last_name']) ?$old['last_name']: '';?>"/>
                          <?php
                            if($errors!="" && $errors->has('last_name'))
                            {
                              echo "<span class='error'>{$errors->first('last_name')}</span>";
                            }
                          ?>
                        </div>
                        <!--/FORM GROUP last_name-->

                      </div>

                      <div class="form-row">
                        <!--FORM GROUP phone_no-->
                        <div class="form-group col-md-6">
                          <label for="phone_no">Phone</label>
                          <input  type="text" 
                                  name="phone_no" 
                                  id="phone_no" 
                                  class="form-control <?= $errors!='' && $errors->has('phone_no') ? 'error' : '';?>"
                                  placeholder = "Enter Phone No"
                                  value="<?=$old != '' && isset($old['phone_no']) ?$old['phone_no']: '';?>"/>
                          <?php
                            if($errors!="" && $errors->has('phone_no'))
                            {
                              echo "<span class='error'>{$errors->first('phone_no')}</span>";
                            }
                          ?>
                        </div>
                        <!--/FORM GROUP phone_no-->


                        <!--FORM GROUP email_id-->
                        <div class="form-group col-md-6">
                          <label for="email_id">Email</label>
                          <input  type="email" 
                                  name="email_id" 
                                  id="email_id" 
                                  class="form-control <?= $errors!='' && $errors->has('email_id') ? 'error' : '';?>"
                                  placeholder = "Enter Email"
                                  value="<?=$old != '' && isset($old['email_id']) ?$old['email_id']: '';?>"/>
                          <?php
                            if($errors!="" && $errors->has('email_id'))
                            {
                              echo "<span class='error'>{$errors->first('email_id')}</span>";
                            }
                          ?>
                        </div>
                        <!--/FORM GROUP email_id-->
                      </div>

                      <div class="form-row">
                        <!--FORM GROUP gender-->
                        <div class="form-group col-md-6">
                          <label for="gender">Gender</label>
                          
                          <select class="custom-select <?= $errors!='' && $errors->has('gender') ? 'error' : '';?>" id="gender" name="gender">
                            <option selected value ="Not Specified">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                          </select>
                          <?php
                            if($errors!="" && $errors->has('gender'))
                            {
                              echo "<span class='error'>{$errors->first('gender')}</span>";
                            }
                          ?>
                        </div>
                        <!--/FORM GROUP gender-->


                        <!--FORM GROUP gst_no-->
                        <div class="form-group col-md-6">
                          <label for="gst_no">GST No</label>
                          <input  type="text" 
                                  name="gst_no" 
                                  id="gst_no" 
                                  class="form-control <?= $errors!='' && $errors->has('gst_no') ? 'error' : '';?>"
                                  placeholder = "Enter GST No"
                                  value="<?=$old != '' && isset($old['gst_no']) ?$old['gst_no']: '';?>"/>
                          <?php
                            if($errors!="" && $errors->has('gst_no'))
                            {
                              echo "<span class='error'>{$errors->first('gst_no')}</span>";
                            }
                          ?>
                        </div>
                        <!--/FORM GROUP gst_no-->
                      </div>
                      
                      <label for="">Address:</label>
                      <div class="form-row">
                        <!--FORM GROUP block_no-->
                        <div class="form-group col-md-6">
                          <label for="block_no">Block No</label>
                          <input  type="text" 
                                  name="block_no" 
                                  id="block_no" 
                                  class="form-control <?= $errors!='' && $errors->has('block_no') ? 'error' : '';?>"
                                  placeholder = "Enter Block No"
                                  value="<?=$old != '' && isset($old['block_no']) ?$old['block_no']: '';?>"/>
                          
                          <?php
                            if($errors!="" && $errors->has('block_no'))
                            {
                              echo "<span class='error'>{$errors->first('block_no')}</span>";
                            }
                          ?>
                        </div>
                        <!--/FORM GROUP block_no-->


                        <!--FORM GROUP street-->
                        <div class="form-group col-md-6">
                          <label for="street">Street</label>
                          <input  type="text" 
                                  name="street" 
                                  id="street" 
                                  class="form-control <?= $errors!='' && $errors->has('street') ? 'error' : '';?>"
                                  placeholder = "Enter Street"
                                  value="<?=$old != '' && isset($old['street']) ?$old['street']: '';?>"/>
                          <?php
                            if($errors!="" && $errors->has('street'))
                            {
                              echo "<span class='error'>{$errors->first('street')}</span>";
                            }
                          ?>
                        </div>
                        <!--/FORM GROUP street-->
                      </div>

                      <div class="form-row">
                        <!--FORM GROUP city-->
                        <div class="form-group col-md-6">
                          <label for="city">City</label>
                          <input  type="text" 
                                  name="city" 
                                  id="city" 
                                  class="form-control <?= $errors!='' && $errors->has('city') ? 'error' : '';?>"
                                  placeholder = "Enter City"
                                  value="<?=$old != '' && isset($old['city']) ?$old['city']: '';?>"/>
                          <?php
                            if($errors!="" && $errors->has('city'))
                            {
                              echo "<span class='error'>{$errors->first('city')}</span>";
                            }
                          ?>
                        </div>
                        <!--/FORM GROUP city-->

                        <!--FORM GROUP pincode-->
                        <div class="form-group col-md-6">
                          <label for="pincode">Pincode</label>
                          <input  type="text" 
                                  name="pincode" 
                                  id="pincode" 
                                  class="form-control <?= $errors!='' && $errors->has('pincode') ? 'error' : '';?>"
                                  placeholder = "Enter Pincode"
                                  value="<?=$old != '' && isset($old['pincode']) ?$old['pincode']: '';?>"/>
                          
                          <?php
                            if($errors!="" && $errors->has('pincode'))
                            {
                              echo "<span class='error'>{$errors->first('pincode')}</span>";
                            }
                          ?>
                        </div>
                        <!--/FORM GROUP pincode-->
                      </div>

                      <div class="form-row">
                        <!--FORM GROUP state-->
                        <div class="form-group col-md-6">
                          <label for="state">State</label>
                          <input  type="text" 
                                  name="state" 
                                  id="state" 
                                  class="form-control <?= $errors!='' && $errors->has('state') ? 'error' : '';?>"
                                  placeholder = "Enter State"
                                  value="<?=$old != '' && isset($old['state']) ?$old['state']: '';?>"/>
                          <?php
                            if($errors!="" && $errors->has('state'))
                            {
                              echo "<span class='error'>{$errors->first('state')}</span>";
                            }
                          ?>
                        </div>
                        <!--/FORM GROUP state-->

                        <!--FORM GROUP country-->
                        <div class="form-group col-md-6">
                          <label for="country">Country</label>
                          <input  type="text" 
                                  name="country" 
                                  id="country" 
                                  class="form-control <?= $errors!='' && $errors->has('country') ? 'error' : '';?>"
                                  placeholder = "Enter Country"
                                  value="<?=$old != '' && isset($old['country']) ?$old['country']: '';?>"/>
                          
                          <?php
                            if($errors!="" && $errors->has('country'))
                            {
                              echo "<span class='error'>{$errors->first('country')}</span>";
                            }
                          ?>
                        </div>
                        <!--/FORM GROUP country-->
                      </div>

                      <div class="form-row">
                        <!--FORM GROUP town-->
                        <div class="form-group col-md-6">
                          <label for="town">Town</label>
                          <input  type="text" 
                                  name="town" 
                                  id="town" 
                                  class="form-control <?= $errors!='' && $errors->has('town') ? 'error' : '';?>"
                                  placeholder = "Enter Town"
                                  value="<?=$old != '' && isset($old['town']) ?$old['town']: '';?>"/>
                          <?php
                            if($errors!="" && $errors->has('town'))
                            {
                              echo "<span class='error'>{$errors->first('town')}</span>";
                            }
                          ?>
                        </div>
                        <!--/FORM GROUP town-->
                      </div>


                      <button type="submit" class="btn btn-primary" name="add_customer" value="addCustomer"><i class="fa fa-check"></i> Submit</button>
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
  <?php require_once(__DIR__ . "/../includes/page-level/customer/add-customer-scripts.php");?>
</body>

</html>