<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2019/10/2
 * Time: 13:31
 */

namespace app\api\controller;


use app\common\controller\Api;
use app\admin\model\Banner as BannerModel;

class Banner extends Api
{
    //如果$noNeedLogin为空表示所有接口都需要登录才能请求
    //如果$noNeedRight为空表示所有接口都需要验证权限才能请求
    //如果接口已经设置无需登录,那也就无需鉴权了
    //
    // 无需登录的接口,*表示全部
    protected $noNeedLogin = ['*'];
    // 无需鉴权的接口,*表示全部
    protected $noNeedRight = ['*'];


    public function getBannerData(){
        $data = (new BannerModel())->ApiBannerData();
        $this->success('返回成功', $data);
    }

}