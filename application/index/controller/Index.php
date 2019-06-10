<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Check;
use app\index\controller\Common;
use app\index\model\IndexModel;
class Index extends Common
{

    
    public function index()
    {
        $data=(new IndexModel())->getList();
         $this->assign('data',$data);
         return view('index');
    }
    
}
