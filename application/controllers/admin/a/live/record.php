<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @since 2015年5月24日10:19:53
 * @author xml    
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Record extends UA_Controller
{
    private $dictionary=array(
	    'DICT_ROOM_ATTR' => 1,//房间标签id
	);	
	const pagesize = 10; //分页的页数	
	public function __construct()
	{
		parent::__construct ();
		$this->live_db = $this->load->database ( "live", TRUE );		
	}
	
	/**
	 * @method 打赏列表
	 */
	public function index($page=1)
	{
		$name = $this ->input ->post('name' ,true);
		$starttime = $this ->input ->post('starttime' ,true);
		$endtime = $this ->input ->post('endtime' ,true);		
		
		$param = array();
		$param['name'] = $name;
		$param['starttime'] = $starttime;
		$param['endtime'] = $endtime;		

		$data = array();
		$this->load->library ( 'Page' ); // 加载分页类
		$config['base_url'] = '/admin/a/live/record/index/';
		$config ['pagesize'] = self::pagesize;
		$config ['page_now'] = $page;		
	
		$where_sql = ' 1 ';
		if(!empty($param['name'])){
			//$where_sql.=' AND pcontent LIKE "%'.trim($param['name']).'%" ';
		}
		if(!empty($param['starttime'])){
			$where_sql.=' AND  addtime >="'.trim($param['starttime']).' 00:00:00'.'" ';
		}
		if(!empty($param['endtime'])){
			$where_sql.=' AND  addtime <="'.trim($param['endtime']).' 23:59:59'.'" ';
		}

        $page_size = self::pagesize;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from	
		
		$query_sql2=" select count(id) as total from live_gift_record where ".$where_sql;		
		$query_sql1=" select * from live_gift_record  where ".$where_sql." ORDER BY  id desc LIMIT {$from},{$page_size}";
		
		$t = $this->live_db ->query($query_sql2) ->row_array();
		$total = $t['total'];				
		$wx_flow_activity_member_data = $this->live_db ->query($query_sql1) ->result_array();		
		$config ['pagecount'] = $total;
		$data['pageData']= $wx_flow_activity_member_data;
		$data['name']=$name;
		$data['starttime'] = $starttime;
		$data['endtime'] = $endtime;
		$this->page->initialize ( $config );			
		$this->load_view ( 'admin/a/live/record_gift_list',$data);		

	}
	
	/**
	 * @method 短视频下架记录
	 */
	public function video_list($page=1)
	{
		$name = $this ->input ->post('name' ,true);
		$starttime = $this ->input ->post('starttime' ,true);
		$endtime = $this ->input ->post('endtime' ,true);		
		
		$param = array();
		$param['name'] = $name;
		$param['starttime'] = $starttime;
		$param['endtime'] = $endtime;		

		$data = array();
		$this->load->library ( 'Page' ); // 加载分页类
		$config['base_url'] = '/admin/a/live/record/video_list/';
		$config ['pagesize'] = self::pagesize;
		$config ['page_now'] = $page;		
	
		$where_sql = ' 1 ';
		if(!empty($param['name'])){
			$where_sql.=' AND pcontent LIKE "%'.trim($param['name']).'%" ';
		}
		if(!empty($param['starttime'])){
			$where_sql.=' AND  addtime >="'.strtotime(trim($param['starttime']).' 00:00:00').'" ';
		}
		if(!empty($param['endtime'])){
			$where_sql.=' AND  addtime <="'.strtotime(trim($param['endtime']).' 23:59:59').'" ';
		}

        $page_size = self::pagesize;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from	
		
		$query_sql2=" select count(id) as total from live_video_off_record where ".$where_sql;		
		$query_sql1=" select * from live_video_off_record  where ".$where_sql." ORDER BY  id desc LIMIT {$from},{$page_size}";
		
		$t = $this->live_db ->query($query_sql2) ->row_array();
		$total = $t['total'];				
		$wx_flow_activity_member_data = $this->live_db ->query($query_sql1) ->result_array();		
		$config ['pagecount'] = $total;
		$data['pageData']= $wx_flow_activity_member_data;
		$data['name']=$name;
		$data['starttime'] = $starttime;
		$data['endtime'] = $endtime;
		$this->page->initialize ( $config );

		$sql_str = "select dict_id as categoryid,description as categoryname,showorder from live_dictionary where enable=0 and pid=".$this->dictionary['DICT_ROOM_ATTR']." ";
		$category_live_dictionary_data = $this->live_db->query($sql_str)->result_array();
		if(!empty($category_live_dictionary_data)){
			$valuea = array();
			foreach ($category_live_dictionary_data as $key => $value) {				
				$sortfiled[$key] = $value['showorder'];//根据showorder字段排序
				$valuea[$value['showorder']] = $value['showorder'];
			}
			if(count($valuea)>1){
				array_multisort($sortfiled, $category_live_dictionary_data);				
			}
			foreach ($category_live_dictionary_data as $key => $value) {
				unset($category_live_dictionary_data[$key]['showorder']);
			}			
		}
		$data["all_room_attr"]=$category_live_dictionary_data;
		$this->load_view ( 'admin/a/live/record_video_list',$data);		

	}	
	
	/**
	 * @method 封号记录
	 */
	public function lock_list($page=1)
	{
		$name = $this ->input ->post('name' ,true);
		$starttime = $this ->input ->post('starttime' ,true);
		$endtime = $this ->input ->post('endtime' ,true);		
		$locktime = $this ->input ->post('time' ,true);	
		
		$param = array();
		$param['name'] = $name;
		$param['starttime'] = $starttime;
		$param['endtime'] = $endtime;		
		$param['locktime'] = $locktime;
		
		$data = array();
		$this->load->library ( 'Page' ); // 加载分页类
		$config['base_url'] = '/admin/a/live/record/lock_list/';
		$config ['pagesize'] = self::pagesize;
		$config ['page_now'] = $page;		
	
		$where_sql = ' 1 ';
		if(!empty($param['name'])){
			$where_sql.=' AND  name="'.trim($param['name']).'" ';
		}
		if(!empty($param['locktime']) && $param['locktime']>=0){
			$where_sql.=' AND  locktime="'.trim($param['locktime']).'" ';
		}
		if(!empty($param['starttime'])){
			$where_sql.=' AND  regtime >="'.strtotime(trim($param['starttime']).' 00:00:00').'" ';
		}
		if(!empty($param['endtime'])){
			$where_sql.=' AND  regtime <="'.strtotime(trim($param['endtime']).' 23:59:59').'" ';
		}
        $page_size = self::pagesize;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from	
		
		$query_sql2=" select count(id) as total from live_anchor_lock_record where ".$where_sql;		
		$query_sql1=" select * from live_anchor_lock_record  where ".$where_sql." ORDER BY  regtime desc LIMIT {$from},{$page_size}";
		
		$t = $this->live_db ->query($query_sql2) ->row_array();
		$total = $t['total'];				
		$wx_flow_activity_member_data = $this->live_db ->query($query_sql1) ->result_array();		
		$config ['pagecount'] = $total;
		$data['pageData']= $wx_flow_activity_member_data;
		$data['name'] = $name;
		$data['time'] = $locktime;
		$data['starttime'] = $starttime;
		$data['endtime'] = $endtime;		
		$this->page->initialize ( $config );			
		$this->load_view ( 'admin/a/live/record_lock_list',$data);		

	}

	
	/**
	 * @method 举报审查
	 */
	public function report_check_list($page=1)
	{
		$name = $this ->input ->post('name' ,true);
		$starttime = $this ->input ->post('starttime' ,true);
		$endtime = $this ->input ->post('endtime' ,true);		
		
		$param = array();
		$param['name'] = $name;
		$param['starttime'] = $starttime;
		$param['endtime'] = $endtime;		

		$data = array();
		$this->load->library ( 'Page' ); // 加载分页类
		$config['base_url'] = '/admin/a/live/record/report_check_list/';
		$config ['pagesize'] = self::pagesize;
		$config ['page_now'] = $page;		
	
		$where_sql = ' v.status=1 ';
		if(!empty($param['name'])){
			$where_sql.=' AND r.content LIKE "%'.trim($param['name']).'%" ';
		}
		if(!empty($param['starttime'])){
			$where_sql.=' AND  r.addtime >="'.strtotime(trim($param['starttime']).' 00:00:00').'" ';
		}
		if(!empty($param['endtime'])){
			$where_sql.=' AND  r.addtime <="'.strtotime(trim($param['endtime']).' 23:59:59').'" ';
		}

        $page_size = self::pagesize;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from	
		
		$query_sql2="select count(*) as total from(  select count(r.id) as total from live_video_report_record  as r left join live_video as v on(r.video_id=v.id)  where ".$where_sql." group by r.video_id ) as a ";		
		$query_sql1=" select r.*,count(r.id) as nums,max(r.addtime) as lasttime,v.name as video_name from live_video_report_record as r left join live_video as v on(r.video_id=v.id)  where ".$where_sql."  group by r.video_id ORDER BY r.id desc  LIMIT {$from},{$page_size}";
		
		$t = $this->live_db ->query($query_sql2) ->row_array();
		$total = $t['total'];				
		$live_video_report_record_data = $this->live_db ->query($query_sql1) ->result_array();		
		$config ['pagecount'] = $total;
		
	/*	
		$num_live_video_report_record_data = count($live_video_report_record_data);
		$video_ids = array();
		if($num_live_video_report_record_data>0){
			foreach($live_video_report_record_data as $v){
				$video_ids[$v['video_id']] = $v['video_id'];
			}
		}		
		$live_video_ids_data = array();		
		if(!empty($video_ids)){
			$sql_str = "select * from live_video where id in(".trim(implode(",",$video_ids),',').") ";
			$live_video_data = $this->live_db->query($sql_str)->result_array();
			foreach($live_video_data as $v){
				$live_video_ids_data[$v['id']] = $v;
			}			
		}
		if($num_live_video_report_record_data>0){
			foreach($live_video_report_record_data as $k=> $v){
				if(isset($live_video_ids_data[$v['video_id']])){			
					$live_video_report_record_data[$k]['video_name'] = $live_video_ids_data[$v['video_id']]['name'];									
				}
			}
		}		
*/
		$data['pageData']= $live_video_report_record_data;
		
		$data['name']=$name;
		$data['starttime'] = $starttime;
		$data['endtime'] = $endtime;
		
		$this->page->initialize ( $config );			
		$this->load_view ( 'admin/a/live/record_report_check_list',$data);		

	}		
	
	
	/**
	 * @method 举报审查
	 */
	public function report_check_do($page=1)
	{
		$videoid = $this ->input->get('videoid' ,true);
		$sql_str = "select * from live_video where id=".$videoid." ";
		$live_video_data = $this->live_db->query($sql_str)->row_array();
		
		$sql_str = "select anchor_id,user_id,name,user_type,video_pic,sex,photo,type from live_anchor where anchor_id=".$live_video_data['anchor_id']." ";
		$live_anchor_data = $this->live_db->query($sql_str)->row_array();		
		$param = array();
		$param['videoid'] = $videoid;
		$data = array();
		$this->load->library ( 'Page' ); // 加载分页类
		$config['base_url'] = '/admin/a/live/record/report_check_do/';
		$config ['pagesize'] = self::pagesize;
		$config ['page_now'] = $page;		
	
		$where_sql = ' video_id='.$videoid;

        $page_size = self::pagesize;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from	
		
		$query_sql2="select count(id) as total from live_video_report_record where ".$where_sql."";		
		$query_sql1=" select * from live_video_report_record  where ".$where_sql." ORDER BY  id desc  LIMIT {$from},{$page_size}";
		
		$t = $this->live_db ->query($query_sql2) ->row_array();
		$total = $t['total'];				
		$wx_flow_activity_member_data = $this->live_db ->query($query_sql1) ->result_array();		
		$config ['pagecount'] = $total;
		$data['pageData']= $wx_flow_activity_member_data;
		
		$data['videoid']=$videoid;
		$data['live_video']=$live_video_data;
		$data['live_anchor']=$live_anchor_data;		
		$data['total']=$total;		
		$this->page->initialize ( $config );			
		$this->load_view ( 'admin/a/live/record_report_check_do',$data);		

	}		
	
	/**
	 * 举报审查视频下架
	 */
	public function report_check_del_video() {
		$video_id = intval($this->input->post("video_id"));
		$report_id = intval($this->input->post("report_id"));		
		$content = $this->input->post("content");
		
		$status = $this->live_db->query("update live_video set `status`=0 where id = ".$video_id."");
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"下架失败");
			$this->callback->exit_json();
		}else {
			$data = array(
				'report_id'=>$report_id,
				'video_id'=>$video_id,			
				'content' => $content,
				'user_id' => $this->admin_id,
				'name' => $this->realname,	
				'addtime' => time(),			
			);	
			$this->live_db->insert ( 'live_video_off_record', $data );//			
			//$this ->log(2,3,$this->controllerName,'平台删除'.$this->controllerName.',记录ID:'.$id);
			$this->callback->set_code ( 2000 ,"下架成功");
			$this->callback->exit_json();
		}		
	}		

	/**
	 * @method 举报处理记录
	 */
	public function report_list($page=1)
	{
		$name = $this ->input ->post('name' ,true);
		$starttime = $this ->input ->post('starttime' ,true);
		$endtime = $this ->input ->post('endtime' ,true);		
		
		$param = array();
		$param['name'] = $name;
		$param['starttime'] = $starttime;
		$param['endtime'] = $endtime;		

		$data = array();
		$this->load->library ( 'Page' ); // 加载分页类
		$config['base_url'] = '/admin/a/live/record/report_list/';
		$config ['pagesize'] = self::pagesize;
		$config ['page_now'] = $page;		
	
		$where_sql = ' report_id>0 ';
		if(!empty($param['name'])){
			$where_sql.=' AND pcontent LIKE "%'.trim($param['name']).'%" ';
		}
		if(!empty($param['starttime'])){
			$where_sql.=' AND  addtime >="'.strtotime(trim($param['starttime']).' 00:00:00').'" ';
		}
		if(!empty($param['endtime'])){
			$where_sql.=' AND  addtime <="'.strtotime(trim($param['endtime']).' 23:59:59').'" ';
		}

        $page_size = self::pagesize;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from	
		
		$query_sql2=" select count(id) as total from live_video_off_record where ".$where_sql;		
		$query_sql1=" select * from live_video_off_record  where ".$where_sql." ORDER BY  id desc LIMIT {$from},{$page_size}";
		
		$t = $this->live_db ->query($query_sql2) ->row_array();
		$total = $t['total'];				
		$wx_flow_activity_member_data = $this->live_db ->query($query_sql1) ->result_array();		
		$config ['pagecount'] = $total;
		$data['pageData']= $wx_flow_activity_member_data;
		$data['name']=$name;
		$data['starttime'] = $starttime;
		$data['endtime'] = $endtime;
		$this->page->initialize ( $config );

		$sql_str = "select dict_id as categoryid,description as categoryname,showorder from live_dictionary where enable=0 and pid=".$this->dictionary['DICT_ROOM_ATTR']." ";
		$category_live_dictionary_data = $this->live_db->query($sql_str)->result_array();
		if(!empty($category_live_dictionary_data)){
			$valuea = array();
			foreach ($category_live_dictionary_data as $key => $value) {				
				$sortfiled[$key] = $value['showorder'];//根据showorder字段排序
				$valuea[$value['showorder']] = $value['showorder'];
			}
			if(count($valuea)>1){
				array_multisort($sortfiled, $category_live_dictionary_data);				
			}
			foreach ($category_live_dictionary_data as $key => $value) {
				unset($category_live_dictionary_data[$key]['showorder']);
			}			
		}
		$data["all_room_attr"]=$category_live_dictionary_data;
		
		$this->load_view ( 'admin/a/live/record_report_list',$data);		

	}	

	
	/**
	 * @method 评论删除记录
	 */
	public function video_comment_list($page=1)
	{
		$name = $this ->input ->post('name' ,true);
		$starttime = $this ->input ->post('starttime' ,true);
		$endtime = $this ->input ->post('endtime' ,true);		
		
		$param = array();
		$param['name'] = $name;
		$param['starttime'] = $starttime;
		$param['endtime'] = $endtime;		

		$data = array();
		$this->load->library ( 'Page' ); // 加载分页类
		$config['base_url'] = '/admin/a/live/record/video_comment_list/';
		$config ['pagesize'] = self::pagesize;
		$config ['page_now'] = $page;		
	
		$where_sql = ' 1 ';
		if(!empty($param['name'])){
			$where_sql.=' AND pcontent LIKE "%'.trim($param['name']).'%" ';
		}
		if(!empty($param['starttime'])){
			$where_sql.=' AND  addtime >="'.strtotime(trim($param['starttime']).' 00:00:00').'" ';
		}
		if(!empty($param['endtime'])){
			$where_sql.=' AND  addtime <="'.strtotime(trim($param['endtime']).' 23:59:59').'" ';
		}		

        $page_size = self::pagesize;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from	
		
		$query_sql2=" select count(id) as total from live_video_comment_del_record where ".$where_sql;		
		$query_sql1=" select * from live_video_comment_del_record  where ".$where_sql." ORDER BY  id desc LIMIT {$from},{$page_size}";
		
		$t = $this->live_db ->query($query_sql2) ->row_array();
		$total = $t['total'];				
		$wx_flow_activity_member_data = $this->live_db ->query($query_sql1) ->result_array();		
		$config ['pagecount'] = $total;
		$data['pageData']= $wx_flow_activity_member_data;
		
		$data['name']=$name;
		$data['starttime'] = $starttime;
		$data['endtime'] = $endtime;		
		
		$this->page->initialize ( $config );

		$sql_str = "select dict_id as categoryid,description as categoryname,showorder from live_dictionary where enable=0 and pid=".$this->dictionary['DICT_ROOM_ATTR']." ";
		$category_live_dictionary_data = $this->live_db->query($sql_str)->result_array();
		if(!empty($category_live_dictionary_data)){
			$valuea = array();
			foreach ($category_live_dictionary_data as $key => $value) {				
				$sortfiled[$key] = $value['showorder'];//根据showorder字段排序
				$valuea[$value['showorder']] = $value['showorder'];
			}
			if(count($valuea)>1){
				array_multisort($sortfiled, $category_live_dictionary_data);				
			}
			foreach ($category_live_dictionary_data as $key => $value) {
				unset($category_live_dictionary_data[$key]['showorder']);
			}			
		}
		$data["all_room_attr"]=$category_live_dictionary_data;
		
		$this->load_view ( 'admin/a/live/record_video_comment_list',$data);		

	}		
	
	
}