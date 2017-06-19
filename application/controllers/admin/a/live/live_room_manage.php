<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version	1.0
 * @since		2016年5月24日11:20:18
 * @author	汪晓烽
 */
if (! defined ( 'BASEPATH' ))
exit ( 'No direct script access allowed' );
header("Content-Type:text/html;chasrset=utf-8");
class Live_room_manage extends UA_Controller{

	private static $url = "https://livevip.com.cn/liveApi/";
	private static $username = "2853553772@qq.com";
	private static $password = "123456";
	private static $http_header = array("Accept:application/json");
    private $dictionary=array(
	    'DICT_ROOM_ATTR' => 1,//房间标签id
	);
	const pagesize = 10; //分页的页数	
	private $web_url = "http://www.1b1u.com";	
	public function __construct(){
		parent::__construct ();
		$this->load_model ( 'admin/a/live_room_model', 'live_room' );
		$this->load_model ( '/live/video_model', 'video_model' );		
		$this->live_db = $this->load->database ( "live", TRUE );	
		$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
		if(strpos($_SERVER['HTTP_HOST'],'www.1b1u.com')===0){
			$this->web_url = $http_type.'www.1b1u.com';		
		}else if(strpos($_SERVER['HTTP_HOST'],'t.w.1b1u.com')===0){
			$this->web_url = $http_type.'t.w.1b1u.com';			
		}else {
			$this->web_url = $http_type.'pubtest.1b1u.com';
		}
		
	}

	
	/**
	 * @method 录播视频用户操作日志列表
	 */
	public function roomuserlog($room_id=0)
	{
		$room_id = $this ->input ->get_post('room_id' ,true);
		$data['logs']= $this->live_db ->query( "select * from live_room_userlog where room_id=".$room_id." ") ->result_array();
		$data['room_id']= $room_id;
		$this->load_view ( 'admin/a/live/roomuserlog',$data);
	}	

	/**
	 * @method 历史直播列表
	 */
	public function oldroomlist($page=1)
	{
		$name = $this ->input ->post('name' ,true);
		$anchorname = $this ->input ->post('anchorname' ,true);
		$mobile = $this ->input ->post('mobile' ,true);
		$attr_id = $this ->input ->post('attr_id' ,true);
		$status = $this ->input ->post('status' ,true);
		if(empty($status)){
			$status=2;
		}
		$starttime = $this ->input ->post('starttime' ,true);
		$endtime = $this ->input ->post('endtime' ,true);		
		
		$param = array();
		$param['name'] = $name;
		$param['anchorname'] = $anchorname;
		$param['mobile'] = $mobile;
		$param['attr_id'] = $attr_id;
		$param['starttime'] = $starttime;
		$param['endtime'] = $endtime;		
		$param['status'] = $status;	
		
		$data = array();
		$this->load->library ( 'Page' ); // 加载分页类
		$config['base_url'] = '/admin/a/live/live_room_manage/oldroomlist/';
		$config ['pagesize'] = self::pagesize;
		$config ['page_now'] = $page;		
		$attr_data = array();	
		$sql_str = "select dict_id as categoryid,description as categoryname,showorder from live_dictionary where enable=0 and pid=".$this->dictionary['DICT_ROOM_ATTR']." ";
		$category_live_dictionary_data = $this->live_db->query($sql_str)->result_array();
		if(!empty($category_live_dictionary_data)){
			$valuea = array();
			foreach ($category_live_dictionary_data as $key => $value) {				
				$sortfiled[$key] = $value['showorder'];//根据showorder字段排序
				$valuea[$value['showorder']] = $value['showorder'];
				$attr_data[$value['categoryid']] = $value['categoryname'];
			}
		}
		$data["all_room_attr"]=$category_live_dictionary_data;
		$video_arr_t=$this->video_model->get_old_room_list($param,$page, self::pagesize,true);

		$config ['pagecount'] = $video_arr_t['total'];
		$video_arr = $video_arr_t['data'];
		if(count($video_arr)>0){
			foreach($video_arr as $k=> $v){
				/*if(empty($v['cover'])){
					$category_live_dictionary_data[$k]['cover'] = $live_anchor_ids_data[$v['anchor_id']]['video_pic'];					
				}
				if(strpos($category_live_dictionary_data[$k]['cover'],'http://')!==0){
					$category_live_dictionary_data[$k]['cover'] = trim(base_url(''),'/').$category_live_dictionary_data[$k]['cover'];							
				}*/
				if(isset($attr_data[$v['attr_id']])){
					$video_arr[$k]['attrname'] = $attr_data[$v['attr_id']];
				}else{
					$video_arr[$k]['attrname'] = '';
				}
								
			}
		}		
		$data['pageData']= $video_arr;
		$data['name']=$name;
		$data['anchorname']=$anchorname;
		$data['mobile']=$mobile;
		$data['attr_id']=$attr_id;
		$data['starttime'] = $starttime;
		$data['endtime'] = $endtime;
		$data['status'] = $status;		
		$this->page->initialize ( $config );			
		$this->load_view ( 'admin/a/live/oldroomlist',$data);
	}		

