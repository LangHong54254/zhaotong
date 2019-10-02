<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2019/10/2
 * Time: 14:17
 */

namespace app\api\controller;


use app\common\controller\Api;
use app\admin\model\Goods as GoodsModel;
use app\admin\model\Store as StoreModel;

class Goods extends Api
{
    //如果$noNeedLogin为空表示所有接口都需要登录才能请求
    //如果$noNeedRight为空表示所有接口都需要验证权限才能请求
    //如果接口已经设置无需登录,那也就无需鉴权了
    //
    // 无需登录的接口,*表示全部
    protected $noNeedLogin = ['*'];
    // 无需鉴权的接口,*表示全部
    protected $noNeedRight = ['*'];

    //获取分类
    public function getGoodsData(){
        $data = (new GoodsModel())->GetGoodsDataLogic();
        $this->success('返回成功', $data);
    }

    public function getGoodsStore($id){
        $ids = ['id' => $id];
        $validate = $this->Validate($ids,['id' => 'require|number'],'id必须为整数');
        if ($validate !== true){
            $this->error($validate);
        }
        $data = (new StoreModel())->getStoreDataLogic($id);
        $this->success('返回成功',$data);
    }

    public function getStoreDataFind($id){
        $ids = ['id' => $id];
        $validate = $this->Validate($ids,['id' => 'require|number'],'id必须为整数');
        if ($validate !== true){
            $this->error($validate);
        }
        $data = (new StoreModel())->getStoreDataFindLogic($id);
        $this->success('返回成功',$data);
    }
}