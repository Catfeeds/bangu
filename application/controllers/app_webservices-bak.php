<?php
/*
*
*        do     Interface
*
*        by     zhy
*
*       输出方法为       __outmsg() 
*       数据输出模式为$reDataArr || outmsg 可携带总条数    为确保格式正常，不做统一要求
*       图勿自处理，经过__outmsg时
*       public  下公用，勿多开
*       点赞，取消，收藏，json_encode  2000为成功，json_encode  4000为失败，个别例外
*       token            check_token         expert_check_token
*       efmg        管家接口前缀
*       cfmg        用户接口前缀
*       
*        at     2016年3月8日 17:12:11
*
*/  
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class App_webservices extends CI_Controller {
	public function __construct() {
		          parent::__construct ();
		                  date_default_timezone_set ( 'Asia/Shanghai' );
	                      header ( "content-type:text/html;charset=utf-8" );
		                  $this->db = $this->load->database ( "default", TRUE );
		                  $this->load->helper ( "string" );
		                  header ( 'Content-type: application/json;charset=utf-8' );
		                  echo header ( 'Access-Control-Allow-Origin: *' );
	           }

 /**
  * app首页：温文斌
  * 传入参数： @token
  * 输出模块包含：  
  *         roll_pic  导航图
  *         expert    管家
  *         dest      目的地(又分为：境外、国内、周边)
  *         line      热销线路(又分为：境外、国内、周边)      
  * */
	     public function cfgm_home()
	     {
	     	$reDataArr=array();
	     	$roll_pic_sql = "select id,name,pic,showorder from cfgm_index_roll_pic where is_show=1 order by showorder";
	     	$reDataArr['roll_pic']= $this->db->query($roll_pic_sql)->result_array();
	     	$this->db->select ( "e.id AS eid,e.talk,e.big_photo,e.small_photo,e.realname,a.name,e.credit,e.avg_score,(CASE WHEN grade=1 THEN '管家' WHEN grade=2 THEN '初级' WHEN grade=3 THEN '中级' WHEN grade=4 THEN '高级' END) AS grade" );
	     	$this->db->from ( "cfgm_hot_expert AS cfg" );
	     	$this->db->join ( "u_expert AS e", "cfg.expert_id=e.id", "left" );
	     	$this->db->join ( "u_area AS a", "e.city=a.id", "left" );
	     	$this->db->where ( array(			     'cfg.is_show' => 1,			      'e.status' => 2 	   ) );
	     	$this->db->limit ( 21, 0 ); // 21 row
	     	$this->db->order_by ( "cfg.showorder", "asc" );
	     	$query = $this->db->get ();
	     	$reDataArr['expert']=$query->result_array ();
	     	$dest_sql="select cd.dest_id as id,cd.dest_type,cd.name as linename,cd.pic as pic,cd.linenum as linenum,(select count(1) from u_line as l where l.status='2' and FIND_IN_SET(cd.dest_id,l.overcity)>0) as num,    ud.kindname,ud.description as description  		from cfgm_hot_dest as cd  		left join u_destinations as ud on ud.id=cd.dest_id 	left join cfg_index_kind as cik on cik.id=cd.dest_type 		where cd.is_show='1'";
	     	$jw_dest_sql=$dest_sql." and cd.dest_type=1 limit 3";
	     	$gn_dest_sql=$dest_sql." and cd.dest_type=2 limit 3";
	     	$zb_dest_sql=$dest_sql." and cd.dest_type=3 limit 3";
	     	$reDataArr['dest']['jw'] = $this->db->query($jw_dest_sql)->result_array();
	     	$reDataArr['dest']['gn'] = $this->db->query($gn_dest_sql)->result_array();
	     	$reDataArr['dest']['zb'] =  $this->db->query($zb_dest_sql)->result_array();
	     	$time=date("Y-m-d");     //依据现阶段时间迭代
	     	$line_sql = "SELECT cx.line_id as id,cx.dest_type,cx.pic as pic,l.linetitle as linetitle,l.linename as linename,l.satisfyscore,l.bookcount,l.peoplecount,l.comment_count,l.lineprice     	FROM  	cfgm_hot_line AS cx LEFT JOIN u_line AS l ON cx.line_id=l.id     	left join cfg_index_kind as cik on cik.id=cx.dest_type  	where l.status='2' and cx.starttime<='{$time}' and cx.endtime>='{$time}'";
	     	$jw_line_sql=$line_sql." and cx.dest_type=1 order by cx.showorder limit 3";
	     	$gn_line_sql=$line_sql." and cx.dest_type=2 order by cx.showorder limit 3";
	     	$zb_line_sql=$line_sql." and cx.dest_type=3 order by cx.showorder limit 3";
	     	$reDataArr['line']['jw'] = $this->db->query($jw_line_sql)->result_array();
	     	$reDataArr['line']['gn'] = $this->db->query($gn_line_sql)->result_array();
	     	$reDataArr['line']['zb'] = $this->db->query($zb_line_sql)->result_array();
	     	//  if need to this plase take on 
// 	        $this->output->cache(5);
	        $this->__outmsg($reDataArr);
	     }
	           
/*
*
*        do     find    expert      寻找管家
*
*        by     zhy
*
*        at
*
*/
public function cfgm_find_expert() {
		$num = $this->input->post ("num");
		$where = " where e.status=2 ";
		$order_by = "";
		$sub_where = "";
		$label_where = "";
		$city_name = $this->input->post ( 'cityname', true );
	  if (preg_match('/^[\x{4e00}-\x{9fa5}]+$/u',$city_name)) {
		if ($city_name) {
			$sql = "select id from u_area where name like '%{$city_name}%'";
			$query = $this->db->query ( $sql );
			$result = $query->result_array ();
			if ($result) {
				$city_id = $result[0]['id'];
			} else { // 城市 不存在
				$this->__errormsg ('未查找到城市');
			}
		}}else{
		    $this->__errormsg ('城市输入有误!');
		}
		$qy_id = $this->input->post ( 'qy_id', true );
		$e_grade = $this->input->post ( 'e_grade', true );
		$sex = $this->input->post ( 'sex', true );
		$dest_id = $this->input->post ( 'dest_id', true ); // 多选
		$order = $this->input->post ( 'sort', true );
		$label = $this->input->post ( 'label', true ); // 多选
		$page = $this->input->post ( 'page', true );
		$page_size = $this->input->post ( 'pagesize', true );
		$page_size = empty ( $page_size ) ? 5 : $page_size;
		$page = empty ( $page ) ? 1 : $page;
		$from = ($page - 1) * $page_size;
		if (! empty ( $order )) {
			if ($order == 1) { // 按管家积分由高到低排序
				$order_by = ' order by total_score desc';
			} elseif ($order == 2) { // 满意度 高到低
				$order_by = ' order by e.satisfaction_rate desc';
			} elseif ($order == 3) { // 年度成交额 高到低
				$order_by = ' order by (SELECT SUM(mo.total_price) FROM u_member_order AS mo WHERE mo.expert_id=e.id) desc';
			} elseif ($order == 4) { // 年度成交人次 高到低
// 				$order_by = ' order by (SELECT SUM(mo.dingnum+mo.childnum) FROM u_member_order AS mo WHERE mo.expert_id=e.id) desc';
			    
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
		if ($dest_id || $label) {
			$label_where = "LEFT JOIN u_line_apply AS la ON la.expert_id=e.id LEFT JOIN u_line AS l ON l.id=la.line_id WHERE la.status=2 {$sub_where} ";
		}
		$sql = "SELECT e.id AS expert_id,e.small_photo,e.realname,CASE WHEN e.isstar=1 THEN '明星专家' WHEN e.grade=1 THEN '管家' WHEN e.grade=2 THEN '初级专家' WHEN e.grade=3 THEN '中级专家' WHEN e.grade=4 THEN '高级专家' END grade,e.expert_theme AS expert_dest, 	round(e.satisfaction_rate * 100) as satisfaction_rate, 	e.total_score,e.order_count AS volume,(SELECT l.linename FROM u_line_apply AS la LEFT JOIN u_line AS l ON la.line_id=l.id WHERE la.expert_id=e.id AND la.status=2 ORDER BY la.addtime DESC LIMIT 1) AS newest_apply_line,(SELECT l.id FROM u_line_apply AS la LEFT JOIN u_line AS l ON la.line_id=l.id WHERE la.expert_id=e.id AND la.status=2 ORDER BY la.addtime DESC LIMIT 1) AS line_id FROM u_expert AS e {$label_where}GROUP BY e.id {$order_by} LIMIT {$from},{$page_size}";
		$query = $this->db->query ( $sql ); 
		$Arr = $query->result_array ();
		$lastData = array();
		if (! empty ( $Arr )) {
			foreach ( $Arr as $key => $val ) {
				foreach ( $val as $k => $v ) {
					if ($k == 'expert_id') {
						$reDataArr[$v][$key] = $Arr[$key];
					}
				}
			}
			$i = 0;
			foreach ( $reDataArr as $key => $val ) {
				$dest = '';
				$last = array();
				foreach ( $val as $k => $v ) {
					$dest .= $v['expert_dest'];
					$len = count ( $val );
					if (($i + 1) < $len) {
						$dest .= ",";
					}
					foreach ( $v as $a => $b ) {
						$last[$a] = $b;
					}
				}
				$last['expert_dest'] = $dest;
				$lastData[$i ++] = $last;
			}
		}
	$sql2 = "SELECT e.id AS expert_id,e.small_photo,e.realname,CASE WHEN e.isstar=1 THEN '明星专家' WHEN e.grade=1 THEN '管家' WHEN e.grade=2 THEN '初级专家' WHEN e.grade=3 THEN '中级专家' WHEN e.grade=4 THEN '高级专家' END grade,e.expert_theme AS expert_dest,round(e.satisfaction_rate * 100) as satisfaction_rate, e.total_score,e.order_count AS volume,(SELECT l.linename FROM u_line_apply AS la LEFT JOIN u_line AS l ON la.line_id=l.id WHERE la.expert_id=e.id AND la.status=2 ORDER BY la.addtime DESC LIMIT 1) AS newest_apply_line,(SELECT l.id FROM u_line_apply AS la LEFT JOIN u_line AS l ON la.line_id=l.id WHERE la.expert_id=e.id AND la.status=2 ORDER BY la.addtime DESC LIMIT 1) AS line_id FROM u_expert AS e {$label_where} GROUP BY e.id {$order_by}";
		$query2 = $this->db->query ( $sql2 );
		$Arr2 = $query2->result_array ();
		$lastData2 = array();
		
		if (! empty ( $Arr2 )) {
			foreach ( $Arr2 as $key => $val ) {
				foreach ( $val as $k => $v ) {
					if ($k == 'expert_id') {
						$reDataArr2[$v][$key] = $Arr2[$key];
					}
				}
			}
			$i = 0;
			foreach ( $reDataArr2 as $key => $val ) {
				$dest2 = '';
				$last2 = array();
				foreach ( $val as $k => $v ) {
					$dest2 .= $v['expert_dest'];
					$len = count ( $val );
					if (($i + 1) < $len) {
						$dest2 .= ",";
					}
					foreach ( $v as $a => $b ) {
						$last2[$a] = $b;
					}
				}
				$last2['expert_dest'] = $dest2;
				$lastData2[$i ++] = $last2;
			}
		}
		$total_rows = count($lastData2);
		$total = ceil($total_rows/$page_size);
		$arr = array(
			'expert_list'=>$lastData,
			'total_rows'=>$total_rows
		);
		$this->__outmsg ( $arr );
	}
	
/*
*
*        do     expert      detail  (ps : is master)        管家详情  （主表）
*
*        by     zhy
*
*        at     2016年1月15日 14:26:16
*
*/
public function cfgm_expert_detail() {
	$e_id = intval ( $this->input->post ( 'expertid', true ) );
		$token = $this->input->post ( 'number', true );
		if(empty( $token)){
		    $sc='0';
		}else{
		    $this->check_token ( $token );
		    $this->load->model ( 'common/u_access_token_model','at_model');
		    $result = $this->at_model->result ( array('access_token' => $token),null,null,null,'arr',null,'mid' );
		    $m_id = $result[0]['mid'];
		    $sck = $this->db->query ( " SELECT * FROM (`u_expert_collect`) WHERE `expert_id` = {$e_id} AND `member_id` = {$m_id}")->row_array ();
		    if(empty($sck)){
		        $sc='0';
		    }else{
		        $sc='1';
		    }
		}
		if (! $e_id) {
			$this->__errormsg (); 
		}
		//管家详情
		$query = $this->db->query ( "select e.id,e.title,e.order_amount,e.people_count,e.nickname,( SELECT   `cityname` FROM `u_startplace` as d where d.id = e.city) as city ,e.small_photo,e.login_name,e.sex,e.realname,group_concat(d.kindname) AS expert_dest, e.satisfaction_rate as satisfaction_rate ,e.total_score,e.talk,(CASE WHEN e.grade=1 THEN '管家' WHEN e.grade=2 THEN '初级专家' WHEN e.grade=3 THEN '中级专家' WHEN e.grade=4 THEN '高级专家' WHEN e.isstar=1 THEN '明星专家' END) AS grade,(SELECT COUNT(*) FROM u_member_order AS mo WHERE mo.expert_id=e.id) AS volume ,(select GROUP_CONCAT(name) from u_area where FIND_IN_SET(id,e.visit_service) >0 )as likeplace from u_expert AS e,u_destinations AS d where e.status=2 and find_in_set(d.id,e.expert_dest)>0 and e.id={$e_id}" );
		$expert_list = $query->result_array ();
		foreach ( $expert_list as $key => $val ) {
		    foreach ( $val as $k => $v ) {
		        if ($k == "satisfaction_rate") {
		            if ($v) {
		                $val[$k] = round (  $v * 100 );
		            }
		        }
		    }
		    $expert_list[$key] = $val;
		}
		//售卖路线
		$query = $this->db->query ( "select uee.id as id,uee.content as content,uee.addtime as addtime,uee.praise_count as praise,ueep.pic from u_expert_essay as uee left join u_expert_essay_pic as ueep on uee.id=ueep.expert_essay_id where uee.expert_id='{$e_id}'" );
		$buy_list = $query->result_array ();
		$buy_list_num = count($query->result_array ());
		foreach ( $buy_list as $key => $val ) {
			foreach ( $val as $k => $v ) {
				if ($k == "pic") {
					if ($v) {
						$val[$k] = explode ( ";", $v );
					}
				}
			}
			$buy_list[$key] = $val;
		}
		//产品
		$sql= "select la.id,la.expert_id,(CASE WHEN la.grade=1 THEN '管家' WHEN la.grade=2 THEN '初级专家' WHEN la.grade=3 THEN '中级专家' WHEN la.grade=4 THEN '高级专家' END) AS grade,l.id AS line_id,l.linename,l.linetitle,l.mainpic,l.lineprice,l.satisfyscore  as satisfyscore  ,l.all_score AS total_score, 	l.peoplecount  as sell_num,  	(select sum(avgscore2) from u_comment as c where c.line_id=l.id and c.expert_id={$e_id} ) as expert_total_score 	from u_line_apply AS la left join u_line AS l on l.id=la.line_id 	where la.status=2 and l.status='2' and la.expert_id={$e_id}  GROUP BY l.id limit 0,2         	" ;
		$query =  $this->db->query( $sql );
		$customiz_list = $query->result_array (); 
		foreach ( $customiz_list as $key => $val ) {
		    foreach ( $val as $k => $v ) {
		        if ($k == "satisfyscore") {
		            if ($v) {
		                $val[$k] = round (  $v * 100 );
		            }
		        }
		    }
		    $customiz_list[$key] = $val;
		}
		
		$query =  $this->db->query( $sql );
		$two_list_rows = $query->num_rows ();
		//定制条数
		$sql2="select uc.id as id,uc.question as question,uc.budget as budget,uc.pic as litpic,uc.total_people as total_people,uc.startdate as startdate,uc.estimatedate as estimatedate,uc.startplace as startplace,uc.endplace as endplace,uc.status as status,uca.expert_id as expert_id,uca.isuse as isuse, ua.name as area_name,ud.kindname as dest_name, 		ue.nickname as nickname 	 from u_customize as uc left join u_customize_answer as uca on uc.id=uca.customize_id 	left join u_line as l on uc.line_id=l.id 		left join u_expert as ue on uca.expert_id=ue.id 	left join u_area as ua on ua.id=uc.startplace 		left join u_destinations as ud on ud.id=uc.endplace 	where uc.status='3' and uca.isuse='1' and ISNULL(uca.replytime)=0 	 and uca.expert_id={$e_id} order by uc.addtime desc";
		$query =  $this->db->query( $sql2 );
		$customiz_list_rows = $query->num_rows ();
		//评论数
		$query = $this->db->query ( "select uc.*,um.mobile as mobile,mo.productautoid as productautoid,l.linename as line_name,l.linetitle as line_title from u_comment as uc left join u_member as um on uc.memberid=um.mid left join u_member_order as mo on uc.orderid=mo.id left join u_line as l on l.id=mo.productautoid where uc.expert_id='{$e_id}' order by uc.addtime desc" );
		$talk_num = count($query->result_array ());
		//收藏情况
		$arr = array(
			'expert_list'               =>$expert_list,
			'buy_list'                   =>$buy_list,
		    'cp'                            =>$two_list_rows,
			'customiz_list'           =>$customiz_list,
			'customiz_list_rows' =>$customiz_list_rows,
			'talk_num'                 =>$talk_num,
			'buy_list_num'          =>$buy_list_num,
		     'sc'                           =>$sc
		);
		$this->__outmsg ( $arr );
	}
/*
*
*        do     show    sale    line        售卖路线
*
*        by     zhy
*
*        at
*
*/
public function cfgm_sale_line() {
		$e_id = intval ( $this->input->post ( 'expertid', true ) );
		is_numeric($e_id)? ($e_id):$this->__errormsg 						('tip is null !');
		$page = intval ( $this->input->post ( 'page', true ) );
		$page_size = intval ( $this->input->post ( 'pagesize', true ) );
		$page_size = empty ( $page_size ) ? 5 : $page_size;
		$page = empty ( $page ) ? 1 : $page;
		$from = ($page - 1) * $page_size;
		$this->db->select ( "la.id,la.expert_id,(CASE WHEN la.grade=1 THEN '管家' WHEN la.grade=2 THEN '初级专家' WHEN la.grade=3 THEN '中级专家' WHEN la.grade=4 THEN '高级专家' END) AS grade,l.id AS line_id,l.linename,l.mainpic,l.lineprice,l.satisfyscore,l.all_score AS total_score" );
		$this->db->from ( 'u_line_apply AS la' );
		$this->db->join ( 'u_line AS l', 'l.id=la.line_id', 'left' );
		$this->db->where ( array(		       'la.status' => 2, 	     	'la.expert_id' => $e_id    	) );
		$this->db->limit ( $page_size, $from );
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
		foreach ( $reDataArr as $key => $val ) {
		    foreach ( $val as $k => $v ) {
		        if ($k == "satisfyscore") {
		            if ($v) {
		                $val[$k] = round (  $v * 100 );
		            }
		        }
		    }
		    $reDataArr[$key] = $val;
		}
		$this->__outmsg ( $reDataArr );
	}
/*
*
*        do     volume      record      管家记录
*
*        by     zhy
*
*        at
*
*/
public function cfgm_volume_record() {
		$e_id = intval ( $this->input->post ( 'expertid', true ) );
		is_numeric($e_id)? ($e_id):$this->__errormsg 						('tip is null !');
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
		$this->db->where ( array('mo.status' => 5, 'mo.expert_id' => $e_id ) );
		$this->db->limit ( $page_size, $from );
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
		$this->__outmsg ( $reDataArr );
    }
/*
*
*        do     ask     record      管家咨询记录
*
*        by     zhy
*
*        at
*
*/
	public function cfgm_ask_record() {
		$e_id = intval ( $this->input->post ( 'expertid', true ) );
		is_numeric($e_id)? ($e_id):$this->__errormsg 						('tip is null !');
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
		$this->db->where ( array(             	'lq.reply_id' => $e_id, 		'lq.status' => 1 	) );
		$this->db->limit ( $page_size, $from );
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
		$this->__outmsg ( $reDataArr );
	}
/*
*
*        do     comment     管家评论
*
*        by     zhy
*
*        at
*
*/
	public function cfgm_comment_record() {
		$e_id = intval ( $this->input->post ( 'expertid', true ) );
		is_numeric($e_id)? ($e_id):$this->__errormsg 						('tip is null !');
		$level = intval ( $this->input->post ( 'level', true ) );
		$page = intval ( $this->input->post ( 'page', true ) );
		$page_size = intval ( $this->input->post ( 'pagesize', true ) );
		$page_size = empty ( $page_size ) ? 5 : $page_size;
		$page = empty ( $page ) ? 1 : $page;
		$from = ($page - 1) * $page_size;
		$this->db->select ( 'c.addtime,c.content,c.level,m.nickname,m.litpic,(SELECT COUNT(*) FROM u_comment AS c WHERE c.expert_id=e.id) AS comments' );
		$this->db->from ( 'u_comment AS c' );
		$this->db->join ( 'u_expert AS e', 'e.id=c.expert_id', 'left' );
		$this->db->join ( 'u_member AS m', 'm.mid=c.memberid', 'left' );
		$where['c.expert_id'] = $e_id;
		$where['c.isshow'] = 1;
		if (! empty ( $level )) {	            $where['c.level'] = $level;	        }
		$this->db->where ( $where );
		$this->db->limit ( $page_size, $from );
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
		$this->__outmsg ( $reDataArr );
	}
/*
*
*        do     honor       管家荣耀
*
*        by     zhy
*
*        at
*
*/
	public function cfgm_person_honor() {
		$e_id = intval ( $this->input->post ( 'expertid', true ) );
		is_numeric($e_id)? ($e_id):$this->__errormsg 						('tip is null !');
		$reDataArr = $this->db->query ( " SELECT   uec.certificate,uec.certificatepic as pic    FROM   u_expert_certificate AS uec    WHERE    uec.expert_id = {$e_id}    AND `status` = 1 ")->result_array ();
		$this->__outmsg ( $reDataArr );
	}
	/*
	 *
	 *        do     find    line      查询线路
	 *
	 *        by     zhy
	 *
	 *        at     2015年12月25日 15:34:05
	 *
	 */
	public function cfgm_find_line() {
	    /*
	     *                         old
	     *
	     *
	     $where = "";
	     $order_by = "";
	     $result = "";
	     $areaid = intval ( $this->input->post ( 'areaid', true ) );
	     $city_name = $this->input->post ( 'cityname', true );
	     if ($city_name) {
	     $sql = "select id from u_startplace where cityname like '%{$city_name}%'";
	     $query = $this->db->query ( $sql );
	     $result = $query->result_array ();
	     if ($result) {
	     $city_id = $result[0]['id'];
	     } else {
	     $this->__errormsg ();
	     }
	     }
	     $price = intval ( $this->input->post ( 'price', true ) );
	     $days = $this->input->post ( 'day', true );
	     $dest_id = $this->input->post ( 'dest_id', true );
	     $order = intval ( $this->input->post ( 'sort', true ) );
	     $label = $this->input->post ( 'label', true ); // 多选
	     $page = intval ( $this->input->post ( 'page', true ) );
	     $page_size = intval ( $this->input->post ( 'pagesize', true ) );
	     $page_size = empty ( $page_size ) ? 5 : $page_size;
	     $page = empty ( $page ) ? 1 : $page;
	     $from = ($page - 1) * $page_size;
	     if ($areaid) {
	     $where .= " and FIND_IN_SET({$areaid},l.overcity)>0";
	     }
	     if (! empty ( $order )) {
	     if ($order == 2) { // 好评优先
	     $order_by = " order by l.satisfyscore desc";
	     } elseif ($order == 3) { // 销量优先
	     $order_by = " order by volume desc";
	     } elseif ($order == 4) { // 价格由低到高
	     $order_by = " order by l.lineprice asc";
	     } elseif ($order == 5) { // 价格由高到低
	     $this->db->order_by ( 'l.lineprice', 'desc' );
	     $order_by = " order by l.lineprice desc";
	     }
	     }
	     if ($city_name) {
	     $where .= " and l.startcity={$city_id}";
	     }
	     if ($price == 1) {
	     $where .= " and l.lineprice < 500";
	     } elseif ($price == 2) {
	     $where .= " and (l.lineprice > 500 and l.lineprice < 4000)";
	     } elseif ($price == 3) {
	     $where .= " and (l.lineprice > 4000 and l.lineprice < 8000)";
	     } elseif ($price == 4) {
	     $where .= " and l.lineprice > 8000";
	     }
	     if ($days) {
	     if ($days < 8) {
	     $where .= " and l.lineday={$days}";
	     } else {
	     $where .= " and l.lineday > {$days}";
	     }
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
	     $where .= " and {$l_kh} FIND_IN_SET({$val},l.overcity) > 0";
	     } else {
	     $where .= " or FIND_IN_SET({$val},l.overcity) > 0 {$r_kh}";
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
	     $where .= " and {$l_kh} FIND_IN_SET({$val},l.linetype)>0";
	     } else {
	     $where .= " or FIND_IN_SET({$val},l.linetype)>0 {$r_kh}";
	     }
	     }
	     }
	
	     if (empty ( $city_name ) || empty ( $label )) {
	     $sql = "SELECT cl.line_id,l.linename,l.mainpic,l.lineprice,l.satisfyscore,(SELECT COUNT(*) FROM u_comment AS c WHERE c.line_id=l.id) AS comments,(SELECT SUM(dingnum+childnum) FROM u_member_order AS mo WHERE l.id=mo.productautoid AND mo.status>4) AS people,(SELECT COUNT(*) FROM u_member_order AS mo WHERE l.id=mo.productautoid AND mo.status>4) AS volume FROM cfgm_hot_line AS cl LEFT JOIN u_line AS l ON cl.line_id=l.id WHERE l.status=2 AND cl.is_show=1 {$where}{$order_by} LIMIT {$from},{$page_size}";
	     } else {
	     $sql = "SELECT l.id AS line_id,l.linename,l.mainpic,l.lineprice,l.satisfyscore,(SELECT COUNT(*) FROM u_comment AS c WHERE c.line_id=l.id) AS comments,(SELECT SUM(dingnum+childnum) FROM u_member_order AS mo WHERE l.id=mo.productautoid AND mo.status>4) AS people,(SELECT COUNT(*) FROM u_member_order AS mo WHERE l.id=mo.productautoid AND mo.status>4) AS volume FROM u_line AS l WHERE l.status=2 {$where} {$order_by}  LIMIT {$from},{$page_size}";
	     }
	     $query = $this->db->query ( $sql );
	     $lastData = $query->result_array ();
	
	     $this->__outmsg ( $lastData );
	     }
	
	     */
		$num=$this->input->post("num");
	    $num= empty($num)?1:$num;
	    $where = "";
	    $order_by = "";
	    $result = "";
	    $areaid = intval ( $this->input->post ( 'areaid', true ) );
	    $city_id = $this->input->post ( 'cityid', true );
	    $price = intval ( $this->input->post ( 'price', true ) );
	    $days = $this->input->post ( 'day', true );
	    $dest= $this->input->post ( 'dest_id', true );
	    $dest_id=ltrim($dest,',');
	    $order = intval ( $this->input->post ( 'sort', true ) );
	    $label_id = $this->input->post ( 'label', true ); // 多选
	    $city_name = $this->input->post ( 'cityname', true );//定位城市名
	    $this->load->model('common/u_area_model','area_model');
	    $city_data=$this->area_model->get_row_city($city_name);
	    if($city_data){
	        $city_id=$city_data['id'];
	    }
// 	    $label_id=substr($label, 0, -1);
	    $page = intval ( $this->input->post ( 'page', true ) );
	    $page_size = intval ( $this->input->post ( 'pagesize', true ) );
	    $page_size = empty ( $page_size ) ? 5 : $page_size;
	    
	    
	    $page = empty ( $page ) ? 1 : $page;
	    if($num>1){
	        $page = $num;
	    }
	    $from = ($page - 1) * $page_size;
	    if ($areaid) {
	        $where .= " and FIND_IN_SET({$areaid},l.overcity)>0";
	    }
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
	    //if ($city_id) {
	        //$where .= " and l.startcity={$city_id}";
	    //}
	    
	    if (! empty($city_name) && !empty($city_id)) {
	        $where .= " and l.startcity={$city_id}";
	    }
	    
	    $this->load->model('common/cfg_search_condition_model','cfg_search_condition');
// 	    $whereArr=array('pid'=>'4');
// 	    $price_arr=$this->cfg_search_condition->all($whereArr);
// 	    if(isset($price_arr['minvalue']))
// 	        $where .= " and (l.lineprice >= ".$price_arr['minvalue']." and l.lineprice <= ".$price_arr['maxvalue'].")";
// 	        $days_arr=$this->cfg_search_condition->row(array('id'=>$days));
// 	        if(isset($days_arr['minvalue']))
// 	            $where .= " and (l.lineday >= {$days_arr['minvalue']} and l.lineday <= {$days_arr['maxvalue']})";
	
	            
	            if(isset($price))
	            {
	                $price_arr=$this->cfg_search_condition->row(array('id'=>$price));
	                if(isset($price_arr['minvalue']))
	                    $where .= " and (l.lineprice >= ".$price_arr['minvalue']." and l.lineprice <= ".$price_arr['maxvalue'].")";
	            }
	            if(isset($days))
	            {
	                $days_arr=$this->cfg_search_condition->row(array('id'=>$days));
	                if(isset($days_arr['minvalue']))
	                    $where .= " and (l.lineday >= {$days_arr['minvalue']} and l.lineday <= {$days_arr['maxvalue']})";
	            }
	            
	            if (($dest_id)) {
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
	                        $where .= " or FIND_IN_SET({$val},l.overcity) > 0 {$r_kh}";
	                    }
	                }
	            }
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
	                        $where .= " or FIND_IN_SET({$val},l.linetype)>0 {$r_kh}";
	                    }
	                }
	            }
	             $data['line_list'] = $this->db->query ( "	 SELECT l.id,l.linename,l.linetitle,l.mainpic,l.lineprice,satisfyscore,l.comment_count as comments,l.peoplecount as bookcount,(SELECT	COUNT(*) FROM u_member_order AS mo WHERE l.id = mo.productautoid AND mo. STATUS > 4 ) AS volume FROM u_line AS l WHERE l. STATUS = 2 {$where}{$order_by}  and l.producttype = 0 LIMIT {$from},{$page_size}    ")->result_array ();
	             if(empty( $data['line_list'] )){  $this->__outmsg ($data['line_list']);}
	             foreach (  $data['line_list'] as $key => $val ) {
	                 foreach ( $val as $k => $v ) {
	                     if ($k == "satisfyscore") {
	                         if ($v) {
	                             $val[$k] = round (  $v * 100 );
	                         }
	                     }
	                 }
	                  $data['line_list'][$key] = $val;
	             }
	            //查询总记录数
	            $result= $this->db->query ( "	             select count(*) as cont FROM (SELECT l.id,l.linename,l.linetitle,l.mainpic,l.lineprice,l.satisfyscore,(SELECT COUNT(*) FROM u_comment AS c WHERE c.line_id = l.id ) AS comments,(SELECT	SUM(mo.dingnum + mo.childnum+mo.childnobednum+mo.oldnum) FROM u_member_order AS mo WHERE	l.id = mo.productautoid AND mo. STATUS > 4) AS people,(SELECT	COUNT(*) FROM u_member_order AS mo WHERE l.id = mo.productautoid AND mo. STATUS > 4 ) AS volume FROM u_line AS l WHERE l. STATUS = 2  {$where}{$order_by} ) temp  ")->result_array ();
	            $data['total_rows']= ($result[0]['cont']);
	            $total= ceil( $data['total_rows']/$page_size);
	            $datas['page']=$num;
	            $datas['total']=$total;
	            $datas['result']=$data['line_list'];
	            $datas['total_rows']=$data['total_rows'];
	            $this->__outmsg ( $datas );
	}
	
	
