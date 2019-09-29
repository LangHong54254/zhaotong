<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2019/9/27
 * Time: 23:31
 */

namespace app\admin\model;


use think\Model;

class About extends Model
{
    public function getStatusAttr($value,$data){
        $status = [ 1 => '正常', 0 => '禁止'];
        return $status[$data['status']];
    }
}