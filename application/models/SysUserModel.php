<?php
class SysUserModel extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	//insert into data
	public function insert($arr){
		$res=$this->db->insert('system_users',$arr);
		return $res;
	}
	//delete data
	public function delete($id){
		$this->db->where('userid',$id);
		$this->db->delete('system_users');
		return $this->db->affected_rows();
	}
	function update($id,$update){
		$dat = $this->db->where('userid', $id)->update('system_users', $update);
		return $this->db->affected_rows();
	}
	public function count($arr = array()) {
		$count = $this->db->count_all('system_users');
		return $count;
	}
	//select data
	public function select(){
		//$this->db->where('id',$id);
		$this->db->select('*');
		$query = $this->db->get('system_users');
		return $query->result_array();
	}
	public function select_one($id){
		$this->db->where('userid',$id);
		$this->db->select('*');
		$query = $this->db->get('system_users');
		return $query->row_array();
		//注意如果你返回的是以下内容的话，他就是一个对象的结果集，这样当你返回controller中时，你就得转换；
//     return $query->result();
	}
	public function result($id = '',$affect='fetchAll'){ // $affect   fetchAll返回全集  // row 返回单行
		if($id){
			$this->db->where('roleid',$id);
		}
		$this->db->select('*');
		$query = $this->db->get('system_users');
		if($affect == 'fetchAll') {
			return $query->result_array();
		}else{
			return $query->row_array();
		}
	}
	//登录
	public function check($where){
		$this->db->where($where);
		$this->db->select('*');
		$query = $this->db->get('system_users');
		return $query->row_array();
	}


}
