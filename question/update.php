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
                    <?php
                    if (isset($_GET['id'])) {
                        $question = Question::find($_GET['id']);
                    }
                    ?>
                    <?php if ($question) : ?>
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                $qanss = '';
                                $cans = '';
                                $qans = array();
                                foreach ($question->answers() as $ans) {
                                    $qans[] = $ans->answer;
                                    if ($ans->is_correct) {
                                        $cans = $ans->answer;
                                    }
                                }
                                $qanss = implode("\r\n", $qans);
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
                                                    $image_base64 = base64_encode(file_get_contents($_FILES['photo']['tmp_name']));
                                                    $image = 'data:image/' . $ext . ';base64,' . $image_base64;
                                                    $data['photo'] = $image;
                                                }
                                            }
                                            $data['question'] = $_POST['question'];
                                            $data['answers'] = $answers;
                                            $data['correct_answer'] = $_POST['correct_answer'];
                                            $data['description'] = $_POST['description'];
                                            $result = Question::update($data, $question->id);
                                            if ($result) {
                                                alert("Question Updated", "success");
                                                $question = Question::find($_GET['id']);
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
                                        <input type="text" class="form-control" placeholder="Question" name="question" value="<?php echo input('question', $question->question); ?>" required />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="answers">Options</label>
                                        <textarea name="answers" placeholder="One option per line" class="form-control" rows="5"><?php echo input('answers', $qanss); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Correct Answer</label>
                                        <input type="text" class="form-control" name="correct_answer" value="<?php echo input('correct_answer', $cans); ?>" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="Description">Description to the Answer</label>
                                        <textarea name="description" class="form-control" rows="5"><?php echo input('description', $question->description); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="photo">Photo</label>
                                        <div id="preview_photo" class="preview-box" style="background-image:url('<?php echo $question->photo; ?>');">
                                            <label for="photo" id="label_photo" class="file-input-label">
                                                <i class="fa fa-image"></i> Select Image
                                            </label>
                                            <input type="file" name="photo" id="photo" class="file-input" accept="image/*" />
                                        </div>
                                    </div>
                                    <input type="submit" class="btn" value="Save" name="create" />
                                </form>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-striped mt-4">
                                    <tbody>
                                        <tr>
                                            <th>Exam Name</th>
                                            <td><?php echo $question->exam()->name; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Exam Date</th>
                                            <td><?php echo $question->exam()->startDate() . " TO " . $question->exam()->endDate(); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Course</th>
                                            <td><?php echo $question->exam()->course()->name; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
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