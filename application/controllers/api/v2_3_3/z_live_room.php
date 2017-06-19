<?php
/**
 *   @name:APP接口 => 直播房间
 * 	@author: 汪晓烽
 *   @time: 2016.05.25
 *
 *	 @abstract:
 *
 *      1、	 __outmsg()、__data()是输出格式化数据模式，
 *      	 __null()是输出空，
 *      	 __errormsg()是输出错误模式
 *
 *      2、数据传递方式： POST
 *
 *      3、返回结果状态码:  2000是成功，4001是空null，-3是错误信息
 */

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

//继承APP_Controller类
class Z_live_room extends APP_Controller {

	private static $url = "https://livevip.com.cn/liveApi/";
	private static $username = "2853553772@qq.com";
	private static $password = "123456";
	private static $http_header = array("Accept:application/json");


	public function __construct() {
		parent::__construct ();
		$this ->load_model('admin/a/live_room_model' ,'api_room');
	}

	/**
	 * @method 分配房间给主播
	 * @author 汪晓烽
	 *
	 * 1.判断是否是主播(如果不是主播就跳转到申请成为主播页面.如果是主播就在继续往下走)
	 * 2.根据步骤1返回的数据判断是否有专属房间
	 * 3.如果没有专属房间就选一个: 公共的并且未被占用的房间给主播
	 * 4.如果有专属房间: 首先判断这个房间是否被占用,如果被占用就走步骤3, 如果没被占用就直接把这个房间信息返回给主播
	 */
	public function assign_room(){
		$user_id = $this->input->post("user_id",true);
		$user_type = $this->input->post("user_type",true);
		$anchor = $this->api_room->get_anchor($user_id,$user_type);

		/**
		 *
		 *分配房间之后初始化主播和房间的一些状态
		 */
		//生成唯一的标识符,在每次分配房间的时候
		list($tmp1, $tmp2) = explode(' ', microtime());
		$msec =  (float)sprintf('%.0f', (floatval($tmp1) + floatval($tmp2)) * 10000);
		$room_code = $msec.mt_rand(1,10000).'A'.$anchor['anchor_id'];

		$anchor_data = array("live_status"=>0);
		$room_data = array( /*"live_status"=>1,*/"anchor_id"=>$anchor['anchor_id'],"peoples" =>0,"umoney" =>0,"room_code"=>$room_code);
		/////////////////////////////////////////////
		if($anchor['is_anchor']==1){
			//判断该主播是否有正在直播状态的房间(异常退出状态下重新申请房间)
			$room = $this->api_room->get_room(array(/*"live_status="=>1,*/"anchor_id="=>$anchor['anchor_id']));
			if(!empty($room)){
				$this->api_room->update_live($anchor['anchor_id'],$anchor_data,$room['room_id'],$room_data );
				$room['room_code'] = $room_code;
				$room['nickname'] = $anchor['name'];
				$result = array("code"=>200,"res"=>$room);
			}else{
			//如果有就优先把这个房间给到该主播,没有就走普通的分配流程
			if($anchor['room_id']!=0){
				//有专属房间
				$room = $this->api_room->get_room(array("room_id="=>$anchor['room_id']));
				if($room['live_status']!=1){
					$this->api_room->update_live($anchor['anchor_id'],$anchor_data,$room['room_id'],$room_data );
					//该房间如果没被占用,正常分配完成
					$room['room_code'] = $room_code;
					$room['nickname'] = $anchor['name'];
					$result = array("code"=>200,"res"=>$room);
				}else{
					//已经被占用,就从普通的选个房间出来
					$room = $this->api_room->get_room(array("live_status="=>0,"type="=>1));
					if(!empty($room)){
						$this->api_room->update_live($anchor['anchor_id'],$anchor_data,$room['room_id'],$room_data );
						$room['room_code'] = $room_code;
						$room['nickname'] = $anchor['name'];
						$result = array("code"=>200,"res"=>$room);
					}else{
						$result = array("code"=>203,"res"=>"已经没有空闲房间");
					}
				}
			}else{
				//没有专属房间
				$room = $this->api_room->get_room(array("live_status="=>0,"type="=>1));
				if(!empty($room)){
					$this->api_room->update_live($anchor['anchor_id'],$anchor_data,$room['room_id'],$room_data);
					$room['room_code'] = $room_code;
					$room['nickname'] = $anchor['name'];
					$result = array("code"=>200,"res"=>$room);
				}else{
					$result = array("code"=>207,"res"=>"已经没有空闲房间");
				}
			}
		  }
		}else{

			$result = array("code"=>201,"res"=>"请申请主播");
		}
			$this->__outmsg($result);
	}

