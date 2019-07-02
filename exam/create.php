<?php
require_once '../includes/config.php';
Auth::is_logged_in() or header('Location:' . SITE_URL);
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
                    <h3 class="heading">Exam</h3>
                </div>
                <div class="content-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php
                            if (isset($_POST['create'])) {
                                if (Exam::exists('name', $_POST['name'])) {
                                    alert('Exam name already exists', 'danger');
                                } else if (!ctype_digit($_POST['correct_mark'])) {
                                    alert('Correct Mark must be a number', 'danger');
                                } else if (!ctype_digit($_POST['incorrect_mark'])) {
                                    alert('-ve Mark must be a number', 'danger');
                                } else {
                                    unset($_POST['create']);
                                    $result = Exam::create($_POST);
                                    if ($result) {
                                        foreach ($_POST as $key => $value) {
                                            unset($_POST[$key]);
                                        }
                                        alert('Exam Created Successfully', 'success');
                                    }
                                }
                            }
                            ?>
                            <form method="POST">
                                <div class="form-group">
                                    <label class="control-label">Exam Name</label>
                                    <input type="text" class="form-control" placeholder="Exam Name" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" required />
                                </div>
                                <div class="form-group">
                                    <label for="courSe_id">Course</label>
                                    <?php $courses = Course::all('name'); ?>
                                    <?php if ($courses) : ?>
                                        <select name="courSe_id" id="courSe_id" class="form-control" required>
                                            <option selected hidden disabled>Course</option>
                                            <?php foreach ($courses as $course) : ?>
                                                <option value="<?php echo $course->id; ?>"><?php echo $course->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Mark for a correct Answer</label>
                                    <input type="number" class="form-control" name="correct_mark" min="1" value="<?php echo isset($_POST['correct_mark']) ? $_POST['correct_mark'] : ''; ?>" required />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">-ve Mark for an incorrect Answer</label>
                                    <input type="number" class="form-control" name="incorrect_mark" min="0" value="<?php echo isset($_POST['incorrect_mark']) ? $_POST['incorrect_mark'] : ''; ?>" required />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Start Date</label>
                                    <input type="date" class="form-control" placeholder="Exam Start Date" name="start_date" value="<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>" required />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">End Date</label>
                                    <input type="date" class="form-control" placeholder="Exam End Date" name="end_date" value="<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ''; ?>" required />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Duration of the Exam</label>
                                    <input type="number" name="duration" placeholder="Duration in Minutes" class="form-control" min="1" value="<?php echo isset($_POST['duration']) ? $_POST['duration'] : ''; ?>" required>
                                </div>
                                <input type="submit" class="btn" value="Create" name="create" />
                            </form>
                        </div>
                        <div class="col-md-6">
                            <?php $result = Exam::all(); ?>
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
                                        <?php foreach ($result as $exam) : ?>
                                            <tr>
                                                <td><?php echo $exam->name; ?></td>
                                                <td><?php echo $exam->startDate(); ?> - <?php echo $exam->endDate(); ?></td>
                                                <td><?php echo $exam->course()->name; ?></td>
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
    <script>
        $('#course_id').change(function() {
            $.ajax({
                url: "<?php echo SITE_URL; ?>/exam/subject-list.php",
                data: {
                    course_id: $(this).val()
                },
                success: function(result) {
                    $("#subject_id").html(result);
                }
            });
        });
    </script>
</body>

</html>