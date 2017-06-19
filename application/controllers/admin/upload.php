<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Upload extends MY_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->library ( 'callback' );
	}
	
	/**
	 * @method 上传文件
	 * @author jiakairong
	 * @since  2016-01-18
	 */
	public function uploadFile()
	{
		$fileId = trim($this ->input ->post('fileId' ,true)); //file控件ID
		$type = trim($this ->input ->post('type' ,true)); //上传文件类型  图片(i) or 文件(f)
		$time = time();
		//上传文件目录,以日期创建
		$path = './file/upload/'.date('Ymd' ,$time);
		if (!file_exists($path))
		{
			$status = mkdir($path ,0777 ,true);
			if ($status == false)
			{
				$this ->callback ->setJsonCode(4000 ,'文件目录创建失败');
			}
		}
		$config = array(
			'upload_path' =>$path,
			'allowed_types' =>$type == 'f' ? 'doc|txt|xls|docx' : 'gif|jpg|jpeg',
			'max_size' => '20000',
			'file_name' =>$time.mt_rand(10000,99999)
		);
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload($fileId))
		{
			$error = $this->upload->display_errors();
			$this ->callback ->setJsonCode(4000 ,strip_tags($error));
		}
		else
		{
			$info = $this->upload->data();
			$url = ltrim($path,'.').'/'.$info['file_name'];
			$this ->callback ->setJsonCode(2000 ,$url);
		}
	}
	
	/**
	 * @method 上传直播图片文件
	 * @author jiakairong
	 * @since  2015-09-02
	 */
	function uploadImgFilelive() {
		
		$fileId = trim($this ->input ->post('fileId' ,true));
		$time = date('Ymd',time());
		$upload_path = './file/live/img/'.$time;
		if (!file_exists($upload_path)) {
			$status = mkdir($upload_path ,0777 ,true);
			if ($status == false) {
				$this->callback->setJsonCode ( 4000 ,'上传失败，联系客服');
			}
		}
		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '20000';
		$config['file_name'] = time().mt_rand(10000,99999);
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload($fileId))
		{
			$error = $this->upload->display_errors();
			$this->callback->setJsonCode ( 4000 ,strip_tags($error));
		}
		else
		{
			$file_info = array('upload_data' => $this->upload->data());
			$url = '/file/live/img/'.$time.'/'.$file_info ['upload_data'] ['file_name'];
			$this->callback->setJsonCode ( 2000 ,$url);
		}
	}	
	/**
	 * @method 上传视频文件
	 * @author zyf
	 * @since  2017-01-06
	 */
	function uploadVideoFile() {
		$fileId = trim($this ->input ->post('fileId' ,true));
		$time = date('Ymd',time());
		$upload_path = './file/live/video/'.$time;
		if (!file_exists($upload_path)) {
			$status = mkdir($upload_path ,0777 ,true);
			if ($status == false) {
				$this->callback->setJsonCode ( 4000 ,'上传失败，联系客服');
			}
		}
		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'mp4|mov|avi|wmv';
		$config['max_size'] = '1000000';
		$config['file_name'] = time().mt_rand(10000,99999);
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload($fileId))
		{
			$error = $this->upload->display_errors();
			$this->callback->setJsonCode ( 4000 ,strip_tags($error));
		}
		else
		{
			
			$file_info = array('upload_data' => $this->upload->data());
			$path = "http://".$_SERVER['HTTP_HOST'];
			$url = $path.'/file/live/video/'.$time.'/'.$file_info ['upload_data'] ['file_name'];
			$urls = dirname(BASEPATH).'/file/live/video/'.$time.'/'.$file_info ['upload_data'] ['file_name'];
			//旋转视频裁剪
// 			exec ("ffmpeg -i ".escapeshellarg($urls)."  -f image2 -ss 2 -vf 'transpose=1' -vframes 1 ".$urls.'.jpg'."");		
			exec("ffmpeg -i  ".escapeshellarg($urls)."  -y -f image2 -ss 2  ".$urls.'.jpg'."");
			//裁剪图片开始
			$src_img = $urls.'.jpg';
			//图片地址
			$img_url=$url.'.jpg';
			//宽高比 35:22
			list($src_w,$src_h)=getimagesize($src_img);  // 获取原图尺寸			
			$data = array(
				'url'=>$url,
				'src_w'=>$src_w,
				'src_h'=>$src_h,
				'img_url'=>$img_url
			);
			$this->callback->setJsonCode ( 2000 ,$data);
		}
	}
	
	
	/**
	 * @method 上传图片文件
	 * @author jiakairong
	 * @since  2015-09-02
	 */
	function uploadImgFile() {
		
		$fileId = trim($this ->input ->post('fileId' ,true));
		$time = date('Ymd',time());
		$upload_path = './file/upload/'.$time;
		if (!file_exists($upload_path)) {
			$status = mkdir($upload_path ,0777 ,true);
			if ($status == false) {
				$this->callback->setJsonCode ( 4000 ,'上传失败，联系客服');
			}
		}
		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '20000';
		$config['file_name'] = time().mt_rand(10000,99999);
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload($fileId))
		{
			$error = $this->upload->display_errors();
			$this->callback->setJsonCode ( 4000 ,strip_tags($error));
		}
		else
		{
			$file_info = array('upload_data' => $this->upload->data());
			$url = '/file/upload/'.$time.'/'.$file_info ['upload_data'] ['file_name'];
			$this->callback->setJsonCode ( 2000 ,$url);
		}
	}
	
	
	/**
	 * @method 上传图片文件(适用于美图秀秀标准表单上传)
	 * @author jiakairong
	 * @since  2015-09-07
	 */
	function uploadImgFileXiu() {
		$time = date('Ymd',time());
		$upload_path = './file/upload/'.$time;
		if (!file_exists($upload_path)) {
			$status = mkdir($upload_path ,0777 ,true);
			if ($status == false) {
				$this->callback->setJsonCode ( 4000 ,'上传失败，联系客服');
			}
		}
		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '20000';
		$config['file_name'] = time().mt_rand(10000,99999);
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload('uploadFile'))
		{
			$error = $this->upload->display_errors();
			$this->callback->setJsonCode ( 4000 ,strip_tags($error));
		}
		else
		{
			$file_info = array('upload_data' => $this->upload->data());
			$url = '/file/upload/'.$time.'/'.$file_info ['upload_data'] ['file_name'];
			$this->callback->setJsonCode ( 2000 ,$url);
		}
	}
	
	/**
	 * @method 上传视频封面图片(适用于美图秀秀标准表单上传)
	 * @author zyf
	 * @since  2017-01-06
	 */
	function uploadvideoFileXiu() {
		$time = date('Ymd',time());
		$upload_path = './file/live/img/'.$time;
		if (!file_exists($upload_path)) {
			$status = mkdir($upload_path ,0777 ,true);
			if ($status == false) {
				$this->callback->setJsonCode ( 4000 ,'上传失败，联系客服');
			}
		}
		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '20000';
		$config['file_name'] = time().mt_rand(10000,99999);
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload('uploadFile'))
		{
			$error = $this->upload->display_errors();
			$this->callback->setJsonCode ( 4000 ,strip_tags($error));
		}
		else
		{
			$file_info = array('upload_data' => $this->upload->data());
			$url = '/file/live/img/'.$time.'/'.$file_info ['upload_data'] ['file_name'];
			$this->callback->setJsonCode ( 2000 ,$url);
		}
	}
	/**
	 * @method 图片上传(用于ajax请求上传图片)
	 * @author jiakairong
	 * @since  2015-07-04
	 */
	public function ajax_upload_file() {
		$this->load->library ( 'callback' );
		$name_str = $this ->input ->post('filename' ,true);
		$prefix = $this ->input ->post('prefix' ,true); //
		$this->load->helper ( 'url' );
		$this->load->helper(array('form', 'url'));
		$config['upload_path'] = './file/a/upload/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '40000';
		$file_name = $prefix.'_'.time();
		$config['file_name'] = $file_name;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload($name_str))
		{
			$error = $this->upload->display_errors();
			$this->callback->setJsonCode ( 4000 ,strip_tags($error));
		}
		else
		{
			$file_info = array('upload_data' => $this->upload->data());
			$url = '/file/a/upload/' .$file_info ['upload_data'] ['file_name'];
			$this->callback->setJsonCode ( 2000 ,$url);
		}
	}
	
	/**
	 * @method 上传图片
	 * @author 贾开荣
	 * @since 2015-06-01
	 */
	public function upload_pic() {

		$this->load->helper ( 'url' );
		$this->load->helper(array('form', 'url'));
		$config['upload_path'] = './file/a/upload/';
		
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '20000';
		$file_name = 'avatar_'.time();
		$config['file_name'] = $file_name;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload('upload_file'))
		{
			return false;
		}
		else
		{
 			$file_info = array('upload_data' => $this->upload->data());
 			$url = '/file/a/upload/' .$file_info ['upload_data'] ['file_name'];
 			return $url;
		}
	}
	/**
	 * @method a端管理员上传图片
	 * @author 贾开荣
	 * @since  20105-06-01
 	 */
	public function a_upload_photo() {
		$this->load->library ( 'callback' );
		$url = $this ->upload_pic();
		if (empty($url)) {
			$this->callback->setJsonCode ( 4000, '上传文件失败，请选择gif|jpg|png重新上传' );
		}
		//修改管理员头像
		$this->load->library('session');
		$admin_id = $this->session->userdata('a_user_id');
		$this ->db ->where('id' ,$admin_id);
		$status = $this ->db ->update('u_admin' ,array('photo' =>$url));
		if (empty($status)) {
			$this->callback->setJsonCode ( 4000, '更改失败' );
		}  else {
			$this ->session ->set_userdata(array('a_photo' =>$url));
			$this->callback->setJsonCode ( 2000, '更改成功' );
		}
	}
	/**
	 * @method 会员中心上传图片
	 * @author 贾开荣
	 * @since  20105-06-01
	 */
	public function c_upload_file() {
		$url = $this ->upload_pic();
		if (empty($url)) {
			echo json_encode(array('status' => -1,'msg' =>'上传失败，请刷新重试'));
			exit;
		}
		//更改用户的头像
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
		
		$this->db->where('mid', $userid);
		$status = $this->db->update('u_member', array('litpic' =>$url));
		if (!empty($status)) {
			
			echo json_encode(array('status' => 1,'msg' =>'上传成功'));
			exit;
		} else {
			echo json_encode(array('status' => -1,'msg' =>'上传失败，请刷新重试'));
			exit;
		}
	}
	/**
	 * @method 管家手机端的图片上传
	 * @since  2016-02-04
	 */
	public function expert_moblie_img() {
		$this->load->library ( 'callback' );
		$expertid=intval($this->input->post('expertid'));
		if($expertid>0){
			
			$time = date('Ymd',time());
			$upload_path = './file/a/upload/moblie/'.$time;
			if (!file_exists($upload_path)) {
				$status = mkdir($upload_path ,0777 ,true);
				if ($status == false) {
					$this->callback->setJsonCode ( 4000 ,'上传失败，联系客服');
				}
			}
			$config['upload_path'] = $upload_path;
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = '20000';
			$config['file_name'] = 'm_'.time().mt_rand(10000,99999);
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ( ! $this->upload->do_upload('uploadFile'))
			{
				$error = $this->upload->display_errors();
				$this->callback->setJsonCode ( 4000 ,strip_tags($error));
			}
			else
			{
				$file_info = array('upload_data' => $this->upload->data());
				$url = '/file/a/upload/moblie/'.$time.'/'.$file_info ['upload_data'] ['file_name'];
			    $this->load->model ( 'admin/a/expert_model','expert_model' );
				$this->expert_model->update(array('mobile_photo'=>$url),array('id'=>$expertid));  
				//echo $this->db->last_query(); 
				$this->callback->setJsonCode ( 2000 ,$url);
			}
		}else{
			//$error = $this->upload->display_errors();
			$this->callback->setJsonCode ( 4000 ,'上传失败');
		}
	}
	//专家上传头像
	public function b2_upload_photo() {
		$this->load->library ( 'callback' );
		
		$url = $this ->upload_pic();
		if (empty($url)) {
			$this->callback->setJsonCode ( 4000, '上传文件失败，请选择gif|jpg|png重新上传' );
		}
		//更改专家头像
		$this->load->library('session');
		$expert_id = $this ->session ->userdata('expert_id');
		$this ->db ->where('id' ,$expert_id);
		$status = $this ->db ->update('u_expert' ,array('small_photo' =>$url ,'big_photo' =>$url));
		if (empty($status)) {
			$this->callback->setJsonCode ( 4000, '更改失败' );
		}  else {
			$this ->session ->set_userdata(array('user_pic' =>$url));
			$this->callback->setJsonCode ( 2000, '更改成功' );
		}
	}
	/**
	 * @method 上传文件
	 * @author jiakairong
	 * @since  2015-07-13
	 */
	public function up_file() {
		$this->load->library ( 'callback' );
		$name_str = $this ->input ->post('filename' ,true);

		$this->load->helper ( 'url' );
		$this->load->helper(array('form', 'url'));
		$config['upload_path'] = './file/a/upload/';
		$config['allowed_types'] = 'doc|txt|xls|docx';
		$config['max_size'] = '20000';
		$file_name = $name_str.'_'.time();
		$config['file_name'] = $file_name;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload($name_str))
		{
			$error = $this->upload->display_errors();
			$this->callback->setJsonCode ( 4000 ,strip_tags($error));
		}
		else
		{
			$file_info = array('upload_data' => $this->upload->data());
			$url = '/file/a/upload/' .$file_info ['upload_data'] ['file_name'];
			$this->callback->setJsonCode ( 2000 ,$url);
		}
	}
}
?>