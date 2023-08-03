

<?php
session_start();
include "config.php";

if(isset($_POST['register_btn']))
{
$name = $_POST['name'];
$phone =  $_POST['phone'];
$email = $_POST['email'];
$password = $_POST['password'];

$check_email_query = "SELECT db_email FROM users WHERE email= '$db_email' LIMIT 1";
$check_email_query_run = mysqli_query($conn, $check_email_query);

if(mysqli_num_rows($check_email_query_run) > 0)
{
    $_SESSION['status'] = "Email id already Exists";
    header("Location: register.php");
}
 else{
    $insert_query ="INSERT INTO `registered`(`db_fullName`, `db_username`, `db_email`, `db_dob`, `db_mobile`, `db_pass`, `db_gender`) VALUES ('$r_fullName','$r_username','$r_email','$r_dob','$r_mobile','$r_pass','$r_gender')";
    $insert_query_run = mysqli_query($conn,$insert_query);
    if($insert_query_run)
    {
        sendemail_verify
        $_SESSION['status'] = "Registerd Successful..! Please Verify your Email Address..";
        header("Location: register.php");
    } else {
        $_SESSION['status'] = "Registration Failed";
        header("Location: register.php");
    }
 
}


}

?>