<?php
class DomainModel extends CommonModel{
	public function __construct(){
		parent::__construct();
	}
	
    public function getList($data){
        $min=($data['page']-1)*$data['limit'];
        $this->db->select('d.*,u.username');
        $this->db->from('domain as d');
        $this->db->where_in('domainstatus',[1,2]);
        $this->db->join('vc_system_users as u','d.adminid = u.userid','left');
        if(!empty($data['search'])){
            $this->db->like('d.domainname', $data['search']);
        }

        if(!empty($data['domainstatus'])){
            $this->db->where('d.domainstatus',$data['domainstatus']);
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


