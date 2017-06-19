<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年5月7日18:35:53
 * @author		jiakairong
 * @method 		首页主题线路
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Sc_theme_line extends UA_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load_model('admin/a/sc_theme_line_model','theme_line_model');
	}

	function index(){
		$data['cfg_theme'] = $this->theme_line_model->get_cfg_theme();
		$this->load_view ( 'admin/a/sc_cfg/sc_theme_line_list',$data);
	}

	public function getKindThemeData() {
		$whereArr = array();
		$page_new = intval($this ->input ->post('page_new'));
		$page_new = empty($page_new) ? 1: $page_new;
		//$name = trim($this ->input ->post('search_name' ,true));
		//$city = intval($this ->input ->post('start_city'));
		//$province = intval($this ->input ->post('start_province'));
		//$themeid = intval($this ->input ->post('search_theme'));

		/*if (!empty($themeid))
		{
			$whereArr['tl.theme_id = '] = $themeid;
		}
		if (!empty($name)) {
			$whereArr ['l.linename like'] = "%$name%";
		}
		if (!empty($city)) {
			$whereArr ['tl.startplaceid ='] = $city;
		} elseif (!empty($province)) {
			$whereArr ['s.pid ='] = $province;
		}*/

		//获取数据
		$data = $this ->theme_line_model ->getThemeLineData($whereArr ,$page_new ,sys_constant::A_PAGE_SIZE);
		echo json_encode($data);
	}
	//增加首页分类主题线路
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);

		$sellArr = $this ->commonSell($postArr, 'add');
		$status = $this ->theme_line_model ->insert($sellArr);
		if (empty($status))
		{
			$this->callback->set_code ( 4000 ,'添加失败');
			$this->callback->exit_json();
		}
		else
		{
			$this ->log(1,3,'深窗主题线路配置','深窗主题线路');
			$this->callback->set_code ( 2000 ,'添加成功');
			$this->callback->exit_json();
		}
	}
	//编辑首页分类主题线路
	public function edit() {
		$postArr = $this->security->xss_clean($_POST);

		if (empty($postArr['id'])) {
			$this->callback->set_code ( 4000 ,"缺少编辑的数据");
			$this->callback->exit_json();
		}
		$sellArr = $this ->commonSell($postArr, 'edit');
		$status = $this ->theme_line_model ->update($sellArr ,array('id' =>intval($postArr['id'])));
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"编辑失败");
			$this->callback->exit_json();
		} else {
			$this ->log(3,3,'深窗主题线路配置','编辑深窗主题线路');
			$this->callback->set_code ( 2000 ,"编辑成功");
			$this->callback->exit_json();
		}
	}
	//添加编辑时公用
	public function commonSell($postArr ,$type)
	{
		if(empty($postArr['theme_id']))
		{
			$this->callback->set_code ( 4000 ,"请选择主题");
			$this->callback->exit_json();
		}
		if (empty($postArr['line_id']))
		{
			$this->callback->set_code ( 4000 ,"请选择线路");
			$this->callback->exit_json();
		}
		else
		{
			if ($type == 'add')
			{
				$themeLine = $this ->theme_line_model ->row(array('line_id' =>$postArr['line_id'] ,'theme_id' =>$postArr['themeid'] ));
			}
			else
			{
				$themeLine = $this ->theme_line_model ->row(array('line_id'=>$postArr['line_id'] ,'theme_id' =>$postArr['themeid'],'id !='=>$postArr['id']));
			}
			if (!empty($themeLine))
			{
				$this->callback->set_code ( 4000 ,"当前线路主题下已存在此线路");
				$this->callback->exit_json();
			}
		}

		if (empty($postArr['pic']))
		{
			$this ->load_model('common/u_line_model' ,'line_model');
			$lineData = $this ->line_model ->row(array('id'=>$postArr['line_id']) ,'arr' ,'' ,'mainpic');
			if (empty($lineData))
			{
				$this->callback->set_code ( 4000 ,'线路不存在');
				$this->callback->exit_json();
			}
			$pic = $lineData['mainpic'];
		}
		else
		{
			$pic = $postArr['pic'];
		}

		return array(
				'theme_id' =>intval($postArr['theme_id']),
				'line_id ' =>intval($postArr['line_id']),
				'pic' =>$pic,
				'is_modify' =>intval($postArr['is_modify']),
				'is_show' =>intval($postArr['is_show']),
				'beizhu' =>trim($postArr['beizhu']),
				'showorder' =>empty($postArr['showorder']) ? 999 : intval($postArr['showorder'])
		);
	}

	//获取某条数据
	public function getOneData () {
		$id = intval($this ->input ->post('id'));
		$whereArr=array('tl.id ='=>$id);
		$data=$this ->theme_line_model ->getThemeLineData($whereArr);
		if (!empty($data)) {
			echo json_encode($data['data'][0]);
		}
	}

	//删除首页主题线路
	function delete(){
		$id = intval($this->input->post("id"));
		$status = $this ->theme_line_model ->delete(array('id'=>$id));
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"删除失败==>".$status);
			$this->callback->exit_json();
		}
		else {
			$this ->log(2,3,'深窗主题线路配置',"平台删除深窗主题线路,记录ID:{$id}");
			$this->callback->set_code ( 2000 ,"删除成功");
			$this->callback->exit_json();
		}
	}

	/**
	 * @method 获取首页分类主题
	 * @since  2015-11-27
	 */
	public function getKindThemeJson()
	{
		$this ->load_model('admin/a/index_kind_theme_model' ,'kind_theme_model');
		$kindTheme = $this ->kind_theme_model ->getKindThemeAll();
		$dataArr = array();
		foreach($kindTheme as $key =>$val)
		{
			if (empty($val['startplaceid']))
			{
				continue;
			}
			if (!array_key_exists($val['startplaceid'], $dataArr))
			{
				$dataArr[$val['startplaceid']]['name'] = $val['cityname'];
			}
			$dataArr[$val['startplaceid']]['themes'][] = array('themeid' =>$val['theme_id'] ,'theme_name' =>$val['theme_name']);
		}
		echo json_encode($dataArr);
	}

}