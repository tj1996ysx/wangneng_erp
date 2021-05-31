<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Trendcontrol extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('TrendcontrolModel');
    }

    public function index()
    {
        if (IS_AJAX) {
            $res = $this->TrendcontrolModel->getList($this->input->get());
            return showmsg("0", "查询成功", $res['count'], $res['list']);
        } else {
            $this->load->view('trendcontrol/list');
        }
    }
}

?>
