<?php

/**
 * @desc 社区主题
 * @since 2016-12-16 15:55:12
 * @author 魏勇
 */
defined('BASEPATH') or ( 'No direct script access allowed' );

class Social_known extends UA_Controller {
    const PAGE_SIZE = 10;
    public function __construct() {
        parent::__construct();
        $this->social_db = $this->load->database("live", TRUE);
    }

    /**
     * @method index
     * @desc 社区主题管理首页
     * @since 2016-12-16 15:58:17
     * @author 魏勇
     */
    public function index() {
        $this->view('admin/a/social/social_known');
    }

    /**
     * @method get_them_data
     * @desc    获取主题数据
     * @since   2016-12-23 15:05:27
     * @author  魏勇
     */
    public function get_theme_data(){
        $page = $this->input->post('page', true);
        $pageSize = $this->input->post('pageSize', TRUE);
        $page = $page ? (int)$page : 1;
        $pageSize = $pageSize ? (int)$pageSize : 10;
        $from = ($page - 1) * $pageSize;
        $limit = " LIMIT {$from}, {$pageSize}";
        $sql = "SELECT id, name,is_recommend,app_pic, description,video_url,topic_pic pic,video_pic, show_order,bg_pic, update_time FROM social_topic ORDER BY id DESC ";
        $sqls = $sql.$limit;
        $query = $this->social_db->query($sqls);
        $ret = $query->result_array();
        $num = $this->social_db->query("SELECT COUNT(*) AS num FROM (".$sql.") va", array())->result();
        $count = $num[0]->num;
        // 对update_time进行处理
        $v['update_time'] = isset($v['update_time']) ? $v['update_time'] : 0;
        foreach($ret as &$v){
            $v['update_time'] = date('Y-m-d H:i:s', $v['update_time']);
        }
        // 对update_time处理结束
        $data['count'] = $count;
        $data['data']=$ret;
        echo json_encode($data);
    }
    
    /**
     * @method  edit_social_theme
     * @desc    添加主题
     * @param   type 添加主题的类型 1表示视频类型,2表示图片类型
     * @param   id  主题id
     */
    public function edit_social_theme(){
    	$dataarr=$this->security->xss_clean($_POST);
    	$id=intval($dataarr['id']);
    	if (empty($dataarr['name'])){
    		$this->callback->setJsonCode ( 4001 ,'请填写主题名称');
    	}
    	if (empty($dataarr['icon'])){
    		$this->callback->setJsonCode ( 4001 ,'请上传主题背景图片');
    	}
    	$type_arr=array(1,2);
    	if (empty($dataarr['type']) OR (!in_array($dataarr['type'],$type_arr))){
    		$this->callback->setJsonCode ( 4001 ,'请选择主题类型');
    	}
    	$type = $dataarr['type'];
    	if ($type == 1){    // 视频
            if (empty($dataarr['video1'])||empty($dataarr['video_pic1'])){
            	$this->callback->setJsonCode ( 4001 ,'请上传视频或视频封面图');
            }else {
            	$data['video_pic']=$dataarr['video_pic1'];
            	$str="http://".$_SERVER['HTTP_HOST'];
            	$video = $dataarr['video1'];
            	$video = substr_replace($video, '', 0, strlen($str));
            	$data['video_url']=$video;
            	$update_data['topic_pic']='';
            	$this->social_db->update('social_topic', $update_data, array('id' => $id));
            }           
        }else if ($type == 2){  // 图片
            if (empty($dataarr['theme_pic1'])){
            	$this->callback->setJsonCode ( 4001 ,'请上传主题图片');
            }else {
            	$data['topic_pic']=$dataarr['theme_pic1'];
            	$update_data['video_url']='';
            	$update_data['video_pic']='';
            	$this->social_db->update('social_topic', $update_data, array('id' => $id));
            }
        }
        $data['bg_pic']=$dataarr['icon'];
        $data['description']=$dataarr['description'];
        $data['name']=$dataarr['name'];
        $data['show_order'] = intval(empty($dataarr['order']) ? 0 : $dataarr['order']);
        $data['update_time'] = time();
        $data['app_pic']=$dataarr['app_pic'];
        $update=$this->social_db->update('social_topic', $data, array('id' => $id));
        if ($update){
        	$this->callback->setJsonCode ( 2000 ,'编辑成功');
        }else {
        	$this->callback->setJsonCode ( 4001 ,'编辑失败，请重新尝试');
        }
    }
    
