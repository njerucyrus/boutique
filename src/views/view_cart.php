<?php

include 'cart.php';
$cart = new Cart();
$cartItems = $cart->contents();
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

        <tr style="height: 25px;">
            <td colspan="2">
                <a href="products.php">Continue Shopping</a>
                &nbsp;&nbsp;
            </td>
            <td>Total Cost <span>$</span><?php echo $cart->total() > 0 ? $cart->total(): 0.0; ?></td>
            <td><a href="checkout.php"><button style="margin: 5px;">Checkout</button></a></td>
        </tr>
        </tbody>

    </table>
    </div>
</section>

</body>

</html>