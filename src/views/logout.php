<?php
session_start();
if(session_destroy()) // Destroying All Sessions
{
    header("location: products.php"); // Redirecting To Other Page
}

