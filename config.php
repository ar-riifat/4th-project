<?php
$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "4th-project";

$conn = mysqli_connect($serverName, $userName, $password, $dbName);

if(!$conn){
    die("connection failed!!". mysqli_connect_error($conn));
}
else{
    echo "Connection was successful";
    
}
?> 





