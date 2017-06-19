<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @since 2015年5月24日10:19:53
 * @author xml    
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Lock_anchor extends UA_Controller
{

	const pagesize = 10; //分页的页数	
	public function __construct()
	{
		parent::__construct ();
		$this->live_db = $this->load->database ( "live", TRUE );		
	}
	
	/**
	 * @method 封禁列表
	 * @author xml
	 * @since  2016-5-24 
	 */
	public function index($page=1)
	{
		$name = $this ->input ->post('name' ,true);
		$locktime = $this ->input ->post('time' ,true);		
	
		$param = array();
		$param['name'] = $name;
		$param['locktime'] = $locktime;		
		
		$data = array();
		$this->load->library ( 'Page' ); // 加载分页类
		$config['base_url'] = '/admin/a/live/lock_anchor/index/';
		$config ['pagesize'] = self::pagesize;
		$config ['page_now'] = $page;		
	
		$where_sql = ' 1 ';
		if(!empty($param['name'])){
			$where_sql.=' AND  l.name="'.trim($param['name']).'" ';
		}
		if(!empty($param['locktime'])){
			$where_sql.=' AND  l.locktime="'.trim($param['locktime']).'" ';
		}

        $page_size = self::pagesize;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from	
		
		$query_sql2=" select count(id) as total from live_anchor_lock as l where ".$where_sql;		
		$query_sql1=" select a.addtime,a.upload_num,a.down_num,a.report_num,l.* from live_anchor_lock as l left join live_anchor as a on(l.user_id = a.anchor_id)  where ".$where_sql." ORDER BY  l.id desc LIMIT {$from},{$page_size}";
		
		$t = $this->live_db->query($query_sql2) ->row_array();
		$total = $t['total'];				
		$wx_flow_activity_member_data = $this->live_db->query($query_sql1) ->result_array();	
		$config ['pagecount'] = $total;
		$data['pageData']= $wx_flow_activity_member_data;
		$data['name'] = $name;
		$data['locktime'] = $locktime;
		$this->page->initialize ( $config );			
		$this->load_view ( 'admin/a/live/lock_anchor_list',$data);
	}

	/**
	 * 封禁账号
	 */
	public function lock() 
	{	
		$name=$this->input->post('name',true);//用户
		$live_anchor_data = array();
		if($name){
			$sql = 'SELECT * FROM live_anchor WHERE name="'.$name.'"';
			$live_anchor_data =  $this->live_db->query($sql)->row_array();			
		}
		$data = array();
		$data['anchor'] = $live_anchor_data;
		$data['name'] = $name;		
		$this->load_view ( 'admin/a/live/lock_anchor',$data);		
	}	
	
	/**
	 * @method:主播注册
	 * @author: xml
	 * @param: $user_id:用户id；$user_type:用户类型 0:用户 ,1:管家
	 * @return:
	 */
	public function dolock() 
	{	
		$user_id=$this->input->post('user_id',true);//用户id
		$time=$this->input->post('time',true);//时间
		$content=$this->input->post('content',true);//		
		$nowtime = time();
		$sql = 'SELECT * FROM live_anchor WHERE anchor_id= '.$user_id;
		$live_anchor_data =  $this->live_db->query($sql)->row_array();		
		//验证数据
		if(empty($live_anchor_data)){
			$this->callback->set_code ( 4000 ,"用户不存在");
			$this->callback->exit_json();		
		}
		
		$sql = 'SELECT * FROM live_anchor_lock WHERE user_id= '.$user_id;
		$live_anchor_lock_data =  $this->live_db->query($sql)->row_array();		
		//验证数据
		if(!empty($live_anchor_lock_data) ){
			if($live_anchor_lock_data['locketime']==0){
				$this->callback->set_code ( 4001 ,"用户已经被永久封号了");
				$this->callback->exit_json();				
			}else if($live_anchor_lock_data['locketime']>$nowtime){
				$this->callback->set_code ( 4002 ,"用户已经被封号了");
				$this->callback->exit_json();					
			}
		}		
		
		$lockstime = 0;
		$locketime = 0;
		if($time==0){//表示永久封号
			$lockstime = $nowtime;
			$locketime = 0;			
		}else{
			$lockstime = $nowtime;
			$locketime = $nowtime + $time*60*60*24 ;				
		}
		$this->live_db->trans_begin();//事务		
		$data = array(
			'user_id'=>$user_id,
			'name'=>$live_anchor_data['name'],			
			'regtime'=>$nowtime,
			'lockstime' => $lockstime,
			'locketime' => $locketime,
			'content' => $content,	
			'locktime' => $time,
			'admin_id'=>$this->admin_id,
			'admin_name'=>$this->realname,			
		);	
		$this->live_db->insert ( 'live_anchor_lock', $data );//	
		$this->live_db->insert ( 'live_anchor_lock_record', $data );//	
		if ($this->live_db->trans_status() === FALSE) {
			$this->live_db->trans_rollback();
			$this->callback->set_code ( 4000 ,"网络原因，兑换失败，请再试一下");
			$this->callback->exit_json();	
		} else {
			$this->live_db->trans_commit();
			$this->callback->set_code ( 2000 ,"操作成功");
			$this->callback->exit_json();
		}		
	}	
	
	
	/**
	 * 解封
	 */
	public function del_lock() {
		$ids = $this->input->post("id");
		if(!is_array($ids)){
			$ids = array($ids);
		}
		$status = $this->live_db->query("delete from live_anchor_lock where id in(".implode(",",$ids).")");
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"解封失败");
			$this->callback->exit_json();
		} else {
			//$this ->log(2,3,$this->controllerName,'平台删除'.$this->controllerName.',记录ID:'.$id);
			$this->callback->set_code ( 2000 ,"解封成功");
			$this->callback->exit_json();
		}		
	}	
	
           
}