<?php
/**
 * **
 * 深圳海外国际旅行社
 * 艾瑞可
 * 2015-3-18
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class View extends UB1_Controller {
	function __construct() {
		// $this->need_login = true;
		parent::__construct ();
		// $this->load->helper("url");
		$this->load->database ();
		$this->load->helper ( 'form' );
		$this->load->helper ( array(
				'form', 
				'url' 
		) );
		$this->load->helper ( 'url' );
		$this->load->model ( 'admin/b1/view_model','view' );
		header ( "content-type:text/html;charset=utf-8" );
		
				
	}
	public function index(){
                  $supplier = $this->getLoginSupplier();
                  //企业信息
                  $data['supplier']=$this->view->select_rowData('u_supplier',array('id'=>$supplier['id']));
                  $data['logindatetime']=$supplier['logindatetime'];
                  //统计信息
                  $data['statistics']=$this->view->statistics($supplier['id']);
                  // echo $this->db->last_query();                                        //订单动态 
                  $data['order_status']=$this->view->select_data('cfg_status_definition',array('type'=>2));
                  // echo $this->db->last_query();
                  //动态监控
                  $data['orderName']=$this->view->orderName();
           
                  //$data['dynamic']=$this->view->dynamic($supplier['id']);
                  $data['dynamic'][0]=$this->view->order_cancel($supplier['id']); //订单已取消
                  $data['dynamic'][1]=$this->view->order_refund($supplier['id']); // 平台已退款
                  $data['dynamic'][2]=$this->view->order_c_refund($supplier['id']); // 客人申请退款
                  $data['dynamic'][3]=$this->view->order_b2_refund($supplier['id']); // 管家申请退款

                  $data['dynamic'][4]=$this->view->order_confirm_order($supplier['id']); // 待确认订单
                  $data['dynamic'][5]=$this->view->order_leave_order($supplier['id']); // 待留位订单
                  
                  $data['dynamic'][6]=$this->view->order_c_comment($supplier['id']); // 订单评论
                  $data['dynamic'][7]=$this->view->order_c_complain($supplier['id']); //  客人已投诉
                  $data['dynamic'][8]=$this->view->order_c_experience($supplier['id']); // 客人发体验
                      
                  //定制单动态 
                  $data['custom']=$this->view->custom($supplier['id']);
                  //产品动态 
                  $data['line']=$this->view->line_data($supplier['id']);
                  // echo $this->db->last_query();
                  // 管家统计
                  $data['expert']=$this->view->expert_list($supplier['id']);
                  //管家动态
                  $data['expert_dynamic']=$this->view->expert_dynamic($supplier['id']);
                  //平台公布
                  $data['platform']=$this->view->platform_publish($supplier['id']);
               /*    //消息通知
                  $this->get_order_msg(); */
	              $this->load->view ( 'admin/b1/header.html' );
	              $this->load->view ( 'admin/b1/view',$data);
	              $this->load->view ( 'admin/b1/footer.html' );
	}
	
}