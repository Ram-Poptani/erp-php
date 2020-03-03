<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?=BASEPAGES;?>index.php">
  <div class="sidebar-brand-icon rotate-n-15">
    <i class="fas fa-laugh-wink"></i>
  </div>
  <div class="sidebar-brand-text mx-3">Easy ERP</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item <?= $sidebarSection == 'category' ? 'active' : '';?>">
  <a class="nav-link" href="index.php">
    <i class="fas fa-fw fa-tachometer-alt"></i>
    <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
  MODULES 
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item <?= $sidebarSection == 'category' ? 'active' : '';?>">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategory" aria-expanded="true" aria-controls="collapseCategory">
    <i class="fas fa-fw fa-cog"></i>
    <span>Categories</span>
  </a>
  <div id="collapseCategory" class="collapse <?= $sidebarSection == 'category' ? 'show' : '';?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <a class="collapse-item <?= $sidebarSubSection == 'manage' ? 'active' : '';?>" href="<?= BASEPAGES;?>manage-category.php">Manage Category</a>
      <a class="collapse-item <?= $sidebarSubSection == 'add' ? 'active' : '';?>" href="<?= BASEPAGES;?>add-category.php">Add Category</a>
    </div>
  </div>
</li>


<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item <?= $sidebarSection == 'customer' ? 'active' : '';?>">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCustomer" aria-expanded="true" aria-controls="collapseCustomer">
    <i class="fas fa-fw fa-cog"></i>
    <span>Customers</span>
  </a>
  <div id="collapseCustomer" class="collapse <?= $sidebarSection == 'customer' ? 'show' : '';?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <a class="collapse-item <?= $sidebarSubSection == 'manage' ? 'active' : '';?>"  href="<?= BASEPAGES;?>manage-customers.php">Manage Customers</a>
      <a class="collapse-item <?= $sidebarSubSection == 'add' ? 'active' : '';?>" href="<?= BASEPAGES;?>add-customer.php">Add Customer</a>
    </div>
  </div>
</li>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item <?= $sidebarSection == 'employee' ? 'active' : '';?>">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEmployee" aria-expanded="true" aria-controls="collapseEmployee">
    <i class="fas fa-fw fa-cog"></i>
    <span>Employees</span>
  </a>
  <div id="collapseEmployee" class="collapse <?= $sidebarSection == 'employee' ? 'show' : '';?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <a class="collapse-item <?= $sidebarSubSection == 'manage' ? 'active' : '';?>"  href="<?= BASEPAGES;?>manage-employees.php">Manage Employees</a>
      <a class="collapse-item <?= $sidebarSubSection == 'add' ? 'active' : '';?>" href="<?= BASEPAGES;?>add-employee.php">Add Employee</a>
    </div>
  </div>
</li>


<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item <?= $sidebarSection == 'products' ? 'active' : '';?>">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProduct" aria-expanded="true" aria-controls="collapseProduct">
    <i class="fas fa-fw fa-cog"></i>
    <span>Products</span>
  </a>
  <div id="collapseProduct" class="collapse <?= $sidebarSection == 'products' ? 'show' : '';?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <a class="collapse-item <?= $sidebarSubSection == 'manage' ? 'active' : '';?>"  href="<?=BASEPAGES;?>manage-products.php">Manage Products</a>
      <a class="collapse-item"  href="<?=BASEPAGES;?>check-current-inventory.php">Check Current Inventory</a>
      <a class="collapse-item <?= $sidebarSubSection == 'add' ? 'active' : '';?>" href="<?=BASEPAGES;?>add-product.php">Add Product</a>
    </div>
  </div>
</li>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item <?= $sidebarSection == 'supplier' ? 'active' : '';?>">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSupplier" aria-expanded="true" aria-controls="collapseSupplier">
    <i class="fas fa-fw fa-cog"></i>
    <span>Suppliers</span>
  </a>
  <div id="collapseSupplier" class="collapse <?= $sidebarSection == 'supplier' ? 'show' : '';?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <a class="collapse-item <?= $sidebarSubSection == 'manage' ? 'active' : '';?>"  href="<?=BASEPAGES;?>manage-suppliers.php">Manage Suppliers</a>
      <a class="collapse-item <?= $sidebarSubSection == 'add' ? 'active' : '';?>" href="<?=BASEPAGES;?>add-supplier.php">Add Supplier</a>
    </div>
  </div>
</li>



<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
  Addons
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
    <i class="fas fa-fw fa-folder"></i>
    <span>Reports</span>
  </a>
  <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <a class="collapse-item" href="#">Purchase History</a>
      <a class="collapse-item" href="#">Sales Report</a>
      <a class="collapse-item" href="#">P &amp; L statement</a>
    </div>
  </div>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
  <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->