<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2019/9/25
 * Time: 23:24
 */

namespace app\admin\controller\goods;


use app\common\controller\Backend;
use app\admin\model\Store as StoreModel;
use app\admin\model\Goods as GoodsModel;

class Store extends Backend
{
    protected $model = null;
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new StoreModel();
    }


    public function index(){
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            $filter = $this->request->request('filter');
            $filterArr = (array)json_decode($filter, TRUE);
            $count = $this->model->where($filterArr)->count();
            $data =  $this->model->where($filterArr)->order('id desc')->select();
            $result = array("total" => $count, "rows" => $data);
            return json($result);
        }
        return $this->view->fetch();
    }

    public function add(){
        if ($this->request->isAjax()) {
            $file = $this->request->param()['row'];
            $file['create_time'] = time();
            $res = $this->model->insert($file);
            if ($res){
                $this->success();
            }else{
                $this->error();
            }
        }
        $goodsModel = new GoodsModel();
        $goodsList = $goodsModel->where('status',1)->field('id,goods_name,status')->select();
        $this->assign('goodsList',$goodsList);
        return $this->view->fetch();
    }

    public function edit($ids = null){
        if ($this->request->isAjax()){
            $file = $this->request->param()['row'];
            $id = $this->request->param()['ids'];
            $file['update_time'] = time();
            $res = $this->model->where('id','eq',$id)->update($file);
            if ($res){
                $this->success();
            }else{
                $this->error();
            }
        }
        $id = $this->request->param()['ids'];
        $data = $this->model->where('id','eq',$id)->find();
        $goodsModel = new GoodsModel();
        $goodsList = $goodsModel->where('status',1)->field('id,goods_name,status')->select();
        $this->assign('goodsList',$goodsList);
        $this->assign('row',$data);
        $this->assign('status',$data->getData('status'));
        return $this->fetch();
    }

    /**
     * 删除附件
     * @param array $ids
     */
    public function del($ids = "")
    {
        if ($ids) {
            \think\Hook::add('upload_delete', function ($params) {
                $attachmentFile = ROOT_PATH . '/public' . $params['store_logo_img'];
                if (is_file($attachmentFile)) {
                    @unlink($attachmentFile);
                }

                $attachmentFile2 = ROOT_PATH . '/public' . $params['store_img'];
                if (is_file($attachmentFile2)) {
                    @unlink($attachmentFile2);
                }
            });
            $attachmentlist = $this->model->where('id', 'in', $ids)->select();
            foreach ($attachmentlist as $attachment) {
                \think\Hook::listen("upload_delete", $attachment);
                $attachment->delete();
            }
            $this->success();
        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }

    public function goodsList(){
        $goodsModel = new GoodsModel();
        $data = $goodsModel->where('status',1)->field('id,goods_name,status')->select();
        $goodsList = [];
        foreach ($data as $k => $v){
            $goodsList[$k]['id'] = $v['id'];
            $goodsList[$k]['nickname'] = $v['goods_name'];
            $goodsList[$k]['pid'] = 0;
        }
        return json(['list' => $goodsList, 'total' => count($goodsList)]);
    }

    public function statusList(){
        $statusList = [['id' => 1, 'name' => '正常'],['id' => 2, 'name' => '禁止']];
        return json(['list' => $statusList, 'total' => count($statusList)]);

    }
}