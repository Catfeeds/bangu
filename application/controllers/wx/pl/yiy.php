<?php
class yiy extends UC_NL_Controller {
	
	public function __construct() {
		parent::__construct ();
		set_error_handler('customError');
		$this->db = $this->load->database ( "default", TRUE );
		$this->load_model ( 'wx/wx_member_model', 'wx_member_model' );
		$this->load->model ( 'member_model' );
		$this->load->library ( 'callback' );
	}
	/**
	 * 增加记录，参与活动
	 * */
	public function write_activity()
	{
		$member_id=$this->input->post('member_id',true);
		$activity_id=$this->input->post('activity_id',true);
		$time=date("Y-m-d H:i:s");
		$this->load_model ( 'wx/wx_member_activity_model', 'wx_member_activity_model' );
		//$this->load_model ( 'wx/wx_activity_model', 'wx_activity_model' );
		//$activity=$this->wx_activity_model->row(array('code'=>$code,'status'=>'1'));
		$where=array('wx_member_id'=>$member_id,'wx_activity_id'=>$activity_id);
		$data=array('wx_member_id'=>$member_id,'wx_activity_id'=>$activity_id,'addtime'=>$time);
		$exist=$this->wx_member_activity_model->row($where);
		$result=0;
		if(empty($exist))
		{
		$result=$this->wx_member_activity_model->insert($data);
		}
	    return $result;
	}
	
	/**
	 * 查看参与微信摇一摇的人数
	 * */
	public function wx_member_total($activity_id="")
	{
		$this->load_model ( 'wx/wx_member_activity_model', 'wx_member_activity_model' );
		$this->load_model ( 'wx/wx_activity_model', 'wx_activity_model' );
		$callback = empty($_REQUEST["callback"]) ? '' : $_REQUEST['callback'];
		$where=array();
		$return=array('code'=>0,'data'=>'');
		
		$where['wx_activity_id']=$activity_id;
		
		$return['data']=$this->wx_member_activity_model->num_rows($where);
		echo $callback."(".json_encode($return).")";
		//echo json_encode($return);
	} 
	/**
	 * 查看参与微信摇一摇的人数
	 * */
	public function member_total($activity_id="")
	{
		$this->load_model ( 'wx/wx_member_activity_model', 'wx_member_activity_model' );
		$this->load_model ( 'wx/wx_activity_model', 'wx_activity_model' );
		
		$where=array();
		$return=array('code'=>0,'data'=>'');
	
		$where['wx_activity_id']=$activity_id;
	
		$return['data']=$this->wx_member_activity_model->num_rows($where);
		echo json_encode($return);
		//echo json_encode($return);
	}
	/**
	 * 查看参与微信摇一摇的人数
	 * */
	public function get_gift_list()
	{
		$supplier_where=$this->input->post('supplier_where',true);
		$activity_id=$this->input->post('activity_id',true);
		$this->load_model ( 'wx/wx_gift_model', 'wx_gift_model' );
		$output=$this->wx_gift_model->all('(status=0) and activity_id='.$activity_id.' and '.$supplier_where);
		echo json_encode($output);
	}
	/**
	 * 中奖名单
	 * */
	public function get_gift_member()
	{
		$where=array();
		$member_id=$this->input->post('member_id',true);
		$activity_id=$this->input->post('activity_id',true);
		$sql = "select gm.*,g.logo,g.gift_name,g.big_pic,g.level,g.num,g.link,m.mobile,wm.nickname
				from 
				wx_gift_member as gm left join wx_gift as g on gm.gift_id=g.id 
				left join wx_member as wm on gm.member_id=wm.id
				left join u_member as m on wm.member_id=m.mid
				where gm.status=0";
		if($member_id)
		$sql.=" and gm.member_id={$member_id}";
		if($activity_id)
			$sql.=" and gm.activity_id={$activity_id}";
		$sql.=" order by g.level,gm.addtime desc";
		
		$query = $this->db->query ( $sql );
		$output=$query->result_array();
		echo json_encode($output);
	}
	/**
	 * 中奖名单
	 * */
	public function get_gift_member2()
	{
		$where=array();
		$member_id=$this->input->post('member_id',true);
		$activity_id="2";
		$sql = "select gm.*,g.logo,g.gift_name,g.big_pic,g.level,g.num,g.link,m.mobile,wm.nickname
				from
				wx_gift_member as gm left join wx_gift as g on gm.gift_id=g.id
				left join wx_member as wm on gm.member_id=wm.id
				left join u_member as m on wm.member_id=m.mid
				where gm.status=0";
		if($member_id)
			$sql.=" and gm.member_id={$member_id}";
		if($activity_id)
			$sql.=" and gm.activity_id={$activity_id}";
		$sql.=" order by g.level,gm.addtime desc";
	
		$query = $this->db->query ( $sql );
		$output=$query->result_array();
		echo json_encode($output);
	}
	
