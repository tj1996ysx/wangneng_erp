<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blacklist extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('BlacklistModel');
    }

    public function index()
    {
        if (IS_AJAX) {
            $res = $this->BlacklistModel->getList($this->input->get());
            return showmsg("0", "查询成功", $res['count'], $res['list']);
        } else {
            $this->load->view('blacklist/list');
        }
    }

    public function add()
    {
        if (IS_AJAX) {
            $data = $this->input->post();
            $param = [
                'devicecode' => $data['devicecode'],
                'addtime' => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('blacklist', $param);
            $res = $this->db->insert_id();
            if ($res) {
                return showmsg("0", "添加成功");
            } else {
                return showmsg("1", "添加失败");
            }
        }
        $this->load->view('blacklist/add');
    }

//    public function delete()
//    {
//        if(IS_AJAX){
//            $blackid = $this->input->post('blackid');
//            $res = $this->BlacklistModel->delete('blacklist','blackid',[$blackid]);
//            if(!$res){
//                return showmsg("1", "删除失败");
//            }
//            return showmsg("0", "删除成功");
//        }
//        $this->load->view('home/index');
//    }
}

?>
