<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Line_detail_model extends MY_Model {

	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ( 'u_line' );
	}

	/**
	 * 获取促销价，促销价为今日之后的最小成人价
	 * @param intval $lineid 线路ID
	 * @author jkr
	 */
	public function getMinPrice($lineid)
	{
		$day = date('Y-m-d' ,time());
		$sql = 'select adultprice from u_line_suit_price where lineid='.$lineid.' and day >="'.$day.'" order by adultprice asc limit 1';
		return $this ->db ->query($sql) ->row_array();
	}
	
	/**
	 * 获取线路相册图片
	 */
	public function get_album_data($where)
	{
		$sql = 'select l.id,la.filename,la.filepath from u_line as l left join u_line_pic as lp on lp.line_id=l.id left join u_line_album as la on la.id=lp.line_album_id'.$this ->getWhereStr($where);
		return $this ->db ->query($sql) ->result_array();
		
		$this->db->select ( 'l.id,la.filename,la.filepath' );
		$this->db->from ( 'u_line AS l' );
		$this->db->join ( 'u_line_pic AS lp', 'l.id=lp.line_id', 'left' );
		$this->db->join ( 'u_line_album AS la', 'lp.line_album_id=la.id', 'left' );
		$this->db->where ( $where );
		$query = $this->db->get ();
		return $query->result_array ();
	}

	/**
	 * 获取某条线路的信息 (主表)
	 */
	public function get_line_detail($where) {
		$this->db->select ( 't.name as theme_name,l.overcity,l.units,l.id,l.supplier_id,l.linename,l.line_beizhu,l.linetitle,l.linecode,l.features,l.product_recommend,l.lineprice,l.saveprice,l.linepic,l.satisfyscore,l.comment_count AS peoplecount,l.comment_score AS comments,l.bookcount AS bookcount,l.peoplecount AS sales,l.all_score,s.cityname,l.childrule,l.product_recommend,l.simple_trip,(select count(*) from travel_note AS tn where tn.line_id=l.id and tn.usertype=0 and tn.is_show=1 and tn.status=1) AS sharecount,(SELECT COUNT(*) FROM u_line_question AS lq WHERE lq.productid=l.id) AS online,l.feeinclude,l.feenotinclude,l.book_notice,l.visa_content,l.beizu,l.linedoc,l.sell_direction,l.insurance,l.special_appointment,l.safe_alert,l.other_project,l.child_description,l.child_nobed_description,l.old_description,l.special_description,l.lineday' );
		$this->db->from ( "u_line AS l" );
		$this->db->join ( 'u_startplace AS s', 'l.startcity=s.id', 'left' );
		$this->db->join ( 'u_comment AS c', 'c.line_id=l.id', 'left' );
		$this->db->join ( 'u_theme as t' ,'t.id = l.themeid' ,'left');
		$this->db->where ( $where );
		$query = $this->db->get ();
		$data = $query->result_array ();
		if (empty ( $data )) {
			return false;
		}
		return $data[0];
	}

	/**
	 * 获取线路套餐
	 */
	public function get_suit_data($where) {
		$this->db->select ( '*' );
		$this->db->from ( 'u_line_suit' );
		$this->db->where ( $where );
		$this->db->order_by ( "displayorder", "desc" );
		$query = $this->db->get ();
		return $query->result_array ();
	}

	/**
	 * 获取套餐价格日历
	 */
	public function get_suit_price($where) {
		$this->db->select ( '*' );
		$this->db->from ( 'u_line_suit_price' );
		$this->db->where ( $where );
		$query = $this->db->get ();
		return $query->result_array ();
	}

	/**
	 * 根据线路ID，查费用包含和不包含，预定须知,签证
	 */
