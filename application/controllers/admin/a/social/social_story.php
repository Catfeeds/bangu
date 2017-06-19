<?php

/**
 * @desc 社区故事
 * @since 2017-02-21
 * @author 张允发
 */
defined('BASEPATH') or ( 'No direct script access allowed' );

class Social_story extends UA_Controller {
    const PAGE_SIZE = 10;
    public function __construct() {
        parent::__construct();
        $this->social_db = $this->load->database("live", TRUE);
    }

    /**
     * @method index
     * @desc 社区故事管理首页
     * @since 2017-02-21
     * @author 张允发
     */
    public function index() {
        //$this->view('admin/a/social/social_story');
        $this->view('admin/a/social/socialstoryview');   // 魏勇编辑
    }

    /**
     * @method get_them_data
     * @desc    获取主题数据
     * @since   2017-02-22
     * @author  张允发
     */
    public function get_theme_data(){
        $page = $this->input->post('page', true);
        $pageSize = $this->input->post('pageSize', TRUE);
        $page = $page ? (int)$page : 1;
        $pageSize = $pageSize ? (int)$pageSize : 10;
        $from = ($page - 1) * $pageSize;
        $limit = " LIMIT {$from}, {$pageSize}";
        $sql = "SELECT id, name,is_recommend,app_pic, description, pic1,pic2,pic3, video_url1,video_url2,video_url3,video_pic1,video_pic2,video_pic3, show_order,line1,bg_pic icon, update_time FROM social_story ORDER BY id DESC ";
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
            if ((empty($dataarr['video1'])&&empty($dataarr['video_pic1'])) && (empty($dataarr['video2'])&&empty($dataarr['video_pic2'])) && (empty($dataarr['video3'])&&empty($dataarr['video_pic3']))){
            	$this->callback->setJsonCode ( 4001 ,'请上传视频和封面图');
            }else {
            	$str="http://".$_SERVER['HTTP_HOST'];
            	$video1=substr_replace($dataarr['video1'], '', 0, strlen($str));
            	$video2=substr_replace($dataarr['video2'], '', 0, strlen($str));
            	$video3=substr_replace($dataarr['video3'], '', 0, strlen($str));
            	$data['video_url1']=$video1;
            	$data['video_url2']=$video2;
            	$data['video_url3']=$video3;
            	$data['video_pic1']=$dataarr['video_pic1'];
            	$data['video_pic2']=$dataarr['video_pic2'];
            	$data['video_pic3']=$dataarr['video_pic3'];
            	$update_data['pic1']='';
            	$update_data['pic2']='';
            	$update_data['pic3']='';
            	$this->social_db->update('social_story', $update_data, array('id' => $id));
            }           
        }else if ($type == 2){  // 图片
            if (empty($dataarr['theme_pic1']) && empty($dataarr['theme_pic2']) && empty($dataarr['theme_pic3'])){
            	$this->callback->setJsonCode ( 4001 ,'请上传主题图片');
            }else {
            	$data['pic1']=$dataarr['theme_pic1'];
            	$data['pic2']=$dataarr['theme_pic2'];
            	$data['pic3']=$dataarr['theme_pic3'];
            	$update_data['video_url1']='';
            	$update_data['video_url2']='';
            	$update_data['video_url3']='';
            	$update_data['video_pic1']='';
            	$update_data['video_pic2']='';
            	$update_data['video_pic3']='';
            	$this->social_db->update('social_story', $update_data, array('id' => $id));
            }
        }
        //关联线路处理
//         if (empty($dataarr['line'])) $this->callback->setJsonCode ( 4001 ,'请填写关联线路id');
        $data['bg_pic']=$dataarr['icon'];
        $data['description']=$dataarr['description'];
        $data['name']=$dataarr['name'];
        $data['line1']=trim($dataarr['line'],',');
        $data['show_order'] = intval(empty($dataarr['order']) ? 999 : $dataarr['order']);
        $data['update_time'] = time();
        $data['app_pic']=$dataarr['app_pic'];
        $update=$this->social_db->update('social_story', $data, array('id' => $id));
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
     * @param   line 关联线路
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
			if ((empty($dataarr['video1'])&&!empty($dataarr['video_pic1'])) || (!empty($dataarr['video1'])&&empty($dataarr['video_pic1']))){
				$this->callback->setJsonCode ( 4001 ,'请上传视频1或视频封面图1');
			}
			if ((empty($dataarr['video2'])&&!empty($dataarr['video_pic2'])) || (!empty($dataarr['video2'])&&empty($dataarr['video_pic2']))){
				$this->callback->setJsonCode ( 4001 ,'请上传视频2或视频封面图2');
			}
			if ((empty($dataarr['video3'])&&!empty($dataarr['video_pic3'])) || (!empty($dataarr['video3'])&&empty($dataarr['video_pic3']))){
				$this->callback->setJsonCode ( 4001 ,'请上传视频3或视频封面图3');
			}
            if ((empty($dataarr['video1'])&&empty($dataarr['video_pic1'])) && (empty($dataarr['video2'])&&empty($dataarr['video_pic2'])) && (empty($dataarr['video3'])&&empty($dataarr['video_pic3']))){
            	$this->callback->setJsonCode ( 4001 ,'请上传视频和封面图');
            }else {
            	$str="http://".$_SERVER['HTTP_HOST'];
            	$video1=substr_replace($dataarr['video1'], '', 0, strlen($str));
            	$video2=substr_replace($dataarr['video2'], '', 0, strlen($str));
            	$video3=substr_replace($dataarr['video3'], '', 0, strlen($str));
            	$data['video_url1']=$video1;
            	$data['video_url2']=$video2;
            	$data['video_url3']=$video3;
            	$data['video_pic1']=$dataarr['video_pic1'];
            	$data['video_pic2']=$dataarr['video_pic2'];
            	$data['video_pic3']=$dataarr['video_pic3'];
            }           
        }else if ($type == 2){  // 图片
            if (empty($dataarr['theme_pic1']) && empty($dataarr['theme_pic2']) && empty($dataarr['theme_pic3'])){
            	$this->callback->setJsonCode ( 4001 ,'请上传至少一张主题图片');
            }else {
            	$data['pic1']=$dataarr['theme_pic1'];
            	$data['pic2']=$dataarr['theme_pic2'];
            	$data['pic3']=$dataarr['theme_pic3'];
            }
        }
        //关联线路处理
