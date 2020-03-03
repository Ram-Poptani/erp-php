<?php
require_once 'init.php';

// Util::dd($_POST);

/**
 * **********************************************CATEGORY**********************************************
 */
if(isset($_POST['add_category'])) {
    // Util::dd($_POST);
    //USER HAS REQUESTED TO ADD A NEW CATEGORY
    // Util::dd(Util::verifyCSRFToken($_POST));
    if(isset($_POST['csrf_token']) && Util::verifyCSRFToken($_POST))
    {
        // $_POST["hello"] = "world";
        // Util::dd($_POST);
        $result = $di->get('category')->addCategory($_POST);

        switch($result)
        {
            case ADD_ERROR:
                // $_POST["hello1"] = "world1";
                // Util::dd($_POST);
                Session::setSession(ADD_ERROR, 'There was problem while inserting record, please try again later!');
                Util::redirect('manage-category.php');
            break;

            case ADD_SUCCESS:
                // $_POST["hello2"] = "world2";
                // Util::dd($_POST);
                Session::setSession(ADD_SUCCESS, 'The record have been added successfully!');
                // Util::dd();
                Util::redirect('manage-category.php');
            break;
            
            case VALIDATION_ERROR:
                // $_POST["hello3"] = "world3";
                // Util::dd($_POST);
                Session::setSession(VALIDATION_ERROR, 'There was some problem in validating your data at server side');
                Session::setSession('errors', serialize($di->get('validator')->errors()));
                Session::setSession('old', $_POST);
                Util::redirect('add-category.php');
            break;
        }
    }
}

if (isset($_POST['page']) && $_POST['page'] == 'manage_category') {
    // Util::dd( $di->get( "category" )->getCategoriesName() );
    $search_parameter = $_POST['search']['value'] ?? null;
    $order_by = $_POST['order'] ?? null;
    $start =  $_POST['start'];
    $length =  $_POST['length'];
    $draw =  $_POST['draw'];
    $di->get("category")->getJSONDataForDataTable($draw, $search_parameter, $order_by, $start, $length);
}

if (isset($_POST['fetch']) && $_POST['fetch'] == 'category') {
    $category_id = $_POST['category_id'];
    $result = $di->get("category")->getCategoryById($category_id, PDO::FETCH_ASSOC);
    echo json_encode($result);
}

if (isset($_POST['edit_category'])) {
    // Util::dd($_POST);
    if (isset($_POST['csrf_token']) && Util::verifyCSRFToken($_POST)) {
        
        $result = $di->get('category')->update($_POST, $_POST['category_id']);

        switch($result)
        {
            case EDIT_ERROR:
                $_POST["hello1"] = "world1";
                // Util::dd($_POST);
                Session::setSession(EDIT_ERROR, 'There was problem while editing record, please try again later!');
                Util::redirect('manage-category.php');
            break;

            case EDIT_SUCCESS:
                $_POST["hello2"] = "world2";
                // Util::dd($_POST);
                Session::setSession(EDIT_SUCCESS, 'The record have been updated successfully!');
                // Util::dd();
                Util::redirect('manage-category.php');
            break;
            
            case VALIDATION_ERROR:
                $_POST["hello3"] = "world3";
                // Util::dd($_POST);
                Session::setSession(VALIDATION_ERROR, 'There was some problem in validating your data at server side');
                Session::setSession('errors', serialize($di->get('validator')->errors()));
                Session::setSession('old', $_POST);
                Util::redirect('manage-category.php');
            break;
        }
    }
}

if (isset($_POST['delete_category'])) {
    if (isset($_POST['csrf_token']) && Util::verifyCSRFToken($_POST)) {
        
        $result = $di->get('category')->delete($_POST['record_id']);

        switch($result)
        {
            case DELETE_ERROR:
                // $_POST["hello1"] = "world1";
                // Util::dd($_POST);
                Session::setSession(DELETE_ERROR, 'There was problem while deleteing record, please try again later!');
                Util::redirect('manage-category.php');
            break;

            case DELETE_SUCCESS:
                // $_POST["hello2"] = "world2";
                // Util::dd($_POST);
                Session::setSession(DELETE_SUCCESS, 'The record have been deleted successfully!');
                // Util::dd();
                Util::redirect('manage-category.php');
            break;
        }
    }
}
/**
 * *******************************************END OF CATEGORY*******************************************
 */