/*
*
*        do     hot     area        热门线路
*
*        by     zhy
*
*        at     2015年12月25日 15:01:54
*
*/      
	public function cfgm_hot_area() {
	    $page = intval ( $this->input->post ( 'page', true ) );
	    $page_size = intval ( $this->input->post ( 'pagesize', true ) );
	    $page_size = empty ( $page_size ) ? 5 : $page_size;
	    $page = empty ( $page ) ? 1 : $page;
	    $from = ($page - 1) * $page_size;
	    $dest_id =  ( $this->input->post ( 'dest_id', true ) );
	    if(empty($dest_id)){
	        $where="";
	    }else{
	        $where="and cd.dest_id in ($dest_id) ";
	    }
		$reDataArr = $this->db->query ( "select cd.dest_id as id, cd.name as linename, 	cd.pic as pic,	cd.linenum as linenum,	(select count(1) from u_line as l where l.status='2' and FIND_IN_SET(cd.dest_id,l.overcity)>0) as num,	ud.description as description	from cfgm_hot_dest as cd	left join u_destinations as ud on ud.id=cd.dest_id	where cd.is_show='1' {$where} limit {$from},{$page_size} ")->result_array ();
         $this->__outmsg ( $reDataArr );
	}
/*
*
*        do     line    detail  (   ps :is master)      线路详情    （主表）
*
*        by     zhy
*
*        at
*
*/
	public function cfgm_line_detail() {
		$l_id = intval ( $this->input->post ( 'lineid', true ) );
		$token = $this->input->post ( 'number', true );
			if ($token) { // 有登录 收藏和分享
			$this->load->library ( 'token' );
			$is_login = $this->token->isValidToken ( $token );
			if ($is_login) {
				// 获取mid
				$query = $this->db->query ( "select mid from u_access_token where access_token='{$token}'" );
				$user = $query->result_array ();
				$m_id = $user[0]['mid'];
				$sql = "select (select count(*) from u_line_collect where line_id={$l_id} and member_id={$m_id}) AS is_sc,count(*) AS is_fx from u_line_share where line_id={$l_id} and member_id={$m_id}";
				$query = $this->db->query ( $sql );
				$sc_fx = $query->result_array ();
				// 添加浏览记录
				if ($l_id) {
					$query = $this->db->query ( "select * from u_line_browse where line_id={$l_id}" );
					$result = $query->result_array ();
					if (empty ( $result )) {
						$llData = array(
								'member_id' => $m_id, 
								'line_id' => $l_id, 
								'times' => 0, 
								'addtime' => date ( 'Y-m-d H:i:s', time () ) 
						);
						$this->db->insert ( "u_line_browse", $llData );
					} else {
						$this->db->update ( "u_line_browse", array(
								'addtime' => date ( 'Y-m-d H:i:s', time () ) 
						), array(
								'line_id' => $l_id 
						) );
					}
				}
			}
		}
		$this->db->select ( 'l.id,l.linename,l.linecode,l.lineprice,l.mainpic as tupian,l.comment_count,l.linetitle,l.all_score,l.overcity, l.peoplecount,l.marketprice,l.satisfyscore as satisfyscore,l.all_score, l.feeinclude, l.feenotinclude, l.insurance, l.other_project, l.book_notice, l.visa_content, l.special_appointment, l.beizu, l.safe_alert,   l.avg_score,group_concat(la.filepath) AS filepath,(SELECT COUNT(*) FROM u_member_order AS mo WHERE l.id=mo.productautoid AND mo.status>4) AS volume,l.features' );
		$this->db->from ( 'u_line AS l' );
		$this->db->join ( 'u_line_pic AS lp', 'l.id=lp.line_id', 'left' );
		$this->db->join ( 'u_line_album AS la', 'lp.line_album_id=la.id', 'left' );
		$this->db->where ( array(
				'l.id' => $l_id
		) );
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
			if (! empty ( $reDataArr[0]['filepath'] )) {
			if ($reDataArr[0]['filepath']) {
				$reDataArr[0]['filepath'] = explode ( ',', $reDataArr[0]['filepath'] );
				$reDataArr[0]['filepath'] =array_slice($reDataArr[0]['filepath'],0,5);
			}
		} else {
			$this->__errormsg ();
		}
		
		if(   empty ($reDataArr[0]['filepath'][0])){
		    $re1[]='';
		}else{
		    $re1[]="http://" . $_SERVER['HTTP_HOST'].$reDataArr[0]['filepath'][0];
		}
		if(   empty ($reDataArr[0]['filepath'][1])){
		    $re2[]='';
		}else{
		    $re2[]="http://" . $_SERVER['HTTP_HOST'].$reDataArr[0]['filepath'][1];
		}
		if(   empty ($reDataArr[0]['filepath'][2])){
		    $re3[]='';
		}else{
		    $re3[]="http://" . $_SERVER['HTTP_HOST'].$reDataArr[0]['filepath'][2];
		}
		if(   empty ($reDataArr[0]['filepath'][3])){
		    $re4[]='';
		}else{
		    $re4[]="http://" . $_SERVER['HTTP_HOST'].$reDataArr[0]['filepath'][3];
		}
		if(   empty ($reDataArr[0]['filepath'][4])){
		    $re5[]='';
		}else{
		    $re5[]="http://" . $_SERVER['HTTP_HOST'].$reDataArr[0]['filepath'][4];
		}
		$reDataArr[0]['filepath']=array_merge($re1,$re2,$re3,$re4,$re5);
		if(       empty(  $reDataArr[0]['tupian']    )){   $reDataArr[0]['tupian']  ='    '  ; }else{    $reDataArr[0]['tupian']="http://" . $_SERVER['HTTP_HOST'].$reDataArr[0]['tupian'];    	}
		foreach ( $reDataArr as $key => $val ) {
		    foreach ( $val as $k => $v ) {
		        if ($k == "satisfyscore") {
		            if ($v) {
		                $val[$k] = round (  $v * 100 );
		            }
		        }
		    }
		    $reDataArr[$key] = $val;
		}
		$line_arr = $this->db->query ( "	SELECT m.litpic, m.nickname, c.level, c.content, c.addtime, c.isanonymous, m.mobile 	FROM (u_comment AS c)	LEFT JOIN  u_member as m ON c.memberid=m.mid	WHERE c.line_id =  {$l_id}	LIMIT 2 ")->result_array ();
/* 		
         $linetype = $reDataArr[0]['linetype'];
		 $sql = "select la.attrname from u_line_attr as la where la.id in ({$linetype})";
		 $query = $this->db->query ( $sql );
		 $line_arr = $query->result_array ();
*/
		$result['linecom'] = "";
		if ($line_arr) {
			$result['linecom'] = $line_arr;
		}
		$line_time = $this->db->query ( "	SELECT lj.day, lj.title, lj.jieshao, lj.breakfirst, lj.lunch, lj.supper, lj.transport, lj.hotel  FROM (`u_line_jieshao` AS lj) 	 WHERE lj.lineid = {$l_id}  ORDER BY day  ")->result_array ();
		/*
		 $linetype = $reDataArr[0]['linetype'];
		 $sql = "select la.attrname from u_line_attr as la where la.id in ({$linetype})";
		 $query = $this->db->query ( $sql );
		 $line_arr = $query->result_array ();
		 */
		$result['lineway'] = "";
		if ($line_time) {
		    $result['lineway'] = $line_time;
		}
		$Arr = array_merge ( $reDataArr[0], $result );
		if ($token && $is_login) {
			$Arr = array_merge ( $Arr, $sc_fx[0] );
		}
		$this->__outmsg ( $Arr, 1 );
	}
	
/*
*
*        do     browse      long        游览时长
*
*        by     zhy
*
*        at
*
*/
	public function cfgm_browse_long() {
		$l_id = $this->input->post ( 'lineid', true );
		is_numeric($l_id)? ($l_id):$this->__errormsg 						('tip is null !');
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model','at_model');
		$result = $this->at_model->result ( array('access_token' => $token),null,null,null,'arr',null,'mid' );
		$m_id = $result[0]['mid'];
		$query = $this->db->query ( "select addtime from u_line_browse where line_id=$l_id and member_id=$m_id" );
		$begin = $query->result_array ();
		$close_time = time ();
		$browse_long = $close_time - strtotime ( $begin[0]['addtime'] );
		if ($browse_long > 0) {
			$this->db->update ( 'u_line_browse', array(
					'times' => $browse_long 
			), array(
					'line_id' => $l_id, 
					'member_id' => $m_id 
			) );
		}
	}
	
/*
*
*        do     line        notice      线路标识
*
*        by     zhy
*
*        at
*
*/
	public function cfgm_line_notice() {
		$l_id = $this->input->post ( 'lineid', true );
		is_numeric($l_id)? ($l_id):$this->__errormsg 						('tip is null !');
		$dataFiled="day,title,jieshao,breakfirst,lunch,supper,transport,hotel";
		$this->load->model ( 'common/u_line_jieshao_model','lj_model');
		$reDataArr = $this->lj_model->row ( array('lineid' => $l_id),'arr','day',$dataFiled );
		$this->__outmsg ( $reDataArr, 1 );
	}
	
