<?php
class WkbtradeModel extends CommonModel{
	public function __construct(){
		parent::__construct();
	}
	
    public function getList($data){
        $min=($data['page']-1)*$data['limit'];
        $this->db->select('w.*,u.username,p.productname');
        $this->db->from('wkbtrade as w');
        $this->db->join('userinfo as u','w.userid = u.userid','left');
        $this->db->join('products as p','w.productid = p.productid','left');
        if(!empty($data['productname'])){
            $this->db->like('p.productname', $data['productname']);
        }

        if(!empty($data['username'])){
            $this->db->like('u.username', $data['username']);
        }

        if(!empty($data['tradestatus'])){
            $this->db->where('tradestatus', $data['tradestatus']);
        }
        $count= $this->db->count_all_results('',false);
       // echo $this->db->last_query();die;
        $this->db->limit($data['limit'],$min);
        $res=$this->db->get()->result_array();
        foreach ($res as $k => $v){
            $res[$k]['coinnum'] = floatval($v['coinnum']);
            $res[$k]['tradeamount'] = floatval($v['tradeamount']);
            $res[$k]['expectprofit'] = floatval($v['expectprofit']);
        }
        $ret['list']=$res;
        $ret['count']=$count;
        return $ret;
    }

}


