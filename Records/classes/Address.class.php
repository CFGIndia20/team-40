<?php

require_once __DIR__."/../helper/requirements.php";

class Address{
    private $table = "address";
    private $database;
    protected $di;

    public function __construct(DependencyInjector $di)
    {
        $this->di = $di;
        $this->database = $this->di->get('database');
    }

    public function validateAddress($data)
    {
        $validator = $this->di->get('validator');
        return $validator->check($data, [
            'block_no' => [
                'required' => true,
                'minlength' => 2,
                'maxlength' => 30
            ],
            'street' => [
                'required' => true,
                'minlength' => 2,
                'maxlength' => 25
            ],
            'city' => [
                'required' => true,
                'minlength' => 2,
                'maxlength' => 25
            ],
            'pincode' => [
                'required' => true,
                'minlength' => 6,
                'maxlength' => 6
            ],
            'town' => [
                'required' => true,
                'minlength' => 2,
                'maxlength' => 25
            ],
            'state' => [
                'required' => true,
                'minlength' => 2,
                'maxlength' => 25
            ],
            'country' => [
                'required' => true,
                'minlength' => 2,
                'maxlength' => 25
            ]
        ]);
    }

    public function insert($data){
        return $this->database->insert($this->table, $data);
    }


    public function getAddress($id, $mapping_table_name){
        if($mapping_table_name != null){
            $address_id = self::getAddressId($id, $mapping_table_name);
        }else{
            $address_id = $id;
        }
        return $this->database->readData($this->table, ["*"], "id = $address_id", PDO::FETCH_ASSOC);
    }

    public function getAddressId($id, $mapping_table_name){
        if($mapping_table_name == "address_customer"){
            $column_name = "customer_id";
        } else if($mapping_table_name == "address_supplier"){
            $column_name = "supplier_id";
        }
        $query = "SELECT `address_id` FROM `$mapping_table_name` WHERE `$column_name` = $id";
        $address_id = $this->database->raw($query);
        return $address_id[0]->address_id;
    }

    public function delete($id, $mapping_table_name){
        if($mapping_table_name != null){
            $id = self::getAddressId($id, $mapping_table_name);
        }
        $this->database->delete($this->table, "id = {$id}");
    }
}

?>