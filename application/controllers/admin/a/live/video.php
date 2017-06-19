<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @since 2015年5月24日10:19:53
 * @author xml    
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Video extends UA_Controller
{
    private $dictionary=array(
	    'DICT_ROOM_ATTR' => 1,//房间标签id
	);	
	const pagesize = 10; //分页的页数	
	public function __construct()
	{
		parent::__construct ();
		$this->load_model ( '/live/anchor_model', 'anchor_model' );
		$this->load_model ( '/live/video_model', 'video_model' );
		$this->live_db = $this->load->database ( "live", TRUE );		
	}
	
	/**
	 * @method 视频列表
	 * @author xml
	 * @since  2016-5-24 
	 */
	public function index($page=1)
	{
		if($this ->input ->get('page' ,true)){
			$page = $this ->input ->get('page' ,true);
		}		
		$name = $this ->input ->get_post('name' ,true);
		$anchorname = $this ->input ->get_post('anchorname' ,true);
		$mobile = $this ->input ->get_post('mobile' ,true);
		$attr_id = $this ->input ->get_post('attr_id' ,true);
		$status = $this ->input ->get_post('status' ,true);
		if(empty($status)){
			$status=2;
		}
		$starttime = $this ->input ->get_post('starttime' ,true);
		$endtime = $this ->input ->get_post('endtime' ,true);		
		if($starttime && strpos($starttime,':')===false){
			$starttime = trim($starttime).' 00:00:00';
		}
		if($endtime && strpos($endtime,':')===false){
			$endtime = trim($endtime).' 23:59:59';
		}
		$param = array();
		$param['name'] = $name;
		$param['anchorname'] = $anchorname;
		$param['mobile'] = $mobile;
		$param['attr_id'] = $attr_id;
		$param['starttime'] = $starttime;
		$param['endtime'] = $endtime;		
		$param['status'] = $status;	
		$urldata = array();	
		parse_str($_SERVER['QUERY_STRING'],$urldata);
		unset($urldata['page']);
		$urlstr ='?';
		foreach($urldata as $k => $v){
			$urlstr .=$k.'='.$v.'&';
		}		
		$data = array();
		$this->load->library ( 'Page' ); // 加载分页类
		$config['base_url'] = '/admin/a/live/video/index/'.$urlstr.'&page=';
		$config ['pagesize'] = self::pagesize;
		$config ['page_now'] = $page;		
		$attr_data = array();	
		$sql_str = "select dict_id as categoryid,description as categoryname,showorder from live_dictionary where enable=0 and pid=".$this->dictionary['DICT_ROOM_ATTR']." ";
		$category_live_dictionary_data = $this->live_db->query($sql_str)->result_array();
		if(!empty($category_live_dictionary_data)){
			$valuea = array();
			foreach ($category_live_dictionary_data as $key => $value) {				
				$sortfiled[$key] = $value['showorder'];//根据showorder字段排序
				$valuea[$value['showorder']] = $value['showorder'];
				$attr_data[$value['categoryid']] = $value['categoryname'];
			}
		}
		$data["all_room_attr"]=$category_live_dictionary_data;
		$video_arr_t=$this->video_model->get_video_list($param,$page, self::pagesize,true);
		$config ['pagecount'] = $video_arr_t['total'];
		$video_arr = $video_arr_t['data'];
		if(count($video_arr)>0){
			foreach($video_arr as $k=> $v){
				/*if(empty($v['cover'])){
					$category_live_dictionary_data[$k]['cover'] = $live_anchor_ids_data[$v['anchor_id']]['video_pic'];					
				}
				if(strpos($category_live_dictionary_data[$k]['cover'],'http://')!==0){
					$category_live_dictionary_data[$k]['cover'] = trim(base_url(''),'/').$category_live_dictionary_data[$k]['cover'];							
				}*/
				if(isset($attr_data[$v['attr_id']])){
					$video_arr[$k]['attrname'] = $attr_data[$v['attr_id']];
				}else{
					$video_arr[$k]['attrname'] = '';
				}
								
			}
		}
		$data['pageData']= $video_arr;
		$data['name']=$name;
		$data['anchorname']=$anchorname;
		$data['mobile']=$mobile;
		$data['attr_id']=$attr_id;
		$data['starttime'] = $starttime;
		$data['endtime'] = $endtime;
		$data['status'] = $status;		
		$this->page->initialize ( $config );			
		$this->load_view ( 'admin/a/live/video',$data);
	}
	
	
	/**
	 * 视频删除
	 */
	public function del_video() {
		$id = intval($this->input->post("id"));
		$status = $this->live_db->query("update live_video set `status`=2 where id = ".$id."");
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"删除失败");
			$this->callback->exit_json();
		}else {
			$data = array(
				'video_id'=>$id,			
				'content' => '管理员删除',
				'user_id' => $this->admin_id,
				'name' => $this->realname,	
				'addtime' => time(),			
			);	
			$this->live_db->insert ( 'live_video_off_record', $data );//			
			//$this ->log(2,3,$this->controllerName,'平台删除'.$this->controllerName.',记录ID:'.$id);
			$this->callback->set_code ( 2000 ,"删除成功");
			$this->callback->exit_json();
		}		
	}		
	
	
	/**
	 * 视频下架
	 */
	public function down_video() {
		$id = intval($this->input->post("id"));
		$status = $this->live_db->query("update live_video set `status`=0 where id = ".$id."");
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"下架失败");
			$this->callback->exit_json();
		}else {
			$data = array(
				'video_id'=>$id,			
				'content' => '管理员下架',
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
	 * 视频上架
	 */
	public function up_video() {
		$id = intval($this->input->post("id"));
		$status = $this->live_db->query("update live_video set `status`=1 where id = ".$id."");
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"上架失败");
			$this->callback->exit_json();
		}else {
			$data = array(
				'video_id'=>$id,			
				'content' => '管理员上架',
				'user_id' => $this->admin_id,
				'name' => $this->realname,	
				'addtime' => time(),			
			);	
			$this->live_db->insert ( 'live_video_off_record', $data );//			
			//$this ->log(2,3,$this->controllerName,'平台删除'.$this->controllerName.',记录ID:'.$id);
			$this->callback->set_code ( 2000 ,"上架成功");
			$this->callback->exit_json();
		}		
	}	
	
	
	//app首页推荐,status状态1正常0下架2删除3首页推荐
	function indexVideoInfo(){
		$id = $this->input->post("id",true);
		$sql_str = "select * from live_video where id=".$id." ";
		$data = $this->live_db->query($sql_str)->row_array();
		if(empty($data)){
			$this->callback->set_code ( 100 ,"视频不存在");
			$this->callback->exit_json();
		}
		if($data['status']==2){
			$this->callback->set_code ( 100 ,"视频已经被删除，操作失败");
			$this->callback->exit_json();
		}		
		$status= 0;
		if($data['status']==3){//取消推荐
			$status = $this->live_db->query("update live_video set `status`=1 where id = ".$id."");		
		}else if($data['status']!=3){//推荐
			$status = $this->live_db->query("update live_video set `status`=3 where id = ".$id."");
		}	
		if($status){		
			$this->callback->set_code ( 2000 ,"操作成功");
			$this->callback->exit_json();
		}else{
			$this->callback->set_code ( 401 ,"操作失败");
			$this->callback->exit_json();
		}
		exit;
	}	
	
	
	/**
	 * @method 视频评论列表
	 * @author xml
	 * @since  2016-5-24 
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
		$config['base_url'] = '/admin/a/live/video/video_comment_list/';
		$config ['pagesize'] = self::pagesize;
		$config ['page_now'] = $page;		

		$video_arr_t=$this->video_model->get_video_comment_list($param,$page, self::pagesize,true);
		$config ['pagecount'] = $video_arr_t['total'];
		$video_arr = $video_arr_t['data'];

		$data['pageData']= $video_arr;
		$data['name']=$name;
		$data['starttime'] = $starttime;
		$data['endtime'] = $endtime;
		
		$this->page->initialize ( $config );			
		$this->load_view ( 'admin/a/live/video_comment_list',$data);
	}	
	
	/**
	 * 视频评论删除
	 */
	public function del_video_comment() {
		$ids = $this->input->post("id");
		/*
		if(!is_array($ids)){
			$ids = array($ids);
		}
		$status = $this->live_db->query("delete from live_video_comment where id in(".implode(",",$ids).")");
		*/
		$sql_str = "select * from live_video_comment where id=".$ids." ";
		$live_video_comment_data = $this->live_db->query($sql_str)->row_array();
		if(empty($live_video_comment_data)){
			$this->callback->set_code ( 4001 ,"记录不存在");
			$this->callback->exit_json();			
		}
		$sql_str = "select * from live_video where id=".$live_video_comment_data['video_id']." ";
		$live_video_data = $this->live_db->query($sql_str)->row_array();
		$status = $this->live_db->query("delete from live_video_comment where id=".$ids."");
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"删除失败");
			$this->callback->exit_json();
		} else {
			$data = array(
				'video_comment_id'=>$live_video_comment_data['id'],
				'video_id'=>$live_video_comment_data['video_id'],			
				'video_attr_id'=>$live_video_data['attr_id'],
				'pcontent' => $live_video_comment_data['content'],
				'user_id' => $this->admin_id,
				'name' => $this->realname,	
				'addtime' => time(),			
			);	
			$this->live_db->insert ( 'live_video_comment_del_record', $data );//				
			//$this ->log(2,3,$this->controllerName,'平台删除'.$this->controllerName.',记录ID:'.$id);
			$this->callback->set_code ( 2000 ,"删除成功");
			$this->callback->exit_json();
		}		
	}	
	
	
	/**
	 * @method 直播视频分页,查询
	 * @author xml
	 * @since  2016-5-24 
	 */
	public function indexData() {
		$page = $this->getPage ();
		$param = $this->getParam(array('name','anchorname','mobile','attr_id'));
		//var_dump($param);
		$data = $this->video_model->get_video_list ( $param , $page);

		$sql_str = "select dict_id as categoryid,description as categoryname from live_dictionary where enable=0 and pid=".$this->dictionary['DICT_ROOM_ATTR']." ";
		$category_live_dictionary_data = $this->live_db->query($sql_str)->result_array();
		$attr_data = array();
		if(!empty($category_live_dictionary_data)){
			foreach ($category_live_dictionary_data as $key => $value) {				
				$attr_data[$value['categoryid']] = $value['categoryname'];
			}		
		}	
		if(count($data)>0){
			foreach($data as $k=> $v){
				/*if(empty($v['cover'])){
					$category_live_dictionary_data[$k]['cover'] = $live_anchor_ids_data[$v['anchor_id']]['video_pic'];					
				}
				if(strpos($category_live_dictionary_data[$k]['cover'],'http://')!==0){
					$category_live_dictionary_data[$k]['cover'] = trim(base_url(''),'/').$category_live_dictionary_data[$k]['cover'];							
				}*/
				$data[$k]['attrname'] = $attr_data[$v['attr_id']];				
			}
		}		
		
		echo  $data ;
	}
       
	//编辑房间
	function editVideo(){
		$video_id = $this->input->post("video_id",true);
		if(empty($video_id)){
			$this->callback->set_code ( 101 ,"视频id不存在");
			$this->callback->exit_json();
		}
		$upstr ='';
		if(isset($_POST['city']) && !empty($_POST['city']) ){
			$dest_id=$_POST['city'];
			$query = $this->db->query ( "SELECT `id`, `kindname` AS name, `pid`, `enname`, `simplename`, `level`, `ishot` FROM `u_dest_base` WHERE `id`='".$_POST['city']."' " )->row_array();
			if($query){
				$dest_name=$query['name'];
			}
			$upstr ="`dest_id`='".$dest_id."',`dest_name`='".$dest_name."',";
		}
		$line_ids='';
		if(isset($_POST['line_ids']) && !empty($_POST['line_ids']) ){
			$lineId = trim($_POST['line_ids'],',');
			$lineid_arr1 = explode(",",$lineId);
			$lineid_arr = array();
			if(!empty($lineid_arr1)){
				foreach($lineid_arr1 as $v){
					$v = trim($v);
					$tt = explode(" ",$v);
					if(count($tt)>1){
						foreach($tt as $v1){
						    $v1 = trim($v1);
							if($v1){
								$v1 = trim(trim($v1,'L'),'l');
								if(is_numeric($v1)){
									$lineid_arr[$v1] = $v1;
								}
							}							
						}			
					}else{
						if($v){
							$v = trim(trim($v,'L'),'l');
							if(is_numeric($v)){
								$lineid_arr[$v] = $v;
							}							
						}						
					}
				}					
			}
			if(!empty($lineid_arr)){
				$sql= "SELECT a.id FROM	u_line as a WHERE a.id in(".implode(",",$lineid_arr).") ";
				$data_line=$this->db->query($sql)->result_array();
				$line_true_ids = array();
				foreach($data_line as $v){
					$line_true_ids[$v['id']] = $v['id'];
				}	
				$line_ids=implode(",",$line_true_ids).',';				
			}	
		}	
		$status = $this->live_db->query("update live_video set `line_ids`='".$line_ids."',".$upstr."`like_num`='".$_POST['likenum']."',`attr_id`='".$_POST['vattrid']."',`name`='".$_POST['roomName']."',`sort`='".$_POST['roomSort']."',`pic`='".$_POST['pic']."',`app_index_tui_pic`='".$_POST['app_index_tui_pic']."',`people`='".$_POST['people']."' where id = ".$video_id."");
		if($status){
			$this->callback->set_code ( 2000 ,"修改成功");
			$this->callback->exit_json();
		}else{
			$this->callback->set_code ( 402 ,"修改失败");
			$this->callback->exit_json();
		}
	}
		//获取某条数据
	public function getOneData () {
		$video_id = intval($this ->input ->post('video_id'));
		$sql_str = "select * from live_video where id=".$video_id." ";
		$data = $this->live_db->query($sql_str)->row_array();
		if (empty($data)) {
			echo false;
			exit;
		} else {
			//$data = $data['data'][0];
			echo json_encode($data);
		}
	}
	   
}