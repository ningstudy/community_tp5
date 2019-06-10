<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Check;
use think\Session;
use think\Loader;
class User extends Controller
{
        public function login()
    {
        if (request()->isPost()) {

            $data=input('post.');
            $validate = Loader::validate('Validata');
		$res=$validate->check($data);
		if (!$res) {
		return $this->error(($validate->getError()));
		}
            $login=new Check();
            $stat=$login->login($data);
            switch ($stat['code']) {
                case 1:
                    Session::set('user',$stat['data']);
                    $this->redirect('index/index');     
                    break;
                case 2:
                    $this->error($stat['msg']);
                    break;
            }
            
        }       
             return view('login');
    }
    //退出登录
    public function exitLogin()
    {
        Session::delete('user');
        return $this->redirect('User/login');
    }
    public function register()
    {
    	 $login=new Check();
    	 if (request()->isPost()) {
    	 if (input('post.pass')!=input('post.repassword')) {
    	 	$this->error('两次密码不一致');
    	 }
    	  $validate = Loader::validate('Validata');
            $res=$validate->check(input('post.'));
            if (!$res) {
            	return $this->error(($validate->getError()));
            }
    	 $reg['name']=input('post.userName');
    	 $reg['password']=input('post.pass');
    	 $reg['avatar']='https://pic.qqtn.com/up/2019-4/2019042209164913093.jpg';
    	 $reg['nickname']=input('post.nickname');

            $stat=$login->register($reg);
            switch ($stat['code']) {
                case 1:
                    $this->success($stat['msg'],'login');     
                    break;
                case 2:
                    $this->error($stat['msg']);
                    break;
            }
        }
    	return view('register');
    }
    // 验证码
     public function show_captcha(){  
        	 ob_clean();    
        $captcha = new \think\captcha\Captcha();  
        $captcha->codeSet = '0123456789';
        $captcha->imageW=121;  
        $captcha->imageH = 38;  //图片高  
        $captcha->fontSize =14;  //字体大小  
        $captcha->length   = 4;  //字符数   
        $captcha->expire = 30;  //有效期  
        $captcha->useNoise = false;  //不添加杂点  
        return $captcha->entry();  
    }
    
}
