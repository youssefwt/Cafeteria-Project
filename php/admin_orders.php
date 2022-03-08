<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="../css/admin_orders.css">
</head>
<body>
    <h1>Orders</h1>

    <?php
    $dsn = 'mysql:dbname=cafeteriadb;host=localhost;port=3306;';
    $user = 'root';
    $password = 'password';
    try{
        $conn = new PDO($dsn, $user, $password);

        $sql_user = 'SELECT o.id, o.datetime as time, concat(u.fname, " ", u.lname) as name, o.room, o.status, o.total
            FROM orders o join users u on o.user_id=u.id;';
        $stmt_user = $conn->prepare($sql_user);
        $stmt_user->execute();
        $result_user = $stmt_user->fetchAll(PDO::FETCH_ASSOC);

        foreach($result_user as $row_user){
            echo '<div class="order">';
            echo '<div class="header">';
            echo '<table>';
            echo '<tr>
                <th>Order Date</th>
                <th>Name</th>
                <th>Room</th>
                <th>Status</th>
                </tr>';
            echo '<tr>';
            echo '<td>'. $row_user['time'].'</td>';
            echo '<td>'.$row_user['name'].'</td>';
            echo '<td>'.$row_user['room'].'</td>';
            echo '<td>'.$row_user['status'].'</td>';
            echo '</tr>';
            echo '</table>';
            echo '</div>';

            echo '<div class="body">';

            $id = $row_user['id'];
            $sql_product = "SELECT op.quantity, o.datetime, o.room, o.status, p.image_url, p.price, op.quantity, o.total
                from orders o join order_product op on o.id = op.order_id
                join products p on op.prd_id = p.id
                where o.id = $id";
            $stmt_product = $conn->prepare($sql_product);
            $stmt_product->execute();
            $result_product = $stmt_product->fetchAll(PDO::FETCH_ASSOC);
            $total = 0;
            foreach($result_product as $row_product){
                echo "<div class='image'>";
                    echo "<img src='../items/".$row_product["image_url"]."'>";
                    echo '<span>'.$row_product['quantity']."x ".$row_product['price']."LE".'</span>';
                    $total += $row_product['quantity'] * $row_product['price'];
                echo "</div>";
            }
            echo '</div>
            <div class="footer">
                <span>Total: EGP ';
                //echo $row_user["total"];
                echo $total;
                echo '</span>
            </div>';
            echo '</div>';
        }
    }catch(PDOException $e){
        echo 'Connection failed: '. $e->getMessage();
    }
    ?>

</body>
</html>