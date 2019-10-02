<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2019/9/29
 * Time: 17:13
 */

namespace app\admin\model;


use think\Model;

class Receiving extends Model
{
    protected $type = [
        'create_time' => 'timestamp:Y-m-d G:i:s',
    ];

    public function getReceivingDataLogic(){
        $data = $this->find();
        return $data;
    }
}