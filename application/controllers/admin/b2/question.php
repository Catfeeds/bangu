<?php
/**
 * 客人问答
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月17日11:59:53
 * @author		徐鹏
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Question extends UB2_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library ( 'callback' );
		$this->load_model('admin/b2/question_model', 'question');
	}

	/**
	 * 客人问答  列表
	 *
	 * @param number $page	页
	 */
	public function index($page = 1) {
		$this->load->helper ( 'MY_text' );
		$this->load->library('Page');
		$config['base_url'] = '/admin/b2/question/index/';
		$config['pagesize'] = 15;
		$config['page_now'] = $this->uri->segment(5,0);
		$page = $page==0 ? 1:$page;
		$post_arr = array();
		 if($this->uri->segment (5)!=''){
			# 产品名称
			if ($this->session->userdata('linename') != '') {
				$post_arr['l.linename LIKE'] = '%' . $this->session->userdata('linename') . '%';
			}
		}else{
			unset($post_arr['l.linename LIKE']);
			$this->session->unset_userdata('linename');
		}
		# 搜索表单提交
		if ($this->is_post_mode()) {
			if ($this->input->post('linename') != '') {
				$post_arr['l.linename LIKE'] = '%'.$this->input->post('linename').'%';
				$this->session->set_userdata(array('linename' => $this->input->post('linename')));
			}else{
				unset($post_arr['l.linename LIKE']);
				$this->session->unset_userdata('linename');
			}
		}
		$post_arr['que.reply_id'] = $this->expert_id;
		$post_arr['que.reply_type'] = 1;
		$post_arr['isnull(que.replytime)']=0;
		$config['pagecount'] = $this->question->get_expert_questions($post_arr, 0);
		//$this->pagination->initialize($config);
		$this->page->initialize($config);
		$question_list = $this->question->get_expert_questions($post_arr, $page, $config['pagesize']);
       //print_r($this->db->last_query());exit();
		$this->load_view('admin/b2/question', array(
				'question_list' => $question_list,
				'linename' => $this->session->userdata('linename')
				));
	}

	/*未回复*/
	public function no_answer($page = 1) {
		$this->load->helper ( 'MY_text' );
		$this->load_model('admin/b2/question_model', 'question');
		$this->load->library('Page');
		$config['base_url'] = '/admin/b2/question/no_answer/';
		$config['pagesize'] = 15;
		$config['page_now'] = $this->uri->segment(5,0);
		$page = $page==0 ? 1:$page;
		$post_arr = array();
		if($this->uri->segment (5)!=''){
			# 产品名称
			if ($this->session->userdata('linename') != '') {
				$post_arr['l.linename LIKE'] = '%' . $this->session->userdata('linename') . '%';
			}
		}else{
			unset($post_arr['l.linename LIKE']);
			$this->session->unset_userdata('linename');
		}
		# 搜索表单提交
		if ($this->is_post_mode()) {
		if ($this->input->post('linename') != '') {
		$post_arr['l.linename LIKE'] = '%'.$this->input->post('linename').'%';
		$this->session->set_userdata(array('linename' => $this->input->post('linename')));
			}else{
		unset($post_arr['l.linename LIKE']);
				$this->session->unset_userdata('linename');
			}
		}
		//$post_arr['la.expert_id'] = $this->expert_id;

		//$post_arr['or reply_id'] = $this->expert_id;
		//$post_arr['isnull(que.replytime)>']=0;
		//$post_arr['reply_id'] = 0;
		$config['pagecount'] = $this->question->get_expert_noquestions($post_arr, 0,10,$this->expert_id);
			//$this->pagination->initialize($config);
		$this->page->initialize($config);
		$question_list = $this->question->get_expert_noquestions($post_arr, $page, $config['pagesize'],$this->expert_id);
		//print_r($this->db->last_query());exit();
		$this->load_view('admin/b2/question_n', array(
				'question_list' => $question_list,
					'linename' => $this->session->userdata('linename')
					));
	}


	/**
	 * 回复客户问题
	 */
	public function reply() {

	 //UPDATE u_line_question SET replycontent = '不需要',reply_type = 1,reply_id = 1 WHERE id = 3;
	 $question_id = $this->input->post('question_id');
	 $question_content = $this->input->post('question_content');
	 $question_email = $this->input->post('question_email');
	 $reply_content = $this->input->post('reply_content');

	// $sql = "UPDATE u_line_question SET replycontent ='$reply_content',replytime=now(),reply_type = 1,reply_id = $this->expert_id WHERE id = $question_id";
	 if($this->question->reply_question($reply_content,$this->expert_id,$question_id)){
	 		//$this->send_email($question_email,$question_content,$reply_content);
	 		$this->callback->set_code ( 200 ,"回复成功");
			$this->callback->exit_json();
	 }else{
	 	$this->callback->set_code ( 400 ,"回复失败");
		$this->callback->exit_json();
	 }


	}

	function send_email($email,$question,$replycontent){
		$email_content = "<font color='blue'>您的问题是:</font> $question</br><font color='green'>管家回复:</font> $replycontent";
	$this->load->library('email');            //加载CI的email类

	        //以下设置Email参数
	        $config['protocol'] = 'smtp';
	        $config['smtp_host'] = 'smtp.exmail.qq.com';
	        $config['smtp_user'] = 'service@1b1u.net';
	        $config['smtp_pass'] = 'bangu0508';
	        $config['smtp_port'] = '25';
	        $config['charset'] = 'utf-8';
	        $config['wordwrap'] = TRUE;
	        $config['validate'] = TRUE;
	        $config['mailtype'] = 'html';
	        $config['crlf']="\r\n";
	         $config['newline']="\r\n";
	         //$this->load->library('email');
	        $this->email->initialize($config);

	        //以下设置Email内容
	        $this->email->from('service@1b1u.net', '帮游旅行网');
	        $this->email->to($email);
	        $this->email->subject('管家回复您的提问');
	        $this->email->message($email_content);
	        //$this->email->attach('application\controllers\1.jpeg');           //相对于index.php的路径

	        return  $this->email->send();

	}
}