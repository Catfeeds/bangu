<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since  2016-07-27
 * @author jiakairong
 * @method 线路虚拟值管理
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Line_vr extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('line_model' ,'line_model');
	}
	
	public function index()
	{
		$this->view ( 'admin/a/vr/line_vr');
	}
	
	public function get_line_data()
	{
		$whereArr = array('l.status =' =>2);
		$linecode = trim($this ->input ->post('linecode' ,true));
		$linename = trim($this ->input ->post('linename' ,true));
		$cityname = trim($this ->input ->post('startcity' ,true));
		$cityId = trim($this ->input ->post('startcity_id' ,true));
		
		if (!empty($linecode))
		{
			$whereArr['l.linecode ='] = $linecode;
		}
		if (!empty($linename))
		{
			$whereArr['l.linename like '] = '%'.$linename.'%';
		}
		if ($cityId > 0)
		{
			$whereArr['sp.id ='] = $cityId;
		}
		elseif (!empty($cityname))
		{
			$whereArr['sp.cityname like '] = '%'.$cityname.'%';
		}
		
		$data = $this ->line_model ->getLineVrData($whereArr);
		echo json_encode($data);
	}
	
	//修改虚拟值
	public function update_vr()
	{
		$id = intval($this ->input ->post('id'));
		$collect_num_vr = intval($this ->input ->post('collect_num_vr'));
		$sati_vr = floatval($this ->input ->post('sati_vr'));
		$order_num_vr = intval($this ->input ->post('order_num_vr'));
		if ($collect_num_vr < 1 && $sati_vr < 0 && $order_num_vr < 1)
		{
			$this ->callback ->setJsonCode(4000 ,'请填写需要修改的虚拟值');
		}
		
		$dataArr = array(
				'collect_num_vr' =>$collect_num_vr,
				'sati_vr' =>$sati_vr,
				'order_num_vr' =>$order_num_vr
		);
		$status = $this ->line_model ->update_vr($id ,$dataArr);
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else
		{
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
	}
}