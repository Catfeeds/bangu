<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Travel_note_model extends MY_Model {
	
	private $table_name = 'travel_note';
	
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method 获取申诉的游记数据
	 * @since  2015-12-10
	 * @param unknown $whereArr
	 * @param number $page
	 * @param number $num
	 */
	public function getTravelComplainData($whereArr ,$page=1 ,$num=10 ,$orderBy='tnc.id desc')
	{
		$whereStr = '';
		foreach($whereArr as $key=>$val)
		{
			if (empty($val) && $val !== 0) continue;
			if ($key == 'tn.title')
			{
				$whereStr .= ' '.$key.' like "%'.$val.'%" and';
			}
			else 
			{
				$whereStr .= ' '.$key.'="'.$val.'" and';
			}
		}
		$whereStr = rtrim($whereStr ,'and');
		$limitStr = ' limit '.($page-1)*$num.','.$num;
		$sql = 'select mo.supplier_name,mo.usedate,(mo.dingnum + mo.childnum +mo.oldnum + mo.childnobednum) as number,mo.addtime as orderAddtime,tn.usertype,tn.title,tn.shownum,m.truename,e.realname,me.status as mestatus,tnc.* from travel_note_complain as tnc left join travel_note as tn on tnc.travel_note_id = tn.id left join u_member as m on m.mid = tn.userid left join u_member_order as mo on mo.id=tn.order_id left join u_expert as e on e.id = tn.userid left join u_member_experience as me on mo.memberid = me.member_id where '.$whereStr.' order by '.$orderBy.$limitStr;
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取游记数据
	 * @since  2015-12-10
	 * @param unknown $whereArr
	 * @param number $page
	 * @param number $num
	 */
	public function getTravelNoteData($whereArr ,$page=1 ,$num=10 ,$orderBy='tn.id desc')
	{
		$whereStr = '';
		foreach($whereArr as $key=>$val)
		{
			if (empty($val) && $val !== 0) continue;
			if ($key == 'tn.title')
			{
				$whereStr .= ' '.$key.' like "%'.$val.'%" and';
			}
			else 
			{
				$whereStr .= ' '.$key.'="'.$val.'" and';
			}
		}
		if (!empty($whereStr))
		{
			$whereStr = ' where '.rtrim($whereStr ,'and');
		}
		
		$limitStr = ' limit '.($page-1)*$num.','.$num;
		$sql = 'select mo.supplier_name,mo.usedate,(mo.dingnum + mo.childnum +mo.oldnum + mo.childnobednum) as number,mo.addtime as orderAddtime,tn.usertype,tn.title,tn.shownum,tn.status,tn.is_show,tn.showorder,tn.id,tn.is_essence,tn.addtime,m.truename,e.realname,me.status as mestatus from travel_note as tn left join u_member as m on m.mid = tn.userid left join u_member_order as mo on mo.id=tn.order_id left join u_expert as e on e.id = tn.userid left join u_member_experience as me on mo.memberid = me.member_id '.$whereStr.' order by '.$orderBy.$limitStr;
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 游记申诉通过
	 * @since  2015-12-11
	 * @param unknown $travelId
	 * @param unknown $complainId
	 * @param unknown $complainArr
	 */
	public function throughComplain($travelId ,$complainId ,$complainArr)
	{
		$this->db->trans_start();
		//更改游记状态
		$sql = 'update travel_note set is_show = 0,status = -2,modtime="'.$complainArr['modtime'].'" where id='.$travelId;
		$this ->db ->query($sql);
		//更改申诉状态
		$this ->db ->where(array('id' =>$complainId));
		$this ->db ->update('travel_note_complain' ,$complainArr);
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	/**
	 * @method 游记申诉拒绝
	 * @since  2015-12-11
	 * @param unknown $travelId
	 * @param unknown $complainId
	 * @param unknown $complainArr
	 */
	public function refuseComplain($travelId ,$complainId ,$complainArr)
	{
		$this->db->trans_start();
		//更改游记状态
		$sql = 'update travel_note set is_show = 1,status = 1,modtime="'.$complainArr['modtime'].'" where id='.$travelId;
		$this ->db ->query($sql);
		//更改申诉状态
		$this ->db ->where(array('id' =>$complainId));
		$this ->db ->update('travel_note_complain' ,$complainArr);
	
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	/**
	 * @method 获取申诉记录
	 * @since  2015-12-11
	 * @param unknown $complain_id 申诉记录ID
	 */
	public function getComplainData($complain_id)
	{
		$sql = 'select * from travel_note_complain where id = '.$complain_id;
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取游记详情
	 * @param unknown $whereArr
	 */
	public function getTravelNoteDetail($whereArr) {
		$this ->db ->select('tn.*,mo.supplier_name,mo.productname,m.truename,e.realname,tnc.addtime as taddtime,tnc.reason,tnc.id as tid,me.status as mestatus,me.id as meid');
		$this ->db ->from('travel_note as tn');
		$this ->db ->join('u_member_order as mo','mo.id = tn.order_id' ,'left');
		$this ->db ->join('travel_note_complain as tnc','tn.id = tnc.travel_note_id','left');
		$this ->db ->join('u_expert as e' ,'e.id = tn.userid' ,'left');
		$this ->db ->join('u_member as m','m.mid = tn.userid' ,'left');
		$this ->db ->join('u_member_experience as me','mo.memberid = me.member_id' ,'left');
		$this ->db ->where($whereArr);
		$this ->db ->group_by("tn.id");

		$query = $this->db->get ();
		//echo $this ->db ->last_query();exit;
		return $query->result_array ();
	}
	/**
	 * @method 获取游记的图片
	 * @author jiakairong
	 * @param unknown $whereArr
	 */
	public function get_travel_pic ($whereArr) {
		$this ->db ->select('*');
		$this ->db ->from('travel_note_pic');
		$this ->db ->where($whereArr);
		return $this ->db ->get() ->result_array();
	}
	
	/**
	 * @method 获取游记数据(用于配置表选择游记)
	 * @author 贾开荣
	 * @param array $whereArr
	 * @param number $page
	 * @param number $num
	 * @param array  $keywordArr 关键字搜索
	 */
	public function getNoteCfgData (array $whereArr ,$page = 1, $num = 10 ,$keywordArr = array()) {
		$this ->db ->select ( 'tn.title,tn.id,tn.comment_count,tn.praise_count,tn.shownum,tn.is_essence,tn.cover_pic,l.startcity,l.mainpic,tn.usertype,tn.userid,s.cityname' );
		$this ->db ->from ( $this->table_name.' as tn');
		$this ->db ->join ('u_line as l','l.id = tn.line_id' ,'left');
		$this ->db ->join ('u_startplace as s' ,'s.id = l.startcity' ,'left');
		$this ->db ->where ( $whereArr );
	
		if (! empty ( $keywordArr ) && is_array ( $keywordArr )) {
			foreach ( $keywordArr as $key => $val ) {
				$this->db->or_like ( $key, $val );
			}
		}
		$this->db->order_by ( 'id', "desc" );
		if ($page > 0) {
			$num = empty ( $num ) ? 10 : $num;
			$offset = (empty ( $page ) ? 0 : ($page - 1)) * $num;
			$this->db->limit ( $num, $offset );
		}
		return $this->db->get ()->result_array ();
	}
}