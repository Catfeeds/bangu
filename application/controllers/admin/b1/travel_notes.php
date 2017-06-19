<?php
/**
 * **
 * 深圳海外国际旅行社
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Travel_notes extends  UB1_Controller{
	public function __construct() {
		parent::__construct ();
		$this->load->helper ( array(
				'form', 
				'url' 
		) );
		$this->load->helper ( 'url' );
		$this->load->database ();
		
		$this->load->model ( 'admin/b1/travel_notes_model','travel' );
		header ( "content-type:text/html;charset=utf-8" );
	}
	public function index() {
		$supplier = $this->getLoginSupplier();
		$type=$this->input->get('type');
		if($type==1){
			$where="line_id in( SELECT id from u_line as l where l.supplier_id=".$supplier['id']." ) AND TIMESTAMPDIFF(HOUR,modtime, NOW()) < 48 AND isread = 0 and usertype = 0";
			$this->travel->update_teval_read(array('s_isread'=>1),$where);
		}
		// 结算
		$data['pageData'] = $this->travel->get_travel_data(null,$this->getPage () );
		$data['pageData1'] = $this->travel->get_over_travel(null,$this->getPage () );
		$this->load->view ( 'admin/b1/header.html' );
		$this->load->view ( "admin/b1/travel_notes_last", $data );
		$this->load->view ( 'admin/b1/footer.html' );

	}
	/*结算管理未结算的分页查询*/
	public function indexData(){
		$param =$this->getParam(array('line_name'));	
		//时间查询	
		$line_time=$this->getParam(array('time'));
		
		if(isset($line_time['time'])&&!empty($line_time['time']) ){
			$param['startdatetime'] =trim(substr(trim($line_time['time']),0,10));
			$arr=explode('-', $param['startdatetime']);
			$param['startdatetime']=$arr[0].'-'.$arr[2].'-'.$arr[1];
			$param['enddatetime'] = trim(substr(trim($line_time['time']),12));
			$arr1=explode('-', $param['enddatetime']);
			$param['enddatetime']=$arr1[0].'-'.$arr1[2].'-'.$arr1[1];
		}
		$data = $this->travel->get_travel_data( $param, $this->getPage () );
		echo  $data ; 
	}
	/*结算管理已结算的分页查询*/
	public function indexData1(){
		$param =$this->getParam(array('line_name'));
		//时间查询
		$line_time=$this->getParam(array('time'));
		if(isset($line_time['time'])&&!empty($line_time['time']) ){
			$param['startdatetime'] =trim(substr(trim($line_time['time']),0,10));
			$arr=explode('-', $param['startdatetime']);
			$param['startdatetime']=$arr[0].'-'.$arr[2].'-'.$arr[1];
			$param['enddatetime'] = trim(substr(trim($line_time['time']),12));
			$arr1=explode('-', $param['enddatetime']);
			$param['enddatetime']=$arr1[0].'-'.$arr1[2].'-'.$arr1[1];
		}
		$data = $this->travel->get_over_travel( $param, $this->getPage () );
		echo  $data ;
	}

	//申诉
	public function replay(){
		//启用session
		$this->load->library ( 'session' );
		$session_data = $this->session->userdata ( 'loginSupplier' );
		
		if(!empty($session_data['id'])){
			$supplier_id=$session_data['id'];
		}
		//申诉理由
		$season=$this->input->post('reason');
		$travel_note_id=$this->input->post('travel_note_id');	
		$insert_data=array(
			'travel_note_id'=>$travel_note_id,
			'supplier_id'=>$supplier_id,
			'reason'=>$season,
			'addtime'=>date("Y-m-d h:i:s",time()),
			'status'=>0	
		);
		//游记申诉
		$this->travel->insert_data('travel_note_complain',$insert_data);
		//申诉游记
		$this->travel->update_teval_read(array('is_show'=>1,'status'=>2),array('id'=>$travel_note_id));
		//申诉后发消息个客户
		if(is_numeric($travel_note_id)){
			$travel_note=$this->travel->select_rowData('travel_note',array('id'=>$travel_note_id));
			$title='供应商已经申诉'.'游记标题:'.$travel_note['title'];
			if(!empty($travel_note['userid'])){    
				$this->add_message($title,'0',$travel_note['userid']);
			}
		}
		
		redirect('admin/b1/travel_notes');
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