	/**
	 * @method 还没有同步的视频列表
	 */
	public function tongvideolist($page=1)
	{
		$roomid = $this ->input ->get_post('roomid' ,true);		
		$name = $this ->input ->post('name' ,true);
		$anchorname = $this ->input ->post('anchorname' ,true);
		$mobile = $this ->input ->post('mobile' ,true);
		$attr_id = $this ->input ->post('attr_id' ,true);
		$status = $this ->input ->post('status' ,true);
		if(empty($status)){
			$status=2;
		}
		$starttime = $this ->input ->post('starttime' ,true);
		$endtime = $this ->input ->post('endtime' ,true);		
		
		$param = array();
		$param['roomid'] = $roomid;		
		$param['name'] = $name;
		$param['anchorname'] = $anchorname;
		$param['mobile'] = $mobile;
		$param['attr_id'] = $attr_id;
		$param['starttime'] = $starttime;
		$param['endtime'] = $endtime;		
		$param['status'] = $status;	
		
		$data = array();
		$this->load->library ( 'Page' ); // 加载分页类
		$config['base_url'] = '/admin/a/live/live_room_manage/tongvideolist/';
		$config ['pagesize'] = self::pagesize;
		$config ['page_now'] = $page;		
		$attr_data = array();	
		$sql_str = "select dict_id as categoryid,description as categoryname,showorder from live_dictionary where enable=0 and pid=".$this->dictionary['DICT_ROOM_ATTR']." ";
		$category_live_dictionary_data = $this->live_db->query($sql_str)->result_array();
		if(!empty($category_live_dictionary_data)){
			$valuea = array();
			foreach ($category_live_dictionary_data as $key => $value) {				
				$sortfiled[$key] = $value['showorder'];//根据showorder字段排序
				$valuea[$value['showorder']] = $value['showorder'];
				$attr_data[$value['categoryid']] = $value['categoryname'];
			}
		}
		$data["all_room_attr"]=$category_live_dictionary_data;
		$video_arr_t=$this->video_model->get_tong_video_list($param,$page, self::pagesize,true);

		$config ['pagecount'] = $video_arr_t['total'];
		$video_arr = $video_arr_t['data'];
		if(count($video_arr)>0){
			foreach($video_arr as $k=> $v){
				/*if(empty($v['cover'])){
					$category_live_dictionary_data[$k]['cover'] = $live_anchor_ids_data[$v['anchor_id']]['video_pic'];					
				}
				if(strpos($category_live_dictionary_data[$k]['cover'],'http://')!==0){
					$category_live_dictionary_data[$k]['cover'] = trim(base_url(''),'/').$category_live_dictionary_data[$k]['cover'];							
				}*/
				if(isset($attr_data[$v['attr_id']])){
					$video_arr[$k]['attrname'] = $attr_data[$v['attr_id']];
				}else{
					$video_arr[$k]['attrname'] = '';
				}
								
			}
		}	

		//直播状态和发布的录播视频的未同步的总数
		$sql_str = "select count(room_id) as total from (select r.*, if(v.record_id>0,v.record_id,0) as record_id from live_room as r left join live_video v on( r.room_id=v.room_id ) where ((r.live_status=2 and r.room_name!='no') or r.live_status=1 )) as a where record_id=0";
		$shiping_tongji1 = $this->live_db->query($sql_str)->row_array();
		$data['shiping_tongji1'] = $shiping_tongji1['total'];	

		//正被占且还没开始直播的状态和发布的录播视频的未同步的总数
		$sql_str = "select count(room_id) as total from (select r.*, if(v.record_id>0,v.record_id,0) as record_id from live_room as r left join live_video v on( r.room_id=v.room_id ) where ((r.live_status=2 and r.room_name!='no') or r.live_status=3 )) as a where record_id=0";
		$shiping_tongji1 = $this->live_db->query($sql_str)->row_array();
		$data['shiping_tongji12'] = $shiping_tongji1['total'];	
		
		//已经同步过来的所有视频总数(=已经同步过来的所有录制短视频总数+已经同步过来的所有直播短视频总数)
		$sql_str = "select count(lv.id) as total from live_video as lv  where lv.record_id>0";
		$shiping_tongji2 = $this->live_db->query($sql_str)->row_array();
		$data['shiping_tongji2'] = $shiping_tongji2['total'];
		
		//已经同步过来的所有录制短视频总数
		$sql_str = "select count(lv.id) as total from live_video as lv  where lv.record_id>0 and lv.type=2";
		$shiping_tongji4 = $this->live_db->query($sql_str)->row_array();
		$data['shiping_tongji4'] = $shiping_tongji4['total'];
	
		//已经同步过来的所有直播短视频总数
		$sql_str = "select count(lv.id) as total from live_video as lv  where lv.record_id>0 and lv.type=1";
		$shiping_tongji11 = $this->live_db->query($sql_str)->row_array();
		$data['shiping_tongji11'] = $shiping_tongji11['total'];
	
		
		//已经同步过来的录制短视频且没有对视频进行发布总数(即没有填写视频内容的无效视频)
		$sql_str = "select count(lv.id) as total from live_video as lv  where lv.record_id>0 and lv.type=2 and lv.name='no'";
		$shiping_tongji3 = $this->live_db->query($sql_str)->row_array();		
		$data['shiping_tongji3'] = $shiping_tongji3['total'];
		

		//创建的所有房间总数[即在第三方创建成功的房间总数](=空闲状态房间总数+直播状态房间总数+正被占且还没开始直播的状态房间总数+录播状态的房间总数)
		$sql_str = "select count(room_id) as total from live_room   where 1 ";
		$shiping_tongji5 = $this->live_db->query($sql_str)->row_array();
		$data['shiping_tongji5'] = $shiping_tongji5['total'];
		
		//空闲状态房间总数
		$sql_str = "select count(room_id) as total from live_room   where live_status=0 ";
		$shiping_tongji6 = $this->live_db->query($sql_str)->row_array();		
		$data['shiping_tongji6'] = $shiping_tongji6['total'];
		
		//直播状态房间总数
		$sql_str = "select count(room_id) as total from live_room   where live_status=1 ";
		$shiping_tongji7 = $this->live_db->query($sql_str)->row_array();
		$data['shiping_tongji7'] = $shiping_tongji7['total'];
		
		//正被占且还没开始直播的状态房间总数
		$sql_str = "select count(room_id) as total from live_room   where live_status=3 ";
		$shiping_tongji8 = $this->live_db->query($sql_str)->row_array();
		$data['shiping_tongji8'] = $shiping_tongji8['total'];
		
		//录播状态的房间总数
		$sql_str = "select count(room_id) as total from live_room   where live_status=2 ";
		$shiping_tongji9 = $this->live_db->query($sql_str)->row_array();
		$data['shiping_tongji9'] = $shiping_tongji9['total'];
		
		//录播的房间且没有对视频进行发布总数(即没有填写视频内容的无效视频)
		$sql_str = "select count(room_id) as total from live_room   where live_status=2 and room_name='no' ";
		$shiping_tongji10 = $this->live_db->query($sql_str)->row_array();
		$data['shiping_tongji10'] = $shiping_tongji10['total'];
		
		
		$data['pageData']= $video_arr;
		$data['roomid']=$roomid;		
		$data['name']=$name;
		$data['anchorname']=$anchorname;
		$data['mobile']=$mobile;
		$data['attr_id']=$attr_id;
		$data['starttime'] = $starttime;
		$data['endtime'] = $endtime;
		$data['status'] = $status;
		$data['web_url'] = $this->web_url;		
		$this->page->initialize ( $config );			
		$this->load_view ( 'admin/a/live/tongvideolist',$data);
	}	
	
	
	
	
	function index(){
		$sql_str = "select dict_id as categoryid,description as categoryname,showorder from live_dictionary where enable=0 and pid=".$this->dictionary['DICT_ROOM_ATTR']." ";
		$category_live_dictionary_data = $this->live_db->query($sql_str)->result_array();
		if(!empty($category_live_dictionary_data)){
			$valuea = array();
			foreach ($category_live_dictionary_data as $key => $value) {				
				$sortfiled[$key] = $value['showorder'];//根据showorder字段排序
				$valuea[$value['showorder']] = $value['showorder'];
			}
			if(count($valuea)>1){
				array_multisort($sortfiled, $category_live_dictionary_data);				
			}
			foreach ($category_live_dictionary_data as $key => $value) {
				unset($category_live_dictionary_data[$key]['showorder']);
			}			
		}	
		$this->load_view ( 'admin/a/live/live_room_view',array("all_room_attr"=>$category_live_dictionary_data));
	}

	
	function getRoomInfo(){
		$room_id = $this->input->get("room_id",true);
		$iframeid = $this->input->get("iframeid",true);		
		self::getAccessToken();
		$param = array(
			"roomIds"=>$room_id,
			);
		$returnData = self::curlUtils($param,"GetRoomsLiveInfo");
		if($returnData['status'] == 200 && !empty($returnData['entities'])){
			if($returnData['entities'][0]['streamStatus']==1){
			/*	echo '<html>
				  <head>
				  <link href="http://vjs.zencdn.net/5.5.3/video-js.css" rel="stylesheet">
				  <script src="http://vjs.zencdn.net/ie8/1.1.1/videojs-ie8.min.js"></script>
				</head>
				<body>
				 <video id="my-video" class="video-js" controls preload="auto"  width="100%" height="100%" data-setup="{}">
					<source src="'.$returnData['entities'][0]['playRtmpUrls'][0].'" type="rtmp/flv">
					<!-- 如果上面的rtmp流无法播放，就播放hls流 -->
					<source src="'.$returnData['entities'][0]['playHlsUrls'][0].'" type="application/x-mpegURL">
				 </video>
				 <script src="http://vjs.zencdn.net/5.5.3/video.js"></script>
				</body>
				</html>';
				exit;
			*/	
echo '<object type="application/x-shockwave-flash" name="player" id="gotyeswf" data="http://live.gotlive.com.cn:80/share/client/swf/liveplayer.swf?_version=1.23" width="100%" height="100%"><param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always"><param name="wmode" value="transparent"><param name="flashvars" value="id=100&amp;src='.$returnData['entities'][0]['playRtmpUrls'][0].'&amp;autoPlay=1&amp;showLoading=1"></object>';				
exit;
//$str = '<object type="application/x-shockwave-flash" name="player" id="gotyeswf" data="http://live.gotlive.com.cn:80/share/client/swf/liveplayer.swf?_version=1.23" width="100%" height="100%"><param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always"><param name="wmode" value="transparent"><param name="flashvars" value="id=100&amp;src='.$returnData['entities'][0]['playRtmpUrls'][0].'&amp;autoPlay=1&amp;showLoading=1"></object>';					
				//$str = '<video id="my-video" class="video-js" controls preload="auto" width="300" height="200" data-setup="{}"><source src="'.$returnData['entities'][0]['playRtmpUrls'][0].'" type="rtmp/flv"><source src="'.$returnData['entities'][0]['playHlsUrls'][0].'" type="application/x-mpegURL"></video>';
				echo "<script language='JavaScript'>
					parent.document.getElementById('".$iframeid."').innerHTML='".$str."';
	            </script>"	;				
			}else{
				echo '停止';exit;
				echo "<script language='JavaScript'>
					parent.document.getElementById('".$iframeid."').innerHTML='停止';
	            </script>"	;			
			}
			
		}else{
			echo '无';	
		}
		exit;
	}

