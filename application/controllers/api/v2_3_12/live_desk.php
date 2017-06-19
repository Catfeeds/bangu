<?php

/**
 *   @name:APP接口文件
 *   @version: v2_3_12  对应APP 1.0.3版本
 *   @author: liujian
 *   @time: 2016-10-14 11:20:01
 *   
 * 	 @abstract:
 *
 * 		1、   cfgm是用户接口前缀 ，
 * 		    E是管家接口前缀，
 * 		    G是即时导游接口前缀，
 * 			P是公共函数接口前缀  ；
 *
 *      2、	 __outlivemsg()、__data()是输出格式化数据模式，
 *      	 __null()是输出空，
 *      	 __errormsg()是输出错误模式
 *        
 *      3、数据传递方式： POST
 * 		
 *      4、返回结果状态码:  2000是成功，4001是空null，-3是错误信息
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//继承APP_Controller类
class Live_desk extends APP_Controller {

    private $default_cityid = '235'; //默认城市id为深圳
    private $access_token = '';
    private $user_id = 0;
    private $user_info = array();	
    private $room_timeout = 0;//房间使用时间长度，以秒为单位	
    private $dictionary=array(
	    'DICT_ROOM_ATTR' => 1,//房间标签id
	);	
	
	private static $url = "https://livevip.com.cn/liveApi/";
	private static $username = "2853553772@qq.com";
	private static $password = "123456";
	private static $http_header = array("Accept:application/json");	
	
	
    public function __construct() {
        parent::__construct();
        header('Content-type: application/json;charset=utf-8');  //文档为json格式
        // 允许ajax POST跨域访问
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
		$this->access_token = $this->input->get('number', true); //获取用户登陆access_token
		if(!empty($this->access_token)){
			$this->user_id = $this->F_get_mid($this->access_token);
			if(!empty($this->user_id)){
				$sql = 'SELECT nickname FROM u_member WHERE mid= '.$this->user_id;
				$this->user_info =  $this->db->query($sql )->row_array();				
			}
		}
		$this->live_db = $this->load->database ( "live", TRUE );
    }

    public function get_param_rules() {
        return array(
            'cfgm_home' => array(
                'cityid' => array('name' => 'user_id', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
            ),
            'cfgm_get_city' => array(
                'userIds' => array('name' => 'user_ids', 'type' => 'array', 'format' => 'explode', 'require' => true, 'desc' => '用户ID，多个以逗号分割'),
            ),
        );
    }

    /**
     * 获取推荐列表数据
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function recommend_video_room() {
        $page = intval($this->input->post('page', true)); //翻页
        $offset = intval($this->input->post('offset', true)); //偏移量用在live_video表中		
        $page = empty($page) ? 1 : $page;
        $offset = empty($offset) ? 0 : $offset;		
        $page_size = 20;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from
        $sql_page = " LIMIT {$from},{$page_size}";
		$live_room_data = $live_video_data = array();
		if($offset==0){
			$sql_str = "select anchor_id,room_id,room_name as name,peoples as watching_num from live_room where live_status=1 and status=1 order by peoples desc,starttime desc {$sql_page} ";
			$live_room_data = $this->live_db->query($sql_str)->result_array();			
		}
        $num_live_room_data = count($live_room_data);
		$sql_page_l = "";
		if($num_live_room_data ==0 && $offset==0){//当live_room没有数据了，且已经翻页过了
			$offset = 1;
			$from = $offset-1;
            $sql_page_l = " LIMIT {$from},{$page_size}";
			$page = 1;
        }else if($num_live_room_data ==0 && $offset>0){//表示live_room没有数据，且live_video开始翻译了
		    if($offset>1){
		        $from =$from + $offset - 1;				
			}
            $sql_page_l = " LIMIT {$from},{$page_size}";
		}else if($num_live_room_data<$page_size && $num_live_room_data>0 &&  $offset==0){//表示live_room的数据不够$page_size条
            $sql_page_l = " LIMIT 0,".($page_size-$num_live_room_data);
			$offset = $page_size-$num_live_room_data;
			$page = 1;
		}
		if($sql_page_l){
			$sql_str = "select anchor_id,id as video_id,name,people as read_num,pic as cover from live_video order by people desc,addtime desc {$sql_page_l} ";
			$live_video_data = $this->live_db->query($sql_str)->result_array();				
		}
		$anchor_ids = array();
		if($num_live_room_data>0){
			foreach($live_room_data as $v){
				$anchor_ids[$v['anchor_id']] = $v['anchor_id'];
			}
		}
		if(!empty($live_video_data)){
			foreach($live_room_data as $v){
				$anchor_ids[$v['anchor_id']] = $v['anchor_id'];
			}
		}		
		$live_anchor_data = array();
		if(!empty($anchor_ids)){
			$sql_str = "select anchor_id,user_id,name,user_type,video_pic from live_anchor where anchor_id in(".implode(",",$anchor_ids).") ";
			$live_anchor_data = $this->live_db->query($sql_str)->result_array();				
		}

        $returnData = array();		
        $returnData['info'] = array(
		    array(
				"cover"=>"http://www.banggu.com/upfile/2.png",
				"avatar"=>"http://www.banggu.com/upfile/1.png",
				"anchor_name"=>"好好",
				"watching_num"=>"10545",
				"read_num"=>"10545",
				"anchor_id"=>"1",
				"anchor_type"=>"1",
				"anchor_sex"=>"1",
				"room_id"=>"2",
				"video_id"=> "1",
				"type"=>"3",
				"name"=> "宿雾"				
			),
		    array(
				"cover"=>"http://www.banggu.com/upfile/2.png",
				"avatar"=>"http://www.banggu.com/upfile/1.png",
				"anchor_name"=>"好好",
				"watching_num"=>"10545",
				"read_num"=>"10545",
				"anchor_id"=>"1",
				"anchor_type"=>"1",
				"anchor_sex"=>"1",
				"room_id"=>"2",
				"video_id"=> "1",
				"type"=>"3",
				"name"=> "宿雾"				
			),			
		);
        $returnData['offset'] = $offset;		
        $this->__outlivemsg($returnData);
    }
	
    /**
     * 获取关注列表数据
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function attention_video_room() {
        $page = intval($this->input->post('page', true)); //翻页
		if(empty($this->user_id)){//用户没有登录
			$this->__outlivemsg(array());			
		}
		
		$sql_str = "select lr.anchor_id,lr.room_id,lr.room_name as name,lr.peoples as watching_num from live_anchor_fans as laf left join live_room as lr on(laf.anchor_id=lr.anchor_id) where laf.status=1 and laf.user_id=".$this->user_id." order by lr.starttime desc {$sql_page} ";
		$live_room_data = $this->live_db->query($sql_str)->result_array();			
		
		$sql_str = "select lv.anchor_id,lv.id as video_id,lv.name,lv.people as read_num,lv.pic as cover from live_anchor_fans as laf left join live_video as lv on(laf.anchor_id=lv.anchor_id) where laf.status=1 and laf.user_id=".$this->user_id." order by lv.addtime desc {$sql_page} ";
		$live_video_data = $this->live_db->query($sql_str)->result_array();			
		
        $returnData = array();		
        $returnData['info'] = array(
		    array(
				"cover"=>"http://www.banggu.com/upfile/2.png",
				"avatar"=>"http://www.banggu.com/upfile/1.png",
				"anchor_name"=>"好好",
				"watching_num"=>"10545",
				"read_num"=>"10545",
				"anchor_id"=>"1",
				"anchor_type"=>"1",
				"anchor_sex"=>"1",
				"room_id"=>"2",
				"video_id"=> "1",
				"type"=>"3",
				"name"=> "宿雾"				
			),
		    array(
				"cover"=>"http://www.banggu.com/upfile/2.png",
				"avatar"=>"http://www.banggu.com/upfile/1.png",
				"anchor_name"=>"好好",
				"watching_num"=>"10545",
				"read_num"=>"10545",
				"anchor_id"=>"1",
				"anchor_type"=>"1",
				"anchor_sex"=>"1",
				"room_id"=>"2",
				"video_id"=> "1",
				"type"=>"3",
				"name"=> "宿雾"				
			),			
		);
        $this->__outlivemsg($returnData);
    }

    /**
     * 获取搜索列表数据
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function search_video_room() {
        $page = intval($this->input->post('page', true)); //翻页
        $keyworld = $this->input->post('keyworld', true); //翻页		
        $categoryid = intval($this->input->post('categoryid', true)); //翻页
        $anchortype = intval($this->input->post('anchortype', true)); //翻页
        $destid = intval($this->input->post('destid', true)); //翻页


		
        $returnData = array();		
        $returnData['info'] = array(
		    array(
				"cover"=>"http://www.banggu.com/upfile/2.png",
				"avatar"=>"http://www.banggu.com/upfile/1.png",
				"anchor_name"=>"好好",
				"watching_num"=>"10545",
				"read_num"=>"10545",
				"anchor_id"=>"1",
				"anchor_type"=>"1",
				"anchor_sex"=>"1",
				"room_id"=>"2",
				"video_id"=> "1",
				"type"=>"3",
				"name"=> "宿雾"				
			),
		    array(
				"cover"=>"http://www.banggu.com/upfile/2.png",
				"avatar"=>"http://www.banggu.com/upfile/1.png",
				"anchor_name"=>"好好",
				"watching_num"=>"10545",
				"read_num"=>"10545",
				"anchor_id"=>"1",
				"anchor_type"=>"1",
				"anchor_sex"=>"1",
				"room_id"=>"2",
				"video_id"=> "1",
				"type"=>"3",
				"name"=> "宿雾"				
			),			
		);
        $this->__outlivemsg($returnData);
    }

    /**
     * 获取搜索工具数据
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function search_tool_info() {
		$sql_str = "select dict_id as categoryid,description as categoryname,showorder from live_dictionary where enable=0 and pid=".$this->dictionary['DICT_ROOM_ATTR']." ";
		$category_live_dictionary_data = $this->live_db->query($sql_str)->result_array();
		foreach ($category_live_dictionary_data as $key => $value) {
			$sortfiled[$key] = $value['showorder'];//根据showorder字段排序
		}
		array_multisort($sortfiled, $category_live_dictionary_data);
		foreach ($category_live_dictionary_data as $key => $value) {
			unset($category_live_dictionary_data[$key]['showorder']);
		}		
        $returnData = array();
        $returnData['category'] = $category_live_dictionary_data;
        $returnData['anchortype'] = array(
		    array(
				"anchortypeid"=>"1",
				"anchortypename"=>"达人"				
			),
		    array(
				"anchortypeid"=>"2",
				"anchortypename"=>"领队"				
			),
		    array(
				"anchortypeid"=>"3",
				"anchortypename"=>"管家"				
			),			
		);
        $returnData['dest'] = array(
		    array(
				"destid"=> "1",
				"destname"=> "印度尼西亚",
				"desttype"=> "1"				
			),
		    array(
				"destid"=> "1",
				"destname"=> "印度尼西亚",
				"desttype"=> "1"				
			),			
		);		
        $this->__outlivemsg($returnData);
    }

    /**
     * 直播设置提交数据
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function create_room() {
		if(empty($this->user_id)){//用户没有登录
            $this->__outlivemsg(array());			
		}
        $categoryid = intval($this->input->post('categoryid', true)); //直播类型		
        $roomname = $this->input->post('roomname', true); //房间名称
        $cover = $this->input->post('cover', true); //视频封面		
        $destid = intval($this->input->post('destid', true)); //定位目的地	
        $lineid = intval($this->input->post('lineid', true)); //关联线路		

		$user_id = $this->user_id;		
		$sql = 'SELECT * FROM live_anchor WHERE user_id= '.$user_id;
		$live_anchor_data =  $this->live_db->query($sql )->row_array();
        if(empty($live_anchor_data) || (!empty($live_anchor_data) && $live_anchor_data['is_anchor']==0)){
			$returnData = array();	
			$this->__outlivemsg($returnData,'您还不是主播，请申请主播','3000');			
		}
		if($live_anchor_data['status']==0){
			$returnData = array();	
			$this->__outlivemsg($returnData,"您还不是主播，正在审核中",'3001');				
		}
		if($live_anchor_data['status']==2){
			$returnData = array();	
			$this->__outlivemsg($returnData,"您还不是主播，审核不通过，原因是：".$live_anchor_data['refuse_reason'],'3002');				
		}

		//生成唯一的标识符,在每次分配房间的时候
		list($tmp1, $tmp2) = explode(' ', microtime());
		$msec =  (float)sprintf('%.0f', (floatval($tmp1) + floatval($tmp2)) * 10000);
		$room_code = $msec.mt_rand(1,10000).'A'.$live_anchor_data['anchor_id'];		
		$nowtime = time();
		/*
			在分配房间前，检查是否把上次的直播信息插入到历史直播信息表中，如果有则直接初始化，如果没有则插入，
			然后变更直播间的信息，让starttime为当时时间，endtime为0,peoples=0，umoney=0，live_status=3
			然后
			1.当主播点击退出直播时或当系统自动到计时退出时endtime为退出时间,live_status=0同时将该记录插入到video表中
			2.当上面标题1中操作时数据没有更新时：也表示异常掉线，此时的endtime=0,
			3.当主播没点击退出直播，而直接掉线时,因为视频不全，所以不上传到video表中,这时endtime=0,同时如果主播再次进入到时候不进行修改然后信息继续使用上传的房间
			4.主播不是点击退出主播的视频不上传到video中
		$sql = 'SELECT * FROM live_room WHERE anchor_id= '.$live_anchor_data['anchor_id'].' and live_status>0 and status=1 and  starttime>'.($nowtime - $this->room_timeout).' and starttime < endtime ';
		$live_room_data =  $this->live_db->query($sql )->result_array();		
		if(!empty($live_room_data)){//您已经有房间正在使用
			$result = array("code"=>203,"res"=>"您已经有房间正在使用");			
		}			
		*/
		$iszhuang = 0;//表示不是专属房间分配
		$room_id =0;//分配的房间id
		if($live_anchor_data['room_id']>0){//表示有专属房间
			$sql = 'SELECT * FROM live_room WHERE room_id= '.$live_anchor_data['room_id'].' ';
			$live_room_data =  $this->live_db->query($sql )->row_array();		
			if(!empty($live_room_data) && $live_room_data['status']==1 && $live_room_data['type']==2 && ( $live_room_data['live_status']>0 || $live_room_data['starttime']>($nowtime - $this->room_timeout) ) ){//专属房间正在被使用
				$returnData = array();	
				$this->__outlivemsg($returnData,"您的专属房间正在使用中",'3003');						
			}else if(empty($live_room_data)){//不存在该房间,采用公共房间分配
				$iszhuang = 1;
			}else if(!empty($live_room_data)){//您的专属房间可以使用
				$sql = 'SELECT attr_id FROM live_room_attr WHERE room_id='.$live_room_data['room_id'].' limit 1';
				$old_live_room_attr_data =  $this->live_db->query($sql )->row_array();
				$old_attr_id =0;
				if(!empty($old_live_room_attr_data)){
					$old_attr_id =$old_live_room_attr_data['attr_id'];
				}	
				$sql = 'SELECT id FROM live_video WHERE anchor_id='.$live_anchor_data['anchor_id'].' and room_id='.$live_room_data['room_id'].' and room_code='.$live_room_data['room_code'].' and starttime='.$live_room_data['starttime'].'   limit 1';
				$live_video_data =  $this->live_db->query($sql )->row_array();				
				$this->live_db->trans_begin();//事务		
				//查询是否有空闲的房间然分配空间
				$sql = 'SELECT * FROM live_room WHERE status=1  and ( live_status=0 or  starttime<'.($nowtime - $this->room_timeout).' ) and room_id= '.$live_anchor_data['room_id'].' limit 1 FOR UPDATE';
				$live_room_data =  $this->live_db->query($sql )->row_array();		
				if(!empty($live_room_data)){//有可以使用的房间
					$this->live_db->query("update live_room set `line_ids`={$lineid},`room_code`={$room_code},`room_name`={$roomname},`pic`={$cover},`room_dest_id`={$destid},`starttime`={$nowtime},`peoples`=0,`umoney`=0,`live_status`=3,`endtime`=0 where room_id = ".$live_room_data['room_id']."");//	
					if(empty($live_video_data)){//检查是否已经插入过了
						$endtime = ($live_room_data['endtime']?$live_room_data['endtime']:($live_room_data['starttime']+$this->room_timeout));
						$pic = ($live_room_data['pic']?$live_room_data['pic']:$live_anchor_data['video_pic']);
						$insert_data = array(
								"anchor_id"	=>$live_anchor_data['anchor_id'],
								"room_id"	 	=>$live_room_data['room_id'],
								"room_code"			=>$live_room_data['room_code'],
								"video" 		=> $live_room_data['video_link'],
								"name"	=>$live_room_data['room_name'],
								"pic"	=>$pic,
								"addtime"	 	=>$nowtime,
								"starttime"			=>$live_room_data['starttime'],
								"endtime" 		=> $endtime,
								"time"	=>($endtime-$live_room_data['starttime']),							
								"people"	=>$live_room_data['peoples'],
								"collect"	 	=>0,
								"record_id"			=>0,
								"attr_id"	=>$old_attr_id,	
								"type"	=>1,
								"line_ids"	=>$live_room_data['line_ids'],									
						);	
						$this->live_db->insert('live_video', $insert_data);
						//$this->live_db->insert_id();							
					}				
					if(!empty($old_live_room_attr_data)){//表示存在,则修改
						$this->live_db->query("update live_room_attr set `attr_id`={$categoryid} where room_id = ".$live_room_data['room_id']."");//							
					}else{
						$insert_data = array(
								"room_id"	 	=>$live_room_data['room_id'],
								"attr_id"			=>$categoryid,							
							);	
						$this->live_db->insert('live_room_attr', $insert_data);						
					}
					$room_id =$live_room_data['room_id'];
				}else{//使用公用房间分配
					$iszhuang = 1;
				}		
				if ($this->live_db->trans_status() === FALSE) {
					$this->live_db->trans_rollback();	
				} else {
					$this->live_db->trans_commit();
				}							
			}			
		}
		if($iszhuang==1){//没有专属房间,使用公用房间分配
			$sql = 'SELECT room_id FROM live_room WHERE anchor_id= '.$live_anchor_data['anchor_id'].' and live_status>0 and status=1 and  starttime>'.($nowtime - $this->room_timeout).' ';
			$live_room_data =  $this->live_db->query($sql )->row_array();		
			if(!empty($live_room_data)){//您已经有房间正在使用
				$returnData = array();	
				$this->__outlivemsg($returnData,"您已经有房间正在使用",'3004');				
			}
			$this->live_db->trans_begin();//事务		
			//查询是否有空闲的房间然分配空间
			$sql = 'SELECT * FROM live_room WHERE  type=1 and live_status=0 and status=1 and  starttime<'.($nowtime - $this->room_timeout).' limit 1 FOR UPDATE';
			$live_room_data =  $this->live_db->query($sql )->row_array();		
			if(!empty($live_room_data)){//有可以使用的房间
				$this->live_db->query("update live_room set `line_ids`={$lineid},`room_code`={$room_code},`room_name`={$roomname},`pic`={$cover},`room_dest_id`={$destid},`starttime`={$nowtime},`peoples`=0,`umoney`=0,`live_status`=3,`endtime`=0 where room_id = ".$live_room_data['room_id']."");//	
				$sql = 'SELECT id FROM live_video WHERE anchor_id='.$live_anchor_data['anchor_id'].' and room_id='.$live_room_data['room_id'].' and room_code='.$live_room_data['room_code'].' and starttime='.$live_room_data['starttime'].'   limit 1';
				$live_video_data =  $this->live_db->query($sql )->row_array();			
				if(empty($live_video_data)){//检查是否已经插入过了
					$sql = 'SELECT attr_id FROM live_room_attr WHERE room_id='.$live_room_data['room_id'].' limit 1';
					$old_live_room_attr_data =  $this->live_db->query($sql )->row_array();
					$old_attr_id =0;
					if(!empty($old_live_room_attr_data)){
						$old_attr_id =$old_live_room_attr_data['attr_id'];
					}				
					$endtime = ($live_room_data['endtime']?$live_room_data['endtime']:($live_room_data['starttime']+$this->room_timeout));
					$pic = ($live_room_data['pic']?$live_room_data['pic']:$live_anchor_data['video_pic']);					
					$insert_data = array(
							"anchor_id"	=>$live_anchor_data['anchor_id'],
							"room_id"	 	=>$live_room_data['room_id'],
							"room_code"			=>$live_room_data['room_code'],
							"video" 		=> $live_room_data['video_link'],
							"name"	=>$live_room_data['room_name'],
							"pic"	=>$pic,
							"addtime"	 	=>$nowtime,
							"starttime"			=>$live_room_data['starttime'],
							"endtime" 		=> $endtime,
							"time"	=>($endtime-$live_room_data['starttime']),							
							"people"	=>$live_room_data['peoples'],
							"collect"	 	=>0,
							"record_id"			=>0,
							"attr_id"	=>$old_attr_id,	
							"type"	=>1,
							"line_ids"	=>$live_room_data['line_ids'],							
					);	
					$this->live_db->insert('live_video', $insert_data);
					//$this->live_db->insert_id();	
					if(!empty($old_live_room_attr_data)){//表示存在,则修改
						$this->live_db->query("update live_room_attr set `attr_id`={$categoryid} where room_id = ".$live_room_data['room_id']."");//							
					}else{
						$insert_data = array(
								"room_id"	 	=>$live_room_data['room_id'],
								"attr_id"			=>$categoryid,							
							);	
						$this->live_db->insert('live_room_attr', $insert_data);						
					}					
				}
				$room_id =$live_room_data['room_id'];
			}	
			if ($this->live_db->trans_status() === FALSE) {
				$this->live_db->trans_rollback();	
			} else {
				$this->live_db->trans_commit();
			}			
			
		}
		if($room_id>0){//表示分配成功
			$returnData = array('room_id'=>$room_id);			
		}else{//分配失败
			$returnData = array('room_id'=>0);				
		}
		$this->__outlivemsg($returnData);	
    }

	
	
	

    /**
     * 根据定位目的地选择关联线路数据
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function get_line_by_destid() {
        $destid = $this->input->post('destid', true); //目的地id
        $keyworld = $this->input->post('keyworld', true); //关键字
        $page = intval($this->input->post('page', true)); //翻页		
        $page = empty($page) ? 1 : $page;	
        $page_size = 20;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from
        $sql_page = " LIMIT {$from},{$page_size}";	
		$where = 'l.line_status=1 and l.status=2 ';
		$where1 = '';
		if($destid){
			$where1 = ' and ld.dest_id='.$destid;
		}
		if($keyworld){
			$where .= ' and l.linename like"%'.$keyworld.'%"';
		}
		$sql_str = "select l.id as lineid,l.linename as line_name  from u_line as l left join u_line_dest as ld on(l.id = ld.line_id ".$where1." )  where ".$where." order by l.id desc {$sql_page} ";
		$live_room_chat_data = $this->db->query($sql_str)->result_array();
        $returnData = array();	
        $returnData['info'] = $live_room_chat_data;		
        $this->__outlivemsg($returnData);
    }

    /**
     * 获取滚动评论区数据
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function get_current_room_chat() {
        $roomid = intval($this->input->post('roomid', true)); //直播房间id
        $roomcode = $this->input->post('roomcode', true); //直播房间code			
        $currenttime = intval($this->input->post('currenttime', true)); //用户进入房间的当时时间，根据这个时间来判断还没有加载的聊天记录
        if(empty($currenttime)) $currenttime = time();
		$sql_str = "select nickname,content,addtime from live_room_chat where room_id=".$roomid." and room_code=".$roomcode." addtime>'".$currenttime."' limit 20 ";
		$live_room_chat_data = $this->live_db->query($sql_str)->result_array();
		foreach ($live_room_chat_data as $key => $value) {
			$sortfiled[$key] = $value['addtime'];//根据addtime字段排序
		}
		array_multisort($sortfiled, $live_room_chat_data);
		foreach ($live_room_chat_data as $key => $value) {
			unset($live_room_chat_data[$key]['addtime']);
		}	
		
		
        $returnData = array();
		$returnData['info'] = $live_room_chat_data;
        /*$returnData['info'] = array(
		    array(
				"nickname"=>"宿雾",
				"content"=>"你好不好"		
			),
		    array(
				"nickname"=>"宿雾",
				"content"=>"你好不好"		
			),			
		);*/
        $returnData['currenttime'] = $currenttime;		
        $this->__outlivemsg($returnData);
    }

    /**
     * 获取礼物特性区数据
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function get_current_giving_gifts() {
        $roomid = $this->input->post('roomid', true); //直播房间id
        $roomcode = $this->input->post('roomcode', true); //直播房间code			
        $currenttime = $this->input->post('currenttime', true); //用户进入房间的当时时间，根据这个时间来判断最新送出的礼物
        if(empty($currenttime)) $currenttime = time();
		$sql_str = "select gift_id,gift_name,pic from live_gift ";
		$live_gift_data = $this->live_db->query($sql_str)->result_array();	
		$live_gift_data_byid = array();
		foreach($live_gift_data as $v){
			$live_gift_data_byid[$v['gift_id']] = $v;
		}
		
		$sql_str = "select gift_id,worth,addtime from live_gift_record where room_id=".$roomid." and room_code=".$roomcode." addtime>'".$currenttime."' limit 20 ";
		$live_gift_record_data = $this->live_db->query($sql_str)->result_array();
		foreach ($live_gift_record_data as $key => $value) {
			$sortfiled[$key] = $value['addtime'];//根据addtime字段排序
		}
		array_multisort($sortfiled, $live_gift_record_data);
		$return_gift_record = array();
		foreach ($live_gift_record_data as $key => $value) {
            $return_gift_record[$key]['name']=$live_gift_data_byid[$value['gift_id']]['gift_name'];	
            $return_gift_record[$key]['worth']=$value['worth'];			
            $return_gift_record[$key]['icon']=$live_gift_data_byid[$value['gift_id']]['pic'];			
		}			

		
        $returnData = array();
		$returnData['info'] = $return_gift_record;
        /*$returnData['info'] = array(
			array(
				"name"=>"飞机",
				"worth"=>"1000",
				"icon"=>"icon/1.png"			
			),
			array(
				"name"=>"飞机",
				"worth"=>"1000",
				"icon"=>"icon/1.png"			
			),			
		);*/
        $this->__outlivemsg($returnData);
    }

    /**
     * 聊天及回复内容提交数据
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function send_room_chat_info() {
        $roomid = intval($this->input->post('roomid', true)); //直播房间id
        $roomcode = $this->input->post('roomcode', true); //直播房间code		
        $content = $this->input->post('content', true); //聊天内容			
		$insert_data = array(
			"room_id"	 	=>$roomid,
			"room_code"			=>$roomcode,
			"user_id" 		=>$this->user_id,
			"nickname"	=>$this->user_info['nickname'],
			"content"	=>$content,
			"addtime"	 	=>date("Y-m-d H:i:s"),						
		);
		$this->live_db->insert('live_room_chat', $insert_data);		
        $returnData = array();
        $this->__outlivemsg($returnData);
    }

    /**
     * 获取直播信息数据
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function get_room_infos() {
        $roomid = intval($this->input->post('roomid', true)); //直播房间id
		$sql_str = "select peoples,starttime,umoney from live_room where room_id=".$roomid." ";
		$live_room_data = $this->live_db->query($sql_str)->row_array();		
		
        $returnData = array();		
        $returnData['info'] = array(
			"peoples"=>$live_room_data['peoples'],
			"collect"=>0,
			"time"=>$live_room_data['starttime'],
			"umoney"=>$live_room_data['umoney'],		
		);
        $this->__outlivemsg($returnData);
    }

    /**
     * 获取直播中聊天记录动态数据
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function get_room_chat_list() {
        $roomid = intval($this->input->post('roomid', true)); //直播房间id
        $roomcode = $this->input->post('roomcode', true); //直播房间code		
        $page = intval($this->input->post('page', true)); //翻页		
        $page = empty($page) ? 1 : $page;	
        $page_size = 20;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from
        $sql_page = " LIMIT {$from},{$page_size}";		
		$sql_str = "select user_id,nickname,content,addtime from live_room_chat where room_id=".$roomid." and room_code=".$roomcode." order by id desc {$sql_page} ";
		$live_room_chat_data = $this->live_db->query($sql_str)->result_array();

        $returnData = array();
		$returnData['info'] = $live_room_chat_data;
        $this->__outlivemsg($returnData);
    }

    /**
     * 进入直播且点击开始直播时初始化直播间信息
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function go_into_room() {
        $roomid = intval($this->input->post('roomid', true)); //直播房间id
		if(empty($this->user_id)){//用户没有登录
            $this->__outlivemsg(array());			
		}
		$user_id = $this->user_id;		
		$sql = 'SELECT anchor_id FROM live_anchor WHERE user_id= '.$user_id;
		$live_anchor_data =  $this->live_db->query($sql )->row_array();
        if(empty($live_anchor_data)){
			$returnData = array();	
			$this->__outlivemsg($returnData,'您不是主播','2001');			
		}		
		$sql_str = "select starttime from live_room where room_id=".$roomid." and anchor_id=".$live_anchor_data['anchor_id'];
		$live_room_data = $this->live_db->query($sql_str)->row_array();			
		if(empty($live_room_data)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"房间不存在",'2002');				
		}		
		$nowtime = time();
		$this->live_db->query("update live_room set `live_status`=1,`endtime`={$nowtime} where room_id = ".$roomid."");		
        $returnData = array();
        $this->__outlivemsg($returnData);
    }

    /**
     * 直播过程中定时检测视频结束时间
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function check_room_sign_out_time() {
        $roomid = intval($this->input->post('roomid', true)); //直播房间id
		if(empty($this->user_id)){//用户没有登录
            $this->__outlivemsg(array());			
		}
		$user_id = $this->user_id;		
		$sql = 'SELECT anchor_id FROM live_anchor WHERE user_id= '.$user_id;
		$live_anchor_data =  $this->live_db->query($sql )->row_array();
        if(empty($live_anchor_data)){
			$returnData = array();	
			$this->__outlivemsg($returnData,'您不是主播','2001');			
		}		
		$sql_str = "select starttime from live_room where room_id=".$roomid." and anchor_id=".$live_anchor_data['anchor_id'];
		$live_room_data = $this->live_db->query($sql_str)->row_array();			
		if(empty($live_room_data)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"房间不存在",'2002');				
		}
		$nowtime = time();		
		if($live_room_data['starttime'] && $live_room_data['starttime']>($nowtime - $this->room_timeout) ){
			$this->live_db->query("update live_room set `live_status`=0,`endtime`={$nowtime} where room_id = ".$roomid."");				
			$returnData = array();	
			$this->__outlivemsg($returnData,"已经结束",'2003');				
		}
		$this->live_db->query("update live_room set `endtime`={$nowtime} where room_id = ".$roomid."");	
		$cle = $this->room_timeout-($nowtime-$live_room_data['starttime']); //得出视频播放的时间戳差值		
        $returnData = array(
			'starttime'=>$live_room_data['starttime'],
			'totime'=>$cle,//剩余时间戳
			'tominutes'=> floor(($cle%(3600*24))%3600/60),  //视频播放的剩余时间长度(分钟)
		);
        $this->__outlivemsg($returnData);
    }

    /**
     * 退出直播时更改直播间信息
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function sign_out_room() {
        $roomid = intval($this->input->post('roomid', true)); //直播房间id
		if(empty($this->user_id)){//用户没有登录
            $this->__outlivemsg(array());			
		}
		$user_id = $this->user_id;		
		$sql = 'SELECT anchor_id FROM live_anchor WHERE user_id= '.$user_id;
		$live_anchor_data =  $this->live_db->query($sql )->row_array();
        if(empty($live_anchor_data)){
			$returnData = array();	
			$this->__outlivemsg($returnData,'您不是主播','2001');			
		}	
		$sql_str = "select starttime from live_room where room_id=".$roomid." and anchor_id=".$live_anchor_data['anchor_id'];
		$live_room_data = $this->live_db->query($sql_str)->row_array();			
		if(empty($live_room_data)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"房间不存在",'2002');				
		}
		$nowtime = time();		
		if($live_room_data['starttime'] && $live_room_data['starttime']>($nowtime - $this->room_timeout) ){
			$this->__outlivemsg($returnData,"已经结束",'2003');				
		}
		$this->live_db->query("update live_room set `live_status`=0,`endtime`={$nowtime} where room_id = ".$roomid."");	
        $returnData = array();
        $this->__outlivemsg($returnData);
    }

    /**
     * 视频路径，视频标题，定位地理位置提交
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function send_video_infos() {
        $returnData = array('video_id'=>'1');
        $this->__outlivemsg($returnData);
    }

    /**
     * 获取聊天信息列表及参与人数统计数据
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function get_room_chat_list_and_total() {
        $roomid = intval($this->input->post('roomid', true)); //直播房间id
		
        $page = intval($this->input->post('page', true)); //翻页		
        $page = empty($page) ? 1 : $page;	
        $page_size = 20;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from
        $sql_page = " LIMIT {$from},{$page_size}";		
		$sql_str = "select user_id,nickname,content,addtime from live_room_chat where room_id=".$roomid." order by id desc {$sql_page} ";
		$live_room_chat_data = $this->live_db->query($sql_str)->result_array();		
		
		$sql_str = 'select count(*) as total from (select user_id from live_room_chat GROUP BY user_id order by null ) as a';
		$live_room_chat_total = $this->live_db->query($sql_str)->row_array();	
		
        $returnData = array();
        $returnData['info'] = $live_room_chat_data;
        $returnData['total'] = $live_room_chat_total;			
		/*
        $returnData['info'] = array(
			array(
				"nickname"=>"宿雾",
				"content"=>"你好吗",
				"user_id"=>"11",
				"addtime"=>"2016-12-12 12:23:12",			
			),
			array(
				"nickname"=>"宿雾",
				"content"=>"你好吗",
				"user_id"=>"11",
				"addtime"=>"2016-12-12 12:23:12",			
			),			
		);
        $returnData['total'] = '2';	
		*/
        $this->__outlivemsg($returnData);
    }

    /**
     * 获取贡献列表及打赏人数统计数据
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function get_room_giving_gifts_list_and_total() {
        $roomid = intval($this->input->post('roomid', true)); //直播房间id
        $page = intval($this->input->post('page', true)); //翻页		
        $page = empty($page) ? 1 : $page;	
        $page_size = 20;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from
        $sql_page = " LIMIT {$from},{$page_size}";
		$sql_str = "select gift_id,gift_name,pic from live_gift ";
		$live_gift_data = $this->live_db->query($sql_str)->result_array();	
		$live_gift_data_byid = array();
		foreach($live_gift_data as $v){
			$live_gift_data_byid[$v['gift_id']] = $v;
		}
		
		$sql_str = "select gift_id,user_id,worth,addtime from live_gift_record where room_id=".$roomid." order by id desc {$sql_page} ";
		$live_gift_record_data = $this->live_db->query($sql_str)->result_array();
		$user_ids = array();
		$user_nick = array();
		foreach($live_gift_record_data as $k => $v){
			$user_ids[$v['user_id']]= $v['user_id'];
		}
		if(!empty($user_ids)){
			$sql = 'SELECT mid,nickname FROM u_member WHERE mid in('.implode(',',$user_ids).')';
			$u_member =  $this->db->query($sql )->result_array();	
			foreach($u_member as $v){
				$user_nick[$v['mid']]= $v['nickname'];
			}			
		}

		foreach($live_gift_record_data as $k => $v){
			$live_gift_record_data[$k]['icon'] = $live_gift_data_byid[$v['gift_id']]['pic'];
			$live_gift_record_data[$k]['nickname'] = $user_nick[$v['user_id']];
			unset($live_gift_record_data[$k]['gift_id'],$live_gift_record_data[$k]['addtime']);
		}		
		$sql_str = 'select count(*) as total from (select user_id from live_gift_record GROUP BY user_id order by null ) as a';
		$live_gift_record_total = $this->live_db->query($sql_str)->row_array();		

        $returnData = array();
        $returnData['info'] = $live_gift_record_data;
        $returnData['total'] = $live_gift_record_total;			
		/*
        $returnData['info'] = array(
			array(
				"nickname"=>"飞飞",
				"worth"=>"200",
				"icon"=>"1.png",
				"user_id"=>"1",			
			),
			array(
				"nickname"=>"飞飞",
				"worth"=>"200",
				"icon"=>"1.png",
				"user_id"=>"1",				
			),			
		);
        $returnData['total'] = '2';	
*/		
        $this->__outlivemsg($returnData);
    }

    /**
     * 获取关联线路数据
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function get_line_by_room_or_video() {
        $returnData = array();
        $this->__outlivemsg($returnData);
    }

    /**
     * 关注及取消关注
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function attention_anchor() {
        $anchor_id = $this->input->post('anchor_id', true); //主播id
        $user_id = $this->input->post('user_id', true); //用户id
        if(empty($anchor_id) || empty($user_id) ){
			$returnData = array();	
			$this->__outlivemsg($returnData,'参数错误','2001');			
		}
		$sql_str = "select id,status from live_anchor_fans where anchor_id=".$anchor_id." and user_id=".$user_id;
		$live_anchor_fans_data = $this->live_db->query($sql_str)->row_array();	
		if(!empty($live_anchor_fans_data)){
			if($live_anchor_fans_data['status']==1){//取消关注
				$this->live_db->query("update live_anchor_fans set `status`=0 where id = ".$live_anchor_fans_data['id']."");				
				$returnData = array(
					'code'=>'0',
				);					
			}else{
				$this->live_db->query("update live_anchor_fans set `status`=1 where id = ".$live_anchor_fans_data['id']."");				
				$returnData = array(
					'code'=>'1',
				);				
			}
		}else{//表示未关注，要进行关注
			$insert_data=array(
				'anchor_id'=>$anchor_id,
				'user_id'=>$user_id,
				'addtime'=>date('Y-m-d H:i:s',time()),
				'status'=>1,
			);
			$this->live_db->insert('live_anchor_fans', $insert_data);
			$returnData = array(
				'code'=>'1',
			);			
		}
        $this->__outlivemsg($returnData);
    }

    /**
     * 送礼物（即打赏）
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function giving_gifts_to_anchor() {
        $roomid = $this->input->post('roomid', true); //直播房间id
        $giftid = $this->input->post('giftid', true); //礼物id
		$sql_str = "select anchor_id,room_code from live_room where room_id=".$roomid."";
		$live_room_data = $this->live_db->query($sql_str)->row_array();	
		
		$sql_str = "select gift_id,gift_name as name,pic as icon,worth,unit from live_gift where status=1 and gift_id=".$giftid;
		$live_gift_data = $this->live_db->query($sql_str)->row_array();	
		$this->live_db->trans_begin();//事务
		$this->live_db->query("update live_anchor set `umoney`=umoney+".$live_gift_data['worth']." where anchor_id = ".$live_room_data['anchor_id']."");//	
		$insert_data = array(
			"gift_id"	 	=>$giftid,
			"anchor_id"			=>$live_room_data['anchor_id'],		
			"room_id"	 	=>$roomid,
			"room_code"			=>$live_room_data['room_code'],
			"user_id" 		=>$this->user_id,
			"num"	=>1,
			"worth" 		=>$live_gift_data['worth'],			
			"addtime"	 	=>date("Y-m-d H:i:s"),	
			"pic"	=>$live_gift_data['pic'],			
		);
		$this->live_db->insert('live_gift_record', $insert_data);	
		if ($this->live_db->trans_status() === FALSE) {
			$this->live_db->trans_rollback();	
		} else {
			$this->live_db->trans_commit();
		}			
        $returnData = array();
        $this->__outlivemsg($returnData);
    }

    /**
     * 获取礼物列表数据
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function get_gifts_list() {
		$sql_str = "select gift_id,gift_name as name,pic as icon,worth,unit from live_gift where status=1 ";
		$live_gift_data = $this->live_db->query($sql_str)->result_array();	
        $returnData = array();
        $returnData['info'] = $live_gift_data;		
        $this->__outlivemsg($returnData);
    }

    /**
     * 获取App首页推荐数据
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function get_app_index_infos() {
        $returnData = array();
        $this->__outlivemsg($returnData);
    }
	
	
	//观众进入房间观看直播的时候
	function visitor_in_room(){
		$room_id = $this->input->post("room_id",true);
		$this->live_db->query("update live_room set `peoples`=peoples+1 where room_id = ".$roomid."");	
        $returnData = array();
        $this->__outlivemsg($returnData);
	}

	//观众退出房间观看的时候
	function visitor_out_room(){
		$room_id = $this->input->post("room_id",true);
		$this->live_db->query("update live_room set `peoples`=peoples-1 where room_id = ".$roomid."");	
        $returnData = array();
        $this->__outlivemsg($returnData);
	}	
	
	
	
	//获取刚刚保存的视频数据
	public static function get_new_video($room_id=""){
		self::getAccessToken();
		$param = array(
			"queryRoomId"=>$room_id,
			"index"			=>0,
			"count"			=>""
			);
		$return_result = self::curlUtils($param,"GetRecordings");
		$recordRes 	= self::result_sort($return_result['entities'],"recordingId");
		return array_shift($recordRes);
	}




	//对某一房间下的视频按照recordId排序
	public static function result_sort($arrays,$sort_key,$sort_order=SORT_DESC,$sort_type=SORT_NUMERIC ){
        	if(is_array($arrays)){
            	foreach ($arrays as $array){
                		if(is_array($array)){
                   		 $key_arrays[] = $array[$sort_key];
               		 }else{
                    		return false;
                		}
           		 }
        }else{
            return false;
        }
        array_multisort($key_arrays,$sort_order,$sort_type,$arrays);
        return $arrays;
    }

		//获取验证码
	public static function getAccessToken(){
		$param = array("password"=>self::$password,"scope"=>"app","username"=>self::$username);
		$return_result = self::curlUtils($param,"AccessToken");
		self::$http_header[] = 'Authorization: '.$return_result['accessToken'];
	}

	//Curl工具方法
	public static function curlUtils($param=array(), $accessMethod=""){
		$param = http_build_query($param);
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, self::$url.$accessMethod);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt ($ch, CURLOPT_HTTPHEADER, self::$http_header);
		curl_setopt ($ch, CURLOPT_HEADER, 0);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $param);
		$return_result = json_decode(curl_exec($ch),true);
		curl_close($ch);
		return $return_result;
	}	
	
}

/* End of file webservices.php */
/* Location: ./application/controllers/webservices.php */