<?php?>

<table class="table text-center table-bordered" id="myTable">
    <thead class="thead-dark">
        <tr>
            <th>Serial No</th>
            <th>Seat No</th>
            <th>Name</th>
            <th>Total</th>
            <th>Remark</th>
            <th>GPA</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($students as $key => $student) { ?>
            <tr>
                <td><?php echo $key + 1; ?></td>
                <td><?php echo $student->identity[0]; ?></td>
                <td>
                    <form action="specific_student.php" method="POST" id="specific_student_<?php echo $key; ?>">
                        <input type="hidden" value="<?php print_r(htmlspecialchars(json_encode($student))); ?>" name="student">
                        <input type="hidden" value="<?php print_r(htmlspecialchars(json_encode($subjects))); ?>" name="subjects">
                        <a href="javascript:$('#specific_student_<?php echo $key; ?>').submit();">
                            <?php echo $student->identity[1] . " " . $student->identity[2] . " " . $student->identity[3]; ?>
                        </a>
                    </form>
                </td>
                <td><?php echo $student->result[2]; ?></td>

                <td style="display:flex; justify-content:space-evenly">
                    <?php
                    if ($student->result[0] == 'F') { ?>
                        <div>Fail</div>
                        <div><i class="fa fa-times fa-sm red"></i></div>
                    <?php } else if ($student->result[0] == 'P') { ?>
                        <div>Pass</div>
                        <div><i class="fa fa-check fa-sm green"></i></div>
                    <?php } else if ($student->result[0] == 'P*') { ?>
                        <div>Pass*</div>
                        <div><i class="fa fa-check fa-sm yellow"></i></div>
                    <?php } else { ?>
                        <div>Absent</div>
                        <div><i class="fa fa-times fa-sm"></i></div>
                    <?php } ?>
                </td>
                <td><?php if ($student->result[1] == '--') {
                        echo "0.0";
                    } else {
                        echo  $student->result[1];
                    } ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>