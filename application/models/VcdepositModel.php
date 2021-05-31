<?php
class VcdepositModel extends CommonModel{
	public function __construct(){
		parent::__construct();
	}
	
    public function getList($data){
        $min=($data['page']-1)*$data['limit'];
        $this->db->select('v.*,u.username,c.coinaddress');
        $this->db->from('vcdeposit as v');
        $this->db->join('userinfo as u','v.userid = u.userid','left');
        $this->db->join('coinaddress as c','v.adsid = c.adsid','left');
        if(!empty($data['username'])){
            $this->db->like('u.username', $data['username']);
        }

        if(isset($data['depositstatus']) && $data['depositstatus'] != ''){
            $this->db->where('v.depositstatus', $data['depositstatus']);
        }

        $count= $this->db->count_all_results('',false);
       // echo $this->db->last_query();die;
        $this->db->limit($data['limit'],$min);
        $res=$this->db->get()->result_array();
        foreach ($res as $k => $v){
            $res[$k]['depositnum'] = floatval($v['depositnum']);
            $res[$k]['depositusdt'] = floatval($v['depositusdt']);
            $res[$k]['customername'] = current($this->getOne('services',['customerid' => $v['customerid']],'customername'));
        }
        $ret['list']=$res;
        $ret['count']=$count;
        return $ret;
    }

}


