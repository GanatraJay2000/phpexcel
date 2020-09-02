<?php
session_start();
unset($_SESSION['filename']);
header('Location: index.php');
