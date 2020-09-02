<?php
session_start();
require 'conndb.php';
// Variables
$back_to = $_POST['back_to'];
$go_to = $_POST['go_to'];
$username = $_POST['username'];
$username = strtolower($username);
$password = $_POST['password'];
print_r($password);
$log_message_content = '';
$log_message_type = '';

$select = "SELECT * FROM users WHERE username = '$username'";
$selecting = $conn->query($select);
if ($selecting) {
    if ($selecting->num_rows > 0) {
        while ($row = $selecting->fetch_assoc()) {
            $c_password = $row['password'];
            print_r($c_password);
            if ($password === $c_password) {
                $log_message_type = "success";
                print_r($log_message_type);
                $_SESSION['excel_logged_in'] = $username;
            } else {
                $log_message_content = "Credentials do not match!";
                $log_message_type = "danger";
                print_r($log_message_type);
            }
        }
    } else {
        $log_message_content = "User not present!";
        $log_message_type = "danger";
    }
} else {
    $log_message_content = "Error! Try after some time. Please contact admin !";
    $log_message_type = "danger";
}

$log_message = [$log_message_type, $log_message_content, $username, $password];
$_SESSION['log_message'] = $log_message;
print_r($log_message_type);
print_r($go_to);
print_r($back_to);
print_r($_SESSION['logged_in']);
if ($log_message_type == 'danger') {
    header('Location: ' . $back_to);
} elseif ($log_message_type == 'success') {
    header('Location: ' . $go_to);
}
