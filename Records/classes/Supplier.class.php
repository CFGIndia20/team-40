<?php

require_once __DIR__."/../helper/requirements.php";

class Supplier{
    private $table ="suppliers";
    private $database;
    private $address;
    protected $di;

    public function __construct(DependencyInjector $di)
    {
        $this->di = $di;
        $this->database = $this->di->get('database');
        $this->address = new Address($this->di);
    }

    private function validateData($data, $flag)
    {
        $validator = $this->di->get('validator');
        $rules = [
            'first_name'=> [
                'required'=> true,
                'minlength'=> 2,
                'maxlength'=> 25
            ],
            'last_name'=> [
                'required'=> true,
                'minlength'=> 2,
                'maxlength'=> 25
            ],
            'gst_no'=> [
                'minlength'=> 15,
                'maxlength'=> 15,
            ],
            'phone_no'=> [
                'required'=> true,
                'minlength'=> 10,
                'maxlength'=> 25
            ],
            'email_id'=> [
                'required'=> true,
                'email'=> true,
                'maxlength'=> 40
            ],
            'company_name'=> [
                'required'=> true,
                'minlength' => 2,
                'maxlength' => 25
            ]
        ];
        if($flag === 1){
            $rules['gst_no']['unique'] = $this->table;
            $rules['email_id']['unique'] = $this->table;
        }else if($flag === 2){
            $rules['gst_no']['unique_for_update'] = $this->table."#".$data["id"];
            $rules['email_id']['unique_for_update'] = $this->table."#".$data["id"];
        }
        return $validator->check($data, $rules);
    }
    
