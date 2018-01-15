<?php
require __DIR__.'/../controllers/UserController.php';
require __DIR__.'/../controllers/StoreController.php';


use src\controllers\UserController;
use src\controllers\StoreController;
$userCtrl = new UserController();
$success_msg= $error_msg = '';


if( isset( $_POST['username'] )&&isset( $_POST['password'] )&&isset( $_POST['user_type'] )){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['user_type'];
    $data = [
            "username"=>$username,
            "password"=>$password,
            "user_type"=>$userType
    ];
    $response = $userCtrl->create($data);
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
                <h1>Register user</h1>
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
            <label><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" required><br/>
            </div>

            <div>
            <label><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>
            </div>
            <div>
                <label><b>User Type</b></label>

                <select name="user_type">
                    <option value="admin">Admin</option>
                    <option value="customer">customer</option>

                </select>
            </div>

            <input type="submit" value="Submit">

        </div>

    </form>
</body>
</html>