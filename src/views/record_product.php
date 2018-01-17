<?php
session_status();
require_once __DIR__.'/../controllers/ProductController.php';
require_once __DIR__.'/../controllers/StoreController.php';
require 'urlfy.php';



use src\controllers\ProductController;
use src\controllers\StoreController;
$productCtrl= new ProductController();
$storeCtrl = new StoreController();
$success_msg= $error_msg = '';

if( isset( $_POST['store_id'] )&& isset( $_POST['name'] )&& isset( $_POST['type'] )&&isset( $_POST['description'] )&&isset( $_POST['cost'] )&&isset( $_POST['quantity'] )){


    $store_id = $_POST['store_id'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $cost = $_POST['cost'];
    $quantity = $_POST['quantity'];
    $data = [
            "store_id"=>$store_id,
            "name"=>$name,
            "type"=>$type,
            "description"=>$description,
            "cost"=>$cost,
            "quantity"=>$quantity

    ];
    $response = $productCtrl->create($data);

    if ($response['status'] =="success"){
        $success_msg .= $response["message"];
    }elseif($response['status'] == 'error'){
        $error_msg .= $response['message'];
    }

}
else
{
    $error_msg .="All fields required";
}

$stores= $storeCtrl->all();
$products =$productCtrl->all();





?>
<!DOCTYPE HTML>
<html>
<head>
<style>
    table, th, td {
        border: 1px solid lightgrey;
    }
</style>
</head>
<body bgcolor="#f0f8ff">

<div>
    <div style="width:800px; margin:0 auto;border: 3px solid #f1f1f1;"><h3><?php include_once "admin_menu.php"?></h3></div>
    <form METHOD="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  style="width:800px; margin:0 auto;border: 3px solid #f1f1f1;">

        <div >
            <div>
                <h1>Record Product</h1>
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
            </div>
            <div>
                <label><b>Select Store</b></label>
                <?php

                ?>

                    <select name="store_id">
                        <?php foreach ($stores as $store):?>
                    <option value="<?php echo $store["id"]?>"><?php  echo $store["store_name"]?></option>
                        <?php endforeach;?>


                </select>
                <br> <br>
            </div>
            <div>
            <label><b>Product Name</b></label>
            <input type="text" placeholder="Enter Product Name" name="name" value="<?php echo isset($_GET['name'])? $_GET['name']: '' ?>"required><br/>
                <br>
            </div>

            <div>
            <label><b>Type</b></label>
            <input type="text" placeholder="Enter Product type" name="type"value="<?php echo isset($_GET['type'])? $_GET['type']: '' ?>" required>
                <br> <br>
            </div>

            <div>
                <label><b>Description</b></label>
                <textarea rows="2" cols="50" name="description" ><?php echo isset($_GET['description'])? $_GET['description']: '' ?></textarea>
                <br> <br>
            </div>
            <div>
                <label><b>Cost</b></label>
                <input type="number" placeholder="Product cost" name="cost" value="<?php echo isset($_GET['cost'])? $_GET['cost']: '' ?>"required>
                <br> <br>
            </div>
            <div>
                <label><b>Quantity</b></label>
                <input type="number" placeholder="Product Quantity" name="quantity" value="<?php echo isset($_GET['quantity'])? $_GET['quantity']: '' ?>" required>
                <br> <br>
            </div>


            <input type="submit" value="Submit">
            <?php

            if(!empty(!empty( isset($_GET['id']))))
            {

                echo '<input type="submit" name="edit" value="edit">';
            }


            ?>

        </div>

    </form>

    <table>
        <h1>Products</h1>
        <tr>
            <th>ID</th>
        <th>Product Name</th>
        <th>Type</th>
        <th>Store Name</th>
        <th>Description</th>
        <th>Cost</th>
        <th>Quantity</th>
        <th colspan="2">Action</th>
        </tr>
        <?php foreach ($products as $product): ?>
        <tr>
            <td><?php echo$product['id']?></td>
            <td><?php echo$product['name']?></td>
            <td><?php echo$product['type']?></td>
            <td><?php echo$product['store_name']?></td>
            <td><?php echo$product['description']?></td>
            <td><?php echo$product['cost']?></td>
            <td><?php echo$product['quantity']?></td>
            <td >
                <a href="record_product.php?<?php echo createUrlParams($product)?>"><button type="button">Edit</button></a></td>
            <td>
                <a href="confirm_delete.php?product_id=<?php echo $product['id']?>"><button type="button" style="color: red">Delete</button></a>
            </td>
        </tr>
        <?php endforeach;?>
    </table>



</body>
</html>