	function lookRoomInfo(){
		$room_id = $this->input->get("room_id",true);		
		self::getAccessToken();
		$param = array(
			"roomId"=>$room_id,
			);
		$returnData = self::curlUtils($param,"GetClientUrls");
		if($returnData['status'] == 200 && !empty($returnData['entity']) ){
			header('Location: '.$returnData['entity']['educVisitorUrl']);			
		}else{
			echo '房间错误';	
		}
		exit;
	}
	
	function lockRoomInfo(){
		$room_id = $this->input->post("room_id",true);
		$live_room = $this->live_room->row(array("room_id"=>$room_id));
		if(empty($live_room)){
			$this->callback->set_code ( 100 ,"房间不存在");
			$this->callback->exit_json();
		}
		
		$room_data = array(
			"live_status"	=>3,
			"endtime"	=>time()
			);
		$status = $this->live_room->update($room_data,array("room_id"=>$room_id));		
		if($status){
			self::getAccessToken();
			$param = array(
				"roomId"=>$live_room['roomid'],
				);
			$returnData = self::curlUtils($param,"DelRoom");			
			$this->callback->set_code ( 2000 ,"操作成功");
			$this->callback->exit_json();
		}else{
			$this->callback->set_code ( 401 ,"操作失败");
			$this->callback->exit_json();
		}
		/*self::getAccessToken();
		$param = array(
			"roomId"=>$live_room['roomid'],
			);
		$returnData = self::curlUtils($param,"DelRoom");
		if($returnData['status'] == 200 ){//删除成功
						
		}else{
			echo '操作失败';	
		}*/
		exit;
	}	
	//app首页推荐
	function indexRoomInfo(){
		$room_id = $this->input->post("room_id",true);
		$live_room = $this->live_room->row(array("room_id"=>$room_id));
		if(empty($live_room)){
			$this->callback->set_code ( 100 ,"房间不存在");
			$this->callback->exit_json();
		}
		$room_data = array();
		if($live_room['status']==2){//取消推荐
			$room_data = array(
				"status"	=>1
				);			
		}else if($live_room['status']==1){//推荐
			$room_data = array(
				"status"	=>2
				);
				
		}
		$status= 0;
		if(!empty($room_data)){
			$status = $this->live_room->update($room_data,array("room_id"=>$room_id));
		}		
		if($status){		
			$this->callback->set_code ( 2000 ,"操作成功");
			$this->callback->exit_json();
		}else{
			$this->callback->set_code ( 401 ,"操作失败");
			$this->callback->exit_json();
		}
		exit;
	}		
	


