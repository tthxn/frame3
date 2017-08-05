<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/8/2
 * Time: 19:05
 */

namespace app\admin\controller;

//hd\core\Controller控制失败提示，成功提示
use hd\core\Controller;
//引入hd\view\View类，控制模板的载入
use hd\view\View;
//引入system\model\User类，system\model扩展模型目录，通过继承性载入数据表user，进行数据表的增改删除查找
use system\model\User;
//引入验证码的两个类
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

/**
 * Class login 用户登陆控制器
 * @package app\admin\controller
 */
class login extends Controller
{

    /**
     * @return $this登陆页面，判断用户名密码验证码是否正确，注意一定要进行addslashes转义
     */
    public function index(){
//        预先存入用户名和密码,密码用hash加密
//        $password = password_hash('111111',PASSWORD_DEFAULT);
//        echo $password;

//        当用户输入密码111111  用$post代替
//        可以用password_verify(用户登录传入的密码，数据库中存储的密码)来校验密码是否和哈希值匹配,
//        如果匹配，那么echo可以输出1，不匹配什么也无法输出
//        password_verify($post,$databaseSave['password'])

        if(IS_POST){

//            验证码错误,用户传入的验证码和session中的验证码不匹配
            if(strtolower($_POST['captcha']) != strtolower($_SESSION['captcha'])){
//                返回验证码输入错误的页面
                return $this->error('验证码错误');
            }

//            为了防止用户输入带有符号的内容出现报错的问题，我们需要将用户输入的数据进行转义，否则将会跳转到报错页面
            $post = addslashes($_POST['username']);
//            用户名错误,在user数据表中找不到这个用户名，那么用户名错误,$data是一个二位数组array（[0]=>[''=>'',''=>'',''=>'']）
            $data = User::where("username='{$post}'")->get();
//            p($data);exit;
            if(!$data){
                return $this->error("用户名不存在");
            }

//            密码错误
//        当用户输入密码111111  用$post代替
//        可以用password_verify(用户登录传入的密码，数据库中存储的密码)来校验密码是否和哈希值匹配,
//        如果匹配，那么echo可以输出1，不匹配什么也无法输出
//        password_verify($post,$databaseSave['password'])

//            密码错误
            if(!password_verify($_POST['password'],$data[0]['password'])){
                return $this->error("密码错误");
            }

            /**
             * 如果勾选了7天免登陆
             */
            if(isset($_POST['auto'])){
//                当用户勾选了7天免登陆，修改session的过期时间，由时间延长7天
                setcookie(session_name(),session_id(),time()+7*24*3600,'/');
            }else{
//                如果用户没有点击7天免登陆，过期时间设置为0，表示会话时间，即关闭浏览器再打开就需要重新登陆
                setcookie(session_name(),session_id(),0,'/');
            }

            /**
             * 将uid和username存储再数据库中
             */
            $_SESSION['user'] = [
                'uid'      => $data[0]['uid'],
                'username' => $data[0]['username'],
            ];
//            当用户用户名、密码、验证码全部输入正确，就跳转到后台首页
            return $this->setRedirect( '?s=admin/entry/index' )->success( '登陆成功' );

        }

//        载入模板文件
        return View::make();
    }


    /**
     * 退出
     */
    public function out(){
//        删除session中所有的变量
        session_unset();
//        删除session文件
        session_destroy();
//        退出之后重新登陆
        return $this->setRedirect("?s=admin/login/index")->success('退出成功');
    }
    /**
     * 验证码
     */
    public function captcha(){
//        截取microtime()每一分都不一样，用md5加密后可能有字母，有数字，截取3个
        $str = substr(md5(microtime(true)),0,3);
//        实例化CaptchaBuilder，用于调用内部的一些方法
        $builder = new CaptchaBuilder($str);
//        调用对象中的build方法，build方法控制验证码的正常运行
        $builder->build();
//        声明是一个图片
        header('Content-type: image/jpeg');
//        调用output方法，用于直接输出验证码（直接在页面上显示验证码）
        $builder->output();
//        把值存入session中，hd\core\Boot框架启动类中已经开启session
//        当用户输入验证码，匹配session中存储的内容，判断用户输入验证码是否正确
        $_SESSION['captcha'] = $builder->getPhrase();


    }
}