<?php

require_once __DIR__."/../helper/requirements.php";

class Category{
    private $table = "category";
    private $database;
    protected $di;
    
    public function __construct(DependencyInjector $di)
    {
        $this->di = $di;
        $this->database = $this->di->get('database');
    }
    
    private function validateData($data)
    {
        $validator = $this->di->get('validator');
        return $validator->check($data, [
            'name' => [
                'required' => true,
                'minlength' => 2,
                'maxlength' => 255,
                'unique' => $this->table
            ]
        ]);
    }
    /**
     * This function is responsible to accept the data from the Routing and add it to the Database.
     */
    public function addCategory($data)
    {
        $validation = $this->validateData($data);
        if(!$validation->fails())
        {
            //Validation was successful
            try
            {
                // Util::dd($data);
                //Begin Transaction
                $this->database->beginTransaction();
                $data_to_be_inserted = ['name' => $data['name']];
                $category_id = $this->database->insert($this->table, $data_to_be_inserted);
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

    public function getJSONDataForDataTable($draw, $searchParameter, $orderBy, $start, $length){
        $columns = ["sr_no", "name"];
        $totalRowCountQuery = "SELECT COUNT(id) as total_count FROM {$this->table} WHERE deleted = 0";
        $filteredRowCountQuery = "SELECT COUNT(id) as filtered_total_count FROM {$this->table} WHERE deleted = 0";
        $query = "SELECT * FROM {$this->table} WHERE deleted = 0";

        if($searchParameter != null){
            $query .= " AND name LIKE '%{$searchParameter}%'";
            $filteredRowCountQuery .= " AND name LIKE '%{$searchParameter}%'";
        }
        if ($orderBy != null) {
            $query .= " ORDER BY {$columns[$orderBy[0]['column']]} {$orderBy[0]['dir']}";
        }else {
            $query .= " ORDER BY {$columns[0]} ASC";
        }

        if ($length != -1) {
            $query .= " LIMIT {$start}, {$length}";
        }

        $totalRowCountResult = $this->database->raw($totalRowCountQuery);
        $numberOfTotalRows = is_array($totalRowCountResult) ? $totalRowCountResult[0]->total_count : 0;

        $filteredRowCountResult = $this->database->raw($filteredRowCountQuery);
        $numberOfFilteredRows = is_array($filteredRowCountResult) ? $filteredRowCountResult[0]->filtered_total_count : 0;

        $filteredData = $this->database->raw($query);
        $numberOfRowsToDisplay = is_array($filteredData) ? count($filteredData) : 0;
        $data = [];
        for ($i=0; $i < $numberOfRowsToDisplay; $i++) { 
            $subarray = [];
            $subarray[] = $i + 1;
            $subarray[] = $filteredData[$i]->name;
            $subarray[] = 
            <<<BUTTONS
            <div class= "d-flex">
                <button class="edit btn btn-outline-primary" id="{$filteredData[$i]->id}" data-toggle = "modal" data-target = "#editModal">
                    <i class="fas fa-pencil-alt"></i>
                </button>
                <button class="delete btn btn-outline-danger" id="{$filteredData[$i]->id}" data-toggle = "modal" data-target = "#deleteModal">
                    <i class="fas fa-trash"></i>
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

    public function getCategoryById($categoryId, $mode = PDO::FETCH_OBJ){
        $query = "SELECT * FROM {$this->table} WHERE deleted = 0 AND id = {$categoryId}";
        $result = $this->database->raw($query, $mode);
        return $result;
    }

    public function getIdByCategory($categoryName, $mode = PDO::FETCH_OBJ){
        $categoryName = strtolower( $categoryName );
        $query = "SELECT * FROM {$this->table} WHERE deleted = 0 AND name LIKE '%{$categoryName}%'";
        // Util::dd( $query );
        $result = $this->database->raw($query, $mode);
        return $result[0]->id;
    }

    public function getCategoriesName($mode = PDO::FETCH_OBJ){
        $query = "SELECT `{$this->table}`.name FROM {$this->table} WHERE deleted = 0 ";
        $result = $this->database->raw($query, $mode);
        return $result;
    }

    public function update($data, $id){
        $validationData['name'] = $data['category_name'];
        $validation = $this->validateData($validationData);
        if(!$validation->fails())
        {
            //Validation was successful
            try
            {
                //Begin Transaction
                $this->database->beginTransaction();
                $filteredData['name'] = $data['category_name'];
                $this->database->update($this->table, $filteredData, "id = {$id}");
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

    public function delete($id){
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