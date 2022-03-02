<?php

class DbManager
{
    private $dsn = 'mysql:dbname=CafeteriaDB;host=127.0.0.1;port=3306;';
    // private $user = 'admin';
    // private $password = '12345678';
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

    public function getProducts()
    {
        $query = "SELECT * FROM Products";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $stds = $stmt->fetchAll(PDO::FETCH_OBJ);

        //close query
        $stmt->closeCursor();
        $myjson = json_encode($stds);
        echo $myjson;
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
}
