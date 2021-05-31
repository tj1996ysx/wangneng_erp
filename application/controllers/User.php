<?php
if(!defined('BASEPATH'))exit('No direct script access allowed');
class User extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('UserInfoModel');
	}

	public function index()
	{
		if(IS_AJAX){
			$res = $this->UserInfoModel->getList($this->input->get());
			return showmsg("0", "查询成功", $res['count'], $res['list']);
		}
		$this->load->view('user/list');
	}



}
?>
