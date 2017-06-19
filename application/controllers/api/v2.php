<?php
/**
 *   @name:APP接口文件
 *   @version: v1
 * 	 @author: 温文斌
 *   @time: 2016.03.25
 *   
 *	 @abstract:
 *
 *		1、efmg是管家接口前缀，cfmg是用户接口前缀 ，其他前缀的是公用接口
 *
 *      2、 __outmsg()是输出格式化数据模式， __errormsg()是输出错误模式
 *        
 *      3、数据传递方式： POST
 * 		
 *      4、返回结果状态码:  2000是成功，4000是失败，-3是错误信息
 */


if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

//继承MY_Controller类
class V2 extends MY_Controller {
	public function __construct() {
		parent::__construct ();
		date_default_timezone_set ( 'Asia/Shanghai' );
		header ( "content-type:text/html;charset=utf-8" );
		$this->db = $this->load->database ( "default", TRUE );
		$this->load->helper ( "string" );
		header ( 'Content-type: application/json;charset=utf-8' );
		echo header ( 'Access-Control-Allow-Origin: *' );
		
		$this->load->model ( 'common/cfg_web_model','cfg_web_model');
		$data=$this->cfg_web_model->row(array('id'=>'1'));
		//define('BANGU_URL' ,$data['url']);//设置 BANG_URL常量
		
	}
	
	/**
	 * @name：1、app首页数据
	 * @author:温文斌
	 * @param:无
	 * @return:
	 *         roll_pic 导航图
	 *         expert 管家
	 *         dest 目的地(又分为：境外、国内、周边)
	 *         line 热销线路(又分为：境外、国内、周边)
	 */
	public function cfgm_home() {
		$cityid=$this->input->post('cityid',true); //城市id
		if(!$cityid)
		{
		  $this->__errormsg('city is null');
		}
		
		$reDataArr = array ();
		$roll_pic_sql = "select id,name,pic,showorder from cfgm_index_roll_pic where is_show=1 order by showorder";
		$reDataArr ['roll_pic'] = $this->db->query ( $roll_pic_sql )->result_array ();
		$this->db->select ( "e.id AS eid,e.talk,e.big_photo,e.small_photo,e.realname,a.name,e.credit,e.avg_score,(CASE WHEN grade=1 THEN '管家' WHEN grade=2 THEN '初级' WHEN grade=3 THEN '中级' WHEN grade=4 THEN '高级' END) AS grade" );
		$this->db->from ( "cfgm_hot_expert AS cfg" );
		$this->db->join ( "u_expert AS e", "cfg.expert_id=e.id", "left" );
		$this->db->join ( "u_area AS a", "e.city=a.id", "left" );
		$this->db->where ( array (
				'cfg.is_show' => 1,
				'e.status' => 2 
		) );
		$this->db->limit ( 21, 0 ); // 21 row
		$this->db->order_by ( "cfg.showorder", "asc" );
		$query = $this->db->get ();
		$reDataArr ['expert'] = $query->result_array ();
		$dest_sql = "select cd.dest_id as id,cd.dest_type,cd.name as linename,cd.pic as pic,cd.linenum as linenum,(select count(1) from u_line as l where l.status='2' and l.producttype = 0  and FIND_IN_SET(cd.dest_id,l.overcity)>0) as num,    ud.kindname,ud.description as description  		from cfgm_hot_dest as cd  		left join u_dest_cfg as ud on ud.id=cd.dest_id 	left join cfg_index_kind as cik on cik.id=cd.dest_type 		where cd.is_show='1' and cd.startplaceid={$cityid}";
		$jw_dest_sql = $dest_sql . " and cd.dest_type=1 limit 3";
		$gn_dest_sql = $dest_sql . " and cd.dest_type=2 limit 3";
		$zb_dest_sql = $dest_sql . " and cd.dest_type=3 limit 3";
		$reDataArr ['dest'] ['jw'] = $this->db->query ( $jw_dest_sql )->result_array ();
		$reDataArr ['dest'] ['gn'] = $this->db->query ( $gn_dest_sql )->result_array ();
		$reDataArr ['dest'] ['zb'] = $this->db->query ( $zb_dest_sql )->result_array ();
		$time = date ( "Y-m-d" ); // 依据现阶段时间迭代
		$line_sql = "SELECT cx.line_id as id,cx.dest_type,cx.pic as pic,l.linetitle as linetitle,l.linename as linename,l.satisfyscore,l.bookcount,l.peoplecount,l.comment_count,l.lineprice,l.saveprice,l.recommend_expert as expert_id,e.small_photo,e.nickname   	FROM  	cfgm_hot_line AS cx LEFT JOIN u_line AS l ON cx.line_id=l.id     	left join cfg_index_kind as cik on cik.id=cx.dest_type left join u_expert as e on e.id=l.recommend_expert  	where l.status='2' and cx.starttime<='{$time}' and cx.endtime>='{$time}' and cx.startplaceid={$cityid}";
		$jw_line_sql = $line_sql . " and cx.dest_type=1 order by cx.showorder limit 3";
		$gn_line_sql = $line_sql . " and cx.dest_type=2 order by cx.showorder limit 3";
		$zb_line_sql = $line_sql . " and cx.dest_type=3 order by cx.showorder limit 3";
		$reDataArr ['line'] ['jw'] = $this->db->query ( $jw_line_sql )->result_array ();
		$reDataArr ['line'] ['gn'] = $this->db->query ( $gn_line_sql )->result_array ();
		$reDataArr ['line'] ['zb'] = $this->db->query ( $zb_line_sql )->result_array ();
		// if need to this plase take on
		// $this->output->cache(5);
		
		$this->__outmsg ( $reDataArr );
	}
	/**
	 * @name：2、公共函数：城市定位(根据经纬度获得城市名和城市id)
	 * @author: 温文斌
	 * @param: lat维度；lng=经度
	 *        
	 * @return:
	 *
	 */
	public function get_city() {
		$lat=$this->input->post('lat',true); //维度
		$lng=$this->input->post('lng',true); //经度
		if(!$lat||!$lng) $this->__errormsg('param is null',$code="3");
		//$lat="22.54";
		//$lng="114.02"; 
		$api = 'http://api.map.baidu.com/geocoder?location='.$lat.','.$lng.'&output=json&key=cwnZNPB1ouBCEu9sG423iL63';
		$json = @file_get_contents($api);
		$data = json_decode($json,true);
		
		$city= "深圳市"; //若无法定位，默认是深圳
		$city=mb_substr($city,0,-1);
		if(!empty($data['result']['addressComponent']['city']))
		{
				$city=$data['result']['addressComponent']['city'];
		}
		$arr= $this->db->query("select * from u_area where name like '%".$city."%'")->row_array();
		$returnData=array('cityid'=>$arr['id'],'cityname'=>$city);
		$this->__outmsg ( $returnData );
	}
	/**
	 * @name：2[1]：首页模糊搜索
	 * @author: 温文斌
	 * @param: content=搜索内容；
	 *
	 * @return:
	 *
	 */
	public function home_search()
	{
		$content=$this->input->post('content',true); //搜索内容
		//1、目的地
		$dest_sql = "select
							id,kindname
					 from
							u_dest_cfg as d
				     where
							isopen=1 and kindname like '%{$content}%' order by id desc limit 4";
		$dest_query = $this->db->query ( $dest_sql );
		$out['dest']= $dest_query->result_array();
		//2、管家
		$expert_sql = "select
						id,nickname
			    from
					    u_expert
		        where
						status=2 and nickname like '%{$content}%' order by addtime desc limit 4";
		$expert_query = $this->db->query ( $expert_sql );
		$out['expert']= $expert_query->result_array();
		//3、线路
		$sql_line = "select
							id,linename
					from
							u_line
					where
							status=2 and linename like '%{$content}%' order by addtime desc limit 20";
		$query_line = $this->db->query ( $sql_line );
		$out['line']= $query_line->result_array();
		
		echo $this->__outmsg($out);
	}
	/**
	 * @name：2、管家列表
	 * @author: 温文斌
	 * @param: num=xxx； cityname=城市名称，qy_id=区域；e_grade=管家级别；sex=性别；dest_id=目的地
	 *         sort=排序，label=标签,page=当前页，pagesize=每页显示记录数
	 * @return:
	 *         
	 */
	
	public function cfgm_find_expert() {
		$num = $this->input->post ( "num" );
		$where = " where e.status=2 ";
		$order_by = "";
		$sub_where = "";
		$label_where = "";
		$city_name = $this->input->post ( 'cityname', true );							//城市名字
		if(!empty($city_name)){
			
			if (preg_match ( '/^[\x{4e00}-\x{9fa5}]+$/u', $city_name )) {
				if ($city_name) {
					$sql = "select id from u_area where name like '%{$city_name}%'";
					$query = $this->db->query ( $sql );
					$result = $query->result_array ();
					if ($result) {
						$city_id = $result [0] ['id'];
					} else { // 城市 不存在
						$this->__errormsg ( '未查找到城市' );
					}
				}
			} else {
				$this->__errormsg ( '城市输入有误!' );
			}
			
		}
		
		$qy_id = $this->input->post ( 'qy_id', true );								//区域ID
		$e_grade = $this->input->post ( 'e_grade', true );					//管家ID
		$sex = $this->input->post ( 'sex', true );									//性别
		$dest_id = $this->input->post ( 'dest_id', true ); // 多选
		$order = $this->input->post ( 'sort', true );			//排序
		$label = $this->input->post ( 'label', true ); // 多选
		$page = $this->input->post ( 'page', true );			//当前页
		$page_size = $this->input->post ( 'pagesize', true );//总页
		$page_size = empty ( $page_size ) ? 5 : $page_size;
		$page = empty ( $page ) ? 1 : $page;
		$from = ($page - 1) * $page_size;
		if (! empty ( $order )) {
			if ($order == 1) { // 按管家积分由高到低排序
				$order_by = ' order by total_score desc';
			} elseif ($order == 2) { // 满意度 高到低
				$order_by = ' order by e.satisfaction_rate desc';
			} elseif ($order == 3) { // 年度成交额 高到低
				$order_by = ' order by  e.order_amount desc';
			} elseif ($order == 4) { // 年度成交人次 高到低
			                         // $order_by = ' order by (SELECT SUM(mo.dingnum+mo.childnum) FROM u_member_order AS mo WHERE mo.expert_id=e.id) desc';
				
				$order_by = ' order by e.people_count desc';
			}
		} else {
			$order_by = 'order by total_score desc';
		}
		
		
		if ($dest_id || $label) {
			if ($city_name) {
				$sub_where .= " and e.city={$city_id}";
			}
		}
		if ($qy_id) {
			$sub_where .= " and e.region={$qy_id}";
		}
		
		if ($city_id) {
			$sub_where .= " and e.city={$city_id}";
		}

		if ($e_grade) {
			if ($e_grade != 5) {
				$sub_where .= " and e.grade={$e_grade}";
			} else {
				$sub_where .= " and e.isstar=1";
			}
		}
		if ($sex == 1) {
			$sub_where .= " and e.sex=1";
		} elseif ($sex == 2) {
			$sub_where .= " and e.sex=0";
		}
		if ($dest_id) {
			$l_kh = "";
			$r_kh = "";
			$dest_arr = explode ( ',', $dest_id );
			$i = count ( $dest_arr );
			foreach ( $dest_arr as $key => $val ) {
				if ($i > 1) {
					if ($key == 0) {
						$l_kh = "(";
					}
					if ($key == $i - 1) {
						$r_kh = ")";
					}
				}
				if ($key == 0) {
					$sub_where .= " and {$l_kh} find_in_set({$val},l.overcity)>0";
				} else {
					$sub_where .= " or find_in_set({$val},l.overcity)>0 {$r_kh}";
				}
			}
		}
		if ($label) {
			$l_kh = "";
			$r_kh = "";
			$label_arr = explode ( ',', $label );
			$i = count ( $label_arr );
			foreach ( $label_arr as $key => $val ) {
				if ($i > 1) {
					if ($key == 0) {
						$l_kh = "(";
					}
					if ($key == $i - 1) {
						$r_kh = ")";
					}
				}
				if ($key == 0) {
					$sub_where .= " and {$l_kh} find_in_set({$val},l.linetype)>0";
				} else {
					$sub_where .= " or find_in_set({$val},l.linetype)>0 {$r_kh}";
				}
			}
		}
		if ($dest_id || $label || $sex ||$e_grade || $city_id) {
			$label_where = "LEFT JOIN u_line_apply AS la ON la.expert_id=e.id LEFT JOIN u_line AS l ON l.id=la.line_id WHERE e.status=2 {$sub_where} ";
		}

		$sql = "SELECT e.id AS expert_id,e.small_photo,e.sex,e.realname,
		CASE WHEN e.isstar=1 THEN '明星专家' WHEN e.grade=1 THEN '管家' WHEN e.grade=2 THEN '初级专家' WHEN e.grade=3 THEN '中级专家' WHEN e.grade=4 THEN '高级专家' END grade,
		e.expert_theme AS expert_dest, 	e.satisfaction_rate, 	
		e.total_score,e.order_count AS volume
		FROM u_expert AS e {$label_where}  GROUP BY e.id {$order_by} LIMIT {$from},{$page_size}";
		$query = $this->db->query ( $sql );
		$Arr = $query->result_array ();
		print_r($this->db->last_query());exit();
		$lastData = array ();
		if (! empty ( $Arr )) {
			foreach ( $Arr as $key => $val ) {
				foreach ( $val as $k => $v ) {
					if ($k == 'expert_id') {
						$reDataArr [$v] [$key] = $Arr [$key];
					}
				}
			}
			$i = 0;
			foreach ( $reDataArr as $key => $val ) {
				$dest = '';
				$last = array ();
				foreach ( $val as $k => $v ) {
					$dest .= $v ['expert_dest'];
					$len = count ( $val );
					if (($i + 1) < $len) {
						$dest .= ",";
					}
					foreach ( $v as $a => $b ) {
						$last [$a] = $b;
					}
				}
				$last ['expert_dest'] = $dest;
				$lastData [$i ++] = $last;
			}
		}
		$sql2 = "SELECT e.id AS expert_id,e.sex,e.small_photo,e.realname,CASE WHEN e.isstar=1 THEN '明星专家' WHEN e.grade=1 THEN '管家' WHEN e.grade=2 THEN '初级专家' WHEN e.grade=3 THEN '中级专家' WHEN e.grade=4 THEN '高级专家' END grade,e.expert_theme AS expert_dest,round(e.satisfaction_rate * 100) as satisfaction_rate, e.total_score,e.order_count AS volume,(SELECT l.linename FROM u_line_apply AS la LEFT JOIN u_line AS l ON la.line_id=l.id WHERE la.expert_id=e.id AND la.status=2 ORDER BY la.addtime DESC LIMIT 1) AS newest_apply_line,(SELECT l.id FROM u_line_apply AS la LEFT JOIN u_line AS l ON la.line_id=l.id WHERE la.expert_id=e.id AND la.status=2 ORDER BY la.addtime DESC LIMIT 1) AS line_id FROM u_expert AS e {$label_where} GROUP BY e.id {$order_by}";
		$query2 = $this->db->query ( $sql2 );
		$Arr2 = $query2->result_array ();
		$lastData2 = array ();
		if (! empty ( $Arr2 )) {
			foreach ( $Arr2 as $key => $val ) {
				foreach ( $val as $k => $v ) {
					if ($k == 'expert_id') {
						$reDataArr2 [$v] [$key] = $Arr2 [$key];
					}
				}
			}
			$i = 0;
			foreach ( $reDataArr2 as $key => $val ) {
				$dest2 = '';
				$last2 = array ();
				foreach ( $val as $k => $v ) {
					$dest2 .= $v ['expert_dest'];
					$len = count ( $val );
					if (($i + 1) < $len) {
						$dest2 .= ",";
					}
					foreach ( $v as $a => $b ) {
						$last2 [$a] = $b;
					}
				}
				$last2 ['expert_dest'] = $dest2;
				$lastData2 [$i ++] = $last2;
			}
		}
		$total_rows = count ( $lastData2 );
		$total = ceil ( $total_rows / $page_size );
		$arr = array (
				'expert_list' => $lastData,
				'total_rows' => $total_rows 
		);
		$this->__outmsg ( $arr );
	}
	
	/**
	 * @name：3、管家详情
	 * @author: 温文斌
	 * @param: number=凭证；expertid=管家ID；usertype=用于区分管家和用户
	 * @return:
	 *
	 */
	
	public function cfgm_expert_detail() {
		$e_id = intval ( $this->input->post ( 'expertid', true ) );
		$token = $this->input->post ( 'number', true );
		$usertype = $this->input->post ( 'usertype', true );									//标识，用于区分管家和用户
		//登录与否都会有值，区别在于收藏
		 if($token && $usertype=='0') {
			$this->check_token ( $token );
			$this->load->model ( 'common/u_access_token_model', 'at_model' );
			$result = $this->at_model->result ( array (
					'access_token' => $token 
			), null, null, null, 'arr', null, 'mid' );
			$m_id = $result [0] ['mid'];
			$sck = $this->db->query ( " SELECT * FROM (`u_expert_collect`) WHERE `expert_id` = {$e_id} AND `member_id` = {$m_id}" )->row_array ();
			if (empty ( $sck )) {
				$sc = '0';
			} else {
				$sc = '1';
			}
		}else  {
			$sc = '0';

		}
		if (! $e_id) {
			$this->__errormsg ();
		}
		// 管家详情
		$query = $this->db->query ( "select e.id,e.title,e.order_amount,e.people_count,e.nickname,( SELECT   `cityname` FROM `u_startplace` as d where d.id = e.city) as city ,e.small_photo,e.login_name,e.sex,e.realname,group_concat(d.kindname) AS expert_dest, e.satisfaction_rate as satisfaction_rate ,e.total_score,e.talk,(CASE WHEN e.grade=1 THEN '管家' WHEN e.grade=2 THEN '初级专家' WHEN e.grade=3 THEN '中级专家' WHEN e.grade=4 THEN '高级专家' WHEN e.isstar=1 THEN '明星专家' END) AS grade,(SELECT COUNT(*) FROM u_member_order AS mo WHERE mo.expert_id=e.id) AS volume ,(select GROUP_CONCAT(name) from u_area where FIND_IN_SET(id,e.visit_service) >0 )as likeplace from u_expert AS e,u_dest_cfg AS d where e.status=2 and find_in_set(d.id,e.expert_dest)>0 and e.id={$e_id}" );
		$expert_list = $query->result_array ();
		foreach ( $expert_list as $key => $val ) {
			foreach ( $val as $k => $v ) {
				if ($k == "satisfaction_rate") {
					if ($v) {
						$val [$k] = round ( $v * 100 );
					}
				}
			}
			$expert_list [$key] = $val;
		}
		// 售卖路线
		/*
		 * $query = $this->db->query ( "select uee.id as id,uee.content as content,uee.addtime as addtime,uee.praise_count as praise,ueep.pic from u_expert_essay as uee left join u_expert_essay_pic as ueep on uee.id=ueep.expert_essay_id where uee.expert_id='{$e_id}'" );
		 * $buy_list = $query->result_array ();
		 * $buy_list_num = count($query->result_array ());
		 * foreach ( $buy_list as $key => $val ) {
		 * foreach ( $val as $k => $v ) {
		 * if ($k == "pic") {
		 * if ($v) {
		 * $val[$k] = explode ( ";", $v );
		 * }
		 * }
		 * }
		 * $buy_list[$key] = $val;
		 * }
		 */
		// 产品
		$sql = "select la.id,la.expert_id,(CASE WHEN la.grade=1 THEN '管家' WHEN la.grade=2 THEN '初级专家' WHEN la.grade=3 THEN '中级专家' WHEN la.grade=4 THEN '高级专家' END) AS grade,l.id AS line_id,l.linename,l.linetitle,l.mainpic,l.lineprice,l.satisfyscore  as satisfyscore  ,l.all_score AS total_score, 	l.peoplecount  as sell_num,  	(select sum(avgscore2) from u_comment as c where c.line_id=l.id and c.expert_id={$e_id} ) as expert_total_score 	from u_line_apply AS la left join u_line AS l on l.id=la.line_id 	where la.status=2 and l.status='2' and la.expert_id={$e_id}  GROUP BY l.id";
		$sql_limit=$sql." limit 0,3";
		$query = $this->db->query ( $sql_limit );
		$customiz_list = $query->result_array ();
		foreach ( $customiz_list as $key => $val ) {
			foreach ( $val as $k => $v ) {
				if ($k == "satisfyscore") {
					if ($v) {
						$val [$k] = round ( $v * 100 );
					}
				}
			}
			$customiz_list [$key] = $val;
		}
		
		$query = $this->db->query ( $sql );
		$two_list_rows = $query->num_rows ();
		// 定制条数
		$sql2 = "select uc.id as id,uc.question as question,uc.budget as budget,uc.pic as litpic,uc.total_people as total_people,uc.startdate as startdate,uc.estimatedate as estimatedate,uc.startplace as startplace,uc.endplace as endplace,uc.status as status,uca.expert_id as expert_id,uca.isuse as isuse, ua.name as area_name,ud.kindname as dest_name, 		ue.nickname as nickname 	 from u_customize as uc left join u_customize_answer as uca on uc.id=uca.customize_id 	left join u_line as l on uc.line_id=l.id 		left join u_expert as ue on uca.expert_id=ue.id 	left join u_area as ua on ua.id=uc.startplace 		left join u_dest_cfg as ud on ud.id=uc.endplace 	where uc.status='3' and uca.isuse='1' and ISNULL(uca.replytime)=0 	 and uca.expert_id={$e_id} order by uc.addtime desc";
		$query = $this->db->query ( $sql2 );
		$customiz_list_rows = $query->num_rows ();
		// 评论数
		$query = $this->db->query ( "select
				                           uc.*,um.mobile as mobile,mo.productautoid as productautoid,l.linename as line_name,l.linetitle as line_title 
				                     from 
				                           u_comment as uc 
				                           left join u_member as um on uc.memberid=um.mid 
				                           left join u_member_order as mo on uc.orderid=mo.id 
				                           left join u_line as l on l.id=mo.productautoid 
				                     where uc.expert_id='{$e_id}' and uc.status=1 order by uc.addtime desc" );
		$talk_num = count ( $query->result_array () );
		// 收藏情况
		
		// 又是赞     又是	收藏
		$num = $this->db->query ( "select id,member_id,expert_id from u_expert_collect	where   expert_id={$e_id} " )->num_rows ();
		

		// 评价
		$sql4 = " select uc.addtime,uc.expert_content,uc.reply1,uc.reply2,uc.score5,uc.score6,um.nickname as nickname,mo.productautoid as productautoid,l.linename as line_name,l.linetitle as line_title from u_comment as uc left join u_member as um on uc.memberid=um.mid 	left join u_member_order as mo on uc.orderid=mo.id 	left join u_line as l on l.id=mo.productautoid 	where uc.status=1 	and mo.expert_id={$e_id} order by  uc.addtime desc limit 0,3         	";
		$query = $this->db->query ( $sql4 );
		$comment_list = $query->result_array ();
		// 评价条
		$sql4 = rtrim ( $sql4, "limit 0,3 " );
		$query = $this->db->query ( $sql4 );
		$comment_list_rows = $query->num_rows ();
		// 个人游记
		$sql5 = "   select tn.id,tn.title,tn.content,tn.cover_pic,tn.modtime,tn.line_id,ue.nickname as nickname from travel_note as tn left join u_expert as ue on tn.userid=ue.id  where tn.is_show='1'  and tn.status='1'  and tn.usertype= {$e_id}  and tn.userid=1  order by tn.modtime desc limit 0,3";
		$query = $this->db->query ( $sql5 );
		$travel_note_list = $query->result_array ();
		// 个人游记条
		$sql5 = rtrim ( $sql5, "limit 0,3 " );
		$query = $this->db->query ( $sql5 );
		$travel_note_list_rows = $query->num_rows ();
		
		// 海外代购
		$sql6 = "  select uee.id as id,uee.content as content,uee.addtime as addtime,uee.praise_count as praise,ueep.pic as pic from u_expert_essay as uee left join u_expert_essay_pic as ueep on uee.id=ueep.expert_essay_id	where 	uee.expert_id={$e_id} order by uee.addtime desc limit 0,3 ";
		$query = $this->db->query ( $sql6 );
		$otc_buy_list = $query->result_array ();
		foreach ( $otc_buy_list as $key => $val ) {
			foreach ( $val as $k => $v ) {
				if ($k == "pic") {
					if ($v) {
						$val [$k] = explode ( ";", $v );
						foreach ( $val [$k] as $k ) {
							if (! empty ( $k )) {
								$val ['pics'] [] = "http://" . $_SERVER ['HTTP_HOST'] . $k;
							}
						}
						$val ['pic'] = '1';
					}
				}
			}
			$otc_buy_list [$key] = $val;
		}
		// /海外代购条
		$sql6 = rtrim ( $sql6, "limit 0,3 " );
		$query = $this->db->query ( $sql6 );
		$otc_buy_list_rows = $query->num_rows ();
		
		// 管家定制
		$sql7 = "select uc.id as id,uc.pic as litpic,uca.expert_id as expert_id,	us.cityname as cityname,l.satisfyscore,l.linename,l.lineprice,l.id as lineid,l.peoplecount,l.`all_score`		from u_customize as uc left join u_customize_answer as uca on uc.id=uca.customize_id	        left join u_enquiry as q on uc.id=q.customize_id			left join u_line as l on q.line_id=l.id		left join u_expert as ue on uca.expert_id=ue.id			left join u_startplace as us on us.id=uc.startplace			left join u_dest_cfg as ud on ud.id=uc.endplace			where uc.status='3' and uca.isuse='1' and ISNULL(uca.replytime)=0		 and uca.expert_id={$e_id} order by uc.addtime desc limit 0,3";
		$query = $this->db->query ( $sql7 );
		$foot_buy_list = $query->result_array ();
		foreach ( $foot_buy_list as $key => $val ) {
			foreach ( $val as $k => $v ) {
				if ($k == "satisfyscore") {
					if ($v) {
						$val [$k] = round ( $v * 100 );
					}
				}
			}
			$foot_buy_list [$key] = $val;
		}
		foreach ( $foot_buy_list as $key => $val ) {
			foreach ( $val as $k => $v ) {
				if ($k == "all_score") {
					if ($v) {
						$val [$k] = round ( $v * 100 );
					}
				}
			}
			$foot_buy_list [$key] = $val;
		}
		// /管家定制条
		$sql7 = rtrim ( $sql7, "limit 0,3 " );
		$query = $this->db->query ( $sql7 );
		$foot_buy_list_rows = $query->num_rows ();
		$arr = array (
				'expert_list' => $expert_list,
				'cp' => $two_list_rows,
				'customiz_list' => $customiz_list,
				'customiz_list_rows' => $customiz_list_rows,
				'talk_num' => $talk_num,
				'comment_list' => $comment_list,
				'comment_list_rows' => $comment_list_rows,
				'travel_note_list' => $travel_note_list,
				'travel_note_list_rows' => $travel_note_list_rows,
				'otc_buy_list' => $otc_buy_list,
				'otc_buy_list_row' => $otc_buy_list_rows,
				'foot_buy_list' => $foot_buy_list,
				'foot_buy_list_rows' => $foot_buy_list_rows,
				'sc' => $sc,
				'zan' => $num 
		);
		$this->__outmsg ( $arr );
	}
	
	/**
	 * @name：4、管家售卖线路（废置不用--待验证）
	 * @author: 温文斌
	 * @param: expertid=管家ID；page=当前页；pagesize=每页显示记录数
	 * @return:
	 *
	 */
	
	public function cfgm_sale_line() {
		$e_id = intval ( $this->input->post ( 'expertid', true ) );
		is_numeric ( $e_id ) ? ($e_id) : $this->__errormsg ( 'tip is null !' );
		$page = intval ( $this->input->post ( 'page', true ) );
		$page_size = intval ( $this->input->post ( 'pagesize', true ) );
		$page_size = empty ( $page_size ) ? 5 : $page_size;
		$page = empty ( $page ) ? 1 : $page;
		$from = ($page - 1) * $page_size;
		$this->db->select ( "la.id,la.expert_id,(CASE WHEN la.grade=1 THEN '管家' WHEN la.grade=2 THEN '初级专家' WHEN la.grade=3 THEN '中级专家' WHEN la.grade=4 THEN '高级专家' END) AS grade,l.id AS line_id,l.linename,l.mainpic,l.lineprice,l.satisfyscore,l.all_score AS total_score" );
		$this->db->from ( 'u_line_apply AS la' );
		$this->db->join ( 'u_line AS l', 'l.id=la.line_id', 'left' );
		$this->db->where ( array (
				'la.status' => 2,
				'la.expert_id' => $e_id 
		) );
		$this->db->limit ( $page_size, $from );
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
		foreach ( $reDataArr as $key => $val ) {
			foreach ( $val as $k => $v ) {
				if ($k == "satisfyscore") {
					if ($v) {
						$val [$k] = round ( $v * 100 );
					}
				}
			}
			$reDataArr [$key] = $val;
		}
		$this->__outmsg ( $reDataArr );
	}
	/**
	 * @name：5、管家定制列表
	 * @author: 温文斌
	 * @param: expertid=管家ID；page=当前页；pagesize=每页显示记录数
	 * @return:
	 *
	 */
	
	public function cfgm_volume_record() {
		$e_id = intval ( $this->input->post ( 'expertid', true ) );
		is_numeric ( $e_id ) ? ($e_id) : $this->__errormsg ( 'tip is null !' );
		$page = intval ( $this->input->post ( 'page', true ) );
		$page_size = intval ( $this->input->post ( 'pagesize', true ) );
		$page_size = empty ( $page_size ) ? 5 : $page_size;
		$page = empty ( $page ) ? 1 : $page;
		$from = ($page - 1) * $page_size;
		$this->db->select ( 'mo.productname,mo.finishdatetime,m.nickname,m.litpic,(select name from u_area AS a where a.id=l.startcity) AS startcity,(select name from u_area AS a where a.id=l.overcity) AS overcity,lsp.day,(SELECT SUM(mo.dingnum+mo.childnum) FROM u_member_order AS mo WHERE l.id=mo.productautoid AND mo.id=od.order_id AND mo.status=5) AS people,(SELECT COUNT(*) FROM u_member_order AS mo WHERE mo.expert_id=e.id) AS volume,(ceil(mo.total_price/(SELECT SUM(mo.dingnum+mo.childnum) FROM u_member_order AS mo WHERE l.id=mo.productautoid AND mo.id=od.order_id AND mo.status=5))) AS avg_price' );
		$this->db->from ( 'u_member_order AS mo' );
		$this->db->join ( 'u_expert AS e', 'e.id=mo.expert_id' );
		$this->db->join ( 'u_line AS l', 'l.id=mo.productautoid', 'left' );
		$this->db->join ( 'u_order_detail AS od', 'od.order_id=mo.id', 'left' );
		$this->db->join ( 'u_member AS m', 'm.mid=mo.memberid', 'left' );
		$this->db->join ( 'u_line_suit_price AS lsp', 'lsp.suitid=mo.suitid', 'left' );
		$this->db->where ( array (
				'mo.status' => 5,
				'mo.expert_id' => $e_id 
		) );
		$this->db->limit ( $page_size, $from );
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：6、管家咨询列表
	 * @author: 温文斌
	 * @param: expertid=管家ID；page=当前页；pagesize=每页显示记录数
	 * @return:
	 *
	 */
	
	public function cfgm_ask_record() {
		$e_id = intval ( $this->input->post ( 'expertid', true ) );
		is_numeric ( $e_id ) ? ($e_id) : $this->__errormsg ( 'tip is null !' );
		$page = intval ( $this->input->post ( 'page', true ) );
		$page_size = intval ( $this->input->post ( 'pagesize', true ) );
		$page_size = empty ( $page_size ) ? 5 : $page_size;
		$page = empty ( $page ) ? 1 : $page;
		$from = ($page - 1) * $page_size;
		$this->db->select ( 'lq.content,lq.addtime,lq.replycontent,l.linename,m.nickname,(SELECT COUNT(*) FROM u_line_question AS lq WHERE lq.reply_id=e.id ) AS ask' );
		$this->db->from ( 'u_line_question AS lq' );
		$this->db->join ( 'u_expert AS e', 'e.id=lq.reply_id' );
		$this->db->join ( 'u_line AS l', 'l.id=lq.productid', 'left' );
		$this->db->join ( 'u_member AS m', 'm.mid=lq.memberid', 'left' );
		$this->db->where ( array (
				'lq.reply_id' => $e_id,
				'lq.status' => 1 
		) );
		$this->db->limit ( $page_size, $from );
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：7、管家评论列表
	 * @author: 温文斌
	 * @param: expertid=管家ID；page=当前页；pagesize=每页显示记录数
	 * @return:
	 *
	 */
	
	public function cfgm_comment_record() {
		$e_id = intval ( $this->input->post ( 'expertid', true ) );
		is_numeric ( $e_id ) ? ($e_id) : $this->__errormsg ( 'tip is null !' );
		$level = intval ( $this->input->post ( 'level', true ) );				//标识符号
		$page = intval ( $this->input->post ( 'page', true ) );
		$page_size = intval ( $this->input->post ( 'pagesize', true ) );
		$page_size = empty ( $page_size ) ? 5 : $page_size;
		$page = empty ( $page ) ? 1 : $page;
		$from = ($page - 1) * $page_size;
		$this->db->select ( 'c.addtime,c.content,c.level,m.nickname,m.litpic,(SELECT COUNT(*) FROM u_comment AS c WHERE c.expert_id=e.id) AS comments' );
		$this->db->from ( 'u_comment AS c' );
		$this->db->join ( 'u_expert AS e', 'e.id=c.expert_id', 'left' );
		$this->db->join ( 'u_member AS m', 'm.mid=c.memberid', 'left' );
		$where ['c.expert_id'] = $e_id;
		$where ['c.isshow'] = 1;
		if (! empty ( $level )) {
			$where ['c.level'] = $level;
		}
		$this->db->where ( $where );
		$this->db->limit ( $page_size, $from );
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：8、管家荣誉列表
	 * @author: 温文斌
	 * @param: expertid=管家ID
	 * @return:
	 *
	 */
	public function cfgm_person_honor() {
		$e_id = intval ( $this->input->post ( 'expertid', true ) );
		is_numeric ( $e_id ) ? ($e_id) : $this->__errormsg ( 'tip is null !' );
		$reDataArr = $this->db->query ( " SELECT   uec.certificate,uec.certificatepic as pic    FROM   u_expert_certificate AS uec    WHERE    uec.expert_id = {$e_id}    AND `status` = 1 " )->result_array ();
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：9、线路列表
	 * @author: 温文斌
	 * @param: num=当前页；pagesize=每页显示记录数；cityname=定位城市名； areaid=目的地，price=价格；day=天数；dest_id=线路种类
	 *         sort=排序，label=标签,like=模糊搜索字段；
	 * @return:
	 *
	 */
	
	public function cfgm_find_line() {
		
		//1、传值
		$city_name = $this->input->post ( 'cityname', true ); 		// 定位的城市名（出发城市名）
		$areaid = intval ( $this->input->post ( 'areaid', true ) );	//目的地ID（从目的地列表过来的）
		$price = intval ( $this->input->post ( 'price', true ) );   //价格
		$days = $this->input->post ( 'day', true );					//出游天数
		$dest = $this->input->post ( 'dest_id', true );				//线路种类
		$order = intval ( $this->input->post ( 'sort', true ) );    //排序
		$label_id = $this->input->post ( 'label', true ); 		    // 标签（多选）
		$like = $this->input->post ( "like" );                       //模糊搜索
		$page = $this->input->post ( "page" );                       //当前页
		$page_size = intval ( $this->input->post ( 'pagesize', true ) );  //每页显示记录数

		//2、分页变量
		$page = empty ( $page ) ? 1 : $page; 
		$page_size = empty ( $page_size ) ? 5 : $page_size;
		$from = ($page - 1) * $page_size; //from
		$where = "";
		$order_by = " order by l.peoplecount desc";
		$result = "";
		
		//3、加载model
		$this->load->model ( 'common/u_area_model', 'area_model' );
		$this->load->model ( 'common/cfg_search_condition_model', 'cfg_search_condition' );
		
		//4、排序
		if (! empty ( $order )) {
			if ($order == 2) { // 好评优先
				$order_by = " order by l.satisfyscore desc";
			} elseif ($order == 3) { // 销量优先
				$order_by = " order by l.peoplecount desc";
			} elseif ($order == 4) { // 价格由低到高
				$order_by = " order by l.lineprice asc";
			} elseif ($order == 5) { // 价格由高到低
				$order_by = " order by l.lineprice desc";
			}
		}
		
		//5、"价格"where条件
		if ($price) {
			$price_arr = $this->cfg_search_condition->row ( array ('id' => $price ) );
			$where .= " and (l.lineprice >= " . $price_arr ['minvalue'] . " and l.lineprice <= " . $price_arr ['maxvalue'] . ")";
		}
		
		//6、"出游天数"where条件
		if ($days) {
			$days_arr = $this->cfg_search_condition->row ( array ('id' => $days) );
			$where .= " and  (l.lineday >= {$days_arr['minvalue']} and l.lineday <= {$days_arr['maxvalue']})";
		}
		
		//7、"线路种类"where条件
		$dest_id = ltrim ( $dest, ',' ); //移除最后一个 ,符号
		if ($dest_id) {
			$l_kh = "";
			$r_kh = "";
			$dest_arr = explode ( ',', $dest_id );
			$i = count ( $dest_arr );
			foreach ( $dest_arr as $key => $val ) {
				if ($i > 1) {
					if ($key == 0) {
						$l_kh = "(";
					}
					if ($key == $i - 1) {
						$r_kh = ")";
					}
				}
				if ($key == 0) {
					$where .= " and {$l_kh} FIND_IN_SET({$val},l.overcity) > 0";
				} else {
					$where .= " or FIND_IN_SET({$val},l.overcity) > 0 {$r_kh}  ";
				}
			}
		}
		
		//8、"标签" where条件
		if ($label_id) {
			$l_kh = "";
			$r_kh = "";
			$label_arr = explode ( ',', $label_id );
			$i = count ( $label_arr );
			foreach ( $label_arr as $key => $val ) {
				if ($i > 1) {
					if ($key == 0) {
						$l_kh = "(";
					}
					if ($key == $i - 1) {
						$r_kh = ")";
					}
				}
				if ($key == 0) {
					$where .= " and {$l_kh} FIND_IN_SET({$val},l.linetype)>0";
				} else {
					$where .= "   or FIND_IN_SET({$val},l.linetype)>0 {$r_kh}";
				}
			}
		}
		
		//9、"目的地" where条件
		if($areaid)
		{
		
			$where .= "   and  FIND_IN_SET({$areaid},l.overcity)>0 ";
			if(!empty($startcity_id)){
				$where.=")";
			}
		}
		
		//10、"当前定位出发城市" where条件（若$city_name不为空，则从具体某个城市出发，否则全国出发）
		$all_redata = $this->db->query ( "SELECT id FROM u_startplace WHERE cityname='全国出发' ")->row_array ();
		$all_redataid=isset($all_redata['id'])?$all_redata['id']:'391';//"全国出发"ID
		if(!$areaid) //从“目的地列表”过来的时候，不做全国出发处理
		{
			if ($city_name)
			{
				$city_data = $this->area_model->get_row_city ( $city_name );
				if ($city_data) {
					$startcity_id = $city_data ['id'];	//定位的城市名的ID
					if(!empty($startcity_id)){
						$where.="  and (FIND_IN_SET({$startcity_id},ls.startplace_id)>0 or FIND_IN_SET({$all_redataid},ls.startplace_id)>0)"; //城市出发+全国出发
					}
				}
			}
			else 
			{
				//全国出发
				$where .="  and FIND_IN_SET({$all_redataid},ls.startplace_id)>0";
				
			}
		}
		
		//11、"模糊搜索" where条件
		if($like)
		{
			$where .= "  and (l.linename like'%{$like}%' or l.linetitle like '%{$like}%')";
		}
		//12、sql语句
 		$sql=   "   SELECT 
 		                    l.id,l.linename,l.linetitle,l.mainpic,l.lineprice,satisfyscore,
 		                    l.comment_count as comments,l.status,l.peoplecount as bookcount,
 		                    l.saveprice,l.recommend_expert as expert_id,e.small_photo,e.nickname,
 		                	(SELECT	COUNT(*) FROM u_member_order AS mo WHERE l.id = mo.productautoid AND mo. STATUS > 4 ) AS volume  	
 		            FROM 
 		                    u_line AS l
 		                    LEFT JOIN u_line_startplace AS ls ON l.id=ls.line_id
 		                    left join u_expert as e on e.id=l.recommend_expert
 		                   
 		           WHERE 
 		                    l.status = 2 and l.producttype =0 {$where}
 		           GROUP BY 
 		                    ls.line_id  {$order_by}";
 		//13、分页返回的sql
 		$sql_page=$sql." LIMIT {$from},{$page_size}";
 		$query =  $this->db->query( $sql);
 		$query_page =  $this->db->query( $sql_page );
 		
 		//14、数据结果
 		$data['total_rows'] =$query->num_rows (); 
 		$data ['line_list'] = $query_page->result_array ();
 		if(empty( $data['line_list'] )){  $this->__outmsg ($data['line_list']);}
 		
 		//15、对"满意度"字段数据进行四舍五入
		foreach ( $data ['line_list'] as $key => $val ) {
			foreach ( $val as $k => $v ) {
				if ($k == "satisfyscore") {
					if ($v) {
						$val [$k] = round ( $v * 100 );
					}
				}
			}
			$data ['line_list'] [$key] = $val;
		}
		
       //16、返回结果
		$total = ceil ( $data ['total_rows'] / $page_size );
		$output['page'] = $page;
		$output['total'] = $total;//总页数
		$output['result'] = $data ['line_list'];
		$output['total_rows'] = $data ['total_rows'];
		$output['param']=$dest;
		$this->__outmsg ( $output );
	}
	
	/**
	 * @name：10、热门线路
	 * @author: 温文斌
	 * @param: dest_id=目的地；page=当前页，pagesize=每页显示记录数
	 * @return:
	 *
	 */

	public function cfgm_hot_area() {
		$page = intval ( $this->input->post ( 'page', true ) );
		$page_size = intval ( $this->input->post ( 'pagesize', true ) );
		$page_size = empty ( $page_size ) ? 5 : $page_size;
		$page = empty ( $page ) ? 1 : $page;
		$from = ($page - 1) * $page_size;
		$dest_id = ($this->input->post ( 'dest_id', true ));					//线路	ID
		if (empty ( $dest_id )) {
			$where = "";
		} else {
			$where = "and cd.dest_id in ($dest_id) ";
		}
		$reDataArr = $this->db->query ( "select cd.dest_id as id, cd.name as linename, 	cd.pic as pic,	cd.linenum as linenum,	(select count(1) from u_line as l where l.status='2' and FIND_IN_SET(cd.dest_id,l.overcity)>0) as num,	ud.description as description	from cfgm_hot_dest as cd	left join u_dest_cfg as ud on ud.id=cd.dest_id	where cd.is_show='1' {$where} limit {$from},{$page_size} " )->result_array ();
		$this->__outmsg ( $reDataArr );
	}
	
	
	/**
	 * @name：11、线路详情
	 * @author: 温文斌
	 * @param: number=凭证；lineid=线路ID；usertype=区分管家和用户
	 * @return:
	 *
	 */
	
	public function cfgm_line_detail() {
		$l_id = intval ( $this->input->post ( 'lineid', true ) );				
		$token = $this->input->post ( 'number', true );
		$usertype = $this->input->post ( 'usertype', true );									//标识，用于区分管家和用户
		if ($token && $usertype == '0') { // 当有用户时候有登录 收藏和分享
			$this->check_token ( $token );
			$this->load->model ( 'common/u_access_token_model', 'at_model' );
			$result = $this->at_model->result ( array (
					'access_token' => $token 
			), null, null, null, 'arr', null, 'mid' );
			$m_id = $result [0] ['mid'];
			// 获取mid
			$sql = "select (select count(*) from u_line_collect where line_id={$l_id} and member_id={$m_id}) AS is_sc,count(*) AS is_fx from u_line_share where line_id={$l_id} and member_id={$m_id}";
			$query = $this->db->query ( $sql );
			$sc_fx = $query->result_array ();
			// 添加浏览记录
			if (! empty ( $l_id )) {
				$this->load->model ( 'common/u_line_browse_model', 'line_browse_model' );
				$result = $this->line_browse_model->row ( array (
						'line_id' => $l_id,
						'member_id' => $m_id 
				) );
				if (empty ( $result )) {
					$llData = array (
							'member_id' => $m_id,
							'line_id' => $l_id,
							'times' => 0,
							'addtime' => date ( 'Y-m-d H:i:s', time () ) 
					);
					$this->line_browse_model->insert ( $llData );
				} else {
					$this->line_browse_model->update ( array (
							'addtime' => date ( 'Y-m-d H:i:s', time () ),
							'times' => ++ $result ['times'] 
					), array (
							'line_id' => $l_id 
					) );
				}
			}
		}
		$this->db->select ( 'l.id,l.linename,l.linecode,l.lineprice,l.mainpic as tupian,l.comment_count,l.linetitle,l.all_score,l.overcity, l.peoplecount,l.marketprice,l.satisfyscore as satisfyscore,l.all_score, l.feeinclude, l.feenotinclude, l.insurance, l.other_project, l.book_notice, l.visa_content, l.special_appointment, l.beizu, l.safe_alert,   l.avg_score,group_concat(la.filepath) AS filepath,(SELECT COUNT(*) FROM u_member_order AS mo WHERE l.id=mo.productautoid AND mo.status>4) AS volume,l.features' );
		$this->db->from ( 'u_line AS l' );
		$this->db->join ( 'u_line_pic AS lp', 'l.id=lp.line_id', 'left' );
		$this->db->join ( 'u_line_album AS la', 'lp.line_album_id=la.id', 'left' );
		$this->db->where ( array (
				'l.id' => $l_id 
		) );
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
// 		print_r($this->db->last_query());exit();
		//此处架构坑，后续代码是为了，转换该PIC的域名，且取前5.
		if (! empty ( $reDataArr [0] ['filepath'] )) {
			if ($reDataArr [0] ['filepath']) {
				$reDataArr [0] ['filepath'] = explode ( ',', $reDataArr [0] ['filepath'] );
				$reDataArr [0] ['filepath'] = array_slice ( $reDataArr [0] ['filepath'], 0, 5 );
			}
		} else {
			$this->__errormsg ();
		}
		
		if (empty ( $reDataArr [0] ['filepath'] [0] )) {
			$re1 [] = '';
		} else {
			$re1 [] = "http://" . $_SERVER ['HTTP_HOST'] . $reDataArr [0] ['filepath'] [0];
		}
		if (empty ( $reDataArr [0] ['filepath'] [1] )) {
			$re2 [] = '';
		} else {
			$re2 [] = "http://" . $_SERVER ['HTTP_HOST'] . $reDataArr [0] ['filepath'] [1];
		}
		if (empty ( $reDataArr [0] ['filepath'] [2] )) {
			$re3 [] = '';
		} else {
			$re3 [] = "http://" . $_SERVER ['HTTP_HOST'] . $reDataArr [0] ['filepath'] [2];
		}
		if (empty ( $reDataArr [0] ['filepath'] [3] )) {
			$re4 [] = '';
		} else {
			$re4 [] = "http://" . $_SERVER ['HTTP_HOST'] . $reDataArr [0] ['filepath'] [3];
		}
		if (empty ( $reDataArr [0] ['filepath'] [4] )) {
			$re5 [] = '';
		} else {
			$re5 [] = "http://" . $_SERVER ['HTTP_HOST'] . $reDataArr [0] ['filepath'] [4];
		}
		$reDataArr [0] ['filepath'] = array_merge ( $re1, $re2, $re3, $re4, $re5 );
		if (empty ( $reDataArr [0] ['tupian'] )) {
			$reDataArr [0] ['tupian'] = '    ';
		} else {
			$reDataArr [0] ['tupian'] = "http://" . $_SERVER ['HTTP_HOST'] . $reDataArr [0] ['tupian'];
		}
		foreach ( $reDataArr as $key => $val ) {
			foreach ( $val as $k => $v ) {
				if ($k == "satisfyscore") {
					if ($v) {
						$val [$k] = round ( $v * 100 );
					}
				}
			}
			$reDataArr [$key] = $val;
		}
		$line_arr = $this->db->query ( "	SELECT m.litpic, m.nickname, c.level, c.content, c.addtime, c.isanonymous, m.mobile 	FROM (u_comment AS c)	LEFT JOIN  u_member as m ON c.memberid=m.mid	WHERE c.line_id =  {$l_id}	LIMIT 2 " )->result_array ();
		/*
		 * $linetype = $reDataArr[0]['linetype'];
		 * $sql = "select la.attrname from u_line_attr as la where la.id in ({$linetype})";
		 * $query = $this->db->query ( $sql );
		 * $line_arr = $query->result_array ();
		 */
		$result ['linecom'] = "";
		if ($line_arr) {
			$result ['linecom'] = $line_arr;
		}
		$line_time = $this->db->query ( "	SELECT lj.day, lj.title, lj.jieshao, lj.breakfirst, lj.lunch, lj.supper, lj.transport, lj.hotel  FROM (`u_line_jieshao` AS lj) 	 WHERE lj.lineid = {$l_id}  ORDER BY day  " )->result_array ();
		/*
		 * $linetype = $reDataArr[0]['linetype'];
		 * $sql = "select la.attrname from u_line_attr as la where la.id in ({$linetype})";
		 * $query = $this->db->query ( $sql );
		 * $line_arr = $query->result_array ();
		 */
		$result ['lineway'] = "";
		if ($line_time) {
			$result ['lineway'] = $line_time;
		}
		$Arr = array_merge ( $reDataArr [0], $result );
		if ($token && $usertype == '0') {
			$Arr = array_merge ( $Arr, $sc_fx [0] );
		}
		$this->__outmsg ( $Arr, 1 );
	}
	
	/**
	 * @name：12、游览时长：通过用户和线路ID得到
	 * @author: 温文斌
	 * @param: number=凭证；lineid=线路ID；
	 * @return:
	 *
	 */
	
	public function cfgm_browse_long() {
		$l_id = $this->input->post ( 'lineid', true );
		is_numeric ( $l_id ) ? ($l_id) : $this->__errormsg ( 'tip is null !' );
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$result = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$m_id = $result [0] ['mid'];
		$query = $this->db->query ( "select addtime from u_line_browse where line_id=$l_id and member_id=$m_id" );
		$begin = $query->result_array ();
		$close_time = time ();
		$browse_long = $close_time - strtotime ( $begin [0] ['addtime'] );
		if ($browse_long > 0) {
			$this->db->update ( 'u_line_browse', array (
					'times' => $browse_long 
			), array (
					'line_id' => $l_id,
					'member_id' => $m_id 
			) );
		}
	}
	
	/**
	 * @name：13、线路标识
	 * @author: 温文斌
	 * @param: lineid=线路ID；
	 * @return:
	 *
	 */
	
	public function cfgm_line_notice() {
		$l_id = $this->input->post ( 'lineid', true );
		is_numeric ( $l_id ) ? ($l_id) : $this->__errormsg ( 'tip is null !' );
		$dataFiled = "day,title,jieshao,breakfirst,lunch,supper,transport,hotel";
		$this->load->model ( 'common/u_line_jieshao_model', 'lj_model' );
		$reDataArr = $this->lj_model->row ( array (
				'lineid' => $l_id 
		), 'arr', 'day', $dataFiled );
		$this->__outmsg ( $reDataArr, 1 );
	}
	
	/**
	 * @name：14、线路详细信息
	 * @author: 温文斌
	 * @param: lineid=线路ID；
	 * @return:
	 *
	 */
	
	public function cfgm_line_info() {
		$l_id = $this->input->post ( 'lineid', true );
		is_numeric ( $l_id ) ? ($l_id) : $this->__errormsg ( 'tip is null !' );
		$dataFiled = "id,feeinclude,feenotinclude,book_notice,visa_content";
		$this->load->model ( 'common/u_line_model', 'ul_model' );
		$reDataArr = $this->ul_model->row ( array (
				'id' => $l_id 
		), 'arr', '', $dataFiled );
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：15、用户评论
	 * @author: 温文斌
	 * @param: lineid=线路ID；level=等级；page=当前页；pagesize=每页显示记录数
	 * @return:
	 *
	 */
	
	public function cfgm_user_comments() {
		$l_id = intval ( $this->input->post ( 'lineid', true ) );
		$level = intval ( $this->input->post ( 'level', true ) );					//层级
		$page = $this->input->post ( 'page', true );
		$page_size = $this->input->post ( 'pagesize', true );
		$page_size = empty ( $page_size ) ? 5 : $page_size;
		$page = empty ( $page ) ? 1 : $page;
		$from = ($page - 1) * $page_size;
		is_numeric ( $l_id ) ? ($l_id) : $this->__errormsg ( 'tip is null !' );
		$this->db->select ( 'm.litpic,m.nickname,c.level,c.content,c.addtime,m.mobile' );
		$this->db->from ( 'u_comment AS c' );
		$this->db->join ( 'u_member as m', 'c.memberid=m.mid', 'left' );
		$where ['c.line_id'] = $l_id;
		if ($level) {
			$where ['c.level'] = $level;
		}
		$this->db->where ( $where );
		$this->db->limit ( $page_size, $from );
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：16、线路套餐
	 * @author: 温文斌
	 * @param: suitid=线路ID；
	 * @return:
	 *
	 */

	public function cfgm_line_suit() {
		$l_id = $this->input->post ( 'suitid', true );														//线路的价位格
		is_numeric ( $l_id ) ? ($l_id) : $this->__errormsg ( 'tip is null !' );
		$reDataArr = $this->db->query ( "SELECT id,suitname FROM `u_line_suit` where lineid = {$l_id} " )->result_array ();
		if (empty ( $reDataArr )) {
			$this->__errormsg ();
		}
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：17、线路价格日期
	 * @author: 温文斌
	 * @param: suitid=线路ID；
	 * @return:
	 *
	 */
	
	public function cfgm_price_date() {
		$suit_id = $this->input->post ( 'suitid', true );											//通过标识找到价格
		is_numeric ( $suit_id ) ? ($suit_id) : $this->__errormsg ( 'tip is null !' );
		$where = array (
				'ls.id' => $suit_id,
				'day >' => date ( 'Y-m-d', time () ) 
		);
		$this->db->select ( "lsp.day,lsp.adultprice AS adult_price,lsp.childprice AS kid_price" );
		$this->db->from ( "u_line_suit_price AS lsp" );
		$this->db->join ( "u_line_suit AS ls", "lsp.suitid=ls.id", "left" );
		$this->db->where ( $where );
		$this->db->order_by ( "lsp.day" );
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
		if (! empty ( $reDataArr )) {
			foreach ( $reDataArr as $key => $val ) {
				$reDataArr [$val ['day']] = $val;
				unset ( $reDataArr [$val ['day']] ['day'] );
				unset ( $reDataArr [$key] );
			}
		}
		
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：18、线路套餐详情
	 * @author: 温文斌
	 * @param: lineid=线路ID；suitid=套餐ID；number=凭证
	 * @return:
	 *
	 */
	
	public function cfgm_suit_line_detail() {
		//1、传值
		$l_id = $this->input->post ( 'lineid', true );
		$suit_id = $this->input->post ( 'suitid', true );
		$day = $this->input->post ( 'day', true );
		$token = $this->input->post ( 'number', true );
		
		//$suit_id = "878";
		//$day = "2016-04-15";
		//$l_id = "910";
        //2、验证
		$this->check_token ( $token );
		is_numeric ( $l_id ) ? ($l_id) : $this->__errormsg ( 'tip is null !' );
		is_numeric ( $suit_id ) ? ($suit_id) : $this->__errormsg ( 'tip is null !' );
		
		//3、用户信息
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$result = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$userid = $result [0] ['mid'];
		$reDataArr ['user'] = $this->db->query ( "		select truename,mobile,email from u_member WHERE	mid = {$userid} " )->row_array ();
		
		//4、线路详情、积分
		$line = $this->db->query ( "select l.id AS line_id,l.linename,l.overcity,l.linetitle,l.lineday,l.beizu,l.child_description,l.child_nobed_description,l.old_description,l.special_description,l.special_appointment ,l.safe_alert ,l.feeinclude ,l.feenotinclude,l.other_project ,l.insurance   ,l.visa_content  from u_line AS l where l.id={$l_id} " )->row_array ();
		$linecity = $this->db->query ( "SELECT ul.supplier_id AS supplier_id,CONCAT(us.company_name,us.brand) AS company_name,GROUP_CONCAT(usp.cityname) AS startcity_name  	
										FROM  	u_line AS ul 	
										LEFT JOIN u_supplier AS us ON ul.supplier_id = us.id
										LEFT JOIN u_line_startplace AS ls ON ul.id=ls.line_id
										LEFT JOIN u_startplace AS usp ON ls.startplace_id=usp.id	
										WHERE	ul.id ={$l_id} AND ul. STATUS = 2  " )->row_array ();
		$userjf = $this->db->query ( "		SELECT 	jifen 	FROM  	u_member m 	WHERE	mid = {$userid} " )->row_array ();
		$reDataArr ['line'] = array_merge ( $line, $linecity, $userjf );
		
		// 5、  $num:  境内2、境外1
		$num="2"; //默认是2：境内
		$overcity=explode(',',$line['overcity']);
		if(in_array('1', $overcity))
		{
			$num="1"; //境外
		}
		$reDataArr ['coun'] = $num;
		
		//6、保险  $num：境内、境外   ；$line['lineday']：天数
		$reDataArr ['insurance'] = $this->db->query ( "	
				select 
		              t.*,d.description as insurance_kind_name
		 
		        from 
		             u_travel_insurance as t
				     left join u_dictionary as d on t.insurance_kind=d.dict_id
		        where 
		             t.insurance_date>='{$line['lineday']}' and t.insurance_type='{$num}' and t.status=1
		          " )->result_array ();
		
		//7、线路套餐
		$where = "";
		if (! empty ( $suit_id )) {
			$where .= "and ls.id={$suit_id} ";
		}
		if (! empty ( $day )) {
			$where .= "and lsp.`day`='{$day}'";
		}
		$sql = "select ls.id AS suit_id,ls.suitname,ls.unit,lsp.day,lsp.adultprice,lsp.oldprice,lsp.childnobedprice,lsp.childprice from u_line_suit AS ls left join u_line_suit_price AS lsp on lsp.suitid=ls.id where ls.lineid={$l_id} {$where}";
		$query = $this->db->query ( $sql );
		$suit = $query->result_array ();
		$reDataArr ['suit'] = $suit;
		
		//8、管家
		$sql = "select e.id AS expert_id,e.nickname,e.small_photo,CASE WHEN la.grade=1 THEN '管家' WHEN la.grade=2 THEN '初级专家' WHEN la.grade=3 THEN '中级专家' WHEN la.grade=4 THEN '高级专家' end grade  from u_expert AS e left join u_line_apply AS la on e.id=la.expert_id where e.status=2 and la.status=2 and e.is_kf='N' and la.line_id={$l_id}";
		$query = $this->db->query ( $sql );
		$reDataArr ['expert'] = $query->result_array ();
		
		
		
		$sql = "  SELECT	cmc.id AS 'id',cmc.coupon_id as coupon_id,cmc.member_id as member_id,cmc.status as status,cc.min_price, cc.min_price,	cc.name as name,cc.pic as pic,cc.starttime as starttime,cc.endtime as endtime,cc.coupon_price as coupon_price,cc.use_url as use_url 	FROM cou_member_coupon AS cmc LEFT JOIN cou_coupon AS cc ON cmc.coupon_id=cc.id 	WHERE cmc.status=0 and cc.status='1' and cmc.member_id={$userid}";
// 		$sql2 = "SELECT 	cmc.id AS 'id',cmc.coupon_id as coupon_id,cmc.member_id as member_id,cmc.status as status,cc.min_price,cc.min_price, 	cc.name as name,cc.pic as pic,cc.starttime as starttime,cc.endtime as endtime,cc.coupon_price as coupon_price,cc.use_url as use_url 	FROM cou_member_coupon AS cmc LEFT JOIN cou_coupon AS cc ON cmc.coupon_id=cc.id 	WHERE cmc.status!=0 and cc.status='1' and cmc.member_id={$userid}";
		$query = $this->db->query ( $sql );
// 		$query2 = $this->db->query ( $sql2 );
		$reDataArr ['vol_new'] = $query->result_array (); // 优惠卷未使用、已使用
// 		$reDataArr ['vol_old'] = $query2->result_array (); // 优惠卷已过期
		$this->__outmsg ( $reDataArr, 1 );
	}
	
	/**
	 * @name：19、暂时不用-待验证
	 * @author: 温文斌
	 * @param: number=凭证....
	 * @return:
	 *
	 */
	
	public function cfgm_sc_fx() {
		$status = 0;
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$result = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$m_id = $result [0] ['mid'];
		$fx ['line_id'] = $this->input->post ( 'fxid', true );
		$fx ['content'] = $this->input->post ( 'fxcontent', true );
		$fx ['location'] = $this->input->post ( 'from', true );
		if ($fx ['line_id']) {
			$fx ['member_id'] = $m_id;
			$fx ['praise_count'] = 0;
			$fx ['addtime'] = date ( 'Y-m-d H:i:s', time () );
			$status = $this->db->insert ( 'u_line_share', $fx );
			$fx_id = $this->db->insert_id ();
			if ($_FILES) {
				$path = "./file/c/share/image/";
				foreach ( $_FILES as $key => $val ) {
					$fx_pic = $this->cfgm_upload_pimg ( $path, $key );
					$pic = "/file/c/share/image/" . $fx_pic;
					$status = $this->db->insert ( 'u_line_share_pic', array (
							'line_share_id' => $fx_id,
							'pic' => $pic 
					) );
				}
			}
		}
		if ($status) {
			$this->__successmsg ();
		}
	}
	
	/**
	 * @name：20、线路收藏
	 * @author: 温文斌
	 * @param: number=凭证；scid=线路ID
	 * @return:
	 *
	 */
	
	public function cfgm_sc_line() {
		$status = 0;
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$result = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$m_id = $result [0] ['mid'];
		$sc ['line_id'] = $this->input->post ( 'scid', true );
		if ($sc ['line_id']) {
			$query = $this->db->query ( "select line_id from u_line_collect where line_id={$sc['line_id']} and member_id={$m_id}" );
			$sc_arr = $query->result_array ();
			if ($sc_arr) { // 如果有就取消
				$status = $this->db->query ( "delete from u_line_collect where line_id={$sc['line_id']} and member_id={$m_id}" );
			} else { // 没有就添加
				$sc ['member_id'] = $m_id;
				$sc ['addtime'] = date ( 'Y-m-d H:i:s', time () );
				$status = $this->db->insert ( 'u_line_collect', $sc );
			}
		}
		if ($status) {
			$this->__successmsg ();
		}
	}
	
	/**
	 * @name：21、用户注册
	 * @author: 温文斌
	 * @param: mobile=手机号；password=密码；code=验证码
	 * @return:
	 *
	 */
	
	public function cfgm_user_register() {
		$this->load->library ( 'session' );
		$mobile = $this->input->post ( 'mobile', true );
		$password = $this->input->post ( 'password', true );
		$code = $this->input->post ( 'code', true );
		if (empty ( $mobile )) {
			$this->__errormsg ( '电话号码不能为空！' );
		}
		if (empty ( $password )) {
			$this->__errormsg ( '密码不能为空！' );
		}
		$code_mobile = $this->session->userdata ( 'mobile' );
		$code_number = $this->session->userdata ( 'code' );
		if (($code_mobile == $mobile) && ($code_number == $code)) {
			if ($mobile && $password) {
				if (! preg_match ( "/1[34578]{1}\d{9}$/", $mobile )) {
					$this->__errormsg ( 'mobile err ' );
				}
				$data = array (
						'loginname' => $mobile,
						'pwd' => md5 ( $password ),
						'mobile' => $mobile,
						'litpic' => '/file/c/img/face.png',
						'jointime' => time (),
						'sex' => - 1,
						'register_channel'=>'APP注册',
						'jifen' => 2000 
				);
				$query = $this->db->query ( "select * from u_member where mobile={$mobile}" );
				$result = $query->result_array ();
				if (! $result) {
					$query = $this->db->insert ( 'u_member', $data );
					if ($query) {
						$this->__successmsg ();
					} else {
						$this->result_code = "-2";
						$this->result_msg = "fail";
						$lastData ['rows'] = array ();
						$this->result_data = $lastData;
						$this->resultJSON = json_encode ( array (
								"msg" => $this->result_msg,
								"code" => $this->result_code,
								"data" => $this->result_data,
								"total" => "0" 
						) );
						echo $this->resultJSON;
						exit ();
					}
				} else {
					$this->__errormsg ();
				}
			}
		}
	}
	
	/**
	 * @name：22、用户登录
	 * @author: 温文斌
	 * @param: mobile=手机号；password=密码；md5=
	 * @return:
	 *
	 */
	
	public function cfgm_user_login() {
		$mobile = $this->input->post ( 'mobile' );
		$password = $this->input->post ( 'password' );
		$md5 = $this->input->post ( 'md5' );
		is_numeric ( $mobile ) ? $mobile : $this->__errormsg ( "手机号码有误！" );
		if (empty ( $password )) {
			$this->__errormsg ( '密码不能为空' );
		}
		$this->load->model ( 'common/u_member_model', 'mm_model' );
		$result = $this->mm_model->result ( array (
				'mobile' => $mobile 
		), null, null, null, 'arr', null, '*' );
		if ($result) {
			if (md5 ( $password ) == $result [0] ['pwd']) {
				// 登录成功后 更新或插入token，接口访问时验证token是否过期
				$this->load->library ( 'token' );
				$token_arr = $this->token->getToken ( $result [0] ['mid'] );
				$token = ( array ) json_decode ( $token_arr );
				$this->result_code = "1";
				$this->result_msg = "success";
				$lastData ['rows'] = array (
						// 0 => array(
						'key' => $token ['key'],
						'id' => $result [0] ['mid'] 
				)
				// )
				;
				$this->result_data = $lastData;
				$this->resultJSON = json_encode ( array (
						"msg" => $this->result_msg,
						"code" => $this->result_code,
						"data" => $this->result_data,
						"total" => "0" 
				) );
				echo $this->resultJSON;
				exit ();
			} elseif ($password == $result [0] ['pwd'] && $md5 == 'md5') {
				$this->load->library ( 'token' );
				$token_arr = $this->token->getToken ( $result [0] ['mid'] );
				$token = ( array ) json_decode ( $token_arr );
				$this->result_code = "1";
				$this->result_msg = "success";
				$lastData ['rows'] = array (
						// 0 => array(
						'key' => $token ['key'],
						'id' => $result [0] ['mid'] 
				)
				// )
				;
				$this->result_data = $lastData;
				$this->resultJSON = json_encode ( array (
						"msg" => $this->result_msg,
						"code" => $this->result_code,
						"data" => $this->result_data,
						"total" => "0" 
				) );
				echo $this->resultJSON;
				exit ();
			} else {
				$this->result_code = "-3";
				$this->result_msg = "err";
				$lastData ['rows'] = array ();
				$this->result_data = $lastData;
				$this->resultJSON = json_encode ( array (
						"msg" => $this->result_msg,
						"code" => $this->result_code,
						"data" => $this->result_data,
						"total" => "0" 
				) );
				echo $this->resultJSON;
				exit ();
			}
		} else {
			$this->__errormsg ( '343' );
		}
	}

	/**
	 * @name：23、创建订单
	 * @author: 温文斌
	 * @param: 
	 * @return:
	 *
	 */
	
	public function create_ordersn($ordersn) {
		$this->load->model ( 'order_model', 'order_model' );
		$order = $this->order_model->row ( array (
				'ordersn' => $ordersn 
		) );
		if (! empty ( $order )) {
			return false;
		}
		return true;
	}
	
	/**
	 * @name：23、下订单
	 * @author: 温文斌
	 * @param:number=凭证；line_id=线路ID；expert_id=管家ID；suitid=套餐ID；indent_day=出游日期
	 *        adult_number=出游成年人数；elder_number=出游老人数；child_bed_num=出游占床儿童数；child_not_bed_num=出游不占床儿童数
	 *        linkman=联系人姓名；linkemail=联系人邮箱；linkman_phone=联系人手机号
	 * @return:
	 *
	 */

	public function cfgm_add_order() {
		$this->load->model ( 'common/u_sms_template_model', 'template_model' );
		$this->load->model ( 'admin/b1/order_status_model', 'order_status_model' );
		$this->load->model ( 'line_model', 'l_model' );
		$this->load->model ( 'supplier_model', 's_model' );
		$this->load->model ( 'expert_model', 'e_model' );
		
		$this->load->library ( 'session', true );
		$code_number = $this->session->userdata ( 'code' );
		$code_mobile = $this->session->userdata ( 'mobile' );
		// print_r($this->session->all_userdata());
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$user = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$m_id = $user [0] ['mid'];
		$data ['productautoid'] = $ll_id = $this->input->post ( 'line_id' );
		$data ['expert_id'] = $ee_id = $this->input->post ( 'expert_id' );
		$exp_id = $this->input->post ( 'expert_id' );
		$data ['suitid'] = $this->input->post ( 'suitid' );													//标识
		$data ['usedate'] = $use_date = $this->input->post ( 'indent_day' );				//出游日
		$data ['dingnum'] =$dingnum=$this->input->post ( 'adult_number' );	//总人数
		if(!$dingnum)
		{
			$this->load->model ( 'common/u_line_suit_model', 'u_line_suit_model' );
			$linesuit = $this->u_line_suit_model->row ( array ('id' => $data ['suitid']) );//套餐
			
			$menu_num=$this->input->post ( 'menu_num' );// 套餐数
			$data['suitnum']=$menu_num;  //单位
			$data['dingnum']=$menu_num*$linesuit['unit']; // dingnum=menu_nun*unit
		}
		$data ['oldnum'] = $this->input->post ( 'elder_number' );									//老人数
		$data ['childnum'] = $this->input->post ( 'child_bed_num' );							//小孩数
		$data ['childnobednum'] = $this->input->post ( 'child_not_bed_num' );			//小孩不占床数
		$data ['linkman'] = $this->input->post ( 'linkman' );											//出游人名
		$data ['linkemail'] = $this->input->post ( 'linkemail' );										//出游人邮件
		$data ['linkmobile'] = $this->input->post ( 'linkman_phone' );							//出游人电话
		$linkmobil = $this->input->post ( 'linkman_phone' );
		if (empty ( $data ['linkmobile'] )) {
			$this->__errormsg ( '用户手机不能为空！' );
		}
		$this->load->helper ( 'regexp' );
		if (! regexp ( 'mobile', $data ['linkmobile'] )) {
			$this->__errormsg ( '用户手机号码输入有误' );
		}
		$this->db->trans_start (); 																					 // open
																																	 // 积分
		$this->load->model ( 'common/u_member_model', 'member_model' );
		$reData_member = $this->member_model->row ( array (
				'mid' => $m_id 
		) );
		$this->load->model ( 'common/u_expert_model', 'expert_model' );
		$reData_expert = $this->expert_model->row ( array (
				'id' => $ee_id 
		) );
		$point = $this->input->post ( 'jifen' );																		//积分值
		$data ['jifen'] = isset ( $point ) ? $point : '0';
		if ($point <= $data ['jifen']) {
			if ($point > 0) {
				$data ['jifenprice'] = $point / 100;
			} else {
				$data ['jifenprice'] = '0';
			}
		} else {
			$this->__errormsg ( '积分不足' );
		}
		// $this->db->trans_begin();
		$this->member_model->update ( array (
				'jifen' => $reData_member ['jifen'] - $point 
		), array (
				'mid' => $m_id 
		) );
		$this->load->model ( 'common/u_member_point_log_model', 'u_member_point_log' );
		$point_log = array (
				'point_before' => $reData_member ['jifen'],
				'point_after' => $reData_member ['jifen'] - $point,
				'member_id' => $m_id,
				'point' => $point,
				'content' => '下单支付积分',
				'addtime' => date ( "Y-m-d H:i:s" ) 
		);
		if ($point > '0') {
			$this->u_member_point_log->insert ( $point_log );
		}
		$coupon_choose = $this->input->post ( 'coupon_choose' ); 																						// 优惠券
		if (is_numeric ( $coupon_choose )) {
			$this->load->model ( 'common/cou_member_coupon_model', 'member_coupon_model' );
			$coupon_one_temp = $this->member_coupon_model->page_my_coupon_order ( $m_id, array (
					'id' => $coupon_choose 
			) );
			$coupon_one = $coupon_one_temp ['new'];
			$data ['couponprice'] = isset ( $coupon_one [0] ['coupon_price'] ) ? $coupon_one [0] ['coupon_price'] : '0'; 	 // 优惠卷的价格
			$this->load->model ( 'common/cou_member_coupon_model', 'cou_member_coupon' );
			$this->cou_member_coupon->update ( array (
					'status' => '1' 
			), array (
					'id' => $coupon_choose 
			) );
		}
		$this->load->model ( 'common/u_line_suit_price_model', 'line_suit_model' );
		$reData = $this->line_suit_model->row ( array (
				'suitid' => $data ['suitid'],
				'lineid' => $data ['productautoid'],
				'day' => $data ['usedate'] 
		) );
		$data ['price'] = $reData ['adultprice'];
		if($dingnum)//单人套餐才存储以下字段
		{
		$data ['childprice'] = $reData ['childprice'];
		$data ['oldprice'] = $reData ['oldprice'];
		$data ['childnobedprice'] = $reData ['childnobedprice'];
		}
		else 
		{
			$data['childprice'] = "0";
			$data['oldprice']="0";
			$data['childnobedprice']="0";
		}
																																											// 订单保险
		$insuranceJson = $this->input->post ( 'insuranceList' ); 																			// 保险
		$insurance_price=$settlement_price = 0;
		if (! empty ( $insuranceJson )) {
			foreach ( $insuranceJson as $in => $in_value ) {
				// 保险价格
				$insurance_price = $insurance_price + ($in_value ['insurance_price'] * $in_value ['insurance_num']);
				$settlement_price = $settlement_price + ($in_value ['settlement_price'] * $in_value ['insurance_num']);
			}
		}
		$data ['insurance_price'] =$insurance_price;
		$data ['settlement_price'] =$settlement_price;
		// 订单价格=xx ；实付价格=订单价格-积分价格-优惠券价格+保险价格
		////包括“单人”套餐和“多人”套餐2种情况
		if($dingnum)
		{
			$data ['order_price'] = $data ['dingnum'] * $data ['price'] + $data ['childnum'] * $data ['childprice'] + $data ['oldnum'] * $data ['oldprice'] + $data ['childnobednum'] * $data ['childnobedprice'];
		}
		else 
		{
			$data ['order_price'] = $menu_num*$data ['price'];
		}
		if (isset ( $data ['couponprice'] ) && ! empty ( $data ['couponprice'] )) {
			$coup = $data ['couponprice'];
		} else {
			$coup = '0';
		}
		$data ['total_price'] = $data ['order_price'] - $data ['jifenprice'] - $coup; // -$data['couponprice'];总价格等于订单价格-优惠价格-积分/100
		$data ['channel'] = 1;
		$data ['memberid'] = $m_id;
		$data ['ispay'] = 0;
		$data ['status'] = 0;
		$data ['addtime'] = date ( 'Y-m-d H:i:s', time () );
		// 游客信息
		$touristList = $this->input->post ( 'touristList' );
		// 生成订单号
		$year = date ( 'Y', time () );
		$month = date ( 'm', time () );
		while ( true ) {
			$ordersn = substr ( $year, 2 ) . $month . mt_rand ( 10000000, 99999999 );
			if ($this->create_ordersn ( $ordersn )) {
				break;
			}
		}
		$data ['ordersn'] = $ordersn;
		// 管家佣金
		// 代理费
		if(!empty($exp_id)){
			$expertDatapn = $this->e_model->row ( array (	'id' => $exp_id 		) );										//管家供应商信息
			$lineData = $this->l_model->row ( array (	'id' => $data ['productautoid'] 	) );						//线路ID
			$supplierData = $this->s_model->row ( array (			'id' => $lineData ['supplier_id'] 		) );	//	供应商信息	

			if(	$expertDatapn['supplier_id']==$lineData ['supplier_id']	){
				    $data ['agent_fee']= 0;
			}else
			{
					if(!$dingnum) $data ['agent_fee']=$lineData['agent_rate_int']*$data['dingnum'];//管家*套餐数
					else $data ['agent_fee']=$lineData['agent_rate_int']*($data['dingnum']+$data['oldnum']+$data['childnum']+$data['childnobednum']); //佣金*人数
			}
		}else{
					$data ['agent_fee']= 0;
		}
		$data ['agent_rate']= isset($supplierData['agent_rate'])?$supplierData['agent_rate']:'0';			//agent_rate
		$data ['platform_fee']=$data ['agent_rate']*$data ['total_price']; //平台佣金费
		$data ['productname']=$lineData ['linename'];																	//线路名
		$data ['litpic']=$lineData ['mainpic'];																					//线路图
		$data ['expert_name']=$expertDatapn ['nickname'];														//管家昵称
		$data ['supplier_name']=$supplierData ['company_name'];												//供应商名
		$data ['supplier_id']= $lineData ['supplier_id'];																//供应商ID
		$status = $this->db->insert ( 'u_member_order', $data );
		// 订单插入结束
		// 下单记录
		if (! empty ( $status )) {
			$order_id = $this->db->insert_id ();
			$this->order_status_model->update_order_status_cal($order_id);			//统计订单ID状态用
			
			$log = array (
					'order_id' => $order_id,
					'op_type' => 0,
					'userid' => $data ['memberid'],
					'content' => '会员自己下单',
					'addtime' => $data ['addtime'] 
			);
			$status = $this->db->insert ( 'u_member_order_log', $log );
			$status_attach = $this->db->insert ( 'u_member_order_attach', array (
					'orderid' => $order_id 
			) );
			if (empty ( $status )) {
				$this->result_code = "4000";
				$this->result_msg = "插入用户日志数据或订单附表失败";
				$lastData ['rows'] = "";
				$this->result_data = $lastData;
				$this->resultJSON = json_encode ( array (
						"msg" => $this->result_msg,
						"code" => $this->result_code,
						"data" => $this->result_data,
						"total" => "0" 
				) );
				echo $this->resultJSON;
				exit ();
			}
			// 保险
			if (! empty ( $insuranceJson )) {
				$this->load->model ( "common/u_order_insurance_model", "u_order_insurance" );
				foreach ( $insuranceJson as $insu => $insu_value ) {
					$insu_data = array (
							'order_id' => $order_id,
							'insurance_id' => $insu_value ['insurance_id'],
							'number' => $insu_value ['insurance_num'],
							'amount' => $insu_value ['insurance_price'] * $insu_value ['insurance_num'] 
					);
					$insu_result = $this->u_order_insurance->insert ( $insu_data );
				}
			}
			// 游客信息
			if (! empty ( $touristList )) {
				foreach ( $touristList as $k => $v ) {
					$tour ['name'] = isset ( $v ['name'] ) ? $v ['name'] : $this->__errormsg ( ' 游客姓名不能为空！' );
					$tour ['certificate_type'] = isset ( $v ['cardtype'] ) ? $v ['cardtype'] : $this->__errormsg ( ' 游客证件类别不能为空！' );
					$tour ['certificate_no'] = isset ( $v ['cardnum'] ) ? $v ['cardnum'] : $this->__errormsg ( ' 证件号码不能为空！' );
					$tour ['sex'] = isset ( $v ['sex'] ) ? $v ['sex'] : $this->__errormsg ( ' 性别不能为空！' );
					$tour ['telephone'] = isset ( $v ['phone'] ) ? $v ['phone'] : $this->__errormsg ( ' 游客手机号不能为空！' );
					$tour ['birthday'] = isset ( $v ['birthtime'] ) ? $v ['birthtime'] : $this->__errormsg ( ' 游客出生日期不能为空！' );
					if ((empty ( $v ['enname'] )) && (empty ( $v ['issueAddr'] )) && (empty ( $v ['issuetime'] )) && (empty ( $v ['validtime'] ))) {
						$tour ['enname'] = '';
						$tour ['sign_place'] = '';
						$tour ['sign_time'] = '';
						$tour ['endtime'] = '';
					} else {
						$tour ['enname'] = isset ( $v ['enname'] ) ? $v ['enname'] : $this->__errormsg ( ' 游客英文名字不能为空！' );
						$tour ['sign_place'] = isset ( $v ['issueAddr'] ) ? $v ['issueAddr'] : $this->__errormsg ( ' 签发地不能为空！' );
						$tour ['sign_time'] = isset ( $v ['issuetime'] ) ? $v ['issuetime'] : $this->__errormsg ( ' 签发日期不能为空！' );
						$tour ['endtime'] = isset ( $v ['validtime'] ) ? $v ['validtime'] : $this->__errormsg ( ' 有效期不能为空！' );
					}
					$tour ['member_id'] = $m_id;
					$tour ['addtime'] = date ( 'Y-m-d H:i:s', time () );
					$status = $this->db->insert ( 'u_member_traver', $tour );
					$traver_id = $this->db->insert_id ();
					// 订单关联的出游人信息
					$order_man = array (
							'order_id' => $order_id,
							'traver_id' => $traver_id 
					);
					$status = $this->db->insert ( 'u_member_order_man', $order_man );
				}
			} else {
				$this->__errormsg ( '游客信息不能为空！' );
			}
			// $this->db->trans_complete();
			if ($this->db->trans_status () === TRUE) {
				$this->db->trans_commit ();
			} else {
				$this->db->trans_rollback (); // 事务回滚
				$this->__errormsg ();
			}
			// 事务结束
			// ready send
			
			// 日后整合----------------------------------------

			if (! empty ( $lineData )) {
				// 供应 msg
				$smsData = $this->template_model->row ( array ('msgtype' => 'order_leave') );
				if (! empty ( $smsData ['msg'] )) {
					$msg = str_replace ( "{#LINENAME#}", $lineData ['linename'], $smsData ['msg'] );
					$this->Inside_page_message ( $supplierData ['mobile'], $msg );
				}
				// user msg
				$userData = $this->template_model->row ( array ('msgtype' => 'line_order_msg1') );
				if (! empty ( $userData ['msg'] )) {
					$msg = str_replace ( "{#PRODUCTNAME#}", $lineData ['linename'], $userData ['msg'] );
					$this->Inside_page_message ( $linkmobil, $msg );
				}
				// expert msg
				if (! empty ( $exp_id )) {
// 					$expertDatapn = $this->s_model->row ( array (	'id' => $exp 		) );
					$expertrData = $this->template_model->row ( array ('msgtype' => 'expert_order') );
					if (! empty ( $expertrData ['msg'] )) {
						$msg = str_replace ( "{#LINENAME#}", $lineData ['linename'], $expertrData ['msg'] );
						$this->Inside_page_message ( $expertDatapn ['mobile'], $msg );
					}
				}
			}
			// ----------------------------------------------------------------
			
			$this->result_code = "2000";
			$this->result_msg = "success";
			$lastData ['rows'] = array (
					0 => array (
							'orderid' => $order_id,
							// 'insurance'=>isset($insurance)? $insurance:'',
							// 'order_price'=>$data['order_price'],
							// 'jifen'=>$data['jifenprice'],
							// 'coupon'=>isset($coupon_one)? $coupon_one:'',
							// 'total_price'=>$data['total_price'],
							'name' => $reData_member ['nickname'],
							'phone' => $reData_member ['mobile'],
							'expertphone' => $reData_expert ['mobile'],
							'order_sn' => $ordersn 
					) 
			);
			
			$this->result_data = $lastData;
			$this->resultJSON = json_encode ( array (
					"msg" => $this->result_msg,
					"code" => $this->result_code,
					"data" => $this->result_data,
					"total" => "0" 
			) );
			echo $this->resultJSON;
			exit ();
		} else {
			$this->__errormsg ( '订单生成失败' );
		}
	}
	
	/**
	 * @name：24、下订单成功页面
	 * @author: 温文斌
	 * @param:orderid=订单ID
	 *       
	 * @return:
	 *
	 */
	
	public function cfgm_book_success() {
		$order_id = $this->input->post ( 'orderid' );
		is_numeric ( $order_id ) ? ($order_id) : $this->__errormsg ( 'tip is null !' );
		$this->db->select ( 'mo.ordersn,mo.id,m.nickname,e.realname,e.small_photo,e.mobile' );
		$this->db->from ( 'u_member_order AS mo' );
		$this->db->join ( 'u_expert AS e', 'e.id=mo.expert_id', 'left' );
		$this->db->join ( 'u_member AS m', 'm.mid=mo.memberid', 'left' );
		$this->db->where ( array (
				'mo.id' => $order_id 
		) );
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
		$this->__outmsg ( $reDataArr );
	}

	/**
	 * @name：26、订单评价
	 * @author: 温文斌
	 * @param:orderid=订单ID;number=凭证；dyfw=导游服务；cyzs=餐饮住宿；xcap=行程安排；lyjt=旅游交通
	 *        zytd=专业态度；fwtd=服务态度
	 * @return:
	 *
	 */
	
	public function cfgm_submit_comment() {
		$pics = "";
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$result = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$m_id = $result [0] ['mid'];
		$data ['orderid'] = $order_id = intval ( $this->input->post ( 'order_id', true ) );
		$data ['score1'] = intval ( $this->input->post ( 'dyfw', true ) ); // 导游服务
		$data ['score3'] = intval ( $this->input->post ( 'cyzs', true ) ); // 餐饮住宿
		$data ['score2'] = intval ( $this->input->post ( 'xcap', true ) ); // 行程安排
		$data ['score4'] = intval ( $this->input->post ( 'lyjt', true ) ); // 旅游交通
		$data ['score5'] = intval ( $this->input->post ( 'zytd', true ) ); // 专业态度
		$data ['score6'] = intval ( $this->input->post ( 'fwtd', true ) ); // 服务态度
		$data ['content'] = $this->input->post ( 'estimate', true ); // 线路评价
		$data ['expert_content'] = $this->input->post ( 'expert_comment', true ); // 管家评价
		$data ['isanonymous'] = intval ( $this->input->post ( 'is_anonymity', true ) ); // 匿名评价
		$data ['avgscore1'] = ($data ['score1']+$data ['score2']+$data ['score3']+$data ['score4'])/4; // 线路综合评分
		$data ['avgscore2'] = ($data ['score5'] + $data ['score6']) / 2; // 专家综合评分
		$data ['memberid'] = $m_id;
		$data ['channel'] = 1;
		$data ['isshow'] = 1;
		$data ['addtime'] = date ( 'Y-m-d H:i:s', time () );
		$this->load->model ( 'order_model' );
		$order = $this->order_model->row ( array (
				'id' => $order_id 
		) );
		if ($order) {
			$data ['expert_id'] = $order ['expert_id'];
			$data ['line_id'] = $order ['productautoid'];
		} else {
			$this->__errormsg ( 'order is not exist' );
		}
		
		/*if (empty ( $data ['orderid'] ) || empty ( $data ['score1'] ) || empty ( $data ['score2'] ) || empty ( $data ['score3'] ) || empty ( $data ['score4'] ) || empty ( $data ['score5'] ) || empty ( $data ['score6'] )) {
			$this->__errormsg ( '信息填写不完整' );
		}*/
		// 上传图片
		if ($_FILES) {
			$path = "file/c/img/";
			$len = count ( $_FILES );

			$i = 0;
			foreach ( $_FILES as $key => $val ) {
				$i += 1;
				if ($i < $len) {
					$dh = ",";
				} else {
					$dh = "";
				}
				if ($val) {
					$input_name = $key;
					$fx_pic = $this->cfgm_upload_pimg ( $path, $input_name );
					$pics .= "/file/c/img/" . $fx_pic . $dh;
				}
			}
			$data ['pictures'] = $pics;
			$data ['haspic'] = 1;
		}
		$this->load->model ( 'common/cfg_member_point_model', "cfg_member_point" );
		$this->load->model ( 'common/u_member_model', "u_member" );
		$line_upload_img = $this->cfg_member_point->row ( array (
				'code' => 'COMMENT_PIC',
				'isopen' => '1' 
		) ); // 上传图片送积分
		$line_text_comment = $this->cfg_member_point->row ( array (
				'code' => 'COMMENT_TEXT',
				'isopen' => '1' 
		) ); // 文字评价送积分
		$line_more_text_comment = $this->cfg_member_point->row ( array (
				'code' => 'COMMENT_TEXT_1',
				'isopen' => '1' 
		) ); // 超过30文字送积分
		$line_star_comment = $this->cfg_member_point->row ( array (
				'code' => 'COMMENT_NO_TEXT',
				'isopen' => '1' 
		) ); // 星级评价送积分
		$total_point = 0; // 总积分
		if (! empty ( $data ['score1'] ) && ! empty ( $data ['score2'] ) && ! empty ( $data ['score3'] ) && ! empty ( $data ['score4'] )) {
			$total_point += isset ( $line_star_comment ['value'] ) ? $line_star_comment ['value'] : '0';
		}
		if (! empty ( $pics )) {
			$total_point += isset ( $line_upload_img ['value'] ) ? $line_upload_img ['value'] : '0';
		}
		if (! empty ( $data ['content'] )) {
			if (mb_strlen ( $data ['content'] ) < 30) {
				$total_point += isset ( $line_text_comment ['value'] ) ? $line_text_comment ['value'] : '0'; // 不超过30字
			} else {
				$total_point += isset ( $line_more_text_comment ['value'] ) ? $line_more_text_comment ['value'] : '0'; // 超过30字
			}
		}
		$this->db->trans_start (); // 事务开启
		$status = $this->db->insert ( 'u_comment', $data );
		if ($status) {
			$this->db->update ( 'u_member_order', array (
					'status' => 6 
			), array (
					'id' => $data ['orderid'] 
			) );
		}
		$one = $this->u_member->row ( array (
				'mid' => $m_id 
		) );
		$jifen = isset ( $one ['jifen'] ) ? $one ['jifen'] : '0';
		$update = $this->u_member->update ( array (
				'jifen' => $total_point + $jifen 
		), array (
				'mid' => $m_id 
		) );
		// 积分记录
		$this->load->model ( 'common/u_member_point_log_model', 'u_member_point_log' );
		$logArr = array (
				'member_id' => $m_id,
				'point_before' => $jifen,
				'point_after' => $total_point + $jifen,
				'point' => $total_point,
				'content' => '订单点评赠送积分',
				'addtime' => date ( 'Y-m-d H:i:s', time () ) 
		);
		
		if ($update) // 送积分成功后，才存记录
{
			$this->u_member_point_log->insert ( $logArr );
		}
		$comment_count_status = $this->db->query ( "update u_line set `comment_count`=`comment_count`+1 where id = {$data ['line_id']}" );			//更新线路评论数
		$comment_count_status_expert = $this->db->query ( "update u_expert set `comment_count`=`comment_count`+1 where id = {$order ['expert_id']}");			//更新管家评论数
		if(!$comment_count_status){$this->__errormsg ( '评价数添加有误！' );	}
		$this->db->trans_complete (); // 事务结束
		if ($this->db->trans_status () === TRUE) {
			$this->db->trans_commit ();
		} else {
			$this->db->trans_rollback (); // 事务回滚
			$this->__errormsg ( '评价失败' );
		}
		
		$this->__successmsg ();
	}
	
	/**
	 * @name：27、定制单取消
	 * @author: 温文斌
	 * @param:cid=定制单ID;number=凭证；
	 * @return:
	 *
	 */
	
	public function update_status_del() {
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$cid = $this->input->post ( 'cid', true );
		is_numeric ( $cid ) ? ($cid) : $this->__errormsg ( 'tip is null !' );
		$this->load->model ( 'common/u_customize_model', 'customize_model' );
		$result = $this->customize_model->update ( array (
				'status' => '-2' 
		), array (
				'id' => $cid 
		) );
		if ($result) {
			echo json_encode ( array ('code' => 2000,	'msg' => '取消成功!' 	) );
		} else {
			echo json_encode ( array ('code' => 4000,	'msg' => '取消失败!' 	) );
		}
	}
	
	/**
	 * @name：28、定制单详情
	 * @author: 温文斌
	 * @param:cid=定制单ID;
	 * @return:
	 *
	 */
	
	public function cfgm_customize_info() {
		$c_id = $this->input->post ( 'cid', true );
		is_numeric ( $c_id ) ? ($c_id) : $this->__errormsg ( 'tip is null !' );
		$sql = "SELECT ca.id as ca_id,c.pic AS litpic,c.days,c.question AS question,c.addtime AS addtime,c.budget AS budget,e.small_photo AS small_photo,e.id,e.nickname AS expert_name,c.people AS people_count,e.avg_score AS avg_score,e.total_score AS total_score,eg.title AS e_grade,(SELECT GROUP_CONCAT(d.kindname SEPARATOR ',') FROM u_dest_cfg AS d WHERE FIND_IN_SET(d.id,e.expert_dest)>0) AS good_dest FROM u_customize AS c LEFT JOIN u_customize_answer AS ca ON c.id=ca.customize_id LEFT JOIN u_expert AS e ON ca.expert_id=e.id LEFT JOIN u_expert_grade AS eg ON e.grade=eg.grade WHERE c.id= {$c_id}  AND ca.isuse=1 ";
		$query = $this->db->query ( $sql );
		$reDataArr = $query->result_array ();
		if ($reDataArr) {
			$ca_id = $reDataArr [0] ['ca_id'];
		} else {
			$this->__outmsg ( $reDataArr );
		}
		$sql = "SELECT day, 	breakfirst as breakfirsthas,lunch as lunchhas,supper as supperhas,hotel,jieshao ,`cjp`.`pic` AS pic FROM u_customize_jieshao as cj LEFT JOIN `u_customize_jieshao_pic` AS cjp ON `cj`.`id`=`cjp`.`customize_jieshao_id` WHERE customize_answer_id={$ca_id} ORDER BY day";
		$query = $this->db->query ( $sql );
		$reDataArrs = $query->result_array ();
		foreach ( $reDataArrs as $key => $val ) {
			foreach ( $val as $k => $v ) {
				if ($k == "pic") {
					if ($v) {
						$val [$k] = explode ( ";", $v );
						foreach ( $val [$k] as $k ) {
							if (! empty ( $k )) {
								$val ['pics'] [] = "http://" . $_SERVER ['HTTP_HOST'] . $k;
							}
						}
						$val ['pic'] = '1';
					}
				}
			}
			$reDataArrs [$key] = $val;
		}
		$arr ['fangan'] = $reDataArrs;
		if ($arr ['fangan']) {
			$reDataArr = array_merge ( $reDataArr [0], $arr );
		} else {
			$this->__errormsg ();
		}
		$this->__outmsg ( $reDataArr, 1 );
	}
	
	/**
	 * @name：29、定制所需
	 * @author: 温文斌
	 * @param:type=;
	 * @return:
	 *
	 */

	public function cfgm_play_method() {
		$type = $this->input->post ( 'type', true );
		if ($type == 'hotel') { // 酒店星级
			$query = $this->db->query ( "select dict_id,description from u_dictionary where pid=7" );
			$data ['hotel'] = $query->result_array ();
		} elseif ($type == 'method') { // 出游方式
			$query = $this->db->query ( "select dict_id,description from u_dictionary where pid=39" );
			$data ['method'] = $query->result_array ();
		} elseif ($type == 'theme') { // 旅游主题
			$query = $this->db->query ( "select id,name from u_theme" );
			$data ['theme'] = $query->result_array ();
		} elseif ($type == 'shop') { // 购物要求
			$query = $this->db->query ( "select dict_id,description from u_dictionary where pid=55" );
			$data ['shop'] = $query->result_array ();
		} elseif ($type == 'meal') { // 用餐要求
			$query = $this->db->query ( "select dict_id,description from u_dictionary where pid=59" );
			$data ['meal'] = $query->result_array ();
		} else {
			$data = array ();
		}
		$this->__outmsg ( $data );
	}
	
	
	/*
	 *
	 * do customize 定制订单
	 *
	 * by zhy
	 *
	 * at 2015年x月x日 x:x:x
	 *
	 *
	 *
	 * public function cfgm_ls_customize() {
	 * $this->load->library ( 'session' );
	 * $code_mobile = $this->session->userdata ( 'mobile' );
	 * $code_yzm = $this->session->userdata ( 'code' );
	 * if ($token = $this->input->post ( 'number', true )) {
	 * $this->check_token ( $token );
	 * $this->load->model ( 'common/u_access_token_model','at_model');
	 * $user = $this->at_model->result ( array('access_token' => $token),null,null,null,'arr',null,'mid' );
	 * $m_id = $user[0]['mid'];
	 * }
	 * $password = "";
	 * // $yzm = $this->input->post ( 'yzm', true ); // 验证码
	 * // $data['theme'] = $theme = $this->input->post ( 'theme', true );
	 * // $data['startplace'] = $from = $this->input->post ( 'from', true );
	 * // $data['trip_way'] = $method = $this->input->post ( 'method', true );
	 * // $data['people'] = $people = $this->input->post ( 'people', true );
	 * // $data['startdate'] = $date = $this->input->post ( 'date', true );
	 * // $data['days'] = $days = $this->input->post ( 'days', true );
	 * // $data['budget'] = $budget = $this->input->post ( 'budget', true );
	 * // $end = $this->input->post ( 'end', true );
	 * // // $label = $this->input->post ( 'label', true );
	 * // $data['hotelstar'] = $hotel = $this->input->post ( 'hotel', true );
	 * // $data['isshopping'] = $shop = $this->input->post ( 'isshop', true );
	 * // $data['catering'] = $meal = $this->input->post ( 'meal', true );
	 * // $data['beizhu'] = $beizhu = $this->input->post ( 'beizhu', true );
	 * // $data['linkname'] = $linkname = $this->input->post ( 'linkname', true );
	 * // $data['linkphone'] = $mobile = $this->input->post ( 'mobile', true );
	 * // $data['linkweixin'] = $weixin = $this->input->post ( 'weixin', true );
	 *
	 * $data ['from'] = $this->input->post ( 'from', true );
	 * $data ['estimatedate'] = $this->input->post ( 'estimatedate', true );
	 * $data ['test1id'] = $this->input->post ( 'test1id', true ); //国家
	 * $data ['test2id'] = $this->input->post ( 'test2id', true );
	 * $data ['method'] = $this->input->post ( 'method', true );
	 * $another=$this->input->post ( 'another_choose', true );
	 * $data['another_choose']=rtrim($another, ",");
	 * $data ['question'] = $this->input->post ( 'question', true );
	 * $data ['people'] = $this->input->post ( 'people', true );
	 * $data ['childnum'] = $this->input->post ( 'cp', true );
	 * $data ['childnobednum'] = $this->input->post ( 'cnp', true );
	 * $data ['oldman'] = $this->input->post ( 'olp', true );
	 * $data ['roomnum'] = $this->input->post('roomnum',true);
	 * $data ['startdate'] = $startdate = $this->input->post ( 'dayr', true );
	 * $data ['days'] = $this->input->post ( 'days', true );
	 * $data ['budget'] = $this->input->post ( 'budget', true );
	 * $data ['end'] = $this->input->post ( 'end', true );
	 * $isend=$data ['end'].$data ['test2id'];
	 * $data['isend']=rtrim($isend, ",");
	 * $end=$data['isend'];
	 * $data ['hotel'] = $this->input->post ( 'hotel', true );
	 * $data ['room_require'] = $this->input->post('room_require',true);
	 * $data ['catering'] = $this->input->post('catering',true);
	 * $data ['isshopping'] = $this->input->post ( 'isshopping', true );
	 * $data ['service_range'] = $this->input->post('beizhu',true);
	 * $data ['meal'] = $this->input->post ( 'meal', true );
	 * $data ['beizhu'] = $this->input->post ( 'beizhu', true );
	 * $data ['linkname'] = $this->input->post ( 'linkname', true );
	 * $data ['mobile'] =$pwd= $this->input->post ( 'mobile', true );
	 * $data ['weixin'] = $this->input->post ( 'weixin', true );
	 * $data ['yzm'] = $this->input->post ( 'yzm', true ); //验证码
	 * $data ['total_people']=$this->input->post('total_people',true);
	 * $testtime=date("Y-m-d");
	 * if (empty ( $data ['from'] ) || empty ( $data ['estimatedate'] ) || empty ( $data ['test1id'] ) || empty ( $data ['test2id'] ) || empty ( $data ['method'] ) || empty ( $data['another_choose'] ) || empty ( $data ['startdate'] ) || empty ( $data ['service_range'] ) || empty ( $data ['linkname'] ) || empty ( $data ['mobile'] ) || empty ( $data ['yzm'] ) ) {
	 * $this->__errormsg ();
	 * }
	 *
	 *
	 *
	 * $this->db->trans_start();
	 *
	 * if (empty($m_id)) {
	 * //var_dump('3');
	 * //没有登陆，验证此手机号是否注册，若注册则自动登陆，若没有则自动注册一个账号
	 * $this->load->model ( 'member_model' );
	 * $member_info = $this ->member_model ->row(array('mobile' =>$data['mobile']));
	 * if (!empty($member_info)) {
	 * $m_id = $member_info['mid'];
	 *
	 * }else {
	 * $this->load->model('common/cfg_member_point_model','cfg_member_point');
	 * $point=$this->cfg_member_point->row(array('code'=>'REGISTER','isopen'=>'1'));
	 * $point_num=isset($point['value'])?$point['value']:'0';//积分数
	 * $member_insert_id = array (
	 * 'truename' => $data ['linkname'],
	 * 'loginname' => $mobile,
	 * 'nickname'=>$mobile,
	 * 'mobile' => $mobile,
	 * 'pwd' => md5 ( $mobile ),
	 * 'jointime' => date('Y-m-d H:i:s' ,$time),
	 * 'sex' => - 1,
	 * 'litpic' => '/file/c/img/face.png' ,
	 * 'jifen' => $point_num,
	 * 'logintime' => date('Y-m-d H:i:s' ,$time),
	 * 'loginip'=>$this->get_client_ip(),
	 * );
	 * $this->member_model->insert ( $member_insert_id );
	 * $m_id = $this->db->insert_id ();
	 * //写入积分变化表
	 * if ($member_insert_id['jifen'] >0) {
	 * $memberLogArr = array(
	 * 'member_id' =>$m_id,
	 * 'point_before' =>0,
	 * 'point_after' =>$member_insert_id['jifen'],
	 * 'point' =>$member_insert_id['jifen'],
	 * 'content' =>'注册赠送积分',
	 * 'addtime' =>$member_insert_id['logintime']
	 * );
	 * $this ->db ->insert('u_member_point_log' ,$memberLogArr);
	 * }
	 * $this ->member_coupon(1, $user_id);
	 * //发送短信给用户提示
	 * $this ->load->model('common/u_sms_template_model','template_model');
	 * $smsData = $this ->template_model ->row(array('msgtype' =>'auto_reg'));
	 * if (!empty($smsData['msg'])) {
	 * $msg = str_replace("{#LOGINNAME#}", $mobile ,$smsData['msg']);
	 * $msg = str_replace("{#PASSWORD#}", $pwd ,$msg);
	 * $this ->Inside_send_message($mobile ,$msg);
	 * }else{}
	 * }
	 * }
	 *
	 *
	 * if ($mobile) {
	 * if (! preg_match ( "/1[34578]{1}\d{9}$/", $mobile )) {
	 * $this->__errormsg ();
	 * }
	 * if (! ($code_mobile == $mobile) || ! ($code_yzm == $yzm)) {
	 * $this->__errormsg ();
	 * }
	 *
	 * $this->load->model ( 'member_model' );
	 * $member = $this->member_model->row ( array(
	 * 'mobile' => $mobile
	 * ) );
	 * if (! $member) {
	 * for($i = 0; $i < 6; $i ++) {
	 * $password .= mt_rand ( 0, 9 );
	 * }
	 * $user = array(
	 * 'loginname' => '',
	 * 'pwd' => md5 ( $password ),
	 * 'mobile' => $mobile,
	 * 'jointime' => time (),
	 * 'sex' => - 1 ,
	 * 'jifen' =>2000
	 * );
	 * $query = $this->db->query ( "select * from u_member where mobile={$mobile}" );
	 * $result = $query->result_array ();
	 * if (! $result) {
	 * $this->db->insert ( 'u_member', $user );
	 * $m_id = $this->db->insert_id ();
	 * }
	 * } else {
	 * $m_id = $member['mid'];
	 * }
	 * }
	 *
	 * if ($end) {
	 * if (is_array ( $end )) {
	 * foreach ( $end as $key => $val ) {
	 * $end_str .= $val . ",";
	 * }
	 * $data['endplace'] = $end_str;
	 * } else {
	 * $data['endplace'] = $end;
	 * }
	 * }
	 *
	 * // if ($label) {
	 * // if (is_array ( $label )) {
	 * // foreach ( $label as $key => $val ) {
	 * // $label_str .= $val . ",";
	 * // }
	 * // $data['attrs'] = $label_str;
	 * // } else {
	 * // $data['attrs'] = $label;
	 * // }
	 * // }
	 *
	 * // $data['member_id'] = $m_id;
	 * // $data['user_type'] = 0;
	 * // $data['addtime'] = date ( 'Y-m-d H:i:s', time () );
	 * // $month = date ( 'm', strtotime ( $date ) );
	 * // if ($m = intval ( $month )) {
	 * // $month = $m;
	 * // }
	 * // $data['month'] = $month;
	 * // $szx = date ( 'd', strtotime ( $date ) );
	 * // if ($d = intval ( $szx )) {
	 * // $szx = $d;
	 * // }
	 * // $data['date'] = $szx;
	 * // $data['status'] = 0;
	 * // $data['grabcount'] = 0;
	 * // $data['pic'] = "/file/b2/upload/img/customize.png";
	 * // $data['expert_id'] = 0;
	 *
	 * // $status = $this->db->insert ( 'u_customize', $data );
	 * // if ($status) {
	 * // $this->__successmsg ();
	 * // }
	 *
	 *
	 *
	 *
	 * $data = array (
	 * 'member_id' => $c_userid,
	 * 'startplace' => $data ['from'],
	 * 'endplace' => $data ['isend'],
	 * 'question' => $data ['question'],
	 * 'month' => $data ['month'],
	 * 'date' => $data ['date'],
	 * 'trip_way'=>$data ['method'],
	 * 'another_choose'=>$data['another_choose'],
	 * 'people' => $data ['people'],
	 * 'childnum' => $data ['childnum'],
	 * 'childnobednum' => $data ['childnobednum'],
	 * 'oldman' => $data ['oldman'],
	 * 'roomnum'=>$data ['roomnum'],
	 * 'days' => $data ['days'],
	 * 'startdate' => $data ['startdate'],
	 * 'estimatedate'=>$data ['estimatedate'],
	 * 'budget' => $data ['budget'],
	 * 'hotelstar' => $data ['hotel'],
	 * 'room_require'=>$data ['room_require'],
	 * 'isshopping' => $data ['isshopping'],
	 * 'service_range' => $data ['beizhu'],
	 * 'catering' => $data ['meal'],
	 * 'linkname' => $data ['linkname'],
	 * 'linkphone' => $data ['mobile'],
	 * 'linkweixin' => $data ['weixin'],
	 * 'custom_type' =>$data['test1id'],
	 * //'service_range' => $data ['beizhu'],
	 * 'total_people'=>$data['total_people'],
	 * 'addtime' => date ( 'Y-m-d H:i', time () ),
	 * 'status' => '0',
	 * 'user_type'=>'0',
	 * 'pic'=>'/file/b2/upload/img/customize.png'
	 * );
	 * $this->load->model('common/u_customize_model','u_customize');
	 * $customize_id = $this->u_customize->insert ($data );
	 * $this->load->model('common/u_customize_dest_model','u_customize_dest');
	 * $endplace = explode(',',$end);
	 * for($i=0;$i<count($endplace);$i++){
	 * $this->u_customize_dest->insert(array('customize_id'=>$customize_id,'dest_id'=>$endplace[$i]));
	 * }
	 * $this->db->trans_complete();
	 * if ($this->db->trans_status() === FALSE)
	 * {
	 * return false;
	 * }
	 * else {
	 * if (! empty ( $customize_id )) {
	 * if(!empty($token)){
	 * $this->__successmsg ();
	 * }else{
	 * $reDataArrssdsd = $this->db->query ( "SELECT loginname,pwd FROM `u_member` where mid={$m_id} ORDER BY id limit 1; ")->row_array ();
	 * $this->__outmsg ( $reDataArrssdsd );
	 * }
	 * }
	 * }
	 *
	 * }
	 */
	 
	/**
	 * @name：30、订单列表
	 * @author: 温文斌
	 * @param:number=凭证;
	 * @return:
	 *
	 */
	
	public function cfgm_walk_count() {
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$user = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$m_id = $user [0] ['mid'];
		$sql = "SELECT 
(SELECT count(*) FROM u_member_order AS mb_od LEFT JOIN u_member AS mb ON mb_od.memberid = mb.mid WHERE mb.mid ={$m_id} AND ispay=0 AND (mb_od.status=1) AND mb_od.ispay=0 AND TIMESTAMPDIFF(HOUR,mb_od.addtime,NOW())<24) AS wait_pay, 
(SELECT count(*) FROM u_member_order AS mb_od LEFT JOIN u_member AS mb ON mb_od.memberid = mb.mid WHERE mb.mid ={$m_id} AND (mb_od.status=1 or mb_od.status=4) AND ispay>0) AS wait_walk,
(SELECT count(*) FROM u_member_order AS mb_od LEFT JOIN u_member AS mb ON mb_od.memberid = mb.mid WHERE mb.mid ={$m_id} AND mb_od.status=5 AND ispay>0) AS wait_comment,
(SELECT count(*) FROM u_refund AS r LEFT JOIN u_member_order AS mo ON r.order_id=mo.id WHERE r.refund_type=0 AND r.status=0 AND r.refund_id={$m_id}) AS wait_tk 
FROM u_member_order AS mb_od WHERE mb_od.memberid={$m_id}  order by mb_od.memberid  limit 1        ";
		$query = $this->db->query ( $sql );
		$reDataArr ['four'] = $query->row_array ();
		$query = $this->db->query ( "select mid,nickname,litpic from u_member where mid={$m_id} order by mid limit 1 " );
		$reDataArr ['user'] = $query->row_array ();
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：31、我的定制单
	 * @author：number=凭证;page=当前页；pagesize=每页显示记录数
	 * @return:
	 *
	 */

	public function cfgm_my_line() {
		$page = $this->input->post ( 'page', true );
		$page_size = $this->input->post ( 'pagesize', true );
		$page_size = empty ( $page_size ) ? 5 : $page_size;
		$page = empty ( $page ) ? 1 : $page;
		$from = ($page - 1) * $page_size;
		
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$user = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$m_id = $user [0] ['mid'];
		$this->db->select ( "c.id,c.theme,c.people,ceil(c.budget/c.people) AS budget,c.pic" );
		$this->db->from ( 'u_customize AS c' );
		$this->db->where ( array (
				'c.member_id' => $m_id,
				'c.status >=' => 0 
		) );
		$this->db->limit ( $page_size, $from );
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：32、我的游记
	 * @author: 温文斌
	 * @param:number=凭证;page=当前页；pagesize=每页显示记录数
	 * @return:
	 *
	 */
	
	public function cfgm_my_travel() {
		$page = $this->input->post ( 'page', true );
		$page_size = $this->input->post ( 'pagesize', true );
		$page_size = empty ( $page_size ) ? 5 : $page_size;
		$page = empty ( $page ) ? 1 : $page;
		$from = ($page - 1) * $page_size;
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$user = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$m_id = $user [0] ['mid'];
		$this->db->select ( "tn.cover_pic,tn.title,tn.addtime,m.loginname" );
		$this->db->from ( 'travel_note AS tn' );
		$this->db->join ( 'u_member AS m', 'm.mid=tn.userid', 'left' );
		$this->db->where ( array (
				'tn.userid' => $m_id,
				'tn.is_show' => 1 
		) );
		$this->db->limit ( $page_size, $from );
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：33、游记详情
	 * @author: 温文斌
	 * @param:number=凭证;tnid=游记ID
	 * @return:
	 *
	 */
	
	public function cfgm_travel_detail() {
		$tn_id = $this->input->post ( 'tnid' );
		is_numeric ( $tn_id ) ? ($tn_id) : $this->__errormsg ( 'tip is null !' );
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$user = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$m_id = $user [0] ['mid'];
		$this->db->select ( "tn.cover_pic,tn.title,tn.tags,mo.total_price,(select count(*) from u_line_jieshao AS lj left join u_member_order AS mo on lj.lineid=mo.productautoid) AS days,tn.content1 AS chi,tn.content2 AS zhu,tn.content3 AS xing,tn.content4 AS gou,(select tnp.pic from travel_note_pic AS tnp where tnp.pictype=1 and tnp.note_id={$tn_id}) AS chi_pic,(select tnp.pic from travel_note_pic AS tnp where tnp.pictype=2  and tnp.note_id={$tn_id}) AS zhu_pic,(select tnp.pic from travel_note_pic AS tnp where tnp.pictype=3  and tnp.note_id={$tn_id}) AS xing_pic,(select tnp.pic from travel_note_pic AS tnp where tnp.pictype=4 and tnp.note_id={$tn_id}) AS gou_pic" )->from ( 'travel_note AS tn' )->join ( 'u_member_order AS mo', 'mo.id=tn.order_id', 'left' )->where ( array (
				'tn.userid' => $m_id,
				'tn.id' => $tn_id,
				'tn.is_show' => 1 
		) );
		$reDataArr = $this->db->get ()->result_array ();
		foreach ( $reDataArr as $key => $val ) {
			foreach ( $val as $k => $v ) {
				if ($k == "chi_pic" || $k == "zhu_pic" || $k == "xing_pic" || $k == "gou_pic") {
					if ($v) {
						$val [$k] = explode ( ";", $v );
					}
				}
			}
			$reDataArr [$key] = $val;
		}
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：34、管家游记列表
	 * @author: 温文斌
	 * @param:page=当前页；pagesize=每页显示记录数；eid=管家ID
	 * @return:
	 *
	 */

	public function cfgm_note_comment_list() {
		$page = intval ( $this->input->post ( 'page', true ) );
		$page_size = intval ( $this->input->post ( 'pagesize', true ) );
		$page_size = empty ( $page_size ) ? 6 : $page_size;
		$page = $page == '0' ? 1 : $page;
		$from = ($page - 1) * $page_size;
		$eid = $this->input->post ( "eid" );
		is_numeric ( $eid ) ? ($eid) : $this->__errormsg ( '标识不能为空！' );
		$sql = "     SELECT `m`.`mid` AS m_id, `tn`.`id` AS note_id, `m`.`litpic` AS litpic, `m`.`nickname` AS nickname, `tnr`.`reply_content` AS reply_content, `tnr`.`addtime` AS publish_time    
FROM (`travel_note_reply` AS tnr)     
LEFT JOIN `travel_note` AS tn ON `tnr`.`note_id`=`tn`.`id`      
LEFT JOIN `u_member` AS m ON `tnr`.`member_id`=`m`.`mid`    
WHERE `tn`.`id` = {$eid} ORDER BY `tnr`.`addtime` desc      limit {$from},{$page_size}  ";
		$query = $this->db->query ( $sql );
		$data ['line_list'] = $query->result_array ();
		if (empty ( $data ['line_list'] )) {
			$this->__outmsg ( $data ['line_list'] );
		}
		$sql = rtrim ( $sql, "limit {$from},{$page_size} " );
		$query = $this->db->query ( $sql );
		$data_total = $query->num_rows ();
		$data = array (
				'cur_page' => $from,
				'total' => $page_size,
				'result' => $data ['line_list'] 
		);
		$this->__outmsg ( $data, $data_total );
	}
	
	/**
	 * @name：35、我的分享
	 * @author: 温文斌
	 * @param:number=凭证；page=当前页；pagesize=每页显示记录数；
	 * @return:
	 *
	 */
	
	public function cfgm_my_share() {
		$page = $this->input->post ( 'page', true );
		$page_size = $this->input->post ( 'pagesize', true );
		$page_size = empty ( $page_size ) ? 5 : $page_size;
		$page = empty ( $page ) ? 1 : $page;
		$from = ($page - 1) * $page_size;
		
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$user = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$m_id = $user [0] ['mid'];
		$sql = "SELECT ls.line_id,ls.content,ls.location,ls.addtime,l.linename,GROUP_CONCAT(lsp.pic) AS pic FROM u_line_share_pic AS lsp,u_line_share AS ls LEFT JOIN u_line AS l ON l.id=ls.line_id WHERE ls.member_id={$m_id} AND ls.id=lsp.line_share_id GROUP BY lsp.line_share_id LIMIT {$from},{$page_size}";
		$query = $this->db->query ( $sql );
		$reDataArr = $query->result_array ();
		foreach ( $reDataArr as $key => $val ) {
			$reDataArr [$key] ['pic'] = "";
			if ($val ['pic']) {
				$pic_arr = explode ( ',', $val ['pic'] );
				$val ['pic'] = $pic_arr;
			}
			$reDataArr [$key] = $val;
		}
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：36、我的收藏
	 * @author: 温文斌
	 * @param:number=凭证；page=当前页；pagesize=每页显示记录数；
	 * @return:
	 *
	 */
	
	public function cfgm_my_collection() {
		$page = $this->input->post ( 'page', true );
		$page_size = $this->input->post ( 'pagesize', true );
		$page_size = empty ( $page_size ) ? 5 : $page_size;
		$page = empty ( $page ) ? 1 : $page;
		$from = ($page - 1) * $page_size;
		$token = $this->input->post ( 'number', true );
		$loca = $this->input->post ( 'loca', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$user = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$m_id = $user [0] ['mid'];
		if ($loca == '1') {
			$sql = "    SELECT `lc`.`line_id`, `l`.`linename`, `l`.`lineday`, `l`.`lineprice`, `l`.`mainpic`    FROM (`u_line_collect` AS lc)	    LEFT JOIN `u_line` AS l ON `l`.`id`=`lc`.`line_id`    WHERE `lc`.`member_id` =  {$m_id}   limit {$from},{$page_size}      ";
			$query = $this->db->query ( $sql );
			$reDataArr = $query->result_array ();
			if (empty ( $reDataArr )) {
				$this->__outmsg ( $reDataArr );
			}
			$sql = rtrim ( $sql, "limit {$from},{$page_size} " );
			$query = $this->db->query ( $sql );
			$data_total = $query->num_rows ();
		} else {
			$sql = " SELECT e.id,e.small_photo,e.nickname,eg.title,e.satisfaction_rate,e.people_count,e.comment_count  FROM u_expert_collect AS ec  	LEFT JOIN u_expert AS e ON ec.expert_id=e.id  LEFT JOIN u_expert_grade AS eg ON e.grade=eg.grade  WHERE ec.member_id= {$m_id}  	ORDER BY ec.addtime  limit {$from},{$page_size}       ";
			$query = $this->db->query ( $sql );
			$reDataArr = $query->result_array ();
			if (empty ( $reDataArr )) {
				$this->__outmsg ( $reDataArr );
			}
			$sql = rtrim ( $sql, "limit {$from},{$page_size} " );
			$query = $this->db->query ( $sql );
			$data_total = $query->num_rows ();
			foreach ( $reDataArr as $key => $val ) {
				foreach ( $val as $k => $v ) {
					if ($k == "satisfaction_rate") {
						if ($v) {
							$val [$k] = round ( $v * 100 );
						}
					}
				}
				$reDataArr [$key] = $val;
			}
		}
		$this->__outmsg ( $reDataArr, $data_total );
	}
	
	/**
	 * @name：37、我的浏览记录
	 * @author: 温文斌
	 * @param:number=凭证；page=当前页；pagesize=每页显示记录数；
	 * @return:
	 *
	 */
	
	public function cfgm_browse_record() {
		$page = $this->input->post ( 'page', true );
		$page_size = $this->input->post ( 'pagesize', true );
		$page_size = empty ( $page_size ) ? 5 : $page_size;
		$page = empty ( $page ) ? 1 : $page;
		$from = ($page - 1) * $page_size;
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$user = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$m_id = $user [0] ['mid'];
		$this->db->select ( 'l.id,l.linename,l.mainpic,l.satisfyscore,l.lineprice' );
		$this->db->from ( 'u_line_browse AS lb' );
		$this->db->join ( 'u_line AS l', 'l.id=lb.line_id', 'left' );
		$this->db->where ( array (
				'lb.member_id' => $m_id,
				'l.status' => 2 
		) );
		$this->db->order_by ( "l.addtime", "asc" );
		$this->db->limit ( $page_size, $from );
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
		foreach ( $reDataArr as $key => $val ) {
			foreach ( $val as $k => $v ) {
				if ($k == "satisfyscore") {
					if ($v) {
						$val [$k] = round ( $v * 100 );
					}
				}
			}
			$reDataArr [$key] = $val;
		}
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：38、用户端（订单列表）
	 * @author: 温文斌
	 * @param:number=凭证；code=状态
	 * @return:
	 *
	 */
	public function cfgm_user_order() {
		$where = "";
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$user = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$m_id = $user [0] ['mid'];
		$code = $this->input->post ( 'code', true );
		if ($code == 1) { // 待支付
			$where = "AND ( mb_od.status=1 ) AND ispay=0 AND TIMESTAMPDIFF(HOUR,mb_od.addtime,NOW())<24";
		} elseif ($code == 2) { // 待出行
			$where = "AND ( mb_od.status=1 OR mb_od.status=4 ) AND ispay>0";
		} elseif ($code == 3) { // 待评价
			$where = "AND mb_od.status=5 AND ispay>0";
		}
		$sql = "SELECT 
		               mb_od.id AS mo_id,mb_od.ordersn,l.linetitle as linetitle,mb_od.ispay AS mo_ispay,
		               mb_od.status AS mo_status,mb_od.productname AS linename,mb_od.litpic,
		               mb_od.dingnum,mb_od.childnum,mb_od.oldnum,mb_od.childnobednum,ls.unit,
		              (mb_od.dingnum+mb_od.childnum+mb_od.oldnum+mb_od.childnobednum) AS people,
		              mb_od.usedate AS day,mb_od.total_price,ls.lineid,mb_od.settlement_price,(mb_od.total_price+mb_od.settlement_price) as all_price,
		              CASE WHEN mb_od.ispay = 0 THEN '未支付' WHEN mb_od.ispay = 1 THEN '已首付' WHEN mb_od.ispay = 2 THEN '已支付' END pay_status,
		              CASE WHEN mb_od.id IN (SELECT r.order_id FROM u_refund AS r WHERE r.status=0) AND mb_od.status=-3 THEN '退款审核中' WHEN mb_od.id IN (SELECT r.order_id FROM u_refund AS r WHERE r.status=1) AND mb_od.status=-4 THEN '退款成功' WHEN mb_od.id IN (SELECT r.order_id FROM u_refund AS r WHERE r.status=2) AND mb_od.status=-4 THEN '退款失败' WHEN mb_od.ispay=0 AND TIMESTAMPDIFF(HOUR,mb_od.addtime,NOW())>24 THEN '已经失效' WHEN mb_od.status = -4 THEN '已经取消' WHEN mb_od.status = -3 THEN  '取消中' WHEN mb_od.status = -2 THEN '平台拒绝' WHEN mb_od.status = -1 THEN 'B1拒绝' WHEN mb_od.status = 0 THEN '待留位' WHEN mb_od.status = 1 THEN 'B1已确认留位' WHEN mb_od.status = 2 THEN '用户已付款' WHEN mb_od.status = 3 THEN '平台已确认收款' WHEN mb_od.status = 4 THEN 'B1已控位' WHEN mb_od.status = 5 THEN '出行' WHEN mb_od.status = 6 THEN '点评' WHEN mb_od.status = 7 THEN '已投诉' WHEN mb_od.status = 8 THEN '专家已点评' END order_status 
		        FROM 
		              u_member_order AS mb_od LEFT JOIN 
		              u_member AS mb ON mb_od.memberid = mb.mid 
		              left join u_line as l on mb_od.productautoid = l.id 
		              left join u_line_suit as ls on ls.id=mb_od.suitid
		        WHERE 
		              mb.mid={$m_id} {$where} 
		           
		      ORDER BY 
		              mb_od.addtime DESC,mb_od.status";
		// 退款
		if ($code == 4) {
			$sql = "SELECT 
							mo.id AS mo_id,mo.ordersn,mo.ispay AS mo_ispay,mo.status AS mo_status,r.id AS r_id,
							mo.productname AS linename,mo.litpic,l.linetitle AS linetitle,mo.dingnum,mo.childnum,mo.oldnum,mo.childnobednum,
		                    (mo.dingnum+mo.childnum+mo.oldnum+mo.childnobednum) AS people,ls.unit,
		                    mo.usedate AS day,mo.total_price,mo.settlement_price,(mo.total_price+mo.settlement_price)as all_price,
		                    CASE WHEN mo.ispay=3 AND mo.status=-3 THEN '退款中' WHEN mo.ispay=4 AND mo.status=-4 THEN '退款成功' WHEN r.status=2 THEN '退款失败' END order_status
		            FROM 
		                    u_refund AS r 
		                    LEFT JOIN u_member_order AS mo ON r.order_id=mo.id 
		                    LEFT JOIN u_line AS l ON mo.productautoid = l.id
		                    left join u_line_suit as ls on ls.id=mo.suitid
		            WHERE   
			                mo.memberid={$m_id} 
			        ORDER BY 
			                r.addtime DESC";
		}
		$query = $this->db->query ( $sql );
		$reDataArr = $query->result_array ();
		if ($reDataArr) {
			foreach ( $reDataArr as $key => $val ) {
				foreach ( $val as $k => $v ) {
					if ($k == "usedate") {
						$val [$k] = date ( 'Y-m-d', strtotime ( $val [$k] ) );
					}
				}
				$reDataArr [$key] = $val;
			}
		}
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：39、付款订单详情
	 * @author: 温文斌
	 * @param:number=凭证；bj_id=订单ID
	 * @return:
	 *
	 */
	
	public function cfgm_user_order_detail() {
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$bj = $this->input->post ( 'bj_id', true );
		is_numeric ( $bj ) ? ($bj) : $this->__errormsg ( '标识不能为空！' );
		// 我的订单
		$order_detail=$this->order_detail($bj);
		$arr ['order'] = $order_detail[0]; //第一条记录
		if (empty ( $arr ['order'] )) {
			$this->__outmsg ( $arr ['order'] );
		}
		$arr ['order'] ['team_free'] = $arr ['order'] ['order_price'] - $arr ['order'] ['insurance_price']; // 出团费用
		$arr ['order'] ['discount'] = $arr ['order'] ['jifenprice'] + $arr ['order'] ['couponprice']; // 已优惠
		                                                                                    // 国内外
		$arr ['inou'] = substr ( $arr ['order'] ['overcity'], - 1 );
		if (empty ( $arr ['inou'] )) {
			$arr ['overcity'] = '1';
		}
		// 游客信息列表
		$arr ['yk'] = $this->db->query ( " select group_concat(mt.id) AS id,group_concat(mt.name) AS name,group_concat(mt.enname) AS enname,group_concat(mt.certificate_type) AS certificate_type,group_concat(mt.sex) AS sex,group_concat(mt.certificate_no) AS certificate_no,group_concat(mt.sign_place) AS sign_place,group_concat(mt.sign_time) AS sign_time,date(mt.endtime) AS endtime,group_concat(mt.isman) AS isman,group_concat(mt.telephone) AS phone,group_concat(mt.birthday) AS birth,ud.description as certificate_des from u_member_traver AS mt left join u_dictionary as ud on ud.dict_id=mt.certificate_type where mt.id in (select mom.traver_id from u_member_order_man AS mom where mom.order_id={$bj}) group by mt.id" )->result_array ();
		// 发票
		$arr ['fa'] = $this->db->query ( "select moi.id as id,mi.invoice_type,mi.invoice_name,mi.invoice_detail,mi.receiver,mi.telephone,mi.address,mi.addtime,mi.member_id,umo.total_price from u_member_order_invoice as moi left join u_member_invoice as mi on moi.invoice_id=mi.id 	left join u_member_order as umo on moi.order_id=umo.id 	where moi.order_id={$bj} " )->result_array ();
		$arr ['log'] = $this->db->query ( "				SELECT *  	FROM (`u_member_order_log`)   	WHERE `order_id` = {$bj}	ORDER BY `addtime` desc" )->result_array ();
		$arr ['expert'] = $this->db->query ( "		SELECT id, mobile, big_photo, small_photo, nickname  	FROM (`u_expert`)  	WHERE `id` =  {$arr['order']['expert_id']}   	ORDER BY `id` " )->row_array ();
		
		$this->__outmsg ( $arr, 1 );
	}
	/**
	 * @name：39[2]、 评论、投诉、付款、退款页面
	 * @author: 温文斌
	 * @param:orderid=订单ID;action=操作类型（comment评论、complaint投诉、pay付款、back退款）
	 *
	 * @return:
	 *
	 */
	
	public function cfgm_order_action() {
		$order_id = $this->input->post ( 'orderid' ); //订单号
		$action = $this->input->post ( 'action' ); //操作类型
		//$order_id="101442";
		//$action="pay";
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		
		//用户id
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$result = $this->at_model->result ( array (
				'access_token' => $token
		), null, null, null, 'arr', null, 'mid' );
		$mid = $result [0] ['mid'];
		
        //逻辑开始
		$reDataArr=array();
		if($action=="comment") //评论
		{
			$reDataArr=$this->order_detail($order_id);
		}
		else if($action=="complain")//投诉
		{
			$sql = "
					SELECT
							mo.id,c.id as c_id,c.reason
					FROM
							u_member_order AS mo
							LEFT JOIN u_complain AS c ON mo.id=c.order_id
					WHERE 
							mo.id={$order_id}
			       ";
			$query = $this->db->query ( $sql );
			$row = $query->row_array ();
			
			$reDataArr=$this->order_detail($order_id);
			$reDataArr[0]['reason']=$row['reason'];
			$reDataArr[0]['c_id']=$row['c_id'];
			
			
			
		}
		else if($action=="back") //退款
		{
			$sql = "
					SELECT
							mo.id,r.id as r_id,r.reason,r.amount
					FROM
							u_member_order AS mo
							LEFT JOIN u_refund AS r ON mo.id=r.order_id
					WHERE
							mo.id={$order_id}
			";
			$query = $this->db->query ( $sql );
			$row = $query->row_array ();
			
			$reDataArr=$this->order_detail($order_id);
			$reDataArr[0]['reason']=$row['reason'];
			$reDataArr[0]['r_id']=$row['r_id'];
			$reDataArr[0]['amount']=$row['amount'];
		
			
		}
		else if($action=="pay") //付款
		{
			$reDataArr=$this->order_detail($order_id);
			if($reDataArr[0]['memberid']!=$mid)
			{
				$this->__errormsg('403非法操作');
			}
		}
			
		$this->__outmsg ( $reDataArr );
	}
	/**
	 * @name：40、游客信息操作
	 * @author: 温文斌
	 * @param:number=凭证；bjid=编辑；scid=插入；orderid=订单ID；ykname=名字；ae_name=英文名字；isman=性别
	 * idcard=身份证号码；certificate_type=身份证类型；birth= 出生；startcity=签发地 startcity；starttime=签发时间
	 * endtime= 起止时间；mobile=手机号
	 * @return:
	 *
	 */
	
	
	public function cfgm_action_tourist() {
		$status = 0;
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$bj_id = $this->input->post ( 'bjid', true ); // 编辑
		$sc_id = $this->input->post ( 'scid', true ); // 插入
		$order_id = $this->input->post ( 'orderid', true ); // 隐藏框
		$data ['name'] = $this->input->post ( 'ykname', true ); // 名字
		$data ['enname'] = $this->input->post ( 'ae_name', true ); // 英文名字
		$isman = $this->input->post ( 'isman', true ); // 性别
		if ($isman == 1) {
			$data ['isman'] = 1;
		} elseif ($isman == 2) {
			$data ['isman'] = 0;
		}
		$data ['certificate_type'] = $this->input->post ( 'certificate_type', true ); // 身份证类型
		$data ['certificate_no'] = $this->input->post ( 'idcard', true ); // 身份证号码
		$data ['birthday'] = $this->input->post ( 'birth', true ); // 出生
		$data ['sign_place'] = $this->input->post ( 'startcity', true ); // 签发地 startcity
		$data ['sign_time'] = $this->input->post ( 'starttime', true ); // 签发时间
		$data ['endtime'] = $this->input->post ( 'endtime', true ); // 起止时间
		$data ['telephone'] = $this->input->post ( 'mobile', true ); // 手机
		if ($bj_id) { // 编辑
			$where = array (
					'id' => $bj_id 
			);
			$data ['modtime'] = date ( 'Y-m-d H:i:s', time () );
			$status = $this->db->update ( 'u_member_traver', $data, $where );
		} elseif (empty ( $sc_id )) { // 插入
			$data ['addtime'] = date ( 'Y-m-d H:i:s', time () );
			$status = $this->db->insert ( 'u_member_traver', $data );
			$tourist_id = $this->db->insert_id (); // 返回插入的ID
			$status = $this->db->insert ( 'u_member_order_man', array (
					'order_id' => $order_id,
					'traver_id' => $tourist_id 
			) );
		} else { // 删除
			$status = $this->db->delete ( 'u_member_order_man', array (
					'order_id' => $order_id,
					'traver_id' => $sc_id 
			) );
			$status = $this->db->delete ( 'u_member_traver', array (
					'id' => $sc_id 
			) );
		}
		if ($status) {
			$this->__successmsg ();
		}
	}
	
	
	/**
	 * @name：42、取消订单、申请退单、评价订单、投诉
	 * @author: 温文斌
	 * @param:number=凭证；bjid=编辑；scid=插入；orderid=订单ID；ykname=名字；ae_name=英文名字；isman=性别
	 * @return:
	 *
	 */
	
	public function cfgm_action_order() {
		$this->load->model ( 'admin/b1/order_status_model', 'order_status_model' );						//后台订单状态，统计用。
		$status = 0;
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$user = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$m_id = $user [0] ['mid'];
		$qx = $this->input->post ( 'qx_id', true ); // 取消订单
		$td = $this->input->post ( 'td_id', true ); // 申请退单
		
		$ts = $this->input->post ( 'ts_id', true ); // 投诉
		if ($td) {
			$reason = $this->input->post ( 'reason', true ); // 退款理由
			$total_price = $this->input->post ( 'total_price', true ); // 退款金额
			$mobile = $this->input->post ( 'mobile', true );
			if (empty ( $reason )) {
				$this->__errormsg ( '退款理由不能为空！ ' );
			}
			if (empty ( $total_price )) {
				$this->__errormsg ( '退款金额不能为空！ ' );
			}
			if (empty ( $mobile )) {
				$this->__errormsg ( '手机不能为空! ' );
			}
			if (! preg_match ( "/1[34578]{1}\d{9}$/", $mobile )) {
				$this->__errormsg ( '手机号码错误！' );
			}
			// $card = $this->input->post ( 'card', true );
			// $bank = $this->input->post ( 'bank', true );
		}
		if ($qx || $td) { // 取消订单或退单
			if ($qx) {
				$data ['order_id'] = $qx;
				$log ['content'] = "取消订单成功";
				$sta = - 4;
				$ispay = 4;
				$where = array (
						'id' => $qx 
				);
				$this->order_status_model->update_order_status_cal($qx);
			}
			if ($td) {
				$data ['order_id'] = $td;
				$log ['content'] = "退订中";
				$sta = - 3;
				$ispay = 3;
				$where = array (
						'id' => $td 
				);
				$this->order_status_model->update_order_status_cal($td);
			}
			$status = $this->db->update ( 'u_member_order', array (
					'status' => $sta 
			), $where );
			if ($status && $td) {
				$refund = array (
						'order_id' => $td,
						'refund_type' => 0,
						'refund_id' => $m_id,
						'reason' => $reason,
						'amount_apply' => $total_price,
						'mobile' => $mobile,
						// 'bankcard' => $card,
						// 'bankname' => $bank,
						'status' => 0,
						'is_remit' => 0,
						'addtime' => date ( 'Y-m-d H:i:s', time () ) 
				);
				// print_r($refund);exit();
				$status = $this->db->insert ( 'u_refund', $refund );
				$status = $this->db->update ( 'u_member_order', array (
						'status' => '-3' 
				), array (
						'id' => $td 
				) );
				$this->order_status_model->update_order_status_cal($td);
			}
		}
		
		if ($ts) { // 投诉
			$log ['content'] = "投诉成功";
			$data ['order_id'] = $ts;
			$data ['member_id'] = $m_id;
			$data ['complain_type'] = $this->input->post ( 'complain_type', true ); // 1.专家 2.供应商
			if(empty($data ['complain_type']))
			$this->__errormsg ( '请勾选投诉对象！' );
			$data ['reason'] = $this->input->post ( 'complaint_content', true ); // 投诉内容
			$data ['mobile'] = $this->input->post ( 'mobile', true ); // 用户手机号
			$data ['user_name'] = $this->input->post ( 'user_name', true ); // 用户姓名
			$data ['addtime'] = date ( 'Y-m-d H:i:s', time () );
			$data ['status'] = 0;
			if (empty ( $data ['reason'] ) || empty ( $data ['mobile'] ) || (! preg_match ( "/1[34578]{1}\d{9}$/", $data ['mobile'] ))) {
				$this->__errormsg ( '请完整的输入投诉信息' );
			}
			$status = $this->db->insert ( 'u_complain', $data );
			$status = $this->db->update ( 'u_member_order', array (
					'status' => 7 
			), array (
					'id' => $ts 
			) );
			$this->order_status_model->update_order_status_cal($ts);
		}
		
		// 写入订单日志
		$logArr = array (
				'order_id' => $data ['order_id'],
				'op_type' => 0,
				'userid' => $m_id,
				'content' => $log ['content'],
				'addtime' => date ( 'Y-m-d H:i:s', time () ) 
		);
		$status_log = $this->db->insert ( 'u_member_order_log', $logArr );
		
		if ($status) {
			$this->__successmsg ();
		}
	}
	
	
	/**
	 * @name：44、支付宝支付成功
	 * @author: 温文斌
	 * @param:number=凭证；orderid=订单ID；all_price=付款金额；fapiao=订单号；bank=银行；
	 * cdname=发票抬头；ticketype=发票类型；mobile= 手机号；cityval=省市区；citypid=详细地址
	 * @return:
	 *
	 */
	
	public function cfgm_pay_success() {
		$this->load->model ( 'admin/b1/order_status_model', 'order_status_model' );
		$order_id = $this->input->post ( 'orderid', true );
		
		$amount = $this->input->post ( 'all_price', true ); // 付款金额
		$bank = $this->input->post ( 'bank', true );
		// $card = $this->input->post('card',true);
		// $hz_number = $this->input->post('hz_number',true);
		$fapiao = $this->input->post ( 'fapiao', true ); // 订单号
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$result = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$userid = $result [0] ['mid'];
		is_numeric ( $order_id ) ? ($order_id) : $this->__errormsg ( 'tip is null ' );
		if (($fapiao == '1')) {
			$invoice_name = ($this->input->post ( 'cdname', true )); // 发票抬头
			$invoice_detail = ($this->input->post ( 'ticketype', true )); // 发票类型
			$receiver = ($this->input->post ( 'toname', true )); // 收件人
			$telephone = ($this->input->post ( 'mobile', true )); // 手机号
			$city = ($this->input->post ( 'cityval' )); // 省市区
			$address = ($this->input->post ( 'citypid', true )); // 详细地址
			if (empty ( $invoice_name )) {
				$this->__errormsg ( '请填写发票抬头' );
			}
			if (empty ( $invoice_detail )) {
				$this->__errormsg ( '请填写发票类型' );
			}
			if (empty ( $receiver )) {
				$this->__errormsg ( '请填写收件人' );
			}
			if (empty ( $telephone )) {
				$this->__errormsg ( '请填写手机号' );
			}
			if (empty ( $city )) {
				$this->__errormsg ( '请填写省市区' );
			}
			if (empty ( $address )) {
				$this->__errormsg ( '请填写填写详细地址' );
			}
			$time = date ( 'Y-m-d H:i:s', time () );
			$invoiceArr = array (
					'invoice_name' => $invoice_name,
					'invoice_detail' => $invoice_detail,
					'receiver' => $receiver,
					'telephone' => $telephone,
					'address' => $city . $address,
					'member_id' => $userid,
					'modtime' => $time 
			);
			$this->load->model ( 'common/u_member_order_invoice_model', 'order_invoice_model' );
			$this->load->model ( 'common/u_member_invoice_model', 'invoice_model' );
			$invoiceData = $this->order_invoice_model->row ( array (
					'order_id' => $order_id 
			) );
			if (empty ( $invoiceData )) {
				$invoiceArr ['addtime'] = $time;
				$invoiceId = $this->invoice_model->insert ( $invoiceArr );
				if (empty ( $invoiceId )) {
					$this->__errormsg ( '系统繁忙，稍后重试' );
				} else {
					$oiArr = array (
							'order_id' => $order_id,
							'invoice_id' => $invoiceId 
					);
					$this->order_invoice_model->insert ( $oiArr );
				}
			} else {
				$status = $this->invoice_model->update ( $invoiceArr, array (
						'id' => $invoiceData ['invoice_id'] 
				) );
				if (empty ( $status )) {
					$this->__errormsg ( '系统繁忙，稍后重试' );
				}
			}
		}
		
		$order_detail = array (
				'order_id' => $order_id,
				'amount' => $amount,
				'bankname' => $bank,
				// 'bankcard' => $card,
				// 'receipt'=>$hz_number,
				'addtime' => date ( 'Y-m-d H:i:s', time () ),
				'status' => 0 
		);
		$status = $this->db->insert ( 'u_order_detail', $order_detail );
		if ($status) {
			$data = array (
					'status' => 2,
					'ispay' => 2 
			);
			$where = array (
					'id' => $order_id 
			);
			$status = $this->db->update ( 'u_member_order', $data, $where );
			$this->order_status_model->update_order_status_cal($order_id);				//统计订单用
			
		}
		if ($status) {
			$this->__successmsg ();
		}
	}
	
	/**
	 * @name：45、线下支付
	 * @author: 温文斌
	 * @param:data
	 
	 * @return:
	 *
	 */
	
	public function cfgm_offline_pay() 
	  {
		//1、加载模型
		$this->load->model ( 'admin/b1/order_status_model', 'order_status_model' );
		$this->load->model ( 'order_model', 'order_model' );
		$this->load->model ( 'line_model', 'line_model' );
		
		//2、传值（银行）
		$account_name = $this->input->post ( 'name' ); //开户人姓名
		$bank_name = $this->input->post ( 'bank' );//银行
		$card_num = $this->input->post ( 'num' ); //银行卡号
		$receipt = $this->input->post ( 'sn' );  //流水号
		$receipt_img = $this->input->post ( 'imgurl' ); //流水图片
		if(empty($receipt_img )){$receipt_img='';}
		
		$pay_amount = floatval ( $this->input->post ( 'pric' ) ); //付款金额
		$order_id = $this->input->post ( 'orderid' ); //订单ID
		$fapiao = intval ( $this->input->post ( 'fapiao' ) ); //是否要发票
		$token = $this->input->post ( 'number', true );  //token
		
		//3、传值（发票信息）
		$invoice_name = ($this->input->post ( 'cdname', true )); // 发票抬头
		$invoice_detail = ($this->input->post ( 'ticketype', true )); // 发票类型
		$receiver = ($this->input->post ( 'toname', true )); // 收件人
		$telephone = ($this->input->post ( 'mobile', true )); // 手机号
		$city = ($this->input->post ( 'cityval' )); // 省市区
		$address = ($this->input->post ( 'citypid', true )); // 详细地址
		
		//4、检查登录、用户id
		$this->check_token ( $token );//检测登录
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$result = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$userid = $result [0] ['mid'];
		
		//5、订单验证、线路有效验证
		$order_info = $this->order_model->row ( array ('id' => $order_id ) ); // 判断订单是否存在
		if (empty ( $order_info )) {$this->__errormsg ( "订单不存在！" );}
		
		$line_info = $this->line_model->row ( array ('id' => $order_info ['productautoid'],'status' => 2) );
		if (empty ( $line_info ))
		{
			$this->__errormsg ( "您选择的旅游线路不存在或已下架，请咨询您的旅游专家！" ); // 验证线路
		}
		
		//6、存入数据表u_member_order_invoice、u_member_invoice（发票）
		if (($fapiao == '1')) 
		{
			if (empty ( $invoice_name ))     {$this->__errormsg ( '请填写发票抬头' );	}
			if (empty ( $invoice_detail ))   {$this->__errormsg ( '请填写发票类型' );	}
			if (empty ( $receiver ))		 {$this->__errormsg ( '请填写收件人' );	}
			if (empty ( $telephone )) 		 {$this->__errormsg ( '请填写手机号' );	}
			if (empty ( $city )) 		     {$this->__errormsg ( '请填写省市区' );	}
			if (empty ( $address ))			 {$this->__errormsg ( '请填写填写详细地址' );	}
			$time = date ( 'Y-m-d H:i:s', time () );
			$invoiceArr = array (
					'invoice_name' => $invoice_name,
					'invoice_detail' => $invoice_detail,
					'receiver' => $receiver,
					'telephone' => $telephone,
					'address' => $city . $address,
					'member_id' => $userid,
					'modtime' => $time 
			);
			$this->load->model ( 'common/u_member_order_invoice_model', 'order_invoice_model' );
			$this->load->model ( 'common/u_member_invoice_model', 'invoice_model' );
			$invoiceData = $this->order_invoice_model->row ( array (
					'order_id' => $order_id 
			) );
			if (empty ( $invoiceData )) {
				$invoiceArr ['addtime'] = $time;
				$invoiceId = $this->invoice_model->insert ( $invoiceArr );
				if (empty ( $invoiceId )) {
					$this->__errormsg ( '系统繁忙，稍后重试' );
				} else {
					$oiArr = array (
							'order_id' => $order_id,
							'invoice_id' => $invoiceId 
					);
					$this->order_invoice_model->insert ( $oiArr );
				}
			} else {
				$status = $this->invoice_model->update ( $invoiceArr, array (
						'id' => $invoiceData ['invoice_id'] 
				) );
				if (empty ( $status )) {
					$this->__errormsg ( '系统繁忙，稍后重试' );
				}
			}
		}
		
		//7、存入数据表u_order_detail（订单详情）
		if (empty ( $account_name )) 				{$this->__errormsg ( "付款人开户名必填！" );	}
		if (empty ( $bank_name )) 					{$this->__errormsg ( "付款人开户银行名称必填！" );}
		if (empty ( $card_num )) 					{$this->__errormsg ( "付款人银行卡号必填！" );}
		if (empty ( $receipt )) 					{$this->__errormsg ( "流水回执号必填！" );}
		
		if(empty($line_info ['first_pay_rate']))
			$first_pay_rate="1";
		else
		    $first_pay_rate = $line_info ['first_pay_rate']; // 线路首付比例
		
		$min_pay_money = ($order_info ['total_price']+$order_info ['settlement_price']) * $first_pay_rate; // 最少支付金额
		$all_price=$order_info ['total_price']+$order_info ['settlement_price']; //订单总额
		// 判断订单的支付状态
		switch ($order_info ['ispay']) {
			case 0 : // 没有支付
				if ($order_info ['status'] == 1) 
				{ 
					// B1已留位可以支付 、  验证支付金额
				    if ($pay_amount<$min_pay_money)
				     { 
				     	$this->__errormsg ( "支付金额最少为：￥{$min_pay_money}，请您重新填写支付金额" );
				     }
				    if($pay_amount>$all_price) 
				     {
						$this->__errormsg ( "您填写的支付金额超过了订单金额!" );
					 }
				}elseif ($order_info ['status'] == 0) {
					$this->__errormsg ( "您的订单旅行社尚未留位，请耐心等待，如有问题请咨询旅游专家!" );
				} elseif ($order_info ['status'] < 0) {
					$this->__errormsg ( "您的订单已取消，或留位失败" );
				} else {
					$this->__errormsg ( "订单有误，请联系客服" );
				}
				break;
			case 1 : // 付完首付(支付宝每个订单号只可以支付一次)
				if ($order_info ['status'] < 2) {
					$this->__errormsg ( "订单有误，请联系客服" );
				} else {
					// 验证支付金额
					$final_pay = $order_info ['total_price'] - $order_info ['first_pay']; // 尾款
					if (abs ( $pay_amount - $final_pay ) > 0.001) {
						$this->__errormsg ( "您填写的支付尾款不正确，尾款为：￥{$final_pay}" );
					}
				}
				break;
			case 2 : // 已付完
				$this->__errormsg ( "订单已支付完成，无需再支付" );
				break;
			default : // 未知状态
				$this->__errormsg ( "订单有误，请联系您的专家" );
				break;
		}
		// 验证流水号不能重复填写
		$this->db->select ( 'count(*) AS receipt_count' );
		$this->db->from ( 'u_order_detail' );
		$this->db->where ( array (
				'receipt' => $receipt,
				'bankname' => $bank_name,
				'bankcard' => $card_num 
		) );
		$receipt_c = $this->db->get ()->result_array ();
		if ($receipt_c [0] ['receipt_count'] >= 1) {
			$this->__errormsg ( "流水回执号已经存在,请重新填写" );
		}
		// 写入订单支付详情表
		$this->db->trans_begin ();
		$insert_data ['order_id'] = $order_info ['id'];
		$insert_data ['amount'] = $pay_amount;
		$insert_data ['account_name']=$account_name;
		$insert_data ['bankname'] = $bank_name;
		$insert_data ['bankcard'] = $card_num;
		$insert_data ['receipt'] = $receipt;
		$insert_data ['addtime'] = date ( 'Y-m-d H:i:s' );
		$insert_data ['beizhu'] = '线下付款';
		$insert_data ['receipt_pic'] = $receipt_img;
		$insert_data ['status'] = 0;
		$status = $this->db->insert ( 'u_order_detail', $insert_data );
		
		//8、写入订单日志表u_member_order_log、更改订单支付状态、发送短信
		if ($status) 
		{
			$log_data ['order_id'] = $order_id;
			$log_data ['op_type'] = 0;
			$log_data ['userid'] = $userid;
			$log_data ['content'] = '用户付款 ';
			$log_data ['order_status'] = $order_info ['status'];
			$log_data ['addtime'] = date ( 'Y-m-d H:i:s' );
			$this->db->insert ( 'u_member_order_log', $log_data );   //订单日志
			$order_data = array (
					'isneedpiao' => isset ( $fapiao ) ? $fapiao : '0',
					'ispay' => 1,
					'first_pay' => $pay_amount,
					'final_pay' => 0 
			);
			$this->db->where ( array (
					'id' => $order_info ['id'] 
			) );
			
			$order_status = $this->db->update ( 'u_member_order', $order_data ); //更改订单状态
			
			$this->order_status_model->update_order_status_cal($order_id); //统计订单ID状态用
			
			if ($order_status) 
			{
				/*
				 * 发消息给1:B2,2:B1
				 * 启用session
				 * $this->load->library('session');
				 * $userid=$this->session->userdata('c_userid');
				 * $username=$this->session->userdata('c_username');
				*/
				// 订单信息
				$order_message = $this->order_model->get_alldata ( 'u_member_order', array (
						'id' => $order_id 
				) );
		
				$expert = $this->input->post ( 'expert' );
				$supplier = $this->input->post ( 'supplier' );
				if (! empty ( $expert )) { // 发给b2
					$this->add_message ( '用户' . $username . '付款，订单号:' . $order_message ["ordersn"] . ',线路：' . $order_message ['productname'], '1', $expert );
				}
				if (! empty ( $supplier )) { // 发给B1
					$this->add_message ( '用户' . $username . '付款，订单号:' . $order_message ["ordersn"] . ',线路：' . $order_message ['productname'], '2', $supplier );
				}
				// 统计订单操作数据
				$this->load->model ( 'admin/b1/order_status_model', 'order_status_model' );
				$this->order_status_model->update_order_status_cal ( $order_id );
				
				//返回接口数据
				if ($this->db->trans_status () === FALSE) 
				{
					$this->db->trans_rollback ();
				} 
				else 
				{
					$this->db->trans_commit ();
					echo json_encode ( array (
							'code' => 2000,
							'msg' => 'ok',
							'status'=>$order_status
					) );
				}
				//end
			} 
			else 
			{
				echo json_encode ( array ('code' => 4000,'msg' => '提交失败' ) );
			}
		} 
		else 
		{
			echo json_encode ( array (
					'code' => 4000,
					'msg' => '写入订单付款详情失败' 
			) );
		}
	}
	
	/**
	 * @name：46、对应支付时候的城市插件数组
	 * @author: 温文斌
	 * @param:无
	 * @return:
	 *
	 */
	

	public function cfgm_pay_city() {
		$areaData = $this->db->query ( "select id,name,pid,level from u_area where isopen=1  order by level asc " )->result_array ();
		$areaArr = array ();
		foreach ( $areaData as $key => $val ) {
			switch ($val ['level']) {
				case 2 :
					if ($val ['pid'] == 2) {
						$areaArr ['domestic'] ['tow'] [$val ['id']] = $val;
					}
					break;
				case 3 :
					if (array_key_exists ( $val ['pid'], $areaArr ['domestic'] ['tow'] )) {
						$areaArr ['domestic'] ['tow'] [$val ['pid']] ['three'] [$val ['id']] = $val;
					}
					break;
				case 4 :
					foreach ( $areaArr ['domestic'] ['tow'] as $k => &$v ) {
						if (array_key_exists ( $val ['pid'], $v ['three'] )) {
							$areaArr ['domestic'] ['tow'] [$k] ['three'] [$val ['pid']] ['four'] [] = $val;
						}
					}
					break;
			}
		}
		$this->__outmsg ( $areaArr );
	}
	
	/**
	 * @name：47、展示用户信息
	 * @author: 温文斌
	 * @param:number=凭证
	 * @return:
	 *
	 */
	
	public function cfgm_show_info() {
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$result = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$this->db->select ( "mid,nickname,email,truename,address,postcode,sex" );
		$this->db->from ( 'u_member' );
		$this->db->where ( array (
				'mid' => $result [0] ['mid'] 
		) );
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：48、修改用户信息
	 * @author: 温文斌
	 * @param:number=凭证；data
	 * @return:
	 *
	 */
	
	public function cfgm_update_info() {
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$result = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$data ['nickname'] = $this->input->post ( 'nickname', true );		//昵称
		$data ['email'] = $this->input->post ( 'email', true );					//邮件
		$data ['truename'] = $this->input->post ( 'truename', true );		//真名
		$data ['sex'] = $this->input->post ( 'sex', true );							//性别
		$data ['address'] = $this->input->post ( 'address', true );				//地址
		$data ['postcode'] = $this->input->post ( 'postcode', true );			
		// $data['sex'] = $this->input->post ( 'sex', true );
		$mid = $result [0] ['mid'];
		$where = array (
				'mid' => $mid 
		);
		$this->db->update ( 'u_member', $data, $where );
		$num = $this->db->affected_rows ();
		if ($num) {
			$this->__successmsg ();
		}
	}
	
	/**
	 * @name：49、修改用户头像图片
	 * @author: 温文斌
	 * @param:number=凭证；data
	 * @return:
	 *
	 */
	
	public function user_update_photo() {
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$result = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$m_id = $result [0] ['mid'];
		//$path = "/file/c/img/";
		$path = "../bangu/file/c/img/";
		$input_name = "upfile";
		$photo = $this->cfgm_upload_pimg ( $path, $input_name );
		$where = array (
				'mid' => $m_id 
		);
		if (is_array ( $photo )) {
			$this->__errormsg ( "只能上传一张！" );
		} else {
			$data = array (
					'litpic' => "/file/c/img/" . $photo 
			);
			$status = $this->db->update ( 'u_member', $data, $where );
		}
		if ($status) {
			$this->__successmsg ( $m_id );
		}
	}
	
	/**
	 * @name：50、修改密码
	 * @author: 温文斌
	 * @param:number=凭证；data
	 * @return:
	 *
	 */
	
	public function cfgm_set_password() {
		$ys_psd = $this->input->post ( 'old_password', true );
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$result = $this->at_model->result ( array ('access_token' => $token ), null, null, null, 'arr', null, 'mid' );
		$this->load->model ( 'common/u_member_model', 'mm_model' );
		$ys_data = $this->mm_model->result ( array ('mid' => $result [0] ['mid'] 	), null, null, null, 'arr', null, 'mid,pwd' );
		if ($ys_data [0] ['pwd'] != md5 ( $ys_psd )) {
			$this->__errormsg ( "原密码错误", "-2" );
		}
		if ($new_psd = $this->input->post ( 'new_password', true )) {
			$data ['pwd'] = md5 ( $new_psd );
		} else {
			$this->__errormsg ( '新密码不能为空！' );
		}
		$where = array (
				'mid' => $result [0] ['mid'] 
		);
		$status = $this->db->update ( 'u_member', $data, $where );
		if ($status) {
			$this->__successmsg ();
		} else {
			$this->__errormsg ();
		}
	}
	
	/**
	 * @name：51、更新密码
	 * @author: 温文斌
	 * @param:number=凭证；data
	 * @return:
	 *
	 */
	
	public function cfgm_phone_password() {
		$this->load->library ( 'session' );
		$mobile = $this->input->post ( 'mobile', true );
		$data ['pwd'] = md5 ( $this->input->post ( 'new_password', true ) );
		$code = $this->input->post ( 'code', true );
		$where = array (
				'mobile' => $mobile 
		);
		$code_mobile = $this->session->userdata ( 'mobile' );
		$code_number = $this->session->userdata ( 'code' );
		$code_time = $this->session->userdata ( 'time' );
		if (($code_mobile == $mobile) && ($code_number == $code)) {
			$status = $this->db->update ( 'u_member', $data, $where );
			if ($status) {
				$this->__successmsg ( '重设密码成功' );
			} else {
				$this->__errormsg ( '重设密码失败' );
			}
		} else {
			$this->__errormsg ( '验证码输入错误' );
		}
	}
	
	/**
	 * @name：52、退出登录
	 * @author: 温文斌
	 * @param:number=凭证；data
	 * @return:
	 *
	 */
	
	public function cfgm_user_logout() {
		$token = $this->input->post ( 'number', true );
		$time = time () - 3600;
		$status = $this->db->query ( "update u_access_token set access_token_validtime={$time} where access_token='{$token}'" );
		if ($status) {
			$this->__successmsg ();
		}
	}
	
	/**
	 * @name：53、线路种类
	 * @author: 温文斌
	 * @param:dest=目的地
	 * @return:
	 *
	 */

	public function cfgm_line_sort() {
		$dest_id = $this->input->post ( 'dest', true );
		$reDataArr ['cjy'] = $this->db->query ( "select dd.id,dd.kindname as name  from u_dest_cfg as dd where dd.pid IN (SELECT d.id FROM u_dest_cfg as d where d.pid=1) and dd.`level`=3  and dd.isopen=1  limit 15 " )->result_array ();
		$reDataArr ['gny'] = $this->db->query ( "select dd.id,dd.kindname as name from u_dest_cfg as dd where dd.pid IN (SELECT d.id FROM u_dest_cfg as d where d.pid=2) and dd.`level`=3  and dd.isopen=1   limit 15 " )->result_array ();
		$reDataArr ['zty'] = $this->db->query ( "	select id,name  from u_theme  " )->result_array ();
		if (empty ( $dest_id )) {
			$reDataArr ['zby'] = $this->db->query ( "	select u.kindname as name ,u.id from cfg_round_trip as c LEFT JOIN u_dest_cfg as u on u.id = c. neighbor_id where c.startplaceid='235' and u.isopen=1   " )->result_array ();
		} else {
			$reDataArr ['zby'] = $this->db->query ( "	select u.kindname as name ,u.id from cfg_round_trip as c LEFT JOIN u_dest_cfg as u on u.id = c. neighbor_id where c.startplaceid={$dest_id} and u.isopen=1   " )->result_array ();
		}
		$this->__outmsg ( $reDataArr );
		
	}
	
	/**
	 * @name：54、城市周边
	 * @author: 温文斌
	 * @param:cityname=当前城市
	 * @return:
	 *
	 */

	public function cfgm_in_location() {
		$city_name = $this->input->post ( 'cityname' );
		if (preg_match ( '/^[\x{4e00}-\x{9fa5}]+$/u', $city_name )) {
			$query = $this->db->query ( "SELECT id AS p_id FROM u_area WHERE name like '%{$city_name}%'" );
			$city = $query->result_array ();
			if (empty ( $city )) {
				$this->__errormsg ();
			}
		} else {
			$this->__errormsg ( '城市输入有误！' );
		}
		$this->db->select ( 'id AS a_id,name AS a_name,pid AS p_id,(SELECT name FROM u_area WHERE id=pid) AS p_name' );
		$this->db->from ( 'u_area' );
		$this->db->where ( array (
				'pid' => $city [0] ['p_id'],
				'isopen' => 1,
				'level' => 4 
		) );
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：55、管家类型
	 * @author: 温文斌
	 * @param:cityname=当前城市
	 * @return:
	 *
	 */
	
	public function cfgm_expert_type() {
		$this->db->select ( 'eg.id,eg.grade,eg.title' );
		$this->db->from ( 'u_expert_grade AS eg' );
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：56、城市周边
	 * @author: 温文斌
	 * @param:cityname=当前城市
	 * @return:
	 *
	 */
	
	public function cfgm_around_city() {
		//根据城市名去找寻周边游
		$city_name = $this->input->post ( 'cityname' );
		if (preg_match ( '/^[\x{4e00}-\x{9fa5}]+$/u', $city_name )) {
			$sql = "select a.pid from u_area AS a where a.name like '%{$city_name}%'";
			$query = $this->db->query ( $sql );
			$dest = $query->result_array ();
			if (! $dest) {
				$this->__errormsg ();
			}
		} else {
			$this->__errormsg ( '城市输入有误！' );
		}
		$this->db->select ( "a.id AS n_id,a.name AS n_name" );
		$this->db->from ( 'u_area AS a' );
		$this->db->where ( array (
				'a.pid' => $dest [0] ['pid'] 
		) );
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：57、城市糅合大写拼音查找
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */

	public function cfgm_sort_city() {
		$this->load->library ( 'get_pinying' );
		$reDataArr = array ();
		$city_arr = array ();
		$sql = "SELECT  s2.areaid as id, s2.cityname as name ,s2.enname,s2.simplename , UPPER(SUBSTRING(s2.simplename,1,1 )) AS ch , s2.ishot ,s2.level ,s3.pid FROM u_startplace s2   LEFT JOIN  u_startplace s3  ON s2.pid =s3.id WHERE   s2.level =3  	AND s2.isopen=1  ORDER BY s2.enname,s2.pid DESC , s2.simplename ASC";
		$all_citys = $this->db->query ( $sql )->result_array ();
		// $sql = "select s.id,s.cityname AS name from u_startplace AS s left join u_startplace AS p on p.id=s.pid left join u_startplace AS f on f.id=p.pid where s.isopen=0 and s.ishot=1 and f.id={$sort_id}";
		// $hot_citys = $this->db->query ( $sql )->result_array ();
		if ($all_citys) {
			foreach ( $all_citys as $key => $val ) {
				$val ['spell'] = $this->get_pinying->getAllPY ( $val ['name'] ); // 全拼
				$szm_py [$key] = strtoupper ( substr ( $this->get_pinying->getFirstPY ( $val ['name'] ), 0, 1 ) ); // 首字母拼音大写
				$reDataArr [$szm_py [$key]] [] = $val;
			}
			if ($reDataArr) {
				ksort ( $reDataArr );
			}
			$city_arr ['all_city'] = $reDataArr;
		}
		// if($hot_citys){
		// $city_arr['hot_city'] = $hot_citys;
		// }
		$this->__outmsg ( $city_arr );
	}
	
	/**
	 * @name：58、搜索城市
	 * @author: 温文斌
	 * @param:city=城市名字
	 * @return:
	 *
	 */

	public function find_city() {
		$find = array ();
		$i = 0;
		$this->load->library ( 'get_pinying' );
		$city = $this->input->post ( 'city', true );
		if ($city) {
			$reDataArr = array (); // 中文搜索
			$reDataArr = $this->db->query ( "select s.id,s.cityname from u_startplace AS s left join u_startplace AS p on p.id=s.pid left join u_startplace AS f on f.id=p.pid where s.pid>2 and s.cityname LIKE '%" . $city . "%'" )->result_array ();
			if (! $reDataArr) {
				$sql = "select s.id,s.cityname from u_startplace AS s left join u_startplace AS p on p.id=s.pid left join u_startplace AS f on f.id=p.pid where  s.pid>2";
				$all_citys = $this->db->query ( $sql )->result_array ();
				if ($all_citys) {
					$pattern = "/" . strtolower ( $city ) . "/";
					foreach ( $all_citys as $key => $val ) {
						$py = array ();
						$all_py = $this->get_pinying->getAllPY ( $val ['cityname'] ); // 全拼
						$szm_py = $this->get_pinying->getFirstPY ( $val ['cityname'] ); // 首字母缩写拼音
						$py [$all_py] = $val ['cityname'];
						$py [$szm_py] = $val ['cityname'];
						foreach ( $py as $k => $v ) { // 全拼、简拼 搜索
							if (preg_match ( $pattern, $k )) {
								$reDataArr [$i] ['id'] = $val ['id'];
								$reDataArr [$i] ['cityname'] = $v;
								$i ++;
							}
						}
					}
				}
			}
			$reDataArr = $this->unique_arr ( $reDataArr, $k = 'cityname' );
			$this->__outmsg ( $reDataArr );
		}
	}
	
	/**
	 * @name：59、全部城市
	 * @author: 温文斌
	 * @param:city=城市名字
	 * @return:
	 *
	 */
	
	public function cfgm_all_city() {
		$this->load->library ( 'get_pinying' );
		$reDataArr = array ();
		$city_arr = array ();
		$sql = "select s.id,s.cityname AS name from u_startplace AS s left join u_startplace AS p on p.id=s.pid left join u_startplace AS f on f.id=p.pid where p.pid between 2 and 36";
		$dome_citys = $this->db->query ( $sql )->result_array ();
		$sql = "select s.id,s.cityname AS name from u_startplace AS s left join u_startplace AS p on p.id=s.pid left join u_startplace AS f on f.id=p.pid where p.id between 37 and 999";
		$abro_citys = $this->db->query ( $sql )->result_array ();
		if ($dome_citys) {
			foreach ( $dome_citys as $key => $val ) {
				$val ['spell'] = $this->get_pinying->getAllPY ( $val ['name'] ); // 全拼
				$szm_py [$key] = strtoupper ( substr ( $this->get_pinying->getFirstPY ( $val ['name'] ), 0, 1 ) ); // 首字母拼音大写
				$reDataArr [$szm_py [$key]] [] = $val;
			}
			if ($reDataArr) {
				ksort ( $reDataArr );
			}
			$city_arr ['dome_city'] = $reDataArr;
		}
		if ($abro_citys) {
			$city_arr ['abro_city'] = $abro_citys;
		}
		$this->__outmsg ( $city_arr );
	}
	
	/**
	 * @name：60、线路标签
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function cfgm_line_attr() {
		// $this->db->select ( 'la.id,la.attrname,la.ishot,la.pid,a.attrname AS p_name' );
		// $this->db->from ( 'u_line_attr AS la' );
		// $this->db->join ( 'u_line_attr AS a', 'a.id=la.pid', 'left' );
		// $this->db->where ( array(
		// 'la.isopen' => 1,
		// 'la.pid > ' => 0
		// ) );
		// $this->db->order_by ( 'pid' );
		// $query = $this->db->get ();
		// $reDataArr = $query->result_array ();
		$sql = "select id,attrname,displayorder,ishot from u_line_attr where pid= 155 and isopen =1";
		$query = $this->db->query ( $sql );
		$reDataArr ['观光'] = $query->result_array ();
		$sql = "select id,attrname,displayorder,ishot from u_line_attr where pid= 156 and isopen =1";
		$query = $this->db->query ( $sql );
		$reDataArr ['度假'] = $query->result_array ();
		$sql = "select id,attrname,displayorder,ishot from u_line_attr where pid= 157 and isopen =1";
		$query = $this->db->query ( $sql );
		$reDataArr ['主题'] = $query->result_array ();
		$sql = "select id,attrname,displayorder,ishot from u_line_attr where pid= 217 and isopen =1";
		$query = $this->db->query ( $sql );
		$reDataArr ['运动'] = $query->result_array ();
		$sql = "select id,attrname,displayorder,ishot from u_line_attr where pid= 218 and isopen =1";
		$query = $this->db->query ( $sql );
		$reDataArr ['娱乐'] = $query->result_array ();
		$sql = "select id,attrname,displayorder,ishot from u_line_attr where pid= 219 and isopen =1";
		$query = $this->db->query ( $sql );
		$reDataArr ['餐饮'] = $query->result_array ();
		$sql = "select id,attrname,displayorder,ishot from u_line_attr where pid= 220 and isopen =1";
		$query = $this->db->query ( $sql );
		$reDataArr ['酒店'] = $query->result_array ();
		$sql = "select id,attrname,displayorder,ishot from u_line_attr where pid= 221 and isopen =1";
		$query = $this->db->query ( $sql );
		$reDataArr ['交通'] = $query->result_array ();
		$sql = "select id,attrname,displayorder,ishot from u_line_attr where pid= 222 and isopen =1";
		$query = $this->db->query ( $sql );
		$reDataArr ['行程'] = $query->result_array ();
		$sql = "select id,attrname,displayorder,ishot from u_line_attr where pid= 223 and isopen =1";
		$query = $this->db->query ( $sql );
		$reDataArr ['体验'] = $query->result_array ();
		$sql = "select id,attrname,displayorder,ishot from u_line_attr where pid= 224 and isopen =1";
		$query = $this->db->query ( $sql );
		$reDataArr ['价格'] = $query->result_array ();
		$sql = "select id,attrname,displayorder,ishot from u_line_attr where pid= 225 and isopen =1";
		$query = $this->db->query ( $sql );
		$reDataArr ['适合'] = $query->result_array ();
		$sql = "select id,attrname,displayorder,ishot from u_line_attr where pid= 226 and isopen =1";
		$query = $this->db->query ( $sql );
		$reDataArr ['类型'] = $query->result_array ();
		// print_r($this->db->last_query());exit();
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：61、管家展示信息
	 * @author: 温文斌
	 * @param:page=当前页；pagesize=每月展示记录数
	 * @return:
	 *
	 */
	
	public function cfgm_experience_show() {
		$page = $this->input->post ( 'page', true );
		$page_size = $this->input->post ( 'pagesize', true );
		$page_size = empty ( $page_size ) ? 5 : $page_size;
		$page = empty ( $page ) ? 1 : $page;
		$from = ($page - 1) * $page_size;
		$sql = "SELECT mex.id AS tys_id,me.litpic AS tys_photo,mo.productname AS l_name,tn.content,tn.id AS tn_id,mo.price AS total_price,tn.title,tn.cover_pic AS productpic FROM u_member_experience AS mex LEFT JOIN u_member AS me ON mex.member_id=me.mid LEFT JOIN travel_note AS tn ON mex.member_id=tn.userid LEFT JOIN u_member_order AS mo ON tn.order_id=mo.id GROUP BY mex.id ORDER BY mex.id LIMIT {$from},{$page_size}";
		$query = $this->db->query ( $sql );
		$reDataArr = $query->result_array ();
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：62、管家展示信息-详情
	 * @author: 温文斌
	 * @param:yjid=
	 * @return:
	 *
	 */

	public function cfgm_experience_detail() {
		$yj_id = $this->input->post ( 'yjid' );
		is_numeric ( $yj_id ) ? ($yj_id) : $this->__errormsg ( 'tip is null ' );
		$sql = "SELECT mex.id AS tys_id,me.litpic AS tys_photo,me.truename,tn.addtime,tn.content,tn.title,tn.cover_pic,tn.content1 AS chi_content,tn.content2 AS zhu_content,tn.content3 AS xing_content,tn.content4 AS gou_content FROM u_experience_consult AS ec LEFT JOIN u_member_experience AS mex ON ec.experience_id = mex.id LEFT JOIN  u_member_order AS mo ON mex.order_id = mo.id LEFT JOIN u_member AS me ON mex.member_id=me.mid LEFT JOIN travel_note AS tn ON mex.member_id=tn.userid WHERE tn.id={$yj_id}";
		$query = $this->db->query ( $sql );
		$reDataArr = $query->result_array ();
		$reDataArr [0] ['chi_pic'] = "";						//吃图片
		$reDataArr [0] ['zhu_pic'] = "";						//住图片
		$reDataArr [0] ['xing_pic'] = "";						//行图片
		$reDataArr [0] ['gou_pic'] = "";						//优图片
		if (empty ( $reDataArr )) {
			$this->__errormsg ();
		}
		// 吃住行购 图片
		$query = $this->db->query ( "select tnp.pic,tnp.pictype from travel_note_pic AS tnp where note_id={$yj_id}" );
		$czxg = $query->result_array ();
		if ($czxg) {
			foreach ( $czxg as $key => $val ) {
				if ($val ['pictype'] == 1) {
					$reDataArr [0] ['chi_pic'] = explode ( ';', $val ['pic'] );
				}
				if ($val ['pictype'] == 2) {
					$reDataArr [0] ['zhu_pic'] = explode ( ';', $val ['pic'] );
				}
				if ($val ['pictype'] == 3) {
					$reDataArr [0] ['xing_pic'] = explode ( ';', $val ['pic'] );
				}
				if ($val ['pictype'] == 4) {
					$reDataArr [0] ['gou_pic'] = explode ( ';', $val ['pic'] );
				}
			}
		}
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：63、管家展示信息糅合游记
	 * @author: 温文斌
	 * @param:id
	 * @return:
	 *
	 */
	
	public function cfgm_experience_info() {
		$e_id = $this->input->post ( 'id' );
		is_numeric ( $e_id ) ? ($e_id) : $this->__errormsg ( 'tip is null ' );
		$sql = "select tn.id AS tn_id,tn.title,tn.addtime,tn.cover_pic,tn.comment_count AS pl_count,tn.praise_count from travel_note AS tn left join u_member_order AS mo ON mo.id=tn.order_id where tn.userid={$e_id}";
		$query = $this->db->query ( $sql );
		$yj_list ['yj_list'] = $query->result_array ();
		$sql = "select mex.order_count,(select count(*) from travel_note AS tn where tn.userid={$e_id}) AS yj_count,me.litpic AS tys_photo,me.truename,me.sex from u_member_experience AS mex left join u_member AS me on me.mid=mex.member_id where mex.status=1 and mex.member_id={$e_id}";
		$query = $this->db->query ( $sql );
		$reDataArr = $query->result_array ();
		if ($reDataArr && $yj_list ['yj_list']) {
			$reDataArr = array_merge ( $reDataArr [0], $yj_list );
		} else {
			$this->__errormsg ();
		}
		$this->__outmsg ( $reDataArr, 1 );
	}
	

	/**
	 * @name：64、照相馆
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */

	public function cfg_get_museum() {
		$reDataArr = $this->db->query ( 'select id,name,address,linkman,linkmobile,addtime,beizhu,price from u_museum ' )->result_array ();
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：65、管家注册验证第一页（境内、境外）
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function cfgm_expert_register_p1() {
		$this->load->library ( 'session' );
		$login_name = $this->input->post ( 'login_name', true ); // 登录名
		$password = $this->input->post ( 'password', true ); // 密码
		$reg_type = $this->input->post ( 'reg_type', true ); // 境内外
		$code = $this->input->post ( 'code', true ); // 验证码
		
		if ($reg_type == 1) {
			// =1为境内
			$code_mobile = $this->session->userdata ( 'mobile' );
			$code_number = $this->session->userdata ( 'code' );
			if (! preg_match ( "/1[34578]{1}\d{9}$/", $login_name )) {
				$this->__errormsg ( '手机号码错误！' );
			}
			if (empty ( $code_mobile )) {
				$this->__errormsg ( '请获取验证码! ' );
			}
		} else {
			$kk = $this->session->userdata ( 'email_code' );
			$code_number = $kk ['code'];
			$code_mobile = $kk ['email'];
			if (! preg_match ( "/^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/", $login_name )) {
				$this->__errormsg ( '邮箱错误！' );
			}
			if (empty ( $code_number )) {
				$this->__errormsg ( '请获取验证码!' );
			}
		}
		
		if (($code_mobile == $login_name) && ($code_number == $code)) {
			echo json_encode ( array (
					'code' => 2000,
					'msg' => 'ok!' 
			) );
		} else {
			$this->__errormsg ( '验证码错误！' );
		}
	}
	/**
	 * @name：66[0]、根据城市获得上门服务区域（境内）
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function cfgm_get_area() 
	{
		$cityid = $this->input->post ( 'city', true ); // 城市id
		if(!$cityid)  $this->__errormsg ( 'city is null !' );
		$query = $this->db->query ( "select * from u_area where pid={$cityid}" );
		$output= $query->result_array();
		$this->__outmsg ( $output );
	}
	/**
	 * @name：66[1]、管家注册验证第二页（境内）
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function cfgm_expert_register_p2() {
		$nickname = $this->input->post ( 'nickname', true ); // 用户昵称
		$sex = $this->input->post ( 'sex', true ); // 性别
		$small_photo = $this->input->post ( 'icon_photo', true ); // 头像
		$realname = $this->input->post ( 'realname', true ); // 真实姓名
		
		$idcard = $this->input->post ( 'idcard', true ); // 身份证号码
		$idcardpic = $this->input->post ( 'idcardpic', true ); // 证件正面照片
		$noidcardpic = $this->input->post ( 'noidcardpic', true ); // 证件反面照片
		
		$email = $this->input->post ( 'email', true ); // 电子邮箱
		$this_door = $this->input->post ( 'this_door', true ); // 上门服务
		$city = $this->input->post ( 'city', true ); // 所属城市
		$expert_dest = $this->input->post ( 'expert_dest', true ); // 擅长路线
		$talk = $this->input->post ( 'talk', true ); // 个人描述 (150字)
		
		$talklen = strlen ( $talk );
		$query = $this->db->query ( "select nickname from u_expert where nickname='{$nickname}'" );
		$expert_rows= $query->num_rows();
		
		if (empty ( $nickname )) 				{$this->__errormsg ( '请填写昵称' );}
		if ($expert_rows>0) 				    {$this->__errormsg ( '昵称已被占用，请重新输入' );}
		if ($sex!='1'&&$sex!='0') 				{$this->__errormsg ( '请选择性别' );}
		if (empty ( $small_photo )) 			{$this->__errormsg ( '请上传头像' );}
		if (empty ( $realname )) 				{$this->__errormsg ( '请填写真实姓名' );}
		
		if (empty ( $idcard )) 					{$this->__errormsg ( '身份证号不能为空' );}
		$this->load->helper ( 'regexp' );
		if (! regexp ( 'cid', $idcard )) 		{$this->__errormsg ( "请输入正确的身份证号" );}
		if (empty ( $idcardpic )) 				{$this->__errormsg ( '请上传身份证正面照片' );}
		if (empty ( $noidcardpic )) 				{$this->__errormsg ( '请上传身份证反面照片' );}
		
		if (!empty ( $email ))			
		{			
			if (! preg_match ( "/^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/", $email )) {
				$this->__errormsg ( '邮箱错误' );
			}
		}
		if (empty ( $city )) 					{$this->__errormsg ( '请选择所属城市' );}
		if (empty ( $expert_dest )) 			{$this->__errormsg ( '请选择擅长路线！' );}
		if (empty ( $this_door )) 			{$this->__errormsg ( '请选择上门服务' );}
		if (empty ( $talk )) 					{$this->__errormsg ( '请填写个人描述' );						 }
		if ($talklen < 6 || $talklen > 150) 	{$this->__errormsg ( '请填写6到150字以内的个人简介');}
		echo json_encode ( array ('code' => 2000,'msg' => 'ok!' ) );
	}
	/**
	 * @name：66[2]、管家注册验证第二页（境外）
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function cfgm_expert_register_p2_out() 
	{
		$nickname = $this->input->post ( 'nickname', true ); // 用户昵称
		$sex = $this->input->post ( 'sex', true ); // 性别
		$small_photo = $this->input->post ( 'icon_photo', true ); // 头像
		$realname = $this->input->post ( 'realname', true ); // 真实姓名
		
		$idcard_type = $this->input->post ( 'idcard_type', true ); // 证件类型
		$idcard = $this->input->post ( 'idcard', true ); // 证件号码
		$idcardpic = $this->input->post ( 'idcardpic', true ); // 证件正面照片
		$noidcardpic = $this->input->post ( 'noidcardpic', true ); // 证件反面照片
		
		$mobile = $this->input->post ( 'moblie', true ); // 手机号码
		$city = $this->input->post ( 'city', true ); // 所属城市
		$this_door = $this->input->post ( 'this_door', true ); // 上门服务
		$expert_dest = $this->input->post ( 'expert_dest', true ); // 擅长路线
		$talk = $this->input->post ( 'talk', true ); // 个人描述 (150字)
		
		$talklen = strlen ( $talk );
		$query = $this->db->query ( "select nickname from u_expert where nickname='{$nickname}'" );
		$expert_rows= $query->num_rows();
		
		if (empty ( $nickname )) 				{$this->__errormsg ( '请填写昵称' );}
		if ($expert_rows>0) 				    {$this->__errormsg ( '昵称已被占用，请重新输入' );}
		if ($sex!='1'&&$sex!='0')  			    { $this->__errormsg ( '请填写性别' );}
		if (empty ( $small_photo )) 			{$this->__errormsg ( '请上传头像' );}
		if (empty ( $realname )) 				{$this->__errormsg ( '请填写真实姓名' );}
						
		if (empty ( $idcard_type )) 			{$this->__errormsg ( '证件类型不能为空' ); }
		if (empty ( $idcard )) 					{$this->__errormsg ( '证件号不能为空' );}
		if (empty ( $idcardpic )) 				{$this->__errormsg ( '请上传证件正面照片' );}
		if (empty ( $noidcardpic )) 			{$this->__errormsg ( '请上传证件反面照片' );}
		
		$this->load->helper ( 'regexp' );
		if (empty($mobile)) 	                {$this->__errormsg ( "请输入手机号码" );}
		if (! regexp ( 'mobile', $mobile )) 		{$this->__errormsg ( "请输入正确的手机号码" );}
		if (empty ( $city )) 				    {$this->__errormsg ( '请选择所属城市' );	}
		if ($this_door!='1'&&$this_door!='0')	{$this->__errormsg ( '请选择上门服务' );	}
		if (empty ( $expert_dest )) 			{$this->__errormsg ( '请选择擅长路线！' ); }
		if (empty ( $talk )) 					{$this->__errormsg ( '请填写个人描述！' );}
		if ($talklen < 6 || $talklen > 150) 	{$this->__errormsg ( '请填写6到150字以内的个人简介！' );}
		echo json_encode( array ('code' => 2000,'msg' => 'ok!' ) );
	}
	
	/**
	 * @name：67、管家注册
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function cfgm_expert_register() {
		$this->load->library ( 'session' );
		$noCheckCode = $this->input->post ( 'noCheckCode', true ); // 是否需要"验证码"验证，true为不需要，false为需要，默认为fasle
		//1、传值 （第一个页面）
		$login_name = $this->input->post ( 'login_name', true ); // 登录名
		$password = $this->input->post ( 'password', true ); // 密码
		$reg_type = $this->input->post ( 'reg_type', true ); // 境内外
		$code = $this->input->post ( 'code', true ); // 验证码
		//2、传值 （第二个页面）
		$nickname = $this->input->post ( 'nickname', true ); // 用户昵称
		$sex = $this->input->post ( 'sex', true ); // 性别
		$small_photo = $this->input->post ( 'icon_photo', true ); // 头像
		$realname = $this->input->post ( 'realname', true ); // 真实姓名
		
		$idcardtype = $this->input->post ( 'idcard_type', true ); // 证件类型
		$idcard = $this->input->post ( 'idcard', true ); // 证件号（身份证号码）
		$idcardpic = $this->input->post ( 'idcardpic', true ); // 身份证扫描正面
		$noidcardpic = $this->input->post ( 'noidcardpic', true ); // 身份证扫描反面                               
		
		$email = $this->input->post ( 'email', true ); // 电子邮箱
		$phone = $this->input->post ( 'phone', true ); // 手机号
		$weixin = $this->input->post ( 'weixin', true ); // 微信号
		$city = $this->input->post ( 'city', true ); // 所属城市
		$this_door = $this->input->post ( 'this_door', true ); // 上门服务
		$expert_dest = $this->input->post ( 'expert_dest', true ); // 擅长路线
		$talk = $this->input->post ( 'talk', true ); // 个人描述 (150字)
		$museum = $this->input->post ( 'museum', true ); // 照相馆
		$certificate = $this->input->post ( 'certificate', true ); // -- 证书名称
		
		//3、传值（第三个页面）
		$school = $this->input->post ( 'school', true ); // 毕业院校
		$lycy = $this->input->post ( 'lycy', true ); // 旅游从业
		$year = $this->input->post ( 'year', true ); // 工作年限
		$jobs = $this->input->post ( 'jobs', true ); // --所在企业
		
		//处理字段
		if(!empty($small_photo )){ $small_photo= $small_photo ;}else{$small_photo='';}
		if(!empty($idcardpic )){ $idcardpic= $idcardpic ;}else{$idcardpic='';}
		if(!empty($noidcardpic )){ $noidcardpic= $noidcardpic ;}else{$noidcardpic='';}
		if(!empty($unidcardpic )){ $unidcardpic= $unidcardpic ;}else{$unidcardpic='';}
		
	
		$email_code_number = $this->session->userdata ( 'email_code' );
		$code_number = $this->session->userdata ( 'code' );
	
		if (empty ( $email_code_number ) && empty ( $code_number ) && $noCheckCode == false) {	$this->__errormsg ( '长时间未操作，请重新填写' );}
		//4、第三个页面： 验证
		if (empty ( $school )) 		{$this->__errormsg ( '请选择毕业院校' );}
		if (empty ( $lycy )) 	    {$this->__errormsg ( '请填写旅游从业岗位' );}
		if (empty ( $year )) 		{$this->__errormsg ( '请选择工作年限' );}
		    // 验证旅游从业简历
		if (! empty ( $jobs ) && is_array ( $jobs )) {
			foreach ( $jobs as $k => $v ) {
				if (empty ( $jobs [$k] ['starttime'] ))			{$this->__errormsg ( '请填写从业经历的起始时间' );}
				if (empty ( $jobs [$k] ['company_name'] ))		{$this->__errormsg ( '经历处请填写公司名称' );}
				if (empty ( $jobs [$k] ['job'] ))				{$this->__errormsg ( '请填写职务' );}
				if (empty ( $jobs [$k] ['endtime'] )) 			{$this->__errormsg ( '请填写从业经历的结束时间' );}
				if (empty ( $jobs [$k] ['description'] ))		{	$this->__errormsg ( '经历处请填写描述' );}
			}
		} else {
			$this->__errormsg ( '请添加从业经历' );
		}
		
       //5、数据操作
	   $this->db->trans_begin ();
	   if (! empty ( $city ) && ($city > 1)) 
	   {
					$province = $this->db->query ( "select pid from u_area where id ={$city}" )->result_array ();
					$pro = ($province ['0'] ['pid']);
					if (! empty ( $pro )) {
						$country = $this->db->query ( "select pid from u_area where id ={$pro}" )->result_array ();
						$con = ($country ['0'] ['pid']);
					}
	   } 
	   else 
	   {
					$pro = 0;
					$con = 0;
	   }
	   $data = array (
					'type' => $reg_type,
	   		        'nickname' => $nickname,
					'mobile' => is_numeric ( $login_name ) ? $login_name : $phone,
					'login_name' => $login_name,
					'password' => md5 ( $password ),
					'realname' => $realname,
					'sex' => intval ( $sex ),
	   		        'idcardtype' => isset ( $idcardtype ) ? $idcardtype : '',//证件类型
					'idcard' => $idcard,//证件号
					'idcardpic' => $idcardpic,//证件正面
					'idcardconpic'=>$noidcardpic, //证件反面
					'visit_service' => $this_door,
					'email' => empty ( $email ) ? $login_name : $email,
					'weixin' => $weixin,
					'small_photo' => $small_photo,
					'big_photo' => $small_photo,
					'talk' => $talk,
					'province' => $pro,
					'country' => $con,
					'beizhu' => '毕业于' . $school . ';旅游从业岗位：' . $lycy . ';' . intval ( $year ) . '年从业经验',
					'expert_dest' => $expert_dest,
					'city' => isset ( $city ) ? $city : 0,
					'status' => 1,
					'is_limit' => 0,
					'grade' => 1,
					'addtime' => date ( 'Y-m-d H:i:s', time () ),
					'modtime' => date ( 'Y-m-d H:i:s', time () ),
					'isstar' => 0,
	   				'register_channel'=>'3',       //注册渠道app
	   		        'is_kf'=>'N'   //是否是客服
			         );
			
			$this->load->model ( 'common/u_expert_model', 'expert_model' );
			$expertid = $this->expert_model->insert ( $data );
			if (empty ( $expertid )) {
				$this->__errormsg ( '添加失败，稍后再试' );
			}   //插入u_expert表（管家）
			
			if (! empty ( $jobs ) && is_array ( $jobs )) {
				foreach ( $jobs as $k => $v ) {
					$tour ['expert_id'] = $expertid;
					$tour ['company_name'] = $v ['company_name'];
					$tour ['job'] = $v ['job'];
					$tour ['starttime'] = $v ['starttime'];
					$tour ['endtime'] = $v ['endtime'];
					$tour ['description'] = $v ['description'];
					$tour ['status'] = 1;
					$status = $this->db->insert ( 'u_expert_resume', $tour );
				}
			} else {
				$this->__errormsg ( '从业信息有误！' );
			}  //插入 u_expert_resume表（就业信息）
		
			if (! empty ( $certificate ) && is_array ( $certificate )) {
				foreach ( $certificate as $k => $v ) {
					$tours ['expert_id'] = $expertid;
					$tours ['certificate'] = $v ['certificate'];
					$tours ['certificatepic'] =  	isset($v ['certificatepic']	)?$v ['certificatepic']:'';		
					$tours ['status'] = 1;
					$status = $this->db->insert ( 'u_expert_certificate', $tours );
				}
			} // 插入 u_expert_certificate 表 （荣耀证书）
			
			
			if (! empty ( $museum )) 
			{    // 管家关联相馆表
				$this->load->model ( '/common/u_expert_museum_model', 'museum_model' );
				$data = $this->museum_model->all ( array (
						'expert_id' => $expertid 
				) );
				if (empty ( $data )) {
					$museum = array (
							'expert_id' => $expertid,
							'museum_id' => $museum,
							'qrcode' => '/file/qrcodes/' . $expertid . '_qr.png',
							'addtime' => date ( 'Y-m-d H:i:s' ),
							'status' => 0 
					);
					$expert_museum_id = $this->museum_model->insert ( $museum );
					if (! empty ( $expert_museum_id )) { // 管家二维码关联表
						$qrcode = array (
								'qrcode' => '/file/qrcodes/' . $expertid . '_qr.png',
								'status' => 0,
								'expert_id' => $expertid,
								'expert_museum_id' => $expert_museum_id 
						);
						$this->load->model ( '/common/u_expert_qrcode_model', 'qrcode_model' );
						$this->qrcode_model->insert ( $qrcode );
					}
				} else {
					$this->museum_model->update ( array (
							'museum_id' => $museum 
					), array (
							'expert_id' => $expertid 
					) );
					
				}
				
				$this->get_qrcodes ( $expertid ); // 申请二维码
			}  // 照片二维码
			
			
			//6、返回结果
			if ($this->db->trans_status () === FALSE) 
			{
				$this->db->trans_rollback ();
			} 
			else
			{
				$this->db->trans_commit ();
				echo json_encode ( array ('code' => 2000,'msg' => 'ok' ) );
			}
	  // END 
	}
	/**
	 * @name：68[2]、修改管家注册信息
	 * @author: 温文斌
	 * @param: number=凭证
	 * @return:
	 *
	 */
	
	public function cfgm_update_expert_register() 
	{
		$m_id = $this->input->post ( 'eid', true ); //管家id

		if(empty($m_id))
			$this->__errormsg('mid is null');
		$sql = "select 
						e.id,e.login_name,e.realname,e.nickname,e.mobile,e.email,e.qq,e.idcardtype,e.idcard,e.sex,e.small_photo,e.small_photo as true_small_photo,e.big_photo,e.big_photo as true_big_photo,e.weixin,
						e.idcardpic,e.idcardpic as true_idcardpic,e.idcardconpic,e.idcardconpic as true_idcardconpic,e.city,us.cityname,e.talk,em.qrcode,m.id as museum_id,m.name as museum_name,m.address as museum_address,
						e.beizhu,e.type,
						(select GROUP_CONCAT(d.kindname) from u_dest_cfg as d where FIND_IN_SET(d.id,e.expert_dest)) as expert_dest_name,e.expert_dest,
						(select GROUP_CONCAT(a.name) from u_area as a where FIND_IN_SET(a.id,e.visit_service)) as visit_service_name,e.visit_service
		        from 
		        		u_expert as e
		        		left join u_startplace as us on us.id=e.city
		        		left join u_expert_museum as em on em.expert_id=e.id
		        		left join u_museum as m on m.id=em.museum_id
		        where 	
						e.id={$m_id}";
		$query = $this->db->query ( $sql );
		$reDataArr = $query->row_array ();
		//性别
		if($reDataArr['sex']=='0')
		{
			$reDataArr['sex_name']="女";
		}
		else if($reDataArr['sex']=='1')
		{
			$reDataArr['sex_name']="男";
		}
		else
		{
			$reDataArr['sex_name']="保密";
		}
		//国内国外
		if($reDataArr['type']=='1')
		{
			$reDataArr['type_name']="境内";
		}
		elseif($reDataArr['type']=='2')
		{
			$reDataArr['type_name']="境外";
		}
		//大学，专业，年
		$arr=explode(";",$reDataArr['beizhu']);
		$reDataArr['school']=mb_substr($arr[0],3);
		$reDataArr['zhuanye']=@mb_substr($arr[1],7);
		$reDataArr['year']=@mb_substr($arr[2],0,-5);
		//工作经历
		$reDataArr['work'] = $this->db->query ( "select * from u_expert_resume where expert_id={$m_id}")->result_array ();
		//证书
		$reDataArr['certificate'] = $this->db->query ( "select id,certificate,certificatepic,certificatepic as true_certificatepic from u_expert_certificate where expert_id={$m_id}")->result_array ();

		if (empty ( $reDataArr )) 						{$this->__errormsg ();	}			//为空输出
		$this->__outmsg ( $reDataArr );																//为实输出
	}
	/**
	 * @name：68[3]、修改管家：提交数据处理
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function cfgm_update_expert_deal() 
	{
		//1、当前登录管家id
		$m_id = $this->input->post ( 'eid', true ); //管家id
		//2、传值 （第二个页面）
		$nickname = $this->input->post ( 'nickname', true ); // 用户昵称
		$sex = $this->input->post ( 'sex', true ); // 性别
		$small_photo = $this->input->post ( 'icon_photo', true ); // 头像
		$realname = $this->input->post ( 'realname', true ); // 真实姓名
	
		$idcardtype = $this->input->post ( 'idcard_type', true ); // 证件类型
		$idcard = $this->input->post ( 'idcard', true ); // 证件号（身份证号码）
		$idcardpic = $this->input->post ( 'idcardpic', true ); // 身份证扫描正面
		$noidcardpic = $this->input->post ( 'noidcardpic', true ); // 身份证扫描反面
	
		$email = $this->input->post ( 'email', true ); // 电子邮箱
		$phone = $this->input->post ( 'phone', true ); // 手机号
		$weixin = $this->input->post ( 'weixin', true ); // 微信号
		$city = $this->input->post ( 'city', true ); // 所属城市
		$this_door = $this->input->post ( 'this_door', true ); // 上门服务
		$expert_dest = $this->input->post ( 'expert_dest', true ); // 擅长路线
		$talk = $this->input->post ( 'talk', true ); // 个人描述 (150字)
		$talklen = strlen ( $talk );
		$museum = $this->input->post ( 'museum', true ); // 照相馆
		$certificate = $this->input->post ( 'certificate', true ); // -- 证书名称
	
		//3、传值（第三个页面）
		$school = $this->input->post ( 'school', true ); // 毕业院校
		$lycy = $this->input->post ( 'lycy', true ); // 旅游从业
		$year = $this->input->post ( 'year', true ); // 工作年限
		$jobs = $this->input->post ( 'jobs', true ); // --所在企业
	
		// 3.5、第二个页面：验证
		//昵称不能重复
		$expert_arr= $this->db->query ( "select nickname from u_expert where nickname='{$nickname}'")->row_array();
		$expert_arr_my= $this->db->query ( "select nickname from u_expert where id='{$m_id}'")->row_array();
		$expert_rows=count($expert_arr);
		if (empty ( $nickname )) 				{$this->__errormsg ( '请填写昵称' );}
		if ($expert_rows>0&&$expert_arr_my['nickname']!=$nickname) {$this->__errormsg ( $m_id.'昵称已被占用，请重新输入' );}
		
		if ($sex!='1'&&$sex!='0') 				{$this->__errormsg ( '请选择性别' );}
		if (empty ( $small_photo )) 			{$this->__errormsg ( '请上传头像' );}
		if (empty ( $realname )) 				{$this->__errormsg ( '请填写真实姓名' );}
		
		if($idcardtype=="")
		{
		if (empty ( $idcard )) 					{$this->__errormsg ( '身份证号不能为空' );}
		$this->load->helper ( 'regexp' );
		if (! regexp ( 'cid', $idcard )) 		{$this->__errormsg ( "请输入正确的身份证号" );}
		}
		else
		{
			if (empty ( $idcard )) 					{$this->__errormsg ( '证件号不能为空' );}
		}
		if (empty ( $idcardpic )) 				{$this->__errormsg ( '请上传身份证正面照片' );}
		if (empty ( $noidcardpic )) 				{$this->__errormsg ( '请上传身份证反面照片' );}
		
		if (!empty ( $email ))
		{
			if (! preg_match ( "/^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/", $email )) {
				$this->__errormsg ( '邮箱错误' );
			}
		}
		if (empty ( $city )) 					{$this->__errormsg ( '请选择所属城市' );}
		if (empty ( $expert_dest )) 			{$this->__errormsg ( '请选择擅长路线！' );}
		if ($this_door=="") 			{$this->__errormsg ( '请选择上门服务' );}
		if (empty ( $talk )) 					{$this->__errormsg ( '请填写个人描述' );						 }
		if ($talklen < 6 || $talklen > 150) 	{$this->__errormsg ( '请填写6到150字以内的个人简介');}
		
		//4、第三个页面： 验证
		if (empty ( $school )) 		{$this->__errormsg ( '请选择毕业院校' );}
		if (empty ( $lycy )) 	    {$this->__errormsg ( '请填写旅游从业岗位' );}
		if (empty ( $year )) 		{$this->__errormsg ( '请选择工作年限' );}
		// 验证旅游从业简历
		if (! empty ( $jobs ) && is_array ( $jobs )) {
			foreach ( $jobs as $k => $v ) {
				if (empty ( $jobs [$k] ['starttime'] ))			{$this->__errormsg ( '请填写从业经历的起始时间' );}
				if (empty ( $jobs [$k] ['company_name'] ))		{$this->__errormsg ( '经历处请填写公司名称' );}
				if (empty ( $jobs [$k] ['job'] ))				{$this->__errormsg ( '请填写职务' );}
				if (empty ( $jobs [$k] ['endtime'] )) 			{$this->__errormsg ( '请填写从业经历的结束时间' );}
				if (empty ( $jobs [$k] ['description'] ))		{	$this->__errormsg ( '经历处请填写描述' );}
			}
		} else {
			$this->__errormsg ( '请添加从业经历' );
		}
	
		//5、数据操作
		$this->db->trans_begin ();
		if (! empty ( $city ) && ($city > 1))
		{
			$province = $this->db->query ( "select pid from u_area where id ={$city}" )->result_array ();
			$pro = ($province ['0'] ['pid']);
			if (! empty ( $pro )) {
				$country = $this->db->query ( "select pid from u_area where id ={$pro}" )->result_array ();
				$con = ($country ['0'] ['pid']);
			}
		}
		else
		{
			$pro = 0;
			$con = 0;
		}
		$data = array (
				'nickname' => $nickname,
				//'mobile' => $phone,
				'realname' => $realname,
				'sex' => intval ( $sex ),
				//'idcardtype' => isset ( $idcardtype ) ? $idcardtype : '',//证件类型
				'idcard' => $idcard,//证件号
				'idcardpic' => $idcardpic,//证件正面
				'idcardconpic'=>$noidcardpic, //证件反面
				'visit_service' => $this_door,
				//'email' => $email,
				'weixin' => $weixin,
				'small_photo' => $small_photo,
				'big_photo' => $small_photo,
				'talk' => $talk,
				'province' => $pro,
				'country' => $con,
				'beizhu' => '毕业于' . $school . ';旅游从业岗位：' . $lycy . ';' . intval ( $year ) . '年从业经验',
				'expert_dest' => $expert_dest,
				'city' => isset ( $city ) ? $city : 0,
				'modtime' => date ( 'Y-m-d H:i:s', time () ),
				'status'=>'1'
		);
		if(!empty($phone))
			$data['mobile']=$phone;
		if(!empty($email))
			$data['email']=$email;
		if(!empty($idcardtype))
			$data['idcardtype']=$idcardtype;
			
		$this->load->model ( 'common/u_expert_model', 'expert_model' );
		$this->load->model ( 'common/u_expert_resume_model', 'expert_resume_model' );
		$this->load->model ( 'common/u_expert_certificate_model', 'expert_certificate_model' );
		
		$update_row = $this->expert_model->update($data,array('id'=>$m_id)); //更新expert表
		if ($update_row=='0') {
			//$this->__errormsg ( '提交失败，稍后再试'.$m_id );
		}   
		//6、工作经历	
		if (! empty ( $jobs ) && is_array ( $jobs )) 
		{
			foreach ( $jobs as $k => $v ) {
				
				$resume_data ['company_name'] = $v ['company_name'];
				$resume_data ['job'] = $v ['job'];
				$resume_data ['starttime'] = $v ['starttime'];
				$resume_data ['endtime'] = $v ['endtime'];
				$resume_data ['description'] = $v ['description'];
				
				$one=$this->expert_resume_model->row(array('id'=>@$v['job_id'],'expert_id'=>$m_id));
				if(empty($one))
				{   //插入
					$resume_data ['expert_id']=$m_id;
					$resume_data ['status']='1';
					$status = $this->expert_resume_model->insert($resume_data);
				}
				else 
				{  //更新
					$status = $this->expert_resume_model->update($resume_data,array('id'=>@$v['job_id'],'expert_id'=>$m_id));
					
				}
	
			}
		} else {
			$this->__errormsg ( '从业信息有误！' );
		}  //插入、更新 u_expert_resume表（就业信息）
	  
	  // 7、荣誉证书
		if (! empty ( $certificate ) && is_array ( $certificate )) {
			$a="";
			foreach ( $certificate as $k => $v ) {
				//更新数据
				$cert_data ['certificate'] = $v ['certificate'];
				$cert_data ['certificatepic'] =  	isset($v ['true_certificatepic']	)?$v ['true_certificatepic']:'';
			
			    $one=$this->expert_certificate_model->row(array('id'=>@$v['id'],'expert_id'=>$m_id));
				
				if(empty($one))
				{   //插入
				
				$cert_data ['expert_id']=$m_id;
				$cert_data ['status']='1';
				$status = $this->expert_certificate_model->insert($cert_data);
				}
				else
				{   
					//更新
					
					$status = $this->expert_certificate_model->update($cert_data,array('id'=>@$v['id'],'expert_id'=>$m_id));
				}
				
				
			}
		} // 插入、更新 u_expert_certificate 表 （荣耀证书）
			
	    //8、管家关联相馆表
		if (! empty ( $museum ))
		{  
			$this->load->model ( '/common/u_expert_museum_model', 'museum_model' );
			$data = $this->museum_model->all ( array ('expert_id' => $m_id) );
			if (empty ( $data )) 
			{
				$museum = array (
						'expert_id' => $m_id,
						'museum_id' => $museum,
						'qrcode' => '/file/qrcodes/' . $m_id . '_qr.png',
						'addtime' => date ( 'Y-m-d H:i:s' ),
						'status' => 0
				);
				$expert_museum_id = $this->museum_model->insert ( $museum );
				if (! empty ( $expert_museum_id )) { // 管家二维码关联表
					$qrcode = array (
							'qrcode' => '/file/qrcodes/' . $m_id . '_qr.png',
							'status' => 0,
							'expert_id' => $m_id,
							'expert_museum_id' => $expert_museum_id
					);
					$this->load->model ( '/common/u_expert_qrcode_model', 'qrcode_model' );
					$this->qrcode_model->insert ( $qrcode );
				}
				$this->get_qrcodes ( $m_id ); // 申请二维码
			} 
			else 
			{  
				//更新
				$this->museum_model->update ( array ('museum_id' => $museum), array ('expert_id' => $m_id) );	
			}
	
			
		} // 照片二维码
			
			
		//9、返回结果
		if ($this->db->trans_status () === FALSE)
		{
			$this->db->trans_rollback ();
		}
		else
		{
			$this->db->trans_commit ();
			echo json_encode ( array ('code' => 2000,'msg' => 'ok','cert'=>$certificate) );
		}
		// END
	}
	/**
	 * @name：68、全部城市
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function all_product() {
		$reDataArr = array ();
		$internalId = 1; // 国际ID
		$sql_inter_2 = "select * FROM  u_dest_cfg where  pid={$internalId}  order by pid asc ";
		$inter_citys_2 = $this->db->query ( $sql_inter_2 )->result_array ();
		$sql_inter_3 = "select * FROM  u_dest_cfg where  level=3  order by pid asc ";
		$inter_citys_3 = $this->db->query ( $sql_inter_3 )->result_array ();
		$inter_city = array ();
		$inter_cityTab = array ();
		foreach ( $inter_citys_2 as $key => $val ) {
			$inter_city ['id'] = $val ['id'];
			$inter_city ['name'] = $val ['kindname'];
			$inter_city ['childs'] = array ();
			foreach ( $inter_citys_3 as $k => $v ) {
				if ($v ['pid'] == $val ['id']) {
					$inter_city ['childs'] [] = array (
							'id' => $v ['id'],
							'name' => $v ['kindname'] 
					);
				}
			}
			$inter_cityTab [] = $inter_city;
		}
		$reDataArr [] = array (
				"inter_city" => $inter_cityTab 
		);
		$domesticId = 2; // 国内ID
		$sql_dome_2 = "select * FROM  u_dest_cfg where  pid={$domesticId}  order by pid asc ";
		$dome_citys_2 = $this->db->query ( $sql_dome_2 )->result_array ();
		$sql_dome_3 = "select * FROM  u_dest_cfg where  level=3  order by pid asc ";
		$dome_citys_3 = $this->db->query ( $sql_dome_3 )->result_array ();
		$dome_city = array ();
		$dome_cityTab = array ();
		foreach ( $dome_citys_2 as $key => $val ) {
			$dome_city ['id'] = $val ['id'];
			$dome_city ['name'] = $val ['kindname'];
			$dome_city ['childs'] = array ();
			foreach ( $dome_citys_3 as $k => $v ) {
				if ($v ['pid'] == $val ['id']) {
					$dome_city ['childs'] [] = array (
							'id' => $v ['id'],
							'name' => $v ['kindname'] 
					);
				}
			}
			$dome_cityTab [] = $dome_city;
		}
		$reDataArr [] = array (
				"dome_city" => $dome_cityTab 
		);
		/**
		 * 周边游
		 * wait development .
		 * ..
		 */
		/**
		 * 主题游
		 * wait development .
		 * ..
		 */
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：69、管家登录
	 * @author: 温文斌
	 * @param: mobile=手机号；password=密码；
	 * @return:
	 *
	 */
	
	public function cfgm_expert_login() {
		$mobile = $this->input->post ( 'mobile', true );
		$password = $this->input->post ( 'password', true );
		$this->load->model ( 'common/u_expert_model', 'expert_model' );
		$res_query = $this->expert_model->row ( array (
				'mobile' => $mobile 
		), $type = "arr", $gre = "ID DESC limit 1" ); // 手机登陆
		if (empty ( $res_query )) {
			$res_query = $this->expert_model->row ( array (
					'login_name' => $mobile
			), $type = "arr" ); // 获取用户信息
			if (empty ( $res_query )) {
				$res_query = $this->expert_model->row ( array (
						'email' => $mobile 
				), $type = "arr" ); // 邮箱登陆
				if (empty ( $res_query )) {
					echo json_encode(array('code'=>'-1','msg' =>'用户不存在!',));
				}
			}
		}
		if ($res_query) {
			// print_r($res_query);exit();
			if (md5 ( $password ) == $res_query ['password'] && $res_query ['status'] == "2") {
				// 登录成功后 更新或插入token，接口访问时验证token是否过期
				$this->load->library ( 'token' );
				$token_arr = $this->token->expert_get_Token ( $res_query ['id'] );
				$token = ( array ) json_decode ( $token_arr );
				$this->result_code = "1";
				$this->result_msg = "success";
				$lastData ['rows'] = array (
						0 => array (
								'key' => $token ['key'],
								'id' => $res_query ['id']
						) 
				);
				$this->result_data = $lastData;
				$this->resultJSON = json_encode ( array (
						"msg" => $this->result_msg,
						"code" => $this->result_code,
						"data" => $this->result_data,
						"total" => "0" 
				) );
				echo $this->resultJSON;
				exit ();
			} elseif (md5 ( $password ) == $res_query ['password'] && $res_query ['status'] == "-1") {
				  echo json_encode(array('code'=>'4','msg' =>'平台终止了与您的合作，请联系客服!'));
			} elseif (md5 ( $password ) == $res_query ['password'] && $res_query ['status'] == "1") {
				echo json_encode(array('code'=>'2','msg' =>'该帐号在审核中，请耐心等待!','type'=>$res_query ['type'],'eid'=>$res_query ['id']));
			} elseif (md5 ( $password ) == $res_query ['password'] && $res_query ['status'] == "3") {
				echo json_encode(array('code'=>'3','msg' =>'该帐号审核被拒绝，请重新完善个人资料!','type'=>$res_query ['type'],'eid'=>$res_query ['id'],'refuse_reasion'=>$res_query['refuse_reasion']));
			} else {
				echo json_encode(array('code'=>'-1','msg' =>'密码输入不正确!'));
			}
		} else {
			echo json_encode(array('code'=>'-1','msg' =>'用户不存在!'));
		}
	}
	
	/**
	 * @name：70、管家信息
	 * @author: 温文斌
	 * @param: number=凭证
	 * @return:
	 *
	 */
	
	public function expert_info_show() {
		$token = $this->input->post ( 'number', true );
		$this->expert_check_token ( $token );
		$this->load->model ( 'common/u_expert_access_token_model', 'eat_model' );
		$result = $this->eat_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'eid' );
		$m_id = $result [0] ['eid'];
		$sql = "select id,realname,small_photo from u_expert where id={$m_id}";
		$query = $this->db->query ( $sql );
		$reDataArr = $query->result_array ();
		if (empty ( $reDataArr )) 						{$this->__errormsg ();	}			//为空输出
		$this->__outmsg ( $reDataArr );																//为实输出
	}
	
	/**
	 * @name：71、管家端：订单列表
	 * @author: 温文斌
	 * @param: number=凭证
	 * @return:
	 *
	 */
	
	public function cfgm_expert_order() {
		$token = $this->input->post ( 'number', true );
		$this->expert_check_token ( $token );
		$this->load->model ( 'common/u_expert_access_token_model', 'eat_model' );
		$user = $this->eat_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'eid' );
		$m_id = $user [0] ['eid'];
		$code = $this->input->post ( 'code', true );
		$where = "";
		if ($code == 0) { // 全部
			$where = "";
		} elseif ($code == 1) { // 待留位
			$where = "AND mo.status=0 AND mo.ispay=0";
		} elseif ($code == 2) { // 待支付
			$where = "AND mo.status=1 AND mo.ispay=0 AND TIMESTAMPDIFF(HOUR,mo.addtime,NOW())<24";
		} elseif ($code == 3) { // 待确认
			$where = "AND mo.status=1 AND mo.ispay in (1,2)";
		} elseif ($code == 4) { // 取消中.
			$where = "AND mo.status in(-3,-4) AND mo.ispay in (3,4)";
		}
		$sql = "SELECT 
		               mo.id AS mo_id,e.id AS e_id,mo.ordersn,mo.productname,
		              (mo.dingnum+mo.childnum+mo.childnobednum+mo.oldnum) AS  people,mo.usedate,mo.total_price,
		              l.mainpic,mo.ispay,mo.status,mo.settlement_price,(mo.total_price+mo.settlement_price) as all_price
				FROM 
						u_member_order AS mo  
						LEFT JOIN u_expert AS e ON mo.expert_id=e.id 
						LEFT JOIN u_line AS l ON mo.productautoid=l.id 
			   WHERE    
						mo.expert_id={$m_id} {$where} 
		       ORDER BY 
		       			mo.id desc";
		$query = $this->db->query ( $sql );
		$reDataArr = $query->result_array ();
		if ($reDataArr) {
			foreach ( $reDataArr as $key => $val ) {
				foreach ( $val as $k => $v ) {
					if ($k == "usedate") {
						$val [$k] = date ( 'Y-m-d', strtotime ( $val [$k] ) );
					}
				}
				$reDataArr [$key] = $val;
			}
		}
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：72、管家端:订单详情
	 * @author: 温文斌
	 * @param: number=凭证；orderid=订单ID
	 * @return:
	 *
	 */
	
    public function cfgm_order_detail() {
		$token = $this->input->post ( 'number', true );
		$this->expert_check_token ( $token );
		$order_id = $this->input->post ( 'orderid', true );
		//$order_id="100352";
		$order_detail=$this->order_detail($order_id);
		$this->__outmsg ( $order_detail );
	}
	/**
	 * @name：公共函数:订单详情
	 * @author: 温文斌
	 * @param: number=凭证；orderid=订单ID
	 * @return:
	 *
	 */
	private function order_detail($order_id)
	{
		$sql = "
				SELECT
						mo.id,mo.memberid,mo.productautoid,mo.supplier_id,mo.expert_id,mo.ordersn,mo.productname,mo.oldnum,mo.childnobednum,mo.dingnum,mo.childnum,
						(mo.oldnum+mo.childnobednum+mo.dingnum+mo.childnum) as people,mo.usedate,mo.agent_fee,mo.linkman,mo.linkmobile,mo.linkemail,litpic,
						CASE WHEN mo.isneedpiao=1 THEN '是' WHEN mo.isneedpiao=0 THEN '否' END AS is_fp,mo.ispay,mo.status,
						mo.jifenprice,mo.couponprice,mo.settlement_price,mo.insurance_price,mo.suitnum,mo.order_price,mo.total_price,(mo.total_price+mo.settlement_price) as all_price,
						(CASE  WHEN mo.ispay=0 AND TIMESTAMPDIFF(HOUR,mo.addtime,NOW())>24 THEN '已经失效'  WHEN mo.id IN (SELECT r.order_id FROM u_refund AS r WHERE r.status=0) AND mo.status=-3 THEN '退款审核中'  WHEN mo.id IN (SELECT r.order_id FROM u_refund AS r WHERE r.status=1) AND mo.status=-4 THEN '退款成功'  WHEN mo.id IN (SELECT r.order_id FROM u_refund AS r WHERE r.status=2) AND mo.status=-4 THEN '退款失败'  WHEN mo.status = -4 THEN '已经取消'  WHEN mo.status = -3 THEN  '取消中'  WHEN mo.status = -2 THEN '平台拒绝'  WHEN mo.status = -1 THEN 'B1拒绝'  WHEN mo.status = 0 AND mo.ispay=0 THEN '待留位'  WHEN mo.status = 1 AND mo.ispay=0 THEN 'B1已确认留位'  WHEN mo.status = 1 AND mo.ispay=1 THEN '用户已付款'  WHEN mo.status = 1 AND mo.ispay=2 THEN '平台已确认收款'  WHEN mo.status = 4 AND mo.ispay=2 THEN 'B1已控位'  WHEN mo.status = 5 AND mo.ispay=2 THEN '出行'  WHEN mo.status = 6 AND mo.ispay=2 THEN '点评'  WHEN mo.status = 7 AND mo.ispay=2 THEN '已投诉'   END) AS order_status,
						s.cityname,l.linetitle,l.agent_rate_int,l.saveprice,l.overcity,l.linepic,e.nickname,e.small_photo
				FROM
						u_member_order AS mo
						LEFT JOIN u_line AS l ON mo.productautoid=l.id
						LEFT JOIN u_line_startplace AS ls ON mo.productautoid=ls.line_id
						left join u_startplace as s on s.id=ls.startplace_id
						left join u_expert as e on e.id=mo.expert_id
				WHERE 
						mo.id={$order_id}";
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		return $result;
	}
	/**
	 * @name：73、订单中游客信息
	 * @author: 温文斌
	 * @param: number=凭证；orderid=订单ID
	 * @return:
	 *
	 */
	
	public function cfgm_tourist_info() {
		$token = $this->input->post ( 'number', true );
		$this->expert_check_token ( $token );
		$mo_id = $this->input->post ( 'orderid', true );
		is_numeric ( $mo_id ) ? ($mo_id) : $this->__errormsg ( 'tip is null' );
		$sql = "SELECT mo.id AS mo_id,mt.id AS t_id,mt.name AS t_name,mt.certificate_no AS t_idcard,d.description as t_type   FROM u_member_order AS mo LEFT JOIN u_member_order_man AS mom ON mom.order_id=mo.id     LEFT JOIN u_member_traver AS mt ON mom.traver_id=mt.id LEFT JOIN u_dictionary as d on d.dict_id=mt.certificate_type     WHERE mo.id={$mo_id}";
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		$this->__outmsg ( $result );
	}
	
	/**
	 * @name：74、管家定制列表
	 * @author: 温文斌
	 * @param: number=凭证；orderid=订单ID
	 * @return:
	 *
	 */
	
	public function cfgm_customize_manage() {
    	$token = $this->input->post ( 'number', true );
		$this->expert_check_token ( $token );
		$this->load->model ( 'common/u_expert_access_token_model', 'eat_model' );
		$user = $this->eat_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'eid' );
		$e_id = $user [0] ['eid'];  
		$sql="
			   select 
				     uc.id,uc.budget,uc.days,uc.total_people,uc.isshopping,uc.trip_way,uc.startdate,
				     ce.expert_id,
				     (select GROUP_CONCAT(cd.dest_id SEPARATOR '、') as dest_id from u_customize_dest as cd where cd.customize_id=uc.id) as dest_id,
				     (select GROUP_CONCAT(d.kindname SEPARATOR '、') as dest_id from u_customize_dest as cd left join u_dest_cfg as d on cd.dest_id=d.id where cd.customize_id=uc.id) as dest_name
				from 
				     u_customize as uc 
				     left join u_customize_expert as ce on ce.customize_id=uc.id
				where ce.expert_id={$e_id}
			";
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		$this->__outmsg ( $result );
	}
	
	/**
	 * @name：75、定制详情
	 * @author: 温文斌
	 * @param: number=凭证；cid=定制单ID 
	 * @return:
	 *
	 */
	
	public function cfgm_customize_detail() {
		$token = $this->input->post ( 'number', true );
		$this->expert_check_token ( $token );
		$c_id = $this->input->post ( 'cid', true );
		is_numeric ( $c_id ) ? ($c_id) : $this->__errormsg ( 'tip is null' );
		$sql = "SELECT c.id AS c_id,c.startdate,c.budget,c.hotelstar,c.trip_way,CASE WHEN c.isshopping=1 THEN '有购物' WHEN c.isshopping=0 THEN '无购物' END shop_status,(select GROUP_CONCAT(kindname) from u_dest_cfg where FIND_IN_SET(id,c.endplace) >0 )as endplace,c.days,c.people,c.childnum,c.childnobednum,c.oldman,d.description AS play_method,d.description AS hotel_status,c.service_range,c.other_service FROM u_customize AS c LEFT JOIN u_dictionary AS d ON c.hotelstar=d.dict_id WHERE c.id={$c_id}";
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		$this->__outmsg ( $result );
	}
	
	/**
	 * @name：76、抢单
	 * @author: 温文斌
	 * @param: number=凭证；cid=定制单ID
	 * @return:
	 *
	 */
	
	public function cfgm_get_bill() {
		$token = $this->input->post ( 'number', true );
		$this->expert_check_token ( $token );
		$this->load->model ( 'common/u_expert_access_token_model', 'eat_model' );
		$user = $this->eat_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'eid' );
		$e_id = $user [0] ['eid'];
		$c_id = $this->input->post ( 'cid', true );
		is_numeric ( $c_id ) ? ($c_id) : $this->__errormsg ( 'tip is null' );
		$sql = "INSERT INTO u_customize_grab(customiz_id,expert_id,ADDTIME,isreply) VALUES({$c_id},{$e_id},NOW(),0)";
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		if ($result) {
			$this->__successmsg ();
		}
	}
	
	/**
	 * @name：77、管家信息
	 * @author: 温文斌
	 * @param: number=凭证；
	 * @return:
	 *
	 */
	
	public function cfgm_expert_info() {
		$token = $this->input->post ( 'number', true );
		$this->expert_check_token ( $token );
		$this->load->model ( 'common/u_expert_access_token_model', 'eat_model' );
		$expert = $this->eat_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'eid' );
		$e_id = $expert [0] ['eid'];
		$sql = "	SELECT e.id AS e_id,e.small_photo,e.realname,e.nickname,e.mobile,e.expert_dest as expert_destid,e.sex as sexid,
		CASE WHEN e.sex=0 THEN '女' WHEN e.sex=1 THEN '男' WHEN e.sex=-1 THEN '保密' END AS sex,e.idcard,e.idcardpic,
		a.name AS city_name ,e.city,
(select GROUP_CONCAT(kindname SEPARATOR '、') from u_dest_cfg where FIND_IN_SET(id,e.expert_dest) >0 )as expert_dest
		FROM u_expert AS e LEFT JOIN u_area AS a ON e.city=a.id WHERE e.id={$e_id}";
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		$this->__outmsg ( $result );
	}
	
	/**
	 * @name：78、线路列表
	 * @author: 温文斌
	 * @param: number=凭证；
	 * @return:
	 *
	 */

	public function cfgm_line_list() {
		$sql = "select id,kindname from u_dest_cfg where level=2";
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		$this->__outmsg ( $result );
	}
	
	/**
	 * @name：79、修改管家信息
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function expert_update_info() {
		$this->load->model ( 'admin/b2/expert_model', 'expert' );
		$path = "./file/b2/upload/img/";
		if (! file_exists ( $path )) {
			mkdir ( $path, 0700 );
		}
		$token = $this->input->post ( 'number', true );
		$this->expert_check_token ( $token );
		$this->load->model ( 'common/u_expert_access_token_model', 'eat_model' );
		$expert = $this->eat_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'eid' );
		$e_id = $expert [0] ['eid']; 
		$nickname = $this->input->post ( 'realname', true ); // 昵称
		$idcard = $this->input->post ( 'idcard', true ); // 身份证号
		$business = $this->input->post ( 'business', true ); // 擅长线路
		$city = $this->input->post ( 'city', true ); // 城市
		
		/*
		 * $mobile = $mobile = $this->input->post ( 'mobile', true );
		 * //修改手机号码
		 * if (!empty($mobile)) {
		 * $this->load->helper ( 'regexp' );
		 * if (!regexp('mobile' ,$mobile)) { $this->__errormsg ('请输入正确的手机号'); }
		 * if (!$this ->efmg_unique_field(array('mobile' =>$mobile))) { $this->__errormsg ('手机号已存在'); }
		 * } else { $this->__errormsg ('请填写手机号'); }
		 * $post_array['mobile']=$mobile;
		 * $post_array['login_name']=$mobile;
		 * $update_id=$this->expert->update_rowdata('u_expert',$post_array,array('id'=>$e_id));
		 */
		
		// $query = $this->db->query ( "select small_photo,idcardpic from u_expert where id={$e_id}" );
		// $exert_info = $query->result_array ();
		if (isset ( $_FILES ['photo'] ) && $_FILES ['photo']) { // 头像上传
			$input_name = "photo";
			$tx_pic = $this->cfgm_upload_pimg ( $path, $input_name );
			if ($exert_info [0] ['small_photo'] && ($exert_info [0] ['small_photo'] != "/file/c/img/face.png")) {
				$dir = dir ( $path );
				while ( ($file = $dir->read ()) !== false ) {
					if ($file == $tx_pic) {
						unlink ( "." . $exert_info [0] ['small_photo'] );
					}
				}
				$dir->close ();
			}
			$post_array ['small_photo'] = "/file/b2/upload/img/" . $tx_pic;
			$post_array ['big_photo'] = $data ['small_photo'];
		}
		
		if (isset ( $_FILES ['idcard_pic'] ) && $_FILES ['idcard_pic']) { // 身份证上传
			$input_name = "idcard_pic";
			$idcard_pic = $this->cfgm_upload_pimg ( $path, $input_name );
			if ($exert_info [0] ['idcardpic']) {
				$dir = dir ( $path );
				while ( ($file == $dir->read ()) !== false ) {
					if ($file == $idcard_pic) {
						unlink ( "." . $exert_info [0] ['idcardpic'] );
					}
				}
				$dir->close ();
			}
			$post_array ['idcardpic'] = "/file/b2/upload/img/" . $idcard_pic;
		}
		/*
		 * $data['modtime'] = date ( 'Y-m-j H:i:s', time () );
		 * $where = array(
		 * 'id' => $e_id
		 * );
		 * if ($mobile) { // 判断修改后的手机号是否存在于非当前id
		 * $query = $this->db->query ( "select mobile from u_expert where id <>{$e_id} and mobile={$mobile} limit 1" );
		 * $is_exist = $query->result_array ();
		 * if ($is_exist) {
		 * $this->__errormsg ( 'tel error' );
		 * }
		 * } else { // 手机号不能为空
		 * $this->__errormsg ( 'tel cannot be null' );
		 * }
		 * $result = $this->db->update ( 'bridge_expert', $data, $where );
		 * if ($result) {
		 * $this->__successmsg ( array(
		 * 'e_id' => $e_id
		 * ) );
		 * }
		 */
		
		
		$post_array=$this->expert->row(array('id'=>$e_id));
		
		
		
		if ($nickname) 		{	$post_array ['nickname'] = $nickname;			}
		if ($idcard) 				{	$post_array ['idcard'] = $idcard;						}
		if ($business) 			{	$post_array ['expert_dest'] = $business;		}
		if (! empty ( $post_array ['expert_dest'] )) {
			$post_array ['expert_dest'] = $business;
		}
		if ($city) 		{	$post_array ['city'] = $city;			}
		
/* 		if (!preg_match ( '/^[\x{4e00}-\x{9fa5}]+$/u', $city )) {
			if ($city) {
				$sql = "select id from u_area where name like '%{$city}%'";
				$query = $this->db->query ( $sql );
				$result = $query->result_array ();
				if ($result) {
					$post_array ['city'] = $result [0] ['id'];
				} else { // 城市 不存在
					$this->__errormsg ( '未查找到城市' );
				}
			}
		} else {
			$this->__errormsg ( '城市输入有误!' );
		} 
		
*/
		
		
		unset($post_array['pc_photo']);
		unset($post_array['mobile_photo']);
		unset($post_array['id']);
		unset($post_array['refuse_reasion']);
		// 插入管家资料桥接关联表
		$update_id = $this->expert->update_expert ( $post_array, null, null, $e_id );
		if (! $update_id) {
			echo json_encode ( array (	'code' => 2000,		'msg' => '修改成功!' 			) );
		} else {
			echo json_encode ( array (	'code' => 4000,	     'msg' => '修改失败!' 		) );
		}
		
		/*
		 * //查询管家证书
		 * $certificate_sql=$this->db->query('select certificate,certificatepic from u_expert_certificate where expert_id='.$e_id);
		 * $certificate = $certificate_sql->result_array();
		 * //管家从业
		 * $resume_sql=$this->db->query('select company_name,job,starttime,endtime,description,status from u_expert_resume where expert_id='.$e_id);
		 * $resume= $resume_sql->result_array();
		 * //插入管家证书
		 * if(!empty($certificate)){
		 * foreach ($certificate as $k=>$v){
		 * $certificate[$k]['expert_id']=$expert_id;
		 * $this->db->insert('bridge_expert_certificate',$certificate[$k]);
		 * $certificateid[]=$this->db->insert_id();
		 * }
		 * }
		 * //插入管家从业
		 * if(!empty($resume)){
		 * foreach ($resume as $k=>$v){
		 * $resume[$k]['expert_id']=$expert_id;
		 * $this->db->insert('bridge_expert_resume ',$resume[$k]);
		 * $resumeid[]=$this->db->insert_id();
		 * }
		 * }
		 * //管家审核资料桥接关联表
		 * if(!empty($certificateid)){
		 * $cerid=implode(',', $certificateid);
		 * $insert['b_expert_certificate_ids']=$cerid;
		 * }
		 * if(!empty($resumeid)){
		 * $resid=implode(',', $resumeid);
		 * $insert['b_expert_resume_ids']=$resid;
		 * }
		 * $insert['expert_id']=$expertId;
		 * $insert['addtime']=date('Y-m-d H:i:s');
		 * $insert['b_expert_id']=$expert_id;
		 * $insert['status']=0;
		 * $inser=$this->db->insert('u_expert_bridge',$insert);
		 * if ($inser) {
		 * $this->__successmsg ();
		 * }else {
		 * $this->__errormsg ();
		 * }
		 */
	}
	
	// public function expert_validate_password() {
	// $ys_psd = $this->input->post ( 'password' );
	// 校验token是否过期并且获取mid
	// $token = $this->input->post ( 'number', true );
	// $this->expert_check_token ( $token );
	// $this->load->model ( 'common/u_expert_access_token_model','eat_model');
	// $result = $this->eat_model->result ( array('access_token' => $token),null,null,null,'arr',null,'eid' );
	// $m_id = $result[0]['eid'];
	// $query = $this->db->query ( "select password from u_expert where id={$m_id}" );
	// $user = $query->result_array ();
	// if ($user) {
	// if ($user[0]['password'] == md5 ( $ys_psd )) {
	// $this->__successmsg ();
	// }
	// } else {
	// $this->__errormsg ();
	// }
	// }
	
	/**
	 * @name：80、修改密码
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function expert_set_password() {
		$token = $this->input->post ( 'number', true );
		$this->expert_check_token ( $token );
		$this->load->model ( 'common/u_expert_access_token_model', 'eat_model' );
		$result = $this->eat_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'eid' );
		$m_id = $result [0] ['eid'];
		$old_password = $this->input->post ( 'old_password', true );
		$data ['password'] = $new_password = md5 ( $this->input->post ( 'new_password', true ) );
		$new_password2 = md5 ( $this->input->post ( 'new_password2', true ) );
		if ($new_password2 != $new_password) {
			$this->__errormsg ( '两次密码输入不一致' );
			exit ();
		}
		$query = $this->db->query ( "select password from u_expert where id={$m_id}" );
		$user = $query->result_array ();
		if ($user) {
			if ($user [0] ['password'] == md5 ( $old_password )) {
				$where = array (
						'id' => $m_id 
				);
				$status = $this->db->update ( 'u_expert', $data, $where );
				if ($status) {
					$this->__successmsg ( '密码修改成功！' );
				} else {
					$this->__errormsg ( '密码修改失败！' );
				}
			} else {
				$this->__errormsg ( '用户原密码错误！' );
			}
		} else {
			$this->__errormsg ( '用户不存在！' );
		}
	}
	
	/**
	 * @name：81、修改密码-do
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function expert_phone_password() {
		$data ['mobile'] = $this->input->post ( 'mobile', true );						//手机
		$code = $this->input->post ( 'code', true );											//验证码
		$new_password = $this->input->post ( 'new_password', true );			//新密码
		$new_password2 = $this->input->post ( 'new_password2', true );		//旧密码
		if ($new_password2 != $new_password) {
			$this->__errormsg ( '两次密码输入不一致' );
			exit ();
		}
		$code_mobile = $data ['mobile'];
		$this->load->library ( 'session' );
		$code_number = $this->session->userdata ( 'code' );
		if (($code_mobile == $data ['mobile']) && ($code_number == $code)) {
			$data ['password'] = md5 ( $new_password );
			$where = array (
					'mobile' => $data ['mobile'] 
			);
			$status = $this->db->update ( 'u_expert', $data, $where );
			if ($status) {
				$this->__successmsg ( '重设密码成功' );
			} else {
				$this->__errormsg ( '重设密码失败，请重试' );
			}
		} else {
			$this->__errormsg ( '验证码输入错误' );
		}
	}
	
	/**
    * @name：82、管家退出
 	* @author: 温文斌
 	* @param: number=凭证；data
 	* @return:
 	*
 	*/

	public function expert_user_logout() {
		$token = $this->input->post ( 'number', true );
		$time = time () - 3600;
		$status = $this->db->query ( "update u_expert_access_token set access_token_validtime={$time} where access_token='{$token}'" );
		if ($status) {
			$this->result_code = "1";
			$this->result_msg = "logout success";
			$lastData ['rows'] = "";
			$this->result_data = $lastData;
			$this->resultJSON = json_encode ( array (
					"msg" => $this->result_msg,
					"code" => $this->result_code,
					"data" => $this->result_data,
					"total" => "0" 
			) );
			echo $this->resultJSON;
			exit ();
		}
	}
	
	/**
	 * @name：83、管家搜索
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function get_expert_list() {
		//1、传值
		$page = $this->input->post ( "page" ); // 当前页数
		$page_size = $this->input->post ( "page_size" ); // 每页显示记录条数
		$city_name = $this->input->post ( 'cityname', true ); // 定位城市名
		$qy_id = $this->input->post ( 'qy_id', true ); // 区域id
		$e_grade = $this->input->post ( 'type', true ); // 专家等级
		$sex = $this->input->post ( 'sex', true ); // 性别
		$dest_id = $this->input->post ( 'dest', true ); // 目的地 多选
		$order = $this->input->post ( 'sort', true ); // 排序
		$like = $this->input->post ( 'like', true ); // 模糊搜索
		
		$lat = $this->input->post ( 'lat', true ); // 经度 多选
		$lon = $this->input->post ( 'lon', true ); // 纬度 多选
		$len = $this->input->post ( 'len', true ); // 长度 多选
		
		//2、分页处理
		$page = empty ( $page ) ? 1 : $page; // 当前页
		$page_size = empty ( $page_size ) ? 5 : $page_size; // 每页的条数
		$from = ($page - 1) * $page_size; //
		$where="";
		$order_by = "";
		
		//3、排序
		if ($order) {
			if ($order == 5) { // 按管家积分由高到低排序
				$order_by = 'order by e.online desc,e.satisfaction_rate desc,e.people_count desc,e.id desc';
			} elseif ($order == 1) { // 按管家积分由高到低排序
				$order_by = ' order by total_score desc,e.online desc';
			} elseif ($order == 2) { // 满意度 高到低
				$order_by = ' order by e.satisfaction_rate desc,e.online desc';
			} elseif ($order == 3) { // 年度销量 高到低
				$order_by = ' order by  e.order_amount desc';
			} elseif ($order == 4) { // 年度成交人次 高到低
				$order_by = ' order by e.people_count desc';
			}
		}
		else
		{
			$order_by = 'order by e.online desc,e.satisfaction_rate desc,e.people_count desc,e.id desc';
				
		}
		
		//4、"当前定位城市" where条件
		if($city_name)
		{
			$this->load->model ( 'common/u_area_model', 'area_model' );
			$city_data = $this->area_model->get_row_city ( $city_name );
			if ($city_data) {
				$city_id = $city_data ['id'];
			}
			if (!empty ( $city_id )) {
				$where .= " and e.city in ({$city_id})";
			}
		}
		
		//5、"lat、lon" 经纬度 where 条件
		if ($lat && $lon && $len) {			//根据经纬度查询并且匹配最近管家
			$this->load->library ( 'Geohash' );
			$geohash = $this->geohash->encode_geohash ( $lat, $lon, $len );
			$expands = $this->geohash->getGeoHashExpand ( $geohash );
			$expands0 = $expands [0];
			$expands1 = $expands [1];
			$expands2 = $expands [2];
			$expands3 = $expands [3];
			$expands4 = $expands [4];
			$expands5 = $expands [5];
			$expands6 = $expands [6];
			$expands7 = $expands [7];
			$expands8 = $expands [8];
			$where .= " and (uel.geohash like '{$expands0}%'  or uel.geohash like '{$expands1}%' or uel.geohash like '{$expands2}%' or uel.geohash like '{$expands3}%' or uel.geohash like '{$expands4}%' or uel.geohash like '{$expands5}%' or uel.geohash like '{$expands6}%' or uel.geohash like '{$expands7}%' or uel.geohash like '{$expands8}%' or uel.geohash like '{$geohash}%' )";
		}
		
		//6、"线路种类" where条件
		$where_dest="";
		if ($dest_id) {
			$l_kh = "";
			$r_kh = "";
			$dest_arr = explode ( ',', $dest_id );
			$i = count ( $dest_arr );
			foreach ( $dest_arr as $key => $val ) {
				if ($i > 1) {
					if ($key == 0) {
						$l_kh = "(";
					}
					if ($key == $i - 1) {
						$r_kh = ")";
					}
				}
				if ($key == 0) {
					$where_dest .= " where {$l_kh} find_in_set({$val},A.expert_destid)>0 ";
				} else {
					$where_dest .= " or find_in_set({$val},A.expert_destid)>0 {$r_kh}";
				}
			}
		}
		//7、"性别" where条件
		if ($sex) 
		{
			if ($sex == 1) {$where .= " and e.sex=1";} 
			elseif ($sex ==2) {$where .= " and e.sex=0";}
		}
		//8、"区域" where条件
		if ($qy_id) {
			$l_kh = "";
			$r_kh = "";
			$qy_id_arr = explode ( ',', $qy_id );
			$i = count ( $qy_id_arr );
			foreach ( $qy_id_arr as $key => $val ) {
				if ($i > 1) {
					if ($key == 0) {
						$l_kh = "(";
					}
					if ($key == $i - 1) {
						$r_kh = ")";
					}
				}
				if ($key == 0) {
					$where .= " and  {$l_kh} find_in_set({$val},e.visit_service)";
				} else {
					$where .= " or find_in_set({$val},e.visit_service) {$r_kh}";
				}
			}
		}
		//9、"管家级别" where条件
		if ($e_grade) 
		{
			if ($e_grade != 5) {$where .= " and e.grade={$e_grade}";} 
			else {$where .= " and e.isstar=1";}
		}
		//10、"模糊搜索" where条件

		if($like)
		{
			$where .= "  and (e.nickname like'%{$like}%' or e.realname like '%{$like}%')";
		}
		
		//11、sql语句
		$sql = "SELECT A.* FROM(
		            SELECT 
		                    e.id AS expert_id,e.small_photo,e.sex,e.online,e.nickname,e.realname,e.comment_count, 
		                    eg.title AS grade, 
		                    e.expert_theme, e.satisfaction_rate AS satisfaction_rate , e.total_score,e.people_count AS volume, ua.name AS cityname, 
		                    (select GROUP_CONCAT(d.kindname SEPARATOR '、') as expert_dest from u_dest_cfg as d where FIND_IN_SET(d.id,e.expert_dest)) as expert_dest,
		                    (select GROUP_CONCAT(d.id) as expert_dest from u_dest_cfg as d where FIND_IN_SET(d.id,e.expert_dest)) as expert_destid 
		            FROM 
		                     u_expert AS e  
		                     LEFT JOIN u_area AS ua ON e.city=ua.id 
		                     LEFT JOIN u_expert_location AS uel ON e.id=uel.eid  
		                     left join u_expert_grade as eg on e.grade=eg.grade 
		            WHERE    
		                     e.status=2 and e.is_kf='N' {$where}        
		            group by 
		                     e.id {$order_by}
		            )A{$where_dest}
		       ";
		$sql_page=$sql." LIMIT {$from},{$page_size}";
		$query=$this->db->query ( $sql);
		$query_page= $this->db->query ( $sql_page);
		
		//12、数据结果
		$expert_list= $query_page->result_array ();
		$total_rows = $query->num_rows ();
		$total = ceil ( $total_rows / $page_size );
    
		//13、数据处理（满意度四舍五入）
		foreach ( $expert_list as $key => $val ) {
			foreach ( $val as $k => $v ) {
				if ($k == "satisfaction_rate") {
					if ($v) {
						$val [$k] = round ( $v * 100 );
					}
				}
			}
			$expert_list [$key] = $val;
		}
		if(empty($expert_list)){  $this->__outmsg ($expert_list);}
		
		//14、返回结果
		$output = array (
				'cur_page' => $page,
				'total' => $total,
				'result' => $expert_list,
				'total_rows' => $total_rows 
		);
		$this->__outmsg ( $output );
	}
	
	/**
	 * @name：84、定制沿用城市数据。
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */

	public function ls_customize_city_list() {
		$cityId = intval ( $this->input->post ( 'cityid' ) );
		if (is_numeric ( $cityId ) && ! empty ( $cityId )) {
			
			$this->load->model ( 'common/cfg_round_trip_model', 'trip_model' );
			// 获取周边目的地
			$tripData = $this->trip_model->all ( array (
					'startplaceid' => $cityId,
					'isopen' => 1 
			) );
			if (! empty ( $tripData )) {
				$destId = '';
				foreach ( $tripData as $v ) {
					$destId .= $v ['neighbor_id'] . ',';
				}
				$destId = rtrim ( $destId, ',' );
				// 获取目的地
				$sql = "select kindname,id from u_dest_cfg where id in ($destId)";
				$destArr = $this->db->query ( $sql )->result_array ();
			} else {
				$this->__outmsg ( $tripData );
			}
		} else {
			$this->load->model ( 'common/u_dest_cfg_model', 'dest_model' );
			$destData = $this->dest_model->all ( array (
					'level <=' => 3 
			) );
			$destArr = array ();
			$h = 'h';
			foreach ( $destData as $val ) {
				if ($val ['pid'] == $cityId) {
					$destArr ['top'] [] = $val;
				} else {
					$destArr [$h . $val ['pid']] [] = $val;
				}
			}
			unset ( $destData );
		}
		if ($destArr) {
			$this->__outmsg ( $destArr );
		}
	}
	
	/**
	 * @name：85、定制单验证第一页
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function mo_ls_customize_page1() {
		$startcity = $this->input->post ( 'startcity', true ); // 出发城市
		$city_name1 = $this->input->post ( 'city1', true ); // 国内外
		$city_name2 = $this->input->post ( 'city2', true ); // 省
		$city_name3 = $this->input->post ( 'city3', true ); // 市
		$travel_type = $this->input->post ( 'travel_type', true ); // 市
		$more_service = $this->input->post ( 'more_service', true ); // 市
		if (empty ( $startcity ))			{		$this->__errormsg ( '请填写出发城市名！' );		}
		if (empty ( $city_name1 )) 	{		$this->__errormsg ( '请填写出发城市名！' );		}
		if (empty ( $city_name2 )) 	{		$this->__errormsg ( '请填写目的地城市名！' );	}
		if (empty ( $travel_type )) 		{		$this->__errormsg ( '请填写出游方式！' );			}
		echo json_encode 			( array (		'code' => 2000,	'msg' => 'ok!' ) );
	}
	
	/**
	 * @name：86、定制单验证第二页
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function mo_ls_customize_page2() {
		$travel_time1 = $this->input->post ( 'travel_time1', true ); // 出游日期
		$travel_time2 = $this->input->post ( 'travel_time', true ); // 出游日期文字描述
		$budget = $this->input->post ( 'budget', true ); // 人均预算
		$days = $this->input->post ( 'days', true ); // 出游时长
		$hotel = $this->input->post ( 'hotel', true ); // 酒店要求
		if ((! empty ( $travel_time1 )) xor (! empty ( $travel_time2 ))) {
			if (! empty ( $travel_time1 )) {
				$time1 = strtotime ( $travel_time1 );
				if ($time1 < time ()) {
					{
						$this->__errormsg ( '出游时间得大于今天！' );
					}
				}
			}
			if (empty ( $budget )) {
				$this->__errormsg ( '请填写人均预算 ！' );
			}
			if (empty ( $days )) {
				$this->__errormsg ( '请填写出游时长！' );
			}
			// if (empty($hotel)) {$this->__errormsg ('请填写酒店要求！'); }
			echo json_encode ( array (
					'code' => 2000,
					'msg' => 'ok!' 
			) );
		} else {
			$this->__errormsg ( '出游日期不能写两个！' );
		}

	}
	
	/**
	 * @name：87、定制单		提交
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function mo_ls_customize() {
		$this->load->library ( 'session' );
		$code_mobile = $this->session->userdata ( 'mobile' );
		$token = $this->input->post ( 'number', true );
		if (! empty ( $token )) {
			$this->check_token ( $token );
			$this->load->model ( 'common/u_access_token_model', 'eat_model' );
			$user = $this->eat_model->result ( array (
					'access_token' => $token 
			), null, null, null, 'arr', null, 'mid' );
			$m_id = $user [0] ['mid'];
		}
		$data ['from'] = $this->input->post ( 'from', true );																	//出发城市
		$data ['estimatedate'] = $this->input->post ( 'estimatedate', true );
		$data ['test1id'] = $this->input->post ( 'test1id', true ); 															// 境内外
		$data ['test2id'] = $this->input->post ( 'test2id', true );															//省市
		$data ['method'] = $this->input->post ( 'method', true );															//出游方式
		$data ['another_choose'] = $this->input->post ( 'another_choose', true );								//多选出游方式
		$data ['question'] = $this->input->post ( 'question', true );														//定制线路标题
		$data ['people'] = $this->input->post ( 'people', true );															//成人
		$data ['childnum'] = $this->input->post ( 'cp', true );																//小孩
		$data ['childnobednum'] = $this->input->post ( 'cnp', true );													//小孩不占床
		$data ['oldman'] = $this->input->post ( 'olp', true );																	//老人
		$data ['roomnum'] = $this->input->post ( 'roomnum', true );													//房间数
		$data ['startdate'] = $startdate = $this->input->post ( 'dayr', true );										//出游日
		$data ['days'] = $this->input->post ( 'days', true );																	//时长
		$data ['budget'] = $this->input->post ( 'budget', true );															//备注
		$data ['end'] = $this->input->post ( 'end', true );																		//目的地
		$end = $data ['test2id'] . ',' . $data ['end'];																				
		// $data['isend']=rtrim($isend, ",");
		// $end=$data['isend'];
		$data ['hotel'] = $this->input->post ( 'hotel', true ); 																	// 酒店
		$data ['room_require'] = $this->input->post ( 'room_require', true );
		$data ['catering'] = $this->input->post ( 'catering', true ); 														// 用餐
		$data ['isshopping'] = $this->input->post ( 'isshopping', true ); 												// 购物
		if (empty ( $data ['hotel'] )) 				{		$data ['hotel'] = "无";				}
		if (empty ( $data ['catering'] )) 			{		$data ['catering'] = "无";			}
		if (empty ( $data ['isshopping'] )) 		{	$data ['isshopping'] = "无";			}
		$data ['service_range'] = $this->input->post ( 'beizhu', true );													//多选
		$data ['meal'] = $this->input->post ( 'meal', true );																	//吃
		$data ['beizhu'] = $this->input->post ( 'beizhu', true );											
		$data ['linkname'] = $this->input->post ( 'linkname', true );														//游客名
		$data ['mobile'] = $pwd = $this->input->post ( 'mobile', true );												//手机
		$data ['weixin'] = $this->input->post ( 'weixin', true );																//微信
		$data ['yzm'] = $this->input->post ( 'yzm', true ); 																		// 验证码
		$data ['total_people'] = $this->input->post ( 'total_people', true );											//总人数
		$testtime = date ( "Y-m-d" );
		if (empty ( $data ['from'] )) {
			$this->resultJSON = json_encode ( array (
					"msg" => "出发城市不能为空",
					"code" => "4001" 
			) );
			echo $this->resultJSON;
			exit ();
		} elseif (empty ( $data ['method'] )) {
			$this->resultJSON = json_encode ( array (
					"msg" => "出游方式不能为空",
					"code" => "4001" 
			) );
			echo $this->resultJSON;
			exit ();
		} elseif (empty ( $data ['startdate'] ) && empty ( $data ['estimatedate'] )) {
			$this->resultJSON = json_encode ( array (
					"msg" => "出发日期不能为空",
					"code" => "4001" 
			) );
			echo $this->resultJSON;
			exit ();
		} elseif (empty ( $data ['end'] )) {
			$this->resultJSON = json_encode ( array (
					"msg" => "目的地城市不能为空",
					"code" => "4001" 
			) );
			echo $this->resultJSON;
			exit ();
		} elseif (($data ['total_people']) < 1) {
			$this->resultJSON = json_encode ( array (
					"msg" => "人数至少需有一位",
					"code" => "4001" 
			) );
			echo $this->resultJSON;
			exit ();
		}
		$this->load->helper ( 'regexp' );
		$mobile = $data ['mobile'];
		$name = $data ['linkname'];
		if (! regexp ( 'mobile', $mobile )) {
			$this->resultJSON = json_encode ( array (
					"msg" => "请确保手机格式正确以及不能为空",
					"code" => "4001" 
			) );
			echo $this->resultJSON;
			exit ();
		}
		if (! regexp ( 'name', $name )) {
			$this->resultJSON = json_encode ( array (
					"msg" => "联系人姓名输入有误",
					"code" => "4001" 
			) );
			echo $this->resultJSON;
			exit ();
		}
		
		if (! empty ( $token )) {
			$user_id = $m_id;
		} else {
			$user_id = '';
		}
		$yzm = $this->session->userdata ( 'code' );
		if (empty ( $user_id )) {
			if ($yzm != $data ['yzm']) {
				$this->resultJSON = json_encode ( array (
						"msg" => "验证码错误",
						"code" => "4001" 
				) );
				echo $this->resultJSON;
				exit ();
			}
		}
		
		$time = time ();
		// var_dump($user_id);
		$this->db->trans_start ();
		if (empty ( $user_id )) {
			// var_dump('3');
			// 没有登陆，验证此手机号是否注册，若注册则自动登陆，若没有则自动注册一个账号
			$this->load->model ( 'member_model' );
			$member_info = $this->member_model->row ( array (
					'mobile' => $data ['mobile'] 
			) );
			if (! empty ( $member_info )) {
				$user_id = $member_info ['mid'];
				// 已注册 自动登陆
			} else {
				$this->load->model ( 'common/cfg_member_point_model', 'cfg_member_point' );
				$point = $this->cfg_member_point->row ( array (
						'code' => 'REGISTER',
						'isopen' => '1' 
				) );
				$point_num = isset ( $point ['value'] ) ? $point ['value'] : '0'; // 积分数
				$member_insert_id = array (
						'truename' => $data ['linkname'],
						'loginname' => $mobile,
						'nickname' => $mobile,
						'mobile' => $mobile,
						'pwd' => md5 ( $mobile ),
						'jointime' => date ( 'Y-m-d H:i:s', $time ),
						'sex' => - 1,
						'litpic' => '/file/c/img/face.png',
						'jifen' => $point_num,
						'logintime' => date ( 'Y-m-d H:i:s', $time ),
						'loginip' => $this->get_client_ip () 
				);
				$this->member_model->insert ( $member_insert_id );
				$user_id = $this->db->insert_id ();
				// 写入积分变化表
				if ($member_insert_id ['jifen'] > 0) {
					$memberLogArr = array (
							'member_id' => $user_id,
							'point_before' => 0,
							'point_after' => $member_insert_id ['jifen'],
							'point' => $member_insert_id ['jifen'],
							'content' => '注册赠送积分',
							'addtime' => $member_insert_id ['logintime'] 
					);
					$this->db->insert ( 'u_member_point_log', $memberLogArr );
				}
				$this->member_coupon ( 1, $user_id );
				// 发送短信给用户提示
				$smsData = "尊敬的帮游会员，系统已为您自动注册账号，可在会员中心查看定制单信息，账号为{$mobile}，密码为{$pwd}。为安全起见，请尽快修改密码，谢谢。";
				$this->Inside_page_message ( $mobile, $smsData );
			}
		}
		$data ['month'] = "";
		$data ['date'] = "";
		if (! empty ( $data ['startdate'] )) {
			$arr = explode ( "-", $data ['startdate'] );
			$data ['month'] = $arr [1];
			$data ['date'] = $arr [2];
		}
		$data = array (
				'member_id' => $user_id,
				'startplace' => $data ['from'],
				'endplace' => $end,
				'question' => $data ['question'],
				'month' => $data ['month'],
				'date' => $data ['date'],
				'trip_way' => $data ['method'],
				'another_choose' => $data ['another_choose'],
				'people' => $data ['people'],
				'childnum' => $data ['childnum'],
				'childnobednum' => $data ['childnobednum'],
				'oldman' => $data ['oldman'],
				'roomnum' => $data ['roomnum'],
				'days' => $data ['days'],
				'startdate' => $data ['startdate'],
				'estimatedate' => $data ['estimatedate'],
				'budget' => $data ['budget'],
				'hotelstar' => $data ['hotel'],
				'room_require' => $data ['room_require'],
				'isshopping' => $data ['isshopping'],
				'service_range' => $data ['beizhu'],
				'catering' => $data ['meal'],
				'linkname' => $data ['linkname'],
				'linkphone' => $data ['mobile'],
				'linkweixin' => $data ['weixin'],
				'custom_type' => $data ['test1id'],
				// 'service_range' => $data ['beizhu'],
				'total_people' => $data ['total_people'],
				'addtime' => date ( 'Y-m-d H:i', time () ),
				'status' => '0',
				'user_type' => '0',
				'pic' => '/file/b2/upload/img/customize.png' 
		);
		$this->load->model ( 'common/u_customize_model', 'u_customize' );
		$customize_id = $this->u_customize->insert ( $data );
		$cid = $this->db->insert_id ();
		$this->load->model ( 'common/u_customize_dest_model', 'u_customize_dest' );
		$endplace = explode ( ',', $end );
		for($i = 0; $i < count ( $endplace ); $i ++) {
			$this->u_customize_dest->insert ( array (
					'customize_id' => $customize_id,
					'dest_id' => $endplace [$i] 
			) );
		}
		$this->db->trans_complete ();
		if ($this->db->trans_status () === FALSE) {
			return false;
		} else {
			if (! empty ( $customize_id )) {
				if (!isset ($m_id)) {
					$reDataArrssdsd = $this->db->query ( "SELECT loginname,pwd FROM `u_member` where mid={$user_id} ORDER BY mid limit 1; " )->row_array ();
				} else {
					$reDataArrssdsd = '';
				}
				echo json_encode ( array (
						'code' => 2000,
						'msg' => 'ok!',
						'cid' => $reDataArrssdsd,
						'cust_id' => $cid 
				) );
			} else {
				echo json_encode ( array (
						'code' => 4000,
						'msg' => 'null!' 
				) );
			}
		}
	}
	
	/**
	 * @name：89、QQ登录
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */

	public function cfgm_qq_register() {
		$data ['connectid'] = $this->input->post ( 'openid', true );
		$data ['access_token'] = $this->input->post ( 'token', true );
		$data ['from'] = $this->input->post ( 'status', true );
		$data ['addtime'] = time ();
		$data ['mid'] = $mid = $this->input->post ( 'mid', true );
		$query = $this->db->query ( "select id from u_member_third_login where mid={$mid}" );
		$result = $query->result_array ();
		if (! $result) {
			$this->__errormsg ();
		}
	}
	
	/**
	 * @name：90、订单状态
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function order_idtype() {
		$lineid = $this->input->post ( 'lineid', true );
		is_numeric ( $lineid ) ? ($lineid) : $this->__errormsg ( '线路标识不能为空！' );
		$query = $this->db->query ( "select right(overcity,1) as city from u_line where id={$lineid}" );
		$city = $query->result_array ();
		$num = $city [0] ['city'];
		if ($city [0] ['city'] == 1) {
			$where = "where pid =100";
		} elseif ($city [0] ['city'] == 2) {
			$where = "where pid =99";
		} else {
			$where = "where pid =99";
		}
		$query = $this->db->query ( "select dict_id,description from u_dictionary {$where}" );
		$result ['type_id'] = $query->result_array ();
		$result ['inou'] = "$num";
		if ($result) {
			$this->__outmsg ( $result );
		}
	}
	
	/**
	 * @name：91、上门服务
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function expert_door_list() {
		$token = $this->input->post ( 'number', true );
		$this->expert_check_token ( $token );
		$this->load->model ( 'common/u_expert_access_token_model', 'eat_model' );
		$result = $this->eat_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'eid' );
		$m_id = $result [0] ['eid'];
		$number = $this->input->post ( 'pageSize', true );
		$page = $this->input->post ( 'pageNum', true );
		$status = $this->input->post ( 'progress', true );
		$number = empty ( $number ) ? 15 : $number;
		$page = empty ( $page ) ? 1 : $page;
		$this->load_model ( 'admin/b2/expert_service_model', 'expert_service' );
		$service_list = $this->expert_service->get_service_list ( $m_id, $status, $page, $number );
		// $reply_list = $this->grab_custom_order->get_grab_custom_list( $page, $number,$this->expert_id);
		// print_r($this->db->last_query());exit();
		$pagecount = $this->expert_service->get_service_list ( $m_id, $status, 0, $number );
		$this->db->close ();
		if (($total = $pagecount - $pagecount % $number) / $number == 0) {
			$total = 1;
		} else {
			$total = ($pagecount - $pagecount % $number) / $number;
			if ($pagecount % $number > 0) {
				$total += 1;
			}
		}
		$data = array (
				"totalRecords" => $pagecount,
				"totalPages" => $total,
				"pageNum" => $page,
				"pageSize" => $number,
				"rows" => $service_list 
		);
		if (! $data) {
			$this->__outmsg ( $data );
		} else {
			$this->__errormsg ();
		}
	}
	
	/**
	 * @name：92、线路确认
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function expert_line_apply() {
		$num = $this->input->post ( "num" ); // 页数
		$page_size = $this->input->post ( "page_size" ); // 条数
		$num = empty ( $num ) ? 1 : $num; // 每页的条数
		$page_size = empty ( $page_size ) ? 5 : $page_size; // 每页的条数
		$from = ($num - 1) * $page_size;
		$token = $this->input->post ( 'number', true );
		$this->expert_check_token ( $token );
		$this->load->model ( 'common/u_expert_access_token_model', 'eat_model' );
		$result = $this->eat_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'eid' );
		$m_id = $result [0] ['eid'];
		$sid = $theme = $this->input->post ( 'supplier', true );
		$su_id = $theme = $this->input->post ( 'supplier_id', true );
		$a_id = $theme = $this->input->post ( 'apply_id', true );
		if (! empty ( $su_id )) {
			$supplier = "AND `supplier_id` = '{$su_id}' ";
		} else {
			$supplier = ' ';
		}
		if ($sid == 1) {
			$reDataArr = $this->db->query ( "SELECT `id`, `company_name` as realname FROM (`u_supplier`) WHERE `status` = 2 " )->result_array ();
			$this->__outmsg ( $reDataArr );
		} else {
			if ($a_id == '1') {
				$reDataArr = $this->db->query ( "  SELECT  `l`.`id` AS line_id,   `l`.`linecode` AS line_sn, `l`.`linename` AS line_title,   `l`.`all_score` AS all_score, `st`.`cityname` AS start_city,  `l`.`agent_rate` AS agent_rate, `l`.`satisfyscore` AS satisfyscore,  `l`.`comment_count` AS comment_count,  `l`.`peoplecount` AS peoplecount, `l`.`sell_direction` AS sell_direction, `s`.`company_name` AS company_name, `s`.`mobile` AS mobile  FROM (`u_line` as l) LEFT JOIN `u_supplier` as s ON `l`.`supplier_id` =`s`.`id` LEFT JOIN `u_startplace` as st ON `l`.`startcity`=`st`.`id` WHERE `l`.`id` NOT IN( SELECT line_id FROM u_line_apply as la WHERE la.expert_id ={$m_id} and la.status=2) {$supplier} AND `l`.`status` = 2   AND `l`.`producttype` = 0   ORDER BY `l`.`addtime`  desc LIMIT {$from},{$page_size} " )->result_array ();
				$this->__outmsg ( $reDataArr );
			} else {
				$reDataArr = $this->db->query ( "   SELECT  `l`.`id` AS line_id,   `l`.`linecode` AS line_sn,   `l`.`linename` AS line_title,   `s`.`company_name` AS supplier_name,  `la`.`grade`,   `st`.`cityname` AS cityname,   `l`.`agent_rate` AS agent_rate,   `l`.`satisfyscore` AS satisfyscore,  `l`.`comment_count` AS comment_count,   `l`.`peoplecount` AS peoplecount,   `l`.`lineprice` AS lineprice,   `s`.`mobile` AS mobile,   `l`.`status`   FROM (`u_line_apply` AS la)   LEFT JOIN `u_line` AS l ON `la`.`line_id` = `l`.`id`   LEFT JOIN `u_supplier` AS s ON `l`.`supplier_id` = `s`.`id`   LEFT JOIN `u_startplace` as st ON `l`.`startcity`=`st`.`id`   WHERE `la`.`status` = 2    {$supplier}  AND `l`.`producttype` = 0   AND `la`.`expert_id` = {$m_id}   ORDER BY `la`.`addtime` desc LIMIT {$from},{$page_size}" )->result_array ();
				$this->__outmsg ( $reDataArr );
			}
		}
	}
	
	/**
	 * @name：93、管家排序
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function line_expert_sort() {
		$avg = $this->input->post ( "avg" );
		$sort = $this->input->post ( "sort" );
		$l_id = $this->input->post ( "lineid" );
		is_numeric ( $l_id ) ? ($l_id) : $this->__errormsg ( 'tip is null' );
		is_numeric ( $avg ) ? ($avg) : $this->__errormsg ( 'tip is null' );
		$this->load->helper ( 'regexp' );
		if (! isset ( $sort )) {
			$sort = $sort;
		}
		if (! empty ( $sort ) || regexp ( 'zhcnup', $sort )) {
			$sort = $sort;
		} // 极虐验证
		if ($avg == '1') { // 综合
			$order = "and (e.nickname like '%{$sort}%' or ua.name like '%{$sort}%')   order by e.online    desc  ";
		} elseif ($avg == '2') { // 好评
			$order = "and (e.nickname like '%{$sort}%' or ua.name like '%{$sort}%')  order by e.satisfaction_rate  desc";
		} elseif ($avg == '3') { // 成交
			$order = "and (e.nickname like '%{$sort}%' or ua.name like '%{$sort}%')  order by e.order_count  desc ";
		} else {
			$this->__errormsg ();
		}
		$reDataArr = $this->db->query ( "     SELECT  e.id AS expert_id,	e.realname, 	e.nickname, 	e.big_photo,	e.small_photo,	e.comment_count,	e.sex,	e.online,  	e.expert_theme AS expert_dest, 	e.satisfaction_rate  as satisfaction_rate , 	e.people_count  AS volume, 	ua.name as cityname, 	        (select GROUP_CONCAT(d.kindname SEPARATOR '、') as expert_dest from u_dest_cfg as d where FIND_IN_SET(d.id,substring_index  (e.expert_dest,',',3))) as expert_dest,     CASE 	WHEN la.grade = 1 THEN  '管家'  WHEN la.grade = 2 THEN  '初级专家'  	WHEN la.grade = 3 THEN 	'中级专家'  WHEN la.grade = 4 THEN  	'高级专家' END grade 	FROM 	u_expert AS e 	LEFT JOIN u_line_apply AS la ON e.id = la.expert_id 	left join u_area as ua on ua.id=e.city  WHERE 	la.line_id = {$l_id} 	AND la. STATUS = 2  and e.`status`=2 and e.is_kf='N'   {$order}  	   " )->result_array ();
		foreach ( $reDataArr as $key => $val ) {
			foreach ( $val as $k => $v ) {
				if ($k == "satisfaction_rate") {
					if ($v) {
						$val [$k] = round ( $v * 100 );
					}
				}
			}
			$reDataArr [$key] = $val;
		}
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：94、管家产品
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function cfmg_expert_sell_line() {
		$page = intval ( $this->input->post ( 'page', true ) );
		$page_size = intval ( $this->input->post ( 'pagesize', true ) );
		$page_size = empty ( $page_size ) ? 6 : $page_size;
		$page = $page == '0' ? 1 : $page;
		$from = ($page - 1) * $page_size;
		$eid = $this->input->post ( "eid" );
		is_numeric ( $eid ) ? ($eid) : $this->__errormsg ( '管家标识不能为空！' );
		$sql = "select 
		               la.id,la.expert_id,(CASE WHEN la.grade=1 THEN '管家' WHEN la.grade=2 THEN '初级专家' WHEN la.grade=3 THEN '中级专家' WHEN la.grade=4 THEN '高级专家' END) AS grade,
		               l.id AS line_id,l.linename,l.linetitle,l.mainpic,l.lineprice,l.satisfyscore,l.all_score AS total_score, 
		               l.peoplecount  as sell_num, (select sum(avgscore2) from u_comment as c where c.line_id=l.id and c.expert_id={$eid}) as expert_total_score       
		        from 
		 			   u_line_apply AS la 
		               left join u_line AS l on l.id=la.line_id     
	            where 
		               la.status=2 and l.status='2' and la.expert_id= {$eid} 
		 		GROUP BY l.id limit {$from},{$page_size}    ";
		$query = $this->db->query ( $sql );
		$data ['line_list'] = $query->result_array ();
		
	
		foreach ( $data ['line_list'] as $key => $val ) {
			foreach ( $val as $k => $v ) {
				if ($k == "satisfyscore") {
					if ($v) {
						$val [$k] = round ( $v * 100 );
					}
				}
			}
			$data ['line_list'] [$key] = $val;
		}
		if (empty ( $data ['line_list'] )) {
			$this->__outmsg ( $data ['line_list'] );
		}
		$sql = rtrim ( $sql, "limit {$from},{$page_size} " );
		$query = $this->db->query ( $sql );
		$data ['line_list_total'] = $query->num_rows ();
		$total = ceil ( $data ['line_list_total'] / $page_size );
		$data = array (
				'cur_page' => $from,
				'total' => $page_size,
				'result' => $data ['line_list'],
				'total_rows' => $data ['line_list_total'] 
		);
		$this->__outmsg ( $data );
	}
	
	/**
	 * @name：95、管家定制
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function cfmg_expert_custiome_list() {
		$page = intval ( $this->input->post ( 'page', true ) );
		$page_size = intval ( $this->input->post ( 'pagesize', true ) );
		$page_size = empty ( $page_size ) ? 6 : $page_size;
		$page = $page == '0' ? 1 : $page;
		$from = ($page - 1) * $page_size;
		$eid = $this->input->post ( "eid" );
		is_numeric ( $eid ) ? ($eid) : $this->__errormsg ( '管家标识不能为空！' );
		$sql = "   select uc.id as id,uc.question as question,uc.budget as budget,uc.pic as litpic,uc.total_people as total_people,uc.startdate as startdate,uc.estimatedate as estimatedate,uc.startplace as startplace,uc.status as status,uca.expert_id as expert_id,uca.isuse as isuse, 		ua.name as area_name,ud.kindname as dest_name, 		ue.nickname as nickname 		 from u_customize as uc left join u_customize_answer as uca on uc.id=uca.customize_id 		left join u_line as l on uc.line_id=l.id 	left join u_expert as ue on uca.expert_id=ue.id 	left join u_area as ua on ua.id=uc.startplace 	left join u_dest_cfg as ud on ud.id=uc.endplace  	where uc.status='3' and uca.isuse='1' and ISNULL(uca.replytime)=0 	 and uca.expert_id= {$eid} order by uc.addtime desc   limit {$from},{$page_size}     ";
		$query = $this->db->query ( $sql );
		$data ['line_list'] = $query->result_array ();
		if (empty ( $data ['line_list'] )) {
			$this->__outmsg ( $data ['line_list'] );
		}
		$sql = rtrim ( $sql, "limit {$from},{$page_size} " );
		$query = $this->db->query ( $sql );
		$data ['line_list_total'] = $query->num_rows ();
		$total = ceil ( $data ['line_list_total'] / $page_size );
		$data = array (
				'cur_page' => $from,
				'total' => $page_size,
				'result' => $data ['line_list'],
				'total_rows' => $data ['line_list_total'] 
		);
		$this->__outmsg ( $data );
	}

	/**
	 * @name：96、管家评价
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function cfmg_expert_comment_list() {
		$page = intval ( $this->input->post ( 'page', true ) );
		$page_size = intval ( $this->input->post ( 'pagesize', true ) );
		$page_size = empty ( $page_size ) ? 6 : $page_size;
		$page = $page == '0' ? 1 : $page;
		$from = ($page - 1) * $page_size;
		$eid = $this->input->post ( "eid" );
		$type = $this->input->post ( "type" );
		if (is_numeric ( $type )) {
			if ($type == '1') {
				$where = " and uc.avgscore2='5' ";
			} // 惊喜
			elseif ($type == '2') {
							$where = " and uc.avgscore2<'5' and uc.avgscore2>='4' ";
						} // 满意
			elseif ($type == '3') {
							$where = "  and uc.avgscore2<'4' and uc.avgscore2>='3' ";
						} // 一般
			elseif ($type == '4') {
							$where = " and uc.avgscore2<'3' ";
						} // 失望
			elseif ($type == '0') {
							$where = "  ";
						} // 失望
			}else {
						$where = ' ';
					}
		is_numeric ( $eid ) ? ($eid) : $this->__errormsg ( '管家标识不能为空！' );
		$sql = "select     uc.score5,uc.score6,uc.expert_content as content,uc.reply1,uc.reply2,uc.avgscore2,uc.addtime,um.nickname as nickname,mo.productautoid as productautoid,l.linename as line_name,l.linetitle as line_title       from u_comment as uc left join u_member as um on uc.memberid=um.mid        left join u_member_order as mo on uc.orderid=mo.id    left join u_line as l on l.id=mo.productautoid        where uc.status=1	and uc.expert_id={$eid}      {$where} 	order by uc.addtime  	desc limit {$from},{$page_size}     ";
		$query = $this->db->query ( $sql );
		$data ['line_list'] = $query->result_array ();
		if (empty ( $data ['line_list'] )) {
			$this->__outmsg ( $data ['line_list'] );
		}
		$sql = rtrim ( $sql, "limit {$from},{$page_size} " );
		$query = $this->db->query ( $sql );
		$line_list_total = $query->num_rows ();
		$total = ceil ( $line_list_total / $page_size );
		$data = array (
				'cur_page' => $from,
				'total' => $page_size,
				'result' => $data ['line_list'] 
		);
		$this->__outmsg ( $data, $line_list_total );
	}
	
	/**
	 * @name：97、管家咨询
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function cfmg_expert_consultation_list() {
		$page = intval ( $this->input->post ( 'page', true ) );
		$page_size = intval ( $this->input->post ( 'pagesize', true ) );
		$page_size = empty ( $page_size ) ? 6 : $page_size;
		$page = $page == '0' ? 1 : $page;
		$from = ($page - 1) * $page_size;
		$eid = $this->input->post ( "eid" );
		is_numeric ( $eid ) ? ($eid) : $this->__errormsg ( '管家标识不能为空！' );
		$sql = "   select ulq.*,ul.linename,ul.linetitle,um.nickname from u_line_question as ulq left join u_line as ul on ul.id=ulq.productid    left join u_member as um on um.mid=ulq.memberid     where ulq.replytime!='' and ulq.reply_type=1 and ulq.reply_id={$eid}  order by ulq.addtime desc limit {$from},{$page_size}  ";
		$query = $this->db->query ( $sql );
		$data ['line_list'] = $query->result_array ();
		if (empty ( $data ['line_list'] )) {
			$this->__outmsg ( $data ['line_list'] );
		}
		$sql = rtrim ( $sql, "limit {$from},{$page_size} " );
		$query = $this->db->query ( $sql );
		$data ['line_list_total'] = $query->num_rows ();
		$total = ceil ( $data ['line_list_total'] / $page_size );
		$data = array (
				'cur_page' => $from,
				'total' => $page_size,
				'result' => $data ['line_list'],
				'total_rows' => $data ['line_list_total'] 
		);
		$this->__outmsg ( $data );
	}
	
	/**
	 * @name：98、管家游记
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function cfmg_expert_travels_list() {
		$page = intval ( $this->input->post ( 'page', true ) );
		$page_size = intval ( $this->input->post ( 'pagesize', true ) );
		$page_size = empty ( $page_size ) ? 6 : $page_size;
		$page = $page == '0' ? 1 : $page;
		$from = ($page - 1) * $page_size;
		$eid = $this->input->post ( "eid" );
		is_numeric ( $eid ) ? ($eid) : $this->__errormsg ( '管家标识不能为空！' );
		$sql = " SELECT tn.id , tn.title, DATE_FORMAT(tn.addtime  , '%Y-%m-%d') AS addtime, `tn`.`comment_count` AS comment_count, `tn`.`praise_count` AS praise_count, `tn`.`content` AS content, `tn`.`cover_pic` AS pic FROM (`travel_note` AS tn) WHERE `tn`.`userid` = {$eid} AND `tn`.`usertype` = 1 AND `tn`.`is_show` = 1 ORDER BY `tn`.`addtime` desc limit {$from},{$page_size}  ";
		$query = $this->db->query ( $sql );
		$data ['line_list'] = $query->result_array ();
		if (empty ( $data ['line_list'] )) {
			$this->__outmsg ( $data ['line_list'] );
		}
		$sql = rtrim ( $sql, "limit {$from},{$page_size} " );
		$query = $this->db->query ( $sql );
		$data ['line_list_total'] = $query->num_rows ();
		$sql = " SELECT nickname from u_expert where id={$eid} ORDER BY id desc  limit 1  ";
		$query = $this->db->query ( $sql );
		$data ['expert'] = $query->row_array ();
		$total = ceil ( $data ['line_list_total'] / $page_size );
		$data = array (
				'cur_page' => $from,
				'total' => $page_size,
				'result' => $data ['line_list'],
				'expert' => $data ['expert'],
				'total_rows' => $data ['line_list_total'] 
		);
		$this->__outmsg ( $data );
	}
	
	/**
	 * @name：99、管家售卖线路
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function cfmg_expert_onuserbuy_list() {
		$page = intval ( $this->input->post ( 'page', true ) );
		$page_size = intval ( $this->input->post ( 'pagesize', true ) );
		$page_size = empty ( $page_size ) ? 6 : $page_size;
		$page = $page == '0' ? 1 : $page;
		$from = ($page - 1) * $page_size;
		$eid = $this->input->post ( "eid" );
		is_numeric ( $eid ) ? ($eid) : $this->__errormsg ( '管家标识不能为空！' );
		$sql = "         select uee.id as id,uee.content as content,uee.addtime as addtime,uee.praise_count as praise,ueep.pic as pic from u_expert_essay as uee left join u_expert_essay_pic as ueep on uee.id=ueep.expert_essay_id   where uee.expert_id={$eid}  order by uee.addtime desc  limit {$from},{$page_size}";
		$query = $this->db->query ( $sql );
		$datas = $query->result_array ();
		if (empty ( $datas )) {
			$this->__outmsg ( $datas );
		}
		foreach ( $datas as $key => $val ) {										//用于转换数组，只因数组内嵌过多，导致图片过滤无法带上域名，而后转换域名。
			foreach ( $val as $k => $v ) {
				if ($k == "pic") {
					if ($v) {
						$val [$k] = explode ( ";", $v );
						foreach ( $val [$k] as $k ) {
							if (! empty ( $k )) {
								$val ['pics'] [] = "http://" . $_SERVER ['HTTP_HOST'] . $k;
							}
						}
						$val ['pic'] = '1';
					}
				}
			}
			$datas [$key] = $val;
		}
		$sql = rtrim ( $sql, "limit {$from},{$page_size} " );
		$query = $this->db->query ( $sql );
		$data ['line_list_total'] = $query->num_rows ();									//条数
		$total = ceil ( $data ['line_list_total'] / $page_size );
		$data = array (
				'cur_page' => $from,
				'total' => $page_size,
				'result' => $datas,
				'total_rows' => $data ['line_list_total'] 
		);
		$this->__outmsg ( $data );
	}
	
	/**
	 * @name：100、旅游日记
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function cfmg_expert_travel_note_list() {
		$eid = $this->input->post ( "eid" );
		is_numeric ( $eid ) ? ($eid) : $this->__errormsg ( '管家标识不能为空！' );
		$reDataArr ['expert'] = $this->db->query ( "   SELECT e.id AS expert_id,tn.is_show,e.small_photo AS small_photo,e.nickname AS e_name,eg.title AS e_grade,tn.travel_impress AS travel_theme,l.linename AS linename,l.overcity,l.id as lineid,DATE_FORMAT(tn.addtime,'%Y-%m-%d') AS publish_time,(SELECT GROUP_CONCAT(attrname SEPARATOR ',') FROM u_line_attr AS la WHERE FIND_IN_SET(la.id,l.linetype)) AS line_attr, tn.praise_count AS praise_count,tn.comment_count,tn.content AS content FROM u_expert AS e LEFT JOIN travel_note AS tn ON e.id=tn.userid LEFT JOIN u_line AS l ON tn.line_id=l.id LEFT JOIN u_expert_grade AS eg ON e.grade=eg.grade WHERE tn.id={$eid}   " )->row_array ();
		if (empty ( $reDataArr ['expert'] )) {
			$this->__outmsg ( $reDataArr ['expert'] );
		}
		$pics = $this->db->query ( "SELECT tnp.pic ,tnp.description,tn.id , tnp.pictype FROM travel_note AS tn LEFT JOIN travel_note_pic AS tnp ON tn.id=tnp.note_id WHERE tn.id={$eid} ORDER BY tnp.pictype desc " )->result_array ();
		if (empty ( $pics )) {
			$this->__outmsg ( $pics );
		}
		foreach ( $pics as $key => $val ) {
			if ($val ['pictype'] == '1')						 {	$inter_city ['eat'] [] = array (	'id' => $val ['id'],	'pictype' => $val ['pictype'],	'description' => $val ['description'],	'pic' => $val ['pic'] );			} 
			elseif ($val ['pictype'] == '2') 				 {	$inter_city ['live'] [] = array (	'id' => $val ['id'],	'pictype' => $val ['pictype'],	'description' => $val ['description'],	'pic' => $val ['pic'] );			} 
			elseif ($val ['pictype'] == '3') 				 {	$inter_city ['walk'] [] = array (	'id' => $val ['id'],	'pictype' => $val ['pictype'],	'description' => $val ['description'],	'pic' => $val ['pic'] );		} 
			elseif ($val ['pictype'] == '4')				 {	$inter_city ['buy'] [] = array (	'id' => $val ['id'],	'pictype' => $val ['pictype'],	'description' => $val ['description'],	'pic' => $val ['pic'] );			}
			$reDataArr ['pics'] = $inter_city;
		}
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：101、日志插入，用于pc网站记录
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function cfmg_m_log() {
		$title = $this->input->post ( 'title' );
		$content = $this->input->post ( 'content' );
		mysql_real_escape_string ( $title );
		mysql_real_escape_string ( $content );
		if (empty ( $title )) {
			$this->__errormsg ( '标题为空！' );
		}
		if (empty ( $content )) {
			$this->__errormsg ( '内容为空！' );
		}
		$reDataArr = $this->db->query ( "insert into m_log values(null,{$title},{$content}" )->result_array ();
		if ($reDataArr) {
			echo json_encode ( array (
					'code' => 2000,
					'msg' => '插入日志成功！' 
			) );
		} else {
			echo json_encode ( array (
					'code' => 4000,
					'msg' => '插入日志失败！' 
			) );
		}
	}
	
	/**
	 * @name：102、线路分享
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function cfmg_line_share() {
		$page = intval ( $this->input->post ( 'page', true ) );
		$page_size = intval ( $this->input->post ( 'pagesize', true ) );
		$page_size = empty ( $page_size ) ? 6 : $page_size;
		$page = $page == '0' ? 1 : $page;
		$from = ($page - 1) * $page_size;
		$eid = $this->input->post ( "eid" );
		is_numeric ( $eid ) ? ($eid) : $this->__errormsg ( '线路标识不能为空！' );
		$sql = "     select tn.id,tn.title,tn.content,tn.cover_pic,tn.modtime,tn.line_id,um.nickname as nickname from travel_note as tn left join u_member as um on tn.userid=um.mid where tn.usertype='0' and tn.is_show='1' and tn.status='1' and   tn.line_id={$eid} order by tn.modtime desc limit {$from},{$page_size}  ";
		$query = $this->db->query ( $sql );
		$data ['line_list'] = $query->result_array ();
		if (empty ( $data ['line_list'] )) {
			$this->__outmsg ( $data ['line_list'] );					//为空输出
		}
		$sql = rtrim ( $sql, "limit {$from},{$page_size} " );		//输出条数
		$query = $this->db->query ( $sql );
		$data_total = $query->num_rows ();
		$total = ceil ( $data_total / $page_size );
		$data = array (
				'cur_page' => $from,
				'total' => $page_size,
				'result' => $data ['line_list'] 
		);
		$this->__outmsg ( $data, $data_total );
	}
	
	/**
	 * @name：103、用户评论
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function cfmg_user_comment_list() {
		$page = intval ( $this->input->post ( 'page', true ) );
		$page_size = intval ( $this->input->post ( 'pagesize', true ) );
		$page_size = empty ( $page_size ) ? 6 : $page_size;
		$page = $page == '0' ? 1 : $page;
		$from = ($page - 1) * $page_size;
		$eid = $this->input->post ( "eid" ); //线路ID
		$type = $this->input->post ( "type" );
		
		is_numeric ( $type ) ? ($type) : $this->__errormsg ( '标识不能为空！' );
		is_numeric ( $eid ) ? ($eid) : $this->__errormsg ( '线路标识不能为空！' );
		if ($type == '1') {
			$where = " and uc.avgscore1='5' ";		} // 惊喜
		elseif ($type == '2') {
			$where = " and uc.avgscore1<'5' and uc.avgscore1>='4' ";} // 满意
		elseif ($type == '3') {
			$where = "  and uc.avgscore1<'4' and uc.avgscore1>='3' ";	} // 一般
		elseif ($type == '4') {
			$where = " and uc.avgscore1<'3' ";	} // 失望
		elseif ($type == '5') {
			$where = "  ";		}  // 全部
		else {
			$this->__errormsg ( 'sorry , no it !' );
		}
		$sql = "select 
		                uc.score1,uc.score2,uc.score3,uc.score4,uc.addtime,uc.reply1,uc.reply2,uc.content ,
		                um.mobile ,um.nickname ,uc.pictures as pic 
		       from 
		                u_comment as uc 
		                left join u_member as um on uc.memberid=um.mid 
		       where 
		                uc.status=1 and uc.line_id={$eid} {$where} 	
		       order by 
		                uc.addtime desc limit {$from},{$page_size}    
		        ";
		$query = $this->db->query ( $sql );
		$datas = $query->result_array ();
		if (empty ( $datas )) {
			$this->__outmsg ( $datas );					//空输出
		}
		// 为图片路径 加域名
		foreach ( $datas as $key => $val ) {			
			foreach ( $val as $k => $v ) {
				if ($k == "pic") {
					if ($v) {
						$val [$k] = explode ( ",", $v );
						foreach ( $val [$k] as $k ) {
							if (! empty ( $k )) {
								$val ['pics'] [] = BANGU_URL. $k;
							}
						}
						$val ['pic'] = '1';
					}
				}
			}
			$datas [$key] = $val;
		}
		//处理号码
		foreach ( $datas as $key => $val ) {			
			foreach ( $val as $k => $v ) {
				if ($k == "mobile") {
					if ($v) {
						$val [$k] = substr_replace ( $v, '*****', 4, 4 );
					}
				}
			}
			$datas [$key] = $val;
		}
		$sql = rtrim ( $sql, "limit {$from},{$page_size} " );		//处理条数
		$query = $this->db->query ( $sql );
		$dat = $query->num_rows ();
		$total = ceil ( $dat / $page_size );
		$data = array (
				'cur_page' => $from,
				'total' => $page_size,
				'result' => $datas 
		);
		$this->__outmsg ( $data, $dat );
	}
	
	/**
	 * @name：104、下单合同URL展示
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function cfgm_web_pdf() {
		$is = $this->input->posy ( 'is', true );
		is_numeric ( $is ) ? ($is) : $this->__errormsg ( 'tip is null !' );
		if ($is == '1') {		
			$reDataArr = $this->db->query ( " select  travel_contract_abroad_url as pic  from  cfg_web " )->row_array ();				//境外合同
		} elseif ($is == '2') {
			$reDataArr = $this->db->query ( " select  travel_contract_domestic_url as pic  from  cfg_web " )->row_array ();			//境内合同
		} else {
			$this->__errormsg ( ' error ! ' );
		}
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：105、管家收藏	又称		管家点赞
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function cfmg_expert_collect() {
		$eid = $this->input->post ( 'eid' );
		is_numeric ( $eid ) ? ($eid) : $this->__errormsg ( 'tip is null !' );
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$result = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$mid = $result [0] ['mid'];
		if ((empty ( $eid )) && (empty ( $token ))) {
			$this->__errormsg ( 'not null !' );
		}
		$reDataArr = $this->db->query ( " SELECT * FROM (`u_expert_collect`) WHERE `expert_id` = {$eid} AND `member_id` = {$mid}" )->result_array ();
		if (empty ( $reDataArr )) {
			$llData = array (
					'expert_id' => $eid,
					'member_id' => $mid,
					'addtime' => date ( 'Y-m-d H:i:s', time () ) 
			);
			$this->db->insert ( "u_expert_collect", $llData );
			echo json_encode ( array (
					'code' => 2000,
					'msg' => '收藏成功！' 
			) );
		} else {
			$status = $this->db->delete ( 'u_expert_collect', array (
					'expert_id' => $eid,
					'member_id' => $mid 
			) );
			echo json_encode ( array (
					'code' => 4000,
					'msg' => '取消收藏！' 
			) );
		}
	}
	
	/**
	 * @name：106、点赞		用户为管家游记点赞
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function efmg_expert_good_detail() {
		$insert_arr = array ();
		$note_id = $this->input->post ( 'note_id' );
		is_numeric ( $note_id ) ? ($note_id) : $this->__errormsg ( 'tip is null !' );
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$result = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$c_userid = $result [0] ['mid'];
		$this->db->select ( "count(*) AS  praise_count" );
		$this->db->from ( 'travel_note_praise' );
		$this->db->where ( array (
				'note_id' => $note_id,
				'member_id' => $c_userid 
		) );
		$res = $this->db->get ()->result_array ();
		if ($res [0] ['praise_count'] == 0) {
			$insert_arr ['note_id'] = $note_id;
			$insert_arr ['member_id'] = $c_userid;
			$insert_arr ['ip'] = $_SERVER ["REMOTE_ADDR"];
			$insert_arr ['addtime'] = date ( 'Y-m-d H:i:s' );
			if ($this->db->insert ( 'travel_note_praise', $insert_arr )) {
				$update_sql = "update travel_note set praise_count=praise_count+1 where id=$note_id";
				if ($this->db->query ( $update_sql )) {
					$this->db->select ( "praise_count" );
					$this->db->from ( 'travel_note' );
					$this->db->where ( array (
							'id' => $note_id 
					) );
					$res = $this->db->get ()->result_array ();
					echo json_encode ( array (
							'code' => 2000,
							'msg' => '点赞成功',
							'praise_count' => $res [0] ['praise_count'] 
					) );
				} else {
					echo json_encode ( array (
							'code' => 4000,
							'msg' => '点赞失败' 
					) );
				}
			} else {
				echo json_encode ( array (
						'code' => 4000,
						'msg' => '点赞失败' 
				) );
			}
		} else {
			$delete_sql = "delete from travel_note_praise where note_id=$note_id and member_id=$c_userid";
			if ($this->db->query ( $delete_sql )) {
				$update_sql = "update travel_note set praise_count=praise_count-1 where id=$note_id";
				if ($this->db->query ( $update_sql )) {
					$this->db->select ( "praise_count" );
					$this->db->from ( 'travel_note' );
					$this->db->where ( array (
							'id' => $note_id 
					) );
					$res = $this->db->get ()->result_array ();
					echo json_encode ( array (
							'code' => 2001,
							'msg' => '取消点赞',
							'praise_count' => $res [0] ['praise_count'] 
					) );
				} else {
					echo json_encode ( array (
							'code' => 4000,
							'msg' => '取消点赞失败' 
					) );
				}
			} else {
				echo json_encode ( array (
						'code' => 4000,
						'msg' => '取消点赞失败' 
				) );
			}
		}
	}
	
	/**
	 * @name：107、点管家评论提交
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function efmg_expert_comment_submit() {
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$result = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$c_userid = $result [0] ['mid'];
		$comment = $this->input->post ( 'comment' );
		mysql_real_escape_string ( $comment );
		$insert_arr = array ();
		$insert_arr ['note_id'] = $this->input->post ( 'note_id' );
		$insert_arr ['member_id'] = $c_userid;
		$insert_arr ['reply_content'] = $comment;
		if (empty ( $insert_arr ['reply_content'] )) {
			echo json_encode ( array (
					'code' => 4000,
					'msg' => '发表内容不能为空' 
			) );
			exit ();
		}
		$insert_arr ['ADDTIME'] = date ( 'Y-m-d H:i:s' );
		if ($this->db->insert ( 'travel_note_reply', $insert_arr )) {
			$sql = "update travel_note set comment_count=comment_count+1 where id=" . $this->input->post ( 'note_id' );
			if ($this->db->query ( $sql )) {
				echo json_encode ( array (
						'code' => 2000,
						'msg' => '发表成功' 
				) );
				exit ();
			} else {
				echo json_encode ( array (
						'code' => 4000,
						'msg' => '发表失败' 
				) );
				exit ();
			}
		} else {
			echo json_encode ( array (
					'code' => 4000,
					'msg' => '发表失败' 
			) );
			exit ();
		}
	}
	
	/**
	 * @name：108、定制展示
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	 
	public function cfgm_my_customize() {
		$page = intval ( $this->input->post ( 'page', true ) );
		$page_size = intval ( $this->input->post ( 'pagesize', true ) );
		$page_size = empty ( $page_size ) ? 6 : $page_size;
		$page = $page == '0' ? 1 : $page;
		$from = ($page - 1) * $page_size;
		$sql = " SELECT c.id ,c.question,c.pic,c.budget,c.people,	eg.title  AS grade,e.realname,e.nickname,e.small_photo,e.id AS expert_id  FROM u_customize_answer AS ca    LEFT JOIN u_customize AS c ON ca.customize_id=c.id   LEFT JOIN u_expert AS e ON ca.expert_id=e.id     left join u_expert_grade as eg on e.grade=eg.grade   WHERE ca.isuse=1 and c.status = 3 and e.status=2    order by c.id desc     limit {$from},{$page_size}  ";
		$query = $this->db->query ( $sql );
		$data ['line_list'] = $query->result_array ();
		if (empty ( $data ['line_list'] )) {
			$this->__outmsg ( $data ['line_list'] );						//输出空
		}
		$sql = rtrim ( $sql, "limit {$from},{$page_size} " );			//取条数
		$query = $this->db->query ( $sql );
		$roes = $query->num_rows ();
		$total = ceil ( $roes / $page_size );
		$data = array (
				'this_page' => $from,
				'page' => $page_size,
				'result' => $data ['line_list'] 
		);
		$this->__outmsg ( $data, $len = $roes );
	}
	
	/**
	 * @name：109、我的定制
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function cfmg_my_customize_list() {
		$page = intval ( $this->input->post ( 'page', true ) );
		$page_size = intval ( $this->input->post ( 'pagesize', true ) );
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$result = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$m_id = $result [0] ['mid'];
		
		is_numeric ( $m_id ) ? ($m_id) : $this->__errormsg ( '不能为空！' );
		$page_size = empty ( $page_size ) ? 1 : $page_size;
		$page = $page == '0' ? 1 : $page;
		$from = ($page - 1) * $page_size;
		$sql = "	  select   (SELECT	ey.line_id	FROM u_enquiry AS ey LEFT JOIN u_line AS l ON ey.line_id = l.id	WHERE ey.expert_id=  (SELECT expert_id FROM u_customize_answer AS ca WHERE ca.customize_id=c.id AND ca.isuse=1 LIMIT 1)AND l.status= 2 AND ey.line_id>0 AND ey.customize_id=c.id LIMIT 1 ) AS line_id,	l.status as line_status,c.estimatedate,m.mid,c.id,c.startdate, (SELECT st.cityname FROM u_startplace AS st WHERE st.id=c.startplace) AS cityname, c.budget,  c.days,  c.people,  c.total_people,  c.service_range,  g.isuse,c.childnum,   (select GROUP_CONCAT(kindname ) from u_dest_cfg where FIND_IN_SET(id,endplace) >0 )as end ,   (SELECT COUNT(*)	FROM u_customize_answer AS ca WHERE ca.customize_id = c.id) AS 'design_expert',   (SELECT COUNT(*) FROM u_customize_answer AS ca WHERE	ca.customize_id = c.id AND ISNULL(ca.replytime) = 0) AS 'num',   CASE   WHEN c. STATUS =3 THEN '已完成'   WHEN c. STATUS = -3 THEN	'已过期'  WHEN c. STATUS = -2 THEN '已取消'    WHEN TIMESTAMPDIFF(HOUR, c.addtime, NOW()) > 24  AND c. STATUS = 0 THEN '已过期'  WHEN c.id NOT IN (SELECT ca.customize_id FROM u_customize_answer AS ca WHERE	ca.customize_id = c.id ) THEN '制作中'   WHEN c.id IN (	SELECT ca.customize_id FROM	u_customize_answer AS ca WHERE ca.customize_id = c.id	AND ca.isuse = 1 ) THEN '已确认'   WHEN c.id IN (SELECT	ca.customize_id	FROM u_customize_answer AS ca WHERE	ca.customize_id = c.id) THEN '待选方案' END 'status' ,  CASE   WHEN c. STATUS =3 THEN '4'   WHEN c. STATUS = -3 THEN	'-3'   WHEN c. STATUS =- 2 THEN '-2'   WHEN TIMESTAMPDIFF(HOUR, c.addtime, NOW()) > 24 AND c. STATUS = 0 THEN '0'  WHEN c.id NOT IN (SELECT ca.customize_id FROM	u_customize_answer AS ca WHERE	ca.customize_id = c.id ) THEN '1'  WHEN c.id IN (	SELECT	ca.customize_id FROM	u_customize_answer AS ca WHERE ca.customize_id = c.id	AND ca.isuse = 1 ) THEN '2'  WHEN c.id IN (SELECT	ca.customize_id	FROM u_customize_answer AS ca WHERE	ca.customize_id = c.id) THEN '3' END 'nostatus'  FROM	(`u_customize` AS c)  LEFT JOIN `u_member` AS m ON `c`.`member_id` = `m`.`mid`  LEFT JOIN u_enquiry as e on e.customize_id=c.id  LEFT JOIN u_line as l on l.id=c.line_id  left join u_enquiry_grab as g on g.enquiry_id=e.id  WHERE `m`.`mid` ={$m_id}  GROUP BY id ORDER BY c.id DESC  limit {$from},{$page_size}";
		$query = $this->db->query ( $sql );
		$datas = $query->row_array ();
		
		$sql = rtrim ( $sql, "limit {$from},{$page_size} " );
		$query = $this->db->query ( $sql );
		$dat = $query->num_rows ();
		
		if (! empty ( $datas ['end'] )) {												//毋须复杂数据查询判断城市是否为省市，直接用此截取，效果一样，但性能优于此前一半
			$end = ($datas ['end']);
			if (strstr ( $end, ',' )) {
				$ar = explode ( ',', $end );
				$datas ['endpl'] = array_slice ( $ar, 1, 6 );
				$datas ['endplaces'] = implode ( "/", $datas ['endpl'] );
				unset ( $datas ['endpl'] );
				unset ( $datas ['end'] );
			} else {
				$datas ['endplaces'] = $end;
			}
		} 
		if (!empty ( $datas ['startdate'] )) {
			$datas ['startdate'] = $datas ['startdate'];
		} elseif (!empty ( $datas ['estimatedate'] )) {
			$datas ['startdate'] = $datas ['estimatedate'];
		}
		$total = ceil ( $dat / $page_size );
		$return = array (
				'cur_page' => $from,
				'total' => $dat,
				'result' => $datas 
		);
		if($dat>0)
		$this->__outmsg ($return,$dat);
		else
		$this->__errormsg($msg = "", $code = "4001");
			
	}
	
	/**
	 * @name：110、定制 详情 行
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function cfmg_custoimze_detail_row() {
		$token = $this->input->post ( 'number', true );
		$cid = intval ( $this->input->post ( 'cid', true ) );
		$this->check_token ( $token );
		$datas = $this->db->query ( "      SELECT c.linkname,c.linkphone,c.estimatedate,c.another_choose,c.linkweixin,c.id,c.roomnum,c.expert_id,c.startdate,c.status,c.service_range,c.childnum,c.other_service,c.budget, (SELECT st.cityname FROM u_startplace AS st WHERE st.id=c.startplace) AS cityname,(select GROUP_CONCAT(kindname) from u_dest_cfg where FIND_IN_SET(id,c.endplace) >0 )as end ,c.days,c.trip_way ,c.people,c.childnum,c.childnobednum,c.oldman,c.total_people,th.name as theme, c.hotelstar ,c.room_require, c.isshopping as 'isshopping',c.catering ,m.truename,m.mobile,m.weixin ,c.member_id as cid FROM `u_customize` as c LEFT JOIN u_dictionary AS d ON c.hotelstar = d.dict_id LEFT JOIN u_dictionary AS dc ON c.trip_way = dc.dict_id LEFT JOIN u_theme as th on th.id=c.theme LEFT JOIN u_dictionary AS dt ON c.isshopping = dt.dict_id LEFT JOIN u_member as m on m.mid=c.member_id WHERE c.id ={$cid}       " )->row_array ();
		if (! empty ( $datas ['end'] )) {									//毋须复杂数据查询判断城市是否为省市，直接用此截取，效果一样，但性能优于此前一半
			$end = ($datas ['end']);
			if (strstr ( $end, ',' )) {
				$ar = explode ( ',', $end );
				$datas ['endpl'] = array_slice ( $ar, 1, 6 );
				$datas ['endplaces'] = implode ( "/", $datas ['endpl'] );
				unset ( $datas ['endpl'] );
				unset ( $datas ['end'] );
			} else {
				$datas ['endplaces'] = $end;
			}
		} else {
			$datas ['endplaces'] = '';
		}
		if (empty ( $datas ['estimatedate'] )) {
			$datas ['startdate'] = $datas ['startdate'];
		} else {
			$datas ['startdate'] = $datas ['estimatedate'];
		}
		$datas ['expert'] = $this->db->query ( "     SELECT ca.expert_id as expert_id,ca.id,ca.title AS ca_title,ca.price_description,c.id as cid,e.id as eid,e.realname ,ca.addtime ,ca.isuse,ISNULL(ca.replytime) as reply,e.small_photo,CASE WHEN ISNULL(ca.replytime) > 0 THEN '管家还未回复方案，请耐心等待。。。' WHEN ISNULL(ca.replytime) = 0 THEN	ca.plan_design END 'solution' FROM u_customize_answer AS ca LEFT JOIN u_customize AS c ON ca.customize_id = c.id LEFT JOIN u_expert AS e ON ca.expert_id = e.id WHERE c.id ={$cid} and isnull(ca.replytime)=0 ORDER BY ca.addtime desc       " )->result_array ();
		$this->__outmsg ( $datas );
	}
	
	/**
	 * @name：111、管家抢单
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function cfmg_custoimze_expert_detail_row() {
		$cid = $this->input->post ( 'cid', true );
		$eid = $this->input->post ( 'eid', true );
		is_numeric ( $cid ) ? ($cid) : $this->__errormsg ( '不能为空！' );
		is_numeric ( $eid ) ? ($eid) : $this->__errormsg ( '不能为空！' );
		$sql = "  select ans.plan_design,day,cj.title as cjtitle,ans.title,jieshao,cjp.pic,ans.attachment, ans.childprice as childprice,ans.childnobedprice,ans.price,ans.price_description, ans.oldprice,  cj.breakfirsthas, cj.breakfirst,cj.transport,cj.hotel,cj.lunchhas,cj.lunch, cj.supperhas, cj.supper, ans.id as caid, ans.customize_id as id, ans.expert_id, ans.isuse, ISNULL(ans.replytime) AS reply from u_customize_answer AS ans Left Join u_customize_jieshao as cj on cj.customize_answer_id=ans.id left join u_customize_jieshao_pic as cjp on cj.id = customize_jieshao_id where ans.id ={$cid}";
		$query = $this->db->query ( $sql );
		$plan_list ['plan_list'] = $query->result_array ();
		$expert_id = ($plan_list ['plan_list'] [0] ['expert_id']);
		if (! empty ( $expert_id )) {
			$plan_list ['expert_list'] = $this->db->query ( "select   realname,mobile,weixin,nickname,id from u_expert  where id={$expert_id} " )->row_array ();
		} else {
			$plan_list ['expert_list'] = 'null';
		}
		$plan_list ['order_id'] = $eid;
		foreach ( $plan_list ['plan_list'] as $key => $val ) {						//用于转换数组，只因数组内嵌过多，导致图片过滤无法带上域名，而后转换域名。
			foreach ( $val as $k => $v ) {
				if ($k == "pic") {
					if ($v) {
						$val [$k] = explode ( ";", $v );
						foreach ( $val [$k] as $k ) {
							if (! empty ( $k )) {
								$val ['pics'] [] = "http://" . $_SERVER ['HTTP_HOST'] . $k;
							}
						}
						$val ['pic'] = '1';
					}
				}
			}
			$plan_list ['plan_list'] [$key] = $val;
		}
		
		$this->__outmsg ( $plan_list );
	}
	
	/**
	 * @name：112、抢单
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function cfmg_custoimze_detail_update_status() {
		$this->load->model ( 'member_model', 'member' );
		$cid = $this->input->post ( 'cid', true ); // 定制单ID
		$expert = $this->input->post ( 'expert', true );
		$orderid = $this->input->post ( 'orderid', true ); // 管家ID
		is_numeric ( $cid ) ? ($cid) : $this->__errormsg ( 'tip is null ' );
		is_numeric ( $expert ) ? ($expert) : $this->__errormsg ( 'tip is null' );
		is_numeric ( $orderid ) ? ($orderid) : $this->__errormsg ( 'tip is null' );
		$reDataArr = $this->db->query ( "    select status	FROM	(`u_customize` AS c) 	WHERE c.id ={$cid}" )->row_array ();
		// if(empty($reDataArr['status']) &&($reDataArr['status']==)){ echo json_encode ( array("msg" => "该方案异常,请稍后在试 !","code" => "4000") ); exit(); }
		$sta = $reDataArr ['status'];
		if ($sta == '-3') {
			echo json_encode ( array (
					"msg" => "该方案已过期，请勿重复选择！",
					"code" => "4000" 
			) );
			exit ();
		}
		if ($sta == '3') {
			echo json_encode ( array (
					"msg" => "该方案已完成,请勿重复选择！",
					"code" => "4000" 
			) );
			exit ();
		}
		if ($sta == '-2') {
			echo json_encode ( array (
					"msg" => "该方案已取消。",
					"code" => "4000" 
			) );
			exit ();
		}
		if ($sta == '1') {
			echo json_encode ( array (
					"msg" => "该方案已确定,请勿重复选择！",
					"code" => "4000" 
			) );
			exit ();
		}
		if ($sta == '0') {
			$cc = $this->member->updata_alldata ( 'u_customize', array (
					'id' => $cid 
			), array (
					'status' => 1,
					'is_assign' => 1,
					'expert_id' => $orderid 
			) );
			$re = $this->member->updata_alldata ( 'u_customize_answer', array (
					'id' => $expert 
			), array (
					'isuse' => 1 
			) );
			if ($re) {
				echo json_encode ( array (
						"msg" => "选择方案成功",
						"code" => "2000" 
				) );
				exit ();
			} else {
				echo json_encode ( array (
						"msg" => "方案已经选择",
						"code" => "4000" 
				) );
				exit ();
			}
		}
	}
	
	/**
	 * @name：113、管家未申请线路
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function efmg_expert_apply() {
		$this->load->model ( 'admin/b2/line_apply_model', 'line_apply' );
		$page = intval ( $this->input->post ( 'page', true ) );
		$page_size = intval ( $this->input->post ( 'pagesize', true ) );
		$page_size = empty ( $page_size ) ? 5 : $page_size;
		$page = $page == '0' ? 1 : $page;
		$from = ($page - 1) * $page_size;
		$token = $this->input->post ( 'number', true );
		$this->expert_check_token ( $token );
		$this->load->model ( 'common/u_expert_access_token_model', 'eat_model' );
		$result = $this->eat_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'eid' );
		$m_id = $result [0] ['eid'];
		is_numeric ( $m_id ) ? ($m_id) : $this->__errormsg ( 'tip is null' );
		$sid = $this->input->post ( 'supplier_id', true ); // 供应商
		$startcity = $this->input->post ( 'startcity', true ); // 出发地
		$overcity = $this->input->post ( 'overcity', true ); // 目的地
		$linename = $this->input->post ( 'linename', true ); // 线路名字
		$this->load->helper ( 'regexp' );
		if (is_numeric ( $sid )) {
			$where = "AND `supplier_id` = {$sid}";
		} 
/* 		elseif (! empty ( $startcity )) {
			$where = "and l.startcity in ({$startcity}) ";
		} elseif (! empty ( $overcity )) {
			$where = "and ( find_in_set({$overcity} ,l.overcity) ) ";
		}  */
		elseif (regexp ( 'zhcnup', $linename )) {
			// elseif(!empty()){
			$where = " AND `l`.`linename` like '%{$linename}%'";
		} else {
			$where = ' ';
		}
		$sql = "         SELECT 
		                         `l`.`id` AS line_id, `l`.`linecode` AS line_sn, `l`.`linename` AS line_title, l.mainpic as pic ,`l`.`all_score` AS all_score,l.agent_rate_int,
		                         GROUP_CONCAT(`st`.`cityname`) AS start_city, `l`.`agent_rate` AS agent_rate, `l`.`satisfyscore` AS satisfyscore, `l`.`comment_count` AS comment_count,
		                          `l`.`peoplecount` AS peoplecount, `l`.`sell_direction` AS sell_direction, `s`.`company_name` AS company_name, `s`.`mobile` AS mobile   		 
		                 FROM 
		                         (`u_line` as l)     
		                         LEFT JOIN `u_supplier` as s ON `l`.`supplier_id` =`s`.`id`   
		                         left join u_line_startplace as ls on l.id=ls.line_id  
		                         LEFT JOIN `u_startplace` as st ON `ls`.`startplace_id`=`st`.`id`       
		                 where   
		                         `l`.`id` NOT IN( SELECT line_id FROM u_line_apply as la WHERE la.expert_id ={$m_id} and la.status=2) 
		                          {$where}   AND `l`.`status` = 2 and l.producttype=0  GROUP BY l.id   ORDER BY `l`.`addtime` desc limit {$from},{$page_size}";
		$query = $this->db->query ( $sql );
		$line_apply_list = $query->result_array ();
		
		foreach ( $line_apply_list as $key => $val ) {			//处理佣金
			foreach ( $val as $k => $v ) {
				if ($k == "agent_rate") {
					if ($v) {
						$val [$k] = round ( $v * 100 );
					}
				}
			}
			$line_apply_list [$key] = $val;
		}
		foreach ( $line_apply_list as $key => $val ) {		//处理积分
			foreach ( $val as $k => $v ) {
				if ($k == "satisfyscore") {
					if ($v) {
						$val [$k] = round ( $v ,3) * 100 ;
						$val [$k] = sprintf("%.1f",$val [$k]);
					}
				}
			}
			$line_apply_list [$key] = $val;
		}
		$sql = rtrim ( $sql, "limit {$from},{$page_size} " );		//条数
		$query = $this->db->query ( $sql );
		$dat = $query->num_rows ();
		$total = ceil ( $dat / $page_size );
		$data = array (
				'line_apply_list' => $line_apply_list 
		);
		$this->__outmsg ( $data, $total );
	}
	
	/**
	 * @name：114、管家已申请线路
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function efmg_expert_no_apply() {
		$this->load->helper ( 'regexp' );
		$page = intval ( $this->input->post ( 'page', true ) );
		$page_size = intval ( $this->input->post ( 'pagesize', true ) );
		$page_size = empty ( $page_size ) ? 5 : $page_size;
		$page = $page == '0' ? 1 : $page;
		$from = ($page - 1) * $page_size;
		$token = $this->input->post ( 'number', true );
		$this->expert_check_token ( $token );
		$this->load->model ( 'common/u_expert_access_token_model', 'eat_model' );
		$result = $this->eat_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'eid' );
		$m_id = $result [0] ['eid'];
		$sid = $this->input->post ( 'supplier_id', true ); // 供应商
		$startcity = $this->input->post ( 'startcity', true ); // 出发地
		$overcity = $this->input->post ( 'overcity', true ); // 目的地
		$linename = $this->input->post ( 'linename', true ); // 线路名字
		$grade = $this->input->post ( 'grade', true ); // 管家搜索
		
		$where="";
		if (is_numeric ( $sid )) {
			$where = "AND `supplier_id` = {$sid}";
		}

		if ( regexp ( 'zhcnup', $linename )) {
			// elseif(!empty($linename)){
			$where = " AND `l`.`linename` like '%{$linename}%'";
		} 
		
		if (! empty ( $grade )) {
			$where = " AND `la`.`grade` = {$grade} ";
		} 
		
		$sql = "      SELECT 
		                      `l`.`id` AS line_id, `l`.`linecode` AS line_sn, `l`.`linename` AS line_title,l.agent_rate_int,
		                      l.mainpic as pic, `s`.`company_name` AS supplier_name, (CASE WHEN `la`.`grade`=1 THEN '管家' WHEN `la`.`grade`=2 THEN '初级专家' WHEN `la`.`grade`=3 THEN '中级专家' WHEN `la`.`grade`=4 THEN '高级专家' END) AS grade  ,
		                   	  GROUP_CONCAT(`st`.`cityname`) AS cityname, `l`.`agent_rate` AS agent_rate, `l`.`satisfyscore` AS satisfyscore, 
		                      `l`.`comment_count` AS comment_count, `l`.`peoplecount` AS peoplecount, `l`.`lineprice` AS lineprice, `s`.`mobile` AS mobile, `l`.`status`   	
		             FROM     
		                     (`u_line_apply` AS la)   	
		                     LEFT JOIN `u_line` AS l ON `la`.`line_id` = `l`.`id`   
		                     LEFT JOIN `u_supplier` as s ON `l`.`supplier_id` =`s`.`id`   
		                     left join u_line_startplace as ls on l.id=ls.line_id  
		                     LEFT JOIN `u_startplace` as st ON `ls`.`startplace_id`=`st`.`id`      	
		            WHERE    
		                    `la`.`status` = 2 	{$where}	AND `l`.`producttype` = 0 	AND `la`.`expert_id` = {$m_id}	 
		            GROUP BY 
		                     l.id  ORDER BY `la`.`addtime` desc     
		            limit {$from},{$page_size}";
		$query = $this->db->query ( $sql );
		$line_apply_list = $query->result_array ();
		foreach ( $line_apply_list as $key => $val ) {
			foreach ( $val as $k => $v ) {
				if ($k == "agent_rate") {
					if ($v) {
						$val [$k] = round ( $v * 100 );
					}
				}
			}
			$line_apply_list [$key] = $val;
		}
		foreach ( $line_apply_list as $key => $val ) {
			foreach ( $val as $k => $v ) {
				if ($k == "satisfyscore") {
					if ($v) {
						$val [$k] = round ( $v * 100 );
					}
				}
			}
			$line_apply_list [$key] = $val;
		}
		$sql = rtrim ( $sql, "limit {$from},{$page_size} " );
		$query = $this->db->query ( $sql );
		$dat = $query->num_rows ();
		$data = array (
				'line_apply_list' => $line_apply_list 
		);
		$this->__outmsg ( $data, $dat );
	}
	
	/**
	 * @name：115、供应商信息
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function efmg_expert_apply_supplier() {
		$this->load->model ( 'admin/b2/line_apply_model', 'line_apply' );
		$token = $this->input->post ( 'number', true );
		$this->expert_check_token ( $token );
		$suppliers = $this->line_apply->get_suppliers ();
		$data = array (
				'suppliers' => $suppliers 
		);
		$this->__outmsg ( $data );
	}
	
	/**
	 * @name：116、供应商-线路
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function efmg_line_detial_apply() {
		$this->load->model ( 'admin/b2/line_apply_model', 'line_apply' );
		$this->load->model ( 'admin/b1/user_shop_model' ); // 线路详情页用到
		$lineId = intval ( $this->input->post ( 'id', true ) );
	
		is_numeric ( $lineId ) ? ($lineId) : $this->__errormsg ( 'null' );
		$token = $this->input->post ( 'number', true );
		$this->expert_check_token ( $token );
		$data ['data'] = $this->db->query ( " SELECT a.*,GROUP_CONCAT(`u`.`cityname`) AS cityname	FROM u_line as a  left join u_line_startplace as ls on a.id=ls.line_id  LEFT JOIN u_startplace as u  on ls.startplace_id=u.id   		WHERE a.id={$lineId} LIMIT 1 " )->row_array ();
		$this->load->model ( 'admin/a/lineattr_model', 'lineattr_model' );
		$this->load->model ( 'admin/a/destinations_model', 'destinations_model' );
		// $data['line_attr'] = $this->lineattr_model->getLineattrTreeDate();
		// $data['destinations'] = $this->destinations_model->getDestinationsTreeDate();
		$data ['overcity_arr'] = array ();
		if ("" != $data ['data'] ['overcity2']) {
			$data ['overcity_arr'] = $this->destinations_model->getDestinations ( explode ( ",", $data ['data'] ['overcity2'] ) );
		}
		$data ['line_attr_arr'] = array ();
		if ("" != $data ['data'] ['linetype']) {
			$data ['line_attr_arr'] = $this->lineattr_model->getLineattr ( explode ( ",", $data ['data'] ['linetype'] ) );
		}
		// 供应商信息
		$supplierData = $this->user_shop_model->get_user_shop_select ( 'u_supplier', array (
				'id' => $data ['data'] ['supplier_id'] 
		) );
		// 线路名称
		if ($data ['data'] ['linenight'] == '' || $data ['data'] ['linenight'] == 0) {
			$data ['data'] ['linename'] = $data ['data'] ['lineprename'] . $data ['data'] ['lineday'] . '天游';
		} else {
			$data ['data'] ['linename'] = $data ['data'] ['lineprename'] . $data ['data'] ['linenight'] . '晚' . $data ['data'] ['lineday'] . '天游';
		}
		$data ['data'] ['brand'] = $supplierData [0] ['brand'];
		
		$data ['suits'] = $this->user_shop_model->getLineSuit ( $lineId );
		// 行程安排
		$data ['rout'] = $this->user_shop_model->getLineRout ( $lineId );
		foreach ( $data ['rout'] as $key => $val ) {
			foreach ( $val as $k => $v ) {
				if ($k == "pic") {
					if ($v) {
						$val [$k] = explode ( ";", $v );
						foreach ( $val [$k] as $k ) {
							if (! empty ( $k )) {
								$val ['pics'] [] = "http://" . $_SERVER ['HTTP_HOST'] . $k;
							}
						}
						$val ['pic'] = '1';
					}
				}
			}
			$data ['rout'] [$key] = $val;
		}
		
		// 线路图片
		$data ['imgurl'] = $this->user_shop_model->select_imgdata ( $lineId );
		// 交通方式
		$data ['transport'] = $this->user_shop_model->description_data ( 'DICT_TRANSPORT' );
		// 星际酒店概述
		$data ['hotel'] = $this->user_shop_model->description_data ( 'DICT_HOTEL_STAR' );
		// 是否是主题游
		$data ['themeid'] = '';
		if (! empty ( $data ['data'] ['themeid'] )) {
			$data ['themeid'] = $this->user_shop_model->get_user_shop_select ( 'u_theme', array (
					'id' => $data ['data'] ['themeid'] 
			) );
		}
		// 管家培训
		$data ['train'] = $this->user_shop_model->get_user_shop_select ( 'u_expert_train', array (
				'line_id' => $lineId,
				'status' => 1 
		) );
		// 礼品管理
		$data ['gift'] = $this->user_shop_model->get_gift_data ( $lineId );
		$this->__outmsg ( $data );
	}
	
	/**
	 * @name：117、查看线路
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function efgm_show_line_detail() {
		$this->load->model ( 'admin/b1/user_shop_model' ); // 线路详情页用到
		$lineId = intval ( $this->input->post ( 'id', true ) );
		is_numeric ( $lineId ) ? ($lineId) : $this->__errormsg ( 'null' );
// 		$token = $this->input->post ( 'number', true );
// 		$this->expert_check_token ( $token );
		$data ['data'] = $this->db->query ( " SELECT a.*,GROUP_CONCAT(`u`.`cityname`) AS cityname  FROM u_line as a   left join u_line_startplace as ls on a.id=ls.line_id  LEFT JOIN u_startplace as u  on ls.startplace_id=u.id    	WHERE a.id={$lineId} LIMIT 1 " )->row_array ();
		$this->load->model ( 'admin/a/lineattr_model', 'lineattr_model' );
		$this->load->model ( 'admin/a/destinations_model', 'destinations_model' );
		// $data['line_attr'] = $this->lineattr_model->getLineattrTreeDate();
		// $data['destinations'] = $this->destinations_model->getDestinationsTreeDate();
		// var_dump($data['data']);exit;
		$data ['overcity_arr'] = array ();
		if ("" != $data ['data'] ['overcity2']) {
			$data ['overcity_arr'] = $this->destinations_model->getDestinations ( explode ( ",", $data ['data'] ['overcity2'] ) );
		}
		$data ['line_attr_arr'] = array ();
		if ("" != $data ['data'] ['linetype']) {
			$data ['line_attr_arr'] = $this->lineattr_model->getLineattr ( explode ( ",", $data ['data'] ['linetype'] ) );
		}
		// 供应商信息
		$supplierData = $this->user_shop_model->get_user_shop_select ( 'u_supplier', array (
				'id' => $data ['data'] ['supplier_id'] 
		) );
		// 线路名称
		if ($data ['data'] ['linenight'] == '' || $data ['data'] ['linenight'] == 0) {
			$data ['data'] ['linename'] = $data ['data'] ['lineprename'] . $data ['data'] ['lineday'] . '天游';
		} else {
			$data ['data'] ['linename'] = $data ['data'] ['lineprename'] . $data ['data'] ['linenight'] . '晚' . $data ['data'] ['lineday'] . '天游';
		}
		$data ['data'] ['brand'] = $supplierData [0] ['brand'];
		$data ['suits'] = $this->user_shop_model->getLineSuit ( $lineId );
		// 行程安排
		$data ['rout'] = $this->user_shop_model->getLineRout ( $lineId );
		foreach ( $data ['rout'] as $key => $val ) {
			foreach ( $val as $k => $v ) {
				if ($k == "pic") {
					if ($v) {
						$val [$k] = explode ( ";", $v );
						foreach ( $val [$k] as $k ) {
							if (! empty ( $k )) {
								$val ['pics'] [] = "http://" . $_SERVER ['HTTP_HOST'] . $k;
							}
						}
						$val ['pic'] = '1';
					}
				}
			}
			$data ['rout'] [$key] = $val;
		}
		// 线路图片
		$data ['imgurl'] = $this->user_shop_model->select_imgdata ( $lineId );
		// 交通方式
		$data ['transport'] = $this->user_shop_model->description_data ( 'DICT_TRANSPORT' );
		// 星际酒店概述
		$data ['hotel'] = $this->user_shop_model->description_data ( 'DICT_HOTEL_STAR' );
		// 是否是主题游
		$data ['themeid'] = '';
		if (! empty ( $data ['data'] ['themeid'] )) {
			$data ['themeid'] = $this->user_shop_model->get_user_shop_select ( 'u_theme', array (
					'id' => $data ['data'] ['themeid'] 
			) );
		}
		// 管家培训
		$data ['train'] = $this->user_shop_model->get_user_shop_select ( 'u_expert_train', array (
				'line_id' => $lineId,
				'status' => 1 
		) );
		// 礼品管理
		$data ['gift'] = $this->user_shop_model->get_gift_data ( $lineId );
		
		$this->__outmsg ( $data );
	}
	
	/**
	 * @name：118、放弃
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function efgm_show_line_detail_status() {
		$line_id = $this->input->post ( 'line_id' );
		$token = $this->input->post ( 'number', true );
		$this->expert_check_token ( $token );
		$this->load->model ( 'common/u_expert_access_token_model', 'eat_model' );
		$result = $this->eat_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'eid' );
		$m_id = $result [0] ['eid'];
		$sql = "update u_line_apply set status=4 where line_id=$line_id and expert_id={$m_id}";
		if ($this->db->query ( $sql )) {
			echo json_encode ( array (
					'code' => 2000,
					'msg' => '操作成功' 
			) );
		} else {
			echo json_encode ( array (
					'code' => 4000,
					'msg' => '操作失败' 
			) );
		}
	}
	
	/**
	 * @name：119、管家申请线路
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function efgm_update_apply_line() {
		$this->load->model ( 'admin/b2/line_apply_model', 'line_apply' );
		$post_arr = array ();
		$line_id = $this->input->post ( 'apply_line_id' );
		$token = $this->input->post ( 'number', true );
		$this->expert_check_token ( $token );
		$this->load->model ( 'common/u_expert_access_token_model', 'eat_model' );
		$result = $this->eat_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'eid' );
		$m_id = $result [0] ['eid'];
		$insert_data ['line_id'] = $line_id;
		$insert_data ['expert_id'] = $m_id;
		$insert_data ['grade'] = 1;
		$insert_data ['addtime'] = date ( 'Y-m-d H:i:s' );
		$insert_data ['modtime'] = date ( 'Y-m-d H:i:s' );
		$insert_data ['status'] = 2;
		// 判断一下是否已经有了数据,不重复插入
		$post_arr ['line_id'] = $line_id;
		$post_arr ['expert_id'] = $m_id;
		$this->db->select ( 'count(*) as cunt' );
		$this->db->where ( $post_arr );
		$this->db->from ( 'u_line_apply' );
		$result = $this->db->get ()->result_array ();
		if ($result [0] ['cunt'] != 0) {
			$this->db->update ( 'u_line_apply', $insert_data, $post_arr );
			$this->line_apply->insert_expert_dest ( $line_id, $m_id );
		} else {
			$this->db->insert ( 'u_line_apply', $insert_data );
			$this->line_apply->insert_expert_dest ( $line_id, $m_id );
		}
		echo json_encode ( array (
				'status' => 2000,
				'msg' => '申请成功' 
		) );
	}
	
	/**
	 * @name：120、通过用户ID寻找优惠卷
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function mfgm_my_coupon() {
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$result = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$m_id = $result [0] ['mid'];
		$reDataArr ['new'] = $this->db->query ( "SELECT   cmc.id AS 'id',cmc.coupon_id as coupon_id,cmc.member_id as member_id,cmc.status as status,  cc.name as name,cc.pic as pic,cc.starttime as starttime,cc.endtime as endtime,cc.coupon_price as coupon_price,cc.use_url as use_url       FROM cou_member_coupon AS cmc LEFT JOIN cou_coupon AS cc ON cmc.coupon_id=cc.id    WHERE cmc.status>=0 and cc.status='1' and cmc.member_id={$m_id}  order by cmc.status,cmc.id desc " )->result_array (); // 未使用、已使用
		$reDataArr ['old'] = $this->db->query ( "SELECT     cmc.id AS 'id',cmc.coupon_id as coupon_id,cmc.member_id as member_id,cmc.status as status,  cc.name as name,cc.pic as pic,cc.starttime as starttime,cc.endtime as endtime,cc.coupon_price as coupon_price,cc.use_url as use_url       FROM cou_member_coupon AS cmc LEFT JOIN cou_coupon AS cc ON cmc.coupon_id=cc.id    WHERE cmc.status<0 and cc.status='1' and cmc.member_id={$m_id}  order by cmc.status,cmc.id desc " )->result_array (); // 已过期
		if (empty ( $reDataArr ['new'] ) && empty ( $reDataArr ['old'] )) {
			$this->__outmsg ( $reDataArr ['new'] );
		} else {
			$this->__outmsg ( $reDataArr );
		}
	}
	
	/**
	 * @name：121、我的礼品
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function mfgm_my_prize() {
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$result = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$m_id = $result [0] ['mid'];
		$reDataArr = $this->db->query ( "SELECT   lg.id AS 'id',lg.worth AS 'worth',lg.gift_name AS 'gift_name',lg.status as 'isnormal',  lg.starttime AS 'starttime',lg.endtime AS 'endtime',lgm.id as 'lgm_id',lgm.status AS 'isuse'      FROM luck_gift_member AS lgm LEFT JOIN luck_gift AS lg ON lgm.gift_id=lg.id       WHERE lgm.member_id={$m_id} order by lgm.status,lgm.addtime desc " )->result_array ();
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：122、我的礼品详情
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function mfgm_my_prize_detail() {
		$token = $this->input->post ( 'number', true );
		$lg_id = $this->input->post ( 'lg_id', true );
		is_numeric ( $lg_id ) ? ($lg_id) : $this->__errormsg ( 'err !' );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model', 'at_model' );
		$result = $this->at_model->result ( array (
				'access_token' => $token 
		), null, null, null, 'arr', null, 'mid' );
		$m_id = $result [0] ['mid'];
		$reDataArr ['deta'] = $this->db->query ( "SELECT     lg.id AS 'id',      lg.logo as 'pic',     lg.worth AS 'worth',     lg.gift_name AS 'gift_name',      lg.description AS 'description',      lg.starttime AS 'starttime',      lg.endtime AS 'endtime',      lgm. STATUS AS 'isuse',      CONCAT(s.company_name, s.brand) AS 'suppliername',      lg. STATUS AS 'isnormal'    FROM    luck_gift_member AS lgm    LEFT JOIN luck_gift AS lg ON lgm.gift_id = lg.id    LEFT JOIN u_supplier AS s ON lg.supplier_id = s.id   WHERE     lg.id = {$lg_id}    AND lgm.member_id ={$m_id} " )->result_array ();
		$reDataArr ['line'] = $this->db->query ( "SELECT     SELECT   l.id AS 'id',  l.linename AS 'linename',  l.mainpic AS 'mainpic'      FROM     u_line AS l      LEFT JOIN luck_gift_line AS lgl ON l.id = lgl.line_id       LEFT JOIN luck_gift AS lg ON lgl.gift_id = lg.id     LEFT JOIN u_supplier AS s ON lg.supplier_id = s.id      LEFT JOIN luck_gift_member AS lgm ON lg.id = lgm.gift_id    WHERE    lg.id = {$lg_id}   AND lgm.member_id = {$m_id}     AND l. STATUS = 2   AND lgl. STATUS = 1  " )->result_array ();
		
		if (empty ( $reDataArr ['deta'] ) && empty ( $reDataArr ['line'] )) {
			$this->__outmsg ( $reDataArr ['deta'] );
		} else {
			$this->__outmsg ( $reDataArr );
		}
	}
	
	/**
	 * @name：123、用于聊天api
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function efmg_expert_api(){
		$this->load->model ( "common/u_expert_model", 'expert_model' );
		$eid = $this->input->post ( 'eid', true );
		is_numeric ( $eid ) ? ($eid) : $this->__errormsg ( 'tip is null !' );
		$reDataArr = $this->expert_model->row ( array (	'id' => $eid	), $type = "arr", $gre = "ID DESC limit 1",$select="nickname,mobile,small_photo,online" );  
		$this->__outmsg ( $reDataArr );
	}
	
	/**
	 * @name：124、管家修改订单价格
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function efmg_update_order_price(){
		$token = $this->input->post ( 'number', true );			
		$this->expert_check_token ( $token );
		$this->load->model ( 'common/u_expert_access_token_model','eat_model');
		$result = $this->eat_model->result ( array('access_token' => $token),null,null,null,'arr',null,'eid' );
		$m_id = $result[0]['eid'];
		$content= $this->input->post ( 'content', true );		//理由
		$bfprice = $this->input->post ( 'bfprice', true );		//之前价格
		$price = $this->input->post ( 'price', true );				//修改价格
		$orderid= $this->input->post ( 'orderid', true );			//订单号
		if(empty($content))												{	$this->__errormsg ( "请填写修改价位理由！");	}
		if(mb_strlen($content,'utf8')<3)							{	$this->__errormsg ( "理由太短了！");				}
		if(mb_strlen($content,'utf8')>60)							{	$this->__errormsg ( "理由长度超过限制！");		}
		is_numeric($bfprice)? ($bfprice):$this->__errormsg 						('请填写价位！');
		is_numeric($price)? ($price):$this->__errormsg 							('请填写修改价位！');
		is_numeric($orderid)? ($orderid):$this->__errormsg 					('请填写订单号！');
		$data = array (
				'order_id' => $orderid,
				'expert_id' => $m_id,
				'before_price'=>$bfprice,
				'after_price' => $price,
				'addtime' =>   date('Y-m-d H:i:s' ,time()),
				'modtime' =>date('Y-m-d H:i:s' ,time()),
				'status' => '0' ,
				'expert_reason' =>	$content
		);
		$this->db->insert('u_order_price_apply',$data);
		$or_id = $this->db->insert_id ();
		if($or_id){
			$this->load->model ( 'common/u_expert_model','expert_model' );
			$result_user = $this->expert_model->row ( array(
					'id' => $m_id
			) );
			$datas = array(
					'order_id' => $orderid,
					'op_type' => 1,
					'userid' => $m_id,
					'content' => '管家' . $result_user['nickname'] . '修改了订单价格,由' . $bfprice . '元修改为' . $price . '元,修改原因:' . $content ,
					'addtime' => date ( 'Y-m-d H:i:s' )
			);
			$this->db->insert ( 'u_member_order_log', $datas );
			echo json_encode(array('code'=>2000 ,'msg' =>'修改价格已提交，等待平台处理！'));
		}else{
			$this->__errormsg 					('修改价格提交失败！');
		}
	}
	
	
	
/**
 ***********************************      公共函数         *********************************************************/
     public function ____________________________common()
     {
     	
     }
	/**
	 * @name：公共函数：发邮箱
	 * @author: 温文斌
	 * @param: 
	 * @return:
	 *
	 */
	
	public function sendEmailCode() {
		$this->load->library ( 'session', true );
		$email = $this->input->post ( 'email', true ); // 手机号
		$type = $this->input->post ( 'type', true ); // 用于区分发送哪种短信
		$time = time ();
		// 判断是否一分钟内已发送过
		$email_code = $this->session->userdata ( 'email_code' );
		if (! empty ( $email_code )) {
			$endtime = $time - $email_code ['time'];
			if ($endtime < 60) {
				$this->__errormsg ( "请您一分钟后再获取验证码" );
			}
		}
		$this->load->helper ( 'regexp' );
		if (! regexp ( 'email', $email )) {
			$this->__errormsg ( "请输入正确的邮箱号" );
		}
		// 生成验证码
		$code = mt_rand ( 1000, 9999 );
		$this->load->model ( 'sms_template_model', 'sms_model' );
		switch ($type) {
			case 1 : // 管家注册
			        // 判断手机号是否存在
				$this->load->model ( "common/u_expert_model", 'expert_model' );
				$sql = "select mobile,id,status from u_expert where email='{$email}' and status !=3 order by id desc";
				$expertData = $this->db->query ( $sql )->result_array ();
				if (! empty ( $expertData )) {
					switch ($expertData [0] ['status']) {
						case 1 :
							$this->__errormsg ( "该邮箱正在审核中，请耐心等待！" );
							break;
						case 2 :
							$this->__errormsg ( "该邮箱邮箱已存在，请不要重复注册" );
							break;
						case - 1 :
							$this->__errormsg ( "该邮箱已被平台终止，请联系客服" );
							break;
						default :
							$this->__errormsg ( "邮箱已存在" );
							break;
					}
				}
				$template = $this->sms_model->row ( array (
						'msgtype' => sys_constant::expert_register_msg 
				) );
				// 将验证码放入模板中
				$content = str_replace ( "{#CODE#}", $code, $template ['msg'] );
				break;
			case 2 : // 修改管家
			        // 判断手机号是否存在
				$this->load_model ( "common/u_expert_model", 'expert_model' );
				$sql = "select mobile,id,status from u_expert where email='{$email}' and status !=3 order by id desc";
				$expertData = $this->db->query ( $sql )->result_array ();
				if (! empty ( $expertData )) {
					switch ($expertData [0] ['status']) {
						case 1 :
							$this->__errormsg ( "此邮箱正在审核中，请耐心等待" );
							break;
						case 2 :
							$this->__errormsg ( "邮箱已存在" );
							break;
						case - 1 :
							$this->__errormsg ( "您的邮箱已被平台终止，请联系客服" );
							break;
						default :
							$this->__errormsg ( "邮箱已存在" );
							break;
					}
				}
				$template = $this->sms_model->row ( array (
						'msgtype' => sys_constant::expert_update 
				) );
				// 将验证码放入模板中
				$content = str_replace ( "{#CODE#}", $code, $template ['msg'] );
				break;
			default :
				$this->__errormsg ( "请确认发送类型" );
				break;
		}
		// 保存到session
		$this->load->library ( 'session' );
		$data = array (
				'code' => $code,
				'email' => $email,
				'time' => $time 
		);
		
		// 发送邮件
		$this->load->library ( 'mailer' );
		$status = $this->mailer->sendmail ( $email, '深圳市海外国际旅行社', '深圳市海外国际旅行社', $content );
		// 保存入session
		if (! empty ( $status )) {
			$this->session->set_userdata ( array (
					'email_code' => $data 
			) );
		}
		
		echo json_encode ( array (
				'code' => 2000,
				'msg' => '发送成功',
				'status'=>$status,
				'result' => md5 ( $code )
		) ); // 返回加密的验证码
	}
	
	/**
	 * @name：公共函数：发短信
	 * @author: 温文斌
	 * @param: 
	 * @return:
	 *
	 */
	
	public function send_mobile() {
		$this->load->library ( 'session', true );
		$mobile = $this->input->post ( 'mobile', true );
		$type = intval ( $this->input->post ( 'type', true ) ); // 短信模板标识码
		$usertype = intval ( $this->input->post ( 'msgtype', true ) ); // 短信模板标识码
		$code_time = $this->session->userdata ( 'time' ); // 发送时间
		
		try {
			$time = time ();
			// 判断是否一分钟内已发送过
			if (! empty ( $code_time )) {
				$endtime = $time - $code_time;
				if ($endtime < 60) {
					$this->__errormsg ( '60秒之后再发送' );
				}
			}
			// 验证手机是否为空
			if (empty ( $mobile )) {
				$this->__errormsg ( '手机号码不能为空' );
			}
			// 验证手机号
			$this->load->helper ( 'regexp' );
			if (! regexp ( 'mobile', $mobile )) {
				$this->__errormsg ( '手机号码输入有误' );
			}
			switch ($type) {
				case 1 : // 会员注册
					$msgtype = 'reg_msgcode';
					// 验证手机号是否存在
					if ($usertype == '1') {
						$this->load->model ( 'common/u_expert_model', 'expert_model' );
						$result_user = $this->expert_model->row ( array (
								'mobile' => $mobile 
						) );
						if (! empty ( $result_user )) {	$this->__errormsg ( '管家手机号已存在' );			}
					} else {
						$this->load->model ( 'common/u_member_model', 'member_model' );
						$member = $this->member_model->row ( array (
								'mobile' => $mobile 
						) );
						if (! empty ( $member )) 					{		$this->__errormsg ( '手机号已被注册' );		}
					}

					break;
				case 2 : // 找回密码
					$msgtype = 'reg_findpwd';
					// 验证管家手机号是否存在
					if ($usertype == '2') {
						$this->load->model ( 'common/u_expert_model', 'expert_model' );
						$result_user = $this->expert_model->row ( array (
								'mobile' => $mobile 
						) );
						if (empty ( $result_user )) 				{		$this->__errormsg ( '管家手机号未注册' );		}
						// 验证用户手机号是否存在
					} elseif ($usertype == '1') {
						$this->load->model ( 'common/u_member_model', 'member_model' );
						$member = $this->member_model->row ( array (
								'mobile' => $mobile 
						) );
						if (empty ( $member )) 					{		$this->__errormsg ( '用户手机号未注册' );		}
					}

					break;
				case 3 : // 下单
					$msgtype = 'submit_order_msg';
					break;
				case 4 : // 管家注册
					$msgtype = 'expert_register_msg';
					// 验证手机号状态
					if ($usertype == '1') {
						$result_user = $this->db->query ( "select  status  from u_expert  where mobile={$mobile} and status !=3 ORDER BY `id` desc " )->result_array ();
						if (! empty ( $result_user [0] ['status'] )) {
							if ($result_user [0] ['status'] == 1) {
								$this->__errormsg ( '该手机号正在审核中，请耐心等待！' );
							} elseif ($result_user [0] ['status'] == 2) {
								$this->__errormsg ( '手机号已存在！' );
							} elseif ($result_user [0] ['status'] == - 1) {
								$this->__errormsg ( '该手机号已经被终止合作，请联系系统管理员 ！' );
							}/*elseif ($result_user [0] ['status'] == 3) {
								$this->__errormsg ( '该手机号审核被拒绝，请联系系统管理员 ！' );
							}*/
						} else {
							true;
						}
					}
					break;
				case 5 : // 定制 下单
					$msgtype = 'custom_msgcode';
					break;
				default :
					$this->__errormsg ( 'is null' );
					break;
			}
			// 生成验证码
			$code = mt_rand ( 1000, 9999 );
			// 读取短信模板
			$this->load->model ( 'sms_template_model', 'sms_model' );
			$template = $this->sms_model->row ( array (
					'msgtype' => $msgtype 
			) );
			// 将验证码放入模板中
			$content = str_replace ( "{#CODE#}", $code, $template ['msg'] );
			
			$status=$this->send_message($mobile, $content); //发送短信
			
			$data = array (
					0 => array (
							'mobile' => $mobile,
							'status'=>$status
					) 
			);
			$this->session->set_userdata ( array (
					'code' => $code,
					'mobile' => $mobile,
					'time' => $time 
			) );
			$this->result_msg = '发送成功';
			$this->result_code = "2000";
			$lastData ['rows'] = array ();
			$lastData ['rows'] = $data;
			$this->result_data = $lastData;
		} catch ( Exception $e ) {
			$this->result_msg = $e->postMessage ();
			$this->result_code = "4000";
		}
		$this->resultJSON = json_encode ( array (
				"msg" => $this->result_msg,
				"code" => $this->result_code,
				"data" => $this->result_data,
				'result' => md5 ( $code ), // 返回加密的验证码
				"total" => 0 
		) );
		echo $this->resultJSON;
		exit ();
	}
	
	/**
	 * @name：公共函数：短信内部掉用
	 * @author: 温文斌
	 * @param: 
	 * @return:
	 *
	 */
	
	public function Inside_page_message($mobile, $content) {
		if (empty ( $mobile ) || empty ( $content )) {
			return false;
		}
		$post_data = array ();
		$post_data ['account'] = iconv ( 'GB2312', 'GB2312', "hwgj_vip" );
		$post_data ['pswd'] = iconv ( 'GB2312', 'GB2312', "Hwgj16888" );
		$post_data ['mobile'] = $mobile;
		$post_data ['msg'] = mb_convert_encoding ( $content, 'UTF-8', 'auto' );
		$url = 'http://222.73.117.158/msg/HttpBatchSendSM?';
		// $url='http://115.182.84.226/msg/HttpBatchSendSM?';
		$o = "";
		foreach ( $post_data as $k => $v ) {
			$o .= "$k=" . urlencode ( $v ) . "&";
		}
		$post_data = substr ( $o, 0, - 1 );
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		$result = curl_exec ( $ch );
		if (! empty ( $result )) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * @name：公共函数：一对一消息写入 content 消息内容 $msg_type 接收人实体类型 （0:用户,1:B2,2:B1） $receipt_id 接收人ID $title 消息标题
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function add_message($content, $msg_type, $receipt_id, $title = '') {
		$time = date ( 'Y-m-d H:i:s', time () );
		if (empty ( $title )) {
			$title = mb_substr ( $content, 0, 20 );
		}
		$data = array (
				'title' => $title,
				'content' => $content,
				'addtime' => $time,
				'msg_type' => $msg_type,
				'receipt_id' => $receipt_id,
				'read' => 0,
				'modtime' => $time 
		);
		$status = $this->db->insert ( 'u_message', $data );
		if (! empty ( $status )) {
			return $this->db->insert_id ();
		} else {
			return false;
		}
	}
	
	/**
	 * @name：公共函数：验证管家手机是否唯一
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function efmg_unique_field($where) {
		$this->db->select ( 'id' );
		$this->db->from ( 'u_expert' );
		$this->db->where ( $where );
		$this->db->where ( '(status = 1 or status=2 or status=-1)' );
		$query = $this->db->get ();
		$data = $query->result_array ();
		if (empty ( $data )) {
			return true; // 其值不存在
		} else {
			return false; // 其值存在
		}
	}
	
	/**
	 * @name：公共函数：公共上传
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	function upload_pic_test() {
		$page = $this->input->post ( 'page', true );
		if ($page == 1) {
			
			$path = "../bangu/file/c/img/";
			$input_name = "icon_photo";
			$photo = $this->cfgm_upload_pimg ( $path, $input_name );
			if (is_array ( $photo )) {
				$this->__errormsg ( "仅仅只要一张就可以了哦。" );
			}
			
			$return_path="/file/c/img/";
			$kk = $return_path . $photo;
			echo json_encode ( array (
					'code' => 2000,
					'msg' => $kk 
			) );
			
		} elseif ($page == 2) {
			$path = "../bangu/file/c/img/";
			$input_name = "idcardpic";
			$photo = $this->cfgm_upload_pimg ( $path, $input_name );
			if (is_array ( $photo )) {
				$this->__errormsg ( "仅仅只要一张就可以了哦。" );
			}
			$return_path="/file/c/img/";
			$kk = $return_path . $photo;
			echo json_encode ( array (
					'code' => 2000,
					'msg' => $kk 
			) );
			
		} elseif ($page == 3) {
			$path = "../bangu/file/c/img/";
			$input_name = "certificatepic";
			$photo = $this->cfgm_upload_pimg ( $path, $input_name );
			$return_path="/file/c/img/";
			$kk = $return_path . $photo;
			echo json_encode ( array (
					'code' => 2000,
					'msg' => $kk 
			) );
		}
		else {
			echo json_encode ( array (
					'code' => 4000,
					'msg' => '  don`t this !' 
			) );
		}
	}
	
	/**
	 * @name：公共函数： 二维码上传以及生成
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	function get_qrcodes($id) {
		$this->load->library ( 'ciqrcode' );
		$params ['data'] = base_url () . 'admin/b2/register/upExpertMuseum?id=' . $id;
		$params ['level'] = 'H';
		$params ['size'] = 12;
		$params ['savename'] = FCPATH . 'file/qrcodes/guanjiaid_' . $id . '.png';
		$this->ciqrcode->generate ( $params );
		$logo = FCPATH . 'file/qrcodes/logo.png'; // 准备好的logo图片
		$QR = base_url () . 'file/qrcodes/guanjiaid_' . $id . '.png'; // 已经生成的原始二维码图
		if ($logo !== FALSE) {
			$QR = imagecreatefromstring ( file_get_contents ( $QR ) );
			$logo = imagecreatefromstring ( file_get_contents ( $logo ) );
			$QR_width = imagesx ( $QR ); // 二维码图片宽度
			$QR_height = imagesy ( $QR ); // 二维码图片高度
			$logo_width = imagesx ( $logo ); // logo图片宽度
			$logo_height = imagesy ( $logo ); // logo图片高度
			$logo_qr_width = $QR_width / 5; //
			$scale = $logo_width / $logo_qr_width;
			$logo_qr_height = $logo_height / $scale; //
			$from_width = ($QR_width - $logo_qr_width) / 2;
			// 重新组合图片并调整大小
			imagecopyresampled ( $QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height );
		}
		imagepng ( $QR, FCPATH . 'file/qrcodes/' . $id . '_qr.png' );
	}
	
	/**
	 * @name：公共函数：去重二维数组
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	function unique_arr($arr, $key) {
		$tmp_arr = array ();
		foreach ( $arr as $k => $v ) {
			if (in_array ( $v [$key], $tmp_arr )) {
				unset ( $arr [$k] );
			} else {
				$tmp_arr [] = $v [$key];
			}
		}
		sort ( $arr );
		return $arr;
	}
	
	/**
	 * @name：公共函数：验证token
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function check_token($token) {
		$this->load->library ( 'token' );
		$result = $this->token->isValidToken ( $token );
		if (! $result) {
			$this->result_code = "-1";
			$this->result_msg = "token exceed the time limit";
			$lastData ['rows'] = "";
			$this->result_data = $lastData;
			$this->resultJSON = json_encode ( array (
					"msg" => $this->result_msg,
					"code" => $this->result_code,
					"data" => $this->result_data,
					"total" => "0"
			) );
			echo $this->resultJSON;
			exit ();
		}
	}
	
	/**
	 * @name：公共函数：验证token
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function expert_check_token($token) {
		$this->load->library ( 'token' );
		$result = $this->token->expert_isValidToken ( $token );
		
		if (! $result) {
			$this->result_code = "-1";
			$this->result_msg = "token exceed the time limit";
			$lastData ['rows'] = "";
			$this->result_data = $lastData;
			$this->resultJSON = json_encode ( array (
					"msg" => $this->result_msg,
					"code" => $this->result_code,
					"data" => $this->result_data,
					"total" => "0"
			) );
			
			echo $this->resultJSON;
			exit ();
		}
	}
	
	/**
	 * @name：公共函数：发票
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */

	public function orderInvoice($fapiao, $userid, $order_id) {
		$invoice_name = trim ( $this->input->post ( 'cdname', true ) ); // 发票抬头
		$invoice_detail = trim ( $this->input->post ( 'ticketype', true ) ); // 发票类型
		$receiver = trim ( $this->input->post ( 'toname', true ) ); // 收件人
		$telephone = trim ( $this->input->post ( 'mobile', true ) ); // 手机号
		$city = trim ( $this->input->post ( 'cityval' ) ); // 省市区
		$address = trim ( $this->input->post ( 'citypid', true ) ); // 详细地址
		if (empty ( $invoice_name )) {
			$this->__errormsg ( '请填写发票抬头' );
		}
		if (empty ( $invoice_detail )) {
			$this->__errormsg ( '请填写发票类型' );
		}
		if (empty ( $receiver )) {
			$this->__errormsg ( '请填写收件人' );
		}
		if (empty ( $telephone )) {
			$this->__errormsg ( '请填写手机号' );
		}
		if (empty ( $city )) {
			$this->__errormsg ( '请填写省市区' );
		}
		if (empty ( $address )) {
			$this->__errormsg ( '请填写填写详细地址' );
		}
		$time = date ( 'Y-m-d H:i:s', time () );
		$invoiceArr = array (
				'invoice_name' => $invoice_name,
				'invoice_detail' => $invoice_detail,
				'receiver' => $receiver,
				'telephone' => $telephone,
				'address' => $city . $address,
				'member_id' => $userid,
				'modtime' => $time 
		);
		$this->load->model ( 'common/u_member_order_invoice_model', 'order_invoice_model' );
		$this->load->model ( 'common/u_member_invoice_model', 'invoice_model' );
		$invoiceData = $this->order_invoice_model->row ( array (
				'order_id' => $order_id 
		) );
		if (empty ( $invoiceData )) {
			$invoiceArr ['addtime'] = $time;
			$invoiceId = $this->invoice_model->insert ( $invoiceArr );
			if (empty ( $invoiceId )) {
				$this->__errormsg ( '系统繁忙，稍后重试' );
			} else {
				$oiArr = array (
						'order_id' => $order_id,
						'invoice_id' => $invoiceId 
				);
				$this->order_invoice_model->insert ( $oiArr );
			}
		} else {
			$status = $this->invoice_model->update ( $invoiceArr, array (
					'id' => $invoiceData ['invoice_id'] 
			) );
			if (empty ( $status )) {
				$this->__errormsg ( '系统繁忙，稍后重试' );
			}
		}
	}
	
	/**
	 * @name：公共函数：公用用户优惠卷查询
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function member_coupon($type, $mid) {
		$this->load->model ( 'common/cou_action_model', 'cou_action_model' );
		$this->load->model ( 'common/cou_member_action_model', 'member_action_model' );
		switch ($type) {
			case 1 : // 会员注册
				$code = 'REGISTER';
				break;
		}
		$couActionData = $this->cou_action_model->getCouActionCode ( $code );
		if (empty ( $couActionData )) {
			return 1; // 会员的当前操作没有可参与项目
		}
		
		if ($couActionData [0] ['isrepeat'] == 0) // 不可以重复参与
{
			$memberActionData = $this->member_action_model->all ( array (
					'member_id' => $mid,
					'action_id' => $couActionData [0] ['id'] 
			) );
			if (! empty ( $memberActionData )) {
				return 2; // 用户已参与过此项目
			}
		}
		
		// 获取当前项目关联的优惠券
		$actionCouponData = $this->cou_action_model->getActionCoupon ( $couActionData [0] ['id'] );
		if (empty ( $actionCouponData )) {
			return 3; // 没有优惠券
		}
		// 验证优惠券数量是否足够
		foreach ( $actionCouponData as $key => $val ) {
			if ($val ['couponNumber'] < $val ['cacNumber'] || $val ['cacNumber'] == 0) {
				unset ( $actionCouponData [$key] ); // 优惠券数量不足 or 赠送数量为0, 则不与赠送
			}
		}
		if (count ( $actionCouponData ) == 0) {
			return 3;
		}
		return $this->cou_action_model->changeMemberCoupon ( $mid, $actionCouponData );
	}
	/**
	 * @name：公共函数：上传图片
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function cfgm_upload_pimg($path, $input_name) {
		if (! file_exists ( $path )) {
			mkdir($path ,0777 ,true);
		}
		foreach ( $_FILES [$input_name] as $key => $val ) {
			if ($key == "name") {
				if (is_array ( $val )) {
					foreach ( $val as $k => $v ) {
						$ext [$k] = pathinfo ( $v, PATHINFO_EXTENSION );
						if (! in_array ( strtolower ( $ext [$k] ), array (
								'jpg',
								'gif',
								'png',
								'jpeg'
						) )) {
							$this->__errormsg ( 'ext is error' );
						}
						$file = time () . mt_rand ( 0, 9999 ) . "." . $ext [$k];
						$file_path [$k] = $path . $file;
					}
				} else {
					$ext = pathinfo ( $_FILES [$input_name] ['name'], PATHINFO_EXTENSION );
					$file = time () . mt_rand ( 0, 9999 ) . "." . $ext;
					$file_path = $path . $file;
				}
			}
			if ($key == "tmp_name") {
				if (is_array ( $val )) {
					foreach ( $val as $k => $v ) {
						if (! move_uploaded_file ( $v, $file_path [$k] )) {
							$error_msg = "from " . $k . " is failed";
							$this->__errormsg ( $error_msg );
						}
					}
				} else {
					if (! move_uploaded_file ( $_FILES [$input_name] ['tmp_name'], $file_path )) {
						$error_msg = "upload failed";
						$this->__errormsg ( $error_msg );
					}
				}
			}
		}
		// 返回新图片的名称
		return $file;
	}
	
	/**
	 * @name：受保护函数：获取真实IP
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	protected function get_client_ip() {
		if (getenv ( 'HTTP_CLIENT_IP' )) {
			
			$ip = getenv ( 'HTTP_CLIENT_IP' );
			
		} elseif (getenv ( 'HTTP_X_FORWARDED_FOR' )) {
			
			$ip = getenv ( 'HTTP_X_FORWARDED_FOR' );
			
		} elseif (getenv ( 'HTTP_X_FORWARDED' )) {
			
			$ip = getenv ( 'HTTP_X_FORWARDED' );
			
		} elseif (getenv ( 'HTTP_FORWARDED_FOR' )) {
			
			$ip = getenv ( 'HTTP_FORWARDED_FOR' );
			
		} elseif (getenv ( 'HTTP_FORWARDED' )) {
			
			$ip = getenv ( 'HTTP_FORWARDED' );
			
		} else {
			
			$ip = $_SERVER ['REMOTE_ADDR'];
			
		}
		return $ip;
	}
	
	/**
	 * @name：私有函数：图片格式
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	private function image_resize($path, $img, $maxW, $maxH) {
		$info = getimagesize ( $img );
		$w = $info [0];
		$h = $info [1];
		switch ($info [2]) { // 获取图片类型，并为此创建对应图片资源
			case 1 :
				$src = imagecreatefromgif ( $img );
				break;
			case 2 :
				$src = imagecreatefromjpeg ( $img );
				break;
			case 3 :
				$src = imagecreatefrompng ( $img );
				break;
			default :
				die ( "图片类型错误" );
		}
		// 创建新的图片资源
		$dest = imagecreatetruecolor ( $maxW, $maxH );
		// 重采样拷贝部分图像并调整大小 调整图片清晰度
		imagecopyresampled ( $dest, $src, 0, 0, 0, 0, $maxW, $maxH, $w, $h );
		// 根据源图片 生成新的图片
		$new = pathinfo ( $img );
		switch ($info [2]) {
			case 1 :
				imagegif ( $dest, $path . $new ['basename'] );
				break;
			case 2 :
				imagejpeg ( $dest, $path . $new ['basename'] );
				break;
			case 3 :
				imagepng ( $dest, $path . $new ['basename'] );
				break;
		}
		imagedestroy ( $src );
		imagedestroy ( $dest );
		return $new ['basename'];
	}
	/**
	 * @name：服务器ip判断：若ip是内网202或者外网,则返回true
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	private function serverIP() {
		if(in_array(gethostbyname($_SERVER["SERVER_NAME"]),array('192.168.10.202','120.25.217.197')))
			return true;
	}
	/**
	 * @name：私有函数：定义数据接口结束，后面为必要输出函数。
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	private function __dealData($lastData, $i = 0, $path = '') {
		if (! isset ( $k )) {
			$k = 0;
		}
		$arr = array (
				'small_photo',
				'big_photo',
				'mainpic',
				'litpic',
				'pic',
				'filepath',
				'tys_photo',
				'productpic',
				'cover_pic',
				'idcardpic',
				'chi_pic',
				'zhu_pic',
				'xing_pic',
				'idcardconpic',
				'certificatepic',
				'gou_pic' 
		);
		if (is_array ( $lastData ) && $lastData) {
			foreach ( $lastData as $key => $val ) {
				if ($i == 0) {
					$path = "";
				}
				if ($val) {
					if (is_array ( $val )) {
						if (! is_numeric ( $key ) && in_array ( $key, array_values ( $arr ) )) {
							if($this->serverIP())
							{
							$path = "http://" . $_SERVER ['HTTP_HOST'];
							}
							else 
							{
							$path="http://192.168.10.202";
							}
						}
						
						$lastData [$key] = $this->__dealData ( $val, 1, $path );
					} else {
						if (! is_numeric ( $key ) && in_array ( $key, array_values ( $arr ) )) {
						    if($this->serverIP())
							 {
							  $path = "http://" . $_SERVER ['HTTP_HOST'];
							 }
							else 
							 {
							   $path="http://192.168.10.202";
							 }
							$i = 0;
						} else {
							$path = "";
						}
						if ($path) {
							$k ++;
						}
						if ($k == count ( $lastData )) {
							$i = 0;
						}
						
						$lastData [$key] = $path . htmlspecialchars ( $val );
					}
				}
			}
		}
		return $lastData;
	}
	
	/**
	 * @name：私有函数：输出数据,$len是长度
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function __outmsg($reDataArr, $len = 0) {
		$lastData ['rows'] = "";
		if (sizeof ( $reDataArr ) == 0) {
			$this->result_code = "4001";
			$this->result_msg = "data empty";
		} else {
			$this->result_code = "2000";
			$this->result_msg = "success";
		}
		if (! empty ( $reDataArr )) {
			$reDataArr = strip_slashes ( $reDataArr );
			$lastData ['rows'] = $this->__dealData ( $reDataArr );
		}
		if (! $len) {
			$len = sizeof ( $reDataArr );
		}
		$this->result_data = $lastData;
		$this->resultJSON = json_encode ( array (
				"msg" => $this->result_msg,
				"code" => $this->result_code,
				"data" => $this->result_data,
				"total" => $len 
		), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
		echo $this->resultJSON;
		exit ();
	}
	
	/**
	 * @name：私有函数：错误输出，已-3为标志
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	private function __errormsg($msg = "", $code = "-3") {
		$this->result_code = $code;
		if ($msg == "") {
			//$this->result_msg = "data not exist or error";
		} else {
			$this->result_msg = $msg;
		}
		$lastData ['rows'] = "";
		$this->result_data = $lastData;
		$this->resultJSON = json_encode ( array (
				"msg" => $this->result_msg,
				"code" => $this->result_code,
				"data" => $this->result_data,
				"total" => "0" 
		) );
		echo $this->resultJSON;
		exit ();
	}
	
	/**
	 * @name：私有函数：成功输出信息，较少使用
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	private function __successmsg($data = "") {
		$this->result_code = "1";
		$this->result_msg = "success";
		$lastData ['rows'] = $data;
		$this->result_data = $lastData;
		$this->resultJSON = json_encode ( array (
				"msg" => $this->result_msg,
				"code" => $this->result_code,
				"data" => $this->result_data,
				"total" => "0" 
		) );
		echo $this->resultJSON;
		exit ();
	}
	
}

/* End of file webservices.php */
/* Location: ./application/controllers/webservices.php */