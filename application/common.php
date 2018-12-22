<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件


/**
 * 数组重新按某一索引进行分组
 * @param $array
 * @param $filed
 * @return array
 */
function group_array($array,$filed){
    $new = [];
    foreach ($array as $key=>$value){
        $new[$value[$filed]][] = $value;
    }
    return $new;
}