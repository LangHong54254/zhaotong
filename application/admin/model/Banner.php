<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/15
 * Time: 9:52
 */

namespace app\admin\model;


use think\Model;

class Banner extends Model
{
    public function getZhidingAttr($value,$data){
        $status = [1 => '电脑端',0 => '手机端'];
        return $status[$data['zhiding']];
    }

    public function getStatusAttr($value,$data){
        $status = [ 1 => '正常', 0 => '禁止'];
        return $status[$data['status']];
    }
}