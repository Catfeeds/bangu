<?php
/**
 * 专家答题
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年7月28日15:05:11
 * @author		汪晓烽
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pre_order extends UB2_Controller {

	public function __construct() {
		parent::__construct();

		$this->load_model('admin/b2/pre_order_model', 'pre_order');
		$this->load_model('admin/b2/v2/order_deal_model', 'order_deal');
	}
    /*
     * 产品预订页面
     * */
	function index() 
	{
		$account = $this->pre_order->get_all_limit();
		$data = array(
				'account'=>$account,
				'is_manage'=>$this->session->userdata('is_manage'),
				'expert_stauts'=>$this->session->userdata('e_status')  //管家状态
			);
		$expert_id=$this->expert_id;
		//如是帮游管家是否有申请售卖线路
		$data['is_line']=0;
		if($data['expert_stauts']==2){
			$line=$this->pre_order->get_sel_lineData($expert_id);
			if(!empty($line)){
				$data['is_line']=1;
			}
		}
		$this->view('admin/b2/pre_order_view',$data);
	}
	/*
	 * 当前部门及子部门
	 * */
	public function depart_list()
	{
		$depart_list = $this->pre_order->get_all_depart();
		echo json_encode(array('code'=>'2000','data'=>$depart_list));
	}
	/*
	 * 额度调整提交数据接口
	 * */
	public function api_save_limit(){
		$depart_id=$this->input->post("depart_id",true);
		$cash_limit_after=$this->input->post("cash_limit",true);
		$credit_limit_after=$this->input->post("credit_limit",true);
		
		if (!is_numeric($cash_limit_after)) { echo json_encode(array('code'=>'-3','msg'=>'现金额度只能填数字','depart_id'=>$depart_id));exit;}
		if ( !is_numeric($credit_limit_after)) { echo json_encode(array('code'=>'-3','msg'=>'信用额度只能填数字','depart_id'=>$depart_id));exit;}
		
		$depart_row=$this->order_deal->depart_detail($depart_id);
		$depart_pid_row=$this->order_deal->depart_detail($depart_row['pid']);
		if(empty($depart_row))  { echo json_encode(array('code'=>'-3','msg'=>'部门不存在','depart_id'=>$depart_id));exit;}
		if(empty($depart_pid_row))  { echo json_encode(array('code'=>'-3','msg'=>'上级部门不存在','depart_id'=>$depart_id));exit;}
		
		$this->db->trans_begin();//开启事物
		//1、现金
		if($cash_limit_after!=$depart_row['cash_limit'])
		{
			$diff=$cash_limit_after-$depart_row['cash_limit'];//调整的现金
			if($diff>0)
			{//调大
			  if($depart_pid_row['cash_limit']<$diff) { echo json_encode(array('code'=>'-3','msg'=>'上级部门('.$depart_pid_row['name'].')现金额度不足','depart_id'=>$depart_id));exit; }
			  $this->order_deal->del_cash($diff,$depart_row['pid']);
			  $this->order_deal->write_depart_log($depart_row['pid'],array('cut_money'=>-$diff,'type'=>'经理调整现金额度','remark'=>'b2：经理调整现金额度'));
			  $this->order_deal->add_cash($diff,$depart_id);
			  $this->order_deal->write_depart_log($depart_id,array('receivable_money'=>$diff,'type'=>'经理调整现金额度','remark'=>'b2：经理调整现金额度'));
			  
			}
			else
			{
				$diff=abs($diff);
				if($depart_row['cash_limit']<$diff) { echo json_encode(array('code'=>'-3','msg'=>'部门('.$depart_row['name'].')现金额度不能调整为负数','depart_id'=>$depart_id));exit; }
				$this->order_deal->del_cash($diff,$depart_id);
				$this->order_deal->write_depart_log($depart_id,array('cut_money'=>-$diff,'type'=>'经理调整现金额度','remark'=>'b2：经理调整现金额度'));
				$this->order_deal->add_cash($diff,$depart_row['pid']);
				$this->order_deal->write_depart_log($depart_row['pid'],array('receivable_money'=>$diff,'type'=>'经理调整现金额度','remark'=>'b2：经理调整现金额度'));
			}
		}
		//2、信用
		if($credit_limit_after!=$depart_row['credit_limit'])
		{
			$diff=$credit_limit_after-$depart_row['credit_limit'];//调整的信用
			if($diff>0)
			{//调大
				if($depart_pid_row['credit_limit']<$diff) { echo json_encode(array('code'=>'-3','msg'=>'上级部门('.$depart_pid_row['name'].')信用额度不足','depart_id'=>$depart_id));exit; }
				$this->order_deal->del_credit($diff,$depart_row['pid']);
				$this->order_deal->write_depart_log($depart_row['pid'],array('cut_money'=>-$diff,'type'=>'经理调整信用额度','remark'=>'b2：经理调整信用额度'));
				$this->order_deal->add_credit($diff,$depart_id);
				$this->order_deal->write_depart_log($depart_id,array('receivable_money'=>$diff,'type'=>'经理调整信用额度','remark'=>'b2：经理调整信用额度'));
					
			}
			else
			{//调小
				$diff=abs($diff);
				if($depart_row['credit_limit']<$diff) { echo json_encode(array('code'=>'-3','msg'=>'部门('.$depart_row['name'].')信用额度不能调整为负数','depart_id'=>$depart_id));exit; }
				$this->order_deal->del_credit($diff,$depart_id);
				$this->order_deal->write_depart_log($depart_id,array('cut_money'=>-$diff,'type'=>'经理调整信用额度','remark'=>'b2：经理调整信用额度'));
				$this->order_deal->add_credit($diff,$depart_row['pid']);
				$this->order_deal->write_depart_log($depart_row['pid'],array('receivable_money'=>$diff,'type'=>'经理调整信用额度','remark'=>'b2：经理调整信用额度'));
			}
		}
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo json_encode(array('code'=>-3,'msg'=>'操作失败','depart_id'=>$depart_id));
			exit();
		}else{
			$this->db->trans_commit();
			$depart_pid_row=$this->order_deal->depart_detail($depart_row['pid']);
			echo json_encode(array('code'=>2000,'depart_id'=>$depart_id,'data'=>array('cash_limit'=>$cash_limit_after,'credit_limit'=>$credit_limit_after,'p_cash_limit'=>$depart_pid_row['cash_limit'],'p_credit_limit'=>$depart_pid_row['credit_limit'])));
			exit();
		}
		
		
	}
	/**
	 * 供应商详情
	 * */
	public function supplier_detail(){
	
		$supplier_id=$this->input->get("id",true);
		$this->load->model('admin/t33/u_supplier_model','u_supplier_model');
		$this->load_model ( 'supplier_model');
		$data = $this ->supplier_model ->getSupplierDetail($supplier_id);
		$this->load->view("admin/b2/supplier_detail_view",$data);
	}
	/**
	 * 线路详情
	 * */
	public function line_detail(){
		$line_id=$this->input->get("id",true);
		$line = $this->F_line_detail_more($line_id);

		$data['line']=$line;
	
		// 供应商信息
		$this->load->model ( 'app/user_shop_model' );
		$supplier = $this->user_shop_model->get_user_shop_select ( 'u_supplier', array ('id' => $line['data']['supplier_id']) );
		$data['supplier'] = $supplier;

		//上车地点
   		$data['carAddress']=$this->user_shop_model->get_user_shop_select('u_line_on_car',array('line_id'=>$line_id));

		$this->load->view("admin/b2/line_detail_view",$data);
	}
	//套餐详情
	public function getProductPriceJSON(){
		$this->load->model ( 'admin/b1/user_shop_model' );

		$lineId = $this->get("lineId");
		$productPrice = "[]";
		if(null!=$lineId && ""!=$lineId){
			$productPrice = $this->user_shop_model->getProductPriceByProductId($lineId);
		}
		//echo $this->db->last_query();
		echo $productPrice;
	}
	/*
	 * 产品预定：售卖线路
	 * */
	function ajax_get_product()
	{
		//1、post数据
		$linename = trim($this ->input ->post('linename' ,true)); //产品名称
		$company_name = trim($this ->input ->post('supplier' ,true)); //供应商名称
		$supplier_id = intval($this ->input ->post('supplier_id'));
		$kindname = trim($this ->input ->post('kindname' ,true));
		$overcity = intval($this ->input ->post('destid'));
		$starttime = trim($this ->input ->post('starttime' ,true));
		$endtime = trim($this ->input ->post('endtime' ,true));
		$start_place = trim($this ->input ->post('start_place' ,true));
		$start_place_id = trim($this ->input ->post('start_place_id' ,true));
		$start_price = trim($this ->input ->post('start_price' ,true));
		$end_price = trim($this ->input ->post('end_price' ,true));
		$start_days  = trim($this ->input ->post('start_days' ,true));
		$end_days  = trim($this ->input ->post('end_days' ,true));
		$linecode = trim($this ->input ->post('linecode' ,true));
		$is_zhishu = trim($this ->input ->post('is_zhishu' ,true));
		$team_num = trim($this ->input ->post('team_num' ,true));
		//$linecode = trim($this ->input ->post('line_code' ,true)); //产品编号
		
		//2、where条件数组
		$whereArr = array();
		if (!empty($team_num)){ $whereArr['lsp.description like'] = '%'.$team_num.'%';}  //团号
		if (!empty($linename)){ $whereArr['l.linename like'] = '%'.$linename.'%';}       //线路名称
		if (!empty($linecode)){ $whereArr['l.linecode like'] = '%'.$linecode.'%';}       //线路编号
		//目的地
		if (!empty($overcity)){
			$specialSql = ' find_in_set('.$overcity.' ,l.overcity)';
			$whereArr['overcity'] = $specialSql;
		}elseif (!empty($kindname)){
			$this ->load_model('destinations_model' ,'dest_model');
			$destData = $this ->dest_model ->all(array('kindname like' =>'%'.$kindname.'%'));
			if (empty($destData)) {
				echo json_encode($this ->defaultArr);exit;
			}else{
				$specialSql = ' (';
				foreach($destData as $v){
					$specialSql .= ' find_in_set('.$v['id'].' ,l.overcity) or';
				}
				$specialSql = rtrim($specialSql ,'or').') ';
			}
			$whereArr['overcity'] = $specialSql;
		}

		//出发城市
		if (!empty($start_place_id)){
			$whereArr['startplace_id'] = $start_place_id; //$whereArr['ls.startplace_id ='] = $start_place_id;
		}elseif (!empty($start_place)){
			$whereArr['cityname'] = $start_place;//$whereArr['sp.cityname like'] = '%'.$start_place.'%';
		}

		if (!empty($starttime)){ $whereArr['lsp.day >='] = $starttime;} //出团时间：起始
		if (!empty($endtime)){ $whereArr['lsp.day <='] = $endtime.' 23:59:59';} //出团时间：结束
		if (!empty($start_price)){$whereArr['lsp.adultprice >='] = $start_price;}  // 价格：起始
		if (!empty($end_price)){$whereArr['lsp.adultprice <='] = $end_price;}      // 价格：结束
		if (!empty($start_days)){$whereArr['l.lineday >='] = $start_days;}         // 天数：起始
		if (!empty($end_days)){$whereArr['l.lineday <='] = $end_days;}             // 天数：结束
		$whereArr['l.producttype ='] = 0;  //线路类型
        $page = $this->getPage();
		$page = $this->pre_order->get_all_product($whereArr,$page,$this->expert_id,$this->session->userdata('union_id'),$is_zhishu);
		echo json_encode($page);
	}

	//售卖线路
	function get_sell_line(){
		
		//1、post数据
		$linename = trim($this ->input ->post('linename' ,true)); //产品名称
		$company_name = trim($this ->input ->post('supplier' ,true)); //供应商名称
		$supplier_id = intval($this ->input ->post('supplier_id'));
		$kindname = trim($this ->input ->post('kindname' ,true));
		$overcity = intval($this ->input ->post('destid'));
		$starttime = trim($this ->input ->post('starttime' ,true));
		$endtime = trim($this ->input ->post('endtime' ,true));
		$start_place = trim($this ->input ->post('start_place' ,true));
		$start_place_id = trim($this ->input ->post('start_place_id' ,true));
		$start_price = trim($this ->input ->post('start_price' ,true));
		$end_price = trim($this ->input ->post('end_price' ,true));
		$start_days  = trim($this ->input ->post('start_days' ,true));
		$end_days  = trim($this ->input ->post('end_days' ,true));
		$linecode = trim($this ->input ->post('linecode' ,true));
		$is_zhishu = trim($this ->input ->post('is_zhishu' ,true));
		$team_num = trim($this ->input ->post('team_num' ,true));
		
		//2、where条件数组
		$whereArr = array();
		if (!empty($team_num)){ $whereArr['lsp.description like'] = '%'.$team_num.'%';}  //团号
		if (!empty($linename)){ $whereArr['l.linename like'] = '%'.$linename.'%';}       //线路名称
		if (!empty($linecode)){ $whereArr['l.linecode like'] = '%'.$linecode.'%';}       //线路编号
		//目的地
		if (!empty($overcity)){
			$specialSql = ' find_in_set('.$overcity.' ,l.overcity)';
			$whereArr['overcity'] = $specialSql;
		}elseif (!empty($kindname)){
			$this ->load_model('destinations_model' ,'dest_model');
			$destData = $this ->dest_model ->all(array('kindname like' =>'%'.$kindname.'%'));
			if (empty($destData)) {
				echo json_encode($this ->defaultArr);exit;
			}else{
				$specialSql = ' (';
				foreach($destData as $v){
					$specialSql .= ' find_in_set('.$v['id'].' ,l.overcity) or';
				}
				$specialSql = rtrim($specialSql ,'or').') ';
			}
			$whereArr['overcity'] = $specialSql;
		}

		//出发城市
		$whereCity='';
		if (!empty($start_place_id)){
			$whereCity['startplace_id'] = $start_place_id; //$whereArr['ls.startplace_id ='] = $start_place_id;
		}elseif (!empty($start_place)){
			$whereCity['cityname'] = $start_place;//$whereArr['sp.cityname like'] = '%'.$start_place.'%';
		}

		if (!empty($starttime)){ $whereArr['lsp.day >='] = $starttime;} //出团时间：起始
		if (!empty($endtime)){ $whereArr['lsp.day <='] = $endtime.' 23:59:59';} //出团时间：结束
		if (!empty($start_price)){$whereArr['lsp.adultprice >='] = $start_price;}  // 价格：起始
		if (!empty($end_price)){$whereArr['lsp.adultprice <='] = $end_price;}      // 价格：结束
		if (!empty($start_days)){$whereArr['l.lineday >='] = $start_days;}         // 天数：起始
		if (!empty($end_days)){$whereArr['l.lineday <='] = $end_days;}             // 天数：结束
		
		if (!empty($starttime)){ $whereArr['lsp.day >='] = $starttime;}//出团时间：起始
		if (!empty($endtime)){ $whereArr['lsp.day <='] = $endtime.' 23:59:59';} //出团时间：结束
		$whereArr['l.producttype ='] = 0;  //线路类型
		
		
		$page = $this->getPage();
		$page = $this->pre_order->get_sellLine_product($whereArr,$page,$this->expert_id,$whereCity);
		echo json_encode($page);
	} 

	function show_travel(){
		$this->load->model('admin/t33/u_line_model','u_line_model');
		$line_id=$this->input->get("line_id",true);
		$return = $this ->u_line_model ->line_trip($line_id);
		$data['list'] = $return['result'];
		$data['line_id'] = $line_id;
		$data['line_row'] = $this ->u_line_model ->row(array('id'=>$line_id));
		//var_dump($data['line_row']);exit();
		$this->load->view("admin/b2/show_travel_view",$data);
	}
	
	function travel_print()
	{
		$line_id=$this->input->get("id",true);
		$this->load->model('admin/t33/u_line_model','u_line_model');
		$return = $this ->u_line_model ->line_trip($line_id);
		
		$data['list'] = $return['result'];
		$union_id=$this->session->userdata('union_id');
		$this->load->model('admin/t33/sys/b_union_log_model','b_union_log_model');
		$data['logo']=$this->b_union_log_model->row(array('union_id'=>$union_id));
		$data['line']['data']=$this->u_line_model->row(array('id'=>$line_id));
		//var_dump($data);
		$this->load->view("admin/b2/trip",$data);
	}
	
}