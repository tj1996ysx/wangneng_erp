<?php
class CommissionModel extends CommonModel{
	public function __construct(){
		parent::__construct();
	}
	
    public function getList($data){
        $min=($data['page']-1)*$data['limit'];
        $this->db->select('c.*,u.realname as name');
        $this->db->from('commission as c');
        $this->db->join('userinfo as u','u.userid = c.userid','left');
        if(!empty($data['name'])){
            $this->db->like('u.realname', $data['name']);
        }

        if(isset($data['paystatus']) && strlen($data['paystatus']) > 0){
            $this->db->where('c.paystatus',$data['paystatus']);
        }
        $count= $this->db->count_all_results('',false);
       // echo $this->db->last_query();die;
        $this->db->limit($data['limit'],$min);
        $res=$this->db->get()->result_array();
        foreach ($res as $k => $v){
            $res[$k]['comamount'] = floatval($v['comamount']);
            $res[$k]['comratio'] = floatval($v['comratio']).'%';
            $res[$k]['allprofit'] = floatval($v['allprofit']);
            $res[$k]['profitamount'] = floatval($v['profitamount']);
        }
        $ret['list']=$res;
        $ret['count']=$count;
        return $ret;
    }

}


