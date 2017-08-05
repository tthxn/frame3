<?php
//设置命名空间，和其他命名空间区分开来，解决类名或者函数出现重名的情况
namespace app\admin\controller;
//载入hd\core\Controller类，控制跳转，成功提示，错误提示等
use hd\core\Controller;
use hd\model\Model;
//载入hd\view\View类，控制模板的载入
use hd\view\View;
//载入system\model\Stu类，给hd\model\Model提供数据表参数等
use system\model\Stu;
//载入system\model\Grade类，给hd\model\Model提供数据表参数等
use system\model\Grade;
//载入system\model\Material类，给hd\model\Model提供数据表参数等
use system\model\Material;

/**
 * Class Student学生控制器
 * @package app\admin\controller
 */
class Student extends Common
{
    /**
     * 显示学生
     * @return mixed
     */
    public function lists(){
//        因为要获取学生的班级信息，需要联表stu和grade进行操作，用get方法只能获取单张表的信息，
//        因此这里用hd\model\Model中的q方法
        $data = Model::q("SELECT * FROM stu s LEFT JOIN grade g ON s.gid=g.gid");
//        载入模板，hd\view\View控制模板文件，hd\view\View中实例化Base，Base中make方法返回一个对象
//        返回给hd\view\View中，hd\view\View又将对象返回当前这个页面，此时又将对象返回给hd\core\Boot中
//        hd\core\Boot中有echo类，触发hd\view\View中Base中的__toString方法，引入模板文件
        return View::make()->with(compact('data'));
    }


    /**
     * 添加学生信息
     */
    public function add(){
//        当用户点击提交的时候
        if(IS_POST){
//            处理爱好，因为提交过来的爱好是一个数组，无法存在数据库中，因此我们需要将数组转换成字符串
            if(isset($_POST['hobby'])){
//                将爱好的数组根据 , 转化成字符串
                $_POST['hobby'] = implode(',',$_POST['hobby']);
            }
//         将用户传递过来的数据传递给stu数据表，静态调用system\model\Stu类中的save方法，未找到此方法，那么在
//         父类hd\model\Model中寻找，触发__callStatic方法，进入hd\model\Base类中，调用save方法
            Stu::save($_POST);
//        跳转列表页、提示……父类hd\core\Controller控制页面跳转，成功提示等
            return $this->setRedirect('?s=admin/student/lists')->success('添加成功');
        }

//        获得班级信息
        $gradeData = Grade::get();
//        获得素材信息
        $materialData = Material::get();
//        载入模板，hd\view\View控制模板文件，hd\view\View中实例化Base，Base中make方法返回一个对象
//        返回给hd\view\View中，hd\view\View又将对象返回当前这个页面，此时又将对象返回给hd\core\Boot中
//        hd\core\Boot中有echo类，触发hd\view\View中Base中的__toString方法，引入模板文件
        return View::make()->with(compact('gradeData','materialData'));
    }

    /**
     * 修改
     */
    public function update(){
//        获取要修改哪一条的sid
        $sid = $_GET['sid'];
//        当用户提交表单的时候
        if(IS_POST){
//            处理爱好，因为提交过来的爱好是一个数组，无法存在数据库中，因此我们需要将数组转换成字符串
            if(isset($_POST['hobby'])){
//                将爱好的数组根据 , 转化成字符串，
                $_POST['hobby'] = implode(',',$_POST['hobby']);
            }
//            对 stu表中的数据进行编辑，未找到system\model\Stu中的where方法,寻找 Stu的父类hd\model\Model找中where方法
//            触发父类中__callStatic,跳转到hd\model\Base中
            Stu::where("sid={$sid}")->update($_POST);
//        跳转列表页、提示……父类hd\core\Controller控制页面跳转，成功提示等
            return $this->setRedirect('?s=admin/student/lists')->success('修改成功');
        }

//        获取旧的信息
        $oldData = Stu::find($sid);
//        p($oldData);
//        Array
//        (
//            [sid] => 3
//            [sname] => 123
//            [birthday] => 2017-08-05
//            [sex] => 女
//            [hobby] => 篮球,足球,乒乓球
//            [profile] => upload/170802/5981279e680ec.jpg
//            [gid] => 6
//        )
//        将从数据库中获取的爱好的字符串由原来的字符串重新转成数组
//        这样才能在修改页面的复选框内对应多个个人爱好
            $oldData['hobby'] = explode(',',$oldData['hobby']);
//            p($oldData);
//        Array
//        (
//            [sid] => 3
//            [sname] => 123
//            [birthday] => 2017-08-05
//            [sex] => 女
//            [hobby] => Array
//                            (
//                                [0] => 篮球
//                                [1] => 足球
//                                [2] => 乒乓球
//                            )
//
//            [profile] => upload/170802/5981279e680ec.jpg
//            [gid] => 6
//        )

//        获得班级信息
        $gradeData = Grade::get();
//        获得素材信息
        $materialData = Material::get();
//        载入模板，hd\view\View控制模板文件，hd\view\View中实例化Base，Base中make方法返回一个对象
//        返回给hd\view\View中，hd\view\View又将对象返回当前这个页面，此时又将对象返回给hd\core\Boot中
//        hd\core\Boot中有echo类，触发hd\view\View中Base中的__toString方法，引入模板文件
        return View::make()->with(compact('oldData','gradeData','materialData'));
    }


    /**
     * 删除
     */
    public function remove(){
//        通过use system\model\Stu载入类，静态调用Stu类中的where方法，Grade中的where方法不存在，寻找父类Model中的
//        where方法，自动触发hd\model\Model  中的__callStatic方法，找到hd\model\Base中的where方法，where方法返回一个对象
//        回到本页面，之后，同样的过程在hd\model\Base中调用destroy方法，进行数据销毁
        Stu::where("sid={$_GET['sid']}")->destroy();
//        跳转、提示……父类hd\core\Controller控制页面跳转，成功提示等
        return $this->setRedirect('?s=admin/student/lists')->success('删除成功');
    }




}