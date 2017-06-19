<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年5月7日18:35:53
 * @author		jiakairong
 * @method 		手机端热门管家
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Mobile_hot_expert extends UA_Controller {
	public $controllerName = '手机端热门管家';
	public function __construct()
	{
		parent::__construct ();
		$this->load_model('admin/a/mobile_hot_expert_model','hot_expert_model');
	}
	public function index()
	{
		$this->view ( 'admin/a/cfg_mobile/mobile_hot_expert_list');
	}
	
	public function getMHotExpertData()
	{
		$whereArr = array();
		$name = trim($this ->input ->post('search_name' ,true));
		$city = intval($this ->input ->post('city'));
		$province = intval($this ->input ->post('province'));
		
		if (!empty($name)) 
		{
			$whereArr ['e.realname like'] = "%$name%";
		}
		if (!empty($city))
		{
			$whereArr ['he.startplaceid ='] = $city;
		}
		elseif (!empty($province))
		{
			$whereArr ['a.pid ='] = $province;
		}

		$data = $this ->hot_expert_model ->getMhotExpert($whereArr);
		
		echo json_encode($data);
	}
	//增加
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		$dataArr = $this ->commonFunc($postArr, 'add');		
		$status = $this ->hot_expert_model ->insert($dataArr);
		$u_data = array(
			'big_photo'=>$dataArr['smallpic'],  //封面
			'small_photo'=>$dataArr['pic']      //小头像
		);
		$this ->load_model('expert_model');
		$result=$this->expert_model->update($u_data,array(
				'id'=>$dataArr['expert_id']
		));
		if (empty($status) || !$result)
		{
			$this->callback->setJsonCode ( 4000 ,"添加失败");
		}
		else
		{
			$this ->log(1,3,$this->controllerName,'增加'.$this->controllerName);
			$this->callback->setJsonCode ( 2000 ,'添加成功');
		}
	}
	//编辑
	public function edit() {
		$postArr = $this->security->xss_clean($_POST);
	
		if (empty($postArr['id'])) {
			$this->callback->setJsonCode ( 4000 ,"缺少编辑的数据");
		}
		$dataArr = $this->commonFunc($postArr, 'edit');
		$status = $this ->hot_expert_model ->update($dataArr ,array('id' =>intval($postArr['id'])));
		$u_data = array(
				'big_photo'=>$dataArr['smallpic'],  //封面
				'small_photo'=>$dataArr['pic']      //小头像
		);
		$this ->load_model('expert_model');
		$result=$this->expert_model->update($u_data,array(
				'id'=>$dataArr['expert_id']
		));
		if (empty($status) || !$result) {
			$this->callback->setJsonCode ( 4000 ,"编辑失败");
		} else {
			$this->log(3,3,$this->controllerName,'编辑'.$this->controllerName);
			$this->callback->setJsonCode ( 2000 ,"编辑成功");
		}
	}
	//添加编辑时公用
	public function commonFunc($postArr ,$type)
	{
		if (empty($postArr['expertId']))
		{
			$this->callback->setJsonCode ( 4000 ,'请选择管家');
		}
		else
		{
			if ($type == 'add') {
				$data = $this ->hot_expert_model ->row(array('expert_id' =>$postArr['expertId']) ,'arr' ,'' ,'id');
			} else {
				$data = $this ->hot_expert_model ->row(array('expert_id'=>$postArr['expertId'] ,'id !='=>$postArr['id'] ));
			}
			if (!empty($data))
			{
				$this->callback->setJsonCode ( 4000 ,'此管家已是'.$this->controllerName.'，请重新选择');
			}
		}
		if (empty($postArr['pic']))
		{
			$this ->load_model('expert_model');
			$expertData = $this ->expert_model ->row(array('id'=>$postArr['expertId']) ,'arr' ,'' ,'city,small_photo');
			$pic = $expertData['small_photo'];
		}
		else
		{
			$pic = $postArr['pic'];
		}
                if (empty($postArr['smallpic']))
		{
			$this ->load_model('expert_model');
			$expertData = $this ->expert_model ->row(array('id'=>$postArr['expertId']) ,'arr' ,'' ,'city,big_photo');
			$smallpic = $expertData['big_photo'];
		}
		else
		{
			$smallpic = $postArr['smallpic'];
		}
		
		return array(
				'expert_id' =>intval($postArr['expertId']),
				'pic' =>$pic,
                                'smallpic'=>$smallpic,
				'is_modify' =>intval($postArr['is_modify']),
				'is_show' =>intval($postArr['is_show']),
				'beizhu' =>trim($postArr['beizhu']),
				'showorder' =>empty($postArr['showorder']) ? 999 : intval($postArr['showorder']),
				'startplaceid' =>$postArr['city']
		);
	}
	
	//获取某条数据
	public function getDetailjson ()
	{
		$id = intval($this ->input ->post('id'));
		$data=$this ->hot_expert_model ->getMobileExpertDetail($id);
		echo json_encode($data);
	}

	//删除
	function delete(){
		$id = intval($this->input->post("id"));
		$status = $this ->hot_expert_model ->delete(array('id'=>$id));
		if (empty($status)) {
			$this->callback->setJsonCode ( 4000 ,"删除失败");
		} 
		else {
			$this ->log(2,3,$this->controllerName,'平台删除'.$this->controllerName.',记录ID:'.$id);
			$this->callback->setJsonCode ( 2000 ,"删除成功");
		}
	}
}