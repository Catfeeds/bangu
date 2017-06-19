<?php

/**
 * @copyright	深圳海外国际旅行社有限公司
 * @author		何俊
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Line_list extends UC_NL_Controller {
	//线路搜索条件
	public $whereArr = array(
			'status' =>2,
			'producttype' =>0
	); 
	//默认排序
	public $orderBy = 'ordertime asc';//,l.satisfyscore desc,l.peoplecount desc
	//当前页数
	public $pageNow = 1;
        /*cj改为chujing,gn改为guonei,zb改为zhoubian,zt改为zhuti 魏勇编辑*/
	public $destNavArr = array(
			'chujing' =>'出境游',
			'guonei' =>'国内游',
			'zhoubian' =>'周边游',
			'zhuti' =>'主题游'
		);
	//保存搜索的目的地，主题，线路属性的条件数组，用于页面的搜索按钮显示
	public $buttonArr = array();
	public $dataArr = array();
	
	public function __construct() {
		parent::__construct ();
		//set_error_handler('customError');
		$this->load_model ( 'line_model', 'line_model' );
		$this ->load_model('line_attr_model' ,'attr_model');
		$this ->load_model('dest/dest_base_model' ,'dest_base_model');
		$this ->load_model('dest/dest_cfg_model' ,'dest_cfg_model');
		$this ->load_model('theme_model' ,'theme_model');
		$this->load->helper ('my_text');
		$this->load->helper ( 'kefu' );
	}
	
	public function index($type = '',$url = '')
	{
		
		$this ->whereArr['type'] = $type;
		$this ->dataArr['type'] = $this ->whereArr['type'];
		
		//解析url获取搜索条件
		$this ->analyticalUrl($url);
		//生成搜素条件的显示按钮
		$this ->createButton($this ->whereArr ,$url);
		//地址中没有出发城市则使用当前站点
		if (!isset($this->whereArr['startcity']))
		{
			$this ->whereArr['startcity'] = $this ->session ->userdata('city_location_id');
		}
		//线路类型不存在则默认全部
		if (!isset($this ->whereArr['type'])) {
			$this ->whereArr['type'] = 'all';
			$this ->dataArr['type'] = 'all';
		}
		
		//获取目的地 or 取主题
		switch($this ->whereArr['type'])
		{
			case 'guonei'://国内
				$this ->dataArr['lineType'] = $this ->getLineDest(1 ,$url);
				break;
			case 'chujing'://境外
				$this ->dataArr['lineType'] = $this ->getLineDest(2 ,$url);
				break;
			case 'zhoubian': //周边游
				$this ->dataArr['lineType'] = $this ->getTripDest($this ->whereArr['startcity'] ,$url);
				break;
			case 'zhuti': //主题游
				$this ->dataArr['lineType'] = $this ->getLineTheme($url);
				break;
			default:
				$this ->dataArr['type'] = 'all';
				$this ->dataArr['lineType'] = $this ->getLineDest(0 ,$url);
				break;
		}
		
		//区分是主题还是目的地,并将线路类型归类,注意：此方法要放在上边switch的后面使用
		$this ->distinguishDestTheme($this ->dataArr['lineType']);
		
		//unset($this ->whereArr['startcity']);
		$this ->dataArr['buttonArr'] = $this ->buttonArr;
		//获取子站点(子站点获取要在buttonArr方法调用之后)
		$this ->load_model('startplace_child_model' ,'child_model');
		$childData = $this ->child_model ->all(array('startplace_id' =>$this ->whereArr['startcity']));
		if (!empty($childData))
		{
			foreach($childData as $val)
			{
				$this ->whereArr['startcity'] .= ','.$val['startplace_child_id'];
			}
		}
		//获取全国出发的出发城市ID
		$this ->load_model('startplace_model');
		$startData = $this ->startplace_model ->row(array('cityname' =>'全国出发'));
		
		if (!empty($startData))
		{
			$this ->whereArr['startcity'] .= ','.$startData['id'];
			$this ->whereArr['startcity'] = trim($this ->whereArr['startcity'] ,',');
		}
		
		//热门线路&销量排行
		$this ->dataArr['hotLine'] = $this ->getLineHot();
		if ($this ->whereArr['type'] == 'zb' && empty($this ->dataArr['lineType'])) 
		{
			//周边游但出发城市没有周边目的地，则数据为空
			//注销type条件要在销量排行之后
			unset($this ->whereArr['type']);
			//线路数据
			$lineData = array('count' =>0 ,'list' => array());
		} else  {
			//注销type条件要在销量排行之后
			unset($this ->whereArr['type']);
			//线路数据
			$this->whereArr['startplace_ids'] = explode(',', $this->whereArr['startcity']);
			if (isset($this->whereArr['themeid']) && $this->whereArr['themeid']!==0) {
				$this->whereArr['themeid'] = explode(',', $this->whereArr['themeid']);
			}
			
			if (!empty($this->whereArr['expert_ids']))
			{
				$this->whereArr['expert_ids'] = array($this->whereArr['expert_ids']);
			}
			unset($this ->whereArr['startcity']);
			$this ->whereArr['line_kind'] = 1;
			//var_dump($this ->whereArr);
			//$lineData = $this ->line_model ->getLineData($this ->whereArr ,$this->pageNow ,sys_constant::PAGE_SIZE ,$this->orderBy);
			$lineData = $this ->line_model ->line_list_sphinx($this ->whereArr ,$this->pageNow ,sys_constant::PAGE_SIZE ,$this->orderBy);
		}
		$this ->dataArr['lineArr'] = $this ->getLineDate($lineData['list']);
		$this ->dataArr['count'] = ceil($lineData['count'] /sys_constant::PAGE_SIZE);
		$this ->dataArr['page'] = $this ->pageNow;
		//分页
		$this ->getPageStr($lineData['count'] ,$url);
		//轮播图
		$this ->dataArr['rollPic'] = $this ->getRollPic(); 
		//线路类型导航
		$this ->dataArr['destNavArr'] =$this ->destNavArr;
		//线路属性
		$this ->dataArr['lineAttr'] = $this ->getLineAttr($url);
		
		//上一页，下一页的url
		$this ->dataArr['url'] = $this ->createUrl($url, array('pa'));
		//关键字and 价格搜索url
		$this ->dataArr['surl'] = $this ->createUrl($url, array('kw' ,'pa'));
		//排序url
		$this ->dataArr['orderUrl'] = $this ->createUrl($url, array('pa' ,'o'));
		
		//seo语句组装
		$this ->getSeo();
		$this->load->view ( 'line/line_list_view', $this ->dataArr );
	}

	
	/**
	 * @method 组装视图层的seo语句
	 * @since  2015-12-15
	 */
	protected function getSeo()
	{
		switch($this ->dataArr['type'])
		{
			case 'chujing': //出境游
				$this ->dataArr['title'] = '出境游_出境跟团游_自助游_自由行_出国旅游-帮游旅行网';
				$this ->dataArr['keywords'] = '出境游旅行社,春节出境游,出国游,自助游,跟团游';
				$this ->dataArr['description'] = '帮游旅游网为您提供世界各地出境旅游跟团游，自助游，港澳游以及出境旅游线路、景点、价格、攻略等出境旅游服务';
				break;
			case 'guonei': //国内游
				$this ->dataArr['title'] = '国内游_国内旅游价格_国内旅游线路-帮游旅行网';
				$this ->dataArr['keywords'] = '国内旅游线路,,国内旅游景点,国内旅游价格';
				$this ->dataArr['description'] = '帮游旅游网提供全国各地优质旅游线路，为您的旅途提供国内旅游线路、景点、价格、攻略以及周边旅游、蜜月旅游等一站式国内旅游服务';
				break;
			case 'zhoubian': //周边游
				$this ->dataArr['title'] = '周边游_周边旅游线路_周末跟团游-帮游旅行网';
				$this ->dataArr['keywords'] = '周边旅游,周边旅游游路线,周边旅游景点';
				$this ->dataArr['description'] = '帮游旅游网为您提供专业的周边旅游服务，为您规划好您所在城市的周边旅游线路、价格，旅游景点推荐、攻略、旅游管家等周边旅游服务';
				break;
			case 'zhuti'://主题游
				$this ->dataArr['title'] = '主题游_主题旅游线路_亲子游_蜜月游-帮游旅行网';
				$this ->dataArr['keywords'] = '主题游,主题旅游,主题游路线,亲子游';
				$this ->dataArr['description'] = '帮游旅游网为您量身订制各类主题旅游线路，包括蜜月游、亲子游、海岛游、周末游、爸妈游、主题旅游攻略等各式各样的旅游主题服务，专业旅游，帮游网更贴心';
				break;
			default:
				$this ->dataArr['title'] = '旅游线路_国内/出境旅游线路推荐_定制/设计/规划-帮游旅行网';
				$this ->dataArr['keywords'] = '旅游线路,旅游线路定制,线路规划';
				$this ->dataArr['description'] = '帮游旅行网（www.1b1u.com）提供最全的出国、国内旅游线路规划、设计、推荐和报价服务，你可根据自己所需选择最适合你的旅游线路';
				break;
		}
		
		if (!empty($this ->dataArr['buttonArr'])) //没有目的地和线路属性的搜索条件
		{
			if (!empty($this ->whereArr['overcity']) && count($this ->whereArr['overcity']) >1 && empty($this ->whereArr['linetype'])) 
			{
				$d_where = array(
						'in' =>array('id' =>implode(',', $this ->whereArr['overcity'])),
						'level =' =>3
				);
				$destData = $this ->dest_base_model ->getDestBaseAllData($d_where);
				$destName = '';
				$this ->dataArr['keywords'] = '旅游线路定制,';
				$this ->dataArr['description'] = '帮游旅行网（www.1b1u.com）提供最全的';
				foreach($destData as $val)
				{
					$destName .= $val['name'].'/';
					$this ->dataArr['keywords'] .= $val['name'].'旅游,';
					$this ->dataArr['description'] .= $val['name'].'、';
				}
				$this ->dataArr['title'] = rtrim($destName,'/').'_旅游线路推荐/报价-帮游旅行网';
				$this ->dataArr['description'] = rtrim($this ->dataArr['description'],'、').'旅游线路规划、设计、推荐和报价服务，你可根据自己所需选择最适合你的旅游线路，让你的旅程更舒心';
			}
			elseif (!empty($this ->whereArr['overcity']) && count($this ->whereArr['overcity']) == 1 && empty($this ->whereArr['linetype']))
			{
				$destData = $this ->dest_base_model ->getDestPdata($this ->whereArr['overcity'][0]);
				if (!empty($destData))
				{
					$this ->dataArr['title'] = $destData[0]['pname'].$destData[0]['kindname'].'_旅游线路推荐_定制/设计/报价-帮游旅行网';
					$this ->dataArr['keywords'] = '旅游线路,旅游线路定制,线路规划';
					$this ->dataArr['description'] = '帮游旅行网（www.1b1u.com）提供最全的'.$destData[0]['pname'].'旅游线路规划、设计、推荐和报价服务，你可根据自己所需选择最适合你的旅游线路，让你的旅程更舒心。';
				}
			}
			else
			{
				$themeName = '';
				$attrName = '';
				$destName = '';
				if (!empty($this ->whereArr['overcity']))
				{
					$d_where = array(
							'in' =>array('id' =>implode(',', $this ->whereArr['overcity'])),
							'level =' =>3
					);
					$destData = $this ->dest_base_model ->getDestBaseAllData($d_where);
					$destArr = array();
					foreach($destData as $key=>$val)
					{
						$destName .= $val['name'];
						if ($val['pid'] > 0) $destArr[] = $val['pid'];
					}
					if (!empty($destArr))
					{
						$d_where = array(
								'in' =>array('id' =>implode(',',array_unique($destArr))),
								'level =' =>3
						);
						$destData = $this ->dest_base_model ->getDestBaseAllData($d_where);
						foreach($destData as $val)
						{
							$destName = $val['name'].$destName;
						}
					}
				}
				if (!empty($this ->whereArr['themeid']))
				{
					$themeData = $this ->theme_model ->getThemeInData(implode(',', $this ->whereArr['themeid']));	
					foreach($themeData as $val)
					{
						$themeName .= $val['name'];
					}
				}
				if (!empty($this ->whereArr['linetype']))
				{
					$attrid = implode(',' ,$this ->whereArr['linetype']);
					$attrData = $this ->attr_model ->getAttrInData($attrid);
					$attrArr = array();
					foreach($attrData as $key=>$val)
					{
						$attrName .= $val['name'];
						if ($val['pid'] > 0) $attrArr[] = $val['pid'];
					}
					if (!empty($attrArr)) 
					{
						$attrData = $this ->attr_model ->getAttrInData(implode(',',array_unique($attrArr)));
						foreach($attrData as $val)
						{
							$attrName = $val['name'].$attrName;
						}
					}
				}
				$name = $destName.$themeName.$attrName;
				$this ->dataArr['title'] = $name.'_旅游线路推荐/报价-帮游旅行网';
				$this ->dataArr['keywords'] = '旅游线路,旅游线路定制,线路规划';
				$this ->dataArr['description'] = '帮游旅行网（www.1b1u.com）提供最全的'.$name.'旅游线路规划、设计、推荐和报价服务，你可根据自己所需选择最适合你的旅游线路，让你的旅程更舒心';
			}
		}
	}
	// 	www.1b1u.com/line_t-2_st-235_dl-3-5_p-200-250_ds-2-3-4_o-3_al-3-45_pa-2.html
	// 	t:线路类型，0 or 1 or 2 or 3 or 4
	// 	st:出发城市
	// 	dl:天数
	// 	p:价格
	// 	ds:目的地可多个
	//  ts:主题可多个
	// 	o:排序
	// 	al:线路属性
	//  pa:分页,注意：分页参数要在url地址最后
	//  kw:关键字
	
	/**
	 * @method 生成url地址,针对参数为单选的
	 * @param unknown $url  地址栏参数部分
	 * @param unknown $typeArr  生成的url中不包括的参数  传参形式:array('ksn' ,'p' ,'stn);
	 */
	protected function createUrl($url ,array $typeArr)
	{
		$urlArr = explode('_',$url);
		$urlStr = '';
		foreach($urlArr as $val)
		{
			if (empty($val))
			{
				continue;
			}
			$parameterArr = explode('-' ,$val);
			$firstStr = array_shift($parameterArr);
			if ($firstStr == 'kw')
			{
				$val = 'kw-'.urldecode($parameterArr[0]);
			}
			if (!in_array($firstStr ,$typeArr))
			{
				$urlStr = $urlStr.'_'.$val;
			}
		}
		if (empty($urlStr))
		{
			return '/'.$this ->dataArr['type'].'/';
		}
		else 
		{
			return '/'.$this ->dataArr['type'].'/'.ltrim($urlStr,'_');
		}
	}
	
	/**
	 * @method 获取摸个搜索条件，并以数组返回
	 * @param unknown $url
	 * @param unknown $type  返回的搜索参数类型
	 */
	protected function getUrlParameter($url ,$type)
	{
		$urlArr = explode('_', $url);
		$typeArr = array();
		foreach($urlArr as $val)
		{
			if (empty($val))
			{
				continue;
			}
			$parameterArr = explode('-' ,$val);
			$firstStr = array_shift($parameterArr);
			if ($type == $firstStr)
			{
				$typeArr = $parameterArr;
			}
		}
		return $typeArr;
	}
	
	/**
	 * @method 解析url地址参数
	 * @param unknown $url  地址栏的传参
	 */
	protected function analyticalUrl($url)
	{
		//过滤数组的空值,与array_filter函数一起使用
		function filterEmpty($val)
		{
			if (empty($val))
				return false;
			else
				return true;
		}
		$urlArr = explode('_', $url);
		foreach($urlArr as $val)
		{
			$parameterArr = explode('-', $val);
			$firstStr = array_shift($parameterArr);
			if (empty($parameterArr))
			{
				continue;
			}
			switch($firstStr)
			{
// 				case 't': //线路类型 ,国内 or 境外 or 周边 or 主题
// 					$this ->whereArr['type'] = isset($parameterArr[0]) ? intval($parameterArr[0]) : 0;
// 					$this ->dataArr['type'] = $this ->whereArr['type'];
// 					break;
				case 'st'://出发城市
					$this ->getStartCityWhere($parameterArr);
					break;
				case 'dl'://天数
					$this ->getDayWhere($parameterArr);
					break;
				case 'p'://价格
					$this ->getPriceWhere($parameterArr);
					break;
				case 'ds'://目的地
					$this ->getDestWhere(array_filter($parameterArr,"filterEmpty"));
					break;
				case 'o'://排序
					$this ->lineOrderBy($parameterArr);
					break;
				case 'al'://线路属性
					$this ->getAttrWhere(array_filter($parameterArr,"filterEmpty"));
					break;
				case 'pa'://分页
					$this ->pageNow = empty($parameterArr[0]) ? 1 : intval($parameterArr[0]);
					break;
				case 'kw'://关键字
					$keyWord = empty($parameterArr[0]) ? '' : trim(urldecode($parameterArr[0]));
					$this ->whereArr['linename'] = preg_replace('/"/','',$keyWord);
					$this ->dataArr['keyword'] = $this ->whereArr['linename'];
					break;
				case 'ts'://主题
					$this ->getThemeWhere(array_filter($parameterArr,"filterEmpty"));
					break;
				case 'e'://管家
					$this ->whereArr['expert_ids'] = isset($parameterArr[0]) ? intval($parameterArr[0]) : 0;
					break;
			}
		}
	}
	
	/**
	 * @method 出发城市搜索
	 * @param unknown $cityArr 保存出发城市的数组
	 */
	protected function getStartCityWhere($cityArr)
	{
		$startCityId = isset($cityArr[0]) ? intval($cityArr[0]) : 0;
		if (!empty($startCityId))
		{
			$this ->whereArr['startcity'] = $startCityId;
		}
	}
	
	/**
	 * @method 主题搜索
	 * @param unknown $themeArr
	 */
	protected function getThemeWhere($themeArr)
	{
		if (!empty($themeArr) && is_array($themeArr))
		{
			$themeid = '';
			foreach($themeArr as $k=>$v)
			{
				$themeid .= $v.',';
			}
			$this ->whereArr['themeid'] = rtrim($themeid ,',');
		}
	}
	
	
	
	/**
	 * @method 目的地搜索
	 * @param unknown $destArr
	 */
	protected function getDestWhere($destArr)
	{
		if (is_array($destArr) && !empty($destArr))
		{
			$this->whereArr['overcityCfg'] = $destArr;
			
			//通过目的地配置获取目的地
			$whereArr = array(
					'in' =>array('id' =>implode(',' ,$destArr))
			);
			$destCfgData = $this ->dest_cfg_model ->getDestCfgAll($whereArr);
			
			if (!empty($destCfgData))
			{
				$idArr = array();
				foreach($destCfgData as $val)
				{
					$idArr[] = $val['dest_id'];
				}
				$this ->whereArr['overcity'] = $idArr;
			}
		}
	}
	
	/**
	 * @method 线路属性搜索
	 * @param unknown $attrArr
	 */
	protected function getAttrWhere($attrArr)
	{
		if (!empty($attrArr) && is_array($attrArr))
		{
			$this ->whereArr['linetype'] = $attrArr;
		}
	}
	
	/**
	 * @method 线路排序
	 * @param unknown $orderByArr
	 */
	protected function lineOrderBy ($orderByArr)
	{
		$orderNum = isset($orderByArr[0]) ? intval($orderByArr[0]) : 0;
		$this ->dataArr['order'] = $orderNum;
		switch($orderNum)
		{
			case 1:
				$this ->orderBy = 'peoplecount desc';
				break;
			case 2:
				$this ->orderBy = 'satisfyscore desc';
				break;
			case 3:
				$this ->orderBy = 'lineday desc';
				break;
			case 4:
				$this ->orderBy = 'lineprice asc';
				break;
			default:
				$this ->orderBy = 'ordertime asc ';//,l.satisfyscore desc,l.peoplecount desc
				break;
		}
	}
	
	
	
	/**
	 * @method 价格搜索
	 * @param  array $priceArr  保存价格的数组
	 */
	protected function getPriceWhere($priceArr)
	{
		$priceMin = isset($priceArr[0]) ? intval($priceArr[0]) : 0;
		$priceMax = isset($priceArr[1]) ? intval($priceArr[1]) : 0;
	
		if ($priceMin > 0)
		{
// 			$this ->whereArr['l.lineprice >'] = $priceMin;
			$this ->whereArr['min_price'] = $priceMin;
		}
		if ($priceMax > 0)
		{
// 			$this ->whereArr['l.lineprice <'] = $priceMax;
			$this ->whereArr['max_price'] = $priceMax;
		}
		$this ->dataArr['minprice'] = $priceMin;
		$this ->dataArr['maxprice'] = $priceMax;
	}
	
	/**
	 * @method 天数搜索
	 * @param unknown $dayArr  保存天数的数组
	 */
	protected function getDayWhere($dayArr)
	{
		$dayMin = isset($dayArr[0]) ? intval($dayArr[0]) : 0;
		$dayMax = isset($dayArr[1]) ? intval($dayArr[1]) : 100;
		$this ->whereArr['lineday'] = array(
				'min' =>$dayMin,
				'max' =>$dayMax
		);
	}
	
	
	/**
	 * @method 获取线路的出发日期
	 * @since  2015-11-14
	 * @author jiakairong
	 */
	protected function getLineDate($data)
	{
		$this ->load_model('common/u_line_suit_price_model' ,'suit_price_model');
		//获取线路的出发日期，取当天后面的最近三天
		$dayNow = date('Y-m-d' ,$_SERVER['REQUEST_TIME']);
		foreach($data as $key =>&$val)
		{
			$whereArr = array(
				'lineid' => $val['lineid'],
				'day >' =>$dayNow
			);
			$suitArr = $this ->suit_price_model ->getLineSuieDate($whereArr ,1 ,3);
			$usedate = '';
			foreach($suitArr as $v)
			{
				$usedate .= date('m-d' ,strtotime($v['day'])).'、';
			}
			$data[$key]['dates'] = rtrim($usedate ,'、');
		}
		return $data;
	}
	
	/**
	 * @method 根据搜索条件生成显示按钮数据
	 * @param unknown $data 搜索条件
	 */
	protected function createButton($whereArr ,$url)
	{
		foreach($whereArr as $key =>$val)
		{
			if (empty($val)) 
			{
				continue;
			}
			switch ($key)
			{
				case 'themeid'://主题
					$this ->getButtonTheme($val ,$url);
					break;
				case 'linetype'://线路属性
					$this ->getButtonAttr($val ,$url);
					break;
 				case 'overcityCfg'://目的地
					$this ->getButtonDest($val ,$url);
					break;
				case 'expert_ids':
					$this ->getButtonExpert($val ,$url);
					break;
				case 'startcity'://出发城市
					$this ->getButtonStartCity($val ,$url);
					break;
			}
		}
		//天数
		if(isset($whereArr['lineday']))
		{
			$min = isset($whereArr['lineday']['min']) ? $whereArr['lineday']['min'] : 0;
			$max = isset($whereArr['lineday']['max']) ? $whereArr['lineday']['max'] : 0;
			if ($min>0 && ($max>0 && $max ==100)) {
				$name = $min.'天以上';
			} else {
				$name = $min.'-'.$max.'天';
			}
			$this ->buttonArr[] = array(
					'name' =>$name,
					'link' =>$this ->urlVerification($this ->createUrl($url ,array('dl' ,'pa')).'.html')
			);
		}
	}
	/**
	 * @method url验证,用于显示搜索按钮的url验证
	 * @param unknown $url
	 */
	protected function urlVerification($url)
	{
		if ($url == '/'.$this->dataArr['type'].'/.html')
		{
			return '/'.$this ->dataArr['type'];
		}
		else
		{
			return $url;	
		}
	}
	/**
	 * @method 或出发城市按钮数据
	 * @param unknown $cityId
	 */
	protected function getButtonStartCity($cityId ,$url)
	{
		$this ->load_model('common/u_startplace_model' ,'startplace_model');
		$startData = $this ->startplace_model ->row(array('id' =>$cityId));
		$this ->buttonArr[] = array(
				'link' =>$this ->urlVerification($this ->createUrl($url ,array('st' ,'pa')).'.html'),
				'name' =>$startData['cityname']
		);
	}
	
	/**
	 * @method 获取搜索管家
	 * @param unknown $expertId
	 */
	protected function getButtonExpert($expertId ,$url)
	{
		$this ->load_model('expert_model');
		$expertData = $this ->expert_model ->row(array('id' =>$expertId) ,'arr' ,'' ,'id,nickname');
		if (empty($expertData))
		{
			$this ->buttonArr[] = array(
					'name' =>'管家错误',
					'link' =>'/all'
			);
		}
		else
		{
			$url = $this ->createUrl($url ,array('e' ,'pa'));
			$this ->buttonArr[] = array(
					'name' =>$expertData['nickname'],
					'link' =>$this ->urlVerification($url.'.html')
			);
		}
	}
	
	/**
	 * @method 获取主题的搜索条件显示数据
	 * @param unknown $themeid
	 */
	protected function getButtonTheme($themeid ,$url)
	{
		$themeData = $this ->theme_model ->getThemeInData($themeid);
		$themeArr = explode(',', $themeid);
		$url = $this ->createUrl($url ,array('ts' ,'pa')).'_ts-';
		//获取地址栏url路径
		foreach($themeData as $key=>$val)
		{
			$link = $url.'_ts-';
			foreach($themeArr as $k=>$v)
			{
				if ($v != $val['id'])
				{
					$link = $link.$v.'-';
				}
			}
			$val['link'] = $this ->urlVerification(rtrim($link ,'-').'.html');
			$this ->buttonArr[] = $val;
		}
		
	}
	/**
	 * @method 获取线路属性的搜索条件显示数据
	 * @param unknown $themeid
	 */
	protected function getButtonAttr($attrIdArr ,$url)
	{
		$attrData = $this ->attr_model ->getAttrInData(implode(',', $attrIdArr));
		$url = $this ->createUrl($url ,array('al' ,'pa')).'_al-';
		//获取地址栏url路径
		foreach($attrData as $key=>$val)
		{
			$link = $url;
			foreach($attrIdArr as $k=>$v)
			{
				if ($v != $val['id'])
				{
					$link = $link.$v.'-';
				}
			}
			$val['link'] = $this ->urlVerification(rtrim($link ,'-').'.html');
			$this ->buttonArr[] = $val;
		}
	}
	/**
	 * @method 获取线路目的地的搜索条件显示数据
	 * @param unknown $themeid
	 */
	protected function getButtonDest($destIdArr ,$url)
	{
		$d_where = array(
				'in' =>array('id' =>implode(',', $destIdArr)),
				'level =' =>3
		);
		if ($this ->whereArr['type'] == 'zhoubian')
		{
			$destData = $this ->dest_base_model ->getDestBaseAll($d_where);
		}
		else
		{
			$destData = $this ->dest_cfg_model ->getDestCfgAll($d_where);
		}
		
		$url = $this ->createUrl($url ,array('ds' ,'pa'));
		//获取地址栏url路径
		foreach($destData as $key=>$val)
		{
			$link = $url.'_ds-';
			foreach($destIdArr as $k=>$v)
			{
				if ($v != $val['id'])
				{
					$link = $link.$v.'-';
				} 
			}
			$val['link'] = $this ->urlVerification(rtrim($link ,'-').'.html');
			$this ->buttonArr[] = $val;
		}
	}

	
	/**
	 * @method 区分主题游，周边游，国内，境外游
	 * @param unknown $tripDestArr  周边游目的地,线路类型是周边游时，可用
	 */
	protected function distinguishDestTheme($tripDestArr) {
            // 将zt改为'zhuti'
		if($this ->whereArr['type'] == 'zt')//主题游
		{
			if (!isset($this ->whereArr['themeid']))
			{
				$this ->whereArr['theme'] = 0; //主题游且没有搜索详细的主题，则查询主题字段大于0的数据
			}
		}
                // 将zb改为zhoubian
		elseif ($this ->whereArr['type'] == 'zhoubian')//周边游
		{
			if (!isset($this ->whereArr['overcity'])) //周边游，但没有搜索目的地
			{
				foreach($tripDestArr as $val)
				{
					$this ->whereArr['overcity'][] = $val['id'];
				}
			}
		}
		else 
		{
			if (!isset($this ->whereArr['overcity']))
			{
                            // 将gn改为guonei
				if ($this ->whereArr['type'] == 'guonei')
				{
					$this ->whereArr['overcity'] = array(1);
				}
                                // 将cj改为chujing
				elseif ($this ->whereArr['type'] == 'chujing')
				{
					$this ->whereArr['overcity'] = array(2);
				}
			}
		}
		
	}
	

	
	/**
	 * @method 分页
	 * @param unknown $page
	 * @param unknown $count
	 */
	protected function getPageStr ($count ,$url)
	{
		$this->load->library ( 'page' );
		$config['pagesize'] = sys_constant::PAGE_SIZE;
		$config['page_now'] = $this ->pageNow;
		$config['pagecount'] = $count;
		$config['base_url'] = $this ->createUrl($url ,array('pa')).'_pa-';
		$config['suffix'] = '.html';
		$this->page->initialize ( $config );
	}
	
	/**
	 * @method 获取线路目的地
	 * @since  2015-11-12
	 * @param  intval $type 要返回的目的地类型，1：境外游，2：国内游，0：全部
	 */
	protected function getLineDest($type ,$url)
	{
		$destData = array();
		if ($type == 1 || $type == 2)
		{
			$topArr = $this ->dest_cfg_model ->row(array('dest_id'=>$type));
			if (!empty($topArr))
			{
				$destData = $this ->dest_cfg_model->getLowerData($topArr['id']);
			}
		}
		else 
		{
			$destData = $this ->dest_cfg_model ->all(array('level <='=>3) ,'pid asc,displayorder asc' ,'arr' ,'name,id,pid,level');
		}
		
		
		$destArr = array();
		$urlStr = $this ->createUrl($url ,array('ds' ,'pa'));
		$parameterArr = $this ->getUrlParameter($url ,'ds');
		foreach($destData as $key=>$val)
		{
			if ($val['level'] == 2)
			{
				$val['kindname'] = $val['name'];
				$destArr[$val['id']] = $val;
// 				if ($type == 1)
// 				{
// 					if ($val['pid'] == 1) 
// 					{
// 						$destArr[$val['id']] = $val;
// 					}
					
// 				} 
// 				elseif ($type == 2)
// 				{
// 					if ($val['pid'] == 2) 
// 					{
// 						$destArr[$val['id']] = $val;
// 					}
// 				} 
// 				else 
// 				{
// 					$destArr[$val['id']] = $val;
// 				}
			} 
			elseif ($val['level'] == 3) 
			{
				if (array_key_exists($val['pid'], $destArr))
				{
					$parameterArr['dest'] = $val['id'];
					$val['link'] = $urlStr.'_ds-'.implode('-', array_unique($parameterArr)).'.html';	
					
					$val['kindname'] = $val['name'];
					$destArr[$val['pid']]['lower'][] = $val;
					unset($parameterArr['dest']);
				}
			}
		}
		//过滤没有下级目的地的数据
		foreach($destArr as $key=>$val)
		{
			if (!isset($val['lower']))
			{
				unset($destArr[$key]);
			}
		}
		return $destArr;
	}

	/**
	 * @method 获取线路主题
	 * @since  2015-11-12
	 */
	protected function getLineTheme($url)
	{
		$themeData = $this ->theme_model ->all(array() ,'showorder asc' ,'arr' ,'name as kindname,id');
		$urlStr = $this ->createUrl($url ,array('ts','pa'));
		$parameterArr = $this ->getUrlParameter($url ,'ts');
		//获取链接
		foreach($themeData as $k=>$v)
		{
			$parameterArr['theme'] = $v['id'];
			$themeData[$k]['link'] = $urlStr.'_ts-'.implode('-', array_unique($parameterArr)).'.html';
			unset($parameterArr['theme']);
		}
		return $themeData;
	}

	/**
	 * @method 获取周边目的地 
	 * @since  2015-11-12
	 * @param  intval $startplaceid 出发城市ID
	 */
	protected function getTripDest($startplaceid ,$url)
	{
		$tripArr = array();
		$this ->load_model('common/cfg_round_trip_model' ,'trip_model');
		//获取周边目的地
		$tripData = $this ->trip_model ->all(array('startplaceid' =>$startplaceid ,'isopen' =>1));
		if (!empty($tripData)) 
		{
			$destId = '';
			foreach($tripData as $v)
			{
				$destId .= $v['neighbor_id'].',';
			}
			$destId = rtrim($destId ,',');
			//获取目的地
			$where = array(
					'in' =>array('id' =>$destId)
			);
			$tripArr = $this ->dest_base_model ->getDestData($where);
		}
		$urlStr = $this ->createUrl($url ,array('ds','pa'));
		$parameterArr = $this ->getUrlParameter($url ,'ds');
		//获取链接
		foreach($tripArr as $k=>$v)
		{
			$parameterArr['dest'] = $v['id'];
			$tripArr[$k]['link'] = $urlStr.'_ds-'.implode('-', array_unique($parameterArr)).'.html';
			unset($parameterArr['dest']);
		}
		
		return $tripArr;
	}

	/**
	 * @method 获取线路属性标签
	 * @author jiakairong
	 */
	protected function getLineAttr($url)
	{
		$attrData = $this ->attr_model ->all(array('isopen' =>1) ,'pid asc , displayorder asc');
		$attrArr = array();
		$urlStr = $this ->createUrl($url ,array('al','pa'));
		$parameterArr = $this ->getUrlParameter($url ,'al');
		
		if (!empty($attrData)) 
		{
			foreach($attrData as $val) 
			{
				if ($val['pid'] == 0) 
				{
					$attrArr[$val['id']] = $val;
				} 
				else 
				{
					if (array_key_exists($val['pid'] ,$attrArr))
					{
						$parameterArr['attr'] = $val['id'];
						$val['link'] = $urlStr.'_al-'.implode('-', array_unique($parameterArr)).'.html';
						$attrArr[$val['pid']]['lower'][] = $val;
						unset($parameterArr['attr']);
					} 
					else 
					{
						continue;
					}
				}
			}
		}
		foreach($attrArr as $k =>$v)
		{
			if (empty($v['lower'])) //过滤没有下级的线路属性
			{ 
				unset($attrArr[$k]);
			}
		}
		return $attrArr;
	}
	
	/**
	 * @method 线路销量排序
	 * @since  2015-11-12
	 */
	protected function getLineHot()
	{
		switch($this ->whereArr['type'])
		{
			case 'gn':
				$whereArr = array(
					'l.status' =>2,
					'ls.startplace_id' =>$this->whereArr['startcity'],
					'overcity' =>array(2)
				);
				break;
			case 'cj':
				$whereArr = array(
					'l.status' =>2,
					'ls.startplace_id' =>$this->whereArr['startcity'],
					'overcity' =>array(1)
				);
				break;
			case 'zt':
				$whereArr = array(
					'l.status' =>2,
					'ls.startplace_id' =>$this->whereArr['startcity'],
					'themeid' =>0
				);
				break;
			case 'zb':
				$whereArr = array(
					'l.status' =>2,
					'ls.startplace_id' =>$this->whereArr['startcity']
				);
				if (!empty($this ->whereArr['overcity'])) {
					$whereArr['overcity'] = $this ->whereArr['overcity'];
				}
				break;
			default:
				$whereArr = array(
					'l.status' =>2,
					'ls.startplace_id' =>$this->whereArr['startcity']
				);
				break;
		}
		return $this ->line_model ->lineSortData($whereArr ,1 ,10 ,'bookcount desc');
	}
	
	/**
	 * @method 获取轮播图
	 * @since  2015-11-12
	 */
	protected function getRollPic()
	{
		$this ->load_model('common/cfg_index_roll_pic_model' ,'roll_pic_model');
		$whereArr = array(
				'is_show' =>1
		);
		return $this ->roll_pic_model ->all($whereArr ,'showorder asc');
	}

	public function kefu_url_line($memberId="",$lineId="",$action="0"){
			$this->load->library("curl");
			$b2_one_data=$this->curl->simple_get("http://bangu.com/kefu_webservices/get_b2_one_data?lineid=".$lineId);
			$b2_one_dataArr=json_decode($b2_one_data, true);
			$expertId=$b2_one_dataArr[0]['id'];
			return base_url()."kefu?member_id=$memberId&expert_id=$expertId&action=$action";
		}
	

}
