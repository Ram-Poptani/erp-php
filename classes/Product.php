<?php

require_once __DIR__."/../helper/requirements.php";

class Product {
    private $table = "products";
    private $database;
    protected $di;
    
    public function __construct(DependencyInjector $di) {
        $this->di = $di;
        $this->database = $this->di->get('database');
    }
    
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
    /**
     * This function is responsible to accept the data from the Routing and add it to the Database.
     */
    public function addProduct($data) {
        // Util::dd( $data );
        $validation = $this->validateData($data);
        // Util::dd( !$validation->fails() );
        if( !$validation->fails() ) 
        {
            //Validation was successful
            // Util::dd( "Validation was successful" );
            try
            {
                // Util::dd(["product", $data]);
                //Begin Transaction
                $this->database->beginTransaction();

                // $category_id = $this->database->readData('category', ['id'], "`category`.name LIKE ". $data['category']); 
                $category_id = $this->di->get('category')->getIdByCategory( $data['category'] );
                // Util::dd( $category_id );

                $product_data = [
                    'name' => $data['name'],
                    'specification' => $data['specification'],
                    'hsn_code' => $data['hsn_code'],
                    'category_id' => $category_id,
                    'eoq_level' => $data['eoq_level'],
                    'danger_level' => $data['danger_level'],
                    'quantity' => $data['quantity'],
                ];
                $product_id = $this->database->insert($this->table, $product_data);
                // Util::dd( $product_id );
                $product_selling_rate = [
                    'selling_rate' => $data['selling_rate'],
                    'product_id' => $product_id
                ];
                $this->database->insert('products_selling_rate', $product_selling_rate);

                // Util::dd($product_data);


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
        
        $columns = ["name", "specification", "category", "selling_rate", "quantity", "eoq_level", "danger_level"];

        $totalRowCountQuery = "SELECT COUNT(id) as total_count FROM {$this->table} WHERE deleted = 0";

        // Util::dd($totalRowCountQuery);

        $filteredRowCountQuery = "SELECT COUNT(`{$this->table}`.id) AS filtered_total_count FROM `{$this->table}`, `category` WHERE `{$this->table}`.category_id = `category`.id  AND  `{$this->table}`.deleted = 0";

        // Util::dd($filteredRowCountQuery);

        $query = "
            SELECT 
                `{$this->table}`.id, 
                `{$this->table}`.name, 
                `{$this->table}`.specification, 
                `{$this->table}`.quantity,  
                `{$this->table}`.danger_level,  
                `{$this->table}`.eoq_level, 
                `category`.name AS 'category_name', 
                `products_selling_rate`.selling_rate
            FROM 
                `{$this->table}`, `category`, `products_selling_rate` 
            WHERE 
                `{$this->table}`.category_id = `category`.id 
                    AND 
                    `products_selling_rate`.product_id = `{$this->table}`.id 
                    AND 
                `{$this->table}`.deleted = 0 
                    AND
                `category`.deleted = 0";
        
        // Util::dd($query);

        if($searchParameter != null){

            $query .= " AND CONCAT(
                
                `{$this->table}`.name, 
                `{$this->table}`.specification, 
                `category`.id 

                ) LIKE '%$searchParameter%'";
                
            $filteredRowCountQuery .= " AND CONCAT(
                
                `{$this->table}`.name, 
                `{$this->table}`.specification, 
                `category`.id 
                                
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
            $subarray[] = $filteredData[$i]->name;
            $subarray[] = $filteredData[$i]->specification;
            $subarray[] = $filteredData[$i]->category_name;
            $subarray[] = $filteredData[$i]->selling_rate;
            $subarray[] = $filteredData[$i]->quantity;
            $subarray[] = $filteredData[$i]->eoq_level;
            $subarray[] = $filteredData[$i]->danger_level;
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


    public function getProductWithCategory($id, $readMode = PDO::FETCH_OBJ) {

        $query = "
            SELECT 
                `{$this->table}`.id, 
                `{$this->table}`.name, 
                `{$this->table}`.specification, 
                `{$this->table}`.quantity,  
                `{$this->table}`.danger_level,  
                `{$this->table}`.eoq_level, 
                `category`.name AS 'category_name'
            FROM 
                `{$this->table}`, `category` 
            WHERE 
                `{$this->table}`.category_id = `category`.id 
                    AND 
                `{$this->table}`.deleted = 0
                    AND
                `category`.deleted = 0
                    AND
                `{this->table}`.id = $id";

        $filteredData = $this->database->raw($query, $readMode);
        
        // Util::dd($filteredData);

        echo json_encode($filteredData);
    }

    public function getProductById($productId, $mode = PDO::FETCH_OBJ) {
        $query = "SELECT * FROM {$this->table} WHERE deleted = 0 AND id = {$productId}";
        $result = $this->database->raw($query, $mode);
        return $result;
    }

    public function update($data, $id) {
        // Util::dd(["update", $data]);

        $category_id = $this->di->get('category')->getIdByCategory( $data['category'] );

        $validationData['update'] = true;
        $validationData['id'] = $data['product_id'];
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

                $product_data = [
                    'name' => $data['name'],
                    'specification' => $data['specification'],
                    'hsn_code' => $data['hsn_code'],
                    'category_id' => $category_id,
                    'eoq_level' => $data['eoq_level'],
                    'danger_level' => $data['danger_level'],
                    'quantity' => $data['quantity']
                ];

                $filteredProductData['id'] = $data['product_id'];
                $filteredProductData['name'] = $data['name'];
                $filteredProductData['specification'] = $data['specification'];
                $filteredProductData['hsn_code'] = $data['hsn_code'];
                $filteredProductData['eoq_level'] = $data['eoq_level'];
                $filteredProductData['danger_level'] = $data['danger_level'];
                $filteredProductData['quantity'] = $data['quantity'];
                $filteredProductData['category_id'] = $category_id;

                $this->database->update($this->table, $filteredProductData, "id = {$id}");
                // Util::dd($this->database->update($this->table, $filteredProductData, "id = {$id}"));
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

