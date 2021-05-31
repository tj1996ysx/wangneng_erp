<?php
class CoinModel extends CommonModel{
	public function __construct(){
		parent::__construct();
	}
	
    public function getList($data){
        $min=($data['page']-1)*$data['limit'];
        $this->db->select('c.*,u.username');
        $this->db->from('coin as c');
        $this->db->join('vc_system_users as u','c.adminid = u.userid','left');
        $this->db->where('c.coinstatus !=',2);
        if(!empty($data['coincode'])){
            $this->db->like('c.coincode', $data['coincode']);
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


