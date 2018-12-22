<?php

namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\facade\Request;
use think\facade\Session;
use think\facade\Validate;


/**
* 首页控制器
*/
class User extends Controller {

    /**
     * 后台用户登录方法
     * @return mixed
     */
    public function login(){
        if(Request::isPost()){
            $post = Request::param();
            $rule = [
                'username'=>'require',
                'password'=>'require'
            ];
            $msg = [
                'username.require'=>'用户名不能为空',
                'password.require'=>'密码不能为空',
            ];
            $validate = Validate::make($rule)->message($msg);
            if(!$validate->check($post)){
                $this->error($validate->getError());
            }
            $where = [];
            $where[] = ['username','eq',$post['username']];
            $where[] = ['password','eq',md5($post['password'])];
            $user = Db::name('admin_user')->where($where)->find();
            if(!$user){
                $this->error('账号信息不正确');
            }
            else if($user['status']===2){
                $this->error('该账号已被禁用，请联系管理员');
            }
            else{
                //验证成功 进行登录
                $update = [
                    'id'=>$user['id'],
                    'login_time'=>time(),
                ];
                Db::name('admin_user')->update($update);
                Session::set('admin',$user);
                $this->success("登录成功",'Index/index');
            }
        }
        return $this->fetch();
    }

    /**
     * 后台注销登录
     */
    public function logout(){
        session('admin',null);
        session('privilege_src',null);
        $this->success("退出成功",'User/login');
    }
}