/*
*
*        do     line    info        线路详情
*
*        by     zhy
*
*        at
*
*/
	public function cfgm_line_info() {
		$l_id = $this->input->post ( 'lineid', true );
		is_numeric($l_id)? ($l_id):$this->__errormsg 						('tip is null !');
		$dataFiled="id,feeinclude,feenotinclude,book_notice,visa_content";
		$this->load->model ( 'common/u_line_model','ul_model');
		$reDataArr = $this->ul_model->row ( array('id' => $l_id),'arr','',$dataFiled );
		$this->__outmsg ( $reDataArr );
	}
	
/*
*
*        do     user     comments       用户评论
*
*        by     zhy
*
*        at
*
*/
	public function cfgm_user_comments() {
		$l_id = intval ( $this->input->post ( 'lineid', true ) );
		$level = intval ( $this->input->post ( 'level', true ) );
		$page = $this->input->post ( 'page', true );
		$page_size = $this->input->post ( 'pagesize', true );
		$page_size = empty ( $page_size ) ? 5 : $page_size;
		$page = empty ( $page ) ? 1 : $page;
		$from = ($page - 1) * $page_size;
		is_numeric($l_id)? ($l_id):$this->__errormsg 						('tip is null !');
		$this->db->select ( 'm.litpic,m.nickname,c.level,c.content,c.addtime,m.mobile' );
		$this->db->from ( 'u_comment AS c' );
		$this->db->join ( 'u_member as m', 'c.memberid=m.mid', 'left' );
		$where['c.line_id'] = $l_id;
		if ($level) {
			$where['c.level'] = $level;
		}
		$this->db->where ( $where );
		$this->db->limit ( $page_size, $from );
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
		$this->__outmsg ( $reDataArr );
	}
/*
*
*        do     line    suit
*
*        by     zhy
*
*        at     2015年12月29日 14:40:09
*
*/
	public function cfgm_line_suit() {
		$l_id = $this->input->post ( 'suitid', true );
		is_numeric($l_id)? ($l_id):$this->__errormsg 						('tip is null !');
		$reDataArr = $this->db->query ( "SELECT id,suitname FROM `u_line_suit` where lineid = {$l_id} ")->result_array ();
		if(empty($reDataArr)){
		    $this->__errormsg ();
		}
		$this->__outmsg ( $reDataArr );
	}
/*
*
*        do     price   date        价格详情
*
*        by     zhy
*
*        at
*
*/
	public function cfgm_price_date() {
		$suit_id = $this->input->post ( 'suitid', true );
		is_numeric($suit_id)? ($suit_id):$this->__errormsg 						('tip is null !');
		$where = array(
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
				$reDataArr[$val['day']] = $val;
				unset ( $reDataArr[$val['day']]['day'] );
				unset ( $reDataArr[$key] );
			}
		}
		 
		$this->__outmsg ( $reDataArr );
	}
	
/*
*
*        do     line    detail      线路详情
*
*        by     zhy
*
*        at     2015年12月30日 15:07:46
*
*/
	public function cfgm_suit_line_detail() {
		$where = "";
		$l_id = $this->input->post ( 'lineid', true );
		$suit_id = $this->input->post ( 'suitid', true );
		$day = $this->input->post ( 'day', true );
		is_numeric($l_id)? ($l_id):$this->__errormsg 						('tip is null !');
		is_numeric($suit_id)? ($suit_id):$this->__errormsg 						('tip is null !');
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model','at_model');
		$result = $this->at_model->result ( array('access_token' => $token),null,null,null,'arr',null,'mid' );
		$userid = $result[0]['mid'];
		$reDataArr['user'] = $this->db->query ( "		select truename,mobile,email from u_member WHERE	mid = {$userid} ")->row_array ();
		$line = $this->db->query ( "select l.id AS line_id,l.linename,l.linetitle,l.beizu,l.child_description,l.child_nobed_description,l.old_description,l.special_description,l.special_appointment ,l.safe_alert ,l.feeinclude ,l.feenotinclude,l.other_project ,l.insurance   ,l.visa_content  from u_line AS l where l.id={$l_id} ")->row_array ();
		$linecity = $this->db->query ( "SELECT ul.supplier_id as supplier_id,us.company_name as company_name,usp.cityname as startcity_name  	FROM  	u_line AS ul 	LEFT JOIN u_supplier AS us ON ul.supplier_id = us.id	left join u_startplace as usp on ul.startcity=usp.id	WHERE	ul.id = {$l_id} AND ul. STATUS = 2  ")->row_array ();
		$userjf = $this->db->query ( "		SELECT 	jifen 	FROM  	u_member m 	WHERE	mid = {$userid} ")->row_array ();
		$reDataArr['line'] =  array_merge($line,$linecity,$userjf);
		$reDataArr['insurance'] = $this->db->query ( "	select li.id AS id,li.insurance_id as insurance_id,li.line_id as line_id,ti.insurance_name as insurance_name,	ti.insurance_price as insurance_price,ti.insurance_date as insurance_date, 	ti.insurance_clause as insurance_clause 	from u_line_insurance AS li 	left join u_travel_insurance as ti on li.insurance_id=ti.id  	where 	li.status='1' 	and li.line_id={$l_id} ")->result_array ();
		if (! empty ( $suit_id )) {
			$where .= "and ls.id={$suit_id} ";
		}
		if (! empty ( $day )) {
			$where .= "and lsp.`day`='{$day}'";
		}
		$sql = "select ls.id AS suit_id,lsp.day,lsp.adultprice,lsp.oldprice,lsp.childnobedprice,lsp.childprice from u_line_suit AS ls left join u_line_suit_price AS lsp on lsp.suitid=ls.id where ls.lineid={$l_id} {$where}";
		$query = $this->db->query ( $sql );
		$suit = $query->result_array ();
		$reDataArr['suit'] = $suit;
		$sql = "select e.id AS expert_id,e.nickname,e.small_photo,CASE WHEN la.grade=1 THEN '管家' WHEN la.grade=2 THEN '初级专家' WHEN la.grade=3 THEN '中级专家' WHEN la.grade=4 THEN '高级专家' end grade  from u_expert AS e left join u_line_apply AS la on e.id=la.expert_id where la.line_id={$l_id}";
		$query = $this->db->query ( $sql );
		$reDataArr['expert'] = $query->result_array ();
		//国内外
		$query = $this->db->query ("select right(overcity,1) as city from u_line where id={$l_id}");
		$city = $query->result_array ();
		if(!empty($city)){
		    $num=$city[0]['city'];
		}else{
		    $num='1';
		}
		$reDataArr['coun']=$num;
		
		 $sql = "  SELECT	cmc.id AS 'id',cmc.coupon_id as coupon_id,cmc.member_id as member_id,cmc.status as status,cc.min_price, cc.min_price,	cc.name as name,cc.pic as pic,cc.starttime as starttime,cc.endtime as endtime,cc.coupon_price as coupon_price,cc.use_url as use_url 	FROM cou_member_coupon AS cmc LEFT JOIN cou_coupon AS cc ON cmc.coupon_id=cc.id 	WHERE cmc.status>=0 and cc.status='1' and cmc.member_id={$userid}";
		$sql2 = "SELECT 	cmc.id AS 'id',cmc.coupon_id as coupon_id,cmc.member_id as member_id,cmc.status as status,cc.min_price,cc.min_price, 	cc.name as name,cc.pic as pic,cc.starttime as starttime,cc.endtime as endtime,cc.coupon_price as coupon_price,cc.use_url as use_url 	FROM cou_member_coupon AS cmc LEFT JOIN cou_coupon AS cc ON cmc.coupon_id=cc.id 	WHERE cmc.status<0 and cc.status='1' and cmc.member_id={$userid}";
		$query = $this->db->query ( $sql );
		$query2 = $this->db->query ( $sql2 );
		$reDataArr['vol_new'] = $query->result_array (); //未使用、已使用
		$reDataArr['vol_old'] = $query2->result_array ();//已过期 
		$this->__outmsg ( $reDataArr, 1 );
	}
	
