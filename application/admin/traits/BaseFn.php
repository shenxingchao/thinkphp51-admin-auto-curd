<?php
/**
 * Created by PhpStorm.
 * User: Raytine
 * Date: 2018/12/6
 * Time: 14:52
 */

namespace app\admin\traits;
use think\App;
use think\Exception;
use think\facade\Request;
use think\facade\Env;

/**
 * 后台公共方法
 * Trait BaseFn
 * @package app\admin\traits
 */
trait BaseFn{
    /**
     * 列表
     */
    public function index(){
        if(Request::isAjax()){

            list($where,$sort) = $this->buildQuery();

            $list = $this->model
                ->where($where)
                ->order($sort)
                ->paginate(Request::param('pageSize'));

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
     * 建立查询参数
     * @return array
     */
    public function buildQuery(){
        $querys = Request::param('query')?Request::param('query'):[];
        $ops = Request::param('op',[]);
        $sort = Request::param('sort',[]);


        $where  = [];
        foreach ($querys as $key=>$value){ //类似username=>123
            switch ($ops[$key]){
                case 'like':
                    $where[] = [$key,'like','%'. $value .'%'];
                    break;
                case 'eq':
                    $where[] = [$key,'eq',$value];
                    break;
                case 'between':
                    $range = explode(' - ',$value);
                    $where[] = [$key,'between',[strtotime($range[0]),strtotime($range[1])]];
                    break;
                default:
                    break;
            }
        }

        return [$where,$sort];
    }

    /**
     * state字段更新
     * @return \think\response\Json
     */
    public function changeState(){
        $code = 0;
        $msg = 'success';
        $data = null;
        try{
            if(Request::isAjax()){
                $param = Request::param();
                $this->model
                    ->where(['id'=>$param['id']])
                    ->update([$param['field']=>$param['value']]);
                $msg = '操作成功';
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
     * 单文件上传
     */
    public function fileUpload(){
        $code = 0;
        $msg = 'success';
        $data = null;

        $file = request()->file('file');
        $root_path = Env::get('root_path');

        $data_type = Request::param('data_type');

        if($data_type=='file'){
            $relative_path = "/public/admin/uploads/files";
            $save_path = $root_path . $relative_path;
            $info = $file->validate(['size'=>10240000])->move($save_path);
        }else if($data_type =='image'){
            $relative_path = "/public/admin/uploads/images";
            $save_path = $root_path . $relative_path;
            $info = $file->validate(['size'=>2048000,'ext'=>'jpg,jpeg,png,gif,bmp'])->move($save_path);
        }else{
            $code = 10002;
            $msg = '上传类型不正确';
            return json(['data'=>$data,'msg'=>$msg,'code'=>$code]);
        }

        if($info){
            // 成功上传后 获取上传信息
            $file_path = str_replace('\\','/',$relative_path . "/" . $info->getSaveName());
            $msg = "上传成功";
            $data = $file_path;
        }else{
            // 上传失败获取错误信息
            $code = 10001;
            $msg = $file->getError();
        }
        return json(['data'=>$data,'msg'=>$msg,'code'=>$code]);
    }

    /**
     * 单文件删除
     */
    public function fileDelete(){
        $code = 0;
        $msg = 'success';
        $data = null;
        try{
            if(Request::isAjax()){
                $file_url = Request::param('file_url');
                if(!$file_url){
                    $code = 10002;
                    throw new Exception('参数错误');
                }
                $root_path = Env::get('root_path');
                @unlink($root_path . $file_url);
                $msg = '删除成功';

            }else{
                $code = 10001;
                throw new Exception('请求失败');
            }
        }catch (Exception $e){
            $msg = $e->getMessage();
        }

        return json(['data'=>$data,'msg'=>$msg,'code'=>$code]);
    }
}