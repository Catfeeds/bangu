<?php
/**
 *   @name:APP接口基类
 * 	 @author: 温文斌
 *   @time: 2016.03.28
 *   
 *	 @abstract:
 *
 *
 *      1、	 __outmsg()、__data()是输出格式化数据模式，
 *      	 __null()是输出空数据，
 *      	 __errormsg()是输出错误
 *        
 *      3、数据传递方式： POST
 * 		
 *      4、返回结果状态码:  2000是成功，4001是空null，-3是错误信息
 */


if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

//继承MY_Controller类
class APP_Controller extends MY_Controller {
	public function __construct() {
		parent::__construct ();
		date_default_timezone_set ( 'Asia/Shanghai' );
		header( "content-type:text/html;charset=utf-8" );
		
		$this->db = $this->load->database ( "default", TRUE );
		$this->load->helper ( "string" );
		$this->config->load('integral'); //加载积分的配置
		header ( 'Content-type: application/json;charset=utf-8' );  //文档为json格式
		// 允许ajax POST跨域访问
		header('Access-Control-Allow-Origin:*');
		header('Access-Control-Allow-Methods:POST');
		header('Access-Control-Allow-Headers:x-requested-with,content-type');
	}
	
	/**
	 * @name：公共接口：发消息到邮箱
	 * @author: 温文斌
	 * @param: 
	 * @return:
	 *
	 */
	
