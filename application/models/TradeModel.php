<?php
class TradeModel extends CommonModel{
	public function __construct(){
		parent::__construct();
	}
	
    public function getList($data){
        $min=($data['page']-1)*$data['limit'];
        $this->db->select('t.*,u.username');
        $this->db->from('trade as t');
        $this->db->join('userinfo as u','t.userid = u.userid','left');
        if(!empty($data['username'])){
            $this->db->like('u.username', $data['username']);
        }

        if(!empty($data['status'])){
            $this->db->where('status', $data['status']);
        }

        if(!empty($data['tradetype'])){
            $this->db->where('tradetype', $data['tradetype']);
        }
        $count= $this->db->count_all_results('',false);
       // echo $this->db->last_query();die;
        $this->db->limit($data['limit'],$min);
        $res=$this->db->get()->result_array();
        foreach ($res as $k => $v){
            $res[$k]['avgprice'] = floatval($v['avgprice']);
            $res[$k]['tradeamount'] = floatval($v['tradeamount']);
            if(isset($v['selltime'])){
                $res[$k]['profitamount'] = floatval($v['profitamount']);
                $res[$k]['sellprice'] = floatval($v['sellprice']);
                $res[$k]['profitratio'] = floatval($v['profitratio']).'%';
            }
        }
        $ret['list']=$res;
        $ret['count']=$count;
        return $ret;
    }

}


