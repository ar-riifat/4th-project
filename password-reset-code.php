<?php
include 'config.php';

if(isset($_POST['password_reset_link']));
{
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $token = md5(rand());

    $check_email = "SELECT email FROM registration WHERE email='$email' LIMIT 1";
    $check_email_run = mysqli_query($conn, $check_email);

    if(mysqli_num_rows($check_email_run) > 0)
    {
        $row = mysqli_fetch_array($check_email_run);
        $get_name = $row['name'];
        $get_email = $row['email'];

        $update_token = "UPDATE registration SET verify_token = '' ";
    }
    else
    {
        $_SESSION['status'] = "No  Email Found";
        header("Location: Password-reset.php");
        exit(0);
    }


}

?>