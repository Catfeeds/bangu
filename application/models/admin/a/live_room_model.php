<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年5月23日11:53:18
 * @author		汪晓烽
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Live_room_model  extends APP_Model{

	protected $table="live_room";
	protected $room_timeout = 1800;//房间使用时间长度，以秒为单位	
    private $dictionary=array(
	    'DICT_ROOM_ATTR' => 1,//房间标签id
	);	
	public function __construct() {
		parent::__construct($this->table);
	}


	public function getRooms($whereArr = array()) {
		if(!isset($whereArr['status='])){
			$whereArr['status>'] = 0;
		}
		$whereArr[' live_status= '] = 1;
		$nowtime = time();		
		$whereStr = ' createtime>'.($nowtime - $this->room_timeout).' and';
		foreach ($whereArr as $key=>$val){
			$whereStr .= ' '.$key.'"'.$val.'" and';
		}
		if (!empty($whereStr)){
			$whereStr = ' where '.rtrim($whereStr ,'and');
		}
		$sql = 'select * from live_room  '.$whereStr;
		$data['count'] = $this ->getCount($sql, array());
		$live_room_data = $this ->db ->query($sql.' order by room_id desc '.$this ->getLimitStr()) ->result_array();
		
		
		$sql_str = "select dict_id as categoryid,description as categoryname from live_dictionary where enable=0 and pid=".$this->dictionary['DICT_ROOM_ATTR']." ";
		$category_live_dictionary_data = $this->live_db->query($sql_str)->result_array();
		$attr_data = array();
		if(!empty($category_live_dictionary_data)){
			foreach ($category_live_dictionary_data as $key => $value) {				
				$attr_data[$value['categoryid']] = $value['categoryname'];
			}		
		}		
		
		
		$num_live_room_data = count($live_room_data);
		$anchor_ids = array();
		if($num_live_room_data>0){
			foreach($live_room_data as $v){
				$anchor_ids[$v['anchor_id']] = $v['anchor_id'];					
			}
		}		
		$live_anchor_ids_data = array();		
		if(!empty($anchor_ids)){
			$sql_str = "select anchor_id,user_id,name,user_type,video_pic,sex,photo,type from live_anchor where anchor_id in(".implode(",",$anchor_ids).") ";
			$live_anchor_data = $this->db->query($sql_str)->result_array();
			foreach($live_anchor_data as $v){
				$live_anchor_ids_data[$v['anchor_id']] = $v;
			}			
		}
		if($num_live_room_data>0){
			foreach($live_room_data as $k=> $v){
				if(isset($live_anchor_ids_data[$v['anchor_id']])){
					if(empty($v['cover'])){
						$live_room_data[$k]['cover'] = $live_anchor_ids_data[$v['anchor_id']]['video_pic'];					
					}
					if(strpos($live_room_data[$k]['cover'],'http://')!==0){
						$live_room_data[$k]['cover'] = trim(base_url(''),'/').$live_room_data[$k]['cover'];							
					}
					$live_room_data[$k]['avatar'] = trim(base_url(''),'/').$live_anchor_ids_data[$v['anchor_id']]['photo'];
					$live_room_data[$k]['anchor_name'] = $live_anchor_ids_data[$v['anchor_id']]['name'];				
					$live_room_data[$k]['anchor_sex'] = $live_anchor_ids_data[$v['anchor_id']]['sex'];
					$live_room_data[$k]['anchor_type'] = $live_anchor_ids_data[$v['anchor_id']]['type'];
					$live_room_data[$k]['user_id'] = $live_anchor_ids_data[$v['anchor_id']]['user_id'];
									
				}
				if($v['starttime']<$v['endtime']){
					$live_room_data[$k]['usetime'] = intval(($v['endtime'] - $v['starttime'])/60);
				}else{
					$live_room_data[$k]['usetime'] = '';
				}
				$live_room_data[$k]['starttime'] = date("Y-m-d H:i:s",$v['starttime']);
				$live_room_data[$k]['attrname'] = $attr_data[$v['attr_id']];				
			}
		}	
		$data['data'] = $live_room_data;
		return $data;
	}


	//获取全部没有分配过专属房间的主播
	function get_all_anchor($whereArr=array(),$page=1 ,$num=10){
		$whereArr[' status= '] = 1;
		$whereArr[' room_id= '] = 0;
		$whereStr = '';
		foreach ($whereArr as $key=>$val){
			$whereStr .= ' '.$key.'"'.$val.'" and';
		}
		if (!empty($whereStr)){
			$whereStr = ' where '.rtrim($whereStr ,'and');
		}
		$limieStr = ' limit '.($page - 1) * $num.','.$num;
		$sql = ' SELECT * FROM live_anchor '.$whereStr.$limieStr;
		$res =  $this->db->query($sql)->result_array();
		$data['list'] = $res;
		$data['count'] = $this->getCountNumber($this->db->last_query());
		return $data;
	}


	//获取记录的总条数
	public function getCountNumber($sql) {
		if (stripos($sql ,'limit')) {
			$sql = substr($sql ,0 ,stripos($sql ,'limit'));
		}
		$query = $this->db->query("SELECT COUNT(*) AS num FROM (".$sql.") va");
		$result = $query->result();
		$totalRecords = $result[0]->num;
		return $totalRecords;
	}

	function add_room($insert_data=array()){
		$this->db->insert('live_room', $insert_data);
		return $this->db->insert_id();
	}

	//分配专属或者解除专属房间给主播
	function anchor_to_room($anchor_id, $room_id,$is_bind=1){
		if($is_bind==1){
			//确定分配专属房间
			$sql = 'UPDATE live_anchor SET room_id='.$room_id.' WHERE anchor_id in ('.$anchor_id.')';
		}else{
			$sql = 'UPDATE live_anchor SET room_id=0 WHERE anchor_id in ('.$anchor_id.')';
		}
			$status = $this->db->query($sql );
			return $status;
	}


	//获取修改的数据

	function get_edit_data($room_id){
		$sql = 'SELECT r.*, GROUP_CONCAT(a.anchor_id) AS str_anchor_id,GROUP_CONCAT(a.name) AS str_anchor_name  FROM live_room AS r LEFT JOIN live_anchor AS a ON a.room_id=r.room_id WHERE r.room_id='.$room_id;
		$res =  $this->db->query($sql )->result_array();
		$result = $res[0];
		/*if(!empty($result['str_anchor_id'])){
			$anchor_id_arr = explode(',', $str_anchor_id);
			$anchor_name_arr = explode(',', $str_anchor_name);
			$arr_count = count($anchor_id_arr);
			for($i=0; $i<$arr_count; $i++){
				$str_res += $anchor_id_arr[$i]+'|'+$anchor_name_arr[$i]+';';
			}
			$str_res = rtrim($str_res,';');
		}
		$result['res_str'] = $str_res;*/
		return $result;
	}


	/**************************以下方法都是供 API 操作数据库使用*******************************************/
	//用于API接口获取主播信息
	public function get_anchor($user_id,$user_type){
		$sql = 'SELECT * FROM live_anchor WHERE user_id= '.$user_id.' and user_type= '.$user_type;
		$res =  $this->db->query($sql )->result_array();
		return $res[0];
	}
	//获取房间数据
	public function get_room($whereArr=array()){
		$whereArr[' status= '] = 1;
		$whereStr = '';
		foreach ($whereArr as $key=>$val){
			$whereStr .= ' '.$key.'"'.$val.'" and';
		}
		if (!empty($whereStr)){
			$whereStr = ' where '.rtrim($whereStr ,'and');
		}
		$sql = 'select * from live_room  '.$whereStr;
		$sql = ' SELECT * FROM live_room '.$whereStr." limit 1";
		$res =  $this->db->query($sql )->result_array();
		if(!empty($res)){
			return $res[0];
		}else{
			return array();
		}
	}

	//当分配房间/或者真正开始直播推流了以后需要修改一下主播和房间的状态
	public function update_live($anchor_id,$anchor_data=array(),$room_id,$room_data=array()){
		$this->db->update('live_anchor', $anchor_data, array('anchor_id' => $anchor_id));
		$this->db->update('live_room', $room_data, array('room_id' => $room_id));
	}

	//开始直播的时候修改房间状态(****暂停使用这个***)
	public function start_live($anchor_id,$room_id){
		$this->db->update('live_room', array("live_status"=>1), array('room_id' => $room_id,"anchor_id"=>$anchor_id));
	}
	//找到视频数据之后更新到我们的数据库
	public function update_video_data($video_id="", $update_data=array()){
		$this->db->update('live_video', $update_data, array('id' =>$video_id));
	}

	//开始设置封面和名称的时候插入表
	public function insert_video_data($data=array()){
		$status = $this->db->insert('live_video', $data);
		return $this->db->insert_id();
	}


	//开始设置封面和名称的时候插入表
	public function get_video_data($video_id){
		$sql = 'SELECT v.*, dict.description AS attr_name FROM live_video AS v LEFT JOIN live_dictionary AS dict ON dict.dict_id=v.attr_id WHERE v.id='.$video_id;
		$res =  $this->db->query($sql )->result_array();
		if(!empty($res)){
			return $res[0];
		}else{
			return array();
		}

	}

	//观众进入房间和退出房间的时候增减peoples字段
	function update_peoples($room_id,$type='in'){
		if($type=='in'){
			//观众进入房间
			$sql='UPDATE live_room SET peoples=peoples+1 WHERE room_id='.$room_id;
		}else{
			//观众退出房间观看的时候
			$sql='UPDATE live_room SET peoples=peoples-1 WHERE room_id='.$room_id;
		}
		$status = $this->db->query($sql);
		return $status;
	}

	//主播设置视频信息的时候回去直播字典里的属性
	function get_live_dict($dict_id){
		$sql = 'SELECT * FROM live_dictionary WHERE pid='.$dict_id;
		$res =  $this->db->query($sql )->result_array();
		return $res;
	}

}