<?php

/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @method 		首页轮播图
 * @since		2015年5月7日18:35:53
 * @author		汪晓烽
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Index_Roll_Pic extends UA_Controller {

    public function __construct() {
        parent::__construct();
        $this->load_model('admin/a/index_roll_pic_model', 'roll_pic_model');
    }

    public function index() {
        $this->view('admin/a/cfg/index_roll_pic_list');
    }

    //获取轮播图数据
    public function getRollPicJson() {
        $data = $this ->roll_pic_model ->getRollPicData();
        //$data = $this->roll_pic_model->getRollPicDataNew();
        echo json_encode($data);
    }

    //增加轮播图
    public function add() {
        $postArr = $this->security->xss_clean($_POST);
        $dataArr = $this->commonRollPic($postArr);
        $status = $this->roll_pic_model->insert($dataArr);
        if ($status == false) {
            $this->callback->setJsonCode('4000', '添加失败');
        } else {
            $this->cache->redis->delete('SYrollPicAll');
            $this->log(1, 3, '首页轮播图配置', '增加轮播图');
            $this->callback->setJsonCode('2000', '添加成功');
        }
    }

    //编辑轮播图
    public function edit() {
        $postArr = $this->security->xss_clean($_POST);
        $dataArr = $this->commonRollPic($postArr);
        $status = $this->roll_pic_model->update($dataArr, array('id' => intval($postArr['id'])));
        if (empty($status)) {
            $this->callback->setJsonCode('4000', '编辑失败');
        } else {
            $this->cache->redis->delete('SYrollPicAll');
            $this->log(3, 3, '首页轮播图配置', '编辑轮播图');
            $this->callback->setJsonCode('2000', '编辑成功');
        }
    }

    //添加和编辑公用部分
    public function commonRollPic($postArr) {
        $name = trim($postArr['name']);
        $pic = trim($postArr['pic']);
        $showorder = intval($postArr['showorder']);
        if (empty($name)) {
            $this->callback->setJsonCode('4000', '请填写名称');
        }
        if (empty($pic)) {
            $this->callback->setJsonCode('4000', '请上传图片');
        }
        return array(
            'name' => $name,
            'link' => trim($postArr['link']),
            'pic' => $pic,
            'is_modify' => intval($postArr['is_modify']),
            'is_show' => intval($postArr['is_show']),
            'showorder' => empty($showorder) ? 999 : $showorder,
            'description' => trim($postArr['description']),
            //'remark' => trim($postArr['remark']),
            //'kind' => trim($postArr['kind'])
        );
    }

    //获取某条数据
    public function getDetailJson() {
        $id = intval($this->input->post('id'));
        $data = $this->roll_pic_model->row(array('id' => $id));
        echo json_encode($data);
    }

    //删除
    public function delRollPic() {
        $id = intval($this->input->post('id'));
        $status = $this->roll_pic_model->delete(array('id' => $id));
        if (empty($status)) {
            $this->callback->setJsonCode('4000', '删除失败');
        } else {
            $this->cache->redis->delete('SYrollPicAll');
            $this->log(2, 3, '首页轮播图配置', '平台删除首页轮播图,记录ID:' . $id);
            $this->callback->setJsonCode('2000', '删除成功');
        }
    }

}
