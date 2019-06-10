<?php
 namespace app\index\validate;

use think\Validate;

class Validata extends Validate
{
   protected $rule =   [
        'userName'  => 'require|max:25',
        'pass'   => 'require',
        'code' => 'require|captcha',    
    ];
    
    protected $message  =   [
        'username.require' => '名称必须',
        'username.max'     => '名称最多不能超过25个字符',
        'password.require'  => '密码不能为空',  
    ];

}
?>