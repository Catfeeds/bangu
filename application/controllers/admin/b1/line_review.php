<?php 
/****
 * 深圳海外国际旅行社
* 艾瑞可
* 2015-3-18
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Line_review extends UB1_Controller {

	function __construct(){
		//$this->need_login = true;
		parent::__construct();
		//$this->load->helper("url");
		$this->load->database();
		$this->load->model('admin/b1/line_review_model','line_review');
		$this->load->helper('url');
		header ( "content-type:text/html;charset=utf-8" );
			
}
	public function index()
	{

		$page = $this->getPage ();
		$data['pageData'] = $this->line_review->get_line_comment(null,$page );
	//	echo $this->db->last_query();exit;
		$this->load->view('admin/b1/header.html');
		$this->load->view('admin/b1/line_review_last',$data);
		$this->load->view('admin/b1/footer.html');
	}	
	/*投诉维权的分页查询*/
	public function indexData(){
		$param = $this->getParam(array('productname'));
		$data = $this->line_review->get_line_comment( $param , $this->getPage () );
		
		echo  $data ;
	}
	//评论的回复
	public function reply(){	
		//启用session
		$this->load->library ( 'session' );
		$session_data = $this->session->userdata ( 'loginSupplier' );
		
		if(!empty($session_data['id'])){
			$supplier_id=$session_data['id'];
		}
		$id=$this->input->post('reply_comment_id');
		$season=$this->input->post('reason');
		$insert_data=array(		
				'reply1'=>$season,	
		);
	
		if(is_numeric($id)){
		      $re=$this->line_review->update_data('u_comment',$insert_data,array('id'=>$id));
		      if($re){
		          echo json_encode(array('status' =>1,'msg' =>'提交成功'));
		          exit;
		      }else{
		          echo json_encode(array('status' =>-1,'msg' =>'提交失败'));
		          exit;
		      }
		}else{
		    echo json_encode(array('status' =>-1,'msg' =>'提交失败'));
	     	exit;
		}
		
	}
	//申诉
	public function insert_appeal(){
		//启用session
		$this->load->library ( 'session' );
		$session_data = $this->session->userdata ( 'loginSupplier' );
		
		if(!empty($session_data['id'])){
			$supplier_id=$session_data['id'];
		}
		
		$appeal_reason=$this->input->post('appeal_reason');
		if(empty($appeal_reason)){
		    echo json_encode(array('status' =>-1,'msg' =>'申诉内容不能为空'));
		    exit;
		}
		$comment_id=$this->input->post('comment_id');	
		$insert_data=array(
				'comment_id'=>$comment_id,
				'supplier_id'=>$supplier_id,
				'reason'=>$appeal_reason,
				'addtime'=>date("Y-m-d h:i:s",time()),
				'status'=>0	
		);

		$re=$this->line_review->insert_data('u_comment_complain',$insert_data);
		if($re){
		    echo json_encode(array('status' =>1,'msg' =>'提交成功'));
		    exit;
		}else{
		    echo json_encode(array('status' =>-1,'msg' =>'提交失败'));
		    exit;
		}
		
	}
	//回复
	function get_review(){
		$id=$this->input->post('id',true);
		$comment='';
		if($id>0){
		     	$commentData=$this->line_review->all(array('id'=>$id));
		     	if(!empty($commentData)){
		     		$comment=$commentData[0];
		     	}
		}
	   	echo json_encode(array('status' =>1,'res' =>$comment));
	     	exit;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */