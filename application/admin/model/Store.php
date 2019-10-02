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
    protected $type = [
        'create_time' => 'timestamp:Y-m-d G:i:s',
        'update_time' => 'timestamp:Y-m-d G:i:s',
    ];

    public function getStatusAttr($value,$data){
        $status = [ 1 => '正常', 0 => '禁止'];
        return $status[$data['status']];
    }

    public function getGoodsIdAttr($value,$data){
        $status = Db::table('fa_goods')->cache(1200)->column('goods_name','id');
        return $status[$data['goods_id']];
    }

    public function getStoreDataLogic($id){
        $data = $this->where('goods_id',$id)
            ->where('status',1)
            ->order('sort desc')
            ->field('id,store_name,province,city,area,store_describe,store_logo_img')
            ->select();
        return $data;
    }

    public function getStoreDataFindLogic($id){
        $data = $this->where('id',$id)
            ->where('status',1)
            ->field('id,store_img,store_name,store_address,store_phone,store_describe')
            ->find();
        return $data;
    }


}