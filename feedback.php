<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap Admin Panel</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/icon-moon.css" rel="stylesheet">
        <link href="css/admin-menu.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/admin-menu.js"></script>
        <script src="js/jquery.custom.js"></script>
    </head>
    <body>
        <?php require_once 'admin-bar.php'; ?>
        <div class="container-fluid">
            <div class="row" id="main">
                <?php require_once 'admin-menu.php'; ?>
                <div id="content">
                    <div id="content-header">
                        <h3 class="heading">Feedback</h3>
                    </div>
                    <div class="content-body">
                     <form>
                      <div class="row">
                       <div class="col-md-6">
                          <div class="form-group">
                             <textarea class="form-control" placeholder="comments..."></textarea>
                            </div>
                            <div class="form-group">
                             <select class="form-control">
                              <option selected>1</option>
                              <option>2</option>
                              <option>3</option>
                            </select>
                            </div>
                            <div class="form-group">
                             <select class="form-control">
                          <option selected>1</option>
                          <option>2</option>
                          <option>3</option>
                          </select>
                            </div>
                            <input type="submit" class="btn btn-success" value="Register" />
                        </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
