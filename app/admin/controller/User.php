<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/8/2
 * Time: 23:44
 */

namespace app\admin\controller;

//控制视图中的模板载入
use hd\view\View;
//载入数据表类
use system\model\User as UserModel;

/**
 * Class User 修改密码类
 * @package app\admin\controller
 */
class User extends Common
{
    /**
     * 修改密码
     */
    public function changePwd(){
//        当用户点击了提交按钮
        if(IS_POST){
//            1、先比对旧的密码是否正确
            $user = UserModel::where("uid='{$_SESSION['user']['uid']}'")->get();
//            将用户输入的密码和从数据库中读取的密码进行比对，如果不正确，返回旧密码错误
            if(!password_verify($_POST['oldPwd'],$user[0]['password'])){
//                返回旧密码错误
                return $this->error('旧密码错误');
            }

//            2、判断两次密码是否一致
            if($_POST['newPwd'] != $_POST['reNewPwd']){
//                返回错误原因
                return $this->error('两次密码不一致');
            }

//            3、修改，要修改的内容为$data
            $data = ['password' => password_hash($_POST['newPwd'],PASSWORD_DEFAULT)];
//            修改数据表user中的密码
            UserModel::where("uid='{$_SESSION['user']['uid']}'")->update($data);

//            删除session重新登陆
            session_unset();//删除session中所有的变量
            session_destroy();//删除session这个文件
//            重新登陆
            return $this->setRedirect('?s=admin/login/index')->success('修改成功');
        }
//        载入模板
        return View::make();
    }

}