<?php

require_once __DIR__."/../helper/requirements.php";

class Sale {
    private $table = "sales";
    private $database;
    protected $di;
    
    public function __construct(DependencyInjector $di) {
        $this->di = $di;
        $this->database = $this->di->get('database');
    }
    /*
    private function validateData($data) {
        $validator = $this->di->get('validator');
        return $validator->check($data, [
            'name' => [
                'required' => true,
                'minlength' => 2,
                'maxlength' => 255

            ],
            'specification' => [
                'required' => true,
                'minlength' => 20,
                'maxlength' => 255

            ],
            'hsn_code' => [
                'required' => true
            ],
            'category' =>[
                'required' => true
            ],
            'eoq_level' => [
                'required' => true,
            ],
            'danger_level' => [
                'required' => true
            ],
            'quantity' => [
                'required' => true
            ]
        ]);
    }
    */
    /**
     * 
     */
    /*
            This function is responsible to accept the data from the Routing and add it to the Database.
    public function addSale($data) {
        // Util::dd( $data );
        $validation = $this->validateData($data);
        // Util::dd( !$validation->fails() );
        if( !$validation->fails() ) 
        {
            //Validation was successful
            // Util::dd( "Validation was successful" );
            try
            {
                // Util::dd(["purchase", $data]);
                //Begin Transaction
                $this->database->beginTransaction();

                // $category_id = $this->database->readData('category', ['id'], "`category`.name LIKE ". $data['category']); 
                $category_id = $this->di->get('category')->getIdByCategory( $data['category'] );
                // Util::dd( $category_id );

                $purchase_data = [
                    'name' => $data['name'],
                    'specification' => $data['specification'],
                    'hsn_code' => $data['hsn_code'],
                    'category_id' => $category_id,
                    'eoq_level' => $data['eoq_level'],
                    'danger_level' => $data['danger_level'],
                    'quantity' => $data['quantity'],
                ];
                $purchase_id = $this->database->insert($this->table, $purchase_data);
                // Util::dd( $purchase_id );
                $purchase_selling_rate = [
                    'selling_rate' => $data['selling_rate'],
                    'purchase_id' => $purchase_id
                ];
                $this->database->insert('sales_selling_rate', $purchase_selling_rate);

                // Util::dd($purchase_data);


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
    */

