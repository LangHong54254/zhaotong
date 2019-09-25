<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/20
 * Time: 15:21
 */
namespace app\admin\controller\brand;

use app\common\controller\Backend;
use app\admin\model\Brand as BrandModel;

class Brand extends Backend
{

    protected $model = null;
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new BrandModel();
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
            $res = $this->model->where('id','eq',$id)->update($file);
            if ($res){
                $this->success();
            }else{
                $this->error();
            }
        }
        $id = $this->request->param()['ids'];
        $data =  $this->model->where('id','eq',$id)->find();
        $this->assign('row',$data);
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
                $res = preg_match_all("/src=\"(.*)\"/iUs",$params['content'],$out);
                $img = $out[1];
                foreach ($img as $k){
                    $attachmentFile = ROOT_PATH . '/public' . $k;
                    if (is_file($attachmentFile)) {
                        @unlink($attachmentFile);
                    }
                }
//                $attachmentFile = ROOT_PATH . '/public' . $params['img_url'];
//                if (is_file($attachmentFile)) {
//                    @unlink($attachmentFile);
//                }
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
}