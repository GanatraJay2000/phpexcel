<?php
require 'conndb.php';
$select = "SELECT * FROM users";
$selecting = $conn->query($select);
$username = [];
if ($selecting->num_rows > 0) {
    while ($row = $selecting->fetch_assoc()) {
        $username[] = $row['username'];
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="./my_vendors/bootstrap.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Karla&display=swap" rel="stylesheet">
    <style>
        body * {
            font-family: "Karla";
        }

        body>.container {
            height: 80vh;
        }
    </style>
</head>

<body>
    <a href="dashboard.php" class="btn"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>

    <div class="container d-flex justify-content-center align-items-center text-center">
        <div>
            <h1 class="mb-3">Users</h1>
            <div class="text-left">
                <?php

                foreach ($username as $key => $user) {
                ?>
                    <div><?php echo $key + 1 . ". &nbsp;" . ucfirst($user); ?></div>

                <?php
                }
                ?>
            </div>

        </div>
    </div>
</body>

</html>