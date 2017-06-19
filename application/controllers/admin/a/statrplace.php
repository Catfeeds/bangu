<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月22日10:48:00
 * @author		贾开荣
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Statrplace extends UA_Controller {
	const pagesize = 10;
	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'admin/a/startplace_model', 'start_model' );
	}
	//出发城市列表
	public function index() {
		$this ->load_view('admin/a/ui/startplace');
	}
	//出发城市数据
	public function getStartplace() {
		$whereArr = array();
		$page_new = intval($this ->input ->post('page_new'));
		$page_new = empty($page_new) ? 1 : $page_new;
		
		$name = trim($this ->input ->post('search_name'));
		$isopen = intval($this ->input ->post('search_isopen'));
		$city = intval($this->input ->post('start_city'));
		$province = intval($this ->input ->post('start_province'));

		if (!empty($city)) {
			$whereArr ['s.id'] = $city;
		} elseif (!empty($province)) {
			$whereArr ['s.pid'] = $province;
		}
		
		if ($isopen == 1 || $isopen ==0) {
			$whereArr ['s.isopen'] = $isopen;
		}
		if (!empty($name)) {
			$whereArr['cityname'] = $name;
		}
		
		$data['list'] = $this->start_model->getStartplaceData($whereArr ,$page_new ,sys_constant::A_PAGE_SIZE);
		//echo $this ->db ->last_query();
		$count = $this ->getCountNumber($this ->db ->last_query());
		$data['page_string'] = $this ->getAjaxPage($page_new ,$count);
		
		echo json_encode($data);
	}
	//添加出发城市
	public function add() {
		$postArr = $this->security->xss_clean($_POST);
		
		$startArr = $this ->commonFunc($postArr, 'add');
		$id = $this ->start_model ->insert($startArr);
		if (empty($id)) {
			$this->callback->set_code ( 4000 ,"添加失败");
			$this->callback->exit_json();
		} else {
			$this ->log(1, 3, '出发城市管理', '添加出发城市，ID：'.$id);
			$this->callback->set_code ( 2000 ,"添加成功");
			$this->callback->exit_json();
		}
	}
	//编辑出发城市
	public function edit() {
		$postArr = $this->security->xss_clean($_POST);
		
		$startArr = $this ->commonFunc($postArr, 'edit');
		$status = $this ->start_model ->update($startArr ,array('id' =>intval($postArr['id'])));
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"编辑失败");
			$this->callback->exit_json();
		} else {
			$this ->log(3, 3, '出发城市管理', '编辑出发城市，ID：'.$postArr['id']);
			$this->callback->set_code ( 2000 ,"编辑成功");
			$this->callback->exit_json();
		}
	}
	//添加，编辑公用
	public function commonFunc($postArr ,$type) {
		$country = isset($postArr['country']) ? intval($postArr['country']) : 0;
		$province = isset($postArr['province']) ? intval($postArr['province']) : 0;
		$city = isset($postArr['city']) ? intval($postArr['city']) : 0;
		$start_country = isset($postArr['start_country']) ? intval($postArr['start_country']) : 0;
		$start_province = isset($postArr['start_province']) ? intval($postArr['start_province']) : 0;
		
		if (empty($country) && empty($province) && empty($city)) {
			$this->callback->set_code ( 4000 ,"请选择城市");
			$this->callback->exit_json();
		} else {
			//判断城市是否已是出发城市
			$city = empty($city) ? $province : $city;
			$city = empty($city) ? $country : $city;
			if ($type == 'add') {
				$startData = $this ->start_model ->row(array('areaid' =>$city));
			} else {
				$startData = $this ->start_model ->row(array('areaid' =>$city ,'id !=' =>intval($postArr['id'])));
			}
			//echo $this ->db ->last_query();
			if (!empty($startData)) {
				$this->callback->set_code ( 4000 ,"此城市已是出发城市");
				$this->callback->exit_json();
			}
			//获取城市名称 
			$this ->load_model('admin/a/area_model' ,'area_model');
			$areaData = $this ->area_model ->row(array('id' =>$city));
			if (!empty($areaData)) {
				$cityname = $areaData['name'];
			} else {
				$this->callback->set_code ( 4000 ,"城市错误");
				$this->callback->exit_json();
			}
		}
		if (empty($postArr['enname'])) {
			$this->callback->set_code ( 4000 ,"请填写全拼");
			$this->callback->exit_json();
		}
		if (empty($postArr['simplename'])) {
			$this->callback->set_code ( 4000 ,"请填写简拼");
			$this->callback->exit_json();
		}
		//计算级别
		$pid = empty($start_province) ? $start_country : $start_province;
		if ($pid == 0) {
			$level = 1;
		} else {
			$startData = $this ->start_model ->row(array('id' =>$pid));
			$level = $startData['level'] + 1;
		}
		
		return array(
			'cityname' =>$cityname,
			'enname' =>trim($postArr['enname']),
			'simplename' =>trim($postArr['simplename']),
			'isopen' =>intval($postArr['isopen']),
			'displayorder' =>empty($postArr['displayorder']) ? 999 :intval($postArr['displayorder']),
			'ishot' =>intval($postArr['ishot']),
			'areaid' =>$city,
			'pid' =>$pid,
			'level' =>$level
		);
		
	}
	
	//启用
	public function enable() {
		$id = intval($this ->input ->post('id'));
		$status = $this ->start_model ->update(array('isopen' =>1) ,array('id'=>$id));
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"启用失败");
			$this->callback->exit_json();
		} else {
			$this ->log(3,3,'出发城市管理','启用出发城市,城市ID：'.$id);
			$this->callback->set_code ( 2000 ,"启用成功");
			$this->callback->exit_json();
		}
	}
	//禁用
	public function desable() {
		$id = intval($this ->input ->post('id'));
		$status = $this ->start_model ->update(array('isopen' =>0) ,array('id'=>$id));
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"禁用失败");
			$this->callback->exit_json();
		} else {
			$this ->log(3,3,'出发城市管理','禁用出发城市,城市ID：'.$id);
			$this->callback->set_code ( 2000 ,"禁用成功");
			$this->callback->exit_json();
		}
	}

	//获取一条记录
	public function getOneData() {
		$id = intval($this ->input ->post('id'));
		$startData = $this ->start_model ->getStartplaceData(array('s.id' =>$id));
		if (!empty($startData)) {
			$startData = $startData['0'];
			$parentData = $this ->start_model ->row(array('id' =>$startData['pid']));
			if (!empty($parentData)) {
				$startData['parentid'] = $parentData['pid'];
			}
			$this ->load_model('admin/a/area_model' ,'area_model');
			$areaData = $this ->area_model ->row(array('id' =>$startData['areaid']));
			if (!empty($areaData['pid'])) {
				$startData['areaPid'] = $areaData['pid'];
				$areaData = $this ->area_model ->getParents($areaData['pid']);
				if (!empty($areaData)) {
					$startData['areaParentId'] = $areaData['parentid'];
				}
			}
			echo json_encode($startData);
		}
	}
	//获取出发城市
	public function get_startcity_data () {
		$this ->load_model('admin/a/startplace_model' ,'start_model');
		$startplace = $this ->start_model ->all(array('isopen' =>1,'level'=>3),'id asc');
		echo json_encode($startplace);
	}
	public function __destruct() {
		$this ->db ->close();
	}
}
