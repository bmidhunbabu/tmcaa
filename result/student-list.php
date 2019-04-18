<?php

require_once '../includes/config.php';

$exam_id = $_REQUEST['exam_id'];

?>

<?php if($exam_id):?>
    <?php 
        $sql = "select name,id from users where role_id = (select id from roles where name = 'student') and course_id = (select course_id from exams where id = '$exam_id')"; 
        $result = $mysqli->query($sql);
    ?>
    <?php if($result->num_rows): ?>
        <?php while($student = $result->fetch_assoc()): ?>
            <option value="<?php echo $student['id']; ?>"><?php echo $student['name']; ?></option>
        <?php endwhile; ?>
    <?php endif; ?>
<?php endif; ?> 