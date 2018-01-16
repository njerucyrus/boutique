<?php
session_status();
require __DIR__.'/../controllers/CustomerController.php';
require __DIR__.'/../controllers/UserController.php';



use src\controllers\CustomerController;
use src\controllers\UserController;
$userCtrl = new UserController();
$customerCtrl = new CustomerController();
$success_msg= $error_msg = '';

if( isset( $_POST['username'] )&&isset( $_POST['password'] )&&$_POST['first_name'] &&isset( $_POST['last_name'] )&&isset( $_POST['address'] )&&isset( $_POST['telephone'] )&&isset( $_POST['dob'] )){

    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['user_type'];
    $data = [
        "username"=>$username,
        "password"=>$password,
        "user_type"=>"customer"
    ];
    $response = $userCtrl->create($data);

    $first_name= $_POST['first_name'];
    $last_name= $_POST['last_name'];
    $address = $_POST['address'];
    $telephone= $_POST['telephone'];
    $dob=$_POST['dob'];
    $data2 =[
        "user_id"=>$response['id'],
        "first_name"=>$first_name,
        "last_name"=>$last_name,
        "address"=>$address,
        "telephone"=>$telephone,
        "dob"=>$dob
    ];

    $response=$customerCtrl->create($data2);


    if ($response['status'] =="success"){
        $success_msg .= $response["message"];
    }elseif($response['status'] == 'error'){
        $error_msg .= $response['message'];
    }


}
else
{

    $error_msg .="All fields required";
}
?>
<!DOCTYPE HTML>
<html>

<body bgcolor="#f0f8ff">
<div>
    <div style="width:800px; margin:0 auto;border: 3px solid #f1f1f1;"><h3><?php include_once "admin_menu.php"?></h3></div>
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
            <label><b>First name</b></label>
            <input type="text" placeholder="Enter Your First Name" name="first_name" required><br/>
            <label><b>Last name</b></label>
            <input type="text" placeholder="Enter Your Last Name" name="last_name" required><br/>
        </div>

        <div>
            <label><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>
        </div>
        <div>
            <label><b>Address</b></label>
            <input type="text" placeholder="Enter Address" name="address" required><br/>
            <label><b>Telephone</b></label>
            <input type="text" placeholder="Enter Phone Number" name="telephone" required><br/>

            <label><b>Date of birth</b></label>
            <input id="dob" type="date"  name="dob" required>



        </div>

        <input type="submit" value="Submit">

    </div>

</form>
</body>
</html>