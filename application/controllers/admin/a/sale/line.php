<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since 	2016-03-15
 * @author jiakairong
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Line extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load->model ( 'line_model');
		$this->load->model ( 'admin/b1/user_shop_model' );
		$this->load->model ( 'admin/a/sale_model','sale_model');
	}
	public function index()
	{
		
		$this ->load_model('admin/a/admin_model' ,'admin_model');
		$data['admin'] = $this ->admin_model ->all(array(),'' ,'arr', 'id,realname');
		$data['plate'] =$this->sale_model->all(array(),'sort desc');
	
		$this->view ( 'admin/a/sale/line' ,$data);
	}
	public function getLineData()
	{
		$data = $this ->getCommonData();
		echo json_encode($data);
	}
	public function getOneData()
	{
		$lineid=$this->input->post("id",true); //线路id
		if(empty($lineid))  {echo json_encode(array('code'=>'-1','msg'=>'线路id不能为空'));exit();};
		$one=$this->sale_model->getOneLine($lineid);
		echo json_encode(array('code'=>0,'msg'=>'success','data'=>$one));
	}
    public function edit()
    {
    	$lineid=$this->input->post("lineid",true);
    	$sort=$this->input->post("sort",true);
    	$linename=$this->input->post("linename",true);
    	$line_pic=$this->input->post("line_pic",true);
    	$typeId=$this->input->post("typeId",true);
    	if(empty($sort)) {echo json_encode(array('code'=>'-1','msg'=>'排序不能为空'));exit();}
    	$this->db->query("update u_sales_line set sort={$sort},typeId={$typeId},lineName='{$linename}',pic='{$line_pic}' where lineId={$lineid}");
    	echo json_encode(array('code'=>0,'msg'=>'保存成功'));exit();
    }
    //下线： 仅仅从促销活动中下线
    public function line_off()
    {
    	$lineid=$this->input->post("lineid",true);
    	$off_reason=$this->input->post("off_reason",true);
    	
    	if(empty($lineid)) {echo json_encode(array('code'=>'-1','msg'=>'线路id不能为空'));exit();}
    	if(empty($off_reason)) {echo json_encode(array('code'=>'-1','msg'=>'请填写下线原因'));exit();}
    	
    	$this->db->query("update u_sales_line set isOnline=0,off_reason='{$off_reason}' where lineId={$lineid}");
    	$this->db->query("update u_sales_line_suit_price set isOnline=0 where lineId={$lineid}");
    	echo json_encode(array('code'=>0,'msg'=>'已下线'));exit();
    }
    //上线： 仅仅从促销活动中下线
    public function line_on()
    {
    	$lineid=$this->input->post("lineid",true);
    	 
    	if(empty($lineid)) {echo json_encode(array('code'=>'-1','msg'=>'线路id不能为空'));exit();}
    	$this->db->query("update u_sales_line set isOnline=1 where lineId={$lineid}");
    	$this->db->query("update u_sales_line_suit_price set isOnline=1 where lineId={$lineid}");
    	echo json_encode(array('code'=>0,'msg'=>'上线成功'));exit();
    }
	
	public function getCommonData($type=1)
	{
		$whereArr = array();
		$specialSql = ''; //特殊语句sql
		$status = intval($this ->input ->post('status')); //线路状态
		$linecode = trim($this ->input ->post('code' ,true)); //产品编号
		$linename = trim($this ->input ->post('linename' ,true)); //产品名称
		$company_name = trim($this ->input ->post('supplier' ,true)); //供应商名称
		$supplier_id = intval($this ->input ->post('supplier_id'));
		$admin_id = rtrim($this ->input ->post('admin_id') ,',');
		$startcity = trim($this ->input ->post('startcity' ,true));
		$startcity_id = intval($this ->input ->post('startcity_id'));
		$kindname = trim($this ->input ->post('kindname' ,true));
		$overcity = intval($this ->input ->post('destid'));
		$starttime = trim($this ->input ->post('starttime' ,true));
		$endtime = trim($this ->input ->post('endtime' ,true));
		$stime = trim($this ->input ->post('stime' ,true));
		$etime = trim($this ->input ->post('etime' ,true));
		$typeId = trim($this ->input ->post('typeId',true));
		
		$online="1";
		if($status=="2")
			$online="1";
		else 
			$online="0";
		$whereArr['sl.isOnline ='] = $online;
		//$whereArr['sl.isOnline ='] = 1;
		$whereArr['l.line_kind ='] = 1;
		$orderBy = 'l.modtime desc';
		switch($status)
		{
			case 2:
				$orderBy = 'l.confirm_time desc';
				$whereArr['l.status ='] = $status;
				break;
			case 3:
				$whereArr['l.status ='] = 2;
				break;
			case 1:
				$whereArr['l.status ='] = $status;
				break;
			case 4:
				$whereArr['l.status ='] = $status;
				$whereArr['l.line_status ='] = 1;
				break;
			case 5:
				$whereArr['l.status ='] = 4;
				$whereArr['l.line_status ='] = 0;
				break;
			default:
				echo json_encode($this ->defaultArr);
				exit;
				break;
		}
		if (!empty($linecode))
		{
			$whereArr['l.linecode ='] = $linecode;
		}
		if (!empty($linename))
		{
			$whereArr['l.linename like'] = '%'.$linename.'%';
		}
		//供应商
		if (!empty($supplier_id))
		{
			$whereArr['l.supplier_id ='] = $supplier_id;
		}
		elseif (!empty($company_name))
		{
			$whereArr['s.company_name like'] = '%'.$company_name.'%';
		}
		//出发城市
		if (!empty($startcity_id))
		{
			$whereArr['ls.startplace_id ='] = $startcity_id;
		}
		elseif (!empty($startcity))
		{
			$whereArr['sp.cityname like'] = '%'.$startcity.'%';
		}
		//目的地
		if (!empty($overcity))
		{
			$specialSql = ' find_in_set('.$overcity.' ,l.overcity)';
		}
		elseif (!empty($kindname))
		{
			$this ->load_model('dest/dest_base_model' ,'dest_base_model');
			$destData = $this ->dest_base_model ->all(array('kindname like' =>'%'.$kindname.'%'));
			if (empty($destData))
			{
				echo json_encode($this ->defaultArr);exit;
			}
			else
			{
				$specialSql = ' (';
				foreach($destData as $v)
				{
					$specialSql .= ' find_in_set('.$v['id'].' ,l.overcity) or';
				}
				$specialSql = rtrim($specialSql ,'or').') ';
			}
		}
		if (!empty($starttime))
		{
			$whereArr['l.online_time >='] = $starttime;
		}
		if (!empty($endtime))
		{
			$whereArr['l.online_time <='] = $endtime.' 23:59:59';
		}
		if ($status == 2)
		{
			if (!empty($stime))
			{
				$whereArr['l.confirm_time >='] = $stime;
			}
			if (!empty($etime))
			{
				$whereArr['l.confirm_time <='] = $etime.' 23:59:59';
			}
		}
		else 
		{
			if (!empty($stime))
			{
				$whereArr['l.modtime >='] = $stime;
			}
			if (!empty($etime))
			{
				$whereArr['l.modtime <='] = $etime.' 23:59:59';
			}
		}
		
		if (!empty($admin_id))
		{
			$specialSql .= ' l.admin_id in ('.$admin_id.')';
		}
		if (!empty($typeId))
		{
			$specialSql .= ' sl.typeId = '.$typeId;
		}
	
		if ($type == 1)
		{
			return $this->sale_model->getALineData ( $whereArr ,$specialSql ,false ,'st.sort,sl.sort');
		}
		else 
		{
			return $this->sale_model->getALineData ( $whereArr ,$specialSql ,'all','st.sort,sl.sort');
		}
	}
	//设置售卖线路管家
	function save_lineExpert(){
		$lineId=$this->input->post('line_id',true);
		$expertId=$this->input->post('expertId',true);
		if(empty($lineId)){
			echo json_encode(array('status' => -1,'msg' =>'操作失败!'));
			exit;
		}
		if(empty($expertId)){
			echo json_encode(array('status' => -1,'msg' =>'请选择管家!'));
			exit;
		}
		
		$re=$this->sale_model->saveLineSaleExpert($lineId,$expertId);
		//echo $this->db->last_query();
		if($re){
			echo json_encode(array('status' => 1,'msg' =>'操作成功!'));
			exit;
		}else{
			echo json_encode(array('status' => -1,'msg' =>'操作失败!'));
			exit;
		}
	}
	function get_lineExpert(){
		$this->load->model ( 'admin/a/line_model','line_model');
		
		$lineid=$this->input->get('line_id',true);
		$data['line']=$this->line_model->row(array('id'=>$lineid));
		
		//售卖管家
		$data['expert']=$this->sale_model->get_saleExpert($lineid);
		
		$this->view ( 'admin/a/sale/add_expert',$data);
	}
	
}