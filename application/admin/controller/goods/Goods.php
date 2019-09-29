<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2019/9/25
 * Time: 22:30
 */
namespace app\admin\controller\goods;


use app\common\controller\Backend;
use app\admin\model\Goods as GoodsModel;

class Goods extends Backend
{
    protected $model = null;
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new GoodsModel();
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
        return $this->view->fetch();
    }

    public function edit($ids = null){
        if ($this->request->isAjax()){
            $file = $this->request->param()['row'];
            $id = $this->request->param()['ids'];
            $data['goods_name'] = $file['goods_name']; //图片名称
            $data['sort'] = (int)$file['sort']; //排序
            $data['goods_img'] = $file['goods_img']; //图片地址
            $data['status'] = (int)$file['status']; //状态
            $res = $this->model->where('id','eq',$id)->update($data);
            if ($res){
                $this->success();
            }else{
                $this->error();
            }
        }
        $id = $this->request->param()['ids'];
        $data = $this->model->where('id','eq',$id)->find();
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
                $attachmentFile = ROOT_PATH . '/public' . $params['goods_img'];
                if (is_file($attachmentFile)) {
                    @unlink($attachmentFile);
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

    public function statusList(){
        $statusList = [['id' => 1, 'name' => '正常'],['id' => 2, 'name' => '禁止']];
        return json(['list' => $statusList, 'total' => count($statusList)]);

    }


}