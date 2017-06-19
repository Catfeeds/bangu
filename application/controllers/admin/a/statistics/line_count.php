<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016-02-26
 * @author		jiakairong
 * @method 		统计始发地的线路数量
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Line_count extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model('admin/a/statistics_model','statistics_model');
	}
	public function index()
	{
		$whereArr = array(
			'l.status =' =>2,
			//'l.producttype =' =>0,
			's.level =' =>3,
			'l.line_kind =' =>1
		);
		$data['countArr'] = $this ->statistics_model ->getStartCityLineCount($whereArr);
		$this ->view('admin/a/statistics/line_count' ,$data);
	}
	public function getSearchJson()
	{
		$whereArr = array(
				'l.status =' =>2,
				's.level =' =>3,
				//'l.producttype =' =>0,
				'l.line_kind =' =>1
		);
		$city = intval($this ->input ->post('city'));
		$province = intval($this ->input ->post('province'));
		$type = intval($this ->input ->post('type'));
		$data = array();
		if (!empty($city))
		{
			$whereArr['s.id ='] = $city;
		}
		elseif(!empty($province))
		{
			$whereArr['s.pid ='] = $province;
		}
		if ($type == 1)
		{
			$data = $this ->statistics_model ->getStartCityLineCount($whereArr);
		}
		elseif ($type == 2)
		{
			$dataArr = $this ->statistics_model ->getStartProvinceLineCount($whereArr);
			//echo $this ->db ->last_query();exit;
			$countArr = array();
			foreach($dataArr as $v)
			{
				$countArr[$v['name']][$v['lineid']] = $v;
			}
			foreach($countArr as $key =>$val)
			{
				$data[] = array(
						'count' =>count($val),
						'name' =>$key
				); 
			}
		}
		elseif ($type == 3) 
		{
			//全国出发
			$countArr = $this ->statistics_model ->getCountryLineCount();
			$data[] = array(
					'count' =>$countArr[0]['count'],
					'name' =>'全国出发'
			);
		}
		echo json_encode($data);
	}
}