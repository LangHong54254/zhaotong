<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2019/10/2
 * Time: 15:48
 */

namespace app\api\controller;


use app\common\controller\Api;
use app\admin\model\Receiving as ReceivingModel;

class Receiving extends Api
{
    //如果$noNeedLogin为空表示所有接口都需要登录才能请求
    //如果$noNeedRight为空表示所有接口都需要验证权限才能请求
    //如果接口已经设置无需登录,那也就无需鉴权了
    //
    // 无需登录的接口,*表示全部
    protected $noNeedLogin = ['*'];
    // 无需鉴权的接口,*表示全部
    protected $noNeedRight = ['*'];

    public function getReceivingData(){
        $data = (new ReceivingModel())->getReceivingDataLogic();
        $this->success('返回成功',$data);
    }
}