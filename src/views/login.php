<?php
require __DIR__.'/../controllers/UserController.php';
require __DIR__.'/../controllers/StoreController.php';


use src\controllers\UserController;
use src\controllers\StoreController;
$userCtrl = new UserController();
$success_msg= $error_msg = '';


if( isset( $_POST['username'] )&&isset( $_POST['password'] )){
    $username = $_POST['username'];
    $password = $_POST['password'];


    $response = $userCtrl::authenticate($username,$password);
    if ($response['status'] =="success"){
        $success_msg .= $response["message"];
        session_start();

        $_SESSION['username']=$response['data']['username']; // Initializing Session
        $_SESSION['user_type']=$response['data']['user_type']; // Initializing Session
        if($response['data']['user_type']=="admin") {
            header("location: record_product.php"); // Redirecting To Other Page
        }
        elseif($response['data']['user_type']=="customer") {
            header("location: products.php"); // Redirecting To Other Page
        }


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
            <h1>Welcome to Sarah’s Sports Boutique</h1>
            <h3>Please fill the required details to login</h3>
            <div>
                <?php
                if($success_msg!="")
                    echo $success_msg;
                elseif($error_msg!="")
                    echo $error_msg;
                ?>

            </div>

        </div>
        <div>
            <label><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" required><br/>
        </div>

        <div>
            <label><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>
        </div>


        <input type="submit" value="Submit">

    </div>

</form>
</body>
</html>