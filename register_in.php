<?php
session_start();
require 'conndb.php';

$back_to = $_POST['back_to'];
$go_to = $_POST['go_to'];
$username = $_POST['username'];
$username = strtolower($username);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$reg_message_content = '';
$reg_message_type = '';


if ($password === $confirm_password) {
    $select = "SELECT * FROM users WHERE username='$username'";
    $selecting = $conn->query($select);
    if ($selecting->num_rows > 0) {
        $reg_message_type = "danger";
        $reg_message_content = "User Already Exists !";
    } else {
        $insert = "INSERT INTO users(username, password) VALUES('$username', '$password')";
        $inserting = $conn->query($insert);
        $reg_message_type = "success";
        $reg_message_content = "$username was registered Successfully";
    }
} else {
    $reg_message_type = "danger";
    $reg_message_content = "Passwords Do not Match !";
}



$reg_message = [$reg_message_type, $reg_message_content, $username, $password, $confirm_password];
$_SESSION['reg_message'] = $reg_message;
if ($reg_message_type === 'danger') {
    header('Location: ' . $back_to);
} else if ($reg_message_type === 'success') {
    header('Location: ' . $go_to);
}
