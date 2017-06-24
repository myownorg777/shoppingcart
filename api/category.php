<?php
class Category{
 
    // database connection and table name
    private $conn;
    private $table = "category";
    
 // object properties
    public $priColumn = "category_id";
    public $id;
    public $name;
    public $description;
    public $category_name;
    public $created;
    
 
    public function __construct($db){
        $this->dbh = $db;
    }
     
  function insertCategory($name,$description,$Tax)
 {
           $data =  array( 'name' => $name, 'description' => $description, 'Tax' => $Tax, 'createdDate' => date('Y-m-d H:i:s') );

	   	    $response = $this->dbh->insert($this->table ,$data);
        
        // Check for successful insertion
            return json_encode($response); 
 }
    
  function updateCategory($name,$description,$Tax,$id)
 {
           $fields =  array( 'name' => $name, 'description' => $description, 'Tax' => $Tax) ;

	   	    $response = $this->dbh->update($this->table , $this->priColumn, $id, $fields);
        // print_r($response);
        // Check for successful insertion
          return json_encode($response); 
 }
 function deleteCategory($data)
 {
	   	    $response = $this->dbh->deleteData($this->table , $this->priColumn ,$data);
        
        return json_encode($response);
 }

   public function getCategoryById($id) 
    {
		    $fields =array('name','description','tax','createdDate');
	   	    $response = $this->dbh->selectwhere($this->table,$this->priColumn, $id, $fields);
               
            return json_encode($response); 
 }
 public function getCategoriesById($id) 
    {
	   	    $response = $this->dbh->select($this->table,$this->priColumn, $id);
               
            return ($response); 
 }
 function getTax($id)
 {
	        $selectColumn ='tax'; 
	   	    $response = $this->dbh->selectSingle($this->table,$this->priColumn, $id,$selectColumn);
              // print_r($response);
            return ($response[0]['tax']);  
 }
}
?>