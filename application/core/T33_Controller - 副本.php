<?php
/**
 * 2016-07-27 上午11:10:16
 * 温文斌
 *
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class T33_Controller extends MY_Controller {
	
	public function __construct() 
	{
		parent::__construct ();
		$this->load->library ( 'session' );
		$this->load->helper('string');
		$sess_employee_id=$this->session->userdata('employee_id');
		$c=$this->uri->segment(3, 0); //控制器
		$a=$this->uri->segment(4, 0); //方法
		if(!$sess_employee_id)
		{
			if($c=="0"||$c=="login")
			{
				
			}
			else 
			{
				redirect(base_url('admin/t33')); //当前页不是登录页，且有没有登录态时，都跳转到登录页
			}
		}
		
		$this->load->model('admin/t33/approve/u_order_receivable_model','u_order_receivable_model');  //订单收款表
		$this->load->model('admin/t33/u_member_order_model','u_member_order_model'); //订单表
		$this->load->model('admin/t33/limit/b_expert_limit_apply_model','b_expert_limit_apply_model'); //信用额度使用表
		$this->load->model('admin/t33/limit/b_limit_apply_model','b_limit_apply_model'); //申请表
		$this->load->model('admin/t33/approve/u_order_debit_model','u_order_debit_model'); //订单扣款表
		
		$this->load->model('admin/t33/approve/u_supplier_refund_model','u_supplier_refund_model'); //供应商退款申请
		$this->load->model('admin/t33/b_depart_model','b_depart_model');
	}
	/*
	 * 获得旅行社id
	 * */
	public function userinfo()
	{
		$employee_id=$this->session->userdata("employee_id");
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$employee=$this->b_employee_model->detail($employee_id);
		return $employee;
	}
	/**
	 *
	 * @param  $post_url:url地址;
	 *         $data:传递的数据
	 * @return 数组
	 */
	public function curl($post_url,$data)
	{
		//$post_url = "http://www.1b1u.com/wx/pl/api/save_wx_member";
		$ch = curl_init ();

		curl_setopt ( $ch, CURLOPT_URL, $post_url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
		$output = curl_exec ( $ch );
		curl_close ( $ch );
		return $output; // true 表示数组形式
	}
	/*
	 * 获得旅行社id
	* */
	public function get_union()
	{
		$employee_id=$this->session->userdata("employee_id");
		$this->load->model('admin/t33/b_employee_model','b_employee_model');
		$employee=$this->b_employee_model->row(array('id'=>$employee_id));
		$union_id=$employee['union_id'];
		return $union_id;
	}
	
	/**
	 * 是否AJAX请求:是否是jquery的$.post、$.get、$.ajax，不包括原生态ajax
	 * @access protected
	 * @return bool
	 */
	protected function isAjax()
	{
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) ) {
			if('xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH']))
				return true;
		}
	
		return false;
	}
	/**
	 * @name：私有函数：输出数据,$len是长度
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function __data($reDataArr,$common=array()) {
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
			$data=$reDataArr;
			$code="2000";
			$msg="success";
		}
	
		$output= json_encode ( array (
				"code" => $code,
				"msg" => $msg,
				"data" => $data,
				"total" => $len,
				'common'=>$common
		), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
	
		echo $output;
		exit ();
	}
	/**
	 * 请求错误信息接口
	 * @param string $msg
	 * @param string $code
	 */
	public function __errormsg($msg = "", $code = "-3") {
		$this->result_code = $code;
		if ($msg == "") {
			$this->result_msg = "data error";
		} else {
			$this->result_msg = $msg;
		}
		
		$this->resultJSON = json_encode ( array(
				"code" => $this->result_code,
				"msg" => $this->result_msg,
		) );
		echo $this->resultJSON;
		exit ();
	}
	/**
	 * 营业部额度变化记录表
	 * @param string $msg
	 * @param string $code
	 */
	public function write_limit_log($data)
	{
		$this->load->model('admin/t33/limit/b_limit_log_model','b_limit_log_model'); //营业部额度变化记录表
		$this->b_limit_log_model->insert($data);
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
		(select group_concat(us.cityname) from u_line_startplace as ls left join u_startplace as us on ls.startplace_id=us.id where ls.line_id=a.id) as startplace
			
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
	protected function F_line_detail_more($lineId){
		$sql="
		SELECT
		a.*,(select GROUP_CONCAT(kindname) from u_destinations where FIND_IN_SET(id,a.overcity2) >0 )as overcity_name,
		(select group_concat(us.cityname) from u_line_startplace as ls left join u_startplace as us on ls.startplace_id=us.id where ls.line_id=a.id) as startplace,
		t.name as theme_name
		FROM
		u_line as a
		left join u_line_startplace as ls on a.id=ls.line_id
		LEFT JOIN u_startplace as u  on ls.startplace_id=u.id
		left join u_theme as t on t.id=a.themeid
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
			if (!empty($data ['data'] ['linetype'])) 
			{
			$data ['line_attr_arr'] = $this->lineattr_model->getLineattr ( explode ( ",", $data ['data'] ['linetype'] ) );
			}
		// 供应商信息
		$supplierData = $this->user_shop_model->get_user_shop_select ( 'u_supplier', array ('id' => $data ['data'] ['supplier_id']) );
		// 线路品牌、套餐
		$data ['data'] ['brand'] = $supplierData [0] ['brand'];
		$data ['suits'] = $this->user_shop_model->getLineSuit ( $lineId );
		$data['line_aff']=$this->user_shop_model->select_rowData('u_line_affiliated',array('line_id'=>$lineId));
		//线路轮播图
			$pics=$this->db->query("select a.filepath from u_line as l left join u_line_pic as p on l.id=p.line_id left join u_line_album as a on a.id=p.line_album_id where l.id='{$lineId}'")->result_array();
			$data ['data'] ['pics']=$pics;
		// 行程安排
			$data ['rout'] = $this->user_shop_model->getLineRout ( $lineId );
			foreach ( $data ['rout'] as $key => $val ) 
			{
				foreach ( $val as $k => $v ) 
				{
					if ($k == "pic") 
					{
						if ($v) 
						{
							$val [$k] = explode ( ";", $v );
							foreach ( $val [$k] as $k ) 
							{
							if (! empty ( $k )) {
							$val ['pics'] [] =  $k;
							}
							}
							$val ['pic'] = '1';
						}
					}
				}
				$data ['rout'] [$key] = $val;
			}
			//线路评论
				$data ['comment_list'] = $this->db->query ( "SELECT m.litpic, m.nickname, c.level, c.content,c.reply1,c.reply2,c.pictures, c.addtime, c.isanonymous, m.mobile FROM u_comment AS c	LEFT JOIN  u_member as m ON c.memberid=m.mid	WHERE c.line_id ='{$lineId}' order by c.addtime desc LIMIT 5" )->result_array ();
				foreach ($data ['comment_list'] as $n=>$m)
			{
				$pic_arr=explode(",", $m['pictures']);
				
			    $m['pictures']=$pic_arr;
				$data ['comment_list'][$n]=$m;
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
			$data ['train'] = $this->user_shop_model->get_user_shop_select ( 'u_expert_train', array ('line_id' => $lineId,'status' => 1) );
			// 礼品管理
			$data ['gift'] = $this->user_shop_model->get_gift_data ( $lineId );

			//指定营业部
   			$data['package']=$this->user_shop_model->select_line_package($lineId);

        			// 定制管家数据
			$data['expert']=$this->user_shop_model->get_group_expert($lineId);

			//线路图片
			$data['imgurl']=$this->user_shop_model->select_imgdata($lineId); 
			

			return $data;
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
	 * @name：公共函数:订单详情
	 * @author: 温文斌
	 * @param: number=凭证；orderid=订单ID
	 * @return:
	 *
	 */
	protected function F_order_detail($order_id)
	{
		$sql = "
		SELECT
		mo.id,mo.addtime,mo.suitid,mo.memberid,mo.productautoid,mo.supplier_id,mo.expert_id,mo.ordersn,mo.productname,mo.oldnum,mo.childnobednum,mo.dingnum,mo.childnum,lsp.adultprice,lsp.oldprice,lsp.childprice,lsp.childnobedprice,
		(mo.oldnum+mo.childnobednum+mo.dingnum+mo.childnum) as people,mo.usedate,mo.agent_fee,mo.linkman,mo.linkmobile,mo.linkemail,
		(mo.oldnum*lsp.oldprice+mo.childnobednum*lsp.childnobedprice+mo.dingnum*lsp.adultprice+mo.childnum*lsp.childprice) as team_free,mo.supplier_cost,mo.balance_money,mo.platform_fee,mo.supplier_cost-mo.platform_fee as jiesuan_money,
		CASE WHEN mo.isneedpiao=1 THEN '是' WHEN mo.isneedpiao=0 THEN '否' END AS is_fp,mo.ispay,mo.status,mo.beizhu,mo.ys_lock,mo.yf_lock,mo.yj_lock,mo.bx_lock,mo.wj_lock,
		mo.jifenprice,mo.couponprice,mo.settlement_price,mo.insurance_price,mo.suitnum,mo.order_price,mo.total_price,(mo.total_price+mo.settlement_price) as all_price,
		(select sum(money) from u_order_receivable where status=2 and order_id=mo.id)as receive_price,
		s.cityname,l.linetitle,l.agent_rate_int,l.saveprice,l.overcity,l.linepic,e.nickname as expert_name,e.small_photo,e.mobile,
		su.company_name,su.brand,su.linkman,su.link_mobile as supplier_mobile,su.telephone as supplier_telephone,
		
		(
					    CASE  
					    	WHEN mo.ispay=0 AND TIMESTAMPDIFF(HOUR,mo.addtime,NOW())>24 
					    		THEN '已取消'  
					   	    WHEN mo.status = -3
					   	    	THEN '退款中'  
					   	    WHEN mo.id IN (SELECT r.order_id FROM u_order_refund AS r WHERE r.status=3) AND (mo.status=-4) 
					   	    	THEN '退款成功'  
					   	    WHEN mo.status = -4 
					   	    	THEN '已取消'  
					   	    WHEN mo.status = -2 
					   	    	THEN '已取消'  
					   	    WHEN mo.status = -1 
					   	    	THEN '已取消'  
					   	    WHEN mo.status = 0 AND mo.ispay=0 
					   	    	THEN '预留位'  
					   	    WHEN mo.status = 1 AND mo.ispay=0 
					   	    	THEN '已留位'  
					   	    WHEN mo.status = 1 AND mo.ispay=1 
					   	    	THEN '已留位'  
					   	    WHEN mo.status = 1 AND mo.ispay=2 
					   	    	THEN '已确认'  
					   	    WHEN mo.status = 2
					   	    	THEN '申请中'  
					   	    WHEN mo.status = 4 
					   	        THEN '已确认' 
					   	    WHEN mo.status = 5 
					   	    	THEN '出团中'  
					   	    WHEN (mo.status = 8 or mo.status = 6 or mo.status = 7)
					   	    	THEN '行程结束'  
					   	 
					   	   
					   	END) AS order_status,
        		(
					    CASE 
					   	    WHEN mo.ispay=6
					   	    	THEN '已交款'  
					   	    else
					   	        '未交款'  
					   	   
					   	END) AS order_pay
		FROM
		u_member_order AS mo
		LEFT JOIN u_line AS l ON mo.productautoid=l.id
		left join u_line_suit_price as lsp on lsp.dayid=mo.suitid
		LEFT JOIN u_line_startplace AS ls ON mo.productautoid=ls.line_id
		left join u_startplace as s on s.id=ls.startplace_id
		left join u_expert as e on e.id=mo.expert_id
		left join u_supplier as su on su.id=mo.supplier_id
		WHERE
		mo.id={$order_id}";
		$query = $this->db->query ( $sql );
		$result = $query->row_array ();
		return $result;
	}
	/*
	 * 交款时，还款：将该交款下的所有订单，先交还管家信用额度，再还营业部信用额度，再存入现金额度
	* */
	public function hand_deal($item_id,$reply,$employee_id)
	{
		//1、还款：将该交款下的所有订单，先交还管家信用额度，再还营业部信用额度，再存入现金额度
		$this->back($item_id);
	
		//2、更改额度申请单状态更改 + (可请款，已请款，平台佣金)
		$apply=$this->u_order_receivable_model->item_apply_detail(array('id'=>$item_id)); //$apply[0]['order_id']
		
		if(empty($apply[0]['order_id']))
		{
			$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			$data=array('reply'=>$reply,'employee_id'=>$employee_id,'status'=>'2','employee_name'=>$employee['realname'],'modtime'=>date("Y-m-d H:i:s"));
			$this->u_order_receivable_model->update($data,array('id'=>$item_id));
		}
		else
		{
			$order=$this->u_member_order_model->row(array('id'=>$apply[0]['order_id']));//订单

			$receive=$this->u_order_receivable_model->all(array('order_id'=>$apply[0]['order_id'],'status'=>'2'));
			$re_money=0;//该订单总共交的钱
			if(!empty($receive))
			{
				foreach ($receive as $n=>$m)
				{
					$re_money+=$m['money'];
				}
			}
			$a=$apply[0]['money']+$re_money;//以前交款+本次交款
			$b=$order['total_price']-$order['platform_fee']; //订单应收-平台佣金  （为了扣佣金）
			$employee=$this->b_employee_model->row(array('id'=>$employee_id));
			$update=array('reply'=>$reply,'employee_id'=>$employee_id,'status'=>'2','employee_name'=>$employee['realname'],'modtime'=>date("Y-m-d H:i:s"));
		
			if($a<$b) //不够扣佣金
			{
				$update['allow_money']=$apply[0]['money'];
				$update['already_money']="0";
				$update['union_money']="0";
			}
			else //够扣佣金
			{
				$exit=$this->u_order_receivable_model->row(array('order_id'=>$apply[0]['order_id'],'status'=>'2','union_money !='=>'0'));
				if(empty($exit))
				{
					$update['allow_money']=$apply[0]['money']-$order['platform_fee'];
					$update['already_money']="0";
					$update['union_money']=$order['platform_fee'];
				}
				else
				{
					$update['allow_money']=$apply[0]['money'];
					$update['already_money']="0";
					$update['union_money']="0";
				}
					
			}
			//1.1 留住佣金
			$this->u_order_receivable_model->update($update,array('id'=>$item_id));
			
			//1.2  管家利润返给营业部（交全款）：订单状态=9（未提交）时，不返管家佣金
			if($order['depart_balance']<$order['agent_fee']&&$a>=$order['total_price']&&$order['status']!="9")
			{
				//var_dump($a);var_dump($order['total_price']);exit();
				$no_balance=$order['agent_fee']-$order['depart_balance'];//未结算管家佣金
				$depart=$this->b_depart_model->row(array('id'=>$apply[0]['depart_id']));
				$this->b_depart_model->update(array('cash_limit'=>$depart['cash_limit']+$no_balance),array('id'=>$apply[0]['depart_id'])); //利润充值到现金
				$new_depart=$this->b_depart_model->row(array('id'=>$apply[0]['depart_id']));
				//修改管家已结算佣金
				$this->u_member_order_model->update(array('depart_balance'=>$order['agent_fee']),array('id'=>$apply[0]['order_id'])); //重写“已结算”
				//写日志
				$log_fee['order_id']=$apply[0]['order_id'];
				$log_fee['depart_id']=$apply[0]['depart_id'];
				$log_fee['expert_id']=$apply[0]['expert_id'];
				$log_fee['order_sn']=$order['ordersn'];
				$log_fee['order_price']=$order['order_price'];
				$log_fee['union_id']=$apply[0]['union_id'];
				$log_fee['supplier_id']=$order['supplier_id'];
				$log_fee['receivable_money']=$no_balance; //交款:利润
				$log_fee['cash_limit']=$new_depart['cash_limit'];
				$log_fee['credit_limit']=$new_depart['credit_limit'];
				$log_fee['addtime']=date("Y-m-d H:i:s",time()+3);
				$log_fee['type']="管家佣金结算";
				$this->write_limit_log($log_fee); 
			}
			//1.3 修改支付状态
			$this->u_member_order_model->update(array('ispay'=>'6'),array('id'=>$apply[0]['order_id']));
			//end
		}
		//exit();
		//3、更改扣款表
		$this->reback_debit($item_id);
	}
	/*
	 * 交款时，还款：将该交款下的所有订单，先交还管家信用额度，再还营业部信用额度，再存入现金额度
	 * 区分(from)： 1是现金转账，手动  2是账户余额，下单
	* */
	protected function back($item_id)
	{
		$addtime=date("Y-m-d H:i:s");
		$order_list=$this->u_order_receivable_model->item_apply_detail(array('id'=>$item_id));
		if(!empty($order_list))
		{
			if($order_list[0]['status']=="1")
			{
			foreach ($order_list as $k=>$v)
			{
				$expert_limit=$this->b_expert_limit_apply_model->limit_apply_detail2($v['order_id']);
	
				$log=array(
						'depart_id'=>$v['depart_id'],
						'expert_id'=>$v['expert_id'],
						'manager_id'=>isset($expert_limit['manager_id'])==true?$expert_limit['manager_id']:"",
						'order_id'=>$v['order_id'],
						'order_sn'=>$v['order_sn'],
						'union_id'=>isset($expert_limit['union_id'])==true?$expert_limit['union_id']:"",
						'supplier_id'=>isset($expert_limit['supplier_id'])==true?$expert_limit['supplier_id']:""
				);

				if($v['order_id']!="0")  //有订单的交款
				{
					if($v['money']>0)  //交的是正数
					{
						//有未还的信用额度
						$no_pay=0;//剩余未还款的金额
						if(!empty($expert_limit)&&$v['way']!="2")
						{
							$no_pay=$expert_limit['apply_amount']-$expert_limit['return_amount']; //剩余未还款的金额
							if($v['money']>=$no_pay)  //若交款金额大于等于未还款的金额[能还清]
							{
	
								//管家未还款的信用=》改为已还款
								$owe=$expert_limit['apply_amount'];//已还的款$expert_limit['return_amount']+$v['money']
								$this->b_expert_limit_apply_model->update(array('status'=>'2','return_amount'=>$owe),array('id'=>$expert_limit['id']));
								$this->b_limit_apply_model->update(array('status'=>'4'),array('id'=>$expert_limit['apply_id']));
								
								//有剩余的金额
								$new_depart=$this->b_depart_model->row(array('id'=>$v['depart_id']));
								
								$log2=$log;
								$log2['sx_limit']=0-$no_pay; //交款
								$log2['cash_limit']=$new_depart['cash_limit'];
								$log2['credit_limit']=$new_depart['credit_limit'];
								$log2['addtime']=date("Y-m-d H:i:s",time()+1);
								$log2['type']="自动还款(管家信用)";
								$this->write_limit_log($log2);
							}
							else  // [不能还清]
							{
								//管家未还款的信用金额= 原金额- 已还
								$owe=$expert_limit['return_amount']+$v['money'];//已还的款
								$this->b_expert_limit_apply_model->update(array('return_amount'=>$owe),array('id'=>$expert_limit['id']));
									
								//没有剩余的金额
								$new_depart=$this->b_depart_model->row(array('id'=>$v['depart_id']));
								
								$log4=$log;
								$log4['sx_limit']=0-$v['money']; //交款
								$log4['cash_limit']=$new_depart['cash_limit'];
								$log4['credit_limit']=$new_depart['credit_limit'];
								$log4['addtime']=date("Y-m-d H:i:s",time()+1);
								$log4['type']="自动还款(管家信用)";
								$this->write_limit_log($log4); 
									
							}
						}
						//剩余的金额存入营业部信用额度
						$credit_money=$v['money']-$no_pay; //剩余的金额
						$debit=$this->u_order_debit_model->row(array('order_id'=>$v['order_id'],'type'=>'2'));//扣的信用额度
						if(empty($debit))
							$reback=0;
						else
						    $reback=$debit['real_amount']-$debit['repayment']; //需还的信用
						if($reback>0&&$credit_money>0&&$v['from']!="2")
						{
							if($credit_money>=$reback)
								$chong=$reback;
							else
								$chong=$credit_money;
	
							$depart=$this->b_depart_model->row(array('id'=>$v['depart_id']));
							$new_credit_money=$depart['credit_limit']+$chong; //增加之后的信用额度
							$this->b_depart_model->update(array('credit_limit'=>$new_credit_money),array('id'=>$v['depart_id']));
						    $new_depart=$this->b_depart_model->row(array('id'=>$v['depart_id']));
						    $log_credit=$log;
							$log_credit['sx_limit']=0-$chong; //换营业部信用
							$log_credit['cash_limit']=$new_depart['cash_limit'];
							$log_credit['credit_limit']=$new_credit_money;
							$log_credit['addtime']=$addtime;
							$log_credit['type']="自动还款(营业部信用)";
							$this->write_limit_log($log_credit); 
						}
							
						//剩余的金额存入现金额度
						$cash_money=$credit_money-$reback;//剩余的金额
						if($cash_money>0)
						{
							if($v['from']!="2")  //"账户余额"交款,现金额度不变化
							{
								$depart=$this->b_depart_model->row(array('id'=>$v['depart_id']));
								$new_cash_money=$depart['cash_limit']+$cash_money; //增加之后的现金额度
								$this->b_depart_model->update(array('cash_limit'=>$new_cash_money),array('id'=>$v['depart_id']));	
							}
							
						}
						$new_depart=$this->b_depart_model->row(array('id'=>$v['depart_id']));
						$log3=$log;
						$log3['receivable_money']=$v['money']; //交款
						$log3['cash_limit']=$new_depart['cash_limit'];
						$log3['credit_limit']=$new_depart['credit_limit'];
						$log3['addtime']=$addtime;
						if($v['from']=="2")
						{
							$log3['cut_money']=0-$v['money']; //交款
							$log3['type']="账户余额交款";
						}
						else 
						  $log3['type']="交款";
						$this->write_limit_log($log3);
	
					}
					else  //交的负数，直接充值到现金额度
					{
						$cash_money=$v['money'];//剩余的金额
						if($cash_money!=0)
						{
							$depart=$this->b_depart_model->row(array('id'=>$v['depart_id']));
							$new_cash_money=$depart['cash_limit']+$cash_money; //增加之后的现金额度
							$this->b_depart_model->update(array('cash_limit'=>$new_cash_money),array('id'=>$v['depart_id']));
							$new_depart=$this->b_depart_model->row(array('id'=>$v['depart_id']));
							$log_fu=$log;
							$log_fu['receivable_money']=$cash_money; //交款
							$log_fu['cash_limit']=$new_cash_money;
							$log_fu['credit_limit']=$new_depart['credit_limit'];
							$log_fu['addtime']=$addtime;
							$log_fu['type']="退客户款";
							$this->write_limit_log($log_fu);
						}
					}
				}
				else  //没有订单的交款,直接充值到营业部现金
				{
						
					//剩余的金额存入现金额度
					$cash_money=$v['money'];//剩余的金额
					if($cash_money!=0)
					{
	
						$depart=$this->b_depart_model->row(array('id'=>$v['depart_id']));
						$new_cash_money=$depart['cash_limit']+$cash_money; //增加之后的现金额度
						$this->b_depart_model->update(array('cash_limit'=>$new_cash_money),array('id'=>$v['depart_id']));
						$new_depart=$this->b_depart_model->row(array('id'=>$v['depart_id']));
						$log5=$log;
						$log5['receivable_money']=$cash_money; //交款
						$log5['cash_limit']=$new_cash_money;
						$log5['credit_limit']=$new_depart['credit_limit'];
						$log5['addtime']=$addtime;
						$log5['type']="交款";
						$this->write_limit_log($log5);
					}
	
				}
	          
				//end
					
					
			  } //foreach end
			}
			else 
			{
				$this->__errormsg('不能重复提交交款');
			}
		}
		else 
			$this->__errormsg('交款单不存在');
	}
	/**
	 * 交款时，还清 u_order_debit 表
	 * */
	protected function reback_debit($item_id)
	{
		$addtime=date("Y-m-d H:i:s");
		$one=$this->u_order_receivable_model->row(array('id'=>$item_id));
		$receive=$this->u_order_receivable_model->all(array('order_id'=>$one['order_id'],'from !='=>'2','status'=>'2','money >'=>'0'));
		$re_money=0;//该订单总共交的钱
		if(!empty($receive))
		{
			foreach ($receive as $n=>$m)
			{
				$re_money+=$m['money'];
			}
		}
		if($one['order_id']!='0'&&!empty($one['order_id']))
		{
			//1、管家信用扣款
			$debit_one=$this->u_order_debit_model->row(array('order_id'=>$one['order_id'],'type'=>'3'));
			if(!empty($debit_one))
			{
				if($re_money>=$debit_one['real_amount'])
				{
					//已还清管家信用
					$this->u_order_debit_model->update(array('repayment'=>$debit_one['real_amount'],'status'=>'2','modtime'=>$addtime),array('order_id'=>$one['order_id'],'type'=>'3'));
				}
				else
				{
					//没还清
					$this->u_order_debit_model->update(array('repayment'=>$re_money,'modtime'=>$addtime),array('order_id'=>$one['order_id'],'type'=>'3'));
				}
			}
			//2、营业部信用
			$debit_one_real_amount=isset($debit_one['real_amount'])==true?$debit_one['real_amount']:0;
			$re_money2=$re_money-$debit_one_real_amount;
			$debit_two=$this->u_order_debit_model->row(array('order_id'=>$one['order_id'],'type'=>'2'));
			if(!empty($debit_two)&&$re_money2>0)
			{
				if($re_money2>=$debit_two['real_amount'])
				{	
					//已还清营业部信用
					$this->u_order_debit_model->update(array('repayment'=>$debit_two['real_amount'],'status'=>'2','modtime'=>$addtime),array('order_id'=>$one['order_id'],'type'=>'2'));
				}
				else
				{
					$this->u_order_debit_model->update(array('repayment'=>$re_money2,'modtime'=>$addtime),array('order_id'=>$one['order_id'],'type'=>'2'));
				}
			}
			//3、营业部现金
			$debit_two_real_amount=isset($debit_two['real_amount'])==true?$debit_two['real_amount']:0;
			$re_money3=$re_money2-$debit_two_real_amount;
			$debit_three=$this->u_order_debit_model->row(array('order_id'=>$one['order_id'],'type'=>'1'));
			if(!empty($debit_three)&&$re_money3>0)
			{
				if($re_money3>=$debit_three['real_amount'])
				{
					//已还清现金额度
					$this->u_order_debit_model->update(array('repayment'=>$debit_three['real_amount'],'status'=>'2','modtime'=>$addtime),array('order_id'=>$one['order_id'],'type'=>'1'));
				}
				else
				{
					$this->u_order_debit_model->update(array('repayment'=>$re_money3,'modtime'=>$addtime),array('order_id'=>$one['order_id'],'type'=>'1'));
				}
			}
			
			
		}
		//end
	
	}
	
	
	
}