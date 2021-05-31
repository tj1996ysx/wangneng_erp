<?php
class LoginlogModel extends CommonModel{
	public function __construct(){
		parent::__construct();
	}
	
    public function getList($data){
        $min=($data['page']-1)*$data['limit'];
        $this->db->select('*');
        $this->db->from('login');
        if(!empty($data['search'])){
            $star_time = $data['search'].' 00:00:00';
            $end_time = $data['search'].' 23:59:59';
            $this->db->where(['addtime >=' => $star_time,'addtime <=' => $end_time]);
        }
        $count= $this->db->count_all_results('',false);
       // echo $this->db->last_query();die;
        $this->db->limit($data['limit'],$min);
        $res=$this->db->get()->result_array();
        $ret['list']=$res;
        $ret['count']=$count;
        return $ret;
    }

}


