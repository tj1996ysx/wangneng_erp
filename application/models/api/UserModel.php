<?php
class UserModel extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function insert($arr){
		$res=$this->db->insert('system_users',$arr);
		return $res;
	}

	//登录
	public function check($where){
		$this->db->where($where);
		$this->db->select('*');
		$query = $this->db->get('userinfo');
		return $query->row_array();
	}


}
