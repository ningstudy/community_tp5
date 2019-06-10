<?php
 namespace app\index\controller;
 use think\Controller;
  use think\Session;
 use app\index\model\DetailModel;
 use app\index\model\GetComm;
 use app\index\controller\Common;
 header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE');
header('Access-Control-Max-Age: 1728000');
class Detail extends Common{
   public function index()
   {
      $data=(new DetailModel())->getDetail(input('get.id'));
      $hotView=(new DetailModel())->hotView();
      $hotTalk=(new DetailModel())->hotTalk();
      $this->assign('data',$data);
      $this->assign('hotView',$hotView);
      $this->assign('hotTalk',$hotTalk);
       return view('detail');
   }
    public function getComments()
  {
    $get_com=new GetComm();
    return json_encode($get_com->getList(input('get.id')));
  }
  public function addComment()
  {
    $input = array();
    $input['comment']=input('get.value');
    $input['time']=date('Y-m-d H:i:s',time());
    $input['userId']=Session::get('user')['id'];
    $input['quesId']=input('get.id');
    if ($input['comment']&&$input['userId']) {
     $get_com=new GetComm();
     return json_encode($get_com->add($input));
   }else{
     return json_encode([
       'code'=>0
     ]);
   }
 }
 public function addSupport()
{
  $support['userId']=Session::get('user')['id'];
  $support['comment_id']=input('get.commentid');
  $support['type']=input('get.type');
  $support['quesId']=input('get.quesId');
  $get_com=new GetComm();
  return json_encode($get_com->support($support));
}
}
?>