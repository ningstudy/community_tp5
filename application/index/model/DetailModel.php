<?php
namespace app\index\model;
/**
 * 
 */
use think\Db;
use think\Model;
class DetailModel extends Model
{
	
  public function getDetail($id)
  {
    $res=Db::name('ques_list')->where('id',$id)->setInc('views');
    $list=Db::name('ques_list')->where('id',$id)->find();
    $list=array_merge($list,$this->getName($list['userId']),$this->getCommentNum($list['id']));
    return $list;
  }
  public function getName($id)
  {
   $name=Db::name('user')->field('name,avatar')->where('id',$id)->find();
   if ($name) {
     return $name;
   }
 }
 public function getCommentNum($id)
 {
  $num=Db::name('comment')->where('quesId',$id)->count();
  if ($num) {
   return [ 
    'num'=>$num
  ];
}else{
  return [ 
    'num'=>0
  ];
}
}
public function hotView()
{
  $list=Db::name('ques_list')->order('views desc')->limit(10)->select();
  return $list;
}
public function hotTalk()
{
  $list=Db::query("SELECT ques_list.id, 
    ques_list.title, 
    comment.id AS comment_id,
    count(comment.id) as counts
FROM ques_list
LEFT JOIN comment 
ON ques_list.id = comment.quesId 
GROUP BY ques_list.id
ORDER BY count(comment.id) DESC, ques_list.id DESC 
LIMIT 10");
  return $list;
}
}

?>