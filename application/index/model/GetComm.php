<?php
namespace app\index\model;
/**
 * 
 */
use think\Db;
use think\Session;
use think\Model;
class GetComm extends Model
{

	public function getList($id)
	{
		$list=Db::name('comment')->where('quesId',$id)->order('id asc')->select();
		foreach ($list as $key => $value) {
			// $list[ $key]['userName']=Db::name('shop')->field('name')->where('shopId',123456)->find();
			// var_dump($list[ $key]);
			$list[ $key]=array_merge($list[ $key],$this->getName($value['userId']));
			$list[ $key]['support']=$this->getSupport($value['id'],1);
			$list[ $key]['is_support']=$this->isSupport($id,1,Session::get('user')['id'],$value['id']);
			$list[ $key]['is_LZ']=$this->isLZ($id);
             if ($value['isreply']) {
             	$list[$key]=array_merge($list[$key],(array)$this->getReply($value['id']));
             }
		}
		if ($list) {
			return [
                'code'=>1,
                'data'=>$list,
                'msg'=>'成功'
			];
		}else{
			return [
                'code'=>0,
                'data'=>[],
                'msg'=>'失败'
			];
		}
	}
	public function add($input=array())
	{
		$res=Db::name('comment')->insertGetId($input);
		if ($res) {
				return [
              'code'=>1,
              'data'=>array_merge($input,$this->getName($input['userId']),['id'=>$res],['support'=>$this->getSupport($res,1)]),
              'msg'=>'成功'
			        ];
			}
			
	}
	
	public function getName($id)
	{
		$name=Db::name('user')->field('name,avatar')->where('id',$id)->find();
		if ($name) {
			return $name;
		}
	}
	public function  getReply($id)
	 {
	 	$reply=Db::name('reply')->where('parentId',$id)->select();
	 	if ($reply) {
	 		foreach ($reply as $key => $value) {
	 			$reply[ $key]['toUser']=$this->getName($value['toId'])['name'];
	 			$reply[ $key]['name']=$this->getName($value['userId'])['name'];
	 			$reply[ $key]['support']=$this->getSupport($value['id'],0);
	 			$reply[ $key]['avatar']=$this->getName($value['userId'])['avatar'];
	 		}
	 		return [
              'reply'=>$reply
			];
	 	}
	 }
	 public function reply($reply=array())
	 {

	 	$up=Db::table('comment')->where('id', $reply['parentId'])->setField('isreply' ,1);
	 	$r=Db::table('reply')->insertGetId($reply);
	 	if ($r) {
	 		$User['id']=$r;
            $User['toUser']=$this->getName($reply['toId'])['name'];
            $User['name']=$this->getName($reply['userId'])['name'];
            $User['avatar']=$this->getName($reply['userId'])['avatar'];
            $User['support']=$this->getSupport($r,0);
	 		return [
              'code'=>1,
              'data'=>array_merge($reply,$User),
              'msg'=>'成功'
			];
	 	}else{
			return [
                'code'=>0,
                'data'=>[],
                'msg'=>'失败'
			];
		}
	 }
	 public function getSupport($id,$type)
	 {
	 	$res=Db::table('support')->where(['comment_id'=>$id,'type'=>$type])->count();
	 	if ($res) {
	 		return $res;
	 	}else{
	 		return 0;
	 	}
	 }
	  public function isSupport($id,$type,$userId,$comment_id)
	 {
	 	$res=Db::table('support')->where(['quesId'=>$id,'type'=>$type,'userId'=>$userId,'comment_id'=>$comment_id])->find();
	 	if ($res) {
	 		return 1;
	 	}else{
	 		return 0;
	 	}
	 }
	 public function support($support=array())
	 {
	 	$isSupport=Db::table('support')->where($support)->count();
	 	if ($isSupport) {
	 		$del=Db::table('support')->where($support)->delete();
	 		if ($del) {
	 			return[
              'code'=>2,
              'data'=>[],
              'msg'=>'取消成功'
	 		];
	 		}
	 	}
	 	else{
	 	$res=Db::table('support')->insert($support);
	 	if ($res) {
	 		return[
              'code'=>1,
              'data'=>[],
              'msg'=>'点赞成功'
	 		];
	 	}else{
	 		return [
              'code'=>0,
              'data'=>[],
              'msg'=>'点赞失败'
	 		];
	 	}
	 }
	}
	public function isLZ($quesId)
	{
		$res=Db::name('ques_list')->where('id',$quesId)->find();
		if (Session::get('user')['id']==$res['userId']) {
			return 1;
		}else{
			return 0;
		}
	}
}
?>