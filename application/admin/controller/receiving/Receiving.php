<?php

namespace app\admin\controller\receiving;
use app\common\controller\Backend;
use app\admin\model\Receiving as ReceivingModel;

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2019/9/29
 * Time: 14:38
 */

class Receiving extends Backend
{
    protected $model = null;
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new ReceivingModel();
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
//            $file['create_time'] = time();
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
        $data = $this->model->where('id','eq',$id)->find();
        $this->assign('row',$data);
        return $this->fetch();
    }
}