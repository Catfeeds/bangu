<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @author 何俊       
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Expert_list extends UC_NL_Controller {
	private $whereArr = array('e.status' =>2,'e.is_commit' =>1); //保存管家的搜索条件
	private $dataArr = array(
			'grade' =>'0',
			'sex' =>'0',
			'visit_service' =>0,
			'order' =>1,
			'search_type' =>1
	);
	private $postArr = array();//搜索条件
	private $sexArr = array(0=>'不限' ,1=>'男' ,'2' =>'女');
	private $orderBy = ' order by e.online desc,e.total_score desc ';
	private $page = 1;
	
	public function __construct() {
		parent::__construct ();
		//set_error_handler('customError');
		$this->load_model ( 'expert_model', 'expert_model' );
		$this ->load_model('expert_grade_model');
		$this->load->helper ( 'kefu' );
	}
	
	
	/**
	 * @method 专家列表
	 * @since 2015-11-03
	 * @author jiakairong
	 */
	public function index($url = '')
	{
		//解析url
		$this ->analyticalUrl($url);
		//没有搜索管家所在城市则使用默认城市
		if (empty($this ->whereArr['e.city']))
		{
			$this ->dataArr['cityName'] = $this ->session ->userdata('city_location');
			$this ->dataArr['cityId'] = $this ->session ->userdata('city_location_id');
			$this ->whereArr['e.city'] = $this ->session ->userdata('city_location_id');
		}
		//管家服务地区
		$this ->load_model('area_model');
		$regionArr = $this ->area_model ->all(array('pid' =>$this ->whereArr['e.city'] ,'isopen' =>1));
		$this ->dataArr['regionArr'] = array('0'=>'不限');
		foreach($regionArr as $val)
		{
			$this ->dataArr['regionArr'][$val['id']] = $val['name'];
		}
		//性别
		$this ->dataArr['sexArr'] = $this ->sexArr;
		//管家级别
		$gradeData = $this ->expert_grade_model ->all(array() ,'grade asc');
		$this ->dataArr['expertGrade'] = array('0' =>'不限');
		foreach($gradeData as $val)
		{
			$this ->dataArr['expertGrade'][$val['grade']] = $val['title'];
		}
		
		// 用户设计方案
		$this ->dataArr['customer_lines'] = $this->expert_model->get_customer_lines (array('ca.isuse' =>1 ,'c.status' =>3) ,1 ,40);
		//管家数据
       	$expertArr = $this ->expert_model ->get_expert_list($this->whereArr ,$this ->page ,sys_constant::PAGE_SIZE ,$this ->orderBy);
      	//echo $this ->db ->last_query();
        //管家数据
        $this ->dataArr['expertData'] = $this ->expertReform($expertArr['expertData'] ,$this ->dataArr['regionArr']);
        //分页
        $this ->getPageStr($expertArr['count']);
        unset($expertArr);
        
		$this->load->view ( 'expert/expert_list_view', $this->dataArr );
		//$this->output->enable_profiler(TRUE);
	}
	/**
	 * @method 解析url地址参数
	 * @param unknown $url  地址栏的传参
	 */
	protected function analyticalUrl($url)
	{
		$urlArr = explode('_', $url);
		foreach($urlArr as $val)
		{
			$parameterArr = explode('-', $val);
			$firstStr = array_shift($parameterArr);
			switch($firstStr)
			{
				case 'c': //管家所在地ID
					if (!empty($parameterArr['0']))
					{
						$this ->load_model('common/u_area_model' ,'area_model');
						//获取管家所在城市
						$areaData = $this ->area_model ->row(array('id' =>intval($parameterArr['0']) ,'isopen' =>1));
						if (!empty($areaData))
						{
							$this ->dataArr['cityName'] = $areaData['name'];
							$this ->dataArr['cityId'] = $areaData['id'];
							$this ->whereArr['e.city'] = $areaData['id'];
						}
					}
					break;
				case 's': //性别
					$sex = empty($parameterArr[0]) ? 0 : intval($parameterArr[0]);
					if ($sex == 1)
					{
						$this ->whereArr['e.sex'] = $sex;
					}
					elseif ($sex == 2)
					{
						$this ->whereArr['e.sex'] = 0;
					}
					$this ->dataArr['sex'] = $sex;
					break;
				case 'g'://管家级别
					if (empty($parameterArr[0]))
					{
						$this ->dataArr['grade'] = 0;
					}
					else 
					{
						$this ->dataArr['grade'] = intval($parameterArr[0]);
						$this ->whereArr['e.grade'] = $this ->dataArr['grade'];
					}
					break;
				case 'd': //目的地ID
					if (!empty($parameterArr[0]))
					{
						//获取目的地名称 
						$this ->load_model('dest/dest_base_model' ,'dest_base_model');
						$destData = $this ->dest_base_model ->row(array('id' =>intval($parameterArr[0])));
						if (!empty($destData))
						{
							$this ->whereArr['l.overcity'] = array($destData['id']);
							$this ->whereArr['la.status'] = 2;
							$this ->whereArr['l.status'] = 2;
							$this ->dataArr['destId'] = $destData['id'];
							$this ->dataArr['destName'] = $destData['kindname'];
						}
					}
					break;
				case 'vs'://上门服务
					if (empty($parameterArr[0]))
					{
						$this ->dataArr['visit_service'] = 0;
					}
					else 
					{
						$this ->dataArr['visit_service'] = intval($parameterArr[0]);
						$this ->whereArr['e.visit_service'] = array($this ->dataArr['visit_service']);
					}
					break;
				case 'na'://管家昵称 or 头部搜索
					if (!empty($parameterArr[0])) 
					{
						$this ->dataArr['expertName'] = trim(urldecode($parameterArr[0]));
						$this ->whereArr['e.nickname'] = $this ->dataArr['expertName'];
					}
					break;
				case 'o': //排序
					$order = empty($parameterArr[0]) ? 1 : intval($parameterArr['0']);
					switch($order) {
						case 1:
							$this ->orderBy = ' order by e.online desc,e.total_score desc ';
							break;
						case 2:
							//满意度
							$this ->orderBy = ' order by e.online desc,e.satisfaction_rate desc ';
							break;
						case 3:
							//年销人数
							$this ->orderBy = ' order by e.online desc,e.people_count desc ';
							break;
						case 4:
							//年成交额
							$this ->orderBy = ' order by e.online desc,e.order_amount desc ';
							break;
						default:
							$order = 1;
							$this ->orderBy = ' order by e.online desc,e.total_score desc ';
							break;
					}
					$this ->dataArr['order'] = $order;
					break;
				case 'p': //分页
					$this ->page = empty($parameterArr[0]) ? 1 :intval($parameterArr[0]);
					break;
			}
		}
	}
	/**
	 * @method 对获取的数据进行处理，目的地，上门服务地区
	 * @param unknown $data  获取的管家数据
	 * @param array   $regionData  当前管家所在城市的区域
	 * @return unknown
	 */
	private function expertReform($data ,$regionData) {
		unset($regionData[0]);
		//目的地数据
		$this ->load_model('destinations_model' ,'dest_model');
		$destData = $this ->dest_model ->all(array('level' =>2) ,'' ,'arr' ,'id,kindname');
		$destArr = array();
		if (!empty($destData)) {
			foreach($destData as $val) {
				$destArr[$val['id']] = $val['kindname'];
			}
		}
		unset($destData);
		//对数据进行处理
		foreach($data as $key=>$val) {
			$expertCity = '';
			$expertDest = '';
			//上门服务
			if (!empty($val['visit_service'])) {
				$a = 1;
				$serviceArr = explode(',' ,$val['visit_service']);
				foreach($serviceArr as $v) {
					if (array_key_exists($v,$regionData)) {
						if ($a > 3) {
							continue;
						}
						$expertCity .= $regionData[$v].'、';
						$a ++ ;
					}
				}
			}
			$data[$key]['expertCity'] = rtrim($expertCity ,'、');
		
			//擅长目的地
			if (!empty($val['expert_dest'])) {
				$b = 1;
				$destIds = explode(',' ,$val['expert_dest']);
				foreach($destIds as $v) {
					if (array_key_exists($v ,$destArr)) {
						if ($b > 3) {
							continue;
						}
						$expertDest .= $destArr[$v].'、';
						$b ++ ;
					}
				}
			}
			$data[$key]['expertDest'] = rtrim($expertDest ,'、');
		}
		return $data;
	}
	/**
	 * @method 分页
	 * @param unknown $page
	 * @param unknown $count
	 * @param unknown $url
	 */
	private function getPageStr ($count)
	{
		$this ->dataArr['page_count'] = ceil($count /sys_constant::PAGE_SIZE); //总页数
		if ($this ->page > $this ->dataArr['page_count'])
		{
			$this ->page = $this ->dataArr['page_count'];
		}
		if ($this ->dataArr['page_count'] == 0)
		{
			$this ->page = 0;
		}
		$this->load->library ( 'page_ajax' );
		$config['pagesize'] = sys_constant::PAGE_SIZE;
		$config['page_now'] = $this ->page;
		$config['pagecount'] = $count;
		$config['base_url'] = '/expert/expert_list/index_';
		$this->page_ajax->initialize ( $config );
		
		$this ->dataArr['page_string'] = $this ->page_ajax ->create_page();
		$this ->dataArr['page'] = $this ->page;
	}
}