/**
 * *******************************************CUSTOMER*******************************************
 */

if(isset($_POST['add_customer'])) {
    // Util::dd($_POST);
    //USER HAS REQUESTED TO ADD A NEW CATEGORY
    // Util::dd(Util::verifyCSRFToken($_POST));
    if(isset($_POST['csrf_token']) && Util::verifyCSRFToken($_POST))
    {
        // $_POST["hello"] = "world";
        // Util::dd($_POST);
        $result = $di->get('customer')->addCustomer($_POST);

        switch($result)
        {
            case ADD_ERROR:
                // $_POST["hello1"] = "world1";
                // Util::dd($_POST);
                Session::setSession(ADD_ERROR, 'There was problem while inserting record, please try again later!');
                Util::redirect('manage-customers.php');
            break;

            case ADD_SUCCESS:
                // $_POST["hello2"] = "world2";
                // Util::dd($_POST);
                Session::setSession(ADD_SUCCESS, 'The record have been added successfully!');
                // Util::dd();
                Util::redirect('manage-customers.php');
            break;
            
            case VALIDATION_ERROR:
                // $_POST["hello3"] = "world3";
                // Util::dd($_POST);
                Session::setSession(VALIDATION_ERROR, 'There was some problem in validating your data at server side');
                Session::setSession('errors', serialize($di->get('validator')->errors()));
                Session::setSession('old', $_POST);
                Util::redirect('add-customer.php');
            break;
        }
    }
}

if (isset($_POST['page']) && $_POST['page'] == 'manage_customer') {
    // Util::dd(["post" , $_POST]);
    $search_parameter = $_POST['search']['value'] ?? null;
    $order_by = $_POST['order'] ?? null;
    $start =  $_POST['start'];
    $length =  $_POST['length'];
    $draw =  $_POST['draw'];
    $di->get("customer")->getJSONDataForDataTable($draw, $search_parameter, $order_by, $start, $length);
}

if (isset($_POST['fetch']) && $_POST['fetch'] == 'customer') {
    $customer_id = $_POST['customer_id'];
    $result = $di->get("customer")->getCustomerById($customer_id, PDO::FETCH_ASSOC);
    // Util::dd(json_encode($result));
    echo json_encode($result);
}

if (isset($_GET['fetch']) && $_GET['fetch'] == 'customer_data') {
    $customer_id = $_GET['customer_id'];
    $result = $di->get("customer")->getCustomerWithAddress($customer_id, PDO::FETCH_ASSOC);
    // Util::dd(json_encode($result));
    echo $result;
}

if (isset($_POST['fetch']) && $_POST['fetch'] == 'edit_customer') {
    // Util::dd($_POST);
    $customer_id = $_POST['customer_id'];
    $result = $di->get("customer")->getCustomerWithAddress($customer_id, PDO::FETCH_ASSOC);
    // Util::dd(json_encode($result));
    // Util::redirect("edit-customer.php");
    echo $result;
}

if (isset($_POST['edit_customer'])) {
    // Util::dd($_POST);
    if (isset($_POST['csrf_token']) && Util::verifyCSRFToken($_POST)) {
        
        $result = $di->get('customer')->update($_POST, $_POST['customer_id']);
        // Util::dd($result);

        switch($result)
        {
            case EDIT_ERROR:
                $_POST["hello1"] = "world1";
                // Util::dd($_POST);
                Session::setSession(EDIT_ERROR, 'There was problem while editing record, please try again later!');
                Util::redirect('manage-customers.php');
            break;

            case EDIT_SUCCESS:
                $_POST["hello2"] = "world2";
                // Util::dd($_POST);
                Session::setSession(EDIT_SUCCESS, 'The record have been updated successfully!');
                // Util::dd();
                Util::redirect('manage-customers.php');
            break;
            
            case VALIDATION_ERROR:
                $_POST["hello3"] = "world3";
                // Util::dd($_POST);
                Session::setSession(VALIDATION_ERROR, 'There was some problem in validating your data at server side');
                Session::setSession('errors', serialize($di->get('validator')->errors()));
                Session::setSession('old', $_POST);
                Util::redirect('manage-customers.php');
            break;
        }
    }
}

