<?php
session_start();
require 'config.php'; // Assuming you define $conn here

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function send_password_link($get_name, $get_email, $token)
{
    $mail = new PHPMailer();
    // ... Your email configuration

    $email_template = "
    <h2>Hello</h2>
    <h4>You are receiving this email because we received a password reset request for your account</h4>
    <br><br>
    <a href='" . BASE_URL . "/Password-reset.php?token=$token&email=$get_email'>Click Me</a>
";

    $mail->Body = $email_template;
    $mail->send();
}

if (isset($_POST['password_reset_link'])) {
    // ... Your password reset link logic

    if ($update_token_run) {
        send_password_link($get_name, $get_email, $token);
        $_SESSION['status'] = "We e-mailed you a password reset link";
        header("Location: Password-reset.php");
        exit(0);
    } else {
        $_SESSION['status'] = "Something went Wrong. #1";
        header("Location: Password-reset.php");
        exit(0);
    }
}

if (isset($_POST['password_update'])) {
    // ... Your password update logic

    if (!empty($email)) {
        if (!empty($token) && !empty($new_password) && !empty($confirm_password)) {
            $check_token = "SELECT verify_token FROM registration WHERE verify_token='$token' LIMIT 1";
            $check_token_run = mysqli_query($conn, $check_token);

            if (mysqli_num_rows($check_token_run) > 0) {
                if ($new_password == $confirm_password) {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_password = "UPDATE registration SET password='$hashed_password' WHERE verify_token='$token' LIMIT 1";
                    $update_password_run = mysqli_query($conn, $update_password);

                    if ($update_password_run) {
                        $new_token = md5(rand()) . "anis";
                        $update_to_new_token = "UPDATE registration SET verify_token='$new_token' WHERE verify_token='$token' LIMIT 1";
                        $update_to_new_token_run = mysqli_query($conn, $update_to_new_token);

                        $_SESSION['status'] = "New Password Successfully Updated!!";
                        header("Location: login.php");
                        exit(0);
                    } else {
                        $_SESSION['status'] = "Did not update password. Something went wrong!!";
                        header("Location: Password-change.php?token=$token&email=$email");
                        exit(0);
                    }
                } else {
                    $_SESSION['status'] = "Password & Confirm Password do not match";
                    header("Location: Password-change.php?token=$token&email=$email");
                    exit(0);
                }
            } else {
                $_SESSION['status'] = "Invalid Token";
                header("Location: Password-change.php?token=$token&email=$email");
                exit(0);
            }
        } else {
            $_SESSION['status'] = "All Fields are Mandatory!!";
            header("Location: Password-change.php?token=$token&email=$email");
            exit(0);
        }
    } else {
        $_SESSION['status'] = "No Token Available";
        header("Location: Password-reset.php");
        exit(0);
    }
}
?>
