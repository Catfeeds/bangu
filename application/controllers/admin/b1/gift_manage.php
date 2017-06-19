<?php
/**
 * **
 * 深圳海外国际旅行社
 *
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Gift_manage extends UB1_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->database ();
		$this->load->helper ( 'form' );
		$this->load->helper ( array(
				'form', 
				'url' 
		) );
		$this->load->helper ( 'url' );
		$this->load->model ( 'admin/b1/gift_manage_model','gift_manage' );
		$this->load->model ( 'admin/b1/user_shop_model' );
		header ( "content-type:text/html;charset=utf-8" );
		
				
	}
	public function index() {
       		$where=' and ( g.status=0 or g.status=1 or g.status=2 )  ';
		$data['pageData'] = $this->gift_manage->get_gift_list(array(),$where,$this->getPage () );
		//echo $this->db->last_query();
		$this->load->view ( 'admin/b1/header.html' );
		$this->load->view ( 'admin/b1/gift_manage_last',$data);
		$this->load->view ( 'admin/b1/footer.html' );
	}

	public function indexData(){
		$where=' and ( g.status=0 or g.status=1 or g.status=2)  ';
		$endtime='';
		$param = $this->getParam(array('title'));
	         	if(isset($_POST['status'])){ 
	         		if(!empty($_POST['endtime1'])){
	         			$endtime=strtotime($_POST['endtime1']);
	         			$param['endtime']=$endtime;
	         		}    	
	        	 }
   
		$data  = $this->gift_manage->get_gift_list($param,$where,$this->getPage () );
		echo  $data ;
	}
	//已发放
	public function indexData0(){ 
		
		$endtime='';
		$param = $this->getParam(array('title'));
		if(isset($_POST['status'])){
			if(!empty($_POST['endtime2'])){
				$endtime=strtotime($_POST['endtime2']);
				$param['endtime']=$endtime;
			}
		} 
		$data  = $this->gift_manage->up_gift_data($param,$this->getPage () );
		echo  $data ;
	}
	
	//添加抽奖管理
	function addGift(){	
		$insert['gift_name']=$this->input->post('gift_name');
		$insert['starttime']=$this->input->post('startdatetime');
		$insert['endtime']=$this->input->post('enddatetime');
		$insert['account']=$this->input->post('account');
		$insert['worth']=$this->input->post('worth');
		$insert['logo']=$this->input->post('logo');
		$insert['description']=$this->input->post('description');
		$insert['modtime']=date('Y-m-d H:i:s');
		$supplier = $this->getLoginSupplier();
		$insert['supplier_id']=$supplier['id'];
		$gift_id=$this->input->post('gift_id');

		/*********************修改礼品 ************************/
		if($gift_id>0){
			$where=array(
					'id'=>$gift_id,
			);
			$re=$this->gift_manage->update_rowdata('luck_gift',$insert,$where);
			if($re){
				echo json_encode(array('status' => 2,'msg' =>'修改成功!','id'=>$gift_id));
				exit;
			}else{
				echo json_encode(array('status' => -2,'msg' =>'修改失败!'));
				exit;
			}
			/*********************添加礼品 ************************/
		}else{	
			$insert['addtime']=date('Y-m-d H:i:s');
			$insert['status']=0;
			$id=$this->gift_manage->insert_data('luck_gift',$insert);
			if($id>0){
				echo json_encode(array('status' => 1,'msg' =>'提交成功!','id'=>$id,'result'=>$insert));
				exit;
			}else{
				echo json_encode(array('status' => -1,'msg' =>'提交成败!','gift'=>$gift));
				exit;
			}
		}
	
	}
	
	//编辑礼品
	function editGift(){
		$gift_id=$this->input->post('id');
		if($gift_id>0){
			$giftArr=$this->user_shop_model->select_rowData('luck_gift',array('id'=>$gift_id));
			if(!empty($giftArr)){
				echo json_encode(array('status' => 1,'gift'=>$giftArr));
			}else{
				echo json_encode(array('status' => -1,'msg'=>'获取数据失败!'));
			}
		}else{
			echo json_encode(array('status' => -1,'msg'=>'获取数据失败!'));
		}
	}
	//编辑礼品
	function lookLineGift(){
		$gift_id=$this->input->post('id');
		$lineid=$this->input->post('line');

		if($gift_id>0){
			$giftArr=$this->gift_manage->get_line_gift($lineid,$gift_id);
		    	//会员中奖信息
			$memberArr=$this->gift_manage->get_gift_member($lineid,$gift_id);
			
			if(!empty($giftArr)){
				echo json_encode(array('status' => 1,'gift'=>$giftArr,'memberArr'=>$memberArr));
			}else{
				echo json_encode(array('status' => -1,'msg'=>'获取数据失败!'));
			}
	
		}else{
			echo json_encode(array('status' => -1,'msg'=>'获取数据失败!'));
		}
	}
	//上架,下架礼品
	function upGift(){
		$gift_id=$this->input->post('id');
		$status=$this->input->post('status');
		if($gift_id>0){
			$re=$this->user_shop_model->update_rowdata('luck_gift',array('status'=>$status),array('id'=>$gift_id));
			if($re){
				echo json_encode(array('status' => 1,'msg'=>'操作成功!'));
			}else{
				echo json_encode(array('status' => -1,'msg'=>'操作失败!'));
			}
		}else{
			echo json_encode(array('status' => -1,'msg'=>'操作失败!'));
		}
	}
	//删除礼品
	function delGift(){
		$gift_id=$this->input->post('id');
		if($gift_id>0){
			$re=$this->user_shop_model->update_rowdata('luck_gift',array('status'=>-1),array('id'=>$gift_id));
			if($re){
				echo json_encode(array('status' => 1,'msg'=>'操作成功!'));
			}else{
				echo json_encode(array('status' => -1,'msg'=>'操作失败!'));
			}
		}else{
			echo json_encode(array('status' => -1,'msg'=>'操作失败!'));
		}
	}
	//删除线路礼品
	function delLineGift(){
		$gift_id=$this->input->post('id');
		if($gift_id>0){
			$re=$this->user_shop_model->update_rowdata('luck_gift_line',array('status'=>-1),array('id'=>$gift_id));
			if($re){
				echo json_encode(array('status' => 1,'msg'=>'操作成功!'));
			}else{
				echo json_encode(array('status' => -1,'msg'=>'操作失败!'));
			}
		}else{
			echo json_encode(array('status' => -1,'msg'=>'操作失败!'));
		}
	}
}
