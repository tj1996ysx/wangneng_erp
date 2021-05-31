<?php

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
//        $this->db->where('userid=1');
//        $this->db->select('*');
//        $query = $this->db->get('system_users');
//        $userinfo  = $query->row_array();
        //    $this->session->set_userdata('userinfo',$userinfo);
        $model = $this->router->class;
        if($model != 'extension'){
            if (!$this->session->userdata('admin_user_info')) {
                redirect("/login");
            }
            //获取控制和方法

            if ($model != "home") {
                $action = $this->router->method;
                if (!checkrole($model, $action)) {
                    echo "无权限";
                    die;
                }
            }
        }

        $class = $this->router->class;
        $method = $this->router->method;
       
        $datas['menuname'] = $this->menuname($class,$method);
        $datas['current_url'] =  current_url();
        $this->load->vars($datas);
        //lx(getmenu());
        // var_dump(checkrole($model,$action));
    }
    //储存操作日志
//    public function SetLogs($txt,$data){
//        $datas=['optxt'=>$_SESSION['userinfo']['username'].$txt,'op'=>$this->router->fetch_class(),'tag'=>$this->router->fetch_method(),'addtime'=>date('Y-m-d H:i:s'),'paraminfo'=>$data,'ipaddr'=>$_SERVER['REMOTE_ADDR'],'userid'=>$_SESSION['userinfo']['userid']];
//        $this->db->insert('system_log',$datas);
//    }
    //菜单名称
    private function menuname($class,$method) {
       
        $row =  $this->db->select('name')->where(array("model"=>$class,"action"=>$method))->get("system_menu")->row_array();
        return $row['name'];
      
    }
}

class ApiController extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }

    /**
     * @Notes:   数据验证
     * @Function form_verify
     * @param $data
     * @param $rule
     * @return bool
     */
    function form_verify($data, $rule)
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        //验证传输过来的数据必须定义为数组,以及不能为空
        if(!empty($rules) || !is_array($data)){
            $error['msg'] = "验证数据格式错误！";
            $error['sign'] = FALSE;
            return $error;
        }
        //将前端提交数据添加到CI验证过程中
        $this->form_validation->set_data($data);
        //添加验证
        if ($this->form_validation->run($rule) == FALSE) {
            $error['msg'] = $this->form_validation->error_array();
            $error['sign'] = FALSE;
            return $error;
        } else {
            $error['sign'] = TRUE;
            return $error;
        }
    }
}

?>
