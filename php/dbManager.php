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
}
