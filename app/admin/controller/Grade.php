<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/8/1
 * Time: 21:50
 */
//设置命名空间，和其他命名空间区分开来，解决类名或者函数出现重名的情况
namespace app\admin\controller;
//载入hd\core\Controller类，控制跳转，成功提示，错误提示等
use hd\core\Controller;
//载入hd\view\View类，控制模板的载入
use hd\view\View;
//为了引入的Grade模型与当前页面Grade类区分开来，我们把引入的Grade模型起一个别名
use system\model\Grade as GradeModel;

//这里不需要载入Common类，因为Common类和Grade是在同一个命名空间下面
/**
 * Class Grade班级控制器
 * @package app\admin\controller
 */
class Grade extends Common
{
    /**
     * 班级列表
     * @return mixed
     */
    public function lists(){
//        GradeModel是system\model中的Grade类，调用get方法，在system\model\Grade未找到方法，走他们父类
//        hd\model\Model,并且 system\model\Grade是子类，在父类中获取子类的名称作为数据表名，进行传参
//        （创建的时候，我们要求数据表名和创建的类名的一样），又走了Model中的Base调用里面的get方法，返回数据到这里
        $data = GradeModel::get();
//        载入模板，hd\view\View控制模板文件，hd\view\View中实例化Base，Base中make方法返回一个对象
//        返回给hd\view\View中，hd\view\View又将对象返回当前这个页面，此时又将对象返回给hd\core\Boot中
//        hd\core\Boot中有echo类，触发hd\view\View中Base中的__toString方法，引入模板文件
        return View::make()->with(compact('data'));
    }

    /**
     * @return $this添加班级
     */
    public function add(){
//        当用户点击添加的时候，将添加内容存储在数据库中
        if(IS_POST){
//                将用户传递过来的数据传递给arc数据表，静态调用system\model\Grade类中的save方法，未找到此方法，那么在
//                父类hd\model\Model中寻找，触发__callStatic方法，进入hd\model\Base类中，调用save方法
            GradeModel::save($_POST);
//        调用父类hd\core\Controller中的success方法，success返回一个对象，
//        接着调用父类hd\core\Controller中的setRedirect方法，所有准备工作完成后，
//        return给了hd\core\Boot.php中的appRun()方法，用echo输出，自动触发__toString
//        载入 include $this->template这个模板（$this->template是修改成功的中转页面）
            return $this->setRedirect('?s=admin/grade/lists')->success('添加成功');
        }
//        载入模板，hd\view\View类，控制模板的载入
        return View::make();
    }

    /**
     * 修改班级
     */
    public function update(){
//        获取用户从地址栏传递过来的要修改的哪一条内容
        $gid = $_GET['gid'];
//        当用户点击编辑的时候，进行数据库的操作
        if(IS_POST){
//            对 Grade表中的数据进行编辑，未找到system\model\Grade中的where方法,寻找 Grade的父类hd\model\Model找中where方法
//            触发父类中__callStatic,跳转到hd\model\Base中
            GradeModel::where("gid={$gid}")->update($_POST);
            return $this->setRedirect('?s=admin/grade/lists')->success('编辑成功');
        }
//        获取旧数据
        $oldData = GradeModel::find($gid);
//        载入模板，hd\view\View控制模板文件，hd\view\View中实例化Base，Base中make方法返回一个对象
//        返回给hd\view\View中，hd\view\View又将对象返回当前这个页面，此时又将对象返回给hd\core\Boot中
//        hd\core\Boot中有echo类，触发hd\view\View中Base中的__toString方法，引入模板文件
        return View::make()->with(compact('oldData'));
    }

    /**
     * 删除班级
     * @return $this
     */
    public function remove(){
//        通过use system\model\Grade载入类，静态调用Grade类中的where方法，Grade中的where方法不存在，寻找父类Model中的
//        where方法，自动触发hd\model\Model  中的__callStatic方法，找到hd\model\Base中的where方法，where方法返回一个对象
//        回到本页面，之后，同样的过程在hd\model\Base中调用destroy方法，进行数据销毁
        GradeModel::where("gid={$_GET['gid']}")->destroy();
        return $this->setRedirect('?s=admin/grade/lists')->success('删除成功');
    }

}