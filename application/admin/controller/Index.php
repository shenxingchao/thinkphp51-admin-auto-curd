<?php

namespace app\admin\controller;

use app\admin\common\Base;
use think\Exception;
use think\Db;
use think\facade\Request;

/**
* 首页控制器
*/
class Index extends Base{

    public function initialize(){
        parent::initialize();

    }

    /**
     * 后台框架
     */
    public function index(){
        return $this->fetch();
    }

    /**
     * 获取菜单
     */
    public function ajaxMenu(){
        $code = 0;
        $msg = 'success';
        $data = null;
        try{
            if(Request::isAjax()){
                $user_info = Db::name('admin_user')->where([['id','eq',session('admin.id')]])->find();
                $role_info = Db::name('privilege_role')->where([['id','in',$user_info['role_ids']]])->select();
                $privilege_menu_str = '';
                foreach ($role_info as $key=>$value){
                    if($value['privilege_menu_ids']!=''){
                        $privilege_menu_str.= ",".$value['privilege_menu_ids'];
                    }
                    if($value['half_menu_ids']!=''){
                        $privilege_menu_str.= ",".$value['half_menu_ids'];
                    }
                }

                $privilege_menu_ids = array_values(array_filter(array_unique(explode(',',$privilege_menu_str))));
                $privilege_menu = Db::name('privilege_menu')->where([['id','in',$privilege_menu_ids],['show_status','eq',1]])->order('sort,id','desc,asc')->select();
                $privilege_menu = $this->getTreeArr($privilege_menu);
                $privilege_menu = $this->executeTreeArr($privilege_menu);
                $data = $privilege_menu;
            }else{
                $code = 10001;
                throw new Exception('请求失败');
            }
        }catch (Exception $e){
            $msg = $e->getMessage();
        }

        return json(['data'=>$data,'msg'=>$msg,'code'=>$code]);
    }

    /**
     * 控制台
     */
    public function dashboard(){
        return $this->fetch();
    }

    /**
     * 获取无限极分类数组（直接是树形结构的数组） 直接循环输出时用 这里暂时无用
     * @param $data
     * @return array
     */
    private function getTreeArr($data){
        //构造数据
        $items = array();
        //以分类的id为索引
        foreach ($data as $key=>$value){
            $items[$value['id']] = $value;
        }
        //第二部 遍历数据 生成树状结构
        $tree = array();
        foreach($items as $key => $value){
            if($value['parent_id']!==0){//不是顶级分类
                //把当前循环的value放入父节点下面
                $items[$value['parent_id']]['son'][] = &$items[$key];
                //引用传值  当items更改时，tree里面的items也会更改
            }else{
                $tree[] = &$items[$key];
            }
        }
        return $tree;
    }

    /**
     * 递归返回可使用格式的权限节点
     * @param $data
     * @return array
     */
    private function executeTreeArr($data){
        $res = array();
        foreach ($data as $key=>$value){
            $arr = [
                'id'=>$value['id'],
                'title'=>$value['title'],
                'icon'=>$value['icon'],
                'href'=>url($value['href']),
            ];
            if(!empty($value['son'])){
                $arr['child'] = $this->executeTreeArr($value['son']);
            }
            $res[$key] = $arr;
        }
        return $res;
    }
}