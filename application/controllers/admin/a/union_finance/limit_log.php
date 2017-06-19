<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since  2016-07-27
 * @author jiakairong
 * @method 信用额度查询
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Limit_log extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('admin/t33/b_limit_log_model' ,'limit_log_model');
		$this ->load_model('admin/t33/b_depart_model' ,'depart_model');
	}
	
	public function index()
	{
		$this->view ( 'admin/a/union_finance/limit_log');
	}
	//获取营业部额度数据
	public function getDepartQuota()
	{
		$whereArr = array();
		$union_name = trim($this ->input ->post('union_name'));
		$depart_name = trim($this ->input ->post('depart_name'));
		

		if (!empty($union_name))
		{
			$whereArr['union_name like '] = '%'.$union_name.'%';
		}
		if (!empty($depart_name))
		{
			$whereArr['name like'] = '%'.$depart_name.'%';
		}
		
		$data = $this ->depart_model ->getDepartQuotaData($whereArr);
		echo json_encode($data);
	}
	
	//营业部详细
	public function detail()
	{
		$id = intval($this ->input ->get('id'));
		$data = $this ->depart_model ->depart_detail($id);
		$this ->view('admin/a/union_finance/limit_log_detail' ,array('departData' =>$data));
	}
	//额度使用日志
	public function getLimitLogData()
	{
		$departId = intval($this ->input ->post('depart_id'));
		$ordersn = trim($this ->input ->post('ordersn' ,true));
		$starttime = trim($this ->input ->post('starttime' ,true));
		$endtime = trim($this ->input ->post('endtime' ,true));
		
		$whereArr = array(
				'log.depart_id =' =>$departId
		);
		
		if (!empty($ordersn))
		{
			$whereArr['log.order_sn ='] = $ordersn;
		}
		if (!empty($starttime))
		{
			$whereArr['log.addtime >='] = $starttime;
		}
		if (!empty($endtime))
		{
			$whereArr['log.addtime <='] = $endtime.' 23:59:59';
		}
		
		$data = $this ->limit_log_model ->getLimitLogData($whereArr);
		echo json_encode($data);
	}
}