<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    // 生成应用公共文件
    '__file__' => ['common.php'],

    // 定义demo模块的自动生成 （按照实际定义的文件名生成）
    'admin'     => [
        '__file__'   => ['common.php','command.php'],
        '__dir__'    => ['common','command','controller', 'model', 'view','trait'],
        'controller' => ['Test'],
        'model'      => ['Test'],
        'view'       => ['index/index'],
    ],

    // 其他更多的模块定义
];