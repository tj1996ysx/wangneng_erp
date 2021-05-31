<?php
class ArticleModel extends CommonModel{
	public function __construct(){
		parent::__construct();
	}
	
    public function getList($data){
        $min=($data['page']-1)*$data['limit'];
        $this->db->select('a.*,u.username');
        $this->db->from('article as a');
        $this->db->join('vc_system_users as u','a.adminid = u.userid','left');
        $this->db->where('is_delete',0);
        if(!empty($data['title'])){
            $this->db->like('a.title', $data['title']);
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


