<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月20日11:59:53
 * @author		何俊
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Home extends UA_Controller 
{
	public function __construct()
	{
		parent::__construct ();
	}
	public function index()
	{
		//$this->load->model ( 'common/cfg_web_model' );
		$this->load->model ( 'admin/a/expert_model' ,'expert_model' );
		$this->load->model ( 'admin/a/supplier_model' ,'supplier_model' );
		//$photo = $this ->session ->userdata('a_photo');
// 		$eqixiu_url='';
// 		$web=$this->cfg_web_model->all(array(),'' ,'arr' ,'eqixiu_url');
		if(!empty($web[0]))
		{
			$eqixiu_url=$web[0]['eqixiu_url'];
		}
		$data= array (
				//'admin_photo' =>$photo,
				'nav_list' =>$this ->admin_nav(),
				//'eqixiu_url'=>$eqixiu_url,
				'expertCount' =>$this ->expert_model ->getExpertCount(1),
				'supplierCount' =>$this ->supplier_model ->getSupplierCount(1)
		);
		//$this->load->view('admin/a/home',$data);
                SeasLog::critical('nav is :'.  json_encode($data));
		$this->load->view('admin/a/common/home',$data);
	}
	/**
	 * @method 导航栏显示
	 * @author jiakairong
	 * @since  2016-01-08
	 */
	public function admin_nav()
	{
		$this ->load_model('admin/a/admin_model' ,'admin_model');
		$resourceArr = array();
		$adminResource = $this ->admin_model->getAdminResource($this ->admin_id);
		
		if (!empty($adminResource))
		{
			foreach($adminResource as $key =>$val)
			{
				if (empty($val['name']) || empty($val['id']))
				{
					unset($adminResource[$key]);	
				}
				if ($val['pid'] == 0)
				{
					$resourceArr[$val['id']] = $val;
					unset($adminResource[$key]);
				}
			}
			foreach($adminResource as $v)
			{
				if (array_key_exists($v['pid'], $resourceArr) && (empty($resourceArr[$v['pid']]['lower']) || !array_key_exists($v['id'], $resourceArr[$v['pid']]['lower'])))
				{
					$resourceArr[$v['pid']]['lower'][$v['id']] = $v;
				}
			}
		}
		foreach($resourceArr as $key=>$val)
		{
			if (empty($val['lower']))
			{
				unset($resourceArr[$key]);
			}
		}
		return $resourceArr;
	}
}