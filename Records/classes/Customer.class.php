<?php

require_once __DIR__."/../helper/requirements.php";

class Customer{
    private $table ="customers";
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
            'gender'=> [
                'required'=> true
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
    public function addCustomer($data)
    {
        $customer_data = ['first_name' => $data["first_name"], 'last_name' => $data["last_name"], 'gst_no' => $data["gst_no"], 'phone_no' => $data["phone_no"], 'email_id'=>$data["email_id"], 'gender'=>$data["gender"]];

        $address_data = ['block_no' => $data["block_no"], 'street' => $data["street"], 'city' => $data["city"], 'pincode' => $data["pincode"], 'town' => $data["pincode"], 'town' => $data["town"], 'state' => $data["state"], 'country' => $data['country']];

        $validation = $this->validateData($customer_data, 1);
        $addressValidation = $this->address->validateAddress($address_data);

        if(!($validation->fails() || $addressValidation->fails()))
        {
            //Validation was successful
            try
            {
                $this->database->beginTransaction();

                $address_id = $this->address->insert($address_data);

                $customer_id = $this->database->insert($this->table, $customer_data);

                $map_data = ['address_id' => $address_id, 'customer_id' => $customer_id];

                $this->database->insert("address_customer", $map_data);

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

    public function editCustomer($data)
    {
        $customer_data = ['id'=>$data["id"], 'first_name' => $data["first_name"], 'last_name' => $data["last_name"], 'gst_no' => $data["gst_no"], 'phone_no' => $data["phone_no"], 'email_id'=>$data["email_id"], 'gender'=>$data["gender"]];

        $address_data = ['block_no' => $data["block_no"], 'street' => $data["street"], 'city' => $data["city"], 'pincode' => $data["pincode"], 'town' => $data["pincode"], 'town' => $data["town"], 'state' => $data["state"], 'country' => $data['country']];

        $validation = $this->validateData($customer_data, 2);
        $addressValidation = $this->address->validateAddress($address_data);

        if(!($validation->fails() || $addressValidation->fails()))
        {
            //Validation was successful
            try
            {
                $this->database->beginTransaction();

                $id = $customer_data['id'];
                unset($customer_data['id']);
                $this->database->update($this->table, $customer_data, 'id = '.$id);

                $address_id = $this->address->getAddressId($id, "address_customer");
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

        $columns = ["sr_no", "full_name", "gst_no", "phone_no", "email_id", "gender", "address"];

        $totalRowCountQuery = "SELECT COUNT(id) AS total_count FROM {$this->table} WHERE deleted = 0";

        $filteredRowCountQuery = "SELECT COUNT(customers.id) AS filtered_total_count FROM {$this->table}, address, address_customer WHERE customers.deleted = 0 AND customers.id = address_customer.customer_id AND address.id = address_customer.address_id";

        $query = "SELECT CONCAT(customers.first_name, ' ', customers.last_name) AS full_name, customers.id, customers.gst_no, customers.phone_no, customers.email_id, customers.gender, CONCAT(address.block_no, ' ', address.street, ' ', address.town, ' ', address.city, ' ', address.pincode, ' ', address.state, ' ', address.country) AS address FROM customers, address, address_customer WHERE customers.deleted=0 AND customers.id = address_customer.customer_id AND address.id = address_customer.address_id";

        if($searchParameter != null)
        {
            $query .= " AND(CONCAT(customers.first_name, ' ', customers.last_name) LIKE '%{$searchParameter}%' OR customers.gst_no LIKE '%{$searchParameter}%' OR customers.phone_no LIKE '%{$searchParameter}%' OR customers.email_id LIKE '%{$searchParameter}%' OR customers.gender LIKE '%{$searchParameter}%' OR CONCAT(address.block_no, ' ', address.street, ' ', address.town, ' ', address.city, ' ', address.pincode, ' ', address.state, ' ', address.country) LIKE '%{$searchParameter}%')";

            $filteredRowCountQuery .= " AND(CONCAT(customers.first_name, ' ', customers.last_name) LIKE '%{$searchParameter}%' OR customers.gst_no LIKE '%{$searchParameter}%' OR customers.phone_no LIKE '%{$searchParameter}%' OR customers.email_id LIKE '%{$searchParameter}%' OR customers.gender LIKE '%{$searchParameter}%' OR CONCAT(address.block_no, ' ', address.street, ' ', address.town, ' ', address.city, ' ', address.pincode, ' ', address.state, ' ', address.country) LIKE '%{$searchParameter}%')";
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
            $subarray[] = $filteredData[$i]->gender;
            $subarray[] = $filteredData[$i]->address;
            $subarray[] = <<<BUTTONS
            <a href="{$basePages}view-customer.php?id={$filteredData[$i]->id}" class='view btn btn-outline-success m-1'><i class='fas fa-eye'></i></a>
            <a href="{$basePages}edit-customer.php?id={$filteredData[$i]->id}" class='edit btn btn-outline-primary m-1'><i class='fas fa-pencil-alt'></i></a>
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

    public function getCustomerDetailsById($customer_id){
        $customerDetails = $this->database->readData($this->table, ['*'], "id = $customer_id", PDO::FETCH_ASSOC);
        $addressDetails = $this->address->getAddress($customer_id, "address_customer");
        $data = $customerDetails[0] + $addressDetails[0];
        // if($mode = PDO::FETCH_OBJ){
        //     return ((object)$data);
        // }

        return $data;
    }

    public function delete($id){
        try{
            $this->database->beginTransaction();
            $this->database->delete($this->table, "id={$id}");
            $this->address->delete($id, "address_customer");
            $this->database->commit();
            return DELETE_SUCCESS;
        }catch(Exception $e){
            $this->database->rollback();
            return DELETE_ERROR;
        }
    }

    public function getCustomerWithEmail($email){
        $customer_id = $this->database->readData($this->table, ['id'], "email_id = '{$email}' and deleted=0", PDO::FETCH_ASSOC);
        $data = $customer_id;
        if($data!=null){
            return $data;
        }
    }

    public function getCustomerByEmailID($emailID){
        $customerDetails = $this->database->readData($this->table, ['*'], "email_id = '$emailID' AND deleted = 0 ", PDO::FETCH_ASSOC);
        return $customerDetails[0];
    }

}