<?php
/**
 * @method 		管家注册，修改，添加
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015-10-29
 * @author		jiakairong
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CommonExpert extends MY_Controller {
	protected $expertArr; //管家资料
	protected $time;
	
	public function __construct($expertArr) {
		parent::__construct();
		$this ->expertArr = $this->security->xss_clean($expertArr);
		//过滤前后的空格
		foreach($this->expertArr as $key=>$val) {
			if (is_array($this->expertArr[$key])) {
				continue;
			}
			$this->expertArr[$key] = trim($val);
		}
		$this ->time = time();
		$this ->load_model('common/u_expert_model','expert_model');
		$this ->load_model('/common/u_expert_certificate_model' ,'certificate_model');
		$this ->load_model('/common/u_expert_resume_model' ,'resume_model');
		$this ->load_model('/common/u_expert_museum_model' ,'museum_model');
		$this ->load_model('/common/u_expert_qrcode_model' ,'qrcode_model');
		$this->load->library('callback');
	}
	//内部管家注册，没有手机验证码
	public function expertRegisterInsert() {
		try {
			if (!isset($this->expertArr['isAgree']) || $this ->expertArr['isAgree'] != 1) {
				throw new Exception('请您阅读并同意管家服务总则');
			}
			if ($this->expertArr['type'] == 1 || $this->expertArr['type'] == 2) {
				//验证图形验证码
				if (strtolower($this->expertArr['code']) != strtolower($this->session->userdata('captcha'))) {
					throw new Exception('图形验证码不正确');
				}
				$this ->isCommonData('add');
					
				$this->db->trans_begin();
	
				//写入管家数据
				$expertArr = $this ->getExpertArr();
				$expertid = $this ->expert_model ->insert($expertArr);
				if (empty($expertid)) {
					throw new Exception('注册失败，稍后再试');
				}
				//从业经历
				$this ->upExpertResume($expertid);
	
				//管家申请照相
				$this->upExpertMuseum($expertid);
				//session 存放管家id
				$this ->session ->set_userdata(array('upExpertId'=>$expertid));
	
				if ($this->expertArr['type'] == 1) {
					//荣耀证书
					$this ->upExpertCertificate($expertid);
				}
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					throw new Exception('注册失败，稍后再试');
				}
				else {
					$this->db->trans_commit();
					$this->callback->set_code ( 2000 ,$expertid);
					$this->callback->exit_json();
				}
			}
			else {
				throw new Exception('请选择管家类型');
			}
		} catch (Exception $e) {
			$this->callback->set_code ( 4000 ,$e ->getMessage());
			$this->callback->exit_json();
		}
	
	}
	
	//管家注册
	public function expertRegisterCom() {
		try {
			if (!isset($this->expertArr['isAgree']) || $this ->expertArr['isAgree'] != 1) {
				throw new Exception('请您阅读并同意管家服务总则');
			}
			if ($this->expertArr['type'] == 1 || $this->expertArr['type'] == 2) {
				if ($this->expertArr['type'] == 1) {
					//验证手机短信
					$this ->isMobileCode();
				} else {
					//验证邮箱验证码
					$this ->isEmailCode();
				}
				
				$this ->isCommonData('add');
			
				$this->db->trans_begin();
		
				//写入管家数据
				$expertArr = $this ->getExpertArr();
				$expertid = $this ->expert_model ->insert($expertArr);
				if (empty($expertid)) {
					throw new Exception('注册失败，稍后再试');
				}
				//从业经历
				$this ->upExpertResume($expertid);
				
				//管家申请照相
				$this->upExpertMuseum($expertid);
				//session 存放管家id
				$this ->session ->set_userdata(array('upExpertId'=>$expertid));
				
				if ($this->expertArr['type'] == 1) {
					//荣耀证书
					$this ->upExpertCertificate($expertid);
				} 
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					throw new Exception('注册失败，稍后再试');
				}
				else {
					$this->db->trans_commit();
					$this->callback->set_code ( 2000 ,$expertid);
					$this->callback->exit_json();
				}
			} 
			else {
				throw new Exception('请选择管家类型');
			}
		} catch (Exception $e) {
			$this->callback->set_code ( 4000 ,$e ->getMessage());
			$this->callback->exit_json();
		}
		
	}
	/*生成二维码*/
	function get_qrcodes($id){
		$this->load->library('ciqrcode');
		$params['data'] = base_url().'admin/b2/register/upExpertMuseum?id='.$id;
		$params['level'] = 'H';
		$params['size'] = 12;
		$params['savename'] = FCPATH.'file/qrcodes/guanjiaid_'.$id.'.png';
		$this->ciqrcode->generate($params);
		//echo '<img src="'.base_url().'file/qrcodes/guanjiaid.png" />';
		$logo = FCPATH.'file/qrcodes/logo.png';//准备好的logo图片
		//echo FCPATH;
		$QR = base_url().'file/qrcodes/guanjiaid_'.$id.'.png';//已经生成的原始二维码图
		if ($logo !== FALSE) {
			$QR = imagecreatefromstring(file_get_contents($QR));
			$logo = imagecreatefromstring(file_get_contents($logo));
			$QR_width = imagesx($QR);//二维码图片宽度
			$QR_height = imagesy($QR);//二维码图片高度
			$logo_width = imagesx($logo);//logo图片宽度
			$logo_height = imagesy($logo);//logo图片高度
			$logo_qr_width = $QR_width/ 5;//
			$scale = $logo_width/$logo_qr_width;
			$logo_qr_height = $logo_height/$scale;//
			$from_width = ($QR_width - $logo_qr_width) /2;
			//重新组合图片并调整大小
			imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,$logo_qr_height, $logo_width, $logo_height);
		}
		imagepng($QR, FCPATH.'file/qrcodes/'.$id.'_qr.png');
		//	echo '<img src="'.base_url().'file/qrcodes/guanjiaid_qr.png">';
	}
	//管家资料完善
	public function expertDataPerfect() {
		try {
			if (!isset($this->expertArr['isAgree']) || $this ->expertArr['isAgree'] != 1) {
				throw new Exception('请您阅读并同意管家服务总则');
			}
			if ($this->expertArr['type'] == 1 || $this->expertArr['type'] == 2) {
				if ($this->expertArr['type'] == 1) {
					//验证手机短信
					$this ->isMobileCode();
				} else {
					//验证邮箱验证码
					$this ->isEmailCode();
				}
		
				$this ->isCommonData('edit');
		
				$this->db->trans_begin();
				//写入管家数据
				$expertArr = $this ->getExpertArr();
				$status = $this ->expert_model ->update($expertArr ,array('id' =>intval($this->expertArr['expert_id'])));
				if (empty($status)) {
					throw new Exception('完善信息失败，稍后再试');
				}
				//删除管家的荣誉证书以及从业经历
				$this ->deleteInfo($this->expertArr['expert_id']);
				//从业经历
				$this ->upExpertResume($this->expertArr['expert_id']);
		
				//管家申请照相
				$this->upExpertMuseum($this->expertArr['expert_id']);
				
				if ($this->expertArr['type'] == 1) {
					//荣耀证书
					$this ->upExpertCertificate($this->expertArr['expert_id']);
				}
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					throw new Exception('完善信息失败，稍后再试');
				}
				else {
					$this->db->trans_commit();
					$this->callback->set_code ( 2000 ,'完善信息失败成功');
					$this->callback->exit_json();
				}
			}
			else {
				throw new Exception('请选择管家类型');
			}
		} catch (Exception $e) {
			$this->callback->set_code ( 4000 ,$e ->getMessage());
			$this->callback->exit_json();
		}
		
	}
	
	//平台添加管家
	public function addAExpert() {
		try {
 			if ($this->expertArr['type'] == 1 || $this->expertArr['type'] == 2) {
	
				$this ->isCommonData('add');
	
				$this->db->trans_begin();
				
				//写入管家数据
				$expertArr = $this ->getExpertArr();
				$expertid = $this ->expert_model ->insert($expertArr);
				if (empty($expertid)) {
					throw new Exception('添加失败，稍后再试');
				}
				//从业经历
				$this ->upExpertResume($expertid);
	
				if ($this->expertArr['type'] == 1) {
					//荣耀证书
					$this ->upExpertCertificate($expertid);
				}
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					throw new Exception('添加失败，稍后再试');
				}
				else {
					$this->db->trans_commit();
					$this->callback->set_code ( 2000 ,'添加成功');
					$this->callback->exit_json();
				}
			}
			else {
				throw new Exception('请选择管家类型');
			} 
		} catch (Exception $e) {
			$this->callback->set_code ( 4000 ,$e ->getMessage());
			$this->callback->exit_json();
		}
	
	}
	
	//删除管家的附属信息，荣誉证书，从业经历
	private function deleteInfo($expert_id) {
		$this ->certificate_model ->delete(array('expert_id' =>$expert_id));
		$this ->resume_model ->delete(array('expert_id' =>$expert_id));
	}
	
	//获取保存管家信息的数组
	private function getExpertArr() {
		//获取地区最上级 
		$this->load_model('common/u_area_model' ,'area_model');
		$areaData = $this ->area_model ->row(array('id' =>$this->expertArr['province']));
		if (empty($areaData)) {
			$country = 0;
		} else {
			$country = $areaData['pid'];
		}
		return array(
				'type' =>$this->expertArr['type'],
				'mobile' =>$this->expertArr['mobile'],
				'login_name' =>$this->expertArr['mobile'],
				'password' =>md5($this->expertArr['password']),
				'realname' =>$this->expertArr['realname'],
				'sex' =>intval($this->expertArr['sex']),
				'idcard' =>$this->expertArr['idcard'],
				'idcardpic' =>$this->expertArr['idcardpic'],
				'idcardconpic' =>$this->expertArr['idcardconpic'],
				'email' =>$this->expertArr['email'],
				'weixin' =>$this->expertArr['weixin'],
				'small_photo' =>$this->expertArr['photo'],
				'big_photo' =>$this->expertArr['big_photo'],
				'talk' =>$this->expertArr['talk'],
				'school' =>$this ->expertArr['school'],
				'profession' =>$this ->expertArr['job_name'],
				'working' =>intval($this ->expertArr['year']),
				'expert_dest' =>rtrim($this->expertArr['expert_dest'] ,','),
				'visit_service' =>$this->expertArr['visit_service'],
				'province' =>$this->expertArr['province'],
				'city' =>isset($this->expertArr['city']) ? $this->expertArr['city'] : 0,
				'country' =>$country,
				'status' =>1,
				'is_limit' =>0,
				'grade' =>1,
				'addtime' =>date('Y-m-d H:i:s',$this->time),
				'modtime' =>date('Y-m-d H:i:s',$this->time),
				'isstar' =>0,
				'nickname' =>$this->expertArr['nickname'],
				'idcardtype' =>isset($this->expertArr['idcardtype'])?$this->expertArr['idcardtype']:'',
				'depart_id'=>empty($this->expertArr['depart_id'])?'':$this->expertArr['depart_id'],     //营业部
				'expert_type'=>empty($this->expertArr['expert_type'])?'0':$this->expertArr['expert_type'], //管家类型
		);
	}
	
	//管家荣耀证书
	private function upExpertCertificate($expert_id) {
		if (!empty($this->expertArr['certificate']) && is_array($this->expertArr['certificate'])) {
			foreach($this->expertArr['certificate'] as $k=>$v) {
				if (empty($this ->expertArr['certificate'][$k]) || empty($this->expertArr['certificatepic'][$k])) {
					continue;
				}
				$certificateArr = array(
						'expert_id' =>$expert_id,
						'certificate' =>$this->expertArr['certificate'][$k],
						'certificatepic' =>$this->expertArr['certificatepic'][$k],
						'status' =>1
				);
				$this ->certificate_model ->insert($certificateArr);
			}
		}
	}
	
	//管家从业经历
	private function upExpertResume($expert_id) {
		if (is_array($this->expertArr['starttime'])) {
			foreach($this->expertArr['starttime'] as $k=>$v) {
				$resumeArr = array(
						'expert_id' =>$expert_id,
						'company_name' =>$this->expertArr['company_name'][$k],
						'job' =>$this->expertArr['job'][$k],
						'starttime' =>$this->expertArr['starttime'][$k],
						'endtime' =>$this->expertArr['endtime'][$k],
						'description' =>$this->expertArr['description'][$k],
						'status' => 1
				);
				$this ->resume_model ->insert($resumeArr);
			}
		}
	}
	//管家申请照片信息
	private function upExpertMuseum($expert_id){
		if ($this->expertArr['expert_museum']>0) {  //管家关联相馆表
			$museum_id=$this->expertArr['expert_museum'];
			$data['resume'] = $this ->museum_model ->all(array('expert_id' =>$expert_id));
			if(empty($data['resume'])){
				$museum['museum_id']=$this->expertArr['expert_museum'];
				$museum['qrcode']='/file/qrcodes/'.$expert_id.'_qr.png';
				$museum['expert_id']=$expert_id;
				$museum['addtime']=date('Y-m-d H:i:s');
				$museum['status']=0;
				$expert_museum_id=$this->museum_model ->insert($museum);
				if(!empty($expert_museum_id)){  //管家二维码关联表
					$qrcode=array(
						'qrcode'=>'/file/qrcodes/'.$expert_id.'_qr.png',
						'status'=>0,
						'expert_id'=>$expert_id,
						'expert_museum_id'=>$expert_museum_id
					);
					$this->qrcode_model->insert($qrcode);
				}
			}else{
			    $this->museum_model ->update(array('museum_id' =>$museum_id) ,array('expert_id' =>$expert_id));
				//$data['resume'] = $this ->resume_model ->all(array('expert_id' =>$id));
			}
			//申请二维码
			$this->get_qrcodes($expert_id);
			
		}

	}
	//境内&境外管家公用的验证
	private function isCommonData($type) {
		
		$this ->isMobileNnique($type);
		$this ->isEmailNnique($type);
		
		//验证密码
		$passlen = strlen($this->expertArr['password']);
		if ($passlen < 6 || $passlen >20) {
			throw new Exception('请填写6到20位的密码');
		} else {
			if ($this->expertArr['password'] != $this->expertArr['repass']) {
				throw new Exception('两次密码输入不一致');
			}
		}
		
		if (empty($this ->expertArr['realname'])) {
			throw new Exception('请填写真实姓名');
		}
		if (empty($this ->expertArr['nickname'])) {
			throw new Exception('请填写昵称');
		} else {
			$nickname=trim($this ->expertArr['nickname']);
			if(preg_match('/[a-zA-Z]/',$nickname)){
				throw new Exception('昵称中不能有字母');
			}
			$query = $this->db->query ( "select nickname from u_expert where nickname='{$nickname}'" );
			$expert_rows= $query->num_rows();
			$sql_query = $this->db->query ( "select nickname from bridge_expert where nickname='{$nickname}' and status=1" );		
			$data=$sql_query->num_rows();
			if(($data>0)||($expert_rows>0)){
				throw new Exception('昵称已存在');
			} 
		}
		if (!isset($this->expertArr['sex']) || ($this->expertArr['sex'] !=0 && $this->expertArr['sex'] != 1)) {
			throw new Exception('请选择性别');
		}
		
		if (empty($this->expertArr['photo'])) {
			throw new Exception('请上传头像');
		}
		
		if (empty($this->expertArr['big_photo'])) {
			throw new Exception('请上传背景图');
		}
		
		if ($this->expertArr['type'] == 1) {
			if (strlen($this->expertArr['idcard']) < 15 || strlen($this->expertArr['idcard']) >18) {
				throw new Exception('请填写正确的身份证号');
			}
			if (empty($this->expertArr['idcardpic'])) {
				throw new Exception('请上传身份证扫描件');
			}
			if (empty($this ->expertArr['idcardconpic'])) {
				throw new Exception('请上传身份证反面');
			}
			if (!isset($this->expertArr['city']) || $this->expertArr['city'] < 1) {
				throw new Exception('请选择所属城市');
			}
			if (empty($this->expertArr['visit_service'])) {
				throw new Exception('请选择上门服务地区');
			} else {
				$this->expertArr['visit_service'] = implode(',',$this->expertArr['visit_service']);
			}
			
			if (!empty($this->expertArr['certificate']) && is_array($this->expertArr['certificate'])) {
				foreach($this->expertArr['certificate'] as $k=>$v) {
					if (!empty($this->expertArr['certificate'][$k]) && empty($this->expertArr['certificatepic'][$k])) {
						throw new Exception('请上传证书片');
					}
				}
			}
			
		} else {
			if (empty($this->expertArr['idcardtype'])) {
				throw new Exception('请填写证件类型');
			}
			if (empty($this->expertArr['idcard'])) {
				throw new Exception('请填写证件号码');
			}
			if (empty($this->expertArr['idcardpic'])) {
				throw new Exception('请上传证件扫描件');
			}
			if (empty($this ->expertArr['idcardconpic'])) {
				throw new Exception('请上传证件反面');
			}
			if ($this->expertArr['province'] < 1) {
				throw new Exception('请选择所在国家');
			}
			if (isset($this->expertArr['visit_service']) && ($this ->expertArr['visit_service'] == 1 || intval($this ->expertArr['visit_service']) == 0)) {
				if ($this->expertArr['visit_service'] == 1) { //提供上门服务,将国家或城市写入上门服务字段中
					$city = isset($this->expertArr['city']) ? $this->expertArr['city'] : 0;
					$this->expertArr['visit_service'] = empty($city) ? $this->expertArr['province'] : $city;
				}
				$this->expertArr['visit_service'] = intval($this->expertArr['visit_service']);
			} else {
				throw new Exception('请选择上门服务');
			}
		}
		if (empty($this->expertArr['expert_dest'])) {
			throw new Exception('请选择擅长线路');
		} else {
			$this->expertArr['expert_dest'] = trim($this->expertArr['expert_dest'] ,',');
		}
		
		if (empty($this->expertArr['talk'])) {
			throw new Exception('请填写个人描述');
		}
		if (empty($this->expertArr['school'])) {
			throw new Exception('请填写毕业院校');
		}
		if (empty($this->expertArr['job_name'])) {
			throw new Exception('请填写岗位名称');
		}
		if (floatval($this->expertArr['year']) <= 0) {
			throw new Exception('请填写工作年限');
		}
		//验证旅游从业简历
		if (empty($this->expertArr['starttime'])) {
			throw new Exception('请添加从业经历');
		} else {
			if (is_array($this->expertArr['starttime'])) {
				
				foreach($this->expertArr['starttime'] as $key =>$val) {
					if (empty($val) || empty($this->expertArr['endtime'][$key])) {
						throw new Exception('请填写从业经历的起止时间');
					} else {
						if ($this->expertArr['endtime'][$key] < $val) {
							throw new Exception('开始时间不可以大于结束时间');
						}
						if (empty($this->expertArr['company_name'][$key])) {
							throw new Exception('经历处请填写公司名称');
						}
						if (empty($this->expertArr['job'][$key])) {
							throw new Exception('经历处请填写职务');
						}
						if (empty($this->expertArr['description'][$key])) {
							throw new Exception('经历处请填写描述');
						}
					}
				}
			}
		}
	}
	
	//短信验证码验证
	private function isMobileCode() {
		$mobileCode = $this ->session ->userdata('register_expert_code');
		if (empty($mobileCode)) {
			throw new Exception('请您先获取手机验证码');
		} else {
			//10分钟过期
			if ($this->time - $mobileCode['send_time'] > 600) {
				$this ->session ->unset_userdata('mobile_code');
				throw new Exception('您的验证码已过期');
			}
			if($mobileCode ['code'] != $this->expertArr['code'] || $mobileCode['mobile'] != $this->expertArr['mobile'] ) {
				throw new Exception('您输入的手机验证码不正确');
			}
		}
	}
	
	//邮箱验证码验证
	private function isEmailCode() {
		$emailCode = $this ->session ->userdata('email_code');
		if (empty($emailCode)) {
			throw new Exception('请您先获取邮箱验证码');
		} else {
			//10分钟过期
			if ($this->time - $emailCode['time'] > 600) {
				$this ->session ->unset_userdata('email_code');
				throw new Exception('您的验证码已过期');
			}
			if($emailCode ['code'] != $this->expertArr['code'] || $emailCode['email'] != $this->expertArr['email'] ) {
				throw new Exception('您输入的邮箱验证码不正确');
			}
		}
	}
	
	//验证手机号是否存在
	private function isMobileNnique ($type) {
		if (empty($this->expertArr['mobile'])) {
			throw new Exception('请填写手机号');
		}
		if ($type == 'add') {//添加
			$expertData = $this ->expert_model ->getMobileUnique($this->expertArr['mobile']);
		} 
		else {//编辑
			$expertData = $this ->expert_model ->getMobileUniqueNo($this->expertArr['mobile'] ,$this->expertArr['expert_id']);
		}
		//echo $this ->db->last_query();
		if (!empty($expertData)) {
			throw new Exception('手机号已存在');
		}
	}
	
	//验证邮箱号是否存在
	private function isEmailNnique ($type) {
		if (empty($this->expertArr['email'])) {
			throw new Exception('请填写邮箱号');
		}
		if ($type == 'add') { //添加
			$expertData = $this ->expert_model ->getEmailUnique($this->expertArr['email']);
		} 
		else { //编辑
			$expertData = $this ->expert_model ->getMobileUniqueNo($this->expertArr['mobile'] ,$this->expertArr['expert_id']);
		}
		if (!empty($expertData)) {
			throw new Exception('邮箱号已存在');
		}
	}
}