if (isset($_POST['delete_customer'])) {
    if (isset($_POST['csrf_token']) && Util::verifyCSRFToken($_POST)) {
        
        $result = $di->get('customer')->delete($_POST['record_id']);

        switch($result)
        {
            case DELETE_ERROR:
                // $_POST["hello1"] = "world1";
                // Util::dd($_POST);
                Session::setSession(DELETE_ERROR, 'There was problem while deleteing record, please try again later!');
                Util::redirect('manage-customers.php');
            break;

            case DELETE_SUCCESS:
                // $_POST["hello2"] = "world2";
                // Util::dd($_POST);
                Session::setSession(DELETE_SUCCESS, 'The record have been deleted successfully!');
                // Util::dd();
                Util::redirect('manage-customers.php');
            break;
        }
    }
}

/**
 * *******************************************END OF CUSTOMER*******************************************
 */


 /**
 * *******************************************SUPPLIER*******************************************
 */

if(isset($_POST['add_supplier'])) {
    // Util::dd($_POST);
    //USER HAS REQUESTED TO ADD A NEW CATEGORY
    // Util::dd(Util::verifyCSRFToken($_POST));
    if(isset($_POST['csrf_token']) && Util::verifyCSRFToken($_POST))
    {
        // $_POST["hello"] = "world";
        // Util::dd($_POST);
        $result = $di->get('supplier')->addSupplier($_POST);

        switch($result)
        {
            case ADD_ERROR:
                // $_POST["hello1"] = "world1";
                // Util::dd($_POST);
                Session::setSession(ADD_ERROR, 'There was problem while inserting record, please try again later!');
                Util::redirect('manage-suppliers.php');
            break;

            case ADD_SUCCESS:
                // $_POST["hello2"] = "world2";
                // Util::dd($_POST);
                Session::setSession(ADD_SUCCESS, 'The record have been added successfully!');
                // Util::dd();
                Util::redirect('manage-suppliers.php');
            break;
            
            case VALIDATION_ERROR:
                // $_POST["hello3"] = "world3";
                // Util::dd($_POST);
                Session::setSession(VALIDATION_ERROR, 'There was some problem in validating your data at server side');
                Session::setSession('errors', serialize($di->get('validator')->errors()));
                Session::setSession('old', $_POST);
                Util::redirect('add-supplier.php');
            break;
        }
    }
}

if (isset($_POST['page']) && $_POST['page'] == 'manage_supplier') {
    // Util::dd(["post" , $_POST]);
    $search_parameter = $_POST['search']['value'] ?? null;
    $order_by = $_POST['order'] ?? null;
    $start =  $_POST['start'];
    $length =  $_POST['length'];
    $draw =  $_POST['draw'];
    $di->get("supplier")->getJSONDataForDataTable($draw, $search_parameter, $order_by, $start, $length);
}

if (isset($_POST['fetch']) && $_POST['fetch'] == 'supplier') {
    $supplier_id = $_POST['supplier_id'];
    $result = $di->get("supplier")->getSupplierById($supplier_id, PDO::FETCH_ASSOC);
    // Util::dd(json_encode($result));
    echo json_encode($result);
}

if (isset($_GET['fetch']) && $_GET['fetch'] == 'supplier_data') {
    $supplier_id = $_GET['supplier_id'];
    $result = $di->get("supplier")->getSupplierWithAddress($supplier_id, PDO::FETCH_ASSOC);
    // Util::dd(json_encode($result));
    echo $result;
}

if (isset($_POST['fetch']) && $_POST['fetch'] == 'edit_supplier') {

    // Util::dd([$_POST]);
    $supplier_id = $_POST['supplier_id'];
    $result = $di->get("supplier")->getSupplierWithAddress($supplier_id, PDO::FETCH_ASSOC);
    // Util::dd( json_encode( $result ) );
    // Util::redirect("edit-supplier.php");
    // echo json_encode( $result );
    echo $result;
}

