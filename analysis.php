<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Analysis</title>
   <link rel="stylesheet" href="./my_vendors/bootstrap.min.css" />
   <link rel="stylesheet" href="./my_vendors/datatables.css" />
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
   <link rel="stylesheet" href="./my_vendors/modal.css">
   <link rel="stylesheet" href="./my_vendors/scrollbar.css">
   <link href="https://fonts.googleapis.com/css2?family=Karla&display=swap" rel="stylesheet">
   <style>
      body {
         padding: 30px;
      }

      body * {
         font-family: "Karla", serif;
      }
   </style>
</head>

<body>
   <a href="logic.php" class="btn"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>

   <?php
   require 'conndb.php';
   echo "<br><br><br>";
   $filename = $_SESSION['filename'];
   $select = "SELECT * FROM files WHERE filename='$filename';";
   $selecting = $conn->query($select);
   if ($selecting->num_rows > 0) {
      while ($row = $selecting->fetch_assoc()) {
         $dbsubjects = $row['subjects'];
         $dbstudents = $row['text'];
      }
   }
   $dbstudents = json_decode($dbstudents);
   $dbsubjects = json_decode($dbsubjects);
   $data = array($dbstudents, $dbsubjects);
   $students = $data[0];
   $subjects = $data[1];

   echo "<h1  class='text-center' >1.  Pass-Fail Percentage</h1>";
   $count_pass = 0;
   $count_fail = 0;
   $total_students = count($students);
   foreach ($students as $student) {
      if ($student->result[0] == 'P') {
         $count_pass += 1;
      } else {
         $count_fail += 1;
      }
   }
   $pass_rate = ($count_pass / $total_students) * 100;
   $fail_rate = ($count_fail / $total_students) * 100;
   $background = "conic-gradient(#FF5722 0% " . $fail_rate . "%, #FFEB3B " . $fail_rate . "% 100%);";
   ?>
   <center>
      <div>Total Number of Students:<?php echo $total_students ?></div><br>

      <br>
      <div class="row">
         <div class="col-lg-6 col-12">No of Students Failed: <?php echo $count_fail; ?></div>
         <div class="col-lg-6 col-12">No of Students Passed: <?php echo $count_pass; ?></div>
      </div>
      <div class="row">
         <div class="col-lg-6 col-12">Fail Ratio: <?php echo round($fail_rate, 2); ?>%</div>
         <div class="col-lg-6 col-12">Pass Ratio: <?php echo round($pass_rate, 2); ?>%</div>
      </div>
   </center>
   <center>
      <style>
         .pie {
            width: 300px;
            height: 300px;
            background: <?= $background ?>;
            margin: 10px;
            display: inline-block;
            border-radius: 50%;
            position: relative;
         }

         .pie>div:first-child {
            position: absolute;
            bottom: 60px;
            left: 60px;
         }

         .pie>div:last-child {
            position: absolute;
            top: 60px;
            right: 60px;
         }
      </style>
      <div class="pie">
         <div>Pass Rate<br><?php echo round($pass_rate, 2); ?>%</div>
         <div>Fail Rate<br><?php echo round($fail_rate, 2); ?>%</div>
      </div>
   </center>
   <?php
   echo "<br><br><h1  class='text-center' >2. List of faliures </h1>";
   ?>
   <center>
      <button type="button" class="open-modal btn btn-primary btn-sm" data-modal-id="fail_list">Open Table</button>
   </center>
   <div class="custom-modal my_modal" id="fail_list">
      <div class="my_popup">
         <h1 style="margin-bottom:30px;">Fail List</h1>
         <table class="table table-bordered datatable">
            <thead class="thead-dark">
               <tr>
                  <th>Seat No.</th>
                  <th>Name</th>
                  <th>Total</th>
                  <th>GPA</th>
               </tr>
            </thead>
            <tbody>
               <?php
               foreach ($students as $key => $student) {
                  if ($student->result[0] !== 'P') {
               ?>
                     <tr>
                        <td><?php echo $student->identity[0] ?></td>
                        <td>
                           <form action="specific_student.php" method="POST" id="specific_student_<?php echo $key; ?>">
                              <input type="hidden" value="<?php print_r(htmlspecialchars(json_encode($student))); ?>" name="student">
                              <input type="hidden" value="<?php print_r(htmlspecialchars(json_encode($subjects))); ?>" name="subjects">
                              <input type="hidden" value="analysis.php" value="back_to">
                              <a href="javascript:$('#specific_student_<?php echo $key; ?>').submit();">
                                 <?php echo $student->identity[1] . " " . $student->identity[2] . " " . $student->identity[3]; ?>
                              </a>
                           </form>
                        </td>
                        <td><?php echo $student->result[2]; ?></td>
                        <td><?php echo $student->result[1]; ?></td>
                     </tr>
               <?php }
               } ?>
            </tbody>
         </table>
      </div>
   </div>

   <?php

   $desc_sorted_students = $students;
   usort($desc_sorted_students, function ($first, $second) {
      return $first->result[1] < $second->result[1];
   });
   $max_to_be_printed = 3;
   echo "<br><br><br><h1  class='text-center' >3. Top $max_to_be_printed </h1>";
   ?>
   <center>
      <button type="button" class="open-modal btn btn-primary btn-sm" data-modal-id="top3">Open Table</button>
   </center>
   <div class="custom-modal my_modal" id="top3">
      <div class="my_popup">
         <h1 style="margin-bottom:30px;">Top <?php echo $max_to_be_printed ?></h1>
         <table class="table table-bordered">
            <thead class="thead-dark">
               <tr>
                  <th>Seat No.</th>
                  <th>Name</th>
                  <th>Total</th>
                  <th>GPA</th>
               </tr>
            </thead>
            <tbody>
               <?php for ($i = 0; $i < $max_to_be_printed; $i++) { ?>
                  <tr>
                     <td><?php echo $desc_sorted_students[$i]->identity[0] ?></td>
                     <td>
                        <form action="specific_student.php" method="POST" id="specific_student_<?php echo $key; ?>">
                           <input type="hidden" value="<?php print_r(htmlspecialchars(json_encode($student))); ?>" name="student">
                           <input type="hidden" value="<?php print_r(htmlspecialchars(json_encode($subjects))); ?>" name="subjects">
                           <input type="hidden" value="analysis.php" value="back_to">
                           <a href="javascript:$('#specific_student_<?php echo $key; ?>').submit();">
                              <?php echo $desc_sorted_students[$i]->identity[1] . " " . $desc_sorted_students[$i]->identity[2] . " " . $desc_sorted_students[$i]->identity[3]; ?>
                           </a>
                        </form>
                     </td>
                     <td><?php echo $desc_sorted_students[$i]->result[2]; ?></td>
                     <td><?php echo $desc_sorted_students[$i]->result[1]; ?></td>
                  </tr>
               <?php } ?>
            </tbody>
         </table>
      </div>
   </div>
   <?php

   echo "<br><br><br><h1 class='text-center'>4. Subject wise Data</h1><br><br>";
   ?>
   <div class="d-flex flex-wrap justify-content-center">
      <?php
      foreach ($subjects as $key => $subject) {
      ?>
         <div class="col-4 my-4 text-center">
            <?php
            echo "<h5>" . $subject . "</h5>";

            ?>


            <button type="button" class="open-modal btn btn-primary btn-sm" data-modal-id="s_<?php echo $key; ?>">All Student Data</button>
            <?php
            foreach ($students as $student) {
               if (strpos($student->evaluation[$key][6], "--") !== false) {
            ?>
                  <button type="button" class="open-modal btn btn-danger btn-sm" data-modal-id="s_<?php echo $key; ?>_fails">Failed Students</button>
            <?php
                  break;
               }
            }
            ?>

            <div class="custom-modal my_modal" id="s_<?php echo $key; ?>">
               <div class="my_popup">
                  <h1 style="margin-bottom:30px;"><?php echo $subject; ?></h1>
                  <table class="table table-bordered specific_subject">
                     <thead class="thead-dark">
                        <tr>
                           <th>Seat No.</th>
                           <th>Name</th>
                           <th>Term Test</th>
                           <th>Unit Test</th>
                           <th>Total</th>
                           <th>Grade</th>
                           <th>CP</th>
                           <th>GP</th>
                           <th>C*GP</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        foreach ($students as $student) { ?>
                           <tr>
                              <td><?php echo $student->identity[0] ?></td>
                              <td>
                                 <form action="specific_student.php" method="POST" id="specific_student_<?php echo $key; ?>">
                                    <input type="hidden" value="<?php print_r(htmlspecialchars(json_encode($student))); ?>" name="student">
                                    <input type="hidden" value="<?php print_r(htmlspecialchars(json_encode($subjects))); ?>" name="subjects">
                                    <input type="hidden" value="analysis.php" value="back_to">
                                    <a href="javascript:$('#specific_student_<?php echo $key; ?>').submit();">
                                       <?php echo $student->identity[1] . " " . $student->identity[2] . " " . $student->identity[3]; ?>
                                    </a>
                                 </form>
                              </td>
                              <td><?php echo $student->evaluation[$key][0] . " &nbsp; - &nbsp; " . $student->evaluation[$key][1]; ?></td>
                              <td><?php echo $student->evaluation[$key][2] . " &nbsp; - &nbsp; " . $student->evaluation[$key][3]; ?></td>
                              <td>
                                 <?php
                                 echo intval(str_replace("*", "", $student->evaluation[$key][4]));
                                 ?>
                              </td>
                              <td><?php echo $student->evaluation[$key][6]; ?></td>
                              <td><?php echo $student->evaluation[$key][5]; ?></td>
                              <td><?php echo $student->evaluation[$key][7]; ?></td>
                              <td><?php echo $student->evaluation[$key][8]; ?></td>
                           </tr>
                        <?php } ?>
                     </tbody>
                  </table>
               </div>
            </div>
            <div class="custom-modal my_modal" id="s_<?php echo $key; ?>_fails">
               <div class="my_popup">
                  <h1 style="margin-bottom:30px;"><?php echo $subject; ?></h1>
                  <table class="table table-bordered specific_subject">
                     <thead class="thead-dark">
                        <tr>
                           <th>Seat No.</th>
                           <th>Name</th>
                           <th>Term Test</th>
                           <th>Unit Test</th>
                           <th>Total</th>
                           <th>Grade</th>
                           <th>CP</th>
                           <th>GP</th>
                           <th>C*GP</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        foreach ($students as $student) {
                           if (strpos($student->evaluation[$key][6], "--") !== false) {
                        ?>
                              <tr>
                                 <td><?php echo $student->identity[0] ?></td>
                                 <td>
                                    <form action="specific_student.php" method="POST" id="specific_student_<?php echo $key; ?>">
                                       <input type="hidden" value="<?php print_r(htmlspecialchars(json_encode($student))); ?>" name="student">
                                       <input type="hidden" value="<?php print_r(htmlspecialchars(json_encode($subjects))); ?>" name="subjects">
                                       <input type="hidden" value="analysis.php" value="back_to">
                                       <a href="javascript:$('#specific_student_<?php echo $key; ?>').submit();">
                                          <?php echo $student->identity[1] . " " . $student->identity[2] . " " . $student->identity[3]; ?>
                                       </a>
                                    </form>
                                 </td>
                                 <td><?php echo $student->evaluation[$key][0] . " &nbsp; - &nbsp; " . $student->evaluation[$key][1]; ?></td>
                                 <td><?php echo $student->evaluation[$key][2] . " &nbsp; - &nbsp; " . $student->evaluation[$key][3]; ?></td>
                                 <td>
                                    <?php
                                    echo intval(str_replace("*", "", $student->evaluation[$key][4]));
                                    ?>
                                 </td>
                                 <td><?php echo $student->evaluation[$key][6]; ?></td>
                                 <td><?php echo $student->evaluation[$key][5]; ?></td>
                                 <td><?php echo $student->evaluation[$key][7]; ?></td>
                                 <td><?php echo $student->evaluation[$key][8]; ?></td>
                              </tr>
                        <?php }
                        } ?>
                     </tbody>
                  </table>
               </div>
            </div>

         </div>
      <?php
      }
      ?>
   </div>









   <script src="./my_vendors/jquery.min.js"> </script>
   <script src="./my_vendors/bootstrap.min.js"> </script>
   <script src="./my_vendors/datatables.js"></script>
   <script src="./my_vendors/modal.js"></script>
   <script>
      $(document).ready(function() {
         var tables = Array.from(document.querySelectorAll('.datatable'));
         tables.forEach(function(table) {
            $(table).DataTable({
               "pageLength": 25,
            })
         });
         var specific_subject = Array.from(document.querySelectorAll('.specific_subject'));
         specific_subject.forEach(function(table) {
            $(table).DataTable({
               "pageLength": 25,
               "order": [
                  [4, "desc"]
               ],
               "columnDefs": [{
                  "type": "num",
                  "targets": 4
               }]
            })
         });

      });
   </script>
</body>

</html>