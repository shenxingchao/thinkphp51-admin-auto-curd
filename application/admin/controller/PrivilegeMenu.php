<?php

namespace app\admin\controller;

use app\admin\common\Base;
use think\facade\Env;
use think\facade\Request;
use think\Exception;

/**
* 菜单控制器
*/
class PrivilegeMenu extends Base{

    use \app\admin\traits\BaseFn;//引入公共方法(增删改查)  具体看traits

    protected $model = null;

    public function initialize(){
        parent::initialize();
        $this->model = new \app\admin\model\PrivilegeMenu;
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
                ->select()
                ->toArray();

            $list = $this->getTree($list,'title');
            $total = count($list);
            $data = [
                "total"=>$total,
                'rows'=>$list,
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
                foreach ($post as $key=>$value){
                    if(substr($key,-4) === 'time'){
                        //时间自动转为时间戳
                        $post[$key] = strtotime($value);
                    }
                }
                $post['add_time'] = time();
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

        $cat_info = $this->getAllCatLst();
        $this->assign('cat_info',$cat_info);

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
                foreach ($update as $key=>$value){
                    if(substr($key,-4) === 'time'){
                        //时间自动转为时间戳
                        $update[$key] = strtotime($value);
                    }
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
        $this->assign('data',$data);
        $cat_info = $this->getAllCatLst($data['id']);
        $this->assign('cat_info',$cat_info);

        return $this->fetch();
    }

    /**
     * 删除
     */
    public function delete(){
        $code = 0;
        $msg = 'success';
        $data = null;
        try{
            if(Request::isAjax()){
                $ids = Request::param('ids');
                if(empty($ids)){
                    $code = 10001;
                    throw new Exception('缺少参数');
                }
                //查找当前记录是否有 下级 有下级则不能被删除
                foreach ($ids as $key=>$value){
                    $where[] = ['parent_id','eq',$value];
                    $is_use = $this->model->where($where)->find();
                    if($is_use){
                        $code = 10001;
                        throw new Exception('存在子分类不允许被删除');
                    }
                }
                //先删除图片资源 或文件资源
                $res = $this->model
                    ->where([
                        ['id','in',$ids]
                    ])
                    ->select()
                    ->toArray();
                //批量删除
                $delete_count = $this->model
                    ->where([
                        ['id','in',$ids]
                    ])
                    ->delete();
                if($delete_count > 0){
                    $root_path = Env::get('root_path');
                    foreach ($res as $key=>$value){
                        foreach ($value as $k=>$val){ //username=>333
                            if(substr($k,-5) === 'image'||substr($k,-4) === 'file'){
                                //删除图片或文件
                                @unlink($root_path.$val);
                            }
                        }
                    }
                    $msg = '操作成功';
                }else{
                    $code = 10002;
                    throw new Exception('删除失败');
                }

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
     * 获取无限极分类菜单
     * @param int $id 不能等于这个id
     * @return array
     */
    public function getAllCatLst($id=null){
        $where = [];
        if($id!=null){
            $where[] = ['id','neq',$id];
            $where[] = ['parent_id','neq',$id];
        }
        $cat_info = $this->model->where($where)->select()->toArray();
        $tree = $this->getTree($cat_info,'title');
        return $tree;
    }


    /**
     * 递归实现无限极分类列表
     * @param $data
     * @param string $name
     * @param int $parent_id
     * @param int $level
     * @return array
     */
    private function getTree($data, $name='', $parent_id=0, $level = 0){
        static $tree = array();
        foreach ($data as $key => $value) {
            if ($value['parent_id'] == $parent_id) {
                $value[$name] = str_repeat('—— ',$level * 1) . $value[$name];
                $tree[] = $value;
                unset($data[$key]);
                $this->getTree($data, $name, $value['id'], $level + 1);
            }
        }
        return $tree;
    }
}