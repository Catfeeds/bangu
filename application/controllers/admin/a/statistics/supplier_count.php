<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016-02-26
 * @author		jiakairong
 * @method 		统计地区的供应商数量
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Supplier_count extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model('admin/a/statistics_model','statistics_model');
	}
	public function index()
	{
		$whereArr = array(
			's.status =' =>2,
			'a.level =' =>3
		);
		$data['countArr'] = $this ->statistics_model ->getAreaSupplierCount($whereArr);
		$this ->view('admin/a/statistics/supplier_count' ,$data);
	}
	public function getSearchJson()
	{
		$whereArr = array(
				's.status =' =>2,
				'a.level =' =>3
		);
		$city = intval($this ->input ->post('city'));
		$province = intval($this ->input ->post('province'));
		if (!empty($city))
		{
			$whereArr['a.id ='] = $city;
		}
		elseif(!empty($province))
		{
			$whereArr['a.pid ='] = $province;
		}
		$data = $this ->statistics_model ->getAreaSupplierCount($whereArr);
		echo json_encode($data);
	}
}