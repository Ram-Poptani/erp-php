<?php

require_once __DIR__."/../helper/requirements.php";

class Customer {
    private $table = "customers";
    private $database;
    protected $di;
    
    public function __construct(DependencyInjector $di) {
        $this->di = $di;
        $this->database = $this->di->get('database');
    }
    
    private function validateData($data) {
        $validator = $this->di->get('validator');
        return $validator->check($data, [
            'first_name' => [
                'required' => true,
                'minlength' => 2,
                'maxlength' => 255
                
            ],

            'last_name' => [
                'required' => true,
                'minlength' => 2,
                'maxlength' => 255
                
            ],
            'gst_no' => [
                'required' => true,
                'uniqueUpdate' => $this->table
               
            ],
            'phone_no' => [
                'required' => true,
                'uniqueUpdate' => $this->table
            ],
            'email_id' => [
                'required' => true,
                'minlength' => 2,
                'maxlength' => 255,
                'uniqueUpdate' => $this->table
            ],
            'gender'=>[
                'required'=>true
            ],
            'block_no' => [
                'required' => true,
            ],
            'street' => [
                'required' => true
            ],
            'city' => [
                'required' => true
            ],
            'pincode' => [
                'required' => true
            ],
            'state' => [
                'required' => true
            ],
            'country' => [
                'required' => true
            ],
            'town' => [
                'required' => true
            ]
        ]);
    }
    /**
     * This function is responsible to accept the data from the Routing and add it to the Database.
     */
    public function addCustomer($data) {
        $validation = $this->validateData($data);
        if(!$validation->fails())
        {
            //Validation was successful
            try
            {
                // Util::dd(["customer", $data]);
                //Begin Transaction
                $this->database->beginTransaction();
                $customer_data = [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'phone_no' => $data['phone_no'],
                    'email_id' => $data['email_id'],
                    'gender' => $data['gender'],
                    'gst_no' => $data['gst_no']
                ];
                $customer_id = $this->database->insert($this->table, $customer_data);
                // Util::dd([$customer_id]);

                $address_data = [
                    'block_no' => $data['block_no'],
                    'street' => $data['street'],
                    'city' => $data['city'],
                    'pincode' => $data['pincode'],
                    'state' => $data['state'],
                    'country' => $data['country'],
                    'town' => $data['town'],
                ];
                $address_id = $this->database->insert("address", $address_data);
                // Util::dd([$address_id]);

                $this->database->insert("address_customer", [
                "address_id" => $address_id, "customer_id" => $customer_id 
                ]);
                $this->database->commit();
                return ADD_SUCCESS;
            }
            catch(Exception $e)
            {
                $this->database->rollback();
                return ADD_ERROR;
            }
        }
        else
        {
            //Validation Failed!
            return VALIDATION_ERROR;
        }
    }

