<?php

require_once '../includes/config.php';

$student_id = $_REQUEST['student_id'];

?>

<?php if($student_id):?>
    <?php 
        $sql = "select s.name,s.id from subjects s inner join course_subject cs on s.id = cs.subject_id where cs.course_id = (select course_id from users where id = '$student_id')"; 
        $result = $mysqli->query($sql);
    ?>
    <?php if($result->num_rows): ?>
        <?php while($subject = $result->fetch_assoc()): ?>
            <option value="<?php echo $subject['id']; ?>"><?php echo $subject['name']; ?></option>
        <?php endwhile; ?>
    <?php endif; ?>
<?php endif; ?> 