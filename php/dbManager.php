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
}
