<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Statistics extends MY_Controller {
	
	public function __construct() {
		parent::__construct ();
		$this->load->library('user_agent');
		$this->load_model( 'statistics_model', 'statistics_model' );
	}

	/**
	 * @method 统计入口
	 */
	public function index($module='',$uid='') {
		$referrer='';
		if ($this->agent->is_referral()){
			$referrer = $this->agent->referrer();
		}
		$sid = session_id();
		if(empty($sid)){
			session_start();
		}
// 		echo "SID: ".SID."<br>session_id(): ".session_id()."<br>COOKIE: ".$_COOKIE["PHPSESSID"];
		
		$addData['module'] = $module;
		$addData['ucode'] = $uid;
		$addData['recDate'] = date("Y-m-d h:i:s",time());
		$addData['ref'] = $referrer;
		$addData['uuid'] = $sid;
		$arr = $this->statistics_model->chk($sid);
		var_dump( $arr ); 
		if(null==$arr || ''==$arr['uuid']){
			$this->statistics_model->add( $addData );
		}
// 		echo $module;
// 		echo $uid;
		redirect('http://viewer.maka.im/pcviewer/A52CFW6Z');
	}
	
}