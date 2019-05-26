<?php require_once("../includes/config.php"); ?>

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
                    <h3 class="heading">Exam</h3>
                </div>
                <div class="content-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php if (isset($_GET['exam_id'])) : $exam = Exam::find($_GET['exam_id']);  ?>
                                <?php if ($exam) : ?>
                                    <?php
                                    if (isset($_POST['create'])) {
                                        if (!ctype_digit($_POST['correct_mark'])) {
                                            alert('Correct Mark must be a number', 'danger');
                                        } else if (!ctype_digit($_POST['incorrect_mark'])) {
                                            alert('-ve Mark must be a number', 'danger');
                                        } else {
                                            unset($_POST['create']);
                                            if (Exam::existsWith($_POST)) {
                                                alert('No changes found', 'danger');
                                            } else {
                                                $result = Exam::update($_POST, $_GET['exam_id']);
                                                if ($result == 1) {
                                                    alert('Exam Created Successfully', 'success');
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                    <form method="POST">
                                        <div class="form-group">
                                            <label class="control-label">Exam Name</label>
                                            <input type="text" class="form-control" placeholder="Exam Name" name="name" value="<?php echo input('name', $exam->name); ?>" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="courSe_id">Course</label>
                                            <?php $courses = Course::all('name'); ?>
                                            <?php if ($courses) : ?>
                                                <select name="courSe_id" id="courSe_id" class="form-control" required>
                                                    <option selected hidden disabled>Course</option>
                                                    <?php foreach ($courses as $course) : ?>
                                                        <option value="<?php echo $course->id; ?>" <?php echo $course->id == $exam->course()->id ? 'selected' : ''; ?>><?php echo $course->name; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Mark for a correct Answer</label>
                                            <input type="number" class="form-control" name="correct_mark" min="1" value="<?php echo input('correct_mark', $exam->correct_mark); ?>" required />
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">-ve Mark for an incorrect Answer</label>
                                            <input type="number" class="form-control" name="incorrect_mark" min="0" value="<?php echo input('incorrect_mark', $exam->incorrect_mark); ?>" required />
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Start Date</label>
                                            <input type="date" class="form-control" placeholder="Exam Start Date" name="start_date" value="<?php echo input('start_date', $exam->start_date); ?>" required />
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">End Date</label>
                                            <input type="date" class="form-control" placeholder="Exam End Date" name="end_date" value="<?php echo input('end_date', $exam->end_date); ?>" required />
                                        </div>
                                        <input type="submit" class="btn" value="Create" name="create" />
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <?php
                            $result = Exam::paginate(0, 10, null, 'updated_at', 'DESC');
                            ?>
                            <?php if ($result) : ?>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Exam Name</th>
                                            <th>Date</th>
                                            <th>Course</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($result as $exm) : ?>
                                            <tr>
                                                <td><?php echo $exm->name; ?></td>
                                                <td><?php echo $exm->startDate(); ?> - <?php echo $exm->endDate(); ?></td>
                                                <td><?php echo $exm->course()->name; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>