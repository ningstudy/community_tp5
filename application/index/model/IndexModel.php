<?php
namespace app\index\model;
/**
 * 
 */
use think\Db;
use think\Model;
class IndexModel extends Model
{
	
      public function getList()
      {
        $list=Db::name('ques_list')->select();
        foreach ($list as $key => $value){
          
          $list[ $key]=array_merge($list[ $key],$this->getName($value['userId']),$this->getCommentNum($value['id']));
        }

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
}

?>