//         if (empty($dataarr['line'])) $this->callback->setJsonCode ( 4001 ,'请填写关联线路id');
        $data['bg_pic']=$dataarr['icon'];
        $data['description']=$dataarr['description'];
        $data['name']=$dataarr['name'];
        $data['line1']=trim($dataarr['line'],',');
        $data['show_order'] = intval(empty($dataarr['order']) ? 999 : $dataarr['order']);
        $data['update_time'] = time();
        $data['app_pic']=$dataarr['app_pic'];
        $result=$this->social_db->insert('social_story', $data);
        if ($result){
        	$id=$this->social_db->insert_id();
        	$theme_data['theme_id']=$id;
        	$theme_data['update_time']=$data['update_time'];
        	$theme_data['type']=2;
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
        $ret = $this->social_db->where('id', $id)->delete('social_story');
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
    	$sql_str = "select id,is_recommend from social_story where id=".$id." ";
    	$data = $this->social_db->query($sql_str)->row_array();
    	if(empty($data)){
    		$this->callback->set_code ( 100 ,"该主题不存在");
    		$this->callback->exit_json();
    	}
    	$status= 0;
    	if($data['is_recommend']==1){//取消推荐
    		$status = $this->social_db->query("update social_story set `is_recommend`=0 where id = ".$id."");
    	}else{//推荐
    		$status = $this->social_db->query("update social_story set `is_recommend`=1 where id = ".$id."");
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
        $sql = "SELECT id, name,app_pic,video_pic1,video_pic2,video_pic3, description,pic1,pic2,pic3,bg_pic icon,line1, video_url1,video_url2,video_url3, show_order, update_time FROM social_story WHERE id = ".$id;
        $dtl = $this->social_db->query($sql)->row_array();
        $video_url1 = isset($dtl['video_url1']) ? $dtl['video_url1'] : '';
        $video_url2 = isset($dtl['video_url2']) ? $dtl['video_url2'] : '';
        $video_url3 = isset($dtl['video_url3']) ? $dtl['video_url3'] : '';
        $dtl['theme_type'] = 0;
        if (!empty($video_url1)||!empty($video_url2)||!empty($video_url3)){
            $dtl['theme_type'] = 1;         // 视频
        }else {
            $dtl['theme_type'] = 2;         // 图片
        }
        echo json_encode($dtl);
    }

    /**
     * @method  get_posts_by_theme_id
     * @desc    获取某个故事的动态
     * @param   theme_id    故事id
     */
    public function get_posts_by_theme_id($page = 1){
        if($this ->input ->get('page' ,true)){
            $page = $this ->input ->get('page' ,true);
        }	
        $theme_id = $this->input->get_post('theme_id', TRUE);
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
        $config['base_url'] = '/admin/a/social/social_story/get_posts_by_theme_id/' . $urlstr . 'page=';
        $config ['pagesize'] = Social_story::PAGE_SIZE;
        $config ['page_now'] = $page;
        $data = array();
        $from = ($page - 1) * 10;
        $query_posts = $this->social_db->query("SELECT * FROM social_story_post WHERE theme_id = $theme_id ORDER BY last_ans_time DESC, update_time DESC LIMIT {$from}, {$config ['pagesize']}");
        $data['posts'] = $query_posts->result_array();
        $config ['pagecount'] = $this->social_db->query("SELECT id FROM social_story_post WHERE theme_id = $theme_id")->num_rows();
        $data['theme_id'] = $theme_id;
        // 根据theme_id获取主题名称
        $sql_story = "SELECT name FROM social_story WHERE id = $theme_id";
        $story = $this->social_db->query($sql_story)->row_array();
        $theme_name = isset($story['name']) ? $story['name'] : '';
        $data['theme_name'] = $theme_name;
        $this->page->initialize($config);
        $this->load_view( 'admin/a/social/socialstorypostview',$data);
    }
}
