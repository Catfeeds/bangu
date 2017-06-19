<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Video_model extends APP_Model
{
	private $table_name = 'live_video';	
	function __construct()
	{
		parent::__construct ( $this->table_name );


	}

	/**
	 * @method 历史直播列表，用于平台管理 
	 * @param array $whereArr
	 * @author xml
	 */
	public function get_old_room_list($param,$page=1, $num = 10,$iscount = false)
	{

		$query_sql1=" select r.*,if(v.record_id>0,v.record_id,0) as record_id,v.pic as video_pic,v.name as video_name,v.video ";
		$query_sql2=" select count(r.room_id) as total ";		
		$query_sql=" from live_room r left join live_video v on( r.room_id=v.room_id ) ";
        $query_sql2 .= $query_sql;
		
		$query_sql.=" ORDER BY  r.createtime desc";
        $page_size = $num;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from
		$query_sql.=" LIMIT {$from},{$page_size}";		
        $query_sql1 .= $query_sql;
		$data = array();
		if($iscount){
			$t = $this ->db ->query($query_sql2) ->row_array();
			$data['total'] = $t['total'];				
		}
		$live_room_data= $this ->db ->query($query_sql1) ->result_array();
		
		
		$num_live_room_data = count($live_room_data);
		$anchor_ids = array();
		if($num_live_room_data>0){
			foreach($live_room_data as $v){
				$anchor_ids[$v['anchor_id']] = $v['anchor_id'];					
			}
		}		
		$live_anchor_ids_data = array();		
		if(!empty($anchor_ids)){
			$sql_str = "select anchor_id,user_id,name,user_type,video_pic,sex,photo,type from live_anchor where anchor_id in(".implode(",",$anchor_ids).") ";
			$live_anchor_data = $this->db->query($sql_str)->result_array();
			foreach($live_anchor_data as $v){
				$live_anchor_ids_data[$v['anchor_id']] = $v;
			}			
		}
		if($num_live_room_data>0){
			foreach($live_room_data as $k=> $v){
				if(isset($live_anchor_ids_data[$v['anchor_id']])){
					if(empty($v['cover'])){
						$live_room_data[$k]['cover'] = $live_anchor_ids_data[$v['anchor_id']]['video_pic'];					
					}
					if(strpos($live_room_data[$k]['cover'],'http://')!==0){
						$live_room_data[$k]['cover'] = trim(base_url(''),'/').$live_room_data[$k]['cover'];							
					}
					$live_room_data[$k]['avatar'] = trim(base_url(''),'/').$live_anchor_ids_data[$v['anchor_id']]['photo'];
					$live_room_data[$k]['anchor_name'] = $live_anchor_ids_data[$v['anchor_id']]['name'];				
					$live_room_data[$k]['anchor_sex'] = $live_anchor_ids_data[$v['anchor_id']]['sex'];
					$live_room_data[$k]['anchor_type'] = $live_anchor_ids_data[$v['anchor_id']]['type'];
					$live_room_data[$k]['user_id'] = $live_anchor_ids_data[$v['anchor_id']]['user_id'];
									
				}		
			}
		}		
		$data['data'] = $live_room_data;
		
		
		return $data;
	}		
	
	
	/**
	 * @method 还没有同步的视频列表，用于平台管理 
	 * @param array $whereArr
	 * @author xml
	 */
	public function get_tong_video_list($param,$page=1, $num = 10,$iscount = false)
	{
		$where ='';
		if(!empty($param['roomid'])){
			$where=' AND r.roomid LIKE "%'.trim($param['roomid']).'%" ';
		}		
		$query_sql1=" select * ";
		$query_sql2=" select count(room_id) as total ";		
		//$query_sql=" from (select r.*,  if(v.record_id>0,v.record_id,0) as record_id from live_room as r left join live_video v on( r.room_id=v.room_id ) where ((r.live_status=2 and r.room_name!='no') or r.live_status in(1,3) ) ".$where."  ) as a where record_id=0 ";
		$query_sql=" from (select r.*,  if(v.record_id>0,v.record_id,0) as record_id,v.pic as video_pic,v.name as video_name,v.video from live_room as r left join live_video v on( r.room_id=v.room_id ) where  r.room_name!='no'  ".$where."  ) as a where record_id=0 ";
                
		$query_sql2 .= $query_sql;
		
		$query_sql.=" ORDER BY  createtime desc";
        $page_size = $num;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from
		$query_sql.=" LIMIT {$from},{$page_size}";		
        $query_sql1 .= $query_sql;
		$data = array();
		if($iscount){
			$t = $this ->db ->query($query_sql2) ->row_array();
			$data['total'] = $t['total'];				
		}
		$live_room_data= $this ->db ->query($query_sql1) ->result_array();
		
		
		$num_live_room_data = count($live_room_data);
		$anchor_ids = array();
		if($num_live_room_data>0){
			foreach($live_room_data as $v){
				$anchor_ids[$v['anchor_id']] = $v['anchor_id'];					
			}
		}		
		$live_anchor_ids_data = array();		
		if(!empty($anchor_ids)){
			$sql_str = "select anchor_id,user_id,name,user_type,video_pic,sex,photo,type from live_anchor where anchor_id in(".implode(",",$anchor_ids).") ";
			$live_anchor_data = $this->db->query($sql_str)->result_array();
			foreach($live_anchor_data as $v){
				$live_anchor_ids_data[$v['anchor_id']] = $v;
			}			
		}
		if($num_live_room_data>0){
			foreach($live_room_data as $k=> $v){
				if(isset($live_anchor_ids_data[$v['anchor_id']])){
					if(empty($v['cover'])){
						$live_room_data[$k]['cover'] = $live_anchor_ids_data[$v['anchor_id']]['video_pic'];					
					}
					if(strpos($live_room_data[$k]['cover'],'http://')!==0){
						$live_room_data[$k]['cover'] = trim(base_url(''),'/').$live_room_data[$k]['cover'];							
					}
					$live_room_data[$k]['avatar'] = trim(base_url(''),'/').$live_anchor_ids_data[$v['anchor_id']]['photo'];
					$live_room_data[$k]['anchor_name'] = $live_anchor_ids_data[$v['anchor_id']]['name'];				
					$live_room_data[$k]['anchor_sex'] = $live_anchor_ids_data[$v['anchor_id']]['sex'];
					$live_room_data[$k]['anchor_type'] = $live_anchor_ids_data[$v['anchor_id']]['type'];
					$live_room_data[$k]['user_id'] = $live_anchor_ids_data[$v['anchor_id']]['user_id'];
									
				}		
			}
		}		
		$data['data'] = $live_room_data;
		
		
		return $data;
	}	
	
	
	/**
	 * @method 获取视频数据，用于平台管理 
	 * @param array $whereArr
	 * @author xml
	 */
	public function get_video_list($param,$page=1, $num = 10,$iscount = false)
	{

		$query_sql1=" select lv.*,lan.name as anchorname,lan.mobile ";
		$query_sql2=" select count(lv.id) as total ";		
		$query_sql=" from live_video as lv";
		//$query_sql.=" left join live_room as lr on lv.room_id=lr.room_id";
		$query_sql.=" left join live_anchor as lan on lan.anchor_id=lv.anchor_id where lv.status in(".($param['status']-1).") and lv.name!='no' ";  
		if(!empty($param['name'])){
			$query_sql.=' AND lv.name LIKE "%'.trim($param['name']).'%" ';
		}
		if(!empty($param['anchorname'])){
			$query_sql.=' AND  lan.name LIKE "%'.trim($param['anchorname']).'%" ';
		}
		if(!empty($param['mobile'])){
			$query_sql.=' AND  lan.mobile = "'.$param['mobile'].'" ';
		}
		if(!empty($param['attr_id'])){
			$query_sql.=' AND  lv.attr_id = '.$param['attr_id'].' ';
		}
		if(!empty($param['starttime'])){
			//$query_sql.=' AND  lv.starttime >='.strtotime($param['starttime']).' ';
			$query_sql.=' AND   lv.addtime >='.strtotime($param['starttime']).' ';
		}
		if(!empty($param['endtime'])){
			//$query_sql.=' AND  lv.endtime <='.strtotime($param['endtime']).' ';
			$query_sql.=' AND   lv.addtime <='.strtotime($param['endtime']).' ';
		}		
		
        $query_sql2 .= $query_sql;
		
		$query_sql.=" ORDER BY  lv.addtime desc";
        $page_size = $num;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from
		$query_sql.=" LIMIT {$from},{$page_size}";		
        $query_sql1 .= $query_sql;
		$data = array();
		if($iscount){
			$t = $this ->db ->query($query_sql2) ->row_array();
			$data['total'] = $t['total'];				
		}
		$data['data'] = $this ->db ->query($query_sql1) ->result_array();
		return $data;
	}
	
	
	/**
	 * @method 视频评论列表 
	 * @param array $whereArr
	 * @author xml
	 */
	public function get_video_comment_list($param,$page=1, $num = 10,$iscount = false)
	{

		$query_sql1=" select * ";
		$query_sql2=" select count(*) as total ";		
		$query_sql=" from live_video_comment  where 1 ";
		if(!empty($param['name'])){
			$query_sql.=' AND content LIKE "%'.trim($param['name']).'%" ';
		}
		if(!empty($param['starttime'])){
			$query_sql.=' AND  addtime >="'.trim($param['starttime']).' 00:00:00" ';
		}
		if(!empty($param['endtime'])){
			$query_sql.=' AND  addtime <="'.trim($param['endtime']).' 23:59:59" ';
		}		
        $query_sql2 .= $query_sql;
		$query_sql.=" ORDER BY  addtime desc";
        $page_size = $num;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from
		$query_sql.=" LIMIT {$from},{$page_size}";		
        $query_sql1 .= $query_sql;
		$data = array();
		if($iscount){
			$t = $this ->db ->query($query_sql2) ->row_array();
			$data['total'] = $t['total'];				
		}
		$data['data'] = $this ->db ->query($query_sql1) ->result_array();
		return $data;
	}	
	
	
	/**
	*@method 视频的优先级 ,用于接口  
	*@param array $whereArr
	*@author xml
	*/
	function live_video_most($action_where,$type){
		$query_sql=" SELECT lr.*,la.name,la.video_pic as pic,ld.description as atrname,la.photo as anchor_photo ";
		$query_sql.=" FROM	 live_room AS lr ";   
		$query_sql.=" LEFT JOIN live_room_attr AS lra ON lr.room_id = lra.room_id ";    
		$query_sql.=" LEFT JOIN live_dictionary AS ld ON ld.dict_id = lra.attr_id ";
		$query_sql.=" LEFT JOIN  live_anchor AS  la ON la.anchor_id= lr.anchor_id ";
                      	$query_sql.=$action_where; 
                      	$query_sql.="  order by peoples desc ";
	          	$video=$this ->db ->query($query_sql) ->result_array();  

		return $video;
	}

           /**
	*@method 2,最热的视频更多 3,正在直播更多 4,精彩的视频更多 ,用于接口  
	*@param $type 2,3,4
	*@author xml
	*/
	function live_video_type($type,$orderArr){
                      if($type==2){  
                              //最热的视频更多
                      	$query_sql=" select  lv.*,ld.description as attrname  from live_video as lv  left join live_room  as lr on lv.room_id=lr.room_id ";  
			$query_sql.=" left join live_room_attr as lra on lv.room_id=lra.room_id left join live_dictionary  as  ld on ld.dict_id=lra.attr_id";   
                      	$query_sql.=$orderArr;  

                      }elseif ($type==3) {
                      	//正在直播更多
                      	$query_sql=" select lv.*, lr.live_status,ld.description as attrname  from live_video as lv LEFT JOIN live_room as lr on lv.room_id = lr.anchor_id";   
			$query_sql.=" left join live_room_attr as lra on lv.room_id=lra.room_id left join live_dictionary  as  ld on ld.dict_id=lra.attr_id";    
                      	$query_sql.=$orderArr;  
                      }elseif ($type==4) {
                      	//精彩的视频更多
                      	$query_sql=" select lv.*,ld.description as attrname from live_video as lv  left join live_room  as lr on lv.room_id=lr.room_id ";   
			$query_sql.=" left join live_room_attr as lra on lv.room_id=lra.room_id left join live_dictionary  as  ld on ld.dict_id=lra.attr_id";    
                      	$query_sql.=$orderArr;  
                      }else{
                      	$query_sql=" select  lv.*,ld.description as attrname  from live_video as lv  left join live_room  as lr on lv.room_id=lr.room_id ";  
			$query_sql.=" left join live_room_attr as lra on lv.room_id=lra.room_id left join live_dictionary  as  ld on ld.dict_id=lra.attr_id";   
                      	$query_sql.=$orderArr; 
                      }
                      $video=$this ->db ->query($query_sql) ->result_array();  

                      if(!empty( $video)){
                      	$web=$this->select_rowtable('bangu.cfg_web',array());
                      	if(!empty($web)){
                      		foreach ($video as $key => $value) {
                      			$video[$key]['pic']=$web['url'].$value['pic'];
                      		}
                      	}
                      }
 
                      return $video;
	}

	/**
	*@method 
	*@param  $user_id 用户id
	*/
	function follow_live_video($user_id,$limit=''){
		$query_sql=" SELECT lv.* FROM live_video AS lv LEFT JOIN  live_room AS lr ON lv.room_id = lr.room_id ";
		//$query_sql.=" WHERE lr.live_status = 0 ";
		if(!empty($limit)){
			$query_sql.=" LIMIT {$limit}  ";
		}			
		$video=$this ->db ->query($query_sql) ->result_array();  	
		return $video;
	}
         /**
	*@method 我的粉丝
	*@param  $where
	*/
	function  live_anchor_fans($where){
		$this->db->select('count(id) as fans_sum');
		$this->db->from('live_anchor_fans');
		$this->db->where($where);
		$query = $this->db->get();
		return $query->row_array();
	}
	 /**
	*@method 我的标签
	*@param  $user_id :用户id 
	*/
	function  live_anchor_attr($user_id){
		$query_sql="select  laa.*,ld.description from live_anchor_attr as laa ";
		$query_sql.=" left join live_dictionary ld on laa.attr_id = ld.dict_id ";
		$query_sql.=" where laa.anchor_id={$user_id}";
		return $this ->db ->query($query_sql) ->result_array();  
	}
          
          	 /**
	*@method 主播获取的打赏
	*@param  $anchor_id :主播id 
	*/
	function  get_gift_record($anchor_id){
		$query_sql="select  count(id) as gift_sum from live_gift_record where anchor_id={$anchor_id}";
		return $this ->db ->query($query_sql) ->row_array();  
	}
	/**
	*@method 
	*@param  $where
	*
	*/
	function select_rowtable($table,$where,$order=''){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		if(!empty($order)){
			$this->db->order_by($order);
		}
		
		$query = $this->db->get();
		return $query->row_array();
	}
		/**
	*@method 
	*@param  $where
	*
	*/
	function select_Alltable($table,$where,$order=''){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		if(!empty($order)){
			$this->db->order_by($order);
		}
		
		$query = $this->db->get();
		return $query->result_array();
	}

	/**
	*@method 我的关注
	*@param  $fansArr,$type
	*@return bool  ture or false
	*/
	function save_anchor_fans($fansArr,$type){
		$this->db->trans_begin(); //事务开启

                      if($type==0){   //关注
                      	$sql="select id from live_anchor_fans where anchor_id={$fansArr['anchor_id']} and user_id={$fansArr['user_id']}";
                      	$fans=$this ->db ->query($sql)->row_array();
                      	if(!empty($fans)){
                                   $this ->db ->query("update live_anchor_fans set status=1 where anchor_id={$fansArr['anchor_id']} and user_id={$fansArr['user_id']}");
                                   $id= $fansp['id'];       
                      	}else{
			//插入主播粉丝
			$this->db->insert('live_anchor_fans',$fansArr);
			$id=$this->db->insert_id();
                      	}
                      
                                    //主播的粉丝+1
		            $this ->db ->query("update live_anchor set fans=fans+1 where anchor_id={$fansArr['anchor_id']}"); 

			//用户的关注数+1  	
  			$this ->db ->query("update live_anchor set attention=attention+1 where anchor_id={$fansArr['user_id']}"); 

                      }else{  //取消关注

                                	$this ->db ->query("update live_anchor_fans set status=0 where anchor_id={$fansArr['anchor_id']} and user_id={$fansArr['user_id']}"); 

 			//主播的粉丝-1
		         	$this ->db ->query("update live_anchor set fans=fans-1 where anchor_id={$fansArr['anchor_id']}"); 

			//用户的关注数-1  	
  			$this ->db ->query("update live_anchor set attention=attention-1 where anchor_id={$fansArr['user_id']}"); 

			$id=1;
                      }
       
		$this->db->trans_complete();//事务结束
		if ($this->db->trans_status () === TRUE) {
			$this->db->trans_commit ();
			return $id;
		} else {
			$this->db->trans_rollback (); // 事务回滚
			echo false;
		}

	}
	/**
	*@method 我的关注
	*@param $fansArr,$type
	*@return 
	*/
	function opare_attetion($fansArr){
                     	$sql="select id,status from live_anchor_fans where anchor_id={$fansArr['anchor_id']} and user_id={$fansArr['user_id']}";
                     	$fans=$this ->db ->query($sql)->row_array();
                     	if($fans['status']==1){ //取消关注

	                     	$this ->db ->query("update live_anchor_fans set status=0 where anchor_id={$fansArr['anchor_id']} and user_id={$fansArr['user_id']}");	 
	                     	//主播的粉丝-1
			$this ->db ->query("update live_anchor set fans=fans-1 where anchor_id={$fansArr['anchor_id']}"); 
			//用户的关注数-1  	
	  		$this ->db ->query("update live_anchor set attention=attention-1 where anchor_id={$fansArr['user_id']}"); 
	                     	$flag=0;		
                    	 }else{  //关注
			$this ->db ->query("update live_anchor_fans set status=1 where anchor_id={$fansArr['anchor_id']} and user_id={$fansArr['user_id']}");
			//主播的粉丝+1
			$this ->db ->query("update live_anchor set fans=fans+1 where anchor_id={$fansArr['anchor_id']}"); 
			//用户的关注数+1  	
	  	            $this ->db ->query("update live_anchor set attention=attention+1 where anchor_id={$fansArr['user_id']}"); 
	  	            $flag=1;
                    	 }
                     return $flag;
	}

	/**
	 *  @method修改表数据     
	 *  @param $dataArr:(array)更新的数据
	 *  $whereArr:(array)更新的条件
	 * @return:更新的数据条数
	 */
	function update($table,$dataArr, $whereArr)
	{
		$this->db->where($whereArr);
		$this->db->update($table, $dataArr);
		return $this->db->affected_rows();
	}

	/**
	*@method 视频信息和房间信息
	*@param  $room_id 房间id
	*
	*
	*/
	function get_room_video($room_id){
		$sql=" SELECT lr.peoples,lr.type,lr.starttime,lr.room_name,lr.room_number,lr.anchor_id, ";
		$sql.=" lr.anchor_password,lr.audience_password,lr.room_code,lr.video_link,lr.room_number,la.photo AS anchor_photo,";
		$sql.=" lr.room_id,lr.roomid,la. NAME AS anchor_name,la.umoney AS anchor_umoney,la.realname AS anchor_realname ";
		$sql.=" FROM	live_room AS lr ";
		$sql.=" LEFT JOIN live_anchor AS la ON la.anchor_id = lr.anchor_id ";
		$sql.=" where lr.room_id={$room_id} ";
		return $this ->db ->query($sql) ->result_array();  
	}
	/**
	*@method  我的收藏
	*@param  $room_id 房间id
	*
	*/
	function insert_tvideo_collect($collectArr){
		$this->db->trans_begin(); //事务开启

		$query_sql="update live_video set collect=collect+1 where id={$collectArr['video_id']}";
		$this ->db ->query($query_sql);

		$this->db->insert("live_video_collect ",$collectArr);
		$anchor_id=$this->db->insert_id();

		$this->db->trans_complete();//事务结束
		if ($this->db->trans_status () === TRUE) {
			$this->db->trans_commit ();
			return $id;
		} else {
			$this->db->trans_rollback (); // 事务回滚
			echo false;
		}

	}
	/**
	*@method 平台推荐的线路
	*@param  $room_id  房间id
	*
	*/
	function get_recommend_line($room_id){
		$query_sql=" SELECT l.linename,l.id as line_id ,l.lineprice,l.mainpic ";
		$query_sql.=" FROM	live_room AS lr ";
		$query_sql.=" LEFT JOIN bangu.u_line_dest AS uld ON lr.room_dest_id = uld.dest_id ";
		$query_sql.=" LEFT JOIN bangu.u_line as l on l.id=uld.line_id where lr.room_id={$room_id}  ";
		$query_sql.=" and l.status=2 ";
		$query_sql.="  ORDER BY l.addtime desc limit 20 ";
		return $this ->db ->query($query_sql) ->result_array();  
	}
	/**
	*@method 推荐线路 成交量,满意度
	*/
	function get_recond_line(){
		$query_sql=" SELECT id,linename,lineprice,bookcount,satisfyscore,mainpic";
		$query_sql.="  from bangu.u_line ORDER BY bookcount desc ,satisfyscore desc LIMIT 20 ";
		return $this ->db ->query($query_sql) ->result_array(); 
	}

	/**
	*@method 直播视频信息
	*@param  video_id:视频id 
	*/
	function get_direct_seeding($video_id){
		$query_sql=" SELECT lr.peoples,la.fans,lr.room_id,lr.umoney,lv.time as video_time,lv.video,lv.name as video_name,lr.room_name ";
		$query_sql.=" FROM live_video as lv LEFT JOIN  live_room as lr on lv.room_id=lr.room_id ";
		$query_sql.=" LEFT JOIN live_anchor as la on la.anchor_id=lv.anchor_id ";
		$query_sql.=" WHERE  lv.id={$video_id} ";
		return $this ->db ->query($query_sql) ->row_array();  
	}
        
           /**
           *@method  人气主播
           */
           function get_top_anchor($order=''){
		$query_sql=" SELECT anchor_id,user_id,user_type,name,sex,photo as pic,fans,realname from live_anchor ";
		$query_sql.=" where status=1 order by fans desc  ";
		$query_sql.=$order;
		return $this ->db ->query($query_sql) ->result_array(); 
           }
           /**
           *@method  周边游城市
           */
           function get_round_city($cityid,$order=''){
           		$query_sql=" SELECT rt.neighbor_id as id,dest.kindname ";
           		$query_sql.=" FROM	bangu.cfg_round_trip AS rt ";
           		$query_sql.=" LEFT JOIN bangu.u_dest_base AS dest ON rt.neighbor_id = dest.id ";
           		$query_sql.=" where rt.isopen =1 and rt.startplaceid={$cityid} ";
           		$query_sql.=$order;
           		return $this ->db ->query($query_sql) ->result_array(); 
           }
            /**
           *@method  国内游城市
           */
           function get_country_city($order=''){
           		$query_sql=" SELECT fdest.id, fdest.kindname ";
           		$query_sql.=" FROM	bangu.u_dest_base AS pdest ";
           		$query_sql.="  LEFT JOIN bangu.u_dest_base AS fdest ON pdest.id = fdest.pid ";
           		$query_sql.=" WHERE pdest.pid = 2 AND fdest.isopen = 1 AND fdest.ishot = 1 ";
           		$query_sql.=" ORDER BY fdest.displayorder ASC ";
           		$query_sql.=$order;
           		return $this ->db ->query($query_sql) ->result_array(); 
           }
           /*
           *@method 出境游
           */
           function get_abroad_city($order=''){
		$query_sql="  SELECT pdest.id,pdest.kindname ";
           		$query_sql.=" FROM	bangu.u_dest_base AS pdest ";
           		$query_sql.="  where pdest.ishot=1 and pdest.isopen=1 and pdest.pid=1 ";
           		$query_sql.=" ORDER BY pdest.displayorder ASC ";
           		$query_sql.=$order;
           		return $this ->db ->query($query_sql) ->result_array(); 
           }
           /**
           *@method 搜索视频
           */
           function get_video_data($name){
           		$query_sql=" SELECT lv.anchor_id,lv.name,lv.pic,lv.addtime,record_id FROM live_video AS lv ";
           		if(!empty($name)){
			$query_sql.=" where  lv.name LIKE '%{$name}%' ";
           		}
		$query_sql.=" GROUP BY lv.id  order by lv.id desc";
           		return $this ->db ->query($query_sql) ->result_array(); 
           }
            /**
           *@method 搜索主播
           */
           function get_anchor_data($name){
                  	$query_sql=" SELECT anchor_id,user_id,user_type,name,sex,photo as pic,fans,realname from live_anchor ";
		$query_sql.=" where status=1 ";
		if(!empty($name)){
			$query_sql.=" and name LIKE '%{$name}%' ";
		}
		$query_sql.=' order by fans desc ';
		return $this ->db ->query($query_sql) ->result_array(); 
           }
           /**
           *@method 主播视频的搜索
           */
           function get_action_video($name){
           		$query_sql=" SELECT lr.*,la.name,la.video_pic as pic ";
		$query_sql.=" FROM	 live_room AS lr ";   
		$query_sql.=" LEFT JOIN  live_anchor AS  la ON la.anchor_id= lr.anchor_id ";
                      	$query_sql.=" where lr.live_status=1 "; 
                        if(!empty($name)){
			$query_sql.=" and lr.room_name LIKE '%{$name}%' ";
		}
                      	$query_sql.="  order by peoples desc ";
                      	return $this ->db ->query($query_sql) ->result_array();
           }
           /**
           *@method 目的模糊匹配
           */
           function get_dest($name){
           		$query_sql=" SELECT id,kindname,isopen,displayorder from bangu.u_dest_base where isopen=1 ";
                         if(!empty($name)){
			$query_sql.=" and kindname LIKE '%{$name}%' ";
			$query_sql.="  order by displayorder asc  ";	
		}else{
		         $query_sql.="  order by displayorder asc limit 10 ";	
		}
                      	
                      	return $this ->db ->query($query_sql) ->result_array();
           }
}