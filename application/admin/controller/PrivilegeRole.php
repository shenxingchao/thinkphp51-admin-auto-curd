<?php

namespace app\admin\controller;

use app\admin\common\Base;
use think\Db;
use think\Exception;
use think\facade\Request;

/**
* 角色控制器
*/
class PrivilegeRole extends Base{

    use \app\admin\traits\BaseFn;//引入公共方法(增删改查)  具体看traits

    protected $model = null;

    public function initialize(){
        parent::initialize();
        $this->model = new \app\admin\model\PrivilegeRole;
    }


    /**
     * 获取角色菜单节点数组
     */
    public function privilegeMenuNodes(){
        $code = 0;
        $msg = 'success';
        $data = null;
        try{
            if(Request::isAjax()){
                $privilegeMenu = Db::name('privilege_menu')->select();
                $privilegeMenu = $this->getTreeArr($privilegeMenu);
                $menuOption = $this->executeTreeArr($privilegeMenu);
                $data = $menuOption;
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
     * 获取角色资源节点数组
     */
    public function privilegeSrcNodes(){
        $code = 0;
        $msg = 'success';
        $data = null;
        try{
            if(Request::isAjax()){
                $privilegeSrc = Db::name('privilege_src')->select();
                $privilegeSrc = $this->getTreeArr($privilegeSrc);
                $srcOption = $this->executeTreeArr($privilegeSrc);
                $data = $srcOption;
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
                'text'=>$value['title'],
                'state'=>['opened'=>true],
            ];
            if(!empty($value['son'])){
                $arr['children'] = $this->executeTreeArr($value['son']);
            }
            $res[$key] = $arr;
        }
        return $res;
    }
}