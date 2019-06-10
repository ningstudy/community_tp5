<?php
namespace app\index\model;
/**
 * 
 */
use think\Db;
use think\Model;
use think\Session;
class AddQues extends Model
{
	
      public function add($data=array())
      {
             
            $reward=Db::name('user')->where('id',$data['userId'])->find();
            if ($reward['reward']==0) {
                  return [
                       'code'=>0,
                       'msg'=>"您还没有积分，去社区积极发言赚积分吧"
                  ];
            }
           else if ($reward['reward']<$data['reward']) {
                  return [
                       'code'=>2,
                       'msg'=>"悬赏积分不能超过自身所拥有的积分哦"
                  ];
            }else{
                  $res=Db::name('ques_list')->insert($data);
                  if ($res) {
                      $update=Db::name('user')->where('id',$data['userId'])->update(['reward' => 'reward-1']);
                      if ( $update) {
                            return [
                                 'code'=>1,
                                 'msg'=>"发布成功"
                                ];
                      }
                     
                  }
            }

      }
}

?>