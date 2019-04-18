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
                                <?php
                                    if(isset($_GET['exam_id'])) {
                                        $id = $_GET['exam_id'];
                                        $sql = "select * from exams where id = '$id'";
                                        $result = $mysqli->query($sql);
                                        if($result->num_rows) {
                                            $exam = $result->fetch_assoc();
                                            $name = $exam['name'];
                                            $course_id = $exam['course_id'];
                                            $subject_id = $exam['subject_id'];
                                            $exam_category_id = $exam['exam_category_id'];
                                            $date = $exam['date'];
                                            $maximum_marks = $exam['maximum_marks'];
                                        } else {
                                            alert('Invalid Exam','danger');
                                        }
                                    }
                                    if(isset($_POST['create'])) {
                                        if(preg_match('/[^a-zA-Z\s]/', $_POST['name'])) {
                                            alert('Exam Name cannot contain numbers and special characters','danger');
                                        } else if(!ctype_digit($_POST['maximum_marks'])) {
                                            alert('Maximum Marks must be a number','danger');
                                        } else {
                                            unset($_POST['create']);
                                            if(Exam::existsWith($_POST)) {
                                                alert('No changes found','danger');
                                            } else {
                                                $result = Exam::update($_POST,$_GET['exam_id']);
                                                if($result == 1) {
                                                    unset($name);
                                                    unset($course_id);
                                                    unset($subject_id);
                                                    unset($exam_category_id);
                                                    unset($date);
                                                    unset($maximum_marks);
                                                    alert('Exam Created Successfully','success');
                                                }
                                            }
                                        }
                                    }
                                ?>
                                <form method="POST">
                                    <div class="form-group">
                                        <label class="control-label">Exam Name</label>
                                        <input type="text" class="form-control" placeholder="Exam Name" name="name" value="<?php echo isset($name) ? $name: '' ; ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Course</label>
                                        <select class="form-control" name="course_id">
                                            <option selected disabled hidden>Course</option>
                                            <?php
                                            $sql = "select * from courses";
                                            $courses = $mysqli->query($sql);
                                            ?>
                                            <?php while ($course = $courses->fetch_assoc()) : ?>
                                                <option value="<?php echo $course['id']; ?>" <?php echo (isset($course_id) && $course_id == $course['id']) ? 'selected' : ''; ?>><?php echo ucwords($course['name']); ?></option> 
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Subject</label>
                                        <select class="form-control" name="subject_id">
                                            <option selected disabled hidden>Subject</option>
                                            <?php
                                            $sql = "select * from subjects";
                                            $subjects = $mysqli->query($sql);
                                            ?>
                                            <?php while ($subject = $subjects->fetch_assoc()) : ?>
                                                <option value="<?php echo $subject['id']; ?>" <?php echo (isset($subject_id) && $subject_id == $subject['id']) ? 'selected' : ''; ?>><?php echo ucwords($subject['name']); ?></option> 
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Exam Category</label>
                                        <select class="form-control" name="exam_category_id">
                                            <option selected disabled hidden>Exam Category</option>
                                            <?php
                                            $sql = "select * from exam_categories";
                                            $categories = $mysqli->query($sql);
                                            ?>
                                            <?php while ($category = $categories->fetch_assoc()) : ?>
                                                <option value="<?php echo $category['id']; ?>" <?php echo (isset($exam_category_id) && $exam_category_id == $category['id']) ? 'selected' : ''; ?>><?php echo ucwords($category['name']); ?></option> 
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Exam Date</label>
                                        <input type="date" class="form-control" placeholder="Exam Date" name="date" value="<?php echo isset($date) ? $date: '' ; ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Maximum Marks</label>
                                        <input type="text" class="form-control" placeholder="Max. Marks" name="maximum_marks" value="<?php echo isset($maximum_marks) ? $maximum_marks: '' ; ?>" />
                                    </div>
                                    <input type="submit" class="btn" value="Create" name="create" />  
                                </form>
                            </div>
                            <div class="col-md-6">
                                <?php
                                    $sql = "select e.id,e.name as exam_name,e.date,e.maximum_marks,c.name as course_name,s.name as subject_name,x.name as category_name from exams e\n"
                                    . "inner join courses c on e.course_id = c.id\n"
                                    . "inner join subjects s on e.subject_id = s.id \n"
                                    . "inner join exam_categories x on e.exam_category_id = x.id order by e.updated_at";
                                    $result = $mysqli->query($sql);
                                ?>
                                <?php if($result->num_rows) : ?>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Exam Name</th>
                                                <th>Date</th>
                                                <th>Max. Marks</th>
                                                <th>Course</th>
                                                <th>Subject</th>
                                                <th>Category</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($exam = $result->fetch_assoc()): ?>
                                                <tr>
                                                    <td><?php echo $exam['exam_name']; ?></td>
                                                    <td><?php echo $exam['date']; ?></td>
                                                    <td><?php echo $exam['maximum_marks']; ?></td>
                                                    <td><?php echo $exam['course_name']; ?></td>
                                                    <td><?php echo $exam['subject_name']; ?></td>
                                                    <td><?php echo $exam['category_name']; ?></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>                                         
                                    </table>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
