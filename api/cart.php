<?php

class Cart
{
    private $items = array(); // Associative array of items
    private $dbh;
    private $table = "cart"; 
    // object properties
    public $id;
    public $name;
    public $product_id;
    public $total;    
    public $total_discount;
    public $discount_total;
	public $total_tax;
	public $tax_total;
	public $grand_total;
    public $created; 

    function __construct($db)
    {
        $this->syncCartToSession();
		$this->dbh = $db;
    }
    function insertCart($name,$product_id,$total, $total_discount,$discount_total,$total_tax,$tax_total,$grand_total)
 {
           $data =  array( 'name' => $name, 'product_id' => $product_id, 'total' => $total,'total_discount' => $total_discount, 'discount_total' => $discount_total,'total_tax' => $total_tax,'tax_total' => $tax_total,'grand_total' => $grand_total, 'createdDate' => date('Y-m-d H:i:s') );

	   	    $response = $this->dbh->insert($this->table ,$data);
        // Check for successful insertion
            return json_encode($response); 
 }
 function showCart($value)
 {
	 
	   	    $response = $this->dbh->select($this->table,'name', $value);
               
            return ($response); 
 }
    public function addItem($itemID, $quantity)
    {
        if (isset($this->items[$itemID]))
        {
            $this->items[$itemID]['quantity'] += (int)$quantity;
        }
        else
        {
            $this->items[$itemID]['id'] = $itemID;
            $this->items[$itemID]['quantity'] = (int)$quantity;
        }
        
        // Sync the session with the cart now
        $this->syncSessionToCart();
    }
    
    public function deleteItem($itemID)
    {
        if (isset($this->items[$itemID]))
        {
            unset($this->items[$itemID]);
            
            // Sync the session with the cart now
            $this->syncSessionToCart();
        }
    }
    
    public function setQuantity($itemID, $newQuantity)
    {
        if (isset($this->items[$itemID]))
        {
            if ((int)$newQuantity <= 0)
            {
                $this->deleteItem($itemID);
            }
            else
            {
                $this->items[$itemID]['quantity'] = (int)$newQuantity;
            }
            
            // Sync the session with the cart now
            $this->syncSessionToCart();
        }
    }
    
    public function getQuantity($itemID)
    {
        if (isset($this->items[$itemID]))
        {
            return ($this->items[$itemID]['quantity']);
        }
    }
    
    public function numberOfItems()
    {
        if (isset($this->items))
        {
            $numberOfItems = 0;
            
            foreach ($this->items as $item)
            {
                $numberOfItems += $item['quantity'];
            }
            return $numberOfItems;
        }
    }
    
    public function emptyCart()
    {
        unset($this->items);
        
        $this->items = array();
        
        // Sync the session with the cart now
        $this->syncSessionToCart();
    }

    public function getContents()
    {
        if (isset($this->items))
        {
            return $this->items;
        }
    }

    public function getTotal()
    {
        if (isset($this->items))
        {
            $product = new Product($this->dbh);
			$category = new Category($this->dbh);
            $total = 0;
            
			
            //foreach ($this->items as $item)
            {
				
				
                $total += $this->getTotalTaxPrice()+ $this->getTotalDiscountPrice();
            }
        
            return $total;
        }
        else
        {
            return 0;
        }
    }
public function getTotalTaxPrice()
    {
        if (isset($this->items))
        {
            $product = new Product($this->dbh);
			$category = new Category($this->dbh);
            $total = 0;
        
            foreach ($this->items as $item)
            {
				
				$total += (number_format(($category->getTax($product->getCategory($item['id']))/100),2) * ((number_format($product->getPrice($item['id']),2)) * $item['quantity']));
               
            }
        
            return $total;
        }
        else
        {
            return 0;
        }
    }
	public function getTotalDiscountPrice()
    {
        if (isset($this->items))
        {
            $product = new Product($this->dbh);
			
			
            $Discount = 0;
        
            foreach ($this->items as $item)
            {
				//echo "hiiiiiiiiii".$product->getPrice($item['id']);
				
				$Discount +=   (number_format($product->getPrice($item['id']),2) - (number_format(($product->getDiscount(($item['id']))/100),2)* number_format($product->getPrice($item['id']),2))) ;
                //$total += $product->getPrice($item['id']) * $item['quantity'];
            }
        
            return $Discount;
        }
        else
        {
            return 0;
        }
    }
    public function serializeCart()
    {
        $serializedCart = serialize($this->items);
        
        return $serializedCart;
    }
    
    public function unserializeCart($serializedCart)
    {
        $unserializedCart = unserialize($serializedCart);
        
        $this->items = $unserializedCart;
        
        $this->syncSessionToCart();
    }
    
    private function syncSessionToCart()
    {
        $_SESSION['items'] = $this->items;
    }
    
    private function syncCartToSession()
    {
        if (isset($_SESSION['items']))
        {
            $this->items = $_SESSION['items'];
        }
    }

}  
?>