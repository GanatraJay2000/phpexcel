<?php
// error_reporting(0);
session_start();

if (isset($_FILES['myfile'])) {
    $_SESSION['filename'] = $_FILES['myfile']['name'];
} elseif (isset($_POST['filename'])) {
    $_SESSION['filename'] = $_POST['filename'];
}
include 'functions.php';
$data = get_data();
$students = $data[0];
$subjects = $data[1];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./my_vendors/bootstrap.min.css" />
    <link rel="stylesheet" href="./my_vendors/datatables.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <title>Logic</title>
    <style>
        .green {
            color: green;
        }

        .red {
            color: red;
        }

        .yellow {
            color: gold;
        }
    </style>
</head>

<body>

    <div class=" d-flex justify-content-between m-4">
        <a href="exit_file.php" class="btn"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
        <a class="mr-5" href="analysis.php">Analysis</a>
    </div>
    <div class="container my-5">
        <div id="filters" class="my-5 d-flex justify-content-center align-items-center">
            <select name="remark" id="remark" class="form-control col-3">
                <option value="">All </option>
                <option value="Pass">Pass</option>
                <option value="Pass*">Pass*</option>
                <option value="Fail">Fail</option>
                <option value="Absent">Absent</option>
            </select>
            <div class="mx-5" id="tableInfo"></div>
        </div>
        <?php require './table.php' ?>
    </div>

    <script src="./my_vendors/jquery.min.js"> </script>
    <script src="./my_vendors/bootstrap.min.js"> </script>
    <script src="./my_vendors/datatables.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#myTable').DataTable({
                "pageLength": 50,
                "columnDefs": [{
                    "type": "num",
                    "targets": 5
                }]
            });

            $('#remark').on('change', function() {
                table.search(this.value).draw();
                document.getElementById("tableInfo").innerHTML = table.page.info().recordsDisplay + ' Entries';
            });
        });
    </script>
</body>

</html>