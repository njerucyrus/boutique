<?php
?>
<div>

    <a href="products.php" style="text-decoration:none">Sarah’s Sports Boutique (SSB) Ltd</a>
    <a href="products.php">Home</a> |

    <a href="register_customer.php">Register</a> |

    <a href="#">Check out</a>


    <?php
    if(!isset($login_session)){

        ?>

        <a href="login.php">Login</a> |
        <?php
    }
    else {
        ?>
        <a href="logout.php">Logout</a> |
        <?php
    }
    ?>
</div>
