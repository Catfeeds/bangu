<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since  2016-07-27
 * @author jiakairong
 * @method 旅行社佣金结算管理
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Union_agent_sel extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('union_model' ,'union_model');
	}
	
	public function index()
	{
		$this->view ( 'admin/a/union_finance/union_agent_sel');
	}
	//获取佣金结算数据
	public function getUnionAgentJson()
	{
		$whereArr = array();
		$union_name = trim($this ->input ->post('union_name' ,true));
		
		if (!empty($union_name))
		{
			$whereArr['u.union_name like '] = '%'.$union_name.'%';
		}
		
		$data = $this ->union_model ->getUnionData($whereArr);
		//echo $this ->db ->last_query();exit;
		echo json_encode($data);
	}
	
	//结算单详细
	public function detail()
	{
		$id = intval($this ->input ->get('id'));
		$unionArr = $this ->union_model ->row(array('id' =>$id));
		$this ->view('admin/a/union_finance/union_agent_detail' ,array('unionArr' =>$unionArr));
	}
	//结算订单明细
	public function getAgentOrder()
	{
		$unionId = intval($this ->input ->post('detail_id'));
		
		$whereArr = array(
				'mo.platform_id =' =>$unionId,
				'mo.status >=' =>4
		);
		$data = $this ->union_model ->getUnionOrderData($whereArr);
		echo json_encode($data);
	}

}