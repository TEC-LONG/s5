<?php

namespace core;
use \core\NiceModel;

class Model extends NiceModel{

    protected $table;
    protected $select;
    protected $limit;
    protected $where=[];
    protected $left_join=[];

    protected $e;
    protected $sql;
    protected $pdostatement;

    protected $fields;
    protected $insert=[];
    protected $flag;//操作标识  'insert':新增操作  'update':更新操作    'delete':删除操作

    protected $update=[];
    protected $update_fields=[];

    public function table($table){
        $this->table= $table;
        return $this;
    }

    public function select($select){
        $this->select = $select;
        return $this;
    }

    public function where($where){

        if( $this->is2arr($where)==1 ){//一维数组  $where=['name', '=', 'xxx']
            
            $where[0] = '`' . $where[0] . '`';//字段两侧加反引号
            if( count($where)==3 ){//三个元素  $where=['name', '=', 'xxx']

                $where[2] = '"' . $where[2] . '"';//数据两侧加双引号
                $where = implode('', $where);
            }else{//两个元素  $where=['name', 'xxx']
                
                $where[1] = '"' . $where[1] . '"';
                $where = $where[0] . '=' . $where[1];
            }
            
        }elseif( $this->is2arr($where)==2 ){//二维数组    $where=[['name', '=', 'xxx'], ['age', '>=', 10]]

            $tmp = [];
            foreach( $where as $one){
                
                $one[0] = '`' . $one[0] . '`';
                if( count($one)==3 ){//三个元素  $one=['name', '=', 'xxx']

                    $one[2] = '"' . $one[2] . '"';//  "xxx"
                    $tmp1 = implode('', $one);// name="xxx"
                }else{//两个元素  $one=['name', 'xxx']

                    $one[1] = '"' . $one[1] . '"';
                    $tmp1 = $one[0] . '=' . $one[1];
                }
                
                $tmp[] = $tmp1;
            }

            $where = implode(' and ', $tmp);//    name="xxx" and age="10"
        }

        $this->where[] = str_replace('\'', '"', $where);//统一数据包裹符号为双引号
        return $this;
    }

    public function limit($limit){
    
        $this->limit = ' limit ' . $limit;
        return $this;
    }

    public function leftjoin($right_tb, $on){

        $this->left_join[] = ' left join ' . $right_tb . ' on ' . $on;
        return $this;
    }

    protected function query($type=1){

        if( $type==1 )://执行查询
            
            $sql = $this->get_sql();

            try{
                $this->pdostatement=$this->_pdo->query($sql);
            }catch(\PDOException $e){//捕获异常,并且进行捕获异常后的处理.
    
                $this->e = $e;//记录错误对象
                if( C('pdo.mysql.debug') ){
                    $this->dbug('err.echo');//如果为调试模式，则直接输出
                }else{
                    $this->dbug('err.log');//如果是非调试模式，则记录日志
                }
                return false;
            }
            return true;
        elseif ($type==2)://执行增，删，改

            $sql = $this->get_sql(2);
            // echo '<pre>';
            // var_dump($sql);
            // echo '<pre>';
            // exit;
            
            if( is_array($sql) ){//本条件只对批量更新有效，若为批量更新，则使用事务
            
                $this->_pdo->beginTransaction();
                $is_ok = 1;
                foreach( $sql as $one_sql){
                
                    try{
                        $this->_pdo->exec($one_sql);
                    }catch(\PDOException $e){
            
                        $this->e = $e;//记录错误对象
                        if( C('pdo.mysql.debug') ){
                            $this->dbug('err.echo', $one_sql);
                        }else{
                            $this->dbug('err.log', $one_sql);
                        }
                        $this->_pdo->rollBack();//有问题则立即回滚
                        return false;//并且终止继续执行
                    }
                }

                $this->_pdo->commit();//全部执行成功则提交事务
            }else{

                try{
                    $this->_pdo->exec($sql);
                }catch(\PDOException $e){
        
                    $this->e = $e;//记录错误对象
                    if( C('pdo.mysql.debug') ){
                        $this->dbug('err.echo');
                    }else{
                        $this->dbug('err.log');
                    }
                    return false;
                }
            }

            return true;
        endif;
    }

