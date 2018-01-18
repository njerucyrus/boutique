<?php
session_start();
// initialize shopping cart class
include 'cart.php';
require_once __DIR__.'/../controllers/ProductController.php';
require_once __DIR__.'/../controllers/SalesController.php';
require_once __DIR__.'/../controllers/LeasesController.php';
use src\controllers\ProductController;
use src\controllers\SalesController;
use src\controllers\LeasesController;

$cart = new Cart();

$productCtrl = new ProductController();

if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
    if($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])){
        $productID = $_REQUEST['id'];
        // get product details
        $product = $productCtrl->getId((int) $productID);
        $itemData = array(
            'product_id' => $product['id'],
            'name' => $product['name'],
            'cost' => $product['cost'],
            'quantity' => 1,
            "customer_id"=>null,
            'receipt_no'=> null
        );

        $insertItem = $cart->insert($itemData);


        $redirectLoc = $insertItem ?'view_cart.php':'products.php';
        header("Location: ".$redirectLoc);
    }elseif($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id'])){
        $itemData = array(
            'rowid' => $_REQUEST['id'],
            'quantity' => $_REQUEST['qty']
        );
        $updateItem = $cart->update($itemData);
        echo $updateItem?'ok':'err';die;
    }elseif($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id'])){
        $deleteItem = $cart->remove($_REQUEST['id']);
        header("Location: view_cart.php");
    }elseif($_REQUEST['action'] == 'buy' && $cart->total_items() > 0 && !empty($_SESSION['sessCustomerID'])){

            $receiptNo = SalesController::generateReceiptNo();
            // get cart items
            $cartItems = $cart->contents();
            $checkoutItems = [];
            foreach($cartItems as $item){
                $item['customer_id'] = (int)$_SESSION['sessCustomerID'];

                $item['receipt_no'] = $receiptNo;

                array_push($checkoutItems, $item);

            }

            // insert order items into database
            $salesCtrl = new SalesController();
            $checkoutStatus = $salesCtrl->checkout($checkoutItems);
            //print_r($checkoutStatus);

            if($checkoutStatus){
                $cart->destroy();
                header("Location: order_success.php?id=$receiptNo");
            }else{
                header("Location: checkout.php");
            }


    }
    elseif($_REQUEST['action'] == 'lease'
        && $cart->total_items() > 0 && !empty($_SESSION['sessCustomerID'])){

        $receiptNo = LeasesController::generateReceiptNo();
        // get cart items
        $cartItems = $cart->contents();
        $checkoutItems = [];
        foreach($cartItems as $item){
            $item['customer_id'] = (int)$_SESSION['sessCustomerID'];
            $item['receipt_no'] = $receiptNo;
            array_push($checkoutItems, $item);

        }

        // insert order items into database
        $leaseCtrl = new LeasesController();
        $checkoutStatus = $leaseCtrl->checkout($checkoutItems);

        if($checkoutStatus){
            $cart->destroy();
            header("Location: order_success.php?id=$receiptNo");
        }else{
            header("Location: checkout.php");
        }
    }

    else{
        header("Location: products.php");
    }
}else{
    header("Location: products.php");
}