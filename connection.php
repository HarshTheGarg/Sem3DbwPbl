<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function openCon()
{
    $host = "localhost";
    $user = "root";
    $pass = "password 3";
    $db = "project";
    $con = mysqli_connect($host, $user, $pass, $db);
    if ( !$con or mysqli_connect_errno() ) {
        echo "Some error! < /br> </br>";
        header("Location: http://localhost/dbw/project/index.php?connected=false");
    }
    else {
        return $con;
    }
}
?>