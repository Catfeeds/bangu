<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @author		何俊
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Index extends UC_NL_Controller {
	
	public $customType = array(
			'1' =>'出境游',
			'2' =>'国内游',
			'3' =>'周边游'
	);
    public function __construct() {
        parent::__construct();
       // set_error_handler('customError');
        $this->load_model('index_model', 'index_model');
        $this->load_model('dest/dest_base_model' ,'dest_base_model');
        $this ->load_model('area_model');
        $this ->load_model('search_condition_model');
	}
	
	public function Index()
	{
		$this ->load_model('common/u_startplace_model' ,'startplace_model');
		$this->load->helper("my_text");
		$data = array();
		$startcityId = $this->session->userdata('city_location_id'); //出发城市id
		
		$startcityName = $this->session->userdata('city_location'); //出发城市
		//通过出发城市获取地区表id
		$startData = $this ->startplace_model ->row(array('id' =>$startcityId));
		$cityId = empty($startData) ? 0 : $startData['areaid'];
		
		//管家级别
		$data['expertGrade'] = $this->getExpertGrade();
		//中部管家
		$data['expertData'] = $this ->getExpertData($startcityId ,1 ,$cityId ,7 ,$data['expertGrade']);
		//最美管家
		$data['beautifulExpert'] = $this ->getExpertData($startcityId ,4 ,$cityId ,10);
		//旅游体验师
		//$data['experienceData'] = $this ->getExperienceData($startcityId);
		//最美体验师
		//$data['beautyExperience'] = $this ->getBeautyExperience($cityId);
		//特价线路
		$data['lineSellData'] = $this->getLineSellData($startcityId);
		//最新点评
		$data['commentData'] = $this ->getCommentData($startcityId);
		//底部文章
		$data['articleArr'] = $this->getArticleData();
		//友情链接
		$linkArr = $this ->getFriendLink();
		$data['friendLinkPic'] = $linkArr['pic'];
		$data['friendLinkWord'] = $linkArr['word'];
		//轮播图
		$data['rollPic'] = $this ->getRollPic();
		//销量排行
		$data['orderByLine'] = $this->getLineRanking($startcityId);//
		//目的地线路
		$data['indexKind'] = $this ->getDestLine($startcityId);//
		//产品搜索价格
		$data['linePrice'] = $this ->getSearchPrice();
		//
		$data['areaArr'] = $this->getCityRegion($cityId);
		//产品搜索天数
		$data['lineDay'] = $this ->getSearchDay();
		$data['startcityid'] = $startcityId;
		$this->load->view('home_view', $data);
		//$this->output->enable_profiler(TRUE);
	}
	/**
	 * @method 产品搜索价格范围
	 * @author jkr
	 */
	public function getSearchPrice()
	{
		$priceStr = $this->cache->redis->get('SYSearchPriceAll');
		if ($priceStr)
		{
			$priceData = unserialize($priceStr);
		}
		else
		{
			$priceData = $this ->search_condition_model ->get_search_data(sys_constant::CON_LINE_PRICE);
			$this->cache->redis->setex('SYSearchPriceAll' ,7*24*3600 ,serialize($priceData));
		}
		return $priceData;
	}
	/**
	 * @method 产品搜索天数范围
	 * @author jkr
	 */
	public function getSearchDay()
	{
		$dayStr = $this->cache->redis->get('SYSearchDayAll');
		if ($dayStr)
		{
			$dayData = unserialize($dayStr);
		}
		else
		{
			$dayData = $this ->search_condition_model ->get_search_data(sys_constant::CON_LINE_DAY);
			$this->cache->redis->setex('SYSearchDayAll' ,7*24*3600 ,serialize($dayData));
		}
		return $dayData;
	}
	/**
	 * @method 获取管家级别
	 * @author jkr
	 */
	public function getExpertGrade()
	{
		$gradeStr = $this->cache->redis->get('expertGradeAll');
		if($gradeStr)
		{
			$gradeArr = unserialize($gradeStr);
		}
		else
		{
			$this ->load_model('expert_grade_model');
			$gradeData = $this ->expert_grade_model ->all();
			$gradeArr = array();
			if (!empty($gradeData))
			{
				foreach($gradeData as $val)
				{
					$gradeArr[$val['grade']] = $val['title'];
				}
			}
			$this->cache->redis->setex('expertGradeAll',24*3600,serialize($gradeArr));
		}
		return $gradeArr;
	}

	/**
	 * @method 获取线路分类的默认展示线路 
	 * @author jiakairong
	 * @param unknown $dataArr
	 */
	public function getDefaultLine($dataArr)
	{
		$count = count($dataArr);
		$i = 0;
		for($i ;$i <$count-1 ;$i++)
		{
			$j = 0;
			for ($j ;$j < $count-$i-1 ;$j ++)
			{
				if($dataArr[$j]['showorder'] > $dataArr[$j+1]['showorder'])
				{
					$arr = $dataArr[$j];
					$dataArr[$j] = $dataArr[$j+1];
					$dataArr[$j+1] = $arr;
				}
			}
		}
		foreach($dataArr as $key =>$val)
		{
			if ($key > 5)
			{
				unset($dataArr[$key]);
			}
		}
		return $dataArr;
	}
	/**
	 * @method 获取目的地线路数据
	 * @param unknown $startcityId
	 */
	public function getDestLine($startcityId)
	{
		$kindStr = $this ->cache->redis->hget('SYDestLine' ,$startcityId);
		if ($kindStr)
		{
			$kindData = unserialize($kindStr);
		}
		else
		{
			//首页一级分类
			$kindData = $this ->index_model ->getIndexKind();
			if (!empty($kindData))
			{
				foreach($kindData as $key=>$val)
				{
					if ($val['name'] == '主题游')
					{
						$kindData[$key]['kindDest'] = $this ->index_model ->getIndexKindTheme($val['id'] ,$startcityId ,9);
                                                // 将zt改为/zhuti/  魏勇编辑
						// $kindData[$key]['url'] ='/zt';
                                                $kindData[$key]['url'] ='/zhuti/';
						$lineArr = array();
						if (!empty($kindData[$key]['kindDest'])) {
							//获取分类主题下的线路
							foreach($kindData[$key]['kindDest'] as $k=>$v) {
								$whereArr = array(
										'l.status' =>2,
										'tl.startplaceid' =>$startcityId,
										'l.producttype' =>0,
										'tl.is_show' =>1,
										'tl.theme_id' =>$v['theme_id'],
										//'tl.index_kind_theme_id' =>$v['id']
								);
								$lineData = $this ->index_model ->getKindThemeLine($whereArr ,1,6,'id desc');
								$kindData[$key]['kindDest'][$k]['lineArr'] = $lineData;
								foreach($lineData as $item) {
									$lineArr [] = $item;
								}
							}
						}
						//默认展示线路
						$kindData[$key]['defaultLine'] = $this ->getDefaultLine($lineArr);
					}
					else
					{
						$kindData[$key]['kindDest'] = $this ->index_model ->getIndexKindDest($val['id'] ,$startcityId ,9);
						switch($val['name']) {
							case '出境游':
                                                            // 将cj改为chujing/
                                                            // $kindData[$key]['url'] = '/cj';
                                                            $kindData[$key]['url'] = '/chujing/';
                                                            break;
							case '国内游':
                                                            // 将gn改为guonei/
                                                            // $kindData[$key]['url'] = '/gn';
                                                            $kindData[$key]['url'] = '/guonei/';
                                                            break;
							case '周边游':
                                                            // 将zb改为zhoubian/
							    // $kindData[$key]['url'] = '/zb';
                                                            $kindData[$key]['url'] = '/zhoubian/';
                                                            break;
						}
						$lineArr = array();
						if (!empty($kindData[$key]['kindDest'])) {
							//获取线路
							foreach($kindData[$key]['kindDest'] as $k=>$v) {
								$whereArr = array(
										'l.status' =>2,
										'kdl.startplaceid' =>$startcityId,
										'l.producttype' =>0,
										'kdl.is_show' =>1,
										'kdl.index_kind_dest_id' =>$v['id']
								);
								$lineData = $this ->index_model ->getKindDestLine($whereArr ,1,6,'id desc');
								foreach($lineData as $item) {
									$lineArr [] = $item;
								}
								$kindData[$key]['kindDest'][$k]['lineArr'] = $lineData;
							}
							//默认展示线路
							$kindData[$key]['defaultLine'] = $this ->getDefaultLine($lineArr);
	
						}
					}
					unset($kindData[$key]['id']);
				}
			}
			$this->cache->redis->hset('SYDestLine',$startcityId,serialize($kindData));
			$this->cache->redis->expire('SYDestLine',2*3620);
		}
		return $kindData;
	}
	
	/**
	 * @method 线路销量排行
	 * @author jkr
	 */
	public function getLineRanking($startcityId)
	{
		$dataStr = $this->cache->redis->get('SYhomeLineRanking');
		if ($dataStr)
		{
			$dataArr = unserialize($dataStr);
		}
		else
		{
			//主题游
			$whereArr = array(
					'l.status' =>2,
					'ls.startplace_id' =>$startcityId,
					'l.producttype' =>0,
					'themeid' =>0
			);
			$themeData = $this ->index_model ->getLineRanking($whereArr ,5);
			//国内游
			$whereArr = array(
					'l.status' =>2,
					'ls.startplace_id' =>$startcityId,
					'l.producttype' =>0,
					'overcity' =>array(2)
			);
			$domesticData = $this ->index_model ->getLineRanking($whereArr ,5);
				
			//境外游
			$whereArr = array(
					'l.status' =>2,
					'ls.startplace_id' =>$startcityId,
					'l.producttype' =>0,
					'overcity' =>array(1)
			);
			$abroadData = $this ->index_model ->getLineRanking($whereArr ,5);
			//周边游
			$tripData = $this ->index_model ->getRoundTrip($startcityId);
			if (empty($tripData))
			{
				$aroundData = array();
			}
			else
			{
				$overcity = array();
				foreach($tripData as $v)
				{
					$overcity[] = $v['dest_id'];
				}
				$whereArr = array(
						'l.status' =>2,
						'ls.startplace_id' =>$startcityId,
						'l.producttype' =>0,
						'overcity' =>$overcity
				);
				$aroundData = $this ->index_model ->getLineRanking($whereArr ,5);
			}
				
			$dataArr = array(
					array(
							'name' =>'出境',
							'lower' =>$abroadData
					),
					array(
							'name' =>'国内',
							'lower' =>$domesticData
					),
					array(
							'name' =>'周边',
							'lower' =>$aroundData
					),
					array(
							'name' =>'主题',
							'lower' =>$themeData
					)
			);
			$this->cache->redis->setex('SYhomeLineRanking' ,3600,serialize($dataArr));
		}
		return $dataArr;
	}
	
	/**
	 * @method 底部文章
	 * @author jkr
	 */
	protected function getArticleData()
	{
		$articleStr = $this->cache->redis->get('SYhomeArticle');
		if ($articleStr)
		{
			$articleArr = unserialize($articleStr);
		}
		else
		{
			$attrData = $this ->index_model ->getArticleAttr(5);
			$articleArr = array();
			if (!empty($attrData))
			{
				$ids = '';
				foreach($attrData as $val)
				{
					$ids .= $val['id'].',';
					$articleArr[$val['id']] = array('name' =>$val['attr_name']);
				}
				$articleData = $this ->index_model ->getArticleData(rtrim($ids,','));
				foreach($articleData as $val)
				{
					if (empty($articleArr[$val['attrid']]['lower']))
					{
						$articleArr[$val['attrid']]['lower'] = array();
					}
					$count = count($articleArr[$val['attrid']]['lower']);
					if ($count < 5)
					{
						$articleArr[$val['attrid']]['lower'][] = array(
								'title' =>$val['title'],
								'id' =>$val['id']
						);
					}
				}
			}
			if (!empty($articleArr))
			{
				$this->cache->redis->setex('SYhomeArticle' ,7*24*3600 ,serialize($articleArr));
			}
		}
		return $articleArr;
	}
	
	/**
	 * @method  轮播图
	 * @author jkr
	 */
	protected function getRollPic()
	{
		$rollStr = $this->cache->redis->get('SYrollPicAll');
		if ($rollStr)
		{
			$rollPic = unserialize($rollStr);
		}
		else
		{
			$rollPic = $this ->index_model ->getRollPic(array('is_show' =>1));
			$this ->cache->redis->setex('SYrollPicAll' ,7*24*3600 ,serialize($rollPic));
		}
		return $rollPic;
	}
	/**
	 * @method 获取友情链接
	 * @author jkr
	 */
	protected function getFriendLink()
	{
		$linkPicStr = $this ->cache->redis->get('SYFriendLinkPic10');
		$linkWordStr = $this ->cache->redis->get('SYFriendLinkWord30');
		if ($linkPicStr)
		{
			$linkPic = unserialize($linkPicStr);
		}
		else
		{
			$linkPic = $this ->index_model ->getFriendLink(array('link_type' =>1) ,1 ,10);
			if (!empty($linkPic))
			{
				$this ->cache->redis->setex('SYFriendLinkPic10' ,7*24*3600 ,serialize($linkPic));
			}
		}
		if ($linkWordStr)
		{
			$linkWord = unserialize($linkWordStr);
		}
		else
		{
			$linkWord = $this ->index_model ->getFriendLink(array('link_type' =>3) ,1 ,30);
			if (!empty($linkWord))
			{
				$this ->cache->redis->setex('SYFriendLinkWord30' ,7*24*3600 ,serialize($linkWord));
			}
		}
		return array(
				'pic' =>$linkPic,
				'word' =>$linkWord
		);
	}
	
	/**
	 * @method 获取特价线路
	 * @author jkr
	 * @param intval $startcityId 出发城市ID
	 */
	protected function getLineSellData($startcityId)
	{
		$sellStr = $this ->cache->redis->hget('SYhomeLineSell' ,$startcityId);
		if (!empty($sellStr))
		{
			$sellData = unserialize($sellStr);
		}
		else
		{
			$now_time = date('Y-m-d' ,time());
			$whereArr = array(
					'ls.is_show' =>1,
					'l.status' =>2,
					'ls.startplaceid' =>$startcityId,
					'ls.starttime <=' =>$now_time,
					'ls.endtime >=' =>$now_time
			);
			$sellData = $this ->index_model ->getIndexLineSell($whereArr ,1 ,8);
			$this->cache->redis->hset('SYhomeLineSell' ,$startcityId ,serialize($sellData));
			$this->cache->redis->expire('SYhomeLineSell' ,24*3600);
		}
		return $sellData;
	}
	/**
	 * @method 获取特价线路
	 * @author jkr
	 * @param intval $startcityId 出发城市ID
	 */
	protected function getCommentData($startcityId)
	{
		$commentStr = $this ->cache->redis->hget('SYhomeComment' ,$startcityId);
		$commentStr = false;
		if ($commentStr)
		{
			$commentData = unserialize($commentStr);
		}
		else
		{
			$whereArr = array(
					'c.isshow' =>1,
					'c.status' =>1,
					'l.status' =>2,
					'c.starcityid' =>$startcityId
			);
			$commentData = $this ->index_model ->getNewComment($whereArr ,1 ,20);
			//echo $this ->db ->last_query();
			if (!empty($commentData))
			{
				$this->cache->redis->hset('SYhomeComment' ,$startcityId ,serialize($commentData));
				$this->cache->redis->expire('SYhomeComment' ,1800);
			}
		}
		return $commentData;
	}
	
	/**
	 * @method 获取旅游体验师
	 * @author jkr
	 * @param intval $startcityId 出发城市ID
	 */
	protected function getExperienceData($startcityId)
	{
		$experienceStr = $this->cache->redis->hget('SYhomeExperience' ,$startcityId);
		if (!empty($experienceStr))
		{
			$experienceData = unserialize($experienceStr);
		}
		else
		{
			$whereArr = array(
					'l.status' =>2,
					'ie.is_show' =>1,
					'ie.startplaceid' =>$startcityId,
					'me.status' =>1
			);
			$experienceData = $this ->index_model ->getIndexExpertience($whereArr ,1,7);
			$this ->cache->redis->hset('SYhomeExperience' ,$startcityId ,serialize($experienceData));
			$this ->cache->redis->expire('SYhomeExperience' ,24*3600);
		}
		return $experienceData;
	}
	
	/**
	 * @method 获取最美体验师
	 * @author jkr
	 * @param intval $cityId 地区ID
	 */
	protected function getBeautyExperience($cityId)
	{
		$experienceStr = $this ->cache->redis->hget('SYhomeBeautyExperience' ,$cityId);
		if (empty($experienceStr))
		{
			$whereArr = array(
					'be.startplaceid' =>$cityId,
					'be.is_show' =>1,
					'me.status' =>1
			);
			$experienceData = $this ->index_model ->getBeautyExperience($whereArr ,1,10);
			$this ->cache->redis->hset('SYhomeBeautyExperience' ,$cityId ,serialize($experienceData));
			$this ->cache->redis->expire('SYhomeBeautyExperience' ,24*3600);
		}
		else
		{
			$experienceData = unserialize($experienceStr);
		}
		return $experienceData;
	}
	/**
	 * @method 获取当前城市下的地区
	 * @author jkr
	 */
	protected function getCityRegion($cityId)
	{
		$areaStr = $this->cache->redis->hget('SYCityRegion',$cityId);
		if ($areaStr)
		{
			$areaArr = unserialize($areaStr);
		}
		else 
		{
			$areaArr = array();
			$areaData = $this ->area_model ->getAreaData(array('pid' =>$cityId ,'isopen' =>1) ,'id,name');
			if (!empty($areaData))
			{
				foreach($areaData as $v)
				{
					$areaArr[$v['id']] = $v['name'];
				}
			}
			unset($areaData);
			$this->cache->redis->hset('SYCityRegion',$cityId ,serialize($areaArr));
			$this->cache->redis->expire('SYCityRegion',24*3600);
		}
		return $areaArr;
	}
	
	/**
	 * @method 获取首页管家数据
	 * @author jkr
	 * @since  2016-06-12
	 * @param intval $startcityId 出发城市ID
	 * @param intval $location 管家类型
	 * @param intval $city 地区ID
	 * @param intval $num 获取数据条数
	 * @param array  管家级别
	 */
	protected  function getExpertData($startcityId ,$location ,$cityId ,$num ,$gradeArr=array())
	{
		$expertStr = $this->cache->redis->hget('SYhomeExpert' ,$location.$startcityId);
		if (!empty($expertStr))
		{
			$expertData = unserialize($expertStr);
		}
		else
		{
			$whereArr = array(
					'ie.is_show' =>1,
					'ie.location' =>$location,
					'e.status' =>2,
					'ie.startplaceid' =>$startcityId
			);
			$expertData = $this ->index_model ->getIndexExpert($whereArr ,1 ,$num);
			//上门服务地区
			$areaArr = array();
			if ($location == 1)
			{
				$areaArr = $this ->getCityRegion($cityId);
			}
			//目的地
			$destArr = $this ->getDestTowLevel();
			if (!empty($expertData))
			{
				foreach($expertData as $k =>$v)
				{
					if (!empty($gradeArr))
					{
						if (array_key_exists($v['grade'], $gradeArr))
						{
							$expertData[$k]['gradeName'] = $gradeArr[$v['grade']];
						}
						else
						{
							$expertData[$k]['gradeName'] = '管家';
						}
					}
					
					//管家擅长目的地
					$kindname = '';
					if (!empty($v['expert_dest']) && !empty($destArr))
					{
						$destIdArr = explode(',', $v['expert_dest']);
						foreach($destIdArr as $item)
						{
							if (array_key_exists($item ,$destArr))
							{
								$kindname .= $destArr[$item].'、';
							}
						}
						unset($expertData[$k]['expert_dest']);
					}
					//上门服务地区
					$name = '';
					if (!empty($v['visit_service']) && !empty($areaArr))
					{
						$areaIdArr = explode(',', $v['visit_service']);
						foreach($areaIdArr as $item)
						{
							if (array_key_exists($item ,$areaArr)) {
								$name .= $areaArr[$item].'、';
							}
						}
						unset($expertData[$k]['visit_service']);
					}
					$expertData[$k]['dest_name'] = empty($kindname) ? '无' : rtrim($kindname ,'、');
					$expertData[$k]['service_name'] = empty($name) ? '不提供' : rtrim($name ,'、');
				}
			}
			// 		foreach($data['expertData'] as $key =>$item) {
			// 			foreach($item as $k=>$i) {
			// 				$data['expertData'][$key][$k] = mb_convert_encoding($i, "UTF-8", "auto");
			// 			}
			// 		}
			$this->cache->redis->hset('SYhomeExpert' ,$location.$startcityId ,serialize($expertData));
			$this->cache->redis->expire('SYhomeExpert' , 24*3600);
		}
		//var_dump($expertData);
		return $expertData;
	}
	/**
	 * @method 获取目的地第二级数据
	 * @author jkr
	 * @since  2016-06-12
	 */
	protected function getDestTowLevel()
	{
		$destStr = $this ->cache->redis ->get('destTwoLevelData');
		if (empty($destStr))
		{
			$whereArr = array(
					'isopen =' =>1,
					'level =' =>2
			);
			$destData = $this ->dest_base_model ->getDestData($whereArr ,'id,kindname');
			$destArr = array();
			if (!empty($destData))
			{
				foreach($destData as $val)
				{
					$destArr[$val['id']] = $val['kindname'];
				}
			}
			unset($destData);
			$this ->cache->redis ->setex('destTwoLevelData' ,24*3600 ,serialize($destArr));
		} else {
			$destArr = unserialize($destStr);
		}
		return $destArr;
	}
       
		/**
         * [set_city_location description]保存位置
         */
        function set_city_location()
        {
        	$this ->load_model('startplace_model');
            $id = intval($this ->input ->post('id'));
			$startData = $this ->startplace_model ->row(array('id'=>$id,'isopen' =>1));
			if (!empty($startData))
			{
				$this->session->set_userdata('city_location_id',$id);
				$this->session->set_userdata('city_location',$startData['cityname']);
				echo 'success';
			}
			else
			{
				echo 'error';
			} 
        }
        
        /**
         * 网站地图
         * 翁金碧
         */
        function site_map(){
        	//轮播图
        	$banner_list = $this->index_model->get_banner_list();
        	$this->load->view('sitemap_view',array('banner_list'=>$banner_list));
        }
        
        /**
         * 网站地图
         * 翁金碧
         */
        function test(){
        	 
        	$this->load->library('ciqrcode');
        	$params['data'] = base_url().'admin/b2/register/upExpertMuseum?id='.$id;
        	$params['level'] = 'H';
        	$params['size'] = 12;
        	$params['savename'] = FCPATH.'file/qrcodes/guanjiaid_'.$id.'.png';
        	$this->ciqrcode->generate($params);
        	//echo '<img src="'.base_url().'file/qrcodes/guanjiaid.png" />';
        	$logo = FCPATH.'file/qrcodes/logo.png';//准备好的logo图片
        	//echo FCPATH;
        	$QR = base_url().'file/qrcodes/guanjiaid_'.$id.'.png';//已经生成的原始二维码图
        	if ($logo !== FALSE) {
        		$QR = imagecreatefromstring(file_get_contents($QR));
        		$logo = imagecreatefromstring(file_get_contents($logo));
        		$QR_width = imagesx($QR);//二维码图片宽度
        		$QR_height = imagesy($QR);//二维码图片高度
        		$logo_width = imagesx($logo);//logo图片宽度
        		$logo_height = imagesy($logo);//logo图片高度
        		$logo_qr_width = $QR_width/ 5;//
        		$scale = $logo_width/$logo_qr_width;
        		$logo_qr_height = $logo_height/$scale;//
        		$from_width = ($QR_width - $logo_qr_width) /2;
        		//重新组合图片并调整大小
        		imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,$logo_qr_height, $logo_width, $logo_height);
        	}
        	imagepng($QR, FCPATH.'file/qrcodes/guanjiaid_qr.png');
        	echo '<img src="'.base_url().'file/qrcodes/guanjiaid_qr.png">';
        }
        
        /**
         * 测试：sphinx全文搜索
         * */
        function sphinx()
        {
        	$this->load->view("sphinx_view");
        }
}
