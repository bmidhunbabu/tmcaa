<?php

require_once '../includes/config.php';

$course_id = $_REQUEST['course_id'];
if(isset($_REQUEST['date'])) {
    $date = $_REQUEST['date'];
}
?>

<?php if($course_id): ?>
<?php
    $sql = "select * from users where course_id = '$course_id' and role_id = (select id from roles where name = 'student')";
    if(isset($_REQUEST['date'])) {
        $sql .= " and date = '$date'";
    }
    echo $sql;
    $result = $mysqli->query($sql);
?>
    <?php if($result->num_rows): ?>
        <tbody>
            <tr>
                <th>Student Name</th>
                <th>Present</th>
                <th>Absent</th>
            </tr>
            <?php while($student = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $student['name']; ?></td>
                    <td>
                        <input type="radio" class="form-radio-input" name="status[<?php echo $student['id']; ?>]" value="1">
                    </td>
                    <td>
                        <input type="radio" class="form-radio-input" name="status[<?php echo $student['id']; ?>]" value="0">
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    <?php else: ?>
        <tr><td>No Student Found</td></tr>
    <?php endif; ?>
<?php endif; ?> 