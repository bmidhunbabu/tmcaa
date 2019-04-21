<?php
require_once '../includes/config.php';
Auth::is_logged_in() or header('Location:' . SITE_URL);
User::is_admin() or die('Unauthorized Access');
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
                    if (isset($_POST['delete'])) {
                        $result = Exam::delete($_POST['id']);
                        if ($result) {
                            alert('Exam deleted', 'success');
                        }
                    }
                    ?>
                    <?php $result = Exam::all(); ?>
                    <?php if ($result) : ?>
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>Exam Name</th>
                                    <th>Date</th>
                                    <th>Course</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <?php foreach ($result as $exam) : ?>
                                    <tr>
                                        <td><?php echo $exam->name; ?></td>
                                        <td><?php echo $exam->startDate(); ?> To <?php echo $exam->endDate(); ?></td>
                                        <td><?php echo $exam->course()->name; ?></td>
                                        <?php /* ?>
                                <td>
                                    <a href="<?php echo SITE_URL; ?>/exam/update.php?exam_id=<?php echo $exam['id']; ?>" class="btn btn-sm btn-success">Edit</a>
                                </td>
                                <?php */ ?>
                                        <td>
                                            <a href="<?php echo SITE_URL; ?>/question/index.php?exam_id=<?php echo $exam->id; ?>" class="btn btn-sm btn-success">View Questions</a>
                                        </td>
                                        <td>
                                            <a href="<?php echo SITE_URL; ?>/question/create.php?exam_id=<?php echo $exam->id; ?>" class="btn btn-sm btn-success">Add Questions</a>
                                        </td>
                                        <td>
                                            <form method="POST">
                                                <input type="hidden" name="id" value="<?php echo $exam->id; ?>" />
                                                <input type="submit" class="btn btn-sm btn-danger" value="Delete" name="delete" />
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>