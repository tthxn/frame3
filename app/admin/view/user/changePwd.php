<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="./static/bs3/css/bootstrap.min.css">
    <!--    bootstrap中的下拉框是js写的，因此需要引入js文件，但是js文件是依赖于jquery写的，因此，一定要在引入js之前引入jQuery文件-->
    <script src="./static/js/jquery.min.js"></script>
    <script src="./static/bs3/js/bootstrap.min.js"></script>
</head>
<body>
<?php include "./view/admin/header.php"?>
<div class="container">
    <div class="row">
        <?php include "./view/admin/left.php"?>
        <div class="col-xs-9">
            <div class="panel panel-default">
                <div class="panel-heading">修改密码</div>
                <div class="panel-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="exampleInputEmail1">旧密码</label>
                            <input type="password" class="form-control" name="oldPwd" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">新密码</label>
                            <input type="password" class="form-control" name="newPwd" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">确认密码</label>
                            <input type="password" class="form-control" name="reNewPwd" required>
                        </div>

                        <button type="submit" class="btn btn-default">确认修改</button>
                    </form>
                </div>
            </div>


        </div>
    </div>
</div>
</body>
</html>


