<?php
class Product{
 
    // database connection and table name
    private $dbh;
    private $table = "products"; 
    // object properties
	public $priColumn = "product_id";
    public $id;
    public $name;
    public $description;
    public $price;
	public $discount;
    public $category_id;
    public $category_name;
    public $created;
 
 
    public function __construct($db){
        $this->dbh = $db;
    }
     
	 function insertProduct($name,$description,$price,$discount,$catId)
 {
           $data =  array( 'name' => $name, 'description' => $description, 'price' => $price, 'discount' => $discount,'category_id' => $catId, 'createdDate' => date('Y-m-d H:i:s') );

	   	    $response = $this->dbh->insert($this->table ,$data);        
        
            echo json_encode($response); 
 }
 
  function updateProduct($name,$description,$price,$discount,$id)
 {
           $fields =  array( 'name' => $name, 'description' => $description, 'Tax' => $Tax, 'discount' => $discount) ;

	   	    $response = $this->dbh->update($this->table , $this->priColumn, $id, $fields);
        // print_r($response);
        // Check for successful insertion
          return json_encode($response); 
 }
 function deleteProduct($data)
 {
	   	    $response = $this->dbh->deleteData($this->table , $this->priColumn ,$data);
        
        return json_encode($response);
 }
 function getPrice($id)
 {
	        $selectColumn ='price'; 
	   	    $response = $this->dbh->selectSingle($this->table,$this->priColumn, $id,$selectColumn);
              // print_r($response);
            return ($response[0]['price']);  
 }
 function getDiscount($id)
 {
	        $selectColumn ='discount'; 
	   	    $response = $this->dbh->selectSingle($this->table,$this->priColumn, $id,$selectColumn);
              // print_r($response);
            return ($response[0]['discount']);  
 }function getCategory($id)
 {
	        $selectColumn ='category_id'; 
	   	    $response = $this->dbh->selectSingle($this->table,$this->priColumn, $id,$selectColumn);
              // print_r($response);
            return ($response[0]['category_id']);  
 }
 function getProductById($id)
 {
	        $fields =array('name','description','price','discount','createdDate'); 
	   	    $response = $this->dbh->selectwhere($this->table,$this->priColumn, $id,$fields);
               
            return json_encode($response); 
 }
 function getProductsById($id)
 {
	 
	   	    $response = $this->dbh->select($this->table,$this->priColumn, $id);
               
            return ($response); 
 }
}
?>