<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("MenuModel");
    }

    public function index() {
        if (IS_AJAX) {
            $count = $this->MenuModel->count();
            if ($count) {
                $res = $this->MenuModel->getall();
                return showmsg("0", "查询成功", $count, $res);
            } else {
                return showmsg("0", "数据为空");
            }
            echo $res;
        } else {
            $this->load->view('menu/index');
        }
    }

    public function del() {
        die;
        if (IS_AJAX) {
            $id = $this->input->post('id');
            //判断是否存在子分类
            $dat = $this->MenuModel->issetchild($id);
            if ($dat) {
                return showmsg("1", '该分类下含有子分类，不能删除');
            }
            $res = $this->MenuModel->delete($id);
            if ($res) {
                return showmsg("0", '删除成功');
            } else {
                return showmsg("1", '删除失败');
            }
        }
    }

    public function add() {
        if (IS_AJAX) {
            $data = array(
                'name' => $this->input->post('name'),
                'parent' => $this->input->post('parent'),
                'status' => $this->input->post('status'),
                'sort' => $this->input->post('sort'),
                'action' => $this->input->post('action'),
                'model' => $this->input->post('model'),
            );
            $res = $this->MenuModel->insert($data);
            if ($res) {
                return showmsg("0", '添加成功');
            } else {
                return showmsg("1", '添加失败');
            }
        } else {
            $res = $this->MenuModel->getall();
            $data['list'] = getTree($res, $id = 'id', $pid = 'parent');
            $this->load->view('menu/add', $data);
        }
    }

    public function edit() {
        if (IS_AJAX) {
            $data = array(
                'name' => $this->input->post('name'),
                'parent' => $this->input->post('parent'),
                'status' => $this->input->post('status'),
                'sort' => $this->input->post('sort'),
                'action' => $this->input->post('action'),
                'model' => $this->input->post('model'),
            );
            $id = $this->input->post('id');
            $list = $this->MenuModel->getall();
            $list = tree($list, $data['parent'], 'id', 'parent');
            foreach ($list as $v) {
                if ($v['id'] == $id) {
                    return showmsg("1", "不能以自身或子孙栏目做自己的父栏目");
                }
            }
            $res = $this->MenuModel->update($id, $data);
            if ($res) {
                return showmsg("0", '修改成功');
            } else {
                return showmsg("1", '修改失败');
            }
        } else {
            $id = $this->input->get('id');
            $res = $this->MenuModel->getone($id);
            $data['row'] = $res;
            $res = $this->MenuModel->getall();
            $data['list'] = getTree($res, $id = 'id', $pid = 'parent');
            $this->load->view('menu/edit', $data);
        }
    }

}

?>
