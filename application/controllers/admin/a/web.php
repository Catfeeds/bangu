<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年6月15日11:59:53
 * @author		jiakairong
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Web extends UA_Controller {

	public function __construct() {
		parent::__construct ();
		$this->load_model ( 'admin/a/web_model', 'web_model' );
		$this->load->library ( 'callback' );
	}
	//站点配置展示
	public function web_list() {
		$data = $this ->web_model ->row(array());
		$this->load_view ( 'admin/a/ui/index_config/web_list', $data );
	}
	
	//编辑网站配置
	public function edit_web() {
		$web_data = array();
		//$data = $this->security->xss_clean($_POST);
		$data = $_POST;
		$id = intval($this ->input ->post('id'));
		unset($data['id']);
		foreach($data as $key =>$val) {
			if ($key == "ordor_cancel_ms") {
				$web_data [$key] = intval($val);
			} else {
				$web_data [$key] = trim($val);
			}
		}
		$web_data['agent_rate'] = $data['agent_rate'] / 100;
		
		$status = $this ->web_model ->update($web_data ,array('id' =>$id));
		//echo $this ->db ->last_query();exit;
		if (!empty($status)) {
			$this ->log(3,3,'平台基础设置->网站配置','编辑网站配置');
			$this->callback->set_code ( 2000 ,"操作成功");
			$this->callback->exit_json();
		} else {
			$this->callback->set_code ( 4000 ,"操作失败");
			$this->callback->exit_json();
		}
	}
	/**
	 * 功能：上传文件
	 * 作者：贾开荣 v1.0.0
	 * 时间：2015-04-23
	 */
	public function up_file() {
		$name_str = $this ->input ->post('filename' ,true);
		$config['upload_path'] = './file/a/upload/';
		$config['allowed_types'] = 'doc|txt|xls|docx|pdf|jpg|png|jpeg';
		$config['max_size'] = '40000';
		$file_name = $name_str.'_'.time();
		$config['file_name'] = $file_name;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload($name_str))
		{
			echo json_encode(array('status' => -1,'msg' =>strip_tags($this->upload->display_errors())));
			exit;
		}
		else
		{
			$file_info = array('upload_data' => $this->upload->data());
			$url = '/file/a/upload/' .$file_info ['upload_data'] ['file_name'];
			echo json_encode(array('status' =>1, 'msg' =>'上传成功' ,'url' =>$url ));
			exit;
		}
	}
	//上传中文命名的文件
	public function up_contract_file(){
		$name_str = $this ->input ->post('filename' ,true);
		$config['upload_path'] = './file/a/upload/';//文件上传目录

		if($_FILES[$name_str]['error']==0){
			$pathinfo=pathinfo($_FILES[$name_str]['name']);
			$extension=$pathinfo['extension'];
			if($name_str=='contract_abroad'){  //境外
				$file_url=$config['upload_path'].'团队出境旅游合同_帮游旅行网'.".".$extension;
			}else{                             //境内
				$file_url=$config['upload_path'].'团队境内旅游合同_帮游旅行网'.".".$extension;
			}
			//$file_url=iconv("UTF-8","gb2312",$file_url);
			$file_arr=array('doc','docx','txt','xls','pdf');
		
			if(!in_array($extension, $file_arr)){
				echo json_encode(array('status' => -1,'msg' =>'上传格式出错,请选择doc,docx,txt,xls,pdf格式的文件'));
				exit;
			}
			//var_dump($file_url);
			if(!move_uploaded_file ($_FILES[$name_str]['tmp_name'], iconv("UTF-8","gb2312",$file_url))){
				echo json_encode(array('status' => -1,'msg' =>'上传出错,请重新选择文件'));
				exit;
			}else{
				$linedoc=mb_substr($file_url,1 );
				$linename=$_FILES[$name_str]['name'];
				echo json_encode(array('status' =>1, 'url' =>$linedoc));
			}
		}else{
			echo json_encode(array('status' => -1,'msg' =>'上传出错,请重新选择文件'));
			exit;
		}
	} 
	

}