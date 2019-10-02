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
    protected $type = [
        'create_time' => 'timestamp:Y-m-d G:i:s',
    ];

    public function getStatusAttr($value,$data){
        $status = [ 1 => '正常', 0 => '禁止'];
        return $status[$data['status']];
    }

    public function getAboutDataLogic(){
        $data = $this->find();
        return $data;
    }
}