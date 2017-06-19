<?php
/**
 *
* @copyright 深圳海外国际旅行社有限公司
* @version 1.0
* @since 2015年7月20日
* @author jiakairong
* @method 游记管理
*/
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Travel_note extends UA_Controller
{
	const PAGESIZE = 10;
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model ('admin/a/travel_note_model' ,'travel_model');
	}
	//进入游记列表
	public function index()
	{
		$this->load_view ( 'admin/a/travel_note/travel_list');
	}
	//已下线和全部游记
	public function getTravelNoteJson()
	{
		$whereArr = array();
		$orderBy = 'tn.id desc';
		$postArr = $this->security->xss_clean($_POST);
		$pageNew = empty($postArr['page_new']) ? 1 : intval($postArr['page_new']);
		$status = empty($postArr['status']) ? 1 : intval($postArr['status']);
		switch($status)
		{
			case 3: //已下线
				$whereArr['tn.status'] = -2;
				$orderBy = 'tn.modtime desc';
				break;
			case 4:	//全部游记
				$whereArr['tn.status !'] = 0;
				$whereArr['tn.status !'] = -1;
				break;
			default:
		
				break;
		}
		if (!empty($postArr['title']))
		{
			$whereArr['tn.title'] = trim($postArr['title']);
		}
		if (!empty($postArr['endtime']))
		{
			$whereArr['tn.addtime <'] = $postArr['endtime'].' 23:59:59';
		}
		if (!empty($postArr['starttime']))
		{
			$whereArr['tn.addtime >'] = $postArr['starttime'];
		}
		$data['list'] = $this ->travel_model ->getTravelNoteData($whereArr ,$pageNew ,sys_constant::A_PAGE_SIZE ,$orderBy);
		//echo $this ->db ->last_query();
		$count = $this->getCountNumber($this->db->last_query());
		$data['page_string'] = $this ->getAjaxPage($pageNew ,$count);
		echo json_encode($data);
	}
	
	//审核中和已拒绝的游记
	public function getTravelComplainJson()
	{
		$whereArr = array();
		$orderBy = 'tnc.id desc';
		$postArr = $this->security->xss_clean($_POST);
		$pageNew = empty($postArr['page_new']) ? 1 : intval($postArr['page_new']);
		$status = empty($postArr['status']) ? 1 : intval($postArr['status']);
		switch($status)
		{
			case 1: //申诉中的游记
				$whereArr['tnc.status'] = 0;
				break;
			case 2:	//申诉拒绝的游记
				$whereArr['tnc.status'] = 2;
				$orderBy = 'tnc.modtime desc';
				break;
			default:
				$whereArr['tnc.status'] = 0;
				break;
		}
		if (!empty($postArr['title']))
		{
			$whereArr['tn.title'] = trim($postArr['title']);
		}
		if (!empty($postArr['endtime']))
		{
			$whereArr['tnc.addtime <'] = $postArr['endtime'].' 23:59:59';
		}
		if (!empty($postArr['starttime']))
		{
			$whereArr['tnc.addtime >'] = $postArr['starttime'];
		}
		
		$data['list'] = $this ->travel_model ->getTravelComplainData($whereArr ,$pageNew ,sys_constant::A_PAGE_SIZE ,$orderBy);
		$count = $this->getCountNumber($this->db->last_query());
		$data['page_string'] = $this ->getAjaxPage($pageNew ,$count);
		echo json_encode($data);
	}
	//获取游记详情
	public function getTravelDetail()
	{
		$id = intval($this ->input ->post('id'));
		//游记信息
		$whereArr = array('tn.id' =>$id);
		$travel = $this ->travel_model ->getTravelNoteDetail($whereArr);
		if(empty($travel))
		{
			echo false;exit;
		}
		$travel = $travel[0];
		//获取图片
		$whereArr = array('note_id' =>$id);
		$pic = $this ->travel_model ->get_travel_pic($whereArr);
		if (!empty($pic))
		{
			foreach($pic as $key =>$val)
			{
				switch($val['pictype'])
				{
					case 1:
						$travel ['pic1'] = explode(';' ,$val['pic']);
						$travel ['description1'] = $val['description'];
						break;
					case 2:
						$travel ['pic2'] =  explode(';' ,$val['pic']);
						$travel ['description2'] = $val['description'];
						break;
					case 3:
						$travel ['pic3'] =  explode(';' ,$val['pic']);
						$travel ['description3'] = $val['description'];
						break;
				}
			}
		}
		echo json_encode($travel);
	}
	//游记下线
	public function show_change() {
		$id = intval($this ->input ->post('id'));
		$time = date('Y-m-d H:i:s' ,time());

		$whereArr = array('id' =>$id);
		$travelArr = array(
			'status' =>-2,
			'is_show' =>0,
			'modtime' =>$time
		);
		
		$status = $this ->travel_model ->update($travelArr ,$whereArr);
		if (empty($status)) {
			throw new Exception('游记下线失败');
		} else {
			$this ->log(3,3,'游记管理','游记下线,游记ID:'.$id);
		}
		$this->callback->set_code ( 2000 ,"操作成功");	
		$this->callback->exit_json();
	}
	//通过申诉申请
	public function through_complain()
	{
		$complain_id = intval($this ->input ->post('complain_id')); //申诉记录ID
		$remark = trim($this ->input ->post('remark' ,true));
		if (empty($remark))
		{
			$this->callback->set_code ( 4000 ,'请填写处理意见');
			$this->callback->exit_json();
		}
		//获取申诉记录
		$complainData = $this ->travel_model ->getComplainData($complain_id);
		if (empty($complainData) || $complainData[0]['status'] != 0)
		{
			$this->callback->set_code ( 4000 ,'记录不存在或已处理');
			$this->callback->exit_json();
		}
		
		$complainArr = array(
				'modtime' =>date('Y-m-d H:i:s' ,time()),
				'status' =>1,
				'remark' =>$remark,
				'admin_id' =>$this ->admin_id
		);
		$status = $this ->travel_model ->throughComplain($complainData[0]['travel_note_id'] ,$complain_id ,$complainArr);
		if ($status == false)
		{
			$this->callback->set_code ( 4000 ,'操作失败');
			$this->callback->exit_json();
		}
		else 
		{
			$this ->log(3,3,'游记管理','游记申诉通过,申诉ID:'.$id.',游记ID:'.$complainData[0]['travel_note_id']);
			$this->callback->set_code ( 2000 ,'操作成功');
			$this->callback->exit_json();
		}
	}
	
	//拒绝申诉申请
	public function refuse_complain()
	{
		$complain_id = intval($this ->input ->post('complain_id')); //申诉记录ID
		$remark = trim($this ->input ->post('remark' ,true));
		if (empty($remark))
		{
			$this->callback->set_code ( 4000 ,'请填写处理意见');
			$this->callback->exit_json();
		}
		//获取申诉记录
		$complainData = $this ->travel_model ->getComplainData($complain_id);
		if (empty($complainData) || $complainData[0]['status'] != 0)
		{
			$this->callback->set_code ( 4000 ,'记录不存在或已处理');
			$this->callback->exit_json();
		}
		
		$complainArr = array(
				'modtime' =>date('Y-m-d H:i:s' ,time()),
				'status' =>2,
				'remark' =>$remark,
				'admin_id' =>$this ->admin_id
		);
		$status = $this ->travel_model ->refuseComplain($complainData[0]['travel_note_id'] ,$complain_id ,$complainArr);
		if ($status == false)
		{
			$this->callback->set_code ( 4000 ,'操作失败');
			$this->callback->exit_json();
		}
		else
		{
			$this ->log(3,3,'游记管理','游记申诉拒绝,申诉ID:'.$id.',游记ID:'.$complainData[0]['travel_note_id']);
			$this->callback->set_code ( 2000 ,'操作成功');
			$this->callback->exit_json();
		}
	}
	
	//游记加精
	public function essence_change() {
		$id = intval($this ->input ->post('id'));
		$whereArr = array('id' =>$id);
		$travelArr = array(
				'is_essence' =>1,
				'modtime' =>date('Y-m-d H:i:s' ,time())
		);
		$status = $this ->travel_model ->update($travelArr ,$whereArr);
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"操作失败");
		} else {
			$this ->log(3,3,'游记管理','游记加精,游记ID:'.$id);
			$this->callback->set_code ( 2000 ,"操作成功");
		}
		$this->callback->exit_json();
	}
	//取消加精
	public function cancelEssence() {
		$id = intval($this ->input ->post('id'));
		$whereArr = array('id' =>$id);
		$travelArr = array(
				'is_essence' =>0,
				'modtime' =>date('Y-m-d H:i:s' ,time())
		);
		$status = $this ->travel_model ->update($travelArr ,$whereArr);
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"操作失败");
		} else {
			$this ->log(3,3,'游记管理','游记取消加精,游记ID:'.$id);
			$this->callback->set_code ( 2000 ,"操作成功");
		}
		$this->callback->exit_json();
	}
}