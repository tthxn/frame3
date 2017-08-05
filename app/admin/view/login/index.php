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
<div class="container" style="margin-top: 50px;">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">登陆后台页面</h3>
        </div>
        <div class="panel-body">
            <form method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1">用户名</label>
                    <input type="text" class="form-control"  name="username" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">密码</label>
                    <input type="password" class="form-control"  name="password" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">验证码</label>
                    <input type="text" class="form-control"  name="captcha" required>
                    <img src="?s=admin/login/captcha" alt="" style="margin-top: 2px;" onclick="this.src=this.src + '&mt='+ Math.random()">
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="auto"> 7天免登陆
                    </label>
                </div>
                <button type="submit" class="btn btn-default">登陆</button>
            </form>

        </div>
    </div>
</div>
</body>
</html>