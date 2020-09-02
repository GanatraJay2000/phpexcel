<?php

function get_data()
{
    require 'conndb.php';
    if (isset($_FILES['myfile']['name'])) {
        $filename = $_FILES['myfile']['name'];
        $format = $_POST['format'];
        $_SESSION['filename'] = $filename;

        $select = "SELECT filename FROM files WHERE filename='$filename'";
        $selecting = $conn->query($select);
        if ($selecting->num_rows < 1) {

            if ($format == '2019') {
                $data = get_data_2019();
            } elseif ($format == '2018') {
                $data = get_data_2018();
            }
            $students = $data[0];
            $subjects = $data[1];
            insert_into_database($filename, $students, $subjects);
        } else {
            $data = extract_from_database($filename);
        }
    } elseif (isset($_POST['filename'])) {
        $filename = $_POST['filename'];
        $_SESSION['filename'] = $filename;
        $data = extract_from_database($filename);
    } else {
        $filename = $_SESSION['filename'];
        $data = extract_from_database($filename);
    }
    $error = '';
    // $error = error_get_last();
    if ($error != '') {
        if ($error['type'] == '8') {
            customError();
        }
    }

    return $data;
}




function get_data_2019()
{
    require 'student.php';
    $inputFile = $_FILES['myfile']['tmp_name'];
    $subjectsIndex = 1;
    $firstStudentIndex = 6;
    $numberOfStudents = 73;
    --$firstStudentIndex;

    $text = extracted_data($inputFile);
    $subjects = $text[$subjectsIndex];
    $students = [];
    for ($i = $firstStudentIndex; $i < $firstStudentIndex + $numberOfStudents; $i++) {
        if (!isset($text[$i])) {
            break;
        }
        $identity = [$text[$i][2]];
        $result = [$text[$i][6], $text[$i][90], $text[$i][5],  $text[$i][88], $text[$i][89]];
        $evaluation = [];
        for ($j = 7; $j <= 87; $j++) {
            array_push($evaluation, $text[$i][$j]);
        }
        $evaluation = array_chunk($evaluation, 9);
        $name = explode(" ", $text[$i][4]);
        $name = array_filter($name);
        $name = array_values($name);
        array_push($identity, ...$name);
        array_push($identity, $text[$i][0]);
        $details = [$identity, $result, $evaluation];
        $student = new Student($details);
        array_push($students, $student);
    }
    $data = array($students, $subjects);
    return $data;
}
function get_data_2018()
{
    require 'student.php';
    $inputFile = $_FILES['myfile']['tmp_name'];
    $number_of_students = 90;
    $height_of_block = 5;
    $start = 8;
    --$start;
    $length = ($number_of_students * 5);

    $students = [];
    $data = extracted_data($inputFile);
    array_pop($data);
    $subjects = $data[5];
    $output = array_slice($data, $start, $length);
    foreach ($output as $key => $out) {
        array_shift($output[$key]);
        $output[$key] = array_values($output[$key]);
    }
    function array_move(&$a, $oldpos, $newpos)
    {
        if ($oldpos == $newpos) {
            return;
        }
        array_splice($a, max($newpos, 0), 0, array_splice($a, max($oldpos, 0), 1));
    }
    for ($i = 0; $i < count($output); $i = $i + 5) {
        $identity = array_shift($output[$i]);
        $identity = str_replace("/", "", $identity);
        $identity = str_replace("\n", " ", $identity);
        $identity = explode(" ", $identity);
        array_move($identity, count($identity) - 1, 0);
        $identity = array_filter($identity);
        $result = array_pop($output[$i]);
        array_splice($output[$i], 0, 1);
        $result = str_replace("\n", " ", $result);
        $result = explode(" ", $result);
        $result = array_filter($result);

        array_move($result, 1, 0);
        array_move($result, 4, 1);
        $j = 0;
        $k = 0;
        $evaluation = [];
        for ($l = 0; $l < (count($output[$i]) + count($output[$i + 1]) - 1); $l = $l + 2) {
            $evaluation[$l] = $output[$i][$j];
            $evaluation[$l + 1] = $output[$i + 1][$k];
            $j++;
            $k++;
        }
        $evaluation = array_chunk($evaluation, 6);
        foreach ($evaluation as $key => $eval) {
            array_push($evaluation[$key], $output[$i + 2][$key]);
            array_push($evaluation[$key], $output[$i + 3][$key]);
            array_push($evaluation[$key], $output[$i + 4][$key]);
        }
        $details = [$identity, $result, $evaluation];
        $student = new Student($details);
        array_push($students, $student);
    }
    $data = array($students, $subjects);
    return $data;
}





function extracted_data($inputFile)
{
    require 'vendor/autoload.php';
    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
    $reader->setReadDataOnly(TRUE);
    $spreadsheet = $reader->load($inputFile);
    $worksheet = $spreadsheet->getActiveSheet();
    $highestRow = $worksheet->getHighestRow(); // e.g. 10
    $highestColumn = $worksheet->getHighestColumn();
    $lastcell = $highestColumn . $highestRow;
    $dataArray = $spreadsheet->getActiveSheet()->rangeToArray('A1:' . $lastcell, NULL, TRUE, TRUE, TRUE);

    $dataArray = array_filter($dataArray);
    $dataArray = array_values($dataArray);
    foreach ($dataArray as $key => $dataarr) {
        $dataArray[$key] = array_filter($dataArray[$key]);
        $dataArray[$key] = array_values($dataArray[$key]);
    }
    return $dataArray;
}




function  insert_into_database($filename, $students, $subjects)
{
    require 'conndb.php';
    $students = json_encode($students);
    $subjects = json_encode($subjects);
    $insert = "INSERT INTO files (filename, text, subjects) VALUES('$filename', '$students', '$subjects')";
    $inserting = $conn->query($insert);
}
function extract_from_database($filename)
{
    require 'conndb.php';
    $select = "SELECT * FROM files WHERE filename='$filename';";
    $selecting = $conn->query($select);
    if ($selecting->num_rows == 1) {
        while ($row = $selecting->fetch_assoc()) {
            $students = json_decode($row['text']);
            $subjects = json_decode($row['subjects']);
        }
    }
    $data = array($students, $subjects);
    return $data;
}

function delete_from_database($filename)
{
    require 'conndb.php';
    $delete = "DELETE FROM files where filename='$filename'";
    $seleting = $conn->query($delete);
}

function print_this($data)
{

    foreach ($data as $value) {
        print_r($value);
        echo " <br><br>";
    }
}
function print_line($dataq)
{
    foreach ($dataq as $value) {
        print_r($value);
        echo ",  ";
    }
}



function customError()
{
    $filename = $_FILES['myfile']['name'];
    print_r($filename);
    delete_from_database($filename);
    $_SESSION['error'] = ["danger", "A problem occured during the extraction of data! <br> Please check if file matches the format properly !!"];
    header('Location: dashboard.php');
}
