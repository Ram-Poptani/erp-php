<?php

$app = __DIR__;

require_once "$app/../classes/helper_classes/Session.php";
require_once "$app/../classes/helper_classes/DependencyInjector.php";
require_once "$app/../classes/helper_classes/Config.php";
require_once "$app/../classes/helper_classes/Database.php";
require_once "$app/../classes/helper_classes/ErrorHandler.php";
require_once "$app/../classes/helper_classes/Hash.php";
require_once "$app/../classes/helper_classes/Validator.php";
require_once "$app/../classes/helper_classes/TokenHandler.php";
require_once "$app/../classes/helper_classes/Util.php";

require_once "$app/../classes/Category.php";
require_once "$app/../classes/Customer.php";
require_once "$app/../classes/Supplier.php";
require_once "$app/../classes/Employee.php";
require_once "$app/../classes/Product.php";
require_once "$app/../classes/Purchase.php";
require_once "$app/../classes/Sale.php";