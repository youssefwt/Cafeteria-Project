<?php

class DbManager
{
    private $dsn = 'mysql:dbname=cafeteriadb;host=127.0.0.1;port=3306;';
    private $user = 'root';
    private $password = 'Azhar254@';
    public $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO($this->dsn, $this->user, $this->password);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function close()
    {
        //close connection
        $this->pdo = null;
    }

    private function executeToJson($stmt)
    {
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        //close query
        $stmt->closeCursor();
        $resultAsJson = json_encode($result);
        echo $resultAsJson;
    }

    public function userExistence($email, $password){
        $query = "SELECT * FROM users WHERE email='".$email."' AND password='".$password."';";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }

    public function getProducts()
    {
        $query = "SELECT * FROM Products";
        $stmt = $this->pdo->prepare($query);
        $this->executeToJson($stmt);
    }

    public function getUsersTotal()
    {
        $query = "SELECT o.user_id,u.finame , SUM(o.total) AS total FROM Users u , Orders o 
                WHERE u.id=o.user_id
                GROUP BY o.user_id";

        $stmt = $this->pdo->prepare($query);
        $this->executeToJson($stmt);
    }

    public function getOrdersByUser($userId)
    {
        $query = "SELECT o.id , o.datetime , o.total ,o.status
                FROM Users u , Orders o 
                WHERE u.id=:userId;";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute(["userId" => $userId]);
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        //close query
        $stmt->closeCursor();
        $resultAsJson = json_encode($result);
        echo $resultAsJson;
    }
//methods for products table
    public function addProduct(...$args)
    {
        $query = "INSERT INTO `products` (`name`, `Price`, `image_url`, `category_name`) VALUES(?,?,?,?)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($args);
    }

    public function  getProductById($id){
        $query = "SELECT * FROM`products`
        WHERE id=:ProductId;";
    
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(["ProductId" => $id]);
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    
        //close query
        $stmt->closeCursor();
        $resultAsJson = json_encode($result);
        echo $resultAsJson;
    
    }
    
    public function get_From_Table($table_name, ...$args){
     
          $query = "SELECT * FROM $table_name;";
          $stmt=$this->pdo->prepare($query);
          $stmt->execute();
        
      }
      public function update_Table($table_name, $id, ...$args){
        $query = "UPDATE $table_name SET ";
        for($i = 0; $i < count($args); $i+=2){
            $some_number = $i + 1;
            if($some_number == count($args) - 1)
            {
                $query .= "`$args[$i]`"."="."'$args[$some_number]' ";
            }
            else{
                $query .= "`$args[$i]`"."="."'$args[$some_number]', ";
            }
        }
        $the_int_id = (int) $id;
        $query .= "WHERE id=$the_int_id;";
        $stmt=$this->pdo->prepare($query);
        $stmt->execute();
    }
    public function delete_Record($table_name, $id){
        $query = "DELETE FROM $table_name WHERE id=$id";
        $stmt=$this->pdo->prepare($query);
        $stmt->execute();
    }
    public function fetch_img($id){
        $query ="SELECT `image_url` FROM products WHERE id= $id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result[0][0];
    }
    //category
    public function add_Category($name){
        $query="INSERT INTO category  VALUES('$name') ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
   

    }
    public function get_All_Category(){
        $query="SELECT * FROM category";
        $stmt = $this->pdo->prepare($query);
        $this->executeToJson( $stmt);
      
    }
    // Methods for Users Table
    function SELECTUSERS()
    {
        $query = "SELECT * FROM `Users`";
        $stmt = $this->pdo->prepare($query);
        $this->executeToJson($stmt);
    }
    function FETCHUSER(...$args)
    {
        $query = "SELECT * FROM `users` WHERE `id` = ?;";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($args);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    function INSERTUSER(...$args)
    {
        $query = "Insert INTO `users` (finame, lname, password, email, image_url) Values(?,?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($args);
        return $stmt;
    }
    function UPDATEUSER(...$args)
    {
        $query = "UPDATE `users` SET `finame` = ?, `lname` = ?, `password` = ?, `email` = ?, `image_url` = ? WHERE `id` = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($args);
        return $stmt;
    }
    function DELETEUSER(...$args)
    {
        $query = "DELETE FROM `users` WHERE `id` = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($args);
        return $stmt;
    }

    public function getOrderItems($orderId)
    {
        $query = "SELECT p.name, p.Price, p.image_url, op.quantity
                FROM Orders o , order_product op , products p
                WHERE op.order_id=:orderId and o.id=op.order_id and p.id=op.prd_id; ";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute(["orderId" => $orderId]);
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        //close query
        $stmt->closeCursor();
        $resultAsJson = json_encode($result);
        echo $resultAsJson;
    }
    // End of Methods for Users Table
}
