<?php
class DepartMentModel extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	//insert into data
	public function insert($arr){
		$this->db->insert('system_users_role',$arr);
		return $this->db->insert_id('system_users_role');
	}
	//delete data
	public function delete($id){
		$this->db->where('roleid',$id);
		$this->db->delete('system_users_role');
		return $this->db->affected_rows();
	}

	function update($id,$update){

		$dat = $this->db->where('roleid', $id)->update('system_users_role', $update);
		return $this->db->affected_rows();
	}
	public function count($arr = array()) {
		$count = $this->db->count_all('system_users_role');
		return $count;
	}
	//取出所有数据
	public function select(){
		//$this->db->where('id',$id);
		$this->db->select('*');
		$query = $this->db->get('system_users_role');
		return $query->result_array();
		//注意如果你返回的是以下内容的话，他就是一个对象的结果集，这样当你返回controller中时，你就得转换；
//     return $query->result();
	}
	//取出单行数据
	public function select_one($id){
		$this->db->where('roleid',$id);
		$this->db->select('*');
		$query = $this->db->get('system_users_role');
		return $query->row_array();
	}
	public function result($id = '',$affect='fetchAll'){ // $affect   fetchAll返回全集  // row 返回单行
		if($id){
			$this->db->where('roleid',$id);
		}
		$this->db->select('*');
		$query = $this->db->get('system_users_role');
		if($affect == 'fetchAll') {
			return $query->result_array();
		}else{
			return $query->row_array();
		}
	}
}
