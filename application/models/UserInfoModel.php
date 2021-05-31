<?php
class UserInfoModel extends CommonModel{
	public function __construct(){
		parent::__construct();
	}
	
    public function getList($data){
        $min=($data['page']-1)*$data['limit'];
        $this->db->select('*');
        $this->db->from('userinfo');
        if(!empty($data['username'])){
            $this->db->like('realname', str_replace(" ",'',$data['username']));
        }
        $count= $this->db->count_all_results('',false);
       // echo $this->db->last_query();die;
        $this->db->limit($data['limit'],$min);
        $res=$this->db->get()->result_array();
        foreach ($res as $k => $v){
            $res[$k]['comratio'] = floatval($v['comratio'])."%";
        }
        $ret['list']=$res;
        $ret['count']=$count;
        return $ret;
    }

}


