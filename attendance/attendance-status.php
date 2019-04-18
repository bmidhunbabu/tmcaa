<?php

require_once '../includes/config.php';

$course_id = $_REQUEST['course_id'];

?>

<?php if($course_id): ?>
<?php
    $sql = "select a.status,u.name,u.id from attendance a inner join users u on a.student_id = u.id where a.course_id = '$course_id' group by a.student_id";
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
                        <input type="radio" class="form-radio-input" name="status[<?php echo $student['id']; ?>]" value="1" <?php echo ($student['status']) ? 'checked' : ''; ?>>
                    </td>
                    <td>
                        <input type="radio" class="form-radio-input" name="status[<?php echo $student['id']; ?>]" value="0" <?php echo ($student['status'] == 0) ? 'checked' : ''; ?>>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    <?php else: ?>
        <tr><td>No Student Found</td></tr>
    <?php endif; ?>
<?php endif; ?> 