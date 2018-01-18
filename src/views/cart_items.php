<?php
/**
 * Created by PhpStorm.
 * User: njerucyrus
 * Date: 1/18/18
 * Time: 12:38 AM
 */

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
            <tr>
                <td>Product 1</td>
                <td> 2</td>
                <td>$36.2</td>
                <td>
                    <a href="#">Edit Qty</a>
                    <a href="#" class="delete">Remove </a>
                </td>
            </tr>
            <tr>
                <td>Product 1</td>
                <td> 2</td>
                <td>$36.2</td>
                <td>
                    <a href="#">Edit Qty </a>
                    <a href="#" class="delete">Remove </a>
                </td>
            </tr>
            <tr>
                <td>Product 1</td>
                <td> 2</td>
                <td>$36.2</td>
                <td>
                    <a href="#">Edit Qty </a>
                    <a href="#" class="delete">Remove </a>
                </td>

            </tr>
        <tr style="height: 25px;">
            <td colspan="2">
                <button>Continue Shopping</button>
                &nbsp;&nbsp;

            </td>
            <td>Total Cost <span>$</span> 104</td>
            <td><button style="margin: 5px;">Checkout</button></td>
        </tr>
        </tbody>

    </table>
    </div>
</section>

</body>

</html>