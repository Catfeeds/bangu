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
class Register extends MY_Controller {
	public function __construct() {
		parent::__construct();
		set_error_handler('customError' ,E_ALL);
		$this ->load_model('common/u_expert_model','expert_model');
	}
	//内部注册，无需手机验证码
	public function inside() {
		$this->get_qrcodes(0);
		//相馆信息
		$data['museum']=$this ->expert_model ->get_museum();
		$data['destArr'] = $this ->getDestData();
		$this ->load_view('admin/b2/inside_register',$data);
	}
	
	//进入注册页面
	public function index() {
		$this->get_qrcodes(0);
		//相馆信息
		$data['museum']=$this ->expert_model ->get_museum();
		$data['destArr'] = $this ->getDestData();
		$this ->load_view('admin/b2/register',$data);
	}
	
	//验证用户是否有权限拍照
	public function reg_photo() {
	 $id = ($this->input->post('mobile'));
	 $this->load->helper ( 'regexp' );
	 if (!regexp('mobile' ,$id)) {
		echo json_encode(array('code'=>4000,'msg'=>'请正确填写手机号码！'));exit();
		}
	 if(empty($id)){
		 echo json_encode(array('status'=>4000,'msg'=>'手机号码必须填写，才能享受免费照相业务！'));exit();
	 }
	 @$reDataArr = $this->db->query ( " SELECT status FROM `u_expert` where  mobile={$id}")->result_array ();
	 if(empty($reDataArr)){
		echo json_encode(array('code'=>2000));
	}elseif ( ( $reDataArr[0]['status'] ) == 3 || ( $reDataArr[0]['status'] ) == '-1') {
		echo json_encode(array('status'=>4000,'msg'=>'该帐号审核未通过，不能免费照相！'));
	} else {
		echo json_encode(array('status'=>4000,'msg'=>'您的手机号已存在'));
	}
	}
	
	//管家注册
	public function expertRegister() {
		$expertNew = new CommonExpert($_POST);
		$expertNew ->expertRegisterCom();
	}
	//内部管家注册
	public function expertInsiderAdd() {
		$expertNew = new CommonExpert($_POST);
		$expertNew ->expertRegisterInsert();
	}

	//审核中和已拒绝的管家进入完善信息
	public function perfect() {
		$id = intval($this->input->get('id'));
		$data['expert'] = $this ->expert_model ->row(array('id' =>$id) ,'arr' ,'id desc');
		if ($id != $this->session->userdata('upExpertId') || empty($data['expert'])) {
			header("Location:/admin/b2/login");exit;
		}

		//毕业于adfasdf,旅游从业岗位：dfghdfgh,4年从业经验
		//$beizhu = mb_substr($data['expert']['beizhu'] ,3);

		//$data['expert']['scholl'] = mb_substr($beizhu ,0 ,mb_strpos($beizhu ,',旅游从业岗位'));
		//$data['expert']['job_name'] = mb_substr($beizhu ,mb_strpos($beizhu ,'：')+1 ,mb_strrpos($beizhu ,',')-mb_strpos($beizhu ,'：')-1);
		//$data['expert']['year'] = floatval(mb_substr($beizhu ,mb_strrpos($beizhu ,',')+1));

		$this ->load_model('/common/u_expert_certificate_model' ,'certificate_model');
		$this ->load_model('/common/u_expert_resume_model' ,'resume_model');
		$data['resume'] = $this ->resume_model ->all(array('expert_id' =>$id));
		$data['certificate'] = $this ->certificate_model ->all(array('expert_id' =>$id));
		//获取擅长目的地
		$this->load_model('dest/dest_base_model' ,'dest_base_model');
		$whereArr = array(
				'in' =>array('id' =>$data['expert']['expert_dest'])
		);
		$data['dest'] = $this ->dest_base_model ->getDestBaseAllData($whereArr);
		//echo $this->db->last_query();
		//相馆信息
		$data['expert_qrcode']=$this ->expert_model ->get_expert_qrcode($id);
		$data['museum']=$this ->expert_model ->get_museum();
		$data['expert_museum']=$this ->expert_model ->get_expert_museum($id);
		//$this->get_qrcodes(0);
		$data['destArr'] = $this ->getDestData();
		$this ->load_view('admin/b2/register' ,$data);
	}
	public function getDestData()
	{
		$destArr = array();
		$this->load_model('dest/dest_base_model' ,'dest_base_model');
		$destData = $this ->dest_base_model ->all(array('level <=' =>2) ,'level asc');
		if (!empty($destData))
		{
			foreach($destData as $val)
			{
				if ($val['level'] == 1)
				{
					$destArr[$val['id']] = $val;
				} 
				elseif ($val['level'] == 2)
				{
					if (array_key_exists($val['pid'], $destArr))
					{
						$destArr[$val['pid']]['lower'][] = $val;
					}
				}
			}
		}
		return $destArr;
	}
	
	//完善管家资料
	public function updateExpert() {
		$expertNew = new CommonExpert($_POST);
		$expertNew ->expertDataPerfect();
		$this ->session ->unset_userdata('upExpertId');
	}
	//管家扫面二维码
	 public function upExpertMuseum(){
	 	$expert_id=$this->input->get('id');
	 	$data=array();
	 	if($expert_id){
	 		$re=$this ->expert_model ->up_expert_museum($expert_id);
	 		$data['expert']=$this ->expert_model ->get_expert_data($expert_id);
	 		//var_dump($data['expert']);
	 		if($re){
	 		//	echo  1;
	 		}else{
	 		//	echo  0;
	 		}
	 	}else{
	 	//	echo  0;
	 	}
	 	$this ->load_view('admin/b2/register_expert_pic',$data);
	 }
	//成功提示页面
	public function success() {
		$this ->load_view('admin/b2/register_success');
	}
	/*生成二维码*/
	function get_qrcodes($id){
		$this->load->library('ciqrcode');
		$params['data'] = base_url().'admin/b2/register/upExpertMuseum?id='.$id;
		$params['level'] = 'H';
		$params['size'] = 12;
		$params['savename'] = FCPATH.'file/qrcodes/guanjiaid_'.$id.'.png';
		$this->ciqrcode->generate($params);
		//echo '<img src="'.base_url().'file/qrcodes/guanjiaid.png" />';
		$logo = FCPATH.'file/qrcodes/logo.png';//准备好的logo图片
		//echo FCPATH;
		$QR = base_url().'file/qrcodes/guanjiaid_'.$id.'.png';//已经生成的原始二维码图
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
		imagepng($QR, FCPATH.'file/qrcodes/'.$id.'_qr.png');
		//	echo '<img src="'.base_url().'file/qrcodes/guanjiaid_qr.png">';
		//echo "file/qrcodes/".$id."_qr.png";
	}

}