    public function getJSONDataForDataTable($draw, $searchParameter, $orderBy, $start, $length) {
        
        $columns = ["product_name", "quantity", "discount", "sold_on", "sold_to"];

        $totalRowCountQuery = "SELECT COUNT(id) as total_count FROM {$this->table} WHERE deleted = 0";

        // Util::dd($totalRowCountQuery);

        $filteredRowCountQuery = "
            SELECT 
                COUNT(`{$this->table}`.id) AS filtered_total_count 
            FROM 
                `{$this->table}`, `products`, `invoice`, `customers` 
            WHERE 
                `{$this->table}`.product_id = `products`.id 
                    AND 
                `{$this->table}`.invoice_id = `invoice`.id  
                    AND 
                `invoice`.customer_id = `customers`.id  
                    AND  
                `{$this->table}`.deleted = 0
                    AND  
                `products`.deleted = 0
                    AND  
                `invoice`.deleted = 0
                    AND  
                `customers`.deleted = 0";

        // Util::dd($filteredRowCountQuery);

        $query = "
            SELECT 
                `{$this->table}`.id, 
                `products`.name AS product_name, 
                `{$this->table}`.discount,  
                `{$this->table}`.quantity,  
                DATE_FORMAT(`{$this->table}`.created_at, '%d %b %Y') AS sold_on, 
                CONCAT(`customers`.first_name, ' ', `customers`.last_name) AS sold_to
            FROM 
                `{$this->table}`, `products`, `invoice`, `customers` 
            WHERE 
                `{$this->table}`.product_id = `products`.id 
                    AND 
                `{$this->table}`.invoice_id = `invoice`.id  
                    AND 
                `invoice`.customer_id = `customers`.id  
                    AND  
                `{$this->table}`.deleted = 0
                    AND  
                `products`.deleted = 0
                    AND  
                `invoice`.deleted = 0
                    AND  
                `customers`.deleted = 0";
        
        // Util::dd($query);

        if($searchParameter != null){

            $query .= " AND CONCAT(
                
                `products`.name, 
                CONCAT(`customers`.first_name, ' ', `customers`.last_name), 
                `{$this->table}`.created_at 

                ) LIKE '%$searchParameter%'";
                
            $filteredRowCountQuery .= " AND CONCAT(
                
                `products`.name,
                CONCAT(`customers`.first_name, ' ', `customers`.last_name), 
                `{$this->table}`.created_at 

                ) LIKE '%$searchParameter%'";
        }   
        if ($orderBy != null) {
            $query .= " ORDER BY {$columns[$orderBy[0]['column']]} {$orderBy[0]['dir']}";
        }else {
            $query .= " ORDER BY {$columns[3]} ASC";
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
        // Util::dd( $filteredData );
        $numberOfRowsToDisplay = is_array($filteredData) ? count($filteredData) : 0;
        $data = [];
        for ($i=0; $i < $numberOfRowsToDisplay; $i++) { 
            $subarray = [];
            $subarray[] = $filteredData[$i]->product_name;
            $subarray[] = $filteredData[$i]->quantity;
            $subarray[] = $filteredData[$i]->discount;
            $subarray[] = $filteredData[$i]->sold_on;
            $subarray[] = $filteredData[$i]->sold_to;
            $baseurl = BASEPAGES;
            $subarray[] = 
            <<<BUTTONS
            <div>
                <button class="view btn btn-outline-primary" id="{$filteredData[$i]->id}">
                    <i class="fas fa-eye"></i>
                </button>
            <div>
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



    public function getJSONDataForChart( $lowestQuantity = true, $sections = 5 ) {

        $sort = $lowestQuantity ? "ASC " : "DESC ";

        $query = "
            SELECT 
                `{$this->table}`.id, 
                `{$this->table}`.name, 
                `{$this->table}`.quantity 
            FROM 
                `{$this->table}` 
            WHERE 
                `{$this->table}`.deleted = 0 
            ORDER BY 
                `{$this->table}`.quantity " . $sort . "
            LIMIT
                0, $sections
            ";

        // Util::dd( $query );

        $filteredData = $this->database->raw($query);

        // Util::dd( $filteredData );

        return $filteredData;
    }


    public function getSaleById($saleId, $mode = PDO::FETCH_OBJ) {
        $query = "SELECT * FROM {$this->table} WHERE deleted = 0 AND id = {$saleId}";
        $result = $this->database->raw($query, $mode);
        return $result;
    }

    public function update($data, $id) {
        // Util::dd(["update", $data]);

        $category_id = $this->di->get('category')->getIdByCategory( $data['category'] );

        $validationData['update'] = true;
        $validationData['id'] = $data['purchase_id'];
        $validationData['name'] = $data['name'];
        $validationData['specification'] = $data['specification'];
        $validationData['hsn_code'] = $data['hsn_code'];
        $validationData['category_name'] = $data['category_name'];
        $validationData['eoq_level'] = $data['eoq_level'];
        $validationData['danger_level'] = $data['danger_level'];
        $validationData['quantity'] = $data['quantity'];

        $validation = $this->validateData($validationData);
        if(!$validation->fails())
        {
            //Validation was successful
            try
            {
                //Begin Transaction
                $this->database->beginTransaction();

                $purchase_data = [
                    'name' => $data['name'],
                    'specification' => $data['specification'],
                    'hsn_code' => $data['hsn_code'],
                    'category_id' => $category_id,
                    'eoq_level' => $data['eoq_level'],
                    'danger_level' => $data['danger_level'],
                    'quantity' => $data['quantity']
                ];

                $filteredSaleData['id'] = $data['purchase_id'];
                $filteredSaleData['name'] = $data['name'];
                $filteredSaleData['specification'] = $data['specification'];
                $filteredSaleData['hsn_code'] = $data['hsn_code'];
                $filteredSaleData['eoq_level'] = $data['eoq_level'];
                $filteredSaleData['danger_level'] = $data['danger_level'];
                $filteredSaleData['quantity'] = $data['quantity'];
                $filteredSaleData['category_id'] = $category_id;

                $this->database->update($this->table, $filteredSaleData, "id = {$id}");
                // Util::dd($this->database->update($this->table, $filteredSaleData, "id = {$id}"));
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
            $this->database->commit();
            return DELETE_SUCCESS;
        }catch(Exception $e){
            $this->database->rollback();
            return DELETE_ERROR;
        }
    }
}