   /**
     * @method  add_social_theme
     * @desc    添加主题
     * @param   type 添加主题的类型 1表示视频类型,2表示图片类型
     * @param   name 主题名称
     * @param   icon 主题背景图片
     * @param   order   排序值      越大越靠前
     * @param   theme_pic1  主题图片1
     * @param   theme_pic2  主题图片2
     * @param   theme_pic3  主题图片3
     * @param   video_pic1  视频封面图1
     * @param   video_pic2  视频封面图2
     * @param   video_pic3  视频封面图3
     * @param   description 主题描述
     */
    public function add_social_theme(){
    	$dataarr=$this->security->xss_clean($_POST);
        if (empty($dataarr['name'])){
        	$this->callback->setJsonCode ( 4001 ,'请填写主题名称');
        }
        if (empty($dataarr['icon'])){
        	$this->callback->setJsonCode ( 4001 ,'请上传主题背景图片');
        }
        $type_arr=array(1,2);
        if (empty($dataarr['type']) OR (!in_array($dataarr['type'],$type_arr))){
        	$this->callback->setJsonCode ( 4001 ,'请选择主题类型');
        }
        $type = $dataarr['type'];
		if ($type == 1){    // 视频
            if (empty($dataarr['video1'])||empty($dataarr['video_pic1'])){
            	$this->callback->setJsonCode ( 4001 ,'请上传视频或视频封面图');
            }else {
            	$data['video_pic']=$dataarr['video_pic1'];
            	$str="http://".$_SERVER['HTTP_HOST'];
            	$video = $dataarr['video1'];
            	$video = substr_replace($video, '', 0, strlen($str));
            	$data['video_url']=$video;
            }           
        }else if ($type == 2){  // 图片
            if (empty($dataarr['theme_pic1'])){
            	$this->callback->setJsonCode ( 4001 ,'请上传主题图片');
            }else {
            	$data['topic_pic']=$dataarr['theme_pic1'];
            }
        }
        $data['bg_pic']=$dataarr['icon'];
        $data['description']=$dataarr['description'];
        $data['name']=$dataarr['name'];
        $data['show_order'] = intval(empty($dataarr['order']) ? 0 : $dataarr['order']);
        $data['update_time'] = time();
		$data['app_pic']=$dataarr['app_pic'];
        $result=$this->social_db->insert('social_topic', $data);
        if ($result){
        	$id=$this->social_db->insert_id();
        	$theme_data['theme_id']=$id;
        	$theme_data['update_time']=$data['update_time'];
        	$theme_data['type']=3;
        	//添加热度数据
        	$this->social_db->insert('social_theme_hot_num', $theme_data);
        	$this->callback->setJsonCode ( 2000 ,'添加成功');
        }else {
        	$this->callback->setJsonCode ( 4001 ,'添加失败，请重新尝试');
        }
    }
    
    /**
     * @method  del_social_theme
     * @desc    删除主题
     * @param   id  要删除的主题的id
     */
    public function del_social_theme(){
        $id = $this->input->post('id', TRUE);
        $id = $id ? (int)$id : 0;
        $ret = $this->social_db->where('id', $id)->delete('social_topic');
        if (!$ret){
            $this->callback->setJsonCode ( 4001 ,'删除失败，请重新尝试');
        }else {
        	$this->social_db->where('theme_id', $id)->delete('social_theme_hot_num');
        	$this->callback->setJsonCode ( 2000 ,'删除成功');
        }

    }
    
