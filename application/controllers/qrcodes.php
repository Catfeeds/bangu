<?php
/**
 * @method 		专家入驻
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月23日16:55:24
 * @author		jiakairong
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include './application/controllers/admin/commonExpert.php';
class qrcodes extends MY_Controller {
	public function __construct() {
		parent::__construct();
		set_error_handler('customError' ,E_ALL);
		$this ->load_model('activity_ticke_model','activity');
		//$this ->load_model( 'activity_ticket_model','activity');
	}
	 public function index() { 
	 	$data['account']=$this->activity->get_activity();
	 	$data['member']=$this->activity->all();
	 	$this->load_view('qrcodes',$data);
	 }
	 //获取入场人数
	 public function get_member_list(){

		//$param = $this->getParam(array('u_starttime','u_endtime'));
		$page=$this->input->post('page',true);
		$pageSize=$this->input->post('pageSize',true);
		if(empty($page)){
			$page=1;
		}
		if(empty($pageSize)){
			$pageSize=10;
		}
		$data = $this->activity->get_member_data($param,$page,$pageSize);
		echo json_encode($data);	

	 }
   //生成二维码	
    public function code() { 

    	$mobile=$this->input->post('mobile',true);
    	$name=$this->input->post('name',true);
    	$id=$mobile;
    	if(!file_exists("./file/qrcodes/activity")){
		mkdir("./file/qrcodes/activity",0777,true);//原图路径
	}

	/*生成二维码*/
	$this->load->library('ciqrcode');
	$params['data'] = base_url().'qrcodes/validate?mobile='.$mobile.'&name='.$name;
	$params['level'] = 'H';
	$params['size'] = 12;
	$params['savename'] = FCPATH.'file/qrcodes/activity/activity_'.$id.'.png';
	$this->ciqrcode->generate($params);
	//echo '<img src="'.base_url().'file/qrcodes/guanjiaid.png" />';
	$logo = FCPATH.'file/qrcodes/logo.png';//准备好的logo图片
	//echo FCPATH;
	$QR = base_url().'file/qrcodes/activity/activity_'.$id.'.png';//已经生成的原始二维码图
	if ($logo !== FALSE) {
		$QR = imagecreatefromstring(file_get_contents($QR));
		$logo = imagecreatefromstring(file_get_contents($logo));
		$QR_width = imagesx($QR);//二维码图片宽度
		$QR_height = imagesy($QR);//二维码图片高度
		$logo_width = imagesx($logo);//logo图片宽度
		$logo_height = imagesy($logo);//logo图片高度
		$logo_qr_width = $QR_width/ 5;//
		$scale = $logo_width/$logo_qr_width;
		$logo_qr_height = $logo_height/$scale;//
		$from_width = ($QR_width - $logo_qr_width) /2;
		//重新组合图片并调整大小
		imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,$logo_qr_height, $logo_width, $logo_height);
	}
	imagepng($QR, FCPATH.'file/qrcodes/activity/activity_'.$id.'_qr.png');
	$code_pic='/file/qrcodes/activity/activity_'.$id.'_qr.png';
	//$code_pic='<img src="/file/qrcodes/activity/activity_'.$id.'_qr.png" />';
	$insertData=array(
		'mobile'=>$mobile,
		'name'=>$name,
		'code_pic'=>$code_pic
	);

	$data=$this->activity->row(array('mobile'=>$mobile));
	if(empty($data)){
		$this->activity->insert($insertData);
		echo json_encode(array('status'=>1,'msg'=>'操作成功','code_pic'=>$code_pic));
	}else{
		echo json_encode(array('status'=>-1,'msg'=>'已注册过','code_pic'=>$code_pic));
	}

     }

     //验证二维码
     function validate(){

     	$mobile=$this->input->get('mobile');
     	$name=$this->input->get('name');
     	

     	$where=array('mobile'=>$mobile,'name'=>$name);
     	$data=$this->activity->row($where);
     	if(!empty($data)){
     		if($data['isuse']==1){
     			echo '<p style="margin-top:200px;text-align:center;color:#EC4504;font-size:45px;">此二维码已使用! 姓名:'.$name.';手机号:'.$mobile.'</p>';	
	     	}else{
	     		$this->activity->update(array('isuse'=>1), $where);
	     		echo '<p style="margin-top:200px;text-align:center;color:#169A14;font-size:45px;">验证成功! 姓名:'.$name.';手机号:'.$mobile.'<p/>';
	     	}
     	}else{
     		echo '该用户不存在';
     	}

     }

}