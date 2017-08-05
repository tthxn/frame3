<?php
/**
 * 打印函数
 */
function p($var){
    echo '<pre style="background: #e6e6e6">';
    print_r($var);
    echo '</pre>';
}


//写一个c方法，当需要的时候，自动载入 （如：database.php）这一个文件，设置或者使用里面数据，如db_name
//c('database.db_name');
//c('Captcha.length')
function c($path)
{
//    将用户传入的内容根据.拆分成数组，如$path = database.db_name
    $arr = explode('.', $path);
//    $arr = ['database','db_name'] 拆分成数组之后
//    引入配置项文件，如database配置项文件放在system/config/database.php中
//    将获取到的数组内容返给$config
    $config = include "../system/config/" . $arr[0] . ".php";
//    返回$config文件中$arr[1]的值，如database.php中db_name项的值，return将值返出到hd/model/Model.php中的Base类中中
    return isset($config[$arr[1]]) ? $config[$arr[1]] : NULL;

}

/**go函数，用于app\admin\controller\Common中判断用户是否登陆，如果没有登陆，自动跳转到$url指向的登陆页面
 * @param $url
 */
function go($url){
    header("Location:{$url}");
    exit;
}