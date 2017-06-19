<?php

/**
 * @copyright	深圳海外国际旅行社有限公司
 * @author		何俊
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Member_experience extends UC_NL_Controller {

	public function __construct() {
		parent::__construct ();
		$this->load_model ( 'member_experience_model', 'experience_model' );
	}
	
	/**
	 * @method 体验师列表
	 * @since  2015-05-20
	 * @author 贾开荣
	 */
	public function index() {
		//echo sys_constant::DICT_TRANSPORT ;exit;
		$this ->load ->helper ('my_text');
		$key_word = trim($this ->input ->post("key_word" ,true));//关键字
		//var_dump($key_word);exit;
		$whereArr = array();
		//获取热门体验线路
		$this ->load_model ('experience_line_hot_model' ,'hot_model');
		$hot_where = array(
			'is_show' =>1
		);
		$hot_list = $this ->hot_model ->get_line_hot_data($hot_where ,1 ,6);
		
		//获取最美体验师
		$this ->load_model ('beauty_experience_model' ,'beauty_model');
		$beauty_where = array(
			'is_show' =>1
		);
		$beauty_list = $this ->beauty_model ->get_beauty_expertience_data($beauty_where ,1,4);
		//获取年龄搜索范围
		$this ->load_model('search_condition_model' ,'search_model');
		$age_search = $this ->search_model ->get_search_data(sys_constant::SEARCH_AGE_CODE);
		//var_dump($age_search);exit;
		$data = array(
			'beauty_list' =>$beauty_list,
			'hot_list' =>$hot_list,
			'age_search' =>$age_search,
			'key_word' =>$key_word
		);
		$this->load->view ( 'experience/experience_list' ,$data);
	}
	public function search_ajax_list() {
		$whereArr = array('me.status' =>1);
		$likeArr = array();
		$page_new = intval($this ->input ->post('page_new')); //当前页
		$sex = intval($this ->input ->post('sex')); //性别
		$age = $this ->input ->post('age'); //年龄
		$nickname = $this ->input ->post('nickname' ,true); //搜索关键字
		$city = $this ->input ->post('city' ,true); //所在城市
		$city_id = intval($this ->input ->post('city_id'));
		$dest_name = trim($this ->input ->post('dest_name'));//目的地
		$dest_id = intval($this ->input ->post('dest_id'));
		//搜索性别
		switch($sex) {
			case 1: //男
				$whereArr ['m.sex'] = 1;
				break;
			case 2: //女
				$whereArr ['m.sex'] = 0;
				break;
		}
		//搜索年龄
		if (!empty($age)) {
			$age = explode('-',$age);
			$minAge = intval($age['0']);
			$maxAge = intval($age['1']);
			$year_new = date('Y' ,time());
			if ($minAge < 1) { //多少岁以下
				$whereArr ['m.birthday >'] = $year_new - $maxAge;
			} elseif ($maxAge < 1) {//多少岁以上
				$whereArr ['m.birthday <'] = $year_new - $minAge.'-12-30';
			} else {
				$whereArr ['m.birthday >'] = $year_new - $maxAge;
				$whereArr ['m.birthday <'] = $year_new - $minAge.'-12-30';
			}
		}
		//搜索昵称
		if (!empty($nickname)) {
			$likeArr ['m.nickname'] = $nickname;
		}
		//搜索所在城市
		if (!empty($city_id)) {
			$whereArr['m.city'] = $city_id;
		} elseif (!empty($city)) {
			//获取城市ID
			$this ->load_model('area_model');
			$area_info = $this ->area_model ->row(array('name like' =>$city.'%'));
			if (empty($area_info)) {
				echo false; exit;
			} else {
				$whereArr['m.city'] = $area_info ['id'];
			}
		}
		//搜索去过的地方
		if (!empty($dest_id)) {
			$whereArr['ed.dest_id'] = $dest_id;
		} elseif (!empty($dest_name)) {
			$this ->load_model('destinations_model');
			$destArr = $this ->destinations_model ->row(array('kindname like' =>$dest_name.'%'));
			if (empty($destArr)) {
				echo false;exit;
			} else {
				$whereArr['ed.dest_id'] = $destArr['id'];
			}
		}
		
		//获取体验师总条数
		$count = count($this ->experience_model ->get_expertience_data($whereArr , 0, 0 ,$likeArr));
		
		$this->load->library ( 'Page_ajax' ); //加载分页类
		$config ['pagesize'] = sys_constant::EXPERTIENCE_PAGE_SIZE;
		$config ['page_now'] = $page_new;
		$config ['pagecount'] = $count; // 获取查询结果的条数
		$this->page_ajax->initialize ( $config );
		$page_string = $this ->page_ajax ->create_page();
		//获取体验师数据
		$list =  $this ->experience_model ->get_expertience_data($whereArr , $page_new, sys_constant::EXPERTIENCE_PAGE_SIZE ,$likeArr);
		//echo $this ->db ->last_query();exit;
		if (empty($list)) {
			echo false;
		} else {
			foreach($list as &$val) {
				$destData = $this ->experience_model ->get_expertience_dest($val['member_id']);
			//	echo $this ->db ->last_query();echo '<br/>';
				if (empty($destData)) {
					$val['dest_name'] = '';
				} else {
					$dest_name = '';
					foreach($destData as $v) {
						$dest_name .= $v['kindname'].'、'; 
					}
					$val['dest_name'] = rtrim($dest_name ,'、');
				}
			}
			$data = array(
					'list' =>$list,
					'page_string' =>$page_string
			);
			echo json_encode($data);
		}
	}
	
}
