<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Coinaddress extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('CoinaddressModel');
    }

    public function index()
    {
        if (IS_AJAX) {
            $res = $this->CoinaddressModel->getList($this->input->get());
            return showmsg("0", "查询成功", $res['count'], $res['list']);
        } else {
            $this->load->view('coinaddress/list');
        }
    }

    public function add()
    {
        if (IS_AJAX) {
            $data = $this->input->post();
//            $user = $this->CoinaddressModel->getOne('userinfo',['userid' => $data['user']]);
//            if(empty($user)){
//                return showmsg("1", "输入的用户ID不存在");
//            }
//            $coinaddress_one = $this->CoinaddressModel->getOne('coin',['coinid' => $data['coincode'],'coinstatus' => 1],'coincode');
//            if(empty($coinaddress_one)){
//                return showmsg("1", "充值虚拟币代码ID不存在");
//            }
//            $coincode = $coinaddress_one['coincode'];
            $param = [
                'coinaddress' => $data['coinaddress'],
                'coincode' => $data['coincode'],
                'adminid' => $this->session->userdata('admin_user_info')['userid'],
//                'userid'  => $data['user'],
                'addtime' => date('Y-m-d H:i:s')
            ];
//            $res = $this->CoinaddressModel->updateOrInsert('coinaddress',['coincode' => $coincode,'userid' => $data['user']],$param);
            $res = $this->CoinaddressModel->add('coinaddress',$param);
            if ($res) {
                return showmsg("0", "添加成功");
            } else {
                return showmsg("1", "添加失败");
            }
        }
        $data['coincode'] = $this->CoinaddressModel->getAll('coincode',[],'*');
        $this->load->view('coinaddress/add',$data);
    }

    public function edit($id)
    {
        if (IS_AJAX) {
            $data = $this->input->post();
            $param = [
                'coinaddress' => $data['coinaddress'],
                'coincode' => $data['coincode'],
                'adminid' => $this->session->userdata('admin_user_info')['userid'],
                'userid'  => $data['user'],
            ];
            $res = $this->CoinaddressModel->update('coinaddress', ['adsid' => $id], $param);
            if (!$res) {
                return showmsg("1", "修改失败");
            }
            return showmsg("0", "修改成功");
        }
        $res = $this->db->select('c.*,u.username')
            ->from('coinaddress as c')
            ->join('userinfo as u','c.userid = u.userid','left')
            ->where('c.adsid',$id)
            ->get()
            ->row_array();
        $this->load->view('coinaddress/edit', $res);
    }

    public function delete()
    {
        if(IS_AJAX){
            $param = [
                'adminid' => $this->session->userdata('admin_user_info')['userid'],
                'is_delete' => 1,
            ];
            $adsid = $this->input->post('adsid');
            $res = $this->CoinaddressModel->update('coinaddress',['adsid' => $adsid],$param);
            if(!$res){
                return showmsg("1", "删除失败");
            }
            return showmsg("0", "删除成功");
        }
        $this->load->view('home/index');
    }
}

?>
