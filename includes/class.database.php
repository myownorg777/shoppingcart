<?php
class database {
     
    private $dbName = null, $dbHost = null, $dbPass = null, $dbUser = null;
    
    private static $instance = null;
    
     
    private function __construct($dbDetails = array()) {
         
        // Please note that this is Private Constructor
              
		$this->dbName = $dbDetails['db_name'];
        $this->dbHost = $dbDetails['db_host'];
        $this->dbUser = $dbDetails['db_user'];
        $this->dbPass = $dbDetails['db_pass'];;
        $this->table = "";
		
        // Your Code here to connect to database //
        $this->pdo = new PDO('mysql:host='.$this->dbHost.';dbname='.$this->dbName, $this->dbUser, $this->dbPass);
    }
     public function getConnection()
  {
    return $this->pdo;
  }
    public static function connect($dbDetails = array()) {
         
        // Check if instance is already exists      
        if(self::$instance == null) {
            self::$instance = new database($dbDetails);
        }
         
        return self::$instance;
         
    }
	public function selectwhere($table,$field, $value, $fields)
    {
		try
		{
		$str = implode (", ", $fields);
        $this->stmt = $this->pdo->prepare("SELECT {$str} FROM {$table} WHERE {$field} = {$value}");

        if($this->stmt->execute())
        { 
			$results=$this->stmt->fetchAll(PDO::FETCH_ASSOC);
			
		   $json=json_encode($results);
           $data = array("result" => "1", "message" =>"success","data"=> $json);
  			} 
		  else 
		    {
			 $data = array("result" => 0, "message" => "Error!");
		    }

        } 
   	  catch (PDOException $e) {
   	  	
   	  	$data = array("result" => 0, "message" => "Error!");
	    } 
	     return $data;

    }
	
public function select($table,$field, $value)
    {
		try
		{
			//echo "SELECT * FROM {$table} WHERE {$field} = '{$value}'";
        $this->stmt = $this->pdo->prepare("SELECT * FROM {$table} WHERE {$field} = '{$value}'");

        if($this->stmt->execute())
        { 
			$results=$this->stmt->fetchAll(PDO::FETCH_ASSOC);
			
		   
           $data = $results;
  			} 
		  else 
		    {
			 $data = array("result" => 0, "message" => "Error!");
		    }

        } 
   	  catch (PDOException $e) {
   	  	
   	  	$data = array("result" => 0, "message" => "Error!");
	    } 
	     return $data;

    }
	
     public function insert($table,$data)
    {
        
        $keys = array_keys($data);

        $fields = '`' . implode('`, `', $keys) . '`';
        $placeholders = ':' . implode(', :', $keys);
	 
	 try
   	   {

        $this->stmt = $this->pdo->prepare("INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})");

        if($this->stmt->execute($data))
        {
           $data = array("result" => "1", "message" => "Success");
  			} 
		  else 
		    {
			 $data = array("result" => 0, "message" => "Error!");
		    }

        } 
   	  catch (PDOException $e) {
   	  	
   	  	$data = array("result" => 0, "message" => "Error!");
	    } 
	     return $data;

    }
    
  public function update($table, $chosenfield, $id, $fields){
    $set = '';
    $x = 1;
    foreach($fields as $name => $value){
      $set .="{$name} = '{$value}'";
      if($x < count($fields)){
        $set .= ', ';
      }
      $x++;
    }
    $keys = array_keys($fields);        
    
		 try
   	   {

		$sql = "UPDATE {$table} SET {$set} WHERE {$chosenfield} = '{$id}'";

		// Create the prepared statement
		$this->stmt = $this->pdo->prepare($sql);
		

		// The execute call tells whether or not the query was successful
		if($this->stmt->execute())
		{
			$data = array("result" => "1", "message" => "Success");
  			} 
		  else 
		    {
			 $data = array("result" => 0, "message" => "Error!");
		    }

        } 
   	  catch (PDOException $e) {
   	  	
   	  	$data = array("result" => 0, "message" => "Error!");
	    } 
	     return $data;
    
  }
  public function deleteData($table,$chosenfield,$id)
	{
 		try{
 
 			$sql="UPDATE {$table} SET Flag = 'N' WHERE {$chosenfield}=:id";
 			
 			$this->stmt = $this->pdo->prepare($sql);
 			
 			if($this->stmt->execute(array(':id'=>$id)))
 			{
           		$data = array("result" => "1", "message" => "Success");
  			} 
		  	else 
		    {
			 	$data = array("result" => 0, "message" => "Error!");
		    }

        } 
   	  catch (PDOException $e) {
   	  	
   	  		$data = array("result" => 0, "message" => "Error!");
	    } 
	     return $data;

 
 }   
public function selectSingle($table,$field, $value,$column)
    {
		try
		{
			
        $this->stmt = $this->pdo->prepare("SELECT {$column} FROM {$table} WHERE {$field} = {$value}");

        if($this->stmt->execute())
        { 
			$results=$this->stmt->fetchAll(PDO::FETCH_ASSOC);
			
		   
           $data = $results;
  			} 
		  else 
		    {
			 $data = array("result" => 0, "message" => "Error!");
		    }

        } 
   	  catch (PDOException $e) {
   	  	
   	  	$data = array("result" => 0, "message" => "Error!");
	    } 
	     return $data;

    }
	public function delete($table,$chosenfield,$id)
	{
 		try{
 
 			$sql="DELETE FROM $table WHERE {$chosenfield}=:id";
 			
 			$this->stmt = $this->pdo->prepare($sql);
 			
 			if($this->stmt->execute(array(':id'=>$id)))
 			{
           		$data = array("result" => "1", "message" => "Success");
  			} 
		  	else 
		    {
			 	$data = array("result" => 0, "message" => "Error!");
		    }

        } 
   	  catch (PDOException $e) {
   	  	
   	  		$data = array("result" => 0, "message" => "Error!");
	    } 
	     return $data;

 
 }   
    private function __clone() {
        // Stopping Clonning of Object
    }
     
    private function __wakeup() {
        // Stopping unserialize of object
    }
     
}

?>