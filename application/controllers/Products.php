<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');
class Products extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('ProductsModel');
    }

    public function index() {
        if (IS_AJAX) {
            $res = $this->ProductsModel->getList($this->input->get());
            return showmsg("0", "查询成功", $res['count'], $res['list']);
        }else{
            $this->load->view('products/index');
        }
    }

    public function add(){
        if (IS_AJAX) {
            $data = $this->input->post();
            $param = [
                'productname' => $data['productname'],
                'lowcoin' => floatval($data['lowcoin']),
                'lowprofit' => floatval($data['lowprofit']),
                'highprofit' => floatval($data['highprofit']),
                'productcycle' => $data['productcycle'],
                'deadlinetime' => $data['deadlinetime'],
                'status' => $data['status'],
                'adminid' => $this->session->userdata('admin_user_info')['userid'],
                'addtime' => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('products', $param);
            $res = $this->db->insert_id();
            if($res){
                return showmsg("0", "添加成功");
            }else{
                return showmsg("1", "添加失败");
            }
        }
        $this->load->view('products/add');
    }

    public function edit($id){
        if(IS_AJAX){
            $data = $this->input->post();
            $param = [
                'productname' => $data['productname'],
                'lowcoin' => floatval($data['lowcoin']),
                'lowprofit' => floatval($data['lowprofit']),
                'highprofit' => floatval($data['highprofit']),
                'productcycle' => $data['productcycle'],
                'deadlinetime' => $data['deadlinetime'],
                'status' => $data['status'],
                'adminid' => $this->session->userdata('admin_user_info')['userid'],
            ];
            $res = $this->ProductsModel->update('products',['productid' => $id],$param);
            if(!$res){
                return showmsg("1", "修改失败");
            }
            return showmsg("0", "修改成功");
        }
        $res = $this->ProductsModel->getOne('products',['productid' => $id]);
        $this->load->view('products/edit',$res);
    }
}

?>
