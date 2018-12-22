<?php

namespace app\admin\controller;

use app\admin\common\Base;
use think\Exception;
use think\facade\Env;
use think\facade\Request;

/**
* 系统设置控制器
*/
class SystemSetting extends Base{

    protected $model = null;

    public function initialize(){
        parent::initialize();
        $this->model = new \app\admin\model\SystemSetting;
    }

    /**
     * 列表
     */
    public function index(){
        //获取分组设置
        $group_setting = $this->model->where([['name','eq','group_setting']])->find()->toArray();
        $group_setting['value'] = unserialize($group_setting['value']);
        $this->assign('group_setting',$group_setting);
        //获取所有配置
        $setting = $this->model->order('id','asc')->select()->toArray();
        $this->assign('setting',group_array($setting,'group'));

        return $this->fetch();
    }

    /**
     * 分组保存
     */
    public function groupSetting(){
        $code = 0;
        $msg = 'success';
        $data = null;
        if(Request::isAjax()){
            try{
                $where = [];
                $where[] = ['name','eq','group_setting'];
                $param = Request::param();
                $update_value = [];
                foreach ($param['group_setting_name'] as $key=>$value){
                    $update_value[$value] = $param['group_setting_value'][$key];
                }
                $update = [
                    'value'=>serialize($update_value)
                ];
                $this->model->save($update,$where);
                //分组不存在的数据删除


                $msg = "保存成功";
            }catch (Exception $e){
                $msg = $e->getMessage();
            }
        }else{
            $code = 404;
            $msg = '请求失败';
        }
        return json(['data'=>$data,'msg'=>$msg,'code'=>$code]);
    }

    /**
     * 添加变量到分组
     */
    public function addParam(){
        $code = 0;
        $msg = 'success';
        $data = null;
        if(Request::isAjax()){
            try{
                $post = Request::param();
                $where = [];
                $where[] = ['name','eq',$post['name']];
                $count = $this->model->where($where)->count();
                if($count>0){
                    $code = 10002;
                    throw new Exception('变量已存在');
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
        }else{
            $code = 404;
            $msg = '请求失败';
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

    /**
     * 变量设置保存
     */
    public function paramSave(){
        $code = 0;
        $msg = 'success';
        $data = null;
        if(Request::isAjax()){
            try{
                //找出当前分组存在的变量
                $param = Request::param();
                $cur_param = $this->model->where([['group','eq',$param['group']]])->column('name');
                $match = [];
                $update = [];
                foreach ($param as $key=>$value){
                    $match[] = $key;
                    if(in_array($key,$cur_param)){

                        $update[$key] = $value;
                    }
                }
                foreach ($cur_param as $key=>$value){
                    if(!in_array($value,$match)){
                        //删除
                        $this->model->where([['group','eq',$param['group']],['name','eq',$value]])->delete();
                    }
                }
                foreach ($update as $key=>$value){
                    $where = [['group','eq',$param['group']],['name','eq',$key]];
                    $this->model->save(['value'=>$value],$where);
                }
                $msg = "保存成功";
            }catch (Exception $e){
                $msg = $e->getMessage();
            }
        }else{
            $code = 404;
            $msg = '请求失败';
        }
        return json(['data'=>$data,'msg'=>$msg,'code'=>$code]);
    }
}