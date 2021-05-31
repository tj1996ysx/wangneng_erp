<?php
class TrendcontrolModel extends CommonModel{
	public function __construct(){
		parent::__construct();
	}
	
    public function getList($data){
        $min=($data['page']-1)*$data['limit'];
        $this->db->select('*');
        $this->db->from('trendcontrol');
        if(!empty($data['coincode'])){
            $this->db->like('coincode', $data['coincode']);
        }

        if(!empty($data['startDate'])){
            $this->db->where('starttime >=',$data['startDate']);
        }

        if(!empty($data['endDate'])){
            $this->db->where('endtime <=',$data['endDate']);
        }
        $count= $this->db->count_all_results('',false);
       // echo $this->db->last_query();die;
        $this->db->limit($data['limit'],$min);
        $res=$this->db->get()->result_array();
        foreach ($res as $k => $v){
            $res[$k]['rangeratio'] = floatval($v['rangeratio']);
        }
        $ret['list']=$res;
        $ret['count']=$count;
        return $ret;
    }

}