if (isset($_POST['edit_supplier'])) {
    // Util::dd($_POST);
    if (isset($_POST['csrf_token']) && Util::verifyCSRFToken($_POST)) {
        
        $result = $di->get('supplier')->update($_POST, $_POST['supplier_id']);
        // Util::dd($result);

        switch($result)
        {
            case EDIT_ERROR:
                // $_POST["hello1"] = "world1";
                // Util::dd($_POST);
                Session::setSession(EDIT_ERROR, 'There was problem while editing record, please try again later!');
                Util::redirect('manage-suppliers.php');
            break;

            case EDIT_SUCCESS:
                // $_POST["hello2"] = "world2";
                // Util::dd($_POST);
                Session::setSession(EDIT_SUCCESS, 'The record have been updated successfully!');
                // Util::dd();
                Util::redirect('manage-suppliers.php');
            break;
            
            case VALIDATION_ERROR:
                $_POST["hello3"] = "world3";
                // Util::dd($_POST);
                Session::setSession(VALIDATION_ERROR, 'There was some problem in validating your data at server side');
                Session::setSession('errors', serialize($di->get('validator')->errors()));
                Session::setSession('old', $_POST);
                Util::redirect('manage-suppliers.php');
            break;
        }
    }
}

if (isset($_POST['delete_supplier'])) {
    // Util::dd([
    //     "csrf" => Session::getSession("csrf_token"),
    //     $_POST
    //     ]);

    if (isset($_POST['csrf_token']) && Util::verifyCSRFToken($_POST)) {
        // Util::dd("hello");
        // Util::dd($_POST);
        $result = $di->get('supplier')->delete($_POST['record_id']);
        // Util::dd($result);

        switch($result)
        {
            case DELETE_ERROR:
                // $_POST["hello1"] = "world1";
                // Util::dd($_POST);
                Session::setSession(DELETE_ERROR, 'There was problem while deleteing record, please try again later!');
                Util::redirect('manage-suppliers.php');
            break;

            case DELETE_SUCCESS:
                // $_POST["hello2"] = "world2";
                // Util::dd($_POST);
                Session::setSession(DELETE_SUCCESS, 'The record have been deleted successfully!');
                // Util::dd();
                Util::redirect('manage-suppliers.php');
            break;
        }
    }
}

/**
 * *******************************************END OF SUPPLIER*******************************************
 */


 /**
 * *******************************************EMPLOYEE*******************************************
 */

if(isset($_POST['add_employee'])) {
    // Util::dd($_POST);
    //USER HAS REQUESTED TO ADD A NEW CATEGORY
    // Util::dd(Util::verifyCSRFToken($_POST));
    if(isset($_POST['csrf_token']) && Util::verifyCSRFToken($_POST))
    {
        // $_POST["hello"] = "world";
        // Util::dd($_POST);
        $result = $di->get('employee')->addEmployee($_POST);
        // Util::dd($result);

        switch($result)
        {
            case ADD_ERROR:

                // $_POST["ADD_ERROR"] = "ADD_ERROR";
                // Util::dd($_POST);
                Session::setSession(ADD_ERROR, 'There was problem while inserting record, please try again later!');
                Util::redirect('manage-employees.php');
            break;

            case ADD_SUCCESS:
                // $_POST["ADD_SUCCESS"] = "ADD_SUCCESS";
                // Util::dd($_POST);
                Session::setSession(ADD_SUCCESS, 'The record have been added successfully!');
                // Util::dd();
                Util::redirect('manage-employees.php');
            break;
            
            case VALIDATION_ERROR:
                // $_POST["VALIDATION_ERROR"] = "VALIDATION_ERROR";
                // Util::dd($_POST);
                Session::setSession(VALIDATION_ERROR, 'There was some problem in validating your data at server side');
                Session::setSession('errors', serialize($di->get('validator')->errors()));
                Session::setSession('old', $_POST);
                Util::redirect('add-employee.php');
            break;
        }
    }
}

if (isset($_POST['page']) && $_POST['page'] == 'manage_employee') {
    // Util::dd(["post" , $_POST]);
    $search_parameter = $_POST['search']['value'] ?? null;
    $order_by = $_POST['order'] ?? null;
    $start =  $_POST['start'];
    $length =  $_POST['length'];
    $draw =  $_POST['draw'];
    $di->get("employee")->getJSONDataForDataTable($draw, $search_parameter, $order_by, $start, $length);
}