	/*function anchor_to_room(){
		$anchor_id = $this->input->post('anchor_id',true);
		$room_id = $this->input->post('room_id',true);
		$is_bind = $this->input->post('is_bind',true);
		$this->live_room->anchor_to_room($anchor_id, $room_id,$is_bind);
	}*/



	//选择主播分配专属房间的时候需要
	function getAnchors(){
		//$page_new = intval($this ->input ->post('page_new'));
		$page_new = 1;
		$data = $this->live_room->get_all_anchor($whereArr=array() ,$page_new ,9);
		$result['list'] = $data['list'];
		$result['page_string'] = $this ->getAjaxPage($page_new ,$data['count'] ,9);
		echo json_encode($result);
	}



	//创建房间
	function creatRoom(){
		$room_num = $this->input->post("room_number",true);
		if(!preg_match("/^\d{1,4}$/", $room_num)){
			$this->callback->set_code ( 101 ,"房间号不能超过四位数");
			$this->callback->exit_json();
		}
		$check_num_res = $this->live_room->row(array("room_number"=>$room_num));
		if(!empty($check_num_res)){
				$this->callback->set_code ( 102 ,"房间号已经存在");
				$this->callback->exit_json();
		}
		//AccessToken
		self::getAccessToken();
		$param = $this->getPostArr($_POST);
		$return_result = self::curlUtils($param,"CreateRoom");
		if($return_result['status']==200){
			$room_data = array(
				"anchor_password"	=>$return_result['entity']['anchorPwd'],
				"admin_password"	=>$return_result['entity']['assistPwd'],
				"audience_password"=>$return_result['entity']['userPwd'],
				"room_name"			=>$return_result['entity']['roomName'],
				"roomid"				=>$return_result['entity']['roomId'],
				"status"				=>1,
				"type"					=>$_POST['room_type'],
				"starttime"				=>$return_result['entity']['dateCreate'],
				"room_number"		=>$room_num
				);
			$room_id = $this->live_room->add_room($room_data);
			$anchor_id_str = trim($_POST['anchor_id'],',');
			if($_POST['room_type']==2 && !empty($anchor_id_str)){
				$this->live_room->anchor_to_room($anchor_id_str,$room_id,1);
			}
			$this->callback->set_code ( 2000 ,"添加成功");
			$this->callback->exit_json();
		}else{
			$this->callback->set_code ( 401 ,"添加失败");
			$this->callback->exit_json();
		}
	}



