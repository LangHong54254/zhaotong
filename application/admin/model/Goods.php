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
    protected $type = [
        'create_time' => 'timestamp:Y-m-d G:i:s',
        'update_time' => 'timestamp:Y-m-d G:i:s',
    ];

    public function getStatusAttr($value,$data){
        $status = [ 1 => '正常', 0 => '禁止'];
        return $status[$data['status']];
    }

    public function GetGoodsDataLogic(){
        $data = $this->where('status',1)
            ->order('sort desc')
            ->field('id,goods_name,goods_img')
            ->select();
        return $data;
    }


}