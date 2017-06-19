<?php

/**
流量活动接口
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//继承APP_Controller类
class Flow_activity extends APP_Controller {

    private $access_token = '';
    private $userid = 0;
   // private $url = 'http://m.1b1u.com/home/flow_activity/';	
    private $url = 'http://m.1b1u.com/home/tui_activity/';		
    public function __construct() {
        parent::__construct();
        header('Content-type: application/json;charset=utf-8');  //文档为json格式
        // 允许ajax POST跨域访问
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
		$this->access_token = $this->input->get('number', true); //获取用户登陆access_token
		if(!empty($this->access_token)){
			$this->userid = $this->F_get_mid($this->access_token);			
		}
        if(empty($this->userid)){
			echo json_encode ( array(
					"msg" => '请先登录',
					"code" => '0001',
			) );
			exit ();			
		}
    }


	/**
	 * 流量活动中领取流量
	 */
	public function flow_activity_receive() {
		$uid = $this->userid;
		$str_sql = "select id,status from wx_flow_activity_member where member_id=".$uid;
		$wx_flow_activity_member_data = $this->db->query($str_sql)->result_array();
		if(!empty($wx_flow_activity_member_data)){
			$wx_flow_activity_member_data = $wx_flow_activity_member_data[0];
			if($wx_flow_activity_member_data['status']==0){
				//判断领取人数超过15k
				$str_sql = "select count(id) as num from wx_flow_activity_member where status=1";
				$wx_flow_activity_member_data = $this->db->query($str_sql)->result_array();
				if(!empty($wx_flow_activity_member_data)){
					$wx_flow_activity_member_data = $wx_flow_activity_member_data[0]['num'];
				}
				if(!empty($wx_flow_activity_member_data) && $wx_flow_activity_member_data<20000){//激活人数小于20k的可以参与活动							
					$str_sql = "select member_id,member_get_flow,member_get_money,to_member_get_flow from wx_flow_activity_rec where to_member_id=".$uid;
					$wx_flow_activity_rec_data = $this->db->query($str_sql)->result_array();
					if(!empty($wx_flow_activity_rec_data)){
						$wx_flow_activity_rec_data = $wx_flow_activity_rec_data[0];
						$member_id = $wx_flow_activity_rec_data['member_id'];
						$member_get_flow = $wx_flow_activity_rec_data['member_get_flow'];
						$member_get_money = $wx_flow_activity_rec_data['member_get_money']; 
						$to_member_get_flow = $wx_flow_activity_rec_data['to_member_get_flow'];
						$time = time();
						$this->db->trans_begin();//事务
						$this->db->query("update wx_flow_activity_rec set status=1,activatytime={$time} where to_member_id = {$uid}");
						$this->db->query("update wx_flow_activity_member set `flownums`=`flownums`+{$to_member_get_flow},status=1 where member_id = {$uid}");//自己增加流量	
						$data = array(
							'member_id'=>$uid,									
							'flownums'=>$to_member_get_flow,
							'type' => 0,
							'info' => '参与流量活动获取流量',
							'addtime' => $time,									
						);	
						$this->db->insert ( 'wx_flow_activity_flowlog', $data );//自己增加流量记录
						if($member_id>0){
							$str_sql = "select utype from wx_flow_activity_member where member_id=".$member_id;
							$wx_flow_activity_member_data = $this->db->query($str_sql)->result_array();	
							if(!empty($wx_flow_activity_member_data)){
								$wx_flow_activity_member_data = $wx_flow_activity_member_data[0];
								if($wx_flow_activity_member_data['utype']==1){//判断为直推人
									$this->db->query("update wx_flow_activity_member set `money`=`money`+{$member_get_money} where member_id = {$member_id}");//推荐人增加钱不加流量							
									/*							
									$this->db->query("update wx_flow_activity_member set `flownums`=`flownums`+{$member_get_flow},`money`=`money`+{$member_get_money},status=1 where member_id = {$member_id}");//推荐人增加流量及钱
									$data = array(
										'member_id'=>$member_id,									
										'flownums'=>$member_get_flow,
										'type' => 0,
										'info' => '在流量活动中推荐好友获取流量',
										'addtime' => $time,									
									);	
									$this->db->insert ( 'wx_flow_activity_flowlog', $data );//推荐人增加流量记录
									*/									
								}else{//普通推荐人
									$this->db->query("update wx_flow_activity_member set `flownums`=`flownums`+{$member_get_flow} where member_id = {$member_id}");//推荐人增加流量
									$data = array(
										'member_id'=>$member_id,									
										'flownums'=>$member_get_flow,
										'type' => 0,
										'info' => '在流量活动中推荐好友获取流量',
										'addtime' => $time,									
									);	
									$this->db->insert ( 'wx_flow_activity_flowlog', $data );//推荐人增加流量记录									
								}								
							}
						}
						if ($this->db->trans_status() === FALSE) {
							$this->db->trans_rollback();
							$msg = '网络原因，领取失败，请再试一下';
							$code ="4000";	
						} else {
							$this->db->trans_commit();
							$msg = '领取成功';
							$code ="3000";	
						}					
					}else{
						$msg = '参与活动操作失败';
						$code ="5000";						
					}				
				}else{
					$msg = '活动已经结束';
					$code ="6000";						
				}		
			}else{
				$msg = '您已经领取过了';
				$code ="2000";					
			}
		}else{
			$msg = '您还没有参与此活动';
			$code ="1000";			
		}	
		echo json_encode ( array(
				"msg" => $msg,
				"code" => $code,
		) );
		exit ();		
	}

	/**
	 * 流量活动中积分兑换流量,1个积分换1M流量,且目前一次只换20积分
	 */
	public function flow_activity_point_to_flow() {
		$uid = $this->userid;
		$str_sql = "select status from wx_flow_activity_member where member_id=".$uid;
		$wx_flow_activity_member_data = $this->db->query($str_sql)->result_array();
		if(!empty($wx_flow_activity_member_data)){
			$str_sql = "select points from u_member where mid=".$uid;
			$u_member_data = $this->db->query($str_sql)->result_array();
			if(!empty($u_member_data) && $u_member_data[0]['points']>=20){
				$points = $u_member_data[0]['points'];
				$time = time();
				$this->db->trans_begin();//事务
				$this->db->query("update u_member set `points`=`points`-20 where mid = {$uid}");//消耗积分
				$data = array(
					'member_id'=>$uid,									
					'points'=>20,
					'type' => 1,
					'ptype' => 2,				
					'info' => '使用积分兑换流量',
					'addtime' => $time,									
				);	
				$this->db->insert ( 'u_points_log', $data );//消耗积分记录
				
				$this->db->query("update wx_flow_activity_member set `flownums`=`flownums`+20 where member_id = {$uid}");//增加流量	
				$data = array(
					'member_id'=>$uid,									
					'flownums'=>20,
					'type' => 0,
					'info' => '使用积分兑换流量',
					'addtime' => $time,									
				);	
				$this->db->insert ( 'wx_flow_activity_flowlog', $data );//增加流量记录
				
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$msg = '网络原因，兑换失败，请再试一下';
					$code ="4000";	
				} else {
					$this->db->trans_commit();
					$msg = '兑换成功';
					$code ="3000";	
				}					
			}else{
				$msg = '您积分不足';
				$code ="1000";			
			}	
		}else{
			$msg = '您还没有参与流量活动，不能兑换流量';
			$code ="5000";			
		}			
		echo json_encode ( array(
				"msg" => $msg,
				"code" => $code,
		) );
		exit ();		
	}
	
	/**
	 * 流量活动中直推的我推荐的人(全民拉新)
	 */
	public function flow_activity_zhime_rec() {
		$uid = $this->userid;
		$data = array();
		$str_sql = "select count(id)as nums from wx_flow_activity_rec where status=1 and member_id=".$uid;//统计自己推荐了多个人
		$wx_flow_activity_rec_data = $this->db->query($str_sql)->result_array();
		if(!empty($wx_flow_activity_rec_data)){
			$wx_flow_activity_rec_data = $wx_flow_activity_rec_data[0]['nums'];			
		}else{
			$wx_flow_activity_rec_data = 0;				
		}
		$data['nums']=$wx_flow_activity_rec_data;
		
		$str_sql = "select flownums,money,utype,status from wx_flow_activity_member where member_id=".$uid;
		$wx_flow_activity_member_data = $this->db->query($str_sql)->result_array();	
		if(!empty($wx_flow_activity_member_data)){
			$wx_flow_activity_member_data = $wx_flow_activity_member_data[0];			
		}else{
			$wx_flow_activity_member_data = array('flownums'=>0,'money'=>0,'utype'=>0,'status'=>0);				
		}		
		$data['activity_member']=$wx_flow_activity_member_data;
		$data['share_url'] = $this->url.'?uid='.intval($uid);
		//$data['share_url'] = $this->url.'?&BY='.base64_encode(intval($uid)*1).'&';		
		echo json_encode ( array(
				"data" => $data,
		) );
		exit ();			
	}	
	
	/**
	 * 流量活动中我推荐的人(流量送送送)
	 */
	public function flow_activity_me_rec() {
		$uid = $this->userid;
		$data = array();
		$str_sql = "select count(id)as nums from wx_flow_activity_rec where status=1 and member_id=".$uid;//统计自己推荐了多个人
		$wx_flow_activity_rec_data = $this->db->query($str_sql)->result_array();
		if(!empty($wx_flow_activity_rec_data)){
			$wx_flow_activity_rec_data = $wx_flow_activity_rec_data[0]['nums'];			
		}else{
			$wx_flow_activity_rec_data = 0;				
		}
		$data['nums']=$wx_flow_activity_rec_data;
		
		$str_sql = "select flownums,money,utype,status from wx_flow_activity_member where member_id=".$uid;
		$wx_flow_activity_member_data = $this->db->query($str_sql)->result_array();	
		if(!empty($wx_flow_activity_member_data)){
			$wx_flow_activity_member_data = $wx_flow_activity_member_data[0];			
		}else{
			$wx_flow_activity_member_data = array('flownums'=>0,'money'=>0,'utype'=>0,'status'=>0);				
		}			
		$data['activity_member']=$wx_flow_activity_member_data;
		$data['share_url'] = $this->url.'?uid='.intval($uid);
		//$data['share_url'] = $this->url.'?&BY='.base64_encode(intval($uid)*1).'&';
		echo json_encode ( array(
				"data" => $data,
		) );
		exit ();				
	}	

	/**
	 * 流量活动列表菜单
	 */
	public function flow_activity_menu() {
		$uid = $this->userid;
		$data = array();
		$str_sql = "select flownums,money,utype,status from wx_flow_activity_member where member_id=".$uid;
		$wx_flow_activity_member_data = $this->db->query($str_sql)->result_array();	
		if(!empty($wx_flow_activity_member_data)){
			$wx_flow_activity_member_data = $wx_flow_activity_member_data[0];
			$data['activity_is']=1;//参与活动			
		}else{
			$wx_flow_activity_member_data = array('flownums'=>0,'money'=>0,'utype'=>0,'status'=>0);	
			$data['activity_is']=0;//未参与活动				
		}
        if($data['activity_is']==1){
			$data['activity_member']=$wx_flow_activity_member_data;
			$data['share_url'] = $this->url.'?uid='.intval($uid);
			//$data['share_url'] = $this->url.'?&BY'.base64_encode(intval($uid)*1).'&';
			if($wx_flow_activity_member_data['utype']==1){//直推的,全民拉新
				$data['webinfo'] = array(
					'action_name' => '校园拉新',
					'activity_name' => "我分享一个红包给你哦，我领过了，是真的！",
					'activity_pic' => "http://m.1b1u.com/static/img/hongbao.jpg",
					'activity_url' => $data['share_url'],
					'activity_describe' => '领红包集好运，就可以去旅游啦，快试试手气！',
					'url' => "http://m.1b1u.com/member_activity/tui_activity_zhime_rec",			
				);				
			}else{
				$data['webinfo'] = array(
					'action_name' => '流量送送送',
					'activity_name' => "您的好友送你50M流量，快去抢！",
					'activity_pic' => "http://m.1b1u.com/static/img/flow_action_ico.jpg",
					'activity_describe' => $data['share_url'],
					'url' => "http://m.1b1u.com/member_activity/flow_activity_me_rec",			
				);						
			}			
		}		
		echo json_encode ( array(
				"data" => $data,
		) );
		exit ();						
	}	
	
	/**
	 * 流量活动中积分中心
	 */
	public function flow_activity_point() {
		$uid = $this->userid;
		$data = array();
		$str_sql = "select points from u_member where mid=".$uid;
		$u_member_data = $this->db->query($str_sql)->result_array();
		if(!empty($u_member_data)){
			$u_member_data = $u_member_data[0]['points'];			
		}else{
			$u_member_data = 0;				
		}
		$data['nums']=$u_member_data;
		$data['share_url'] = $this->url.'?uid='.intval($uid);
		//$data['share_url'] = $this->url.'?&BY='.base64_encode(intval($uid)*1).'&';	
		echo json_encode ( array(
				"data" => $data,
		) );
		exit ();						
	}	

}

/* End of file webservices.php */
/* Location: ./application/controllers/webservices.php */