    protected function get_sql($type=1){

        $sql = '';
        if( $type==1 ){//返回查询sql语句

            $sql = 'select %s from %s%s where %s';
            $sql = sprintf($sql, $this->select, $this->table, implode(' ', $this->left_join), implode(' and ', $this->where));

            if(!empty($this->limit)) $sql .= ' ' . $this->limit;

            // $sql = 'select ' . $this->select . ' from ' . $this->table . implode(' ', $this->left_join) . ' where ' . implode(' and ', $this->where);
            // if(!empty($this->limit)) $sql .= ' ' . $this->limit;
        }elseif ($type==2){ //返回 增/删/改 SQL语句

            if( $this->flag==='insert' )://新增
                //      insert into xx (x, x, x) values (x, x, x)
                $sql = 'insert into %s %s values %s';
                $sql = sprintf($sql, $this->table, $this->fields, implode(',', $this->insert));
            elseif ($this->flag==='update')://更新
    
                $count_fields = count($this->update_fields);
                $count_update = count($this->update);
                $count_where = count($this->where);

                $is_accordance = ($count_fields===$count_update) && ($count_fields===$count_where);

                // if(!$is_accordance) echo '字段、数据和条件配对不一致！';

                if( $count_fields===1 ){//单条更新
                
                    $count_fields_son = count($this->update_fields[0]);
                    $count_update_son = count($this->count_update[0]);
                    
                    // if($count_fields_son!==$count_update_son) echo '字段个数与数据个数不匹配';

                    $sql = 'update %s set %s where %s';

                    $tmp_arr_target = [];
                    foreach( $this->update_fields[0] as $k=>$field){
                        $tmp_arr_target[] = '`'.$field.'`='.$this->update[0][$k];
                    }
                    $target = implode(',', $tmp_arr_target);

                    $sql = sprintf($sql, $this->table, $target, $this->where[0]);

                }else{//批量更新
                    
                    $sql = [];
                    foreach( $this->update_fields as $k=>$fields_row){
                    
                        $count_fields_son = count($this->fields_row);
                        $count_update_son = count($this->count_update[$k]);

                        // if($count_fields_son!==$count_update_son) echo '字段个数与数据个数不匹配';

                        $tmp_sql = 'update %s set %s where %s';

                        $tmp_arr_target = [];
                        foreach( $fields_row as $k1=>$field){
                            $tmp_arr_target[] = '`'.$field.'`='.$this->update[$k][$k1];
                        }
                        $target = implode(',', $tmp_arr_target);

                        $sql[] = sprintf($tmp_sql, $this->table, $target, $this->where[$k]);
                    }
                }
                
            elseif ($this->flag==='delete')://删除
                
            endif;
        }

        return $this->sql=$sql;
    }

    public function fields($fields){
    
        if( is_array($fields) ){//传进来的是数组  $fields=['name', 'age',...]

            if( $this->is2arr($fields)==1 ){

                $this->update_fields[] = $fields;//这个操作只针对搜集更新字段有效
                $this->fields = '(`' . implode('`,`', $fields) . '`)';
            }elseif ( $this->is2arr($fields)==2 ) {//这个操作只针对搜集更新字段有效
                
                foreach( $fields as $row){
                    $this->update_fields[] = $row;
                }
            }
            
        }else {//传进来的是字符串  $fields='name, age,...'

            $tmp = explode(',', $fields);
            $this->update_fields[] = array_map(function ($val){
                return trim($val);
            }, $tmp);//这个操作只针对搜集更新字段有效

            $this->fields = '(' . $fields . ')';//针对新增
        }
        return $this;
    }

    public function update($update){

        if( $this->is2arr($update)==1 ){//一维数组  $insert=['zhangsan', 12]

            $this->update[] = array_map(function ($val){
                return '"' . str_replace('"', '\'', $val) . '"';
            }, $update);
        
        }elseif ($this->is2arr($update)==2) {//二维数组  $insert=[['zhangsan', 12],['lisi', 13]]
            
            foreach( $update as $row){
            
                $this->update[] = array_map(function ($val){
                    return '"' .  str_replace('"', '\'', $val) . '"';
                }, $row);
            }
        }
    
        $this->flag = 'update';//操作标识， update代表接下来如果调用exec方法则将执行update操作
        return $this;
    }

