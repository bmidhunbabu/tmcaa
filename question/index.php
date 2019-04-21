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
                    <h3 class="heading">Questions</h3>
                </div>
                <div class="content-body">
                    <?php if (isset($_GET['exam_id'])) : $exam = Exam::find($_GET['exam_id']); ?>
                        <table class="table mb-4">
                            <tbody>
                                <tr>
                                    <th>Exam Name</th>
                                    <td><?php echo $exam->name; ?></td>
                                </tr>
                                <tr>
                                    <th>Exam Date</th>
                                    <td><?php echo $exam->startDate() . " TO " . $exam->endDate(); ?></td>
                                </tr>
                                <tr>
                                    <th>Course</th>
                                    <td><?php echo $exam->course()->name; ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <?php $questions = $exam->questions(); ?>
                        <?php foreach ($questions as $question) : ?>
                            <div class="question-card">
                                <p class="question"><?php echo $question->question; ?></p>
                                <?php $answers = $question->answers(); ?>
                                <div class="row">
                                    <?php foreach ($answers as $answer) : ?>
                                        <div class="col-md-6">
                                            <p class="answer<?php echo ($answer->is_correct) ? ' correct' : ''; ?>"><?php echo $answer->answer; ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>