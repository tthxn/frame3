<div class="col-xs-3">
    <div class="list-group">
        <a href="#" class="list-group-item" style="background:#e6e6e6">管理</a>
        <a href="?s=admin/grade/lists"  <?php if(CONTROLLER == 'grade'): ?> style="background:#F5F5F5" <?php endif ?> class="list-group-item" >班级</a>
        <a href="?s=admin/material/lists" <?php if(CONTROLLER == 'material'): ?> style="background:#F5F5F5" <?php endif ?> class="list-group-item">素材</a>
        <a href="?s=admin/student/lists" <?php if(CONTROLLER == 'student'): ?> style="background:#F5F5F5" <?php endif ?> class="list-group-item">学生</a>
    </div>
</div>