/*
*
*        do     line     Details    Collection (ps : old)       线路详情
*
*        by     zhy
*
*        at
*
*/
	public function cfgm_sc_fx() {
		$status = 0;
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model','at_model');
		$result = $this->at_model->result ( array('access_token' => $token),null,null,null,'arr',null,'mid' );
		$m_id = $result[0]['mid'];
		$fx['line_id'] = $this->input->post ( 'fxid', true );
		$fx['content'] = $this->input->post ( 'fxcontent', true );
		$fx['location'] = $this->input->post ( 'from', true );
		if ($fx['line_id']) {
			$fx['member_id'] = $m_id;
			$fx['praise_count'] = 0;
			$fx['addtime'] = date ( 'Y-m-d H:i:s', time () );
			$status = $this->db->insert ( 'u_line_share', $fx );
			$fx_id = $this->db->insert_id ();
			if ($_FILES) {
				$path = "./file/c/share/image/";
				foreach ( $_FILES as $key => $val ) {
					$fx_pic = $this->cfgm_upload_pimg ( $path, $key );
					$pic = "/file/c/share/image/" . $fx_pic;
					$status = $this->db->insert ( 'u_line_share_pic', array(
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
	
/*
*
*        do     Line     Details    Collection      线路详情
*
*        by     zhy
*
*        at
*
*/
	public function cfgm_sc_line() {
		$status = 0;
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model','at_model');
		$result = $this->at_model->result ( array('access_token' => $token),null,null,null,'arr',null,'mid' );
		$m_id = $result[0]['mid'];
		$sc['line_id'] = $this->input->post ( 'scid', true );
		if ($sc['line_id']) {
			$query = $this->db->query ( "select line_id from u_line_collect where line_id={$sc['line_id']} and member_id={$m_id}" );
			$sc_arr = $query->result_array ();
			if ($sc_arr) { // 如果有就取消
				$status = $this->db->query ( "delete from u_line_collect where line_id={$sc['line_id']} and member_id={$m_id}" );
			} else { // 没有就添加
				$sc['member_id'] = $m_id;
				$sc['addtime'] = date ( 'Y-m-d H:i:s', time () );
				$status = $this->db->insert ( 'u_line_collect', $sc );
			}
		}
		if ($status) {
			$this->__successmsg ();
		}
	}
	
/*
*
*        do     user    register        用户注册
*
*        by     zhy
*
*        at
*
*/
	public function cfgm_user_register() {
		$this->load->library ( 'session' );
		$mobile = $this->input->post ( 'mobile', true );
		$password = $this->input->post ( 'password', true );
		$code = $this->input->post ( 'code', true );
		if (empty($mobile ))			                                                      {$this->__errormsg ('电话号码不能为空！');      }
		if (empty($password ))			                                                  {$this->__errormsg ('密码不能为空！');            }
		$code_mobile = $this->session->userdata ( 'mobile' );
		$code_number = $this->session->userdata ( 'code' );
		if (($code_mobile == $mobile) && ($code_number == $code)) {
			if ($mobile && $password) {
				if (! preg_match ( "/1[34578]{1}\d{9}$/", $mobile )) {
					$this->__errormsg ('mobile err ');
				}
				$data = array(
						'loginname' => $mobile, 
						'pwd' => md5 ( $password ), 
						'mobile' => $mobile, 
						'litpic' => '/file/c/img/face.png', 
						'jointime' => time (), 
						'sex' => - 1 ,
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
						$lastData['rows'] = array();
						$this->result_data = $lastData;
						$this->resultJSON = json_encode ( array(
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
/*
*
*        do     user    login       用户登录
*
*        by     zhy
*
*        at     2016年3月7日 14:25:55
*
*/
	public function cfgm_user_login() {
		$mobile = $this->input->post ( 'mobile' );
		$password = $this->input->post ( 'password' );
		$md5 = $this->input->post ( 'md5' );
		is_numeric ($mobile) ? $mobile:  $this->__errormsg ( "手机号码有误！" );
		if ( empty($password)) {$this->__errormsg('密码不能为空');}
		$this->load->model ( 'common/u_member_model','mm_model');
		$result = $this->mm_model->result ( array('mobile' => $mobile),null,null,null,'arr',null,'*' );
		if ($result) {
			if (md5 ( $password ) == $result[0]['pwd']) {
				// 登录成功后 更新或插入token，接口访问时验证token是否过期
				$this->load->library ( 'token' );
				$token_arr = $this->token->getToken ( $result[0]['mid'] );
				$token = ( array ) json_decode ( $token_arr );
				$this->result_code = "1";
				$this->result_msg = "success";
				$lastData['rows'] = array(
// 						0 => array(
								'key' => $token['key'],
								'id'=>$result[0]['mid']
// 						) 
				);
				$this->result_data = $lastData;
				$this->resultJSON = json_encode ( array(
						"msg" => $this->result_msg, 
						"code" => $this->result_code, 
						"data" => $this->result_data, 
						"total" => "0" 
				) );
				echo $this->resultJSON;
				exit ();
			}elseif(    $password  == $result[0]['pwd']   && $md5=='md5'){
			    $this->load->library ( 'token' );
			    $token_arr = $this->token->getToken ( $result[0]['mid'] );
			    $token = ( array ) json_decode ( $token_arr );
			    $this->result_code = "1";
			    $this->result_msg = "success";
			    $lastData['rows'] = array(
			    // 						0 => array(
			            'key' => $token['key'],
			            'id'=>$result[0]['mid']
			            // 						)
			    );
			    $this->result_data = $lastData;
			    $this->resultJSON = json_encode ( array(
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
				$lastData['rows'] = array();
				$this->result_data = $lastData;
				$this->resultJSON = json_encode ( array(
						"msg" => $this->result_msg, 
						"code" => $this->result_code, 
						"data" => $this->result_data, 
						"total" => "0" 
				) );
				echo $this->resultJSON;
				exit ();
			}
		} else {
			$this->__errormsg ('343');
		}
	}
/*
*
*        do     check   user    token       验证token
*
*        by     zhy
*
*        at
*
*/
	public function check_token($token) {
		$this->load->library ( 'token' );
		$result = $this->token->isValidToken ( $token );
		if (! $result) {
			$this->result_code = "-1";
			$this->result_msg = "token exceed the time limit";
			$lastData['rows'] = "";
			$this->result_data = $lastData;
			$this->resultJSON = json_encode ( array(
					"msg" => $this->result_msg, 
					"code" => $this->result_code, 
					"data" => $this->result_data, 
					"total" => "0" 
			) );
			echo $this->resultJSON;
			exit ();
		}
	}
	
/*
*
*        do     order (ps : no user)        创建订单
*
*        by     zhy
*
*        at
*
*/
	public function create_ordersn($ordersn) {
		$this->load->model ( 'order_model', 'order_model' );
		$order = $this->order_model->row ( array('ordersn' => $ordersn ) );
		if (! empty ( $order )) {
			return false;
		}
		return true;
	}
/*
*
*        do     order       创建订单
*
*        by     zhy
*
*        at     2016年1月5日 10:10:48
*
*/
	public function cfgm_add_order() {
		$this->load->library ( 'session',true);
		$code_number = $this->session->userdata ( 'code' );
		$code_mobile = $this->session->userdata ( 'mobile' );
		//print_r($this->session->all_userdata());
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model','at_model');
		$user = $this->at_model->result ( array('access_token' => $token),null,null,null,'arr',null,'mid' );
		$m_id = $user[0]['mid'];
		$data['productautoid'] = $ll_id =$this->input->post ( 'line_id' );
		$data['expert_id'] = $ee_id =$this->input->post ( 'expert_id' );
		$data['suitid'] = $this->input->post ( 'suitid' );
		$data['usedate'] = $use_date = $this->input->post ( 'indent_day' );
		$data['dingnum'] = $this->input->post ( 'adult_number' );
		$data['oldnum'] = $this->input->post ( 'elder_number' );
		$data['childnum']= $this->input->post ( 'child_bed_num' );
		$data['childnobednum']= $this->input->post ( 'child_not_bed_num' );
		$data['linkman'] = $this->input->post ( 'linkman' );
		$data['linkemail'] = $this->input->post ( 'linkemail' );
		$data['linkmobile'] = $this->input->post ( 'linkman_phone' );
		$this->db->trans_start();//事务开启--------
		//积分
		$this->load->model('common/u_member_model','member_model');
		$reData_member=$this->member_model->row(array('mid'=>$m_id));
		$this->load->model('common/u_expert_model','expert_model');
		$reData_expert=$this->expert_model->row(array('id'=>$ee_id));
		$point=$this->input->post ( 'jifen' );
		$data['jifen']=isset($point)?$point:'0';
		if($point<=$data['jifen']){
			if($point>0)	{	$data['jifenprice']=$point/100;	}
			else 			{	$data['jifenprice']='0';	}
		}else 
		{		$this->__errormsg ('积分不足');		}
		// $this->db->trans_begin(); 
		$this->member_model->update(array('jifen'=>$reData_member['jifen']-$point),array('mid'=>$m_id));
		$this->load->model('common/u_member_point_log_model','u_member_point_log');
		$point_log=array(
				'point_before'=>$reData_member['jifen'],
				'point_after'=>$reData_member['jifen']-$point,
				'member_id'=>$m_id,
				'point'=>$point,
				'content'=>'下单支付积分',
				'addtime'=>date("Y-m-d H:i:s")
		        );
		if($point>'0')		{	$this->u_member_point_log->insert($point_log);		}
		$coupon_choose=$this->input->post('coupon_choose');			//优惠券
		if(is_numeric($coupon_choose)){
			$this->load->model('common/cou_member_coupon_model','member_coupon_model');
			$coupon_one_temp=$this->member_coupon_model->page_my_coupon_order($m_id,array('id'=>$coupon_choose));
			$coupon_one=$coupon_one_temp['new'];
			$data['couponprice']=isset($coupon_one[0]['coupon_price'])?$coupon_one[0]['coupon_price']:'0';//优惠卷的价格-暂时为空		
			$this->load->model('common/cou_member_coupon_model','cou_member_coupon');
			$this->cou_member_coupon->update(array('status'=>'1'),array('id'=>$coupon_choose));
		}
		$this->load->model('common/u_line_suit_price_model','line_suit_model');	
		$reData=$this->line_suit_model->row(array('suitid'=>$data['suitid'],'lineid'=>$data['productautoid'],'day'=>$data['usedate']));
		$data['price'] = $reData['adultprice'];
		$data['childprice'] = $reData['childprice'];
		$data['oldprice']=$reData['oldprice'];
		$data['childnobedprice']=$reData['childnobedprice'];
		//订单保险
		$insuranceJson = $this->input->post ( 'insuranceList' );//保险
		// $insurance=json_decode($insuranceJson,true);
		$insurance_price=0;
		if(!empty($insuranceJson)){
				foreach ($insuranceJson as $in=>$in_value)
							{
							        //保险价格
									$insurance_price=$insurance_price+($in_value['insurance_price']*$in_value['insurance_num']);
							}
		}
		//订单价格=xx ；实付价格=订单价格-积分价格-优惠券价格
		 $data['order_price'] =$data['dingnum']*$data['price']+$data['childnum']*$data['childprice']+$data['oldnum']*$data['oldprice']+$data['childnobednum']*$data['childnobedprice'];
		 if( isset($data['couponprice'])&&!empty( $data['couponprice'])     ){
		    $coup= $data['couponprice'];
		 }else{
		     $coup='0';
		 }
		 $data['total_price'] = $data['order_price']-$data['jifenprice']-$coup;//-$data['couponprice'];总价格等于订单价格-优惠价格-积分/100
		$data['channel'] = 1;
		$data['memberid'] = $m_id ;
		$data['ispay'] = 0;
		$data['status'] = 0;
		$data['addtime'] = date ( 'Y-m-d H:i:s', time () );

		// 游客信息
		$touristList = $this->input->post ( 'touristList' );
		// 生成订单号
		$year = date ( 'Y', time () );
		$month = date('m' , time ());
		while ( true ) {
				$ordersn = substr ( $year, 2 ).$month. mt_rand ( 10000000, 99999999 );
				if ($this->create_ordersn ( $ordersn )) {
					break;
				}
		}
		$data['ordersn'] = $ordersn;
		// 管家信息
		$this->load->model('line_model','line_model');
		$expert_info=$this->line_model->add_order_expert($ll_id,$ee_id);
		// 代理费
		$agent_fee['agent_fee'] = "";
		$agent_rate=$this->line_model->add_order_agent_rate($ll_id); 
		$data['agent_rate']=$agent_rate[0]['agent_rate'];
	    if($expert_info[0]['expert_type']=='2'){
			  	$agent_fee['agent_fee'] = "0";//若专家是供应商
	     }else {
			  	if ($agent_rate) {	
			  		$agent_fee['agent_fee'] = $agent_rate[0]['agent_rate'] * ($data['total_price']);//-$insurance_price); //实际金额-保险
			  	}
		 }
		$info=$this->line_model->add_order_info($ll_id,$ee_id);
	    if ($info) {
				if (isset ( $agent_fee['agent_fee'] )) {
						$data = array_merge ( $data, $info[0], $agent_fee );
				}
		} else {
				$this->__errormsg ('信息有误');
		}
		$status = $this->db->insert ( 'u_member_order', $data );
		//订单插入结束
		//下单记录
		if (! empty ( $status )) {
				$order_id = $this->db->insert_id ();
				$log = array(
						'order_id' => $order_id,
						'op_type' => 0,
						'userid' => $data['memberid'],
						'content' => '会员自己下单',
						'addtime' => $data['addtime']
		);
		$status = $this->db->insert ( 'u_member_order_log', $log );
		$status_attach = $this->db->insert ( 'u_member_order_attach', array('orderid'=>$order_id) );
		if (empty ( $status)) {
			$this->result_code = "4000";
			$this->result_msg = "插入用户日志数据或订单附表失败";
			$lastData['rows'] = "";
			$this->result_data = $lastData;
			$this->resultJSON = json_encode ( array(
					"msg" => $this->result_msg,
					"code" => $this->result_code,
					"data" => $this->result_data,
					"total" => "0"
			) );
			echo $this->resultJSON;
			exit ();
		}
		//保险
	 if(!empty($insuranceJson)){
		$this->load->model("common/u_order_insurance_model","u_order_insurance");
		foreach ($insuranceJson as $insu=>$insu_value){
			$insu_data=array('order_id'=>$order_id,
					        'insurance_id'=>$insu_value['insurance_id'],
					        'number'=>$insu_value['insurance_num'],
					        'amount'=>$insu_value['insurance_price']*$insu_value['insurance_num']
			 );
			$insu_result=$this->u_order_insurance->insert($insu_data);
		}
	 }
		//游客信息		
		if (! empty ( $touristList )) {
			foreach ( $touristList as $k => $v ) {
				$tour['name'] = isset($v['name'])? $v['name']:$this->__errormsg 						(' 游客姓名不能为空！');
				$tour['certificate_type'] = isset($v['cardtype'])? $v['cardtype']:$this->__errormsg 	(' 游客证件类别不能为空！');
				$tour['certificate_no'] = isset($v['cardnum'])? $v['cardnum']:$this->__errormsg 		(' 证件号码不能为空！');
				$tour['sex'] = isset($v['sex'])? $v['sex']:$this->__errormsg 							(' 性别不能为空！');
				$this->load->helper("regexp");
				if (!regexp('cid' ,$tour['certificate_no'])) {	$this->__errormsg 						('请填写正确的身份证号');	}
				$tour['telephone'] = isset($v['phone'])? $v['phone']:$this->__errormsg 					(' 游客手机号不能为空！');
				$tour['birthday'] = isset($v['birthtime'])? $v['birthtime']:$this->__errormsg 			(' 游客出生日期不能为空！');
				if((empty($v['enname'])) && (empty($v['issueAddr'])) && (empty($v['issuetime'])) && (empty($v['validtime'])) ){
					$tour['enname'] ='';
					$tour['sign_place']='';
					$tour['sign_time']='';
					$tour['endtime'] ='';
				}else{
					$tour['enname'] = isset($v['enname'])? $v['enname']:$this->__errormsg 				(' 游客英文名字不能为空！');
					$tour['sign_place'] = isset($v['issueAddr'])? $v['issueAddr']:$this->__errormsg 	(' 签发地不能为空！');
					$tour['sign_time'] = isset($v['issuetime'])? $v['issuetime']:$this->__errormsg 		(' 签发日期不能为空！');
					$tour['endtime'] = isset($v['validtime'])? $v['validtime']:$this->__errormsg 		(' 有效期不能为空！');	
				}
				$tour['member_id'] = $m_id;
				$tour['addtime'] = date ( 'Y-m-d H:i:s', time () );
				$status = $this->db->insert ( 'u_member_traver', $tour );
				$traver_id = $this->db->insert_id ();
				// 订单关联的出游人信息
				$order_man = array(		'order_id' => $order_id,	'traver_id' => $traver_id		);						
				$status = $this->db->insert ( 'u_member_order_man', $order_man );
			}
		  }else{
			  $this->__errormsg ('游客信息不能为空！');
		  }				
		// $this->db->trans_complete(); 
		if ($this->db->trans_status() === TRUE)
		{
			$this->db->trans_commit();
		}
		else
		{
			$this->db->trans_rollback();//事务回滚
			$this->__errormsg ();
		}
		//事务结束
		$this->result_code = "2000";
		$this->result_msg = "success";
		$lastData['rows'] = array(
				0 => array(
						'orderid' => $order_id,
						// 'insurance'=>isset($insurance)? $insurance:'',
						// 'order_price'=>$data['order_price'],
						// 'jifen'=>$data['jifenprice'],
						// 'coupon'=>isset($coupon_one)? $coupon_one:'',
						// 'total_price'=>$data['total_price'],
						'name'=>$reData_member['nickname'],
						'phone'=>$reData_member['mobile'],
						'expertphone'=>$reData_expert['mobile'],
				        'order_sn'=>$ordersn
				)
		);
		$this->result_data = $lastData;
		$this->resultJSON = json_encode ( array(
				"msg" => $this->result_msg,
				"code" => $this->result_code,
				"data" => $this->result_data,
				"total" => "0"
		) );
		echo $this->resultJSON;
		exit ();
	} else {
		$this->__errormsg ('订单生成失败');
	}
		
	}
/*
*
*        do     order       success     订单成功
*
*        by     zhy
*
*        at     2015年x月x日 x:x:x
*
*/
	public function cfgm_book_success() {
		$order_id = $this->input->post ( 'orderid' );
		is_numeric($order_id)? ($order_id):$this->__errormsg 						('tip is null !');
		$this->db->select ( 'mo.ordersn,mo.id,m.nickname,e.realname,e.small_photo,e.mobile' );
		$this->db->from ( 'u_member_order AS mo' );
		$this->db->join ( 'u_expert AS e', 'e.id=mo.expert_id', 'left' );
		$this->db->join ( 'u_member AS m', 'm.mid=mo.memberid', 'left' );
		$this->db->where ( array(	'mo.id' => $order_id 	) );
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
		$this->__outmsg ( $reDataArr );
	}
	
/*
*
*        do     show order      订单展示
*
*        by     zhy
*
*        at     2015年x月x日 x:x:x
*
*/
	public function cfgm_order_show() {
		$order_id = $this->input->post ( 'orderid' );		
		is_numeric($order_id)? ($order_id):$this->__errormsg 						('tip is null !');
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model','at_model');
		$result = $this->at_model->result ( array('access_token' => $token),null,null,null,'arr',null,'mid' );
		$m_id = $result[0]['mid'];
		$this->db->select ( 'mo.id,mo.productname,mo.usedate,mo.total_price,mo.litpic,SUM(mo.dingnum+mo.childnum+mo.childnobednum+mo.oldnum) AS people' );
		$this->db->from ( 'u_member_order AS mo' );
		$this->db->where ( array(
				'mo.id' => $order_id, 
				'mo.memberid' => $m_id, 
				'mo.status' => 5 
		) );
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
		$this->__outmsg ( $reDataArr );
	}
/*
*
*        do     comment     评论
*
*        by     zhy
*
*        at     2016年3月3日 10:32:11
*
*/
	public function cfgm_submit_comment() {
		$pics = "";
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model','at_model');
		$result = $this->at_model->result ( array('access_token' => $token),null,null,null,'arr',null,'mid' );
		$m_id = $result[0]['mid'];
		$data['orderid'] = $order_id = intval ( $this->input->post ( 'order_id', true ) );
		$data['score1'] = intval ( $this->input->post ( 'dyfw', true ) );     //导游服务
		$data['score3'] = intval ( $this->input->post ( 'cyzs', true ) );     //餐饮住宿
		$data['score2'] = intval ( $this->input->post ( 'xcap', true ) );     //行程安排
		$data['score4'] = intval ( $this->input->post ( 'lyjt', true ) );     //旅游交通
		$data['score5'] = intval ( $this->input->post ( 'zytd', true ) );     //专业态度
		$data['score6'] = intval ( $this->input->post ( 'fwtd', true ) );     //服务态度
		$data['content'] = $this->input->post ( 'estimate', true );       //线路评价
		$data['expert_content'] = $this->input->post ( 'expert_content', true );   //管家评价
		$data['isanonymous'] = intval ( $this->input->post ( 'is_anonymity', true ) );        //匿名评价
		$data['avgscore1'] =$this->input->post ( 'lineavg', true );  // 线路综合评分
		$data['avgscore2'] = ($data['score5'] + $data['expertavg']) / 2; // 专家综合评分                                                        
		$data['memberid'] = $m_id;
		$data['channel'] = 1;
		$data['isshow'] = 1;
		$data['addtime'] = date ( 'Y-m-d H:i:s', time () );
		$this->load->model ( 'order_model' );
		$order = $this->order_model->row ( array(
				'id' => $order_id 
		) );
		if ($order) {
			$data['expert_id'] = $order['expert_id'];
			$data['line_id'] = $order['productautoid'];
		} else {
			$this->__errormsg ( 'order is not exist' );
		}
		
		if (empty ( $data['orderid'] ) || empty ( $data['score1'] ) || empty ( $data['score2'] ) || empty ( $data['score3'] ) || empty ( $data['score4'] ) || empty ( $data['score5'] ) || empty ( $data['score6'] ) || empty ( $data['content'] )) {
			$this->__errormsg ( 'data cannot be null' );
		}
		// 上传图片
		if ($_FILES) {
			$path = "./file/c/share/image/";
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
					$pics .= "/file/c/share/image/" . $fx_pic . $dh;
				}
			}
			$data['pictures'] = $pics;
			$data['haspic'] = 1;
		}
		$this->load->model ( 'common/cfg_member_point_model',"cfg_member_point" );
		$this->load->model ( 'common/u_member_model',"u_member" );
		$line_upload_img=$this->cfg_member_point->row(array('code'=>'COMMENT_PIC','isopen'=>'1')); //上传图片送积分
		$line_text_comment=$this->cfg_member_point->row(array('code'=>'COMMENT_TEXT','isopen'=>'1')); //文字评价送积分
		$line_more_text_comment=$this->cfg_member_point->row(array('code'=>'COMMENT_TEXT_1','isopen'=>'1')); //超过30文字送积分
		$line_star_comment=$this->cfg_member_point->row(array('code'=>'COMMENT_NO_TEXT','isopen'=>'1')); //星级评价送积分
		$total_point=0;//总积分
		if (!empty ( $data['score1'] ) && !empty ( $data['score2'] ) && !empty ( $data['score3'] ) && !empty ( $data['score4'] ) ) {
		    $total_point+=isset($line_star_comment['value'])?$line_star_comment['value']:'0';
		}
		if(!empty($pics))
		{
		    $total_point+=isset($line_upload_img['value'])?$line_upload_img['value']:'0';
		}
		if(!empty($data['content']))
		{
		    if(mb_strlen($data['content'])<30)
		    {
		        $total_point+=isset($line_text_comment['value'])?$line_text_comment['value']:'0'; //不超过30字
		    }
		    else
		    {
		        $total_point+=isset($line_more_text_comment['value'])?$line_more_text_comment['value']:'0'; //超过30字
		    }
		}
		$this->db->trans_start();//事务开启
		$status = $this->db->insert ( 'u_comment', $data );
		if ($status) {
			    $this->db->update ( 'u_member_order', array('status' => 6), array('id' => $data['orderid'] ) );
		}
			$one=$this->u_member->row(array('mid'=>$m_id));
			$jifen=isset($one['jifen'])?$one['jifen']:'0';
			$update=$this->u_member->update(array('jifen'=>$total_point+$jifen),array('mid'=>$m_id));
			//积分记录
			$this->load->model('common/u_member_point_log_model','u_member_point_log');
			$logArr=array(
			        'member_id'=>$m_id,
			        'point_before'=>$jifen,
			        'point_after'=>$total_point+$jifen,
			        'point'=>$total_point,
			        'content'=>'订单点评赠送积分',
			        'addtime'=>date ( 'Y-m-d H:i:s', time () )
			);
			if($update) //送积分成功后，才存记录
			{
			    $this->u_member_point_log->insert($logArr);
			}
			$this->db->trans_complete();//事务结束
			if ($this->db->trans_status() === TRUE)
			{
			    $this->db->trans_commit();
			}
			else
			{
			    $this->db->trans_rollback();//事务回滚
			    $this->__errormsg('评价失败');
			}
			
			$this->__successmsg ();
		}
	
/*
*
*        do     show    customize       定制列表
*
*        by     zhy
*
*        at     2016年1月11日 15:19:51
*
*/
// 	public function cfgm_customize_info() {
// 	    $page = intval ( $this->input->post ( 'page', true ) );
// 	    $page_size = intval ( $this->input->post ( 'pagesize', true ) );
// 	    $page_size = empty ( $page_size ) ? 6 : $page_size;
// 	    $page = $page=='0'? 1 : $page;
// 	    $from = ($page - 1) * $page_size;
// 	    $sql=   " SELECT c.id ,c.question,c.pic,c.budget,c.people,	eg.title  AS grade,e.realname,e.nickname,e.small_photo,e.id AS expert_id  FROM u_customize_answer AS ca    LEFT JOIN u_customize AS c ON ca.customize_id=c.id   LEFT JOIN u_expert AS e ON ca.expert_id=e.id     left join u_expert_grade as eg on e.grade=eg.grade   WHERE ca.isuse=1 and c.status = 3 and e.status=2    order by c.id desc     limit {$from},{$page_size}  ";
// 	    $query =  $this->db->query( $sql );
// 	    $data['line_list'] = $query->result_array ();
// 	    if(empty( $data['line_list'] )){  $this->__outmsg ($data['line_list']);}
// 	    $sql= rtrim($sql, "limit {$from},{$page_size} ");
// 	    $query =  $this->db->query( $sql );
// 	    $roes= $query->num_rows ();
// 	    $total= ceil( $roes/$page_size);
// 	    $data=array(
// 	            'this_page' =>$from,
// 	            'page' => $page_size,
// 	            'result' => $data['line_list'],
// 	    ) ;
// 	    $this->__outmsg ($data,$len=$roes);
// 	}
/*
*
*        do     customize   update  status
*
*        by     zhy
*
*        at     2016年3月3日 10:42:19
*
*/
	public     function  update_status_del(){
	       $token = $this->input->post ( 'number', true );
	        $this->check_token ( $token );
	        $cid = $this->input->post ( 'cid', true );
	        is_numeric($cid)? ($cid):$this->__errormsg 						('tip is null !');
	        $this->load->model('common/u_customize_model','customize_model');
	        $result=$this->customize_model->update(array('status'=>'-2'),array('id'=>$cid));
	        if($result) {
	            echo json_encode(array('code'=>2000 ,'msg' =>'取消成功!',));
	        }else{
	            echo json_encode(array('code'=>4000 ,'msg' =>'取消失败!',));
	        }
	}
/*
*
*        do     customize   info    定制详情
*
*        by     zhy
*
*        at     2016年1月12日 14:16:51
*
*/
	public function cfgm_customize_info() {
		$c_id = $this->input->post ( 'cid', true );
	    is_numeric($c_id)? ($c_id):$this->__errormsg 						('tip is null !');
		$sql = "SELECT ca.id as ca_id,c.pic AS litpic,c.days,c.question AS question,c.addtime AS addtime,c.budget AS budget,e.small_photo AS small_photo,e.nickname AS expert_name,e.people AS people_count,e.avg_score AS avg_score,e.total_score AS total_score,eg.title AS e_grade,(SELECT GROUP_CONCAT(d.kindname SEPARATOR ',') FROM u_destinations AS d WHERE FIND_IN_SET(d.id,e.expert_dest)>0) AS good_dest FROM u_customize AS c LEFT JOIN u_customize_answer AS ca ON c.id=ca.customize_id LEFT JOIN u_expert AS e ON ca.expert_id=e.id LEFT JOIN u_expert_grade AS eg ON e.grade=eg.grade WHERE c.id= {$c_id}  AND ca.isuse=1 " ;
		$query = $this->db->query ( $sql );
		$reDataArr = $query->result_array ();
		if ($reDataArr) {
			$ca_id = $reDataArr[0]['ca_id'];
		} else {
			$this->__errormsg ();
		}
		$sql = "SELECT day,breakfirsthas,lunchhas,supperhas,hotel,jieshao ,`cjp`.`pic` AS pic FROM u_customize_jieshao as cj LEFT JOIN `u_customize_jieshao_pic` AS cjp ON `cj`.`id`=`cjp`.`customize_jieshao_id` WHERE customize_answer_id={$ca_id} ORDER BY day";
		$query = $this->db->query ( $sql );
		$reDataArrs = $query->result_array ();
		foreach ( $reDataArrs as $key => $val ) {
		    foreach ( $val as $k => $v ) {
		    		if ($k == "pic") {
		                if ($v) {
                                $val[$k] = explode ( ";", $v );
                                foreach ($val[$k] as $k){
                                    if(!empty($k)){
                                        $val['pics'][]="http://" . $_SERVER['HTTP_HOST'].$k;
                                    }
                                }
                              $val['pic']='1';
                         }
		        }
		    }
		    $reDataArrs[$key] = $val;
		}
		$arr ['fangan'] = $reDataArrs;
		if ($arr['fangan']) {
			$reDataArr = array_merge ( $reDataArr[0], $arr );
		} else {
			$this->__errormsg ();
		}
		$this->__outmsg ( $reDataArr, 1 );
	}
/*
*
*        do     method      需求
*
*        by     zhy
*
*        at     2015年x月x日 x:x:x
*
*/
	public function cfgm_play_method() {
		$type = $this->input->post ( 'type', true );
		if ($type == 'hotel') { // 酒店星级
			$query = $this->db->query ( "select dict_id,description from u_dictionary where pid=7" );
			$data['hotel'] = $query->result_array ();
		} elseif ($type == 'method') { // 出游方式
			$query = $this->db->query ( "select dict_id,description from u_dictionary where pid=39" );
			$data['method'] = $query->result_array ();
		} elseif ($type == 'theme') { // 旅游主题
			$query = $this->db->query ( "select id,name from u_theme" );
			$data['theme'] = $query->result_array ();
		} elseif ($type == 'shop') { // 购物要求
			$query = $this->db->query ( "select dict_id,description from u_dictionary where pid=55" );
			$data['shop'] = $query->result_array ();
		} elseif ($type == 'meal') { // 用餐要求
			$query = $this->db->query ( "select dict_id,description from u_dictionary where pid=59" );
			$data['meal'] = $query->result_array ();
		} else {
			$data = array();
		}
		$this->__outmsg ( $data );
	}
/*
*
*        do     customize       定制订单
*
*        by     zhy
*
*        at      2015年x月x日 x:x:x
*

	
	public function cfgm_ls_customize() {
		$this->load->library ( 'session' );
		$code_mobile = $this->session->userdata ( 'mobile' );
		$code_yzm = $this->session->userdata ( 'code' );
		if ($token = $this->input->post ( 'number', true )) {
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model','at_model');
		$user = $this->at_model->result ( array('access_token' => $token),null,null,null,'arr',null,'mid' );
		$m_id = $user[0]['mid'];	
		}
		$password = "";
// 		$yzm = $this->input->post ( 'yzm', true ); // 验证码
// 		$data['theme'] = $theme = $this->input->post ( 'theme', true );
// 		$data['startplace'] = $from = $this->input->post ( 'from', true );
// 		$data['trip_way'] = $method = $this->input->post ( 'method', true );
// 		$data['people'] = $people = $this->input->post ( 'people', true );
// 		$data['startdate'] = $date = $this->input->post ( 'date', true );
// 		$data['days'] = $days = $this->input->post ( 'days', true );
// 		$data['budget'] = $budget = $this->input->post ( 'budget', true );
// 		$end = $this->input->post ( 'end', true );
// 		// $label = $this->input->post ( 'label', true );
// 		$data['hotelstar'] = $hotel = $this->input->post ( 'hotel', true );
// 		$data['isshopping'] = $shop = $this->input->post ( 'isshop', true );
// 		$data['catering'] = $meal = $this->input->post ( 'meal', true );
// 		$data['beizhu'] = $beizhu = $this->input->post ( 'beizhu', true );
// 		$data['linkname'] = $linkname = $this->input->post ( 'linkname', true );
// 		$data['linkphone'] = $mobile = $this->input->post ( 'mobile', true );
// 		$data['linkweixin'] = $weixin = $this->input->post ( 'weixin', true );

		$data ['from'] = $this->input->post ( 'from', true );
		$data ['estimatedate'] = $this->input->post ( 'estimatedate', true );
		$data ['test1id'] = $this->input->post ( 'test1id', true );       //国家
		$data ['test2id'] = $this->input->post ( 'test2id', true );
		$data ['method'] = $this->input->post ( 'method', true );
		$another=$this->input->post ( 'another_choose', true );
		$data['another_choose']=rtrim($another, ",");
		$data ['question'] = $this->input->post ( 'question', true );
		$data ['people'] = $this->input->post ( 'people', true );
		$data ['childnum'] = $this->input->post ( 'cp', true );
		$data ['childnobednum'] = $this->input->post ( 'cnp', true );
		$data ['oldman'] = $this->input->post ( 'olp', true );
		$data ['roomnum'] = $this->input->post('roomnum',true);
		$data ['startdate'] = $startdate = $this->input->post ( 'dayr', true );
		$data ['days'] = $this->input->post ( 'days', true );
		$data ['budget'] = $this->input->post ( 'budget', true );
		$data ['end'] = $this->input->post ( 'end', true );
		$isend=$data ['end'].$data ['test2id'];
		$data['isend']=rtrim($isend, ",");
		$end=$data['isend'];
		$data ['hotel'] = $this->input->post ( 'hotel', true );
		$data ['room_require'] = $this->input->post('room_require',true);
		$data ['catering'] = $this->input->post('catering',true);
		$data ['isshopping'] = $this->input->post ( 'isshopping', true );
		$data ['service_range'] = $this->input->post('beizhu',true);
		$data ['meal'] = $this->input->post ( 'meal', true );
		$data ['beizhu'] = $this->input->post ( 'beizhu', true );
		$data ['linkname'] = $this->input->post ( 'linkname', true );
		$data ['mobile'] =$pwd= $this->input->post ( 'mobile', true );
		$data ['weixin'] = $this->input->post ( 'weixin', true );
		$data ['yzm'] = $this->input->post ( 'yzm', true ); //验证码
		$data ['total_people']=$this->input->post('total_people',true);
		$testtime=date("Y-m-d");
		if (empty ( $data ['from'] ) || empty ( $data ['estimatedate'] ) || empty ( $data ['test1id'] ) || empty ( $data ['test2id'] ) || empty ( $data ['method'] ) || empty ( $data['another_choose'] ) || empty ( $data ['startdate']  ) || empty ( $data ['service_range'] ) || empty ( $data ['linkname'] ) || empty ( $data ['mobile']  ) || empty ( 	$data ['yzm']  ) ) {
		    $this->__errormsg ();
		}
		
		
		
		$this->db->trans_start();
		
		if (empty($m_id)) {
		    //var_dump('3');
		    //没有登陆，验证此手机号是否注册，若注册则自动登陆，若没有则自动注册一个账号
		    $this->load->model ( 'member_model' );
		    $member_info = $this ->member_model ->row(array('mobile' =>$data['mobile']));
		    if (!empty($member_info)) {
		        $m_id = $member_info['mid'];

		    }else {
		        $this->load->model('common/cfg_member_point_model','cfg_member_point');
		        $point=$this->cfg_member_point->row(array('code'=>'REGISTER','isopen'=>'1'));
		        $point_num=isset($point['value'])?$point['value']:'0';//积分数
		        $member_insert_id = array (
		                'truename' => $data ['linkname'],
		                'loginname' => $mobile,
		                'nickname'=>$mobile,
		                'mobile' => $mobile,
		                'pwd' => md5 ( $mobile ),
		                'jointime' =>  date('Y-m-d H:i:s' ,$time),
		                'sex' => - 1,
		                'litpic' => '/file/c/img/face.png' ,
		                'jifen' =>	$point_num,
		                'logintime' => date('Y-m-d H:i:s' ,$time),
		                'loginip'=>$this->get_client_ip(),
		        );
		        $this->member_model->insert ( $member_insert_id );
		        $m_id = $this->db->insert_id ();
		        //写入积分变化表
		        if ($member_insert_id['jifen'] >0)   {
		            $memberLogArr = array(
		                    'member_id' =>$m_id,
		                    'point_before' =>0,
		                    'point_after' =>$member_insert_id['jifen'],
		                    'point' =>$member_insert_id['jifen'],
		                    'content' =>'注册赠送积分',
		                    'addtime' =>$member_insert_id['logintime']
		            );
		            $this ->db ->insert('u_member_point_log' ,$memberLogArr);
		        }
		        $this ->member_coupon(1, $user_id);
		        //发送短信给用户提示
		        $this ->load->model('common/u_sms_template_model','template_model');
		        $smsData = $this ->template_model ->row(array('msgtype' =>'auto_reg'));
		        if (!empty($smsData['msg'])) {
		            $msg = str_replace("{#LOGINNAME#}", $mobile ,$smsData['msg']);
		            $msg = str_replace("{#PASSWORD#}", $pwd ,$msg);
		            $this ->Inside_send_message($mobile ,$msg);
		        }else{}
		    }
		}
		
		
		if ($mobile) {
			if (! preg_match ( "/1[34578]{1}\d{9}$/", $mobile )) {
				$this->__errormsg ();
			}
			if (! ($code_mobile == $mobile) || ! ($code_yzm == $yzm)) {
				$this->__errormsg ();
			}
			
			$this->load->model ( 'member_model' );
			$member = $this->member_model->row ( array(
					'mobile' => $mobile 
			) );
			if (! $member) {
				for($i = 0; $i < 6; $i ++) {
					$password .= mt_rand ( 0, 9 );
				}
				$user = array(
						'loginname' => '', 
						'pwd' => md5 ( $password ), 
						'mobile' => $mobile, 
						'jointime' => time (), 
						'sex' => - 1 ,
						'jifen' =>2000
				);
				$query = $this->db->query ( "select * from u_member where mobile={$mobile}" );
				$result = $query->result_array ();
				if (! $result) {
					$this->db->insert ( 'u_member', $user );
					$m_id = $this->db->insert_id ();
				}
			} else {
				$m_id = $member['mid'];
			}
		}
		
		if ($end) {
			if (is_array ( $end )) {
				foreach ( $end as $key => $val ) {
					$end_str .= $val . ",";
				}
				$data['endplace'] = $end_str;
			} else {
				$data['endplace'] = $end;
			}
		}
		
		// if ($label) {
		// if (is_array ( $label )) {
		// foreach ( $label as $key => $val ) {
		// $label_str .= $val . ",";
		// }
		// $data['attrs'] = $label_str;
		// } else {
		// $data['attrs'] = $label;
		// }
		// }
		
// 		$data['member_id'] = $m_id;
// 		$data['user_type'] = 0;
// 		$data['addtime'] = date ( 'Y-m-d H:i:s', time () );
// 		$month = date ( 'm', strtotime ( $date ) );
// 		if ($m = intval ( $month )) {
// 			$month = $m;
// 		}
// 		$data['month'] = $month;
// 		$szx = date ( 'd', strtotime ( $date ) );
// 		if ($d = intval ( $szx )) {
// 			$szx = $d;
// 		}
// 		$data['date'] = $szx;
// 		$data['status'] = 0;
// 		$data['grabcount'] = 0;
// 		$data['pic'] = "/file/b2/upload/img/customize.png";
// 		$data['expert_id'] = 0;
		
// 		$status = $this->db->insert ( 'u_customize', $data );
// 		if ($status) {
// 			$this->__successmsg ();
// 		}
		
		
		

		$data = array (
		        'member_id' => $c_userid,
		        'startplace' => $data ['from'],
		        'endplace' => $data ['isend'],
		        'question' => $data ['question'],
		        'month' => $data ['month'],
		        'date' => $data ['date'],
		        'trip_way'=>$data ['method'],
		        'another_choose'=>$data['another_choose'],
		        'people' => $data ['people'],
		        'childnum' => $data ['childnum'],
		        'childnobednum' => $data ['childnobednum'],
		        'oldman' => $data ['oldman'],
		        'roomnum'=>$data ['roomnum'],
		        'days' => $data ['days'],
		        'startdate' => $data ['startdate'],
		        'estimatedate'=>$data ['estimatedate'],
		        'budget' => $data ['budget'],
		        'hotelstar' => $data ['hotel'],
		        'room_require'=>$data ['room_require'],
		        'isshopping' => $data ['isshopping'],
		        'service_range' => $data ['beizhu'],
		        'catering' => $data ['meal'],
		        'linkname' => $data ['linkname'],
		        'linkphone' => $data ['mobile'],
		        'linkweixin' => $data ['weixin'],
		        'custom_type' =>$data['test1id'],
		        //'service_range' => $data ['beizhu'],
		        'total_people'=>$data['total_people'],
		        'addtime' => date ( 'Y-m-d H:i', time () ),
		        'status' => '0',
		        'user_type'=>'0',
		        'pic'=>'/file/b2/upload/img/customize.png'
		);
		$this->load->model('common/u_customize_model','u_customize');
		$customize_id = $this->u_customize->insert ($data );
		$this->load->model('common/u_customize_dest_model','u_customize_dest');
		$endplace = explode(',',$end);
		for($i=0;$i<count($endplace);$i++){
		    $this->u_customize_dest->insert(array('customize_id'=>$customize_id,'dest_id'=>$endplace[$i]));
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
		    return false;
		}
		else	{
		    if (! empty ( $customize_id )) {
		        if(!empty($token)){ 
		            $this->__successmsg ();
		        }else{
		            $reDataArrssdsd = $this->db->query ( "SELECT loginname,pwd FROM `u_member` where mid={$m_id} ORDER BY id limit 1; ")->row_array ();
		            $this->__outmsg ( $reDataArrssdsd );
		        }
		    }
		}
		
	}
*/	
/*
*
*        do     order       (ps :  nouser)      订单
*
*        by     zhy
*
*        at     2015年x月x日 x:x:x
*
*/
	public function cfgm_walk_count() {
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model','at_model');
		$user = $this->at_model->result ( array('access_token' => $token),null,null,null,'arr',null,'mid' );
		$m_id = $user[0]['mid'];
		$sql = "SELECT 
(SELECT count(*) FROM u_member_order AS mb_od LEFT JOIN u_member AS mb ON mb_od.memberid = mb.mid WHERE mb.mid ={$m_id} AND ispay=0 AND (mb_od.status=1 or mb_od.status=0) AND mb_od.ispay=0 AND TIMESTAMPDIFF(HOUR,mb_od.addtime,NOW())<24) AS wait_pay, 
(SELECT count(*) FROM u_member_order AS mb_od LEFT JOIN u_member AS mb ON mb_od.memberid = mb.mid WHERE mb.mid ={$m_id} AND (mb_od.status=1 or mb_od.status=4) AND ispay>0) AS wait_walk,
(SELECT count(*) FROM u_member_order AS mb_od LEFT JOIN u_member AS mb ON mb_od.memberid = mb.mid WHERE mb.mid ={$m_id} AND mb_od.status=5 AND ispay>0) AS wait_comment,
(SELECT count(*) FROM u_refund AS r LEFT JOIN u_member_order AS mo ON r.order_id=mo.id WHERE r.refund_type=0 AND r.status=0 AND r.refund_id={$m_id}) AS wait_tk 
FROM u_member_order AS mb_od WHERE mb_od.memberid={$m_id}  order by mb_od.memberid  limit 1        ";
		$query = $this->db->query ( $sql );
		$reDataArr['four'] = $query->row_array ();	
		$query = $this->db->query ( "select mid,nickname,litpic from u_member where mid={$m_id} order by mid limit 1 " );
		$reDataArr['user'] = $query->row_array ();	
		$this->__outmsg ( $reDataArr);
	}
	
/*
*
*        do     line        线路
*
*        by     zhy
*
*        at     2015年x月x日 x:x:x
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
		$this->load->model ( 'common/u_access_token_model','at_model');
		$user = $this->at_model->result ( array('access_token' => $token),null,null,null,'arr',null,'mid' );
		$m_id = $user[0]['mid'];
		$this->db->select ( "c.id,c.theme,c.people,ceil(c.budget/c.people) AS budget,c.pic" );
		$this->db->from ( 'u_customize AS c' );
		$this->db->where ( array(
				'c.member_id' => $m_id, 
				'c.status >=' => 0 
		) );
		$this->db->limit ( $page_size, $from );
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
		$this->__outmsg ( $reDataArr );
	}
/*
*
*        do     travel      我的游记
*
*        by     zhy
*
*        at     2015年x月x日 x:x:x
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
		$this->load->model ( 'common/u_access_token_model','at_model');
		$user = $this->at_model->result ( array('access_token' => $token),null,null,null,'arr',null,'mid' );
		$m_id = $user[0]['mid'];
		$this->db->select ( "tn.cover_pic,tn.title,tn.addtime,m.loginname" );
		$this->db->from ( 'travel_note AS tn' );
		$this->db->join ( 'u_member AS m', 'm.mid=tn.userid', 'left' );
		$this->db->where ( array(
				'tn.userid' => $m_id, 
				'tn.is_show' => 1 
		) );
		$this->db->limit ( $page_size, $from );
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
		$this->__outmsg ( $reDataArr );
	}
/*
*
*        do     travel  detail      游记详情
*
*        by     zhy
*
*        at     2015年x月x日 x:x:x
*
*/
	public function cfgm_travel_detail() {
		$tn_id = $this->input->post ( 'tnid' ); 
		is_numeric($tn_id)? ($tn_id):$this->__errormsg 						('标识不能为空！');
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model','at_model');
		$user = $this->at_model->result ( array('access_token' => $token),null,null,null,'arr',null,'mid' );
		$m_id = $user[0]['mid'];
		$this->db->select ( "tn.cover_pic,tn.title,tn.tags,mo.total_price,(select count(*) from u_line_jieshao AS lj left join u_member_order AS mo on lj.lineid=mo.productautoid) AS days,tn.content1 AS chi,tn.content2 AS zhu,tn.content3 AS xing,tn.content4 AS gou,(select tnp.pic from travel_note_pic AS tnp where tnp.pictype=1 and tnp.note_id={$tn_id}) AS chi_pic,(select tnp.pic from travel_note_pic AS tnp where tnp.pictype=2  and tnp.note_id={$tn_id}) AS zhu_pic,(select tnp.pic from travel_note_pic AS tnp where tnp.pictype=3  and tnp.note_id={$tn_id}) AS xing_pic,(select tnp.pic from travel_note_pic AS tnp where tnp.pictype=4 and tnp.note_id={$tn_id}) AS gou_pic" )->from ( 'travel_note AS tn' )->join ( 'u_member_order AS mo', 'mo.id=tn.order_id', 'left' )->where ( array(
				'tn.userid' => $m_id, 
				'tn.id' => $tn_id, 
				'tn.is_show' => 1 
		) );
		$reDataArr = $this->db->get ()->result_array ();
		foreach ( $reDataArr as $key => $val ) {
			foreach ( $val as $k => $v ) {
				if ($k == "chi_pic" || $k == "zhu_pic" || $k == "xing_pic" || $k == "gou_pic") {
					if ($v) {
						$val[$k] = explode ( ";", $v );
					}
				}
			}
			$reDataArr[$key] = $val;
		}
		$this->__outmsg ( $reDataArr );
	}
/*
*
*        do     note    comment     list
*
*        by     zhy
*
*        at     2016年3月3日 11:08:09
*
*/
	public     function cfgm_note_comment_list(){
	    $page = intval ( $this->input->post ( 'page', true ) );
	    $page_size = intval ( $this->input->post ( 'pagesize', true ) );
	    $page_size = empty ( $page_size ) ? 6 : $page_size;
	    $page = $page=='0'? 1 : $page;
	    $from = ($page - 1) * $page_size;
	    $eid=$this->input->post("eid");
	    is_numeric($eid)? ($eid):$this->__errormsg 						('标识不能为空！');
	    $sql=   "     SELECT `m`.`mid` AS m_id, `tn`.`id` AS note_id, `m`.`litpic` AS litpic, `m`.`nickname` AS nickname, `tnr`.`reply_content` AS reply_content, `tnr`.`addtime` AS publish_time    
FROM (`travel_note_reply` AS tnr)     
LEFT JOIN `travel_note` AS tn ON `tnr`.`note_id`=`tn`.`id`      
LEFT JOIN `u_member` AS m ON `tnr`.`member_id`=`m`.`mid`    
WHERE `tn`.`id` = {$eid} ORDER BY `tnr`.`addtime` desc      limit {$from},{$page_size}  ";
	    $query =  $this->db->query( $sql );
	    $data['line_list'] = $query->result_array ();
	    if(empty( $data['line_list'] )){  $this->__outmsg ( $data['line_list']);  }
	    $sql= rtrim($sql, "limit {$from},{$page_size} ");
	    $query =  $this->db->query( $sql );
	    $data_total= $query->num_rows ();
	    $data=array(
	            'cur_page' =>$from,
	            'total' => $page_size,
	            'result' => $data['line_list']
	    ) ;
	    $this->__outmsg ($data, $data_total);
	}
	
/*
*
*        do     share       我的分享
*
*        by     zhy
*
*        at      2015年x月x日 x:x:x
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
		$this->load->model ( 'common/u_access_token_model','at_model');
		$user = $this->at_model->result ( array('access_token' => $token),null,null,null,'arr',null,'mid' );
		$m_id = $user[0]['mid'];
		$sql = "SELECT ls.line_id,ls.content,ls.location,ls.addtime,l.linename,GROUP_CONCAT(lsp.pic) AS pic FROM u_line_share_pic AS lsp,u_line_share AS ls LEFT JOIN u_line AS l ON l.id=ls.line_id WHERE ls.member_id={$m_id} AND ls.id=lsp.line_share_id GROUP BY lsp.line_share_id LIMIT {$from},{$page_size}";
		$query = $this->db->query ( $sql );
		$reDataArr = $query->result_array ();
		foreach ( $reDataArr as $key => $val ) {
			$reDataArr[$key]['pic'] = "";
			if ($val['pic']) {
				$pic_arr = explode ( ',', $val['pic'] );
				$val['pic'] = $pic_arr;
			}
			$reDataArr[$key] = $val;
		}
		$this->__outmsg ( $reDataArr );
	}
/*
*
*        do     Collection      我的记录
*
*        by     zhy
*
*        at     2016年3月4日 14:32:50
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
		$this->load->model ( 'common/u_access_token_model','at_model');
		$user = $this->at_model->result ( array('access_token' => $token),null,null,null,'arr',null,'mid' );
		$m_id = $user[0]['mid'];
		if($loca=='1'){
		    $sql="    SELECT `lc`.`line_id`, `l`.`linename`, `l`.`lineday`, `l`.`lineprice`, `l`.`mainpic`    FROM (`u_line_collect` AS lc)	    LEFT JOIN `u_line` AS l ON `l`.`id`=`lc`.`line_id`    WHERE `lc`.`member_id` =  {$m_id}   limit {$from},{$page_size}      ";
		    $query =  $this->db->query( $sql );
		    $reDataArr= $query->result_array ();
		    if(empty( $reDataArr )){  $this->__outmsg ( $reDataArr);  }
		    $sql= rtrim($sql, "limit {$from},{$page_size} ");
		    $query =  $this->db->query( $sql );
		    $data_total= $query->num_rows ();
		}else{
		    $sql =  " SELECT e.id,e.small_photo,e.nickname,eg.title,e.satisfaction_rate,e.people_count,e.comment_count  FROM u_expert_collect AS ec  	LEFT JOIN u_expert AS e ON ec.expert_id=e.id  LEFT JOIN u_expert_grade AS eg ON e.grade=eg.grade  WHERE ec.member_id= {$m_id}  	ORDER BY ec.addtime  limit {$from},{$page_size}       ";
		    $query =  $this->db->query( $sql );
		    $reDataArr= $query->result_array ();
		    if(empty( $reDataArr )){  $this->__outmsg ( $reDataArr);  }
		    $sql= rtrim($sql, "limit {$from},{$page_size} ");
		    $query =  $this->db->query( $sql );
		    $data_total= $query->num_rows ();
		    foreach ( $reDataArr as $key => $val ) {        foreach ( $val as $k => $v ) {       if ($k == "satisfaction_rate") {        if ($v) {           $val[$k] = round (  $v * 100 );        }      }     }
		        $reDataArr[$key] = $val;
		    }
		}
		$this->__outmsg ( $reDataArr, $data_total);
	}
	
/*
*
*        do     Visit   Record      我的游览记录
*
*        by     zhy
*
*        at     2015年x月x日 x:x:x
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
		$this->load->model ( 'common/u_access_token_model','at_model');
		$user = $this->at_model->result ( array('access_token' => $token),null,null,null,'arr',null,'mid' );
		$m_id = $user[0]['mid'];
		$this->db->select ( 'l.id,l.linename,l.mainpic,l.satisfyscore,l.lineprice' );
		$this->db->from ( 'u_line_browse AS lb' );
		$this->db->join ( 'u_line AS l', 'l.id=lb.line_id', 'left' );
		$this->db->where ( array(	'lb.member_id' => $m_id 	,'l.status'=>2) );
		$this->db->order_by ( "l.addtime", "asc" );
		$this->db->limit ( $page_size, $from );
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
		foreach ( $reDataArr  as $key => $val ) {
		    foreach ( $val as $k => $v ) {
		        if ($k == "satisfyscore") {
		            if ($v) {
		                $val[$k] = round (  $v * 100 );
		            }
		        }
		    }
		    $reDataArr[$key] = $val;
		}
		$this->__outmsg ( $reDataArr );
	}
/*
*
*        do     pay        trip        evaluate        refund       总条数
*
*        by     zhy
*
*        at    2015年x月x日 x:x:x
*
*/
	public function cfgm_order_status() {
		$where = "";
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model','at_model');
		$user = $this->at_model->result ( array('access_token' => $token),null,null,null,'arr',null,'mid' );
		$m_id = $user[0]['mid'];
		$code = $this->input->post ( 'code', true );
		if ($code == 1) { // 待支付
			$where = "AND ( mb_od.status=0 OR mb_od.status=1 ) AND ispay=0 AND TIMESTAMPDIFF(HOUR,mb_od.addtime,NOW())<24";
		} elseif ($code == 2) { // 待出行
			$where = "AND ( mb_od.status=1 OR mb_od.status=4 ) AND ispay>0";
		} elseif ($code == 3) { // 待评价
			$where = "AND mb_od.status=5 AND ispay>0";
		}
		$sql = "SELECT mb_od.id AS mo_id,mb_od.ordersn,l.linetitle as linetitle,mb_od.ispay AS mo_ispay,mb_od.status AS mo_status,mb_od.productname AS linename,mb_od.litpic,(mb_od.dingnum+mb_od.childnum+mb_od.oldnum+mb_od.childnobednum) AS people,mb_od.usedate AS day,mb_od.total_price,CASE WHEN mb_od.ispay = 0 THEN '未支付' WHEN mb_od.ispay = 1 THEN '已首付' WHEN mb_od.ispay = 2 THEN '已支付' END pay_status,CASE WHEN mb_od.id IN (SELECT r.order_id FROM u_refund AS r WHERE r.status=0) AND mb_od.status=-3 THEN '退款审核中' WHEN mb_od.id IN (SELECT r.order_id FROM u_refund AS r WHERE r.status=1) AND mb_od.status=-4 THEN '退款成功' WHEN mb_od.id IN (SELECT r.order_id FROM u_refund AS r WHERE r.status=2) AND mb_od.status=-4 THEN '退款失败' WHEN mb_od.ispay=0 AND TIMESTAMPDIFF(HOUR,mb_od.addtime,NOW())>24 THEN '已经失效' WHEN mb_od.status = -4 THEN '已经取消' WHEN mb_od.status = -3 THEN  '取消中' WHEN mb_od.status = -2 THEN '平台拒绝' WHEN mb_od.status = -1 THEN 'B1拒绝' WHEN mb_od.status = 0 THEN '待留位' WHEN mb_od.status = 1 THEN 'B1已确认留位' WHEN mb_od.status = 2 THEN '用户已付款' WHEN mb_od.status = 3 THEN '平台已确认收款' WHEN mb_od.status = 4 THEN 'B1已控位' WHEN mb_od.status = 5 THEN '出行' WHEN mb_od.status = 6 THEN '点评' WHEN mb_od.status = 7 THEN '已投诉' WHEN mb_od.status = 8 THEN '专家已点评' END order_status FROM u_member_order AS mb_od LEFT JOIN u_member AS mb ON mb_od.memberid = mb.mid left join u_line as l on mb_od.productautoid = l.id WHERE mb.mid={$m_id} {$where} ORDER BY mb_od.addtime DESC,mb_od.status";
		if ($code == 4) { // 退款
			$sql = "SELECT mo.id AS mo_id,mo.ordersn,mo.ispay AS mo_ispay,mo.status AS mo_status,r.id AS r_id,mo.productname AS linename,mo.litpic,l.linetitle AS linetitle,
		    (mo.dingnum+mo.childnum+mo.oldnum+mo.childnobednum) AS people,mo.usedate AS day,mo.total_price,CASE WHEN mo.ispay=3 AND mo.status=-3 THEN '退款中' WHEN mo.ispay=4 AND mo.status=-4 THEN '退款成功' WHEN r.status=2 THEN '退款失败' END order_status FROM u_refund AS r LEFT JOIN u_member_order AS mo ON r.order_id=mo.id LEFT JOIN u_line AS l ON mo.productautoid = l.id
		    WHERE mo.memberid={$m_id} ORDER BY r.addtime DESC";
		}
		$query = $this->db->query ( $sql );
		$reDataArr = $query->result_array ();
		if ($reDataArr) {
			foreach ( $reDataArr as $key => $val ) {
				foreach ( $val as $k => $v ) {
					if ($k == "usedate") {
						$val[$k] = date ( 'Y-m-d', strtotime ( $val[$k] ) );
					}
				}
				$reDataArr[$key] = $val;
			}
		}
		$this->__outmsg ( $reDataArr );
	}
/*
*
*        do     order   details     订单详情
*
*        by     zhy
*
*        at     2016年1月15日 10:59:10
*
*/
	public function cfgm_xs_order() {
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$bj = $this->input->post ( 'bj_id', true );
		is_numeric($bj)? ($bj):$this->__errormsg 						('标识不能为空！');
        //我的订单
		$arr['order'] = $this->db->query ( "  SELECT ul.id as line_id,mo.ordersn,mo.ispay,mo.status,mo.productautoid,mo.productname,mo.litpic,mo.usedate,mo.linkman,mo.linkmobile,mo.linkemail,mo.expert_id,mo.jifenprice,mo.couponprice,mo.order_price,mo.total_price,mo.dingnum,mo.oldnum,mo.childnobednum,mo.childnum, (CASE  WHEN mo.ispay=0 AND TIMESTAMPDIFF(HOUR,mo.addtime,NOW())>24 THEN '已经失效'  WHEN mo.id IN (SELECT r.order_id FROM u_refund AS r WHERE r.status=0) AND mo.status=-3 THEN '退款审核中'  WHEN mo.id IN (SELECT r.order_id FROM u_refund AS r WHERE r.status=1) AND mo.status=-4 THEN '退款成功'  WHEN mo.id IN (SELECT r.order_id FROM u_refund AS r WHERE r.status=2) AND mo.status=-4 THEN '退款失败'  WHEN mo.status = -4 THEN '已经取消'  WHEN mo.status = -3 THEN  '取消中'  WHEN mo.status = -2 THEN '平台拒绝'  WHEN mo.status = -1 THEN 'B1拒绝'  WHEN mo.status = 0 AND mo.ispay=0 THEN '待留位'  WHEN mo.status = 1 AND mo.ispay=0 THEN 'B1已确认留位'  WHEN mo.status = 1 AND mo.ispay=1 THEN '用户已付款'  WHEN mo.status = 1 AND mo.ispay=2 THEN '平台已确认收款'  WHEN mo.status = 4 AND mo.ispay=2 THEN 'B1已控位'  WHEN mo.status = 5 AND mo.ispay=2 THEN '出行'  WHEN mo.status = 6 AND mo.ispay=2 THEN '点评'  WHEN mo.status = 7 AND mo.ispay=2 THEN '已投诉'   END) AS order_status, (SELECT s.cityname FROM u_startplace AS s LEFT JOIN u_line AS l ON s.id=l.startcity LEFT JOIN u_member_order AS mo ON l.id=mo.productautoid WHERE mo.id= {$bj}) AS cf_city , (SELECT l.linetitle FROM u_line AS l LEFT JOIN u_member_order AS mo ON mo.productautoid=l.id WHERE mo.id= {$bj}) AS producttitle, 	 (SELECT SUM(amount) FROM u_order_insurance WHERE order_id= {$bj}) AS insurance_price,ul.overcity 	 FROM u_member_order AS mo LEFT JOIN u_line AS ul ON ul.id=mo.productautoid WHERE mo.id= {$bj}  ")->row_array ();
		if(empty($arr['order'] )){     $this->__outmsg ( $arr['order'] );       }
		$arr['order']['team_free']=$arr['order']['order_price']-$arr['order']['insurance_price']; //出团费用
		$arr['order']['discount']=$arr['order']['jifenprice']+$arr['order']['couponprice']; //已优惠
        // 国内外
		$arr['inou']=substr($arr['order']['overcity'], -1);       if(empty(  $arr['inou'] )){  $arr['overcity']='1'; }
		// 游客信息列表
		$arr['yk'] = $this->db->query ( " select group_concat(mt.id) AS id,group_concat(mt.name) AS name,group_concat(mt.enname) AS enname,group_concat(mt.certificate_type) AS certificate_type,group_concat(mt.sex) AS sex,group_concat(mt.certificate_no) AS certificate_no,group_concat(mt.sign_place) AS sign_place,group_concat(mt.sign_time) AS sign_time,date(mt.endtime) AS endtime,group_concat(mt.isman) AS isman,group_concat(mt.telephone) AS phone,group_concat(mt.birthday) AS birth,ud.description as certificate_des from u_member_traver AS mt left join u_dictionary as ud on ud.dict_id=mt.certificate_type where mt.id in (select mom.traver_id from u_member_order_man AS mom where mom.order_id={$bj}) group by mt.id")->result_array ();
		//发票
		$arr['fa'] = $this->db->query ( "select moi.id as id,mi.invoice_type,mi.invoice_name,mi.invoice_detail,mi.receiver,mi.telephone,mi.address,mi.addtime,mi.member_id,umo.total_price from u_member_order_invoice as moi left join u_member_invoice as mi on moi.invoice_id=mi.id 	left join u_member_order as umo on moi.order_id=umo.id 	where moi.order_id={$bj} ")->result_array ();
		$arr['log'] = $this->db->query ( "				SELECT *  	FROM (`u_member_order_log`)   	WHERE `order_id` = {$bj}	ORDER BY `addtime` desc")->result_array ();
		$arr['expert'] = $this->db->query ( "		SELECT id, mobile, big_photo, small_photo, nickname  	FROM (`u_expert`)  	WHERE `id` =  {$arr['order']['expert_id']}   	ORDER BY `id` ")->row_array ();
		
		$this->__outmsg ( $arr, 1 );
	}
/*
*
*        do     Tourist   message       游客信息
*
*        by     zhy
*
*        at     2016年1月23日 14:05:51
*
*/
	public function cfgm_action_tourist() {
    	$status = 0;
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$bj_id = $this->input->post ( 'bjid', true );     //编辑
		$sc_id = $this->input->post ( 'scid', true );     //插入
		$order_id = $this->input->post ( 'orderid', true ); // 隐藏框
		$data['name'] = $this->input->post ( 'ykname', true );                            //名字
		$data['enname'] = $this->input->post ( 'ae_name', true );       //英文名字
		$isman = $this->input->post ( 'isman', true );                                //性别
		if ($isman == 1) {            	$data['isman'] = 1;        	} elseif ($isman == 2) {       	$data['isman'] = 0;    	}
		$data['certificate_type'] = $this->input->post ( 'certificate_type', true ); //身份证类型
		$data['certificate_no'] = $this->input->post ( 'idcard', true );                  // 身份证号码
		$data['birthday'] = $this->input->post ( 'birth', true );                 //出生
		$data['sign_place'] = $this->input->post ( 'startcity', true );       //签发地   startcity
		$data['sign_time'] = $this->input->post ( 'starttime', true );     //签发时间
		$data['endtime'] = $this->input->post ( 'endtime', true );       //起止时间
		$data['telephone'] = $this->input->post ( 'mobile', true );               //手机    
		if ($bj_id) { // 编辑
			$where = array(
					'id' => $bj_id 
			);
			$data['modtime'] = date ( 'Y-m-d H:i:s', time () );
			$status = $this->db->update ( 'u_member_traver', $data, $where );
		} elseif (empty ( $sc_id )) { // 插入
			$data['addtime'] = date ( 'Y-m-d H:i:s', time () );
			$status = $this->db->insert ( 'u_member_traver', $data );
			$tourist_id = $this->db->insert_id (); // 返回插入的ID
			$status = $this->db->insert ( 'u_member_order_man', array(
					'order_id' => $order_id, 
					'traver_id' => $tourist_id 
			) );
		} else { // 删除
			$status = $this->db->delete ( 'u_member_order_man', array(
					'order_id' => $order_id, 
					'traver_id' => $sc_id 
			) );
			$status = $this->db->delete ( 'u_member_traver', array(
					'id' => $sc_id 
			) );
		}
		if ($status) {
			$this->__successmsg ();
		} 
	}
	
/*
*
*        do     refund      Complaint       评论投诉
*
*        by     zhy
*
*        at      2015年x月x日 x:x:x
*
*/
	public function cfgm_tk_detail() {
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$tk_id = $this->input->post ( 'tk_id' );
		$ts_id = $this->input->post ( 'ts_id' );
		if ($tk_id) {
			         $this->db->select ( "mo.status,mo.productname,mo.litpic,mo.total_price,mo.usedate,SUM(mo.dingnum+mo.childnum+mo.oldnum+mo.childnobednum) AS people,mo.linkmobile,r.amount,r.reason,mo.linkman" );
		}
		if ($ts_id) {
					$this->db->select ( "mo.status,mo.productname,mo.litpic,mo.total_price,mo.usedate,SUM(mo.dingnum+mo.childnum+mo.oldnum+mo.childnobednum) AS people,mo.linkmobile,c.reason,mo.linkman" );
		}
		$this->db->from ( 'u_member_order AS mo' );
		if ($tk_id) {
			$this->db->join ( 'u_refund AS r', 'r.order_id=mo.id', 'left' );
			$this->db->where ( array(
					'mo.id' => $tk_id 
			) );
		}
		if ($ts_id) {
			$this->db->join ( 'u_complain AS c', 'c.order_id=mo.id', 'left' );
			$this->db->where ( array(
					'mo.id' => $ts_id 
			) );
		}else{
		    $this->__errormsg 						('null');
		}
		$query = $this->db->get ();
		$reDataArr = $query->result_array ();
		$this->__outmsg ( $reDataArr );
	}
	
	/*
	*
	*        do       cancel       Apply       evaluate        Complaint       取消订单申请退单评价订单投诉
	*
	*        by       zhy
	*
	*        at        2015年x月x日 x:x:x
	*
	*/
	public function cfgm_action_order() {
		$status = 0;
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model','at_model');
		$user = $this->at_model->result ( array('access_token' => $token),null,null,null,'arr',null,'mid' );
		$m_id = $user[0]['mid'];
		$qx = $this->input->post ( 'qx_id', true );       //取消订单
		$td = $this->input->post ( 'td_id', true );       //申请退单
		$pj = $this->input->post ( 'pj_id', true );       //评价订单
		$ts = $this->input->post ( 'ts_id', true );       //投诉
		if ($td) {
			$reason = $this->input->post ( 'reason', true ); // 退款理由
			$total_price = $this->input->post ( 'total_price', true ); // 退款金额
			$mobile = $this->input->post ( 'mobile', true );
			if (empty($reason))		 {$this->__errormsg ('退款理由不能为空！ ');}
			if (empty($total_price))		 {$this->__errormsg ('退款金额不能为空！ ');}
			if (empty($mobile))		 {$this->__errormsg ('手机不能为空! ');}
			if (! preg_match ( "/1[34578]{1}\d{9}$/", $mobile )) {$this->__errormsg ('手机号码错误！');}
			// $card = $this->input->post ( 'card', true );
			// $bank = $this->input->post ( 'bank', true );
		}
		if ($qx || $td) { // 取消订单或退单
			if ($qx) {
			    $data['order_id'] = $qx;
			    $log['content']="取消订单成功";
				$sta = - 4;
				$ispay= 4;
				$where = array(
						'id' => $qx 
				);
			}
			if ($td) {
			    $data['order_id'] = $td;
			    $log['content']="退订中";
				$sta = - 3;
				$ispay= 3;
				$where = array(
						'id' => $td 
				);
			}
			$status = $this->db->update ( 'u_member_order', array(
					'status' => $sta 
			), $where );
			if ($status && $td) {
			    $refund = array(
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
			    //print_r($refund);exit();
			    $status = $this->db->insert ( 'u_refund', $refund );
			    $status = $this->db->update ( 'u_member_order', array(
			            'status' => '-3'
			    ), array(
			            'id' => $td
			    ) );
			}
		}
		if ($pj) { // 评价
		    $log['content']="评价成功";
			$data['orderid'] = $pj;
			$data['memberid'] = $m_id;
			$data['line_id'] = $this->input->post ( 'lineid', true ); // 隐藏框
			$data['expert_id'] = $this->input->post ( 'expertid', true ); // 隐藏框
			$data['content'] = $this->input->post ( 'content', true );
			$pics = $this->input->post ( 'pics', true );
			$pic_url = trim ( $pics, ',' );
			$data['pictures'] = $pic_url;
			if ($data['pictures']) {
				$data['haspic'] = 1;
			} else {
				$data['haspic'] = 0;
			}
			$data['expert_content'] = $this->input->post ( 'expert_content', true );
			$data['score1'] = $this->input->post ( 'dy', true );
			$data['score2'] = $this->input->post ( 'xc', true );
			$data['score3'] = $this->input->post ( 'cy', true );
			$data['score4'] = $this->input->post ( 'jt', true );
			$data['score5'] = $this->input->post ( 'zy', true );
			$data['score6'] = $this->input->post ( 'fw', true );
			$data['channel'] = 1;
			$data['isshow'] = 1;
			$data['addtime'] = date ( 'Y-m-d H:i:s', time () );
			$status = $this->db->insert ( 'u_comment', $data );
			$status = $this->db->update ( 'u_member_order', array('status' => 6 ), array('id' => $pj ));
		}
		if ($ts) { // 投诉
		    $log['content']="投诉成功";
		    $data['order_id'] = $ts;
		    $data['member_id'] = $m_id;
		    $data['complain_type'] = $this->input->post ( 'complain_type', true ); // 1.专家 2.供应商
		    is_numeric ($data['complain_type']) ? $data['complain_type'] :  			$this->__errormsg ('不能为空！');  
		    if($data['complain_type']=="-1"){  $data['complain_type']=="-1";    }else{       $data['complain_type']="1,2";   }
	        $data['reason'] = $this->input->post ( 'complaint_content', true ); // 投诉内容
	        $data['mobile'] = $this->input->post ( 'mobile', true ); // 用户手机号
	        $data['user_name'] = $this->input->post ( 'user_name', true ); // 用户姓名
	        $data['addtime'] = date ( 'Y-m-d H:i:s', time () );
	        $data['status'] = 0;
	        if (empty ( $data['reason'] ) || empty ( $data['mobile'] ) || (! preg_match ( "/1[34578]{1}\d{9}$/", $data['mobile'] ))) {
	            $this->__errormsg ('请完整的输入投诉信息');
	        }
		        $status = $this->db->insert ( 'u_complain', $data );
		        $status = $this->db->update ( 'u_member_order', array('status' => 7), array('id' => $ts) );
		}
		
		//写入订单日志
		$logArr = array(
		        'order_id' =>$data['order_id'],
		        'op_type' => 0,
		        'userid' =>$m_id,
		        'content' =>$log['content'],
		        'addtime' => date('Y-m-d H:i:s',time())
		);
		$status_log = $this ->db ->insert('u_member_order_log' ,$logArr);
		
		
		if ($status) {
			$this->__successmsg ();
		}
	}
	
/*
*
*        do     Pay    Preferential volume      支付
*
*        by     zhy
*
*        at     2015年x月x日 x:x:x
*
*/
	public function cfgm_pay_order() {
    		$token = $this->input->post ( 'number', true );
    		$order_id = $this->input->post ( 'orderid', true );
    		is_numeric($order_id)? ($order_id):$this->__errormsg 						('tip is null ');
    		$this->check_token ( $token );
    		$this->load->model ( 'common/u_access_token_model','at_model');
    		$result = $this->at_model->result ( array('access_token' => $token),null,null,null,'arr',null,'mid' );
            $mid=$result[0]['mid'];
    		$reDataArr = $this->db->query ( "	
    		SELECT `mo`.`ordersn`, `mo`.`productname`, `mo`.`dingnum` AS adult, `mo`.`childnum` AS child, mo.childnum,mo.childnobednum,mo.oldnum,mo.dingnum,
    		(select l.linetitle from u_line AS l left join u_member_order AS mo on mo.productautoid=l.id where mo.id={$order_id}) AS producttitle,
    		mo.total_price as order_price,`mo`.`jifenprice`,mo.couponprice,mo.order_price as ctf,
    		(select SUM(amount) from u_order_insurance as o WHERE o.order_id={$order_id}) as amount,
    		(select count(*) from cou_member_coupon AS mcou left join cou_coupon AS cou on cou.id=mcou.coupon_id where cou.endtime < NOW() and cou.status=0 and cou.userid={$mid}) AS yhj_count
    		FROM (`u_member_order` AS mo)
    		WHERE `mo`.`id` =  {$order_id} AND `memberid` =  {$mid}  ")->result_array ();
		    $this->__outmsg ( $reDataArr );
	}
	
/*
*
*        do     alipay     支付成功
*
*        by     zhy
*
*        at     2015年x月x日 x:x:x
*
*/
	public function cfgm_pay_success() {
		$order_id = $this->input->post ( 'orderid', true );

		$amount = $this->input->post ( 'all_price', true ); // 付款金额
		$bank = $this->input->post ( 'bank', true );
		// $card = $this->input->post('card',true);
		// $hz_number = $this->input->post('hz_number',true);
		$fapiao = $this ->input ->post('fapiao', true); //订单号
		$token = $this->input->post ( 'number', true );
		$this->check_token ( $token );
		$this->load->model ( 'common/u_access_token_model','at_model');
		$result = $this->at_model->result ( array('access_token' => $token),null,null,null,'arr',null,'mid' );
		$userid=$result[0]['mid'];
		is_numeric($order_id)? ($order_id):$this->__errormsg 						('tip is null ');
	    if (($fapiao=='1')) {
		             $invoice_name = ($this ->input ->post('cdname' ,true));           //发票抬头
		             $invoice_detail = ($this ->input ->post('ticketype' ,true));         //发票类型
		             $receiver = ($this ->input ->post('toname' ,true));                     //收件人
		             $telephone = ($this ->input ->post('mobile' ,true));                   //手机号
		             $city = 	($this ->input ->post('cityval'));                                      //省市区
		             $address = ($this ->input ->post('citypid' ,true));                     //详细地址
		             if (empty($invoice_name)) 	 {	  $this->__errormsg 						('请填写发票抬头');		           }
		             if (empty($invoice_detail))     {	  $this->__errormsg 						('请填写发票类型');	   	           }
		             if (empty($receiver)) 		         {	  $this->__errormsg 						('请填写收件人');	      	           }
		             if (empty($telephone)) 		     {	  $this->__errormsg 						('请填写手机号');    		           }
		             if (empty($city)) 			         {	  $this->__errormsg 						('请填写省市区');        	           }
		             if (empty($address)) 		         {	  $this->__errormsg 						('请填写填写详细地址');           }
		             $time = date('Y-m-d H:i:s' ,time());
		             $invoiceArr = array(
		                     'invoice_name' =>$invoice_name,
		                     'invoice_detail' =>$invoice_detail,
		                     'receiver' =>$receiver,
		                     'telephone' =>$telephone,
		                     'address' =>$city.$address,
		                     'member_id' =>$userid,
		                     'modtime' =>$time
		             );
		             $this ->load->model('common/u_member_order_invoice_model' ,'order_invoice_model');
		             $this ->load->model('common/u_member_invoice_model' ,'invoice_model');
		             $invoiceData = $this ->order_invoice_model ->row(array('order_id' =>$order_id));
		             if (empty($invoiceData)) {
		                 $invoiceArr['addtime'] = $time;
		                 $invoiceId = $this ->invoice_model ->insert($invoiceArr);
		                 if (empty($invoiceId)) {                               $this->__errormsg 						('系统繁忙，稍后重试');                }
		                 else {
		                     $oiArr = array(           'order_id' =>$order_id,           'invoice_id' =>$invoiceId      );
		                     $this ->order_invoice_model ->insert($oiArr);
		                 }
		             } else {
		                 $status = $this ->invoice_model ->update($invoiceArr ,array('id' =>$invoiceData['invoice_id']));
		                 if (empty($status)) {            $this->__errormsg 						('系统繁忙，稍后重试');             }
		             }
		              
		         }

		$order_detail = array(
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
			$data = array(
					'status' => 2, 
					'ispay' => 2 
			);
			$where = array(
					'id' => $order_id 
			);
			$status = $this->db->update ( 'u_member_order', $data, $where );
		}
		if ($status) {
			$this->__successmsg ();
		}
	}

/*
*
*        do     offline     pay
*
*        by     zhy
*
*        at     2016年3月1日 16:47:06
*
*/
	public     function       cfgm_offline_pay(){
	    $this->load->model ( 'order_model', 'order_model' );
	    $this->load->model ( 'line_model', 'line_model' );
	    $account_name = $this->input->post('name');
	    $bank_name = $this->input->post('bank');
	    $card_num = $this->input->post('num');
	    $receipt = $this->input->post('sn');
	    $receipt_img = $this->input->post('imgurl');
	    if(!empty($receipt_img )){  $receipt_img= '/'.$receipt_img ;}else{$receipt_img='';}
	    $pay_amount = floatval($this->input->post('pric'));
	    $order_id = $this->input->post('orderid');
	    $fapiao = intval($this ->input ->post('fapiao'));
	    $token = $this->input->post ( 'number', true );
	    $this->check_token ( $token );
	    $this->load->model ( 'common/u_access_token_model','at_model');
	    $result = $this->at_model->result ( array('access_token' => $token),null,null,null,'arr',null,'mid' );
	    $userid=$result[0]['mid'];
	    if (($fapiao=='1')) {        
	        $invoice_name = ($this ->input ->post('cdname' ,true));           //发票抬头
	        $invoice_detail = ($this ->input ->post('ticketype' ,true));         //发票类型
	        $receiver = ($this ->input ->post('toname' ,true));                     //收件人
	        $telephone = ($this ->input ->post('mobile' ,true));                   //手机号
	        $city = 	($this ->input ->post('cityval'));                                      //省市区
	        $address = ($this ->input ->post('citypid' ,true));                     //详细地址
	        if (empty($invoice_name)) 	 {	  $this->__errormsg 						('请填写发票抬头');		           }
	        if (empty($invoice_detail))     {	  $this->__errormsg 						('请填写发票类型');	   	           }
	        if (empty($receiver)) 		         {	  $this->__errormsg 						('请填写收件人');	      	           }
	        if (empty($telephone)) 		     {	  $this->__errormsg 						('请填写手机号');    		           }
	        if (empty($city)) 			         {	  $this->__errormsg 						('请填写省市区');        	           }
	        if (empty($address)) 		         {	  $this->__errormsg 						('请填写填写详细地址');           }
	        $time = date('Y-m-d H:i:s' ,time());
	        $invoiceArr = array(
	                'invoice_name' =>$invoice_name,
	                'invoice_detail' =>$invoice_detail,
	                'receiver' =>$receiver,
	                'telephone' =>$telephone,
	                'address' =>$city.$address,
	                'member_id' =>$userid,
	                'modtime' =>$time
	        );
	        $this ->load->model('common/u_member_order_invoice_model' ,'order_invoice_model');
	        $this ->load->model('common/u_member_invoice_model' ,'invoice_model');
	        $invoiceData = $this ->order_invoice_model ->row(array('order_id' =>$order_id));
	        if (empty($invoiceData)) {
	            $invoiceArr['addtime'] = $time;
	            $invoiceId = $this ->invoice_model ->insert($invoiceArr);
	            if (empty($invoiceId)) {                               $this->__errormsg 						('系统繁忙，稍后重试');                }
	            else {
	                $oiArr = array(           'order_id' =>$order_id,           'invoice_id' =>$invoiceId      );
	                $this ->order_invoice_model ->                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                rd) {
			$this->__errormsg ('两次密码输入不一致');
			exit ();
		}
		$code_mobile = $data['mobile'];
		$this->load->library('session');
		$code_number = $this->session->userdata ( 'code' );
		if (($code_mobile == $data['mobile'])&&($code_number == $code)) {
			$data['password'] = md5 ( $new_password );
			$where = array(
					'mobile' => $data['mobile'] 
			);
			$status = $this->db->update ( 'u_expert', $data, $where );
			if ($status) {
				$this->__successmsg ('重设密码成功');
			} else {
				$this->__errormsg ('重设密码失败，请重试');
			}
		}else{
			$this->__errormsg ('验证码输入错误');
		}
	}
/*
*
*        do     expert      Sign out        退出
*
*        by     zhy
*
*        at     2016年3月7日 18:26:21
*
*/
	public function expert_user_logout() {
		$token = $this->input->post ( 'number', true );
		$time = time () - 3600;
		$status = $this->db->query ( "update u_expert_access_token set access_token_validtime={$time} where access_token='{$token}'" );
		if ($status) {
			$this->result_code = "1";
			$this->result_msg = "logout success";
			$lastData['rows'] = "";
			$this->result_data = $lastData;
			$this->resultJSON = json_encode ( array(
					"msg" => $this->result_msg, 
					"code" => $this->result_code, 
					"data" => $this->result_data, 
					"total" => "0" 
			) );
			echo $this->resultJSON;
			exit ();
		}
	}
/*
*
*        do     expert search       管家搜索
*
*        by     zhy
*
*        at     2015年11月18日 09:24:23
*
*/
	public function get_expert_list(){
		$num = $this->input->post("num");//页数
		$page_size = $this->input->post("page_size");//条数
		$num = empty ( $num ) ? 1 : $num;//每页的条数
		$page_size = empty ( $page_size ) ? 5 : $page_size;//每页的条数
		$from = ($num - 1) * $page_size;			
		$city_name = $this->input->post ( 'cityname', true );//定位城市名
		$this->load->model('common/u_area_model','area_model');
		$city_data=$this->area_model->get_row_city($city_name);
		if($city_data){               $city_id=$city_data['id'];	       }
		$qy_id = $this->input->post ( 'qy_id', true );//区域id
		$e_grade = $this->input->post ( 'type', true );//专家等级
		$sex = $this->input->post ( 'sex', true );//性别
		$dest_id = $this->input->post ( 'dest', true ); //目的地 多选
		$order = $this->input->post ( 'sort', true );//排序
		$lat = $this->input->post ( 'lat', true ); //经度   多选
		$lon = $this->input->post ( 'lon', true ); //纬度   多选
		$len = $this->input->post ( 'len', true ); //长度   多选
		if(is_numeric($lat) && is_numeric ($lon) && is_numeric ($len)){
		$this->load->library ( 'Geohash' );
		$geohash = $this ->geohash->encode_geohash($lat,$lon,$len);
		$expands = $this->geohash ->getGeoHashExpand($geohash) ;
		$expands0=$expands[0];
		$expands1=$expands[1];
		$expands2=$expands[2];
		$expands3=$expands[3];
		$expands4=$expands[4];
		$expands5=$expands[5];
		$expands6=$expands[6];
		$expands7=$expands[7];
		$expands8=$expands[8];
		$expands_where=" geohash like '{$expands0}%'  or geohash like '{$expands1}%' or geohash like '{$expands2}%' or geohash like '{$expands3}%' or geohash like '{$expands4}%' or geohash like '{$expands5}%' or geohash like '{$expands6}%' or geohash like '{$expands7}%' or geohash like '{$expands8}%' or geohash like '{$geohash}%'  and";
		}else{
			$expands_where='';
		}
		$order_by = "";
		$sub_where = " ";
		$label_where = "";
		$label_search="(FIND_IN_SET(160,l.linetype)>0 OR FIND_IN_SET(220,l.linetype)>0) GROUP BY e.id";
		if (! empty ( $order )) {
		    if ($order == 0) { // 按管家积分由高到低排序
		        $order_by = 'order by e.online desc,e.satisfaction_rate desc,e.people_count desc,e.id desc';
		    }
		    elseif ($order == 1) { // 按管家积分由高到低排序
		        $order_by = ' order by total_score desc,e.online desc';
		    } elseif ($order == 2) { // 满意度 高到低
		        $order_by = ' order by e.satisfaction_rate desc,e.online desc';
		    } elseif ($order == 3) { // 年度销量 高到低
		        $order_by = ' order by e.people_count desc,e.online desc';
		    } elseif ($order == 4) { // 年度成交人次 高到低
		        $order_by = ' order by (SELECT SUM(mo.dingnum+mo.childnum) FROM u_member_order AS mo WHERE mo.expert_id=e.id) desc,e.online desc';
		    }
		} else {
		    $order_by = 'order by e.online desc,e.satisfaction_rate desc,e.people_count desc,e.id desc';
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
					$sub_where .= " and {$l_kh} find_in_set({$val},l.overcity)>0 ";
				} else {
					$sub_where .= " or find_in_set({$val},l.overcity)>0 {$r_kh}";
				}
			}
		}
// 		if ($label) {
// 			$l_kh = "";
// 			$r_kh = "";
// 			$label_arr = explode ( ',', $label );
// 			$i = count ( $label_arr );
// 			foreach ( $label_arr as $key => $val ) {
// 				if ($i > 1) {
// 					if ($key == 0) {
// 						$l_kh = "(";
// 					}
// 					if ($key == $i - 1) {
// 						$r_kh = ")";
// 					}
// 				}
// 				if ($key == 0) {
// 					$sub_where .= " and  {$l_kh} find_in_set({$val},l.linetype)>0";
// 				} else {
// 					$sub_where .= " or find_in_set({$val},l.linetype)>0 {$r_kh}";
// 				}
// 			}
// 		}
		$temp_where="" ;
			if(!empty($sex)){
		    if ($sex == 1) {
		        $temp_where .= " and e.sex=1";
		    } elseif ($sex == 0) {
		        $temp_where .= " and e.sex=0";
		    }
		}
		else{
		    $temp_where .= " ";
		}
		if (! empty($city_name) && !empty($city_id)) {
			$temp_where .= " and e.city={$city_id}";
		} 
		
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
							$sub_where .= " and  {$l_kh} find_in_set({$val},e.visit_service)";
						} else {
							$sub_where .= " or find_in_set({$val},e.visit_service) {$r_kh}";
						}
					}
				}
		
		
		
		
// 		if ($qy_id!=0||$qy_id) {//改成上门服务
// 			$temp_where .= " and  FIND_IN_SET({$qy_id},e.visit_service )";
// 		}
		if ($e_grade) {
			if ($e_grade != 5) {
				$temp_where .= " and e.grade={$e_grade}";
			} else {
				$temp_where .= " and e.isstar=1";
			}
		}
		if ($dest_id || $qy_id ) {
			$label_where = "   la.status=2 {$sub_where}  {$temp_where} and e.status=2";
		}   else{
			$label_where= "  1=1  {$temp_where} and e.status=2 ";
		}
		$sql = "SELECT e.id AS expert_id,e.small_photo,e.sex,e.online,e.nickname,e.realname,e.comment_count,
CASE WHEN e.isstar=1 THEN '明星专家' WHEN e.grade=1 THEN '管家' WHEN e.grade=2 THEN '初级专家' WHEN e.grade=3 THEN '中级专家' WHEN e.grade=4 THEN '高级专家' END grade,
e.expert_theme AS expert_dest,
e.satisfaction_rate as satisfaction_rate ,
e.total_score,e.people_count AS volume,
(SELECT l.linename FROM u_line_apply AS la LEFT JOIN u_line AS l ON la.line_id=l.id WHERE la.expert_id=e.id AND la.status=2 ORDER BY la.addtime DESC LIMIT 1) AS newest_apply_line,
(SELECT l.linetitle FROM u_line_apply AS la LEFT JOIN u_line AS l ON la.line_id=l.id WHERE la.expert_id=e.id AND la.status=2 ORDER BY la.addtime DESC LIMIT 1) AS newest_apply_line_title,
(SELECT l.id FROM u_line_apply AS la LEFT JOIN u_line AS l ON la.line_id=l.id WHERE la.expert_id=e.id AND la.status=2 ORDER BY la.addtime DESC LIMIT 1) AS line_id ,
ua.name as cityname, 
(select GROUP_CONCAT(d.kindname SEPARATOR '、') as expert_dest from u_destinations as d where FIND_IN_SET(d.id, substring_index  (expert_dest,',',3))) as expert_dest 
FROM u_expert AS e 
left join u_area as ua on e.city=ua.id 
left join u_expert_location as uel on e.id=uel.eid
LEFT JOIN u_line_apply AS la ON la.expert_id=e.id 
LEFT JOIN u_line AS l ON l.id=la.line_id  where {$expands_where}  {$label_where} and e.status=2
and l.status=2 GROUP BY e.id {$order_by} LIMIT {$from},{$page_size}"  ;
		$query = $this->db->query ( $sql );		
		$data1= $query->result_array();
		foreach ( $data1 as $key => $val ) {
		    foreach ( $val as $k => $v ) {
		        if ($k == "satisfaction_rate") {
		            if ($v) {
		                $val[$k] = round (  $v * 100 );
		            }
		        }
		    }
		    $data1[$key] = $val;
		}
		
// 		print_r($this->db->last_query());exit();
		$this->__outmsg ( $data1 );
		$sql= rtrim($sql, "limit {$from},{$page_size} ");
		$query =  $this->db->query( $sql );
		$total_rows= $query->num_rows ();
		$total= ceil($total_rows/$page_size);
		$data=array(
				'cur_page' =>$num,
				'total' => $total,
				'result' => $data1,
				'total_rows' => $total_rows
		) ;
		$this->__outmsg ($data);
	}
	/*
	*
	*        do      customize  city  list
	*
	*        by     zhy
	*
	*        at    2016年1月14日 11:37:50
	*
	*/
	public function    ls_customize_city_list(){
		 $cityId = intval($this ->input ->post('cityid'));
		    if (is_numeric($cityId)&&!empty($cityId)) {
		       
                        	        $this ->load->model('common/cfg_round_trip_model' ,'trip_model');
                        	        //获取周边目的地
                        	        $tripData = $this ->trip_model ->all(array('startplaceid' =>$cityId ,'isopen' =>1));
                        	        if (!empty($tripData)) {
                                    	            $destId = '';
                                    	            foreach($tripData as $v) {
                                    	                $destId .= $v['neighbor_id'].',';
                                    	            }
                                    	            $destId = rtrim($destId ,',');
                                    	            //获取目的地
                                    	            $sql = "select kindname,id from u_destinations where id in ($destId)";
                                    	            $destArr = $this ->db ->query($sql) ->result_array(); 
                        	        }else{
                        	                        $this->__outmsg ( $tripData );
                        	        }
	    } else{
                        	        $this ->load->model('common/u_destinations_model' ,'dest_model');
                        	        $destData = $this ->dest_model ->all(array('level <=' =>3));
                        	        $destArr = array();
                        	        $h='h';
                        	        foreach($destData as $val) {
                        	            if ($val['pid'] == $cityId) {
                        	                                $destArr['top'][] = $val;
                        	            } else {
                        	                               $destArr[$h.$val['pid']][] = $val;
                        	            }
                        	        }
                        	        unset($destData);
	    }
	if ( $destArr) {
	    $this->__outmsg ( $destArr );
	}
		}
	/*
	 *
	 *        do     customize    page1
	 *
	 *        by     zhy
	 *
	 *        at     2016年1月12日 15:45:20
	 *
	 */
	public function mo_ls_customize_page1(){
	    $startcity  = $this->input->post ( 'startcity', true );        //出发城市
	    $city_name1  = $this->input->post ( 'city1', true );        //国内外
	    $city_name2  = $this->input->post ( 'city2', true );        //省
	    $city_name3  = $this->input->post ( 'city3', true );        //市
	    $travel_type  = $this->input->post ( 'travel_type', true );        //市
	    $more_service  = $this->input->post ( 'more_service', true );        //市
			             if (empty($startcity)) 	 {	  $this->__errormsg 						('请填写出发城市名！');		           }
			             if (empty($city_name1)) 	 {	  $this->__errormsg 						('请填写出发城市名！');		           }
			             if (empty($city_name2)) 	 {	  $this->__errormsg 						('请填写目的地城市名！');		           }
			             if (empty($travel_type)) 	 {	  $this->__errormsg 						('请填写出游方式！');		           }
	    echo json_encode(array('code'=>2000 ,'msg' =>'ok!'));
	}
	/*
	 *
	 *        do     customize  page2
	 *
	 *        by     zhy
	 *
	 *        at     2016年1月12日 16:55:58
	 *
	 */
	public function mo_ls_customize_page2(){
	    $travel_time1= $this->input->post ( 'travel_time1', true );                     //出游日期
	    $travel_time2 = $this->input->post ( 'travel_time', true );                     //出游日期文字描述
	    $budget  = $this->input->post ( 'budget', true );                                    //人均预算
	    $days  = $this->input->post ( 'days', true );                                           //出游时长
	    $hotel  = $this->input->post ( 'hotel', true );                                         //酒店要求
	    if (   (  !empty($travel_time1 )    ) xor (  !empty($travel_time2 )    ))	       {              
	                                        if(!empty($travel_time1)){
                                        	        $time1= strtotime($travel_time1);
                                        	        if($time1<time())                                                                                                                       {{$this->__errormsg ('出游时间得大于今天！');       }   }
	                                       }
	    if (empty($budget))			                                                                                                          {$this->__errormsg ('请填写人均预算 ！');                  }
	    if (empty($days))			                                                                                                              {$this->__errormsg ('请填写出游时长！');                   }
// 	    if (empty($hotel))			                                                                                                              {$this->__errormsg ('请填写酒店要求！');                   }
	    echo json_encode(array('code'=>2000 ,'msg' =>'ok!'));
         }else{
             $this->__errormsg ('出游日期不能写两个！');
         }
         $this->__errormsg ('请填写信息');
	}
	
/*
*
*        do     customize   定制单
*
*        by     zhy
*
*        at     2015年10月24日 16:23:36
*
*/
	public function mo_ls_customize() {
		$this->load->library ( 'session' );       
		$code_mobile = $this->session->userdata ( 'mobile' );    
		$token = $this->input->post ( 'number', true )	;	
		if (!empty($token)) {
            		$this->check_token ( $token );
            		$this->load->model ( 'common/u_access_token_model','eat_model');
            		$user = $this->eat_model->result ( array('access_token' => $token),null,null,null,'arr',null,'mid' );
            		$m_id = $user[0]['mid'];
		}
		$data ['from'] = $this->input->post ( 'from', true );                                         
		$data ['estimatedate'] = $this->input->post ( 'estimatedate', true );
		$data ['test1id'] = $this->input->post ( 'test1id', true );       //国家
		$data ['test2id'] = $this->input->post ( 'test2id', true );
		$data ['method'] = $this->input->post ( 'method', true );
		$data ['another_choose']=$this->input->post ( 'another_choose', true );
		$data ['question'] = $this->input->post ( 'question', true );
		$data ['people'] = $this->input->post ( 'people', true );
		$data ['childnum'] = $this->input->post ( 'cp', true );
		$data ['childnobednum'] = $this->input->post ( 'cnp', true );
		$data ['oldman'] = $this->input->post ( 'olp', true );
		$data ['roomnum'] = $this->input->post('roomnum',true);
		$data ['startdate'] = $startdate = $this->input->post ( 'dayr', true );
		$data ['days'] = $this->input->post ( 'days', true );
		$data ['budget'] = $this->input->post ( 'budget', true );
		$data ['end'] = $this->input->post ( 'end', true );
		$end=$data ['test2id'].','.$data ['end'];
// 		$data['isend']=rtrim($isend, ",");
// 		$end=$data['isend'];
		$data ['hotel'] = $this->input->post ( 'hotel', true );  //酒店
		$data ['room_require'] = $this->input->post('room_require',true);
		$data ['catering'] = $this->input->post('catering',true);  //用餐
		$data ['isshopping'] = $this->input->post ( 'isshopping', true );// 购物
		if(empty( $data ['hotel'] )){         $data ['hotel'] ="无";}
		if(empty( $data ['catering'] )){         $data ['catering'] ="无";}
		if(empty( $data ['isshopping'] )){         $data ['isshopping'] ="无";}
		$data ['service_range'] = $this->input->post('beizhu',true);
		$data ['meal'] = $this->input->post ( 'meal', true );
		$data ['beizhu'] = $this->input->post ( 'beizhu', true );
		$data ['linkname'] = $this->input->post ( 'linkname', true );
		$data ['mobile'] =$pwd= $this->input->post ( 'mobile', true );
		$data ['weixin'] = $this->input->post ( 'weixin', true );
		$data ['yzm'] = $this->input->post ( 'yzm', true ); //验证码
		$data ['total_people']=$this->input->post('total_people',true);
		$testtime=date("Y-m-d");
		 if (empty ( $data ['from'] )) {
			$this->resultJSON = json_encode ( array ("msg" => "出发城市不能为空","code" => "4001" ) );echo $this->resultJSON;exit ();
		}elseif (empty( $data ['method'] )) {
			$this->resultJSON = json_encode ( array ("msg" => "出游方式不能为空","code" => "4001" ) );echo $this->resultJSON;exit ();
		}elseif (empty( $data ['startdate'] )&&empty($data ['estimatedate'])) {
			$this->resultJSON = json_encode ( array ("msg" => "出发日期不能为空","code" => "4001" ) );echo $this->resultJSON;exit ();
		}  elseif (empty ( $data ['end'] )) {
			$this->resultJSON = json_encode ( array ("msg" => "目的地城市不能为空","code" => "4001" ) );echo $this->resultJSON;exit ();
		}elseif (( $data ['total_people'])<1) {
			$this->resultJSON = json_encode ( array ("msg" => "人数至少需有一位","code" => "4001" ) );echo $this->resultJSON;exit ();
		} 
		$this->load->helper ( 'regexp' );
		$mobile = $data ['mobile'];
		$name=$data['linkname'];
		if (! regexp ( 'mobile', $mobile )) {
			$this->resultJSON = json_encode ( array ("msg" => "请确保手机格式正确以及不能为空","code" => "4001" ) );echo $this->resultJSON;exit ();
		}if (! regexp ( 'name', $name )) {
			$this->resultJSON = json_encode ( array ("msg" => "联系人姓名输入有误","code" => "4001" ) );echo $this->resultJSON;exit ();
		}
		
		if (!empty($token)) {
		$user_id = $m_id;
		}else{
		$user_id ='';
		}
		$yzm = $this->session->userdata('code');
		if (empty($user_id)){
	         if($yzm!=$data ['yzm']){
		              	$this->resultJSON = json_encode ( array ( "msg" => "验证码错误","code" => "4001" ) ); echo $this->resultJSON;exit ();
                         }
		}
		
		$time = time();
		//var_dump($user_id);
		$this->db->trans_start();
		if (empty($user_id)) {
			//var_dump('3');
			//没有登陆，验证此手机号是否注册，若注册则自动登陆，若没有则自动注册一个账号
			$this->load->model ( 'member_model' );
			$member_info = $this ->member_model ->row(array('mobile' =>$data['mobile']));
			if (!empty($member_info)) {
				$user_id = $member_info['mid'];
				//已注册  自动登陆
			}else {
				$this->load->model('common/cfg_member_point_model','cfg_member_point');
				$point=$this->cfg_member_point->row(array('code'=>'REGISTER','isopen'=>'1'));
				$point_num=isset($point['value'])?$point['value']:'0';//积分数
				$member_insert_id = array (
					'truename' => $data ['linkname'],
					'loginname' => $mobile,
					'nickname'=>$mobile,
					'mobile' => $mobile,
					'pwd' => md5 ( $mobile ),
					'jointime' =>  date('Y-m-d H:i:s' ,$time),
					'sex' => - 1,
					'litpic' => '/file/c/img/face.png' ,
					'jifen' =>	$point_num,
					'logintime' => date('Y-m-d H:i:s' ,$time),
					'loginip'=>$this->get_client_ip(),
			);	
			$this->member_model->insert ( $member_insert_id );
			$user_id = $this->db->insert_id ();
			//写入积分变化表
		if ($member_insert_id['jifen'] >0)
			{
				$memberLogArr = array(
						'member_id' =>$user_id,
						'point_before' =>0,
						'point_after' =>$member_insert_id['jifen'],
						'point' =>$member_insert_id['jifen'],
						'content' =>'注册赠送积分',
						'addtime' =>$member_insert_id['logintime']
				);
				$this ->db ->insert('u_member_point_log' ,$memberLogArr);
			}
			$this ->member_coupon(1, $user_id);
		//发送短信给用户提示
			$smsData = "尊敬的帮游会员，系统已为您自动注册账号，可在会员中心查看定制单信息，账号为{#LOGINNAME#}，密码为{#PASSWORD#}。为安全起见，请尽快修改密码，谢谢。";
			if (!empty($smsData['msg'])) {
				$msg = str_replace("{#LOGINNAME#}", $mobile ,$smsData['msg']);
				$msg = str_replace("{#PASSWORD#}", $pwd ,$msg);
				$this ->Inside_page_message($mobile ,$msg);
			}else{}
			
			} 
		}
		$data['month']="";
		$data['date']="";
	    if(!empty($data ['startdate']))
	    {
	    	$arr=explode("-", $data ['startdate']);
	    	$data['month']=$arr[1];
	    	$data['date']=$arr[2];
	    }
	    $data = array (
				'member_id' => $user_id,
				'startplace' => $data ['from'],
				'endplace' => $end,
				'question' => $data ['question'],
				'month' => $data ['month'],
	    		'date' => $data ['date'],
				'trip_way'=>$data ['method'],
				'another_choose'=>$data['another_choose'],
				'people' => $data ['people'],
				'childnum' => $data ['childnum'],
				'childnobednum' => $data ['childnobednum'],
				'oldman' => $data ['oldman'],
				'roomnum'=>$data ['roomnum'],
				'days' => $data ['days'],
				'startdate' => $data ['startdate'],
				'estimatedate'=>$data ['estimatedate'],
				'budget' => $data ['budget'],
				'hotelstar' => $data ['hotel'],
				'room_require'=>$data ['room_require'],
				'isshopping' => $data ['isshopping'],
				'service_range' => $data ['beizhu'],
				'catering' => $data ['meal'],
				'linkname' => $data ['linkname'],
				'linkphone' => $data ['mobile'],
				'linkweixin' => $data ['weixin'],
	            'custom_type' =>$data['test1id'],
				//'service_range' => $data ['beizhu'],
				'total_people'=>$data['total_people'],
				'addtime' => date ( 'Y-m-d H:i', time () ),
				'status' => '0',
	    		'user_type'=>'0',
				'pic'=>'/file/b2/upload/img/customize.png'
		);
	    $this->load->model('common/u_customize_model','u_customize');
		$customize_id = $this->u_customize->insert ($data );
		$cid = $this->db->insert_id ();
		$this->load->model('common/u_customize_dest_model','u_customize_dest');
		$endplace = explode(',',$end); 
		for($i=0;$i<count($endplace);$i++){ 
				$this->u_customize_dest->insert(array('customize_id'=>$customize_id,'dest_id'=>$endplace[$i]));
		} 
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE){		return false;		} 
	  else{
			if (! empty ( $customize_id )) {
					if(empty($token)){
						$reDataArrssdsd = $this->db->query ( "SELECT loginname,pwd FROM `u_member` where mid={$user_id} ORDER BY mid limit 1; ")->row_array ();
					}else{
						$reDataArrssdsd ='';
					}
				   echo json_encode(array('code'=>2000 ,'msg' =>'ok!','cid'=>$reDataArrssdsd,'cust_id'=>$cid));
			}else{
			     echo json_encode(array('code'=>4000 ,'msg' =>'null!'));
			}
		}
		
	}
/*
*
*        do     qq      register        QQ登录
*
*        by     zhy
*
*        at
*
*/
	public function cfgm_qq_register() {		
	$data ['connectid'] = $this->input->post ( 'openid', true );
	$data ['access_token'] = $this->input->post ( 'token', true );
	$data ['from'] = $this->input->post ( 'status', true );
	$data ['addtime'] = time();
	$data ['mid'] = $mid = $this->input->post ( 'mid', true );
	$query = $this->db->query ( "select id from u_member_third_login where mid={$mid}" );
	$result = $query->result_array ();
	if (! $result) {
		  $this->__errormsg ();
	}
	}
	
/*
*
*        do     domestic  vs   abroad       订单状态
*
*        by     zhy
*
*        at
*
*/
	public function order_idtype() {		
	$lineid=$this->input->post ( 'lineid', true );
	is_numeric($lineid)? ($lineid):$this->__errormsg 						('线路标识不能为空！');
	$query = $this->db->query ("select right(overcity,1) as city from u_line where id={$lineid}");
	$city = $query->result_array ();
	$num=$city[0]['city'];
	if($city[0]['city']==1){
		$where="where pid =100";
	}elseif($city[0]['city']==2){
		$where="where pid =99";
	}else{
		$where="where pid =99";
	}
	$query = $this->db->query ( "select dict_id,description from u_dictionary {$where}" );
	$result['type_id'] = $query->result_array ();	
	$result['inou']="$num";
	if ( $result) {
		  $this->__outmsg ( $result );
	}
	}
	

/*
*
*        do     door                上门服务
*
*        by     zhy
*
*        at     2015年12月22日 10:36:20
*
*/
public function expert_door_list(){
                $token = $this->input->post ( 'number', true );
                $this->expert_check_token ( $token );
                $this->load->model ( 'common/u_expert_access_token_model','eat_model');
                $result = $this->eat_model->result ( array('access_token' => $token),null,null,null,'arr',null,'eid' );
                $m_id = $result[0]['eid'];
                $number = $this->input->post('pageSize', true);
                $page = $this->input->post('pageNum', true);
                $status = $this->input->post('progress', true);
                $number = empty($number) ? 15 : $number;
                $page = empty($page) ? 1 : $page;
                $this->load_model('admin/b2/expert_service_model', 'expert_service');
                $service_list = $this->expert_service->get_service_list($m_id ,$status,$page,$number);
                //$reply_list = $this->grab_custom_order->get_grab_custom_list( $page, $number,$this->expert_id);
                //print_r($this->db->last_query());exit();
                $pagecount = $this->expert_service->get_service_list($m_id,$status,0,$number);
                $this->db->close();
                if (($total = $pagecount - $pagecount % $number) / $number == 0) {
                    $total = 1;
                } else {
                    $total = ($pagecount - $pagecount % $number) / $number;
                    if ($pagecount % $number > 0) {
                        $total +=1;
                    }
                }
                $data=array(
                        "totalRecords" => $pagecount,
                        "totalPages" =>  $total,
                        "pageNum" => $page,
                        "pageSize" => $number,
                        "rows" => $service_list
                );
                if ( !$data) {
                    $this->__outmsg ( $data );
                }else{
					$this->__errormsg ();
				}
}
/*
*
*        do     line_apply          线路确认
*
*        by     zhy
*
*        at     2015年12月22日 11:24:13
*
*/
public function expert_line_apply(){
    $num = $this->input->post("num");//页数
    $page_size = $this->input->post("page_size");//条数
    $num = empty ( $num ) ? 1 : $num;//每页的条数
    $page_size = empty ( $page_size ) ? 5 : $page_size;//每页的条数
    $from = ($num - 1) * $page_size;
    $token = $this->input->post ( 'number', true );
    $this->expert_check_token ( $token );
    $this->load->model ( 'common/u_expert_access_token_model','eat_model');
    $result = $this->eat_model->result ( array('access_token' => $token),null,null,null,'arr',null,'eid' );
    $m_id = $result[0]['eid'];
    $sid = $theme = $this->input->post ( 'supplier', true );
    $su_id = $theme = $this->input->post ( 'supplier_id', true );
    $a_id = $theme = $this->input->post ( 'apply_id', true );
    if(!empty($su_id)){   $supplier="AND `supplier_id` = '{$su_id}' ";}else{$supplier=' ';}
    if($sid==1){
                 $reDataArr = $this->db->query ( "SELECT `id`, `company_name` as realname FROM (`u_supplier`) WHERE `status` = 2 ")->result_array ();
                 $this->__outmsg ( $reDataArr );
       }else{
                if($a_id=='1'){
                $reDataArr = $this->db->query(
                        "  SELECT  `l`.`id` AS line_id,   `l`.`linecode` AS line_sn, `l`.`linename` AS line_title,   `l`.`all_score` AS all_score, `st`.`cityname` AS start_city,  `l`.`agent_rate` AS agent_rate, `l`.`satisfyscore` AS satisfyscore,  `l`.`comment_count` AS comment_count,  `l`.`peoplecount` AS peoplecount, `l`.`sell_direction` AS sell_direction, `s`.`company_name` AS company_name, `s`.`mobile` AS mobile  FROM (`u_line` as l) LEFT JOIN `u_supplier` as s ON `l`.`supplier_id` =`s`.`id` LEFT JOIN `u_startplace` as st ON `l`.`startcity`=`st`.`id` WHERE `l`.`id` NOT IN( SELECT line_id FROM u_line_apply as la WHERE la.expert_id ={$m_id} and la.status=2) {$supplier} AND `l`.`status` = 2   AND `l`.`producttype` = 0   ORDER BY `l`.`addtime`  desc LIMIT {$from},{$page_size} ")->result_array();
                $this->__outmsg($reDataArr);
                }
                else{
                    $reDataArr = $this->db->query(
                            "   SELECT  `l`.`id` AS line_id,   `l`.`linecode` AS line_sn,   `l`.`linename` AS line_title,   `s`.`company_name` AS supplier_name,  `la`.`grade`,   `st`.`cityname` AS cityname,   `l`.`agent_rate` AS agent_rate,   `l`.`satisfyscore` AS satisfyscore,  `l`.`comment_count` AS comment_count,   `l`.`peoplecount` AS peoplecount,   `l`.`lineprice` AS lineprice,   `s`.`mobile` AS mobile,   `l`.`status`   FROM (`u_line_apply` AS la)   LEFT JOIN `u_line` AS l ON `la`.`line_id` = `l`.`id`   LEFT JOIN `u_supplier` AS s ON `l`.`supplier_id` = `s`.`id`   LEFT JOIN `u_startplace` as st ON `l`.`startcity`=`st`.`id`   WHERE `la`.`status` = 2    {$supplier}  AND `l`.`producttype` = 0   AND `la`.`expert_id` = {$m_id}   ORDER BY `la`.`addtime` desc LIMIT {$from},{$page_size}")->result_array();
                    $this->__outmsg($reDataArr);
                }
       }
}


/*
 *
 *        do     line expert sort
 *
 *        by     zhy
 *
 *        at     2015年12月30日 11:05:46
 *
 */
public function  line_expert_sort(){
    $avg = $this->input->post("avg");
    $sort = $this->input->post("sort");
    $l_id=$this->input->post("lineid");
    is_numeric($l_id)? ($l_id):$this->__errormsg 						('线路标识不能为空！');
    $this->load->helper("regexp");
    if (!regexp('zhcn' ,$sort)) {	$this->__errormsg 						('请填写正确的城市名！');	}
    if($avg=='1'){                    //综合
        $order=" order by e.online    desc  ";
    }elseif($avg=='2'){            //好评
        $order="order by e.satisfaction_rate  desc";
    }elseif($avg=='3'){            //成交
        $order="order by e.order_count  desc ";
    }else{
        $this->__errormsg ();
    }
    if( !empty($sorts)) {
        $order="and (e.nickname like '%{$sort}%' or ua.name like '%{$sort}%') order by e.order_count";
    }
    $reDataArr = $this->db->query(  "     SELECT  e.id AS expert_id,	e.realname, 	e.nickname, 	e.big_photo,	e.small_photo,	e.comment_count,	e.sex,	e.online,  	e.expert_theme AS expert_dest, 	e.satisfaction_rate  as satisfaction_rate , 	e.order_count AS volume, 	ua.name as cityname, 	        (select GROUP_CONCAT(d.kindname SEPARATOR '、') as expert_dest from u_destinations as d where FIND_IN_SET(d.id,substring_index  (e.expert_dest,',',3))) as expert_dest,     CASE 	WHEN la.grade = 1 THEN  '管家'  WHEN la.grade = 2 THEN  '初级专家'  	WHEN la.grade = 3 THEN 	'中级专家'  WHEN la.grade = 4 THEN  	'高级专家' END grade 	FROM 	u_expert AS e 	LEFT JOIN u_line_apply AS la ON e.id = la.expert_id 	left join u_area as ua on ua.id=e.city  WHERE 	la.line_id = {$l_id} 	AND la. STATUS = 2     {$order}  	   ")->result_array();
    foreach ( $reDataArr as $key => $val ) {
        foreach ( $val as $k => $v ) {
            if ($k == "satisfaction_rate") {
                if ($v) {
          