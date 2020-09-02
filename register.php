<?php
session_start();
$reg_message = isset($_SESSION['reg_message']) ? $_SESSION['reg_message'] : ['None', 'No reg_message received', false, false, false];
$reg_message_type = $reg_message[0];
$reg_message_content = $reg_message[1];
$username = $reg_message[2];
$password = $reg_message[3];
$confirm_password = $reg_message[4];
if ($reg_message_type == 'success') {
    $username = false;
    $password = false;
    $confirm_password = false;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Housie | Register</title>
    <link rel="stylesheet" href="./my_vendors/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Karla&display=swap" rel="stylesheet">

    <style>
        body {
            padding: 30px;
        }

        body * {
            font-family: "Karla";
        }

        .message {
            position: absolute;
            top: 10px;
            width: 500px;
            left: calc(50% - 250px);
        }
    </style>
</head>

<body>
    <a href="dashboard.php" class="btn"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>

    </div>
    <?php if ($reg_message_type == 'success' or $reg_message_type === 'danger') { ?>
        <div class="message">
            <div class="alert alert-<?php echo $reg_message_type ?> alert-dismissible fade show" role="alert">
                <?php echo $reg_message_content;
                if ($reg_message_type == 'success') {
                    echo " &nbsp;<a href='login.php'>Login</a>";
                }
                ?>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    <?php } ?>
    <div class="login-page-wrapper d-flex justify-content-center">

        <form class="col-4 text-center" action="register_in.php" method="POST">
            <input type="hidden" name="back_to" value="register.php">
            <input type="hidden" name="go_to" value="register.php">
            <h1 class="mb-3">Register</h1>
            <div class="form-group">
                <label>Username</label>
                <input type="text" required name="username" class="form-control" value="<?php echo $username; ?>">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" required name="password" id="myPassword" class="form-control" value="<?php echo $password; ?>">
                <div class="m-1"><input type="checkbox" onclick="myFunction()">&nbsp;&nbsp;<small>Show Password</small>
                </div>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" required name="confirm_password" id="myConfirmPassword" class="form-control" value="<?php echo $confirm_password; ?>">
                <div class="m-1"><input type="checkbox" onclick="myConfirmFunction()">&nbsp;&nbsp;<small>Show
                        Password</small></div>
            </div>
            <div>
                <button class="btn btn-success">Login</button></div>
        </form>
    </div>
    <script src="./my_vendors/jquery.min.js"></script>
    <script src="./my_vendors/bootstrap.min.js"></script>
    <script>
        function myFunction() {
            var x = document.getElementById("myPassword");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        function myConfirmFunction() {
            var x = document.getElementById("myConfirmPassword");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>

</html>

<?php unset($_SESSION['reg_message']); ?>