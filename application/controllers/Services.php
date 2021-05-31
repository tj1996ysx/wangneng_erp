<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Services extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ServicesModel');
    }

    public function index()
    {
        if (IS_AJAX) {
            $res = $this->ServicesModel->getList($this->input->get());
            return showmsg("0", "查询成功", $res['count'], $res['list']);
        } else {
            $this->load->view('services/list');
        }
    }

    public function add()
    {
        if (IS_AJAX) {
            $data = $this->input->post();
            $param = [
                'customername' => $data['customername'],
                'cusstatus' => $data['cusstatus'],
                'customertype' => $data['customertype'],
                'linkaddress' => $data['linkaddress'],
                'adminid' => $this->session->userdata('admin_user_info')['userid'],
            ];
            $this->db->insert('services', $param);
            $res = $this->db->insert_id();
            if ($res) {
                return showmsg("0", "添加成功");
            } else {
                return showmsg("1", "添加失败");
            }
        }
        $this->load->view('services/add');
    }

    public function edit($id)
    {
        if (IS_AJAX) {
            $data = $this->input->post();
            $param = [
                'customername' => $data['customername'],
                'cusstatus' => $data['cusstatus'],
                'customertype' => $data['customertype'],
                'linkaddress' => $data['linkaddress'],
                'adminid' => $this->session->userdata('admin_user_info')['userid'],
            ];
            $res = $this->ServicesModel->update('services', ['customerid' => $id], $param);
            if (!$res) {
                return showmsg("1", "修改失败");
            }
            return showmsg("0", "修改成功");
        }
        $res = $this->ServicesModel->getOne('services', ['customerid' => $id]);
        $this->load->view('services/edit', $res);
    }

    public function delete()
    {
        if(IS_AJAX){
            $customerid = $this->input->post('customerid');
            $res = $this->ServicesModel->update('services',['customerid' => $customerid],['cusstatus' => 2,'adminid' => $this->session->userdata('admin_user_info')['userid']]);
            if(!$res){
                return showmsg("1", "删除失败");
            }
            return showmsg("0", "删除成功");
        }
        $this->load->view('home/index');
    }
}

?>
