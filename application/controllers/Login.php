<?php

if(!defined('BASEPATH'))exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('SysUserModel');
		$this->load->model('CommonModel');
	}
	public function index()
	{
		if(IS_AJAX)
		{
			$arruser=$this->input->post();
			$secode = strtolower($_SESSION['secode']);
		//	unset($_SESSION['secode']);
		 	$res = $this->SysUserModel->check(array('username'=>$arruser['username'],'password'=>md5($arruser['password'])));
		 	if($arruser['captcha']==$secode)
			{
				if($res)
				{
					if($res['ipallow']==1){
						$this->session->set_userdata('admin_user_info',$res);
						$_SESSION['admin_user_info']['userid'] = $res['userid'];
						$_SESSION['admin_user_info']['username'] = $res['username'];
						$_SESSION['admin_user_info']['roleid'] = $res['roleid'];
						$res = $this->CommonModel->getOne('system_users_role',['roleid'=>$res['roleid']]);
						$_SESSION['admin_user_info']['rolename'] = $res['rolename'];
						
						return showmsg("0", '登录成功');
					}else{
						return showmsg("1", '账号已关闭');
					}
					
				}
				else
				{
					if(!$arruser['username'] || !$arruser['password'])
					{
						return showmsg("1", '用户名或者密码不能为空');
					}
					else
					{
						return showmsg("1", '用户名或者密码不对');
					}

				}
			}
		 	else
			{
				return showmsg("1", '验证码不正确');
			}
		}
		$this->load->view('login/index');
	}
	public function loginout()
	{
		$this->session->set_userdata('admin_user_info','');
		redirect('/login');
	}
	function captcha() {
		header ('Content-Type: image/png');
		$image=imagecreatetruecolor(100, 35);
		//背景颜色为白色
		$color=imagecolorallocate($image, 255, 255, 255);
		imagefill($image, 20, 20, $color);
		$code='';
		for($i=0;$i<4;$i++){
			$fontSize=16;
			$x=rand(5,10)+$i*100/4;
			$y=rand(5, 15);
			$data='abcdefghjkmnpqrstuvwxyz23456789ABCDEFGHJKMNPQRSTUVWXYZ';
			$string=substr($data,rand(0, strlen($data)-1),1);
			$code.=$string;
			$color=imagecolorallocate($image,rand(0,120), rand(0,120), rand(0,120));
			imagestring($image, $fontSize, $x, $y, $string, $color);
		}
		$_SESSION['secode']=$code;//存储在session里
		for($i=0;$i<200;$i++){
			$pointColor=imagecolorallocate($image, rand(100, 255), rand(100, 255), rand(100, 255));
			imagesetpixel($image, rand(0, 100), rand(0, 30), $pointColor);
		}
		for($i=0;$i<2;$i++){
			$linePoint=imagecolorallocate($image, rand(150, 255), rand(150, 255), rand(150, 255));
			imageline($image, rand(10, 50), rand(10, 20), rand(80,90), rand(15, 25), $linePoint);
		}
		imagepng($image);
		imagedestroy($image);
	}
}
?>