if (isset($_POST['delete_employee'])) {
    // Util::dd([
    //     "csrf" => Session::getSession("csrf_token"),
    //     $_POST
    //     ]);

    if (isset($_POST['csrf_token']) && Util::verifyCSRFToken($_POST)) {
        // Util::dd("hello1");
        // Util::dd($_POST);
        $result = $di->get('employee')->delete($_POST['record_id']);
        // Util::dd($result);

        switch($result)
        {
            case DELETE_ERROR:
                $_POST["DELETE_ERROR"] = "DELETE_ERROR";
                // Util::dd($_POST);
                Session::setSession(DELETE_ERROR, 'There was problem while deleteing record, please try again later!');
                Util::redirect('manage-employees.php');
            break;

            case DELETE_SUCCESS:
                $_POST["DELETE_SUCCESS"] = "DELETE_SUCCESS";
                // Util::dd($_POST);
                Session::setSession(DELETE_SUCCESS, 'The record have been deleted successfully!');
                // Util::dd();
                Util::redirect('manage-employees.php');
            break;
        }
    }
}
/**
 * *******************************************END OF EMPLOYEE*******************************************
 */

 /**
 * *******************************************PRODUCT*******************************************
 */

if ( isset( $_POST['fetch'] ) && $_POST['fetch'] == "categories_for_product" ) {
    // Util::dd( "hello" );
    echo json_encode( $di->get('category')->getCategoriesName() );
}

if(isset($_POST['add_product'])) {
    // Util::dd($_POST);
    // USER HAS REQUESTED TO ADD A NEW PRODUCT
    // Util::dd(Util::verifyCSRFToken($_POST));
    if(isset($_POST['csrf_token']) && Util::verifyCSRFToken($_POST))
    {
        // $_POST["hello"] = "world";
        // Util::dd($_POST);
        $result = $di->get('product')->addProduct($_POST);
        // Util::dd($result);

        switch($result)
        {
            case ADD_ERROR:

                // $_POST["ADD_ERROR"] = "ADD_ERROR";
                // Util::dd($_POST);
                Session::setSession(ADD_ERROR, 'There was problem while inserting record, please try again later!');
                Util::redirect('manage-products.php');
            break;

            case ADD_SUCCESS:
                // $_POST["ADD_SUCCESS"] = "ADD_SUCCESS";
                // Util::dd($_POST);
                Session::setSession(ADD_SUCCESS, 'The record have been added successfully!');
                // Util::dd();
                Util::redirect('manage-products.php');
            break;
            
            case VALIDATION_ERROR:
                // $_POST["VALIDATION_ERROR"] = "VALIDATION_ERROR";
                // Util::dd($_POST);
                Session::setSession(VALIDATION_ERROR, 'There was some problem in validating your data at server side');
                Session::setSession('errors', serialize($di->get('validator')->errors()));
                Session::setSession('old', $_POST);
                Util::redirect('add-product.php');
            break;
        }
    }
}

if (isset($_POST['page']) && $_POST['page'] == 'manage_product') {
    // Util::dd(["post" , $_POST]);
    $search_parameter = $_POST['search']['value'] ?? null;
    $order_by = $_POST['order'] ?? null;
    $start =  $_POST['start'];
    $length =  $_POST['length'];
    $draw =  $_POST['draw'];
    $di->get("product")->getJSONDataForDataTable($draw, $search_parameter, $order_by, $start, $length);
}

if (isset($_POST['delete_product'])) {
    // Util::dd([
    //     "csrf" => Session::getSession("csrf_token"),
    //     $_POST
    //     ]);

    if (isset($_POST['csrf_token']) && Util::verifyCSRFToken($_POST)) {
        // Util::dd("hello1");
        // Util::dd($_POST);
        $result = $di->get('product')->delete($_POST['record_id']);
        // Util::dd($result);

        switch($result)
        {
            case DELETE_ERROR:
                $_POST["DELETE_ERROR"] = "DELETE_ERROR";
                // Util::dd($_POST);
                Session::setSession(DELETE_ERROR, 'There was problem while deleteing record, please try again later!');
                Util::redirect('manage-products.php');
            break;

            case DELETE_SUCCESS:
                $_POST["DELETE_SUCCESS"] = "DELETE_SUCCESS";
                // Util::dd($_POST);
                Session::setSession(DELETE_SUCCESS, 'The record have been deleted successfully!');
                // Util::dd();
                Util::redirect('manage-products.php');
            break;
        }
    }
}