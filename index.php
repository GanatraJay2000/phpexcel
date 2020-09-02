<?php
session_start();
if (isset($_SESSION['excel_logged_in'])) {
    header('Location: dashboard.php');
} else {
    header('Location: login.php');
}
