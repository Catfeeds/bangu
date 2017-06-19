<?php
/**
 * 单项预定
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年7月28日15:05:11
 * @author		汪晓烽
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group_line extends UB2_Controller
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

		$depart_id=$this->session->userdata('depart_id');
		if(!empty($depart_id)){
			$account = $this->pre_order->get_all_limit();
			$data = array(
				'account'=>$account,
				'expertId' =>$this ->expert_id,
				'is_manage'=>$this->session->userdata('is_manage')
			);
			$this->view('admin/b2/group_line_view',$data);
			
		}else{
			echo '该销售人员没有营业部';
		}
		
		
	}

	public function getReserveJson()
	{
		$expertData = $this ->expert_model ->row(array('id' =>$this ->expert_id));
		
		$whereArr = array(
				//'l.line_kind =' =>2,
				'l.producttype =' =>1,
				'lsp.day >=' =>date('Y-m-d')
				//'lsp.number >=' =>1
		);
		$line_item=trim($this ->input ->post('line_item' ,true));
		$linename = trim($this ->input ->post('linename' ,true));
		$linecode = trim($this ->input ->post('linecode' ,true));
		$starttime = trim($this ->input ->post('starttime' ,true));
		$endtime = trim($this ->input ->post('endtime' ,true));
		$start_price = trim($this ->input ->post('start_price' ,true));
		$end_price = trim($this ->input ->post('end_price' ,true));
		$startcity = trim($this ->input ->post('start_place' ,true));
		$startcityId = intval($this ->input ->post('start_place_id'));
		//$destid = intval($this ->input ->post('destid'));
		if(!empty($line_item)){
			$whereArr['lsp.description ='] = $line_item;
		}
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
		$cityid='';
		if (!empty($startcityId))
		{
			//$whereArr['ls.startplace_id ='] = $startcityId;
			//$whereArr["FIND_IN_SET({$startcityId},l.overcity2)>"] =0;
			$cityid=$startcityId;
		} 
		elseif (!empty($startcity))
		{
			//$whereArr['sp.cityname like '] = '%'.$startcity.'%';
		}

		$depart_id=$this->session->userdata('depart_id');


		//上一级的营业部  三级营业部
		$this->load_model('admin/b2/b_depart_model', 'b_depart');
		$depart=$this->b_depart->row(array('id'=>$depart_id));
		if($depart['level']>1){

			$p_depart_id=$depart['pid'];	
			$departID=$this->b_depart->row(array('id'=>$p_depart_id));
			$start0="( ";
			$start1=")";
			if(!empty($departID['level']) && $departID['level']>1){
				$sqlWhere=$sqlWhere." lpc.expert_id ={$this ->expert_id} or (lpc.expert_id =0 and lpc.depart_id ={$depart_id})  ";
				$sqlWhere=$sqlWhere."or (lpc.expert_id =0 and lpc.depart_id ={$p_depart_id}) ";
				$sqlWhere=$sqlWhere." or (lpc.expert_id =0 and lpc.depart_id ={$departID['pid']}) ";
				$sqlWhere=$start0.$sqlWhere.$start1;
			}else{
				$sqlWhere="lpc.expert_id ={$this ->expert_id} or (lpc.expert_id =0 and lpc.depart_id ={$depart_id})";	
				$sqlWhere.="or (lpc.expert_id =0 and lpc.depart_id ={$p_depart_id}) ";
				$sqlWhere=$start0.$sqlWhere.$start1 ;
			}

		}else{
			$sqlWhere="(lpc.expert_id ={$this ->expert_id} or (lpc.expert_id =0 and lpc.depart_id ={$depart_id}) )" ;
		}
		//var_dump($depart['level']);
		

		$whereArr['lapl.status ='] = 2;
		$whereArr['l.producttype ='] =1;
		$whereArr['lsp.is_open ='] =1;
// 		if (!empty($destid))
// 		{
// 			$whereArr['d.id ='] = $destid;
// 		}

		//$specialSql = ' (sa.sell_object='.$this->expert_id.' or sa.union_id='.$expertData['union_id'].') ';
		$data = $this ->line_model ->getGroupLine($whereArr ,'lsp.dayid desc' ,$expertData['union_id'],$sqlWhere,$cityid);
		//echo $this ->db ->last_query();exit;
		echo json_encode($data);
	}
}