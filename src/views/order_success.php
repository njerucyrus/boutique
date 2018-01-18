<?php
/**
 * Created by PhpStorm.
 * User: njerucyrus
 * Date: 1/18/18
 * Time: 2:28 PM
 */

?>
<html>
<head>
    <title>Checkout Success</title>
    <style>
        #content{
            margin: 15px;
        }
    </style>
</head>
<body>

<section id="content">
    <div style="background: rgba(58,147,73,0.84)">
        <p>Your Checkout was successful your receipt no is <?php echo $_REQUEST['id'] ?> </p>
    </div>
</section>

</body>
</html>
