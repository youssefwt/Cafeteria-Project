
<?php


include("dbManager.php");
$db = new DbManager();

try{
  
    $db->get_From_Table("products","name", "Price");
}catch(Exception $e){
    echo $e->getMessage();
}
?>