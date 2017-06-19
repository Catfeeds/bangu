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
    private $user_type = 0;//获取用户类型0用户1管家	
    private $user_info = array();	
    private $live_anchor_info = array();//登录进去的主播表信息	
    private $room_timeout = 1800;//房间使用时间长度，以秒为单位	
    private $dictionary=array(
	    'DICT_ROOM_ATTR' => 1,//房间标签id
		'DICT_CONSTELLATION'=>7,//星座
		'DICT_EXPERT_ATTR'=>32,//性格
		'DICT_LIFE_ATTR'=>42,//生活方式
		'DICT_DECADE'=>25,//年代		
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
		$this->access_token = $this->input->post('number', true); //获取用户登陆access_token
		$this->user_type = intval($this->input->post('type', true)); //获取用户类型0用户1管家	
		$this->live_db = $this->load->database ( "live", TRUE );
		if(!empty($this->access_token)){
			if(!in_array($this->user_type,array(0,1))){
				$returnData = array();	
				$this->__outlivemsg($returnData,'用户类型参数错误!','1000');					
			}
			if($this->user_type==1){//管家用户
				$this->user_id = $this->F_get_eid($this->access_token);				
			}else{//普通用户
				$this->user_id = $this->F_get_mid($this->access_token);				
			}
			if(!empty($this->user_id)){//用户登录
				if($this->user_type==1){//判断是管家
					$sql = 'SELECT * FROM u_expert WHERE id= '.$this->user_id;
					$this->user_info =  $this->db->query($sql )->row_array();					
				}else{//判断是用户
					$sql = 'SELECT * FROM u_member WHERE mid= '.$this->user_id;
					$this->user_info =  $this->db->query($sql )->row_array();					
				}
				$sql = 'SELECT * FROM live_anchor WHERE user_id= '.$this->user_id.' and user_type='.$this->user_type;
				$live_anchor_data =  $this->live_db->query($sql)->row_array();
				if(empty($live_anchor_data)){
					$live_anchor_data =  $this->insert_live_anchor($this->user_id,$this->user_type);
				}
				$this->live_anchor_info = $live_anchor_data;			
			}else{
				//$this->user_type = 0;
				//$returnData = array();	
				//$this->__outlivemsg($returnData,'您还没有登录','1001');				
			}
		}
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
	*@method:插入用户信息
	 * @author: xml
	 * @param: $user_id:用户id；$user_type:用户类型 0:用户 ,1:管家
	*/
	private function  insert_live_anchor($user_id,$user_type){
		$data = array();
		$user= $this->user_info;
		if($user_id>0 && $user_type==0){ //用户注册主播
			$data['name']=$user['nickname']; //真实姓名
			$data['photo']=$user['litpic']; //头像图片
			$data['type']=0; //0普通用户1达人2领队3管家
		}elseif($user_id >0 && $user_type==1){ //管家注册主播
			$data['name']=$user['nickname']; //真实姓名
			$data['photo']=$user['small_photo']; //头像图片
			$data['country']=$user['country']; //国家id
			$data['type']=3; //0普通用户1达人2领队3管家
		}
		//添加的数据
		$data['user_id']=$user_id;  
		$data['user_type']=$user_type; //注册类型
		//$data['status']=5;//用户状态
		if($user_type==1){ //管家直接是主播
			$data['status']=1;//主播状态
		}else{
			$data['status']=5;//用户状态
		}		
		$data['mobile']=$user['mobile']; //手机号
		$data['sex']=$user['sex']; //性别
		$data['province']=$user['province']; //省份id
		$data['city']=$user['city']; //城市id
		$this->live_db->insert("live_anchor",$data);
		$anchor_id=$this->live_db->insert_id();
		$data['anchor_id'] = $anchor_id;
		return $data;
	}

    /**
     * 检查主播是否合法及判断是否登录
     */
    private function anchor_verification() {
		if(empty($this->user_id)){//用户没有登录
			$returnData = array();	
			$this->__outlivemsg($returnData,'您还没有登录','1001');				
		}
		if($this->user_type==1){
			return true;
		}		
		$live_anchor_data =  $this->live_anchor_info;
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
	}	

	
	/**
	 * @method:主播注册
	 * @author: xml
	 * @param: $user_id:用户id；$user_type:用户类型 0:用户 ,1:管家
	 * @return:
	 */
	public function save_live_anchor() 
	{
		if(empty($this->user_id)){//用户没有登录
			$returnData = array();	
			$this->__outlivemsg($returnData,'您还没有登录','1001');				
		}		
		//APP传来的数据
		$name=$this->input->post('name',true);//主播昵称
		//$description=$this->input->post('description',true);//个人简介
		$comment=$this->input->post('comment',true);//个人签名

		$idcard=$this->input->post('idcard',true);//身份证正面照
        $idcardconpic=$this->input->post('idcardconpic',true);//身份证反面照 
		
		//$video_pic=$this->input->post('video_pic',true);//视频封面	
		//$anchor_attr=$this->input->post('anchor_attr',true);//	
		$photo=$this->input->post('photo',true);//头像		
		$anchor_pic=$this->input->post('anchor_pic');//头像背景


		$constellation=$this->input->post('constellation',true);//个性标签数组
		$expert=$this->input->post('expert',true);//个性标签数组
		//$life=$this->input->post('life',true);//个性标签数组
		$decade=$this->input->post('decade',true);//个性标签数组
		$attr_ids=array($constellation,$expert,$decade);		
		//验证数据
		if(empty($name)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"昵称不能为空!",'3001');			
		}
		$live_anchor_data =  $this->live_anchor_info;
		if(!empty($live_anchor_data)){
			//修改数据
			$data = array();
			$data['name']=$name ;     //主播名
			//$data['description']=$description ;  //个人简介
			$data['comment']=$comment;//个人签名
			$data['idcard']=$idcard;//身份证正面照
			$data['idcardconpic']=$idcardconpic;//身份证正面照
			$data['photo']=$photo;//视频封面图
			$data['addtime']=date("Y-m-d H:i:s",time());//添加时间
			$data['applytime']=date("Y-m-d H:i:s",time());//申请时间
			$data['modtime']=date("Y-m-d H:i:s",time());//修改时间
			$data['status']=0;//申请状态
			$this->live_db->update('live_anchor', $data, array('user_id'=>$this->user_id));	

			$this->live_db->delete('live_anchor_attr', array('anchor_id'=>$live_anchor_data['anchor_id']));
			$insert_data = array();
			foreach($attr_ids as $k=> $v){
				if($v){
					$insert_data[$k] = array(
							"anchor_id"	 	=>$live_anchor_data['anchor_id'],
							"attr_id"			=>$v,							
						);						
				}
			}
			$this->live_db->insert_batch('live_anchor_attr', $insert_data);
			$returnData = array();
			$this->__outlivemsg($returnData);			
		}else{
			$returnData = array();	
			$this->__outlivemsg($returnData,"注册异常!",'3020');			
		}
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
		$nowtime = time();
        $page = intval($this->input->post('page', true)); //翻页	
        $page = empty($page) ? 1 : $page;	
        $page_size = 20;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from
        $sql_page = " LIMIT {$from},{$page_size}";
		$sql_str = '(select anchor_id,room_id,0 as video_id, room_name as name,0 as read_num,peoples as watching_num,pic as cover,starttime as addtime,peoples as peopleby,3 as type,room_dest as dest_name,room_dest_id as dest_id from live_room  where live_status>0 and status=1  and  createtime>'.($nowtime - $this->room_timeout).' )union (select anchor_id,room_id,id as video_id,name,people as read_num,0 as watching_num,pic as cover,addtime,people as peopleby,type,dest_name,dest_id from live_video where video<>"" ) order by peopleby desc,addtime desc '.$sql_page;
		$live_room_data = $this->live_db->query($sql_str)->result_array();			
		$num_live_room_data = count($live_room_data);
		$anchor_ids = array();
		if($num_live_room_data>0){
			foreach($live_room_data as $v){
				$v['anchor_id'] && $anchor_ids[$v['anchor_id']] = $v['anchor_id'];					
			}
		}		
		$live_anchor_ids_data = array();		
		if(!empty($anchor_ids)){ 
			$sql_str = "select anchor_id,user_id,name,user_type,video_pic,sex,photo,type from live_anchor where anchor_id in(".trim(implode(",",$anchor_ids),',').") ";
			$live_anchor_data = $this->live_db->query($sql_str)->result_array();
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
				}
				unset($live_room_data[$k]['addtime'],$live_room_data[$k]['peopleby']);
			}
		}		
		if(empty($live_room_data)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"无数据",'4001');				
		}		
        $returnData = array();		
        $returnData['info'] =$live_room_data;	
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
		$nowtime = time();		
		//$this->user_id =278;
		if(empty($this->user_id)){//用户没有登录
			$returnData = array();	
			$this->__outlivemsg($returnData,"无数据",'4001');			
		}
        $page = intval($this->input->post('page', true)); //翻页	
        $page = empty($page) ? 1 : $page;	
        $page_size = 20;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from
        $sql_page = " LIMIT {$from},{$page_size}";
		$sql_str = 'select lr.* from live_anchor_fans as laf left join ((select anchor_id,room_id,0 as video_id, room_name as name,0 as read_num,peoples as watching_num,pic as cover,starttime as addtime,peoples as peopleby,3 as type,room_dest as dest_name,room_dest_id as dest_id from live_room  where live_status>0 and status=1  and  createtime>'.($nowtime - $this->room_timeout).' )union (select anchor_id,room_id,id as video_id,name,people as read_num,0 as watching_num,pic as cover,addtime,people as peopleby,type,dest_name,dest_id from live_video where  video<>"" )) as lr on(laf.anchor_id=lr.anchor_id) where laf.status=1 and laf.user_id='.$this->user_id.' order by lr.addtime desc,lr.peopleby desc '.$sql_page;
		$live_room_data = $this->live_db->query($sql_str)->result_array();			
		$num_live_room_data = count($live_room_data);
		$anchor_ids = array();
		if($num_live_room_data>0){
			foreach($live_room_data as $v){
				$v['anchor_id'] && $anchor_ids[$v['anchor_id']] = $v['anchor_id'];
			}
		}		
		$live_anchor_ids_data = array();		
		if(!empty($anchor_ids)){
			$sql_str = "select anchor_id,user_id,name,user_type,video_pic,sex,photo,type from live_anchor where anchor_id in(".trim(implode(",",$anchor_ids),',').") ";
			$live_anchor_data = $this->live_db->query($sql_str)->result_array();
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
				}
				unset($live_room_data[$k]['addtime'],$live_room_data[$k]['peopleby']);
			}
		}		
		if(empty($live_room_data)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"无数据",'4001');				
		}		
        $returnData = array();		
        $returnData['info'] = $live_room_data;
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
		$nowtime = time();		
        $keyworld = $this->input->post('keyworld', true); //		
        $categoryid = intval($this->input->post('categoryid', true)); //
        $anchortype = intval($this->input->post('anchortype', true)); //
        $destid = intval($this->input->post('destid', true)); //
		
        $page = intval($this->input->post('page', true)); //翻页	
        $page = empty($page) ? 1 : $page;	
        $page_size = 20;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from
        $sql_page = " LIMIT {$from},{$page_size}";
		$where1 = '';
		$where2 = '';		
		if($keyworld){
			$where1 .= ' and room_name like"%'.$keyworld.'%" ';
			$where2 .= ' and name like"%'.$keyworld.'%" ';			
		}
		if($categoryid){
			$where1 .= ' and attr_id='.$categoryid.' ';
			$where2 .= ' and attr_id='.$categoryid.' ';			
		}		
		if($anchortype){
			$where1 .= ' and user_type='.$anchortype.' ';
			$where2 .= ' and user_type='.$anchortype.' ';			
		}
		if($destid){
			$where1 .= ' and room_dest_id='.$destid.' ';
			$where2 .= ' and dest_id='.$destid.' ';			
		}
		$sql_str = '(select anchor_id,room_id,0 as video_id, room_name as name,0 as read_num,peoples as watching_num,pic as cover,starttime as addtime,peoples as peopleby,3 as type,room_dest as dest_name,room_dest_id as dest_id from live_room  where live_status>0 and status=1 '.$where1.'  and  createtime>'.($nowtime - $this->room_timeout).' )union (select anchor_id,room_id,id as video_id,name,people as read_num,0 as watching_num,pic as cover,addtime,people as peopleby,type,dest_name,dest_id from live_video where video<>"" '.$where2.' ) order by peopleby desc,addtime desc '.$sql_page;
		$live_room_data = $this->live_db->query($sql_str)->result_array();			
		$num_live_room_data = count($live_room_data);
		$anchor_ids = array();
		if($num_live_room_data>0){
			foreach($live_room_data as $v){
				$anchor_ids[$v['anchor_id']] = $v['anchor_id'];
			}
		}		
		$live_anchor_ids_data = array();		
		if(!empty($anchor_ids)){
			$sql_str = "select anchor_id,user_id,name,user_type,video_pic,sex,photo,type from live_anchor where anchor_id in(".trim(implode(",",$anchor_ids),',').") ";
			$live_anchor_data = $this->live_db->query($sql_str)->result_array();
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
				}
				unset($live_room_data[$k]['addtime'],$live_room_data[$k]['peopleby']);
			}
		}	
		if(empty($live_room_data)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"无数据",'4001');				
		}		
        $returnData = array();		
        $returnData['info'] = $live_room_data;
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
		//热门目的
		$cityid=$this->input->post('cityid',true);
		if(!$cityid){
            $cityid= $this->default_cityid;
		}		
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
		
		//周边游
		$query_sql=" SELECT rt.neighbor_id as destid,dest.kindname as destname";
		$query_sql.=" FROM	bangu.cfg_round_trip AS rt ";
		$query_sql.=" LEFT JOIN bangu.u_dest_cfg AS dest ON rt.neighbor_id = dest.id ";
		$query_sql.=" where rt.isopen =1 and rt.startplaceid={$cityid} ";
		$query_sql.=" limit 4";
		$round_city=$this->db ->query($query_sql) ->result_array(); 		
		//国内游
		$query_sql=" SELECT fdest.id as destid, fdest.kindname as destname ";
		$query_sql.=" FROM	bangu.u_dest_cfg AS pdest ";
		$query_sql.="  LEFT JOIN bangu.u_dest_cfg AS fdest ON pdest.id = fdest.pid ";
		$query_sql.=" WHERE pdest.pid = 2 AND fdest.isopen = 1 AND fdest.ishot = 1 ";
		$query_sql.=" ORDER BY fdest.displayorder ASC ";
		$query_sql.=" limit 4";	
		$country_city=$this->db ->query($query_sql) ->result_array(); 
		//出境游
		$query_sql="  SELECT pdest.id as destid,pdest.kindname as destname ";
		$query_sql.=" FROM	bangu.u_dest_cfg AS pdest ";
		$query_sql.="  where pdest.ishot=1 and pdest.isopen=1 and pdest.pid=1 ";
		$query_sql.=" ORDER BY pdest.displayorder ASC ";
		$query_sql.=" limit 4";		
		$abroad_city=$this->db ->query($query_sql) ->result_array(); 
		
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
			'round'=>$round_city,
			'country'=>$country_city,
			'abroad'=>$abroad_city,						
		);		
        $this->__outlivemsg($returnData);
    }
	
    /**
     * 获取主播申请工具数据
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function apply_tool_info() {
        $returnData = array();	
		//星座
		$sql_str = "select dict_id as categoryid,description as categoryname,showorder from live_dictionary where enable=0 and pid=".$this->dictionary['DICT_CONSTELLATION']." ";
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
        $returnData['constellation'] = $category_live_dictionary_data;
		
		//性格
		$sql_str = "select dict_id as categoryid,description as categoryname,showorder from live_dictionary where enable=0 and pid=".$this->dictionary['DICT_EXPERT_ATTR']." ";
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
        $returnData['expert'] = $category_live_dictionary_data;
		
		//生活方式	
/*		$sql_str = "select dict_id as categoryid,description as categoryname,showorder from live_dictionary where enable=0 and pid=".$this->dictionary['DICT_LIFE_ATTR']." ";
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
        $returnData['life'] = $category_live_dictionary_data;
*/

		//年代	
		$sql_str = "select dict_id as categoryid,description as categoryname,showorder from live_dictionary where enable=0 and pid=".$this->dictionary['DICT_DECADE']." ";
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
        $returnData['decade'] = $category_live_dictionary_data;

        $this->__outlivemsg($returnData);
    }	
	

    /**
     * 获取直播设置提交工具数据
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function create_room_tool_info() {
        $returnData = array();	
		//生活方式
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
				if($this->user_id){//根据用户身份现身内容
					$live_anchor_data =  $this->live_anchor_info;
					if($value['categoryid']==6){//服务,属于管家
						if($live_anchor_data['type']!=3){	//不是管家
							unset($category_live_dictionary_data[$key]);
						}					
					}else if($value['categoryid']==45){//出团说明会,属于领队
						if($live_anchor_data['type']!=2){	//不是领队
							unset($category_live_dictionary_data[$key]);
						}							
					}
				}else{
					if($value['categoryid']==6){//服务,属于管家
						unset($category_live_dictionary_data[$key]);
					}else if($value['categoryid']==45){//出团说明会,属于领队
						unset($category_live_dictionary_data[$key]);					
					}					
				}				
			}			
		}			
        $returnData = $category_live_dictionary_data;
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
		$this->anchor_verification();//检查是否为主播
		/*$returnData = array(
			'room_id'=>'1',
			'roomid'=>'212328',
			'anchor_password'=>'111',
			'nickname'=>'testtest',	
		);	
		$this->__outlivemsg($returnData);
		*/
        $categoryid = intval($this->input->post('categoryid', true)); //直播类型		
        $roomname = $this->input->post('roomname', true); //房间名称
        $cover = $this->input->post('cover', true); //视频封面		
        $destid = intval($this->input->post('destid', true)); //定位目的地	
        $lineid = intval($this->input->post('lineid', true)); //关联线路
		$room_dest = '';//开播所属目的地		
		if($destid){
			$arr = $this->db->query("select id,name from u_area where id=" . $destid . "")->row_array();
			if(!empty($arr)){
				$room_dest =$arr['name'];
			}
		}

