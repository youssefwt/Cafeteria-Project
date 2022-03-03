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

        $sql = 'select o.datetime, o.total, o.status, o.room, u.fname, u.lname from orders o join users u on o.user_id = u.id;';
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row){
            echo '<div class="order">';
            echo '<div class="header">';
            echo '<table>';
            echo '<tr>
            <th>Order Date</th>
            <th>Name</th>
            <th>Room</th>
            <th>Extension</th>
            <th>Status</th>
            </tr>';
            echo '<tr>';
            echo '<td>'. $row['datetime'].'</td>';
            $name = $row['fname']." ".$row["lname"];
            echo '<td>'.$name.'</td>';
            echo '<td>'.$row['room'].'</td>';
            echo '<td>'."TBD".'</td>';
            echo '<td>'.$row['status'].'</td>';
            echo '</tr>';
            echo '</table>';
            echo '</div>';
            echo '<div class="body">
            <img src="items/1.jpg" alt="coffee">
            <img src="items/2.jpg" alt="cinnabon">
            <img src="items/3.jpg" alt="water">
            </div>
            <div class="footer">
                <span>Total: EGP ';
                echo $row["total"];
                echo '</span>
            </div>';
            echo '</div>';
        }

    }catch(PDOException $e){
        echo 'Connection failed: '. $e->getMessage();
    }
    ?>

    <!--<div class="order">
        <div class="header">
            <table>
                <tr>
                    <th>Order Date</th>
                    <th>Name</th>
                    <th>Room</th>
                    <th>Extension</th>
                    <th>Status</th>
                </tr>
                <tr>
                    <td>2022/03/02 22:26:13</td>
                    <td>Youssef Gazzar</td>
                    <td>2006</td>
                    <td>1307</td>
                    <td>Delivered</td>
                </tr>
            </table>
        </div>
        <div class="body">
            <img src="items/1.jpg" alt="coffee">
            <img src="items/2.jpg" alt="cinnabon">
            <img src="items/3.jpg" alt="water">
            <img src="items/1.jpg" alt="coffee">
            <img src="items/2.jpg" alt="cinnabon">
            <img src="items/3.jpg" alt="water">
            <img src="items/1.jpg" alt="coffee">
            <img src="items/2.jpg" alt="cinnabon">
            <img src="items/3.jpg" alt="water">
        </div>
        <div class="footer">
            <span>Total: EGP 89</span>
        </div>
    </div>-->
</body>
</html>