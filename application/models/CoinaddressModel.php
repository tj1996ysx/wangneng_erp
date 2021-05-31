<?php
class CoinaddressModel extends CommonModel{
	public function __construct(){
		parent::__construct();
	}
	
    public function getList($data){
        $min=($data['page']-1)*$data['limit'];
        $this->db->select('c.*,u.username');
        $this->db->from('coinaddress as c');
        $this->db->join('vc_system_users as u','c.adminid = u.userid','left');
        $this->db->where('is_delete',0);
        if(!empty($data['search'])){
            $this->db->like('c.coincode', $data['search']);
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