// 	public function line_info($where) {
// 		$this->db->select ( 'id,feeinclude,feenotinclude,book_notice,visa_content,beizu' );
// 		$this->db->from ( 'u_line' );
// 		$this->db->where ( $where );
// 		$query = $this->db->get ();
// 		return $query->result_array ();
// 	}

	/**
	 * 获取专家
	 */
	public function get_expert_data($where, $page = 1, $num = 4,$city_localtion = array()) {
		$this->db->select ( "e.id,la.line_id,e.small_photo,e.online,e.supplier_id,e.nickname,a.name AS city,eg.title AS grade,e.people_count AS scheme,e.comment_count,e.satisfaction_rate" );
		$this->db->from ( 'u_expert AS e' );
		$this->db->join ( 'u_line_apply AS la', 'la.expert_id=e.id', 'left' );
		$this->db->join ( 'u_expert_grade AS eg', 'la.grade=eg.grade', 'left' );

		$this->db->join ( 'u_area AS a','a.id=e.city','left');
		$this->db->where ( $where );
		if(!empty($city_localtion)){
			$this->db->where_in('e.city', $city_localtion );
		}
		$num = empty ( $num ) ? 4 : $num;
		$offset = (empty ( $page ) ? 0 : ($page - 1)) * $num;
		$this->db->order_by('e.online','desc');
		//$this->db->order_by('e.expert_type','desc');
		$this->db->order_by('e.people_count','desc');
		$this->db->limit ( $num, $offset );
		$query = $this->db->get ();
		return $query->result_array ();
	}

	/**
	 * 获取站点的城市ID 和 它的子ID
	 */
	public function get_city_localtion(){
		$p_city_id = $this->session->userdata('city_location_id');
		$return_array = array($p_city_id);
		$get_child_id_sql = 'SELECT startplace_child_id FROM u_startplace_child WHERE startplace_id='.$p_city_id;
		$res = $this->db->query($get_child_id_sql)->result_array();
		if(empty($res)){
			return $return_array;
		}else{
			foreach ($res as $key => $val) {
				$return_array[] = $val['startplace_child_id'];
			}
			return $return_array;
		}
	}

	/**
	 * 获取某条线路的行程
	 */
	public function get_line_jieshao($where) {
		$this->db->select ( 'lj.day AS days,
				      lj.title AS theme,
				      lj.breakfirst AS dejeuner,
				      lj.breakfirsthas,
				      lj.lunchhas,
				      lj.lunch,
				      lj.supperhas,
				      lj.supper,
				      lj.transport AS traffic,
				      lj.jieshao AS introduce,
				      lj.lunch AS nooning,
				      lj.supper AS dinner,
				      lj.hotel,
				      lp.pic AS c_pic' );
		$this->db->from ( 'u_line_jieshao AS lj' );
		$this->db->join('u_line_jieshao_pic AS lp','lj.id=lp.jieshao_id','left');
		$this->db->where ( $where );
		$this->db->order_by ( 'day' );
		$result = $this->db->get ()->result_array();
		array_walk($result, array($this, '_fetch_list'));
		return $result;
	}

	/**
	 * 统计某条线路的点评数量 全部评论 满意 不满意 一般
	 */
	public function get_comment_count($where, $page = 1, $num = 2) {
		$this->db->select ( 'count(id) as total,avgscore1,haspic' );
		$this->db->from ( 'u_comment AS c' );
		$this->db->where ( $where );
		if ($page > 0) {
			$this->db->group_by ( 'avgscore1' );
		}
		$query = $this->db->get ();
		return $query->result_array ();
	}

	/**
	 * 获取某条线路的点评
	 */
	public function get_comment_data($where, $page = 1, $num = 2) {
		$this->db->select ( 'c.id,m.litpic,m.truename,c.pictures,c.isanonymous,c.avgscore1,c.score1,c.score2,c.score3,c.score4,c.content,c.addtime,(case when c.channel=0 then "网页" when c.channel=1 then "APP" end) AS channel, c.reply1 AS supplier_reply, c.reply2 AS admin_reply ' );
		$this->db->from ( 'u_comment AS c' );
		$this->db->join ( 'u_member as m', 'c.memberid=m.mid', 'left' );
		$this->db->join ( 'u_member_order as mo', 'c.orderid=mo.id', 'left' );
		$this->db->join ( 'u_line AS l', 'mo.productautoid=l.id', 'left' );
		$this->db->where ( $where );
		$num = empty ( $num ) ? 2 : $num;
		$offset = (empty ( $page ) ? 0 : ($page - 1)) * $num;
		if ($page > 0) {
			$this->db->limit ( $num, $offset );
		}
		$query = $this->db->get ();
		return $query->result_array ();
	}

	//获取在线留言的数据
	function get_online_msg($line_id, $typeid, $page = 1, $num = 2){
		$sql = "SELECT lq.id,lq.typeid AS typeid,m.nickname AS nickname,lq.content AS content,e.nickname AS e_name,lq.replycontent AS replycontent FROM u_line_question AS lq LEFT JOIN u_member AS m ON lq.memberid=m.mid LEFT JOIN u_expert AS e ON (lq.reply_id=e.id AND reply_type=1) WHERE ISNULL(lq.replytime)=0 AND lq.productid={$line_id} ";
		if(!empty($typeid) && $typeid!=0){
			$sql = $sql." AND lq.typeid={$typeid} ";
		}
		$num = empty ( $num ) ? 2 : $num;
		$offset = (empty ( $page ) ? 0 : ($page - 1)) * $num;
		 if ($page > 0) {
			$offset = ($page-1) * $num;
			$sql = $sql." ORDER BY lq.addtime DESC";
			$sql = $sql." limit $offset,$num";
		}
		$query = $this->db->query($sql);
		$result=$query->result_array();
		if(!empty($result)){
			foreach ($result as $key => &$value) {
				if(mb_strlen($value['nickname'],'utf-8')>5){
					$nickname_tmp =  mb_substr($value['nickname'],0,5,'utf-8');
					$nick_str1 = mb_substr($nickname_tmp,0,1,'utf-8');
					$nick_str2 = mb_substr($nickname_tmp,-1,1,'utf-8');
					$value['nickname'] = $nick_str1.'***'.$nick_str2;
				}
			}
		}
		return $result;
	}

	/**
	 * 获取某条线路的游客分享
	 */
	public function get_share_data($where, $page = 1, $num = 2) {
		$num = empty ( $num ) ? 2 : $num;
		$offset = (empty ( $page ) ? 0 : ($page - 1)) * $num;
		if($page>0){
			$limit = "limit $offset,$num";
		}else{
			$limit = "";
		}
		$sql = "SELECT
		tn.id AS tn_id,m.litpic AS litpic,m.nickname AS nickname,tn.title AS title,
		(SELECT GROUP_CONCAT(tnp.pic SEPARATOR ';') FROM travel_note_pic AS tnp WHERE tnp.note_id=tn.id LIMIT 4) AS pic,
		tn.addtime AS addtime,
		CASE
		WHEN m.mid IN (SELECT me.member_id FROM u_member_experience AS me) THEN 5
		ELSE 0
		END usertype
		FROM travel_note AS tn LEFT JOIN u_line AS l ON tn.line_id=l.id
		LEFT JOIN u_member AS m ON tn.userid=m.mid
		WHERE tn.usertype=0   and tn.status=1 and tn.line_id=$where $limit";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/**
	 * @method 相关目的地的线路，按销量排序
	 * @param unknown $destId 目的地
	 */
	public function get_hot_line($destArr ,$cityId)
	{
		$get_start_id_sql = "SELECT id FROM u_startplace WHERE cityname='全国出发' ";
		$start_res = $this ->db ->query($get_start_id_sql) ->result_array();
		$departure_id = $start_res[0]['id'];
		$findStr = '';
		foreach($destArr as $v)
		{
			$findStr .= ' find_in_set('.$v.' ,overcity) or';
		}
		if (!empty($findStr))
		{
			$findStr = ' and ('.rtrim($findStr ,'or').')';
		}
		
		
		$sql = 'select l.id,l.linename,l.lineprice,l.linepic,l.mainpic,l.overcity from u_line AS l LEFT JOIN u_line_startplace AS ls ON ls.line_id=l.id where l.status=2 and l.producttype=0 and (ls.startplace_id = '.$cityId.' OR ls.startplace_id='.$departure_id.')  '.$findStr.' group by l.id order by bookcount desc limit 0,10';
		return $this ->db ->query($sql) ->result_array();
	}

	/**
	 * 在线咨询
	 */
	public function get_on_line($where) {
		$this->db->select ( 'id,productid,content,typeid' );
		$this->db->from ( 'u_line_question' );
		$this->db->where ( $where );
		$query = $this->db->get ();
		return $query->result_array ();
	}

	/**
	 * 获取专家心得
	 */
	public function get_expert_mind($where) {
		$this->db->select ( "e.id,e.small_photo,e.realname,e.city,(CASE WHEN e.grade=0 THEN '初级' WHEN e.grade=1 THEN '中级' WHEN e.grade=2 THEN '高级' END) AS grade,e.business,e.talk" );
		$this->db->from ( 'u_expert AS e' );
		$this->db->join ( 'u_line_apply AS la', 'e.id=la.expert_id', 'left' );
		$this->db->where ( $where );
		$query = $this->db->get ();
		return $query->result_array ();
	}

	/**
	 * 线路属性
	 */
	public function get_line_property($l_id) {
		$sql = "SELECT * FROM u_line_attr st WHERE FIND_IN_SET(st.id ,(SELECT l.linetype FROM u_line l WHERE l.id=$l_id))>0 ORDER BY st.pid ASC";
		$result = $this->db->query ( $sql );
		return $result->result_array ();
	}

	/**
	 * 向评论表那里插入用户在线咨询
	 */
	function inert_online_consultation($insert_data = array()) {
		$insert_data['addtime'] = date ( 'Y-m-d H:i:s' );
		$this->db->insert ( 'u_line_question', $insert_data );
	}

	/**
	 * 线路是否已经被收藏
	 */
	public function get_line_collection($whereArr=array())
	{
		$sql = 'select count(*) AS collection_count from u_line_collect '.$this ->getWhereStr($whereArr);
		return $this ->db ->query($sql) ->result_array();
		
		$this->db->select ( "count(*) AS collection_count" );
		$this->db->from ( 'u_line_collect' );
		$this->db->where ( $whereArr );
		$query = $this->db->get ();
		return $query->result_array ();
	}

	/**
	 * 收藏线路
	 */
	function insert_line_collection($insert_data = array()){
		$insert_data['addtime'] = date ( 'Y-m-d H:i:s' );
		$this->db->insert ( 'u_line_collect', $insert_data );
		return $this->db->insert_id();
	}

	/**
	 * 删除收藏线路
	 */
	function delete_line_collection($whereArr=array()){
		if($this->db->delete('u_line_collect', $whereArr)){
			return true;
		}else{
			return false;
		}
	}

	//每次点击进入线路详情的时候,浏览数就加一次
	function update_shownum($line_id){
		$sql = 'UPDATE u_line SET shownum=shownum+1 WHERE id='.$line_id;
		$result = $this->db->query ( $sql );
		return $result;
	}



	/**
	 * 回调函数
	 * @param unknown $value
	 * @param unknown $key
	 */
	protected function _fetch_list(&$value, $key) {
		if(isset($value['c_pic'])&&$value['c_pic']!=''){
			$c_pic = trim($value['c_pic'], ';');
			$pic_arr = explode(';', $c_pic);
			$value['pic_arr'] = $pic_arr;
		}
	}


}
