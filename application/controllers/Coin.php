<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Coin extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('CoinModel');
    }

    public function index()
    {
        if (IS_AJAX) {
            $res = $this->CoinModel->getList($this->input->get());
            return showmsg("0", "查询成功", $res['count'], $res['list']);
        } else {
            $this->load->view('coin/list');
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
                'coincode' => $data['coincode'],
                'coinstatus' => $data['coinstatus'],
                'recommand' => $data['recommand'],
                'adminid' => $this->session->userdata('admin_user_info')['userid'],
                'addtime' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('coin', $param);
            $res = $this->db->insert_id();
            if ($res) {
                return showmsg("0", "添加成功");
            } else {
                return showmsg("1", "添加失败");
            }
        }
        $this->load->view('coin/add');
    }

    public function edit($id)
    {
        if (IS_AJAX) {
            $data = $this->input->post();
            $param = [
                'coincode' => $data['coincode'],
                'coinstatus' => $data['coinstatus'],
                'recommand' => $data['recommand'],
                'adminid' => $this->session->userdata('admin_user_info')['userid'],
            ];
            $res = $this->CoinModel->update('coin', ['coinid' => $id], $param);
            if (!$res) {
                return showmsg("1", "修改失败");
            }
            return showmsg("0", "修改成功");
        }
        $res = $this->CoinModel->getOne('coin', ['coinid' => $id]);
        $this->load->view('coin/edit', $res);
    }

    public function delete()
    {
        if(IS_AJAX){
            $coinid = $this->input->post('coinid');
            $res = $this->CoinModel->update('coin',['coinid' => $coinid],['coinstatus' => 2,'adminid' => $this->session->userdata('admin_user_info')['userid'],]);
            if(!$res){
                return showmsg("1", "删除失败");
            }
            return showmsg("0", "删除成功");
        }
        $this->load->view('home/index');
    }
}

?>
