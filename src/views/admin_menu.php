<?php

?>
<div>
    <a href="products.php" style="text-decoration:none">Sarah’s Sports Boutique (SSB) Ltd</a><br>
    <a href="products.php">Home</a> |
    <a href="register_user.php">Register User</a> |
    <a href="record_product.php">Record Product</a> |
    <a href="record_store.php">Record Store</a> |
    <a href="register_customer.php">Register Customer</a> |

    <?php
    if(!isset($login_session)){

    ?>
        <a href="logout.php">Logout</a>

    <?php
    }
    else
?>




</div>
