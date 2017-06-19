<?php

/**
 *   @name:APP接口文件
 *   @version: v2.2.0
 *   @author: 魏勇
 *   @time: 2016-12-7 17:01:29
 *   
 * 	 @abstract:
 *
 * 		1、   cfgm是用户接口前缀 ，
 * 		    E是管家接口前缀，
 * 		    G是即时导游接口前缀，
 * 			P是公共函数接口前缀  ；
 *
 *      2、	 __outmsg()、__data()是输出格式化数据模式，
 *      	 __null()是输出空，
 *      	 __errormsg()是输出错误模式
 *        
 *      3、数据传递方式： POST
 * 		
 *      4、返回结果状态码:  2000是成功，4001是空null，-3是错误信息
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//继承APP_Controller类
class Social extends APP_Controller {
    private $share_url = 'http://m.1b1u.com/social/';	
    private $access_token = '';
    private $user_id = 0;
    private $user_type = 0; //获取用户类型0用户1管家	
    private $anchor_id = 0;    // 对应live_anchor表中的anchor_id
    const share_pic = 'https://m.1b1u.com/static/img/app_logo.png';

    public function __construct() {
        parent::__construct();
        header('Content-type: application/json;charset=utf-8');  //文档为json格式
        // 允许ajax POST跨域访问
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $this->access_token = $this->input->post('number', true); //获取用户登陆access_token
        $this->user_type = intval($this->input->post('user_type', true)); //获取用户类型0用户1管家	
        $this->social_db = $this->load->database("live", TRUE);
        if (!empty($this->access_token)) {
            if (!in_array($this->user_type, array(0, 1))) {
                $returnData = array();
                $this->__outlivemsg($returnData, '用户类型参数错误!', '1000');
            }
            if ($this->user_type == 1) {//管家用户
                $this->user_id = $this->F_get_eid($this->access_token);
            } else {//普通用户
                $this->user_id = $this->F_get_mid($this->access_token);
            }
            if (!empty($this->user_id)) {//用户登录
                if ($this->user_type == 1) {//判断是管家
                    $sql = 'SELECT * FROM u_expert WHERE id= ' . $this->user_id;
                    $this->user_info = $this->db->query($sql)->row_array();
                } else {//判断是用户
                    $sql = 'SELECT * FROM u_member WHERE mid= ' . $this->user_id;
                    $this->user_info = $this->db->query($sql)->row_array();
                }
                $sql = 'SELECT * FROM live_anchor WHERE user_id= ' . $this->user_id . ' and user_type=' . $this->user_type;
                $live_anchor_data = $this->social_db->query($sql)->row_array();
                if (empty($live_anchor_data)) {
                    $live_anchor_data = $this->insert_live_anchor($this->user_id, $this->user_type);
                }
                $this->live_anchor_info = $live_anchor_data;
                $this->anchor_id = $live_anchor_data['anchor_id'];      // 魏勇添加
            } else {
                //$this->user_type = 0;
                //$returnData = array();	
                //$this->__outlivemsg($returnData,'您还没有登录','1001');				
            }
        }
        
    }

    /**
     * @desc 发布帖子
     * @author 魏勇
     * @param type $theme_id    帖子主题id
     * @param type $title       帖子标题
     * @param type $text        帖子正文
     * @param type $video_pic   帖子视频图片
     * @param type $video_url   帖子视频url
     * @param type $pic         帖子图片
     * @param type $line_id     帖子线路id
     */
    public function cfgm_putup_post() {
        if (empty($this->user_id)) {//用户没有登录
            $this->__errormsg('用户没有登录');
        }
        $theme_id = intval($this->input->post('theme_id', TRUE));
        $title = $this->input->post('title', TRUE);
        $text = $this->input->post('text', TRUE);
        $video_pic = $this->input->post('video_pic', TRUE);
        $video_url = $this->input->post('video_url', TRUE);
        $pic = $this->input->post('pic', TRUE);
        $line_id = intval($this->input->post('line_id', TRUE));

        $data = array();
        //$data['member_id'] = $this->user_id;
        $data['member_id'] = $this->anchor_id;    // 统一关联到live_anchor表中的anchor_id
        $data['theme_id'] = $theme_id;
        $data['title'] = $title;
        $data['content'] = $text;
        $data['video_pic'] = $video_pic;
        $data['video_url'] = $video_url;
        $pic = rtrim($pic, ',');
        $arr_pic = explode(',', $pic);
        $data['pic1'] = '';
        $data['pic2'] = '';
        $data['pic3'] = '';
        if (sizeof($arr_pic) >= 3) {
            $data['pic1'] = $arr_pic[0];
            $data['pic2'] = $arr_pic[1];
            $data['pic3'] = $arr_pic[2];
        } else if (count($arr_pic) >= 2) {
            $data['pic1'] = $arr_pic[0];
            $data['pic2'] = $arr_pic[1];
        } else if (1 <= count($arr_pic)) {
            $data['pic1'] = $arr_pic[0];
        }
        $data['line_id'] = $line_id;
        $data['update_time'] = time();

        $ret = $this->social_db->insert('social_theme_post', $data);
        
        if (empty($ret)) {
            $this->__errormsg("发布帖子失败");
        } else {
        	// 往social_dynamics表中插入记录
        	$post_id = $this->social_db->insert_id();
        	$dyn['post_id'] = $post_id;
        	$dyn['type'] = 1;       // 为1表示帖子
        	$dyn['theme_id'] = $data['theme_id'];
        	$dyn['pic1'] = $data['pic1'];
        	$dyn['pic2'] = $data['pic2'];
        	$dyn['pic3'] = $data['pic3'];
        	$dyn['member_id'] = $data['member_id'];
        	$dyn['update_time'] = $data['update_time'];
        	//获取配置
        	$integral_config=$this->config->item('integral_config');
        	$content = '发布帖子获得';
        	$this->db->trans_begin();//事务开启
        	//记录积分
        	$this->record_integration($this->user_id, $integral_config['dynamic_reward'], $content,1, $data['update_time'],0,array());       	
        	$this->social_db->insert('social_dynamics', $dyn);
        	$this->db->trans_complete(); //事务结束
        	//事务
        	if ($this->db->trans_status() === FALSE)
        	{
        		$this->db->trans_rollback();
        		$this->__errormsg("发布帖子失败,请重新发布");
        	}else{
        		$this->db->trans_commit();
        		$retData['post_id'] = $post_id;
            	$this->__outmsg($retData);
        	}
        }
    }

    /**
     * @desc 回复帖子
     * @param type $theme_id    帖子主题id
     * @param type $text        帖子正文
     * @param type $video_pic   帖子视频图片
     * @param type $video_url   帖子视频url
     * @param type $pic         帖子图片
     * @param type $line_id     帖子线路id
     * @param type $post_id     被回复帖子id
     */
    public function cfgm_response_post() {
        if (empty($this->user_id)) {//用户没有登录
            $this->__errormsg('用户没有登录');
        }
        $theme_id = intval($this->input->post('theme_id', TRUE));
        $text = $this->input->post('text', TRUE);
        $video_pic = $this->input->post('video_pic', TRUE);
        $video_url = $this->input->post('video_url', TRUE);
        $pic = $this->input->post('pic', TRUE);
        $line_id = intval($this->input->post('line_id', TRUE));
        $post_id = intval($this->input->post('post_id', TRUE));
        if (empty($post_id)) {
            $this->__errormsg('post_id不能为空');
        }

        $data = array();
        //$data['member_id'] = $this->user_id;
        $data['member_id'] = $this->anchor_id;       // 统一关联到live_anchor表中的anchor_id
        $data['theme_id'] = $theme_id;
        $data['content'] = $text;
        $data['video_pic'] = $video_pic;
        $data['video_url'] = $video_url;
        $data['pic1'] = $pic;
        $data['line_id'] = $line_id;
        $data['post_id'] = $post_id;
        $data['update_time'] = time();

        $ret = $this->social_db->insert('social_theme_post_answer', $data);
        if (empty($ret)) {
            $this->__errormsg("回复帖子失败!");
        } else {
        	// 对应帖子的参与数加1
        	$sql_incre_post = "UPDATE social_theme_post SET watched_count = watched_count + 1 WHERE id = {$post_id}";
        	//获取积分配置
        	$integral_config=$this->config->item('integral_config');
        	$content='回复帖子获得';
        	$this->db->trans_begin();//事务开启
        	$this->record_integration($this->user_id, $integral_config['comment_reply'], $content,1, $data['update_time'],0,array());
        	$this->social_db->query($sql_incre_post);
        	$this->db->trans_complete(); //事务结束
        	//事务
        	if ($this->db->trans_status() === FALSE)
        	{
        		$this->db->trans_rollback();
        		$this->__errormsg('回复帖子异常,请重新尝试');
        	}
        	else
        	{
        		$this->db->trans_commit();
        		$this->__outmsg('回复帖子成功!');
        	}
        }
    }

    /**
     * @desc 获取主题首页数据
     * @param type $page            第几页
     * @param type $page_size       每页条目数
     */
    public function cfgm_get_theme_home() {
        $page = $this->input->post('page', TRUE);
        $page_size = $this->input->post('page_size', TRUE);
        $page = empty($page) ? 1 : intval($page);
        $page_size = empty($page_size) ? 9 : intval($page_size);

        $from = ($page - 1) * $page_size;
        $sql = "SELECT id, name, icon, pic1 AS bg_pic FROM social_theme ORDER BY show_order DESC LIMIT {$from}, {$page_size}";
        $query = $this->social_db->query($sql);
        $returnData = $query->result_array();
        foreach($returnData as &$v){
            $arr_pic = explode(',', isset($v['bg_pic']) ? $v['bg_pic'] : '');
            $v['bg_pic'] = $this->__doImage($arr_pic);
        }
        $this->__outmsg($returnData);
    }

    /**
     * 获取主题详情数据分为三个接口
     */

    /**
     * @desc 获取主题详情页描述和线路部分
     * @param type theme_id 主题id
     * @param type page 第几页
     * @param type page_size 每页条数
     */
    public function cfgm_get_theme_detail_of_description() {
        $theme_id = $this->input->post('theme_id', TRUE);
        if (empty($theme_id)) {
            $this->__errormsg("theme_id不能为空");
        }
        // 主题描述
//        $sql = "SELECT name, icon, concern_count, concat_ws(',', pic1, pic2, pic3) as pic, concat_ws(',', video_url1, video_url2, video_url3) as video_urls, description  
//                FROM social_theme WHERE id = {$theme_id}";
        $sql = "SELECT name, icon, concern_count, pic1 as pic, video_url1 as video_urls, description
                FROM social_theme WHERE id = {$theme_id}";
        $returnData['desc'] = $this->social_db->query($sql)->row_array();
        if (empty($returnData['desc'])){
            $this->__nullmsg();
        }
        $arr_video_urls = explode(',', isset($returnData['desc']['video_urls']) ? $returnData['desc']['video_urls'] : '');
        $returnData['desc']['video_urls'] = $this->__doImage($arr_video_urls);
        $arr = explode(',', isset($returnData['desc']['pic']) ? $returnData['desc']['pic'] : '');
        $returnData['desc']['pic'] = $this->__doImage($arr);
        // 线路
        $sql_line_id = "SELECT line1, line2, line3, line4, line5, line6 FROM social_theme WHERE id = $theme_id";
        $arr_line = $this->social_db->query($sql_line_id)->row_array();
        $line1 = $arr_line['line1'] ? $arr_line['line1'] : 0;
        $line2 = $arr_line['line2'] ? $arr_line['line2'] : 0;
        $line3 = $arr_line['line3'] ? $arr_line['line3'] : 0;
        $line4 = $arr_line['line4'] ? $arr_line['line4'] : 0;
        $line5 = $arr_line['line5'] ? $arr_line['line5'] : 0;
        $line6 = $arr_line['line6'] ? $arr_line['line6'] : 0;
        $sql_line = "select distinct ul.id, ul.mainpic as pic, ul.linename as linename
            FROM u_line ul WHERE id in ( {$line1} , {$line2} , {$line3}  , {$line4} , {$line5} , {$line6} )";
        $returnData['line'] = $this->db->query($sql_line)->result_array();
        foreach($returnData['line'] as &$v){
            $arr_pic = explode(',', isset($v['pic']) ? $v['pic'] : '');
            $v['pic'] = $this->__doImage($arr_pic);
        }
        if (empty($this->user_id)) {    // 用户未登录
            $returnData['is_concern'] = 0;
            $returnData['desc']['concern_count'] = 0;
        } else {
//            $sql = "SELECT id FROM social_concern WHERE member_id = {$this->user_id} and type = 1 and category_id = {$theme_id}";
            $sql = "SELECT id FROM social_concern WHERE member_id = {$this->anchor_id} and type = 1 AND category_id = {$theme_id} AND content_id = 0";   // 将user_id改为anchor_id
            $query = $this->social_db->query($sql);
            if ($query->num_rows() < 1) {
                $returnData['is_concerned'] = 0;
            } else {
                $returnData['is_concerned'] = 1;
            }
        }
        // 获取主题下面帖子的数量
        $sql_theme = "SELECT COUNT(id) as count FROM social_theme_post WHERE theme_id = {$theme_id} ORDER BY NULL";
        $theme = $this->social_db->query($sql_theme)->row_array();
        $returnData['count'] = isset($theme['count']) ? $theme['count'] : 0;
        // 分享
        $returnData['desc']['share_url'] = $this->share_url . 'dongtai_share/?theme_id=' . $theme_id;
        $theme_name = isset($returnData['desc']['name']) ? $returnData['desc']['name'] : '';
        $returnData['desc']['share_name'] = '#'.$theme_name.'# | From 帮游网';
        $returnData['desc']['share_pic'] = Social::share_pic;
        $content = isset($returnData['desc']['description']) ? $returnData['desc']['description'] : '';
        $description = mb_substr($content, 0, 20, 'utf-8');
        $returnData['desc']['share_content'] = $description;
        $this->__outmsg($returnData);
    }

    /**
     * @desc 获取主题帖子
     * @param type theme_id 主题id
     * @param type page     第几页
     * @param type page_size 每页条数
     */
    public function cfgm_get_theme_detail_of_post() {
        // 获取主题下的帖子
        $theme_id = $this->input->post('theme_id', TRUE);
        if (empty($theme_id)) {
            $this->__errormsg('theme_id不能为空');
        }
//        SeasLog::info('user_type is:' . $this->user_type);
        if ($this->user_type != 0 && $this->user_type != 1) {
            $this->__errormsg('无效的user_type');
        }
        $page = $this->input->post('page', true);
        $page_size = $this->input->post('page_size', true);
        $page = empty($page) ? 1 : intval($page);
        $page_size = empty($page_size) ? 6 : intval($page_size);
        $from = ($page - 1) * $page_size;
//        $sql_post = "SELECT * FROM social_theme_post WHERE theme_id = {$theme_id} ORDER BY update_time DESC";
        $sql_post = "SELECT id, title, content, video_pic, video_url, concat_ws(',', pic1, pic2, pic3) as pics, member_id, theme_id, praise_count, 
            (select count(id) from social_theme_post_answer where post_id = stp.id) as watched_count, update_time, line_id, 
                '' as linename, '' as linepic, '' as nickname, '' as litpic
                FROM social_theme_post stp WHERE theme_id = {$theme_id} ORDER BY update_time DESC limit {$from}, $page_size";
        $arr_post = $this->social_db->query($sql_post)->result_array();
        // arr_post进行处理，获取member_id对应的昵称以及line_id对应的线路名和图片
        foreach ($arr_post as &$v) {
            // 根据member_id查询用户的昵称,根据line_id查询线路名称和图片
            $m_id = $v['member_id'];        // member_id对应live_anchor表中的anchor_id
            $line_id = $v['line_id'];
            // 判断用户是管家还是普通用户
            //$sql_type = "SELECT user_type FROM live_anchor WHERE user_id = {$m_id}";
//            SeasLog::info('m_id is:'.$m_id);
//            $query = $this->social_db->query($sql_type)->row_array();
//            $sql_member = '';
//            if (0 == $query['user_type']) {          // 普通用户
//                $sql_member = "SELECT nickname, litpic FROM u_member WHERE mid = {$m_id}";
//            } else if (1 == $query['user_type']) {    // 管家
//                $sql_member = "SELECT nickname, small_photo litpic FROM u_expert WHERE id = {$m_id}";
//            }
            $sql_member = "SELECT nickname, photo litpic, type FROM live_anchor WHERE anchor_id = {$m_id}";
            $member = $this->social_db->query($sql_member)->row_array();
            $sql_line = "SELECT linename, mainpic FROM u_line WHERE id = {$line_id}";
            $line = $this->db->query($sql_line)->row_array();
            $v['nickname'] = isset($member['nickname']) ? $member['nickname'] : '';
            $v['litpic'] = isset($member['litpic']) ? $member['litpic'] : '';
            $v['user_type'] = isset($member['type']) ? $member['type'] : -1;
            $v['linename'] = isset($line['linename']) ? $line['linename'] : '';
            
            $pics = isset($v['pics']) ? $v['pics'] : '';
            $pics = trim(trim($pics), ',');
            $arr_pics = explode(',', $pics);
            $v['pics'] = $this->__doImage($arr_pics);
            
            $mainpic = isset($line['mainpic']) ? $line['mainpic'] : '';
            $mainpic = trim(trim($mainpic), ',');
            $arr_linepic = explode(',', $mainpic);
            $v['linepic'] = $this->__doImage($arr_linepic);

            $video_pic = isset($v['video_pic']) ? $v['video_pic'] : '';
            $video_pic = trim(trim($video_pic), ',');
            $arr_video_pic = explode(',', $video_pic);
            $v['video_pic'] = $this->__doImage($arr_video_pic);

            $video_url = isset($v['video_url']) ? $v['video_url'] : '';
            $video_url = trim(trim($video_url), ',');
            $arr_video_url = explode(',', $video_url);
            $v['video_url'] = $this->__doImage($arr_video_url);
            
            // 当天是否对帖子点过赞
            $post_id = isset($v['id']) ? $v['id'] : 0;
            $sql_praised_post = "SELECT update_time FROM social_praise WHERE category_id = {$post_id} AND type = 1 AND member_id = {$this->anchor_id} ORDER BY update_time DESC LIMIT 1";
            $query_praised_post = $this->social_db->query($sql_praised_post);
            if ($query_praised_post->num_rows() < 1) {
                $v['praised_today'] = 0;
            } else {
                $ret = $query_praised_post->row_array();
                $update_time = $ret['update_time'];
                if (date('Y-m-d', time()) == date('Y-m-d', $update_time)) {
                    $v['praised_today'] = 1;
                } else {
                    $v['praised_today'] = 0;
                }
            }
        }
        $this->__outmsg($arr_post);
    }

    /**
     * @desc 获取某个帖子的回帖
     * @param  post_id  帖子id
     * @param  page     第几页
     * @param  page_size 每页条数
     */
    public function cfgm_get_theme_detail_of_post_answer() {
        file_put_contents('o.txt', $this->user_id);
        $post_id = $this->input->get_post('post_id', TRUE);
        if (empty($post_id)) {
            $this->__errormsg('post_id不能为空');
        }
        $page = $this->input->post('page', true);
        $page_size = $this->input->post('page_size', true);
        $page = empty($page) ? 1 : intval($page);
        $page_size = empty($page_size) ? 6 : intval($page_size);
        $from = ($page - 1) * $page_size;
        $sql_post_answer = "SELECT content, video_pic, video_url, concat_ws(',', pic1, pic2, pic3) as pics, member_id, praise_count,
            update_time, line_id, '' as linename, '' as linepic, '' as nickname, '' as litpic
            FROM social_theme_post_answer WHERE post_id = {$post_id} ORDER BY update_time DESC limit $from, $page_size";
        $ret = $this->social_db->query($sql_post_answer)->result_array();
        foreach ($ret as &$v) {
            $m_id = isset($v['member_id']) ? $v['member_id'] : 0;        // member_id对应live_anchor中的anchor_id
            $line_id = isset($v['line_id']) ? $v['line_id'] : 0;
            $sql_member = "SELECT nickname, photo litpic FROM live_anchor WHERE anchor_id = {$m_id}";
            $member = $this->social_db->query($sql_member)->row_array();
            $sql_line = "SELECT linename, mainpic FROM u_line WHERE id = {$line_id}";
            $line = $this->db->query($sql_line)->row_array();
            $v['nickname'] = isset($member['nickname']) ? $member['nickname'] : '';
            $v['litpic'] = isset($member['litpic']) ? $member['litpic'] : '';
            $v['linename'] = isset($line['linename']) ? $line['linename'] : '';

            $arr_pics = explode(',', isset($v['pics']) ? $v['pics'] : '');
            $v['pics'] = $this->__doImage($arr_pics);
            $arr_linepic = explode(',', isset($line['mainpic']) ? $line['mainpic'] : '');
            $v['linepic'] = $this->__doImage($arr_linepic);
            $arr_video_url = explode(',', isset($v['video_url']) ? $v['video_url'] : '');
            $v['video_url'] = $this->__doImage($arr_video_url);
            $arr_video_pic = explode(',', isset($v['video_pic']) ? $v['video_pic'] : '');
            $v['video_pic'] = $this->__doImage($arr_video_pic);
        }
        $this->__outmsg($ret);
    }

    /**
     * @desc 获取指定id的帖子
     * @param post_id  帖子id
     */
    public function get_post_by_id() {
        $post_id = $this->input->post('post_id', TRUE);
        if (empty($post_id)) {
            $this->__errormsg('post_id不能为空');
        }
        $sql_post = "SELECT id, title, content, video_pic, video_url, concat_ws(',', pic1, pic2, pic3) as pics, member_id, theme_id, praise_count, 
            (select count(id) from social_theme_post_answer where post_id = stp.id) as watched_count, update_time, line_id, 
                '' as linename, '' as linepic, '' as nickname, '' as litpic
                FROM social_theme_post stp WHERE id = {$post_id}";

        $v = $this->social_db->query($sql_post)->row_array();
        if (empty($v)){
            $this->__nullmsg();
        }
        // 获取主题名称
        $theme_id = isset($v['theme_id']) ? $v['theme_id'] : 0;
        $sql_theme = "SELECT name, description FROM social_theme WHERE id = $theme_id";
        $theme = $this->social_db->query($sql_theme)->row_array();
        $v['theme_name'] = isset($theme['name']) ? $theme['name'] : '';
        $m_id = isset($v['member_id']) ? $v['member_id'] : 0;    // member_id对应live_anchor表中的anchor_id
        $line_id = isset($v['line_id']) ? $v['line_id'] : 0;
        $sql_member = "SELECT nickname, photo litpic, type, user_id FROM live_anchor WHERE anchor_id = {$m_id}";    // 加入user_id
        $member = $this->social_db->query($sql_member)->row_array();
        $v['user_type'] = isset($member['type']) ? $member['type'] : -1;
        $v['user_id'] = isset($member['user_id']) ? $member['user_id'] : 0;

        $sql_line = "SELECT linename, mainpic FROM u_line WHERE id = {$line_id}";
        $line = $this->db->query($sql_line)->row_array();
        $v['nickname'] = isset($member['nickname']) ? $member['nickname'] : '';
        $v['litpic'] = isset($member['litpic']) ? $member['litpic'] : '';
        $v['linename'] = isset($line['linename']) ? $line['linename'] : '';

        $arr_pics = explode(',', $v['pics']);
        $v['pics'] = $this->__doImage($arr_pics);
        $arr_linepic = explode(',', isset($line['mainpic']) ? $line['mainpic'] : '');
        $v['linepic'] = $this->__doImage($arr_linepic);
        $arr_video_url = explode(',', isset($v['video_url']) ? $v['video_url'] : '');
        $v['video_url'] = $this->__doImage($arr_video_url);
        $arr_video_pic = explode(',', isset($v['video_pic']) ? $v['video_pic'] : '');
        $v['video_pic'] = $this->__doImage($arr_video_pic);
        
        if ($this->anchor_id) {   // 如果已登录
            // 是否已关注发帖人
            // 根据帖子id获取发帖人id
            $post_man_id = isset($v['member_id']) ? $v['member_id'] : 0;
            $sql_concerned_post_man = "SELECT id FROM social_concern WHERE category_id = {$post_man_id} AND type = 4 AND member_id = {$this->anchor_id}";
            $query_post_man = $this->social_db->query($sql_concerned_post_man);
            if ($query_post_man->num_rows() > 0) {
                $v['concerned_post_man'] = 1;
            } else {
                $v['concerned_post_man'] = 0;
            }
            // 当天是否对帖子点过赞
            //$sql_praised_post = "SELECT update_time FROM social_praise WHERE category_id = {$post_id} AND type = 1 AND member_id = {$this->user_id} ORDER BY update_time DESC LIMIT 1";
            $sql_praised_post = "SELECT update_time FROM social_praise WHERE category_id = {$post_id} AND type = 1 AND member_id = {$this->anchor_id} ORDER BY update_time DESC LIMIT 1";
            $query_praised_post = $this->social_db->query($sql_praised_post);
            if ($query_praised_post->num_rows() < 1) {
                $v['praised_today'] = 0;
            } else {
                $ret = $query_praised_post->row_array();
                $update_time = $ret['update_time'];
                if (date('Y-m-d', time()) == date('Y-m-d', $update_time)) {
                    $v['praised_today'] = 1;
                } else {
                    $v['praised_today'] = 0;
                }
            }
            // 是否是用户自己的帖子
            $member_id = "SELECT member_id FROM social_theme_post WHERE id = {$post_id}";
            $query_member_id = $this->social_db->query($member_id);
            if ($query_member_id->num_rows() > 0) {
                $ret = $query_member_id->row_array();
                if ($ret['member_id'] == $this->anchor_id) {
                    $v['is_self'] = 1;
                } else {
                    $v['is_self'] = 0;
                }
            }
        } else {
            $v['concerned_post_man'] = 0;
            $v['praised_today'] = 0;
            $v['is_self'] = 0;
        }
        // 分享
        $v['share_url'] = $this->share_url . 'dongtai_share/?post_id=' . $post_id;
        $v['share_name'] = '#'.$v['theme_name'].'# | From ' . $v['nickname'];
        $v['share_pic'] = Social::share_pic;
        $content = isset($v['content']) ? $v['content'] : '';
        $description = mb_substr($content, 0, 20, 'utf-8');
        $v['share_content'] = $description;
        $this->__outmsg($v);
    }

    /**
     * @desc 关注或取消关注
     * @param category_id       分类id
     * @param content_id        内容id
     * @param type              关注类型  1表示主题,2表示话题,3表示场景,4表示人
     */
    public function concern() {
        if (empty($this->user_id)) {
            $this->__errormsg('关注操作请先登录');
        }
        $type = $this->input->post('type', TRUE);
        if ($type != 1 && $type != 2 && $type != 3 && $type != 4) {
            $this->__errormsg('无效的type');
        }
        $category_id = $this->input->post('category_id', TRUE);
        if (empty($category_id)) {
            $this->__errormsg('category_id不能为空');
        }
        $content_id = $this->input->post('content_id', TRUE);
        $content_id = empty($content_id) ? 0 : $content_id;
        $time = time();
        $sql = "SELECT id FROM social_concern WHERE member_id = {$this->anchor_id} AND category_id = {$category_id} AND content_id = {$content_id} AND type = {$type}";
        $query = $this->social_db->query($sql);
        if ($query->num_rows() < 1) {    // 还没有关注,进行关注
            // 将对应的关注数加1
            if ($type == 1 && empty($content_id)) { // 主题
                $sql = "UPDATE social_theme SET concern_count = concern_count + 1 WHERE id = {$category_id}";
                $this->social_db->query($sql);
                $sql_insert = "INSERT INTO social_concern VALUES (null, {$category_id}, $content_id, $type, $this->anchor_id, $time)";
                $this->social_db->query($sql_insert);
                if ($this->social_db->affected_rows() > 0) {
                    $this->__outlivemsg('', '关注成功', 2000);
                } else {
//                    $this->social_db->trans_rollback();
                    $this->__errormsg('操作异常');
                }
            } else if ($type == 1 && !empty($content_id)) {   // 帖子
                $sql = "UPDATE social_theme_post SET watched_count = watched_count + 1 WHERE id = {$content_id} ";
                $this->social_db->query($sql);
                $sql_insert = "INSERT INTO social_concern VALUES (null, {$category_id}, $content_id, $type, $this->anchor_id, $time)";
                $this->social_db->query($sql_insert);
                if ($this->social_db->affected_rows() > 0) {
                    // 同步帖子的关注数到social_dynamics
                    $sql_dyn = "UPDATE social_dynamics SET watched_count = watched_count + 1 WHERE post_id = {$content_id} AND type = 1";   // type为1表示帖子
                    $this->social_db->query($sql_dyn);
                    $this->__outlivemsg('', '关注成功', 2000);
                } else {
                    $this->__errormsg('操作异常');
                }
            } else if ($type == 4 && empty($content_id)) {  // 人
                // TODO 修改用户表的关注数  ?
                $sql_insert = "INSERT INTO social_concern VALUES (null, {$category_id}, $content_id, $type, $this->anchor_id, $time)";
                $this->social_db->query($sql_insert);
                if ($this->social_db->affected_rows() > 0) {
                    $this->__outlivemsg('', '关注成功', 2000);
                } else {
                    $this->__errormsg('操作异常');
                }
            } else if ($type == 2 && empty($content_id)) { // 话题
                $sql = "UPDATE social_topic SET concern_count = concern_count + 1 WHERE id = {$category_id}";
                $this->social_db->query($sql);
                $sql_insert = "INSERT INTO social_concern VALUES (null, {$category_id}, $content_id, $type, $this->anchor_id, $time)";
                $this->social_db->query($sql_insert);
                if ($this->social_db->affected_rows() > 0) {
                    $this->__outlivemsg('', '关注成功', 2000);
                } else {
                    $this->__errormsg('操作异常');
                }
            } else if ($type == 2 && !empty($content_id)) {   // 问题
                $sql = "UPDATE social_topic_question SET concern_count = concern_count + 1 WHERE id = {$content_id} ";
                $this->social_db->query($sql);
                $sql_insert = "INSERT INTO social_concern VALUES (null, {$category_id}, $content_id, $type, $this->anchor_id, $time)";
                $this->social_db->query($sql_insert);
                if ($this->social_db->affected_rows() > 0) {
                    // 同步问题的关注数到social_dynamics
                    $sql_dyn = "UPDATE social_dynamics SET concern_count = concern_count + 1 WHERE post_id = {$content_id} AND type = 2";   // type为2表示问题
                    $this->social_db->query($sql_dyn);
                    $this->__outlivemsg('', '关注成功', 2000);
                } else {
                    $this->__errormsg('操作异常');
                }
            }
        } else {     // 关注过,取消关注
            // 将对应的关注数减1
            if ($type == 1 && empty($content_id)) { // 主题
                $sql = "UPDATE social_theme SET concern_count = concern_count - 1 WHERE id = {$category_id}";
                $this->social_db->query($sql);
                //$sql_del = "DELETE FROM social_concern WHERE member_id = {$this->user_id} AND category_id = {$category_id} AND content_id = {$content_id} AND type = {$type}";
                $sql_del = "DELETE FROM social_concern WHERE member_id = {$this->anchor_id} AND category_id = {$category_id} AND content_id = {$content_id} AND type = {$type}";
                $this->social_db->query($sql_del);
                if ($this->social_db->affected_rows() > 0) {
                    $this->__outlivemsg('', '取消关注成功', 2001);
                } else {
                    $this->__errormsg('操作异常');
                }
            } else if ($type == 1 && !empty($content_id)) {   // 帖子
                $sql = "UPDATE social_theme_post SET watched_count = watched_count - 1 WHERE id = {$content_id} ";
                $this->social_db->query($sql);
                //$sql_del = "DELETE FROM social_concern WHERE member_id = {$this->user_id} AND category_id = {$category_id} AND content_id = {$content_id} AND type = {$type}";
                $sql_del = "DELETE FROM social_concern WHERE member_id = {$this->anchor_id} AND category_id = {$category_id} AND content_id = {$content_id} AND type = {$type}";
                $this->social_db->query($sql_del);
                if ($this->social_db->affected_rows() > 0) {
                    // 同步帖子的关注数到social_dynamics
                    $sql_dyn = "UPDATE social_dynamics SET watched_count = watched_count - 1 WHERE post_id = {$content_id} AND type = 1";   // type为1表示帖子
                    $this->social_db->query($sql_dyn);
                    $this->__outlivemsg('', '取消关注成功', 2001);
                } else {
                    $this->__errormsg('操作异常');
                }
            } else if ($type == 4 && empty($content_id)) {  // 人
                // TODO 修改用户表的关注数  ?
                //$sql_del = "DELETE FROM social_concern WHERE member_id = {$this->user_id} AND category_id = {$category_id} AND content_id = {$content_id} AND type = {$type}";
                $sql_del = "DELETE FROM social_concern WHERE member_id = {$this->anchor_id} AND category_id = {$category_id} AND content_id = {$content_id} AND type = {$type}";
                $this->social_db->query($sql_del);
                if ($this->social_db->affected_rows() > 0) {
                    $this->__outlivemsg('', '取消关注成功', 2001);
                } else {
                    $this->__errormsg('操作异常');
                }
            } else if ($type == 2 && empty($content_id)) {  // 话题
                $sql = "UPDATE social_topic SET concern_count = concern_count - 1 WHERE id = {$category_id}";
                $this->social_db->query($sql);
                //$sql_del = "DELETE FROM social_concern WHERE member_id = {$this->user_id} AND category_id = {$category_id} AND content_id = {$content_id} AND type = {$type}";
                $sql_del = "DELETE FROM social_concern WHERE member_id = {$this->anchor_id} AND category_id = {$category_id} AND content_id = {$content_id} AND type = {$type}";
                $this->social_db->query($sql_del);
                if ($this->social_db->affected_rows() > 0) {
                    $this->__outlivemsg('', '取消关注成功', 2001);
                } else {
                    $this->__errormsg('操作异常');
                }
            } else if ($type == 2 && !empty($content_id)) {   // 问题
                $sql = "UPDATE social_topic_question SET concern_count = concern_count - 1 WHERE id = {$content_id} ";
                $this->social_db->query($sql);
                //$sql_del = "DELETE FROM social_concern WHERE member_id = {$this->user_id} AND category_id = {$category_id} AND content_id = {$content_id} AND type = {$type}";
                $sql_del = "DELETE FROM social_concern WHERE member_id = {$this->anchor_id} AND category_id = {$category_id} AND content_id = {$content_id} AND type = {$type}";
                $this->social_db->query($sql_del);
                if ($this->social_db->affected_rows() > 0) {
                    // 同步问题的关注数到social_dynamics
                    $sql_dyn = "UPDATE social_dynamics SET concern_count = concern_count - 1 WHERE post_id = {$content_id} AND type = 2";   // type为2表示问题
                    $this->social_db->query($sql_dyn);
                    $this->__outlivemsg('', '取消关注成功', 2001);
                } else {
                    $this->__errormsg('操作异常');
                }
            }
        }
    }

    /**
     * @desc 点赞              可多次点赞,不能取消点赞
     * @param type 类型        为1表示帖子,为2表示话题回答
     * @param category_id      帖子id或答案id
     */
    public function praise_post() {
        if (empty($this->user_id)) {//用户没有登录
            $this->__errormsg('没有登录');
        }
        $category_id = $this->input->post('category_id', TRUE);
        if (empty($category_id)) {
            $this->__errormsg('category_id不能为空');
        }
        $type = $this->input->post('type', TRUE);
        if ($type != 1 && $type != 2) {
            $this->__errormsg('无效的type');
        }
        $time = time();
        if (1 == $type){    // 帖子每天只能点赞一次
            // 获取上次点赞的时间
            //$sql_praisable = "SELECT update_time FROM social_praise WHERE category_id = {$category_id} AND type = {$type} AND member_id = {$this->user_id}";
            $sql_praisable = "SELECT update_time FROM social_praise WHERE category_id = {$category_id} AND type = 1 AND member_id = {$this->anchor_id}";
            $query = $this->social_db->query($sql_praisable);
            if ($query->num_rows() > 0) {
                $ret = $query->row_array();
                $update_time = $ret['update_time'];
                if (date('Y-m-d', $update_time) == date('Y-m-d', $time)) {
                    $this->__outlivemsg('', '点赞无效,每天只能点赞一次', 2001);
                }
            }
        }else if (2 == $type){  // 问题答案每一个用户只能点一次赞
            // 当前用户是否对这条答案已点赞
            $sql_praise = "SELECT id FROM social_praise WHERE category_id = {$category_id} AND type = 2 AND member_id = {$this->anchor_id}";
            $query = $this->social_db->query($sql_praise);
            if ($query->num_rows() > 0) {   // 已点过赞
                $this->__outlivemsg('', '不能重复点赞', 2001);
            } 
        }
        //$sql = "INSERT INTO social_praise VALUES(null, {$category_id}, {$this->user_id}, {$type}, $time) ON DUPLICATE KEY UPDATE update_time = {$time}";
        $sql = "INSERT INTO social_praise(category_id, member_id, type, update_time) VALUES({$category_id}, {$this->anchor_id}, {$type}, $time) ON DUPLICATE KEY UPDATE update_time = {$time}";
        $this->social_db->query($sql);
        if ($this->social_db->affected_rows() > 0) {
            // 点赞数加1
            if ($type == '1') {
                $sql_update_count = "UPDATE social_theme_post SET praise_count = praise_count + 1 WHERE id = {$category_id}";
                $this->social_db->query($sql_update_count);
                // 同步点赞数到social_dynamics
                $sql_dyn = "UPDATE social_dynamics SET praise_count = praise_count + 1 WHERE post_id = {$category_id} AND type = 1";    // type为1表示帖子
                $this->social_db->query($sql_dyn);
                $this->__outlivemsg('', '点赞成功', 2000);
            } else if ($type == '2') {
                $sql_update_count = "UPDATE social_topic_answer SET praise_count = praise_count + 1 WHERE id = {$category_id}";
                $this->social_db->query($sql_update_count);
                $this->__outlivemsg('', '点赞成功', 2000);
            }
        }
        $this->__errormsg('点赞操作异常');
    }

    /**
     * @method:插入用户信息
     * @author: xml
     * @param: $user_id:用户id；$user_type:用户类型 0:用户 ,1:管家
     */
    private function insert_live_anchor($user_id, $user_type) {
        $data = array();
        $user = $this->user_info;
        if ($user_id > 0 && $user_type == 0) { //用户注册主播
            $data['name'] = $user['nickname']; //真实姓名
            $data['photo'] = $user['litpic']; //头像图片
            $data['type'] = 0; //0普通用户1达人2领队3管家
        } elseif ($user_id > 0 && $user_type == 1) { //管家注册主播
            $data['name'] = $user['nickname']; //真实姓名
            $data['photo'] = $user['small_photo']; //头像图片
            $data['country'] = $user['country']; //国家id
            $data['type'] = 3; //0普通用户1达人2领队3管家
        }
        //添加的数据
        $data['user_id'] = $user_id;
        $data['user_type'] = $user_type; //注册类型
        //$data['status']=5;//用户状态
        if ($user_type == 1) { //管家直接是主播
            $data['status'] = 2; //主播状态
        } else {
            $data['status'] = 0; //用户状态
        }
        $data['mobile'] = $user['mobile']; //手机号
        $data['sex'] = $user['sex']; //性别
        $data['country'] = ($data['country'] ? $data['country'] : 0); //国家		
        $data['province'] = ($user['province'] ? $user['province'] : 0); //省份id
        $data['city'] = ($user['city'] ? $user['city'] : 0); //城市id
        $data['nickname'] = $user['nickname'];  // 昵称     weiyong add
        $this->social_db->insert("live_anchor", $data);
        $anchor_id = $this->social_db->insert_id();
        $data['anchor_id'] = $anchor_id;    
        return $data;
    }

    /*     * ****************************************话题*********************************************** */

    /**
     * @method get_topic_home
     * @time 2016-12-19 11:34:58
     * @desc 获取话题首页信息
     * @param string page   第几页
     * @param string page_size  每页多少条
     * @author 魏勇
     */
    public function get_topic_home() {
        $page = $this->input->post('page', true);
        $page = empty($page) ? 1 : (int) $page;
        $page_size = $this->input->post('page_size', TRUE);
        $page_size = empty($page_size) ? 4 : (int) $page_size;
        $from = ($page - 1) * $page_size;
        $sql_hot_topic = "SELECT id, name, involve_count, concern_count, bg_pic FROM social_topic ORDER BY update_time DESC LIMIT $from, $page_size";
        $query = $this->social_db->query($sql_hot_topic);
        if ($query->num_rows() == 0){
            $this->__nullmsg();
        }
        $ret['topic'] = $query->result_array();
        $sql_count = "SELECT id FROM social_topic";
        $query_count = $this->social_db->query($sql_count);
        $count = $query_count->num_rows();
        $page_count = 0;
        if ($count % $page_size > 0) {
            $page_count =  ceil($count / $page_size);
        } else {
            $page_count = $count / $page_size;
        }
        $ret['page_count'] = $page_count;
        // 当前第几页
        $ret['page'] = $page;
        // 获取话题下面的问题数,对图片进行处理
        foreach($ret['topic'] as &$v){
            $topic_id = isset($v['id']) ? $v['id'] : 0;
            $sql_question = "SELECT id FROM social_topic_question WHERE topic_id = $topic_id";
            $v['question_cnt'] = $this->social_db->query($sql_question)->num_rows();
            // 对图片进行处理
            $bg_pic = isset($v['bg_pic']) ? $v['bg_pic'] : '';
            $bg_pic = trim(trim($bg_pic), ',');
            $v['bg_pic'] = $this->__doImage(explode(',', $bg_pic));
            // 获取话题关注数
            $sql_topic_concern = "SELECT id FROM social_concern WHERE type = 2 AND category_id = $topic_id AND content_id = 0";
            $v['concern_count'] = $this->social_db->query($sql_topic_concern)->num_rows();
        }
//        $ret['topic'] = $topic;
        $this->__outmsg($ret);
    }

    /**
     * @method get_popular_question
     * @desc 获取大家都在问的问题   前五条
     */
    public function get_popular_question_home() {
        $sql_question = "SELECT id, topic_id, '' topic, title, content, involve_count, concern_count FROM social_topic_question ORDER BY involve_count DESC LIMIT 5";
        $ret['questions'] = $this->social_db->query($sql_question)->result_array();
        // 查询问题所属话题的名称
        foreach ($ret['questions'] as &$v) {
            $sql_topic = "SELECT name FROM social_topic WHERE id = {$v['topic_id']}";
            $arr_topic = $this->social_db->query($sql_topic)->row_array();
            $v['topic'] = isset($arr_topic['name']) ? $arr_topic['name'] : '';
            // 是否已关注当前问题 1表示已关注 0表示未关注
            $topic_id = isset($v['topic_id']) ? $v['topic_id'] : 0;
            $question_id = isset($v['id']) ? $v['id'] : 0;
            $sql_concern_type = "SELECT * FROM social_concern WHERE category_id = {$topic_id} AND content_id = {$question_id} AND member_id = {$this->anchor_id} AND type = 2";
            $query_type = $this->social_db->query($sql_concern_type);
            if ($query_type->num_rows() > 0) {
                $v['concerned_question'] = 1;         // 1表示已关注
            } else {
                $v['concerned_question'] = 0;         // 0表示未关注
            }
        }
        if (count($ret['questions']) == 0) {
            $this->__nullmsg();
        } else {
            $this->__outmsg($ret);
        }
    }

    /**
     * @method wanna_go
     * @desc 也许你想去
     * @param string count   需要显示的线路条数,默认为3
     */
    public function wanna_go() {
        $count = $this->input->post('count', TRUE);
        $count = empty($count) ? 3 : (int) $count;
        $sql = "SELECT line_id, name, pic FROM cfgm_hot_line LIMIT $count";
        $ret = $this->db->query($sql)->result_array();
        // 根据线路id查询线路名称
        foreach ($ret as &$v) {
            $line_id = $v['line_id'];
            $sql_linename = "SELECT linename FROM u_line WHERE id = $line_id";
            $line = $this->db->query($sql_linename)->row_array();
            $v['name'] = $line['linename'];
        }
        $this->__outmsg($ret);
    }

    /**
     * @method putup_question
     * @desc 发布问题
     * @param string topic_id 话题id
     * @param string number 用户token
     * @param string user_type 用户类型  0为普通用户,1为管家
     * @param string title  问题标题
     * @param string content 问题正文
     * @param string pics    提问图片
     * @param string line_id 提问线路id
     * @param string invited_id 受邀大咖id
     * @param string video_pic  视频图片
     * @param string video_url  视频url
     */
    public function putup_question() {
        if (empty($this->user_id)) {
            $this->__errormsg('请先登录再发布问题');
        }
        $topic_id = $this->input->post('topic_id', TRUE);
        if (empty($topic_id)) {
            $this->__errormsg('topic_id不能为空');
        }
        $title = $this->input->post('title', TRUE);
        if (empty($title)) {
            $this->__errormsg('标题不能为空');
        }
        $content = $this->input->post('content', TRUE);
        if (empty($content)) {
            $this->__errormsg('提问内容不能为空');
        }
        $invited_id = $this->input->post('invited_id', TRUE);
        $pics = $this->input->post('pics', TRUE);
        $line_id = $this->input->post('line_id', TRUE);
        $video_pic = $this->input->post('video_pic', TRUE);
        $video_url = $this->input->post('video_url', TRUE);
        $data['topic_id'] = $topic_id;
        //$data['member_id'] = $this->user_id;
        $data['member_id'] = $this->anchor_id;
        $data['title'] = $title;
        $data['content'] = $content;
        $data['update_time'] = time();
//        $data['pic1'] = $pics;
        
        $pics = rtrim($pics, ',');
        $arr_pic = explode(',', $pics);
        $data['pic1'] = '';
        $data['pic2'] = '';
        $data['pic3'] = '';
        if (sizeof($arr_pic) >= 3) {
            $data['pic1'] = $arr_pic[0];
            $data['pic2'] = $arr_pic[1];
            $data['pic3'] = $arr_pic[2];
        } else if (count($arr_pic) >= 2) {
            $data['pic1'] = $arr_pic[0];
            $data['pic2'] = $arr_pic[1];
        } else if (1 <= count($arr_pic)) {
            $data['pic1'] = $arr_pic[0];
        }
        
        $data['line_id'] = $line_id;
        $data['invited_id'] = $invited_id;
        $data['video_pic'] = $video_pic;
        $data['video_url'] = $video_url;
        $ret = $this->social_db->insert('social_topic_question', $data);
        $question_id = $this->social_db->insert_id();
        $data['question_id'] = $question_id;
        
        
        if (empty($ret)) {
            $this->__errormsg('发布问题失败');
        } else {
            // 往social_dynamics表中插入记录
            $post_id = $question_id;
            $dyn['post_id'] = $post_id;
            $dyn['type'] = 2;       // 为2表示问题
            $dyn['theme_id'] = $data['topic_id'];
            $dyn['pic1'] = $data['pic1'];
            $dyn['pic2'] = $data['pic2'];
            $dyn['pic3'] = $data['pic3'];
            $dyn['member_id'] = $data['member_id'];
            $dyn['update_time'] = $data['update_time']; 
            //获取积分配置
            $integral_config=$this->config->item('integral_config');
            $content='发布问题获得';
            $this->db->trans_begin();//事务开启
            $this->record_integration($this->user_id, $integral_config['dynamic_reward'], $content,1, $data['update_time'],0,array());
            $this->social_db->insert('social_dynamics', $dyn);
            $this->db->trans_complete(); //事务结束
            //事务
            if ($this->db->trans_status() === FALSE)
            {
            	$this->db->trans_rollback();
            	$this->__errormsg('发布问题失败,请重新尝试');
            }
            else
            {
            	$this->db->trans_commit();
            	$this->__outmsg(array('question_id' => $question_id));
            }  
        }
    }

    /**
     * @method putup_answer
     * @desc 发布回答
     * @param string question_id 问题id
     * @param string number 用户token
     * @param string user_type 用户类型  0为普通用户,1为管家
     * @param string content 问题正文
     * @param string pics    提问图片
     * @param string line_id 提问线路id
     * @param string video_pic 视频图片
     * @param string video_url 视频地址
     */
    public function putup_answer() {
        if (empty($this->user_id)) {
            $this->__errormsg('请先登录再发布问题');
        }
        $question_id = $this->input->post('question_id', TRUE);
        if (empty($question_id)) {
            $this->__errormsg('问题id不能为空');
        }
        $content = $this->input->post('content', TRUE);
        if (empty($content)) {
            $this->__errormsg('提问内容不能为空');
        }
        $pics = $this->input->post('pics', TRUE);
        $line_id = $this->input->post('line_id', TRUE);
        $video_pic = $this->input->post('video_pic', TRUE);
        $video_url = $this->input->post('video_url', TRUE);

        $data['question_id'] = $question_id;
        $data['content'] = $content;
        $data['pic1'] = $pics;
        $data['line_id'] = $line_id;
        $data['update_time'] = time();
        $data['video_pic'] = $video_pic;
        $data['video_url'] = $video_url;
        //$data['member_id'] = $this->user_id;
        $data['member_id'] = $this->anchor_id;

        $ret = $this->social_db->insert('social_topic_answer', $data);
        if (empty($ret)) {
            $this->__errormsg('回答失败');
        } else {
            // 对应问题的参与数加1
            $sql_incre_quest = "UPDATE social_topic_question SET involve_count = involve_count + 1 WHERE id = {$question_id}";
            $this->social_db->query($sql_incre_quest);
            // 对应话题的参与数加1
            // 根据question_id获得topic_id
            $sql_topic = "SELECT topic_id FROM social_topic_question WHERE id = {$question_id}";
            $topic = $this->social_db->query($sql_topic)->row_array();
            $topic_id = isset($topic['topic_id']) ? $topic['topic_id'] : 0;
            $sql_incre_topic = "UPDATE social_topic SET involve_count = involve_count + 1 WHERE id = {$topic_id}";
            //获取积分配置
            $integral_config=$this->config->item('integral_config');
            $content='回答问题获得';
            $this->db->trans_begin();//事务开启
            $this->record_integration($this->user_id, $integral_config['comment_reply'], $content,1, $data['update_time'],0,array());
            $this->social_db->query($sql_incre_topic);
            $this->db->trans_complete(); //事务结束
            //事务
            if ($this->db->trans_status() === FALSE)
            {
            	$this->db->trans_rollback();
            	$this->__errormsg('回答异常,请重新尝试');
            }
            else
            {
            	$this->db->trans_commit();
            	$this->__outmsg('回答成功');
            }
        }
    }

    /**
     * @method get_geek_list
     * @desc   获取大咖列表
     * @param  type   大咖类型  1达人2领队3管家
     */
    // TODO new 大咖配置表
        public function get_geek_list() {
        $sql_1 = "SELECT type, anchor_id, photo, nickname FROM live_anchor WHERE type = 1 AND anchor_id <> {$this->anchor_id} ORDER BY applytime LIMIT 20";
        $query_1 = $this->social_db->query($sql_1);
        $ret['daren'] = $query_1->result_array();
        $sql_2 = "SELECT type, anchor_id, photo, nickname FROM live_anchor WHERE type = 2 AND anchor_id <> {$this->anchor_id} ORDER BY applytime LIMIT 20";
        $query_2 = $this->social_db->query($sql_2);
        $ret['lingdui'] = $query_2->result_array();
        $sql_3 = "SELECT type, anchor_id, photo, nickname FROM live_anchor WHERE type = 3 AND anchor_id <> {$this->anchor_id} ORDER BY applytime LIMIT 20";
        $query_3 = $this->social_db->query($sql_3);
        $ret['guanjia'] = $query_3->result_array();
        foreach ($ret as &$v) {
            foreach ($v as &$val) {
                $photo_arr = explode(',', $val['photo']);
                $val['photo'] = $this->__doImage($photo_arr);
            }
        }
        $this->__outmsg($ret);
    }

    /**
     * @method geek_search
     * @desc 大咖搜索
     * @param content   搜索内容
     * @param type 大咖类型 1达人2领队3管家
     */
    public function geek_search() {
        $type = $this->input->post('type', TRUE);
        if ($type != 1 && $type != 2 && $type != 3) {
            $this->__errormsg('无效的type');
        }
        $content = $this->input->post('content', TRUE);
        $sql = "SELECT anchor_id, type, photo, nickname FROM live_anchor WHERE nickname like '%$content%' AND type = $type ORDER BY applytime";
        $ret = $this->social_db->query($sql)->result_array();
        foreach ($ret as &$v) {
            $arr_photo = explode(',', $v['photo']);
            $v['photo'] = $this->__doImage($arr_photo);
        }
        $this->__outmsg($ret);
    }

    /**
     * @method  get_topic_detail
     * @desc    获取话题详情描述部分
     * @param   topic_id    话题id
     * @param   number      用户token
     */
    public function get_topic_detail_of_descrition() {
        $topic_id = $this->input->post('topic_id', TRUE);
        if (empty($topic_id)) {
            $this->__errormsg("话题id不能为空");
        }
        // 话题描述
        $sql = "SELECT name, bg_pic, concern_count, description, involve_count, video_pic, video_url  
                FROM social_topic WHERE id = {$topic_id}";
        $returnData['desc'] = $this->social_db->query($sql)->row_array();
        if (empty($this->user_id)) {    // 用户未登录
            $returnData['is_concerned'] = 0;
            $returnData['desc']['concern_count'] = 0;
        } else {
            //$sql = "SELECT id FROM social_concern WHERE member_id = {$this->user_id} and type = 2 and category_id = {$topic_id}";
            $sql = "SELECT id FROM social_concern WHERE member_id = {$this->anchor_id} and type = 2 and category_id = {$topic_id} AND content_id = 0";
            $query = $this->social_db->query($sql);
            if ($query->num_rows() < 1) {
                $returnData['is_concerned'] = 0;
            } else {
                $returnData['is_concerned'] = 1;
            }
        }
        $arr_bg_pic = explode(',', $returnData['desc']['bg_pic']);
        $returnData['desc']['bg_pic'] = $this->__doImage($arr_bg_pic);
        $arr_video_pic = explode(',', $returnData['desc']['video_pic']);
        $returnData['desc']['video_pic'] = $this->__doImage($arr_video_pic);
        $arr_video_url = explode(',', $returnData['desc']['video_url']);
        $returnData['desc']['video_url'] = $this->__doImage($arr_video_url);
         // 分享
        $returnData['share_url'] = $this->share_url . 'question_share/?topic_id=' . $topic_id;
        $theme_name = isset($returnData['desc']['name']) ? $returnData['desc']['name'] : '';
        $returnData['share_name'] = '#'.$theme_name.'# | From 帮游网';
        $returnData['share_pic'] = Social::share_pic;
        $content = isset($returnData['desc']['description']) ? $returnData['desc']['description'] : '';
        $description = mb_substr($content, 0, 20, 'utf-8');
        $returnData['share_content'] = $description;
        $this->__outmsg($returnData);
    }

    /**
     * @method get_topic_detail_of_question
     * @desc    获取话题详情中的问题
     * @param   topic_id    话题id
     */
    public function get_topic_detail_of_question() {
        // 获取话题下的问题
        $topic_id = $this->input->post('topic_id', TRUE);
        if (empty($topic_id)) {
            $this->__errormsg('topic_id不能为空');
        }
        $page = $this->input->post('page', true);
        $page_size = $this->input->post('page_size', true);
        $page = empty($page) ? 1 : intval($page);
        $page_size = empty($page_size) ? 5 : intval($page_size);
        $from = ($page - 1) * $page_size;
        $sql = "SELECT id, topic_id, member_id, title, content, update_time, involve_count,
                    concern_count, pic1 as pics, line_id, video_pic, video_url FROM social_topic_question where topic_id = {$topic_id} ORDER BY update_time DESC limit {$from}, {$page_size}";
        $ret = $this->social_db->query($sql)->result_array();
        foreach ($ret as &$v) {
            $arr_pics = explode(',', $v['pics']);
            $v['pics'] = $this->__doImage($arr_pics);
            $arr_video_pic = explode(',', isset($v['video_pic']) ? $v['video_pic'] : '');
            $v['video_pic'] = $this->__doImage($arr_video_pic);
            $arr_video_url = explode(',', $v['video_url']);
            $v['video_url'] = $this->__doImage($arr_video_url);
            // 判断用户是管家还是普通用户
            $sql_member = "SELECT nickname, type user_type, user_id FROM live_anchor WHERE anchor_id = {$v['member_id']}";   // 加入user_type, user_id
            $member = $this->social_db->query($sql_member)->row_array();
            $v['nickname'] = isset($member['nickname']) ? $member['nickname'] : '';
            $v['user_type'] = isset($member['user_type']) ? $member['user_type'] : 0;
            $v['user_id'] = isset($member['user_id']) ? $member['user_id'] : 0;
            // 是否已关注当前问题  1表示已关注 0表示未关注
            $question_id = isset($v['id']) ? $v['id'] : 0;
            $sql_concern_type = "SELECT * FROM social_concern WHERE category_id = {$topic_id} AND content_id = {$question_id} AND member_id = {$this->anchor_id} AND type = 2";
            $query_type = $this->social_db->query($sql_concern_type);
            if ($query_type->num_rows() > 0) {
                $v['concerned_question'] = 1;         // 1表示已关注
            } else {
                $v['concerned_question'] = 0;         // 0表示未关注
            }
            // 获取问题的回答数
            $sql_answer = "SELECT id FROM social_topic_answer WHERE question_id = $question_id";
            $v['answer_cnt'] = $this->social_db->query($sql_answer)->num_rows();
        }
        $this->__outmsg($ret);
    }

    /**
     * @name get_question_detail
     * @desc 获取问题详情
     * @param question_id   问题id
     */
    public function get_question_detail() {
        $question_id = $this->input->post('question_id', TRUE);
        if (empty($question_id)) {
            $this->__errormsg('问题id不能为空');
        }
        $sql = "SELECT id, topic_id, member_id, title, content, update_time, involve_count, concern_count, ''  pics, pic1, pic2, pic3, line_id, video_pic, video_url FROM social_topic_question WHERE id = {$question_id}";
        $ret = $this->social_db->query($sql)->row_array();
        $arr_video_pic = explode(',', isset($ret['video_pic']) ? $ret['video_pic'] : '');
        $arr_video_url = explode(',', isset($ret['video_url']) ? $ret['video_url'] : '');
        $pic1 = isset($ret['pic1']) ? $ret['pic1'] : '';
        $pic2 = isset($ret['pic2']) ? $ret['pic2'] : '';
        $pic3 = isset($ret['pic3']) ? $ret['pic3'] : '';
        $pics = '';
        if (empty($pic2)){
            $pics = $pic1 . ',' . $pic3;
        }else{
            $pics = $pic1 . ',' . $pic2 . ',' . $pic3;
        }
        $pics = trim(trim($pics), ',');
        $arr_pics = explode(',', $pics);
        $ret['pics'] = $this->__doImage($arr_pics);
        $ret['video_pic'] = $this->__doImage($arr_video_pic);
        $ret['video_url'] = $this->__doImage($arr_video_url);
        // 是否已关注当前问题
        // 根据问题id获取发问人id
        $sql_post_man_id = "SELECT topic_id FROM social_topic_question WHERE id = {$question_id}";
        $ret_post_man = $this->social_db->query($sql_post_man_id)->row_array();
        $topic = isset($ret_post_man['topic_id']) ? $ret_post_man['topic_id'] : 0;
        //$sql_concerned_post_man = "SELECT id FROM social_concern WHERE category_id = {$post_man_id} AND content_id = {$question_id} AND type = 2 AND member_id = {$this->user_id}";
        // 是否关注某个问题
        //$sql_concerned_post_man = "SELECT id FROM social_concern WHERE category_id = {$post_man_id} AND content_id = {$question_id} AND type = 2 AND member_id = {$this->anchor_id}";
        $sql_concerned_post_man = "SELECT id FROM social_concern WHERE category_id = {$topic} AND content_id = {$question_id} AND type = 2 AND member_id = {$this->anchor_id}";
        $query_post_man = $this->social_db->query($sql_concerned_post_man);
        if ($query_post_man->num_rows() > 0) {
            $ret['concerned_question_man'] = 1;
        } else {
            $ret['concerned_question_man'] = 0;
        }
        // 根据线路id获取线路名称和线路图片
        $sql_line = "SELECT linename, mainpic FROM u_line WHERE id = {$ret['line_id']}";
        $ret_line = $this->db->query($sql_line)->row_array();
        $ret['linename'] = isset($ret_line['linename']) ? $ret_line['linename'] : '';
        $ret['linepic'] = isset($ret_line['mainpic']) ? $ret_line['mainpic'] : '';
        $ret['update_time'] = date('Y-m-d', isset($ret['update_time']) ? $ret['update_time'] : 0);
        // 昵称，头像
        //$sql_member = "SELECT nickname, photo FROM live_anchor WHERE user_id = {$ret['member_id']}";
        $sql_member = "SELECT nickname, photo, type, user_id FROM live_anchor WHERE anchor_id = {$ret['member_id']}";   // 加入user_id
        $query_member = $this->social_db->query($sql_member)->row_array();
        $ret['nickname'] = isset($query_member['nickname']) ? $query_member['nickname'] : '';
        $ret['photo'] = isset($query_member['photo']) ? $query_member['photo'] : '';
        $arr_photo = explode(',', isset($ret['photo']) ? $ret['photo'] : '');
        $ret['photo'] = $this->__doImage($arr_photo);
        $ret['user_type'] = isset($query_member['type']) ? $query_member['type'] : -1;
        $ret['user_id'] = isset($query_member['user_id']) ? $query_member['user_id'] : 0;
        // 话题名称
        $sql_topicname = "SELECT name FROM social_topic WHERE id = {$ret['topic_id']}";
        $query_topicname = $this->social_db->query($sql_topicname)->row_array();
        $ret['topicname'] = isset($query_topicname['name']) ? $query_topicname['name'] : '';
        // 图片路径处理
        $arr_pic = explode(',', $ret['linepic']);
        $ret['linepic'] = $this->__doImage($arr_pic);
        // 分享
        $ret['share_url'] = $this->share_url . 'dongtai_share/?question_id=' . $question_id;
        $theme_name = isset($ret['title']) ? $ret['title'] : '';
        //$ret['share_name'] = '#'.$theme_name.'# | From 帮游网';
        $ret['share_name'] = '我分享了'. '#'.$theme_name.'#';
        $ret['share_pic'] = Social::share_pic;
        $content = isset($ret['content']) ? $ret['content'] : '';
        $description = mb_substr($content, 0, 20, 'utf-8');
        $ret['share_content'] = $description;

        $this->__outlivemsg($ret);
    }

    /**
     * @name get_question_answer_list
     * @desc 获取某个问题答案列表
     * @param question_id   问题id
     * @param page  第几页
     * @param page_size 每页多少条
     */
    public function get_question_answer_list() {
        $question_id = $this->input->post('question_id', TRUE);
        if (empty($question_id)) {
            $this->__errormsg('问题id不能为空');
        }
        $page = $this->input->post('page', TRUE);
        $page = empty($page) ? 1 : (int) $page;
        $page_size = $this->input->post('page_size', TRUE);
        $page_size = empty($page_size) ? 5 : (int) $page_size;
        $from = ($page - 1) * $page_size;
        $sql = "SELECT id, '' as photo, '' as nickname, question_id, member_id, content, praise_count, line_id, pic1 as pics, update_time, video_pic, video_url FROM social_topic_answer WHERE question_id = {$question_id} ORDER BY update_time DESC LIMIT {$from}, {$page_size}";
        $ret = $this->social_db->query($sql)->result_array();
        foreach ($ret as &$v) {
            $arr_pics = explode(',', isset($v['pics']) ? $v['pics'] : '');
            $v['pics'] = $this->__doImage($arr_pics);
            // 头像,昵称
            $v['member_id'] = isset($v['member_id']) ? $v['member_id'] : 0;
            //$sql_member = "SELECT photo, nickname FROM live_anchor WHERE user_id = {$v['member_id']}";
            $sql_member = "SELECT photo, nickname FROM live_anchor WHERE anchor_id = {$v['member_id']}";
            $ret_member = $this->social_db->query($sql_member)->row_array();
            $v['photo'] = isset($ret_member['photo']) ? $ret_member['photo'] : '';
            $v['nickname'] = isset($ret_member['nickname']) ? $ret_member['nickname'] : '';
            // 当前用户是否对这条答案已点赞
            $answer_id = isset($v['id']) ? $v['id'] : 0;
            //$sql_praise = "SELECT id FROM social_praise WHERE category_id = {$question_id} AND type = 2 AND member_id = {$this->user_id}";
            $sql_praise = "SELECT id FROM social_praise WHERE category_id = {$answer_id} AND type = 2 AND member_id = {$this->anchor_id}";
            $query = $this->social_db->query($sql_praise);
            if ($query->num_rows() > 0) {
                $v['praised'] = '1';
            } else {
                $v['praised'] = 0;
            }
            // 线路名称,线路图片
            $line_id = isset($v['line_id']) ? $v['line_id'] : 0;
            $sql_line = "SELECT linename, mainpic FROM u_line WHERE id = {$line_id}";
            $ret_line = $this->db->query($sql_line)->row_array();
            $v['linename'] = isset($ret_line['linename']) ? $ret_line['linename'] : '';
            $v['linepic'] = isset($ret_line['mainpic']) ? $ret_line['mainpic'] : '';
            $arr_line_pic = explode(',', $v['linepic']);
            $v['linepic'] = $this->__doImage($arr_line_pic);
            // video_pic,video_url处理
            $arr_video_pic = explode(',', isset($v['video_pic']) ? $v['video_pic'] : '');
            $v['video_pic'] = $this->__doImage($arr_video_pic);
            $arr_video_url = explode(',', isset($v['video_url']) ? $v['video_url'] : '');
            $v['video_url'] = $this->__doImage($arr_video_url);
            // photo处理
            $arr_photo = explode(',', $v['photo']);
            $v['photo'] = $this->__doImage($arr_photo);
        }

        $this->__outmsg($ret);
    }

    /**************************************************场景**************************************************/

    /**
     * @method get_scene_home
     * @desc 获取场景首页信息
     * @param page   第几页
     * @param page_size 每页条数
     */
    public function get_scene_home() {
        $page = $this->input->post('page', TRUE);
        $page_size = $this->input->post('page_size', TRUE);
        $page = empty($page) ? 1 : (int) $page;
        $page_size = empty($page_size) ? 6 : (int) $page_size;
        $from = ($page - 1) * $page_size;
        $this->input->post('page_size', TRUE);
        $sql = "SELECT c.scene_id, s.name, s.scene_pic, c.type_id FROM cfgm_social_scene c LEFT JOIN social_scene s ON c.scene_id = s.id WHERE c.is_show = 1 ORDER BY show_order DESC LIMIT {$from}, {$page_size}";
        $ret = $this->social_db->query($sql)->result_array();
        foreach ($ret as &$v) {
            // 对scene_pic做处理
            $arr_scene_pic = explode(',', $v['scene_pic']);
            $v['scene_pic'] = $this->__doImage($arr_scene_pic);
            // 对name做处理
            if ($v['type_id'] == 2) {
                $v['name'] = '美景';
            } else if ($v['type_id'] == 3) {
                $v['name'] = '美食';
            } else if ($v['type_id'] == 4) {
                $v['name'] = '生活';
            } else if ($v['type_id'] == 5) {
                $v['name'] = '亲子';
            } else if ($v['type_id'] == 6) {
                $v['name'] = '服务';
            }
        }
        // 对scene_pic做处理结束
        $this->__outmsg($ret);
    }

    /**
     * @method  get_videos_of_scene
     * @desc    获取某个场景下的视频
     * @param   type_id    场景类型id
     * @param   page        第几页
     * @param   page_size   每页条数
     */
    public function get_videos_of_scene() {
        $type_id = $this->input->post('type_id', TRUE);
        if (empty($type_id)) {
            $this->__errormsg('场景类型id不能为空');
        }
        $page = $this->input->post('page', TRUE);
        $page_size = $this->input->post('page_size', TRUE);
        $page = empty($page) ? 1 : (int) $page;
        $page_size = empty($page_size) ? 4 : (int) $page_size;
        $from = ($page - 1) * $page_size;
        //$sql = "SELECT s.video_id, l.name, l.pic, l.people, l.dest_id FROM social_scene_video s LEFT JOIN live_video l ON s.video_id = l.id WHERE s.scene_id = {$scene_id} ORDER BY l.people DESC LIMIT {$from}, {$page_size}";
        $sql = "SELECT l.id as video_id, l.name, l.pic, l.people, l.dest_id FROM live_video l WHERE l.attr_id = {$type_id} ORDER BY l.people DESC LIMIT {$from}, {$page_size}";
//        $sql = "SELECT id video_id, video_name name, video_pic pic, 0 as people, 0 as dest_id FROM social_scene_video LIMIT {$from}, {$page_size}";
        $ret = $this->social_db->query($sql)->result_array();
        foreach ($ret as &$v) {
            // 处理pic
            $arr_pic = explode(',', $v['pic']);
            $v['pic'] = $this->__doImage($arr_pic);
            // 根据目的地id获取目的地名称
            $sql_dest = "SELECT kindname FROM u_dest_cfg WHERE id = {$v['dest_id']}";
            $dest = $this->db->query($sql_dest)->row_array();
            if (empty($dest)) {
                $dest['kindname'] = '';
            }
            $v['dest_name'] = $dest['kindname'];
        }
        $this->__outmsg($ret);
    }

    /**
     * @name get_video_info_by_id
     * @desc 根据id获取视频的信息
     * @param video_id  视频id
     */
    public function get_video_info_by_id() {
        $video_id = $this->input->post('video_id', TRUE);
        if (empty($video_id)) {
            $this->__errormsg('视频id不能为空!');
        }
        $sql = "SELECT id, anchor_id, video, name, people FROM live_video WHERE id = {$video_id}";
        $ret = $this->social_db->query($sql)->row_array();
        if ($ret) {
            // 根据主播id获取主播昵称
            $sql_anchor = "SELECT nickname FROM live_anchor WHERE anchor_id = {$ret['anchor_id']}";
            $anchor = $this->social_db->query($sql_anchor)->row_array();
            $ret['anchor_name'] = isset($anchor['nickname']) ? $anchor['nickname'] : '';
        }
        $this->__outmsg($ret);
    }

    
    /**************************************************大咖**************************************************/
    /**
     * @method get_home_daka
     * @desc    获取首页大咖
     */
    public function get_home_daka() {
        $sql_daka = "SELECT type, anchor_id, user_id, nickname, photo FROM live_anchor WHERE type <> 0 ORDER BY applytime LIMIT 6";
        $ret = $this->social_db->query($sql_daka)->result_array();
        foreach ($ret as &$v) {
            $arr_photo = explode(',', $v['photo']);
            $v['photo'] = $this->__doImage($arr_photo);
        }
        $this->__outmsg($ret);
    }

    /**
     * @method  get_daka_dynamics
     * @desc    获取大咖动态
     * @param   page    第几页
     * @param   page_size   每页多少条
     */
    public function get_daka_dynamics() {
        $page = $this->input->post('page', TRUE);
        $page_size = $this->input->post('page_size', TRUE);
        $page = (empty($page)) ? 1 : (int) $page;
        $page_size = (empty($page_size)) ? 5 : (int) $page_size;
        $from = ($page - 1) * $page_size;
        $sql_dynamics = "SELECT id, type, theme_id, '' pics, pic1, pic2, pic3, member_id, praise_count, watched_count, involve_count, concern_count, post_id, update_time FROM social_dynamics ORDER BY update_time DESC LIMIT {$from}, {$page_size}";
        $ret = $this->social_db->query($sql_dynamics)->result_array();
        if (empty($ret)){
            $this->__nullmsg();
        }
        foreach ($ret as &$v) {
            $pic1 = isset($v['pic1']) ? $v['pic1'] : '';
            $pic2 = isset($v['pic2']) ? $v['pic2'] : '';
            $pic3 = isset($v['pic3']) ? $v['pic3'] : '';
            $pics = '';
            if (empty($pic2)){
                $pics = $pic1 . ',' . $pic3;
            }else{
                $pics = $pic1 . ',' . $pic2 . ',' . $pic3;
            }
            $pics = trim(trim($pics), ',');
            $arr_pics = explode(',', $pics);
            $v['pics'] = $this->__doImage($arr_pics);
            // 根据member_id获取用户昵称和头像
            $member_id = isset($v['member_id'] ) ? $v['member_id'] : 0;
            $sql_member = "SELECT nickname, photo, user_id, type user_type FROM live_anchor WHERE anchor_id = {$member_id}";
            $member = $this->social_db->query($sql_member)->row_array();
            $v['nickname'] = isset($member['nickname']) ? $member['nickname'] : '';
            $v['photo'] = isset($member['photo']) ? $member['photo'] : '';
            $arr_photo = explode(',', $v['photo']);
            $v['photo'] = $this->__doImage($arr_photo);
            $v['user_type'] = isset($member['user_type']) ? $member['user_type'] : -1;
            $v['user_id'] = isset($member['user_id']) ? $member['user_id'] : 0;
            // 获取管家的星级,如果不是管家,星级为0
            if ($v['user_type'] == 3){  // 管家
                $user_id = isset($v['user_id']) ? $v['user_id'] : 0;
                $sql_expert = "SELECT grade FROM u_expert WHERE id = $user_id";
                $expert = $this->db->query($sql_expert)->row_array();
                $v['grade'] = isset($expert['grade']) ? $expert['grade'] : 0;
            }else{
                $v['grade'] = 0;
            }
            // 判断是否是自己的动态
            if ($this->anchor_id == $member_id){
                $v['be_self'] = 1;
            }else{
                $v['be_self'] = 0;
            }
            // 是否已关注发帖人
            $sql_concern = "SELECT id FROM social_concern WHERE type = 4 AND member_id = {$this->anchor_id} AND category_id = $member_id";
            if ($this->social_db->query($sql_concern)->num_rows() > 0){
                $v['is_concerned'] = 1;
            }else{
                $v['is_concerned'] = 0;
            }
            $update_time = isset($v['update_time']) ? $v['update_time'] : 0;
            $v['update_time'] = date('Y-m-d', $update_time);
            $v['type'] = isset($v['type']) ? $v['type'] : 0;
            if (1 == $v['type']) {   // 主题
                // 根据主题id获取主题名称
                $theme_id = isset($v['theme_id']) ? $v['theme_id'] : 0;
                $sql_theme = "SELECT name FROM social_theme WHERE id = {$theme_id}";
                $theme = $this->social_db->query($sql_theme)->row_array();
                if ($theme) {
                    $v['theme_name'] = isset($theme['name']) ? $theme['name'] : '';
                } else {
                    $v['theme_name'] = '';
                }
                // 根据帖子id获取帖子标题和正文
                $post_id = isset($v['post_id']) ? $v['post_id'] : 0;
                $sql_post = "SELECT title, content, video_pic, pic1, pic2, pic3 FROM social_theme_post WHERE id = {$post_id}";
                $post = $this->social_db->query($sql_post)->row_array();
                if ($post) {
                    $v['theme_title'] = isset($post['title']) ? $post['title'] : '';
                    $v['theme_content'] = isset($post['content']) ? $post['content'] : '';
                    // 判断帖子的图片类型,0表示既没有视频,也没有图片;1表示帖子有图片;2表示帖子有视频
                    $video_pic = isset($post['video_pic']) ? $post['video_pic'] : '';
                    $pic1 = isset($post['pic1']) ? $post['pic1'] : '';
                    $pic2 = isset($post['pic2']) ? $post['pic2'] : '';
                    $pic3 = isset($post['pic3']) ? $post['pic3'] : '';
                    if (!empty($pic1) OR !empty($pic2) OR !empty($pic3)) {
                        $v['pic_type'] = 1;     // 图片
                    } else if (!empty($video_pic)) {
                        $v['pic_type'] = 2;     // 视频
                    } else if (empty($video_pic) && empty($pic1) && empty ($pic2) && empty ($pic3)) {
                        $v['pic_type'] = 0;     // 既没有视频,也没有图片
                    }
                    // 当天是否对帖子点过赞
                    $member_id_1 = empty($this->anchor_id) ? 0 : $this->anchor_id;
                    $post_id_1 = $post_id;
                    $sql_praised_post = "SELECT update_time FROM social_praise WHERE category_id = {$post_id_1} AND type = 1 AND member_id = {$member_id_1} ORDER BY update_time DESC LIMIT 1";
                    $query_praised_post = $this->social_db->query($sql_praised_post);
                    if ($query_praised_post->num_rows() < 1) {
                        $v['praised_today'] = 0;
                    } else {
                        // 点赞
                        $ret_dz = $query_praised_post->row_array();
                        $update_time = isset($ret_dz['update_time']) ? $ret_dz['update_time'] : 0;
                        if (date('Y-m-d', time()) == date('Y-m-d', $update_time)) {
                            $v['praised_today'] = 1;
                        } else {
                            $v['praised_today'] = 0;
                        }
                    }
                } else {
                    $v['theme_title'] = '';
                    $v['theme_content'] = '';
                    $v['pic_type'] = 0;
                    $v['praised_today'] = 0;
                }
                // 获取回帖数
                $sql_answer = "SELECT id FROM social_theme_post_answer WHERE post_id = {$post_id} ";
                $answer = $this->social_db->query($sql_answer);
                $v['answer_cnt'] = $answer->num_rows();
            } else if (2 == $v['type']) { // 提问
                // 根据话题id获取话题名称
                $theme_id = isset($v['theme_id']) ? $v['theme_id'] : 0;
                $sql_topic = "SELECT name FROM social_topic WHERE id = {$theme_id}";
                $topic = $this->social_db->query($sql_topic)->row_array();
                if ($topic) {
                    $v['topic_name'] = isset($topic['name']) ? $topic['name'] : '';
                } else {
                    $v['topic_name'] = '';
                }
                // 根据问题id获取问题的标题和正文
                $post_id = isset($v['post_id']) ? $v['post_id'] : 0;
                $sql_question = "SELECT id, topic_id, title, pic1, pic2, pic3, video_pic, content FROM social_topic_question WHERE id = {$post_id}";
                $question = $this->social_db->query($sql_question)->row_array();
                if ($question) {
                    $v['question_title'] = isset($question['title']) ? $question['title'] : '';
                    $v['question_content'] = isset($question['content']) ? $question['content'] : '';
                    // 判断话题的图片类型,0表示既没有视频,也没有图片;1表示帖子有图片;2表示帖子有视频
                    $video_pic = isset($question['video_pic']) ? $question['video_pic'] : '';
                    $pic1 = isset($question['pic1']) ? $question['pic1'] : '';
                    $pic2 = isset($question['pic2']) ? $question['pic2'] : '';
                    $pic3 = isset($question['pic3']) ? $question['pic3'] : '';
                    if (!empty($pic1) OR !empty($pic2) OR !empty($pic3)) {
                        $v['pic_type'] = 1;     // 图片
                    } else if (!empty($video_pic)) {
                        $v['pic_type'] = 2;     // 视频
                    } else if (empty($video_pic) && empty($pic1) && empty ($pic2) && empty ($pic3)) {
                        $v['pic_type'] = 0;     // 既没有视频,也没有图片
                    }
                    // 是否已关注当前问题   1已关注   0未关注
                    $question_id = isset($question['id']) ? $question['id'] : 0;
                    $topic_id = isset($question['topic_id']) ? $question['topic_id'] : 0;
                    $sql_concern_type = "SELECT * FROM social_concern WHERE category_id = {$topic_id} AND content_id = {$question_id} AND member_id = {$this->anchor_id} AND type = 2";
                    $query_type = $this->social_db->query($sql_concern_type);
                    if ($query_type->num_rows() > 0) {
                        $v['concerned_question'] = 1;         // 1表示已关注
                    } else {
                        $v['concerned_question'] = 0;         // 0表示未关注
                    }
                } else {
                    $v['question_title'] = '';
                    $v['question_content'] = '';
                    $v['pic_type'] = 0;
                    $v['concerned_question'] = 0;         // 0表示未关注
                }
                // 获取答问数
                $sql_answer = "SELECT id FROM social_topic_answer WHERE question_id = {$question_id} ";
                $answer = $this->social_db->query($sql_answer);
                $v['answer_cnt'] = $answer->num_rows();
            } else if (3 == $v['type']) {      // 视频
                // 获取大咖视频
                $anchor_id = isset($v['member_id']) ? $v['member_id'] : 0;
                $sql_video_info = "SELECT DISTINCT v.like_num, d.member_id, v.id, v.dest_name, v.video, v.pic video_pic, v.name, v.people watched_count, v.dest_name, v.comment_num, a.photo, a.nickname
                        FROM social_dynamics d JOIN live_anchor a ON d.member_id = a.anchor_id JOIN live_video v ON d.member_id = v.anchor_id WHERE d.member_id = {$anchor_id}";
                $video_info = $this->social_db->query($sql_video_info)->result_array();
                if (empty($video_info)){
                    $this->__nullmsg();
                }
                foreach ($video_info as &$val){
                    // 对图片进行处理
                    $val['photo'] = isset($val['photo']) ? $val['photo'] : '';
                    $arr_photo = explode(',', $val['photo']);
                    $v['photo'] = $this->__doImage($arr_photo);
                    $val['video_pic'] = isset($val['video_pic']) ? $val['video_pic'] : '';
                    $arr_pic = explode(',', $val['video_pic']);
                    $v['video_pic'] = $this->__doImage($arr_pic);
                    // 视频名称
                    $v['video_name'] = isset($val['name']) ? $val['name'] : '';
                    // 视频地址
                    $v['video_url'] = isset($val['video']) ? $val['video'] : '';
                    // 观看数
                    $v['watched_count'] = isset($val['watched_count']) ? $val['watched_count'] : 0;
                    // 评论数
                    $v['comment_num'] = isset($val['comment_num']) ? $val['comment_num'] : 0;
                    // 地点
                    $v['dest_name'] = isset($val['dest_name']) ? $val['dest_name'] : '';
                    // 视频id
                    $v['video_id'] = isset($val['id']) ? $val['id'] : 0;
                     // 视频点赞数
                    $v['like_num'] = isset($val['like_num']) ? $val['like_num'] : 0;
                }
            }
        }
        $this->__outmsg($ret);
    }

    /**
     * @method  get_more_daka
     * @desc    更多大咖
     * @param   type        大咖类型    1达人   2领队    3管家
     * @param   page        第几页
     * @param   page_size   每页多少条
     */
    public function get_more_daka() {
        $type = $this->input->post('type', TRUE);
        if (1 != $type && 2 != $type && 3 != $type) {
            $this->__errormsg('invalid type');
        }
        $page = $this->input->post('page', TRUE);
        $page_size = $this->input->post('page_size', TRUE);
        $page = $page ? (int) $page : 1;
        $page_size = $page_size ? (int) $page_size : 15;
        $from = ($page - 1) * $page_size;
        $sql = "SELECT anchor_id, user_id, nickname, photo, type FROM live_anchor WHERE status = 2 AND type = {$type} ORDER BY applytime LIMIT {$from}, {$page_size}";
        $ret = $this->social_db->query($sql)->result_array();
        if ($ret) {
            foreach ($ret as &$v) {
                // 处理photo
                $arr_photo = explode(',', isset($v['photo']) ? $v['photo'] : '');
                $v['photo'] = $this->__doImage($arr_photo);
            }
        }
        $this->__outmsg($ret);
    }

    /**
     * @method  get_daka_description_by_id
     * @desc    获取大咖描述
     * @param   id   大咖id   live_anchor表中的anchor_id
     */
    public function get_daka_description_by_id() {
        $id = $this->input->get_post('id', TRUE);
        if (empty($id)) {
            $this->__errormsg('大咖id不能为空');
        }
        // 根据主播表id获取用户id
        $sql_user = "SELECT user_id FROM live_anchor WHERE anchor_id = {$id}";
        $user = $this->social_db->query($sql_user)->row_array();
        if (!$user) {
            $this->__errormsg('获取用户id失败');
        }
        // 根据用户id获取用户相关信息
        $user_id = isset($user['user_id']) ? $user['user_id'] : 0;
        $sql_daka = "SELECT mid, nickname, sex, litpic, travel_pic, talk FROM u_member WHERE mid = {$user_id}";
        $daka = $this->db->query($sql_daka)->row_array();
        if (empty($daka)) {
            $this->__errormsg('用户信息为空');
        }
        // 判断是否已关注此大咖
        if ($this->anchor_id) {
            $sql_concern = "SELECT id FROM social_concern WHERE member_id = {$this->anchor_id} AND category_id = {$id} AND type = 4";
            $query = $this->social_db->query($sql_concern);
            if ($query->num_rows() > 0) {
                $daka['concerned'] = 1;
            } else {
                $daka['concerned'] = 0;
            }
        } else {
            $daka['concerned'] = 0;
        }
        // 判断当前大咖是否是自己
        if ($this->anchor_id == $id) {
            $daka['isself'] = 1;
        } else {
            $daka['isself'] = 0;
        }
        // 根据anchor_id获取用户id
        $sql_member = "SELECT user_id, nickname, photo FROM live_anchor WHERE anchor_id = $id";
        $member = $this->social_db->query($sql_member)->row_array();
        if ($member) {
            $member_id = isset($member['user_id']) ? $member['user_id'] : 0;
            if (0 == $member_id) {
                $this->__errormsg('数据异常');
            }
            // 星座
            $sql_constellation = "SELECT description constellation FROM u_dictionary d JOIN u_member_attr m ON d.dict_id = m.constellation WHERE m.member_id = {$member_id}";
            $constellation = $this->db->query($sql_constellation)->row_array();
            $daka['constellation'] = isset($constellation['constellation']) ? $constellation['constellation'] : '';
            // 年代
            $sql_years = "SELECT description years FROM u_dictionary d JOIN u_member_attr m ON d.dict_id = m.years WHERE m.member_id = {$member_id}";
            $years = $this->db->query($sql_years)->row_array();
            $daka['years'] = isset($years['years']) ? $years['years'] : '';
            // 血型
            $sql_blood = "SELECT description blood FROM u_dictionary d JOIN u_member_attr m ON d.dict_id = m.blood WHERE m.member_id = {$member_id}";
            $blood = $this->db->query($sql_blood)->row_array();
            $daka['blood'] = isset($blood['blood']) ? $blood['blood'] : '';
            // 国家  
            $sql_country = "SELECT name country FROM u_area a JOIN u_member_attr m ON a.id = m.country WHERE m.member_id = {$member_id}";
            $member = $this->db->query($sql_country)->row_array();
            $daka['country'] = isset($member['country']) ? $member['country'] : '';
            // 省
            $sql_province = "SELECT name province FROM u_area a JOIN u_member_attr m ON a.id = m.province WHERE m.member_id = {$member_id}";
            $province = $this->db->query($sql_province)->row_array();
            $daka['province'] = isset($province['province']) ? $province['province'] : '';
            // 市
            $sql_city = "SELECT name city FROM u_area a JOIN u_member_attr m ON a.id = m.city WHERE m.member_id = {$member_id}";
            $city = $this->db->query($sql_city)->row_array();
            $daka['city'] = isset($city['city']) ? $city['city'] : '';
            // 爱好,美食,到过的地方
            $sql_hfd = "SELECT hobby1 hobby, food1 food, dest1 dest FROM u_member_attr WHERE member_id = {$member_id}";
            $hfd = $this->db->query($sql_hfd)->row_array();
            $daka['hobby'] = isset($hfd['hobby']) ? explode('/', $hfd['hobby']) : '';
            $daka['food'] = isset($hfd['food']) ? explode('/', $hfd['food']) : '';
            $daka['dest'] = isset($hfd['dest']) ? explode('/', $hfd['dest']) : '';
            // 性格类型
            $sql_characters = "SELECT GROUP_CONCAT(ud.description SEPARATOR '/') AS characters FROM u_dictionary AS ud RIGHT JOIN u_member_character AS umc ON FIND_IN_SET(ud.dict_id, umc.characters) WHERE umc.member_id = {$member_id}";
            $character = $this->db->query($sql_characters)->row_array();
            $arr_character = explode('/', isset($character['characters'])? $character['characters'] : '');
            $daka['characters'] = $arr_character;
            // 喜欢去哪玩(境内)
            $sql_prefer_domestic = "SELECT GROUP_CONCAT(ud.description SEPARATOR '/') AS prefer_domestic FROM u_dictionary AS ud LEFT JOIN u_member_play_domestic AS umpd ON FIND_IN_SET(ud.dict_id, umpd.dest_id)  WHERE umpd.member_id = {$member_id}";
            $prefer_domestic = $this->db->query($sql_prefer_domestic)->row_array();
            $arr_prefer_domestic = explode('/', isset($prefer_domestic['prefer_domestic']) ? $prefer_domestic['prefer_domestic'] : '');
            $daka['prefer_domestic'] = $arr_prefer_domestic;
            // 喜欢去哪玩(境外)
            $sql_prefer_abroad = "SELECT GROUP_CONCAT(ud.description SEPARATOR '/') AS prefer_abroad FROM u_dictionary AS ud LEFT JOIN u_member_play_abroad AS umpa ON FIND_IN_SET(ud.dict_id, umpa.dest_id) WHERE umpa.member_id = {$member_id}";
            $prefer_abroad = $this->db->query($sql_prefer_abroad)->row_array();
            $arr_prefer_abroad = explode('/', isset($prefer_abroad['prefer_abroad']) ? $prefer_abroad['prefer_abroad'] : '');
            $daka['prefer_abroad'] = $arr_prefer_abroad;
            // 喜欢怎么玩
            $sql_prefer_how_play = "SELECT GROUP_CONCAT(ud.description SEPARATOR '/') AS prefer_how_play FROM u_dictionary AS ud LEFT JOIN u_member_play_how AS umph ON FIND_IN_SET(ud.dict_id, umph.way_id) WHERE umph.member_id = {$member_id}";
            $prefer_how_play = $this->db->query($sql_prefer_how_play)->row_array();
            $arr_prefer_how_play = explode('/', isset($prefer_how_play['prefer_how_play']) ? $prefer_how_play['prefer_how_play'] : '');
            $daka['prefer_how_play'] = $arr_prefer_how_play;
            // 喜欢跟谁玩
            $sql_prefer_whom_prefer_play_with = "SELECT GROUP_CONCAT(ud.description SEPARATOR '/') AS whom_play_with FROM u_dictionary AS ud LEFT JOIN u_member_play_with AS umpw ON FIND_IN_SET(ud.dict_id, umpw.with_id) WHERE umpw.member_id = {$member_id}";
            $whom_play_with = $this->db->query($sql_prefer_whom_prefer_play_with)->row_array();
            $arr_whom_play_with = explode('/', isset($whom_play_with['whom_play_with']) ? $whom_play_with['whom_play_with'] : '');
            $daka['whom_play_with'] = $arr_whom_play_with;
            // 平日休闲方式
            $sql_relax = "SELECT GROUP_CONCAT(ud.description SEPARATOR '/') AS relax FROM u_dictionary AS ud LEFT JOIN u_member_relax AS umr ON FIND_IN_SET(ud.dict_id, umr.relax_id) WHERE umr.member_id = {$member_id}";
            $relax = $this->db->query($sql_relax)->row_array();
            $arr_relax = explode('/', isset($relax['relax']) ? $relax['relax']: '');
            $daka['relax'] = $arr_relax;
        }
        // 分享
        $daka['share_url'] = $this->share_url . 'dongtai_share/?daka_id=' . $user_id;
        $daka['share_name'] = '我分享了一个旅游达人'.(isset($daka['nickname']) ? $daka['nickname'] : '');
        // 获取当前用户的头像
        $sql_member_1 = "SELECT photo FROM live_anchor WHERE anchor_id = {$this->anchor_id}";
        $member_1 = $this->social_db->query($sql_member_1)->row_array();
        $photo = isset($member_1['photo']) ? $member_1['photo'] : '';
        $daka['share_pic'] = $this->__doImage(explode(',', $photo));
        $content = isset($daka['talk']) ? $daka['talk'] : '暂无简介';
        $description = mb_substr($content, 0, 20, 'utf-8');
        $daka['share_content'] = $description;
        
        $this->__outmsg($daka);
    }

    /**
     * @method get_dynamics_of_someone
     * @desc  获取达人,领队的动态
     * @param   id  大咖id
     * @param   page 第几页
     * @param   page_size 每页条数
     */
    public function get_dynamics_of_someone() {
        $id = $this->input->post("id", TRUE);
        if (empty($id)) {
            $this->__errormsg('大咖id不能为空');
        }
        // 判断用户是否是达人或领队
        $sql_type = "SELECT type FROM live_anchor WHERE anchor_id = {$id}";
        $type = $this->social_db->query($sql_type)->row_array();
        if ($type) {
            $type = isset($type['type']) ? $type['type'] : -1;
            if (1 != $type && 2 != $type) {
                $this->__errormsg('既不是领队,也不是管家');
            }
        } else {
            $this->__errormsg('invalid id');
        }
        $page = $this->input->post('page', TRUE);
        $page = $page ? (int) $page : 1;
        $page_size = $this->input->post('page_size', TRUE);
        $page_size = $page_size ? (int) $page_size : 5;
        $from = ($page - 1) * $page_size;
        $sql_dynamics = "SELECT id, type, theme_id, '' pics, pic1, pic2, pic3, member_id, praise_count, watched_count, involve_count, concern_count, post_id, update_time FROM social_dynamics WHERE member_id = {$id} ORDER BY update_time DESC LIMIT {$from}, {$page_size}";
        $ret = $this->social_db->query($sql_dynamics)->result_array();
        if (empty($ret)){
            $this->__nullmsg();
        }
        foreach ($ret as &$v) {
            $pic1 = isset($v['pic1']) ? $v['pic1'] : '';
            $pic2 = isset($v['pic2']) ? $v['pic2'] : '';
            $pic3 = isset($v['pic3']) ? $v['pic3'] : '';
            $pics = '';
            if (empty($pic2)){
                $pics = $pic1 . ',' . $pic3;
            }else{
                $pics = $pic1 . ',' . $pic2 . ',' . $pic3;
            }
            $v['pics'] = trim(trim($pics), ',');
            $arr_pics = explode(',', $v['pics']);
            $v['pics'] = $this->__doImage($arr_pics);
            // 根据member_id获取用户昵称和头像
            $member_id = isset($v['member_id']) ? $v['member_id'] : 0;
            $sql_member = "SELECT nickname, photo, user_id, type user_type FROM live_anchor WHERE anchor_id = {$member_id}";
            $member = $this->social_db->query($sql_member)->row_array();
            $v['nickname'] = isset($member['nickname']) ? $member['nickname'] : '';
            $v['photo'] = isset($member['photo']) ? $member['photo'] : '';
            $arr_photo = explode(',', $v['photo']);
            $v['photo'] = $this->__doImage($arr_photo);
            $v['user_type'] = isset($member['user_type']) ? $member['user_type'] : -1;
            $v['user_id'] = isset($member['user_id']) ? $member['user_id'] : 0;
            $v['update_time'] = isset($v['update_time']) ? $v['update_time'] : 0;
            $v['update_time'] = date('Y-m-d', $v['update_time']);
            $v['type'] = isset($v['type']) ? $v['type'] : 0;
            $post_id = isset($v['post_id']) ? $v['post_id'] : 0;
            $theme_id = isset($v['theme_id']) ? $v['theme_id'] : 0;     // 主题id或话题id
            if (1 == $v['type']) {   // 主题
                // 根据主题id获取主题名称
                $sql_theme = "SELECT name FROM social_theme WHERE id = {$theme_id}";
                $theme = $this->social_db->query($sql_theme)->row_array();
                if ($theme) {
                    $v['theme_name'] = isset($theme['name']) ? $theme['name'] : '';
                } else {
                    $v['theme_name'] = '';
                }
                // 根据帖子id获取帖子标题和正文
                $sql_post = "SELECT title, content, video_pic, pic1, pic2, pic3 FROM social_theme_post WHERE id = {$post_id}";
                $post = $this->social_db->query($sql_post)->row_array();
                if ($post) {
                    $v['theme_title'] = isset($post['title']) ? $post['title'] : '';
                    $v['theme_content'] = isset($post['content']) ? $post['content'] : '';
                    // 判断帖子的图片类型,0表示既没有视频,也没有图片;1表示帖子有图片;2表示帖子有视频
                    $pic1 = isset($post['pic1']) ? $post['pic1'] : '';
                    $pic2 = isset($post['pic2']) ? $post['pic2'] : '';
                    $pic3 = isset($post['pic3']) ? $post['pic3'] : '';
                    $video_pic = isset($post['video_pic']) ? $post['video_pic'] : '';
                    $v['pic_type'] = -1;
                    if (!empty($pic1) OR !empty($pic2) OR !empty($pic3)) {
                        $v['pic_type'] = 1;
                    } else if (!empty($video_pic)) {
                        $v['pic_type'] = 2;
                    } else if (empty($pic1) && empty($pic2) && empty($pic3) && empty($video_pic)) {
                        $v['pic_type'] = 0;
                    }
                    // 获取回帖数
                    $sql_answer = "SELECT id FROM social_theme_post_answer WHERE post_id = {$post_id} ";
                    $answer = $this->social_db->query($sql_answer);
                    $v['answer_cnt'] = $answer->num_rows();
                } else {
                    $v['theme_title'] = '';
                    $v['theme_content'] = '';
                    $v['pic_type'] = 0;
                }
            } else if (2 == $v['type']) { // 提问
                // 根据话题id获取话题名称
                $sql_topic = "SELECT name FROM social_topic WHERE id = {$theme_id}";
                $topic = $this->social_db->query($sql_topic)->row_array();
                if ($topic) {
                    $v['topic_name'] = isset($topic['name']) ? $topic['name'] : '';
                } else {
                    $v['topic_name'] = '';
                }
                // 根据问题id获取问题的标题和正文
                $sql_question = "SELECT title, pic1, pic2, pic3, video_pic, content FROM social_topic_question WHERE id = {$post_id}";
                $question = $this->social_db->query($sql_question)->row_array();
                if ($question) {
                    $v['question_title'] = isset($question['title']) ? $question['title'] : '';
                    $v['question_content'] = isset($question['content']) ? $question['content'] : '';
                    // 判断话题的图片类型,0表示既没有视频,也没有图片;1表示帖子有图片;2表示帖子有视频
                    $pic1 = isset($question['pic1']) ? $question['pic1'] : '';
                    $pic2 = isset($question['pic2']) ? $question['pic2'] : '';
                    $pic3 = isset($question['pic3']) ? $question['pic3'] : '';
                    $video_pic = isset($question['video_pic']) ? $question['video_pic'] : '';
                    $v['pic_type'] = -1;
                    if (!empty($pic1) OR !empty($pic2) OR !empty($pic3)) {
                        $v['pic_type'] = 1;
                    } else if (!empty($video_pic)) {
                        $v['pic_type'] = 2;
                    } else if (empty($pic1) && empty($pic2) && empty($pic3) && empty($video_pic)) {
                        $v['pic_type'] = 0;
                    }
                    // 获取答问数
                    $sql_answer = "SELECT id FROM social_topic_answer WHERE question_id = {$post_id} ";
                    $answer = $this->social_db->query($sql_answer);
                    $v['answer_cnt'] = $answer->num_rows();
                } else {
                    $v['question_title'] = '';
                    $v['question_content'] = '';
                    $v['pic_type'] = 0;
                }
            }
        }
        $this->__outmsg($ret);
    }

    /**
     * @method  get_live_of_daren
     * @desc    获取达人的直播
     * @param   id  达人id
     * @param   page    第几页
     * @param   page_size 每页多少条
     * 
     */
    public function get_live_of_daren() {
        $id = $this->input->post('id', TRUE);
        if (empty($id)) {
            $this->__errormsg('param exception');
        }
        $page = $this->input->post('page', TRUE);
        $page = $page ? (int) $page : 1;
        $page_size = $this->input->post('page_size', TRUE);
        $page_size = $page_size ? (int) $page_size : 5;
        $from = ($page - 1) * $page_size;
        $sql_videos = "SELECT id, anchor_id, video, name, pic, people, dest_id FROM live_video WHERE anchor_id = {$id} ORDER BY addtime DESC LIMIT {$from}, {$page_size}";
        $videos = $this->social_db->query($sql_videos)->result_array();
        if ($videos) {
            foreach ($videos as &$v) {
                $arr_pic = explode(',', isset($v['pic']) ? $v['pic'] : '');
                $v['pic'] = $this->__doImage($arr_pic);
                // 根据目的地id获取目的地名称
                $dest_id = isset($v['dest_id']) ? $v['dest_id'] : 0;
                $sql_dest = "SELECT kindname dest_name FROM u_dest_cfg WHERE id = {$dest_id}";
                $dest = $this->db->query($sql_dest)->row_array();
                $v['dest_name'] = isset($dest['dest_name']) ? $dest['dest_name'] : '';
            }
        }
        $this->__outmsg($videos);
    }

    
    /**********************************************关注**********************************************/
    /**
     * @method  get_concern_by_user
     * @desc    获取用户的关注信息
     * @param   page        第几页
     * @param   page_size   每页多少条
     * @param   type        1表示主题,2表示问答,3表示大咖
     */
    public function get_concern_by_user() { 
        if (empty($this->user_id)){
            $this->__nullmsg('没有登录');
        }
        $type = $this->input->post('type');
        if ('1' != $type && '2' != $type && '3' != $type) {
            $this->__errormsg('error type', 4001);
        }
        $page = $this->input->post('page', TRUE);
        $page_size = $this->input->post('page_size', TRUE);
        $page = $page ? (int) $page : 1;
        $page_size = $page_size ? (int) $page_size : 5;
        $from = ($page - 1) * $page_size;
        if ($type == 1) {        // 主题
            // 获取关注的主题
            $sql_theme = "SELECT DISTINCT category_id, update_time FROM social_concern WHERE member_id = {$this->anchor_id} AND type = 1";
            $theme = $this->social_db->query($sql_theme)->result_array();
            if (!$theme) {
                $this->__errormsg('信息为空', 4001);
            }
            $where = '';
            foreach ($theme as $val){
                $where .= " OR (theme_id = {" . isset($val['category_id']) ? $val['category_id'] : 0 . "} AND update_time >= {" . isset($val['update_time']) ? $val['update_time'] : 0 . "}) ";
            }
            $where = 'WHERE ' . trim(trim($where), 'OR');
            $where_limit = $where." ORDER BY update_time DESC LIMIT {$from}, {$page_size}";
            $sql_post_where_limit = "SELECT id, title, content, video_pic, video_url, pic1, pic2, pic3, member_id, theme_id, praise_count, watched_count, update_time, line_id FROM social_theme_post " . $where_limit;
            $post = $this->social_db->query($sql_post_where_limit)->result_array();
            if ($post) {
                foreach ($post as &$v) {
                    // 图片处理
                    $video_pic = $v['video_pic'];   // 用来判断图片类型
                    $arr_v_pic = explode(',', isset($v['video_pic']) ? $v['video_pic'] : '');
                    $v['video_pic'] = $this->__doImage($arr_v_pic);
                    $arr_v_url = explode(',', isset($v['video_url']) ? $v['video_url'] : '');
                    $v['video_url'] = $this->__doImage($arr_v_url);
                    $pic1 = isset($v['pic1']) ? $v['pic1'] : '';
                    $pic2 = isset($v['pic2']) ? $v['pic2'] : '';
                    $pic3 = isset($v['pic3']) ? $v['pic3'] : '';
                    $v['pics'] = '';
                    if (empty($pic2) && !empty($pic1) && !empty($pic3)){
                        $v['pics'] = $pic1 . ',' . $pic3;
                    }else if(!empty($pic2) && !empty($pic1) && !empty($pic3)){
                        $v['pics'] = $pic1 . ',' . $pic2 . ',' . $pic3;
                    }else if (!empty($pic2) && !empty($pic1) && empty($pic3)){
                        $v['pics'] = $pic1 . ',' . $pic2;
                    }else if (!empty($pic2) && !empty($pic1) && empty($pic3)){
                        $v['pics'] = $pic2 . ',' . $pic3;
                    }else{
                        $v['pics'] = $pic1 . ',' . $pic2 . ',' . $pic3;
                    }
                    $v['pics'] = trim(trim($v['pics']), ',');
                    $arr_pics = explode(',', isset($v['pics']) ? $v['pics'] : '');
                    $v['pics'] = $this->__doImage($arr_pics);
                    
                    // 判断帖子的图片类型,0表示既没有视频,也没有图片;1表示帖子有图片;2表示帖子有视频
                    if (!empty($pic1) OR !empty($pic2) OR !empty($pic3)) {
                        $v['pic_type'] = 1;
                    } else if (!empty($video_pic)) {
                        $v['pic_type'] = 2;
                    } else if ((empty($pic1) && empty($pic2) && empty($pic3)) && empty($video_pic)) {
                        $v['pic_type'] = 0;
                    }
                    
                    // 时间处理
                    $v['update_time'] = date('Y-m-d', isset($v['update_time']) ? $v['update_time'] : 0);
                    // 获取发帖人头像,昵称,user_id,type
                    $member_id = isset($v['member_id']) ? $v['member_id'] : 0;
                    $sql_post_man = "SELECT photo, nickname, user_id, type FROM live_anchor WHERE anchor_id = {$member_id}";
                    $post_man = $this->social_db->query($sql_post_man)->row_array();
                    $v['photo'] = isset($post_man['photo']) ? $post_man['photo'] : '';
                    $arr_p = explode(',', $v['photo']);
                    $v['photo'] = $this->__doImage($arr_p);
                    $v['nickname'] = isset($post_man['nickname']) ? $post_man['nickname'] : '';
                    $v['user_id'] = isset($post_man['user_id']) ? $post_man['user_id'] : 0;
                    $v['user_type'] = isset($post_man['type']) ? $post_man['type'] : -1;
                    // 获取帖子来自主题的名称
                    $theme_id = isset($v['theme_id']) ? $v['theme_id'] : 0;
                    $sql_theme = "SELECT name FROM social_theme WHERE id = {$theme_id}";
                    $theme = $this->social_db->query($sql_theme)->row_array();
                    $v['theme_name'] = isset($theme['name']) ? $theme['name'] : '';
                    // 获取回帖数
                    $post_id = isset($v['id']) ? $v['id'] : 0;
                    $sql_answer = "SELECT id FROM social_theme_post_answer WHERE post_id = {$post_id} ";
                    $answer = $this->social_db->query($sql_answer);
                    $v['answer_cnt'] = $answer->num_rows();
                    // 设置内容类型
                    $v['content_type'] = 1;     // 为1表示帖子
                    
                    // 当天是否对帖子点过赞
                    $member_id_1 = empty($this->anchor_id) ? 0 : $this->anchor_id;
                    $post_id_1 = isset($v['id']) ? $v['id'] : 0;
                    $sql_praised_post = "SELECT update_time FROM social_praise WHERE category_id = {$post_id_1} AND type = 1 AND member_id = {$member_id_1} ORDER BY update_time DESC LIMIT 1";
                    $query_praised_post = $this->social_db->query($sql_praised_post);
                    if ($query_praised_post->num_rows() < 1) {
                        $v['praised_today'] = 0;
                    } else {
                        $ret_dz = $query_praised_post->row_array();
                        $update_time = isset($ret_dz['update_time']) ? $ret_dz['update_time'] : 0;
                        if (date('Y-m-d', time()) == date('Y-m-d', $update_time)) {
                            $v['praised_today'] = 1;
                        } else {
                            $v['praised_today'] = 0;
                        }
                    }
                    $ret['post'][] = $v;
                }
            }
            $sql_post = "SELECT id, title, content, video_pic, video_url, pic1 pics, member_id, theme_id, praise_count, watched_count, update_time, line_id FROM social_theme_post ".$where;
            $cnt = $this->social_db->query($sql_post)->num_rows();
            if (0 == $cnt){
                $this->__nullmsg();
            }
            $ret['cnt'] = $cnt;
        } else if ($type == 2) {   // 问答
            // 获取关注的话题
            $sql_topic = "SELECT DISTINCT category_id, update_time FROM social_concern WHERE member_id = {$this->anchor_id} AND type = {$type}";
            $topic = $this->social_db->query($sql_topic)->result_array();
            if (!$topic) {
                $this->__errormsg('信息为空', 4001);
            }
            $where = '';
            foreach ($topic as $val){
                $where .= " OR (topic_id = {" . isset($val['category_id']) ? $val['category_id'] : 0 . "} AND update_time >= {" . isset($val['update_time']) ? $val['update_time'] : 0 . "}) ";
            }
            $where = 'WHERE ' . trim(trim($where), 'OR');
            $where_limit = $where . " ORDER BY update_time DESC LIMIT {$from}, {$page_size}";
            $sql_question_where_limit = "SELECT id, topic_id, member_id, title, content, update_time, involve_count, concern_count, pic1 pics, line_id, invited_id, video_pic, video_url FROM social_topic_question " . $where_limit;
            $question = $this->social_db->query($sql_question_where_limit)->result_array();
            if ($question) {
                foreach ($question as &$v) {
                    $video_pic = isset($v['video_pic']) ? $v['video_pic'] : '';   // 用来判断图片类型
                    $arr_v_pic = explode(',', isset($v['video_pic']) ? $v['video_pic'] : '');
                    $v['video_pic'] = $this->__doImage($arr_v_pic);
                    $arr_v_url = explode(',', isset($v['video_url']) ? $v['video_url'] : '');
                    $v['video_url'] = $this->__doImage($arr_v_url);
                    $pic1 = isset($v['pic1']) ? $v['pic1'] : '';
                    $pic2 = isset($v['pic2']) ? $v['pic2'] : '';
                    $pic3 = isset($v['pic3']) ? $v['pic3'] : '';
                    $v['pics'] = '';
                    if (empty($pic2) && !empty($pic1) && !empty($pic3)){
                        $v['pics'] = $pic1 . ',' . $pic3;
                    }else if(!empty($pic2) && !empty($pic1) && !empty($pic3)){
                        $v['pics'] = $pic1 . ',' . $pic2 . ',' . $pic3;
                    }else if (!empty($pic2) && !empty($pic1) && empty($pic3)){
                        $v['pics'] = $pic1 . ',' . $pic2;
                    }else if (!empty($pic2) && !empty($pic1) && empty($pic3)){
                        $v['pics'] = $pic2 . ',' . $pic3;
                    }else{
                        $v['pics'] = $pic1 . ',' . $pic2 . ',' . $pic3;
                    }
                    $v['pics'] = trim(trim($v['pics']), ',');
                    $arr_pics = explode(',', isset($v['pics']) ? $v['pics'] : '');
                    $v['pics'] = $this->__doImage($arr_pics);
                    // 判断帖子的图片类型,0表示既没有视频,也没有图片;1表示帖子有图片;2表示帖子有视频
                    if (!empty($pic1) OR !empty($pic2) OR !empty($pic3)) {
                        $v['pic_type'] = 1;
                    } else if (!empty($video_pic)) {
                        $v['pic_type'] = 2;
                    } else if ((empty($pic1) && empty($pic2) && empty($pic3)) && empty($video_pic)) {
                        $v['pic_type'] = 0;
                    }
                    // 时间处理
                    $v['update_time'] = date('Y-m-d', isset($v['update_time']) ? $v['update_time'] : 0);
                    // 获取发帖人头像,昵称,type,user_id
                    $member_id = isset($v['member_id']) ? $v['member_id'] : 0;
                    $sql_post_man = "SELECT photo, nickname, type, user_id FROM live_anchor WHERE anchor_id = {$member_id}";   // 加入type, user_id
                    $post_man = $this->social_db->query($sql_post_man)->row_array();
                    $v['photo'] = isset($post_man['photo']) ? $post_man['photo'] : '';
                    $arr_p = explode(',', $v['photo']);
                    $v['photo'] = $this->__doImage($arr_p);
                    $v['nickname'] = isset($post_man['nickname']) ? $post_man['nickname'] : '';
                    $v['user_type'] = isset($post_man['type']) ? $post_man['type'] : -1;
                    $v['user_id'] = isset($post_man['user_id']) ? $post_man['user_id'] : 0;
                    // 获取问题来自话题的名称
                    $topic_id = isset($v['topic_id']) ? $v['topic_id'] : 0;
                    $sql_topic = "SELECT name FROM social_topic WHERE id = {$topic_id}";
                    $topic = $this->social_db->query($sql_topic)->row_array();
                    $v['topic_name'] = isset($topic['name']) ? $topic['name'] : '';

                    // 获取回帖数
                    $question_id = isset($v['id']) ? $v['id'] : 0;
                    $sql_answer = "SELECT id FROM social_topic_answer WHERE question_id = {$question_id}";
                    $answer = $this->social_db->query($sql_answer);
                    $v['answer_cnt'] = $answer->num_rows();
                    // 设置内容类型
                    $v['content_type'] = 2;     // 为2表示问题
                    
                    // 当天是否对帖子点过赞
                    $member_id_1 = empty($this->anchor_id) ? 0 : $this->anchor_id;
                    $post_id_1 = isset($v['id']) ? $v['id'] : 0;
                    $sql_praised_post = "SELECT update_time FROM social_praise WHERE category_id = {$post_id_1} AND type = 1 AND member_id = {$member_id_1} ORDER BY update_time DESC LIMIT 1";
                    $query_praised_post = $this->social_db->query($sql_praised_post);
                    if ($query_praised_post->num_rows() < 1) {
                        $v['praised_today'] = 0;
                    } else {
                        $ret_dz = $query_praised_post->row_array();
                        $update_time = isset($ret_dz['update_time']) ? $ret_dz['update_time'] : 0;
                        if (date('Y-m-d', time()) == date('Y-m-d', $update_time)) {
                            $v['praised_today'] = 1;
                        } else {
                            $v['praised_today'] = 0;
                        }
                    }
                    // 关注类型 1表示关注话题,2表示关注问题
                    $sql_concern_type = "SELECT * FROM social_concern WHERE category_id = {$topic_id} AND content_id = {$question_id} AND member_id = {$this->anchor_id} AND type = 2";
                    $query_type = $this->social_db->query($sql_concern_type);
                    if ($query_type->num_rows() > 0){
                        $v['concern_type'] = 2;         // 2表示关注的问题
                    }else{
                        $v['concern_type'] = 1;         // 1表示关注的话题
                    }
                    $ret['topic'][] = $v;
                }
            }
            $sql_question = "SELECT id FROM social_topic_question ".$where;
            $cnt = $this->social_db->query($sql_question)->num_rows();
            if ($cnt == 0){
                $this->__nullmsg();
            }
            $ret['cnt'] = $cnt;
        } else if ($type == 3) {   // 大咖
            // 获取关注的大咖
            $sql_daka = "SELECT category_id, update_time FROM social_concern WHERE type = 4 AND member_id = {$this->anchor_id} ";      // type为4表示关注人
            $daka = $this->social_db->query($sql_daka)->result_array();
            if (!$daka) {
                $this->__errormsg('信息为空', 4001);
            }
            $where = '';
            foreach ($daka as $val){
                $where .= " OR (member_id = {" . isset($val['category_id']) ? $val['category_id'] : 0 . "} AND update_time >= {" . isset($val['update_time']) ? $val['update_time'] : 0 . "}) ";
            }
            $where = 'WHERE ' . trim(trim($where), 'OR');
            $where_limit = $where . " ORDER BY update_time DESC LIMIT {$from}, {$page_size}";
            // 被关注大咖的发帖
            $sql_all = "SELECT * FROM
            (SELECT id, title, content, video_pic, video_url, pic1, pic2, pic3, member_id, line_id, theme_id,  0 topic_id, update_time, 0 involve_count, praise_count, watched_count, 0 concern_count, 0 invited_id FROM social_theme_post
            UNION
            SELECT id, title, content, video_pic, video_url, pic1, pic2, pic3, member_id, line_id, 0 theme_id, topic_id, update_time, involve_count, 0 praise_count, 0 watched_count, concern_count, invited_id FROM social_topic_question
            ) t ".$where_limit;
        $post = $this->social_db->query($sql_all)->result_array();
        if ($post) {
                foreach ($post as &$v) {
                    // 图片处理
                    $video_pic = $v['video_pic'];   // 用来判断图片类型
                    $arr_v_pic = explode(',', isset($v['video_pic']) ? $v['video_pic'] : '');
                    $v['video_pic'] = $this->__doImage($arr_v_pic);
                    $arr_v_url = explode(',', isset($v['video_url']) ? $v['video_url'] : '');
                    $v['video_url'] = $this->__doImage($arr_v_url);
                    $pic1 = isset($v['pic1']) ? $v['pic1'] : '';
                    $pic2 = isset($v['pic2']) ? $v['pic2'] : '';
                    $pic3 = isset($v['pic3']) ? $v['pic3'] : '';
                    $v['pics'] = '';
                    if (empty($pic2) && !empty($pic1) && !empty($pic3)) {
                        $v['pics'] = $pic1 . ',' . $pic3;
                    } else if (!empty($pic2) && !empty($pic1) && !empty($pic3)) {
                        $v['pics'] = $pic1 . ',' . $pic2 . ',' . $pic3;
                    } else if (!empty($pic2) && !empty($pic1) && empty($pic3)) {
                        $v['pics'] = $pic1 . ',' . $pic2;
                    } else if (!empty($pic2) && !empty($pic1) && empty($pic3)) {
                        $v['pics'] = $pic2 . ',' . $pic3;
                    } else {
                        $v['pics'] = $pic1 . ',' . $pic2 . ',' . $pic3;
                    }
                    $v['pics'] = trim(trim($v['pics']), ',');
                    $arr_pics = explode(',', isset($v['pics']) ? $v['pics'] : '');
                    $v['pics'] = $this->__doImage($arr_pics);
                    // 判断帖子的图片类型,0表示既没有视频,也没有图片;1表示帖子有图片;2表示帖子有视频
                    if (!empty($pic1) OR ! empty($pic2) OR ! empty($pic3)) {
                        $v['pic_type'] = 1;
                    } else if (!empty($video_pic)) {
                        $v['pic_type'] = 2;
                    } else if ((empty($pic1) && empty($pic2) && empty($pic3)) && empty($video_pic)) {
                        $v['pic_type'] = 0;
                    }
                    // 时间处理
                    $v['update_time'] = date('Y-m-d', isset($v['update_time']) ? $v['update_time'] : 0);
                    // 获取发帖人头像,昵称,user_id,type
                    $member_id = isset($v['member_id']) ? $v['member_id'] : 0;
                    $sql_post_man = "SELECT photo, nickname, user_id, type FROM live_anchor WHERE anchor_id = {$member_id}";
                    $post_man = $this->social_db->query($sql_post_man)->row_array();
                    $v['photo'] = isset($post_man['photo']) ? $post_man['photo'] : '';
                    $arr_p = explode(',', $v['photo']);
                    $v['photo'] = $this->__doImage($arr_p);
                    $v['nickname'] = isset($post_man['nickname']) ? $post_man['nickname'] : '';
                    $v['user_id'] = isset($post_man['user_id']) ? $post_man['user_id'] : 0;
                    $v['user_type'] = isset($post_man['type']) ? $post_man['type'] : -1;
                    // 获取帖子来自主题或话题的名称
                    $theme_id = isset($v['theme_id']) ? $v['theme_id'] : 0;
                    $topic_id = isset($v['topic_id']) ? $v['topic_id'] : 0;
                    $v['content_type'] = 0;
                    if (!empty($theme_id)) {   // 主题
                        // 内容类型
                        $v['content_type'] = 1;     // 为1表示帖子
                        $sql_theme = "SELECT name FROM social_theme WHERE id = {$theme_id}";
                        $theme = $this->social_db->query($sql_theme)->row_array();
                        $v['theme_name'] = isset($theme['name']) ? $theme['name'] : '';
                    } else if (!empty($v['topic_id'])) {  // 话题
                        $v['content_type'] = 2;
                        $sql_topic = "SELECT name FROM social_topic WHERE id = {$topic_id}";
                        $topic = $this->social_db->query($sql_topic)->row_array();
                        $v['theme_name'] = isset($topic['name']) ? $topic['name'] : '';
                    }
                    // 获取回帖数
                    if (!empty($theme_id)) {   // 主题
                        $post_id = isset($v['id']) ? $v['id'] : 0;
                        $sql_answer = "SELECT id FROM social_theme_post_answer WHERE post_id = {$post_id} ";
                        $answer = $this->social_db->query($sql_answer);
                        $v['answer_cnt'] = $answer->num_rows();
                    } else if (!empty($v['topic_id'])) {
                        $post_id = isset($v['id']) ? $v['id'] : 0;
                        $sql_answer = "SELECT id FROM social_topic_answer WHERE question_id = {$post_id} ";
                        $answer = $this->social_db->query($sql_answer);
                        $v['answer_cnt'] = $answer->num_rows();
                    }
                    // 是否已关注当前问题   1已关注   0未关注
                    if ($v['content_type'] == 2) {
                        $question_id = isset($v['id']) ? $v['id'] : 0;
                        $sql_concern_type = "SELECT * FROM social_concern WHERE category_id = {$topic_id} AND content_id = {$question_id} AND member_id = {$this->anchor_id} AND type = 2";
                        $query_type = $this->social_db->query($sql_concern_type);
                        if ($query_type->num_rows() > 0) {
                            $v['concerned_question'] = 1;         // 1表示已关注
                        } else {
                            $v['concerned_question'] = 0;         // 0表示未关注
                        }
                    }
                    // 当天是否对帖子点过赞
                    $member_id_1 = empty($this->anchor_id) ? 0 : $this->anchor_id;
                    $post_id_1 = isset($v['id']) ? $v['id'] : 0;
                    $sql_praised_post = "SELECT update_time FROM social_praise WHERE category_id = {$post_id_1} AND type = 1 AND member_id = {$member_id_1} ORDER BY update_time DESC LIMIT 1";
                    $query_praised_post = $this->social_db->query($sql_praised_post);
                    if ($query_praised_post->num_rows() < 1) {
                        $v['praised_today'] = 0;
                    } else {
                        $ret_dz = $query_praised_post->row_array();
                        $update_time = isset($ret_dz['update_time']) ? $ret_dz['update_time'] : 0;
                        if (date('Y-m-d', time()) == date('Y-m-d', $update_time)) {
                            $v['praised_today'] = 1;
                        } else {
                            $v['praised_today'] = 0;
                        }
                    }
                    $ret['post'][] = $v;
                }
            }
            $sql = "SELECT * FROM
                (SELECT id, title, content, video_pic, video_url, pic1, pic2, pic3, member_id, line_id, theme_id,  0 topic_id, update_time, 0 involve_count, praise_count, watched_count, 0 concern_count, 0 invited_id FROM social_theme_post
                UNION
                SELECT id, title, content, video_pic, video_url, pic1, pic2, pic3, member_id, line_id, 0 theme_id, topic_id, update_time, involve_count, 0 praise_count, 0 watched_count, concern_count, invited_id FROM social_topic_question
                ) t " . $where;
            $cnt_post = $this->social_db->query($sql)->num_rows();
            if (0 == $cnt_post) {
                $this->__nullmsg();
            }
            $ret['cnt'] = $cnt_post;
        }
        $this->__outmsg($ret);
    }

    

    /**********************************************推荐**********************************************/
    /**
     * @method get_recommend
     * @desc    获取推荐数据
     */
    public function get_recommend(){
        // 从帖子和问答中取出10条,从视频中取1条
        $sql_recommend = "SELECT * FROM
        (SELECT id, title, content, video_pic, video_url, pic1, pic2, pic3,member_id, theme_id, praise_count, watched_count, update_time, line_id, 1 content_type from social_theme_post 
        UNION ALL
        SELECT id, title, content, video_pic, video_url, pic1, pic2, pic3, member_id, topic_id, concern_count, involve_count, update_time, line_id, 2 content_type from social_topic_question) t
        ORDER BY watched_count DESC, update_time DESC LIMIT 10";
        $ret = $this->social_db->query($sql_recommend)->result_array();
        foreach($ret as &$v){
            // 帖子id或问题id
            $post_id = isset($v['id']) ? $v['id'] : 0;
            // 主题id或话题id
            $theme_id = isset($v['theme_id']) ? $v['theme_id'] : 0;
            $pic1 = isset($v['pic1']) ? $v['pic1'] : '';
            $pic2 = isset($v['pic2']) ? $v['pic2'] : '';
            $pic3 = isset($v['pic3']) ? $v['pic3'] : '';
            $pics = '';
            if (empty($pic2)){
                $pics = $pic1 . ',' . $pic3;
            }else{
                $pics = $pic1 . ',' . $pic2 . ',' . $pic3;
            }
            $v['pics'] = trim(trim($pics), ',');
            $arr_pics = explode(',', $v['pics']);
            $v['pics'] = $this->__doImage($arr_pics);
            
            $video_pic = isset($v['video_pic']) ? $v['video_pic'] : '';
            $arr_v_pic = explode(',', $video_pic);
            $v['video_pic'] = $this->__doImage($arr_v_pic);
            $video_url = isset($v['video_url']) ? $v['video_url'] : '';
            $arr_v_url = explode(',', $video_url);
            $v['video_url'] = $this->__doImage($arr_v_url);
            // 根据线路id获取线路名称
            $line_id = isset($v['line_id']) ? $v['line_id'] : 0;
            $sql_line = "SELECT id, linename FROM u_line WHERE id = $line_id";
            $line = $this->db->query($sql_line)->row_array();
            $v['line_name'] = isset($line['linename']) ? $line['linename'] : '';
            // pic_type
            $v['pic_type'] = 0;
            if ($pic1 OR $pic2 OR $pic3){
                $v['pic_type'] = 1;     // 图片
            }else if ($video_pic){
                $v['pic_type'] = 2;     // 视频
            }else if (empty($pic1) && empty($pic2) && empty($pic3) && empty($video_pic)){
                $v['pic_type'] = 0;     // 都没有
            }
            // 时间
            $update_time = isset($v['update_time']) ? $v['update_time'] : 0;
            $v['update_time'] = date('Y-m-d', $update_time);
            // user_type    1达人  2领队   3管家
            $member_id = isset($v['member_id']) ? $v['member_id'] : 0;
            $sql_member = "SELECT anchor_id, type, nickname, photo, user_id FROM live_anchor WHERE anchor_id = $member_id";
            $member = $this->social_db->query($sql_member)->row_array();
            $v['user_type'] = isset($member['type']) ? $member['type'] : -1;
            // nickname 昵称
            $v['nickname'] = isset($member['nickname']) ? $member['nickname'] : '';
            // photo    头像
            $photo = isset($member['photo']) ? $member['photo'] : '';
            $arr_photo = explode(',', $photo);
            $v['photo'] = $this->__doImage($arr_photo);
            // user_id
            $v['user_id'] = isset($member['user_id']) ? $member['user_id'] : 0;
            $content_type = isset($v['content_type']) ? $v['content_type'] : 0;
            if (1 == $content_type){
                // 来自主题
                $sql_theme = "SELECT id, name FROM social_theme WHERE id = $theme_id";
                $theme = $this->social_db->query($sql_theme)->row_array();
                $v['theme_id'] = isset($theme['id']) ? $theme['id'] : 0;
                $v['theme_name'] = isset($theme['name']) ? $theme['name'] : '';
            }else if (2 == $content_type){
                $sql_topic = "SELECT id, name FROM social_topic WHERE id = $theme_id";
                $topic = $this->social_db->query($sql_topic)->row_array();
                $v['topic_id'] = isset($topic['id']) ? $topic['id'] : 0;
                $v['topic_name'] = isset($topic['name']) ? $topic['name'] : '';
            }
            if (!empty($this->anchor_id)) {
                if (1 == $content_type) {    // 主题
                    // 当天是否对帖子点过赞
                    $member_id_1 = empty($this->anchor_id) ? 0 : $this->anchor_id;
                    $post_id_1 = $post_id;
                    $sql_praised_post = "SELECT update_time FROM social_praise WHERE category_id = {$post_id_1} AND type = 1 AND member_id = {$member_id_1} ORDER BY update_time DESC LIMIT 1";
                    $query_praised_post = $this->social_db->query($sql_praised_post);
                    if ($query_praised_post->num_rows() < 1) {
                        $v['praised_today'] = 0;
                    } else {
                        $ret_dz = $query_praised_post->row_array();
                        $update_time = isset($ret_dz['update_time']) ? $ret_dz['update_time'] : 0;
                        if (date('Y-m-d', time()) == date('Y-m-d', $update_time)) {
                            $v['praised_today'] = 1;
                        } else {
                            $v['praised_today'] = 0;
                        }
                    }
                } else if (2 == $content_type) {    // 话题
                    // 是否已关注当前问题   1已关注   0未关注
                    $sql_concern_type = "SELECT id FROM social_concern WHERE category_id = {$theme_id} AND content_id = {$post_id} AND member_id = {$this->anchor_id} AND type = 2";
                    $query_type = $this->social_db->query($sql_concern_type);
                    if ($query_type->num_rows() > 0) {
                        $v['concerned_question'] = 1;         // 1表示已关注
                    } else {
                        $v['concerned_question'] = 0;         // 0表示未关注
                    }
                }
            }else{
                $v['praised_today'] = 0;
                $v['concerned_question'] = 0;         // 0表示未关注
            }
        }
        // 获取一条视频数据
        $sql_video = "SELECT id, name title, '' content, pic video_pic, video video_url, '' pic1, '' pic2, '' pic3, anchor_id member_id, '' theme_id, 0 praise_count, people watched_count, addtime update_time, 
            line_ids line_id, 3 content_type, '' pics, '' line_name, 0 pic_type, -1 user_type, '' nickname, '' photo, 0 user_id, '' theme_name, 0 praised_today, 0 concerned_question, dest_id, comment_num
            FROM live_video ORDER BY people DESC LIMIT 1";
        $video = $this->social_db->query($sql_video)->row_array();
        if ($video){
            // 处理video_pic
            $video_pic = isset($video['video_pic']) ? $video['video_pic'] : '';
            $arr_v_pic = explode(',', $video_pic);  
            $video['video_pic'] = $this->__doImage($arr_v_pic);
            // user_type, nickname, photo
            $anchor_id = isset($video['member_id']) ? $video['member_id'] : 0;
            $sql_anchor = "SELECT type, nickname, photo FROM live_anchor WHERE anchor_id = $anchor_id";
            $anchor = $this->social_db->query($sql_anchor)->row_array();
            $video['user_type'] = isset($anchor['type']) ? $anchor['type'] : -1;
            $video['nickname'] = isset($anchor['nickname']) ? $anchor['nickname'] : '';
            $photo = isset($anchor['photo']) ? $anchor['photo'] : '';
            $arr_photo = explode(',', $photo);
            $video['photo'] = $this->__doImage($arr_photo);
            $dest_id = isset($video['dest_id']) ? $video['dest_id'] : 0;
            // 根据dest_id获取dest_name
            $sql_dest = "SELECT kindname FROM u_dest_cfg WHERE id = $dest_id";
            $dest = $this->db->query($sql_dest)->row_array();
            $video['dest_name'] = isset($dest['kindname']) ? $dest['kindname'] : '';
            $update_time = isset($video['update_time']) ? $video['update_time'] : 0;
            $video['update_time'] = date('Y-m-d', $update_time);
            $ret[] = $video;
        }
        $this->__outmsg($ret);
    }
    
    /**********************************************新版2017-1-18 14:55:35*****************************************************/
    /**
     * @method get_home_info
     * @desc   获取首页信息
     * @param  page 第几页
     * @param  page_size    每页条数
     * @param  type         显示类型    1为推荐,2为参与,3为评论,4为收藏
     * @since  2017-1-18 14:56:27
     */
    public function get_home_info(){
        // 获取主题相关信息
        $type = $this->input->post('type', TRUE);
        $type = $type ? (int)$type : 0;
        // TODO 加入排序
        $page = $this->input->post('page', TRUE);
        $page = $page ? (int)$page : 1;
        $page_size = $this->input->post('page_size', TRUE);
        $page_size = $page_size ? (int)$page_size : 5;
        $from = ($page - 1) * $page_size;
        $sql_theme = "SELECT id theme_id, name theme_name, pic1 pics, video_url1 video_url, concern_count FROM social_theme LIMIT $from, $page_size";
        $theme = $this->social_db->query($sql_theme)->result_array();
        if (empty($theme)){
            $this->__nullmsg();
        }
        foreach($theme as &$v){
            // 处理pics,video_url
            $pics = rtrim(isset($v['pics']) ? $v['pics'] : '', ',');
            $arr_pics = explode(',', $pics);
            $v['pics'] = $this->__doImage($arr_pics);
            $urls = rtrim(isset($v['video_url']) ? $v['video_url'] : '', ',');
            $arr_url = explode(',', $urls);
            $v['video_url'] = $this->__doImage($arr_url);
            // 处理pics,video_url结束
            $cnt_post = 0;      // 主题的帖子数
            $cnt_answer = 0;    // 主题的回复数
            // 获取主题的参与数,评论数;参与数为帖子数与回复数之和,评论数为所有帖子的回复数之和
            $theme_id = isset($v['theme_id']) ? $v['theme_id'] : 0;
            // 获取含有视频的帖子
            $sql_post = "SELECT id, title, content, video_pic, praise_count FROM social_theme_post WHERE theme_id = $theme_id AND video_url IS NOT NULL AND video_url <> '' ";
            $query_post = $this->social_db->query($sql_post);
            $cnt_post += $query_post->num_rows();
            $posts = $query_post->result_array();
            foreach($posts as &$val){
                // 处理video_pic
                $video_pic = isset($val['video_pic']) ? $val['video_pic'] : '';
                $arr_v_pic = explode(',', $video_pic);
                $val['video_pic'] = $this->__doImage($arr_v_pic);
                $post_id = isset($val['id']) ? $val['id'] : 0;
                $sql_answer = "SELECT id FROM social_theme_post_answer WHERE post_id = $post_id";
                $answer_cnt = $this->social_db->query($sql_answer)->num_rows();
                $cnt_answer += $answer_cnt;
                $val['post_anser_cnt'] = $answer_cnt;   // 帖子回复数
            }
            $v['cnt_theme_invol'] = $cnt_post + $cnt_answer;    // 主题参与数
            $v['cnt_theme_answer'] = $cnt_answer;               // 主题评论数
            $v['posts'] = $posts;
        }
        $this->__outmsg($theme);
    }
}
