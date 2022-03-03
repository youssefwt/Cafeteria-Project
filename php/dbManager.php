<?php

class DbManager
{
    private $dsn = 'mysql:dbname=CafeteriaDB;host=127.0.0.1;port=3306;';
    private $user = 'admin';
    private $password = '12345678';
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
        $query = "SELECT o.id , o.datetime , o.total 
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

    public function addProduct(...$args){
        $query = "INSERT INTO `products` (`name`, `Price`, `image_url`, `status`) VALUES(?,?,?,?)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($args);
    }
    public function Product_table($table_name, ...$args){
      echo" <div class='container w-50 mt-5 border rounded-3'>"  ;
        echo "<table class='table table-striped'><tr>";
        for($i = 0; $i < count($args);$i++){
            echo"<th scope='col'>$args[$i]</th>";
        }
        
        echo '<th>Image</th>';
        echo '<th colspan="2">Action</th>';
        echo '</tr>';
        $query = "SELECT * FROM $table_name;";
        $stmt=$this->pdo->prepare($query);
        $stmt->execute();
        while ($obj = $stmt -> fetchObject()) {
            echo '<tr>';
            for ($i = 0; $i < count($args);$i++){
                echo '<td>';
                $something = $args[$i];
                echo $obj->$something;
                echo '</td>';
            }
            echo "<td><img src='../assets/images/test-images/$obj->image_url' style='width:50px;height:50px'></td>";
            
            echo "<td><a href='edit.php?id=".$obj->id."'>Edit</a></td>";
            echo "<td><a href='delete.php?id=".$obj->id."'>Delete</a></td>";
            echo'</tr>';
        }
        echo '</table>';
       echo "</div>" ;
    }
    // Methods for Users Table
    function SELECTUSERS()
    {
        $query = "SELECT * FROM `Users`";
        $stmt = $this->pdo->prepare($query);
        $this->executeToJson($stmt);
    }
    function FETCHUSER( ...$args)
    {
        $query = "SELECT * FROM `users` WHERE `id` = ?;";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($args);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    function INSERTUSER( ...$args)
    {
        $query = "Insert INTO `users` (finame, lname, password, email, image_url) Values(?,?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($args);
        return $stmt;
    }
    function UPDATEUSER( ...$args)
    {
        $query = "UPDATE `users` SET `finame` = ?, `lname` = ?, `password` = ?, `email` = ?, `image_url` = ? WHERE `id` = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($args);
        return $stmt;
    }
    function DELETEUSER( ...$args)
    {
        $query = "DELETE FROM `users` WHERE `id` = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($args);
        return $stmt;
    }
    // End of Methods for Users Table
}