    /**
     * This function is responsible to accept the data from the Routing and add it to the Database.
     */
    public function addSupplier($data)
    {
        $supplier_data = ['first_name' => $data["first_name"], 'last_name' => $data["last_name"], 'gst_no' => $data["gst_no"], 'phone_no' => $data["phone_no"], 'email_id'=>$data["email_id"], 'company_name'=>$data["company_name"]];

        $address_data = ['block_no' => $data["block_no"], 'street' => $data["street"], 'city' => $data["city"], 'pincode' => $data["pincode"], 'town' => $data["pincode"], 'town' => $data["town"], 'state' => $data["state"], 'country' => $data['country']];

        $validation = $this->validateData($supplier_data, 1);
        $addressValidation = $this->address->validateAddress($address_data);

        if(!($validation->fails() || $addressValidation->fails()))
        {
            //Validation was successful
            try
            {
                $this->database->beginTransaction();

                $address_id = $this->address->insert($address_data);

                $supplier_id = $this->database->insert($this->table, $supplier_data);

                $map_data = ['address_id' => $address_id, 'supplier_id' => $supplier_id];

                $this->database->insert("address_supplier", $map_data);

                $this->database->commit();

                return ADD_SUCCESS;
            }
            catch(Exception $e)
            {
                $this->database->rollback();
                return ADD_ERROR;
            }
        }
        else{
            //Validation Failed
            return VALIDATION_ERROR;
        }
    }
    public function editSupplier($data)
    {
        $supplier_data = ['id'=>$data["id"], 'first_name' => $data["first_name"], 'last_name' => $data["last_name"], 'gst_no' => $data["gst_no"], 'phone_no' => $data["phone_no"], 'email_id'=>$data["email_id"], 'company_name'=>$data["company_name"]];

        $address_data = ['block_no' => $data["block_no"], 'street' => $data["street"], 'city' => $data["city"], 'pincode' => $data["pincode"], 'town' => $data["pincode"], 'town' => $data["town"], 'state' => $data["state"], 'country' => $data['country']];

        $validation = $this->validateData($supplier_data, 2);
        $addressValidation = $this->address->validateAddress($address_data);

        if(!($validation->fails() || $addressValidation->fails()))
        {
            //Validation was successful
            try
            {
                $this->database->beginTransaction();

                $id = $supplier_data['id'];
                unset($supplier_data['id']);
                $this->database->update($this->table, $supplier_data, 'id = '.$id);

                $address_id = $this->address->getAddressId($id, "address_supplier");
                $this->database->update("address", $address_data, 'id = '.$address_id);

                $this->database->commit();

                return EDIT_SUCCESS;
            }
            catch(Exception $e)
            {
                $this->database->rollback();
                return EDIT_ERROR;
            }
        }
        else{
            //Validation Failed
            return VALIDATION_ERROR;
        }
    }
    public function getJSONDataForDataTable($draw, $searchParameter, $orderBy, $start, $length)
    {

        $columns = ["sr_no", "full_name", "gst_no", "phone_no", "email_id", "company_name", "address"];

        $totalRowCountQuery = "SELECT COUNT(id) AS total_count FROM {$this->table} WHERE deleted = 0";

        $filteredRowCountQuery = "SELECT COUNT(suppliers.id) AS filtered_total_count FROM {$this->table}, address, address_supplier WHERE suppliers.deleted = 0 AND suppliers.id = address_supplier.supplier_id AND address.id = address_supplier.address_id";

        $query = "SELECT CONCAT(suppliers.first_name, ' ', suppliers.last_name) AS full_name, suppliers.id, suppliers.gst_no, suppliers.phone_no, suppliers.email_id, suppliers.company_name, CONCAT(address.block_no, ' ', address.street, ' ', address.town, ' ', address.city, ' ', address.pincode, ' ', address.state, ' ', address.country) AS address FROM suppliers, address, address_supplier WHERE suppliers.deleted=0 AND suppliers.id = address_supplier.supplier_id AND address.id = address_supplier.address_id";

        if($searchParameter != null)
        {
            $query .= " AND(CONCAT(suppliers.first_name, ' ', suppliers.last_name) LIKE '%{$searchParameter}%' OR suppliers.gst_no LIKE '%{$searchParameter}%' OR suppliers.phone_no LIKE '%{$searchParameter}%' OR suppliers.email_id LIKE '%{$searchParameter}%' OR suppliers.company_name LIKE '%{$searchParameter}%' OR CONCAT(address.block_no, ' ', address.street, ' ', address.town, ' ', address.city, ' ', address.pincode, ' ', address.state, ' ', address.country) LIKE '%{$searchParameter}%')";

            $filteredRowCountQuery .= " AND(CONCAT(suppliers.first_name, ' ', suppliers.last_name) LIKE '%{$searchParameter}%' OR suppliers.gst_no LIKE '%{$searchParameter}%' OR suppliers.phone_no LIKE '%{$searchParameter}%' OR suppliers.email_id LIKE '%{$searchParameter}%' OR suppliers.company_name LIKE '%{$searchParameter}%' OR CONCAT(address.block_no, ' ', address.street, ' ', address.town, ' ', address.city, ' ', address.pincode, ' ', address.state, ' ', address.country) LIKE '%{$searchParameter}%')";
        }
        if($orderBy != null)
        {
            $query .= " ORDER BY {$columns[$orderBy[0]['column']]} {$orderBy[0]['dir']}";
        }
        if($length != -1)
        {
            $query .= " LIMIT {$start}, {$length}";
        }

        $totalRowCountResult = $this->database->raw($totalRowCountQuery);
        $numberOfTotalRows = is_array($totalRowCountResult) ? $totalRowCountResult[0]->total_count : 0;

        $filteredRowCountResult = $this->database->raw($filteredRowCountQuery);
        $numberOfFilteredRows = is_array($filteredRowCountResult) ? $filteredRowCountResult[0]->filtered_total_count : 0;

        $filteredData = $this->database->raw($query);

        $numberOfRowsToDisplay = is_array($filteredData) ? count($filteredData) : 0;

        $data = [];

        for($i = 0; $i < $numberOfRowsToDisplay; $i++)
        {
            $basePages = BASEPAGES;
            $subarray = [];
            $subarray[] = $i + 1;
            $subarray[] = $filteredData[$i]->full_name;
            $subarray[] = $filteredData[$i]->gst_no;
            $subarray[] = $filteredData[$i]->phone_no;
            $subarray[] = $filteredData[$i]->email_id;
            $subarray[] = $filteredData[$i]->company_name;
            $subarray[] = $filteredData[$i]->address;
            $subarray[] = <<<BUTTONS
            <a href="{$basePages}view-supplier.php?id={$filteredData[$i]->id}" class='view btn btn-outline-success m-1'><i class='fas fa-eye'></i></a>
            <a href="{$basePages}edit-supplier.php?id={$filteredData[$i]->id}" class='edit btn btn-outline-primary m-1'><i class='fas fa-pencil-alt'></i></a>
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

    public function getSupplierDetailsById($supplier_id){
        $supplierDetails = $this->database->readData($this->table, ['*'], "id = $supplier_id", PDO::FETCH_ASSOC);
        $addressDetails = $this->address->getAddress($supplier_id, "address_supplier");
        $data = $supplierDetails[0] + $addressDetails[0];
        return $data;
    }

    public function delete($id){
        try{
            $this->database->beginTransaction();
            $this->database->delete($this->table, "id={$id}");
            $this->address->delete($id, "address_supplier");
            $this->database->commit();
            return DELETE_SUCCESS;
        }catch(Exception $e){
            $this->database->rollback();
            return DELETE_ERROR;
        }
    }
}