	//真正开始直播的时候需要修改房间状态
	function start_live(){
		$anchor_id = $this->input->post("anchor_id",true);
		$room_id = $this->input->post("room_id",true);
		//$this->api_room->start_live($anchor_id,$room_id);
		$anchor_data = array("live_status"=>1);
		$room_data = array( "live_status"=>1);
		$this->api_room->update_live($anchor_id,$anchor_data,$room_id,$room_data );
		$result = array("code"=>200,"res"=>"开始直播");
	}


	/**
	 * [releaseRoom description]
	 * @return [type] [description]
	 * 退出房间
	 *
	 */
	public function releaseRoom(){
		$anchor_id 	= $this->input->post("anchor_id",true);
		   $room_id 	= $this->input->post("room_id",true);
		$startTime 	= $this->input->post("startTime",true);
		$endTime 		= $this->input->post("endTime",true);
		$have_video 	= $this->input->post("have_video",true);
		$video_id 		= $this->input->post("video_id",true);
		/**
		 *退出直播房间的状态要还原成未被占用,主播的播放状态也要还原成未直播
		 */
		$anchor_data = array( "live_status"=>0 ); //关闭主播播放状态
		$room_data = array( "live_status"=>0 );//关闭房间播放状态
		$this->api_room->update_live($anchor_id,$anchor_data,$room_id,$room_data);
		////////////////////////////////////////////////////////////////////////////////////

		if($have_video){
			//如果视频是保存成功的就找到这条视频记录
			$room = $this->api_room->get_room(array("room_id="=>$room_id));
			$video_record = self::get_new_video($room_id);
			$one 		= strtotime($startTime);//开始时间 时间戳
			$tow 		= strtotime($endTime);//结束时间 时间戳
			$cle 		= $tow - $one; //得出时间戳差值
			$minutes 	= floor(($cle%(3600*24))%3600/60);  //视频播放的时间长度(分钟)
			$video_data = array(
					"starttime"		=>$startTime,
					"endtime"		=>$endTime,
					"record_id"	=>$video_record['recordingId'],
					"room_code"	=>$room['room_code'],
					"time"			=>$minutes,
					"video"			=>$video_record['downUrl']
				);

		}else{
			//如果视频没有保存成功
			//如果视频是保存成功的就找到这条视频记录
			$room = $this->api_room->get_room(array("room_id="=>$room_id));
			//$video_record = self::get_new_video($room_id);
			$one 		= strtotime($startTime);//开始时间 时间戳
			$tow 		= strtotime($endTime);//结束时间 时间戳
			$cle 		= $tow - $one; //得出时间戳差值
			$minutes 	= floor(($cle%(3600*24))%3600/60);  //视频播放的时间长度(分钟)
			$video_data = array(
					"starttime"		=>$startTime,
					"endtime"		=>$endTime,
					//"record_id"	=>"",
					"room_code"	=>$room['room_code'],
					"time"			=>$minutes
					//"video"			=>""
				);
		}
		$this->api_room->update_video_data($video_id, $video_data);
		$result = array("code"=>200,"res"=>"退出直播成功");
		$this->__outmsg($ressult);
	}




