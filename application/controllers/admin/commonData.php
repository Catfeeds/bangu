<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
* @version		1.0
* @since		2015年09月28日14:46:53
* @author		贾开荣
* @method 		用于配置表的数据选择
*/
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class CommonData extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
	}
	
	/**
	 * 线路数据选择页面
	 * @author jkr
	 * @since 2017-03-29
	 */
	public function choice_line_view()
	{
		$this ->load_model('startplace_model');
		//出发城市ID
		$startplaceid = intval($this ->input ->get('startplaceid'));
		//选择数据，用于的地方，1：首页目的地线路 (用于查询线路数据的特殊处理)
		$type = intval($this ->input ->get('type'));
		
		//当$is_search_city的值为1的时候，不可以搜索出发城市
		$is_search_city = intval($this ->input ->get('isc'));
		
		//是否有全部出发的城市，当此参数为1时，每次查询都将加上全国出发的数据
		$is_all_city = intval($this ->input ->get('is_all_city'));
		if ($is_all_city == 1)
		{
			$all_city = $this ->startplace_model ->row(array('cityname =' =>'全国出发'));
		}
		
		
		$startcity = '';
		if ($startplaceid > 0)
		{
			$startData = $this ->startplace_model ->row(array('id' =>$startplaceid));
			if (!empty($startData))
			{
				$startcity = $startData['cityname'];
			}
		}
		
		$dataArr = array(
				'startplaceid' =>$startplaceid,
				'startcity' =>$startcity,
				'all_city' =>isset($all_city['id']) ? $all_city['id'] : 0,
				'type' =>$type,
				'is_search_city' =>$is_search_city
		);
		$this ->view('admin/a/choice_data/choice_line_view' ,$dataArr);
	}
	
	/**
	 * 线路数据
	 * @author jkr
	 * @since 2017-03-29
	 */
	public function getLineData()
	{
		$dataArr = array(
				'list' =>array(),
				'page_string' =>$this ->getAjaxPage(1 ,0 ,9)
		);
		$this ->load_model('admin/a/line_model' ,'line_model');
		$this ->load_model('startplace_model');
		$whereArr = array(
				'l.status =' =>2,
				's.status =' =>2,
				'l.producttype =' =>0,
				'l.line_kind =' => 1
		);
		$page = intval($this ->input ->post('page'));
		$page = empty($page) ? 1 : $page;
		$linename = trim($this ->input ->post('linename' ,true));
		$linecode = trim($this ->input ->post('linecode' ,true));
		$startplaceid = intval($this ->input ->post('startplaceid'));
		$startcity = trim($this ->input ->post('startcity' ,true));
		
		//线路数据，用于的地方 1:首页目的地线路
		$type = intval($this ->input ->post('type'));
		//全国出发，当有此参数时，每次查询的数据都会加上全国出发的线路
		$all_city = intval($this ->input ->post('all_city'));
		
		if (!empty($linename))
		{
			$whereArr['l.linename like'] = '%'.$linename.'%';
		}
		if (!empty($linecode))
		{
			$whereArr['l.linecode ='] = $linecode;
		}
		
		/*出发城市查询条件 start*/
		if ($startplaceid)
		{
			$startData = $this ->startplace_model ->all(array('id' =>$startplaceid));
		}
		elseif (!empty($startcity))
		{
			$startData = $this ->startplace_model ->all(array('cityname like' =>'%'.$startcity.'%'));
		}
		
		if (isset($startData))
		{
			if (empty($startData) || !is_array($startData))
			{
				echo json_encode($dataArr);exit;
			}
			else 
			{
				$ids='';
				$pids='';
				foreach($startData as $v)
				{
					if ($v['level'] == 3)
						{
						$ids .= $v['id'].',';
					}
					elseif ($v['level'] ==2)
					{
						$ids .= $v['id'].',';
						$pids .= $v['id'].',';
					}
					else
						{
						//第一级
						$data = $this ->startplace_model ->all(array('pid' =>$v['id']));
						foreach($data as $v)
							{
							$pids .= $v['id'].',';
						}
					}
				}
				//全国出发
				if ($all_city > 0)
				{
					$ids .= $all_city;
				}
				if (!empty($ids) && !empty($pids))
				{
					$whereArr['or'] = array(
							'sp.id in' =>'('.rtrim($ids ,',').')',
							'sp.pid in' =>'('.rtrim($pids , ',').')'
					);
				}
				elseif (!empty($ids))
				{
					$whereArr['in'] = array(
							'sp.id' =>rtrim($ids ,',')
					);
				}
				else
				{
					$whereArr['in'] = array(
							'sp.pid' =>rtrim($pids ,',')
					);
				}
			}
		}
		/*出发城市查询条件 end*/
		
		//var_dump($whereArr);exit;
		$count = $this ->line_model ->getCfgDataCount($whereArr,$type,$startplaceid);
		$dataArr = array(
				'list' =>$this ->line_model ->getCfgData($whereArr ,$type,$startplaceid),
				'page_string' =>$this ->getAjaxPage($page ,$count ,9)
		);
		//echo $this->db->last_query();exit;
		echo json_encode($dataArr);
	}
	
	
	//线路数据
	public function getLineJson()
	{
		$this ->load_model('admin/a/line_model' ,'line_model');
		$whereArr = array(
			'l.status =' =>2,
			's.status =' =>2,
			'l.producttype =' =>0,
            'l.line_kind =' => 1
		);
		$destArr = array();
		$page_new = intval($this ->input ->post('page_new'));
		$page_new = empty($page_new) ? 1 : $page_new;
		$keyword = trim($this ->input ->post('keyword' ,true));
		$linecode = trim($this ->input ->post('linecode' ,true));
		$city = intval($this ->input ->post('city'));
		$province = intval($this ->input ->post('province'));
		$themeId = intval($this ->input ->post('themeId'));
		$city_id = intval($this ->input ->post('city_id')); //配合周边游的始发地城市
		$dest_id = intval($this ->input ->post('dest_id'));
		if (!empty($keyword))
		{
			//$whereArr['s.company_name like'] = '%'.$keyword.'%';
			$whereArr['l.linename like'] = '%'.$keyword.'%';
		}
		if (!empty($linecode))
		{
			$whereArr['l.linecode ='] = $linecode;
		}
		
		if (!empty($city))
		{
			$whereArr['ls.startplace_id ='] = $city;
		}
		elseif (!empty($province))
		{
			$whereArr['sp.pid ='] = $province;
		}
		if (!empty($themeId))
		{
			$whereArr['l.themeid ='] = $themeId;
		}
		if (!empty($dest_id))
		{
			if ($dest_id == 3 && $city_id > 0) //周边游
			{
				//获取城市的周边游目的地
				$this ->load_model('round_trip_model');
				$tripData = $this ->round_trip_model ->getRoundTripDest($city_id);
				if (empty($tripData))
				{
					$data = array(
							'list' =>''
					);
					echo json_encode($data);exit;
				}
				else
				{
					foreach($tripData as $val)
					{
						$destArr[] = $val['dest_id'];
					}
				}
			}
			else
			{
				$destArr = array($dest_id);
			}
		}
                
		$data['list'] = $this ->line_model ->getCfgLineData($whereArr ,$page_new ,9 ,$destArr);
		//echo $this ->db ->last_query();exit;
		$count = $this->getCountNumber($this->db->last_query());
		$data ['page_string'] = $this ->getAjaxPage($page_new ,$count ,9);
		
	   foreach ($data['list'] as $k=>$v){
			$time=date("Y-m-d",time());
			$s_sql="SELECT adultprice from u_line_suit_price as ls where '{$time}'<day and lineid={$v['lineid']} and is_open=1 LIMIT 1";
			$lineprice=$this ->db ->query($s_sql) ->row_array();
			//echo $this->db->last_query();
			if(!empty($lineprice['adultprice'])){
				$data['list'][$k]['s_price']=$lineprice['adultprice'];
			}else{
				$data['list'][$k]['s_price']=0;
			}
		}    
		echo json_encode($data);
	}
	
	////获取线路数据(关联目的地)
	public function getLinesJson()
	{
		$this ->load_model('admin/a/line_model' ,'line_model');
		$whereArr = array(
				'l.status =' =>2,
				's.status =' =>2,
				'l.producttype =' =>0,
				'l.line_kind =' => 1
		);
		$destArr = array();
		$page_new = intval($this ->input ->post('page_new'));
		$page_new = empty($page_new) ? 1 : $page_new;
		$keyword = trim($this ->input ->post('keyword' ,true));
		$lineid = trim($this ->input ->post('lineid' ,true));
		$city = intval($this ->input ->post('city'));
		$province = intval($this ->input ->post('province'));
		$destid = intval($this ->input ->post('city_id')); //目的地id
		if (!empty($keyword))
		{
			$whereArr['l.linename like'] = '%'.$keyword.'%';
		}
	
		$data['list'] = $this ->line_model ->getCfgLinesData($whereArr ,$page_new ,10 ,$destid,$lineid);
		//echo $this->db->last_query();exit();
		$count = $this->getCountNumber($this->db->last_query());
		$data ['page_string'] = $this ->getAjaxPage($page_new ,$count ,10);
	
		echo json_encode($data);
	}
	public function getLinesData() {
		$this ->load_model('common/u_line_model' ,'line_model');
		$whereArr = array(
			'l.status' =>2,
			's.status' =>2,
			'l.producttype' =>0
		);
		$page_new = intval($this ->input ->post('page_new'));
		$page_new = empty($page_new) ? 1 : $page_new;
		$keyword = trim($this ->input ->post('keyword' ,true));
		$startplace = intval($this->input ->post('start_city'));
		$theme_id = intval($this ->input ->post('line_theme'));
		$dest_id = intval($this ->input ->post('line_dest'));
		$startplaceid = intval($this ->input ->post('startplaceid'));

		if (!empty($startplace)) {
			$whereArr['l.startcity'] = $startplace;
		}
		if (!empty($startplaceid))
		{
			$whereArr['l.startcity'] = $startplaceid;
		}
		if (!empty($theme_id)) {
			$whereArr['l.themeid'] = $theme_id;
		}
		if (!empty($dest_id)) {
			$whereArr['l.overcity'] = $dest_id;
		}
		if (!empty($keyword)) {
			$whereArr['keyword'] = $keyword;
		}

		$data['list'] = $this ->line_model ->getCommonLineData($whereArr ,$page_new ,9);
		//echo $this->db->last_query();
		$count = $this->getCountNumber($this->db->last_query());
		$data ['page_string'] = $this ->getAjaxPage($page_new ,$count ,9);
		echo json_encode($data);
	}
	//管家数据
	public function getExpertData() {
		$this ->load_model('admin/a/expert_model' ,'expert_model');
		$whereArr = array('status' =>2);
		$keywordArr = array();
		$cityid = intval($this ->input ->post('city_id'));
		$keyword = trim($this ->input ->post('keyword' ,true));
		$page_new = intval($this ->input ->post('page_new'));
		$page_new = empty($page_new) ? 1 : $page_new;
		$city = intval($this->input ->post('city'));
		$province = intval($this->input ->post('province'));

		if (!empty($keyword)) {
		//	$keywordArr ['nickname'] = $keyword;
			$keywordArr ['realname'] = $keyword;
		}
		if (!empty($cityid)) {
			$whereArr ['city'] = $cityid;
		}

		if (!empty($city)) {
			$whereArr ['city'] = $city;
		} elseif (!empty($province)) {
			$whereArr ['province'] = $province;
		}

		$data['list'] = $this ->expert_model ->getExpertCfgData($whereArr ,$page_new ,sys_constant::A_PAGE_SIZE ,$keywordArr);
//echo $this ->db ->last_query();exit;
		$count = $this->getCountNumber($this->db->last_query());
		$data ['page_string'] = $this ->getAjaxPage($page_new ,$count);
		echo json_encode($data);
	}
	//管家数据(关联目的地)
	public function getExpertsData() {
		$this ->load_model('admin/a/expert_model' ,'expert_model');
		$keywordArr = array();
// 		$cityid = intval($this ->input ->post('city_id'));
		$keyword = trim($this ->input ->post('keyword' ,true));
		$page_new = intval($this ->input ->post('page_new'));
		$page_new = empty($page_new) ? 1 : $page_new;
// 		$city = intval($this->input ->post('city'));
// 		$province = intval($this->input ->post('province'));

		if (!empty($keyword)) {
			$keywordArr ['realname'] = $keyword;
		}
	
		$data['list'] = $this ->expert_model ->getExpertsCfgData($page_new ,sys_constant::A_PAGE_SIZE ,$keywordArr);
		//echo $this ->db ->last_query();exit;
		$count = $this->getCountNumber($this->db->last_query());
		$data ['page_string'] = $this ->getAjaxPage($page_new ,$count);
		echo json_encode($data);
	}
	///体验师数据
	public function getExperienceData() {
		$this ->load_model('admin/a/member_experience_model' ,'experience_model');
		$whereArr = array('me.status' =>1);
		$keywordArr = array();
		$keyword = trim($this ->input ->post('keyword' ,true));
		$page_new = intval($this ->input ->post('page_new'));
		$page_new = empty($page_new) ? 1: $page_new;

		if (!empty($keyword)) {
			$keywordArr ['nickname'] = $keyword;
			//$keywordArr ['truename'] = $keyword;
		}

		$data['list'] = $this ->experience_model ->getExperienceCfgData($whereArr ,$page_new ,sys_constant::A_PAGE_SIZE ,$keywordArr);

		$count = $this->getCountNumber($this->db->last_query());
		$data ['page_string'] = $this ->getAjaxPage($page_new ,$count);
		echo json_encode($data);
	}

	//游记数据
	public function getTravelNoteData() {
		$this ->load_model('admin/a/travel_note_model' ,'travel_note_model');
		$whereArr = array('tn.status' =>1 ,'tn.is_show' =>1, 'l.status' =>2,'l.producttype' =>0);
		$keywordArr = array();
		$keyword = trim($this ->input ->post('keyword' ,true));
		$expertience_id = intval($this ->input ->post('expertience_id'));
		$page_new = intval($this ->input ->post('page_new'));
		$page_new = empty($page_new) ? 1: $page_new;

		if (!empty($expertience_id)) {
			$whereArr ['tn.usertype'] = 0;
			$whereArr ['tn.userid'] = $expertience_id;
		}
		if (!empty($keyword)) {
			$keywordArr ['tn.title'] = $keyword;
		}

		$data['list'] = $this ->travel_note_model ->getNoteCfgData($whereArr ,$page_new ,sys_constant::A_PAGE_SIZE ,$keywordArr);
		$count = $this->getCountNumber($this->db->last_query());
		$data ['page_string'] = $this ->getAjaxPage($page_new ,$count);
		echo json_encode($data);
	}
    //线路详情(b1,b2,t33,a平台)
	function show_line_detail(){
		$lineId= $this->get('id');
		
		//获取线路的信息
		$data['data'] = $this->user_shop_model->get_user_shop_byid($lineId);
		//获取线路的出发地
		$citystr='';
		$cityArr=$this->user_shop_model->select_startplace(array('ls.line_id'=>$lineId));
		foreach ($cityArr as $k=>$v){
			if(!empty($v['startplace_id'])){
				$citystr=$citystr.$v['startplace_id'].',';
			}
		}
		$data['cityArr']=$cityArr;
		$data['citystr']=$citystr;
	
		//获取线路的目的地
		$data['overcity2_arr'] = array();
		if(""!=$data['data']['overcity2']){
			$data['overcity2_arr'] = $this->user_shop_model->getDestinationsData($lineId);
		}
	
		//线路的标签
		$data['line_attr_arr'] = array();
		if(""!=$data['data']['linetype']){
			$this->load_model ( 'admin/a/lineattr_model', 'lineattr_model' );
			$data['line_attr_arr'] = $this->lineattr_model->getLineattr(explode(",",$data['data']['linetype']));
		}
	
		//线路图片
		$data['imgurl']=$this->user_shop_model->select_imgdata($lineId);
		if(!empty($data['imgurl'])){
			$data['imgurl_str']='';
			foreach ($data['imgurl'] as $k=>$v){
				$data['imgurl_str']=$data['imgurl_str'].$v['filepath'].',';
			}
		}
	
		//线路属性
		$data['attr']='';
		$attr=$this->user_shop_model->select_attr_data(array('pid'=>0,'isopen'=>1));
		if(!empty($attr)){
			foreach ($attr as $k=>$v){ //二级
				$attr[$k]['str']='';
				$attr[$k]['two']=$this->user_shop_model->select_attr_data(array('pid'=>$v['id'],'isopen'=>1));
				foreach ($attr[$k]['two'] as $key=>$val){
					$attr[$k]['str'].=$val['id'].',';
				}
			}
			$data['attr']=$attr;
		}
		//行程安排
		$data['rout']=$this->user_shop_model->getLineRout($lineId);

		//供应商信息
		$data['supplier']=$this->user_shop_model->get_user_shop_select('u_supplier',array('id'=>$data['data']['supplier_id']));
		//管家培训
		$data['train']=$this->user_shop_model->get_user_shop_select('u_expert_train',array('line_id'=>$lineId,'status'=>1));

	
		//主题游
		$data['theme']=$this->user_shop_model->get_user_shop_select('u_theme','');
		if(!empty($data['theme'])){
			$data['themeData']='';
			foreach ($data['theme'] as $k=>$v){
				if(empty($data['themeData'])){
					$data['themeData']=$v['id'];
				}else{
					$data['themeData'].=','.$v['id'];
				}
			}
		}
		$data['themeid']='';
		if(!empty($data['data']['themeid'])){   //被选中的主题游
			$data['themeid']=$this->user_shop_model->get_user_shop_select('u_theme',array('id'=>$data['data']['themeid']));
		}
	
		//线路押金,团款
		$data['line_aff']=$this->user_shop_model->select_rowData('u_line_affiliated',array('line_id'=>$lineId));
	
		//指定营业部
		$data['package']=$this->user_shop_model->select_line_package($lineId);
	
		// 定制管家数据
		$data['expert']=$this->user_shop_model->get_group_expert($lineId);
	
		//上车地点
		$data['carAddress']=$this->user_shop_model->select_data('u_line_on_car',array('line_id'=>$lineId));
		 
		$data['line']=$data;
		
		$this->load->view ( 'admin/b1/line_detail_box' ,$data);
	}

}