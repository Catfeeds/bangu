<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @since 2015年5月24日10:19:53
 * @author xml    
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Banguxia_statistics extends UA_Controller
{	
	const pagesize = 10; //分页的页数	
	public function __construct()
	{
		parent::__construct ();	
	}
	
	
	
	/**
	 * @method 直推用户列表
	 * @author xml
	 * @since  2016-5-24 
	 */
	public function zindex($page=1)
	{
		$starttime = $this ->input ->get('starttime' ,true);
		$endtime = $this ->input ->get('endtime' ,true);		
		$status = $this ->input ->get('status' ,true);	
                $tel = $this->input->get('tel', TRUE);
		$param = array();
		$param['starttime'] = $starttime;
		$param['endtime'] = $endtime;		
		if($this ->input ->get('page' ,true)){
			$page = $this ->input ->get('page' ,true);
		}			
		$urldata = array();	
		parse_str($_SERVER['QUERY_STRING'],$urldata);
		unset($urldata['page']);
		$urlstr ='?';
		foreach($urldata as $k => $v){
			$urlstr .=$k.'='.$v.'&';
		}		
		
		$data = array();
		$this->load->library ( 'Page' ); // 加载分页类
		$config['base_url'] = '/admin/a/banguxia_statistics/zindex/'.$urlstr.'&page=';
		$config ['pagesize'] = self::pagesize;
		$config ['page_now'] = $page;		
	
		$where_sql = ' wm.utype=1 ';
		if(!empty($param['starttime'])){
			$where_sql.=' AND  wm.addtime >="'.strtotime(trim($param['starttime']).' 00:00:00').'" ';
		}
		if(!empty($param['endtime'])){
			$where_sql.=' AND  wm.addtime <="'.strtotime(trim($param['endtime']).' 23:59:59').'" ';
		}
                if (!empty($tel)){      // 魏勇添加
                    $where_sql.=" AND  u.mobile = '{$tel}' ";
                }
		$where_sql1= '';
		$status =1;
		if($status>=0){
			$where_sql.=' AND  wm.status="'.$status.'" ';
			$where_sql1=' status="'.$status.'" ';			
		}		
        $page_size = self::pagesize;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from	
		
		$query_sql2=" select count(wm.id) as total from wx_flow_activity_member as wm left join u_member as u on(wm.member_id=u.mid) where ".$where_sql;		
		$query_sql1=" select wm.*,u.loginname,u.mobile from wx_flow_activity_member as wm left join u_member as u on(wm.member_id=u.mid)  where ".$where_sql." ORDER BY  wm.addtime desc LIMIT {$from},{$page_size}";
		
		$t = $this ->db ->query($query_sql2) ->row_array();
		$total = $t['total'];				
		$wx_flow_activity_member_data = $this ->db ->query($query_sql1) ->result_array();		
		$config ['pagecount'] = $total;
		$data['pageData']= $wx_flow_activity_member_data;
		$data['starttime'] = $starttime;
		$data['endtime'] = $endtime;
		$member_ids = array();
		foreach($wx_flow_activity_member_data as $v){
			$member_ids[$v['member_id']] = $v['member_id'];
		}
		$pep_all = array();
		if(!empty($member_ids)){
			$query_sql=" select count(id) as num,member_id from activity_red_envelope_rec where `activate_status`=1 and member_id in(".implode(",",$member_ids).") GROUP BY member_id ";		
			$pep_array = $this ->db ->query($query_sql) ->result_array();
			foreach($pep_array as $v){
				$pep_all[$v['member_id']] = $v['num'];
			}
		}

		$query_sql=" select count(id) as total from wx_flow_activity_member  where utype=1 and status=1 ";		
		$num_total = $this ->db ->query($query_sql) ->row_array();		
		$num_total = $num_total['total'];		
		
		$data['num_total'] = $num_total;
		$data['status'] = $status;		
		$data['pep_all'] = $pep_all;
		
		$this->page->initialize ( $config );
		$this->load_view ( 'admin/a/flow_activity/banguxia_statistics',$data);
	}
	
	/**
	 * @method 直推用户列表
	 * @author xml
	 * @since  2016-5-24 
	 */
	public function zzindex($page=1)
	{
		
		$starttime = $this ->input ->get('starttime' ,true);
		$endtime = $this ->input ->get('endtime' ,true);		
		$status = $this ->input ->get('status' ,true);
                $tel = $this->input->get('tel', TRUE);
		$zid = $this ->input ->get('zid' ,true);		
		$param = array();
		$param['starttime'] = $starttime;
		$param['endtime'] = $endtime;
		$param['zid'] = $zid;
		
		if($this ->input ->get('page' ,true)){
			$page = $this ->input ->get('page' ,true);
		}			
		$urldata = array();	
		parse_str($_SERVER['QUERY_STRING'],$urldata);
		unset($urldata['page']);
		$urlstr ='?';
		foreach($urldata as $k => $v){
			$urlstr .=$k.'='.$v.'&';
		}		
		
		$data = array();
		$this->load->library ( 'Page' ); // 加载分页类
		$config['base_url'] = '/admin/a/banguxia_statistics/zzindex/'.$urlstr.'&page=';
		$config ['pagesize'] = self::pagesize;
		$config ['page_now'] = $page;		
	
		$where_sql = ' 1 ';
		if(!empty($param['starttime'])){
			$where_sql.=' AND  wm.addtime >="'.strtotime(trim($param['starttime']).' 00:00:00').'" ';
		}
		if(!empty($param['endtime'])){
			$where_sql.=' AND  wm.addtime <="'.strtotime(trim($param['endtime']).' 23:59:59').'" ';
		}
		if(!empty($param['zid'])){
			$where_sql.=' AND  wm.member_id ="'.$param['zid'].'" ';
		}		
                if (!empty($tel)){      // 魏勇添加
                    $where_sql.=" AND  u.mobile = '{$tel}' ";
                }
		$where_sql1= '';
		$status =1;
		if($status>=0){
			$where_sql.=' AND  wm.activate_status="'.$status.'" ';
			$where_sql1=' activate_status="'.$status.'" ';			
		}		
        $page_size = self::pagesize;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from	

		$query_sql2=" select count(wm.id) as total from activity_red_envelope_rec as wm left join u_member as u on(wm.to_member_id=u.mid) where ".$where_sql;		
		$query_sql1=" select wm.*,u.loginname,u.mobile,u.equipment_id equip_id from activity_red_envelope_rec as wm left join u_member as u on(wm.to_member_id=u.mid)  where ".$where_sql." ORDER BY  wm.addtime desc LIMIT {$from},{$page_size}";
		
		$t = $this ->db ->query($query_sql2) ->row_array();
		$total = $t['total'];				
		$wx_flow_activity_member_data = $this ->db ->query($query_sql1) ->result_array();		
		$config ['pagecount'] = $total;
		$data['pageData']= $wx_flow_activity_member_data;
		$data['starttime'] = $starttime;
		$data['endtime'] = $endtime;
		$member_ids = array();
		foreach($wx_flow_activity_member_data as $v){
			$member_ids[$v['member_id']] = $v['member_id'];
		}
		$pep_all = array();
		if(!empty($member_ids)){
			$query_sql=" select count(id) as num,member_id from activity_red_envelope_rec where `activate_status`=1 and member_id in(".implode(",",$member_ids).") GROUP BY member_id ";		
			$pep_array = $this ->db ->query($query_sql) ->result_array();
			foreach($pep_array as $v){
				$pep_all[$v['member_id']] = $v['num'];
			}
		}

		$query_sql=" select count(id) as total from wx_flow_activity_member  where utype=1 and status=1 ";		
		$num_total = $this ->db ->query($query_sql) ->row_array();		
		$num_total = $num_total['total'];		
		
		$data['num_total'] = $num_total;
		$data['status'] = $status;		
		$data['pep_all'] = $pep_all;
		
		$this->page->initialize ( $config );			
		$this->load_view ( 'admin/a/activity_red_envelope/index_list_2',$data);
	}	
	
	
	/**
	 * @method 抢红包活动列表
	 * @author xml
	 * @since  2016-5-24 
	 */
	public function index($page=1)
	{
		$starttime = $this ->input ->get('starttime' ,true);
		$endtime = $this ->input ->get('endtime' ,true);		
		$status = intval($this ->input ->get('status' ,true));
                $tel = $this->input->get('tel', TRUE);
		$mobile = $this ->input ->get('mobile' ,true);		
		$param = array();
		$param['starttime'] = $starttime;
		$param['endtime'] = $endtime;
		$param['mobile'] = $mobile;		
		if($this ->input ->get('page' ,true)){
			$page = $this ->input ->get('page' ,true);
		}			
		$urldata = array();	
		parse_str($_SERVER['QUERY_STRING'],$urldata);
		unset($urldata['page']);
		$urlstr ='?';
		foreach($urldata as $k => $v){
			$urlstr .=$k.'='.$v.'&';
		}		
		
		$data = array();
		$this->load->library ( 'Page' ); // 加载分页类
		$config['base_url'] = '/admin/a/banguxia_statistics/index/'.$urlstr.'&page=';
		$config ['pagesize'] = self::pagesize;
		$config ['page_now'] = $page;		
	
		$where_sql = ' wm.utype=0 ';
		if(!empty($param['starttime'])){
			$where_sql.=' AND  wm.addtime >="'.strtotime(trim($param['starttime']).' 00:00:00').'" ';
		}
		if(!empty($param['endtime'])){
			$where_sql.=' AND  wm.addtime <="'.strtotime(trim($param['endtime']).' 23:59:59').'" ';
		}
		if(!empty($param['mobile'])){
			$where_sql.=' AND  u.mobile ="'.$param['mobile'].'" ';
		}	
                if (!empty($tel)){      // 魏勇添加
                    $where_sql.=" AND  u.mobile = '{$tel}' ";
                }
		$where_sql1= '';
		if(($status-1)>=0){
			$where_sql.=' AND  wm.activate_status="'.($status-1).'" ';
			$where_sql1=' activate_status="'.($status-1).'" ';			
		}		
        $page_size = self::pagesize;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from	
		
		$query_sql2=" select count(wm.id) as total from activity_red_envelope_member as wm left join u_member as u on(wm.member_id=u.mid) where ".$where_sql;		
		$query_sql1=" select wm.*,u.loginname,u.mobile from activity_red_envelope_member as wm left join u_member as u on(wm.member_id=u.mid)  where ".$where_sql." ORDER BY  wm.money desc ,wm.addtime desc LIMIT {$from},{$page_size}";
		
		$t = $this ->db ->query($query_sql2) ->row_array();
		$total = $t['total'];				
		$wx_flow_activity_member_data = $this ->db ->query($query_sql1) ->result_array();		
		$config ['pagecount'] = $total;
		$data['pageData']= $wx_flow_activity_member_data;
		$data['starttime'] = $starttime;
		$data['endtime'] = $endtime;
		$data['mobile'] = $mobile;		
		$member_ids = array();
		foreach($wx_flow_activity_member_data as $v){
			$member_ids[$v['member_id']] = $v['member_id'];
		}
		$pep_all =$pep_all1 =$pep_all2 = array();
		if(!empty($member_ids)){
			$query_sql=" select count(id) as num,member_id from activity_red_envelope_rec where `activate_status`=1 and member_id in(".implode(",",$member_ids).") GROUP BY member_id ";		
			$pep_array = $this ->db ->query($query_sql) ->result_array();
			foreach($pep_array as $v){
				$pep_all[$v['member_id']] = $v['num'];
			}
			$query_sql=" select count(id) as num,member_id from activity_red_envelope_rec where `activate_status`=0 and member_id in(".implode(",",$member_ids).") GROUP BY member_id ";		
			$pep_array1 = $this ->db ->query($query_sql) ->result_array();
			foreach($pep_array1 as $v){
				$pep_all1[$v['member_id']] = $v['num'];
			}	

			$query_sql=" select sum(money) as num,member_id from activity_red_envelope_money_log where `type`=1 and member_id in(".implode(",",$member_ids).") GROUP BY member_id ";		
			$pep_array2 = $this ->db ->query($query_sql) ->result_array();
			foreach($pep_array2 as $v){
				$pep_all2[$v['member_id']] = $v['num'];
			}			
			
		}
		
		$query_sql=" select sum(money) as total  from activity_red_envelope_money_log  where type=0 ";		
		$money_total_jia = $this ->db ->query($query_sql) ->row_array();		
		$money_total_jia = $money_total_jia['total'];		
		
		$query_sql=" select sum(money) as total  from activity_red_envelope_money_log  where type=1 ";		
		$money_total_jian = $this ->db ->query($query_sql) ->row_array();		
		$money_total_jian = $money_total_jian['total'];		
		
		
		$query_sql=" select sum(money) as total from activity_red_envelope_member  where utype=0 and activate_status=1 ";		
		$money_total = $this ->db ->query($query_sql) ->row_array();		
		$money_total = $money_total['total'];	
		
		$query_sql=" select count(id) as total from activity_red_envelope_member  where utype=0 and activate_status=1 ";		
		$num_total = $this ->db ->query($query_sql) ->row_array();		
		$num_total = $num_total['total'];

		$query_sql=" select count(id) as total from activity_red_envelope_member  where utype=0 and activate_status=0 ";		
		$num_total_n = $this ->db ->query($query_sql) ->row_array();		
		$num_total_n = $num_total_n['total'];
		
		
		$data['num_total_n'] = $num_total_n;
		$data['num_total'] = $num_total;		
		$data['money_total'] = $money_total;	
		$data['status'] = $status;		
		$data['pep_all'] = $pep_all;
		$data['pep_all1'] = $pep_all1;	
		$data['pep_all2'] = $pep_all2;
		$data['money_total_jia'] = $money_total_jia;
		$data['money_total_jian'] = $money_total_jian;
		$data['numcount'] = $total;		
		$this->page->initialize ( $config );			
		//$this->load_view ( 'admin/a/activity_red_envelope/index_list',$data);
                $this->load_view ( 'admin/a/activity_red_envelope/index_list_2',$data);
	}	
	
	/**
	 * 打款
	 */
	public function dakuang() {
		$id = intval($this->input->post("id"));
		$str_sql = "select * from activity_red_envelope_member where id=".$id;
		$wx_flow_activity_member_data = $this->db->query($str_sql)->row_array();
		if(!empty($wx_flow_activity_member_data)){
			if($wx_flow_activity_member_data['activate_status']==1){
				//$money = $wx_flow_activity_member_data['money'];//只能打整数
				$money = intval($wx_flow_activity_member_data['money']);//只能打整数
				if($money>=1){
					$time = time();
					$this->db->trans_begin();//事务
					$this->db->query("update activity_red_envelope_member set `money`=`money`-".$money." where id = {$id}");//减少流量	
					$str_sql = "select * from activity_red_envelope_member where id=".$id;
					$wx_flow_activity_member_data1 = $this->db->query($str_sql)->row_array();
					$data = array(
						'member_id'=>$wx_flow_activity_member_data['member_id'],									
						'money'=>$money,
						'type' => 1,
						'info' => '管理员打款',
						'addtime' => $time,
						'remainder'=>$wx_flow_activity_member_data1['money'],	
					);	
					$this->db->insert ( 'activity_red_envelope_money_log', $data );//打款记录
					if ($this->db->trans_status() === FALSE) {
						$this->db->trans_rollback();
						$this->callback->set_code ( 4000 ,"网络原因，兑换失败，请再试一下");
						$this->callback->exit_json();	
					} else {
						$this->db->trans_commit();
						$this->callback->set_code ( 2000 ,"打款成功");
						$this->callback->exit_json();
					}					
				}else{
					$this->callback->set_code ( 4000 ,"金额不足1元，不能打款");
					$this->callback->exit_json();		
				}				
			}else{
				$this->callback->set_code ( 4000 ,"账号没激活不能打款");
				$this->callback->exit_json();				
			}	
		}else{
			$this->callback->set_code ( 4000 ,"参数错误");
			$this->callback->exit_json();		
		}					
	}	
	
	/**
	 * 打款
	 */
	public function dakuangling() {
		$id = intval($this->input->post("id"));
		$str_sql = "select * from activity_red_envelope_member where id=".$id;
		$wx_flow_activity_member_data = $this->db->query($str_sql)->row_array();
		if(!empty($wx_flow_activity_member_data)){
			$money = $wx_flow_activity_member_data['money'];//只能打整数
			$time = time();
			$this->db->trans_begin();//事务
			$this->db->query("update activity_red_envelope_member set `money`=`money`-".$money." where id = {$id}");//减少流量	
			$data = array(
				'member_id'=>$wx_flow_activity_member_data['member_id'],									
				'money'=>$money,
				'type' => 2,
				'info' => '管理员余额清零操作',
				'addtime' => $time,
				'remainder'=>0,	
			);	
			$this->db->insert ( 'activity_red_envelope_money_log', $data );//打款记录
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$this->callback->set_code ( 4000 ,"网络原因，兑换失败，请再试一下");
				$this->callback->exit_json();	
			} else {
				$this->db->trans_commit();
				$this->callback->set_code ( 2000 ,"余额清零成功");
				$this->callback->exit_json();
			}					

		}else{
			$this->callback->set_code ( 4000 ,"参数错误");
			$this->callback->exit_json();		
		}					
	}
	
	
           
}