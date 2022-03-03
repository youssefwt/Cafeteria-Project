<?php
include "dbManager.php";
$finame = '';
$lname = '';
$password = '';
$email = '';
if (!empty($_REQUEST["id"]) && $_REQUEST["id"] != "") {
    setcookie("id", $_REQUEST["id"]/* , time() + (86400 * 30), "/" */);
    $d1 = new DbManager();
    $row = $d1->FETCHUSER($_REQUEST["id"]);
    $finame = $row["finame"];
    $lname = $row["lname"];
    $password = $row["password"];
    $email = $row["email"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/EditUser.css" />
</head>

<body style="background-color: #0d0d0d;">

    <div class="container" style="background-color: black; margin-top: 9%">

        <form class="row g-3" method="post" action="EditUser_Validation.php" enctype="multipart/form-data">
            <div class="col-md-6">
                <label for="name" class="form-label text-light">First Name: </label>
                <!--If Condition next to Value -->
                <input type="text" name="firstname" class="form-control <?php echo (isset($_GET["firstname"])) ?  'is-invalid' : '' ?>" id="firstname" aria-describedby="validationServer00Feedback" value="<?php echo $finame; ?>">
                <?php if (isset($_GET["firstname"])) {
                    echo "<div id='validationServer00Feedback' class='invalid-feedback'>
                            Please provide a valid First Name.
                          </div>";
                } ?>
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label text-light">Last Name: </label>
                <input type="text" name="lastname" class="form-control <?php echo (isset($_GET["lastname"])) ?  'is-invalid' : '' ?>" id="lastname" aria-describedby="validationServer01Feedback" value="<?php echo $lname; ?>">
                <?php if (isset($_GET["lastname"])) {
                    echo "<div id='validationServer01Feedback' class='invalid-feedback'>
                             Please provide a valid Last Name.
                           </div>";
                }
                ?>
            </div>
            <div class="col-md-6">
                <label for="password" class="form-label text-light">Password:</label>
                <input type="password" name="password" class="form-control <?php echo (isset($_GET["password"])) ?  'is-invalid' : '' ?>" id="password" aria-describedby="validationServer02Feedback" value="<?php echo $password; ?>">
                <?php if (isset($_GET["password"])) {
                    echo "<div id='validationServer02Feedback' class='invalid-feedback'>
                            Please provide a valid Password.
                          </div>";
                }
                if (isset($_GET['invalidpassword'])) {
                    echo "<div id='validationServer0-2Feedback' class='invalid-feedback'>
                            Please provide a valid Password.
                          </div>";
                } ?>
            </div>
            <div class="col-md-6">
                <label for="password" class="form-label text-light">Confirm password:</label>
                <input type="password" name="confirmpassword" class="form-control <?php echo (isset($_GET["confirmpassword"])) ?  'is-invalid' : '' ?>" id="confirmpassword" aria-describedby="validationServer03Feedback" value="<?php echo $password; ?>">
                <?php if (isset($_GET["confirmpassword"])) {
                    echo "<div id='validationServer03Feedback' class='invalid-feedback'>
                             Please, Your Password doesn't Match!
                           </div>";
                } ?>
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label text-light">Email: </label>
                <input type="text" name="email" class="form-control <?php echo (isset($_GET["email"])) ?  'is-invalid' : '' ?>" id="email" aria-describedby="validationServer04Feedback" value="<?php echo $email; ?>">
                <?php if (isset($_GET["email"])) {
                    echo "<div id='validationServer04Feedback' class='invalid-feedback'>
                            Please provide a valid Email Address.
                          </div>";
                }
                if (isset($_GET["wrongformat"])) {
                    echo "<div id='validationServer0-4Feedback' class='invalid-feedback'>
                            Please provide a valid Email Address.                          </div>";
                } ?>
            </div>
            <div class="col-6">

                <div class="">
                    <label for="formFile" class="form-label text-light">Upload Your Photo:</label>
                    <input class="form-control <?php echo (isset($_GET["img"])) ?  'is-invalid' : '' ?>" type="file" id="formFile" name="img" aria-describedby="validationServer05Feedback">
                </div>
                <?php if (isset($_GET["img"])) {
                    echo "<div id='validationServer05Feedback' class='invalid-feedback'>
                            Please provide a valid Profile Photo.
                          </div>";
                }
                ?>
            </div>
            <button type="submit" class="col-12 btn btn-outline-light btn-lg">Update</button>
        </form>

    </div>

    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../js/AddUser.js"></script>
</body>

</html>