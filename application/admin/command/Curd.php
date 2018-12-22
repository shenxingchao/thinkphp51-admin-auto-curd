<?php

namespace app\admin\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Option;
use think\console\Output;
use think\Exception;
use think\facade\Config;
use think\Db;

class Curd extends Command
{

    private $tpl_path = __DIR__ .'\tpl\\';
    private $controller_path = __DIR__ .'\..\controller\\';
    private $model_path = __DIR__ .'\..\model\\';
    private $view_path = __DIR__ .'\..\view\\';

    /**
     * 指令配置
     */
    protected function configure(){
        $this->setName('curd')
            ->addOption('table','t',Option::VALUE_REQUIRED,'数据库完整表名')
            ->addOption('join','j',Option::VALUE_OPTIONAL | Option::VALUE_IS_ARRAY,'关联表完整表名')
            ->addOption('key','k',Option::VALUE_OPTIONAL | Option::VALUE_IS_ARRAY,'主表外键名');

    }


    protected function execute(Input $input, Output $output){
        $msg = 'execute success';

        $table = $input->getOption('table');
        $relations = $input->getOption('join');//关联表名
        $foreignKeys = $input->getOption('key');//关联外键

        try {
            if (!$table) {
                throw new Exception('缺少表格参数 --table');
            }

            //数据库名称
            $database = Config::get('database.database');
            //表格前缀
            $prefix = Config::get('database.prefix');
            //表格名
            $table = stripos($table, $prefix) === 0 ? substr($table, strlen($prefix)) : $table;
            //获取数据表信息
            $table_info_res = Db::query("show table status like '".$prefix.$table."'");
            if (!$table_info_res) {
                throw new Exception("表格".$prefix.$table."不存在");
            }
            //数据表信息
            $table_info = $table_info_res[0];
            //表注释
            $tableComment = $table_info['Comment'];

            //获取数据表字段信息
            $get_column = "SELECT COLUMN_NAME AS `name`, DATA_TYPE AS `type`, COLUMN_COMMENT AS `comment`, COLUMN_KEY AS `key` , COLUMN_DEFAULT AS `default`"
                        ." FROM `information_schema`.`COLUMNS`"
                         ." WHERE `TABLE_SCHEMA` = '{$database}' AND `TABLE_NAME` = '".$prefix.$table."' ";
            //数据表字段信息
            $column_info  = Db::query($get_column);
            //主键
            $pk = '';

            foreach ($column_info as $key=>$value){
                if($value['key'] == 'PRI'){
                    $pk = $value['name'];
                    break;
                }
            }

            //根据列信息生成HTML 视图文件
            $fieldList = [];
            $indexHtml = '';//列表页
            $addHtml = '';//添加页
            $editHtml = '';//编辑页
            $ueditorInit = '';//编辑器初始化内容

            //循环数据表字段
            foreach ($column_info as $key=>$value){
                //控件类型
                $control_type = 'normal';//普通文本控件
                if(substr($value['name'],-6) === 'status'){
                    $control_type = 'switch';//开关控件
                }
                else if(substr($value['name'],-5) === 'image'){
                    $control_type = 'file';
                    $multiple = "";//单文件上传
                    $data_type = 'image';//判断是图片还是文件的唯一标识符
                }
                else if(substr($value['name'],-4) === 'file'){
                    $control_type = 'file';
                    $multiple = "";//单文件上传
                    $data_type = 'file';//判断是图片还是文件的唯一标识符
                }
                else if(substr($value['name'],-4) === 'time'){
                    $control_type = 'datetime';//日期控件
                }
                else if(substr($value['name'],-7) === 'content'){
                    $control_type = 'textarea';//文本框控件
                }
                else if(substr($value['name'],-6) === 'editor'){
                    $control_type = 'editor';//编辑器控件
                }
                //共有属性
                $field = [
                    "valign" => "middle",
                    "field"  => $value['name'],
                    "title"  => $value['comment'],
                ];
                if($value['key'] != 'PRI'){
                    //如果是主键，则不需要生成表单元素,编辑的话直接利用pk
                    switch ($control_type){
                        case 'normal':
                            $replace = [
                                'comment'=>$value['comment'],
                                'field'=>$value['name'],
                                'op'=>'like',
                            ];
                            $indexHtml .= $this->getReplaceTpl('index\input',$replace);//普通文本框
                            $addHtml   .= $this->getReplaceTpl('add\input',$replace);//普通文本框
                            $editHtml   .= $this->getReplaceTpl('edit\input',$replace);//普通文本框
                            break;
                        case 'switch':
                            $replace = [
                                'comment'=>$value['comment'],
                                'field'=>$value['name'],
                                'op'=>'eq',
                                'default'=> $value['default'],
                            ];
                            $indexHtml .= $this->getReplaceTpl('index\select',$replace);//下拉框
                            $addHtml   .= $this->getReplaceTpl('add\switch',$replace);//开关选择
                            $editHtml   .= $this->getReplaceTpl('edit\switch',$replace);//开关选择

                            $field['formatter'] = "function (value,row,index){return statusFormatter('". $value['name'] ."',value,row,index);}";
                            break;
                        case 'file':
                            $replace = [
                                'comment'=>$value['comment'],
                                'field'=>$value['name'],
                                'default'=> $value['default'],
                                'multiple'=> $multiple,
                                'data_type'=>$data_type,
                            ];
                            $addHtml   .= $this->getReplaceTpl('add\file',$replace);//单图上传
                            $editHtml   .= $this->getReplaceTpl('edit\file',$replace);//单图上传
                            if($data_type ==='image'){
                                $field['formatter'] = "function (value,row,index){return imageFormatter('". $value['name'] ."',value,row,index);}";
                            }else if($data_type === 'file'){
                                $field['formatter'] = "function (value,row,index){return fileFormatter('". $value['name'] ."',value,row,index);}";
                            }

                            break;
                        case 'datetime':
                            $replace = [
                                'comment'=>$value['comment'],
                                'field'=>$value['name'],
                                'op'=>'between',
                                'default'=> $value['default'],
                            ];
                            $indexHtml .= $this->getReplaceTpl('index\dateRange',$replace);//日期范围控件
                            if($value['name']!=='add_time'){
                                //需要添加控件,add_time自动维护
                                $addHtml   .= $this->getReplaceTpl('add\datetime',$replace);//日期时间选择控件
                                $editHtml   .= $this->getReplaceTpl('edit\datetime',$replace);//日期时间选择控件
                            }
                            $field['formatter'] = "function (value,row,index){return timeFormatter('". $value['name'] ."',value,row,index);}";
                            break;
                        case 'textarea':
                            $replace = [
                                'comment'=>$value['comment'],
                                'field'=>$value['name'],
                                'default'=> $value['default'],
                            ];
                            $addHtml   .= $this->getReplaceTpl('add\textarea',$replace);//文本域
                            $editHtml   .= $this->getReplaceTpl('edit\textarea',$replace);//文本域
                            break;
                        case 'editor':
                            $replace = [
                                'comment'=>$value['comment'],
                                'field'=>$value['name'],
                                'default'=> $value['default'],
                            ];
                            $addHtml   .= $this->getReplaceTpl('add\editor',$replace);//编辑器
                            $editHtml   .= $this->getReplaceTpl('edit\editor',$replace);//编辑器
                            $ueditorInit   .= $this->getReplaceTpl('func\ueditorInitFn',$replace);//编辑器初始化内容
                            break;

                    }
                }
                //以下特殊字段表格不显示 显示自行添加
                if(substr($value['name'],-7) === 'content'||substr($value['name'],-6) === 'editor'){
                    continue;
                }
                $fieldList[] = $field;
            }


            /*****************************************关联模型处理start****************************************/
            //以下皆是一一对应关系
            $relationTable = [];//关联表名不带前缀
            $relationColumnInfo = [];//关联表数据表结构信息
            $relationComment = [];//关联表数据表注释信息
            $relationControllerFn = '';
            $withModelName = '';
            $relationModelFn ='';

            if(count($relations) !== count($foreignKeys)){
                throw new Exception("缺少参数key");
            }


            foreach ($relations as $key=>$value){
                //循环判断关联表是否存在
                //获取数据表信息
                $relation_table_info_res = Db::query("show table status like '".$value."'");
                if (!$relation_table_info_res) {
                    throw new Exception("表格".$value."不存");
                }
                if(!$foreignKeys[$key]){
                    throw new Exception("表格".$value."缺少外键");
                }
                //表格名
                $relation_table = stripos($value, $prefix) === 0 ? substr($value, strlen($prefix)) : $value;
                $relationTable[] = $relation_table;
                //表注释
                $relationComment[] = $relation_table_info_res[0]['Comment'];
                //获取关联表字段信息
                $relation_get_column = "SELECT COLUMN_NAME AS `name`, DATA_TYPE AS `type`, COLUMN_COMMENT AS `comment`, COLUMN_KEY AS `key` , COLUMN_DEFAULT AS `default`"
                    ." FROM `information_schema`.`COLUMNS`"
                    ." WHERE `TABLE_SCHEMA` = '{$database}' AND `TABLE_NAME` = '".$value."' ";
                //数据表字段信息
                $relation_column_info  = Db::query($relation_get_column);
                $relationColumnInfo[] = $relation_column_info;
                //判断关联表主键是否存在
                $is_exist_pk = false;
                foreach ($relation_column_info as $k=>$v){
                    if($v['key'] == 'PRI'){
                        $is_exist_pk = true;
                        break;
                    }
                }
                if(!$is_exist_pk){
                    throw new Exception("表格".$value."缺少主键");
                }
                //判断主表外键字段是否存在
                $is_exist_foreignKey = false;
                foreach ($column_info as $k=>$v){
                    if($v['name'] == $foreignKeys[$key]){
                        $is_exist_foreignKey = true;
                        break;
                    }
                }
                if(!$is_exist_foreignKey){
                    throw new Exception("表格".$prefix.$table."缺少外键".$foreignKeys[$key]);
                }

            }

            $withModelNameArrLcf = [];//第一个字母小写 其他驼峰法
            $withModelNameArr = [];//驼峰法
            $relationFiledNameArrLcAll = [];//按_连接  每个类名小写

            foreach ($relationTable as $key=>$value){
                //按 _ 拆分 并每个拆分的首字母大写
                $relationClassNames = explode('_',$value);
                //控制器名称
                $relationModelNameLcf = '';//第一个字母小写 其他驼峰法
                $relationModelName = '';//驼峰法
                $relationFiledName = [];//按_连接  每个类名小写

                foreach ($relationClassNames as $k=>$v){
                    $relationModelName .= ucfirst($v);
                    if($k==0){
                        $relationModelNameLcf .= lcfirst($v);
                    }else{
                        $relationModelNameLcf .= ucfirst($v);
                    }
                    $relationFiledName[] = lcfirst($v);
                }

                $withModelNameArrLcf[] = $relationModelNameLcf;
                $withModelNameArr[] = $relationModelName;
                $relationFiledNameArrLcAll[] = implode('_',$relationFiledName);
            }

            if(count($withModelNameArrLcf)>0){
                $withModelName = implode(',',$withModelNameArrLcf);

                $replace = [
                    'withModelName'=>$withModelName
                ];
                $relationControllerFn =  $this->getReplaceTpl('func/relationControllerFn',$replace);


                foreach ($withModelNameArrLcf as $key=>$value){
                    $replace = [
                        'relationLeftJoinFn'    =>$value,
                        'relationModelName'     =>$withModelNameArr[$key],
                        'foreignKey'            =>$foreignKeys[$key],
                        'pk'                    =>$pk,
                        'comment'               =>$relationComment[$key],
                    ];
                    $relationModelFn .= $this->getReplaceTpl('func/relationModelFn',$replace);
                }

            }
            //将关联模型的字段 添加到fieldList（表格显示字段中）

            foreach ($relationColumnInfo as $k=>$v){
                foreach ($v as $key=>$value){
                    //共有属性
                    $field = [
                        "valign" => "middle",
                        "field"  => $relationFiledNameArrLcAll[$k].".".$value['name'],
                        "title"  => $value['comment'],
                    ];
                    //以下特殊字段表格不显示 显示自行添加
                    if(substr($value['name'],-7) === 'content'||substr($value['name'],-6) === 'editor'){
                        continue;
                    }
                    //关联表数据返回 只返回纯文本格式  其他自行转换 基本用不到
                    $fieldList[] = $field;
                }
            }

            /*****************************************关联模型处理end****************************************/
            //exit;


            //字段转json 并稍微格式化一下 此处需改进
            $fieldList  = json_encode($fieldList,JSON_UNESCAPED_UNICODE);
            $fieldList = str_replace(['{"' , '":"' , '","' , ',{' , ':"function' , '}"' ,  '},' , '[{' , '}]'],['{
            ' , ':"' , '",' , ',
            {', ':function' , '}' ,'
            },', '[
            {' , '
            }]'],$fieldList);

            //按 _ 拆分 并每个拆分的首字母大写
            $classNames = explode('_',$table);
            //控制器名称
            $controllerName = '';
            //模板文件夹名称数组
            $viewPathNameArr = [];
            foreach ($classNames as $key=>$value){
                $controllerName .= ucfirst($value);
                $viewPathNameArr[] = lcfirst($value);
            }
            //模板文件夹名称
            $viewPathName = implode('_',$viewPathNameArr);
            //模型名称
            $modelName = $controllerName;

            //控制器路径
            $controller_save_path = $this->controller_path.$controllerName.".php";
            //模型路径
            $model_save_path = $this->model_path.$modelName.".php";
            //列表路径
            $index_save_path = $this->view_path . lcfirst($viewPathName)."\index.html";
            //添加路径
            $add_save_path = $this->view_path . lcfirst($viewPathName)."\add.html";
            //编辑路径
            $edit_save_path = $this->view_path . lcfirst($viewPathName)."\\edit.html";

            /**
             * 映射数据
             */
            $data = [
                'tableComment'  =>$tableComment,
                'controllerName'=>$controllerName,
                'modelName'     =>$modelName,
                'fieldList'     =>$fieldList,
                'pk'                    =>$pk,
                'indexHtml'             =>$indexHtml,
                'addHtml'               =>$addHtml,
                'editHtml'              =>$editHtml,
                'relationControllerFn'  =>$relationControllerFn,
                'relationModelFn'       =>$relationModelFn,
                'ueditorInit'           =>$ueditorInit,
            ];
            //exit;
            //生成控制器文件
            $this->makeFile('controller',$data,$controller_save_path);
            //生成模型文件
            $this->makeFile('model',$data,$model_save_path);
            //生成列表模板文件
            $this->makeFile('index',$data,$index_save_path);
            //生成添加模板文件
            $this->makeFile('add',$data,$add_save_path);
            //生成编辑模板文件
            $this->makeFile('edit',$data,$edit_save_path);

        } catch (Exception $e){
            $msg = $e->getMessage();
        }
    	// 指令输出
    	$output->writeln($msg);
    }


    /**
     * 生成文件
     * @param $tpl_name
     * @param $data
     * @param $save_path
     * @return bool|int
     */
    private function makeFile($tpl_name,$data,$save_path){
        $content = $this->getReplaceTpl($tpl_name, $data);
        if (!is_dir(dirname($save_path))) {
            mkdir(dirname($save_path), 0755, true);
        }
        return file_put_contents($save_path, $content);
    }


    /**
     * 替换模板变量数据
     * @param $tpl_name
     * @param $data
     * @return mixed
     */
    private function getReplaceTpl($tpl_name,$data){
        //获取模板文件
        $tpl_file_path = $this->getTplByName($tpl_name);

        $search = $replace = [];
        foreach ($data as $k => $v) {
            $search[] = "{{". $k ."}}";
            $replace[] = $v;
        }
        $tpl_content = file_get_contents($tpl_file_path);
        return str_replace($search,$replace,$tpl_content);
    }

    /**
     * 根据模板文件名 获取模板文件完整路径
     * @param $tpl_name 模板名称
     * @return string
     */
    private function getTplByName($tpl_name){
        return $this->tpl_path . $tpl_name . ".tpl";
    }
}
