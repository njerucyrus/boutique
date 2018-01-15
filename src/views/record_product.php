<?php

require_once __DIR__.'/../controllers/ProductController.php';
require_once __DIR__.'/../controllers/StoreController.php';




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
            "store_id12"=>$store_id,
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

$stores= $storeCtrl->all();
?>
<!DOCTYPE HTML>
<html>
<head>

</head>
<body bgcolor="#f0f8ff">


    <form METHOD="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  style="width:800px; margin:0 auto;border: 3px solid #f1f1f1;">

        <div >
            <div>
                <h1>Record Product</h1>
                <div>
                    <?php
                    if($success_msg!="")
                        {echo $success_msg;}
                    elseif($error_msg!="")
                    { echo $error_msg;}
                    ?>


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
            <input type="text" placeholder="Enter Product Name" name="name" required><br/>
                <br>
            </div>

            <div>
            <label><b>Type</b></label>
            <input type="type" placeholder="Enter Product type" name="type" required>
                <br> <br>
            </div>

            <div>
                <label><b>Description</b></label>
                <textarea rows="2" cols="50" name="description"></textarea>
                <br> <br>
            </div>
            <div>
                <label><b>Cost</b></label>
                <input type="type" placeholder="Product cost" name="cost" required>
                <br> <br>
            </div>
            <div>
                <label><b>Quantity</b></label>
                <input type="type" placeholder="Product Quantity" name="quantity" required>
                <br> <br>
            </div>


            <input type="submit" value="Submit">

        </div>

    </form>
</body>
</html>