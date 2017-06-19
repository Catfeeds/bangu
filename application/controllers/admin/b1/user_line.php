<?php 
/****
 * 深圳海外国际旅行社
* 艾瑞可
* 2015-3-18
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_line extends UB1_Controller {

	function __construct(){
		//$this->need_login = true;
		parent::__construct();
		//$this->load->helper("url");
		$this->load->database();
		$this->load->model('admin/b1/user_line_model');
		$this->load->helper('url');
		header ( "content-type:text/html;charset=utf-8" );
			
}
	public function index()
	{
		//启用session
		$this->load->library ( 'session' );
		$session_data = $this->session->userdata ( 'loginSupplier' );
		
		if(!empty($session_data['id'])){
			$param['supplier_id']=$session_data['id'];
		}

		$page = $this->getPage ();
		$data['pageData'] = $this->user_line_model->get_user_line($param,$page );
		//echo $this->db->last_query();
		$this->load->view('admin/b1/header.html');
		$this->load->view('admin/b1/user_line_last',$data);
		$this->load->view('admin/b1/footer.html');
	}	
	/*投诉维权的分页查询*/
	public function indexData(){
		$param = $this->getParam(array('productname','truename','status'));
		//启用session
		$this->load->library ( 'session' );
		$session_data = $this->session->userdata ( 'loginSupplier' );
		
		if(!empty($session_data['id'])){
			$param['supplier_id']=$session_data['id'];
		}
		 
		$data = $this->user_line_model->get_user_line( $param , $this->getPage () );
		//echo $this->db->last_query();
		echo  $data ;
	}
	/*投诉回复内容*/
	public function insert_replay(){
		$complain_id=$this->input->post('complain_id');
		$replay=$this->input->post('replay');
	
		if(is_numeric($complain_id)){
			$this->user_line_model->insert_replay('u_complain',array('supplier_reply'=>$replay),array('id'=>$complain_id));
			echo  '<script>alert("回复成功！");window.location.href="/admin/b1/user_line"</script> ';
		}else{
		   echo  '<script>alert("回复失败！");window.location.href="/admin/b1/user_line"</script> ';
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */