<?php
class ServicesModel extends CommonModel{
	public function __construct(){
		parent::__construct();
	}
	
    public function getList($data){
        $min=($data['page']-1)*$data['limit'];
        $this->db->select('*');
        $this->db->from('services as s');
        $this->db->where_in('s.cusstatus',[0,1]);
        $this->db->join('vc_system_users as u','s.adminid = u.userid','left');
        if(!empty($data['devicecode'])){
            $this->db->like('s.devicecode', $data['devicecode']);
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