    public function insert($insert){
        
        if( $this->is2arr($insert)==1 ){//一维数组  $insert=['zhangsan', 12]或$insert=['name'=>'zhangsan', 'age'=>12]

            $tmp_keys = array_keys($insert);
            if(!is_numeric($tmp_keys[0])){//键为字符串类型，则表示传进来的数组下表代表字段名，值为数据值
                $this->fields = '(`' . implode('`,`', $tmp_keys) . '`)';
            }

            $tmp = array_map(function ($val){
                return '"' . str_replace('"', '\'', $val) . '"';//为数据两边加上双引号包裹
            }, $insert);
            $this->insert[] = '(' . implode(',', $tmp) . ')';
        
        }elseif ($this->is2arr($insert)==2) {//二维数组  $insert=[['zhangsan', 12],['lisi', 13]]
            
            foreach( $insert as $insert_val){
            
                $tmp = array_map(function ($val){
                    return '"' . str_replace('"', '\'', $val) . '"';//为数据两边加上双引号包裹
                }, $insert_val);

                $this->insert[] = '(' . implode(',', $tmp) . ')';
            }
        }else {//字符串    $insert = '"zhangsan", 12'
            $this->insert[] = '(' . $insert . ')';
        }

        $this->flag = 'insert';//操作标识， insert代表接下来如果调用exec方法则将执行insert操作
        return $this;
    }

    public function exec(){

        if( $this->query(2) )
            return true;
        else
            return false;
    }

    /**
     * method:获取多条数据
     * @return 二维数组
     */
    public function get(){
        
        $re = $this->query();

        if( $re )
            return $this->pdostatement->fetchAll(\PDO::FETCH_ASSOC);
        else
            return [];
    }

    /**
     * method:获取一条数据
     * @return 一维数组
     */
    public function find(){
    
        $this->limit('1');
        $re = $this->query();

        if( $re )
            return $this->pdostatement->fetch(\PDO::FETCH_ASSOC);
        else
            return [];
    }

    public function replace(){
    
    }

    

    public function del(){
    
    }

    /**
     * method:调试
     * @param $flag string 调试标识
     * @param $e object 当调试错误时才需要传入的捕获的错误对象
     * @return 根据不同的$flag返回不同的结果
        $flag         结果
        'sql'         返回当前SQL语句
        'err.echo'    输出错误
        'err.log'     记录错误到日志文件
     */
    public function dbug($flag='sql', $sql=''){

        $sql = !empty($sql) ? $sql : $this->sql;
    
        if( $flag==='sql' )://调试返回当前SQL语句

            return $sql;
        elseif ($flag==='err.echo')://输出错误

            echo '时间：' . date('Y-m-d H:i:s');echo '<br/>';
            echo '错误消息内容：'.$this->e->getMessage();echo '<br/>';
            echo '错误代码：'.$this->e->getCode();echo '<br/>';
            echo '错误程序文件名称：'.$this->e->getFile();echo '<br/>';
            echo '错误代码在文件中的行号：'.$this->e->getLine();echo '<br/>';
            echo 'SQL语句：' . $sql;echo '<br/>';
            exit;
        elseif ($flag==='err.log')://记录错误到日志文件

            $log = "-----------------------------------------------------------------\n";
            $log .= '时间：' . date('Y-m-d H:i:s') . "\n";
            $log .= '错误消息内容：'.$this->e->getMessage() . "\n";
            $log .= '错误代码：'.$this->e->getCode() . "\n";
            $log .= '错误程序文件名称：'.$this->e->getFile() . "\n";
            $log .= '错误代码在文件中的行号：'.$this->e->getLine() . "\n";
            $log .= 'SQL语句：'.$sql . "\n";
            $log .= "=================================================================\n";
            $log .= "\n";
        endif;
    }

    /**
     * method:判断传入的数组是一维数组还是二维数组
     * @param $arr array 需要判断的数组
     * @return 0:不是数组；1:一维数组；2:二维数组
     */
    protected function is2arr($arr){

        if(!is_array($arr)) return 0;//不是数组

        if (count($arr)==count($arr, 1)) {
            return 1;//一维数组
        } else {
            return 2;//二维数组
        }
    }
}