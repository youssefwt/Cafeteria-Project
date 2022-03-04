<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    
    <!-- font awesome cdn link  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/addProduct.css">
</head>
<body>
  
   
    <div class="container w-50 mt-5 border rounded-3">
      <div class="row mt-4">
      
        <form class="row" method="post" action="Product_Validation.php" enctype="multipart/form-data">
        
            <div class="col-11">
              <label for="inputProduct" class="form-label">Product</label>
              <input type="text" class="form-control" id="inputProduct" name="productName" placeholder="Tea">
              <label style="color: coral">
                <?php if (isset($_GET["productName"])) {
        echo "productName required";
    } ?>
            </div>
            <div class="col-11">
              <label for="inputPrice" class="form-label" name="Price">Price</label>
              <input type="number" class="form-control" id="inputPrice" name="Price" placeholder="5">
            </div>
           
            <div class="col-md-11">
              <label for="inputCategory" class="form-label" >Category</label>
              <select id="inputCategory" class="form-select" name="status">
                <option selected>Hot Drinks</option>
                <option>Soft Drinks</option>
              </select>
            </div>
          
            <div class="col-11">
              <label for="inputPicture" class="form-label">Product picture</label>
              <input type="file" class="form-control" id="inputPicture"  name="img" placeholder="Browse">
              <label style="color: coral">
                    <?php if (isset($_GET["file"])) {
                        echo "file doesn't match extentions<br>";
                    }
                    if (isset($_GET["wrongformat"])) {
                        echo "Invalid format";
                    } ?>
                </label>
                
              </div>
         
            <div class="col-11  btn-content">
              <button type="submit" class="btn btn-outline-primary btn1">Save</button>
              <button type="reset" class="btn btn-outline-primary btn2">Reset</button>
            </div>
          </form>
          </div>

    </div>
    
    <!-- font awesome cdn link  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> 
</body>
</html>