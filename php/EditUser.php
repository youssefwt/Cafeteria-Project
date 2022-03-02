<?php
include "dbManager.php";
setcookie("id", $_REQUEST["id"]/* , time() + (86400 * 30), "/" */);
$d1 = new DbManager();
$row = $d1->FETCHUSER($_REQUEST["id"]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body style="background-color: #0d0d0d;">

    <div class="container" style="background-color: black; margin-top: 9%" >
       
            <form class="row g-3" method="post" action="EditUser_Validation.php" enctype="multipart/form-data">
                <div class="col-md-6">
                    <label for="name" class="form-label text-light">First Name: </label>
                    <input type="text" name="firstname" class="form-control" id="firstname" value="<?php echo $row["finame"]; ?>">
                    <label style="color: red">
                        <?php if (isset($_GET["firstname"])) {
                            echo "First Name required";
                        } ?>
                    </label>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label text-light">Last Name: </label>
                    <input type="text" name="lastname" class="form-control" id="lastname" value="<?php echo $row["lname"]; ?>">
                    <label style="color: red">
                        <?php if (isset($_GET["lastname"])) {
                            echo "Last Name required <br>";
                        }
                        ?>
                    </label>
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label text-light">Password:</label>
                    <input type="password" name="password" class="form-control" id="password" value="<?php echo $row["password"]; ?>">
                    <label style="color: red">
                        <?php if (isset($_GET["password"])) {
                            echo "Password required";
                        }
                        if (isset($_GET['invalidpassword'])) {
                            echo "<br> Invalid password";
                        } ?>
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label text-light">Confirm password:</label>
                    <input type="password" name="confirmpassword" class="form-control" id="confirmpassword" value="<?php echo $row["password"]; ?>">
                    <label style="color: red">
                        <?php if (isset($_GET["confirmpassword"])) {
                            echo "Password doesn't match";
                        } ?> </label>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label text-light">Email: </label>
                    <input type="text" name="email" class="form-control" id="email" value="<?php echo $row["email"]; ?>">
                    <label style="color: red">
                        <?php if (isset($_GET["email"])) {
                            echo "email required <br>";
                        }
                        if (isset($_GET["wrongformat"])) {
                            echo "invalid email";
                        } ?>
                    </label>
                </div>
                <div class="col-6">
    
                    <div class="">
                        <label for="formFile" class="form-label text-light">Upload Your Photo:</label>
                        <input class="form-control" type="file" id="formFile" name="img">
                    </div>
                    <label style="color: red">
                        <?php if (isset($_GET["file"])) {
                            echo "Please Insert a Valid Photo<br>";
                        }
                        ?>
                    </label>
                </div>
               
                    <button type="submit" class="col-12 btn btn-outline-light btn-lg">Update</button>
            </form>
       
    </div>

    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../js/AddUser.js"></script>
</body>

</html>