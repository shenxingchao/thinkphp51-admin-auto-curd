<?php

namespace app\admin\controller;

use app\admin\common\Base;
use think\Db;
use think\facade\Request;

/**
* 管理员控制器
*/
class AdminUser extends Base{

    use \app\admin\traits\BaseFn;//引入公共方法(增删改查)  具体看traits

    protected $model = null;

    public function initialize(){
        parent::initialize();
        $this->model = new \app\admin\model\AdminUser;
    }

    /**
     * 列表
     */
    public function index(){
        if(Request::isAjax()){

            list($where,$sort) = $this->buildQuery();

            $list = $this->model
                ->where($where)
                ->order($sort)
                ->paginate(Request::param('pageSize'))
                ->each(function ($item,$key){
                    $roles = Db::name('privilege_role')->where([['id','in',$item['role_ids']]])->column('role_name');
                    $item['role_names'] = '';
                    if($roles)
                        $item['role_names'] = implode(',',$roles);
                    return $item;
                });

            $list = $list->toArray();
            $data = [
                "total"=>$list['total'],
                'rows'=>$list['data'],
            ];
            return json($data);
        }
        return $this->fetch();
    }

    /**
     * 添加
     */
    public function add(){
        if(Request::isAjax()){
            $code = 0;
            $msg = 'success';
            $data = null;
            try{
                $post = Request::param();
                //判断用户名是否存在
                $where = [];
                $where[] = ['username','eq',$post['username']];
                $count = $this->model->where($where)->count();
                if($count>0){
                    $code = 10002;
                    throw new Exception('用户名已存在');
                }
                foreach ($post as $key=>$value){
                    if(substr($key,-4) === 'time'){
                        //时间自动转为时间戳
                        $post[$key] = strtotime($value);
                    }
                }
                $post['add_time'] = time();
                $post['password'] = md5($post['password']);
                if(isset($post['role_ids'])){
                    $post['role_ids'] = implode(',',$post['role_ids']);
                }
                $insert = $this->model->allowField(true)->save($post);//过滤数据库字段写入

                if($insert){
                    $msg = "添加成功";
                }else{
                    $code = 10001;
                    throw new Exception('添加失败');
                }

            }catch (Exception $e){
                $msg = $e->getMessage();
            }

            return json(['data'=>$data,'msg'=>$msg,'code'=>$code]);
        }

        //获取所有角色输出
        $roles = Db::name('privilege_role')->select();
        $this->assign('roles',$roles);
        return $this->fetch();
    }

    /**
     * 编辑
     */
    public function edit(){
        if(Request::isAjax()){
            $code = 0;
            $msg = 'success';
            $data = null;
            try{
                $where = [
                    'id'=>Request::param('id'),
                ];
                $update = Request::except('id');

                //判断用户名是否存在
                $map = [];
                $map[] = ['username','eq',$update['username']];
                $map[] = ['id','neq',$where['id']];
                $count = $this->model->where($map)->count();
                if($count>0){
                    $code = 10002;
                    throw new Exception('用户名已存在');
                }
                foreach ($update as $key=>$value){
                    if(substr($key,-4) === 'time'){
                        //时间自动转为时间戳
                        $update[$key] = strtotime($value);
                    }
                }
                if($update['password']!=''){
                    $update['password'] = md5($update['password']);
                }else{
                    unset($update['password']);
                }
                if(isset($update['role_ids'])){
                    $update['role_ids'] = implode(',',$update['role_ids']);
                }else{
                    $update['role_ids'] = '';
                }
                $this->model->save($update,$where);
                $msg = "保存成功";

            }catch (Exception $e){
                $msg = $e->getMessage();
            }

            return json(['data'=>$data,'msg'=>$msg,'code'=>$code]);
        }
        $where = Request::param();
        $data = $this->model->where($where)->find();
        $data['role_ids'] = explode(',',$data['role_ids']);
        $this->assign('data',$data);
        //获取所有角色输出
        $roles = Db::name('privilege_role')->select();
        $this->assign('roles',$roles);

        return $this->fetch();
    }
}