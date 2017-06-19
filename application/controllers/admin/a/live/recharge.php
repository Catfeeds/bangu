<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016-05-24
 * @author		jiakairong
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Recharge extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model('live/live_recharge_model','rechargeModel');
	}
	
	public function index()
	{
		$this ->view('admin/a/live/recharge');
	}
	//充值数据
	public function getRechargeJson()
	{
		$whereArr = array('r.status' =>1);
		$name = trim($this ->input ->post('name' ,true));
		$starttime = trim($this ->input ->post('starttime' ,true));
		$endtime = trim($this ->input ->post('endtime' ,true));
		if (!empty($name))
		{
			$whereArr['like'] = array('a.name' =>'%'.$name.'%');
		}
		if (!empty($starttime))
		{
			$whereArr['r.addtime >'] = $starttime;
		}
		if (!empty($endtime))
		{
			$whereArr['r.addtime <'] = $endtime.' 23:59:59';
		}
		$data = $this ->rechargeModel ->getRechargeData($whereArr);
		//var_dump($this ->rechargeModel ->db ->queries);
		$count = $this ->rechargeModel ->getRechargeCount($whereArr);
		echo json_encode(array('data' =>$data ,'count' =>$count['count']));
	}
}