<?php
 namespace app\index\controller;
 use think\Controller;
 use think\Session;
class Common extends Controller{
	//定义控制器初始化方法_initialize，在该控制器的方法调用之前首先执行。
    public function _initialize()
    {
        
        if(!session('user')){
           return $this->error('请先登录系统',url('User/login'));
        }
    }

    
}
?>