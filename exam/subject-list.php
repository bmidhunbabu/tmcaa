<?php

require_once '../includes/config.php';

$course_id = $_REQUEST['course_id'];

?>

<?php if($course_id):?>
    <?php 
        $sql = "select s.name,s.id from subjects s inner join course_subject cs on s.id = cs.subject_id where cs.course_id = '$course_id'"; 
        $result = $mysqli->query($sql);
    ?>
    <?php if($result->num_rows): ?>
        <?php while($subject = $result->fetch_assoc()): ?>
            <option value="<?php echo $subject['id']; ?>"><?php echo $subject['name']; ?></option>
        <?php endwhile; ?>
    <?php endif; ?>
<?php endif; ?> 