<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2019/9/25
 * Time: 22:54
 */

namespace app\admin\model;


use think\Model;

class Goods extends Model
{
    public function getStatusAttr($value,$data){
        $status = [ 1 => '正常', 0 => '禁止'];
        return $status[$data['status']];
    }
}