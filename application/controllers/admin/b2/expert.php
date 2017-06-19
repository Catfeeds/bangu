<?php
/**
 * 专家个人中心
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月16日18:00:01
 * @author		汪晓烽
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Expert extends UB2_Controller {

	public function __construct() {
		parent::__construct();
		$this->load_model('admin/b2/expert_model', 'expert');
		$this->load_model ( 'admin/a/finance_model', 'finance' );
	}

	/**
	 * 我的资料
	 */
	public function index() {
		$expert_info = $this->expert->row(array(
				'id' => $this->expert_id));
		$data_view = array(
				'expert_info' => $expert_info);
		$this->load_view('admin/b2/expert_index', $data_view);
	}

	/**
	 * 修改我的资料
	 */
	public function update() {
		$data_view['apply_bangu'] = $this->input->get('apply_bangu',true);
		$expert_info = $this->expert->get_expert_list($this->expert_id);
		if(""!=$expert_info['expert_dest']){
			$data_view['expert_dest_arr'] = $this->expert->getDestinationsId(explode(",",$expert_info['expert_dest']));
		}
		//获取国家
		$area_arr =$this->expert->get_alldate('u_area',array('pid' =>0 ,'isopen' =>1));
		//获取地区
		if(!empty($expert_info['country'])){
			$pid=$expert_info['country'];
			$provinceP=$this->expert->get_alldate('u_area',array('id' =>$expert_info['province'] ,'isopen' =>1));
			if(!empty($provinceP[0])){
				$province_arr=$this->expert->get_alldate('u_area',array('pid' =>$provinceP[0]['pid'] ,'isopen' =>1));
			}
		}
		if(!empty($expert_info['province'])){
			// 获取某个地区的名称
			$cityP =$this->expert->get_alldate('u_area',array('id' =>$expert_info['city'] ,'isopen' =>1));
			if(!empty($cityP[0])){
				$city_arr =$this->expert->get_alldate('u_area',array('pid' =>$cityP[0]['pid'] ,'isopen' =>1));
			}
		}
		//var_dump($data['city_arr']);exit;
		if(!empty($expert_info['city'])){
			// 获取某个地区的名称
			$region_arr =$this->expert->get_alldate('u_area',array('pid' =>$expert_info['city'] ,'isopen' =>1));
		}
		if(!empty($area_arr)){
			$data_view['area_arr']= $area_arr;
		}
		if(!empty($province_arr)){
			$data_view['province_arr']= $province_arr;
		}
		if(!empty($city_arr)){
			$data_view['city_arr']= $city_arr;
		}
		if(!empty($region_arr)){
			$data_view['region_arr']= $region_arr;
		}
		//管家从业简历表
		$data_view['expert_resume']=$this->expert->get_alldate('u_expert_resume',array('expert_id'=>$this->expert_id));
		//荣誉证书
		$data_view['expert_certificate']=$this->expert->get_alldate('u_expert_certificate',array('expert_id'=>$this->expert_id));
		//上门服务
		if(!empty($expert_info['visit_service'])){
			$data_view['service']=$this->expert->getLineattr(explode(",",$expert_info['visit_service']));
		}
       	//擅长的目的
        if(!empty($expert_info['expert_dest'])){
			$data_view['dest']=$this->expert->getDestattr(explode(",",$expert_info['expert_dest']));
       	}

		//目的地
		$data_view['destArr'] = $this ->getDestData();
		$data_view['expert_info']= $expert_info;
		$this->load_view('admin/b2/expert_update', $data_view);
	}
	//获取目的地
	public function getDestData()
	{
		$destArr = array();
		$this->load_model('dest/dest_base_model' ,'dest_base_model');
		$destData = $this ->dest_base_model ->all(array('level <=' =>2) ,'level asc');
		if (!empty($destData))
		{
			foreach($destData as $val)
			{
				if ($val['level'] == 1)
				{
					$destArr[$val['id']] = $val;
				}
				elseif ($val['level'] == 2)
				{
					if (array_key_exists($val['pid'], $destArr))
					{
						$destArr[$val['pid']]['lower'][] = $val;
					}
				}
			}
		}
		return $destArr;
	}

	/**
	 * 执行我的资料修改
	 *
	 * @return boolean
	 */
	public function update_expert() {

		$this->load->library ( 'callback' );
		$this->load->library ( 'session' );
		$user_pic=$this ->session ->userdata('user_pic');
		    //邮件验证码
		$email=$this->input->post('email');
		if(!empty($email)){
		     	if (!empty($_POST['code1'])) {
		     		$email_code = $this ->session ->userdata('email_code');
		     		if (empty($email_code)) {
		     			//throw new Exception('请您先获取邮箱验证码');
		     			$this->callback->set_code ( 4000 ,"请您先获取邮箱验证码");
		     			$this->callback->exit_json();
		     		}
		     		$time = time();
		     		//10分钟过期
		     		if ($time - $email_code['time'] > 600) {
		     			$this ->session ->unset_userdata('email_code');
		     			//throw new Exception('您的验证码已过期');
		     			$this->callback->set_code ( 4000 ,"您的验证码已过期");
		     			$this->callback->exit_json();
		     		}

		     		if($email_code ['code'] != $_POST['code1'] || $email_code['email'] != $_POST['email'] ) {
		     			//throw new Exception('您输入的邮箱验证码不正确');
		     			$this->callback->set_code ( 4000 ,"您输入的邮箱验证码不正确");
		     			$this->callback->exit_json();
		     		}
		     	} else {
		     		//throw new Exception('请填写邮箱验证码');
		     		$this->callback->set_code ( 4000 ,"请填写邮箱验证码");
		     		$this->callback->exit_json();
		     	}
		     	$post_array['email']=$email;
		     }

		     $expert_resume['starttime']=$this->input->post('job_name');
		     $expert_resume['endtime']=$this->input->post('year');
		     $expert_resume['company_name']=$this->input->post('company_name');
		     $expert_resume['job']=$this->input->post('job');
		     $expert_resume['description']=$this->input->post('description');
		    //管家信息
		    $post_array=$this->expert->row(array('id'=>$this->expert_id));


		# 接受表单数据
		$weixin=$this->input->post('weixin');
		$nickname=trim($this->input->post('nickname'));
		$weixin=$this->input->post('weixin');
		$small_photo=$this->input->post('small_photo');
        $big_photo = $this->input->post('big_photo');
//        $m_bgpic = $this->input->post('m_bgpic');
		$travel_title_pic=$this->input->post('travel_title_pic');
		$travel_title=$this->input->post('travel_title');
		$post_array['country'] = $this->input->post('country_id');
		$post_array['province'] = $this->input->post('province_id');
		$post_array['city'] = $this->input->post('city_id');
		$post_array['region'] = $this->input->post('region_id');
		$post_array['beizhu']=$this->input->post('beizhu');
		$post_array['talk']=$this->input->post('talk');
		$post_array['expert_dest']=$this->input->post('expert_dest');
		$post_array['idcard']=$this->input->post('idcard');
		$post_array['idcardpic']=$this->input->post('idcardpic');
		$post_array['idcardconpic']=$this->input->post('idcardconpic');
		$expert_dest=$post_array['expert_dest'];
		if(!empty($post_array['expert_dest'])){
			$post_array['expert_dest']=substr($post_array['expert_dest'],0,-1);
		}
		if(!empty($weixin)){
			$post_array['weixin']=$weixin;
		}
		if(empty( $nickname)){
			echo json_encode(array('status' =>-1,'msg' =>'昵称不能为空!'));
			exit;
		}
		if(preg_match('/[a-zA-Z]/',$nickname)){
			echo json_encode(array('status' =>-1,'msg' =>'昵称中不能有字母'));
			exit;
		}
		$id=$this->expert_id;
		$query = $this->db->query ( "select nickname from u_expert where nickname='{$nickname}' and id !={$id}" );
		$expert_rows= $query->num_rows();
		
		$querys = $this->db->query ( "select nickname from u_expert where id='{$id}'" );
		$expert_arr_rows= $querys->row_array();
		$sql_query = $this->db->query ( "select be.nickname from bridge_expert as be left join bridge_expert_map as bep on be.id=bep.b_expert_id where nickname='{$nickname}' and be.status=1 and bep.expert_id !={$id}" );
		$data=$sql_query->num_rows();
		if(($data>0)||($expert_rows>0&&$expert_arr_rows['nickname']!=$nickname)){
			echo json_encode(array('status' =>-1,'msg' =>'昵称已存在'));
			exit;
		}
		if($nickname){
			$post_array['nickname']=$nickname;
		}
		$school=$this->input->post('school',true);
		$job_name=$this->input->post('profession',true);
		$year=$this->input->post('working',true);
		$post_array['beizhu']='毕业于'.$school.';旅游从业岗位：'.$job_name.';'.$year.'年从业经验';
		$post_array['school']=$school;
		$post_array['profession']=$job_name;
		$post_array['working']=intval($year);

        if($travel_title){
        	$post_array['travel_title']=$travel_title;
        }
        $post_array['small_photo']=$small_photo;
        //$post_array['big_photo']=$small_photo;
        $post_array['big_photo']=$big_photo;
//        $post_array['m_bgpic']=$m_bgpic;
        $post_array['travel_title_pic']=$travel_title_pic;
        //上门服务
        $visit_arr=$this->input->post('visit_service');  
        $visit_allservice=$this->input->post('visit_allservice');
       
        if(!empty($visit_arr)){
        	$visit_service=implode(',', $visit_arr);
        	$post_array['visit_service']=$visit_service;
        }
        $visit=$post_array['visit_service'];
       
        //荣誉证书
        $certificate=$this->input->post('certificate');
        $certificatepic=$this->input->post('certificatepic');
        $certificateArr=array(
        	'certificate'=>$certificate,
        	'certificatepic'=>$certificatepic
        );
        $expert_certificate=$this->expert->get_alldate('u_expert_certificate',array('expert_id'=>$this->expert_id));
        foreach ($expert_certificate as $k=>$v){
        	$certificate_pic[]=$v['certificatepic'];
        }


        unset($post_array['pc_photo']);
        unset($post_array['mobile_photo']);
        unset($post_array['id']);
        unset($post_array['refuse_reasion']);
        unset($post_array['is_kf']);
        
        $type_status=$this->input->post('type_status',true);
        
        if($type_status){ //成为帮游管家
            if(empty($post_array['small_photo'])){
                echo json_encode(array('status' =>-1,'msg' =>'头像不能为空'));
                exit;
            } 
            if(empty( $post_array['idcardpic'])|| empty($post_array['idcardconpic'])){
                echo json_encode(array('status' =>-1,'msg' =>'身份证扫描件不能为空!'));
                exit;
            }
            if(empty( $post_array['big_photo'])){
                echo json_encode(array('status' =>-1,'msg' =>'背景图片不能为空!'));
                exit;
            }
            
          /*   if(empty($certificate)){
                echo json_encode(array('status' =>-1,'msg' =>'荣誉证书信息不能为空!'));
                exit;
            }   */
    
          /*   if(empty($expert_resume['company_name']) || empty($expert_resume['job']) || empty($expert_resume['starttime']) || empty($expert_resume['endtime'])){
                echo json_encode(array('status' =>-1,'msg' =>'旅游从业简历不能为空!'));
                exit;
            } */
            if(empty($post_array['talk'])){
                echo json_encode(array('status' =>-1,'msg' =>'个人描述不能为空!'));
                exit;
            }

            if(empty($post_array['school']) || empty($post_array['profession'])){
                echo json_encode(array('status' =>-1,'msg' =>'个人简介信息不能为空!'));
                exit;
            }

            if(empty($expert_dest)){
                echo json_encode(array('status' =>-1,'msg' =>' 擅长线路目的地不能为空!'));
                exit;
               
            } 
            if(empty($post_array['country']) || empty($post_array['province']) || empty($post_array['city'])){
                echo json_encode(array('status' =>-1,'msg' =>'所属城市不能为空!'));
                exit;
                
            }
            if(empty($visit_arr)){
                echo json_encode(array('status' =>-1,'msg' =>'上门服务信息不能为空!'));
                exit;
            }
            $post_array['status']=1;
            $update_id=$this->expert->update_expert_data($post_array,$certificateArr,$expert_resume,$this->expert_id,$expert_dest,$visit);

            
        }else{ //管家资料修改
            
            //插入管家资料桥接关联表
            $update_id=$this->expert->update_expert($post_array,$certificateArr,$expert_resume,$this->expert_id,$expert_dest,$visit);
        }
        
        
        if($update_id){
        	echo json_encode(array('status' => 1,'msg' =>'提交成功!等待平台审核中'));
        	exit;
        }else{
        	echo json_encode(array('status' =>-1,'msg' =>'提交失败'));
        	exit;
        }

	}

	//验证手机号码
	public function unique_field($where) {
		$this ->db ->select('id');
		$this ->db ->from('u_expert');
		$this ->db ->where($where);
		$this ->db ->where('(status = 1 or status=2 or status=-1)');
		$query = $this ->db ->get();
		$data = $query ->result_array();
		if (empty($data)) {
			return true; //其值不存在
		} else {
			return false; //其值存在
		}
	}
	//修改手机号码
	public function  update_mobile(){
		$this->load->library ( 'callback' );
		$this->load->library ( 'session' );
		$mobile=$this->input->post('mobile');
		if(!empty($mobile)){
			$code = $this ->input ->post('code'); //验证码
			$mobile_code = $this ->input ->post('mobile_code'); //手机验证码
			$time = time();
			if (empty($mobile_code)) {
				$this->callback->set_code ( 4000 ,"请输入您的手机验证码");
				$this->callback->exit_json();
			} else {
				//验证手机验证码
				$register_code = $this ->session ->userdata('mobile_code');
				if (empty($register_code)) {
					$this->callback->set_code ( 4000 ,"请您先获取手机验证码");
					$this->callback->exit_json();
				}
				//10分钟过期
				if ($time - $register_code['time'] > 600) {
					$this ->session ->unset_userdata('mobile_code');
					$this->callback->set_code ( 4000 ,"您的验证码已过期");
					$this->callback->exit_json();
				}
				//验证是否正确
				if($register_code ['code'] != $mobile_code || $register_code['mobile'] != $mobile ) {
					$this->callback->set_code ( 4000 ,"您输入的手机验证码不正确");
					$this->callback->exit_json();
				}
			}
			//验证手机
			if (!empty($mobile))
			{
				$this->load->helper ( 'regexp' );
				if (!regexp('mobile' ,$mobile)) {
					$this->callback->set_code ( 4000 ,"请输入正确的手机号");
					$this->callback->exit_json();
				}

				if (!$this ->unique_field(array('mobile' =>$mobile))) {
				//	echo $this->db->last_query();
					$this->callback->set_code ( 4000 ,"手机号已存在");
					$this->callback->exit_json();
				}
			} else {
				$this->callback->set_code ( 4000 ,"请填写手机号");
				$this->callback->exit_json();
			}
			$post_array['mobile']=$mobile;
			$post_array['login_name']=$mobile;
			$update_id=$this->expert->update_rowdata('u_expert',$post_array,array('id'=>$this->expert_id));
			if($update_id){
				echo json_encode(array('status' => 1,'msg' =>'修改成功','mobile'=>$mobile));
				exit;
			}else{
				echo json_encode(array('status' => -1,'msg' =>'修改失败'));
				exit;
			}

		}else{
			echo json_encode(array('status' => -1,'msg' =>'请输入手机号码'));
			exit;
		}
	}
	//修改邮箱
	function update_email(){
		$this->load->library ( 'callback' );
		$this->load->library ( 'session' );
		//邮件验证码
		$email=$this->input->post('email');
		if(!empty($email)){
			if (!empty($_POST['code1'])) {
				$email_code = $this ->session ->userdata('email_code');

				if (empty($email_code)) {
					//throw new Exception('请您先获取邮箱验证码');
					$this->callback->set_code ( 4000 ,"请您先获取邮箱验证码");
					$this->callback->exit_json();
				}
				$time = time();
				//10分钟过期
				if ($time - $email_code['time'] > 600) {
					$this ->session ->unset_userdata('email_code');
					//throw new Exception('您的验证码已过期');
					$this->callback->set_code ( 4000 ,"您的验证码已过期");
					$this->callback->exit_json();
				}

				if($email_code ['code'] != $_POST['code1'] || $email_code['email'] != $_POST['email'] ) {
					//throw new Exception('您输入的邮箱验证码不正确');
					$this->callback->set_code ( 4000 ,"您输入的邮箱验证码不正确");
					$this->callback->exit_json();
				}
			} else {
				//throw new Exception('请填写邮箱验证码');
				$this->callback->set_code ( 4000 ,"请填写邮箱验证码");
				$this->callback->exit_json();
			}
			$post_array['email']=$email;
			$update_id=$this->expert->update_rowdata('u_expert',$post_array,array('id'=>$this->expert_id));
			if($update_id){
				echo json_encode(array('status' => 1,'msg' =>'修改成功','email'=>$email));
				exit;
			}else{
				echo json_encode(array('status' => -1,'msg' =>'修改失败'));
				exit;
			}
		}else{
			echo json_encode(array('status' => -1,'msg' =>'请输入邮箱'));
			exit;
		}
	}
	/**
	 * 我的账户
	 *
	 * @param number $page	提现记录 页
	 */
	public function account($page = 1) {
		$depart_money=0; //旅行社可提现
		# 专家账户基本信息
		$expert_info = $this->expert->row(array(
				'id' => $this->expert_id));
		if(!empty($expert_info['depart_id']) && $expert_info['depart_id']!=0){
			$depart_list=$this->expert->expert_depart($expert_info['depart_id']); //营业部
			foreach ($depart_list as $k=>$v){
				$depart_money+=$v['cash_limit'];
			}
		}

		$total_money=$depart_money+$expert_info['amount'];  //总可提现

		$data_view = array(
				'expert_info' => $expert_info,
				'depart_list'=>$depart_list,
				'depart_money'=>$depart_money,
				'total_money'=>$total_money,
				'expert_id'=>$this->expert_id
				);

		$this->load_view('admin/b2/account', $data_view);
	}

	//显示添加订单的页面
	function show_expert_add_order(){
		$post_arr = array();
		$create_time = date ( 'Y-m-d H:i:s' );
		$expert_info = $this->expert->row(array(
				'id' => $this->expert_id));
		$creator = $this->session->userdata ( 'login_name' );
		$data = array(
				'create_time' => $create_time,
				'creator' => $creator,
				'expert_id'=> $this->expert_id,
				'expert_info'=>$expert_info
		);
		//$this->load->view ( 'admin/a/common/head' );
		$this->load->view ( 'admin/b2/show_account_order', $data );
	}


	/**
	 * 专家未结算订单的时候,只做页面跳转到未结算订单的页面
	 *
	 * @author 汪晓烽
	 */
	function show_expert_unsettled_order() {
		$post_arr = array();
		$expertId = $this->input->get ( 'expertId' );
		$start_time = $this->input->get ( 'start_time' );
		$end_time = $this->input->get ( 'end_time' );
		$beizhu = $this->input->get ( 'beizhu' );


		$bank_name = $this->input->get ( 'bank_name' );
		$brand = $this->input->get ( 'brand' );
		$bank_num = $this->input->get ( 'bank_num' );
		$openman = $this->input->get ( 'openman' );


		$data = array(
				'expertId' => $expertId,
				'start_time' => $start_time,
				'end_time' => $end_time,
				'beizhu' => $beizhu,

				'bank_name' => $bank_name,
				'brand' => $brand,
				'bank_num' => $bank_num,
				'openman' => $openman
		);
		$this->load->view ( 'admin/a/common/head' );
		$this->load->view ( 'admin/b2/expert_unsettled_order', $data );
	}

	/**
	 * 通过ajax 获取专家未结算订单数据的接口
	 *
	 * @author 汪晓烽
	 */
	function get_expert_unsettled_order() {
		$post_arr = array();
		$is_manage = $this->session->userdata('is_manage');
		$expertId = $this->input->post ( 'expert_Id' );
		$number = $this->input->post ( 'pageSize', true );
		$page = $this->input->post ( 'pageNum', true );
		if ($this->input->post ( 'productname' ) != '') {
			$post_arr['mo.productname like'] = '%' . $this->input->post ( 'productname' ) . '%';
		}
		if ($this->input->post ( 'start_time' ) != '') {
			$start_date = $this->input->post ('start_time');
			$end_date= $this->input->post ('end_time');
			if(empty($end_date)){
				$end_date =date('Y-m-d');
			}
			$post_arr['mo.usedate >='] = $start_date . ' 00:00:00';
			$post_arr['mo.usedate <='] = $end_date . ' 23:59:59';
		}
		if ($this->input->post ( 'ordersn' ) != '') {
			$post_arr['mo.ordersn'] = $this->input->post ( 'ordersn' );
		}
		$number = empty ( $number ) ? 5 : $number;
		$page = empty ( $page ) ? 1 : $page;

		$pagecount = $this->finance->expert_unsettled_order ( $post_arr, 0, $number, $expertId,array(),$is_manage,$this->session->userdata('depart_id')) ;
		$order_list = $this->finance->expert_unsettled_order ( $post_arr, $page, $number, $expertId,array(),$is_manage,$this->session->userdata('depart_id'));
		if (($total = $pagecount - $pagecount % $number) / $number == 0) {
			$total = 1;
		} else {
			$total = ($pagecount - $pagecount % $number) / $number;
			if ($pagecount % $number > 0) {
				$total += 1;
			}
		}
		$data = array(
				"totalRecords" => $pagecount,
				"totalPages" => $total,
				"pageNum" => $page,
				"pageSize" => $number,
				'rows' => $order_list
		);
		echo json_encode ( $data );
	}

	/**
	 * Ajax刷新页面显示专家选中的订单列表数据
	 *
	 * @author 汪晓烽
	 */
	function show_expert_ajax_order() {
		$post_arr = array();
		$order_ids = explode ( ',', rtrim ( $this->input->post ( 'order_ids' ), "," ) );
		$expertId = $this->input->post ( 'expert_id' );
		$order_list = $this->finance->expert_unsettled_order ( $post_arr, 1, 5, $expertId, $order_ids );
		echo json_encode ( $order_list );
	}


	/**
	 * 增加专家还未结算的订单数据到数据库
	 *
	 * @author 汪晓烽
	 */
	function add_expert_order() {
		$order_ids = $this->input->post ( 'order_ids' );
		$order_ids_arr = explode ( ',', rtrim ($order_ids, "," ) );
		if(empty($order_ids)){
			echo json_encode(array('code'=>-200,'msg'=>"你还没有选择需要结算的订单"));
			exit();
		}
		$starttime = $this->input->post ( 'start_time' );
		$endtime = $this->input->post ( 'end_time' );
		$expert_id = $this->input->post ( 'expert_id' );
		$beizhu = $this->input->post ( 'beizhu' );


		$bank_name  = $this->input->post ( 'bank_name' );
		$brand 		= $this->input->post ( 'brand' );
		$bank_num 	= $this->input->post ( 'bank_num' );
		$openman 	= $this->input->post ( 'openman' );

		$bank_info = array('bank'=>$bank_num,'bankname'=>$bank_name,'openman'=>$openman,'brand'=>$brand);

		$expert_info = $this->expert->update(array('bankcard'=>$bank_num,'bankname'=>$bank_name,'cardholder'=>$openman,'branch'=>$brand),array(
				'id' => $this->expert_id));

		$res = $this->finance->add_expert_order (0,$expert_id, $starttime, $endtime, $beizhu, $order_ids_arr, $bank_info);
		if($res){
			echo json_encode(array('code'=>200,'msg'=>'Success'));
			exit();
		}else{
			echo json_encode(array('code'=>-200,'msg'=>'Fail'));
			exit();
		}

	}
	/**
	 * 提现记录控制器(用于Ajax获取数据)
	 */
	function cash_record(){
		$this->load_model('admin/b2/exchange_model', 'exchange');
		$post_arr['userid'] = $this->expert_id;
		$post_arr['exchange_type'] = ROLE_TYPE_EXPERT;
		$number = $this->input->post('pageSize', true);
       		 $page = $this->input->post('pageNum', true);
        		$number = empty($number) ? 15 : $number;
        		$page = empty($page) ? 1 : $page;
		$exchange_info = $this->exchange->get_cash_record($post_arr, $page, $number);//$this->exchange->result($post_arr, $page, $number, 'addtime desc');
		$pagecount = count($this->exchange->all($post_arr));

		 if (($total = $pagecount - $pagecount % $number) / $number == 0) {
               		 $total = 1;
           	 } else {
                	$total = ($pagecount - $pagecount % $number) / $number;
                		if ($pagecount % $number > 0) {
                    			$total +=1;
                		}
            	}
		$data=array(
	               	"totalRecords" => $pagecount,
	               	"totalPages" =>  $total,
	                	"pageNum" => $page,
	                	"pageSize" => $number,
	               	"rows" => $exchange_info
            	);
		echo json_encode($data);
	}
	/**
	 * 账单数据记录控制器
	 */
	function bill_record(){
		$post_arr = array();
		$this->load_model('admin/b2/month_account_model', 'month_account');
		$post_arr['ma.userid'] = $this->expert_id;
		$post_arr['ma.account_type'] = ROLE_TYPE_EXPERT;
		$number = $this->input->post('pageSize', true);
		$number = empty($number) ? 15 : $number;
       		$page = $this->input->post('pageNum', true);
       		$page = empty($page) ? 1 : $page;
       		if($this->input->post('order_month_id')!=''){
       			$post_arr['ma.id'] = $this->input->post('order_month_id');
       		}
       		if($this->input->post('departure_date')!='' && $this->input->post('departure_date')!='出账日期'){
       			$usedata_arr = explode(' - ',$this->input->post('departure_date'));
			$post_arr['ma.addtime >='] = $usedata_arr[0].' 00:00:00';
			$post_arr['ma.addtime <='] = $usedata_arr[1].' 23:59:59';
       		}
		$pagecount = count($this->month_account->get_account_statement($post_arr, 0, $number));
		$month_account_info = $this->month_account->get_account_statement($post_arr, $page, $number);
		 if (($total = $pagecount - $pagecount % $number) / $number == 0) {
               		 $total = 1;
           		 } else {
	                	$total = ($pagecount - $pagecount % $number) / $number;
	                		if ($pagecount % $number > 0) {
	                    			$total +=1;
	                		}
            	}
		$data=array(
	               	"totalRecords" => $pagecount,
	               	"totalPages" =>  $total,
	                	"pageNum" => $page,
	                	"pageSize" => $number,
	               	"rows" => $month_account_info
            		);
		echo json_encode($data);
	}

	/**
	 * 更新账户信息
	 */
	public function update_account() {
		$this->load->helper('regexp');
		$post_arr = array();

		$post_arr['cardholder'] = $this->input->post('cardholder');
		$post_arr['bankcard'] = $this->input->post('bankcard');
		$post_arr['bankname'] = $this->input->post('bankname');
		$post_arr['mobile'] = $this->input->post('mobile');
		$post_arr['branch'] = $this->input->post('branch');
		if(!preg_match('/^\d+$/',$post_arr['bankcard'])){
			echo json_encode(array('status'=>-11,'msg'=>'银行卡只能是数字'));
			exit();
		}
		if(!regexp( 'mobile', $post_arr['mobile'])){
			echo json_encode(array('status' =>-11 ,'msg' =>'手机号码格式不对'));
				exit();
		}
		$flag = $this->expert->update($post_arr, array('id' => $this->expert_id));
		# 跳转到我的帐户页面
		echo json_encode(array('status'=>1,'msg'=>'修改成功!'));
	}

	/**
	 * 我的客户
	 *
	 * @param number $page	页
	 */
	public function customer($page = 1) {

		$this->load_model('admin/b2/order_model', 'order');
		$this->load->library ( 'Page' ); // 加载分页类
		$config['base_url'] = '/admin/b2/expert/customer/';
		$config ['pagesize'] = 15;
		$config ['page_now'] = $this->uri->segment ( 5, 0 );
		$page = $page==0 ? 1:$page;
		$post_arr = array();
		if($this->uri->segment (5)!=''){
			# 客户名称
			if ($this->session->userdata('nickname') != '') {
				$post_arr['nickname like'] = '%' . $this->input->post('nickname') . '%';
			}

			# 客户电话
			if ($this->session->userdata('mobile') != '') {
				$post_arr['mobile like'] = $this->session->userdata('mobile');
			}

		}else{
			unset($post_arr['l.linename like']);
			$this->session->unset_userdata('nickname');
			unset($post_arr['mobile like']);
			$this->session->unset_userdata('mobile');

		}
		# 搜索表单提交
		if ($this->is_post_mode()) {

			# 用户名
			if ($this->input->post('nickname') != ''){
				$post_arr['nickname like'] = '%' . $this->input->post('nickname') . '%';
				$this->session->set_userdata(array('nickname' => $this->input->post('nickname')));
			}else{
				unset($post_arr['nickname like']);
				$this->session->unset_userdata('nickname');
			}
			# 客户电话
			if ($this->input->post('mobile') != ''){
				$post_arr['mobile like'] = '%' . $this->input->post('mobile') . '%';
				$this->session->set_userdata(array('mobile' => $this->input->post('mobile')));
			}else{
				unset($post_arr['mobile like']);
				$this->session->unset_userdata('mobile');
			}
		}

		$post_arr['mo.expert_id'] = $this->expert_id;
		$config['pagecount'] = count($this->order->get_expert_customers($post_arr, 0));
		//$this->pagination->initialize($config);
		$this->page->initialize ( $config );

		$cust_info = $this->order->get_expert_customers($post_arr, $page, $config['pagesize']);
		$data_view = array(
				'cust_info' => $cust_info,
				'mobile'     => $this->session->userdata('mobile'),
				'nickname' => $this->session->userdata('nickname')
				);
		$this->load_view('admin/b2/customers', $data_view);
	}

	/**
	 * 首页模板
	 */
	public function template() {

		$expert_info = $this->expert->row(array(
				'id' => $this->expert_id));

		$data_view = array(
				'template_info' => $expert_info['template']);


		$this->load_view('admin/b2/template', $data_view);

	}


	public function template_update() {
		$post_array = array();
		$template = $this->input->post('tmp_file_url');
		$post_array['template'] = $template;
		if ($post_array['template']) {
			$re=$this->expert->update($post_array, array('id' => $this->expert_id));
			if($re){
				echo json_encode(array('status' => 1,'msg' =>'修改成功'));
				exit;
			}else{
				echo json_encode(array('status' => -1,'msg' =>'修改失败'));
				exit;
			}
		}else{
			echo json_encode(array('status' => -1,'msg' =>'修改失败'));
			exit;
		}
	//	return redirect('admin/b2/expert/template');

	}

	/**
	 * 安全中心,修改密码
	 */
	public function security() {

		$this->db->from('u_expert');
		$data['user']=$this->db->where('id',$this->expert_id)->get()->result_array();

		$this->load->library('form_validation');
		if ($this->is_post_mode()) {
			if ($this->security_update()) return;

		}
		$this->load_view('admin/b2/security',$data);
	}

	/**
	 * 执行修改密码
	 *
	 * @return boolean
	 */
	protected function security_update() {

		$post_array = array();

		# 验证规则
		$formCheckArr = array(
		array(
			'field' => 'old_pwd',  'label' => '旧密码', 'rules' => 'trim|required|callback_pwd_check'),
		array(
			'field' => 'new_pwd', 'label' => '新密码', 'rules' => 'trim|required|matches[new_pwd2]'),
		array(
			'field' => 'new_pwd2', 'label' => '确认密码', 'rules' => 'trim|required')
		);

		$this->form_validation->set_rules($formCheckArr);

		if ($this->form_validation->run() == FALSE) {
			return FALSE;
		} else {
			$new_pwd = md5($this->input->post('new_pwd'));
			$email = $this->input->post('email');
			$this->expert->update(array('password' => $new_pwd,'email' =>$email), array('id' => $this->expert_id));
			redirect('admin/b2/expert/account');
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * 回调函数,用于验证原密码是否正确
	 *
	 * @param stirng $str	原密码
	 * @return boolean
	 */
	function pwd_check($str) {

		$expert_info = $this->expert->row(array('id' => $this->expert_id));
		if (md5($str) != $expert_info['password']) {
			# 设置错误信息
			$this->form_validation->set_message('pwd_check', '原密码不对,请重新输入');
			return FALSE;
		} else {
			return TRUE;
		}

	}

	/**
	 * 查看订单
	 */
	function get_order_info(){
	    $this->load_model('admin/b2/month_account_model', 'month_account');
	    $month_account_id = $this->input->post('month_account_id');
	    $acount_info = $this->month_account->get_account_linfo($this->expert_id,$month_account_id);
	    $order_info_list = $this->month_account->get_order_list($month_account_id);
	    if(!empty($acount_info)){
	    	$result['acount_info'] =  $acount_info[0];
	    }else{
	    	$result['acount_info'] = array();
	    }
	    if(!empty($order_info_list)){
	    	$result['order_info_list'] =  $order_info_list;
	    }else{
	    	$result['order_info_list'] =  array();
	    }

	    //var_dump($result);exit();
	    echo json_encode($result);
	}

	/*
	 * 获取地区
	*/
	public function get_area() {
		$pid = intval($_POST['id']);
/* 		$this ->db ->select('id,name');
		$this ->db ->from('u_area');
		$this ->db ->where(array('pid' =>$pid ,'isopen' =>1));
		$this ->db ->order_by("displayorder", "asc");
		$query = $this ->db ->get();
		$area = $query ->result_array(); */
		$area=$this->expert->get_alldate('u_area',array('pid' =>$pid ,'isopen' =>1));
		echo json_encode($area);
	}
	/*
	 * 获取某个地区的名称
	*/
	public function get_area_name ($id) {
// 		$this ->db ->select('id,name');
// 		$this ->db ->from('u_area');
// 		$this ->db ->where(array('id' =>$id ,'isopen' =>1));
// 		$query = $this ->db ->get();
// 		$area = $query ->result_array();
		$area=$this->expert->get_alldate('u_area',array('id' =>$id ,'isopen' =>1));
		return $area [0]['name'];
	}


	public function up_file() {
		$name_str = $this ->input ->post('filename' ,true);
		$this->load->helper ( 'url' );
		$this->load->helper(array('form', 'url'));
		$config['upload_path'] = './file/b2/upload/';
		$config['allowed_types'] ='*';
		$config['max_size'] = '4000000000';
		$file_name = 'template_'.$name_str.'_'.time();
		$config['file_name'] = $file_name;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload($name_str))
		{
			echo json_encode(array('status' => -1,'msg' =>'请重新选择要上传的文件'));
			exit;
		}
		else
		{
			$file_info = array('upload_data' => $this->upload->data());
			$url =  '/file/b2/upload/' .$file_info ['upload_data'] ['file_name'];
			echo json_encode(array('status' =>1, 'url' =>$url ));
			exit;
		}
	}
}