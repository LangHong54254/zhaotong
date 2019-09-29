<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2019/9/26
 * Time: 0:04
 */

namespace app\admin\model;


use think\Db;
use think\Model;

class Store extends Model
{
    public function getStatusAttr($value,$data){
        $status = [ 1 => '正常', 0 => '禁止'];
        return $status[$data['status']];
    }

    public function getGoodsIdAttr($value,$data){
        $status = Db::table('fa_goods')->cache(1200)->column('goods_name','id');
        return $status[$data['goods_id']];
    }
}