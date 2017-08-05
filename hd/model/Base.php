<?php
//设置命名空间，和其他命名空间区分开来，解决类名或者函数出现重名的情况
namespace hd\model;
//引用系统的PDO
use PDO;
//引用系统的PDOException
use PDOException;

/**
 * Class Base模型类，进行数据库的一些操作：连接、删除、查找、修改、插入……
 * @package hd\model
 */
class Base
{
//    保存pdo对象的静态属性，初始值设置成null，是为了在连接数据库的时候，判断第一次$pdo是否为空
    private static $pdo =NULL;
//    保存表名的属性
    private $table;
//    保存where
    private $where;

//    构造函数，每一次实例化类，构造函数自动执行（静态调用的时候，构造函数不会自动执行）
    public function __construct($table)
    {
//        调用当前对象中的connect方法，连接数据库
        $this->connect();
//        表名字，就是传入的$table
        $this->table = $table;
    }

    /**
     * 连接数据库
     */
    private function connect(){
//        如果构造方法多次执行，那么这个方法也会多次执行，用静态属性可以把对象保存起来不丢失
//        第一次：self::$pdo为null，那么就正常连接数据库
//        第二次：self::$pdo已经保存了pdo对象了，不为null，就不再连接数据库
        if(is_null(self::$pdo)){
//            没有错误情况下，进行try内的操作，如果有异常错误，通过catch获取异常错误
            try{
//                dsn代表数据源，包括数据库类型（这里是mysql），主机地址，数据库名
//                $dsn = 'mysql:host=127.0.0.1;dbname=blog';
//                通过hd/core/functions.php中的c函数，引入system/config/database.php文件，调用文件中的用户配置项
//                这样如果需要修改数据库名字或者什么，不再需要修改核心文件中的内容，只需要修改system/config/XX.php的配置项文件即可
//                $dsn = "mysql:host=127.0.0.1;dbname=blog";
                $dsn = 'mysql:host='.c('database.db_host').';dbname='.c('database.db_name');

//                使用PDO连接数据库，如果有异常错误，catch会捕捉到
//                $pdo = new PDO($dsn,'root','root');
                $pdo = new PDO($dsn,c('database.db_user'),c('database.db_password'));
//                设置错误属性，要设置成异常错误，需要被catch捕捉到
                $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
//                转换成php使用的编码格式$pdo->exec('SET NAMES UTF8'));
                $pdo->exec('SET NAMES UTF8');
//                $pdo->exec('SET NAMES '.c('database.db_charset'));
//                把PDO对象放到静态属性中
                self::$pdo = $pdo;
            }catch(PDOException $e){//捕获异常错误（注意这里是异常错误，其他错误无法捕获，$e是自定义的传入的参数）
//                输出异常错误并且退出，getMessage()是固定写法
                echo "<span style='color:red'>".$e->getMessage()."</span>";
//                退出
                exit;
            }
        }
    }

    /**
     * 获取全部数据
     */
    public function get(){
//        没有错误情况下，进行try内的操作，如果有异常错误，通过catch获取异常错误
//        try{
        if(is_null($this->where)){
//        获取传过来的对应的表的数据，将对应的表添加到获取所有数据的SQL语句中，并通过有结果集的操作完成获取数据，并将获取的数据转换才关联数组返回到对应的对象
            $sql = "SELECT * FROM {$this->table}";
        }else{
            $sql="SELECT * FROM {$this->table} WHERE {$this->where}";
        }
//            根据传入的参数进行数据库的操作
//            $sql = "SELECT * FROM {$this->table}";
//        query用于执行有结果集的数据库操作，如：select  show……
            $result = self::$pdo->query($sql);
//        PDO::FETCH_ASSOC仅得到关联方式的数据，fetchAll获取全部数据  fetch是获取一条数据
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
//            返回结果给调用的地方
            return $data;
//        }catch(PDOException $e){//捕获异常错误（注意这里是异常错误，其他错误无法捕获，$e是自定义的传入的参数）
////          输出异常错误并且退出，getMessage()是固定写法
//            echo "<span style='color:red'>".$e->getMessage()."</span>";
////            退出
//            exit;
//        }
    }

