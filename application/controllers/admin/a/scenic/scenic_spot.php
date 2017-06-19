<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月20日11:59:53
 * @author		jiakairong
 * @method 		景区管理
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Scenic_spot extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model ( 'scenic_spot_model', 'scenic_model' );
	}
	public function index()
	{
		$this->view ( 'admin/a/scenic_spot/scenic_spot' );
	}
	//返回景点数据
	public function getScenicSpotData()
	{
		$whereArr = array();
		$postArr = $this->security->xss_clean($_POST);
		
		switch($postArr['status'])
		{
			case 1:
			case 2:
			case 0:
			case -1:
				$whereArr ['s.status = '] = $postArr['status'];
				break;
			default:
				echo json_encode($this->defaultArr);exit;
				break;
		}
		if (!empty($postArr['name']))
		{
			$whereArr['s.name like'] = '%'.trim($postArr['name']).'%';
		}
		if (!empty($postArr['username']))
		{
			$whereArr['a.username like'] = '%'.trim($postArr['username']).'%';
		}
		if (!empty($postArr['starttime']))
		{
			$whereArr['s.open_time >='] = trim($postArr['starttime']);
		}
		if (!empty($postArr['endtime']))
		{
			$whereArr['s.open_time <='] = trim($postArr['endtime']).' 23:59:59';
		}
		if (!empty($postArr['ishot']))
		{
			$ishot = $postArr['ishot'] == 2 ? 0 : $postArr['ishot'];
			$whereArr['s.ishot ='] = $ishot;
		}
		if (!empty($postArr['city_id']))
		{
			$whereArr['s.city_id ='] = $postArr['city_id'];
		}
		elseif (!empty($postArr['province_id']))
		{
			$whereArr['d.pid ='] = $postArr['province_id'];
		}
		elseif (!empty($postArr['country_id']))
		{
			$whereArr['ud.pid ='] = $postArr['country_id'];
		}
		//获取数据
		$data = $this ->scenic_model ->getScenicSpotData ($whereArr);
		//echo $this ->db ->last_query();
		echo json_encode($data);
	}
	//<script src="http://maps.google.cn/maps/api/js?key=AIzaSyBSKn-aQjNNb5S2sdsirPTevHU325xBoVI&callback=initMap" async defer></script>
	//获取景点图片
	public function getScenicPic()
	{
		$id = intval($this ->input ->post('id'));
		$picData = $this ->scenic_model ->getScenicPic($id);
		echo json_encode($picData);
	}
	//景点图片管理
	public function updatePic() 
	{
		$id = intval($this ->input ->post('picid'));
		$index = intval($this ->input ->post('index')); //主图
		$piclist = rtrim($this ->input ->post('piclist') ,',');
		if (empty($piclist))
		{
			$this ->callback ->setJsonCode(4000 ,'请上传图片');
		}
		$picArr = explode(',', $piclist);
		$mainpic = $picArr[$index];
		unset($picArr[$index]);
		array_unshift($picArr ,$mainpic);
		$scenicArr =array();
		foreach($picArr as $val)
		{
			$scenicArr[] = array(
					'pic' =>$val,
					'scenic_spot_id' =>$id
			);
		}
		$status = $this ->scenic_model ->updatePic($id ,$scenicArr ,$mainpic);
		if ($status == true)
		{
			$this ->log(3,3,'景点管理','更改景点图片,ID:'.$id);
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
		else
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
	}
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		$status = $this ->commonFunc($postArr);
		if ($status == true)
		{
			$this ->log(1,3,'景点管理','添加景点');
			$this->callback->setJsonCode(2000 ,'添加成功');
		}
		else
		{
			$this->callback->setJsonCode(2000 ,'添加失败');
		}
	}
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
		$status = $this ->commonFunc($postArr);
		if ($status == true)
		{
			$this ->log(3,3,'景点管理','编辑景点');
			$this->callback->setJsonCode(2000 ,'编辑成功');
		}
		else
		{
			$this->callback->setJsonCode(2000 ,'编辑失败');
		}
	}
	//批量启用
	public function batchEnable()
	{
		$ids = trim($this->input->post('ids'));
		if (empty($ids))
		{
			$this->callback->setJsonCode(4000 ,'没有选择处理的数据');
		}
// 		$idArr = explode(',', rtrim($ids ,','));
// 		//var_dump($idArr);
// 		foreach($idArr as $v) {
// 			$this->scenic_model->update(array('status' =>1) ,array('id' =>$v));
// 			//echo $this->db ->last_query();
// 		}
		$this ->scenic_model ->batchUpdate(rtrim($ids ,',') ,$this->admin_id);
		$this->callback->setJsonCode(2000 ,'处理成功');
	}
	
	//添加编辑公用部分
	public function commonFunc($postArr)
	{
		$name = trim($postArr['name']);
		//$phone = trim($postArr['phone']);
		$address = trim($postArr['address']);
		//$money = floatval($postArr['money']);
		$lat = trim($postArr['lat']);
		$lng = trim($postArr['lng']);
		$geohash = trim($postArr['geohash']);
		$country_id = intval($postArr['country_id']);
		$province_id = intval($postArr['province_id']);
		$city_id = intval($postArr['city_id']);
		$id = empty($postArr['id']) ? '' : intval($postArr['id']);
		$piclist = trim($postArr['piclist']);
		$index = trim($postArr['index']);
		if (empty($lat) || empty($lng) || empty($geohash))
		{
			$this->callback->setJsonCode(4000 ,'获取经纬度错误');
		}
		if ($city_id < 1) {
			$this->callback->setJsonCode(4000 ,'请选择景点地区到第三级');
		}
		if (empty($name))
		{
			$this->callback->setJsonCode(4000 ,'请填写景点名称');
		}
		if (empty($piclist))
		{
			$this->callback->setJsonCode(4000 ,'请上传图片');
		}
// 		if (empty($address))
// 		{
// 			$this->callback->setJsonCode(4000 ,'请填写详细地址');
// 		}
// 		$this ->load_model('scenic_spot_belong_model' ,'belong_model');
// 		$belongData = $this ->belong_model ->row(array('country_id' =>$country_id ,'province_id' =>$province_id ,'city_id' =>$city_id));
// 		if (empty($belongData))
// 		{
// 			$this->callback->setJsonCode(4000 ,'景点地区有误');
// 		}
		$picArr = explode(',', trim($piclist ,','));
		$mainpic = $this ->compressImg($picArr[$index]);
		
		$scenicArr = array(
			'name' =>$name,
			'address' =>$address,
			'description' =>trim($postArr['description']),
			'longitude' =>$lng,
			'latitude' =>$lat,
			'geohash' =>$geohash,
			'ishot' =>$postArr['ishot'],
			'displayorder' => empty($postArr['displayorder']) ? 9999 : $postArr['displayorder'],
			'status' =>intval($postArr['isopen']),
			'mainpic' =>$mainpic,
			'rawPic' =>$picArr[$index],
			'pic_num' =>count($picArr),
			'open_time' =>date('Y-m-d H:i:s' ,time()),
			'city_id' =>$city_id
		);
		if (empty($id))
		{
			$scenicArr['open_time'] = date('Y-m-d H:i:s' ,time());
			$scenicArr['admin_id'] = $this->admin_id;
			return $this ->scenic_model ->insertScenic($scenicArr ,$picArr);
		}
		else 
		{
			return $this ->scenic_model ->updateScenic($scenicArr ,$picArr ,$id);
		}
	}
	//压缩图片
	public function compressImg($picSrc)
	{
		if (!file_exists($picSrc)) 
		{
			return $picSrc;
		}
		$picName = substr($picSrc ,0 ,strrpos($picSrc ,'.')).'_thumb'.substr($picSrc, strrpos($picSrc ,'.'));
		if (file_exists($picName)) {
			return $picName;			
		}
		$config['image_library'] = 'gd2';
		$config['source_image'] = $picSrc;
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width']     = 135;
		$config['height']   = 100;

		$this->load->library('image_lib', $config);
		$status = $this->image_lib->resize();
		if ($status == true)
		{
			return $picName;
		}
		else 
		{
			return $picSrc;	
		}
	}
	
	//景点详细
	public function getScenicDetail() 
	{
		$id = intval($this ->input ->post('id'));
		$data = $this ->scenic_model ->getScenicDetail($id);
		$picData = $this ->scenic_model ->getScenicPic($id);
		$dataArr = array(
				'detail' =>$data,
				'pic' =>$picData
		);
		echo json_encode($dataArr);
	}
	//禁用景点
	public function disable() 
	{
		$id = intval($this ->input ->post('id'));
		$status = $this ->scenic_model ->update(array('status' =>2) ,array('id' =>$id));
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'禁用失败');
		}
		else
		{
			$this ->log(3,3,'景点管理','禁用景点,ID:'.$id);
			$this ->callback ->setJsonCode(2000 ,'禁用成功');
		}
	}
	//启用景点
	public function enable()
	{
		$id = intval($this ->input ->post('id'));
		$dataArr = array(
				'status' =>1,
				'admin_id' =>$this->admin_id,
				'open_time' =>date('Y-m-d H:i:s' ,time())
		);
		$status = $this ->scenic_model ->update($dataArr ,array('id' =>$id));
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'启用失败');
		}
		else
		{
			$this ->log(3,3,'景点管理','启用景点,ID:'.$id);
			$this ->callback ->setJsonCode(2000 ,'启用成功');
		}
	}
	//设为热门
	public function addHot()
	{
		$id = intval($this ->input ->post('id'));
		$status = $this ->scenic_model ->update(array('ishot' =>1) ,array('id' =>$id));
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else
		{
			$this ->log(3,3,'景点管理','添加景点热门,ID:'.$id);
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
	}
	//取消热门
	public function cancelHot()
	{
		$id = intval($this ->input ->post('id'));
		$status = $this ->scenic_model ->update(array('ishot' =>0) ,array('id' =>$id));
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else
		{
			$this ->log(3,3,'景点管理','取消景点热门,ID:'.$id);
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
	}
	//审核通过景点
	public function through()
	{
		$id = intval($this ->input ->post('id'));
		$scenicData = $this ->scenic_model ->row(array('id' =>$id));
		if (empty($scenicData))
		{
			$this ->callback ->setJsonCode(4000 ,'数据不存在');
		}
		if ($scenicData['status'] != 0)
		{
			$this ->callback ->setJsonCode(4000 ,'景点不在审核状态');
		}
		$dataArr = array(
				'status' =>1,
				'admin_id' =>$this ->admin_id,
				'open_time' =>date('Y-m-d H:i:s' ,time())
		);
		$status = $this ->scenic_model ->update($dataArr ,array('id' =>$id));
		if ($status == true)
		{
			$this ->log(3,3,'景点管理','审核通过景点,ID:'.$id);
			$this ->callback ->setJsonCode(2000 ,'通过成功');
		} 
		else
		{
			$this ->callback ->setJsonCode(4000 ,'通过失败');
		}
	}
	//审核拒绝景点
	public function refuse()
	{
		$id = intval($this ->input ->post('id'));
		$scenicData = $this ->scenic_model ->row(array('id' =>$id));
		if (empty($scenicData))
		{
			$this ->callback ->setJsonCode(4000 ,'数据不存在');
		}
		if ($scenicData['status'] != 0)
		{
			$this ->callback ->setJsonCode(4000 ,'景点不在审核状态');
		}
		$dataArr = array(
				'status' =>-1,
				'admin_id' =>$this ->admin_id,
				'open_time' =>date('Y-m-d H:i:s' ,time())
		);
		$status = $this ->scenic_model ->update($dataArr ,array('id' =>$id));
		if ($status == true)
		{
			$this ->log(3,3,'景点管理','审核拒绝景点,ID:'.$id);
			$this ->callback ->setJsonCode(2000 ,'拒绝成功');
		}
		else
		{
			$this ->callback ->setJsonCode(4000 ,'拒绝失败');
		}
	}
}