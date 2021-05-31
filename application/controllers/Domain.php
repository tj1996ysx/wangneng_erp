<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Domain extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('DomainModel');
    }

    public function index()
    {
        if (IS_AJAX) {
            $res = $this->DomainModel->getList($this->input->get());
            return showmsg("0", "查询成功", $res['count'], $res['list']);
        } else {
            $this->load->view('domain/list');
        }
    }

    public function add()
    {
        if (IS_AJAX) {
            $data = $this->input->post();
            //写入验证数据数组以及验证规则配置文件中的名称
//            $result = $this->form_verify($data, "article");
//            if (!$result['sign']) {//验证未通过
//                return showmsg("1", array_shift($result['msg']));
//            }
            $param = [
                'domainname' => $data['domainname'],
                'serverport' => $data['serverport'],
                'domainstatus' => $data['domainstatus'],
                'adminid' => $this->session->userdata('admin_user_info')['userid'],
            ];
            $this->db->insert('domain', $param);
            $res = $this->db->insert_id();
            if ($res) {
                return showmsg("0", "添加成功");
            } else {
                return showmsg("1", "添加失败");
            }
        }
        $this->load->view('domain/add');
    }

    public function edit($id)
    {
        if (IS_AJAX) {
            $data = $this->input->post();
            $param = [
                'domainname' => $data['domainname'],
                'serverport' => $data['serverport'],
                'domainstatus' => $data['domainstatus'],
                'adminid' => $this->session->userdata('admin_user_info')['userid'],
            ];
            $res = $this->DomainModel->update('domain', ['domainid' => $id], $param);
            if (!$res) {
                return showmsg("1", "修改失败");
            }
            return showmsg("0", "修改成功");
        }
        $res = $this->DomainModel->getOne('domain', ['domainid' => $id]);
        $this->load->view('domain/edit', $res);
    }

    public function delete()
    {
        if(IS_AJAX){
            $domainid = $this->input->post('domainid');
            $res = $this->DomainModel->update('domain',['domainid' => $domainid],['domainstatus' => 3,'adminid' => $this->session->userdata('admin_user_info')['userid']]);
            if(!$res){
                return showmsg("1", "删除失败");
            }
            return showmsg("0", "删除成功");
        }
        $this->load->view('home/index');
    }
}

?>
