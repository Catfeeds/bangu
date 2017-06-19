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

class Essay extends UB2_Controller {

	public function __construct() {
		parent::__construct();

		$this->load_model('admin/b2/Essay_model', 'essay');
		$this->load->library('session');
	}

	//我的随笔
	public function index($page = 1) {

		# 分页设置
		$this->load->library('Page');
		$config['base_url'] = '/admin/b2/message/index/';
		$config['pagesize'] = 15;
		$config['page_now'] = $this->uri->segment(5,0);
		$post_arr = array();
		$this->session->unset_userdata('opportunity_title');
		$this->session->unset_userdata('time');
		# 搜索表单提交
		$post_arr['expert_id'] = $this->expert_id;
		$config['pagecount'] = $this->essay->essay_row($post_arr,0);
		$this->page->initialize($config);
		$essay_list = $this->essay->essay_row($post_arr,$page, $config['pagesize']);

		$this->load_view('admin/b2/essay', array('essay_list' => $essay_list));
	}

	//多图片上传的时候的处理程序
	function upload_pics(){
		$this->load->helper ( 'url' );
		$config['upload_path'] = './file/b2/upload/img/';
		if(!file_exists($config['upload_path'])){
			mkdir($config['upload_path'],0777,true);//原图路径
		}
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '40000';
		$file_name = 'b1_'.date('Y_m_d', time()).'_'.sprintf('%02d', rand(0,9999));
		$config['file_name'] = $file_name;
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('file'))
		{
			echo json_encode(array('status' => -1,'msg' =>'请重新选择要上传的文件'));
			exit;
		}
		else
		{
			$file_info = array('upload_data' => $this->upload->data());
			$url =  '/file/b2/upload/img/' .$file_info ['upload_data'] ['file_name'];
			echo json_encode(array('status' =>1, 'url' =>$url ));
			exit;
		}
	}

	//添加随笔
	function add_essay(){
		 $content=$this->input->post('content');
		 $essay_imgss=$this->input->post('essay_imgss');
		 $pic='';
		 if(!empty($essay_imgss)){
		 	$pic=implode(';', $essay_imgss);
		 }
		 $insert_data=array(
		     'expert_id'=>$this->expert_id,
		 	  'content'=>$content,
		      'addtime'=>date('Y_m_d H:i:s', time()),
		 	   'praise_count'=>0,
		 	   'popularity'=>0
		 );
		   $essay_id=$this->essay->insert_data('u_expert_essay',$insert_data);
		 if(is_numeric($essay_id)){   //插入图片
		 	$pic_data=array(
		 			'expert_essay_id'=>$essay_id,
		 			'pic'=>$pic,
		 	);
		 	$this->essay->insert_data('u_expert_essay_pic',$pic_data);
		 }
		 redirect('admin/b2/essay/index');
	}
	//通过id获取随笔
	function get_essay(){
		$id=$this->input->post('id');
		$data='';
		if(is_numeric($id)){
			$data=$this->essay->select_essayData(array('e.id'=>$id));
		}
		echo json_encode($data);
	}
	//保存编辑的随笔
	function edit_essay(){
		$id=$this->input->post('essay_id');
		if(is_numeric($id)){
			$content=$this->input->post('eidt_content');
			$edit_imgss=$this->input->post('edit_imgss');
			$pic='';
			if(!empty($edit_imgss)){
				$pic=implode(';', $edit_imgss);
			}
			$updata_data=array(	'content'=>$content);
			$pic_data=array('pic'=>$pic);
			$this->essay->update_rowdata('u_expert_essay',$updata_data,array('id'=>$id)); //修改内容
			$this->essay->update_rowdata('u_expert_essay_pic',$pic_data,array('expert_essay_id'=>$id)); //修改图片
			//echo $this->db->last_query();exit;
		}
		redirect('admin/b2/essay/index');
	}
}