	/**
	 * 中奖名单:ajax
	 * */
	public function get_gift_member_ajax()
	{
		$callback = empty($_REQUEST["callback"]) ? '' : $_REQUEST['callback'];
		$where=array();
		$member_id=$this->input->get('member_id',true);
		$activity_id=$this->input->get('activity_id',true);
		$sql = "select gm.*,g.logo,g.gift_name,g.big_pic,g.level,g.num,g.link from wx_gift_member as gm left join wx_gift as g on gm.gift_id=g.id where gm.status=0";
		if($member_id)
			$sql.=" and gm.member_id={$member_id}";
		if($activity_id)
			$sql.=" and gm.activity_id={$activity_id}";
		$sql.=" order by g.level,gm.addtime desc";
	
		$query = $this->db->query ( $sql );
		$output=$query->result_array();
		echo $callback."(".json_encode($output[0]).")";
	}
	/**
	 * 是否已经通过第一步
	 * */
	public function is_pass()
	{
		$member_id=$this->input->post('member_id',true);
		$activity_id=$this->input->post('activity_id',true);
		$this->load_model ( 'wx/wx_member_activity_model', 'wx_member_activity_model' );
		$result=$this->wx_member_activity_model->row(array('wx_member_id'=>$member_id,'wx_activity_id'=>$activity_id));
		echo json_encode($result);
	}
	/**
	 * 是否已经通过第一步
	 * */
	public function view_num()
	{
		$activity_id=$this->input->post('activity_id',true);
		$this->load_model ( 'wx/wx_activity_model', 'wx_activity_model' );
		$row=$this->wx_activity_model->row(array('id'=>$activity_id));
		$num=$row['view_num']+1;
		$status=$this->wx_activity_model->update(array('view_num'=>$num),array('id'=>$activity_id));
		$ret['status']=$status;
		echo json_encode($ret);
	}
	/**
	 * 更新手机号
	 * */
	public function update_mobile_ajax()
	{
		$callback = empty($_REQUEST["callback"]) ? '' : $_REQUEST['callback'];
		$member_id=$this->input->get('member_id',true);
		$mobile=$this->input->get('mobile',true);
		$this->load_model ( 'wx/wx_member_model', 'wx_member_model' );
		$data=array('mobile'=>$mobile);
		$where=array('id'=>$member_id);
		$result=$this->wx_member_model->update($data,$where);
		$ret=array('code'=>'2000','msg'=>'ok','mobile'=>$mobile,'member_id'=>$member_id);
		
		echo $callback."(".json_encode($ret).")";
	}
	/**
	 * 是否已经中过奖
	 * */
	public function is_yiy()
	{
		$member_id=$this->input->post('member_id',true);
		$activity_id=$this->input->post('activity_id',true);
		$this->load_model ( 'wx/wx_gift_member_model', 'wx_gift_member_model' );
		$result=$this->wx_gift_member_model->row(array('member_id'=>$member_id,'activity_id'=>$activity_id));
		echo json_encode($result);
	}
	/**
	 * 是否已经中过奖:ajax
	 * */
	public function is_yiy_ajax()
	{
		$callback = empty($_REQUEST["callback"]) ? '' : $_REQUEST['callback'];
		$member_id=$this->input->get('member_id',true);
		$activity_id=$this->input->get('activity_id',true);
		$this->load_model ( 'wx/wx_gift_member_model', 'wx_gift_member_model' );
		$result=$this->wx_gift_member_model->row(array('member_id'=>$member_id,'activity_id'=>$activity_id));
		echo $callback."(".json_encode($result).")";
	}
	
