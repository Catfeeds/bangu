<?php
/**
 * 单项预定
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年7月28日15:05:11
 * @author		汪晓烽
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reserve extends UB2_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load_model('admin/b2/pre_order_model', 'pre_order');
		$this->load_model('line_model');
		$this->load_model('expert_model');
	}

	public function index()
	{
		$account = $this->pre_order->get_all_limit();
		$data = array(
				'account'=>$account,
				'expertId' =>$this ->expert_id
			);
		$this->view('admin/b2/reserve_view',$data);
	}

	public function getReserveJson()
	{
		$expertData = $this ->expert_model ->row(array('id' =>$this ->expert_id));
		
		$whereArr = array(
				'l.line_kind >' =>1,
				'l.status =' =>2,
				'lsp.day >=' =>date('Y-m-d'),
				'lsp.number >=' =>1
		);
		
		$linename = trim($this ->input ->post('linename' ,true));
		$linecode = trim($this ->input ->post('linecode' ,true));
		$starttime = trim($this ->input ->post('starttime' ,true));
		$endtime = trim($this ->input ->post('endtime' ,true));
		$start_price = trim($this ->input ->post('start_price' ,true));
		$end_price = trim($this ->input ->post('end_price' ,true));
		$startcity = trim($this ->input ->post('start_place' ,true));
		$startcityId = intval($this ->input ->post('start_place_id'));
		//$destid = intval($this ->input ->post('destid'));
		
		if (!empty($linename))
		{
			$whereArr['l.linename like '] = '%'.$linename.'%';
		}
		if (!empty($linecode))
		{
			$whereArr['l.linecode like '] = '%'.$linecode.'%';
		}
		
		if (!empty($starttime))
		{
			$whereArr['lsp.day >='] = $starttime;
		}
		if (!empty($endtime))
		{
			$whereArr['lsp.day <='] = $endtime;
		}
		if (!empty($start_price))
		{
			$whereArr['lsp.adultprice >='] = $start_price;
		}
		if (!empty($end_price))
		{
			$whereArr['lsp.adultprice <='] = $end_price;
		}
		if (!empty($startcityId))
		{
			$whereArr['ls.startplace_id ='] = $startcityId;
		} 
		elseif (!empty($startcity))
		{
			$whereArr['sp.cityname like '] = '%'.$startcity.'%';
		}
// 		if (!empty($destid))
// 		{
// 			$whereArr['d.id ='] = $destid;
// 		}
		
		//(sa.sell_object=208 or (sa.sell_object=-1 and sa.union_id=16))
		//$specialSql = ' (sa.sell_object='.$this->expert_id.' or sa.union_id='.$expertData['union_id'].') ';
		$specialSql = ' (sa.sell_object='.$this->expert_id.' or (sa.sell_object=-1 and sa.union_id='.$expertData['union_id'].')) ';
		$data = $this ->line_model ->getLineReserve($whereArr ,'lsp.dayid desc' ,$specialSql);
		//echo $this ->db ->last_query();exit;
		echo json_encode($data);
	}
}