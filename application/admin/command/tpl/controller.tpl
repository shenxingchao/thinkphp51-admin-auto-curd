<?php

namespace app\admin\controller;

use app\admin\common\Base;
use think\facade\Env;
use think\facade\Request;
use think\Exception;
use think\Db;

/**
* {{tableComment}}控制器
*/
class {{controllerName}} extends Base{

    use \app\admin\traits\BaseFn;//引入公共方法(增删改查)  具体看traits

    protected $model = null;

    public function initialize(){
        parent::initialize();
        $this->model = new \app\admin\model\{{modelName}};
    }


    {{relationControllerFn}}
}