    /**
     * 获取单条数据
     * $id 用户传入的要获取的aid的值
     */
    public function find($id){
//        获取主键
        $priKey = $this->getPriKey();
//        拼出完整的sql语句，用于传入的aid编号对应数据的查询,如：select * from arc where aid=22
        $sql = "SELECT * FROM {$this->table} WHERE {$priKey}={$id}";
//        调用当前对象中的q方法，执行有结果集的操作
        $data = $this->q($sql);
//        将二维数组变成一维数组
        return current($data);
    }

    /**
     * 获取主键
     */
    private function getPriKey(){
//        获取数据表的结构
        $sql = "DESC {$this->table}";
//        通过q方法执行数据库的操作，将获取到的数组传递给$data，后期可以通过遍历$data这个数组，从而找到主键
        $data = $this->q($sql);
/*  Array
(
    [0] => Array
         (
                [Field] => aid
                [Type] => int(11)
                [Null] => NO
                [Key] => PRI
                [Default] => [Extra] => auto_increment
        )
    [1] => Array
        (
            [Field] => title
            [Type] => char(20)
            [Null] => NO
            [Key] =>
            [Default] =>
            [Extra] =>
        )
    [2] => Array
        (
            [Field] => click
            [Type] => int(11)
            [Null] => NO
            [Key] =>
            [Default] => 0
            [Extra] =>
        )
)*/
        //主键,设置一个初始值，防止foreach中没有遍历出主键，当返回$primaryKey的时候出现报错的情况
        $primaryKey = '';
//        遍历数组中的数据，需要找到哪一条是主键
        foreach($data as $v){
//            如果$v['Key'] == 'PRI'，那么表示这个是主键
            if($v['Key'] == 'PRI'){
//                $v['Field']将获取到的字段名称赋值给$primaryKey，方便后期找到主键的字段名称
//                如：$primaryKey = aid
                $primaryKey = $v['Field'];
//                跳出此次循环
                break;
            }
        }
//        返回主键的字段名，给其他的方法调用
        return $primaryKey;
    }

    /**
     * where语句，用于修改、查找、删除某一字段内容条件语句
     * @param $where
     * @return $this
     */
    public function where($where){
//        用户传入的参数$where就是属性where的值，where方法在app/home/controller/Entry.php中被Arc静态调用，
//        Arc继承hd\model中的Model类，自动触发__callStatic方法
        $this->where = $where;
//        返回一个对象，返回给hd\model中的Model类，
//          hd\model\Model又将结果返回app/home/controller/Entry.php中index方法中
        return $this;
    }

    /**
     * 摧毁数据
     */
    public function destroy(){
//        为了阻止当删除操作没有加上where语句而删除全部内容的情况，先判断where条件是否存在，如果
//        不存在，就终止程序，
        if(!$this->where){
//            当where条件不存在的时候，输出内容，并且终止程序
            exit('delete必须要有where条件');
        }
//        拼凑出完整的sql语句，方便对于数据库进行操作
        $sql = "DELETE FROM {$this->table} WHERE {$this->where}";
//        用当前类中的e方法，执行无结果集的操作，返回给hd\model\Model中，Model类再将结果返回到s=home/entry/index中
        return $this->e($sql);
    }

    /**
     * 数据修改
     */
    public function update($data){
//        update语句需要where条件，如果没有，将会把所有内容替换掉，因此这里加上一个判断句，如果没有where条件，
//        输出原因，并且终止程序
        if(!$this->where){
//            当没有where条件的时候输出原因，并且终止程序
            exit("更新需要where条件");
        }
//        用户编辑之后传递而来的数据是如下情况
//        Array
//        (
//            [title] => 后盾，早上好
//            [click] => 0
//        )
//        设置一个初始变量，防止出现因为$set未定义而出现的报错问题
        $set = '';
//        遍历数组，拼接字符串，为了接下来sql语句中update传递参数使用
        foreach($data as $f => $v){
//            拼接字符串，第一次遍历$set = "title='后盾，早上好',",
//             第二次遍历：$set="title='后盾，早上好',click='0',"
            $set .= "{$f}='{$v}',";
        }
//        将拼接出来的字符串最右边的 , 给去掉
        $set = rtrim($set,',');
//        组合完整的sql的update语句
        $sql="UPDATE {$this->table} SET {$set} WHERE {$this->where}";
//        执行无结果集的操作，将结果返回给调用这个方法的类中，这里是返出hd\model\Model中，
//        由hd\model\Model（是由system\model\Arc继承自hd\model\Model的方法）返出数据给
//        调用system\model\Arc的s=home\entry\update（app\home\controller\Entry）方法中
        return $this->e($sql);
    }

