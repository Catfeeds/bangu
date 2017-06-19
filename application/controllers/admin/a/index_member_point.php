<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年5月7日18:35:53
 * @author		汪晓烽
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index_Member_Point extends UA_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load_model('admin/a/index_member_point_model','member_point');
	}


	function index($page=1){
		$post_arr = array();
		$this->load->library('Page');
		$config['base_url'] = '/admin/a/index_member_point/index/';
		$config['pagesize'] = 10;
		$config['page_now'] = $this->uri->segment(5,0);
		$page = $page==0 ? 1:$page;
		$member_point_list = $this->member_point->get_data_list($post_arr,$page,$config['pagesize']);
		$config['pagecount'] = count($this->member_point->get_data_list($post_arr,0));
		$this->page->initialize($config);
		$data = array(
			'member_point_list' => $member_point_list
			);
		$this->load_view ( 'admin/a/ui/index_config/index_member_point_list', $data );
	}
	//增加首页专家
	function add_edit_member_point(){


		/**
		 * $this->db->where('id', '1');
		 *$this->db->update('sites', $data);
		 */

		$this->load->helper ( 'url' );
		$this->load->helper('regexp');
		$data = $this->security->xss_clean($_POST);
		if (empty($data['code'])){
			echo json_encode(array('status' =>-11 ,'msg' =>'请填写程序标识'));
			exit;
		}
		if (empty($data['point_type'])){
			echo json_encode(array('status' =>-11 ,'msg' =>'请填写积分类型'));
			exit;
		}
		if (empty($data['point_value'])){
			echo json_encode(array('status' =>-11 ,'msg' =>'请填写积分值'));
			exit;
		}
		$insert_data = array(
			'code'=>$data['code'],
			'pointtype'=>$data['point_type'],
			'content'=>$data['content'],
			'isopen'=>$data['is_open'],
			'value'=>$data['point_value']
		);
		if(empty($data['member_point_id'])){
			$status = $this ->db ->insert('cfg_member_point',$insert_data);
			if (empty($status)){
				echo json_encode(array('status' =>-11 ,'msg' =>'添加失败'));
				exit;
			}else {
				$id = $this ->db ->insert_id();
				$this ->log(1,3,'运营设置->首页用户获取积分配置',"平台新增首页用户获取积分,记录ID:{$id}");
				echo json_encode(array('status' =>1 ,'msg' =>'添加成功'));
				exit;
			}
		}else{
			$this->db->where('id', $data['member_point_id']);
			$this->db->update('cfg_member_point', $insert_data);
			$this ->log(3,3,'运营设置->首页用户获取积分配置',"平台编辑首页用户获取积分,记录ID:{$data['member_point_id']}");
			echo json_encode(array('status' =>1 ,'msg' =>'修改成功'));
			exit();
		}


	}

	//删除首页专家
	function delete_member_point(){
		$id = $this->input->post("id");
		$this->db->where('id', $id);
		$this->db->delete('cfg_member_point');
		$this ->log(2,3,'运营设置->首页用户获取积分配置',"平台删除首页用户获取积分,记录ID:{$id}");
		echo 'Success';
	}


	function get_one_member_point(){
		$post_arr = array();
		$id = $this->input->post('id');
		$post_arr['id'] = $id;
		$one_hot_line = $this->member_point->get_data_list($post_arr,0);
		echo json_encode($one_hot_line[0]);
	}

}