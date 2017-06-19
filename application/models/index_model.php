<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Index_model extends MY_Model {
	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ();
	}
	
	/**
	 * @method 获取首页管家以及最美管家
	 * @author jiakairong
	 * @since  2015-10-20
	 */
	public function getIndexExpert($whereArr ,$page=1 ,$num=7) {
		$this ->db ->select("e.id as eid,e.nickname,e.talk,(e.satisfaction_rate+ea.sati_intervene) as satisfaction_rate,e.expert_dest,e.visit_service,a.name as cityname,ie.smallpic,e.small_photo,e.big_photo,ie.pic,e.grade,e.order_amount,e.total_score,e.people_count,e.order_count");
		$this ->db ->from('cfg_index_expert as ie');
		$this ->db ->join('u_expert as e','ie.expert_id = e.id' ,'left');
		$this ->db ->join('u_expert_affiliated as ea','ea.expert_id = e.id' ,'left');
		$this ->db ->join('u_area as a' ,'a.id = ie.startplaceid' ,'left');
		$this ->db ->where($whereArr);
		$num = empty ( $num ) ? 7 : $num;
		$offset = (empty ( $page ) ? 0 : ($page - 1)) * $num;
		$this ->db ->limit($num ,$offset);
		$this ->db ->order_by('ie.showorder' ,'asc');
		return $this ->db ->get() ->result_array();
	}
	/**
	 * @method 获取首页体验师数据
	 * @author jiakairong
	 * @param array $whereArr 查询条件
	 * @param number $page_new 当前分页
	 * @param number $number 每页条数
	 */
	public function getIndexExpertience($whereArr ,$page_new =1 ,$num =10 ) {
		$this ->db ->select('ie.pic,m.nickname,m.litpic,m.mid,l.id as lineid,l.linename,l.overcity');
		$this ->db ->from('cfg_index_experience as ie');
		$this ->db ->join( 'u_member as m' ,'m.mid = ie.member_id' ,'left');
		$this ->db ->join('u_member_experience as me' ,'m.mid = me.member_id' ,'left');
		$this ->db ->join( 'travel_note as tn' ,'tn.id = ie.travel_note_id' ,'left');
		$this ->db ->join( 'u_line as l' ,'tn.line_id = l.id' ,'left');
		$this ->db ->where($whereArr);
		$this ->db ->order_by('ie.showorder' ,'asc');
		 
		$num = empty($num) ? 10 :$num;
		$page_new = empty($page_new) ? 1 : $page_new;
		$offect = ($page_new - 1) * $num;
		$this ->db ->limit ($num ,$offect);
		return $this ->db ->get() ->result_array();
	}
	
	/**
	 * @method 获取特价线路
	 * @author jiakairong
	 * @since  2015-10-20
	 * @param unknown $whereArr
	 * @param number $page_new
	 * @param number $num
	 */
	public function getIndexLineSell($whereArr ,$page =1 ,$num =10 ) {
		$this ->db ->select('ls.pic,l.linename,l.lineprice,l.id as lineid,l.linetitle,l.overcity');
		$this ->db ->from('cfg_index_line_sell as ls');
		$this ->db ->join('u_line as l' ,'l.id = ls.line_id' ,'left');
		$this ->db ->where($whereArr);
		$this ->db ->order_by('ls.showorder' ,'asc');
		$num = empty($num) ? 10 :$num;
		$page = empty($page) ? 1 : $page;
		$offect = ($page - 1) * $num;
		$this ->db ->limit ($num ,$offect);
		return $this ->db ->get() ->result_array();
	}
	
	/**
	 * @method 获取最美体验师
	 * @author jiakairong
	 * @since  2015-10-20
	 * @param unknown $whereArr
	 * @param number $page_new
	 * @param number $num
	 */
	public function getBeautyExperience($whereArr ,$page=1 ,$num = 10) {
		$this ->db ->select('m.mid,m.nickname,be.pic,(select dest_id from u_experience_dest as ed where ed.member_id = m.mid ) as dest_id');
		$this ->db ->from('cfg_beauty_experience as be');
		$this ->db ->join('u_member as m' ,'m.mid = be.member_id' ,'left');
		$this ->db ->join('u_member_experience as me' ,'m.mid = me.member_id' ,'left');
		$this ->db ->where($whereArr);
		$this ->db ->order_by('be.showorder' ,'asc');
		$num = empty($num) ? 10 :$num;
		$page = empty($page) ? 1 : $page;
		$offect = ($page - 1) * $num;
		$this ->db ->limit ($num ,$offect);
		return $this ->db ->get() ->result_array();
	}
	/**
	 * @method 获取最新点评
	 * @author jiakairong
	 * @since  2015-10-21
	 * @param unknown $whereArr
	 * @param number $page_new
	 * @param number $num
	 */
	public function getNewComment(array $whereArr ,$page=1 ,$num=10) {
		$whereStr = '';
		foreach($whereArr as $k=>$v)
		{
			if ($k == 'c.starcityid') {
				$whereStr .= ' find_in_set('.$v.' ,c.starcityid) and';
			} else {
				$whereStr .= ' '.$k.' = "'.$v.'" and';
			}
		}
		$limitStr = ' limit '.(($page-1)*$num).','.$num;
		
		$sql = 'select c.content,m.mid,l.id as lineid,l.linename,l.overcity,m.nickname from u_comment as c left join u_member as m on m.mid =c.memberid left join u_line as l on l.id = c.line_id where '.rtrim($whereStr ,'and').' order by c.id desc '.$limitStr ;
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 底部文章分类
	 * @param number $num 
	 */
	public function getArticleAttr($num=5)
	{
		$sql = 'select id,attr_name from u_article_attr where ishome=1 order by showorder asc limit '.$num;
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 获取底部文章
	 * @author jiakairong
	 * @since  2015-10-21
	 * @param unknown $whereArr
	 */
	public function getArticleData($attrIds) {
		$sql = 'select id,title,attrid from u_article where attrid in ('.$attrIds.') and status =1 order by showorder asc';
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 获取友情链接
	 * @author jiakairong
	 * @since  2015-10-21
	 * @param unknown $whereArr
	 * @param number $page_new
	 * @param number $num
	 */
	public function getFriendLink($whereArr ,$page=1 ,$num=10) {
		$this ->db ->select('*');
		$this ->db ->from('u_friend_link');
		$this ->db ->where($whereArr);
		$this ->db ->order_by('showorder' ,'asc');
		$num = empty($num) ? 10 :$num;
		$page = empty($page) ? 1 : $page;
		$offect = ($page - 1) * $num;
		$this ->db ->limit ($num ,$offect);
		return $this ->db ->get() ->result_array();
	}
	
	/**
	 * @method 首页轮播图
	 * @author jiakairong
	 * @param unknown $whereArr
	 */
	public function getRollPic($whereArr) {
		$this ->db ->select('id,name,pic,link');
		$this ->db ->from('cfg_index_roll_pic');
		$this ->db ->where($whereArr);
		$this ->db ->order_by('showorder' ,'asc');
		return $this ->db ->get() ->result_array();
	}
	
	/**
	 * @method 获取首页一级分类
	 * @author jiakairong
	 */
	public function getIndexKind() {
		$sql = 'select id,name,pic from cfg_index_kind where is_show = 1 order by showorder asc';
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 根据首页一级分类获取首页分类目的地
	 * @author jiakairong
	 * @param  $pid 一级分类Id
	 * @param  $startplaceid  出发城市id
	 */
	public function getIndexKindDest ($pid ,$startplaceid ,$num) {
		$sql = 'select id,dest_id,name from cfg_index_kind_dest where index_kind_id ='.$pid.' and startplaceid='.$startplaceid.' and is_show =1 order by showorder asc limit 0,'.$num;
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 根据首页一级分类获取首页分类主题
	 * @author jiakairong
	 * @param  $pid 一级分类Id
	 * @param  $startplaceid  出发城市id
	 */
	public function getIndexKindTheme($pid ,$startplaceid ,$num) {
		$sql = 'select id,theme_id,name from cfg_index_kind_theme where index_kind_id ='.$pid.' and startplaceid='.$startplaceid.' and is_show=1 order by showorder asc limit 0,'.$num;
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 根据分类目的地获取线路
	 * @author jiakairong
	 */
	public function getKindDestLine ($whereArr ,$page=1 ,$num) {
		$whereStr = '';
		$limitStr = '';
		if (is_array($whereArr)) {
			foreach($whereArr as $key=>$val) {
				$whereStr .= " $key=$val and";
			}
			$whereStr = rtrim($whereStr ,'and');
		}
		$num = empty($num) ? 10 :$num;
		$page = empty($page) ? 1 : $page;
		$offect = ($page - 1) * $num;
		$limitStr = " limit $offect,$num";
		$sql = 'select l.id as lineid,l.linename,l.linetitle,l.overcity,l.lineprice,l.linetitle,l.saveprice,l.marketprice,kdl.pic,kdl.showorder from cfg_index_kind_dest_line as kdl left join u_line as l on l.id=kdl.line_id where '.$whereStr.' order by showorder asc '.$limitStr;
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 根据分类主题获取线路
	 * @author jiakairong
	 */
	public function getKindThemeLine ($whereArr ,$page=1 ,$num) {
		$whereStr = '';
		$limitStr = '';
		if (is_array($whereArr)) {
			foreach($whereArr as $key=>$val) {
				$whereStr .= " $key=$val and";
			}
			$whereStr = rtrim($whereStr ,'and');
		}
		$num = empty($num) ? 10 :$num;
		$page = empty($page) ? 1 : $page;
		$offect = ($page - 1) * $num;
		$limitStr = " limit $offect,$num";
		$sql = 'select l.id as lineid,l.linename,l.linetitle,l.lineprice,l.linetitle,l.overcity,l.saveprice,l.marketprice,tl.pic,tl.showorder from cfg_index_kind_theme_line as tl left join u_line as l on l.id=tl.line_id where '.$whereStr.' order by showorder asc '.$limitStr;
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 线路销量排行数据
	 * @author jkr
	 */
	public function getLineRanking(array $whereArr ,$num=5)
	{
		$whereStr = '';
		foreach($whereArr as $key =>$val)
		{
			if ($key == 'themeid')
			{
				$whereStr .= ' l.themeid >0';
			}
			elseif ($key == 'overcity')
			{
				$whereStr .= ' (';
				foreach($val as $v) {
					$whereStr .= ' find_in_set ('.$v.' , l.overcity) > 0 or';
				}
				$whereStr =rtrim($whereStr ,'or'). ') and';
			}
			else 
			{
				$whereStr .= ' '.$key.' = '.$val.' and';
			}
		}
		$sql = 'select l.id,l.linename,l.mainpic,l.lineprice,l.overcity from u_line as l left join u_line_startplace as ls on ls.line_id=l.id where '.rtrim($whereStr,'and').' group by l.id order by l.peoplecount desc limit '.$num;
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 获取周边游数据
	 * @author jkr
	 */
	public function getRoundTrip($startplaceid)
	{
		$sql = 'select neighbor_id as dest_id from cfg_round_trip where startplaceid='.$startplaceid.' and isopen =1';
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * 导航栏
	 */
	public function get_nav_list() {
		$this->db->select ( 'id,name' );
		$this->db->from ( 'cfg_index_nav' );
		$this->db->order_by ( 'showorder', 'asc' );
		$query = $this->db->get ();
		return $query->result_array ();
	}
	
	/**
	 * 轮播图
	 */
	public function get_banner_list() {
		$this->db->select ( 'id,pic,link' );
		$this->db->from ( 'cfg_index_roll_pic' );
		$this->db->where ( array(
				'is_show' => 1 
		) );
		$this->db->order_by ( 'showorder', 'asc' );
		$query = $this->db->get ();
		return $query->result_array ();
	}
	
	/**
	 * 线路搜索
	 */
	public function get_line_search($page = 1, $num = 10, $like = array()) {
		$this->db->select ( 'l.id,l.linename,l.lineprice,l.satisfyscore,l.features,l.bookcount AS sales,l.comment_count AS comments,l.transport,l.hotel,l.lineday' );
		$this->db->from ( 'u_line AS l' );
		foreach ( $like as $k => $v ) {
			$this->db->like ( $k, $v );
		}
		$query = $this->db->get ();
		return $query->result_array ();
	}
	
	
	
	/**
	 * 专家信息
	 */
	public function get_expert_info($where) {
		$this->db->select ( "e.id,cfg.pic,cfg.smallpic,e.realname,a.name,e.credit,e.avg_score,(CASE WHEN grade=1 THEN '管家' WHEN grade=2 THEN '初级' WHEN grade=3 THEN '中级' WHEN grade=4 THEN '高级' END) AS grade" );
		$this->db->from ( "cfg_index_expert AS cfg" );
		$this->db->join ( "u_expert AS e", "cfg.expert_id=e.id", "left" );
		$this->db->join ( "u_area AS a", "e.city=a.id", "left" );
		$this->db->where ( $where );
		$this->db->limit ( 1, 0 );
		$this->db->order_by ( "cfg.showorder", "asc" );
		$query = $this->db->get ();
		
		return $query->result_array ();
	}
	
	/**
	 * 最美专家
	 */ 
	public function get_best_expert() {
		$sql = "select e.id,cfg.smallpic,e.nickname as realname,group_concat(d.kindname) AS expert_dest from u_dest_base AS d,u_expert AS e left join cfg_index_expert AS cfg on cfg.expert_id=e.id where find_in_set(d.id,e.expert_dest)>0 and cfg.location=4 GROUP BY e.id";
		$query = $this->db->query($sql); 
		return $query->result_array ();
	}
	
	/**
	 * 最体验师
	 */ 
	public function get_best_experience() {
		$sql = "select m.truename, be.pic, be.id, be.member_id, be.beizhu, m.nickname, ds.dest_id,(select group_concat(d.kindname) from u_dest_base as d where find_in_set(d.id,ds.dest_id)>0) as kindname from (cfg_beauty_experience as be) left join u_member as m on m.mid = be.member_id left join u_experience_dest as ds on ds.member_id = m.mid where is_show =  1 order by showorder asc limit 10";
		$query = $this->db->query($sql); 
		return $query->result_array ();
	}
	/**
	 * 畅销路线
	 */
	public function get_best_line() {
		$this->db->select ( 'l.id,cfg.pic,l.linename,l.linetitle,l.lineprice,l.saveprice,(SELECT COUNT(*) FROM u_member_order AS mo WHERE mo.productautoid=l.id) AS valume' );
		$this->db->from ( 'cfg_index_line_hot AS cfg' );
		$this->db->join ( 'u_line AS l', 'cfg.line_id=l.id', 'left' );
		$this->db->order_by ( 'showorder', 'asc' );
		$this->db->limit ( 8, 0 );
		$this->db->where ( array(
				'cfg.is_show' => 1 
		) );
		$query = $this->db->get ();
		return $query->result_array ();
	}
	
	/**
	 * 特价线路
	 */
	public function get_special_line() {
		$this->db->select ( 'l.id,l.linename,l.linetitle,l.lineprice,s.pic,s.starttime,s.endtime,a.name' );
		$this->db->from ( 'cfg_index_line_sell AS s' );
		$this->db->join ( 'u_line AS l', 's.line_id=l.id', 'left' );
		$this->db->join ( 'u_area AS a', 'a.id=l.overcity', 'left' );
		$this->db->limit ( 8, 0 );
		$this->db->where ( array(
				's.is_show' => 1 
		) );
		$this->db->order_by('s.showorder' ,'asc');
		$query = $this->db->get ();
		return $query->result_array ();
	}
	
	/**
	 * 出境游 国内游  分层 左边：第一、第二层 第三层
	 */
	public function get_first_floor() {
		$this->db->select ( 'f.id AS f_dest_id,f.name AS f_name,f.smallpic AS f_smallpic,f.pic AS f_pic' );
		$this->db->from ( 'cfg_index_kind AS f' );
		$this->db->where ( array(
				'f.is_show' => 1 
		) );
		$query = $this->db->get ();
		return $query->result_array ();
	}
	public function get_second_floor($where) {
		$this->db->select ( 'f.id AS f_dest_id,tw.id AS tw_dest_id,tw.name AS tw_name,tw.pic AS tw_pic' );
		$this->db->from ( 'cfg_index_kind_dest AS tw' );
		$this->db->join ( 'cfg_index_kind AS f', 'f.id=tw.index_kind_id', 'left' );
		$this->db->order_by('tw.showorder' ,'asc');
		$this->db->where ( $where );
		$this->db->group_by ( array(
				'tw.id' 
		) );
		//$this->db->limit ( 12, 0 );
		$query = $this->db->get ();
		return $query->result_array ();
	}
	public function get_third_floor($where) {
		$this->db->select ( 'l.id AS th_id,tw.id AS tw_dest_id,l.mainpic AS th_pic,l.linename AS th_name,l.linetitle AS th_title,l.lineprice AS th_lineprice,l.saveprice AS th_saveprice' );
		$this->db->from ( 'cfg_index_kind AS f' );
		$this->db->join ( 'cfg_index_kind_dest AS tw', 'f.id=tw.index_kind_id', 'left' );
		$this->db->join ( 'cfg_index_kind_dest_line AS th', 'tw.id=th.index_kind_dest_id', 'left' );
		$this->db->join ( 'u_line AS l', 'th.line_id=l.id', 'left' );
		$this->db->where ( $where );
		$this->db->limit ( 6, 0 );
		$query = $this->db->get ();
		return $query->result_array ();
	}

	/**
	 * 周边游 
	 */	
	public function get_round_type(){
		$this->db->select ( 'f.id as f_id,d.kindname as d_kindname,d.id as d_id' );
		$this->db->from ( 'cfg_round_trip AS f' );
		$this->db->join ( 'u_dest_base AS d', 'd.id=f.neighbor_id', 'left' );
		$this->db->order_by('f.id' ,'asc');
		$this->db->where ( array(
				'f.isopen' => 1
		) );
		$query = $this->db->get ();
		//echo $this ->db ->last_query();
		return $query->result_array ();
	
	}
	public function get_round_list($d_id){
		$sql = "select l.id as l_id,l.mainpic as l_mainpic,l.overcity as l_overcity,l.linename as l_linename,l.linetitle as l_linetitle,l.lineprice as l_lineprice,l.saveprice as l_saveprice
				from u_line AS l where find_in_set({$d_id},l.overcity)>0 and l.status=2 limit 0,6";
		$query = $this->db->query ( $sql );
		return $query->result_array ();
		
	}	
	
	/**
	 * 主题游 
	 */
	public function get_theme_type(){
		$this->db->select ( 't.id as t_id,t.name as t_name' );
		$this->db->from ( 'u_theme AS t' );
		$this->db->order_by('t.showorder' ,'asc');
		$query = $this->db->get ();
		return $query->result_array ();
	}	
	public function get_theme_list($t_id){
		$sql = "select l.id as l_id,l.mainpic as l_mainpic,l.themeid as l_themeid,l.linename as l_linename,l.linetitle as l_linetitle,l.lineprice as l_lineprice,l.saveprice as l_saveprice
		from u_line AS l left join u_theme as u on l.themeid=u.id where l.themeid={$t_id} and {$t_id}>0 and l.status=2 limit 0,6";
		$query = $this->db->query ( $sql );
		return $query->result_array ();
		
	}
	
	/**
	 * 可能喜欢(推荐目的地)
	 */
	public function get_recommend_des() {
		$this->db->select ( 'id,pic,name,beizhu' );
		$this->db->from ( 'cfg_index_dest_love' );
		$this->db->where ( array(
				'is_show' => 1 
		) );
		$query = $this->db->get ();
		return $query->result_array ();
	}
	
	/**
	 * 销量排行 出境游 国内游 
	 */
	public function get_right_order($where) {
		$this->db->select ( 'l.id,l.linename,l.lineprice,l.mainpic' );
		$this->db->from ( 'u_line AS l' );
		$this->db->join ( 'cfg_index_kind_dest_line as kdl', 'l.id=kdl.line_id', 'left' );
		$this->db->join ( 'cfg_index_kind_dest as kd', 'kdl.index_kind_dest_id=kd.id', 'left' );
		$this->db->join ( 'cfg_index_kind as k', 'kd.index_kind_id=k.id', 'left' );
		$this->db->order_by ( 'l.bookcount', 'desc' );
		$this->db->where ( $where );
		$this->db->limit ( 5, 0 );
		$query = $this->db->get ();
		return $query->result_array ();
	}
	/**
	 * 销量排行  周边游 
	 */
	public function get_right_order_round(){
		$sql = "select l.id,l.linename,l.lineprice,l.mainpic,l.startcity,l.overcity,l.bookcount from u_line AS l left join u_startplace as s on s.id=l.startcity
				left join cfg_round_trip as rt on rt.startplaceid=s.id where rt.isopen=1 and l.status=2 and rt.startplaceid=l.startcity and find_in_set(rt.neighbor_id,l.overcity)>0 order by l.bookcount desc limit 0,5";
		$query = $this->db->query ( $sql );
		//echo $this ->db ->last_query();
		return $query->result_array ();
	}
	/**
	 * 销量排行  主题游
	 */
	public function get_right_order_theme(){
		$sql = "select l.id,l.linename,l.lineprice,l.mainpic,l.themeid,l.bookcount from u_line AS l left join u_theme as t on t.id=l.themeid where l.status=2 
				order by l.bookcount desc limit 0,5";
		$query = $this->db->query ( $sql );
		//echo $this ->db ->last_query();
		return $query->result_array ();
	}
	
	
	/**
	 *
	 * @method 获取周边游线路
	 * @since 2015-06-04
	 * @author 贾开荣
	 */
	public function get_trip_line($whereArr = array(), $find_in_set = array(), $number = 6, $page_new = 1) {
		$where = null;
		if (! empty ( $whereArr )) {
			foreach ( $whereArr as $key => $val ) {
				$where .= " {$key} = {$val} and";
			}
			$where = rtrim ( $where, 'and' );
		}
		$wf = null;
		if (! empty ( $find_in_set )) {
			foreach ( $find_in_set as $key => $val ) {
				$wf .= " (";
				foreach ( $val as $v ) {
					$wf .= " find_in_set ({$v} , $key) > 0 or"; // $key 检索的字段 $v 查询的id
				}
				$wf = rtrim ( $wf, 'or' ) . " ) and";
			}
			$wf = ' and (' . rtrim ( $wf, 'and' ) . ')';
		}
		$number = empty ( $number ) ? 6 : $number;
		$offset = (empty ( $page_new ) ? 0 : ($page_new - 1)) * $number;
		$limit = " limit {$offset} ,{$number} ";
		
		$sql = "select id,linename,mainpic,lineprice,saveprice from u_line where {$where} {$wf}  order by displayorder asc  {$limit}";
		$query = $this->db->query ( $sql );
		return $query->result_array ();
	}
	/**
	 *
	 * @method 根据目的地名称获取其ID
	 * @since 2015-06-04
	 * @author 贾开荣
	 * @param string $name
	 *        	目的地名称
	 */
	public function get_dest_id($name) {
		$sql = "select id from u_dest_base where kindname like '{$name}%'";
		$query = $this->db->query ( $sql );
		$data = $query->result_array ();
		if (! empty ( $data )) {
			return $data[0]['id'];
		}
		return false;
	}
	
	/**
	 *
	 * @method 获取周边游的目的地
	 * @since 2015-06-04
	 * @author 贾开荣
	 */
	public function get_round_trip($whereArr) {
		$this->db->select ( 't.destid,t.neighbor_id as id,d.kindname' );
		$this->db->from ( 'cfg_round_trip as t' );
		$this->db->join ( 'u_dest_base as d', 't.neighbor_id = d.id', 'left' );
		$this->db->where ( $whereArr );
		$query = $this->db->get ();
		return $query->result_array ();
	}
	/**
	 *
	 * @method 获取某个周边游的邻居目的地
	 * @since 2015-06-04
	 * @author 贾开荣
	 * @param intval $destid
	 *        	周边游配置表的目的地ID
	 * @param intval $number
	 *        	每页条数
	 * @param intval $page_new
	 *        	当前页
	 */
	public function get_dest_neighbor($destid, $number = 4, $page_new = 1) {
		$this->db->select ( 't.neighbor_id as id,d.kindname' );
		$this->db->from ( 'cfg_round_trip as t' );
		$this->db->join ( 'u_dest_base as d', 't.neighbor_id = d.id', 'left' );
		$this->db->where ( array(
				'destid' => $destid 
		) );
		
		$number = empty ( $number ) ? 4 : $number;
		$offset = (empty ( $page_new ) ? 0 : ($page_new - 1)) * $number;
		$this->db->limit ( $number, $offset );
		$result = $this->db->get ()->result_array ();
		if (empty ( $result )) {
			return array();
		}
		return $result;
	}
	/**
	 *
	 * @method 获取线路搜索价格条件
	 * @since 2015-06-05
	 * @author 贾开荣
	 *        
	 */
	public function get_search_line_price() {
		$this->db->select ( 'minprice,maxprice' );
		$this->db->from ( 'cfg_search_line_price' );
		$this->db->where ( array(
				'type' => 0 
		) );
		$this->db->order_by ( 'showorder', 'asc' );
		$result = $this->db->get ()->result_array ();
		if (empty ( $result )) {
			return array();
		}
		return $result;
	}
	
	/**
	 *
	 * @method 获取线路搜索天数条件
	 * @since 2015-06-05
	 * @author 贾开荣
	 *        
	 */
	public function get_search_line_day() {
		$this->db->select ( 'day' );
		$this->db->from ( 'cfg_search_line_day' );
		$this->db->where ( array(
				'ismobile' => 0 
		) );
		$this->db->order_by ( 'showorder', 'asc' );
		$result = $this->db->get ()->result_array ();
		if (empty ( $result )) {
			return array();
		}
		return $result;
	}
	
	/* 获取table的数据 */
	public function get_alldata($table, $where = '', $order = "", $limit = "") {
		$this->db->select ( '*' );
		if (! empty ( $where )) {
			$this->db->where ( $where );
		}
		if (! empty ( $order )) {
			$this->db->order_by ( $order, 'asc' );
		}
		if (! empty ( $limit )) {
			$this->db->limit ( 5 );
		}
		return $this->db->get ( $table )->result_array ();
	}
	
	/* 获取文章列表 */
	public function get_article_list($where) {
		$this->db->select ( 'art.id,art.title,art.content, attr.attr_name, attr.id as attrid,attr.ishome' );
		$this->db->from ( '	u_article AS art' );
		$this->db->join ( 'u_article_attr AS attr', ' art.attrid = attr.id', 'left' );
		$this->db->where ( $where );
		$this->db->order_by ( 'art.showorder', 'asc' );
		$result = $this->db->get ()->result_array ();
		return $result;
	}
	/* 常见问题文章列表 */
	public function get_article_FAQ($where) {
		$this->db->select ( 'art.id,art.title,art.content, attr.attr_name, attr.id as attrid,attr.ishome' );
		$this->db->from ( ' u_article_attr AS attr' );
		$this->db->join ( 'u_article AS art', ' art.attrid = attr.id', 'left' );
		$this->db->where ( $where );
		$this->db->order_by ( 'attr.showorder', 'asc' );
		$result = $this->db->get ()->result_array ();
		return $result;
	}
	/**
	 * 友情链接
	 * 翁金碧
	 */
	public function get_friend_link() {
		$this->db->select ( 'link_type,name,url,icon' );
		$this->db->from ( 'u_friend_link' );
		$this->db->order_by ( 'showorder' );
		$query = $this->db->get ();
		$result = $query->result_array ();
		return $result;
	}
}