<?php
/**
 * 消息通知
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月7日10:06:30
 * @author
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Personal_Page extends UB2_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load_model('admin/b2/Personal_page_model', 'personal');
	}

	//个人主页
	public function index($page = 1) {
		$data = array();
		$label_attr = array();
		$go_place = array();
		$expert_play = array();
		$expert_relax = array();
		$expert_with = array();
		$more_detail = $this ->personal ->get_page_data("u_expert_more_about",array('expert_id'=>$this->expert_id));

		if(empty($more_detail)){
			$more_detail = array(array("id"=>"","expert_id"=>"","county"=>"","province"=>"","city"=>"","hobby"=>"","pass_way"=>"","like_food"=>"","constellation"=>"","decade"=>"","blood"=>""));
		}
		$label_attr_res = $this ->personal ->get_page_data("u_expert_attr",array('expert_id'=>$this->expert_id));
		if(!empty($label_attr_res)){
			foreach($label_attr_res AS $k=>$val){
				$label_attr[] = $val['attr_id'];
			}
		}
		$go_place_res = $this ->personal ->get_page_data("u_expert_go",array('expert_id'=>$this->expert_id));
		if(!empty($go_place_res)){
			foreach($go_place_res AS $k=>$val){
				$go_place[] = $val['dest_id'];
			}
		}
		$expert_play_res = $this ->personal ->get_page_data("u_expert_play",array('expert_id'=>$this->expert_id));
		if(!empty($expert_play_res)){
			foreach($expert_play_res AS $k=>$val){
				$expert_play[] = $val['way_id'];
			}
		}
		$expert_relax_res = $this ->personal ->get_page_data("u_expert_relax",array('expert_id'=>$this->expert_id));
		if(!empty($expert_relax_res)){
			foreach($expert_relax_res AS $k=>$val){
				$expert_relax[] = $val['relax_id'];
			}
		}
		$expert_with_res = $this ->personal ->get_page_data("u_expert_with",array('expert_id'=>$this->expert_id));
		if(!empty($expert_with_res)){
			foreach($expert_with_res AS $k=>$val){
				$expert_with[] = $val['crowd_id'];
			}
		}
		//喜欢的休闲方式
  		$data['relax'] = $this ->personal ->get_dictionary_data('DICT_EXPERT_RELAX');
  		//喜欢跟谁玩
  		$data['with_who'] = $this ->personal ->get_dictionary_data('DICT_EXPERT_WITH');
  		//喜欢怎么样玩
  		$data['play'] = $this ->personal ->get_dictionary_data('DICT_EXPERT_PLAY');
  		//国内游
  		$data['gn'] = $this ->personal ->get_dictionary_data('DICT_EXPERT_DEST_GN');
  		//境外游
  		$data['jw'] = $this ->personal ->get_dictionary_data('DICT_EXPERT_DEST_JW');
  		//性格标签
  		$data['attr'] = $this ->personal ->get_dictionary_data('DICT_EXPERT_ATTR');
  		//年代
  		$data['decade'] = $this ->personal ->get_dictionary_data('DICT_DECADE');
  		//personal
  		$data['blood'] = $this ->personal ->get_dictionary_data('DICT_BLOOD');
  		//星座
  		$data['constellation'] = $this ->personal ->get_dictionary_data('DICT_CONSTELLATION');
  		//获取省份
  		$data['provinces'] = $this ->personal ->get_area_data(array("pid"=>2,"level"=>2));
  		//获取已经插入的数据
  		if(!empty($more_detail[0]['hobby'])){
  			$more_detail[0]['hobby_arr'] = explode("#", $more_detail[0]['hobby']);
  		}
  		if(!empty($more_detail[0]['pass_way'])){
  			$more_detail[0]['pass_way_arr'] = explode("#", $more_detail[0]['pass_way']);
  		}
  		if(!empty($more_detail[0]['like_food'])){
  			$more_detail[0]['like_food_arr'] = explode("#", $more_detail[0]['like_food']);
  		}
  		$data['more_detail'] = $more_detail[0];
  		$data['label_attr'] = $label_attr;
		$data['go_place'] = $go_place;
		$data['expert_play'] = $expert_play;
		$data['expert_relax'] = $expert_relax;
		$data['expert_with'] = $expert_with;

		$this->load_view('admin/b2/personal_page',$data);
	}


	//二级联动省市
	function ajax_get_area(){
		$province_id = $this->input->post('province_id');
		$city= $this ->personal ->get_area_data(array("pid"=>$province_id));
		echo json_encode($city);
		exit();
	}

	//异步修改多项选择的数据
	function ajax_edit_multiSelect(){
		$where_data = array();
		$choose_id = $this->input->post('choose_id');
		$table = $this->input->post('table');
		$operator = $this->input->post('operator');
		$field = $this->input->post('field');
		$where_data = array($field=>$choose_id,'expert_id'=>$this->expert_id);
		$status = $this ->personal ->edit_page_data($operator,$table,$where_data);
		echo json_encode($status);
		exit();
	}


	//修改个人主页数据
	function update_page(){
		$post_arr = $this->security->xss_clean($_POST);
		$res = $this ->personal ->get_page_data('u_expert_more_about',array('expert_id'=>$this->expert_id));
		$insert_arr = array(
				'expert_id'=>$this->expert_id,
				'county'=>2,
				'province'=>!empty($post_arr['provinces'])&&isset($post_arr['provinces']) ? $post_arr['provinces'] : 0,
				'city'=>!empty($post_arr['city'])&&isset($post_arr['city']) ? $post_arr['city'] : 0,
				'hobby'=>$post_arr['interest1'].'#'.$post_arr['interest2'].'#'.$post_arr['interest3'].'#'.$post_arr['interest4'],
				'pass_way'=>$post_arr['placeed1'].'#'.$post_arr['placeed2'].'#'.$post_arr['placeed3'].'#'.$post_arr['placeed4'],
				'like_food'=>$post_arr['food1'].'#'.$post_arr['food2'].'#'.$post_arr['food3'].'#'.$post_arr['food4'],
				'constellation'=>$post_arr['xingzuo'],
				'decade'=>!isset($post_arr['decade']) ? 0 : $post_arr['decade'],
				'blood'=>!isset($post_arr['blood']) ? 0 : $post_arr['blood']
				);
		if(empty($res)){
			 $status = $this->db->insert('u_expert_more_about',$insert_arr);
		}else{
			$status = $this->db->update('u_expert_more_about',$insert_arr,array('expert_id'=>$this->expert_id));
		}
		if($status){
			echo json_encode(array("msg"=>"保存成功","code"=>"200"));
		}else{
			echo json_encode(array("msg"=>"保存失败","code"=>"300"));
		}
		exit();
	}


}