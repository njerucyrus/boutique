<?php
require_once __DIR__.'/../controllers/ProductController.php';

use src\controllers\ProductController;

$productController = new ProductController();
$products= $productController->all();

?>
<!DOCTYPE HTML>
<html>
<head>

</head>
<body bgcolor="#f0f8ff">
<div>
<table style="width:800px; margin:0 auto;border: 3px solid #f1f1f1;">
    <?php foreach ($products as $product):?>
    <tr>
        <td><img src="photos/images.jpg"  ></td>

        <td align="left"><div><b>Name:</b> <?php echo $product['name']?><br><br></div>
        <div><b>Store Name:</b> <?php echo $product['store_name']?><br><br></div>
        <div><b>Description</b><br><?php echo $product['description']?><br><br></div>
        <div><b>Price:</b> $ <?php echo $product['cost']?><br><br></div>
            <div><a href="register_user.php">Buy</div>
            <div><a href="register_user.php">Lease</div>

        </td>

    </tr>
    <?php endforeach; ?>
</table>
</div>
</body>
</html>