    /**
     * @method  indexVideoInfo
     * @desc    app首页推荐
     * @param   id  要推荐的主题的id
     */
    public function indexVideoInfo(){
    	$id = intval($this->input->post("id",true));
    	$sql_str = "select id,is_recommend from social_topic where id=".$id." ";
    	$data = $this->social_db->query($sql_str)->row_array();
    	if(empty($data)){
    		$this->callback->set_code ( 100 ,"该主题不存在");
    		$this->callback->exit_json();
    	}
    	$status= 0;
    	if($data['is_recommend']==1){//取消推荐
    		$status = $this->social_db->query("update social_topic set `is_recommend`=0 where id = ".$id."");
    	}else{//推荐
    		$status = $this->social_db->query("update social_topic set `is_recommend`=1 where id = ".$id."");
    	}
    	if($status){
    		$this->callback->set_code ( 2000 ,"操作成功");
    		$this->callback->exit_json();
    	}else{
    		$this->callback->set_code ( 401 ,"操作失败");
    		$this->callback->exit_json();
    	}
    	exit;
    }
    
    /**
     * @method  get_dtl_json
     * @desc    获取某条主题的详情
     * @param   主题id
     */
    public function get_dtl_json(){
        $id = $this->input->post('id', TRUE);
        $id = isset($id) ? $id : 0;
        // 获取该id为$id的一条记录
        $sql = "SELECT id, name,app_pic, description,bg_pic,video_pic,topic_pic pic,video_url, show_order, update_time FROM social_topic WHERE id = ".$id;
        $dtl = $this->social_db->query($sql)->row_array();
        $video_url = isset($dtl['video_url']) ? $dtl['video_url'] : '';
        $dtl['theme_type'] = 0;
        if (!empty($video_url)){
            $dtl['theme_type'] = 1;         // 视频
        }else {
            $dtl['theme_type'] = 2;         // 图片
        }
        echo json_encode($dtl);
    }
    
    /**
     * @method  get_posts_by_topic_id
     * @desc    获取知道下面的动态
     * @param   topic_id    知道id
     */
    public function get_posts_by_topic_id($page = 1){
        if($this ->input ->get('page' ,true)){
            $page = $this ->input ->get('page' ,true);
        }
        $theme_id = $this->input->get_post('topic_id', TRUE);
        if (empty($theme_id)){
            $theme_id = 0;
        }
        $urldata = array();
        parse_str($_SERVER['QUERY_STRING'], $urldata);
        unset($urldata['page']);
        $urlstr = '?';
        foreach ($urldata as $k => $v) {
            $urlstr .=$k . '=' . $v . '&';
        }
        $this->load->library('Page'); // 加载分页类
        $config['base_url'] = '/admin/a/social/social_known/get_posts_by_topic_id/' . $urlstr . 'page=';
        $config ['pagesize'] = Social_known::PAGE_SIZE;
        $config ['page_now'] = $page;
        $data = array();
        $from = ($page - 1) * 10;
        $query_posts = $this->social_db->query("SELECT * FROM social_topic_question WHERE topic_id = $theme_id ORDER BY last_ans_time DESC, update_time DESC LIMIT {$from}, {$config ['pagesize']}");   // 添加按时间倒序排序
        $data['posts'] = $query_posts->result_array();
        $config ['pagecount'] = $this->social_db->query("SELECT id FROM social_topic_question WHERE topic_id = $theme_id")->num_rows();
        $data['topic_id'] = $theme_id;
        // 根据话题id获取话题名称
        $sql_topic = "SELECT name FROM social_topic WHERE id = $theme_id";
        $topic = $this->social_db->query($sql_topic)->row_array();
        $theme_name = isset($topic['name']) ? $topic['name'] : '';
        $data['theme_name'] = $theme_name;
        $this->page->initialize($config);
        $this->load_view( 'admin/a/social/socialtopicquestionview', $data);
    }


}
