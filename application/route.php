<?php
use think\Route;
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('getBanner','api/banner/getBannerData'); //轮播获取接口
Route::get('getGoods','api/goods/getGoodsData'); //获取商家分类
Route::get('getGoodsStore/:id','api/goods/getGoodsStore'); //获取商家子分类
Route::get('getStoreDataFind/:id','api/goods/getStoreDataFind'); //获取商家详细信息
Route::get('getAboutData','api/about/getAboutData'); //获取关于我们数据
Route::get('getReceivingData','api/receiving/getReceivingData'); //获取代收货数据

return [
    //别名配置,别名只能是映射到控制器且访问时必须加上请求的方法
    '__alias__'   => [
    ],
    //变量规则
    '__pattern__' => [
    ],
//        域名绑定到模块
//        '__domain__'  => [
//            'admin' => 'admin',
//            'api'   => 'api',
//        ],
];
