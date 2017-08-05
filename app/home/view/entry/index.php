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
            <h3 class="panel-title"><b>学生信息管理</b> <a href="?s=admin/entry/index" style="float: right;">去后台</a></h3>
        </div>
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>头像</th>
                        <th>姓名</th>
                        <th>性别</th>
                        <th>所属班级</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $k=>$v):?>
                        <tr>
                            <td><?php echo $k+1; ?></td>
                            <td>
                                <img src="<?php echo $v['profile'] ?>" width="70" alt="">
                            </td>
                            <td><?php echo $v['sname']; ?></td>
                            <td><?php echo $v['sex']; ?></td>
                            <td><?php echo $v['gname']; ?></td>
                            <td>
                                <a href="?s=home/entry/show&sid=<?php echo $v['sid']?>">详细信息</a>
                            </td>

                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>