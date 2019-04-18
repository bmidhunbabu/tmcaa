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
                        <h3 class="heading">Attendance</h3>
                    </div>
                    <div class="content-body">
                        <?php 
                            $student_id = Auth::userId();
                            $sql = "select * from attendance where student_id = '$student_id' order by date";
                            $result = $mysqli->query($sql);
                        ?>
                        <?php if($result->num_rows): ?> 
                            <table class="table table-striped">
                                <tr>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                                <?php while($attendance = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $attendance['date']?></td>
                                        <td><?php echo $attendance['status'] ? 'Present' : 'Absent';?></td>
                                    </tr>
                                <?php endwhile;?>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
