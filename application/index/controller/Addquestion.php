<?php
namespace app\index\controller;
use app\index\controller\Common;
use app\index\model\AddQues;
use think\Session;
class AddQuestion extends Common
{


    public function index()
    {

        return view('add');
    }
    public function add()
    {
    	$addModel=new AddQues();
    	$data=['userId'=>Session::get('user')['id'],'title'=>input('post.title'),'content'=>input('post.content'),'reward'=>input('post.reward'),'time'=>date('Y-m-d H:i:s',time())];
    	$res=$addModel->add($data);
    	switch ($res['code']) {
    		case 1:
    			$this->success($res['msg'],'/index/index/index');
    			break;
    		
    		default:
    			$this->error($res['msg']);
    			break;
    	}
    }
    
}
?>