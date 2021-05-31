<?php
if(!defined('BASEPATH'))exit('No direct script access allowed');
class Sysuser extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('SysUserModel');
		$this->load->model('DepartMentModel');
	}
	public function index()
	{
		if (IS_AJAX) {
			$count = $this->SysUserModel->count();
			if ($count) {
				$res = $this->SysUserModel->select();
				//查出所处部门中文名
				foreach ($res as $k=>$v)
				{
					$res[$k]['rolename']=$this->DepartMentModel->select_one($v['roleid'])['chinesename'];
				}
				return showmsg("0", "查询成功", $count, $res);
			} else {
				return showmsg("0", "数据为空");
			}
			echo $res;
		}
		else {
			$this->load->view('sysuser/index');
		}
	}
	public  function add()
	{
		if (IS_AJAX) {
			$data = array(
				'username' => $this->input->post('username'),
				'password' => md5($this->input->post('password')),
				'realname' => $this->input->post('realname'),
				'mobile' => $this->input->post('mobile'),
				'roleid' => $this->input->post('roleid'),
				'ipallow' => $this->input->post('ipallow'),
				'createtime'=>date("Y-m-d H:i:s"),
			);
			$res = $this->SysUserModel->insert($data);
			if ($res) {
				return showmsg("0", '添加成功');
			} else {
				return showmsg("1", '添加失败');
			}
		} else {
			$res = $this->SysUserModel->select();
			$data['list'] =$res;
			$departinfo=$this->DepartMentModel->select();
			$data['departinfo']=$departinfo;
			$this->load->view('sysuser/add', $data);
		}
	}
	public function del()
	{
		if (IS_AJAX) {
			$id = $this->input->post('userid');
			$res = $this->SysUserModel->delete($id);
			if ($res) {
				return showmsg("0", '删除成功');
			} else {
				return showmsg("1", '删除失败');
			}
		}
	}
	public function edit()
	{
		if (IS_AJAX) {
			if($this->input->post('password'))
			{
				$data = array(
					'username' => $this->input->post('username'),
					'realname' => $this->input->post('realname'),
					'mobile' => $this->input->post('mobile'),
					'password' => md5($this->input->post('password')),
					'roleid' => $this->input->post('roleid'),
					'ipallow' => $this->input->post('ipallow'),
				);
			}
			else
			{
				$data = array(
					'username' => $this->input->post('username'),
					'realname' => $this->input->post('realname'),
					'mobile' => $this->input->post('mobile'),
					'roleid' => $this->input->post('roleid'),
					'ipallow' => $this->input->post('ipallow'),
				);
			}
			$id = $this->input->post('userid');
			$res = $this->SysUserModel->update($id, $data);
			if ($res) {
				return showmsg("0", '修改成功');
			} else {
				return showmsg("1", '修改失败');
			}
		}
		else {
			$id = $this->input->get('userid');
			$res = $this->SysUserModel->select_one($id);
			$data['row'] = $res;
			$departinfo=$this->DepartMentModel->select();
			$data['departinfo']=$departinfo;
			$this->load->view('sysuser/edit', $data);
		}
	}
}
?>
