<?php session_start();
require 'conndb.php';
$select = "SELECT filename from files;";
$selecting = $conn->query($select);
$filenames = [];
if ($selecting->num_rows > 0) {
    while ($row = $selecting->fetch_assoc()) {
        $filenames[] = $row['filename'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHPPDF</title>
    <link rel="stylesheet" href="./my_vendors/bootstrap.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Karla&display=swap" rel="stylesheet">
    <style>
        body * {
            font-family: "Karla";
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="row d-flex justify-content-end mb-4 mx-1">
            <a href="users.php" class="text-dark ml-4">All Users</a>
            <a href="register.php" class="text-dark ml-4">Register</a>
            <a href="logout.php" class="text-dark ml-4">Logout</a>
        </div>
        <div class="row">
            <div class="col-lg-6 col-12">
                <h1>New File</h1>
                <form class="form" action="logic.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="myfile">Select a file:</label>
                        <input required class="mx-3" type="file" id="myfile" name="myfile">
                    </div>
                    <div class="form-group col-7 px-0">
                        <label for="">Format</label>
                        <select name="format" id="" class="form-control">
                            <option value="2019">2019</option>
                            <option value="2018">2018</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
                <?php
                if (isset($_SESSION['error'])) {    ?>
                    <div class="message">
                        <div class="alert alert-<?php echo $_SESSION['error'][0] ?> alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['error'][1]; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-lg-6 col-12">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Serial No.</th>
                            <th>File Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($filenames as $key => $file) { ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td>
                                    <form action="logic.php" method="POST" id="filename_<?php echo $key ?>">
                                        <input type="hidden" name="filename" value="<?php echo $file ?>">
                                        <a href="javascript:$('#filename_<?php echo $key ?>').submit();"><?php echo $file ?></a>
                                    </form>
                                </td>
                                <td>
                                    <form action="delete_file.php" method="POST">
                                        <input type="hidden" name="filename" value="<?php echo $file ?>">
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
    if (isset($_SESSION['result'])) {
        if ($_SESSION['result'][0] == 1) {
            $link = $_SESSION["result"][1] . "s.html";
            echo "success<br>";
            echo "<a href='$link' target='_blank'>Open</a>";
        }
        if ($_SESSION['result'][0] == 0) {
            echo "failed";
        }
    }
    ?>

    <script src="./my_vendors/jquery.min.js"> </script>
    <script src="./my_vendors/bootstrap.min.js"> </script>
</body>

</html>

<?php unset($_SESSION['error']); ?>