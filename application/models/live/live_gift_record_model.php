<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Live_gift_record_model extends APP_Model {
	/**
	 * 模型表名称
	 * @var String
	 */
	protected  $table= 'live_gift_record';
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ( $this->table );
	}
	/**
	 * @method 获取直播房间的贡献排行
	 * @author jkr
	 * @param unknown $anchor_id 主播ID
	 * @param unknown $room_id 房间ID
	 * @param unknown $room_code 房间标识
	 */
	public function contributeRanking($anchor_id ,$room_id ,$room_code)
	{
		$sql = 'select sum(gr.worth) as umoney,a.name as username,gr.user_id from live_gift_record as gr left join live_anchor as a on a.anchor_id=gr.user_id where gr.anchor_id ='.$anchor_id.' and gr.room_id='.$room_id.' and gr.room_code ='.$room_code .' group by gr.user_id order by umoney desc limit 5';
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取主播当次直播获得的U币
	 * @author jkr
	 * @param unknown $anchor_id 主播ID
	 * @param unknown $room_id 房间ID
	 * @param unknown $room_code 房间标识
	 */
	public function anchorUMoneySum($anchor_id ,$room_id ,$room_code)
	{
		$sql = 'select sum(worth) as umoney from live_gift_record where anchor_id ='.$anchor_id.' and room_id='.$room_id.' and room_code ='.$room_code;
		return $this ->db ->query($sql) ->row_array();
	}
	/**
	 * @method 获取打赏记录数据
	 * @author jiakairong
	 * @param array $whereArr
	 */
	public function getRecordData(array $whereArr ,$orderBy = 'gr.id desc')
	{
		$sql = 'select gr.*,a.name as anchor,g.gift_name,la.name as username from live_gift_record as gr left join live_anchor as a on a.anchor_id=gr.anchor_id left join live_gift as g on g.gift_id=gr.gift_id left join live_anchor as la on la.anchor_id = gr.user_id ';
		return $this ->queryCommon($sql ,$whereArr , $this ->getLimitStr() ,'order by '.$orderBy);
	}
	/**
	 * @method 获取记录总数
	 * @author jiakairong
	 * @param array $whereArr
	 */
	public function getRecordCount(array $whereArr)
	{
		$sql = 'select count(*) as count from live_gift_record as gr left join live_anchor as a on a.anchor_id=gr.anchor_id left join live_gift as g on g.gift_id=gr.gift_id left join live_anchor as la on la.anchor_id = gr.user_id';
		return $this ->queryCommonRow($sql ,$whereArr);
	}
	/**
	 * @method 获取某个会员的打赏记录，用于app接口
	 * @param unknown $user_id 会员ID
	 */
	public function getAppRecordData($user_id ,$page=1 ,$pagesize=10)
	{
		$sql = 'select gr.*,g.gift_name,a.name as anchor_name from live_gift_record as gr left join live_gift as g on g.gift_id=gr.gift_id left join live_anchor as a on a.anchor_id = gr.anchor_id where gr.user_id='.$user_id.' order by gr.id desc limit '.($page-1)*$pagesize.','.$pagesize;
		return $this ->db ->query($sql) ->result_array();
	}
}