	public function sendEmailCode() 
	{
		//$email = $this->input->post ( 'email', true ); // 手机号
		//$type = $this->input->post ( 'type', true ); // 用于区分发送哪种短信
		$callback = empty($_REQUEST["callback"]) ? '' : $_REQUEST['callback'];
		$email =isset($_REQUEST['email'])?$_REQUEST['email']:'';
		$type = isset($_REQUEST['type'])?$_REQUEST['type']:'';
		
		$this->load->library ( 'session', true );
		$time = time ();
		// 判断是否一分钟内已发送过
		$email_code = $this->session->userdata ( 'email_code' );
		if (! empty ( $email_code )) {
			$endtime = $time - $email_code ['time'];
			if ($endtime < 60) {
				$this->__wapmsg( "请您一分钟后再获取验证码",$callback);
			}
		}
		$this->load->helper ( 'regexp' );
		if (! regexp ( 'email', $email )) {
			$this->__wapmsg ( "请输入正确的邮箱号",$callback );
		}
		// 生成验证码
		$code = mt_rand ( 1000, 9999 );
		$this->load->model ( 'app/u_sms_template_model', 'sms_model' );
		switch ($type) {
			case 1 : // 管家注册
			        // 判断手机号是否存在
				$this->load->model ( "app/u_expert_model", 'expert_model' );
				$sql = "select mobile,id,status from u_expert where (email='{$email}' or email='{$email}') and status!=3 order by id desc";
				$expertData = $this->db->query ( $sql )->result_array ();
				if (! empty ( $expertData )) {
					switch ($expertData [0] ['status']) {
						case 1 :
							$this->__wapmsg ( "该邮箱正在审核中，请耐心等待！" ,$callback);
							break;
						case 2 :
							$this->__wapmsg ( "该邮箱邮箱已存在，请不要重复注册" ,$callback);
							break;
						/*case - 1 :
							$this->__errormsg ( "该邮箱已被平台终止，请联系客服" );
							break;*/
						default :
							$this->__wapmsg ( "邮箱已存在" ,$callback);
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
							$this->__wapmsg ( "此邮箱正在审核中，请耐心等待" ,$callback);
							break;
						case 2 :
							$this->__wapmsg ( "邮箱已存在" ,$callback);
							break;
						case - 1 :
							$this->__wapmsg ( "您的邮箱已被平台终止，请联系客服",$callback );
							break;
						default :
							$this->__wapmsg ( "邮箱已存在" ,$callback);
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
				$this->__wapmsg ( "请确认发送类型",$callback );
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
		
		//接口输出
		if(empty($callback))
			echo json_encode ( array ('code' => 2000,'msg' => '发送成功','status'=>$status,'result' => md5 ( $code )) ); // 返回加密的验证码
		else 
		    echo $callback."(".json_encode ( array ('code' => 2000,'msg' => '发送成功','status'=>$status,'result' => md5 ( $code )) ).")"; // 返回加密的验证码
		
	}
	
	/**
	 * @name：公共接口：发消息到手机短信
	 * @author: 温文斌
	 * @param: 
	 * @return:
	 *
	 */
	
	public function send_mobile() {
		//$mobile = $this->input->post ( 'mobile', true );
		//$type = intval ( $this->input->post ( 'type', true ) ); // 短信模板标识码
		//$usertype = intval ( $this->input->post ( 'msgtype', true ) ); // 短信模板标识码
		
		$callback = empty($_REQUEST["callback"]) ? '' : $_REQUEST['callback'];
		$mobile =isset($_REQUEST['mobile'])?$_REQUEST['mobile']:'';
		$type = isset($_REQUEST['type'])?$_REQUEST['type']:'';
		$usertype = isset($_REQUEST['msgtype'])?$_REQUEST['msgtype']:'';
		
		$this->load->library ( 'session', true );
		$code_time = $this->session->userdata ( 'time' ); // 发送时间
		
		try {
			$time = time ();
			// 判断是否一分钟内已发送过
			if (! empty ( $code_time )) {
				$endtime = $time - $code_time;
				if ($endtime < 60) {
					$this->__wapmsg( '60秒之后再发送',$callback);
				}
			}
			// 验证手机是否为空
			if (empty ( $mobile )) {
				$this->__wapmsg ( '手机号码不能为空' ,$callback);
			}
			// 验证手机号
			$this->load->helper ( 'regexp' );
			if (! regexp ( 'mobile', $mobile )) {
				$this->__wapmsg ( '手机号码输入有误',$callback );
			}
			switch ($type) {
				case 1 : // 会员注册
					$msgtype = 'reg_msgcode';
					// 验证手机号是否存在
					if ($usertype == '1') {
						$this->load->model ( 'app/u_expert_model', 'expert_model' );
						$result_user = $this->expert_model->row ( array (
								'mobile' => $mobile 
						) );        
                                                // 魏勇编辑
//                                                $result_user = $this->expert_model->getMobileRegistered($mobile);
						if (! empty ( $result_user )) {	$this->__wapmsg ( '管家手机号已存在' ,$callback);			}
					} else {
						$this->load->model ( 'app/u_member_model', 'member_model' );
						$member = $this->member_model->row ( array (
								'mobile' => $mobile 
						) );
						if (! empty ( $member )) 					{		$this->__wapmsg ( '手机号已被注册' ,$callback);		}
					}

					break;
				case 2 : // 找回密码
					$msgtype = 'reg_findpwd';
					// 验证管家手机号是否存在
					if ($usertype == '2') {
						$this->load->model ( 'app/u_expert_model', 'expert_model' );
						$result_user = $this->expert_model->row ( array (
								'mobile' => $mobile 
						) );
						if (empty ( $result_user )) 				{		$this->__wapmsg ( '管家手机号未注册',$callback );		}
						// 验证用户手机号是否存在
					} elseif ($usertype == '1') {
						$this->load->model ( 'app/u_member_model', 'member_model' );
						$member = $this->member_model->row ( array (
								'mobile' => $mobile 
						) );
						if (empty ( $member )) 					{		$this->__wapmsg ( '用户手机号未注册',$callback );		}
					}

					break;
				case 3 : // 下单
					$msgtype = 'submit_order_msg';
					break;
				case 4 : // 管家注册
					$msgtype = 'expert_register_msg';
					// 验证手机号状态
					if ($usertype == '1') {
						$result_user = $this->db->query ( "select  status  from u_expert  where (mobile={$mobile} or login_name={$mobile}) and (status in(0,1,2,5) or union_status=1) ORDER BY `id` desc " )->row_array ();
						if (! empty ( $result_user['status'] )) {
							if ($result_user['status'] == 1||$result_user['status'] == 5) {
								$this->__wapmsg ( '该手机号正在审核中，请耐心等待！' ,$callback);
							} else{
								$this->__wapmsg ( '手机号已存在！',$callback );
							} 
						} else {
							true;
						}
					}
					break;
				case 5 : // 定制 下单
					$msgtype = 'custom_msgcode';
					break;
				case 6 : // 管家修改手机号
						$msgtype = 'defalut';
						// 验证手机号状态
						if ($usertype == '1') {
						$result_user = $this->db->query ( "select  status  from u_expert  where (mobile={$mobile} or login_name={$mobile}) and (status in(0,1,2,5) or union_status=1) ORDER BY `id` desc " )->row_array ();
						if (! empty ( $result_user['status'] )) {
							if ($result_user['status'] == 1||$result_user['status'] == 5) {
								$this->__wapmsg ( '该手机号正在审核中，请耐心等待！' ,$callback);
							} else{
								$this->__wapmsg ( '手机号已存在！' ,$callback);
							}
						} else {
							true;
						}
					}
					break;
				  case 7 : //会员找回交易密码
				  	$msgtype='reg_transaction_pwd';
				  	if ($usertype == '1') { //用户
				  		$this->load->model ( 'app/u_member_model', 'member_model' );
				  		$member = $this->member_model->row ( array (
				  				'mobile' => $mobile
				  		) );
				  		if (empty ( $member )) 					{		$this->__wapmsg ( '用户手机号未注册',$callback );		}
				  	}
				  	break;
				default :
					$this->__wapmsg ( 'is null',$callback );
					break;
			}
			// 生成验证码
			$code = mt_rand ( 1000, 9999 );
			// 读取短信模板
			$this->load->model ( 'app/u_sms_template_model', 'sms_model' );
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
		$output = json_encode ( array (
				"msg" => $this->result_msg,
				"code" => $this->result_code,
				"data" => $this->result_data,
				'result' => md5 ( $code ), // 返回加密的验证码
				"total" => 0 
		) );
		
		if(empty($callback))
			echo $output;
		else 
			echo $callback."(".$output.")";
		exit ();
	}
	/**
	 * @name：公共接口：城市三级联动（国家、省、市） u_area表
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	public function area_list_three() {
		$cityid=$this->input->post("cityid",true); //用于周边城市
		//$cityid="235";
		
		$areaData = $this->db->query ( "select id,name,pid,level from u_area where isopen=1 and level<4  order by level asc,displayorder asc " )->result_array ();
		$areaArr = array ();  //格式1
		$areaArr2 = array ();  //格式2
		foreach ( $areaData as $key => $val ) {
			switch ($val ['level']) {
				case 1 :
						$areaArr ['country'][$val ['id']] = $val;
						$areaArr2[$val ['id']] = $val;
					break;
				case 2 :
					if (array_key_exists ( $val ['pid'], $areaArr ['country'] )) {
						$areaArr ['country'][$val ['pid']]['province'] [$val ['id']] = $val;
						$areaArr2[$val ['pid']]['province'] [] = $val;
					}
					break;
				case 3 :
					foreach ($areaArr ['country'] as $k=>$v)
					{
					  if(array_key_exists($val ['pid'],$v['province']))
					  	$areaArr ['country'] [$k] ['province'][$val ['pid']]['city'][]=$val;
					}
					
					//格式2
					foreach ($areaArr2 as $k=>$v)
					{
						foreach ($v['province'] as $a=>$b)
						{
							if($val ['pid']==$b['id'])
							{
								$areaArr2 [$k] ['province'][$a]['city'][]=$val;
							}
						}
							
					}
					
					break;
			}
		}
		
		
		//周边
		$zb=array();
		if($cityid)
		$zb = $this->db->query ( "select id,name,pid,level from u_area where pid='{$cityid}' and isopen=1")->result_array ();
		$areaArr2['zb'] = array(
				'id'=>'3',
				'name'=>'周边游',
				'level'=>'1',
				'province'=>array(
						'0'=>array(
								'id'=>'0',
								'name'=>'周边游',
								'level'=>'2',
								'city'=>$zb
						)
				)
		);  //$areaArr['country']['3']=
		
		$areaArr2['cj']=$areaArr2[1];
		$areaArr2['jn']=$areaArr2[2];
		unset($areaArr2[1]);
		unset($areaArr2[2]);
		
		$this->__outmsg ( $areaArr );
	}
	/**
	 * @name：新版接口：上传图片
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	function api_upload() 
	{
		//$filename = $this->input->post ( 'filename', true );  //<input type="file" name="file" /> 的name属性
		
		$filename="upload_image"; //写死
		
	    $typeArr = array("jpg", "jpeg","png", "gif");//允许上传文件格式
		$time = date('Ymd',time());
		
		//图片上传路径
		$path ="./file/app/".$time."/"; //上传路径  $path = "../bangu/file/app/";
        $return="/file/app/".$time."/"; //返回的路径
		if (!file_exists($path)) 
		{
			$status = mkdir($path ,0777 ,true);
			if ($status == false) 
				$this->__errormsg('图片上传失败');
		}
		
		//上传
		if (!empty($_FILES)) 
		{
			$name = $_FILES[$filename]['name'];
			$size = $_FILES[$filename]['size'];
			$name_tmp = $_FILES[$filename]['tmp_name'];
			
			if (empty($name)) 
				$this->__errormsg('您还未选择图片');
			$type = strtolower(substr(strrchr($name, '.'), 1)); //获取文件类型
			if (!in_array($type, $typeArr)) 
				$this->__errormsg('图片格式不对');
				
			$pic_name = time() . rand(10000, 99999) . "." . $type;//图片名称
			$pic_url = $path . $pic_name;//上传后图片路径+名称
			$return_url=$return.$pic_name;
			$domain_url=$this->__doImage($return_url);
			if (move_uploaded_file($name_tmp, $pic_url)) 
			{    //临时文件转移到目标文件夹
				echo json_encode(array("code"=>"2000","msg"=>"success","imgurl"=>$return_url,'domain_url'=>$domain_url));
					
			}
			else 
			{
				$this->__errormsg('上传有误，清检查服务器配置！');
				
			}
		}
		else
		{
			$this->__errormsg('请选择图片');
		}
	}
	/**
	 * @name：公共接口：上传图片
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	function upload_pic_test() {
		
		$page = $this->input->post ( 'page', true );
		if ($page == 1) 
		{
		    //管家上传头像
			$path = dirname(BASEPATH) . "/../bangu/file/c/img/";
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
				
		} 
		else if ($page == 2) 
		{ 
			//管家上传身份证
			$path = dirname(BASEPATH) . "/../bangu/file/c/img/";
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
				
		} 
		else if ($page == 3) 
		{
			//管家上传荣誉证书
			$path = dirname(BASEPATH) . "/../bangu/file/c/img/";
			$input_name = "certificatepic";
			$photo = $this->cfgm_upload_pimg ( $path, $input_name );
			$return_path="/file/c/img/";
			$kk = $return_path . $photo;
			echo json_encode ( array (
					'code' => 2000,
					'msg' => $kk
			) );
		} 
		else if ($page == 4) 
		{
			//直播上传图片
			$path = dirname(BASEPATH) . '/../bangu/file/live/img/';
			$input_name = "livepic";
			$photo = $this->cfgm_upload_pimg ( $path, $input_name );
			$return_path="/file/live/img/";
			$kk = $return_path . $photo;
			echo json_encode ( array (
					'code' => 2000,
					'msg' => $kk,
					'path'=>trim(base_url(''),'/').$kk,
			) );
		} 
		else if ($page == 5) 
		{
			//直播上传头像图片
			$path = dirname(BASEPATH) . '/../bangu/file/live/img/';
			$input_name = "live_icon_photo";
			$photo = $this->cfgm_upload_pimg ( $path, $input_name );
			$return_path="/file/live/img/";
			$kk = $return_path . $photo;
			echo json_encode ( array (
					'code' => 2000,
					'msg' => $kk,
					'path'=>trim(base_url(''),'/').$kk,					
			) );
		} 
		else if ($page == 6) 
		{
			//直播上传短视频
			//$path = "../bangu/file/live/video/";
            $path = dirname(BASEPATH) . '/../bangu/file/live/video/';
			$input_name = "live_video";
			$photo = $this->cfgm_upload_pimg ( $path, $input_name );
			$return_path="/file/live/video/";
			$kk = $return_path . $photo;
			//$locale_info = localeconv();		
			//setlocale(LC_CTYPE, "UTF8", "en_US.UTF-8");
			//在2秒处截取图片
			//exec ("ffmpeg -i  ".escapeshellarg($path.$photo)."  -y -f image2 -ss 2  ".$path.$photo.'.jpg'."");
			//旋转视频裁剪
			exec ("ffmpeg -i ".escapeshellarg($path.$photo)."  -f image2 -ss 2 -vf 'transpose=1' -vframes 1 ".$path.$photo.'.jpg'."");	
			//setlocale(LC_ALL,NULL);	

			//裁剪图片开始
			$src_img = $path.$photo.'.jpg';
			$dst_w = 0;
			$dst_h = 0;
			//宽高比 35:22
			list($src_w,$src_h)=getimagesize($src_img);  // 获取原图尺寸
			if(($src_w/$src_h) > (35/22)){//图片比例大于35/22
				$dst_w = intval((($src_h * 35) /22));
				$dst_h = intval($src_h);	
			}else{
				$dst_w = intval($src_w);
				$dst_h = intval((($src_w * 22) /35));	
			}
			$dst_scale = $dst_h/$dst_w; //目标图像长宽比
			$src_scale = $src_h/$src_w; // 原图长宽比
			if ($src_scale>=$dst_scale){  // 过高
				$w = intval($src_w);
				$h = intval($dst_scale*$w);
				$x = 0;
				$y = ($src_h - $h)/3;
			} else { // 过宽
				$h = intval($src_h);
				$w = intval($h/$dst_scale);
				$x = ($src_w - $w)/2;
				$y = 0;
			}
			// 剪裁
			$source=imagecreatefromjpeg($src_img);
			$croped=imagecreatetruecolor($w, $h);
			imagecopy($croped, $source, 0, 0, $x, $y, $src_w, $src_h);
			// 缩放
			$scale = $dst_w / $w;
			$target = imagecreatetruecolor($dst_w, $dst_h);
			$final_w = intval($w * $scale);
			$final_h = intval($h * $scale);
			imagecopyresampled($target, $croped, 0, 0, 0, 0, $final_w,$final_h, $w, $h);
			// 保存
			imagejpeg($target, $src_img);
			imagedestroy($target);
			//裁剪图片结束
			
			echo json_encode ( array (
					'code' => 2000,
					'msg' => $kk,
					'pic' =>$kk.'.jpg',
					'width'=>$src_h,
					'height'=>$src_w,
					'path'=>trim(base_url(''),'/').$kk,					
			) );				
		}else {
			echo json_encode ( array (
					'code' => 4000,
					'msg' => '  don`t this !'
			) );
		}
	}
	
	/**
	 * @name：公共函数：用户端 （验证token）
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	protected function check_token($token) {
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
			) , JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
			$jsoncallback = '';
			if(isset($_GET['jsoncallback']))$jsoncallback = $_GET['jsoncallback'];
			if(isset($_POST['jsoncallback']))$jsoncallback = $_POST['jsoncallback'];		
			if(!empty($jsoncallback)){//用于跨域
				echo $jsoncallback . "(".$this->resultJSON.")";
			}else{
				echo $this->resultJSON;
			}			
			exit ();
		}
	}
	
	/**
	 * @name：公共函数：管家端（验证token）
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	protected function expert_check_token($token) {
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
	 * @name：公共函数:获得app用户的id
	 * @author: 温文斌
	 * @param: $token；
	 * @return:  $mid:用户id
	 *
	 */
	protected function F_get_mid($token)
	{
		
		
		if($token)
		{
			$this->load->model ( 'app/u_access_token_model', 'at_model' );
			$row = $this->at_model->row( array ('access_token' => $token));
			if(empty($row))
				$m_id="0";
			else
				$m_id = $row['mid'];
			
		}
		else
		{
			$m_id="0";
		}
		return $m_id;
	}
	/**
	 * @name：公共函数:获得app管家的id
	 * @author: 温文斌
	 * @param: $token；
	 * @return:  $mid:用户id
	 *
	 */
	protected function F_get_eid($token)
	{
		if($token)
		{
			$this->load->model ( 'app/u_expert_access_token_model', 'u_at_model' );
			$row = $this->u_at_model->row( array ('access_token' => $token));
			if(empty($row))
				$e_id="0";
			else
				$e_id = $row['eid'];
			
		}
		else
		{
			$e_id="0";
		}
		return $e_id;
	}
	/**
	 * @name：公共函数:订单详情
	 * @author: 温文斌
	 * @param: number=凭证；orderid=订单ID
	 * @return:
	 *
	 */
	protected function order_detail($order_id) 
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
	 * @name：公共函数:管家详情
	 * @author: 温文斌
	 * @param: eid=管家id；
	 * @return:  sc_num收藏数（人气值）、prsise_num点赞数
	 *
	 */
        // 将e.m_bgpic改为e.big_photo as m_bgpic
	protected function F_expert_detail($eid)
	{
		$sql="select
		e.id,e.order_amount,e.people_count,e.nickname, e.small_photo,e.big_photo as m_bgpic,e.login_name,e.sex,e.mobile,
		CASE WHEN e.sex=0 THEN '女' WHEN e.sex=1 THEN '男' WHEN e.sex=-1 THEN '保密' END AS sex_name,
		e.realname,e.satisfaction_rate,e.total_score,e.attention_count,e.talk,e.praise_num,e.beizhu,e.type,e.school,e.profession,e.working,
		e.city as cityid,a.name as city, g.title as grade,e.idcardtype,e.idcard,e.idcardpic,e.idcardconpic,e.expert_dest as expert_dest_id,
		e.bankcard,e.bankname,e.cardholder,e.amount,e.branch,e.like_num,
		 
		(select GROUP_CONCAT(d.kindname SEPARATOR ' ') as expert_dest from u_destinations as d where FIND_IN_SET(d.id,e.expert_dest)) as expert_dest,
		(SELECT COUNT(*) FROM u_member_order AS mo WHERE mo.expert_id=e.id) AS volume,
		(SELECT COUNT(*) FROM u_expert_collect AS ec WHERE ec.expert_id=e.id) AS sc_num,
		(select GROUP_CONCAT(name SEPARATOR ' ') from u_area where FIND_IN_SET(id,e.visit_service) >0 )as likeplace
		from
		u_expert AS e
		left join u_area AS a on e.city=a.id
		left join u_expert_grade as g on g.id=e.grade
		where
		e.id={$eid}";
		$result=$this->db->query($sql)->row_array();
		if(empty($result)){
			return array();
		}
		//数据处理(大学、工作年限)
		//$beizhu_arr=explode(";",@$result['beizhu']);
		$result['school']=$result['school'];
		$result['workyear']=$result['working'];
		$result['zhuanye']=$result['profession'];
		$path = "https://" . $_SERVER ['HTTP_HOST'];	//添加域名
		$result['expert_domain']=$path;  //域名
		//国内国外
		if(@$result['type']=='1')
		{
			$result['type_name']="境内";
		}
		elseif(@$result['type']=='2')
		{
			$result['type_name']="境外";
		}
		
		return $result;
	}
	/**
	 * @name：公共函数:管家详情+个人主页
	 * @author: 温文斌
	 * @param: eid=管家id；
	 * @return:  sc_num收藏数（人气值）、prsise_num点赞数
	 *
	 */
	protected function F_expert_detail_more($e_id)
	{
		$result=$this->F_expert_detail($e_id);
		
		//个人主页开始
		$expert_more=$this->db->query("select hobby,pass_way,like_food from u_expert_more_about where expert_id={$e_id}")->row_array();
		$country=$this->db->query("select a.id,a.name from u_expert_more_about as em left join u_area as a on a.id=em.county  where expert_id={$e_id}")->row_array();
		$province=$this->db->query("select a.id,a.name from u_expert_more_about as em left join u_area as a on a.id=em.province where expert_id={$e_id}")->row_array();
		$city=$this->db->query("select a.id,a.name from u_expert_more_about as em left join u_area as a on a.id=em.city  where expert_id={$e_id}")->row_array();
		$blood=$this->db->query("select d.dict_id,d.description as name from u_expert_more_about as em left join u_dictionary as d on d.dict_id=em.blood  where expert_id={$e_id}")->row_array();
		$constellation=$this->db->query("select d.dict_id,d.description as name from u_expert_more_about as em left join u_dictionary as d on d.dict_id=em.constellation  where expert_id={$e_id}")->row_array();
		$decade=$this->db->query("select d.dict_id,d.description as name from u_expert_more_about as em left join u_dictionary as d on d.dict_id=em.decade  where expert_id={$e_id}")->row_array();
		
		$result['hometown']=array(
				'country'=>array('id'=>isset($country['id'])?$country['id']:'','name'=>isset($country['name'])?$country['name']:''),
				'province'=>array('id'=>isset($province['id'])?$province['id']:'','name'=>isset($province['name'])?$province['name']:''),
				'city'=>array('id'=>isset($city['id'])?$city['id']:'','name'=>isset($city['name'])?$city['name']:'')
		);
		
		$result['hobby']=isset($expert_more['hobby'])?$expert_more['hobby']:''; //爱好
		$result['pass_way']=isset($expert_more['pass_way'])?$expert_more['pass_way']:'';//去过的地方
		$result['like_food']=isset($expert_more['like_food'])?$expert_more['like_food']:''; //喜欢美食
		$result['blood']=array('id'=>isset($blood['dict_id'])?$blood['dict_id']:'','name'=>isset($blood['name'])?$blood['name']:'');
		$result['constellation']=array('id'=>isset($constellation['dict_id'])?$constellation['dict_id']:'','name'=>isset($constellation['name'])?$constellation['name']:''); //星座
		$result['decade']=array('id'=>isset($decade['dict_id'])?$decade['dict_id']:'','name'=>isset($decade['name'])?$decade['name']:''); //年代
		//我的标签
		$attr=$this->db->query("select d.dict_id,d.description as name from u_expert_attr as a left join u_dictionary as d on d.dict_id=a.attr_id where a.expert_id={$e_id}")->result_array();
		$attr_arr=array();
		foreach ($attr as $key=>$value)
		{
			$attr_arr[$key]=array('id'=>$value['dict_id'],'name'=>$value['name']);
		}
		$result['attr']=$attr_arr;
		//喜欢去哪儿 (境内、境外)
		$go_in=$this->db->query("select d.dict_id,d.description as name from u_expert_go as go left join u_dictionary as d on d.dict_id=go.dest_id left join u_dictionary as dd on dd.dict_id=d.pid where dd.dict_code='DICT_EXPERT_DEST_GN' and go.expert_id={$e_id}")->result_array();
		$go_out=$this->db->query("select d.dict_id,d.description as name from u_expert_go as go left join u_dictionary as d on d.dict_id=go.dest_id left join u_dictionary as dd on dd.dict_id=d.pid where dd.dict_code='DICT_EXPERT_DEST_JW' and go.expert_id={$e_id}")->result_array();
		
		$go_arr=array();
		foreach ($go_in as $key=>$value)
		{
			$go_arr[$key]=array('id'=>$value['dict_id'],'name'=>$value['name']);
		}
		$result['go']['in']=$go_arr;
		
		$go_arr=array();
		foreach ($go_out as $key=>$value)
		{
			$go_arr[$key]=array('id'=>$value['dict_id'],'name'=>$value['name']);
		}
		$result['go']['out']=$go_arr;
		//喜欢怎样玩
		$play=$this->db->query("select d.dict_id,d.description as name from u_expert_play as p left join u_dictionary as d on d.dict_id=p.way_id where p.expert_id={$e_id}")->result_array();
		$play_arr=array();
		foreach ($play as $key=>$value)
		{
			$play_arr[$key]=array('id'=>$value['dict_id'],'name'=>$value['name']);
		}
		$result['paly']=$play_arr;
		 
		//和谁玩
		$with=$this->db->query("select d.dict_id,d.description as name from u_expert_with as w left join u_dictionary as d on d.dict_id=w.crowd_id where w.expert_id={$e_id}")->result_array();
		$with_arr=array();
		foreach ($with as $key=>$value)
		{
			$with_arr[$key]=array('id'=>$value['dict_id'],'name'=>$value['name']);
		}
		$result['with']=$with_arr;
		//休闲方式
		$relax=$this->db->query("select d.dict_id,d.description as name from u_expert_relax as r left join u_dictionary as d on d.dict_id=r.relax_id where r.expert_id={$e_id}")->result_array();
		$relax_arr=array();
		foreach ($relax as $key=>$value)
		{
			$relax_arr[$key]=array('id'=>$value['dict_id'],'name'=>$value['name']);
		}
		$result['relax']=$relax_arr;
		return $result;
	}
	/**
	 * @name：公共函数:线路详情(一些常用字段)
	 * @author: 温文斌
	 * @param: id=线路id；
	 * @return:  
	 *
	 */
	protected function F_line_detail($id)
	{
		$sql="
				SELECT 
							a.id,a.linename,a.linetitle,a.lineprice,a.marketprice,a.saveprice,a.lineday,a.satisfyscore,a.bookcount,a.supplier_id,
							a.status,mainpic,a.all_score,a.comment_count,a.peoplecount,a.recommend_expert,a.overcity2,
							(select GROUP_CONCAT(kindname) from u_destinations where FIND_IN_SET(id,a.overcity2) >0 )as overcity_name,
							GROUP_CONCAT(u.cityname)AS startplace
							
				FROM
							u_line as a  
							left join u_line_startplace as ls on a.id=ls.line_id  
							LEFT JOIN u_startplace as u  on ls.startplace_id=u.id   		
				WHERE 
							a.id={$id}
		    ";
		$result=$this->db->query($sql)->row_array();
		//满意度4舍5入 ，echo round(0.455,2);
		$result['satisfyscore']=(round($result['satisfyscore'],2)*100).'%';
		return $result;
	}
	/**
	 * @name：公共函数:线路详情（线路的全部相关信息=基本信息+目的地列表+标签+套餐+行程安排+轮播图+交通+酒店+主题）
	 * @author: 温文斌
	 * @param: id=线路id；
	 * @return:
	 *
	 */
	protected function F_line_detail_more($lineId,$iscomment=0)
	{
		$sql="
			  SELECT
						a.*,(select GROUP_CONCAT(kindname) from u_destinations where FIND_IN_SET(id,a.overcity2) >0 )as overcity_name,
						GROUP_CONCAT(u.cityname)AS startplace
			  FROM
						u_line as a
						left join u_line_startplace as ls on a.id=ls.line_id
						LEFT JOIN u_startplace as u  on ls.startplace_id=u.id
			  WHERE
						a.id={$lineId}
		";
		$data['data']=$this->db->query($sql)->row_array(); //线路基本信息+目的地城市+出发城市
		//满意度4舍5入 ，echo round(0.455,2);
		$data['data']['satisfyscore']=(round($data['data']['satisfyscore'],2)*100).'%';
		
		$this->load->model ( 'app/u_line_apply_model', 'line_apply' );
		$this->load->model ( 'app/user_shop_model' );
		$this->load->model ( 'app/u_line_attr_model', 'lineattr_model' );
		$this->load->model ( 'app/u_destinations_model', 'destinations_model' );
		//目的地
		$data ['overcity_arr'] = array ();
		if (!empty($data ['data'] ['overcity2']))
			$data ['overcity_arr'] = $this->destinations_model->getDestinations ( explode ( ",", $data ['data'] ['overcity2'] ) );
	    //标签
		$data ['line_attr_arr'] = array ();
		if (!empty($data ['data'] ['linetype'])) {
			$data ['line_attr_arr'] = $this->lineattr_model->getLineattr ( explode ( ",", $data ['data'] ['linetype'] ) );
		}
		// 供应商信息
		$supplierData = $this->user_shop_model->get_user_shop_select ( 'u_supplier', array ('id' => $data ['data'] ['supplier_id']) );
		// 线路品牌、套餐
		$data ['data'] ['brand'] = isset($supplierData[0]['brand'])?$supplierData[0]['brand']:'';
		$data ['suits'] = $this->user_shop_model->getLineSuit ( $lineId );
		//线路轮播图
		$pics=$this->db->query("select a.filepath from u_line as l left join u_line_pic as p on l.id=p.line_id left join u_line_album as a on a.id=p.line_album_id where l.id='{$lineId}'")->result_array();
		$data ['data'] ['pics']=$pics;
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
		if($iscomment==0){
			//线路评论
			$data ['comment_list'] = $this->db->query ( "SELECT m.litpic, m.nickname, c.id as commentid,c.level, c.content,c.reply1,c.reply2,c.pictures, c.addtime, c.isanonymous,c.like_num, m.mobile FROM u_comment AS c	LEFT JOIN  u_member as m ON c.memberid=m.mid	WHERE c.line_id ='{$lineId}' order by c.addtime desc LIMIT 5" )->result_array ();
			foreach ($data ['comment_list'] as $n=>$m)
			{
				$pic_arr=explode(",", $m['pictures']);
				$pic_arr=$this->__doImage($pic_arr);
				$m['pictures']=$pic_arr;
				$data ['comment_list'][$n]=$m;
			}			
		}

		//线路体验分享
		$data['share_list']=$this->db->query("select tn.id,tn.title,tn.content,tn.cover_pic,tn.modtime,tn.line_id,um.nickname as nickname from travel_note as tn left join u_member as um on tn.userid=um.mid where tn.usertype='0' and tn.is_show='1' and tn.status='1' and tn.line_id='{$lineId}' order by tn.modtime desc limit 5")->result_array();
		// 线路图片
		//$data ['imgurl'] = $this->user_shop_model->select_imgdata ( $lineId );
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
		return $data;
	}
	
	/**
	* @name：公共函数：创建订单流水号
	* @author: 温文斌
	* @param:
	* @return:
	*
	*/
	
	protected function F_create_ordersn($ordersn)
	{
	$this->load->model ( 'app/u_member_order_model', 'order_model' );
	 $order = $this->order_model->row ( array (
	 'ordersn' => $ordersn
	) );
	if (! empty ( $order )) {
	return false;
		}
		return true;
	}
	/**
	 * @name：公共函数：订单状态
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	protected function F_order_status($status,$ispay)
	{
	     //支付状态
			if($status=="0")       $order_status="待留位";      
			elseif($status=="1")   $order_status="已留位";
			elseif($status=="4")   $order_status="已确认";
			elseif($status=="5")   $order_status="已出行";
			elseif($status=="6")   $order_status="已点评";
			elseif($status=="7")   $order_status="已投诉";
			elseif($status=="-3")  $order_status="退订中";
			elseif($status=="-4"&&$ispay=="4")  $order_status="已退订";
			elseif($status=="-4"&&$ispay=="0")  $order_status="已取消";
			else $order_status="";
		  return $order_status;
	}
	/**
	 * @name：公共函数：上传图片过程
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	protected function cfgm_upload_pimg($path, $input_name) {
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
								'jpeg',
								'mp4'
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
	 * @name：公共函数： 二维码上传以及生成
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	protected function get_qrcodes($id) {
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
	
	protected function unique_arr($arr, $key) {
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
	 * @name：公共函数：公用用户优惠卷查询
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	protected function member_coupon($type, $mid) {
		$this->load->model ( 'app/cou_action_model', 'cou_action_model' );
		$this->load->model ( 'app/cou_member_action_model', 'member_action_model' );
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
	
	protected function image_resize($path, $img, $maxW, $maxH) {
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
	protected function serverIP() {
		if(in_array(gethostbyname($_SERVER["SERVER_NAME"]),array('192.168.10.202','120.25.217.197')))
			return true;
	}
	/**
	 * @name：私有函数：将指定经纬度附近的点按近->远排序
	 * @author: 温文斌
	 * @param: 中心位置的纬度
	 * @param: 中心位置的经度
	 * @param: 中心位置附近点的数据
	 * @return:
	 *
	 */
	protected function geohash_sort($n_latitude,$n_longitude,$data)
	{
		if(!empty($data))
		{
			foreach($data as $key=>$val)
			{
				$distance = $this->getDistance($n_latitude,$n_longitude,$val['latitude'],$val['longitude']);
					
				$data[$key]['distance'] = $distance;
					
				//排序列
				$sortdistance[$key] = $distance;
			}
			//距离排序
			array_multisort($sortdistance,SORT_ASC,$data);
			return $data;
	
		}
		else
		{
			return array();
		}
	
	}
	
	/**
	 * @name：私有函数：根据经纬度计算2点之间的距离
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	protected function getDistance($lat1,$lng1,$lat2,$lng2)
	{
		//地球半径
		$R = 6378137;
	
		//将角度转为狐度
		$radLat1 = deg2rad($lat1);
		$radLat2 = deg2rad($lat2);
		$radLng1 = deg2rad($lng1);
		$radLng2 = deg2rad($lng2);
	
		//结果
		$s = acos(cos($radLat1)*cos($radLat2)*cos($radLng1-$radLng2)+sin($radLat1)*sin($radLat2))*$R;
	
		//精度
		$s = round($s* 10000)/10000;
	
		return  round($s);
	}
	/**
	 * @name：私有函数：对图片进行处理（加上域名）
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	protected function __doImage($data) 
	{
		if(!empty($data))
		{
			//host
			if($this->serverIP())
			{
				$path = "http://" . $_SERVER ['HTTP_HOST'];
			}
			else
			{
				$path="http://192.168.10.202";
			}
			//逻辑
			if(is_array($data))
			{
				foreach ($data as $k=>$v)
				{
					$temp=$this->__doImage($v);
					$data[$k]=$temp;
				}
			}
			else
			{
				$data=$path.$data;
			}
			
		}
		return $data;
	}
	/**
	 * @name：私有函数：定义数据接口结束，后面为必要输出函数。
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	protected function __dealData($lastData, $i = 0, $path = '') {
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
				'member_photo',
				'expert_photo',
				'productpic',
				'cover_pic',
				'idcardpic',
				'm_bgpic',
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
	
	protected function __outmsg($reDataArr, $len = 0) {
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
		$jsoncallback = '';
		if(isset($_GET['jsoncallback']))$jsoncallback = $_GET['jsoncallback'];
		if(isset($_POST['jsoncallback']))$jsoncallback = $_POST['jsoncallback'];		
		if(!empty($jsoncallback)){//用于跨域
			echo $jsoncallback . "(".$this->resultJSON.")";
		}else{
			echo $this->resultJSON;
		}
		exit ();
	}
	
	/**
	 * @name：私有函数：输出数据,$len是长度
	 * @author: zyf
	 * @since 2017-03-16
	 * @param:$reDataArr 
	 * @return:json
	 *
	 */
	
	protected function __outstringmsg($reDataArr, $len = 0) {
		$lastData=array();
		if (sizeof ( $reDataArr ) == 0) {
			$this->result_code = "4001";
			$this->result_msg = "data empty";
		} else {
			$this->result_code = "2000";
			$this->result_msg = "success";
		}
		if (! empty ( $reDataArr )) {
			$reDataArr = strip_slashes ( $reDataArr );
			foreach ($reDataArr as $key=>$val)
			{
				$lastData[$key]=$val;
			}
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
		$jsoncallback = '';
		if(isset($_GET['jsoncallback']))$jsoncallback = $_GET['jsoncallback'];
		if(isset($_POST['jsoncallback']))$jsoncallback = $_POST['jsoncallback'];
		if(!empty($jsoncallback)){//用于跨域
			echo $jsoncallback . "(".$this->resultJSON.")";
		}else{
			echo $this->resultJSON;
		}
		exit ();
	}
	
	/**
        直播输出函数
	 *
	 */
	
	protected function __outlivemsg($reDataArr,$msg='success',$code='2000', $len = 0) {
		$lastData ['rows'] = array();
		$this->result_code = $code;
		$this->result_msg = $msg;
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
		$jsoncallback = '';
		if(isset($_GET['jsoncallback']))$jsoncallback = $_GET['jsoncallback'];
		if(isset($_POST['jsoncallback']))$jsoncallback = $_POST['jsoncallback'];		
		if(!empty($jsoncallback)){//用于跨域
			echo $jsoncallback . "(".$this->resultJSON.")";
		}else{
			echo $this->resultJSON;
		}		
		exit ();
	}	
	
	/**
	 * @name：私有函数：错误输出，已-3为标志
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	protected function __errormsg($msg = "", $code = "-3") {
		$this->result_code = $code;
		if ($msg == "") {
			$this->result_msg = "null";
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
		) , JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
		
		$jsoncallback = '';
		if(isset($_GET['jsoncallback']))$jsoncallback = $_GET['jsoncallback'];
		if(isset($_POST['jsoncallback']))$jsoncallback = $_POST['jsoncallback'];		
		if(!empty($jsoncallback)){//用于跨域
			echo $jsoncallback . "(".$this->resultJSON.")";
		}else{
			echo $this->resultJSON;
		}		
		exit ();
	}
	/**
	 * @name：私有函数：错误输出，已-3为标志(和__errormsg一样，增加json跨域问题)
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	protected function __wapmsg($msg = "", $callback="") {
		$this->result_code = "-3";
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
		) , JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
		$output=$this->resultJSON;
		if(empty($callback))
		  echo $this->resultJSON;
		else
			echo $callback."(".$output.")";
		exit ();
	}
	/**
	 * @name：私有函数：输出空
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	protected function __nullmsg() {
		$code="4001";
		$msg="data is empty";
		$output = json_encode ( array (
				"msg" => $msg,
				"code" => $code,
				"data" => array(),
				"total" => "0"
		) , JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
		$jsoncallback = '';
		if(isset($_GET['jsoncallback']))$jsoncallback = $_GET['jsoncallback'];
		if(isset($_POST['jsoncallback']))$jsoncallback = $_POST['jsoncallback'];		
		if(!empty($jsoncallback)){//用于跨域
			echo $jsoncallback . "(".$output.")";
		}else{
			echo $output;
		}		
		exit ();
	}
	/**
	 * @name：私有函数：输出数据,$len是长度
	 * @author: 温文斌
	 * @param:  
	 * @return:
	 *
	 */
	
	protected function __data($reDataArr,$common=array()) {
		$len="1";
		if(empty($reDataArr))
		{
			$code="4001";
			$msg="data empty";
			$data=array();
		}
		else 
		{
			if(is_array($reDataArr))
			$len=count($reDataArr);
		
			$reDataArr = strip_slashes ( $reDataArr );
			$reDataArr = $this->__dealData ( $reDataArr );
			$data=$reDataArr;
			$code="2000";
			$msg="success";
		}
        
		$output= json_encode ( array (
				"msg" => $msg,
				"code" => $code,
				"data" => $data,
				"total" => $len,
				'common'=>$common
		), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
		$jsoncallback = '';
		if(isset($_GET['jsoncallback']))$jsoncallback = $_GET['jsoncallback'];
		if(isset($_POST['jsoncallback']))$jsoncallback = $_POST['jsoncallback'];		
		if(!empty($jsoncallback)){//用于跨域
			echo $jsoncallback . "(".$output.")";
		}else{
			echo $output;
		}		
		exit ();
	}
	/**
	 * @name：私有函数：输出数据,$len是长度 （和__outmsg一样，增加wap端json跨域）
	 * @author: 温文斌
	 * @param:  $callback 用于jsonp
	 * @return:
	 *
	 */
	
	protected function __wap($reDataArr,$callback="") {
	
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
		
		
		$len = sizeof ( $reDataArr );
		
		$this->result_data = $lastData;
		$this->resultJSON = json_encode ( array (
				"msg" => $this->result_msg,
				"code" => $this->result_code,
				"data" => $this->result_data,
				"total" => $len
		), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
		$output=$this->resultJSON;
		if(empty($callback))
		   echo $output;
		else 		
		   echo $callback."(".$output.")";
		exit ();
	}
	/**
	 * @name：私有函数：成功输出信息，较少使用
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	protected function __successmsg($data = "") {
		$this->result_code = "1";
		$this->result_msg = "success";
		$lastData ['rows'] = $data;
		$this->result_data = $lastData;
		$this->resultJSON = json_encode ( array (
				"msg" => $this->result_msg,
				"code" => $this->result_code,
				"data" => $this->result_data,
				"total" => "0" 
		) , JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
		$output=$this->resultJSON;
		$jsoncallback = '';
		if(isset($_GET['jsoncallback']))$jsoncallback = $_GET['jsoncallback'];
		if(isset($_POST['jsoncallback']))$jsoncallback = $_POST['jsoncallback'];		
		if(!empty($jsoncallback)){//用于跨域
			echo $jsoncallback . "(".$output.")";
		}else{
			echo $output;
		}		
		exit ();
	}

	/**
	 * @name：私有函数：输出数据,$len是长度 输出的图片地址不带域名
	 * @author: 张允发
	 * @param: $reDataArr (array)
	 * @return: json
	 *
	 */
	
	protected function __outappmsg($reDataArr, $len = 0) {
		$lastData ['rows'] = "";
		if (sizeof ( $reDataArr ) == 0) {
			$this->result_code = "4001";
			$this->result_msg = "data empty";
		} else {
			$this->result_code = "2000";
			$this->result_msg = "success";
		}
		if (! empty ( $reDataArr )) {
			$lastData ['rows'] = strip_slashes ( $reDataArr );
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
		$output=$this->resultJSON;
		$jsoncallback = '';
		if(isset($_GET['jsoncallback']))$jsoncallback = $_GET['jsoncallback'];
		if(isset($_POST['jsoncallback']))$jsoncallback = $_POST['jsoncallback'];		
		if(!empty($jsoncallback)){//用于跨域
			echo $jsoncallback . "(".$output.")";
		}else{
			echo $output;
		}		
		exit ();		
		
		exit ();
	}
	
	
	/**
	 * 记录积分及更新用户积分数据
	 * @author: 张允发
	 * @param:$member_id 用户id 
	 * @param:$up_arr 更新数据的数组
	 * @param:$point 操作的积分数
	 * @param:$add 是否增加更新的参数，默认为0
	 * @param:$content 说明
	 * @param:$type 操作积分的类型 1为获取2为扣除
	 * @param:$time 时间
	 * @return: boolean 
	 */
	protected function record_integration($member_id,$point,$content,$type=1,$time,$add=0,$up_arr=array())
	{
                $member_id = intval($member_id);
		$this->load->model('app/u_member_model', 'mm_model');
		$this->load->model('app/u_member_points_log_model', 'points_log_model');//用户积分记录模型
		$data=$this->db->query("SELECT integral FROM u_member WHERE mid=$member_id")->row_array();
                if(empty($data)) return FALSE;
		if ($type == 1)
		{
                    $point_after = $data['integral']+$point;
                }else if($type == 2)
                {
                    $point_after = $data['integral']-$point;
                }else
                {
                    return FALSE;
		}
		$log_data=array(
				'member_id'=>$member_id,
				'point_before'=>$data['integral'],  //操作前的积分数
				'point'=>$point,	//本次操作的积分数
				'point_after'=>$point_after,  //操作后的积分数
				'content'=>$content,
				'time'=>$time,	//获得积分的时间
				'type'=>$type    //积分类型(1为获得,2为扣除)
		);
		$update_arr = array('integral'=>$point_after);
		if (!empty($add))
		{
			$update_arr+=$up_arr;
		}
		//用户积分及登录时间更新
		$res=$this->mm_model->update($update_arr,array('mid'=>$member_id));
		if ($res)
		{
			//积分记录
			$result=$this->points_log_model->insert($log_data);
			if ($result)
			{
				return TRUE;
			}
		}
		return FALSE;
	}
}

/* End of file webservices.php */
/* Location: ./application/controllers/webservices.php */