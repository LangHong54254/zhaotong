<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/14
 * Time: 14:49
 */
namespace app\admin\controller\banner;


use app\common\controller\Backend;
use app\admin\model\Banner as BannerModel;

class Banner extends Backend
{
    protected $model = null;
    public function _initialize()
    {
        parent::_initialize();

    }

    public function index(){
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            $filter = $this->request->request('filter');
            $filterArr = (array)json_decode($filter, TRUE);
            $model = new BannerModel();
            $count = $model->where($filterArr)->count();
            $data = $model->where($filterArr)->order('sort')->select();
            $result = array("total" => $count, "rows" => $data);
            return json($result);
        }
        return $this->view->fetch();
    }

    /**
     * 选择附件
     */
    public function select()
    {
        if ($this->request->isAjax()) {
            return $this->index();
        }
        return $this->view->fetch();
    }

    /**
     * 添加
     */
    public function add()
    {
        if ($this->request->isAjax()) {
            $data = [];
            $model = new BannerModel();
            $file = $this->request->param()['row'];
            $data['zhiding'] = $file['zhiding']; //应用端
            $data['name'] = $file['name']; //图片名称
            $data['sort'] = (int)$file['position']; //排序
            $data['href'] = $file['href']; //跳转链接
            $data['img_url'] = $file['imgurl']; //图片物理地址
            $data['status'] = (int)$file['status']; //图片物理地址
            $data['create_time'] = time();
            $res = $model->insert($data);
            if ($res){
                $this->success();
            }else{
                $this->error();
            }
        }
        return $this->view->fetch();
    }

    public function edit($ids = null){
        $model = new BannerModel();
        if ($this->request->isAjax()){
            $file = $this->request->param()['row'];
            $id = $this->request->param()['ids'];
            $data['zhiding'] = $file['zhiding']; //应用端
            $data['name'] = $file['name']; //图片名称
            $data['sort'] = (int)$file['position']; //排序
            $data['href'] = $file['href']; //跳转链接
            $data['img_url'] = $file['imgurl']; //图片物理地址
            $data['status'] = (int)$file['status']; //图片物理地址
            $res = $model->where('id','eq',$id)->update($data);
            if ($res){
                $this->success();
            }else{
                $this->error();
            }
        }
        $id = $this->request->param()['ids'];
        $data = $model->where('id','eq',$id)->find();
        $this->assign('row',$data);
        $this->assign('status',$data->getData('status'));
        $this->assign('zhiding',$data->getData('zhiding'));
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
                $attachmentFile = ROOT_PATH . '/public' . $params['img_url'];
                if (is_file($attachmentFile)) {
                    @unlink($attachmentFile);
                }
            });
            $model = new BannerModel();
            $attachmentlist = $model->where('id', 'in', $ids)->select();
            foreach ($attachmentlist as $attachment) {
                \think\Hook::listen("upload_delete", $attachment);
                $attachment->delete();
            }
            $this->success();
        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }
}