	//编辑房间
	function editRoom(){
		$room_id = $this->input->post("room_id",true);
		if(empty($room_id)){
			$this->callback->set_code ( 101 ,"房间id不存在");
			$this->callback->exit_json();
		}
		$room_data = array(
			"room_name"			=>$_POST['roomName'],
			"sort"					=>$_POST['roomSort'],
			"pic"					=>$_POST['pic'],
			"peoples"					=>$_POST['peoples'],			
			);
		$status = $this->live_room->update($room_data,array("room_id"=>$_POST['room_id']));
		if($status){
			$this->callback->set_code ( 2000 ,"修改成功");
			$this->callback->exit_json();
		}else{
			$this->callback->set_code ( 402 ,"修改失败");
			$this->callback->exit_json();
		}
	}


	//删除房间
	function deleteRoom(){
		$room_id = $this->input->post("room_id",true);
		$status = $this->live_room->update(array("status"=>0),array("room_id"=>$room_id));
		if($status){
			$this->callback->set_code ( 200 ,"删除成功");
			$this->callback->exit_json();
		}else{
			$this->callback->set_code ( 405 ,"删除失败");
			$this->callback->exit_json();
		}

	}


	//异步显示后台数据列表
	function ajaxRoomList(){
		$attr_id = intval($this ->input ->post('attrid'));
		$status = intval($this ->input ->post('status'));		
		$where = array();
		if(!empty($attr_id)){
			$where['attr_id='] = $attr_id;
		}
		if(!empty($status)){
			$where['status='] = $status;
		}		
		$data=$this->live_room->getRooms($where);
		echo json_encode($data);
	}