    /**
     * 添加数据（数据库插入内容）
     */
    public function save($post){
//        查询当前表结构,如果想要用p函数打印出来，一定要在app\home\controller\Entry中调用
//          如在添加页面写上Arc::save($_POST),之后在这里可以p一下，就可以查看表结构
        $tableInfo = $this->q("DESC {$this->table}");
        $tableFields = [];
//        遍历查询表结构返回的数据，由本页中getPriKey方法注释中我们查看表的具体字段
        foreach($tableInfo as $v){
//            表字段：aid title click ，这里相当于重组数组$tableFields=['aid','title','click']
            $tableFields[] = $v['Field'];
        }
//        循环post提交过来的数据
//        post传递过来的数据：
//      Array
//        (
//            [title] => 2222,
//            [click] => 222,
//            [captcha] => 222
//        )
//        数据库中的字段只有aid ，title，click， 因为aid是主键，所以aid不需要传值，
//        数据库中没有captcha字段,因此我们需要将captcha字段过滤掉
//        设置一个空的数组，表示$filterData是一个数组用于foreach中数组数据的追加
        $filterData = [];
//        遍历post传递过来的数据，将不是表字段的内容过滤掉
        foreach ($post as $f => $v){
//            如果属于当前表字段，那么保留，否则过滤掉
            if(in_array($f,$tableFields)){
                $filterData[$f] = $v;
            }
        }
//        Array
//        (
//            [title] => 2222,
//            [click] => 222
//        )

//        eg：insert into arc (title,click) values ('标题','点击量');

//        字段
//        获取过滤后的键名，将他们变成字符串，用于sql语句中insert into 操作
        $fields = array_keys($filterData);
//        将获得的键名的数组转变成字符串,中间用 , 连接起来变成(title,click)的样子
        $fields = implode(',',$fields);

//        值
//        获取过滤后的键值，将他们变成字符串，用于sql语句中insert into 操作
        $values = array_values($filterData);
//        将获取到的键值的数组转变成字符串，中间用 , 隔开，连接起来变成('标题','点击量')的样子
//        implode("','",$values):  标题','点击量
        $values = "'".implode("','",$values)."'";

//        拼接完整的sql语句，用于数据库的插入操作
        $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$values})";
//        调用这个类中的e方法，存储在数据库中，返回受影响的条数，这里应该是1条，因为每次插入一条语句
        return $this->e($sql);
    }



    /**
     * exec用于执行无结果集的操作，如：delete   update  insert  alter……modify……   等
     * 删除数据、增加数据
     */
    public function e($sql){
//        进行try内的操作，如果有异常错误，通过catch获取异常错误
        try{
//            执行无结果集的操作，返回受影响的条数
            return self::$pdo->exec($sql);
        }catch(PDOException $e){//捕获异常错误（注意这里是异常错误，其他错误无法捕获，$e是自定义的传入的参数）
//            exit($e->getMessage());
            echo "<span style='color:red'>".$e->getMessage()."</span>";
//            退出
            exit;
        }
    }

    /**
     * query执行有结果集的操作：select  show  ……
     * @param $sql 传入的sql语句
     * @return mixed
     */
    public function q($sql){
//        因为hd\core\Boot中已经有错误处理机制了，因此这里不必再用catch获取异常错误了

//        没有错误情况下，进行try内的操作，如果有异常错误，通过catch获取异常错误
//        try{


//            执行有结果集的操作
            $result = self::$pdo->query($sql);
//            返回操作出来的受影响的结果
            return $result->fetchAll(PDO::FETCH_ASSOC);


//        }catch(PDOException $e){
////                输出异常错误并且退出，getMessage()是固定写法
//            echo "<span style='color:red'>".$e->getMessage()."</span>";
////            退出
//            exit;
//        }


    }

}