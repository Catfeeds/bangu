<?php
/**
 *   @name:APP接口文件=>积分中心
 *   @version: v2_3_14
 *   @author: 张允发
 *   @time: 2016-12-14
 *
 * 	 @abstract:
 *
 * 		1、   cfgm是用户接口前缀 ，
 * 		    E是管家接口前缀，
 * 		    G是即时导游接口前缀，
 * 			P是公共函数接口前缀  ；
 *
 *      2、	 __outmsg()、__data()是输出格式化数据模式，
 *      	 __null()是输出空，
 *      	 __errormsg()是输出错误模式
 *
 *      3、数据传递方式： GET OR POST
 *
 *      4、返回结果状态码:  2000是成功，4001是空null，-3是错误信息
 */
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

//继承APP_Controller类
class Integral_center extends APP_Controller
{
	private $access_token = '';
	private $userid = 0;
	public function __construct()
	{	
		parent::__construct();
		header('Content-type: application/json;charset=utf-8');  //文档为json格式
		// 允许ajax POST跨域访问
		header('Access-Control-Allow-Origin:*');
		header('Access-Control-Allow-Methods:POST');
		header('Access-Control-Allow-Headers:x-requested-with,content-type');
		$this->access_token = $this->input->get('number', true); //获取用户登陆access_token
		if(!empty($this->access_token))
		{
			$this->userid = $this->F_get_mid($this->access_token);
		}
		if(empty($this->userid))
		{
			echo json_encode ( array(
					"msg" => '请先登录',
					"code" => '0001',
			) );
			exit ();
		}
	}
	
	/**
	 * 获取积分中心首页数据
	 * @author zyf 
	 * @time 2016-12-14
	 * @return string msg 提示信息
	 */
	public function cfgm_integral_center()
	{
		$m_id = intval($this->userid);
		$userdata = $this->db->query("SELECT mid,jifen FROM u_member WHERE mid=$m_id")->row_array();
		$this->__data($userdata);
	}
	
	/**
	 * 用户积分兑换记录
	 * @author zyf
	 * @time 2016-12-16
	 * @return string msg 提示信息
	 */
	public function cfgm_exchange_record()
	{
		$m_id = intval($this->userid);
		//分页
		$page = intval($this->input->post('page', true));
		$page_size = intval($this->input->post('pagesize', true));
		$page_size = empty($page_size) ? 10 : $page_size;
		$this->load->model('app/u_member_point_log_model', 'point_log_model');//用户积分记录模型
		$data=$this->point_log_model->result(array('member_id'=>$m_id),$page,$page_size,"time desc",'arr','','type,content,point,time');
		$this->__successmsg($data);
	}
	
	/**
	 * 获取积分商城首页数据
	 * @author zyf
	 * @time 2016-12-14
	 * @return string msg 提示信息
	 */
	public function cfgm_integral_mall()
	{
		$this->__errormsg('暂时没数据');
	}
	
	/**
	 * 用户签到首页
	 * @author zyf
	 * @time 2016-12-14
	 * @return string msg 提示信息
	 */
	public function cfgm_sign()
	{
		$m_id=intval($this->userid);
		//签到当天
		$nowday=strtotime(date('Y-m-d'));
		//获取当月的第一天和最后一天及当月的天数
		$data=$this->cfgm_getmonsdata($nowday);
		$this->load->model('app/u_member_sign_model', 'sign_model');//用户签到模型
		$m_data=$this->sign_model->row(array('member_id'=>$m_id));
		$m_data['monsday']=$data['monsday'];//当月的天数
		//判断当月是否已签到     0为未签过,1为已签到
		if (!isset($m_data['mon_if_sign']) || $m_data['mon_if_sign'] == "0") 
		{			
			$m_data['last_sign_date']=''; //最近签到的日期
			$m_data['month_sign_integral']=0;  //当月获得的积分数
			$m_data['mon_sign_date']='';   //当月签到的日期号
			$m_data['con_sign_date']=0;		//连续签到的天数
			$m_data['cum_sign_date']=0;    //当月累积签到的天数
		}
		$this->__data($m_data);
	}
	
