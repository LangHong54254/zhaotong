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
    protected $type = [
        'create_time' => 'timestamp:Y-m-d G:i:s'
    ];

    public function getStatusAttr($value,$data){
        $status = [ 1 => '正常', 0 => '禁止'];
        return $status[$data['status']];
    }

    public function ApiBannerData(){
       $data =  $this->where('status',1)
           ->order('sort desc')
           ->field('id,name,sort,href,img_url')
           ->select();
       return $data;
    }
}