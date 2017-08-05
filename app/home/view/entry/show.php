<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="./static/bs3/css/bootstrap.min.css">

</head>
<body>
<div class="container" style="margin-top: 20px;">
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">学生详细信息 <a href="./index.php" style="float: right;">返回</a></h3>
    </div>
    <div class="panel-body">

        <table class="table table-hover">
           <tr>
               <td>ID</td>
               <td><?php echo $data['sid'] ?></td>
           </tr>
            <tr>
                <td>姓名</td>
                <td><?php echo $data['sname'] ?></td>
            </tr>
            <tr>
                <td>性别</td>
                <td><?php echo $data['sex'] ?></td>
            </tr>
            <tr>
                <td>出生年月</td>
                <td><?php echo $data['birthday'] ?></td>
            </tr>
            <tr>
                <td>爱好</td>
                <td><?php echo $data['hobby'] ?></td>
            </tr>
            <tr>
                <td>所属班级</td>
                <td><?php echo $data['gname'] ?></td>
            </tr>
        </table>



    </div>
</div>
</div>
</body>
</html>