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
		$this->access_token = $this->input->post('number', true); //获取用户登陆access_token
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
	 * @since 2016-12-14
	 * @return string msg 提示信息
	 */
	public function cfgm_integral_center()
	{
		$m_id = intval($this->userid);
		$userdata = $this->db->query("SELECT integral FROM u_member WHERE mid=$m_id")->row_array();
		$this->__data($userdata);
	}
	
	/**
	 * 用户积分兑换记录
	 * @author zyf
	 * @since 2016-12-16
	 * @return string msg 提示信息
	 */
	public function cfgm_exchange_record()
	{
		$m_id = intval($this->userid);
		//分页
		$page = intval($this->input->post('page', true));
		$page_size = intval($this->input->post('pagesize', true));
		$page_size = empty($page_size) ? 10 : $page_size;
		$this->load_model('app/u_member_points_log_model', 'points_log_model');//用户积分记录模型
		$where = array('member_id'=>$m_id);
		$data=$this->points_log_model->result($where,$page,$page_size,"time desc",'arr','','type,content,point,time');
		foreach ($data as $key=>$val)
		{
			$val['time'] = date('Y.m.d',$val['time']);
			$data[$key]=$val;
		}
		$this->__data($data);
	}

	
	/**
	 * 用户签到首页
	 * @author zyf
	 * @since 2016-12-14
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
		
		if (!empty($m_data['last_sign_date']))  $m_data['last_sign_date']=date('Y-m-d H:i:s',$m_data['last_sign_date']);
		$this->__data($m_data);
	}
	
	/**
	 * 用户签到验证
	 * @author zyf
	 * @since 2016-12-15
	 * @return string msg 提示信息
	 */
	public function cfgm_check_sign()
	{
		$m_id=intval($this->userid);
		$this->load->model('app/u_member_model', 'member_model');//用户模型
		$this->load->model('app/u_member_sign_model', 'sign_model');//用户签到模型
		//签到当天
		$nowday=time();
		//当天的日期号
		$day=date('d',$nowday);
		$is_data=array();
		$is_data=$m_data=$this->sign_model->row(array('member_id'=>$m_id));
		//本次操作的积分
		$integral_config=$this->config->item('integral_config');
		$point=$integral_config['sign'];
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
// 				if ($result<172800)
// 				{
					//连续签到的天数
					$m_data['con_sign_date']+=1;
// 				}
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
				$this->__errormsg('今天已签到,明天再来哦');
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
		$content = '签到获得';
		//积分记录
		$this->record_integration($m_id, $point, $content, 1, $nowday,0,array());
		$this->db->trans_complete(); // 事务结束
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->__errormsg('签到异常，请重新尝试');
		}
		else
		{
			$this->db->trans_commit();
			$this->__data("签到成功+".$point."积分");
		}
			
	}
	
	/**
	 * 获取当月的第一天和最后一天及当月的天数
	 * @author zyf
	 * @since 2016-12-14
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
	/**
	 * 积分规则
	 * @author zyf
	 * @since 2017-01-10
	 * @param null
	 * @return json
	 */
	public function cfgm_integralrole()
	{
		//本次操作的积分
		$integral_config=$this->config->item('integral_config');
		$sql = "select type,remarks,config_field from u_member_integralrole";
		$data = $this->db->query($sql)->result_array();
		foreach ($data as $key=>$val)		
		{
			foreach ($integral_config as $k=>$v)
			{
				if ($val['config_field'] == $k)
				{
					$val['remarks']=str_replace("{#INTEGRAL#}",$v,$val['remarks']);
					$data[$key]=$val;
				}
			}
		}
		$this->__data($data);
	}
	
	
	/**
	 * 获取积分商城首页数据
	 * @author zyf
	 * @time 2016-12-14
	 * @return string msg 提示信息
	 */
	public function cfgm_integral_mall()
	{
		$m_id = intval($this->userid);
		//分页
		$page = intval($this->input->post('page', true));
		$page_size = intval($this->input->post('pagesize', true));
		$page_size = empty($page_size) ? 10 : $page_size;
		$userdata = $this->db->query("SELECT litpic,integral FROM u_member WHERE mid=$m_id")->row_array();
		$this->load_model('app/u_member_product_model','product_model');//加载商品模型
		$product_data=$this->product_model->result(array('p_if_not'=>1),$page,$page_size,"p_time desc",'arr','','p_id,p_name,p_show_pic,p_integral_price,p_price,p_type');
		if (!empty($product_data))
		{
			$domain="https://".$_SERVER['HTTP_HOST'];
			foreach ($product_data as $key=>$val)
			{
				$val['p_show_pic']=$domain.$val['p_show_pic'];
				$product_data[$key]=$val;
			}
		}
		$reDataArr['user_data']=$userdata;
		$reDataArr['product_data']=$product_data;		
		$this->__data($reDataArr);
	}
	
	/**
	 * 商品详情
	 * @author zyf
	 * @since 2017-01-13
	 * @param null
	 * @return json
	 */
	public function cfgm_product_details()
	{
		$p_id=intval($this->input->post('p_id',true));
		$this->load_model('app/u_member_product_model','product_model');//加载商品模型
		$product_data=$this->product_model->row(array('p_id'=>$p_id),'arr','','p_id,p_name,p_pic,p_integral_price,p_price,p_content,p_describe,p_sold');
		$product_data['p_pic']=explode(',',$product_data['p_pic']);
		$domain="https://".$_SERVER['HTTP_HOST'];
		foreach ((array)$product_data['p_pic'] as $k=>$v)
		{
			$v=$domain.$v;
			$product_data['p_pic'][$k]=$v;
		}
		$reDataArr['product_data']=$product_data;
		$this->__data($reDataArr);
	}
	
	/**
	 * 商品结算
	 * @author zyf
	 * @since 2017-01-13
	 * @param null
	 * @return json
	 */
	public function cfgm_product_settlement()
	{
		$p_id=intval($this->input->post('p_id',true));
		$m_id = intval($this->userid);
		$userdata = $this->db->query("SELECT integral,pwd_type FROM u_member WHERE mid=$m_id")->row_array();
		$this->load_model('app/u_member_product_model','product_model');//加载商品模型
		$product_data=$this->product_model->row(array('p_id'=>$p_id),'arr','','p_id,p_name,p_integral_price');
		$reDataArr['user_data']=$userdata;
		$reDataArr['product_data']=$product_data;
		$this->__data($reDataArr);
	}
	
	/**
	 * 商品购买
	 * @author zyf
	 * @since 2017-01-14
	 * @param null
	 * @return json
	 */
	public function cfgm_product_purchase()
	{
		$m_id = intval($this->userid);
		$p_id=intval($this->input->post('p_id',true)); //产品id
		if (empty($p_id)) $this->__wapmsg('参数有误');
		$p_name=$this->input->post('p_name',true);  //商品名称
		$p_integral_price=intval($this->input->post('p_integral_price',true));  //商品积分价格
		$p_num=intval($this->input->post('p_num',true));		//购买数量
		$transaction_pwd = intval($this->input->post('transaction_pwd',true)); //确认密码
		if (!is_numeric($transaction_pwd) || strlen($transaction_pwd)!=6)
		{
			$this->__wapmsg('请输入6位数字的交易密码');
		}
		$this->load_model('app/u_member_product_model','product_model');//加载商品模型
		$product_data=$this->product_model->row(array('p_id'=>$p_id,'p_if_not'=>1),'arr','','p_name,p_integral_price,p_show_pic,p_price');
		if (empty($product_data)) $this->__wapmsg('找不到该产品');
		if ($p_integral_price < $product_data['p_integral_price'])	//判断积分价格是否合法
		{
			$this->__wapmsg('积分价格不合法');
		}
		if ($p_num<=0) $this->__wapmsg('请输入6位数字的交易密码');
		$this->load->model('app/u_member_model', 'member_model');//用户模型
		$data=$this->member_model->row(array('mid'=>$m_id),'arr','','transaction_pwd,integral');
		$transaction_pwd = MD5(MD5($transaction_pwd)."bangu"); //加密
		if (!empty($data['transaction_pwd']))	//判断是否已设置初始交易密码
		{
			if ($data['transaction_pwd'] == $transaction_pwd)
			{
				if ($data['integral'] < $p_integral_price*$p_num) $this->__wapmsg('您的积分不足');
				//获取配置
				$integral_config=$this->config->item('integral_config');
				$content="下订单获得";
				$where=array('mid'=>$m_id);
				$m_data=array('integral'=>$data['integral']-$p_integral_price*$p_num);
				//生成订单
				$buy_time = time(); 
				$order_id=date('YmdHis',$buy_time).mt_rand(1000,9999);
				$insert_data=array(
					'm_id'=>$m_id,
					'p_id'=>$p_id,
					'order_id'=>$order_id,
					'name'=>$product_data['p_name'],
					'pic'=>$product_data['p_show_pic'],
					'integral_price'=>$p_integral_price,
					'num'=>$p_num,
					'price'=>$product_data['p_price'],
					'status'=>1,		//产品状态 1为已下单，2为已发货
					'buy_time'=>$buy_time
				);
				$this->db->trans_begin();//事务开启
				$this->member_model->update($m_data,$where); //更新用户积分
				$this->db->insert('u_member_buy_record',$insert_data);  //记录购买数据
				$this->record_integration($m_id, $integral_config['single_access'], $content,1, $buy_time,0,array());
				$this->db->trans_complete(); //事务结束
				//事务
				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					$this->__wapmsg('购买失败');
				}else{
					$this->db->trans_commit();
					$this->__data('恭喜您!购买成功');
				}
			}
			else
			{
				$this->__wapmsg('您的交易密码错误');
			}
		}
		else
		{
			$this->__wapmsg('您还没有设置初始交易密码');
		}
		
	}
	
	/**
	 * 设置初始支付密码
	 * @author zyf
	 * @since 2017-01-14
	 * @param null
	 * @return json
	 */
	public function cfgm_setinitial_pwd()
	{
		$m_id = intval($this->userid);
		$initial_pwd = intval($this->input->post('initial_pwd',true)); //初始密码
		$confirm_pwd = intval($this->input->post('confirm_pwd',true)); //确认密码
		$sql = "select transaction_pwd from u_member where mid=".$m_id;
		$m_data=$this->db->query($sql)->row_array();
		if (!empty($m_data['transaction_pwd'])) $this->__wapmsg('您已设置初始交易密码');
		if (!is_numeric($initial_pwd) || !is_numeric($confirm_pwd) || strlen($initial_pwd)!=6 || strlen($confirm_pwd)!=6)
		{
			$this->__wapmsg('请输入6位数字的交易密码');
		}
		if ( $initial_pwd != $confirm_pwd)  $this->__wapmsg('两次密码输入不一致');
		$transaction_pwd = MD5(MD5($confirm_pwd)."bangu"); //加密
		$data = array('transaction_pwd'=>$transaction_pwd,'pwd_type'=>1);
		$this->db->where('mid', $m_id);
		$result=$this->db->update('u_member', $data);
		if (!$result){
			$this->__wapmsg('密码设置失败,请重新设置密码');
		}else{
			$this->__data('密码设置成功');
		}
	}
	
	/**
	 * 商品购买记录
	 * @author zyf
	 * @since 2017-01-14
	 * @param null
	 * @return json
	 */
	public function cfgm_buy_log()
	{
		$m_id = intval($this->userid);
		$page = intval($this->input->post('page', true));
		$page_size = intval($this->input->post('pagesize', true));
		$page_size = empty($page_size) ? 10 : $page_size;
		$this->load_model('app/u_member_buyrecord_model','buy_record_model');
		$log_data=$this->buy_record_model->result(array('m_id'=>$m_id),$page,$page_size,"buy_time desc",'arr','','order_id,name,pic,integral_price,num,price,status,buy_time');
		foreach ($log_data as $key=>$val)
		{
			$val['sum_integral']=$val['integral_price']*$val['num'];
			$val['buy_time']=date('Y-m-d H:i',$val['buy_time']);
			$log_data[$key]=$val;
		}
		$this->__data($log_data);
	}

	/**
	 * 忘记支付密码
	 * @author zyf
	 * @since 2017-01-14
	 * @param null
	 * @return json
	 */
    public function cfgm_find_pwd() {
        $this->load->library('session', true);
        $m_id = intval($this->userid);
        $mobile = $this->input->post('mobile', true);
        $new_pwd= $this->input->post('new_password', true);  //初始密码
        $new_pwd2= $this->input->post('new_password2', true); //确认密码
        $code = $this->input->post('code', true);
		$now=time();
        $time=$this->session->userdata('time'); 
        if (!empty($time))
        {
        	$set_time=$now-$time;
        	if ($set_time > 60) $this->__wapmsg('已超时,请重新设置');
        }
        if (empty($mobile)) $this->__wapmsg('请输入手机号');
        if (empty($code)) $this->__wapmsg('请输入验证码');
        if (!is_numeric($new_pwd) || !is_numeric($new_pwd2) || strlen($new_pwd)!=6 || strlen($new_pwd2)!=6)
        {
        	$this->__wapmsg('请输入6位数字的交易密码');
        }
        if ( $new_pwd != $new_pwd2)  $this->__wapmsg('两次密码输入不一致');
        $data['transaction_pwd']=MD5(MD5($new_pwd)."bangu"); //加密
        $data['mid']=$m_id;
        $where = array(
            'mobile' => $mobile
        );
        $code_mobile = $this->session->userdata('mobile');
        $code_number = $this->session->userdata('code');
        if (($code_mobile == $mobile) && ($code_number == $code)) {
            $status = $this->db->update('u_member', $data, $where);
            if ($status) {
                $this->__data('重设密码成功');
            } else {
                $this->__wapmsg('重设密码失败');
            }
        } else {
            $this->__wapmsg('验证码输入错误');
        }
    }
    
}
