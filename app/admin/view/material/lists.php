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
                <div class="panel-heading">
                    <div class="btn-group" role="group" aria-label="...">
                        <a href="?s=admin/material/lists" class="btn btn-default active">列表</a>
                        <a href="?s=admin/material/add" class="btn btn-default">添加</a>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>图像</th>
                                <th>路径</th>
                                <th>上传时间</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <?php foreach($data as $k => $v):?>
                            <tr>
                                <td><?php echo  $k+1; ?></td>
                                <td>
                                    <img src="<?php echo $v['path'];?>" alt="" width="80">
                                </td>
                                <td><?php echo $v['path']; ?></td>
                                <td><?php echo date('y/m/d H:i:s',$v['create_time']); ?></td>
                                <td>
                                    <a href="javascript:if(confirm('确定删除吗')) location.href='?s=admin/material/remove&mid=<?php echo $v['mid'] ?>';">删除</a>
                                </td>
                            </tr>
                        <?php endforeach ?>

                    </table>


                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>