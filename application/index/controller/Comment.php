<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\GetComm;
/**
 * 
 */
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE');
header('Access-Control-Max-Age: 1728000');
class Comment extends Controller
{
	public function index()
  {
    return view('comment');
  }
  public function getComments()
  {
    $get_com=new GetComm();
    return json_encode($get_com->getList());
  }
  public function addComment()
  {
    $input = array();
    $input['comment']=input('get.value');
    $input['time']=date('Y-m-d H:i:s',time());
    $input['userId']=input('get.userId');
    if ($input['comment']&&$input['userId']) {
     $get_com=new GetComm();
     return json_encode($get_com->add($input));
   }else{
     return json_encode([
       'code'=>0
     ]);
   }
 }
 public function addReply()
 {
  $reply = array();
  $reply['content']=input('get.content');
  $reply['time']=date('Y-m-d H:i:s',time());
  $reply['toId']=input('get.toUser');
  $reply['userId']=input('get.fromId');
  $reply['replyType']=input('get.type');
  $reply['parentId']=input('get.commentid');
  if ($reply['content']) {
   $get_com=new GetComm();
   return json_encode($get_com->reply($reply));
 }else{
   return json_encode([
     'code'=>0
   ]);
 }
}
public function addSupport()
{
  $support['userId']=input('get.id');
  $support['comment_id']=input('get.commentid');
  $support['type']=input('get.type');
  $get_com=new GetComm();
  return json_encode($get_com->support($support));
}
}
?>