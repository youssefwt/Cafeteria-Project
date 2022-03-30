<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="../css/admin_orders.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css" />
    <script src="../js/auth.js"></script>
</head>

<body>

    <header class="header d-flex flex-row justify-content-between w-100 sticky-top align-bottom" id="header">
      <a href="/php/Cafeteria-Project" class="logo">
        <img src="../assets/images/landing-page/logo.png" id="logo" />
      </a>
      <nav class="navbar" id="nav">
        <a href="../">Home</a>
        <a href="../html/user_make_order.html">Make order</a>
        <a href="../html/fillUsersTable.html">Users</a>
        <a href="../html/product_table.html">Products</a>
        <a href="../checks.html">Checks</a>
        <a href="admin_orders.php">All Orders</a>
      </nav>
      <button class="btn btn-danger btn-lg" onclick="signout()">Sign out</button>
    </header>

    <h1>Orders</h1>

    <?php
    $dsn = 'mysql:dbname=cafeteriadb;host=localhost;port=3306;';
    $user = 'root';
    $password = 'hatory0000';
    try{
        $conn = new PDO($dsn, $user, $password);

        $sql_user = 'SELECT o.id as id, o.datetime as time, concat(u.finame, " ", u.lname) as name, o.room, o.status, o.total as total
            FROM orders o join users u on o.user_id=u.id WHERE o.status != "Delivered";';
        $stmt_user = $conn->prepare($sql_user);
        $stmt_user->execute();
        $result_user = $stmt_user->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result_user as $row_user) {
            echo '<div class="order">';
            echo '<div class="header">';
            echo '<table class="table table-dark table-bordered text-center">';
            echo '<tr>
                <th>Order Date</th>
                <th>Name</th>
                <th>Room</th>
                <th>Status</th>
                </tr>';
            echo '<tr>';
            echo '<td>' . $row_user['time'] . '</td>';
            echo '<td>' . $row_user['name'] . '</td>';
            echo '<td>' . $row_user['room'] . '</td>';
            echo '<td class="target">' . $row_user['status'] . '<button data-status="' . $row_user['status'] . '" data-id="' . $row_user['id'] . '" class="btn btn-warning ms-3" onclick="updateStatus(event)">Deliver</button>' . '</td>';
            echo '</tr>';
            echo '</table>';
            echo '</div>';

            echo '<div class="body">';

            $id = $row_user['id'];
            $sql_product = "SELECT op.quantity, o.datetime, o.room, o.status, p.image_url, p.price, op.quantity, o.total
                from orders o join order_product op on o.id = op.order_id
                join products p on op.prd_id = p.id
                where o.id = $id;";
            $stmt_product = $conn->prepare($sql_product);
            $stmt_product->execute();
            $result_product = $stmt_product->fetchAll(PDO::FETCH_ASSOC);
            //$total = 0;
            foreach ($result_product as $row_product) {
                echo "<div class='image'>";


                echo "<img style='max-width:100px;max-height: 100px;min-width:100px;min-height: 100px' src='../assets/images/products/" . $row_product["image_url"] . "'>";
                echo '<span class="text-light">' . $row_product['quantity'] . "x " . $row_product['price'] . "LE" . '</span>';
                //$total += $row_product['quantity'] * $row_product['price'];
                echo "</div>";
            }
            echo '</div>
            <div class="footer">
                <span class="text-light">Total: EGP ';
            //echo $row_user["total"];
            echo $row_user['total'];
            echo '</span>
            </div>';
            echo '</div>';
        }
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
    ?>
    <script>
        document.querySelectorAll(".target").forEach(element => {
            if(element.childNodes[0].data == "On Delivery"){
                element.childNodes[1].innerText = "Done";
                element.childNodes[1].classList.remove("btn-warning");
                element.childNodes[1].classList.add("btn-success");
            }
        });

        async function updateStatus(e) {
            let status = e.target.dataset.status == "Processing" ? "On Delivery" : "Delivered";
            let id = e.target.dataset.id;
            console.log(status, id);
            fetch(`./controllers/changeOrderStatus.php?orderId=${id}&status=${status}`)
                .then(() => {
                    if (status == "On Delivery")
                        e.target.parentElement.innerHTML = `<td>${status}<button data-status="${status}" data-id="${id}" class="btn btn-success ms-3" onclick="updateStatus(event)">Done</button></td>`
                    else
                        e.target.parentElement.innerHTML = `<td>${status}</td>`

                })
        }
    </script>
</body>

</html>