<?php
//配置文件
return [
    // 默认跳转页面对应的模板文件
    'dispatch_success_tmpl'  => Env::get('app_path') . 'admin/view/public/dispatch_jump.tpl',
    'dispatch_error_tmpl'    => Env::get('app_path') . 'admin/view/public/dispatch_jump.tpl',
];