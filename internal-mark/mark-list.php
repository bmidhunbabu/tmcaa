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
                        <h3 class="heading">Results</h3>
                    </div>
                    <div class="content-body">
                        <?php
                            if(isset($_POST['delete'])) {
                                $result = Result::delete($_POST['id']);
                                if($result) {
                                    alert('Result deleted','success');
                                }
                            }
                        ?>
                        <?php
                            $student_id = Auth::userId();
                            $sql = "select i.semester,i.marks_obtained,s.name as subject_name from internal_marks i inner join subjects s on i.subject_id = s.id where i.student_id = '$student_id' order by i.created_at,i.semester";
                            $result = $mysqli->query($sql);
                        ?>
                        <?php if($result->num_rows): ?>
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Marks obtained</th>
                                        <th>Semester</th>
                                    </tr>
                                    <?php while($res = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $res['subject_name']; ?></td>
                                            <td><?php echo $res['marks_obtained'] ; ?></td>
                                            <td><?php echo $res['semester'] ; ?></td>
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
