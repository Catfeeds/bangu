<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/*
 * kefu_url
 * @功能：b2客服url
 * @param unknown $expertId
 * @param unknown $expert_LoginName
 * @return string
 */
if (! function_exists ( 'kefu_url' )) {
	function kefu_url( $memberId = "",$expertId = "",$action=0) {
		$CI = & get_instance();
		$CI->load->model ( 'common/cfg_web_model','cfg_web_model');
		$whereArr=array('id'=>'1');
		$kefu_url=$CI->cfg_web_model->row($whereArr);
		if($action==0){
			return $kefu_url['expert_question_url']."/kefu_member.html?mid=$memberId&eid=$expertId";
		}else if($action==1){
			return $kefu_url['expert_question_url']."kefu_expert.html?mid=$memberId&eid=$expertId";
		}
		
	}
}
/* End of file kefu_helper.php */