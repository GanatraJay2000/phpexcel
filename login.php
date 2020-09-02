<?php
session_start();
$log_message = isset($_SESSION['log_message']) ? $_SESSION['log_message'] : ['None', 'No log_message received', false, false];
$log_message_type = $log_message[0];
$log_message_content = $log_message[1];
$username = $log_message[2];
$password = $log_message[3];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Housie | Login</title>
    <link rel="stylesheet" href="./my_vendors/bootstrap.min.css">
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

        .login-page-wrapper {
            height: 80vh;
        }
    </style>
</head>

<body>
    <?php if ($log_message_type == 'success' or $log_message_type === 'danger') { ?>
        <div class="message">
            <div class="alert alert-<?php echo $log_message_type ?> alert-dismissible fade show" role="alert">
                <?php echo $log_message_content; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    <?php } ?>
    <div class="login-page-wrapper d-flex justify-content-center align-items-center">

        <form class="col-4 text-center" action="loging_in.php" method="POST">
            <input type="hidden" name="back_to" value="login.php">
            <input type="hidden" name="go_to" value="dashboard.php">
            <h1>Login</h1>
            <div class="form-group">
                <label>Username</label>
                <input type="text" required name="username" class="form-control" value="<?php echo $username; ?>">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" required name="password" id="myPassword" class="form-control" value="<?php echo $password; ?>">
                <div class="m-1"><input type="checkbox" onclick="myFunction()">&nbsp;&nbsp;Show Password</div>
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

<?php unset($_SESSION['log_message']); ?>
<?php unset($_SESSION['logged_in']); ?>