<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Travel_note_model extends MY_Model {

	function __construct() {
		parent::__construct ( 'travel_note' );
	}
	/**
	 * @method 获取游记,用户没有登陆
	 * @author jiakaiorng
	 * @since  2015-08-15
	 * @param unknown $whereArr
	 * @param number $page
	 * @param number $num
	 * @param unknown $orderBy
	 */
	public function get_travel_data ($whereArr ,$page = 1,$num =10 ,$orderBy = 'tn.id' ,$isCount = false)
	{
		$whereStr = ' where ';
		foreach($whereArr as $key =>$val)
		{
			if (!empty($val) || $val === 0)
			{
				if ($key == 'l.overcity')
				{
					$whereStr .= " find_in_set ({$val} , l.overcity) > 0 and";
				}
				else
				{
					$whereStr .= " $key = '$val' and";
				}
			}
			else
			{
				continue;
			}
		}
		$whereStr = rtrim($whereStr ,'and');

		$limitStr = ' limit '.($page-1)*$num.','.$num;

		$sql = "select tn.id,tn.title,tn.praise_count,tn.comment_count,tn.addtime,tn.shownum,tn.cover_pic,l.overcity,l.overcity2,tn.usertype,tn.userid,e.realname,e.nickname,e.small_photo,me.status as mestatus,m.litpic,e.grade,m.truename,e.id as eid,me.id as meid from travel_note as tn left join u_expert as e on tn.userid = e.id left join u_member as m on tn.userid = m.mid left join u_member_experience as me on m.mid = me.member_id left join u_line as l on tn.line_id = l.id $whereStr ";

		if ($isCount === true)
		{
			$data['count'] = $this ->getCount($sql ,array());
			$sql = $sql.' order by '.$orderBy.' desc '.$limitStr;
			$data['travelData'] = $this ->db ->query($sql) ->result_array();
			return $data;
		}
		else
		{
			$sql = $sql.' order by '.$orderBy.' desc '.$limitStr;
			return $this ->db ->query($sql) ->result_array();
		}

	}

	/**
	 * @method 获取游记,用户有登陆
	 * @author jiakaiorng
	 * @since  2015-08-15
	 * @param unknown $whereArr
	 * @param number $page
	 * @param number $num
	 */
	public function getTravelData ($whereArr ,$page = 1,$num =10 ,$userid=0)
	{
		$whereStr = ' where ';
		foreach($whereArr as $key =>$val)
		{
			if (!empty($val) || $val === 0)
			{
				if ($key == 'l.overcity')
				{
					$whereStr .= " find_in_set ({$val} , l.overcity) > 0 and";
				}
				else
				{
					$whereStr .= " $key = '$val' and";
				}
			}
			else
			{
				continue;
			}
		}
		$whereStr = rtrim($whereStr ,'and');

		$limitStr = ' limit '.($page-1)*$num.','.$num;

		$sql = 'select tn.id,tn.title,tn.praise_count,tn.comment_count,tn.addtime,tn.shownum,tn.cover_pic,l.overcity,tn.usertype,tn.userid,e.realname,e.nickname,e.small_photo,me.status as mestatus,m.litpic,e.grade,m.truename,e.id as eid,me.id as meid,(select tnp.id from travel_note_praise as tnp where tnp.note_id=tn.id and member_id = '.$userid.' limit 1) as tnpid from travel_note as tn left join u_expert as e on tn.userid = e.id left join u_member as m on tn.userid = m.mid left join u_member_experience as me on m.mid = me.member_id left join u_line as l on tn.line_id = l.id'. $whereStr;

		$data['count'] = $this ->getCount($sql ,array());
		$sql = $sql.' order by tn.id desc '.$limitStr;
		$data['travelData'] = $this ->db ->query($sql) ->result_array();
		return $data;
	}

	/**
	 * @method 获取用户点赞记录
	 * @author jiakairong
	 */
	public function getTravelPraise($note_id ,$userid)
	{
		$sql = 'select id from travel_note_praise where note_id='.$note_id.' and member_id ='.$userid.' limit 1';
		return $this ->db ->query($sql)->result_array();
	}

	/**
	 * @method 游记点赞
	 * @param unknown $travel_id
	 * @param unknown $userid
	 */
	public function travelPraise($travel_id ,$userid)
	{
		$this->db->trans_start();
		$sql = 'update travel_note set praise_count = praise_count+1 where id = '.$travel_id;
		$this ->db ->query($sql);
		//写入用户点赞记录
		$arr = array(
				'note_id' =>$travel_id,
				'member_id' =>$userid,
				'ip' =>$_SERVER['REMOTE_ADDR'],
				'addtime' =>date('Y-m-d H:i:s' ,$_SERVER['REQUEST_TIME'])
		);
		$this ->db ->insert('travel_note_praise' ,$arr);

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			return false;
		} else {
			return true;
		}
	}
	/**
	 * @method 取消游记点赞
	 * @param unknown $travel_id
	 * @param unknown $userid
	 */
	public function cancelPraise($travel_id ,$userid)
	{
		$this->db->trans_start();
		$sql = 'update travel_note set praise_count = praise_count-1 where id = '.$travel_id;
		$this ->db ->query($sql);
		//删除用户点赞记录
		$sql = 'delete from travel_note_praise where member_id='.$userid.' and note_id='.$travel_id;
		$this ->db ->query($sql);

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * @method 获取游记详情
	 * @author wangxiaofeng
	 * @since  2015-08-18
	 * @param unknown $whereArr
	 * @param number $page
	 * @param number $num
	 */
	function get_travel_detail($usertype,$travel_note_id ,$page = 1,$num =10){
		switch($usertype){
			//会员
			case 0:
				$sql = "SELECT
				m.mid AS mid,m.litpic AS small_photo,m.nickname AS e_name,tn.is_show,
				(SELECT GROUP_CONCAT(attrname SEPARATOR ',') FROM u_line_attr AS la WHERE FIND_IN_SET(la.id,l.linetype)) AS line_attr,
				tn.title AS travel_theme,l.linename AS linename,l.id as lineid,l.overcity,tn.addtime AS publish_time,
				tn.praise_count AS praise_count,tn.comment_count AS comment_count,
				tn.content AS content,
				tn.travel_impress AS travel_impress
				FROM travel_note AS tn
				LEFT JOIN u_member AS m ON tn.userid =m.mid
				LEFT JOIN u_line AS l ON tn.line_id=l.id
				WHERE tn.id=$travel_note_id";
				break;
			//管家
			case 1:
				$sql = "SELECT
				e.id AS expert_id,tn.is_show,e.small_photo AS small_photo,e.nickname AS e_name,eg.title AS e_grade,tn.title AS travel_theme,l.linename AS linename,l.overcity,l.id as lineid,tn.addtime AS publish_time,(SELECT GROUP_CONCAT(attrname SEPARATOR ',') FROM u_line_attr AS la WHERE FIND_IN_SET(la.id,l.linetype)) AS line_attr, tn.praise_count AS praise_count,tn.comment_count AS comment_count,tn.content AS content,tn.travel_impress AS travel_impress
					FROM u_expert AS e LEFT JOIN travel_note AS tn ON e.id=tn.userid
					LEFT JOIN u_line AS l ON tn.line_id=l.id
					LEFT JOIN u_expert_grade AS eg ON e.grade=eg.grade
					WHERE tn.id=$travel_note_id";
				break;
			//体验师
			case 5:
				$sql = "SELECT
					me.id AS me_id,tn.is_show,m.mid AS mid,m.litpic AS small_photo,m.nickname AS e_name,
					(SELECT GROUP_CONCAT(attrname SEPARATOR ',') FROM u_line_attr AS la WHERE FIND_IN_SET(la.id,l.linetype)) AS line_attr,
					tn.title AS travel_theme,l.linename AS linename,l.overcity,l.id as lineid,tn.addtime AS publish_time,
					tn.praise_count AS praise_count,tn.comment_count AS comment_count,
					tn.content AS content,tn.travel_impress AS travel_impress
					FROM travel_note AS tn LEFT JOIN u_member_experience AS me ON tn.userid=me.member_id
					LEFT JOIN u_member AS m ON me.member_id=m.mid
					LEFT JOIN u_line AS l ON tn.line_id=l.id
					WHERE tn.id=$travel_note_id";
			break;
		}

		$result = $this ->db ->query($sql) ->result_array();
		array_walk($result, array($this, '_fetch_list'));
		return $result;
	}

	/**
	 * @method 获取游记图片
	 * @author wangxiaofeng
	 * @since  2015-08-18
	 * @param unknown $whereArr
	 * @param number $page
	 * @param number $num
	 */
	function get_travel_pic($travel_note_id,$page = 1,$num =10){
	$sql = "SELECT tn.id AS tn_id,tnp.description,
		tnp.pic AS t_pic,tnp.pictype
		FROM travel_note AS tn LEFT JOIN travel_note_pic AS tnp ON tn.id=tnp.note_id
		WHERE tn.id=$travel_note_id ORDER BY tnp.pictype desc";
		$result = $this ->db ->query($sql) ->result_array();
		//array_walk($result, array($this, '_fetch_list'));
		return $result;
	}

	function get_comment($whereArr ,$page = 1,$num =10){
		$this->db->select('m.mid AS m_id,
			tn.id AS note_id,
			m.litpic AS litpic,
			m.nickname AS nickname,
			tnr.reply_content AS reply_content,
			tnr.addtime AS publish_time');
		$this->db->from('travel_note_reply AS tnr');
		$this->db->join('travel_note AS tn','tnr.note_id=tn.id','left');
		$this->db->join('u_member AS m','tnr.member_id=m.mid','left');
		$this->db->where($whereArr);
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
		}
		$this->db->order_by('tnr.addtime','desc');
		$result=$this->db->get()->result_array();
		return $result;
	}

	/**
	 * wangxiaofeng
	 * 游记相关产品
	 * @return [type] [description]
	 */
	function get_relate_products(){
		$sql = "SELECT l.id AS line_id,l.linename AS line_name,l.mainpic AS line_pic,l.lineprice AS lineprice,l.overcity
	FROM travel_note AS tn LEFT JOIN u_line AS l ON tn.line_id=l.id ORDER BY tn.addtime DESC limit 5";
		return $this ->db ->query($sql) ->result_array();
	}

	/**
	 * 游记推荐
	 * wangxiaofeng
	 * @return [type] [description]
	 */
	function recommend_note(){
		/*SELECT
tn.id AS '游记id',tn.cover_pic AS '封面图',tn.title AS '标题',tn.addtime AS '创建时间',
CASE
WHEN tn.usertype=1 THEN e.id
WHEN tn.usertype=0 THEN m.mid
END '名字',e.realname,m.truename
FROM travel_note AS tn LEFT JOIN u_member AS m ON tn.userid=m.mid
LEFT JOIN u_expert AS e ON tn.userid=e.id
LEFT JOIN u_member_experience AS me ON m.mid = me.member_id
ORDER BY tn.addtime DESC*/

		$sql = "SELECT tn.id AS note_id,me.status as mestatus,me.id as meid,tn.usertype AS usertype,tn.cover_pic AS cover_pic,tn.title AS title,tn.addtime AS addtime,CASE
	WHEN tn.usertype=1 THEN e.nickname
	WHEN tn.usertype=0 THEN m.truename
	END publisher
	FROM travel_note AS tn LEFT JOIN u_member AS m ON tn.userid=m.mid
	LEFT JOIN u_expert AS e ON tn.userid=e.id LEFT JOIN u_member_experience AS me ON m.mid = me.member_id ORDER BY tn.addtime DESC limit 6 ";
		return $this ->db ->query($sql) ->result_array();
	}

	/**
	 * 处理函数
	 * @param unknown $value
	 * @param unknown $key
	 */
	protected function _fetch_list(&$value, $key) {
		if(isset($value['line_attr']) && !empty($value['line_attr'])){
			$value['line_attr'] = rtrim($value['line_attr'],',');
			$line_attr_arr = explode(',',$value['line_attr']);
			$value['line_attr_arr'] = $line_attr_arr;
		}
		if(!isset($value['e_grade']) || empty($value['e_grade'])){
			if(isset($value['me_id']) && !empty($value['me_id'])){
				$value['e_grade'] = '体验师';
			}else{
				$value['e_grade'] = '会员';
			}
		}

		/*if(isset($value['t_pic']) && !empty($value['t_pic'])){
			$value['t_pic'] = rtrim($value['t_pic'],';');
			$line_attr_arr = explode(';',$value['t_pic']);
			$value['t_pic_arr'] = $line_attr_arr;
		}*/
	}
}