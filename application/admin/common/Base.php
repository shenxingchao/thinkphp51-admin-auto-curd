<?php
/**
 * Created by PhpStorm.
 * User: Raytine
 * Date: 2018/12/6
 * Time: 14:56
 */

namespace app\admin\common;
use think\Controller;
use think\Db;
use think\facade\Request;

class Base extends Controller{

    public function initialize(){
        //验证admin是否登录
        if(session('admin')==null)
            $this->error("请先登录",'User/login');
        $this->privilegeCheck();
    }

    /**
     * 权限检查
     */
    private function privilegeCheck(){
        $controller = Request::controller();
        $action = Request::action();
        $request_url = strtolower($controller . "/" . $action);

        //获取权限资源表中所有的权限 判断当前请求是否需要权限验证
        $permission_src = Db::name('privilege_src')->where([['code','neq','']])->select();
        $permission_arr = [];
        foreach ($permission_src as $key=>$value){
            $temp = unserialize($value['code']);
            foreach ($temp as $k=>$v){
                $permission_arr[] = strtolower($v['controllerName']."/".$v['actionName']);
            }
        }
        if(!in_array($request_url,$permission_arr)){
            //不需要权限判断则直接跳过
            return true;
        }
        $user_info = Db::name('admin_user')->where([['id','eq',session('admin.id')]])->find();
        $role_info = Db::name('privilege_role')->where([['id','in',$user_info['role_ids']]])->select();
        $privilege_src_str = '';
        foreach ($role_info as $key=>$value){
            if($value['privilege_src_ids']!=''){
                $privilege_src_str.= ",".$value['privilege_src_ids'];
            }
            if($value['half_src_ids']!=''){
                $privilege_src_str.= ",".$value['half_src_ids'];
            }
        }

        $privilege_src_ids = array_values(array_filter(array_unique(explode(',',$privilege_src_str))));

        $privilege_src = Db::name('privilege_src')->where([['id','in',$privilege_src_ids],['code','neq','']])->select();
        $privilege_arr = [];

        foreach ($privilege_src as $key=>$value){
            $temp = unserialize($value['code']);
            foreach ($temp as $k=>$v){
                $privilege_arr[] = strtolower($v['controllerName']."/".$v['actionName']);
            }
        }
        if(!in_array($request_url,$privilege_arr)){
            //不存在权限，则提示
            if(Request::isAjax())
                $this->result(null,'10000','您没有此操作权限');
            $this->error("您没有此操作权限",'');//此处可替换提示页面
        }
        return true;
    }
}