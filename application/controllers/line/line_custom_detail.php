<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @author		汪晓烽
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Line_custom_detail extends UC_NL_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load_model ( 'line_custom_detail_model', 'custom_detail_model' );
	}
	public function index($cid=0) {
		//$cid = $this->input->get('icd');
		$postArr = array();
		$expert_line_res = array();
		$postArr['c.id']=$cid;
		$expert_line = $this->custom_detail_model->get_expert_line_data($cid);
		$custom_data = $this->custom_detail_model->get_custom_data($postArr);
		if(!empty($expert_line[0])){
			$expert_line_res = $expert_line[0];
		}else{
			echo "<script>alert('没有该条游记');location.href='".base_url('line/line_custom/index')."'</script>";
		}
		$data = array(
			'expert_line'=>$expert_line_res,
			'custom_data'=>$custom_data
			);
		$this->load->view ( 'line/line_custom_detail_view',$data);
	}
}