		//获取某条数据
	public function getOneData () {
		$room_id = intval($this ->input ->post('room_id'));
		//$whereArr=array('roomid'=>$id);
		$data=$this->live_room->get_edit_data($room_id);
		if (empty($data)) {
			echo false;
			exit;
		} else {
			//$data = $data['data'][0];
			echo json_encode($data);
		}
	}

	//在编辑和新建房间的时候组装参数返回
	function getPostArr($post_data){
		list($tmp1, $tmp2) = explode(' ', microtime());
		$msec =  (float)sprintf('%.0f', (floatval($tmp1))* 10000);
		$third_room_id = mt_rand(1,10000).$msec;//不重复的随机数
		if($post_data['roomId']!=""){
				$postArr = array(
					"roomId" 	   =>$post_data['roomId'],
					"roomName"=>$post_data['roomName'],//主播室名称
  					"anchorPwd"=>$post_data['anchorPwd'],//主播登录密码
  					"assistPwd"=>$post_data['assistPwd'],//助理登录密码
  					"userPwd"=>$post_data['userPwd'],//用户登录密码
  					"startPlayTime"=>strtotime(date("Y-m-d H:i:s")), //开播时间,只作显示使用
 					//"stopPlayTime"=>strtotime(date("Y-m-d H:i:s")),//结束时间,只作显示使用
  					"anchorDesc"=> "",//$post_data['anchorDesc'],//主播描述
  					"contentDesc"=> ""//$post_data['contentDesc'],//内容描述
  					//"thirdRoomId"=>$third_room_id, //三方唯一roomId,此id不能重复使用到多个room中
  					//"isImRoom"=> 0//三方roomId是否为亲加IM系统中的聊天室
				);
			}else{
				$postArr = array(
					"roomName"=>$post_data['roomName'],//主播室名称
  					"anchorPwd"=>$post_data['anchorPwd'],//主播登录密码
  					"assistPwd"=>$post_data['assistPwd'],//助理登录密码
  					"userPwd"=>$post_data['userPwd'],//用户登录密码
  					"startPlayTime"=>strtotime(date("Y-m-d H:i:s")), //开播时间,只作显示使用
 					"stopPlayTime"=>strtotime(date("Y-m-d H:i:s")),//结束时间,只作显示使用
  					"anchorDesc"=> "anchorDesc",//$post_data['anchorDesc'],//主播描述
  					"contentDesc"=> "contentDesc",//$post_data['contentDesc'],//内容描述
  					"thirdRoomId"=>$third_room_id, //三方唯一roomId,此id不能重复使用到多个room中
  					"isImRoom"=> 0//三方roomId是否为亲加IM系统中的聊天室
				);
			}
		return $postArr;
	}


	//获取验证码
	public static function getAccessToken(){
		$param = array("password"=>self::$password,"scope"=>"app","username"=>self::$username);
		$return_result = self::curlUtils($param,"AccessToken");
		self::$http_header[] = 'Authorization: '.$return_result['accessToken'];
	}

	//Curl工具方法
	public static function curlUtils($param=array(), $accessMethod=""){
		$param = http_build_query($param);
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, self::$url.$accessMethod);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt ($ch, CURLOPT_HTTPHEADER, self::$http_header);
		curl_setopt ($ch, CURLOPT_HEADER, 0);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $param);
		$return_result = json_decode(curl_exec($ch),true);
		curl_close($ch);
		return $return_result;
	}
}
