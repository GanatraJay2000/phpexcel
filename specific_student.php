<?php
$student = json_decode(htmlspecialchars_decode($_POST['student']));
$subjects = json_decode(htmlspecialchars_decode($_POST['subjects']));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $student->identity[0] ?></title>
    <link rel="stylesheet" href="./my_vendors/bootstrap.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Karla&display=swap" rel="stylesheet">
    <style>
        body * {
            font-family: "Karla";
        }
    </style>
    <script defer src="./my_vendors/jquery.min.js"> </script>
    <script defer src="./my_vendors/bootstra`p.min.js"> </script>

</head>

<body>
    <a href="<?php echo isset($_POST['back_to']) ? $_POST['back_to'] : "logic.php" ?>" class="btn"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>

    <div class="container my-5">
        <h1 style="text-decoration:underline;"><?php echo $student->identity[2] . " " . $student->identity[1]; ?></h1>
        <div class="row mt-5">
            <div class="col-3"><b><?php echo "Seat No: " . $student->identity[0] ?></b></div>
            <?php if (isset($student->identity[5])) { ?>
                <div class="col-3"><b><?php echo "GR No: " . $student->identity[5] ?></b></div>
            <?php } ?>
        </div>
        <div class="row mt-3">
            <div class="col-3"><?php echo "First Name: " . $student->identity[2] ?></div>
            <div class="col-3"><?php echo "Father's Name: " . $student->identity[3] ?></div>
            <div class="col-3"><?php echo "Last Name: " . $student->identity[1] ?></div>
            <?php  ?>
            <div class="col-3">Mother's Name:
                <?php if (isset($student->identity[4])) {
                    echo "" . $student->identity[4];
                } ?>
            </div>

        </div>
        <div class="mt-3"><b><?php echo "Result: " . $student->result[0]; ?></b></div>
        <div class="mt-3"><?php echo "GPA: " . $student->result[1]; ?></div>
        <div class="mt-3"><?php echo "Total: " . $student->result[2]; ?></div>
        <div class="mt-3"><?php echo "Credits: " . $student->result[3]; ?></div>
        <div class="mt-5">
            <h3>Subjectwise Marks and Grades</h3>
            <?php for ($key = 0; $key < 5; $key++) { ?>
                <h6 class="mt-4"><?php echo $subjects[$key]; ?></h6>
                <div class="row mt-3">
                    <div class="col-3">
                        <div style="text-decoration:underline"><b>Term Test</b></div>
                        <div><?php echo "Marks: " . $student->evaluation[$key][0] ?></div>
                        <div><?php echo "Grades: " . $student->evaluation[$key][1] ?></div>
                    </div>
                    <div class="col-3">
                        <div style="text-decoration:underline"><b>Unit Test</b></div>
                        <div><?php echo "Marks: " . $student->evaluation[$key][2] ?></div>
                        <div><?php echo "Grades: " . $student->evaluation[$key][3] ?></div>
                    </div>
                    <div class="col-3">
                        <div style="text-decoration:underline"><b>Total</b></div>
                        <div><?php echo "Marks: " . $student->evaluation[$key][4] ?></div>
                        <div><?php echo "Grades: " . $student->evaluation[$key][6] ?></div>
                    </div>
                    <div class="col-3">
                        <div style="text-decoration:underline"><b>Points</b></div>
                        <div><?php echo "CP: " . $student->evaluation[$key][5] ?></div>
                        <div><?php echo "GP: " . $student->evaluation[$key][7] ?></div>
                        <div><?php echo "C*GP: " . $student->evaluation[$key][8] ?></div>
                    </div>
                </div>
            <?php } ?>
            <h3 class="mt-5">Labwise Marks and Grades</h3>
            <?php for ($key = 5; $key < count($subjects); $key++) { ?>
                <h6 class="mt-4"><?php echo $subjects[$key]; ?></h6>
                <div class="row mt-3">
                    <div class="col-3">
                        <div style="text-decoration:underline"><b>Term Test</b></div>
                        <div><?php echo "Marks: " . $student->evaluation[$key][0] ?></div>
                        <div><?php echo "Grades: " . $student->evaluation[$key][1] ?></div>
                    </div>
                    <div class="col-3">
                        <div style="text-decoration:underline"><b>Unit Test</b></div>
                        <div><?php echo "Marks: " . $student->evaluation[$key][2] ?></div>
                        <div><?php echo "Grades: " . $student->evaluation[$key][3] ?></div>
                    </div>
                    <div class="col-3">
                        <div style="text-decoration:underline"><b>Total</b></div>
                        <div><?php echo "Marks: " . $student->evaluation[$key][4] ?></div>
                        <div><?php echo "Grades: " . $student->evaluation[$key][6] ?></div>
                    </div>
                    <div class="col-3">
                        <div style="text-decoration:underline"><b>Points</b></div>
                        <div><?php echo "CP: " . $student->evaluation[$key][5] ?></div>
                        <div><?php echo "GP: " . $student->evaluation[$key][7] ?></div>
                        <div><?php echo "C*GP: " . $student->evaluation[$key][8] ?></div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>