	/**
	 * 抽奖 code:0 正常  -1未中奖  -2数据异常
	 * */
	public function lottery()
	{
		$ret=array('code'=>'-1','data'=>'','msg'=>'未中奖');
		$this->load_model ( 'wx/wx_gift_model', 'wx_gift_model' );
		$this->load_model ( 'wx/wx_gift_member_model', 'wx_gift_member_model' );
		//$where_supplier="(supplier_id=0 or supplier_id=1)";
		$where_supplier=$this->input->get('where_supplier',true);
		$member_id=$this->input->get('member_id',true);
		$activity_id=$this->input->get('activity_id',true);
		//$member_id="436";
		$callback = empty($_REQUEST["callback"]) ? '' : $_REQUEST['callback'];
		$result=$this->wx_gift_model->enable_gift($where_supplier,$activity_id);//礼品列表
		$member_phone=$this->wx_gift_model->member_phone($member_id);//会员表（平台用户表）：手机号
		$mobile=$member_phone['mobile'];
		$mid=$member_phone['mid']; //平台用户id，用来送优惠券
		$proArr=array(); //随机数组
		foreach ($result as $i=>$value)
		{
			$proArr[$value['id']]=$value['probability']*10000;
		}
		$gift_id=$this->get_rand($proArr);//随机选出的礼品id
		$gift_row=array();//中奖礼品
		$yes=$proArr[$gift_id];
		$rand_num=rand(1, 10000);
		if($rand_num<=$yes)
		{
			//echo "中奖";
			//返回结果
			foreach ($result as $j=>$val)
			{
				if($val['id']==$gift_id)
					$gift_row=$val;
			}
			//若中旅游红包奖，则送320优惠券
			if($gift_row['is_coupon']=="1")
			{
				$this->give_coupon($mid);
			}
			//中奖数据处理
			$insert_data=array(
					'gift_num'=>'1',
					'addtime'=>date('Y-m-d H:i:s'),
					'channel'=>'0',
					'gift_id'=>$gift_id,
					'member_id'=>$member_id,
					'activity_id'=>$activity_id,
					'status'=>'0'
	                 
			);
			$update=array('num'=>$gift_row['num']-1);
			$update_where=array('id'=>$gift_id);
			$this->db->trans_start();//事务开启--------
			$this->wx_gift_member_model->insert($insert_data);
			$this->wx_gift_model->update($update,$update_where);
			$this->db->trans_complete();//事务结束----------
			if ($this->db->trans_status() === TRUE)
			{
				$content="";
				if($activity_id=='2')
				{
					if($gift_row['level']=='1')
					{
						$content="恭喜您获得".$gift_row['gift_name']."奖品!名额有效期至：2016-06-31；出行规则：在有效期到来之前，工作人员会提供3次出行日期，请用户妥善安排出行计划，如3次出行机会都放弃则名额作废，联系点话:0755-25132262(工作日9:00-18:00)";
					}
					elseif($gift_row['level']=='2')
					{
						$content="恭喜您获得".$gift_row['gift_name']."奖品!名额有效期至：2016-06-31；使用规则：在两个工作日内。工作人员将温泉景点信息发送至中奖用户，如有疑问，请咨询0755-25132262";
					}
					elseif($gift_row['level']=='3')
					{
						$content="恭喜您获得320元旅游红包，请登录http://1b1u.com 使用。如有疑问，可咨询帮游客服热线0755-25132560，感谢您的参与。一帮一游，遂您所愿。";
					}
				}
				else if($activity_id=='3')
				{
					if($gift_row['level']=='2')
					{
						$content="恭喜您获得".$gift_row['gift_name']."奖品!名额有效期至：2016-06-31；使用规则：在两个工作日内。工作人员将漂流景点信息发送至中奖用户，如有疑问，请咨询0755-25132262";
					}
					elseif($gift_row['level']=='3')
					{
						$content="恭喜您获得320元旅游红包，请登录http://1b1u.com 使用。如有疑问，可咨询帮游客服热线0755-25132560，感谢您的参与。一帮一游，遂您所愿。";
					}
				}
				elseif($activity_id=='4')
				{
					if($gift_row['level']=='1')
					{
						$content="恭喜您获得".$gift_row['gift_name']."奖品!名额有效期至：2016-06-31；出行规则：在有效期到来之前，工作人员会提供3次出行日期，请用户妥善安排出行计划，如3次出行机会都放弃则名额作废，联系点话:0755-25132262(工作日9:00-18:00)";
					}
					elseif($gift_row['level']=='2')
					{
						$content="恭喜您获得".$gift_row['gift_name']."奖品!名额有效期至：2016-06-31；使用规则：在两个工作日内。工作人员将温泉景点信息发送至中奖用户，如有疑问，请咨询0755-25132262";
					}
					elseif($gift_row['level']=='3')
					{
						$content="恭喜您获得".$gift_row['gift_name']."奖品!；使用规则：在两个工作日内。工作人员将联系中奖用户，如有疑问，请咨询0755-25132262";
					}
					elseif($gift_row['level']=='4')
					{
						$content="恭喜您获得320元旅游红包，请登录http://1b1u.com 使用。如有疑问，可咨询帮游客服热线0755-25132560，感谢您的参与。一帮一游，遂您所愿。";
					}
				}
				$sta=$this->send_message($mobile, $content);
				
				$ret['code']="0";
				$ret['msg']="中奖";
				$ret['data']=$gift_row;
			}
			else
			{
				$this->db->trans_rollback();//事务回滚
				$ret['code']="-2";
				$ret['msg']="数据操作异常";
			}
				
		}
		else
		{
			//echo "没中奖";
		}
	
		echo $callback."(".json_encode($ret).")";
	}
	/**
	 * 抽奖 code:0 正常  -1未中奖  -2数据异常
	 * */
	public function lottery2()
	{
		$ret=array('code'=>'-1','data'=>'','msg'=>'未中奖');
		$this->load_model ( 'wx/wx_gift_model', 'wx_gift_model' );
		$this->load_model ( 'wx/wx_gift_member_model', 'wx_gift_member_model' );
		
		$where_supplier=$this->input->get('where_supplier',true);
		$member_id=$this->input->get('member_id',true);
		$activity_id=$this->input->get('activity_id',true);
		
		$member_id="436";
		$activity_id="4";
		$where_supplier="(supplier_id=0 or supplier_id=1)";
		
		$callback = empty($_REQUEST["callback"]) ? '' : $_REQUEST['callback'];
		$result=$this->wx_gift_model->enable_gift($where_supplier,$activity_id);//礼品列表
		$member_phone=$this->wx_gift_model->member_phone($member_id);//会员表（平台用户表）：手机号
		$mobile=$member_phone['mobile'];
		$mid=$member_phone['mid']; //平台用户id，用来送优惠券
		$proArr=array(); //随机数组
		foreach ($result as $i=>$value)
		{
			$proArr[$value['id']]=$value['probability']*10000;
		}
		$gift_id=$this->get_rand($proArr);//随机选出的礼品id
		
		$gift_row=array();//中奖礼品
		$yes=$proArr[$gift_id];
		$rand_num=rand(1, 10000);
		if($rand_num<=$yes)
		{
			//echo "中奖";
			//返回结果
			foreach ($result as $j=>$val)
			{
				if($val['id']==$gift_id)
					$gift_row=$val;
			}
			
			//若中旅游红包奖，则送320优惠券
			if(in_array($gift_row['level'], $this->coupon_arr))
			{
				$re=$this->give_coupon($mid);
				
			}
			//中奖数据处理
			$insert_data=array(
					'gift_num'=>'1',
					'addtime'=>date('Y-m-d H:i:s'),
					'channel'=>'0',
					'gift_id'=>$gift_id,
					'member_id'=>$member_id,
					'activity_id'=>$activity_id,
					'status'=>'0'
	
			);
			$update=array('num'=>$gift_row['num']-1);
			$update_where=array('id'=>$gift_id);
			$this->db->trans_start();//事务开启--------
			$this->wx_gift_member_model->insert($insert_data);
			$this->wx_gift_model->update($update,$update_where);
			$this->db->trans_complete();//事务结束----------
			if ($this->db->trans_status() === TRUE)
			{
				$content="";
				if($activity_id=='2')
				{
					if($gift_row['level']=='1')
					{
						$content="恭喜您获得".$gift_row['gift_name']."奖品!名额有效期至：2016-06-31；出行规则：在有效期到来之前，工作人员会提供3次出行日期，请用户妥善安排出行计划，如3次出行机会都放弃则名额作废，联系点话:0755-25132262(工作日9:00-18:00)";
					}
					elseif($gift_row['level']=='2')
					{
						$content="恭喜您获得".$gift_row['gift_name']."奖品!名额有效期至：2016-06-31；使用规则：在两个工作日内。工作人员将温泉景点信息发送至中奖用户，如有疑问，请咨询0755-25132262";
					}
					elseif($gift_row['level']=='3')
					{
						$content="恭喜您获得320元旅游红包，请登录http://1b1u.com 使用。如有疑问，可咨询帮游客服热线0755-25132560，感谢您的参与。一帮一游，遂您所愿。";
					}
				}
				else if($activity_id=='3')
				{
					if($gift_row['level']=='2')
					{
						$content="恭喜您获得".$gift_row['gift_name']."奖品!名额有效期至：2016-06-31；使用规则：在两个工作日内。工作人员将漂流景点信息发送至中奖用户，如有疑问，请咨询0755-25132262";
					}
					elseif($gift_row['level']=='3')
					{
						$content="恭喜您获得320元旅游红包，请登录http://1b1u.com 使用。如有疑问，可咨询帮游客服热线0755-25132560，感谢您的参与。一帮一游，遂您所愿。";
					}
				}
				elseif($activity_id=='4')
				{
					if($gift_row['level']=='1')
					{
						$content="恭喜您获得".$gift_row['gift_name']."奖品!名额有效期至：2016-06-31；出行规则：在有效期到来之前，工作人员会提供3次出行日期，请用户妥善安排出行计划，如3次出行机会都放弃则名额作废，联系点话:0755-25132262(工作日9:00-18:00)";
					}
					elseif($gift_row['level']=='2')
					{
						$content="恭喜您获得".$gift_row['gift_name']."奖品!名额有效期至：2016-06-31；使用规则：在两个工作日内。工作人员将温泉景点信息发送至中奖用户，如有疑问，请咨询0755-25132262";
					}
					elseif($gift_row['level']=='3')
					{
						$content="恭喜您获得".$gift_row['gift_name']."奖品!；使用规则：在两个工作日内。工作人员将联系中奖用户，如有疑问，请咨询0755-25132262";
					}
					elseif($gift_row['level']=='4')
					{
						$content="恭喜您获得320元旅游红包，请登录http://1b1u.com 使用。如有疑问，可咨询帮游客服热线0755-25132560，感谢您的参与。一帮一游，遂您所愿。";
					}
				}
				$sta=$this->send_message($mobile, $content);
	
				$ret['code']="0";
				$ret['msg']="中奖";
				$ret['data']=$gift_row;
			}
			else
			{
				$this->db->trans_rollback();//事务回滚
				$ret['code']="-2";
				$ret['msg']="数据操作异常";
			}
	
		}
		else
		{
			//echo "没中奖";
		}
	
		echo $callback."(".json_encode($ret).")";
	}
	/**
	 * 补送优惠券（废）
	 * */
	public function send_again()
	{
		$this->load->model('common/cou_member_coupon_model','cou_member_coupon');
		$result=$this->db->query("select 
                                         gm.id,wm.member_id,wm.nickname,wm.id as wx_member_id
				                  from 
				                        wx_gift_member as gm 
				                        left join wx_member as wm on gm.member_id=wm.id
				                  where (gm.gift_id=3 or gm.gift_id=10 or gm.gift_id=6) and wm.member_id!=0
				                        and gm.id>=5500 and gm.id<=5947
				                  order by id desc
				 ")->result_array();
		$num=0;
		$this->db->trans_start();//事务开启--------
		foreach ($result as $key=>$value)
		{
			$one=$this->cou_member_coupon->num_rows(array('member_id'=>$value['member_id'],'status'=>'0'));
			
			if($one=="0")
			{
			$this->give_coupon($value['member_id']);
			$this->db->insert('wx_log', array('member_id'=>$value['member_id'],'wx_member_id'=>$value['wx_member_id'],'gift_member_id'=>$value['id']));
			$num++;
			}
		}
		$this->db->trans_complete();//事务结束----------
		if ($this->db->trans_status() === TRUE)
		{
		echo "总共：".count($result)."<br />没有优惠券的:".$num;
		}
		else 
		{
			echo "事务回滚";
		}
	}
	/**
	 * 给指定用户id发价值320元旅游红包(优惠券)
	 *
	 * */
	protected function give_coupon($mid)
	{
		//注册送积分、优惠券
		$this->load->model('wx/cou_action_model','cou_action');
		$this->load->model('common/cou_member_coupon_model','cou_member_coupon');
		
		$coupon=$this->cou_action->give_register_coupon('REGISTER_APP');
		
		$user=$this->member_model->row(array('mid'=>$mid));
		$one=$this->cou_member_coupon->all(array('member_id'=>$mid,'status'=>'0'));
		//送优惠券,不重复送
		if(empty($one))
		{
			foreach ($coupon as $item=>$value)
			{
				$num=isset($value['number'])?$value['number']:'0';
				for($i=0;$i<$num;$i++)
				{
					$data=array('coupon_id'=>$value['coupon_id'],'member_id'=>$mid,'status'=>'0');
					$re=$this->cou_member_coupon->insert($data);//送优惠券
				}
			}
		}
		return true;
	}
	/**
	 * 发送短信
	 * 
	 * */
	public function send_message_ajax()
	{
		$callback = empty($_REQUEST["callback"]) ? '' : $_REQUEST['callback'];
		$member_id=$this->input->get('member_id',true);//用户id
		$content=$this->input->get('content',true);//短信内容
		$member_phone=$this->wx_gift_model->member_phone($member_id);//用户手机号
		$mobile=$member_phone['mobile'];
		$status=$this->send_message($mobile, $content);
		$ret=array('code'=>'2000','msg'=>'ok');
		if(!$status)
		{
			$ret['code']="-1";
			$ret['msg']='短信发送失败';
		}
		echo $callback."(".json_encode($ret).")";
	}
	/**
	 * 随机
	 * @$proArr: $proArr=array('a'=>50,'b'=>20,'c'=>40);
	 * */
	private function get_rand($proArr) 
	{
    $result = '';
    //概率数组的总概率精度 
    $proSum = array_sum($proArr);
    //概率数组循环 
    foreach ($proArr as $key => $proCur) {
        $randNum = mt_rand(1, $proSum);
        if ($randNum <= $proCur) {
            $result = $key;
            break;
        } else {
            $proSum -= $proCur;
        }
    }
    unset ($proArr);
    return $result;
}
	
	
	
}