<?php 
/****
 * 深圳海外国际旅行社
* 艾瑞可
* 2015-3-18
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_date extends UB1_Controller {

	function __construct(){
		//$this->need_login = true;
		parent::__construct();
		//$this->load->helper("url");
		$this->load->database();
		$this->load->model('admin/b1/order_status_model','order');
		$this->load->helper('url');
		header ( "content-type:text/html;charset=utf-8" );
			
}
	public function index()
	{
		

		$page = $this->getPage ();

		$data['pageData'] = $this->order->return_order_suit(array('status'=>0),$page );
		//echo $this->db->last_query();
		$this->load->view('admin/b1/header.html');
		$this->load->view('admin/b1/order_date',$data);
		$this->load->view('admin/b1/footer.html');
	}	
	
	function indexData(){
		$page = $this->getPage ();

                     $param = $this->getParam(array('status','ordersn','linecode','linename'));
		$data = $this->order->return_order_suit ( $param , $page);
			
		echo  $data ;
	}
	/*转订单订单*/
	public function return_order_date(){
                         $orderid=$this->input->post('id',true);
                         $supplier = $this->getLoginSupplier();
                         if($orderid>0){
                         	   //订单信息
                                   $price=$this->order->sel_data('u_member_order',array('id'=>$orderid));

                                    //转团记录表
                                    $diffData=$this->order->sel_data('u_member_order_diff',array('order_id'=>$orderid,'status'=>0));

  		              //套餐
                                    $suitData=$this->order->sel_data('u_line_suit',array('id'=>$price['suitid']));

                                    //库存
                                    if($suitData['unit']>1){
                                            $order_people=$price['suitnum'];
                                    }else{
 			 	  $order_people=$price['childnum']+$price['dingnum']+$price['oldnum']+$price['childnobednum'];
                                    }
                   
	                        $number= $this->order->get_line_suit(array('sp.dayid'=>$diffData['days_id']));

		             $num_date=$number['number'];
			if(!empty($order_people)){      //减少库存
				$num_date=$number['number']-$order_people;	
				if($num_date<0){
                                                                  echo  json_encode(array('status'=>-1,'msg'=>'该线路的套餐库存不足'));
                                                                  exit;
				}else{
					$re= $this->order->return_orderSiutDate($price,$orderid,$diffData,$suitData);
					if($re){
                                                                    
				                   $content='供应商已确认您的订单转团,订单编号:'.$price['ordersn'].',出发时间:'.$price['usedate'];
					       //订单日记
					        $this->order->order_log($price['id'], $content,$supplier['id'],$price['status']);

					        //发短信通知
		 			        $this->get_code( $orderid,1);
 					        echo  json_encode(array('status'=>1,'msg'=>'操作成功!'));
					}else{
					         echo  json_encode(array('status'=>-1,'msg'=>'操作失败!'));	
					}
				}			
			}else{
				 echo  json_encode(array('status'=>-1,'msg'=>'没有出游人!'));	
			}

                         }else{
                         	           echo  json_encode(array('status'=>-1,'msg'=>'操作失败!'));
                         }
	}
            
	/*拒绝*/
	function   dis_order_date(){
		 $id=$this->input->post('id',true);
		 // 拒绝操作
		 $orderid=$this->input->post('orderid',true);
		 $re=$this->order->update_tabledata('u_member_order_diff',array('status'=>2), array('id'=>$id)) ;
		 if($re){
		 	$this->order->update_tabledata('u_member_order',array('trun_status'=>0), array('id'=>$orderid)) ;
		 	//发短信
		 	$this->get_code( $orderid,-1);
                                       echo  json_encode(array('status'=>1,'msg'=>'操作成功!'));
		 }else{ 
		              echo  json_encode(array('status'=>-1,'msg'=>'操作失败!'));	
		 }

	}
	//发短信
	public function get_code ($orderid,$type,$Arr=array()) {
		//$this->load->library ( 'callback' );
		if($orderid>0){         
			//订单信息      
                                      $orderData=$this->order->sel_data('u_member_order',array('id'=>$orderid));
		             if($type==-1){   //拒绝申请短信

		                    //发信息给管家
	                        	       $this->load->model ( 'sms_template_model' ,'sms_model' );
			       $template = $this ->sms_model ->row(array('msgtype' =>'trun_order_expert_refuse'));
			       $template = $template ['msg'];
			       $content = str_replace("{#ORDERSN#}", $orderData['ordersn'] ,$template); 
			      //var_dump( $content );

                                             //管家电话
                                             $expertData=$this->order->sel_data('u_expert',array('id'=>$orderData['expert_id']));
                                             $this ->send_message($expertData['mobile'] ,$content);  //发短信

                                             //发信息给用户
                                              $template = $this ->sms_model ->row(array('msgtype' =>'trun_order_member_refuse'));
                                              $template = $template ['msg'];
			       $content = str_replace("{#ORDERSN#}", $orderData['ordersn'] ,$template); 
			       //用户电话       
			        $memberData=$this->order->sel_data('u_member',array('mid'=>$orderData['memberid']));
			       $this ->send_message($memberData['mobile'] ,$content);  //发短信

	                         }else{      //通过申请短信

                                              //发信息给管家
	                        	       $this->load->model ( 'sms_template_model' ,'sms_model' );
			       $template = $this ->sms_model ->row(array('msgtype' =>'trun_order_expert_agree'));
			       $template = $template ['msg'];
			       $content = str_replace("{#ORDERSN#}", $orderData['ordersn'] ,$template); 
			       $content = str_replace("{#DAYS#}", $orderData['usedate'] ,$content);

                                             //管家电话
                                             $expertData=$this->order->sel_data('u_expert',array('id'=>$orderData['expert_id']));
                                             $this ->send_message($expertData['mobile'] ,$content);  //发短信

                                              //发信息给用户
                                              $template = $this ->sms_model ->row(array('msgtype' =>'trun_order_member_agree'));
                                              $template = $template ['msg'];
			        $content = str_replace("{#ORDERSN#}", $orderData['ordersn'] ,$template); 
			        $content = str_replace("{#DAYS#}", $orderData['usedate'] ,$content);
			       //用户电话       
			        $memberData=$this->order->sel_data('u_member',array('mid'=>$orderData['memberid']));
			       $this ->send_message($memberData['mobile'] ,$content);  //发短信

	                         }
			
			
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
