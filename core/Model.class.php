<?php

namespace core;

class Model{

    private $_host;//ip地址 1
	private $_port;//端口号 2
	private $_char;//字符集 3
	private $_db;//数据库 4
	private $_user;//用户名 5
	private $_pwd;//密码 6
	private $_dsn;//连接数据库 7
	protected $_pdo;//pdo

	public function __construct($host='',$port='',$char='',$db='',$user='',$pwd=''){
		$this->_host=empty($host) ? C('pdo.mysql.host') :$host;
		$this->_port=empty($port) ? C('pdo.mysql.port') :$port;
		$this->_char=empty($char) ? C('pdo.mysql.charset') :$char;
		$this->_db=empty($db) ? C('pdo.mysql.dbname') :$db;
		$this->_user=empty($user) ? C('pdo.mysql.user') :$user;
		$this->_pwd=empty($pwd) ? C('pdo.mysql.pwd') :$pwd;
		$this->_dsn="mysql:host={$this->_host};port={$this->_port};charset={$this->_char};dbname={$this->_db}";

        $this->_pdo=new \PDO($this->_dsn,$this->_user,$this->_pwd);
        if( is_object($this->_pdo) ){
            $this->_pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
        }else{
            echo '创建对象失败'; 
            exit;
        }
	}
	/************************************************************/
	/**
     * 方法名: setData1
     * 方法作用: 直接传SQL语句实现增删改的方法
     * 参数
     * @param  $sql  string  SQL语句
     */
	public function setData1($sql){
		try{//监听可能出现错误的代码
			$this->_pdo->exec($sql);
		}catch(\PDOException $aa){//捕获异常,并且进行捕获异常后的处理.

			if( C('pdo.mysql.debug') ) $this->debug($aa);
		}
		return true;
	
    }
    //批量新增
    //批量更新
    //预处理
    /**
     * 方法名: setData
     * 方法作用: 实现增删改的方法
     * 参数
     * @param  $tbname  string  表名
     * @param  $datas  array  需要设置的数据，
            $type值为1则表示新增的数据，例：$datas=array('name'=>'zhangsan', 'age'=>12);
            $type值为2则表示更新的数据，例：$datas=array('name'=>'zhangsan', 'age'=>12);
            $type值为3则表示删除，$datas为删除的条件，例：$datas=array('id'=>1, 'acc'=>'zhangsan');
     * @param  $type  int  设置数据的类型，1表示新增，2表示修改，3表示删除
     * @param  $condition  array  更新数据的条件，例：$condition=array('id'=>1, 'acc'=>'zhangsan');
     */
    public function setData($tbname, $datas, $type=1, $condition=array(), $upd_not_use_quote_fields=[]){ 

        //处理设置的数据
        $arrDatas = array();
        foreach( $datas as $datas_key=>$data ):

            if(!empty($upd_not_use_quote_fields) && in_array($datas_key, $upd_not_use_quote_fields))
                $arrDatas[] = '`'.$datas_key.'`='.$data;
            else
                $arrDatas[] = '`'.$datas_key.'`="'.$data.'"';
        endforeach;
        $strDatas = implode(',', $arrDatas);

        //根据$type值构建SQL语句
        switch ( $type ){
            case 1://新增语句
                $sql = 'insert into `' . $tbname . '` set ' . $strDatas;//拼接SQL语句
            break;
            case 2://更新语句
                #处理更新条件
                $con = array();
                foreach( $condition as $k=>$v ){ 

                    $con[] = '`' . $k . '`' . '="' . $v . '"';
                }
                $con = implode(',', $con);
                $sql = 'update `' . $tbname . '` set ' . $strDatas . ' where ' . $con;

                // var_dump($sql);
                // exit;
                
            break;
            case 3://删除语句
                $sql = 'delete from `' . $tbname . '` where ' . $strDatas;
            break;
        }

        try{//监听可能出现错误的代码
			$this->_pdo->exec($sql);
		}catch(\PDOException $aa){//捕获异常,并且进行捕获异常后的处理.

			if( C('pdo.mysql.debug') ) $this->debug($aa);
		}

        if( $type==1 ){//执行的是新增操作
            return $this->_pdo->lastInsertId();
        }else{
            return true;
        }
    }
    /**
     * 方法名: GN
     * 方法作用: 根据指定条件查询记录条数（Get Number）
     * 参数
     * 
     * @param    string    $tbname
     * @param    array|string    $fieldsVals    如：$fieldsVals=['id'=>10, 'name'=>'zhangsan'];
     * @param    int    $type    指定条件的类型；
                    如果$type=1，表示将$fieldsVals的所有元素作为组合条件查询，将会返回查询的记录条数
                    如果$type=2，表示将$fieldsVals的每个元素单独作为一个条件查询，也就是有多少个元素，查训多少次，第一次查出大于0的值，则将这个值作为返回值返回
                    如果$type=3, 表示$fieldsVals为字符串条件语句
     *
     * 注意：$type=2时，最大支持的$fieldsVals的元素总个数为5个。
     */
    public function GN($tbname, $fieldsVals=1, $type=1){ 
        
        if( $type==1 ):

            if( $fieldsVals==1 ){
                $condition = 1;
            }else {
                $arrCon = array();
                foreach( $fieldsVals as $k=>$v ){ 
                    $arrCon[] = $k . '="' . $v . '"';
                }
                $condition = implode(' and ', $arrCon);
            }
            
            $sql = "select count(*) as num from {$tbname} where {$condition}";
            $row = $this->getRow($sql);
            return $row['num'];

        elseif( $type==2 ):

            foreach( $fieldsVals as $k=>$v ){ 
                $condition = $k . '="' . $v . '"';
                $sql = "select count(*) as num from {$tbname} where {$condition}";
                $row = $this->getRow($sql);
                if( $row['num']>0 ){
                    return $row['num'];
                }
            }
            return 0;
        elseif( $type==3 ):

            $sql = "select count(*) as num from {$tbname} where {$fieldsVals}";
            $row = $this->getRow($sql);
            if( $row['num']>0 ){
                return $row['num'];
            }
            return 0;
        endif;
    }
	/*******************************************************************************/
    /**
     * 方法名: getRow
     * 方法作用: 返回查询的一条数据
     * 参数
     * @param  $sql  string  SQL语句
     */
	public function getRow($sql){
		try{//监听可能出现错误的代码
			$pddostatement=$this->_pdo->query($sql);
		}catch(\PDOException $aa){//捕获异常,并且进行捕获异常后的处理.

			if( C('pdo.mysql.debug') ) $this->debug($aa);
		}
		return $pddostatement->fetch(\PDO::FETCH_ASSOC);
	}
	/*******************************************************************************/
	/**
     * 方法名: getRows
     * 方法作用: 返回查询的多条数据
     * 参数
     * @param  $sql  string  SQL语句
     */
	public function getRows($sql){
		try{//监听可能出现错误的代码
			$pddostatements=$this->_pdo->query($sql);
		}catch(\PDOException $aa){//捕获异常,并且进行捕获异常后的处理.

            if( C('pdo.mysql.debug') ) $this->debug($aa);
		}
		return $pddostatements->fetchAll(\PDO::FETCH_ASSOC);
	}

    //输出错误信息
    private function debug($e){ 
        echo '错误消息内容'.$e->getMessage();echo '<br/>';
        echo '错误代码'.$e->getCode();echo '<br/>';
        echo '错误程序文件名称'.$e->getFile();echo '<br/>';
        echo '错误代码在文件中的行号'.$e->getLine();echo '<br/>';
        exit;
    }
}