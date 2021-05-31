<?php
if(!defined('BASEPATH'))exit('No direct script access allowed');
use \Firebase\JWT\JWT;
class Home extends ApiController {
	public function __construct(){
		parent::__construct();
		$this->load->model('api/UserModel');
	}

	public function login()
	{
		$arruser = $this->input->post();
		//写入验证数据数组以及验证规则配置文件中的名称
		$result = $this->form_verify($arruser, "api_user_login");
		if (!$result['sign']) {//验证未通过
			return showmsg("413", array_shift($result['msg']));
		}
		$res = $this->UserModel->check(array('username'=>$arruser['username'],'password'=>$arruser['password']));
		if($res)
		{
			if($res['ipallow']==1){
				$nowtime = time();
				$token = [
					'iss' => 'http://www.helloweba.net', //签发者
					'aud' => 'http://www.helloweba.net', //jwt所面向的用户
					'iat' => $nowtime, //签发时间
					'nbf' => $nowtime, //在什么时间之后该jwt才可用
					'exp' => $nowtime + 600, //过期时间-10min
					'data' => [
						'userid' => $res['userid'],
						'username' => $res['username']
					]
				];
				$jwt = JWT::encode($token, KEY);
				$res['result'] = 'success';
				$res['jwt'] = $jwt;
				return showmsg("200", '登录成功');
			}else {
				return showmsg("1", '账号已关闭');
			}
		}
		else
		{
			return showmsg("1", '用户名或者密码不对');
		}
	}

	public function register()
	{

	}
}
?>
