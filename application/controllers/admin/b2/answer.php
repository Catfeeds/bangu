<?php
/**
 * 专家答题
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月19日17:05:11
 * @author		徐鹏
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Answer extends UB2_Controller {

	public function __construct() {
		parent::__construct();

		$this->load_model('admin/b2/answer_model', 'answer');
	}
	
	function index($id) {
		echo  $id;exit();
		$answers_list = $this->answer->get_line_apply_answers(array(
				'paper_dest_id' => $id,
				'expert_id' => $this->expert_id));
		
		$this->load_self_view('b2/answer', array('answers_list' => $answers_list));
	}
}