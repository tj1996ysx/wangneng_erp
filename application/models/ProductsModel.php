<?php
class ProductsModel extends CommonModel{
	public function __construct(){
		parent::__construct();
	}
	
    public function getList($data){
        $min=($data['page']-1)*$data['limit'];
        $this->db->select('p.*,u.username');
        $this->db->from('products as p');
        $this->db->join('vc_system_users as u','p.adminid = u.userid','left');
        if(!empty($data['productname'])){
            $this->db->like('p.productname', $data['productname']);
        }

        if(isset($data['status'])){
            $this->db->where('p.status', $data['status']);
        }
        $count= $this->db->count_all_results('',false);
       // echo $this->db->last_query();die;
        $this->db->limit($data['limit'],$min);
        $this->db->order_by('productid desc');
        $res=$this->db->get()->result_array();
        foreach ($res as $k => $v){
            $res[$k]['lowcoin'] = floatval($v['lowcoin']);
            $res[$k]['lowprofit'] = floatval($v['lowprofit']).'%';
            $res[$k]['highprofit'] = floatval($v['highprofit']).'%';
        }
        $ret['list']=$res;
        $ret['count']=$count;
        return $ret;
    }

}