    public function getJSONDataForDataTable($draw, $searchParameter, $orderBy, $start, $length) {
        
        $columns = ["full_name", "gst_no", "phone_no", "email_id", "gender", "address"];

        $totalRowCountQuery = "SELECT COUNT(id) as total_count FROM {$this->table} WHERE deleted = 0";
        $filteredRowCountQuery = "SELECT COUNT(`customers`.id) AS filtered_total_count FROM `customers`, `address`, `address_customer` WHERE `address_customer`.address_id = `address`.id AND `address_customer`.customer_id = `{$this->table}`.id AND  `{$this->table}`.deleted = 0";
        $query = "
            SELECT 
                `{$this->table}`.id, 
                CONCAT(`{$this->table}`.first_name, ' ', `{$this->table}`.last_name) AS 'full_name', 
                `{$this->table}`.gst_no, 
                `{$this->table}`.phone_no, 
                `{$this->table}`.email_id, 
                `{$this->table}`.gender, 
                CONCAT(`address`.block_no, ', ', `address`.street, ', ', `address`.town, ', ', `address`.city, ' - ', `address`.pincode) AS 'address' 
            FROM 
                `{$this->table}`, `address`, `address_customer` 
            WHERE 
                `address_customer`.address_id = `address`.id 
                    AND 
                `address_customer`.customer_id = `customers`.id 
                    AND 
                `{$this->table}`.deleted = 0
                    AND
                `address`.deleted = 0";
        
        // Util::dd($query);

        if($searchParameter != null){

            // $query .= " AND CONCAT(`{$this->table}`.first_name, `{$this->table}`.last_name, `{$this->table}`.gst_no, `{$this->table}`.phone_no, `{$this->table}`.email_id, `{$this->table}`.gender, `address`.block_no, `address`.street, `address`.town, `address`.city, ' - ', `address`.pincode) LIKE '%$searchParameter%'";

            $query .= " AND CONCAT(
                
                CONCAT(`{$this->table}`.first_name, ' ', `{$this->table}`.last_name), 
                `{$this->table}`.gst_no, 
                `{$this->table}`.phone_no, 
                `{$this->table}`.email_id, 
                `{$this->table}`.gender, 
                CONCAT(`address`.block_no, ', ', `address`.street, ', ', `address`.town, ', ', `address`.city, ' - ', `address`.pincode) 
                
                ) LIKE '%$searchParameter%'";
                

            // $filteredRowCountQuery .= " AND CONCAT(`{$this->table}`.id, `{$this->table}`.first_name, `{$this->table}`.last_name, `{$this->table}`.gst_no, `{$this->table}`.phone_no, `{$this->table}`.email_id, `{$this->table}`.gender, `address`.block_no, `address`.street, `address`.town, `address`.city, ' - ', `address`.pincode) LIKE '%$searchParameter%'";
            $filteredRowCountQuery .= " AND CONCAT(
                
                CONCAT(`{$this->table}`.first_name, ' ', `{$this->table}`.last_name), 
                `{$this->table}`.gst_no, 
                `{$this->table}`.phone_no, 
                `{$this->table}`.email_id, 
                `{$this->table}`.gender, 
                CONCAT(`address`.block_no, ', ', `address`.street, ', ', `address`.town, ', ', `address`.city, ' - ', `address`.pincode) 
                
                ) LIKE '%$searchParameter%'";
        }   
        if ($orderBy != null) {
            $query .= " ORDER BY {$columns[$orderBy[0]['column']]} {$orderBy[0]['dir']}";
        }else {
            $query .= " ORDER BY {$columns[0]} ASC";
        }

        if ($length != -1) {
            $query .= " LIMIT {$start}, {$length}";
        }
        
        // Util::dd($query);

        $totalRowCountResult = $this->database->raw($totalRowCountQuery);
        $numberOfTotalRows = is_array($totalRowCountResult) ? $totalRowCountResult[0]->total_count : 0;

        $filteredRowCountResult = $this->database->raw($filteredRowCountQuery);
        $numberOfFilteredRows = is_array($filteredRowCountResult) ? $filteredRowCountResult[0]->filtered_total_count : 0;

        $filteredData = $this->database->raw($query);
        $numberOfRowsToDisplay = is_array($filteredData) ? count($filteredData) : 0;
        $data = [];
        for ($i=0; $i < $numberOfRowsToDisplay; $i++) { 
            $subarray = [];
            $subarray[] = $filteredData[$i]->full_name;
            $subarray[] = $filteredData[$i]->gst_no;
            $subarray[] = $filteredData[$i]->phone_no;
            $subarray[] = $filteredData[$i]->email_id;
            $subarray[] = $filteredData[$i]->gender;
            $subarray[] = $filteredData[$i]->address;
            $baseurl = BASEPAGES;
            $subarray[] = 
            <<<BUTTONS
            <button class="edit btn btn-outline-primary" id="{$filteredData[$i]->id}" data-toggle = "modal" data-target = "#editModal">
                <i class="fas fa-pencil-alt"></i>
            </button>
            <button class="delete btn btn-outline-danger" id="{$filteredData[$i]->id}" data-toggle = "modal" data-target = "#deleteModal">
                <i class="fas fa-trash"></i>
            </button>
            <button class="view btn btn-outline-success" id="{$filteredData[$i]->id}" >
                <i class="fas fa-eye"></i>
            </button>
            BUTTONS;

            $data[] = $subarray;
        }

        $output = [
            "draw" => $draw,
            "recordsTotal" => $numberOfTotalRows,
            "recordsFiltered" => $numberOfFilteredRows,
            "data" => $data
        ];

        echo json_encode($output);
    }


    public function getCustomerWithAddress($id, $readMode = PDO::FETCH_OBJ) {

        $query = "
            SELECT 
                `{$this->table}`.id, 
                `{$this->table}`.first_name,
                `{$this->table}`.last_name, 
                `{$this->table}`.gst_no, 
                `{$this->table}`.phone_no, 
                `{$this->table}`.email_id, 
                `{$this->table}`.gender, 
                `address`.block_no, 
                `address`.street, 
                `address`.town, 
                `address`.city, 
                `address`.pincode,
                `address`.state,
                `address`.country
            FROM 
                `{$this->table}`, `address`, `address_customer` 
            WHERE 
                `address_customer`.address_id = `address`.id 
                    AND 
                `address_customer`.customer_id = `customers`.id 
                    AND 
                `{$this->table}`.id = $id
                    AND 
                `{$this->table}`.deleted = 0
                    AND 
                `address`.deleted = 0";

        $filteredData = $this->database->raw($query, $readMode);
        

        echo json_encode($filteredData);
    }

    public function getCustomerById($customerId, $mode = PDO::FETCH_OBJ) {
        $query = "SELECT * FROM {$this->table} WHERE deleted = 0 AND id = {$customerId}";
        $result = $this->database->raw($query, $mode);
        return $result;
    }

    public function update($data, $id) {
        // Util::dd(["update", $data]);

        $validationData['update'] = true;
        $validationData['id'] = $data['customer_id'];
        $validationData['first_name'] = $data['first_name'];
        $validationData['last_name'] = $data['last_name'];
        $validationData['phone_no'] = $data['phone_no'];
        $validationData['email_id'] = $data['email_id'];
        $validationData['gender'] = $data['gender'];
        $validationData['gst_no'] = $data['gst_no'];
        $validationData['block_no'] = $data['block_no'];
        $validationData['street'] = $data['street'];
        $validationData['city'] = $data['city'];
        $validationData['pincode'] = $data['pincode'];
        $validationData['state'] = $data['state'];
        $validationData['country'] = $data['country'];
        $validationData['town'] = $data['town'];

        $validation = $this->validateData($validationData);
        if(!$validation->fails())
        {
            //Validation was successful
            try
            {
                //Begin Transaction
                $this->database->beginTransaction();
                $filteredCustomerData['first_name'] = $data['first_name'];
                $filteredCustomerData['last_name'] = $data['last_name'];
                $filteredCustomerData['phone_no'] = $data['phone_no'];
                $filteredCustomerData['email_id'] = $data['email_id'];
                $filteredCustomerData['gender'] = $data['gender'];
                $filteredCustomerData['gst_no'] = $data['gst_no'];

                $filteredAddressData['block_no'] = $data['block_no'];
                $filteredAddressData['street'] = $data['street'];
                $filteredAddressData['city'] = $data['city'];
                $filteredAddressData['pincode'] = $data['pincode'];
                $filteredAddressData['state'] = $data['state'];
                $filteredAddressData['country'] = $data['country'];
                $filteredAddressData['town'] = $data['town'];

                // util::dd([$filteredCustomerData, $filteredAddressData]);
                $address_id = $this->database->raw("
                    SELECT address_id FROM `address_customer`
                    WHERE `customer_id` = {$id}
                ", PDO::FETCH_ASSOC);
                // Util::dd( $address_id[0]["address_id"] );
                $address_id = $address_id[0]["address_id"];
                $this->database->update($this->table, $filteredCustomerData, "id = {$id}");
                $this->database->update('address', $filteredAddressData, "id = {$address_id}");
                // Util::dd($this->database->update($this->table, $filteredCustomerData, "id = {$id}"));
                $this->database->commit();
                return EDIT_SUCCESS;
            }
            catch(Exception $e)
            {
                $this->database->rollback();
                return EDIT_ERROR;
            }
        }
        else
        {
            //Validation Failed!
            return VALIDATION_ERROR;
        }
    }

    public function delete($id) {
        try{
            $this->database->beginTransaction();
            $this->database->delete($this->table, "id={$id}");
            $this->database->delete("address", 
                "id = {$this->database->readData("address_customer", ["address_id"], "customer_id = {$id}")[0]->address_id}"
            );
            $this->database->commit();
            return DELETE_SUCCESS;
        }catch(Exception $e){
            $this->database->rollback();
            return DELETE_ERROR;
        }
    }
}

