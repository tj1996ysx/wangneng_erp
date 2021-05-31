<?php
class CommonModel extends CI_Model{
	public function __construct(){
		parent::__construct();
	
	}

    /**
       * 查询分页数据（使用于简单的单表操作）
       * @param string $model 模型     例如：User_model
       * @param string $table 表名
       * @param string $select_fields 要显示字段
       * @param array $param 查询条件：
       *   compare（比较）:
       *     array($key => $val) $key为要操作的字段，$val为要操作的值
       *     array('name !=' => $name, 'id <' => $id, 'date >' => $date);
       *   like(模糊查询)
       *     array('title' => $match, 'page1' => $match, 'page2' => $match)
       *   customStr（自定义字符串）:
       *     "name='Joe' AND status='boss' OR status='active'"
       *   in:
       *     array('userName' => array('Frank', 'Todd', 'James'))
       * @param string $page 当前页数（查询全部数据时，设置为空）
       * @param string $limit 查询条数（查询全部数据时，设置为空）
       * @param array $order 排序条件：
       *   array($key => $val)
       *   $key为排序依据的字段，
       *   $val为排序的方式【asc (升序，默认)或 desc(降序), 或 random(随机)】
       * @$isReturnCount boole    是否返回总条数
       * @return array|boolean
       *
   */
    public function pageData($table, $param = array(),$select_fields = '*', $page = '1', $limit = '20', $order = array(),$isReturnCount = true,$where=[]){

        if(empty($table)){
            return false;
        }
        $table = $this->db->dbprefix.$table;
        //处理查询字段
        
        $this->db->select($select_fields)->from($table);
        
        //处理查询条件
        if (is_array($param) && count($param) > 0){
            $this->parseParam($param);
        }
        //统计总数
        if($isReturnCount){
            $rs['count']  = $this->db->count_all_results('',false);//不重置查询构造器
           //  echo $this->db->last_query();
           
        }
        //分页数据处理
        if(isset($page) && isset($limit)){
          //分页边界值 设置
            $offset = $page <= 1 ? 0 : ($page-1) * $limit;
			
            $this->db->limit($limit, $offset);
        }
        // if($where){
        //   $this->db->where($where);
        // }
        //排序规则的组合
        if (!empty($order) && is_array($order))
        {
            foreach ($order as $key => $val){
                $this->db->order_by($key, $val);
            }
        }
        $query = $this->db->get();
        
        $rs['list'] = $query->result_array();
        //echo $this->db->last_query();
        return $rs;
    }
  /**
   * 解析参数
   */
    private function parseParam($param){

        if(isset($param['compare'])){
            foreach ($param['compare'] as $key => $val){
                $this->db->where($key, $val);
            }
        }
        if(isset($param['like'])){
            foreach ($param['like'] as $key => $val){
                if (!empty($val)) $this->db->like($key, $val);
            }
        }
        if(isset($param['in'])){
            foreach ($param['in'] as $key => $val){
                if (!empty($val)) $this->db->where_in($key, $val);
            }
        }
        if(isset($param['customStr'])){
            if (!empty($val)) $this->db->where($param['customStr']);
        }
    }
      /**
       * 新增信息
       * @param string $table 表名称
       * @param array $param 数据变量
       * @return INT ID
       */
      public function add($table = '', $param = array())
      {
        if(empty($table) || !is_array($param) || empty ($param)){
            return FALSE;
        }
        //写入数据表
        $this->db->insert($table, $param);
      
        //返回记录ID
        return $this->db->insert_id();
      }
      public function PLadd($table = '', $param = array())
      {
        if(empty($table) || !is_array($param) || empty ($param)){
            return FALSE;
        }
        //写入数据表
        $this->db->insert_batch($table, $param);
      
        //返回记录ID
        return $this->db->insert_id();
      }
      /**
       * 更新分类信息
       * @param string  $table   表名称
       * @param string  $primary  表主键
       * @param int    $id     分类ID
       * @param array   $param   更新的数据
       * @return type
       */
    public function update($table = '',$where, $param = array()){
        if(empty($table) ||  empty($param) || empty($where))
        {
            return FALSE;
        }
        $this->db->where($where)
            ->update($table, $param);
		   // echo $this->db->last_query();die;
		    return true;
        return $this->db->affected_rows();
    }
    
  /**
   * 删除指定ID记录
   * @param string  $table   表名称
   * @param string  $primary  表主键
   * @param array   $id     分类ID
   * @return int
   */
    public function delete($table = '', $primary = '', $id = array()){
        if(empty($table) || empty($primary) || empty($id)){
            return FALSE;
        }
        $this->db->where_in($primary, $id)
            ->delete($table);
        return $this->db->affected_rows();
    }
    //获取单条数据
    public function getOne($table,$where=[],$fields="*"){
        $result = $this->db->select($fields)->where($where)->get($table)->row_array();
		    //echo $this->db->last_query();
		    return $result;
    }
	  //获取单条数据
    public function getAll($table,$param = array(),$fields="*",$order='',$sort='',$limit=''){
      if (is_array($param) && count($param) > 0){
        $this->db->where($param);
      }
      if($limit){
        $result = $this->db->select($fields)->order_by($order,$sort)->limit($limit,0)->get($table)->result_array();
      }else{
        $result = $this->db->select($fields)->order_by($order,$sort)->get($table)->result_array();
      }
      //echo $this->db->last_query();die;
		  return $result;
    }

    public function updateOrInsert($table = '',$where, $param = array()){
        $res = $this->getOne($table,$where);
        if(!empty($res)){
          $result = $this->update($table,$where,$param);
        }else{
          $result =  $this->add($table,$param);
        }
        return $result;
    }


}
