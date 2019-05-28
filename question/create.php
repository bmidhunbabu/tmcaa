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
    <!-- upload previe -->
    <script src="<?php echo SITE_URL; ?>/js/jquery.uploadPreview.min.js"></script>
</head>

<body>
    <?php require_once '../admin-bar.php'; ?>
    <div class="container-fluid">
        <div class="row" id="main">
            <?php require_once '../admin-menu.php'; ?>
            <div id="content">
                <div id="content-header">
                    <h3 class="heading">Question</h3>
                </div>
                <div class="content-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php
                            $exam = null;
                            if (isset($_GET['exam_id'])) {
                                $exam = Exam::find($_GET['exam_id']);
                            }
                            if (isset($_POST['create'])) {
                                if (trim($_POST['question']) == '') {
                                    alert('question is required', 'danger');
                                } else if (trim($_POST['answers']) == '') {
                                    alert('answers is required', 'danger');
                                } else if (trim($_POST['correct_answer']) == '') {
                                    alert('Correct answer is required', 'danger');
                                } else {
                                    $answers = explode("\r\n", $_POST['answers']);

                                    if (in_array($_POST['correct_answer'], $answers)) {
                                        $thumbnail_name = '';
                                        $data = array();

                                        if ($_FILES['photo']['size'] == 0) {
                                            $thumbnail_name = '';
                                        } else {
                                            $ext = strtolower(pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION));
                                            if ($ext != "jpg" && $ext != "jpeg") {
                                                alert('Only jpg, jpeg images are allowed', 'danger');
                                            } else if ($_FILES["photo"]["size"] > 2097152) {
                                                alert('Maximum file size is 2MB', 'danger');
                                            } else {
                                                $thumbnail_name = upload($_FILES["photo"], APP_PATH . '/storage/questions/', 'ques-');
                                            }
                                            $data['photo'] = $thumbnail_name;
                                        }
                                        $data['question'] = $_POST['question'];
                                        $data['answers'] = $answers;
                                        $data['correct_answer'] = $_POST['correct_answer'];
                                        $data['description'] = $_POST['description'];
                                        $data['exam_id'] = $exam->id;
                                        $result = Question::create($data);
                                        if ($result) {
                                            alert("Question Added", "success");
                                        }
                                    } else {
                                        alert('Correct answer is not in options', 'danger');
                                    }
                                }
                            }
                            ?>
                            <form method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="control-label">Question</label>
                                    <input type="text" class="form-control" placeholder="Question" name="question" value="<?php echo isset($_POST['question']) ? $_POST['question'] : ''; ?>" required />
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="answers">Options</label>
                                    <textarea name="answers" placeholder="One option per line" class="form-control" rows="5"><?php echo isset($_POST['answers']) ? $_POST['answers'] : ''; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Correct Answer</label>
                                    <input type="text" class="form-control" name="correct_answer" value="<?php echo isset($_POST['correct_answer']) ? $_POST['correct_answer'] : ''; ?>" required />
                                </div>
                                <div class="form-group">
                                    <label for="Description">Description to the Answer</label>
                                    <textarea name="description" class="form-control" rows="5"><?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="photo">Photo</label>
                                    <div id="preview_photo" class="preview-box">
                                        <label for="photo" id="label_photo" class="file-input-label">
                                            <i class="fa fa-image"></i> Select Image
                                        </label>
                                        <input type="file" name="photo" id="photo" class="file-input" accept="image/*" />
                                    </div>
                                </div>
                                <input type="submit" class="btn" value="Create" name="create" />
                            </form>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-striped mt-4">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $.uploadPreview({
                input_field: "#photo",
                preview_box: "#preview_photo",
                label_field: "#label_photo",
                label_default: "Choose File",
                label_selected: '<i class="fa fa-image"></i> Change Image',
                no_label: false
            });
        });
    </script>
</body>

</html>