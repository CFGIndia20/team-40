<?php

require_once __DIR__."/../helper/requirements.php";

class Product{
    private $table = "products";
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
            'name'=> [
                'required'=> true,
                'minlength'=> 2,
                'maxlength'=> 25
            ],
            'specification'=> [
                'required'=> true,
                'minlength'=> 2,
                'maxlength'=> 255
            ],
            'hsn_code'=> [
                'required'=> true,
                'minlength'=> 8,
                'maxlength'=> 8
            ],
            'supplier_id[]' => [
                'required' => true
            ],
            'category_id'=> [
                'required'=> true,
                'exists' => "category|id"
            ],
            'eoq_level'=> [
                'required'=> true
            ],
            'danger_level' => [
                'required' => true
            ],
            'quantity' => [
                'required' => true
            ],
            'selling_rate' => [
                'required' => true
            ]
        ]);
    }
    /**
     * This function is responsible to accept the data from the Routing and add it to the Database.
     */
    public function addProduct($data)
    {
        $validation = $this->validateData($data);
        if(!$validation->fails())
        {
            //Validation was successful
            try
            {
                $columnsOfProductTable = ["name", "specification", "hsn_code", "category_id", "eoq_level", "danger_level", "quantity"];
                $data_to_be_inserted = Util::createAssocArray($columnsOfProductTable, $data);
                //Begin Transaction
                $this->database->beginTransaction();

                $product_id = $this->database->insert($this->table, $data_to_be_inserted);

                $data_to_be_inserted = [];
                $data_to_be_inserted['product_id'] = $product_id;
                foreach($data['supplier_id'] as $supplier_id){
                    $data_to_be_inserted["supplier_id"] = $supplier_id;
                    $this->database->insert("product_supplier", $data_to_be_inserted);
                }

                $data_to_be_inserted = [];
                $data_to_be_inserted['product_id'] = $product_id;
                $data_to_be_inserted['selling_rate'] = $data['selling_rate'];

                $this->database->insert('products_selling_rate', $data_to_be_inserted);

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

    public function editProduct($data)
    {
        $validation = $this->validateData($data);
        if(!$validation->fails())
        {
            //Validation was successful
            try
            {
                $columnsOfProductTable = ["name", "specification", "hsn_code", "category_id", "eoq_level", "danger_level"];
                $data_to_be_inserted = Util::createAssocArray($columnsOfProductTable, $data);
                $product_id = $data["id"];
                //Begin Transaction
                $this->database->beginTransaction();

                $this->database->update($this->table, $data_to_be_inserted, "id={$product_id}");

                // $this->database->hardDelete("product_supplier", "product_id={$product_id}");

                $existing_suppliers = $this->database->readData('product_supplier', ["supplier_id"], "product_id={$product_id}");

                for($i = 0; $i < sizeof($existing_suppliers); $i++){
                    if(in_array($existing_suppliers[$i]->supplier_id,$data['supplier_id'])){
                        $temp1 = array_splice($data['supplier_id'], 0, array_search($existing_suppliers[$i]->supplier_id, $data['supplier_id']));
                        $temp2 = array_splice($data['supplier_id'], array_search($existing_suppliers[$i]->supplier_id, $data['supplier_id'])+1);
                        $data['supplier_id'] = $temp1 + $temp2;
                    }else{
                        $this->database->hardDelete("product_supplier", "product_id={$product_id} AND supplier_id={$existing_suppliers[$i]->supplier_id}");
                    }
                }

                $data_to_be_inserted = [];
                $data_to_be_inserted['product_id'] = $product_id;
                foreach($data['supplier_id'] as $supplier_id){
                    $data_to_be_inserted["supplier_id"] = $supplier_id;
                    $this->database->insert("product_supplier", $data_to_be_inserted);
                }


                $result = $this->database->raw("SELECT selling_rate FROM products_selling_rate WHERE with_effect_from <= CURRENT_TIMESTAMP AND product_id={$product_id} ORDER BY with_effect_from DESC");
                $old_selling_rate = $result[0]->selling_rate;

                if($old_selling_rate != $data["selling_rate"]){
                    $data_to_be_inserted = [];
                    $data_to_be_inserted['product_id'] = $product_id;
                    $data_to_be_inserted['selling_rate'] = $data['selling_rate'];

                    $this->database->insert('products_selling_rate', $data_to_be_inserted);
                }
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

    public function getJSONDataForDataTable($draw, $searchParameter, $orderBy, $start, $length){
        $columns = ["products.name", "products.specification", "products_selling_rate.selling_rate", "products_selling_rate.with_effect_from", "products.eoq_level", "products.danger_level", "category.name"];

        $query = "SELECT products.id, products.name AS product_name, products.specification, products.eoq_level, products.danger_level, category.name AS category_name, products_selling_rate.selling_rate, products_selling_rate.with_effect_from, GROUP_CONCAT(CONCAT(first_name, ' ', last_name)) AS supplier_name FROM products INNER JOIN category ON products.category_id = category.id INNER JOIN product_supplier ON products.id = product_supplier.product_id INNER JOIN suppliers ON product_supplier.supplier_id = suppliers.id INNER JOIN products_selling_rate ON products.id = products_selling_rate.product_id INNER JOIN (SELECT product_id, MAX(with_effect_from) AS wef FROM (SELECT * FROM products_selling_rate WHERE with_effect_from <= CURRENT_TIMESTAMP) AS temp GROUP BY product_id) AS max_date_table ON max_date_table.product_id = products_selling_rate.product_id AND products_selling_rate.with_effect_from = max_date_table.wef WHERE products.deleted = 0";

        $groupBy = " GROUP BY products.id";

        $totalRowCountQuery = "SELECT DISTINCT(COUNT(*) OVER()) AS total_count FROM products INNER JOIN category ON products.category_id = category.id INNER JOIN product_supplier ON products.id = product_supplier.product_id INNER JOIN suppliers ON product_supplier.supplier_id = suppliers.id INNER JOIN products_selling_rate ON products.id = products_selling_rate.product_id INNER JOIN (SELECT product_id, MAX(with_effect_from) AS wef FROM (SELECT * FROM products_selling_rate WHERE with_effect_from <= CURRENT_TIMESTAMP) AS temp GROUP BY product_id) AS max_date_table ON max_date_table.product_id = products_selling_rate.product_id AND products_selling_rate.with_effect_from = max_date_table.wef WHERE products.deleted = 0";

        $filteredRowCountQuery = $totalRowCountQuery;

        if($searchParameter != null)
        {
            $condition = " AND products.name LIKE '%{$searchParameter}%' OR specification LIKE '%{$searchParameter}%' OR category.name LIKE '%{$searchParameter}%' OR CONCAT(suppliers.first_name, ' ', suppliers.last_name) LIKE '%{$searchParameter}%'";
            $query .= $condition;
            $filteredRowCountQuery .= $condition;
        }

        $query .= $groupBy;
        $filteredRowCountQuery .= $groupBy;
        $totalRowCountQuery .= $groupBy;

        if($orderBy != null)
        {
            $query .= " ORDER BY {$columns[$orderBy[0]['column']]} {$orderBy[0]['dir']}";
        }
        else
        {
            $query .= " ORDER BY {$columns[0]} ASC";
        }

        if($length != -1)
        {
            $query .= " LIMIT {$start}, {$length}";
        }

        $totalRowCountResult = $this->database->raw($totalRowCountQuery);
        $numberOfTotalRows = is_array($totalRowCountResult) ? $totalRowCountResult[0]->total_count : 0;

        $filteredRowCountResult = $this->database->raw($filteredRowCountQuery);
        $numberOfFilteredRows = is_array($filteredRowCountResult) ? ($filteredRowCountResult[0]->total_count ?? 0) : 0;

        $filteredData = $this->database->raw($query);
        $numberOfRowsToDisplay = is_array($filteredData) ? count($filteredData) : 0;
        $data = [];

        for($i = 0; $i < $numberOfRowsToDisplay; $i++)
        {
            $basePages = BASEPAGES;
            $subarray = [];
            $subarray[] = $filteredData[$i]->product_name;
            $subarray[] = $filteredData[$i]->specification;
            $subarray[] = $filteredData[$i]->selling_rate;
            $subarray[] = $filteredData[$i]->with_effect_from;
            $subarray[] = $filteredData[$i]->eoq_level;
            $subarray[] = $filteredData[$i]->danger_level;
            $subarray[] = $filteredData[$i]->category_name;
            $subarray[] = $filteredData[$i]->supplier_name;
            $subarray[] = <<<BUTTONS
            <a href="{$basePages}view-product.php?id={$filteredData[$i]->id}" class='view btn btn-outline-success m-1'><i class='fas fa-eye'></i></a>
            <a href="{$basePages}edit-product.php?id={$filteredData[$i]->id}" class='edit btn btn-outline-primary m-1'><i class='fas fa-pencil-alt'></i></a>
            <a href="#" class='delete btn btn-outline-danger m-1' id='{$filteredData[$i]->id}' data-toggle='modal' data-target='#deleteModal'><i class='fas fa-trash'></i></a>
BUTTONS;
            $data[] = $subarray;
        }

        $output = array(
            "draw"=>$draw,
            "recordsTotal"=>$numberOfTotalRows,
            "recordsFiltered"=>$numberOfFilteredRows,
            "data"=>$data
        );

        echo json_encode($output);
    }

    public function getProductDetailsById($product_id){

        $query = "SELECT products.id, products.name AS name, products.hsn_code, products.quantity, products.specification, products.eoq_level, products.danger_level, category.id AS category_id, category.name AS category_name, products_selling_rate.selling_rate, products_selling_rate.with_effect_from, GROUP_CONCAT(suppliers.id) AS supplier_id, GROUP_CONCAT(CONCAT(first_name, ' ', last_name)) AS supplier_name FROM products INNER JOIN category ON products.category_id = category.id INNER JOIN product_supplier ON products.id = product_supplier.product_id INNER JOIN suppliers ON product_supplier.supplier_id = suppliers.id INNER JOIN products_selling_rate ON products.id = products_selling_rate.product_id INNER JOIN (SELECT product_id, MAX(with_effect_from) AS wef FROM (SELECT * FROM products_selling_rate WHERE with_effect_from <= CURRENT_TIMESTAMP) AS temp GROUP BY product_id) AS max_date_table ON max_date_table.product_id = products_selling_rate.product_id AND products_selling_rate.with_effect_from = max_date_table.wef WHERE products.deleted = 0 AND products.id = {$product_id}";

        $productDetails = $this->database->raw($query, PDO::FETCH_ASSOC);
        return $productDetails[0];
    }

    public function delete($id)
    {
        try
        {
            $this->database->beginTransaction();
            $this->database->delete($this->table, "id={$id}");
            $this->database->hardDelete("product_supplier", "product_id={$id}");
            $this->database->commit();
            return DELETE_SUCCESS;
        }catch(Exception $e){
            $this->database->rollback();
            return DELETE_ERROR;
        }
    }

    public function getProductsByCategoryID($categoryID){
        return $this->database->readData($this->table, ['id', 'name'], "category_id = {$categoryID} AND deleted = 0");
    }

    public function getSellingPriceByProductID($productID){
        $query = "SELECT t1.product_id, t1.selling_rate, t1.with_effect_from FROM products_selling_rate t1 INNER JOIN (SELECT product_id, selling_rate, MAX(with_effect_from)AS wef FROM products_selling_rate WHERE with_effect_from <= CURRENT_TIMESTAMP GROUP BY product_id HAVING product_id={$productID}) t2 ON t2.wef = t1.with_effect_from AND t1.product_id = {$productID}";
        return $this->database->raw($query)[0]->selling_rate;
    }
}