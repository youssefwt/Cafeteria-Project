<?php

class DbManager
{
    private $dsn = 'mysql:dbname=Cafeteriadb;host=127.0.0.1;port=3306;';
    private $user = 'abdallah';
    private $password = 'root';

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

    public function get_price($product)
    {
        $query = "SELECT price FROM products WHERE name=:product";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':product' => $product]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function user_make_order($total, $user, $room, $notes, $by_admin, $orders)
    {
        try {
            $this->pdo->beginTransaction();
            $query = "INSERT INTO orders (datetime ,user_id, total, status, notes, by_admin, room) VALUES(:sometime, :u_id, :total, :status,:notes,:by_admin, :room)";
            $time_now = date("y") . "-" . date("m") . "-" . date("d") . " " . date("G:i:s");
            $deliver = "Processing";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['sometime' => $time_now, ':u_id' => $user, ':total' => $total, ':status' => $deliver, ':notes' => $notes, ':by_admin' => $by_admin, ':room' => $room]);
            $order_id = $this->pdo->lastInsertId();
            foreach ($orders as $key => $value) {
                if ($key == "room" || $key == "notes" || $key == "id") {
                    continue;
                }
                $query = "INSERT INTO order_product VALUES(:order_id, :prd_id, :quantity)";
                $stmt = $this->pdo->prepare($query);
                $product_id = $this->get_product_id_by_name($key);
                $stmt->execute([':order_id' => $order_id, ':prd_id' => $product_id, ':quantity' => $value]);
            }
            //            for($i = 0; $i < count($orders)-3;$i+=2){
            //                $query = "INSERT INTO order_product VALUES(:order_id, :prd_id, :quantity)";
            //                $stmt = $this->pdo->prepare($query);
            //                $product_id=$this->get_product_id_by_name($orders[$i]);
            //                $stmt->execute([':order_id'=>$order_id, ':prd_id'=>$product_id, ':quantity'=>$orders[$i+1]]);
            //            }
            $this->pdo->commit();
        } catch (PDOExecption $e) {
            print "Error!: " . $e->getMessage() . "</br>";
        }
        //date("y")."-".date("m")."-".date("d")." ".date("G:i:s")
    }

    public function getLastProductsOrdered($userID)
    {
        $query = "SELECT id FROM orders WHERE user_id=:user_id ORDER BY id DESC LIMIT 1;";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([":user_id" => $userID]);
        $result = $stmt->fetch(PDO::FETCH_COLUMN);
        $query = "SELECT prd_id FROM order_product WHERE order_id = $result";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $query = "SELECT * FROM products WHERE id IN (";
        for ($i = 0; $i < count($result) - 1; $i++) {
            $query .= $result[$i] . ",";
        }
        $query .= $result[count($result) - 1] . ")";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($result);
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

    public function userExistence($email, $password)
    {
        $query = "SELECT * FROM users WHERE email=:email AND password=:password";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':email' => $email, ':password' => $password]);
        $result = $stmt->fetchAll();
        $this->close();
        return $result;
    }

    public function getProducts()
    {
        $query = "SELECT * FROM products";
        $stmt = $this->pdo->prepare($query);
        $this->executeToJson($stmt);
    }

    public function getavailProducts()
    {
        $query = "SELECT * FROM products WHERE status='avail'";
        $stmt = $this->pdo->prepare($query);
        $this->executeToJson($stmt);
    }

    public function getUsersTotal($start, $end)
    {

        $query = "SELECT o.user_id,u.finame , SUM(o.total) AS total FROM users u , orders o 
                WHERE u.id=o.user_id and datetime between :start and :end
                GROUP BY o.user_id";

        $stmt = $this->pdo->prepare($query);

        $stmt->execute([
            "start" => $start,
            "end" => $end
        ]);

        // $this->executeToJson($stmt);
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        //close query
        $stmt->closeCursor();
        $resultAsJson = json_encode($result);
        echo $resultAsJson;
    }

    public function getOrdersByUser($userId, $start, $end)
    {
        $query = "SELECT o.id , o.datetime , o.total ,o.status
                FROM users u , orders o 
                 WHERE u.id=:userId and datetime between :start and :end;";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            "userId" => $userId,
            "start" => $start,
            "end" => $end
        ]);
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

    public function  getProductById($id)
    {
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

    public function get_product_id_by_name($name)
    {
        $query = "SELECT id FROM products WHERE name='$name'";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll()[0][0];
        return $result;
    }

    public function get_From_Table($table_name, ...$args)
    {

        $query = "SELECT * FROM $table_name;";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
    }
    public function update_Table($table_name, $id, ...$args)
    {
        $query = "UPDATE $table_name SET ";
        for ($i = 0; $i < count($args); $i += 2) {
            $some_number = $i + 1;
            if ($some_number == count($args) - 1) {
                $query .= "`$args[$i]`" . "=" . "'$args[$some_number]' ";
            } else {
                $query .= "`$args[$i]`" . "=" . "'$args[$some_number]', ";
            }
        }
        $the_int_id = (int) $id;
        $query .= "WHERE id=$the_int_id;";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
    }
    public function delete_Record($table_name, $id)
    {
        $query = "DELETE FROM $table_name WHERE id=$id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
    }
    public function fetch_img($id)
    {
        $query = "SELECT `image_url` FROM products WHERE id= $id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result[0][0];
    }
    //category
    public function add_Category($name)
    {
        $query = "INSERT INTO category  VALUES('$name') ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
    }
    public function get_All_Category()
    {
        $query = "SELECT * FROM category";
        $stmt = $this->pdo->prepare($query);
        $this->executeToJson($stmt);
    }
    // Methods for Users Table
    function SELECTUSERS()
    {
        $query = "SELECT * FROM `users`";
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

    function cancelUserOrder($orderId)
    {
        $query = "DELETE FROM `order_product` WHERE order_id=:orderId;
                  DELETE FROM `orders` WHERE `id` = :orderId";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(["orderId" => $orderId]);
        return $stmt;
    }

    // public function getOrderItemsFilter($orderId)
    // {
    //     $query = "SELECT p.name, p.Price, p.image_url, op.quantity
    //             FROM Orders o , order_product op , products p
    //             WHERE op.order_id=:orderId and o.id=op.order_id and p.id=op.prd_id; ";

    //     $stmt = $this->pdo->prepare($query);
    //     $stmt->execute(["orderId" => $orderId]);
    //     $result = $stmt->fetchAll(PDO::FETCH_OBJ);

    //     //close query
    //     $stmt->closeCursor();
    //     $resultAsJson = json_encode($result);
    //     echo $resultAsJson;
    // }
    // End of Methods for Users Table


    public function changeOrderStatus($status, $id)
    {
        $query = "update orders set status = :status where id = :orderId;";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(["orderId" => $id, "status" => $status]);
        $stmt->closeCursor();
    }
}
