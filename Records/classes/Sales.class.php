<?php

require_once __DIR__."/../helper/requirements.php";

class Sales{
    private $table = "sales";
    private $database;
    protected $di;
    
    public function __construct(DependencyInjector $di)
    {
        $this->di = $di;
        $this->database = $this->di->get('database');
    }
    
    /**
     * This function is responsible to accept the data from the Routing and add it to the Database.
     */
    public function addSales($data)
    {
        // $validation = $this->validateData($data);
    
            //Validation was successful
        
            try
            {
            $this->database->beginTransaction();
    
                $invoice_id = $this->database->insert("invoice", ["customer_id"=>$data["customer_id"]]);
    
                $data_to_be_inserted["invoice_id"] = $invoice_id;
                for($i = 0; $i < sizeof($data["product_id"]); $i++){
                    $data_to_be_inserted["product_id"] = $data["product_id"][$i];
                    $data_to_be_inserted["quantity"] = $data["quantity"][$i];
                    $data_to_be_inserted["discount"] = $data["discount"][$i];
    
                    $this->database->insert($this->table, $data_to_be_inserted);
                }
    
                $this->database->commit();  
                return $invoice_id;


                //Begin Transaction
                // $this->database->beginTransaction();
                // $data_to_be_inserted = ['customer_id' => $data['customer_id']];
                // $invoice_id = $this->database->insert('invoice', $data_to_be_inserted);
                // $this->database->commit();
                // return ADD_SUCCESS;


                

                // // $this->database->beginTransaction();
                // // $p_id = $data["product_id['id']"];
                // // echo "$p_id";
                // $data_to_be_inserted["invoice_id"] = $invoice_id;

                // for($i = 0; $i < sizeof($data["product_id"]); $i++){
                //     $data_to_be_inserted["product_id"] = $data["product_id"][$i];
                //     $data_to_be_inserted["quantity"] = $data["quantity"][$i];
                //     $data_to_be_inserted["discount"] = $data["discount"][$i];
    
                //     $this->database->insert('sales', $data_to_be_inserted);
                // }

                // return $invoice_id;
                // $sales_data = ['product_id'=>$data["product_id[]"], 'quantity' => $data["quantity[]"], 'discount' => $data["discount[]"], 'invoice_id' => $invoice_id];
                // echo "<script> console.log($p_id); </script>";
                // $data_to = ['product_id' => $data['product_id[0]']];
                // $sales_id = $this->database->insert('sales', $sales_data);
        
        
                // $data_to_be_inserted = ['customer_id' => $data['customer_id']];
                // $invoice_id = $this->database->insert($this->table, $data_to_be_inserted);
                // $this->database->commit();
                // return ADD_SUCCESS;
                
            }
            catch(Exception $e)
            {
                $this->database->rollback();
                return ADD_ERROR;
            }
            
        
    }

    public function getInvoiceByInvoiceID($invoice_id){
        return $this->database->readData('invoice',["*"], "id=$invoice_id AND deleted=0")[0];
    }

    public function getSalesDetails($invoice_id){

        $query = "SELECT sales.product_id, sales.quantity, sales.discount, products.name, products.specification, products_selling_rate.selling_rate, products_selling_rate.with_effect_from, ((products_selling_rate.selling_rate * sales.quantity) - (products_selling_rate.selling_rate*sales.quantity*(sales.discount/100))) as rate_after_disc FROM sales 
        INNER JOIN products ON products.id = sales.product_id 
        INNER JOIN products_selling_rate ON products_selling_rate.product_id = sales.product_id
        INNER JOIN (SELECT product_id, MAX(with_effect_from) AS wef FROM (SELECT products_selling_rate.product_id, products_selling_rate.selling_rate, products_selling_rate.with_effect_from FROM products_selling_rate, sales WHERE products_selling_rate.with_effect_from <= sales.created_at AND sales.product_id = products_selling_rate.product_id) AS temp GROUP BY product_id) AS max_date_table ON max_date_table.product_id = products_selling_rate.product_id AND sales.product_id = max_date_table.product_id AND products_selling_rate.with_effect_from = max_date_table.wef
        WHERE invoice_id = {$invoice_id} AND sales.deleted=0";

        return $this->database->raw($query);

    }


    
}
?>