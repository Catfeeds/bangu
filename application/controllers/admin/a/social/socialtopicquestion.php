<?php

/**
 * @desc 社区知道动态
 * @since  2017-3-2 18:03:46
 * @author 魏勇
 */
defined('BASEPATH') or ( 'No direct script access allowed' );

class Socialtopicquestion extends UA_Controller {

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
        $this->view('admin/a/social/socialtopicquestionview');
    }

    /**
     * @method get_them_data
     * @desc    获取主题数据
     * @since   2016-12-23 15:05:27
     * @author  魏勇
     */
    public function get_theme_data(){
//        $page = $this->input->post('page', true);
//        $pageSize = $this->input->post('pageSize', TRUE);
//        $page = $page ? (int)$page : 1;
//        $pageSize = $pageSize ? (int)$pageSize : 10;
//        $from = ($page - 1) * $pageSize;
        $sql = "SELECT id, name, description, topic_pic pic, video_url, show_order, update_time FROM social_topic ORDER BY show_order DESC";
        $query = $this->social_db->query($sql);
        $ret = $query->result_array();
        $count = $query->num_rows();
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
     * @method  get_post_count_by_id
     * @desc    根据主题id获取主题下面的帖子数
     * @param   id  主题id
     * @since   2017-1-18 10:57:44
     */
    public function get_post_count_by_id(){
        $id = $this->input->post('id', TRUE);
        $id = $id ? (int)$id : 0;
        $sql = '';
        if (0 == $id){
            $sql = "SELECT id FROM social_topic_question LIMIT 20";
        }else{
            $sql = "SELECT id FROM social_topic_question WHERE topic_id = $id";
        }
        $cnt = $this->social_db->query($sql)->num_rows();
        echo json_encode($cnt);
    }
    
    /**
     * @method get_post_data
     * @desc   获取帖子信息包括标题,正文,回复数据
     * @since  2017-2-7 11:15:31
     * @param  topic_id     知道id
     */
    public function get_post_data(){
        $theme_id = $this->input->post('topic_id', TRUE);
        $theme_id = empty($theme_id) ? 0 : intval($theme_id);
        if (0 == $theme_id){    // 如果没有选择任何主题,则显示5个帖子的内容
            $sql = "SELECT id, title, content, video_pic, video_url, pic1, pic2, pic3 FROM social_topic_question LIMIT 20";
        }else{
            $sql = "SELECT id, title, content, video_pic, video_url, pic1, pic2, pic3 FROM social_topic_question WHERE theme_id = $theme_id";
        }
        $ret = $this->social_db->query($sql)->result_array();
        foreach($ret as &$v){
            $post_id = isset($v['id']) ? $v['id'] : 0;
            // 获取帖子的回复
            $sql_reply = "SELECT * FROM social_topic_answer WHERE question_id = $post_id";
            $v['replies'] = $this->social_db->query($sql_reply)->result_array();
        }
        echo json_encode($ret);
    }


    /**
     * @method  get_post_by_id
     * @desc    获取某条动态
     * @param   post_id    帖子id
     */
    public function get_post_by_id(){
        $post_id = $this->input->get_post('post_id', TRUE);
        $post_id = empty($post_id) ? -1 : (int)$post_id;
        $data = $this->social_db->query("SELECT * FROM social_topic_question WHERE id = $post_id")->row_array();
        $data['post_type'] = 0;
        $pic1 = isset($data['pic1']) ? $data['pic1'] : '';
        $pic2 = isset($data['pic2']) ? $data['pic2'] : '';
        $pic3 = isset($data['pic3']) ? $data['pic3'] : '';
        if (empty($pic1) && empty($pic2) && empty($pic3)){
            $data['post_type'] = 1;     // 视频
        }else{
            $data['post_type'] = 2;     // 图片
        }
        if (empty($data)){
            return FALSE;
        }else {
            echo json_encode($data);
        }
    }
    
    /**
     * @method  add_post
     * @desc    添加动态
     * @param   title      帖子标题
     * @param   content    帖子正文
     * @param   video_name 视频名称
     * @param   video_tag  视频标签
     * @param   video_url  视频url
     * @param   video_pic  视频封面图
     * @param   pic1       图片1
     * @param   pic2       图片2
     * @param   pic3       图片3
     * @param   user_type  用户类型
     */
    public function add_post(){
        $dataarr = $this->security->xss_clean($_POST);
//        $member_id = $dataarr['member_id'];
//        $data['member_id'] = empty($member_id) ? 0 : intval($member_id);
        $title = $dataarr['title'];
        $data['title'] = empty($title) ? '' : $title;
        $theme_id = $dataarr['topic_id'];
        $data['topic_id'] = empty($theme_id) ? -1 : intval($theme_id);
        $content = $dataarr['content'];
        $user_type = $dataarr['user_type'];
        if (empty($content)){
            $this->callback->setJsonCode(4001, '正文不能为空');
        }
        if (0 == $user_type){
            $this->callback->setJsonCode(4001, '请选择用户类型');
        }else if (1 == $user_type){ // 官方用户
            // 从管家表中随机取一个
            $sql_official = "SELECT id FROM u_expert ORDER BY rand() LIMIT 1";
            $official = $this->db->query($sql_official)->row_array();
            $id = isset($official['id']) ? $official['id'] : 0;
            $sql_anchor = "SELECT anchor_id FROM live_anchor WHERE user_id = $id AND user_type = 1";
            $anchor = $this->social_db->query($sql_anchor)->row_array();
            $anchor_id = isset($anchor['anchor_id']) ? $anchor['anchor_id'] : 0;
            $data['member_id'] = $anchor_id;
            $data['is_config'] = 1;
        }else if (2 == $user_type){ // 普通用户
            // 从user2表中随机取一个
            $sql_user2 = "SELECT anchor_id FROM user2 ORDER BY rand() LIMIT 1";
            $user2 = $this->social_db->query($sql_user2)->row_array();
            $anchor_id = isset($user2['anchor_id']) ? $user2['anchor_id'] : 0;
            $data['member_id'] = $anchor_id;
            $data['is_config'] = 0;
        }
        $data['content'] = $content;
        $type_arr=array(1,2);
    	if (empty($dataarr['type']) OR (!in_array($dataarr['type'],$type_arr))){
    		$this->callback->setJsonCode ( 4001 ,'请选择主题类型');
    	}
        if (1 == $dataarr['type']){ // 视频
            if (empty($dataarr['video_name'])){
                $this->callback->setJsonCode(4001, '视频名称不能为空');
            }else if (empty($dataarr['video_tag'])){
                $this->callback->setJsonCode(4001, '视频标签不能为空');
            }else if (empty($dataarr['video'])){
                $this->callback->setJsonCode(4001, '视频不能为空');
            }else if (empty($dataarr['video_pic'])){
                $this->callback->setJsonCode(4001, '视频封面图不能为空');
            }
            $data['video_name'] = $dataarr['video_name'];
            $data['video_tag'] = $dataarr['video_tag'];
            $data['video_url'] = $dataarr['video'];
            $data['video_pic'] = $dataarr['video_pic'];
            $data['pic1'] = '';
            $data['pic2'] = '';
            $data['pic3'] = '';
        }else if (2 == $dataarr['type']){   // 图片
            $pic1 = $dataarr['pic1'];
            $pic2 = $dataarr['pic2'];
            $pic3 = $dataarr['pic3'];
            if (empty($pic1) && empty($pic2) && empty($pic3)){
                $this->callback->setJsonCode(4001, '至少要有一张图片');
            }
            $data['pic1'] = $pic1;
            $data['pic2'] = $pic2;
            $data['pic3'] = $pic3;
            $data['video_name'] = '';
            $data['video_tag'] = '';
            $data['video_url'] = '';
            $data['video_pic'] = '';
        }
        
        $data['update_time'] = time();
//        $data['is_config'] = 1;
        $this->social_db->insert('social_topic_question', $data);
        
        $data['code'] = 2000;
        echo json_encode($data);
    }
    
    /**
     * @method  edit_post_by_id
     * @desc    编辑某条动态
     * @param   post_id    帖子id
     * @param   content    帖子正文
     * @param   video_name 视频名称
     * @param   video_tag  视频标签
     * @param   video_url  视频url
     * @param   video_pic  视频封面图
     * @param   pic1       图片1
     * @param   pic2       图片2
     * @param   pic3       图片3
     */
    public function edit_post_by_id(){
        $dataarr=$this->security->xss_clean($_POST);
        $post_id = intval($dataarr['id']);
//        $member_id = $dataarr['member_id'];
//        $data['member_id'] = empty($member_id) ? 0 : intval($member_id);
        $content = $dataarr['content'];
        if (empty($content)){
            $this->callback->setJsonCode ( 4001 ,'请填写正文');
        }
        $data['content'] = $content;
        $type_arr=array(1,2);
    	if (empty($dataarr['type']) OR (!in_array($dataarr['type'],$type_arr))){
    		$this->callback->setJsonCode ( 4001 ,'请选择主题类型');
    	}
        if (1 == $dataarr['type']){ // 视频
            if (empty($dataarr['video_name'])){
                $this->callback->setJsonCode(4001, '视频名称不能为空');
            }else if (empty($dataarr['video_tag'])){
                $this->callback->setJsonCode(4001, '视频标签不能为空');
            }else if (empty($dataarr['video'])){
                $this->callback->setJsonCode(4001, '视频不能为空');
            }else if (empty($dataarr['video_pic'])){
                $this->callback->setJsonCode(4001, '视频封面图不能为空');
            }
            $data['video_name'] = $dataarr['video_name'];
            $data['video_tag'] = $dataarr['video_tag'];
            $data['video_url'] = $dataarr['video'];
            $data['video_pic'] = $dataarr['video_pic'];
            $data['pic1'] = '';
            $data['pic2'] = '';
            $data['pic3'] = '';
        }else if (2 == $dataarr['type']){
            $pic1 = $dataarr['pic1'];
            $pic2 = $dataarr['pic2'];
            $pic3 = $dataarr['pic3'];
            if (empty($pic1) && empty($pic2) && empty($pic3)){
                $this->callback->setJsonCode(4001, '至少要有一张图片');
            }
            $data['pic1'] = $pic1;
            $data['pic2'] = $pic2;
            $data['pic3'] = $pic3;
            $data['video_name'] = '';
            $data['video_tag'] = '';
            $data['video_url'] = '';
            $data['video_pic'] = '';
        }
        $data['update_time'] = time();
        $this->social_db->where('id', $post_id);
        $this->social_db->update('social_topic_question', $data);
        
        $data['code'] = 2000;
        
        echo json_encode($data);
    }
    
    /**
     * @method  del
     * @desc    删除动态
     * @param   post_id   帖子id
     */
    public function del(){
        $post_id = $this->input->get_post('post_id', TRUE);
        $post_id = empty($post_id) ? -1 : $post_id;
        // 根据post_id获取theme_id
        $sql_theme = "SELECT topic_id FROM social_topic_question WHERE id = $post_id";
        $theme = $this->social_db->query($sql_theme)->row_array();
        $theme_id = isset($theme['topic_id']) ? $theme['topic_id'] : -1;
        $ret = $this->social_db->where('id', $post_id)->delete('social_topic_question');
        if (!$ret) {
            $this->callback->setJsonCode(4001, '删除失败，请重新尝试');
        } else {
            // 获取评论数
            $sql_ans = "SELECT id FROM social_topic_answer WHERE question_id = $post_id";
            $query_ans = $this->social_db->query($sql_ans);
            $ans_cnt = $query_ans->num_rows();
            // 获取点赞数
            $ans = $query_ans->result_array();
            $praise_cnt = 0;
            foreach($ans as $v){
                $ans_id = isset($v['id']) ? $v['id'] : -1;
                $sql = "SELECT COUNT(*) cnt FROM social_praise WHERE category_id = $ans_id AND type = 2";
                $ans_data = $this->social_db->query($sql)->row_array();
                $cnt = isset($ans_data['cnt']) ? $ans_data['cnt'] : 0;
                $praise_cnt += $cnt;
            }
            // 获取点赞数
//            $sql_praise = "SELECT COUNT(*) cnt FROM social_praise WHERE type = 1 AND category_id = $post_id";
//            $praise = $this->social_db->query($sql_praise)->row_array();
//            $praise_cnt = isset($praise['cnt']) ? $praise['cnt'] : 0;
            // 更新social_theme_hot_num中的评论数与点赞数
            $this->social_db->query("UPDATE social_theme_hot_num SET ans_cnt = ans_cnt - $ans_cnt, praise_cnt = praise_cnt - $praise_cnt WHERE theme_id = $theme_id AND type = 3");
            // 更新评论表,删除此动态的评论记录
            $this->social_db->query("DELETE FROM social_topic_answer WHERE question_id = $post_id");
            // 更新点赞表,删除此动态的点赞记录
            //$this->social_db->query("DELETE FROM social_praise WHERE type = 2 AND category_id = $post_id");
            foreach($ans as $v){
                $ans_id = isset($v['id']) ? $v['id'] : -1;
                $this->social_db->query("DELETE FROM social_praise WHERE type = 2 AND category_id = $ans_id");
            }
            $this->callback->setJsonCode(2000, '删除成功');
        }
    }

    
}