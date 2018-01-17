<?php
error_reporting(0);
session_status();
require_once __DIR__.'/../controllers/ProductController.php';
require_once __DIR__.'/../controllers/userController.php';

use src\controllers\ProductController;
use src\controllers\UserController;

$productController = new ProductController();
$userController = new UserController();

$user_id=$_GET['user_id'];

$product_id=$_GET['product_id'];
$success_msg= $error_msg = '';

if(isset($_POST['submit'])=="Yes")
{

    if(isset($user_id))
    {
        $response = $userController->delete((int)$user_id);

        if ($response['status'] == "success") {
            $success_msg .= $response["message"];
            header("refresh:3;url=register_user.php");
        } elseif ($response['status'] == 'error') {
            $error_msg .= $response['message'];
        }
    }
    if(isset($product_id))
    {
        $response = $productController->delete((int)$product_id);

        if ($response['status'] == "success") {
            $success_msg .= $response["message"];
            header("refresh:3;url=record_product.php");
        } elseif ($response['status'] == 'error') {
            $error_msg .= $response['message'];
        }
    }
}



?>
<!DOCTYPE HTML>
<html>
<head>

</head>
<body bgcolor="#f0f8ff">
<div>
    <div style="width:800px; margin:0 auto;border: 3px solid #f1f1f1;"><h3><?php include_once "customer_menu.php"?></h3></div>
</div>
<div>
    <div>
        <h3>
            <?php
            if($success_msg!="")
            {echo $success_msg;}
            elseif($error_msg!="")
            { echo $error_msg;}
            ?>
        </h3>

    </div>
    <H1>Do your really want to delete this?</H1>
    <form method="POST"  action="">

        <input id="submit" name="submit" type="submit" value="Yes">

        <input type="button" value="Cancel" onclick="history.back()">
    </form>
</div>
</body>
</html>