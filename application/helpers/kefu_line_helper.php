<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/*
 * kefu_url
 * @功能：b2客服kefu_url_line
 * @param unknown $expertId
 * @param unknown $expert_LoginName
 * @return string
 */
if (! function_exists ( 'kefu_url_line' )) {
		function kefu_url_line($memberId="",$lineId="",$action="0"){
			$this->load->library("curl");
			$b2_one_data=$this->curl->simple_get("http://bangu.com/kefu_webservices/get_b2_one_data?lineid=".$lineId);
			$b2_one_dataArr=json_decode($b2_one_data, true);
			$expertId=$b2_one_dataArr[0]['id'];
			return base_url()."kefu?member_id=$memberId&expert_id=$expertId&action=$action";
		}
}
/* End of file kefu_line_helper.php */