/*
        $categoryid = 1;		
        $roomname = '111';
        $cover = 'ww';		
        $destid = '12';	
        $lineid = '222';
*/
		$live_anchor_data =  $this->live_anchor_info;
		
		if($categoryid==6){//服务,属于管家
			if($live_anchor_data['type']!=3){	//不是管家
				$returnData = array('room_id'=>0);	
				$this->__outlivemsg($returnData,'你不是管家，不能选择服务项','3007');					
			}					
		}else if($categoryid==45){//出团说明会,属于领队
			if($live_anchor_data['type']!=2){	//不是领队
				$returnData = array('room_id'=>0);	
				$this->__outlivemsg($returnData,'你不是领队，不能选择出团说明会','3008');	
			}							
		}		
		//生成唯一的标识符,在每次分配房间的时候
		/*list($tmp1, $tmp2) = explode(' ', microtime());
		$msec =  (float)sprintf('%.0f', (floatval($tmp1) + floatval($tmp2)) * 10000);
		$room_code = $msec.mt_rand(1,10000).'A'.$live_anchor_data['anchor_id'];	*/	
		$nowtime = time();
		/*
			在分配房间前，检查是否把上次的直播信息插入到历史直播信息表中，如果有则直接初始化，如果没有则插入，
			然后变更直播间的信息，让占用时间createtime为当时时间，starttime为0,endtime为0,peoples=0，umoney=0，live_status=3
			然后主播点开始时starttime为当时时间
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
		$room_id =0;//分配的房间id

		//没有专属房间,使用公用房间分配
		$sql = 'SELECT room_id,roomid,anchor_password FROM live_room WHERE anchor_id= '.$live_anchor_data['anchor_id'].' and live_status>0 and status=1 and  createtime>'.($nowtime - $this->room_timeout).' ';
		$live_room_data =  $this->live_db->query($sql )->row_array();		
		if(!empty($live_room_data)){//您已经有房间正在使用
			$returnData = array(
				'room_id'=>$live_room_data['room_id'],
				'roomid'=>$live_room_data['roomid'],
				'anchor_password'=>$live_room_data['anchor_password'],
				'nickname'=>$live_anchor_data['name'],	
			);
			$this->__outlivemsg($returnData);				
			//$this->__outlivemsg($returnData,"您已经有房间正在使用",'3004');				
		}

		//调用接口创建房间
		$roomdata = array();
		$roomdata['anchorPwd'] = mt_rand(100000,300000).$live_anchor_data['anchor_id'];
		$roomdata['assistPwd'] = mt_rand(300000,600000).$live_anchor_data['anchor_id'];
		$roomdata['userPwd'] = mt_rand(600000,900000).$live_anchor_data['anchor_id'];		
		$roomdata['anchor_id'] = '';	
		$roomdata['choosed_anchor_id'] = '0';
		$roomdata['roomId'] = '';	
		$roomdata['roomName'] = $roomname;	
		$roomdata['room_id'] = '';	
		//$roomdata['room_number'] = $room_num.'';	
		$roomdata['room_type'] = 1;//房间类型,1公共2专属			
		//AccessToken
		self::getAccessToken();
		$param = $this->getPostArr($roomdata);
		$return_result = self::curlUtils($param,"CreateRoom");
		if($return_result['status']==200){
			$room_data = array(
				"anchor_password"	=>$return_result['entity']['anchorPwd'],
				"admin_password"	=>$return_result['entity']['assistPwd'],
				"audience_password"=>$return_result['entity']['userPwd'],
				"room_name"			=>$return_result['entity']['roomName'],
				"roomid"				=>$return_result['entity']['roomId'],
				"status"				=>1,
				"type"					=>$roomdata['room_type'],
				"starttime"				=>$return_result['entity']['dateCreate'],
				"room_number"		=>'',
				"anchor_id"=>$live_anchor_data['anchor_id'],
				"user_type"=>$live_anchor_data['type'],
				"attr_id"=>$categoryid,
				"line_ids"=>$lineid,
				"room_code"=>'',
				"room_name"=>$roomname,
				"pic"=>$cover,
				"room_dest_id"=>$destid,
				"room_dest"=>$room_dest,				
				"createtime"=>$nowtime,
				"starttime"=>0,
				"peoples"=>0,
				"umoney"=>0,
				"live_status"=>3,
				"endtime"=>0,
				);
			$this->live_db->insert('live_room', $room_data);
			$room_id = $this->live_db->insert_id();					
		}				
		if($room_id>0){//表示分配成功
			$returnData = array(
				'room_id'=>$room_id,
				'roomid'=>$return_result['entity']['roomId'],
				'anchor_password'=>$return_result['entity']['anchorPwd'],
				'nickname'=>$live_anchor_data['name'],	
			);	
			$this->__outlivemsg($returnData);			
		}else{//分配失败
			$returnData = array('room_id'=>0);	
			$this->__outlivemsg($returnData,'创建失败','3006');				
		}
    }


    /**
     * 判断用户是否为主播
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */	
    public function check_anchor_info() {
		$this->anchor_verification();//检查是否为主播
		
		$live_anchor_data =  $this->live_anchor_info;
		$returnData = array('anchor_id'=>$live_anchor_data['anchor_id']);	
		$this->__outlivemsg($returnData);
    }	
	
	
    /**
     * 获取主播信息
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */	
    public function get_anchor_info() {
        $anchorid = intval($this->input->post('anchorid', true)); //直播房间id
		$sql = 'SELECT * FROM live_anchor WHERE anchor_id= '.$anchorid;
		$live_anchor_data =  $this->live_db->query($sql)->row_array();		
		$returnData = array(
			'anchorid'=>$live_anchor_data['anchor_id'],
			'name'=>$live_anchor_data['name'],
			'photo'=>trim(base_url(''),'/').$live_anchor_data['photo'],			
		);	
		$this->__outlivemsg($returnData);
    }		
	
	
    /**
     * 获取主播进入房间的信息
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function get_anchor_go_room_info() {
        $roomid = intval($this->input->post('roomid', true)); //直播房间id
		$sql = 'SELECT roomid,anchor_password,anchor_id FROM live_room WHERE room_id= '.$roomid.' ';
		$live_room_data =  $this->live_db->query($sql )->row_array();			
		$sql_str = "select name,is_anchor,refuse_reason,status from live_anchor where anchor_id =".$live_room_data['anchor_id']." ";
		$live_anchor_data = $this->live_db->query($sql_str)->row_array();
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
		$returnData = array(
			'room_id'=>$room_id,
			'roomid'=>$live_room_data['roomid'],
			'anchor_password'=>$live_room_data['anchor_password'],
			'nickname'=>$live_anchor_data['name'],	
		);	
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
        $currenttime = intval($this->input->post('currenttime', true)); //用户进入房间的当时时间，根据这个时间来判断还没有加载的聊天记录
        if(empty($currenttime)) $currenttime = time();
		$sql_str = "select nickname,content,addtime from live_room_chat where room_id=".$roomid."  and addtime>'".date("Y-m-d H:i:s",$currenttime)."' limit 20 ";
		$live_room_chat_data = $this->live_db->query($sql_str)->result_array();
		if(!empty($live_room_chat_data)){
			foreach ($live_room_chat_data as $key => $value) {
				$sortfiled[$key] = $value['addtime'];//根据addtime字段排序
			}
			array_multisort($sortfiled, $live_room_chat_data);
			$num = count($live_room_chat_data);
			if(isset($live_room_chat_data[$num-1]['addtime'])){
				$currenttime = strtotime($live_room_chat_data[$num-1]['addtime']);
			}				
			//foreach ($live_room_chat_data as $key => $value) {
				//unset($live_room_chat_data[$key]['addtime']);
			//}
		}
		if(!empty($live_room_chat_data)){
			$this->load->library ( 'SensitiveWordFilter/SensitiveWordFilter' );//过滤敏感词			
			$giftids = array();
			foreach($live_room_chat_data as $k => $v){
				if(strpos($v['content'],'[giftid:')===0){
					$gift_id = intval(str_replace(array('[giftid:',']'),array('',''),$v['content']));
					$gift_id && $giftids[$k] = $gift_id; 
				}
				$live_room_chat_data[$k]['content'] = $this->sensitivewordfilter->delFilterSign($v['content']);//过滤敏感词	
			}
			if(!empty($giftids)){
				$sql_str = "select gift_id,gift_name,pic,unit from live_gift where gift_id in(". implode(",",$giftids).")";
				$live_gift_data = $this->live_db->query($sql_str)->result_array();	
				$live_gift_data_byid = array();
				foreach($live_gift_data as $v){
					$live_gift_data_byid[$v['gift_id']] = $v;
				}				
			}
			foreach($giftids as $k => $v){
				$live_room_chat_data[$k]['content'] = '';				
				$live_room_chat_data[$k]['gift_id'] = $live_gift_data_byid[$v]['gift_id'];
				$live_room_chat_data[$k]['gift_name'] = $live_gift_data_byid[$v]['gift_name'];
				$live_room_chat_data[$k]['pic'] = $live_gift_data_byid[$v]['pic'];
				$live_room_chat_data[$k]['unit'] = $live_gift_data_byid[$v]['unit'];				
			}			
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
        //$roomcode = $this->input->post('roomcode', true); //直播房间code			
        $currenttime = $this->input->post('currenttime', true); //用户进入房间的当时时间，根据这个时间来判断最新送出的礼物
        if(empty($currenttime)) $currenttime = time();
		$sql_str = "select gift_id,gift_name,pic from live_gift ";
		$live_gift_data = $this->live_db->query($sql_str)->result_array();	
		$live_gift_data_byid = array();
		foreach($live_gift_data as $v){
			$live_gift_data_byid[$v['gift_id']] = $v;
		}
		
		$sql_str = "select gift_id,worth,addtime from live_gift_record where room_id=".$roomid."  and addtime>'".date("Y-m-d H:i:s",$currenttime)."' limit 20 ";
		$live_gift_record_data = $this->live_db->query($sql_str)->result_array();
		$return_gift_record = array();		
		if(!empty($live_gift_record_data)){
			foreach ($live_gift_record_data as $key => $value) {
				$sortfiled[$key] = $value['addtime'];//根据addtime字段排序
			}
			array_multisort($sortfiled, $live_gift_record_data);
			$num = count($live_gift_record_data);
			if(isset($live_gift_record_data[$num-1]['addtime'])){
				$currenttime = strtotime($live_gift_record_data[$num-1]['addtime']);
			}		
			foreach ($live_gift_record_data as $key => $value) {
				$return_gift_record[$key]['name']=$live_gift_data_byid[$value['gift_id']]['gift_name'];	
				$return_gift_record[$key]['worth']=$value['worth'];			
				$return_gift_record[$key]['icon']=$live_gift_data_byid[$value['gift_id']]['pic'];			
			}				
		}
		if(empty($return_gift_record)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"无数据",'4001');				
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
		if(empty($this->user_id)){//用户没有登录
			$returnData = array();	
			$this->__outlivemsg($returnData,'您还没有登录','1001');				
		}
        $content = $this->input->post('content', true); //聊天内容		
		if(mb_strlen($content,'utf8')>20 && mb_strlen($content,'utf8')>0){
			$returnData = array();	
			$this->__outlivemsg($returnData,'聊天内容至少1个文字，最多20个文字','2002');				
		}
		
		$nowtime = time();
		$sql_str = "select addtime from live_room_chat where user_id=".$this->user_id." order by id desc ";
		$live_room_chat_data = $this->live_db->query($sql_str)->row_array();
		if(!empty($live_room_chat_data) && ($nowtime - strtotime($live_room_chat_data['addtime']))<5  ){//小于5秒不可以发信息
			$returnData = array();	
			$this->__outlivemsg($returnData,'每隔5秒发一次信息','2003');			
		}
		
		$this->load->library ( 'SensitiveWordFilter/SensitiveWordFilter' );//过滤敏感词
		$content = $this->sensitivewordfilter->addFilterSign($content);
		
		$nowtime = time();		
        $roomid = intval($this->input->post('roomid', true)); //直播房间id	
		$sql = 'SELECT room_id,live_status,status,createtime FROM live_room WHERE room_id= '.$roomid.'';
		$live_room_data =  $this->live_db->query($sql )->row_array();		
		if(empty($live_room_data)){
			$returnData = array();	
			$this->__outlivemsg($returnData,'房间不存在','2001');				
		}
		if(!empty($live_room_data) && $live_room_data['createtime']<($nowtime - $this->room_timeout) ){
			$returnData = array();	
			$this->__outlivemsg($returnData,'房间已经过期','2002');				
		}			
		$insert_data = array(
			"room_id"	 	=>$roomid,
			"room_code"			=>'',
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
     * 视频评论内容提交数据
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function send_video_comment_info() {
		if(empty($this->user_id)){//用户没有登录
			$returnData = array();	
			$this->__outlivemsg($returnData,'您还没有登录','1001');				
		}
        $content = $this->input->post('content', true); //聊天内容
		if(mb_strlen($content,'utf8')>20 && mb_strlen($content,'utf8')>0){
			$returnData = array();	
			$this->__outlivemsg($returnData,'聊天内容至少1个文字，最多20个文字','2002');				
		}
		$nowtime = time();
		$sql_str = "select addtime from live_video_comment where user_id=".$this->user_id." order by id desc ";
		$live_video_comment_data = $this->live_db->query($sql_str)->row_array();
		if(!empty($live_video_comment_data) && ($nowtime - strtotime($live_video_comment_data['addtime']))<5  ){//小于5秒不可以发信息
			$returnData = array();	
			$this->__outlivemsg($returnData,'每隔5秒发一次信息','2003');			
		}
		$this->load->library ( 'SensitiveWordFilter/SensitiveWordFilter' );//过滤敏感词
		$content = $this->sensitivewordfilter->addFilterSign($content);
		
        $videoid = intval($this->input->post('videoid', true)); //直播房间id	
		$sql = 'SELECT id FROM live_video WHERE id= '.$videoid.'';
		$live_video_data =  $this->live_db->query($sql )->row_array();		
		if(empty($live_video_data)){
			$returnData = array();	
			$this->__outlivemsg($returnData,'视频不存在','2001');				
		}		
			
		$insert_data = array(
			"video_id"	 	=>$videoid,
			"user_id" 		=>$this->user_id,
			"nickname"	=>$this->user_info['nickname'],
			"content"	=>$content,
			"addtime"	 	=>date("Y-m-d H:i:s"),						
		);
		$this->live_db->insert('live_video_comment', $insert_data);		
        $returnData = array();
        $this->__outlivemsg($returnData);
    }	
	
	
    /**
     * 获取视频评论数据
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function get_video_comment_list() {
        $videoid = intval($this->input->post('videoid', true)); //直播房间id	
        $page = intval($this->input->post('page', true)); //翻页		
        $page = empty($page) ? 1 : $page;	
        $page_size = 20;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from
        $sql_page = " LIMIT {$from},{$page_size}";		
		$sql_str = "select user_id,nickname,content,addtime from live_video_comment where video_id=".$videoid." order by id desc {$sql_page} ";
		$live_video_comment_data = $this->live_db->query($sql_str)->result_array();
		if(empty($live_video_comment_data)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"无数据",'4001');				
		}		
		if(!empty($live_video_comment_data)){
			$this->load->library ( 'SensitiveWordFilter/SensitiveWordFilter' );//过滤敏感词
			$user_ids = array();
			$user_photo = array();
			foreach($live_video_comment_data as $k => $v){
				$user_ids[$v['user_id']]= $v['user_id'];
			}
			if(!empty($user_ids)){
				$sql = 'SELECT user_id,photo FROM live_anchor WHERE user_id in('.implode(',',$user_ids).')';
				$live_anchor =  $this->live_db->query($sql )->result_array();	
				foreach($live_anchor as $v){
					$user_photo[$v['user_id']]= trim(base_url(''),'/').$v['photo'];
				}			
			}
			foreach($live_video_comment_data as $k => $v){
				$live_video_comment_data[$k]['photo'] = $user_photo[$v['user_id']];
				$live_video_comment_data[$k]['content'] = $this->sensitivewordfilter->delFilterSign($v['content']);//过滤敏感词				
			}			
		}
		$sql_str = "select count(id) as num from live_video_comment where video_id=".$videoid." ";
		$live_video_comment_count_data = $this->live_db->query($sql_str)->row_array();		
		$count = 0;
		if(!empty($live_video_comment_count_data)){$count = $live_video_comment_count_data['num'];} 
        $returnData = array();
		$returnData['info'] = $live_video_comment_data;
		$returnData['count'] = $count;		
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
        $returnData = array();			
		$sql_str = "select peoples,starttime,umoney,room_name,pic,anchor_id,createtime,room_code,audience_password,roomid from live_room where room_id=".$roomid." ";
		$live_room_data = $this->live_db->query($sql_str)->row_array();	
		$returnData['anchor'] = array();
		$returnData['room'] = array();		
		$returnData['fans'] = 0;//表示未关注		
		if(isset($live_room_data['anchor_id']) && $live_room_data['anchor_id']>0){
			$sql = 'SELECT * FROM live_anchor WHERE anchor_id= '.$live_room_data['anchor_id'];
			$live_anchor_data =  $this->live_db->query($sql)->row_array();	
			$returnData['anchor'] = array(
				'anchorid'=>$live_anchor_data['anchor_id'],
				'name'=>$live_anchor_data['name'],
				'photo'=>trim(base_url(''),'/').$live_anchor_data['photo'],			
			);
		}
		if(!empty($live_room_data)){
			$usetime = $this->room_timeout;
			if($this->user_type==1){//判断是管家
				$usetime = 0;
			}
			$returnData['room'] = array(
				"peoples"=>$live_room_data['peoples'],
				"collect"=>0,
				"time"=>$live_room_data['starttime'],
				"umoney"=>$live_room_data['umoney'],
				"name"=>$live_room_data['room_name'],
				"pic"=>$live_room_data['pic'],
				"createtime"=>$live_room_data['createtime'],
				"usetime"=>$usetime,
				"roomcode"=>$live_room_data['room_code'],
				"audience_password"=>$live_room_data['audience_password'],
				"roomid"=>$live_room_data['roomid'],			
			);				
		}
		if(!empty($this->user_id)){//普通用户登录检查是否关注主播
			if(  $live_room_data['anchor_id'] && $live_room_data['anchor_id'] != $this->live_anchor_info['anchor_id'] ){//不是自己，且是主播
				$sql_str = "select id,status from live_anchor_fans where anchor_id=".$live_room_data['anchor_id']." and user_id=".$this->user_id.' limit 1';
				$live_anchor_fans_data = $this->live_db->query($sql_str)->row_array();
				if(!empty($live_anchor_fans_data) && $live_anchor_fans_data['status']==1){
					$returnData['fans'] = 1;//表示关注
				}	
			}			
		}		
        $this->__outlivemsg($returnData);
    }

	
    /**
     * 获取视频信息数据
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function get_video_infos() {
        $videoid = intval($this->input->post('videoid', true)); //直播房间id
        $returnData = array();			
		$sql_str = "select * from live_video where id=".$videoid." ";
		$live_video_data = $this->live_db->query($sql_str)->row_array();		
		$returnData['anchor'] = array();
        $returnData['video'] = array();
		$returnData['fans'] = 0;//表示未关注	
		$returnData['attention'] = 0;//关注数		
		if(!empty($live_video_data)){
			if($live_video_data['anchor_id']){
				$sql = 'SELECT * FROM live_anchor WHERE anchor_id= '.$live_video_data['anchor_id'];
				$live_anchor_data =  $this->live_db->query($sql)->row_array();	
				$returnData['anchor'] = array(
					'anchorid'=>$live_anchor_data['anchor_id'],
					'name'=>$live_anchor_data['name'],
					'photo'=>trim(base_url(''),'/').$live_anchor_data['photo'],			
				);
				$sql_str = "select count(id)as num from live_anchor_fans where status=1 and anchor_id=".$live_video_data['anchor_id'];
				$live_anchor_fans_data = $this->live_db->query($sql_str)->row_array();			
				if(!empty($live_anchor_fans_data)){
					$returnData['attention'] = $live_anchor_fans_data['num'];				
				}				
			}			
			$returnData['video'] = array(
				"people"=>$live_video_data['people'],
				"collect"=>0,
				"starttime"=>$live_video_data['starttime'],
				"endtime"=>$live_video_data['endtime'],
				"time"=>$live_video_data['time'],			
				"name"=>$live_video_data['name'],
				"pic"=>$live_video_data['pic'],
				"video"=>$live_video_data['video'],			
			);
			if(!empty($this->user_id)){//普通用户登录检查是否关注主播
				if(  $live_anchor_data['anchor_id'] && $live_anchor_data['anchor_id'] != $this->live_anchor_info['anchor_id'] ){//不是自己，且是主播
					$sql_str = "select id,status from live_anchor_fans where anchor_id=".$live_anchor_data['anchor_id']." and user_id=".$this->user_id.' limit 1';
					$live_anchor_fans_data = $this->live_db->query($sql_str)->row_array();
					if(!empty($live_anchor_fans_data) && $live_anchor_fans_data['status']==1){
						$returnData['fans'] = 1;//表示关注
					}	
				}			
			}			
		}
        $this->__outlivemsg($returnData);
    }	
	
	
    /**
     * 获取直播房间的关注总数及打赏总数
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function get_room_umoney_fans() {
        $roomid = intval($this->input->post('roomid', true)); //直播房间id
        $returnData = array();			
		$sql_str = "select umoney,anchor_id from live_room where room_id=".$roomid." ";
		$live_room_data = $this->live_db->query($sql_str)->row_array();	
		if(!empty($live_room_data)){
			$sql_str = "select count(id)as num from live_anchor_fans where status=1 and anchor_id=".$live_room_data['anchor_id'];
			$live_anchor_fans_data = $this->live_db->query($sql_str)->row_array();			
			$returnData['info'] = array(
				'umoney'=>$live_room_data['umoney'],
				'attention'=>$live_anchor_fans_data['num'],			
			);			
		}else{
			$returnData['info'] = array(
				'umoney'=>'0',
				'attention'=>'0',			
			);				
		}
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
        //$roomcode = $this->input->post('roomcode', true); //直播房间code		
        $page = intval($this->input->post('page', true)); //翻页		
        $page = empty($page) ? 1 : $page;	
        $page_size = 20;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from
        $sql_page = " LIMIT {$from},{$page_size}";		
		$sql_str = "select user_id,nickname,content,addtime from live_room_chat where room_id=".$roomid." order by id desc {$sql_page} ";
		$live_room_chat_data = $this->live_db->query($sql_str)->result_array();
		
		if(!empty($live_room_chat_data)){
			$this->load->library ( 'SensitiveWordFilter/SensitiveWordFilter' );//过滤敏感词
			$giftids = array();
			foreach($live_room_chat_data as $k => $v){
				if(strpos($v['content'],'[giftid:')===0){
					$gift_id = intval(str_replace(array('[giftid:',']'),array('',''),$v['content']));
					$gift_id && $giftids[$k] = $gift_id; 
				}
				$live_room_chat_data[$k]['content'] = $this->sensitivewordfilter->delFilterSign($v['content']);//过滤敏感词	
			}
			if(!empty($giftids)){
				$sql_str = "select gift_id,gift_name,pic,unit from live_gift where gift_id in(". implode(",",$giftids).")";
				$live_gift_data = $this->live_db->query($sql_str)->result_array();	
				$live_gift_data_byid = array();
				foreach($live_gift_data as $v){
					$live_gift_data_byid[$v['gift_id']] = $v;
				}				
			}
			foreach($giftids as $k => $v){
				$live_room_chat_data[$k]['content'] = '';				
				$live_room_chat_data[$k]['gift_id'] = $live_gift_data_byid[$v]['gift_id'];
				$live_room_chat_data[$k]['gift_name'] = $live_gift_data_byid[$v]['gift_name'];
				$live_room_chat_data[$k]['pic'] = $live_gift_data_byid[$v]['pic'];
				$live_room_chat_data[$k]['unit'] = $live_gift_data_byid[$v]['unit'];				
			}			
		}		
		if(empty($live_room_chat_data)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"无数据",'4001');				
		}
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
		$this->anchor_verification();//检查是否为主播
		$live_anchor_data =  $this->live_anchor_info;
		$sql_str = "select createtime,status,type,live_status from live_room where room_id=".$roomid." and anchor_id=".$live_anchor_data['anchor_id'];
		$live_room_data = $this->live_db->query($sql_str)->row_array();	
		$nowtime = time();		
		if(empty($live_room_data)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"房间不存在",'2002');				
		}
		if( !($live_room_data['status']==1 && ( $live_room_data['live_status']>0 || $live_room_data['createtime']>($nowtime - $this->room_timeout) ) )){//该房间已经过期
			$returnData = array();	
			$this->__outlivemsg($returnData,"该房间已经过期",'3003');						
		}		
		$this->live_db->query("update live_room set `live_status`=1,`starttime`={$nowtime} where room_id = ".$roomid."");		
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
		$this->anchor_verification();//检查是否为主播
		
		$live_anchor_data =  $this->live_anchor_info;
		$sql_str = "select createtime,starttime,status,type,live_status from live_room where room_id=".$roomid." and anchor_id=".$live_anchor_data['anchor_id'];
		$live_room_data = $this->live_db->query($sql_str)->row_array();	
		$nowtime = time();		
		if(empty($live_room_data)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"房间不存在",'2002');				
		}
		$nowtime = time();		
		if($live_room_data['createtime'] && $live_room_data['createtime']>($nowtime - $this->room_timeout) ){
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
		$this->anchor_verification();//检查是否为主播
		$live_anchor_data =  $this->live_anchor_info;
		$sql_str = "select createtime,status,type,live_status from live_room where room_id=".$roomid." and anchor_id=".$live_anchor_data['anchor_id'];
		$live_room_data = $this->live_db->query($sql_str)->row_array();	
		$nowtime = time();		
		if(empty($live_room_data)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"房间不存在",'2002');				
		}
		if( !($live_room_data['status']==1 && ( $live_room_data['live_status']>0 || $live_room_data['createtime']>($nowtime - $this->room_timeout) ) )){//该房间已经过期
			$returnData = array();	
			$this->__outlivemsg($returnData,"该房间已经过期",'3003');						
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
		if(!empty($live_room_chat_data)){
			$this->load->library ( 'SensitiveWordFilter/SensitiveWordFilter' );//过滤敏感词
			$giftids = array();
			foreach($live_room_chat_data as $k => $v){
				if(strpos($v['content'],'[giftid:')===0){
					$gift_id = intval(str_replace(array('[giftid:',']'),array('',''),$v['content']));
					$gift_id && $giftids[$k] = $gift_id; 
				}
				$live_room_chat_data[$k]['content'] = $this->sensitivewordfilter->delFilterSign($v['content']);//过滤敏感词	
			}
			if(!empty($giftids)){
				$sql_str = "select gift_id,gift_name,pic,unit from live_gift where gift_id in(". implode(",",$giftids).")";
				$live_gift_data = $this->live_db->query($sql_str)->result_array();	
				$live_gift_data_byid = array();
				foreach($live_gift_data as $v){
					$live_gift_data_byid[$v['gift_id']] = $v;
				}				
			}
			foreach($giftids as $k => $v){
				$live_room_chat_data[$k]['content'] = '';				
				$live_room_chat_data[$k]['gift_id'] = $live_gift_data_byid[$v]['gift_id'];
				$live_room_chat_data[$k]['gift_name'] = $live_gift_data_byid[$v]['gift_name'];
				$live_room_chat_data[$k]['pic'] = $live_gift_data_byid[$v]['pic'];
				$live_room_chat_data[$k]['unit'] = $live_gift_data_byid[$v]['unit'];				
			}			
		}
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
		$sql_str = "select gift_id,user_id,max(worth) as worth,addtime from live_gift_record where room_id=".$roomid." group by user_id order by null limit 5 ";
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
        //$user_id = $this->input->get('user_id', true); //用户id
		if(empty($this->user_id)){//用户没有登录
			$returnData = array();	
			$this->__outlivemsg($returnData,'您还没有登录','1001');				
		}		
		$user_id = $this->user_id;
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
		if(empty($this->user_id)){//用户没有登录
			$returnData = array();	
			$this->__outlivemsg($returnData,'您还没有登录','1001');				
		}		
        $roomid = $this->input->post('roomid', true); //直播房间id
        $giftid = $this->input->post('giftid', true); //礼物id

		$sql_str = "select anchor_id,room_code from live_room where room_id=".$roomid."";
		$live_room_data = $this->live_db->query($sql_str)->row_array();	
		
		$sql_str = "select gift_id,gift_name as name,pic as icon,worth,unit from live_gift where status=1 and gift_id=".$giftid;
		$live_gift_data = $this->live_db->query($sql_str)->row_array();
		
		$sql_str = "select umoney from live_anchor where user_id = ".$this->user_id."";
		$live_anchor_data = $this->live_db->query($sql_str)->row_array();
		if($live_anchor_data['umoney'] < $live_gift_data['worth']){
			$returnData = array();	
			$this->__outlivemsg($returnData,'U币数不足','3001');				
		}
		$this->live_db->trans_begin();//事务
		$this->live_db->query("update live_anchor set `umoney`=umoney-".$live_gift_data['worth']." where user_id = ".$this->user_id."");//送礼物的人减钱	
		$this->live_db->query("update live_anchor set `umoney`=umoney+".$live_gift_data['worth']." where anchor_id = ".$live_room_data['anchor_id']."");//主播加钱	
		$insert_data = array(
			"gift_id"	 	=>$giftid,
			"anchor_id"			=>$live_room_data['anchor_id'],		
			"room_id"	 	=>$roomid,
			"room_code"			=>$live_room_data['room_code'],
			"user_id" 		=>$this->user_id,
			"num"	=>1,
			"worth" 		=>$live_gift_data['worth'],			
			"addtime"	 	=>date("Y-m-d H:i:s"),	
			"pic"	=>$live_gift_data['icon'],			
		);
		$this->live_db->insert('live_gift_record', $insert_data);	
		
		$insert_data = array(
			"room_id"	 	=>$roomid,
			"room_code"			=>$live_room_data['room_code'],
			"user_id" 		=>$this->user_id,
			"nickname"	=>$this->user_info['nickname'],
			"content"	=>'[giftid:'.$giftid.']',
			"addtime"	 	=>date("Y-m-d H:i:s"),						
		);
		$this->live_db->insert('live_room_chat', $insert_data);	//增加到聊天记录中		
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
		if(count($live_gift_data)>0){
			foreach($live_gift_data as $k=> $v){
				$live_gift_data[$k]['icon'] = trim(base_url(''),'/').$live_gift_data[$k]['icon'];							
			}
		}			
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
	
	
    //把过期的房间关闭或删除
	public function timed_task_del_room(){
		$nowtime = time();
		$sql = 'SELECT room_id,roomid FROM live_room WHERE   createtime<'.($nowtime - $this->room_timeout).' ';
		$live_room_data =  $this->live_db->query($sql )->result_array();
		foreach($live_room_data as $v){
			if($v['roomid']){
				self::getAccessToken();
				$param = array(
					"roomId"=>$v['roomid'],					
				);
				$returnData = self::curlUtils($param,"DelRoom");
				sleep(5);				
			}
		}
        exit('success');
	}		
	
    //获取最新的录播列表并且插入到历史视频中
	public function timed_task_get_new_video(){
		$nowtime = time();
		//获取最大的开始时间
		$sql = 'SELECT starttime FROM live_video WHERE type=1 order by starttime desc limit 1';
		$live_video_data =  $this->live_db->query($sql )->row_array();
		$max_starttime = 0;
		if(!empty($live_video_data)){
			$max_starttime = ($live_video_data['starttime']+1) * 1000;
		}
		//通过接口获取录播列表数据

		self::getAccessToken();
		$param = array(
			//"queryRoomId"=>0,// 主播室id
			"index"=>0,// 查询起始位置
			"count"=>50,// 查询个数
			//"endRecordingTime"=>50,// 结束时间戳*1000=1480499880000
			"startRecordingTime"=>$max_starttime,// 开播时间戳*1000=1478080680000							
		);
		$returnData = self::curlUtils($param,"GetRecordings");
		$total = $returnData['total'];
		if(!empty($returnData['entities'])){
			foreach($returnData['entities'] as $v){
				if($v['status']==2){//正常的视频
					$recStartTime = $v['recStartTime']/1000;
					$recEndTime = $v['recEndTime']/1000;
					$sql = 'SELECT room_id,anchor_id,room_name,peoples,line_ids,user_type,attr_id,room_dest,room_dest_id,pic FROM live_room WHERE roomid='.$v['roomId'].'';
					$live_room_data =  $this->live_db->query($sql )->row_array();
					if(!empty($live_room_data)){
						$pic = $live_room_data['pic'];
						if(empty($pic))$pic = $v['recFirstFrameUrl'];
						$insert_data = array(
								"anchor_id"	=>$live_room_data['anchor_id'],
								"room_id"	 	=>$live_room_data['room_id'],
								"room_code"			=>'',
								"video" 		=> $v['firstHlsUrl'],
								"name"	=>$live_room_data['room_name'],
								"pic"	=>$pic,
								"addtime"	 	=>$nowtime,
								"starttime"			=>$recStartTime,
								"endtime" 		=> $recEndTime,
								"time"	=>$v['duration'],							
								"people"	=>$live_room_data['peoples'],
								"collect"	 	=>0,
								"record_id"			=>$v['recordingId'],
								"attr_id"	=>$live_room_data['attr_id'],	
								"type"	=>1,
								"line_ids"	=>$live_room_data['line_ids'],
								'user_type'=>$live_room_data['user_type'],
								'dest_name'=>$live_room_data['room_dest'],
								'dest_id'=>$live_room_data['room_dest_id'],
								'status'=>1,								
						);	
						$this->live_db->insert('live_video', $insert_data);					
					}
				}
			}				
		}
        exit('success');
	}		
	
	
	
	//观众进入房间观看直播的时候
	function visitor_in_room(){
		$roomid = $this->input->post("roomid",true);
		$this->live_db->query("update live_room set `peoples`=peoples+1 where room_id = ".$roomid."");	
        $returnData = array();
        $this->__outlivemsg($returnData);
	}

	//观众退出房间观看的时候
	function visitor_out_room(){
		$roomid = $this->input->post("roomid",true);
		$this->live_db->query("update live_room set `peoples`=peoples-1 where room_id = ".$roomid."");	
        $returnData = array();
        $this->__outlivemsg($returnData);
	}	
	
	//观看视频的数量
	function visitor_in_video(){
		$video_id = $this->input->post("videoid",true);
		$this->live_db->query("update live_video set `people`=people+1 where id = ".$video_id."");	
        $returnData = array();
        $this->__outlivemsg($returnData);
	}
	
	
    //生成客户端地址
	public function live_GetClientUrls(){
		$room_id = $this->input->post("room_id",true);		
		self::getAccessToken();
		$param = array(
			"roomId"=>$room_id,
			);
		$returnData = self::curlUtils($param,"GetClientUrls");
        $this->__outlivemsg($returnData);
	}	

	
	//批量创建房间
	public function live_creat_room(){
		$total = 1050;
				$i = $this->input->get("id",true);
				if($i>$total){
				//	exit('over');
				}
		//for($i=300;$i<$total;$i++){
			$room_num = $i;//房间号不能超过四位数
			$sql = 'SELECT * FROM live_room WHERE room_number= '.$room_num.' ';
			$check_num_res =  $this->live_db->query($sql )->row_array();				
			
			if(!empty($check_num_res)){//房间号已经存在重新设置
				exit('error');
			}
            $_POST = array();
			$_POST['anchorPwd'] = '111111';	
			$_POST['anchor_id'] = '';	
			$_POST['assistPwd'] = '222222';	
			$_POST['choosed_anchor_id'] = '0';
			$_POST['roomId'] = '';	
			$_POST['roomName'] = '测试房间'.$i;	
			$_POST['room_id'] = '';	
			//$_POST['room_number'] = $room_num.'';	
			$_POST['room_type'] = '1';
			$_POST['userPwd'] = '333333';		
			//AccessToken
			self::getAccessToken();
			$param = $this->getPostArr($_POST);
			$return_result = self::curlUtils($param,"CreateRoom");
			if($return_result['status']==200){
				$room_data = array(
					"anchor_password"	=>$return_result['entity']['anchorPwd'],
					"admin_password"	=>$return_result['entity']['assistPwd'],
					"audience_password"=>$return_result['entity']['userPwd'],
					"room_name"			=>$return_result['entity']['roomName'],
					"roomid"				=>$return_result['entity']['roomId'],
					"status"				=>1,
					"type"					=>$_POST['room_type'],
					"starttime"				=>$return_result['entity']['dateCreate'],
					"room_number"		=>$room_num
					);
				$this->live_db->insert('live_room', $room_data);
				$room_id = $this->live_db->insert_id();					
			}
			//echo $room_id.'-';
			//sleep(5);
			print_r($return_result);exit;			
		//}
   // echo '<script language="javascript">window.location.href=http://bangu.com/api/v2_3_13/live_desk/creat_room?id="'.$i.'";</script>'; 		
		//header('Location: http://bangu.com/api/v2_3_13/live_desk/creat_room?id='.$i);
		
		
		
		header( "content-type:text/html;charset=utf-8" );

		echo '<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>无标题文档</title>
		<script type="text/JavaScript">    
		function countDown(secs,surl){    
		 //alert(surl);    
		 var jumpTo = document.getElementById("jumpTo");
		 jumpTo.innerHTML=secs; 
		 if(--secs>0){    
			 setTimeout("countDown("+secs+",\'"+surl+"\')",1000);    
			 }    
		 else{      
			 location.href=surl;    
			 }    
		 }    
		</script>
		</head>

		<body><span id="jumpTo">5</span>秒后自动跳转到http://bangu.com/api/v2_3_13/live_desk/creat_room?id='.($i+1).'
		<script type="text/javascript">countDown(5,\'http://bangu.com/api/v2_3_13/live_desk/creat_room?id='.($i+1).'\');</script> 
		</body>
		</html>';
		
		
		
		
		exit();
	}
	
	
	//在编辑和新建房间的时候组装参数返回
	function getPostArr($post_data){
		list($tmp1, $tmp2) = explode(' ', microtime());
		$msec =  (float)sprintf('%.0f', (floatval($tmp1))* 10000);
		$third_room_id = mt_rand(1,10000).$msec;//不重复的随机数
		if($post_data['roomId']!=""){
			$postArr = array(
				"roomId" 	   =>$post_data['roomId'],
				"roomName"=>$post_data['roomName'],//主播室名称
				"anchorPwd"=>$post_data['anchorPwd'],//主播登录密码
				"assistPwd"=>$post_data['assistPwd'],//助理登录密码
				"userPwd"=>$post_data['userPwd'],//用户登录密码
				"startPlayTime"=>strtotime(date("Y-m-d H:i:s")), //开播时间,只作显示使用
				//"stopPlayTime"=>strtotime(date("Y-m-d H:i:s")),//结束时间,只作显示使用
				"anchorDesc"=> "",//$post_data['anchorDesc'],//主播描述
				"contentDesc"=> ""//$post_data['contentDesc'],//内容描述
				//"thirdRoomId"=>$third_room_id, //三方唯一roomId,此id不能重复使用到多个room中
				//"isImRoom"=> 0//三方roomId是否为亲加IM系统中的聊天室
			);
		}else{
			$postArr = array(
				"roomName"=>$post_data['roomName'],//主播室名称
				"anchorPwd"=>$post_data['anchorPwd'],//主播登录密码
				"assistPwd"=>$post_data['assistPwd'],//助理登录密码
				"userPwd"=>$post_data['userPwd'],//用户登录密码
				"startPlayTime"=>strtotime(date("Y-m-d H:i:s")), //开播时间,只作显示使用
				"stopPlayTime"=>strtotime(date("Y-m-d H:i:s")),//结束时间,只作显示使用
				"anchorDesc"=> "anchorDesc",//$post_data['anchorDesc'],//主播描述
				"contentDesc"=> "contentDesc",//$post_data['contentDesc'],//内容描述
				"thirdRoomId"=>$third_room_id, //三方唯一roomId,此id不能重复使用到多个room中
				"isImRoom"=> 0,//三方roomId是否为亲加IM系统中的聊天室
			);
		}
		return $postArr;
	}	
	
	
    //录播列表获取
	public function live_GetRecordings(){
		//$room_id = $this->input->post("room_id",true);		
		self::getAccessToken();
		$param = array(
			//"queryRoomId"=>0,// 主播室id
			"index"=>0,// 查询起始位置
			"count"=>50,// 查询个数			
		);
		$returnData = self::curlUtils($param,"GetRecordings");
        $this->__outlivemsg($returnData);
	}		
	
	
	//获取刚刚保存的视频数据
	public function get_new_video($room_id=""){
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