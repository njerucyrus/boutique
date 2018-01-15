<?php

require __DIR__.'/../controllers/StoreController.php';


use src\controllers\UserController;
use src\controllers\StoreController;

$storeCtrl= new StoreController();
$success_msg= $error_msg = '';

if( isset( $_POST['store_name'] )&&isset( $_POST['address'] )){
    $store_name = $_POST['store_name'];
    $address = $_POST['address'];

    $data = [
            "store_name"=>$store_name,
            "address"=>$address

    ];
    $response = $storeCtrl->create($data);
    if ($response['status'] =="success"){
        $success_msg .= $response["message"];
    }elseif($response['status'] == 'error'){
        $error_msg .= $response['message'];
    }

}
?>
<!DOCTYPE HTML>
<html>

<body bgcolor="#f0f8ff">


    <form METHOD="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  style="width:800px; margin:0 auto;border: 3px solid #f1f1f1;">

        <div >
            <div>
                <h1>Register Store</h1>
                <div>
                    <?php
                    if($success_msg!="")
                        echo $success_msg;
                    elseif($error_msg!="")
                        echo $success_msg;
                    ?>

                </div>
            </div>
            <div>
            <label><b>Store Name</b></label>
            <input type="text" placeholder="Enter Store Name" name="store_name" required><br/>
            </div>
<br><br>
            <div>
            <label><b>Address</b></label>
            <input type="address" placeholder="Enter store address" name="address" required>
            </div>
            <br><br>
            <input type="submit" value="Submit">

        </div>

    </form>
</body>
</html>