	/**
	 * 用户签到验证
	 * @author zyf
	 * @time 2016-12-15
	 * @return string msg 提示信息
	 */
	public function cfgm_check_sign()
	{
		$m_id=intval($this->userid);
		$this->load->model('app/u_member_model', 'member_model');//用户模型
		$this->load->model('app/u_member_sign_model', 'sign_model');//用户签到模型
		$this->load->model('app/u_member_point_log_model', 'point_log_model');//用户积分记录模型
		//签到当天
		$nowday=time();
		//当天的日期号
		$day=date('d',$nowday);
		$is_data=array();
		$is_data=$m_data=$this->sign_model->row(array('member_id'=>$m_id));
		//本次操作的积分
		$point=2;
		//数据初始化
		//当月是否已签到(0为未签过,1为已签到)
		$m_data['mon_if_sign']=isset($m_data['mon_if_sign'])?$m_data['mon_if_sign']:0;
		//当月累积签到的天数
		$m_data['cum_sign_date']=isset($m_data['cum_sign_date'])?($m_data['cum_sign_date']+1):1;
		//连续签到的天数
		$m_data['con_sign_date']=isset($m_data['con_sign_date'])?$m_data['con_sign_date']:0;
		//当月获得的积分数
		$m_data['month_sign_integral']=isset($m_data['month_sign_integral'])?($m_data['month_sign_integral']+$point):$point;
		//当月签到的日期号
		$m_data['mon_sign_date']=isset($m_data['mon_sign_date'])?($m_data['mon_sign_date'].",".$day):$day;
		//最近签到时间
		$m_data['last_sign_date']=isset($m_data['last_sign_date'])?$m_data['last_sign_date']:0;	
		//是否已签到
		if ($m_data['mon_if_sign'] == "1")
		{
			$result=$nowday-strtotime(date('Y-m-d',$m_data['last_sign_date']));
			//当前时间与最近签到时间相差是否超过一天
			if ($result>=86400)
			{
				//相差时间在两天以内说明是连续签到的
				if ($result<172800)
				{
					//连续签到的天数
					$m_data['con_sign_date']+=1;
				}
				//连续签到7天额外送30积分
				if ($m_data['con_sign_date'] ==7)
				{
					$m_data['month_sign_integral']+=30;
					$point+=30;
				}
				//连续签到20天额外送50积分
				if ($m_data['con_sign_date'] ==20)
				{
					$m_data['month_sign_integral']+=50;
					$point+=50;
				}
				//连续签到一个月额外送120积分
				if ($m_data['con_sign_date'] ==$day)
				{
					$m_data['month_sign_integral']+=120;
					$point+=120;
				}
			}
			else 
			{
				$this->__errormsg('今天已签到');
			}
		}
		else 
		{
			//连续签到的天数
			$m_data['con_sign_date']+=1;
			//已签到
			$m_data['mon_if_sign']=1;
		}		
		//最近签到的日期
		$m_data['last_sign_date']=$nowday;
		$this->db->trans_start(); // 事务开启
		if (empty($is_data))
		{
			$m_data['member_id']=$m_id;
			$this->sign_model->insert($m_data);
		}
		else 
		{
			$this->sign_model->update($m_data,array('member_id'=>$m_id));
		}
		$data=$this->db->query("SELECT jifen FROM u_member WHERE mid=$m_id")->row_array();
		$member_integral=$data['jifen']+$point; //用户的总积分
		$log_data=array(
			'member_id'=>$m_id,
			'point_before'=>$data['jifen'],  //操作前的积分数
			'point'=>$point,	//本次操作的积分数
			'point_after'=>$member_integral,  //操作后的积分数
			'content'=>'签到获得',
			'addtime'=>date('Y-m-d H:i:s',$nowday),
			'time'=>$nowday,	//获得积分的时间
			'type'=>1    //积分类型(1为获得,2为扣除)
		);		
		//更新用户积分
		$update=$this->member_model->update(array('jifen'=>$member_integral),array('mid'=>$m_id));
		if ($update)
		{
			//积分记录
			$this->point_log_model->insert($log_data);
		}	
		$this->db->trans_complete(); // 事务结束
		$this->__successmsg('已签');	
	}
	
	/**
	 * 获取当月的第一天和最后一天及当月的天数
	 * @author zyf
	 * @time 2016-12-14
	 * @param $date 当天的日期  格式：2016-12-14
	 * @return array (firstday 第一天  lastday 最后一天  monsday 总天数) 
	 */
	public function cfgm_getmonsdata($date)
	{
		//获取当月的天数
		$mons=date('t',$date);
		//获取当月的第一天
		$BeginDate=date('Y-m-01', strtotime($date));
		//获取当月的最后一天
		$lastday=date('Y-m-d', strtotime("$BeginDate +1 month -1 day"));
		$data=array(
			'firstday'=>$BeginDate,
			'lastday'=>$lastday,
			'monsday'=>$mons
		);
		return $data;		
	}
	
	
	
	
	
	
}
