<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since 2015年3月20日11:59:53
 * @author 何俊       
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Line extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load->model ( 'admin/b1/user_shop_model' );
	}
	
	
	public function getProductPriceJSON(){
		$lineId = $this->get("lineId");
		$suitId = $this->get("suitId");
		$startDate = $this->get("startDate");
		$productPrice = "[]";
		$this->load->model ( 'admin/b1/user_shop_model' );
		if(null!=$suitId && ""!=$suitId){
			$productPrice = $this->user_shop_model->getProductPriceByProductId($lineId,$suitId,$startDate);
		}
		echo $productPrice;
	}
	public function switchover_desc(){
		$lineId=$this->input->post('suitId');
		$this->load->model ( 'admin/b1/user_shop_model' );
		$data['suits'] = $this->user_shop_model->select_rowData('u_line_suit',array('id'=>$lineId));
		echo json_encode($data['suits']);
	}
}