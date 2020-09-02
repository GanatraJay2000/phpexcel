<?php
require 'conndb.php';
$filename = $_POST['filename'];

$delete = "DELETE FROM files WHERE filename='$filename'";
$deleting = $conn->query($delete);
header('Location: index.php');
