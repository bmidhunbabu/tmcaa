<?php
require_once("../includes/config.php");
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
                    <h3 class="heading">User Registration</h3>
                </div>
                <div class="content-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php
                            if (isset($_POST['register'])) {
                                if (preg_match('/[^a-zA-Z\s]/', $_POST['name'])) {
                                    alert('Name cannot contain numbers and special characters', 'danger');
                                } else if (!ctype_digit($_POST['phone'])) {
                                    alert('Invalid phone Number', 'danger');
                                } else if (strlen($_POST['phone']) != 10) {
                                    alert('phone number must be of 10 digits', 'danger');
                                } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                                    alert('Invalid Email Address', 'danger');
                                } else if (Student::exists('roll_no', $_POST['roll_no'])) {
                                    alert('Register Number Already Exists', 'danger');
                                } else if (User::exists('email', $_POST['email'])) {
                                    alert('Email Addres Already Exists', 'danger');
                                } else if (User::exists('username', $_POST['username'])) {
                                    alert('Username Already Exists', 'danger');
                                } else {
                                    unset($_POST['register']);
                                    $user_id = User::create(array(
                                        'username' => $_POST['username'],
                                        'email' => $_POST['email'],
                                        'password' => $_POST['password'],
                                        'name' => $_POST['name'],
                                        'phone' => $_POST['phone'],
                                        'role_id' => $_POST['role_id'],
                                        'status' => 1,
                                    ));
                                    if ($user_id) {
                                        $result = Student::create(array(
                                            'user_id' => $user_id,
                                            'roll_no' => $_POST['roll_no'],
                                            'course_id' => $_POST['course_id'],
                                            'date_of_join' => $_POST['date_of_join'],
                                        ));
                                        foreach ($_POST as $key => $value) {
                                            unset($_POST[$key]);
                                        }
                                        if ($result) {
                                            alert('User Created Successfully', 'success');
                                        }
                                    }
                                }
                            }
                            ?>
                            <form method="POST" id="user-form">
                                <div class="form-group">
                                    <label class="control-label">Name</label>
                                    <input type="text" class="form-control" placeholder="Name" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" required />
                                </div>
                                <?php /* ?>
                                <div class="form-group">
                                    <label class="control-label">Date of Birth</label>
                                    <input type="date" class="form-control" placeholder="Date of Birth" name="dob" value="<?php echo isset($_POST['dob']) ? $_POST['dob'] : ''; ?>" id="date" required />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Gender</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="exampleRadios1" name="gender" value="female" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'female') ? 'checked' : ''; ?> required />
                                        <label class="form-check-label" for="exampleRadios1">
                                            Female
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="exampleRadios2" name="gender" value="male" name="gender" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'male') ? 'checked' : ''; ?> required />
                                        <label class="form-check-label" for="exampleRadios2">
                                            Male
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="exampleRadios3" value="other" name="gender" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'other') ? 'checked' : ''; ?> required />
                                        <label class="form-check-label" for="exampleRadios3">
                                            Other
                                        </label>
                                    </div>
                                </div>
                                <?php */ ?>
                                <div class="form-group">
                                    <label class="control-label">Mobile Number</label>
                                    <input type="text" class="form-control" placeholder="Mobile No." name="phone" id="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Email</label>
                                    <input type="text" class="form-control" placeholder="Email id" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Username</label>
                                    <input type="text" class="form-control" placeholder="Username" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" required />
                                </div>
                                <?php /* ?>
                                <div class="form-group">
                                    <label class="control-label">Address</label>
                                    <textarea class="form-control" placeholder="Address" name="address" required><?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?></textarea>
                                </div>
                                <?php */ ?>
                                <div class="form-group">
                                    <label class="control-label">Roll Number</label>
                                    <input type="text" class="form-control" placeholder="Roll No." name="roll_no" id="roll_no" value="<?php echo isset($_POST['roll_no']) ? $_POST['roll_no'] : ''; ?>" id="roll_no" required />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Course</label>
                                    <select class="form-control" name="course_id" required>
                                        <option selected disabled hidden>Course</option>
                                        <?php
                                        $sql = "select * from courses";
                                        $courses = $mysqli->query($sql);
                                        ?>
                                        <?php while ($course = $courses->fetch_assoc()) : ?>
                                            <option value="<?php echo $course['id']; ?>" <?php echo (isset($_POST['course_id']) && $_POST['course_id'] == $course['id']) ? 'selected' : ''; ?>><?php echo ucwords($course['name']); ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Role</label>
                                    <select class="form-control" name="role_id" required>
                                        <option selected disabled hidden>Role</option>
                                        <?php
                                        $sql = "select * from roles where name!= 'admin'";
                                        $roles = $mysqli->query($sql);
                                        ?>
                                        <?php while ($role = $roles->fetch_assoc()) : ?>
                                            <option value="<?php echo $role['id']; ?>" <?php echo (isset($_POST['role_id']) && $_POST['role_id'] == $role['id']) ? 'selected' : ''; ?>><?php echo ucwords($role['name']); ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Date of Join</label>
                                    <input type="date" class="form-control" placeholder="Date of Join" name="date_of_join" value="<?php echo isset($_POST['date_of_join']) ? $_POST['date_of_join'] : ''; ?>" id="date" required />
                                </div>
                                <input type="hidden" name="password" id="password" value="" />
                                <input type="hidden" name="status" value="1" />
                                <input type="submit" class="btn" value="Register" name="register" />
                            </form>
                        </div>
                        <div class="col-md-6 mt-4">
                            <?php
                            $result = User::all();
                            ?>
                            <?php if ($result) : ?>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <td>Name</td>
                                            <td>Email</td>
                                            <td>Mobile</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($result as $user) : ?>
                                            <tr>
                                                <td><?php echo $user->name; ?></td>
                                                <td><?php echo $user->email; ?></td>
                                                <td><?php echo $user->phone; ?></td>
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
        $('#user-form').submit(function(event) {
            var roll_no = $('#roll_no').val();
            var phone = $('#phone').val();
            var password = roll_no.replace(/-/gi, '') + phone.replace(/-/gi, '')
            $('#password').val(password);
        });
    </script>
</body>

</html>