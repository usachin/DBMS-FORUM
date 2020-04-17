<?php
//connect.php
$server = 'localhost';
$username   = 'root';
$password   = '';
$database   = 'forum';



 $conn = new mysqli($server,$username,$password,$database) or die("unable to connect");

?>