<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Commission extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('CommissionModel');
    }

    public function index()
    {
        if (IS_AJAX) {
            $res = $this->CommissionModel->getList($this->input->get());
            return showmsg("0", "查询成功", $res['count'], $res['list']);
        } else {
            $this->load->view('commission/list');
        }
    }
}

?>
