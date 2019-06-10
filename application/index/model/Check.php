<?php
namespace app\index\model;
/**
 * 
 */
use think\Db;

use think\Model;
use app\index\validate\Validata;
class check extends Model
{
	
	public function login($data){
		

 
      	 $user=Db::name('user')->where('name',$data['userName'])->where('password',$data['pass'])->find();
      	 if (!$user) {
      	 	return ['code'=>2,'msg'=>'用户名或密码错误'];
      	 }else{
      	 	return ['code'=>1,'msg'=>'登录成功','data'=>['id'=>$user['id'],'avatar'=>$user['avatar'],'userName'=>$user['name']]];
      	 }
      
    
	}
      public function register($data){
           
    
      
            $data['avatar']='https://pic.qqtn.com/up/2019-4/2019042209164913093.jpg';
             $user=Db::name('user')->insert($data);
             if (!$user) {
                  return ['code'=>2,'msg'=>'注册失败，请重试'];
             }else{
                  return ['code'=>1,'msg'=>'注册成功'];
             }
      
    
      }
}

?>