	//在开启直播之前设置一下视频的相关信息; 比如视频封面,视频名称之类的
	function set_video_info(){
		$anchor_id 	= $this->input->post("anchor_id",true);
		   $room_id 	= $this->input->post("room_id",true);
		$video_pic 	= $this->up_pics('video_pic');
		$video_name 	= $this->input->post("video_name",true);
		$video_type 	= $this->input->post("video_type",true);
		$data_arr = array(
				"anchor_id"	=>$anchor_id,
				"room_id"	 	=>$room_id,
				"pic"			=>$video_pic,
				"name" 		=> $video_name,
				"attr_id"	=>$video_type
			);
		$insert_id = $this->api_room->insert_video_data($data_arr);
		if($insert_id){
			$result = array("code"=>200,"res"=>$insert_id);
		}else{
			$result = array("code"=>201,"res"=>"更新失败");
		}
		$this->__outmsg($result);
	}

	//获取设置好了以后的房间信息
	function get_video_info(){
		$this->load->helper ( 'url' );
		$video_id = $this->input->post("video_id",true);
		$video_info = $this->api_room->get_video_data($video_id);
		if(!empty($video_info)){
			//$video_info['pic'] = site_url($video_info['pic']);
			$result = array("code"=>200,"res"=>$video_info);
		}else{
			$result = array("code"=>201,"res"=>"没有视频信息");
		}
		$this->__outmsg($result);
	}

	//观众进入房间观看直播的时候
	function visitor_in_room(){
		$room_id = $this->input->post("room_id",true);
		$status = $this->api_room->update_peoples($room_id);
		if($status){
			$result = array("code"=>200,"res"=>"进入成功");
		}else{
			$result = array("code"=>201,"res"=>"进入失败");
		}
		$this->__outmsg($ressult);
	}

	//观众退出房间观看的时候
	function visitor_out_room(){
		$room_id = $this->input->post("room_id",true);
		$status = $this->api_room->update_peoples($room_id,'out');
		if($status){
			$result = array("code"=>200,"res"=>"退出成功");
		}else{
			$result = array("code"=>201,"res"=>"退出失败");
		}
		$this->__outmsg($ressult);
	}


	//主播设置视频信息的时候回去直播字典里的属性
	function get_live_dict(){
		$res = $this->api_room->get_live_dict(1);
		$this->__outmsg($res);
	}


	//获取刚刚保存的视频数据
	public static function get_new_video($room_id=""){
		self::getAccessToken();
		$param = array(
			"queryRoomId"=>$room_id,
			"index"			=>0,
			"count"			=>""
			);
		$return_result = self::curlUtils($param,"GetRecordings");
		$recordRes 	= self::result_sort($return_result['entities'],"recordingId");
		return array_shift($recordRes);
	}




	//对某一房间下的视频按照recordId排序
	public static function result_sort($arrays,$sort_key,$sort_order=SORT_DESC,$sort_type=SORT_NUMERIC ){
        	if(is_array($arrays)){
            	foreach ($arrays as $array){
                		if(is_array($array)){
                   		 $key_arrays[] = $array[$sort_key];
               		 }else{
                    		return false;
                		}
           		 }
        }else{
            return false;
        }
        array_multisort($key_arrays,$sort_order,$sort_type,$arrays);
        return $arrays;
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

	function up_pics($myfile="userfile"){
		$this->load->helper ( 'url' );
		$config['upload_path'] = './file/upload/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '40000';
		$file_name = 'video_'.date('Y_m_d', time()).'_'.sprintf('%02d', rand(0,99));
		$config['file_name'] = $file_name;
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload($myfile)){
			return false;
		}else{
			$file_info = array('upload_data' => $this->upload->data());
			$url =  '/file/upload/' .$file_info ['upload_data'] ['file_name'];
			return $url;
		}
	}
}

/* End of file webservices.php */
/* Location: ./application/controllers/webservices.php */