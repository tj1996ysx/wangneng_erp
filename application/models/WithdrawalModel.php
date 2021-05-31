<?php
class WithdrawalModel extends CommonModel{
	public function __construct(){
		parent::__construct();
	}
	
    public function getList($data){
        $min=($data['page']-1)*$data['limit'];
        $this->db->select('w.*,u.realname as name');
        $this->db->from('withdraw as w');
        $this->db->join('userinfo as u','u.userid = w.userid','left');
        if(!empty($data['name'])){
            $this->db->like('u.realname', $data['name']);
        }

        if(isset($data['withdrawstatus']) && strlen($data['withdrawstatus']) > 0){
            $this->db->where('w.withdrawstatus',$data['withdrawstatus']);
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


