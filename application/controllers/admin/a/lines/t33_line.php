<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since 	2016-03-15
 * @author jiakairong
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class T33_line extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load->model ( 'admin/a/line_model');
		$this->load->model ( 'admin/b1/user_shop_model' );
	}
	public function index()
	{
		$this ->load_model('admin/a/admin_model' ,'admin_model');
		$data['admin'] = $this ->admin_model ->all(array(),'' ,'arr', 'id,realname');
		
		$this->view ( 'admin/a/line/t33_line' ,$data);
	}
    //t33 线路
    function get_line_list(){

    	$linecode=trim($this ->input ->post('linecode' ,true));
    	$linename=trim($this ->input ->post('linename' ,true));
    	$starttime=trim($this ->input ->post('starttime' ,true));
    	$endtime=trim($this ->input ->post('endtime' ,true));
    	$startcity=trim($this ->input ->post('startcity' ,true));
    	$mod_time=trim($this ->input ->post('mod_time' ,true));
    	$mod_endtime=trim($this ->input ->post('mod_endtime' ,true));
    	$startcity_id=trim($this ->input ->post('startcity_id' ,true));
    	$supplier=trim($this ->input ->post('supplier' ,true));
    	$supplier_id=trim($this ->input ->post('supplier_id' ,true));
    	$destinations=trim($this ->input ->post('destinations' ,true));
    	$destid=trim($this ->input ->post('destid' ,true));
    	$realname=trim($this ->input ->post('realname' ,true));
    	$line_classify=trim($this ->input ->post('line_classify' ,true));
    	
    	$status=$this->input->post('status',true);
    	$whereArr['pl.status =']=$status;
    	if(!empty($linecode)){
    		$whereArr['l.linecode =']=$linecode;
    	}
    	if(!empty($linename)){
    		$whereArr['l.linename like']= '%'.$linename.'%';
    	}
    	$whereArr['l.line_kind ='] = 1;
    	
    	//供应商
    	if (!empty($supplier_id))
    	{
    		$whereArr['l.supplier_id ='] = $supplier_id;
    	}
    	elseif (!empty($supplier))
    	{
    		$whereArr['s.company_name like'] = '%'.$supplier.'%';
    	}
    	if (!empty($starttime))
    	{
    		$whereArr['pl.online_time >='] = $starttime;
    	}
    	if (!empty($endtime))
    	{
    		$whereArr['pl.online_time <='] = $endtime.' 23:59:59';
    	}
    	if($status==2){  //已通过
    		if (!empty($mod_time))
    		{
    			$whereArr['pl.confirm_time >='] = $mod_time;
    		}
    		if (!empty($mod_endtime))
    		{
    			$whereArr['pl.confirm_time <='] = $mod_endtime.' 23:59:59';
    		}
    	}else{
    		if (!empty($mod_time))
    		{
    			$whereArr['pl.modtime >='] = $mod_time;
    		}
    		if (!empty($mod_endtime))
    		{
    			$whereArr['pl.modtime <='] = $mod_endtime.' 23:59:59';
    		}
    	}
    	//审核人
    	if(!empty($realname)){
    		$whereArr['pl.employee_name like'] = '%'.$realname.'%';
    	}
    	//线路类型
    	if(!empty($line_classify)){
    		$whereArr['l.line_classify ='] = $line_classify;
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
    	$specialSql='';
    	if (!empty($destid))
    	{
    		$specialSql = ' find_in_set('.$destid.' ,l.overcity)';
    	}
    	elseif (!empty($destinations))
    	{
    		$this ->load_model('dest/dest_base_model' ,'dest_base_model');
    		$destData = $this ->dest_base_model ->all(array('kindname like' =>'%'.$destinations.'%'));
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
    	
    	$whereArr['bs.status = ']=1;
    	$data = $this ->line_model ->b_line_list($whereArr,$specialSql); 
    	echo json_encode($data);
    }
    
}