<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Article extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ArticleModel');
    }

    public function index()
    {
        if (IS_AJAX) {
            $res = $this->ArticleModel->getList($this->input->get());
            return showmsg("0", "查询成功", $res['count'], $res['list']);
        } else {
            $this->load->view('article/list');
        }
    }

    public function add()
    {
        if (IS_AJAX) {
            $data = $this->input->post();
            $param = [
                'title' => $data['title'],
                'content' => $data['content'],
                'adminid' => $this->session->userdata('admin_user_info')['userid'],
            ];

            $this->db->insert('article', $param);
            $res = $this->db->insert_id();
            if ($res) {
                return showmsg("0", "添加成功");
            } else {
                return showmsg("1", "添加失败");
            }
        }
        $this->load->view('article/add');
    }

    public function edit($id)
    {
        if (IS_AJAX) {
            $data = $this->input->post();
            $param = [
                'title' => $data['title'],
                'content' => $data['content'],
                'adminid' => $this->session->userdata('admin_user_info')['userid'],
            ];
            $res = $this->ArticleModel->update('article', ['articleid' => $id], $param);
            if (!$res) {
                return showmsg("1", "修改失败");
            }
            return showmsg("0", "修改成功");
        }
        $res = $this->ArticleModel->getOne('article', ['articleid' => $id]);
        $this->load->view('article/edit', $res);
    }

    public function delete()
    {
        if(IS_AJAX){
            $articleid = $this->input->post('articleid');
            $param = [
                'is_delete' => 1,
                'adminid' => $this->session->userdata('admin_user_info')['userid'],
            ];
            $res = $this->ArticleModel->update('article',['articleid' => $articleid],$param);
            if(!$res){
                return showmsg("1", "删除失败");
            }
            return showmsg("0", "删除成功");
        }
        $this->load->view('home/index');
    }
}

?>
