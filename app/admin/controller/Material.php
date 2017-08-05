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
//为了引入的Material模型与当前页面Material类区分开来，我们把引入的Material模型起一个别名
use system\model\Material as MaterialModel;
//载入hd\view\View类，控制模板的载入
use hd\view\View;

/**
 * Class Material素材控制器
 * @package app\admin\controller
 */
class Material extends Common
{
    /**
     * 显示素材列表
     */
    public function lists(){
//        MaterialModel是system\model中的Material类，调用get方法，在system\model\Material未找到方法，走他们父类
//        hd\model\Model,并且 system\model\Material是子类，在父类中获取子类的名称作为数据表名，进行传参
//        （创建的时候，我们要求数据表名和创建的类名的一样），又走了Model中的Base调用里面的get方法，返回数据到这里
        $data = MaterialModel::get();
//        载入模板，hd\view\View控制模板文件，hd\view\View中实例化Base，Base中make方法返回一个对象
//        返回给hd\view\View中，hd\view\View又将对象返回当前这个页面，此时又将对象返回给hd\core\Boot中
//        hd\core\Boot中有echo类，触发hd\view\View中Base中的__toString方法，引入模板文件
        return View::make()->with(compact('data'));
    }

    /**
     * 添加素材
     */
    public function add(){
//        当用户点击提交的时候，请求方式由GET变成POST,在hd\core\Boot定义了常量IS_POST
        if(IS_POST){
//            上传 ，返回上传的信息
            $info = $this->upload();
//            把上传之后的信息保存在数据库
            $data = [
                'path'  => $info['path'],
                'create_time' => time()
            ];
//         将用户传递过来的数据传递给material数据表，静态调用system\model\Material类中的save方法，未找到此方法，那么在
//          父类hd\model\Model中寻找，触发__callStatic方法，进入hd\model\Base类中，调用save方法
            MaterialModel::save($data);
//            调用父类中的方法进行页面跳转，提示上传成功
            return $this->setRedirect('?s=admin/material/lists')->success('上传成功');
        }
//      载入模板
        return View::make();
    }

    /**
     * 文件上传
     */
    private function upload(){
//        创建上传目录
        $dir = 'upload/' . date('ymd');
//        当$dir不是文件的时候，创建文件
        is_dir($dir) || mkdir($dir,0777,true);
        //设置上传目录
        $storage = new \Upload\Storage\FileSystem( $dir );
        $file    = new \Upload\File( 'upload', $storage );
        //设置上传文件名字唯一
        // Optionally you can rename the file on upload
        $new_filename = uniqid();
        $file->setName( $new_filename );

        //设置上传类型和大小
        // Validate file upload
        // MimeType List => http://www.iana.org/assignments/media-types/media-types.xhtml
        $file->addValidations( array(
            // Ensure file is of type "image/png"
            new \Upload\Validation\Mimetype( [ 'image/png', 'image/gif', 'image/jpeg'] ),

            //You can also add multi mimetype validation
            //new \Upload\Validation\Mimetype(array('image/png', 'image/gif'))

            // Ensure file is no larger than 5M (use "B", "K", M", or "G")
            new \Upload\Validation\Size( '2M' )
        ) );

        //组合数组
        // Access data about the file that has been uploaded
        $data = array(
            'name'       => $file->getNameWithExtension(),
            'extension'  => $file->getExtension(),
            'mime'       => $file->getMimetype(),
            'size'       => $file->getSize(),
            'md5'        => $file->getMd5(),
            'dimensions' => $file->getDimensions(),
            //自己组合的上传之后的完整路径
            'path'       => $dir . '/' . $file->getNameWithExtension(),
        );


        // Try to upload file
        try {
            // Success!
            $file->upload();

            return $data;
        } catch ( \Exception $e ) {
            // Fail!
            $errors = $file->getErrors();
            foreach ( $errors as $e ) {
                throw new \Exception( $e );
            }

        }
    }

    /**
     * 删除,  分两步走:  1、删除图片  2、删除数据库中的信息
     * @return $this
     */
    public function remove(){
//        获取从地址栏传入的要删除的图像mid
        $mid=$_GET['mid'];
//        获取这个图像的所有信息,MaterialModel走system\model\Material中的Material类,未找到find方法,寻找父类中
//        hd\model\Model中的find方法,之后跳转到hd\model\Base中,找到find方法,将结果按照原路返回至本页
//        为了从material表格中获取图像存储的路径信息
        $data = MaterialModel::find($mid);

//        删除文件,如果$data['path']是一个文件,那么就删除这个文件
        is_file($data['path']) && unlink($data['path']);

//        删除数据库
//        通过use system\model\Material载入类，静态调用Material类中的where方法，Grade中的where方法不存在，寻找父类Model中的
//        where方法，自动触发hd\model\Model  中的__callStatic方法，找到hd\model\Base中的where方法，where方法返回一个对象
//        回到本页面，之后，同样的过程在hd\model\Base中调用destroy方法，进行数据销毁
        MaterialModel::where("mid={$mid}")->destroy();
//            调用父类中的方法进行页面跳转，提示删除成功
        return $this->setRedirect('?s=admin/material/lists')->success('删除成功');
    }
}