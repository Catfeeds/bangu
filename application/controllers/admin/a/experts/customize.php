<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015-12-15
 * @author		jiakairong
 * @method 		定制单管理 
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Customize extends UA_Controller {

	public function __construct() {
		parent::__construct ();
		$this->load_model ( 'customize_model', 'customize_model' );
		$this->load_model ('dest/dest_base_model' ,'dest_base_model');
	}
	//定制列表
	public function index() {
		$this->load_view ( 'admin/a/expert/customize');
	}
	
	//定制数据
	public function getCustomizeJson()
	{
		$whereArr = array();
		$status = intval($this ->input ->post('status'));
		$linkname = trim($this ->input ->post('linkname'));
		$linkphone = trim($this ->input ->post('linkphone'));
		switch($status)
		{
			case 1:
				$whereArr['u.status >='] = 0;
				$whereArr['u.status <='] = 2;
				break;
			case 3:
			case -2:
			case -3:
				$whereArr['u.status ='] = $status;
				break;
			default:
				echo json_encode($this ->defaultArr);
				exit;
		}
		if (!empty($linkname)) 
		{
			$whereArr['u.linkname like'] = '%'.$linkname.'%';
		}
		if (!empty($linkphone)) 
		{
			$whereArr['u.linkphone ='] = $linkphone; 
		}
		$data = $this ->customize_model ->getCustomizeAdmin($whereArr);
		foreach($data['data'] as &$val) 
		{
			$val['kindname'] = '';
			if (!empty($val['endplace']))
			{
				$whereArr = array(
						'in' =>array('d.id' =>$val['endplace'])
				);
				$destData = $this ->dest_base_model ->getDestBaseData($whereArr);
				foreach($destData as $v) 
				{
					$val['kindname'] .= $v['kindname'].',';
				}
				$val['kindname'] = rtrim($val['kindname'] ,',');
			}
		}
		echo json_encode($data);
	}
	/**
	 * @method 获取一条定制单数据
	 * @author jiakairong
	 */
	public function getCustomizeDetail ()
	{
		$id = intval($this ->input ->post('id'));
		$customize = $this ->customize_model ->getCustomizeDetail($id);
		if (!empty($customize))
		{
			$customize[0]['kindname'] = '';
			if (!empty($customize[0]['endplace'])) 
			{
				$whereArr = array(
						'in' =>array('id' =>$customize[0]['endplace'])
				);
				$destData = $this ->dest_base_model ->getDestBaseAllData($whereArr);
				foreach($destData as $v)
				{
					$customize[0]['kindname'] .= $v['name'].',';
				}
				$customize[0]['kindname'] = rtrim($customize[0]['kindname'] ,',');
			}
			echo json_encode($customize[0]);
		}
		else 
		{
			echo false;
		}
	}
}