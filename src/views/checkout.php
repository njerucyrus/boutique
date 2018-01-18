<?php
require_once __DIR__.'/../controllers/UserController.php';
use src\controllers\UserController;
include 'cart.php';

$cart = new Cart();
$cartItems = $cart->contents();

$customer = UserController::getAssociatedCustomer($_SESSION['user_id']);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Cart Items| Checkout</title>
    <style>
        #cart_items{
            margin: 15px;
        }
        .cart{
            font-size: 16px;
            width: 80%;
        }
        tr,th{
            border: 5px;
            font-size: 16px;
            text-align: justify;

        }
        ul li{
            list-style: none;
            font-size: 16px;
        }
        .delete{
            color: rgba(151,35,16,0.78);
            margin: 5px;
            padding: 5px;
        }
    </style>
</head>
<body bgcolor="#5f9ea0">
<section id="cart_items">
    <div class="cart">
        <h3>Shopping Cart</h3>
        <table id="cart_item_table" border="2px" width="80%">
            <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Action</th>

            </tr>
            </thead>
            <tbody>
            <?php foreach ($cartItems as $cartItem):?>
                <tr>
                    <td><?php echo $cartItem['name']?></td>
                    <td><?php echo $cartItem['quantity'] ?></td>
                    <td>$<?php echo $cartItem['subtotal']?></td>

                    <td>
                        <a href="cart_action.php?action=removeCartItem&id=<?php echo $cartItem['rowid']; ?>" onclick="return confirm('Are you sure?')">
                            <button>Remove</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">
                        <aside>
                            <div>
                                <h3>Customer Shipping Info</h3>
                                <ul>
                                    <li>Name: <?php echo $customer['first_name']. " ". $customer['last_name'] ?> </li>
                                    <li>Address: <?php echo "{$customer['address']}" ?> </li>
                                    <li>Telephone: <?php echo "{$customer['telephone']}"?></li>
                                    <li><a href="cart_action.php?action=buy" style="color: white;">Buy Products</a> </li>
                                    <li><a href="cart_action.php?action=lease" style="color: darkred">Lease Products</a> </li>
                                </ul>
                            </div>
                        </aside>
                    </td>
                </tr>
            </tfoot>
        </table>

    </div>
</section>

</body>

</html>
