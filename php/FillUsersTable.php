<?php
include "dbManager.php";
$d1 = new DbManager();
$stmt = $d1->SELECTUSERS();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Users</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="../css/FillUsersTable.css" />
  </head>
  <body>
    <div id="UsersPage">
      <nav
        class="navbar navbar-expand-lg navbar-dark"
        style="background-color: black"
      >
        <div class="container-fluid">
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
              <a class="nav-link" href="#">Home</a>
              <a class="nav-link" href="#">Products</a>
              <a class="nav-link active" href="#">Users</a>
              <a class="nav-link" href="#">Manual Order</a>
              <a class="nav-link">Checks</a>
            </div>
          </div>
        </div>
      </nav>
      <div id="UsersADD" class="d-flex justify-content-between align-items-center">
        <h2 class=" text-light mt-2 mx-2 ">All Users</h2>
        <a href="AddUser.php" class="mx-5 mt-3 px-3 btn btn-primary btn-lg "> Add User</a>
        
      </div>

      <table class="mt-4 table table-dark table-striped table-hover w-75 m-auto">
        <thead>
          <tr>
            <th scope="col" class='fs-5'>Name</th>
            <th scope="col" class='fs-5'>Email</th>
            <th scope="col" class='fs-5'>Profile Image</th>
            <th scope="col" class='fs-5'>Edit</th>
            <th scope="col" class='fs-5'>Delete</th>
          </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                <td class='fs-5'>".$row["finame"]." ".$row["lname"]."</td>
                <td class='fs-5'>".$row["email"]."</td>
                <td class='fs-5'><img src='".$row["image_url"]."' alt='' class='img-thumbnail img-fluid' style='display:block; width:70px; height:70px; margin: auto;'></td>
                <td class='fs-5'><a class='btn btn-warning' href='EditUser.php?id=".$row["id"]."'> Update</a></td>
                <td class='fs-5'><a class='btn btn-danger' href='DeleteUser.php?id=".$row["id"]."'> Delete</a></td></tr>";
            }
            ?>




        </tbody>
    </table>

    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../js/FillUsersTable.js"></script>
</body>

</html>