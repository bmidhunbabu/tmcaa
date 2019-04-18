<?php 
    require_once '../includes/config.php';
    Auth::is_logged_in() or header('Location:'.SITE_URL);
    User::is_student() or die('Unauthorized Access');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo SITE_TITLE; ?></title>
        <link href="<?php echo SITE_URL; ?>/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo SITE_URL; ?>/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo SITE_URL; ?>/css/icon-moon.css" rel="stylesheet">
        <link href="<?php echo SITE_URL; ?>/css/admin-menu.css" rel="stylesheet">
        <link href="<?php echo SITE_URL; ?>/css/style.css" rel="stylesheet">
        <script src="<?php echo SITE_URL; ?>/js/jquery.min.js"></script>
        <script src="<?php echo SITE_URL; ?>/js/bootstrap.min.js"></script>
        <script src="<?php echo SITE_URL; ?>/js/admin-menu.js"></script>
        <script src="<?php echo SITE_URL; ?>/js/jquery.custom.js"></script>
    </head>
    <body>
        <?php require_once '../admin-bar.php'; ?>
        <div class="container-fluid">
            <div class="row" id="main">
                <?php require_once '../admin-menu.php'; ?>
                <div id="content">
                    <div id="content-header">
                        <h3 class="heading">Exams</h3>
                    </div>
                    <div class="content-body">
                        <?php
                            $user = Auth::user();
                            $course_id = $user['course_id'];
                            $sql = "select e.id,e.name as exam_name,e.date,e.maximum_marks,c.name as course_name,s.name as subject_name,x.name as category_name from exams e\n"
                            . "inner join courses c on e.course_id = c.id\n"
                            . "inner join subjects s on e.subject_id = s.id \n"
                            . "inner join exam_categories x on e.exam_category_id = x.id where e.course_id = '$course_id'";
                            $result = $mysqli->query($sql);
                        ?>
                        <?php if($result->num_rows): ?>
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th>Exam Name</th>
                                        <th>Subject</th>
                                        <th>Category</th>
                                        <th>Date</th>
                                        <th>Max. Marks</th>
                                    </tr>
                                    <?php while($exam = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $exam['exam_name']; ?></td>
                                            <td><?php echo $exam['subject_name']; ?></td>
                                            <td><?php echo $exam['category_name']; ?></td>
                                            <td><?php echo $exam['date']; ?></td>
                                            <td><?php echo $exam['maximum_marks']; ?></td>
                                        </tr>
                                     <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
