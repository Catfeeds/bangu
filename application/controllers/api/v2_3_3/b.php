<?php
/**
 *   @name:APP接口 => C端
 * 	 @author: 温文斌
 *   @time: 2016.03.28
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
class B extends APP_Controller {
	public function __construct() {
		parent::__construct ();
		header ( 'Content-type: application/json;charset=utf-8' );  //文档为json格式
		// 允许ajax POST跨域访问
		header('Access-Control-Allow-Origin:*');
		header('Access-Control-Allow-Methods:POST');
		header('Access-Control-Allow-Headers:x-requested-with,content-type');
	}
	/**
	 * @name：管家登录
	 * @author: 温文斌
	 * @param: mobile=手机号；password=密码；
	 * @return:
	 *
	 */
	
	public function E_expert_login() 
	{
		$mobile = $this->input->post ( 'mobile', true );
		$password = $this->input->post ( 'password', true );
		if(!$mobile||!$password) $this->__errormsg('param missing');

		$this->load->model ( 'common/u_expert_model', 'expert_model' );
		$res_query = $this->expert_model->row ( "(mobile='{$mobile}' or email='{$mobile}' or login_name='{$mobile}')", $type = "arr", $gre = "ID DESC limit 1" ); // 手机登陆
	
		if ($res_query) 
		{
			
			if (md5 ( $password ) == $res_query ['password'] && $res_query ['status'] == "2") 
			{
				// 登录成功后 更新或插入token，接口访问时验证token是否过期
				$this->load->library ( 'token' );
				$token_arr = $this->token->expert_get_Token ( $res_query ['id'] );
				$token = ( array ) json_decode ( $token_arr );
				//修改在线状态
				$this->db->where(array('id'=>$res_query ['id']));
				$this->db->update('u_expert',array('online'=>'2'));
	
				$output=array (
						'key' => $token ['key'],
						'id' => $res_query ['id'],
						'nickname'=>$res_query ['id'],
						'big_photo'=>$res_query ['big_photo']
				);
				$this->__outmsg($output);
				exit ();
			} 
			else if(md5 ( $password ) == $res_query ['password'] && $res_query ['status'] == "-1") 
			{
				echo json_encode(array('code'=>'4','msg' =>'平台终止了与您的合作，请联系客服!'));
			}
			else if (md5 ( $password ) == $res_query ['password'] && $res_query ['status'] == "1") 
			{
				echo json_encode(array('code'=>'2','msg' =>'该帐号在审核中，请耐心等待!','type'=>$res_query ['type'],'eid'=>$res_query ['id']));
			} 
			else if (md5 ( $password ) == $res_query ['password'] && $res_query ['status'] == "3") 
			{
				echo json_encode(array('code'=>'3','msg' =>'该帐号审核被拒绝，请重新完善个人资料!','type'=>$res_query ['type'],'eid'=>$res_query ['id'],'refuse_reasion'=>$res_query['refuse_reasion']));
			} 
			else 
			{
				echo json_encode(array('code'=>'-1','msg' =>'密码输入不正确!'));
			}
		} 
		else 
		{
			echo json_encode(array('code'=>'-1','msg' =>'用户不存在!'));
		}
	}
	
	/**
	 * @name：管家退出登录
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function E_logout() 
	{
		$token = $this->input->post ( 'number', true );
		$time = time () - 3600;
		$status = $this->db->query ( "update u_expert_access_token set access_token_validtime={$time} where access_token='{$token}'" );
		if ($status) {
			$this->result_code = "1";
			$this->result_msg = "logout success";
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
	 * @name：公共接口：发消息到手机短信
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function E_send_mobile() 
	{
		$this->load->library ( 'session', true );
		$mobile = $this->input->post ( 'mobile', true );
		$type = intval ( $this->input->post ( 'type', true ) ); // 编号=》对应短信模板标识码

		//$mobile="13751174462";
		//$type="1";
		// 验证手机是否为空
		if (empty ( $mobile )) 
		{
			$this->__errormsg( '手机号码不能为空');
		}
		// 验证手机号
		$this->load->helper ( 'regexp' );
		if (! regexp ( 'mobile', $mobile )) {
			$this->__errormsg( '手机号码输入有误');
		}
		//更多条件帅选
		switch ($type) 
		{
			case 1: // 绑定银行卡
				$msgtype="expert_bind_card";//代码expert_bind_card
				break;
			default :
				break;
		}
		// 生成验证码
		$code = mt_rand ( 1000, 9999 );
		// 读取短信模板
		$this->load->model ( 'sms_template_model', 'sms_model' );
		if(!isset($msgtype)) $this->__errormsg("短信模板值错误");
		$template = $this->sms_model->row ( array ('msgtype' => $msgtype) );
		if(empty($template)) $this->__errormsg("短信模板值错误");
		// 将验证码放入模板中
		$content = str_replace ( "{#CODE#}", $code, $template ['msg'] );
		//发送短信
		$status=$this->send_message($mobile, $content); 
		//需要存储session的值
		$session_data =array (
				$msgtype.'_code' => $code,
				$msgtype.'_mobile' => $mobile
		);
		if($status)
		{
			$return=$session_data;
			$return['sess_key_code']=$msgtype.'_code';
			$return['sess_key_mobile']=$msgtype.'_mobile';
			$this->session->set_userdata ($session_data);//存储session
			$this->__outmsg($return);
		}
		else 
			$this->__errormsg('短信发送失败');
	}
	/**
	 * @name：管家个人中:绑定银行卡处理页面
	 * @author: 温文斌
	 * @param: number=凭证；
	 * @return:
	 *
	 */
	
	public function E_bind_card()
	{
		$bankcard =$this->input->post ( 'bankcard', true );
		$bankname = $this->input->post ( 'bankname', true );
		$cardholder = $this->input->post ( 'cardholder', true ); // 持卡人
		$mobile =$this->input->post ( 'mobile', true ) ;
		$code =$this->input->post ( 'code', true ) ;//验证码
		
		$sess_key_code =$this->input->post ( 'sess_key_code', true ) ;//验证码存储在session的变量
		$sess_key_mobile = $this->input->post ( 'sess_key_mobile', true ); //手机号码存储在session的变量
		$token = $this->input->post ( 'number', true );//token
		$this->expert_check_token ( $token ); 
		$e_id = $this->F_get_eid($token);
		
		if(empty($bankcard))  $this->__errormsg('银行卡号不能为空');
		if(!preg_match('/^\d+$/',$bankcard)) $this->__errormsg('银行卡号只能是数字');
		if(empty($bankname))  $this->__errormsg('请选择银行卡类型');
		if(empty($cardholder))  $this->__errormsg('持卡人不能为空');
		if(empty($mobile))  $this->__errormsg('手机号码不能为空');
		if(empty($code))  $this->__errormsg('验证码不能为空');
		if(empty($sess_key_code)||empty($sess_key_mobile))  $this->__errormsg('验证码不能为空');
		
		$sess_code=$this->session->userdata($sess_key_code);
		$sess_mobile=$this->session->userdata($sess_key_mobile);
		if($sess_code==$code&&$sess_mobile==$mobile)
		{
			$this->load->model ( 'admin/b2/expert_model', 'expert_model' );
			$data=array('bankcard'=>$bankcard,'bankname'=>$bankname,'cardholder'=>$cardholder);
			$status=$this->expert_model->update($data,array('id'=>$e_id));
			
			$this->__data(array('msg'=>'绑定成功'));
			
		}
		else 
		{
			$this->__errormsg('验证码错误');
		}
		
	}
	/**
	 * @name：管家个人中:提现
	 * @author: 温文斌
	 * @param: number=凭证；
	 * @return:
	 *
	 */
	
	public function E_add_exchange()
	{
		$amount =$this->input->post ( 'amount', true ) ;//提现的金额
		
		$token = $this->input->post ( 'number', true );//token
		$this->expert_check_token ( $token );
		$e_id = $this->F_get_eid($token);
		//$e_id="257";
		//$amount="0.5";
		if($amount=="0"||empty($amount)) $this->__errormsg('请输入提现金额');
		$expert_row=$this->F_expert_detail($e_id);
		if(empty($expert_row['bankcard'])||empty($expert_row['bankname'])||empty($expert_row['cardholder']))
			$this->__errormsg('请先绑定银行卡');
		if($expert_row['amount']<$amount)  $this->__errormsg('您填写的提现金额大于可提现金额，请您重新填写');
		$post_arr['amount']=$amount;
		$post_arr['exchange_type'] = ROLE_TYPE_EXPERT;
		$post_arr['userid'] = $e_id;
		$post_arr['bankcard'] = $expert_row['bankcard'];
		$post_arr['bankname'] = $expert_row['bankname'];
		$post_arr['cardholder'] = $expert_row['cardholder'];
		$post_arr['serial_number'] = 'TX'.date('YmdHis').rand(100,999);
		$post_arr['addtime'] = date('Y-m-d H:i:s', CLIENT_REQUEST_TIME);
		$post_arr['amount_before'] = $expert_row['amount'];
		$post_arr['status'] = 0;
		//数据操作
		$this->db->trans_begin();
		$this->load->model("app/u_exchange_model","u_exchange");
		$this->load->model("app/u_expert_model","u_expert");
		$this->u_exchange->insert($post_arr);
		$this->u_expert->update(array('amount'=>$expert_row['amount']-$amount),array('id'=>$e_id));
		$this->db->trans_complete();
		if($this->db->trans_status()===true)
		{
			$this->db->trans_commit();
			$this->__data('提现成功');
		}
		else 
		{
			$this->db->trans_rollback();
		}
		
	}
	/**
	 * @name：管家个人中心->提现明细
	 * @author: 温文斌
	 * @param: page=当前页数
	 * @return:经典列表、国家列表
	 *
	 */
	
	public function E_exchange()
	{
		//传值
		$page=$this->input->post("page",true);
		$token = $this->input->post ( 'number', true );//token
	
		$this->expert_check_token ( $token );
		$e_id=$this->F_get_eid($token);//根据token获取eid
		//$e_id="1";
	
		//分页数据
		$page_size="6";
		if(!$page) $page="1"; //默认第一页
		$from = ($page - 1) * $page_size;
	
	
		$output=array();
		$sql="select
					 id,userid,bankcard,bankname,cardholder,addtime,modtime,approve_status,amount_before,amount,serial_number,status
			  from
					 u_exchange
			  where
					 exchange_type=1 and userid='{$e_id}' order by addtime desc
		";
		$sql_page=$sql." limit {$from},{$page_size}";
		$total_nums=$this->db->query($sql)->num_rows();
		$output['page']=$page;
		$output['page_size']=$page_size;
		$output['total_rows']=$total_nums;
		$total_page= ceil($total_nums/$page_size);
		$output['total_page']=$total_page;
	
		$output['result']=$this->db->query($sql_page)->result_array();
		foreach ($output['result'] as $k=>$v) //去掉html标签
		{
			if($v['status']=="0")
				$v['status_CH']="提现中";
			else if($v['status']=="1")
				$v['status_CH']="已提现";
			else if($v['status']=="2")
				$v['status_CH']="已拒绝";
			else
				$v['status_CH']="已拒绝";
		
			$output['result'][$k]=$v;
		}
	    $this->__data($output);
	}
	/**
	 * @name：管家个人中心基本资料
	 * @author: 温文斌
	 * @param: number=凭证；
	 * @return:
	 *
	 */
	
	public function E_expert_info() 
	{
		$token = $this->input->post ( 'number', true );
		$this->expert_check_token ( $token );
		$e_id = $this->F_get_eid($token); //eid
		//$e_id="1";
		$sql = "
			SELECT 
						e.id AS e_id,e.small_photo,e.realname,e.nickname,e.mobile,e.expert_dest as expert_destid,
						e.sex as sexid,CASE WHEN e.sex=0 THEN '女' WHEN e.sex=1 THEN '男' WHEN e.sex=-1 THEN '保密' END AS sex,e.idcard,e.idcardpic,
		                a.name AS city_name,e.city,e.amount,e.bankcard,e.bankname,e.branch,e.cardholder,
		                (select GROUP_CONCAT(kindname SEPARATOR '、') from u_dest_cfg where FIND_IN_SET(id,e.expert_dest) >0 )as expert_dest
		    FROM		
						u_expert AS e 
						LEFT JOIN u_area AS a ON e.city=a.id 
			WHERE 
						e.id={$e_id}
		";
		$query = $this->db->query ( $sql );
		$result = $query->row_array();

        $newMessage_row=$this->db->query("select id from u_message where msg_type=1 and `read`=0 and receipt_id='{$e_id}'")->num_rows();	
        $newNotice_row=$this->db->query("select id from u_notice_read where notice_type=1 and `read`=0 and userid='{$e_id}'")->num_rows();
        $result['new_message_num']=$newMessage_row;
        $result['new_notice_num']=$newNotice_row;
		$this->__outmsg ( $result );
	}
	/**
	 * @name：管家个人中心->业务通知
	 * @author: 温文斌
	 * @param: spot_id=景区id,page=当前页数
	 * @return:经典列表、国家列表
	 *
	 */
	
	public function E_message()
	{
		//传值
		$page=$this->input->post("page",true);
		$token = $this->input->post ( 'number', true );//token
	
		$this->expert_check_token ( $token );
		$e_id=$this->F_get_eid($token);//根据token获取eid
		//$e_id="1";
	
		//分页数据
		$page_size="6";
		if(!$page) $page="1"; //默认第一页
		$from = ($page - 1) * $page_size;
	
	
		$output=array();
		$sql="select *,case when `read`=0 then '未读' when `read`=1 then '已读' end as read_CH from u_message where receipt_id='{$e_id}' and msg_type=1 order by modtime desc";
		$sql_page=$sql." limit {$from},{$page_size}";
		$total_nums=$this->db->query($sql)->num_rows();
		$output['page']=$page;
		$output['page_size']=$page_size;
		$output['total_rows']=$total_nums;
		$total_page= ceil($total_nums/$page_size);
		$output['total_page']=$total_page;
	
		$output['result']=$this->db->query($sql_page)->result_array();
		foreach ($output['result'] as $k=>$v) //去掉html标签
		{
			$v['content']=strip_tags($v['content']);
			$output['result'][$k]=$v;
		}
	
		$this->__data($output);
	}
	/**
	 * @name：管家个人中心->平台公告
	 * @author: 温文斌
	 * @param: spot_id=景区id,page=当前页数
	 * @return:经典列表、国家列表
	 *
	 */
	
	public function E_notice()
	{
		//传值
		$page=$this->input->post("page",true);
		$token = $this->input->post ( 'number', true );//token
	
		$this->expert_check_token ( $token );
		$e_id=$this->F_get_eid($token);//根据token获取eid
		//$e_id="1";
	
		//分页数据
		$page_size="6";
		if(!$page) $page="1"; //默认第一页
		$from = ($page - 1) * $page_size;
	
	
		$output=array();
		$sql="
			 select 
						r.id,r.notice_id,r.modtime,n.title,n.content,r.read,
						case when r.read=0 then '未读' when r.read=1 then '已读' end as read_CH
			from 
						u_notice_read as r
				 		left join u_notice as n on n.id=r.notice_id
			where
						r.userid='{$e_id}' and r.notice_type=1 
			order by 
						r.modtime desc
				";	
		$sql_page=$sql." limit {$from},{$page_size}";
		$total_nums=$this->db->query($sql)->num_rows(); 
		$output['page']=$page;
		$output['page_size']=$page_size;
		$output['total_rows']=$total_nums;
		$total_page= ceil($total_nums/$page_size);
		$output['total_page']=$total_page;
	
		$output['result']=$this->db->query($sql_page)->result_array(); 
		foreach ($output['result'] as $k=>$v) //去掉html标签
		{
			$v['content']=strip_tags($v['content']);
			$output['result'][$k]=$v;
		}
	
		$this->__data($output);
	}
	/**
	 * @name：管家修改个人资料页面显示
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function E_update_info()
	{
		$token = $this->input->post ( 'number', true );
		$this->expert_check_token ( $token );
		$e_id = $this->F_get_eid($token);
		//$e_id="235";
		$output=$this->F_expert_detail_more($e_id);
		
		if($output['type']=="1")
			$pid="100";
		else 
			$pid="99";
		$output['cardtype_list']=$this->db->query("select dict_id,description from u_dictionary where pid={$pid}")->result_array();
		$output['decade_list']=$this->db->query("select dict_id,description from u_dictionary where pid=133")->result_array();
		$output['constellation_list']=$this->db->query("select dict_id,description from u_dictionary where pid=115")->result_array();
		$output['blood_list']=$this->db->query("select dict_id,description from u_dictionary where pid=128")->result_array();
		$output['attr_list']=$this->db->query("select dict_id,description from u_dictionary where pid=140")->result_array();
		$output['go_in_list']=$this->db->query("select dict_id,description from u_dictionary where pid=156")->result_array();
		$output['go_out_list']=$this->db->query("select dict_id,description from u_dictionary where pid=150")->result_array();
		$output['play_list']=$this->db->query("select dict_id,description from u_dictionary where pid=162")->result_array();
		$output['with_list']=$this->db->query("select dict_id,description from u_dictionary where pid=168")->result_array();
		$output['relax_list']=$this->db->query("select dict_id,description from u_dictionary where pid=174")->result_array();
		
		//是否在审核中
		$one=$this->db->query("select * from bridge_expert_map where expert_id='{$e_id}' and status=0")->num_rows();
		if($one>0)
		    $output['is_checking']="yes";
		else 
			$output['is_checking']="no";
			
		$this->__outmsg($output);
	}
	/**
	 * @name：验证手机号
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function E_check_mobile()
	{
		$code=$this->input->post("code",true); //验证码
		$mobile=$this->input->post("mobile",true); //验证码
		
		//$code="1465";
		//$mobile="13751174462";
		if(!$code||!$mobile)  $this->__errormsg('param missing');
		$sess_code=$this->session->userdata("code");
		$sess_mobile=$this->session->userdata("mobile");
		$reDataArr=array(
			'code'=>$code,
			'mobile'=>$mobile,
			'sess_code'=>$sess_code,
			'sess_mobile'=>$sess_mobile
		);
		if($sess_code==$code&&$mobile==$sess_mobile)
		{
			$this->__data($reDataArr);
		}
		else 
		{
			$this->__errormsg('验证码错误');
		}
		
	}
	/**
	 * @name：管家修改个人资料->提交数据
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function E_update_info_deal()
	{
		//1、传值
		$token = $this->input->post ( 'number', true );
		$nickname = $this->input->post ( 'nickname', true ); // 昵称
		$sex = $this->input->post ( 'sex', true ); // 性别
		$big_photo = $this->input->post ( 'big_photo', true ); // 头像
		$mobile = $this->input->post ( 'mobile', true ); // 手机号
		$idcardtype = $this->input->post ( 'idcardtype', true ); // 证件类型
		$idcard = $this->input->post ( 'idcard', true ); // 证件号
		$idcardpic = $this->input->post ( 'idcardpic', true ); // 证件正面照
		$idcardconpic = $this->input->post ( 'idcardconpic', true ); // 证件反面照
		$city = $this->input->post ( 'city', true ); // 所在城市
		$expert_dest = $this->input->post ( 'expert_dest', true ); // 擅长线路
		$year = $this->input->post ( 'year', true ); // 从业年限
		$school = $this->input->post ( 'school', true ); // 学校
		
		$reason = $this->input->post ( 'reason', true ); // 修改理由

		$this->expert_check_token ( $token );
		$e_id = $this->F_get_eid($token);
		//$e_id="1";
		//2、验证
		$this->load->model ( 'admin/b2/expert_model', 'expert' );
		if (empty($nickname)) 	                 {$this->__errormsg ( '请填写昵称' );}
		$expert_arr= $this->db->query ( "select nickname from u_expert where nickname='{$nickname}'")->row_array();
		$expert_arr_my= $this->db->query ( "select nickname from u_expert where id='{$e_id}'")->row_array();
		$expert_rows=count($expert_arr);
		if ($expert_rows>0&&$expert_arr_my['nickname']!=$nickname) {$this->__errormsg ( '昵称已被占用，请重新输入' );}
		
		if(empty($big_photo))                    {$this->__errormsg ( '请上传头像' );}
		if(empty($mobile))                       {$this->__errormsg ( '请填写手机号码' );}
		else{
			$this->load->helper ( 'regexp' );
		   if (!regexp('mobile' ,$mobile))       { $this->__errormsg ('请输入正确的手机号'); }
		}
		//if(empty($idcardtype))                   {$this->__errormsg ( '请选择证件类型' );}
		//if(empty($idcard))                       {$this->__errormsg ( '请填写证件号码' );}
		if(empty($idcardpic))                    {$this->__errormsg ( '请上传证件照正面' );}
		if(empty($idcardconpic))                 {$this->__errormsg ( '请上传证件照反面' );}
		if(empty($city))                         {$this->__errormsg ( '请选择所在城市' );}
		if(empty($expert_dest))                  {$this->__errormsg ( '请选择擅长路线' );}
		//if(empty($year))                         {$this->__errormsg ( '请填写工作年限' );}
		if(empty($school))                       {$this->__errormsg ( '请填写毕业学校' );}
		
		//3、组成数据
		$expert=$this->db->query("select * from u_expert where id={$e_id}")->row_array();
		unset($expert['id']);
		$data=$expert;
		$time=date("Y-m-d H:i:s");
		$data['sex']=$sex;
		$data['nickname']=$nickname;
		$data['big_photo']=$big_photo;
		$data['mobile']=$mobile;
		$data['idcardtype']=$idcardtype;
		$data['school']=$school;
		$data['idcard']=$idcard;
		$data['idcardpic']=$idcardpic;
		$data['idcardconpic']=$idcardconpic;
		$data['city']=$city;
		$data['expert_dest']=$expert_dest;
		$data['modtime']=$time;
		
		$one=$this->db->query("select * from bridge_expert_map where expert_id='{$e_id}' and status=0")->num_rows();
		
		if($one>0)
		{
			$this->__errormsg('修改资料正在审核中，不能重复添加');
		}
		else 
		{
			$this->db->trans_begin(); //事务开启
			$this->db->insert("bridge_expert",$data);
			$bridge_expert_id=$this->db->insert_id();
			$arr=array(
				'expert_id'=>$e_id,
				'reason'=>$reason,
				'addtime'=>$time,
				'b_expert_id'=>$bridge_expert_id,
				'status'=>'0'
			);
			$bridge_expert_map=$this->db->insert("bridge_expert_map",$arr);
			$this->db->trans_complete();//事务结束
			if ($this->db->trans_status () === TRUE) {
				$this->db->trans_commit ();
				$this->__outmsg(array('status'=>$bridge_expert_map));  //成功返回数据
			} else {
				$this->db->trans_rollback (); // 事务回滚
				$this->__errormsg('操作异常');
			}
		}

		
	}
	/**
	 * @name：管家修改个人更多资料->提交数据
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function E_update_info_more()
	{
		//1、传值
		$token = $this->input->post ( 'number', true );
		
		$county = $this->input->post ( 'county', true ); // 国家
		$province = $this->input->post ( 'province', true ); // 省份
		$city = $this->input->post ( 'city', true ); // 城市
		$hobby = $this->input->post ( 'hobby', true ); // 爱好
		$like_food = $this->input->post ( 'like_food', true ); // 喜欢的食物
		$pass_way = $this->input->post ( 'pass_way', true ); // 去过的地方
		$blood = $this->input->post ( 'blood', true ); //(性格类型)血型
		$attr = $this->input->post ( 'attr', true ); // （性格 ）标签 、“生活角色”去掉 ; 格式: 127,452,103 
		$decade = $this->input->post ( 'decade', true ); // 年代
		$constellation = $this->input->post ( 'constellation', true ); // 星座
		$go_in = $this->input->post ( 'go_in', true ); // 喜欢去哪玩（境内）   ; 格式: 127,452,103
		$go_out = $this->input->post ( 'go_out', true ); // 喜欢去哪玩（境外）; 格式: 127,452,103
		$play = $this->input->post ( 'play', true ); // 喜欢怎么样玩; 格式: 127,452,103
		$with = $this->input->post ( 'who', true ); // 喜欢跟谁玩; 格式: 127,452,103
		$relax = $this->input->post ( 'relax', true ); // 平日休闲方式; 格式: 127,452,103
		
		$this->expert_check_token ( $token );
		$e_id = $this->F_get_eid($token);
		//$e_id="1";
		//$county="2";
		//$relax="169,170,172";
		
		//2、组成数据
		
		$expert_more=array('expert_id'=>$e_id);
		if(!empty($county))
			$expert_more['county']=$county;
		if(!empty($province))
			$expert_more['province']=$province;
		if(!empty($city))
			$expert_more['city']=$city;
		if(!empty($hobby))
			$expert_more['hobby']=$hobby;
		if(!empty($like_food))
			$expert_more['like_food']=$like_food;
		if(!empty($blood))
			$expert_more['blood']=$blood;
		if(!empty($constellation))
			$expert_more['constellation']=$constellation;
		if(!empty($decade))
			$expert_more['decade']=$decade;
		if(!empty($pass_way))
			$expert_more['pass_way']=$pass_way;
		
		
		$this->db->trans_begin ();
		$re=$this->db->query("delete from u_expert_relax where expert_id='{$e_id}'");
		$re=$this->db->query("delete from u_expert_with where expert_id='{$e_id}'");
		$re=$this->db->query("delete from u_expert_play where expert_id='{$e_id}'");
		$re=$this->db->query("delete from u_expert_attr where expert_id='{$e_id}'");
		$re=$this->db->query("delete from u_expert_go where expert_id='{$e_id}'");
		
		$row=$this->db->query("select id from u_expert_more_about where expert_id='{$e_id}'")->num_rows();
		if($row>0)
		{
		$this->db->where(array('expert_id'=>$e_id));
		$this->db->update("u_expert_more_about",$expert_more);
		}
		else
		{
			$this->db->insert("u_expert_more_about",$expert_more);
		}
		//去哪玩
		$go_str=$go_in;
		if(!empty($go_out))
		$go_str.=','.$go_out;
		$go_arr=explode(",", $go_str);
		foreach ($go_arr as $key=>$value)
		{
			$go_data=array('expert_id'=>$e_id,'dest_id'=>$value);
			$status=$this->db->insert("u_expert_go",$go_data);
		}
		//标签
		$attr_arr=explode(",", $attr);
		foreach ($attr_arr as $key=>$value)
		{
			$attr_data=array('expert_id'=>$e_id,'attr_id'=>$value);
			$status=$this->db->insert("u_expert_attr",$attr_data);
		}
		//怎么玩
		$play_arr=explode(",", $play);
		foreach ($play_arr as $key=>$value)
		{
			$play_data=array('expert_id'=>$e_id,'way_id'=>$value);
			$status=$this->db->insert("u_expert_play",$play_data);
		}
		//和谁玩
		$with_arr=explode(",", $with);
		foreach ($with_arr as $key=>$value)
		{
			$with_data=array('expert_id'=>$e_id,'crowd_id'=>$value);
			$status=$this->db->insert("u_expert_with",$with_data);
		}
		//休闲方式
		$relax_arr=explode(",", $relax);
		foreach ($relax_arr as $key=>$value)
		{
			$relax_data=array('expert_id'=>$e_id,'relax_id'=>$value);
			$status=$this->db->insert("u_expert_relax",$relax_data);
		}
		
		$this->db->trans_complete();//事务结束
		if ($this->db->trans_status () === TRUE) {
			$this->db->trans_commit ();
			$this->__outmsg(array('eid'=>$e_id,'relax'=>$relax));  //成功返回数据
		} else {
			$this->db->trans_rollback (); // 事务回滚
			$this->__errormsg('操作异常');
		}
		
	}
	
	/**
	 * @name：管家个人中心->结算账单
	 * @author: 温文斌
	 * @param: page=当前页数
	 * @return:经典列表、国家列表
	 *
	 */
	
	public function E_month_account()
	{
		//传值
		$page=$this->input->post("page",true);
		$token = $this->input->post ( 'number', true );//token
		$content=$this->input->post("content",true); //模糊搜索
	
		$this->expert_check_token ( $token );
		$e_id=$this->F_get_eid($token);//根据token获取eid
		//$e_id="1";
		//$content="99";
		
		//分页数据
		$page_size="6";
		if(!$page) $page="1"; //默认第一页
		$from = ($page - 1) * $page_size;
	
		$where="";
		if(!empty($content))
			$where=" and (id like '%{$content}%' or amount like '%{$content}%' or real_amount like '%{$content}%')";
		
		$output=array();
		$sql="select 
						id,account_type,userid,addtime,startdatetime,enddatetime,amount,real_amount
				from	
						 u_month_account 
				where 
						account_type=1 and userid='{$e_id}' {$where}
				order by
						addtime desc";
		$sql_page=$sql." limit {$from},{$page_size}";
		$total_nums=$this->db->query($sql)->num_rows(); //景点评论
		$output['page']=$page;
		$output['page_size']=$page_size;
		$output['total_rows']=$total_nums;
		$total_page= ceil($total_nums/$page_size);
		$output['total_page']=$total_page;
	
	    $output['result']=$this->db->query($sql_page)->result_array(); //
	    if(!empty($content))
	    {
	    	$all['result']=$this->db->query($sql)->result_array(); //
	    	$this->__data($all);
	    }
	    else
	    	$this->__data($output);
	    
		}

	/**
	 * @name：管家个人中心：订单列表
	 * @author: 温文斌
	 * @param: number=凭证
	 * @return:
	 *
	 */
	
	public function E_order_list() {
		$page=$this->input->post("page",true);
		$token = $this->input->post ( 'number', true );
		$code = $this->input->post ( 'code', true );
		$content = $this->input->post ( 'content', true ); //模糊搜索

		$this->expert_check_token ( $token );
		$e_id = $this->F_get_eid($token);
		//$e_id="242";
		//$content="160";
		
		//分页数据
		$page_size="6";
		if(!$page) $page="1"; //默认第一页
		$from = ($page - 1) * $page_size;
		
		$where = "";
		if ($code == 0) { // 全部
			$where = "";
		} elseif ($code == 1) { // 待留位
			$where = "AND mo.status=0 AND mo.ispay=0";
		} elseif ($code == 2) { // 待支付
			$where = "AND mo.status=1 AND mo.ispay=0 AND TIMESTAMPDIFF(HOUR,mo.addtime,NOW())<24";
		} elseif ($code == 3) { // 已支付
			$where = "AND mo.status>=1 AND mo.ispay=2";
		} elseif ($code == 4) { // 退款
			$where = "AND mo.status in(-3,-4) AND mo.ispay in (3,4)";
		}
		//模糊搜索
		if(!empty($content)&&$content)
		{
			$where.=" and ( mo.ordersn like'%{$content}%' or mo.productname like'%{$content}%')";
		}
		
		$sql = "SELECT 
		               mo.id AS mo_id,e.id AS e_id,mo.ordersn,mo.productname,
		              (mo.dingnum+mo.childnum+mo.childnobednum+mo.oldnum)AS people,mo.addtime,mo.linkman,
		              l.mainpic,mo.ispay,
		              mo.status,(mo.total_price+mo.settlement_price) as all_price,l.lineprice
				FROM 
						u_member_order AS mo  
						LEFT JOIN u_expert AS e ON mo.expert_id=e.id 
						LEFT JOIN u_line AS l ON mo.productautoid=l.id 
			   WHERE    
						mo.expert_id={$e_id} {$where} 
		       ORDER BY 
		       			mo.id desc";
		$sql_page=$sql." limit {$from},{$page_size}";
		
		$reDataArr = $this->db->query ( $sql_page )->result_array ();
		if ($reDataArr) {
			foreach ( $reDataArr as $key => $val ) {
				foreach ( $val as $k => $v ) {
					if ($k == "usedate") {
						$val [$k] = date ( 'Y-m-d', strtotime ( $val [$k] ) );
					}
				}
			    //支付状态
				$val['ispay_CH']=$this->F_order_status($val['status'], $val['ispay']);
				$reDataArr [$key] = $val;
			}
		}
		
		$total_nums=$this->db->query($sql)->num_rows(); //景点评论
		$output['page']=$page;
		$output['page_size']=$page_size;
		$output['total_rows']=$total_nums;
		$total_page= ceil($total_nums/$page_size);
		$output['total_page']=$total_page;
		$output['result']=$reDataArr;
		
		if(!empty($content))
		{
			$all['result'] = $this->db->query ( $sql)->result_array ();
			$this->__data( $all );
		}
		else
		$this->__data ( $output );
	}
	
	/**
	 * @name：管家个人中心:订单详情
	 * @author: 温文斌
	 * @param: number=凭证；orderid=订单ID
	 * @return:
	 *
	 */
	
    public function E_order_detail() 
    {
		$token = $this->input->post ( 'number', true );
		$order_id = $this->input->post ( 'orderid', true );
		$this->expert_check_token ( $token );
		//$order_id="100352";
		if(!is_numeric ($order_id) || !$order_id)
			$this->__errormsg('param missing');
		$order_detail=$this->order_detail($order_id);

		//出游人列表
		$sql = "
				SELECT
							mo.id AS mo_id,mt.id AS t_id,mt.name AS t_name,mt.enname AS t_enname,mt.certificate_no AS t_idcard,
							d.description as t_type,mt.telephone as t_telephone,mt.birthday as t_birthday,
							mt.endtime as t_endtime,mt.sign_time as t_signtime,mt.sign_place as t_sign_place
				FROM
							u_member_order AS mo
							LEFT JOIN u_member_order_man AS mom ON mom.order_id=mo.id
							LEFT JOIN u_member_traver AS mt ON mom.traver_id=mt.id
							LEFT JOIN u_dictionary as d on d.dict_id=mt.certificate_type
				WHERE
							mo.id={$order_id}
		";
		$order_detail[0]['tourist_list'] = $this->db->query ($sql)->result_array ();
		
		$this->__outmsg ( $order_detail );
	}
	/**
	 * @name：管家个人中心->未支付的订单列表（不包括正在价格申请的订单）
	 * @author: 温文斌
	 * @param: code=状态,page=当前页数；content=模糊搜索内容
	 * @return:经典列表、国家列表
	 *
	 */
	
	public function E_price_apply() {
		$token = $this->input->post ( 'number', true );
		$page=$this->input->post("page",true);
		$content = $this->input->post ( 'content', true ); //模糊搜索
	
	    $this->expert_check_token ( $token );
		$e_id = $this->F_get_eid($token);
     	//$e_id="3";
       
		//分页数据
		$page_size="6";
		if(!$page) $page="1"; //默认第一页
		$from = ($page - 1) * $page_size;
		
		$where = "AND mo.status=0 AND mo.ispay=0 AND TIMESTAMPDIFF(HOUR,mo.addtime,NOW())<24";
		
		//模糊搜索
		if(!empty($content)&&$content)
		{
			$where.=" and ( mo.ordersn like'%{$content}%' or mo.productname like'%{$content}%')";
		}
	
		$sql = "SELECT
						mo.id AS mo_id,mo.ordersn,mo.productname,mo.usedate,
						(mo.dingnum+mo.childnum+mo.childnobednum+mo.oldnum)AS people,mo.addtime,mo.linkman,
						l.mainpic,mo.ispay,case when mo.ispay=0 then '未付款' when mo.ispay='1' then '待确认' when mo.ispay='2' then '已付款' end as ispay_CN,
						mo.status,(mo.total_price+mo.settlement_price) as all_price,l.lineprice
				FROM
						u_member_order AS mo
						LEFT JOIN u_line AS l ON mo.productautoid=l.id
						
				WHERE
						mo.expert_id={$e_id} and mo.id not in(select order_id from u_order_price_apply where expert_id='{$e_id}' and status=0)
		                {$where}
				ORDER BY
						mo.id desc";
		$sql_page=$sql." limit {$from},{$page_size}";
		
		$reDataArr = $this->db->query ( $sql_page )->result_array ();
		
		$total_nums=$this->db->query($sql)->num_rows(); //景点评论
		$output['page']=$page;
		$output['page_size']=$page_size;
		$output['total_rows']=$total_nums;
		$total_page= ceil($total_nums/$page_size);
		$output['total_page']=$total_page;
		$output['result']=$reDataArr;
	    
		if(!empty($content))
		{
			$all['result'] = $this->db->query ( $sql)->result_array ();
			$this->__outmsg ( $all );
		}
		else
		$this->__outmsg ( $output );
		}
	/**
	 * @name：管家个人中心->价格申请列表（申请中、通过、拒绝）
	 * @author: 温文斌
	 * @param: code=状态,page=当前页数；content=模糊搜索内容
	 * @return:经典列表、国家列表
	 *
	 */
	
	public function E_price_apply_list()
	{
		//传值
		$page=$this->input->post("page",true);
		$code=$this->input->post("code",true); //0是申请中，1是通过，2是拒绝
		$content=$this->input->post("content",true); //模糊搜索内容
		$token = $this->input->post ( 'number', true );//token
	
		$this->expert_check_token ( $token );
		$e_id=$this->F_get_eid($token);//根据token获取eid
		//$e_id="1";
		//$code="0";
		//$content="1";

	    if(!is_numeric($code))  $this->__errormsg('param missing');
		//分页数据
		$page_size="6";
		if(!$page) $page="1"; //默认第一页
		$from = ($page - 1) * $page_size;
	
	
		$output=array();
		$sql_init="
			  select 
						pa.*,mo.productname,mo.ordersn,mo.usedate
			  from 
						u_order_price_apply as pa
				 		left join u_member_order as mo on pa.order_id=mo.id
			  where 
						pa.expert_id='{$e_id}' and pa.status='{$code}'
				";
		$sql=$sql_init." order by pa.addtime desc";
		$sql_page=$sql." limit {$from},{$page_size}";
		$total_nums=$this->db->query($sql)->num_rows(); //
		$output['page']=$page;
		$output['page_size']=$page_size;
		$output['total_rows']=$total_nums;
		$total_page= ceil($total_nums/$page_size);
		$output['total_page']=$total_page;
	
		$result=$this->db->query($sql_page)->result_array(); //
	
		$output['result']=$result;
	    if(empty($content))  //有模糊内容的时候，不分页，反之分页
		$this->__data($output);
	    else
	    {
	    	$sql_all=$sql_init." and (mo.productname like '%{$content}%' or mo.ordersn like '%{$content}%')";
	    	$sql_all.=" order by pa.addtime desc";
	    	$all['result']=$this->db->query($sql_all)->result_array(); //
	    	$this->__outmsg($all);
	    }
	}
	/**
	 * @name：管家修改订单价格
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function E_update_order_price()
	{
		$reason= $this->input->post ( 'reason', true );		//理由
		$price = $this->input->post ( 'price', true );				//修改后价格
		$orderid= $this->input->post ( 'orderid', true );			//订单号
		$token = $this->input->post ( 'number', true );
		
		$this->expert_check_token ( $token );
		$e_id = $this->F_get_eid($token);
		//$orderid="101885";
	   // $e_id ="257";
	    //$reason="好贵啊啊";
	    //$price="736.00";
		if(empty($reason))							$this->__errormsg ( "请填写修改价位理由！");
		if(mb_strlen($reason,'utf8')<3)			    $this->__errormsg ( "理由太短了！");
		if(mb_strlen($reason,'utf8')>60)			$this->__errormsg ( "理由长度超过限制！");
		if(!$price)                                 $this->__errormsg('请填写修改价位！');
		if(!$orderid)                               $this->__errormsg('请填写订单号！');
		$order_detail=$this->order_detail($orderid);
		$before_price=$order_detail[0]['all_price'];
		$data = array (
				'order_id' => $orderid,
				'expert_id' => $e_id,
				'before_price'=>$before_price,
				'after_price' => $price,
				'addtime' =>   date('Y-m-d H:i:s' ,time()),
				'modtime' =>date('Y-m-d H:i:s' ,time()),
				'status' => '0' ,
				'expert_reason' =>	$reason
		);
		$row=$this->db->query("select id from u_order_price_apply where expert_id='{$e_id}' and order_id='{$orderid}' and status=0")->row_array();
		
		if(count($row)==0)
		{  //新增一条申请记录
			$this->db->insert('u_order_price_apply',$data);
			$or_id = $this->db->insert_id ();
			if($or_id)
			{
				$expert_row=$this->F_expert_detail($e_id);
				$datas = array(
						'order_id' => $orderid,
						'op_type' => 1,
						'userid' => $e_id,
						'content' => '管家' . $expert_row['nickname'] . '修改了订单价格,由' . $before_price . '元修改为' . $price . '元,修改原因:' . $reason ,
						'addtime' => date ( 'Y-m-d H:i:s' )
				);
				$this->db->insert ( 'u_member_order_log', $datas );
				echo json_encode(array('code'=>2000 ,'msg' =>'修改价格已提交，等待供应商处理！'));
			}
			else
			{
				$this->__errormsg('修改价格提交失败1！');
			}
		}
		else
		{  //修改原来申请记录
			$data=array(
					'before_price'=>$before_price,
					'after_price' => $price,
					'expert_reason' =>	$reason,
					'modtime'=>date("Y-m-d H:i:s")
			);
			$this->load->model('app/u_order_price_apply_model','u_order_price_apply');
			$status=$this->u_order_price_apply->update($data,array('id'=>$row['id']));
			if($status)
			{
				$expert_row=$this->F_expert_detail($e_id);
				$datas = array(
						'order_id' => $orderid,
						'op_type' => 1,
						'userid' => $e_id,
						'content' => '管家' . $expert_row['nickname'] . '修改了订单价格,由' . $before_price . '元修改为' . $price . '元,修改原因:' . $reason ,
						'addtime' => date ( 'Y-m-d H:i:s' )
				);
				$this->db->insert ( 'u_member_order_log', $datas );
				echo json_encode(array('code'=>2000 ,'msg' =>'修改价格已提交，等待供应商处理！'));
			}
			else 
			   $this->__errormsg('修改价格提交失败2！');
			
		}
	}
	/**
	 * @name：管家个人中心-》定制抢单->供管家抢单的定制
	 * @author: 温文斌
	 * @param: number=凭证；orderid=订单ID
	 * @return:
	 *
	 */
	
	public function E_customize_grab() {
		$token = $this->input->post ( 'number', true );
		$page=$this->input->post("page",true);
		$content=$this->input->post("content",true);
		
		$this->expert_check_token ( $token );
		$e_id = $this->F_get_eid($token);
		//$e_id="1";
		//$content="日本";
		//分页数据
		$page_size="6";
		if(!$page) $page="1"; //默认第一页
		$from = ($page - 1) * $page_size;
		
		//模糊搜索
		$where="";
		if(!empty($content)&&$content)
		{
			$where .=" where ( A.endplace_CH like'%{$content}%' or A.startplace_CH like'%{$content}%')";
		}
		
		$sql="
			select * from (select
					c.id,c.startplace,c.endplace,c.addtime,(select GROUP_CONCAT(cityname) from u_startplace where FIND_IN_SET(id,c.startplace)>0) as startplace_CH,
				   (select GROUP_CONCAT(kindname) from u_dest_cfg where FIND_IN_SET(id,c.endplace)>0) as endplace_CH
		    from
					u_customize as c
					LEFT JOIN u_customize_dest AS cd ON c.id=cd.customize_id
			where 
					c.status=0 AND c.user_type=0 AND c.id not in(SELECT customize_id FROM u_customize_answer WHERE replytime is null and expert_id='{$e_id}')
					and cd.dest_id IN (SELECT ed.dest_id FROM u_expert_dest AS ed WHERE ed.expert_id={$e_id})
			group by c.id
			order by c.addtime desc) as A {$where}
		";
		$sql_page=$sql." limit {$from},{$page_size}";
		
		$result = $this->db->query ( $sql_page )->result_array ();
		$total_nums=$this->db->query($sql)->num_rows(); //景点评论
		$output['page']=$page;
		$output['page_size']=$page_size;
		$output['total_rows']=$total_nums;
		$total_page= ceil($total_nums/$page_size);
		$output['total_page']=$total_page;
		$output['result']=$result;
	    
		if(!empty($content))
		{
			$all['result'] = $this->db->query ( $sql)->result_array ();
			$this->__outmsg ( $all );
		}
		else
		$this->__outmsg ( $output );
	}
	/**
	 * @name：管家个人中心-》定制列表
	 * @author: 温文斌
	 * @param: number=凭证；orderid=订单ID
	 * @return:
	 *
	 */
	
	public function E_customize_list() {
    	$token = $this->input->post ( 'number', true );
		$page=$this->input->post("page",true);
		$code=$this->input->post("code",true);
		$content=$this->input->post("content",true);
		
		$this->expert_check_token ( $token );
		$e_id = $this->F_get_eid($token);
		//$e_id="1";
		//$code="3";
		//$content="日本";
		if(!$code||!is_numeric($code))  $this->__errormsg('param missing');
		//分页数据
		$page_size="6";
		if(!$page) $page="1"; //默认第一页
		$from = ($page - 1) * $page_size;
		
		$code_where="";
		if($code=="1") //已投标
			$code_where.="ca.expert_id={$e_id} AND c.user_type=0 AND ca.isuse=0 AND ca.replytime is null";
		elseif($code=="2") //已中标
			$code_where.="ca.expert_id={$e_id} AND c.user_type=0 AND ca.isuse=1 AND c.is_assign=1 and (c.status=1 or c.status=3)";
		elseif($code=="3") //已过期
		$code_where.="ca.expert_id={$e_id} AND c.user_type=0 AND c.is_assign=1 and (c.status=-2 or c.status=-3)";
		//模糊搜索
		$where="";
		if(!empty($content)&&$content)
		{
			$where .=" where ( A.endplace_CH like'%{$content}%' or A.startplace_CH like'%{$content}%')";
		}
		
		$sql="
			  select * from (SELECT 
			  		  ca.id,c.id as customise_id,ca.addtime,c.startplace,c.endplace,(select GROUP_CONCAT(cityname) from u_startplace where FIND_IN_SET(id,c.startplace)>0) as startplace_CH,
				   (select GROUP_CONCAT(kindname) from u_dest_cfg where FIND_IN_SET(id,c.endplace)>0) as endplace_CH
			 FROM 
			 			u_customize_answer AS ca 
			 			LEFT JOIN u_customize AS c ON ca.customize_id=c.id 
			 WHERE 
			 			{$code_where}
			 			
			  ORDER BY  ca.addtime desc) as A {$where}
		";
		$sql_page=$sql." limit {$from},{$page_size}";
		
		$result = $this->db->query ( $sql_page )->result_array ();
		$total_nums=$this->db->query($sql)->num_rows(); //景点评论
		$output['page']=$page;
		$output['page_size']=$page_size;
		$output['total_rows']=$total_nums;
		$total_page= ceil($total_nums/$page_size);
		$output['total_page']=$total_page;
		$output['result']=$result;
		$output['code']=$code;
	    
		if(!empty($content))
		{
			$all['result'] = $this->db->query ( $sql)->result_array ();
			$all['code']=$code;
			$this->__outmsg ( $all );
		}
		else
		$this->__outmsg ( $output );
	}
	
	/**
	 * @name：管家个人中心-》定制详情
	 * @author: 温文斌
	 * @param: number=凭证；cid=定制单ID 
	 * @return:
	 *
	 */
	
	public function E_customize_detail() 
	{
		$token = $this->input->post ( 'number', true );
		$this->expert_check_token ( $token );
		$c_id = $this->input->post ( 'cid', true );
		if( !$c_id )  $this->__errormsg ( 'param missing' );
		$sql = "
				SELECT 
						c.id AS c_id,c.startdate,c.budget,c.hotelstar,c.trip_way,CASE WHEN c.isshopping=1 THEN '有购物' WHEN c.isshopping=0 THEN '无购物' END shop_status,
						(select GROUP_CONCAT(kindname) from u_dest_cfg where FIND_IN_SET(id,c.endplace) >0 )as endplace,c.days,c.people,
						c.childnum,c.childnobednum,c.oldman,d.description AS play_method,d.description AS hotel_status,c.service_range,
						c.other_service 
				FROM 
						u_customize AS c 
						LEFT JOIN u_dictionary AS d ON c.hotelstar=d.dict_id 
				WHERE 
						c.id={$c_id}
				";
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		$this->__outmsg ( $result );
	}
	/**
	 * @name：管家个人中心-》抢单时“简单回复”
	 * @author: 温文斌
	 * @param: number=凭证；cid=定制单ID
	 * @return:
	 *
	 */
	
	public function E_customize_answer()
	{
		$token = $this->input->post ( 'number', true );
		$c_id = $this->input->post ( 'cid', true ); //定制单id
		$answer_content = $this->input->post ( 'answer_content', true ); //抢单时“简单回复”
		//$c_id="477";
		//$answer_content="我这里有合适的行程哦";
		$this->expert_check_token ( $token );
		$e_id=$this->F_get_eid($token);
		//$e_id="1";
		if( !$c_id || !is_numeric($c_id) )  $this->__errormsg ( '定制单id传入有误' );
		if(empty($answer_content))  $this->__errormsg ( '回复内容不能为空' );
		$data=array(
			'customize_id'=>$c_id,
			'expert_id'=>$e_id,
			'plan_design'=>$answer_content,
			'addtime'=>date('Y-m-d H:i:s'),
			'isuse'=>'0',
			'status'=>'1'	
		);
		$one=$this->db->query("select id from u_customize_answer where customize_id={$c_id} and expert_id={$e_id} and isuse=0 and status=1")->num_rows();
		if($one>0)
		{
			$this->__errormsg('回复失败，该定制已投过标');
		}
		else 
		{
			$status=$this->db->insert("u_customize_answer",$data);
			if($status)
				$this->__data(array('msg'=>'回复已提交'));
		}
	
	}

	/**
	 * @name：管家中心：修改密码
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function E_set_password() 
	{
		$token = $this->input->post ( 'number', true );
		$old_password = $this->input->post ( 'old_password', true );
		$new_password=$this->input->post ( 'new_password', true );
		$new_password2=$this->input->post ( 'new_password2', true );
		
		$this->expert_check_token ( $token );
		$e_id = $this->F_get_eid($token);
		if(!$new_password||!$new_password2)
			$this->__errormsg ( 'param missing' );

		$data ['password'] = $new_password = md5 ( $new_password );
		$new_password2 = md5 ( $new_password2 );
		if ($new_password2 != $new_password)
		  $this->__errormsg ( '两次密码输入不一致' );
		
		$query = $this->db->query ( "select password from u_expert where id={$e_id}" );
		$user = $query->result_array ();
		if ($user) 
		{
			if ($user [0] ['password'] == md5 ( $old_password )) 
			{
				$where = array (	'id' => $e_id );
				$status = $this->db->update ( 'u_expert', $data, $where );
				if ($status) 
				{
					$this->__data(array('msg'=>'密码修改成功！'));
				} 
				else 
				{
					$this->__errormsg ( '密码修改失败！' );
				}
			} 
			else 
			{
				$this->__errormsg ( '用户原密码错误！' );
			}
		} 
		else 
		{
			$this->__errormsg ( '用户不存在！' );
		}
	}
	
	/**
	 * @name：管家个人中心：忘记密码
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function E_forget_password() {
		$data ['mobile'] = $this->input->post ( 'mobile', true ); //手机
		$code = $this->input->post ( 'code', true );	//验证码
		$new_password = $this->input->post ( 'new_password', true );	//新密码
		$new_password2 = $this->input->post ( 'new_password2', true );	//新密码2
		if(!$code||!$new_password||!$new_password2)  
			$this->__errormsg ( 'param missing' );
		if ($new_password2 != $new_password) 
			$this->__errormsg ( '两次密码输入不一致' );
			
		$code_mobile = $data ['mobile'];
		$this->load->library ( 'session' );
		$code_number = $this->session->userdata ( 'code' );
		if (($code_mobile == $data ['mobile']) && ($code_number == $code)) 
		{
			$data ['password'] = md5 ( $new_password );
			$where = array (
					'mobile' => $data ['mobile'] 
			);
			$status = $this->db->update ( 'u_expert', $data, $where );
			if ($status) {
				$this->__data(array('msg'=>'重设密码成功！'));
			} else {
				$this->__errormsg ( '重设密码失败，请重试' );
			}
		} else {
			$this->__errormsg ( '验证码输入错误' );
		}
	}
	
	/**
	 * @name：没申请的售卖线路
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function E_no_apply_line() {
		
		$page = intval ( $this->input->post ( 'page', true ) );
		$page_size = intval ( $this->input->post ( 'pagesize', true ) );
		$linename = $this->input->post ( 'linename', true ); // 线路名字
		$token = $this->input->post ( 'number', true );
		
		$this->expert_check_token ( $token );
		$e_id = $this->F_get_eid($token);
		//$e_id="1";
		//$linename="八一";
		
		//$sid = $this->input->post ( 'supplier_id', true ); // 供应商
		//$startcity = $this->input->post ( 'startcity', true ); // 出发地
		//$overcity = $this->input->post ( 'overcity', true ); // 目的地
		
		
		$page_size = empty ( $page_size ) ? 6 : $page_size;
		$page = $page == '0' ? 1 : $page;
		$from = ($page - 1) * $page_size;
		$where="";
		
		//if ($sid) 
		//$where .= "AND `supplier_id` = {$sid}";
		
		//if($startcity)
		//$where .= "and l.startcity in ({$startcity}) ";
		
		//if($overcity)
		//$where .= "and ( find_in_set({$overcity} ,l.overcity) ) ";
     
		if (!empty($linename))
		$where .= " AND l.linename like '%{$linename}%'";

		$sql = "         
		                 SELECT 
		                         l.id as line_id,l.linename,l.linetitle,l.mainpic,l.all_score,l.peoplecount,l.sell_direction,l.satisfyscore,
		                          GROUP_CONCAT(st.cityname) AS start_city
		                        
		                 FROM 
		                         u_line as l  
		                         left join u_line_startplace as ls on l.id=ls.line_id  
		                         left join u_startplace as st ON ls.startplace_id=st.id     
		                 where   
		                          l.id NOT IN( SELECT line_id FROM u_line_apply as la WHERE la.expert_id ={$e_id} and la.status!=4) 
		                          {$where}   AND l.status = 2 and l.producttype=0  
		                GROUP BY l.id   
		                ORDER BY l.addtime desc";
		$sql_page=$sql." limit {$from},{$page_size}";
		
		$line_apply_list = $this->db->query ( $sql_page )->result_array ();
		//处理满意度
		foreach ( $line_apply_list as $key => $val ) {		
			foreach ( $val as $k => $v ) {
				if ($k == "satisfyscore") {
					if ($v) {
						$val [$k] = (round ( $v,2) * 100).'%' ;
					}
				}
			}
			$line_apply_list [$key] = $val;
		}
		
		$total_nums=$this->db->query($sql)->num_rows(); //
		$output['page']=$page;
		$output['page_size']=$page_size;
		$output['total_rows']=$total_nums;
		$total_page= ceil($total_nums/$page_size);
		$output['total_page']=$total_page;
		$output['result']=$line_apply_list;
		 
		if(!empty($linename))
		{
			$all['result'] = $this->db->query ( $sql)->result_array ();
			$this->__outmsg ( $all );
		}
		else
			$this->__outmsg ( $output );
		
	}
	
	/**
	 * @name：管家已申请线路
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function E_apply_line() 
	{
		$page = intval ( $this->input->post ( 'page', true ) );
		$page_size = intval ( $this->input->post ( 'pagesize', true ) );
		$linename = $this->input->post ( 'linename', true ); // 线路名字
		
		$token = $this->input->post ( 'number', true );
		$this->expert_check_token ( $token );
		$e_id = $this->F_get_eid($token);
		//$e_id="1";
		//$linename="2";
		
		//$sid = $this->input->post ( 'supplier_id', true ); // 供应商
		//$startcity = $this->input->post ( 'startcity', true ); // 出发地
		//$overcity = $this->input->post ( 'overcity', true ); // 目的地
		//$grade = $this->input->post ( 'grade', true ); // 管家搜索
		
		$page_size = empty ( $page_size ) ? 6 : $page_size;
		$page = $page == '0' ? 1 : $page;
		$from = ($page - 1) * $page_size;
		
		$where="";
		//if ($sid) 
		//$where .= "AND `supplier_id` = {$sid}";

		//if ($linename) 			
		//$where .= " AND `l`.`linename` like '%{$linename}%'";

		//if ($grade)
		//$where .= " AND `la`.`grade` = {$grade} ";
		
		if (!empty($linename))
			$where .= " AND l.linename like '%{$linename}%'";
		
		$sql = "      SELECT 
		                      la.id,l.id as line_id,l.linename,l.linetitle, l.mainpic,g.title as grade,
		                   	  GROUP_CONCAT(st.cityname) AS start_city,l.satisfyscore,l.peoplecount,l.lineprice,
		                   	  (select status from u_expert_upgrade where expert_id=la.expert_id and line_id=la.line_id and status='1')as status
		                   	  
		             FROM     
		                     u_line_apply AS la  
		                     left join u_expert_grade as g on g.id=la.grade
		                     LEFT JOIN u_line AS l ON la.line_id = l.id   
		                     LEFT JOIN u_supplier as s ON l.supplier_id =s.id  
		                     left join u_line_startplace as ls on l.id=ls.line_id  
		                     LEFT JOIN u_startplace as st ON ls.startplace_id=st.id      	
		            WHERE    
		                    la.status = 2 and l.status=2	{$where}	AND l.producttype = 0 	AND la.expert_id = {$e_id}	 
		            GROUP BY 
		                     l.id  
		            ORDER BY la.addtime desc     
		            ";
		$sql_page=$sql." limit {$from},{$page_size}";
		$line_apply_list= $this->db->query ( $sql_page )->result_array();
		foreach ( $line_apply_list as $key => $val ) {
			foreach ( $val as $k => $v ) {
				if ($k == "satisfyscore") {
					if ($v) {
						$val [$k] = (round ( $v,2) * 100).'%' ;
					}
				}
				
			}
			if($val['status']=="1")
				$val['status_CH']="申请中";
			else
			    $val['status_CH']="未申请中";
				
			$line_apply_list [$key] = $val;
		}
		
		$total_nums=$this->db->query($sql)->num_rows(); //
		$output['page']=$page;
		$output['page_size']=$page_size;
		$output['total_rows']=$total_nums;
		$total_page= ceil($total_nums/$page_size);
		$output['total_page']=$total_page;
		$output['result']=$line_apply_list;
		 
		if(!empty($linename))
		{
			$all['result'] = $this->db->query ( $sql)->result_array ();
			$this->__outmsg ( $all );
		}
		else
			$this->__outmsg ( $output );
	}
	/**
	 * @name：（未申请的售卖线路、已申请的售卖线路） 共用的详情页面
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function E_apply_line_detail()
	{
		$token = $this->input->post ( 'number', true );
		$lineId = intval ( $this->input->post ( 'id', true ) );
		//$lineId="1137";
		$this->expert_check_token ( $token );
		if(!is_numeric ($lineId) || !$lineId)
			$this->__errormsg('param missing');
		$output=$this->F_line_detail_more($lineId);
		$this->__outmsg ( $output );
	}
	/**
	 * @name：申请售卖
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function E_expert_grade()
	{
		$result=$this->db->query("select * from u_expert_grade where title!='管家'")->result_array();
		$this->__data($result);
	}
	/**
	 * @name：公共的列表都在这里：如银行卡列表
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function E_public_list()
	{
		$result['bank']=$this->db->query("select id,name,pic from u_bank_alipay where isopen=1 order by showorder")->result_array();
		$this->__data($result);
	}
	/**
	 * @name：申请售卖
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function E_apply_to_sale()
	{
		$line_id = $this->input->post ( 'line_id' );
		$token = $this->input->post ( 'number', true );
		$this->expert_check_token ( $token );
		$e_id = $this->F_get_eid($token);
	    //$e_id="1";
	    //$line_id="953";
	
		if(!is_numeric($line_id)||!$line_id)  $this->__errormsg('param missing');
	    $this->load->model ( 'line_apply_model', 'line_apply' );
		$post_arr = array ();
		$insert_data ['line_id'] = $line_id;
		$insert_data ['expert_id'] = $e_id;
		$insert_data ['grade'] = 1;
		$insert_data ['addtime'] = date ( 'Y-m-d H:i:s' );
		$insert_data ['modtime'] = date ( 'Y-m-d H:i:s' );
		$insert_data ['status'] = 2;  //不需审核，直接通过
		// 判断一下是否已经有了数据,不重复插入
		$row_nums=$this->line_apply->num_rows(array('line_id'=>$line_id,'expert_id'=>$e_id,'status !='=>'4'));
		
		$this->db->trans_begin ();
		if ($row_nums>0) {
			$this->line_apply->update ( $insert_data, array('line_id'=>$line_id,'expert_id'=>$e_id) );
			$this->insert_expert_dest ( $line_id, $e_id );
		} else {
			$this->line_apply->insert( $insert_data );
			$this->insert_expert_dest ( $line_id, $e_id );
		}
		
		$this->db->trans_complete();//事务结束
		if ($this->db->trans_status () === TRUE) {
			$this->db->trans_commit ();
			$this->__outmsg(array('status'=>'ok'));  //成功返回数据
		} else {
			$this->db->trans_rollback (); // 事务回滚
			$this->__errormsg('操作异常');
		}
		
	}
	 /**
	 * 根据线路ID插入 expert_dest 管家服务目的地表
	 */
	private function insert_expert_dest($line_id,$expert_id)
	{
		$overcity = array();
		$get_line_dest_sql = 'SELECT overcity2 FROM u_line WHERE id='.$line_id;
		$line_query = $this->db->query($get_line_dest_sql);
		$line_res = $line_query->result_array();
		if(!empty($line_res)){
			$overcity = explode(',',rtrim($line_res[0]['overcity2'],','));
			foreach ($overcity as $key => $value) {
				$is_exist_sql = 'select count(*) isexist from u_expert_dest where dest_id='.$value.' and expert_id='.$expert_id;
				$is_exist_res = $this->db->query($is_exist_sql)->result_array();
				if($is_exist_res[0]['isexist']<=0){
					$get_dest_pid_sql = 'SELECT pid FROM u_dest_cfg WHERE id='.$value;
					$result = $this->db->query($get_dest_pid_sql)->result_array();
					if(empty($result[0]['pid'])){	$pid='2'	;}else{	$pid=$result[0]['pid'];	}
					$insert_expert_dest_sql = 'INSERT INTO u_expert_dest(expert_id,dest_id,dest_pid,status) VALUES('.$expert_id.','.$value.','.$pid.',1)';
					$this->db->query($insert_expert_dest_sql);
				}
			}
		}
	}
	/**
	 * @name：售卖升级
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	public function E_grade_promote()
	{
		$line_apply_id = $this->input->post ( 'line_apply_id' );  //u_line_apply表id
		$grade = $this->input->post ( 'grade' );  //管家级别
		$token = $this->input->post ( 'number', true );
		$this->expert_check_token ( $token );
		$e_id = $this->F_get_eid($token);
		//$e_id="1";
		//$line_apply_id="1631";
		//$grade="2";
	    
		if(!is_numeric($line_apply_id)||!$line_apply_id) $this->__errormsg('param missing');
		if(!is_numeric($grade)||!$grade) $this->__errormsg('param missing');
		
		$this->load->model ( 'line_apply_model', 'line_apply' );
		$this->load->model ( 'expert_upgrade_model', 'expert_upgrade' );
		$one=$this->line_apply->row(array('id'=>$line_apply_id));
		
		$insert_data ['line_id'] = $one['line_id'];
		$insert_data ['expert_id'] = $e_id;
		$insert_data ['grade_before'] = $one['grade'];
		$insert_data ['grade_after'] = $grade;
		$insert_data ['addtime'] = date ( 'Y-m-d H:i:s' );
		$insert_data ['modtime'] = date ( 'Y-m-d H:i:s' );
		$insert_data ['status'] = 1;
		// 判断一下是否已经有了数据,不重复插入
		$exist=$this->expert_upgrade->num_rows(array('line_id'=>$one['line_id'],'expert_id'=>$e_id,'status'=>'1'));
		if ($exist > 0) {
			$this->__errormsg('不能重复申请');
		} else {
			$status=$this->expert_upgrade->insert( $insert_data );
			if($status)
				$this->__data(array('msg'=>'申请成功'));
			else 
				$this->__errormsg('申请失败');
		}
		
	}
	/**
	 * @name：放弃线路
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function E_give_up_line() {
		$line_id = $this->input->post ( 'line_id' );
		$token = $this->input->post ( 'number', true );
		$this->expert_check_token ( $token );
		$e_id = $this->F_get_eid($token);
		$sql = "update u_line_apply set status=4 where line_id=$line_id and expert_id={$e_id}";
		if ($this->db->query ( $sql ))
		{
			echo json_encode ( array (
					'code' => 2000,
					'msg' => '操作成功'
			) );
		}
		else
		{
			echo json_encode ( array (
					'code' => 4000,
					'msg' => '操作失败'
			) );
		}
		//end
	}
	/**
	 * @name：所有的供应商列表
	 * @author: 温文斌
	 * @param: number=凭证；data
	 * @return:
	 *
	 */
	
	public function E_apply_supplier() 
	{
		$token = $this->input->post ( 'number', true );
		$this->expert_check_token ( $token );
		
		$this->load->model ( 'admin/b2/line_apply_model', 'line_apply' );
		$suppliers = $this->line_apply->get_suppliers ();
		$data = array (
				'suppliers' => $suppliers 
		);
		$this->__outmsg ( $data );
	}
	/**
	 * @name：管家个人中心->我的客户
	 * @author: 温文斌
	 * @param: code=状态,page=当前页数；content=模糊搜索内容
	 * @return:经典列表、国家列表
	 *
	 */
	
	public function E_my_user() 
	{
		$token = $this->input->post ( 'number', true );
		$page=$this->input->post("page",true);
		$content = $this->input->post ( 'content', true ); //模糊搜索
	    
		//$this->expert_check_token ( $token );
		$e_id = $this->F_get_eid($token);
		$e_id="1";
		//$content="晓燕"; 
		
		//分页数据
		$page_size="6";
		if(!$page) $page="1"; //默认第一页
		$from = ($page - 1) * $page_size;
	
		//模糊搜索
		$where="";
		if(!empty($content)&&$content)
		{
			$where.=" and ( m.mobile like '%{$content}%' or m.nickname like '%{$content}%')";
		}
	
		$sql = "
				select 
						count(1) as order_num,mo.memberid,mo.addtime,sum(mo.total_price+mo.settlement_price) as all_price,
						m.mobile,m.nickname
			    from
						u_member_order as mo
						left join u_member as m on mo.memberid=m.mid
				where  
					    mo.status>0 and mo.ispay>1 and mo.expert_id='{$e_id}' {$where}
				group by mo.memberid
				   
				";
		$sql_page=$sql." limit {$from},{$page_size}";
	
		$reDataArr = $this->db->query ( $sql_page )->result_array ();
	
		$total_nums=$this->db->query($sql)->num_rows(); //景点评论
		$output['page']=$page;
		$output['page_size']=$page_size;
		$output['total_rows']=$total_nums;
		$total_page= ceil($total_nums/$page_size);
		$output['total_page']=$total_page;
		$output['result']=$reDataArr;
	 
		if(!empty($content))
		{
				$all['result'] = $this->db->query ( $sql)->result_array ();
				$this->__outmsg ( $all );
		}		
		else
		$this->__outmsg ( $output );
	}
	/**
	 * @name：管家个人中心->我的投诉
	 * @author: 温文斌
	 * @param: code=状态,page=当前页数；content=模糊搜索内容
	 * @return:经典列表、国家列表
	 *
	 */
		
	public function E_my_complain()
	{
		$token = $this->input->post ( 'number', true );
		$page=$this->input->post("page",true);
		$code=$this->input->post("code",true);
		$content = $this->input->post ( 'content', true ); //模糊搜索
	
		$this->expert_check_token ( $token );
		$e_id = $this->F_get_eid($token);
		//$e_id="1";
		//$code="0";
		//$content="me";

		if($code!="0"&&$code!="1"&&$code!="2")  $this->__errormsg('param missing');
		//分页数据
		$page_size="6";
		if(!$page) $page="1"; //默认第一页
		$from = ($page - 1) * $page_size;
	
		//模糊搜索
		$where="";
		if($code=="1")
		{
			$where.=" and c.status=0"; //未处理投诉
		}
		elseif($code=="2")
		{
			$where.=" and c.status=1"; //已处理投诉
		}
		
		if(!empty($content)&&$content)
		{
			$where.=" and ( mo.productname like '%{$content}%' or m.nickname like '%{$content}%')";
		}
	
		$sql = "
				select 
				       c.id,c.reason,c.remark,c.addtime,c.status,case when c.status=0 then '未处理' when c.status=1 then '已处理' end as status_CH,
				       mo.id as order_id,mo.productname,mo.productautoid,m.nickname,m.mobile
				from 
						u_complain as c 
				        left join u_member_order as mo on mo.id=c.order_id
				        left join u_member as m on m.mid=mo.memberid
				where 
						FIND_IN_SET(1,c.complain_type)>0 and mo.expert_id='{$e_id}' {$where}
	            order by 
	            		c.addtime desc
		";
		$sql_page=$sql." limit {$from},{$page_size}";
	
		$reDataArr = $this->db->query ( $sql_page )->result_array ();
	
		$total_nums=$this->db->query($sql)->num_rows(); //景点评论
		$output['page']=$page;
		$output['page_size']=$page_size;
		$output['total_rows']=$total_nums;
		$total_page= ceil($total_nums/$page_size);
		$output['total_page']=$total_page;
		$output['result']=$reDataArr;
			
		if(!empty($content))
			{
				$all['result'] = $this->db->query ( $sql)->result_array ();
		$this->__outmsg ( $all );
		}
			else
		$this->__outmsg ( $output );
	}
	/**
	 * @name：管家个人中心->我的评论
	 * @author: 温文斌
	 * @param: code=状态,page=当前页数；content=模糊搜索内容
	 * @return:经典列表、国家列表
	 *
	 */
		
	public function E_my_comment()
	{
		$token = $this->input->post ( 'number', true );
		$page=$this->input->post("page",true);
		$content = $this->input->post ( 'content', true ); //模糊搜索
	
		$this->expert_check_token ( $token );
		$e_id = $this->F_get_eid($token);
		//$e_id="1";
		//$content="日本";
	
		//分页数据
		$page_size="6";
		if(!$page) $page="1"; //默认第一页
		$from = ($page - 1) * $page_size;
	
		//模糊搜索
		$where="";

		if(!empty($content)&&$content)
		{
			$where.=" and ( mo.productname like '%{$content}%')";
		}
	
		$sql = "
				select
							c.id,c.content,c.expert_content,c.avgscore1 as line_score,c.avgscore2 as expert_score,c.addtime,
							mo.id as order_id,mo.productname,mo.productautoid
				from
						    u_comment as c
							left join u_member_order as mo on mo.id=c.orderid
							
				where
							 mo.expert_id='{$e_id}' {$where}
				order by
							c.addtime desc
		";
		$sql_page=$sql." limit {$from},{$page_size}";
	
		$reDataArr = $this->db->query ( $sql_page )->result_array ();
	
		$total_nums=$this->db->query($sql)->num_rows(); //景点评论
		$output['page']=$page;
		$output['page_size']=$page_size;
		$output['total_rows']=$total_nums;
		$total_page= ceil($total_nums/$page_size);
		$output['total_page']=$total_page;
						$output['result']=$reDataArr;
							
		if(!empty($content))
		{
	        $all['result'] = $this->db->query ( $sql)->result_array ();
			$this->__outmsg ( $all );
		}
		else
		$this->__outmsg ( $output );
	}
	
	/**
	 * @name：管家注册->验证第一页（境内、境外）
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function E_expert_register_p1()
	{
		$this->load->library ( 'session' );
		$login_name = $this->input->post ( 'login_name', true ); // 登录名
		$password = $this->input->post ( 'password', true ); // 密码
		$reg_type = $this->input->post ( 'reg_type', true ); // 境内外
		$code = $this->input->post ( 'code', true ); // 验证码
	
		if ($reg_type == 1) {
			// =1为境内
			$code_mobile = $this->session->userdata ( 'mobile' );
			$code_number = $this->session->userdata ( 'code' );
			if (! preg_match ( "/1[34578]{1}\d{9}$/", $login_name )) {
				$this->__errormsg ( '手机号码错误！' );
			}
			if (empty ( $code_mobile )) {
				$this->__errormsg ( '请获取验证码! ' );
			}
		} else {
			$kk = $this->session->userdata ( 'email_code' );
			$code_number = $kk ['code'];
			$code_mobile = $kk ['email'];
			if (! preg_match ( "/^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/", $login_name )) {
				$this->__errormsg ( '邮箱错误！' );
			}
			if (empty ( $code_number )) {
				$this->__errormsg ( '请获取验证码!' );
			}
		}
	
		if (($code_mobile == $login_name) && ($code_number == $code)) {
			echo json_encode ( array (
					'code' => 2000,
					'msg' => 'ok!'
			) );
		} else {
			$this->__errormsg ( '验证码错误！' );
		}
	}
	/**
	 * @name：管家注册-》根据城市获得上门服务区域（境内）
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function E_get_area()
	{
		$cityid = $this->input->post ( 'city', true ); // 城市id
		if(!$cityid)  $this->__errormsg ( 'city is null !' );
		$query = $this->db->query ( "select * from u_area where pid={$cityid}" );
		$output= $query->result_array();
		$this->__outmsg ( $output );
	}
	/**
	 * @name：管家注册->验证第二页（境内）
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function E_expert_register_p2()
	{
		$nickname = $this->input->post ( 'nickname', true ); // 用户昵称
		$sex = $this->input->post ( 'sex', true ); // 性别
		$small_photo = $this->input->post ( 'icon_photo', true ); // 头像
		$realname = $this->input->post ( 'realname', true ); // 真实姓名
	
		$idcard = $this->input->post ( 'idcard', true ); // 身份证号码
		$idcardpic = $this->input->post ( 'idcardpic', true ); // 证件正面照片
		$noidcardpic = $this->input->post ( 'noidcardpic', true ); // 证件反面照片
	
		$email = $this->input->post ( 'email', true ); // 电子邮箱
		$this_door = $this->input->post ( 'this_door', true ); // 上门服务
		$city = $this->input->post ( 'city', true ); // 所属城市
		$expert_dest = $this->input->post ( 'expert_dest', true ); // 擅长路线
		$talk = $this->input->post ( 'talk', true ); // 个人描述 (150字)
	
		$talklen = strlen ( $talk );
		$query = $this->db->query ( "select nickname from u_expert where nickname='{$nickname}'" );
		$expert_rows= $query->num_rows();
	
		if (empty ( $nickname )) 				{$this->__errormsg ( '请填写昵称' );}
		if ($expert_rows>0) 				    {$this->__errormsg ( '昵称已被占用，请重新输入' );}
		if ($sex!='1'&&$sex!='0') 				{$this->__errormsg ( '请选择性别' );}
		if (empty ( $small_photo )) 			{$this->__errormsg ( '请上传头像' );}
		if (empty ( $realname )) 				{$this->__errormsg ( '请填写真实姓名' );}
	
		if (empty ( $idcard )) 					{$this->__errormsg ( '身份证号不能为空' );}
		$this->load->helper ( 'regexp' );
		if (! regexp ( 'cid', $idcard )) 		{$this->__errormsg ( "请输入正确的身份证号" );}
		if (empty ( $idcardpic )) 				{$this->__errormsg ( '请上传身份证正面照片' );}
		if (empty ( $noidcardpic )) 				{$this->__errormsg ( '请上传身份证反面照片' );}
	
		if (!empty ( $email ))
		{
			if (! preg_match ( "/^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/", $email )) {
				$this->__errormsg ( '邮箱错误' );
			}
				
			$sql = "select id,status from u_expert where (email='{$email}' or login_name='{$email}') and status!=3 order by id desc";
			$row= $this->db->query ( $sql )->result_array ();
			if(!empty($row))
				$this->__errormsg ( '所填邮箱已被注册，请重新填写' );
		}
		if (empty ( $city )) 					{$this->__errormsg ( '请选择所属城市' );}
		if (empty ( $expert_dest )) 			{$this->__errormsg ( '请选择擅长路线！' );}
		if (empty ( $this_door )) 			{$this->__errormsg ( '请选择上门服务' );}
		if (empty ( $talk )) 					{$this->__errormsg ( '请填写个人描述' );						 }
		if ($talklen < 6 || $talklen > 150) 	{$this->__errormsg ( '请填写6到150字以内的个人简介');}
		echo json_encode ( array ('code' => 2000,'msg' => 'ok!' ) );
	}
	/**
	 * @name：管家注册->验证第二页（境外）
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function E_expert_register_p2_out()
	{
		$nickname = $this->input->post ( 'nickname', true ); // 用户昵称
		$sex = $this->input->post ( 'sex', true ); // 性别
		$small_photo = $this->input->post ( 'icon_photo', true ); // 头像
		$realname = $this->input->post ( 'realname', true ); // 真实姓名
	
		$idcard_type = $this->input->post ( 'idcard_type', true ); // 证件类型
		$idcard = $this->input->post ( 'idcard', true ); // 证件号码
		$idcardpic = $this->input->post ( 'idcardpic', true ); // 证件正面照片
		$noidcardpic = $this->input->post ( 'noidcardpic', true ); // 证件反面照片
	
		$mobile = $this->input->post ( 'moblie', true ); // 手机号码
		$city = $this->input->post ( 'city', true ); // 所属城市
		$this_door = $this->input->post ( 'this_door', true ); // 上门服务
		$expert_dest = $this->input->post ( 'expert_dest', true ); // 擅长路线
		$talk = $this->input->post ( 'talk', true ); // 个人描述 (150字)
	
		$talklen = strlen ( $talk );
		$query = $this->db->query ( "select nickname from u_expert where nickname='{$nickname}'" );
		$expert_rows= $query->num_rows();
	
		if (empty ( $nickname )) 				{$this->__errormsg ( '请填写昵称' );}
		if ($expert_rows>0) 				    {$this->__errormsg ( '昵称已被占用，请重新输入' );}
		if ($sex!='1'&&$sex!='0')  			    { $this->__errormsg ( '请填写性别' );}
		if (empty ( $small_photo )) 			{$this->__errormsg ( '请上传头像' );}
		if (empty ( $realname )) 				{$this->__errormsg ( '请填写真实姓名' );}
	
		if (empty ( $idcard_type )) 			{$this->__errormsg ( '证件类型不能为空' ); }
		if (empty ( $idcard )) 					{$this->__errormsg ( '证件号不能为空' );}
		if (empty ( $idcardpic )) 				{$this->__errormsg ( '请上传证件正面照片' );}
		if (empty ( $noidcardpic )) 			{$this->__errormsg ( '请上传证件反面照片' );}
	
		$this->load->helper ( 'regexp' );
		if (empty($mobile)) 	                {$this->__errormsg ( "请输入手机号码" );}
		if (! regexp ( 'mobile', $mobile )) 		{$this->__errormsg ( "请输入正确的手机号码" );}
		else
		{
			$sql = "select id,status from u_expert where (mobile='{$mobile}' or login_name='{$mobile}') and status!=3 order by id desc";
			$row= $this->db->query ( $sql )->result_array ();
			if(!empty($row))
				$this->__errormsg ( '所填手机号码已被注册，请重新填写');
		}
		if (empty ( $city )) 				    {$this->__errormsg ( '请选择所属城市' );	}
		if ($this_door!='1'&&$this_door!='0')	{$this->__errormsg ( '请选择上门服务' );	}
		if (empty ( $expert_dest )) 			{$this->__errormsg ( '请选择擅长路线！' ); }
		if (empty ( $talk )) 					{$this->__errormsg ( '请填写个人描述！' );}
		if ($talklen < 6 || $talklen > 150) 	{$this->__errormsg ( '请填写6到150字以内的个人简介！' );}
		echo json_encode( array ('code' => 2000,'msg' => 'ok!' ) );
	}
	
	/**
	 * @name：管家注册->提交注册信息
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function E_expert_register() {
		$this->load->library ( 'session' );
		$callback = empty($_REQUEST["callback"]) ? '' : $_REQUEST['callback'];
		$noCheckCode = $this->input->post ( 'noCheckCode', true ); // 是否需要"验证码"验证，true为不需要，false为需要，默认为fasle
		//1、传值 （第一个页面）
		$login_name =isset($_REQUEST['login_name'])?$_REQUEST['login_name']:''; // 登录名
		$password = isset($_REQUEST['password'])?$_REQUEST['password']:''; // 密码
		$reg_type = isset($_REQUEST['reg_type'])?$_REQUEST['reg_type']:''; // 境内外
		$code = isset($_REQUEST['code'])?$_REQUEST['code']:''; // 验证码
		//2、传值 （第二个页面）
		$nickname = isset($_REQUEST['nickname'])?$_REQUEST['nickname']:''; // 用户昵称
		$sex = isset($_REQUEST['sex'])?$_REQUEST['sex']:''; // 性别
		$small_photo = isset($_REQUEST['icon_photo'])?$_REQUEST['icon_photo']:''; // 头像
		$realname = isset($_REQUEST['realname'])?$_REQUEST['realname']:''; // 真实姓名
	
		$idcardtype = isset($_REQUEST['idcard_type'])?$_REQUEST['idcard_type']:''; // 证件类型
		$idcard = isset($_REQUEST['idcard'])?$_REQUEST['idcard']:''; // 证件号（身份证号码）
		$idcardpic = isset($_REQUEST['idcardpic'])?$_REQUEST['idcardpic']:''; // 身份证扫描正面
		$noidcardpic = isset($_REQUEST['noidcardpic'])?$_REQUEST['noidcardpic']:''; // 身份证扫描反面
	
		$email = isset($_REQUEST['email'])?$_REQUEST['email']:''; // 电子邮箱
		$phone = isset($_REQUEST['phone'])?$_REQUEST['phone']:''; // 手机号
		$weixin = isset($_REQUEST['weixin'])?$_REQUEST['weixin']:''; // 微信号
		$city = isset($_REQUEST['city'])?$_REQUEST['city']:''; // 所属城市
		$this_door = isset($_REQUEST['this_door'])?$_REQUEST['this_door']:''; // 上门服务
		$expert_dest = isset($_REQUEST['expert_dest'])?$_REQUEST['expert_dest']:''; // 擅长路线
		$talk = isset($_REQUEST['talk'])?$_REQUEST['talk']:''; // 个人描述 (150字)
		$museum = isset($_REQUEST['museum'])?$_REQUEST['museum']:''; // 照相馆
		$certificate = isset($_REQUEST['certificate'])?$_REQUEST['certificate']:''; // -- 证书名称
	
		//3、传值（第三个页面）
		$school = isset($_REQUEST['school'])?$_REQUEST['school']:''; // 毕业院校
		$lycy = isset($_REQUEST['lycy'])?$_REQUEST['lycy']:''; // 旅游从业
		$year = isset($_REQUEST['year'])?$_REQUEST['year']:''; // 工作年限
		$jobs = isset($_REQUEST['jobs'])?$_REQUEST['jobs']:''; // --所在企业
	
		//处理字段
		if(!empty($small_photo )){ $small_photo= $small_photo ;}else{$small_photo='';}
		if(!empty($idcardpic )){ $idcardpic= $idcardpic ;}else{$idcardpic='';}
		if(!empty($noidcardpic )){ $noidcardpic= $noidcardpic ;}else{$noidcardpic='';}
		if(!empty($unidcardpic )){ $unidcardpic= $unidcardpic ;}else{$unidcardpic='';}
	
	
		$email_code_number = $this->session->userdata ( 'email_code' );
		$code_number = $this->session->userdata ( 'code' );
	
		//if (empty ( $email_code_number ) && empty ( $code_number ) && $noCheckCode == true) {	$this->__errormsg ( '长时间未操作，请重新填写'.$noCheckCode );}
		//4、第三个页面： 验证
		if (empty ( $school )) 		{$this->__wapmsg( '请选择毕业院校' ,$callback);}
		if (empty ( $lycy )) 	    {$this->__wapmsg ( '请填写旅游从业岗位',$callback );}
		if (empty ( $year )) 		{$this->__wapmsg ( '请选择工作年限',$callback );}
		// 验证旅游从业简历
		if (! empty ( $jobs ) && is_array ( $jobs )) {
			foreach ( $jobs as $k => $v ) {
				if (empty ( $jobs [$k] ['starttime'] ))			{$this->__wapmsg ( '请填写从业经历的起始时间',$callback );}
				if (empty ( $jobs [$k] ['company_name'] ))		{$this->__wapmsg ( '经历处请填写公司名称',$callback );}
				if (empty ( $jobs [$k] ['job'] ))				{$this->__wapmsg ( '请填写职务',$callback );}
				if (empty ( $jobs [$k] ['endtime'] )) 			{$this->__wapmsg ( '请填写从业经历的结束时间',$callback );}
				if (empty ( $jobs [$k] ['description'] ))		{	$this->__wapmsg ( '经历处请填写描述',$callback );}
			}
		} else {
			$this->__wapmsg ( '请添加从业经历',$callback );
		}
	
		//管家唯一性验证
		if($phone)
		{
			$sql = "select id,status from u_expert where (mobile='{$phone}' or login_name='{$phone}') and status!=3 order by id desc";
			$row= $this->db->query ( $sql )->result_array ();
			if(!empty($row))
				$this->__wapmsg ( '所填手机号码已被注册，请重新填写',$callback);
		}
		if($email)
		{
			$sql = "select id,status from u_expert where (email='{$email}' or login_name='{$email}') and status!=3 order by id desc";
			$row= $this->db->query ( $sql )->result_array ();
			if(!empty($row))
				$this->__wapmsg ( '所填邮箱已被注册，请重新填写',$callback);
		}
	
		//5、数据操作
		$this->db->trans_begin ();
		if (! empty ( $city ) && ($city > 1))
		{
			$province = $this->db->query ( "select pid from u_area where id ={$city}" )->result_array ();
			$pro = ($province ['0'] ['pid']);
			if (! empty ( $pro )) {
				$country = $this->db->query ( "select pid from u_area where id ={$pro}" )->result_array ();
				$con = ($country ['0'] ['pid']);
			}
		}
		else
		{
			$pro = 0;
			$con = 0;
		}
		$data = array (
				'type' => $reg_type,
				'nickname' => $nickname,
				'mobile' => is_numeric ( $login_name ) ? $login_name : $phone,
				'login_name' => $login_name,
				'password' => md5 ( $password ),
				'realname' => $realname,
				'sex' => intval ( $sex ),
				'idcardtype' => isset ( $idcardtype ) ? $idcardtype : '',//证件类型
				'idcard' => $idcard,//证件号
				'idcardpic' => $idcardpic,//证件正面
				'idcardconpic'=>$noidcardpic, //证件反面
				'visit_service' => $this_door,
				'email' => empty ( $email ) ? $login_name : $email,
				'weixin' => $weixin,
				'small_photo' => $small_photo,
				'big_photo' => $small_photo,
				'talk' => $talk,
				'province' => $pro,
				'country' => $con,
				'beizhu' => '毕业于' . $school . ';旅游从业岗位：' . $lycy . ';' . intval ( $year ) . '年从业经验',
				'school'=>$school,
				'profession'=>$lycy,
				'working'=>$year,
				'expert_dest' => $expert_dest,
				'city' => isset ( $city ) ? $city : 0,
				'status' => 1,
				'is_limit' => 0,
				'grade' => 1,
				'addtime' => date ( 'Y-m-d H:i:s', time () ),
				'modtime' => date ( 'Y-m-d H:i:s', time () ),
				'isstar' => 0,
				'register_channel'=>APP_VERSION,       //注册渠道app,默认是pc端1，若是app端，则存版本号
				'is_kf'=>'N'   //是否是客服
		);
			
		$this->load->model ( 'common/u_expert_model', 'expert_model' );
		$expertid = $this->expert_model->insert ( $data );
		if (empty ( $expertid )) {
			$this->__wapmsg ( '添加失败，稍后再试',$callback );
		}   //插入u_expert表（管家）
			
		if (! empty ( $jobs ) && is_array ( $jobs )) {
			foreach ( $jobs as $k => $v ) {
				$tour ['expert_id'] = $expertid;
				$tour ['company_name'] = $v ['company_name'];
				$tour ['job'] = $v ['job'];
				$tour ['starttime'] = $v ['starttime'];
				$tour ['endtime'] = $v ['endtime'];
				$tour ['description'] = $v ['description'];
				$tour ['status'] = 1;
				$status = $this->db->insert ( 'u_expert_resume', $tour );
			}
		} else {
			$this->__wapmsg ( '从业信息有误！',$callback );
		}  //插入 u_expert_resume表（就业信息）
	
		if (! empty ( $certificate ) && is_array ( $certificate )) {
			foreach ( $certificate as $k => $v ) {
				$tours ['expert_id'] = $expertid;
				$tours ['certificate'] = $v ['certificate'];
				$tours ['certificatepic'] =  	isset($v ['certificatepic']	)?$v ['certificatepic']:'';
				$tours ['status'] = 1;
				$status = $this->db->insert ( 'u_expert_certificate', $tours );
			}
		} // 插入 u_expert_certificate 表 （荣耀证书）
			
			
		if (! empty ( $museum ))
		{    // 管家关联相馆表
			$this->load->model ( '/common/u_expert_museum_model', 'museum_model' );
			$data = $this->museum_model->all ( array (
					'expert_id' => $expertid
			) );
			if (empty ( $data )) {
				$museum = array (
						'expert_id' => $expertid,
						'museum_id' => $museum,
						'qrcode' => '/file/qrcodes/' . $expertid . '_qr.png',
						'addtime' => date ( 'Y-m-d H:i:s' ),
						'status' => 0
				);
				$expert_museum_id = $this->museum_model->insert ( $museum );
				if (! empty ( $expert_museum_id )) { // 管家二维码关联表
					$qrcode = array (
							'qrcode' => '/file/qrcodes/' . $expertid . '_qr.png',
							'status' => 0,
							'expert_id' => $expertid,
							'expert_museum_id' => $expert_museum_id
					);
					$this->load->model ( '/common/u_expert_qrcode_model', 'qrcode_model' );
					$this->qrcode_model->insert ( $qrcode );
				}
			} else {
				$this->museum_model->update ( array (
						'museum_id' => $museum
				), array (
						'expert_id' => $expertid
				) );
					
			}
	
			$this->get_qrcodes ( $expertid ); // 申请二维码
		}  // 照片二维码
			
			
		//6、返回结果
		if ($this->db->trans_status () === FALSE)
		{
			$this->db->trans_rollback ();
			$this->__wapmsg('操作异常',$callback);
		}
		else
		{
			$this->db->trans_commit ();
			//echo json_encode ( array ('code' => 2000,'msg' => 'ok' ) );
			$this->__wap(array ('code' => 2000,'msg' => 'ok' ),$callback);
		}
		// END
	}
	/**
	 * @name：修改管家注册信息：显示页面
	 * @author: 温文斌
	 * @param: number=凭证
	 * @return:
	 *
	 */
	
	public function E_update_expert_register()
	{
		$m_id = $this->input->post ( 'eid', true ); //管家id
	    //$m_id ="1";
		if(empty($m_id))
			$this->__errormsg('mid is null');
		$sql = "select
		e.id,e.login_name,e.realname,e.nickname,e.mobile,e.email,e.qq,e.idcardtype,e.idcard,e.sex,e.small_photo,e.small_photo as true_small_photo,e.big_photo,e.big_photo as true_big_photo,e.weixin,
		e.idcardpic,e.idcardpic as true_idcardpic,e.idcardconpic,e.idcardconpic as true_idcardconpic,e.city,us.cityname,e.talk,em.qrcode,m.id as museum_id,m.name as museum_name,m.address as museum_address,
		e.beizhu,e.type,e.school,e.profession,e.working,
		(select GROUP_CONCAT(d.kindname) from u_dest_cfg as d where FIND_IN_SET(d.id,e.expert_dest)) as expert_dest_name,e.expert_dest,
		(select GROUP_CONCAT(a.name) from u_area as a where FIND_IN_SET(a.id,e.visit_service)) as visit_service_name,e.visit_service
		from
		u_expert as e
		left join u_startplace as us on us.id=e.city
		left join u_expert_museum as em on em.expert_id=e.id
		left join u_museum as m on m.id=em.museum_id
		where
		e.id={$m_id}";
		$query = $this->db->query ( $sql );
		$reDataArr = $query->row_array ();
		//性别
		if($reDataArr['sex']=='0')
		{
		$reDataArr['sex_name']="女";
		}
		else if($reDataArr['sex']=='1')
		{
		$reDataArr['sex_name']="男";
		}
		else
		{
			$reDataArr['sex_name']="保密";
		}
		//国内国外
		if($reDataArr['type']=='1')
		{
			$reDataArr['type_name']="境内";
		}
		elseif($reDataArr['type']=='2')
		{
			$reDataArr['type_name']="境外";
		}
		//大学，专业，年
		
		$reDataArr['school']=$reDataArr['school'];
		$reDataArr['zhuanye']=$reDataArr['profession'];
		$reDataArr['year']=$reDataArr['working'];
		//工作经历
		$reDataArr['work'] = $this->db->query ( "select * from u_expert_resume where expert_id={$m_id}")->result_array ();
		//证书
		$reDataArr['certificate'] = $this->db->query ( "select id,certificate,certificatepic,certificatepic as true_certificatepic from u_expert_certificate where expert_id={$m_id}")->result_array ();
	
		if (empty ( $reDataArr )) 						{$this->__errormsg ();	}			//为空输出
		$this->__outmsg ( $reDataArr );																//为实输出
	}
	/**
	* @name：修改管家注册信息：提交数据处理
	* @author: 温文斌
	* @param:
	* @return:
	*
	*/
	
	public function E_update_expert_deal()
	{
		$callback = empty($_REQUEST["callback"]) ? '' : $_REQUEST['callback'];
		//1、当前登录管家id
		$m_id =isset($_REQUEST['eid'])?$_REQUEST['eid']:''; // 管家id
		//2、传值 （第二个页面）
		$nickname = isset($_REQUEST['nickname'])?$_REQUEST['nickname']:''; // 用户昵称
		$sex = isset($_REQUEST['sex'])?$_REQUEST['sex']:''; // 性别
		$small_photo = isset($_REQUEST['icon_photo'])?$_REQUEST['icon_photo']:''; // 头像
		$realname = isset($_REQUEST['realname'])?$_REQUEST['realname']:''; // 真实姓名
		
		$idcardtype = isset($_REQUEST['idcard_type'])?$_REQUEST['idcard_type']:''; // 证件类型
		$idcard = isset($_REQUEST['idcard'])?$_REQUEST['idcard']:''; // 证件号（身份证号码）
		$idcardpic = isset($_REQUEST['idcardpic'])?$_REQUEST['idcardpic']:''; // 身份证扫描正面
		$noidcardpic = isset($_REQUEST['noidcardpic'])?$_REQUEST['noidcardpic']:''; // 身份证扫描反面
		
		$email = isset($_REQUEST['email'])?$_REQUEST['email']:''; // 电子邮箱
		$phone = isset($_REQUEST['phone'])?$_REQUEST['phone']:''; // 手机号
		$weixin = isset($_REQUEST['weixin'])?$_REQUEST['weixin']:''; // 微信号
		$city = isset($_REQUEST['city'])?$_REQUEST['city']:''; // 所属城市
		$this_door = isset($_REQUEST['this_door'])?$_REQUEST['this_door']:''; // 上门服务
		$expert_dest = isset($_REQUEST['expert_dest'])?$_REQUEST['expert_dest']:''; // 擅长路线
		$talk = isset($_REQUEST['talk'])?$_REQUEST['talk']:''; // 个人描述 (150字)
		$talklen = strlen ( $talk );
		$museum = isset($_REQUEST['museum'])?$_REQUEST['museum']:''; // 照相馆
		$certificate = isset($_REQUEST['certificate'])?$_REQUEST['certificate']:''; // -- 证书名称
	
		//3、传值（第三个页面）
		$school = isset($_REQUEST['school'])?$_REQUEST['school']:''; // 毕业院校
		$lycy = isset($_REQUEST['lycy'])?$_REQUEST['lycy']:''; // 旅游从业
		$year = isset($_REQUEST['year'])?$_REQUEST['year']:''; // 工作年限
		$jobs = isset($_REQUEST['jobs'])?$_REQUEST['jobs']:''; // --所在企业
	
		// 3.5、第二个页面：验证
			//昵称不能重复
		$expert_arr= $this->db->query ( "select nickname from u_expert where nickname='{$nickname}'")->row_array();
		$expert_arr_my= $this->db->query ( "select nickname from u_expert where id='{$m_id}'")->row_array();
		$expert_rows=count($expert_arr);
		if (empty ( $nickname )) 				{$this->__wapmsg( '请填写昵称',$callback);}
		if ($expert_rows>0&&$expert_arr_my['nickname']!=$nickname) {$this->__wapmsg ( '昵称已被占用，请重新输入',$callback );}

		if ($sex!='1'&&$sex!='0') 				{$this->__wapmsg ( '请选择性别',$callback );}
		if (empty ( $small_photo )) 			{$this->__wapmsg ( '请上传头像',$callback );}
		if (empty ( $realname )) 				{$this->__wapmsg ( '请填写真实姓名',$callback );}

		if($idcardtype=="")
		{
			if (empty ( $idcard )) 					{$this->__wapmsg ( '身份证号不能为空' ,$callback);}
			$this->load->helper ( 'regexp' );
			if (! regexp ( 'cid', $idcard )) 		{$this->__wapmsg ( "请输入正确的身份证号" ,$callback);}
		}
		else
		{
			if (empty ( $idcard )) 					{$this->__wapmsg ( '证件号不能为空',$callback );}
		}
		if (empty ( $idcardpic )) 				{$this->__wapmsg ( '请上传身份证正面照片',$callback );}
		if (empty ( $noidcardpic )) 				{$this->__wapmsg ( '请上传身份证反面照片',$callback );}

		if (!empty ( $email ))
		{
			if (! preg_match ( "/^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/", $email )) 
			{
				$this->__wapmsg ( '邮箱错误',$callback );
			}
		}
		if (empty ( $city )) 					{$this->__wapmsg ( '请选择所属城市' ,$callback);}
		if (empty ( $expert_dest )) 			{$this->__wapmsg ( '请选择擅长路线！',$callback );}
		if ($this_door=="") 			{$this->__wapmsg ( '请选择上门服务' ,$callback);}
		if (empty ( $talk )) 					{$this->__wapmsg ( '请填写个人描述',$callback );						 }
		if ($talklen < 6 || $talklen > 150) 	{$this->__wapmsg ( '请填写6到150字以内的个人简介',$callback);}
	
		//4、第三个页面： 验证
		if (empty ( $school )) 		{$this->__wapmsg ( '请选择毕业院校',$callback );}
		if (empty ( $lycy )) 	    {$this->__wapmsg ( '请填写旅游从业岗位',$callback );}
		if (empty ( $year )) 		{$this->__wapmsg ( '请选择工作年限' ,$callback);}
		// 验证旅游从业简历
		if (! empty ( $jobs ) && is_array ( $jobs )) 
		{
				foreach ( $jobs as $k => $v ) 
				{
					if (empty ( $jobs [$k] ['starttime'] ))			{$this->__wapmsg ( '请填写从业经历的起始时间' ,$callback);}
					if (empty ( $jobs [$k] ['company_name'] ))		{$this->__wapmsg ( '经历处请填写公司名称',$callback );}
					if (empty ( $jobs [$k] ['job'] ))				{$this->__wapmsg ( '请填写职务',$callback );}
					if (empty ( $jobs [$k] ['endtime'] )) 			{$this->__wapmsg ( '请填写从业经历的结束时间',$callback );}
					if (empty ( $jobs [$k] ['description'] ))		{	$this->__wapmsg ( '经历处请填写描述' ,$callback);}
				}
		} 
		else 
		{
						$this->__wapmsg ( '请添加从业经历',$callback );
		}
	
		//管家唯一性验证
		if($phone)
		{
			$sql = "select id,email,mobile,status from u_expert where (mobile='{$phone}' or login_name='{$phone}') and status!=3 order by id desc";
			$row= $this->db->query ( $sql )->result_array ();
			if(!empty($row)&&$row[0]['id']!=$m_id)
			$this->__wapmsg ( '所填手机号码已被注册，请重新填写',$callback);
		}
		if($email)
		{
			$sql = "select id,email,mobile,status from u_expert where (email='{$email}' or login_name='{$email}') and status!=3 order by id desc";
			$row= $this->db->query ( $sql )->result_array ();
			if(!empty($row)&&$row[0]['id']!=$m_id)  //不能重复存在
			$this->__wapmsg ( '所填邮箱已被注册，请重新填写',$callback);
		}
	
		//5、数据操作
		$this->db->trans_begin ();
		if (! empty ( $city ) && ($city > 1))
		{
			$province = $this->db->query ( "select pid from u_area where id ={$city}" )->result_array ();
			$pro = ($province ['0'] ['pid']);
			if (! empty ( $pro )) 
			{
			$country = $this->db->query ( "select pid from u_area where id ={$pro}" )->result_array ();
			$con = ($country ['0'] ['pid']);
			}
		}
		else
		{
			$pro = 0;
			$con = 0;
		}
		$data = array (
			'nickname' => $nickname,
			'realname' => $realname,
			'sex' => intval ( $sex ),
			'idcard' => $idcard,//证件号
			'idcardpic' => $idcardpic,//证件正面
			'idcardconpic'=>$noidcardpic, //证件反面
			'visit_service' => $this_door,
			'weixin' => $weixin,
			'small_photo' => $small_photo,
			'big_photo' => $small_photo,
			'talk' => $talk,
			'province' => $pro,
			'country' => $con,
			'beizhu' => '毕业于' . $school . ';旅游从业岗位：' . $lycy . ';' . intval ( $year ) . '年从业经验',
			'school'=>$school,
			'profession'=>$lycy,
			'working'=>$year,
			'expert_dest' => $expert_dest,
			'city' => isset ( $city ) ? $city : 0,
			'modtime' => date ( 'Y-m-d H:i:s', time () ),
			'status'=>'1'
		);
		if(!empty($phone))
	       $data['mobile']=$phone;
	    if(!empty($email))
		  $data['email']=$email;
		if(!empty($idcardtype))
		  $data['idcardtype']=$idcardtype;
		       				
		$this->load->model ( 'common/u_expert_model', 'expert_model' );
		$this->load->model ( 'common/u_expert_resume_model', 'expert_resume_model' );
		$this->load->model ( 'common/u_expert_certificate_model', 'expert_certificate_model' );
	
		$update_row = $this->expert_model->update($data,array('id'=>$m_id)); //更新expert表
		if ($update_row=='0') {
				//$this->__errormsg ( '提交失败，稍后再试'.$m_id );
		}
		//6、工作经历
		if (! empty ( $jobs ) && is_array ( $jobs ))
		{
			foreach ( $jobs as $k => $v ) 
			{
	
				$resume_data ['company_name'] = $v ['company_name'];
				$resume_data ['job'] = $v ['job'];
				$resume_data ['starttime'] = $v ['starttime'];
				$resume_data ['endtime'] = $v ['endtime'];
				$resume_data ['description'] = $v ['description'];
	
				$one=$this->expert_resume_model->row(array('id'=>@$v['job_id'],'expert_id'=>$m_id));
				if(empty($one))
				{   //插入
						$resume_data ['expert_id']=$m_id;
						$resume_data ['status']='1';
						$status = $this->expert_resume_model->insert($resume_data);
				}
				else
				{  //更新
							$status = $this->expert_resume_model->update($resume_data,array('id'=>@$v['job_id'],'expert_id'=>$m_id));
				}
			  }
		  } 
		  else 
		  {
				$this->__wapmsg ( '从业信息有误！',$callback );
		  }  //插入、更新 u_expert_resume表（就业信息）
		  				 
		// 7、荣誉证书
		if (! empty ( $certificate ) && is_array ( $certificate )) 
			{
				$a="";
				foreach ( $certificate as $k => $v ) 
				{
					//更新数据
					$cert_data ['certificate'] = $v ['certificate'];
					$cert_data ['certificatepic'] =  	isset($v ['true_certificatepic']	)?$v ['true_certificatepic']:'';
					$one=$this->expert_certificate_model->row(array('id'=>@$v['id'],'expert_id'=>$m_id));
					if(empty($one))
					{   //插入
	
						$cert_data ['expert_id']=$m_id;
						$cert_data ['status']='1';
						$status = $this->expert_certificate_model->insert($cert_data);
					}
					else
					{
						//更新	
						$status = $this->expert_certificate_model->update($cert_data,array('id'=>@$v['id'],'expert_id'=>$m_id));
					}
				}
			} // 插入、更新 u_expert_certificate 表 （荣耀证书）
						
			//8、管家关联相馆表
			if (! empty ( $museum ))
			{
				$this->load->model ( '/common/u_expert_museum_model', 'museum_model' );
				$data = $this->museum_model->all ( array ('expert_id' => $m_id) );
				if (empty ( $data ))
				{
					$museum = array (
								'expert_id' => $m_id,
								'museum_id' => $museum,
								'qrcode' => '/file/qrcodes/' . $m_id . '_qr.png',
								'addtime' => date ( 'Y-m-d H:i:s' ),
								'status' => 0
							);
					$expert_museum_id = $this->museum_model->insert ( $museum );
					if (! empty ( $expert_museum_id )) 
					{ // 管家二维码关联表
							$qrcode = array (
									'qrcode' => '/file/qrcodes/' . $m_id . '_qr.png',
									'status' => 0,
									'expert_id' => $m_id,
									'expert_museum_id' => $expert_museum_id
										);
							$this->load->model ( '/common/u_expert_qrcode_model', 'qrcode_model' );
							$this->qrcode_model->insert ( $qrcode );
					}
					$this->get_qrcodes ( $m_id ); // 申请二维码
			    }
				else
				{
					//更新
					$this->museum_model->update ( array ('museum_id' => $museum), array ('expert_id' => $m_id) );
				}
			} // 照片二维码
	
			//9、返回结果
			if ($this->db->trans_status () === FALSE)
			{
				$this->db->trans_rollback ();
				$this->__wapmsg('操作异常',$callback);
			}
			else
			{
				$this->db->trans_commit ();
				//echo json_encode ( array ('code' => 2000,'msg' => 'ok','cert'=>$certificate) );
				$this->__wap(array('code' => 2000,'msg' => 'ok','cert'=>$certificate),$callback);
			}
			// END
		}
	
}

/* End of file webservices.php */
/* Location: ./application/controllers/webservices.php */