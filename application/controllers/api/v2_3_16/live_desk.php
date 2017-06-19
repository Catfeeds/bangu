<?php

/**
直播接口
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
    private $notin_attrids = '6';//不包含在内的视频属性id,多个用逗号隔开		
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
    private $share_url = 'http://m.1b1u.com/live/';//测试环境及生产环境域名替换		
	
	
	private $web_url = "http://www.1b1u.com";
	private $pic_web_url = "http://www.1b1u.com";	
    private $chat_url = 'http://chat.1b1u.com';	
	
	private $TOKEN = "Aa11223344";	
	private $APPID = "wxdf9c654d2458ec69";	
	private $SECRET = "74e0ecfa7c222f2be87bd084dae2631e";		
	
	
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
		
		$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
		if(strpos($_SERVER['HTTP_HOST'],'www.1b1u.com')===0){
			$this->share_url = $http_type.'m.1b1u.com/live/';
		}else if(strpos($_SERVER['HTTP_HOST'],'t.w.1b1u.com')===0){
			$this->share_url = $http_type.'t.m.1b1u.com/live/';			
		}else {
			$this->share_url = $http_type.'pubtest.m.1b1u.com/live/';
		}		
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
				if(!empty($this->live_anchor_info)){//判断是否封号
					$sql = 'SELECT * FROM live_anchor_lock WHERE user_id= '.$this->live_anchor_info['anchor_id'];
					$live_anchor_lock_data =  $this->live_db->query($sql)->row_array();	
					if(!empty($live_anchor_lock_data) ){
						$time = time();
						if($live_anchor_lock_data['locketime']==0){
							$returnData = array();	
							$this->__outlivemsg($returnData,'用户已经被永久封号了!','10000');											
						}else if($live_anchor_lock_data['locketime']>$time){
							$returnData = array();	
							$this->__outlivemsg($returnData,'用户已经被封号了,解封时间为：'.date("Y-m-d H:i:s",$live_anchor_lock_data['locketime']).'!','10001');												
						}
					}					
				}					
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
			$data['status']=2;//主播状态
		}else{
			$data['status']=0;//用户状态
		}		
		$data['mobile']=$user['mobile']; //手机号
		$data['sex']=$user['sex']; //性别
		$data['country']=($data['country']?$data['country']:0); //国家		
		$data['province']=($user['province']?$user['province']:0); //省份id
		$data['city']=($user['city']?$user['city']:0); //城市id
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
        if(empty($live_anchor_data) || (!empty($live_anchor_data) && $live_anchor_data['status']==0)){
			$returnData = array();	
			$this->__outlivemsg($returnData,'您还不是主播，请申请主播','3000');			
		}
		if($live_anchor_data['status']==1){
			$returnData = array();	
			$this->__outlivemsg($returnData,"主播资质正在审核中，请稍等",'3900');				
		}
		if($live_anchor_data['status']==3){
			$returnData = array();	
			$this->__outlivemsg($returnData,"您还不是主播，审核不通过，原因是：".$live_anchor_data['refuse_reason'],'3000');				
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
		$realname=$this->input->post('realname',true);//真实姓名
		
		$idcardNum=$this->input->post('idcardNum',true);//身份证号
		
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
		$attr_ids= array();
		$constellation && $attr_ids[]= $constellation;
		$expert && $attr_ids[]= $expert;
		$decade && $attr_ids[]= $decade;			
		//验证数据
		if(empty($name) || mb_strlen($name,'utf8')>20){
			$returnData = array();	
			$this->__outlivemsg($returnData,"昵称不能为空且最多20个文字!",'3022');			
		}
		if(mb_strlen($comment,'utf8')>30){
			$returnData = array();	
			$this->__outlivemsg($returnData,'个人签名最多30个文字','3023');				
		}
		if(empty($idcard)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"请定上传身份证正面照!",'3024');			
		}
		if(empty($idcardconpic)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"请定上传身份证反面照!",'3025');			
		}		
/*
		if(empty($realname)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"请输入真实姓名!",'3026');			
		}
		if(empty($idcardNum)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"请输入身份证号!",'3027');			
		}*/		
		$live_anchor_data =  $this->live_anchor_info;
		if(!empty($live_anchor_data)){
			if($live_anchor_data['status']==1){
				$returnData = array();	
				$this->__outlivemsg($returnData,"您已经申请了，真正审核中，不能重复提交!",'3021');				
			}
			//修改数据
			$data = array();
			$data['name']=$name ;     //主播名
			$data['realname']=$realname ;     //真实姓名			
			//$data['description']=$description ;  //个人简介
			$data['comment']=$comment;//个人签名
			$data['idcardnum']=$idcardNum;//身份证号			
			$data['idcard']=$idcard;//身份证正面照
			$data['idcardconpic']=$idcardconpic;//身份证正面照
			$data['photo']=$photo;//视频封面图
			$data['live_anchor']=$anchor_pic;//头像背景		
			$data['addtime']=date("Y-m-d H:i:s",time());//添加时间
			$data['applytime']=date("Y-m-d H:i:s",time());//申请时间
			$data['modtime']=date("Y-m-d H:i:s",time());//修改时间
			$data['status']=1;//申请状态
			$this->live_db->update('live_anchor', $data, array('user_id'=>$this->user_id));	

			$this->live_db->delete('live_anchor_attr', array('anchor_id'=>$live_anchor_data['anchor_id']));
			$insert_data = array();
			if(!empty($attr_ids)){
				foreach($attr_ids as $k=> $v){
					if($v){
						$insert_data[$k] = array(
								"anchor_id"	 	=>$live_anchor_data['anchor_id'],
								"attr_id"			=>$v,							
							);						
					}
				}
				if(!empty($insert_data)){
					$this->live_db->insert_batch('live_anchor_attr', $insert_data);	
				}			
			}

			$returnData = array();
			$this->__outlivemsg($returnData);			
		}else{
			$returnData = array();	
			$this->__outlivemsg($returnData,"注册异常!",'3020');			
		}
	}	

    /**
     * 获取推荐列表数据,先显示直播再显示视频
     */
    public function recommend_video_room_one() {
		$nowtime = time();		
        $page = intval($this->input->post('page', true)); //翻页
        $offset = intval($this->input->post('offset', true)); //偏移量用在live_video表中		
        $page = empty($page) ? 1 : $page;
        $offset = empty($offset) ? 0 : $offset;		
        $page_size = 20;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from
        $sql_page = " LIMIT {$from},{$page_size}";
		$live_room_datas = $live_room_data = $live_video_data = array();
		if($offset==0){
			$sql_str = 'select anchor_id,room_id,0 as video_id, room_name as name,0 as read_num,peoples as watching_num,pic as cover,starttime as addtime,peoples as peopleby,3 as type,room_dest as dest_name,room_dest_id as dest_id,like_num from live_room  where live_status in(1,3) and status in(1,2)  and  createtime>'.($nowtime - $this->room_timeout).' order by watching_num desc,peopleby desc,addtime desc '.$sql_page;
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
			$sql_str = 'select anchor_id,room_id,id as video_id,name,people as read_num,0 as watching_num,pic as cover,addtime,people as peopleby,type,dest_name,dest_id,like_num from live_video where video<>"" and status=1 order by watching_num desc,peopleby desc,addtime desc '.$sql_page_l;
			$live_video_data = $this->live_db->query($sql_str)->result_array();				
		}
		$live_room_datas = array_merge($live_room_data,$live_video_data);
		$anchor_ids = array();
		if(!empty($live_room_datas)){
			foreach($live_room_datas as $v){
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
		if(!empty($live_room_datas)){
			foreach($live_room_datas as $k=> $v){
				if(isset($live_anchor_ids_data[$v['anchor_id']])){
					if(empty($v['cover'])){
						$live_room_datas[$k]['cover'] = $live_anchor_ids_data[$v['anchor_id']]['video_pic'];					
					}
					if(strpos($live_room_datas[$k]['cover'],'http://')!==0){
						$live_room_datas[$k]['cover'] = trim(base_url(''),'/').$live_room_datas[$k]['cover'];							
					}
					$live_room_datas[$k]['avatar'] = trim(base_url(''),'/').$live_anchor_ids_data[$v['anchor_id']]['photo'];
					$live_room_datas[$k]['anchor_name'] = $live_anchor_ids_data[$v['anchor_id']]['name'];				
					$live_room_datas[$k]['anchor_sex'] = $live_anchor_ids_data[$v['anchor_id']]['sex'];
					$live_room_datas[$k]['anchor_type'] = $live_anchor_ids_data[$v['anchor_id']]['type'];					
				}
				unset($live_room_datas[$k]['addtime'],$live_room_datas[$k]['peopleby']);
			}
		}		
		if(empty($live_room_datas)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"无数据",'4001');				
		}		
        $returnData = array();		
        $returnData['info'] =$live_room_datas;	
        $returnData['offset'] = $offset;		
        $this->__outmsg($returnData);
    }	

	
    /**
     * 分别获取推荐列表数据,直播，视频
     */
    public function recommend_video_room_cat() {		
		$nowtime = time();
        $page = intval($this->input->post('page', true)); //翻页
        $type = intval($this->input->get_post('videoType', true)); //1表示直播及历史直播视频，10表示短视频	
        $lineid = intval($this->input->get_post('lineid', true)); //线路id
        $expertid = intval($this->input->post('expertId', true)); //管家id		
		$where = ' and attr_id not in('.$this->notin_attrids.')';
		if($lineid){
			$where = ' and line_ids like "%'.$lineid.'%" ';
			//$where = ' and FIND_IN_SET('.$lineid.', line_ids) ';
		}
		if($expertid){
			$sql = 'SELECT * FROM live_anchor WHERE user_type=1 and user_id='.$expertid;
			$live_anchor_data =  $this->live_db->query($sql)->row_array();
			if(empty($live_anchor_data)){//
				$sql = 'SELECT * FROM live_anchor WHERE user_type=2 and user_id='.$expertid;
				$live_anchor_data =  $this->live_db->query($sql)->row_array();
			}
			if(empty($live_anchor_data)){//
				$anchor_id = 0;
				$where = ' and anchor_id='.$anchor_id;
			}else{
				$anchor_id = $live_anchor_data['anchor_id'];
				$where = ' and anchor_id='.$anchor_id;				
			}			
		}	
        $page = empty($page) ? 1 : $page;	
        $page_size = 20;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from
        $sql_page = " LIMIT {$from},{$page_size}";
		$live_room_datas = array();
		if($type==1){//1表示直播
			$sql_str = '(select anchor_id,room_id,0 as video_id, room_name as name,0 as read_num,peoples as watching_num,pic as cover,starttime as addtime,peoples as peopleby,3 as type,room_dest as dest_name,room_dest_id as dest_id,1 as isroom,status,sort,0 as video_height,0 as video_width,like_num,attr_id from live_room  where live_status=1 and status in(1,2)  and createtime>'.($nowtime - $this->room_timeout).''.$where.'  )union (select anchor_id,room_id,id as video_id,name,people as read_num,0 as watching_num,pic as cover,addtime,people as peopleby,type,dest_name,dest_id,0 as isroom,status,sort,video_height,video_width,like_num,attr_id from live_video where video<>"" and pic<>"" and status in(1,3)  and type=1 '.$where.') order by isroom desc,status desc,sort asc,watching_num desc,peopleby desc,addtime desc '.$sql_page;	
			$live_room_datas = $this->live_db->query($sql_str)->result_array();						
		}else if($type==10){//10表示短视频
			$sql_str = 'select anchor_id,room_id,id as video_id,name,people as read_num,0 as watching_num,pic as cover,addtime,people as peopleby,type,dest_name,dest_id,video_height,video_width,like_num,attr_id from live_video where video<>"" and pic<>"" and status in(1,3) and type=2 '.$where.' order by status desc,sort asc,watching_num desc,peopleby desc,addtime desc '.$sql_page;
			$live_room_datas = $this->live_db->query($sql_str)->result_array();				
		}

		$anchor_ids = array();
		$attr_id = array();
		if(!empty($live_room_datas)){
			foreach($live_room_datas as $v){
				$anchor_ids[$v['anchor_id']] = $v['anchor_id'];
				$attr_id[$v['attr_id']] = $v['attr_id'];
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
		
		//获取标签
		$category_live_dictionary_data = array();
		if(!empty($attr_id)){
			$sql_str = "select dict_id as categoryid,description as categoryname from live_dictionary where dict_id in(".implode(",",$attr_id).") ";
			$category_live_dictionary_datas = $this->live_db->query($sql_str)->result_array();
			foreach($category_live_dictionary_datas as $v){
				$category_live_dictionary_data[$v['categoryid']]=$v['categoryname'];
			}	
		}			

		if(!empty($live_room_datas)){
			foreach($live_room_datas as $k=> $v){
				if(isset($live_anchor_ids_data[$v['anchor_id']])){
					if(empty($v['cover'])){
						$live_room_datas[$k]['cover'] = $live_anchor_ids_data[$v['anchor_id']]['video_pic'];					
					}
					if(strpos($live_room_datas[$k]['cover'],'http://')!==0){
						$live_room_datas[$k]['cover'] = trim(base_url(''),'/').$live_room_datas[$k]['cover'];							
					}
					$live_room_datas[$k]['avatar'] = trim(base_url(''),'/').$live_anchor_ids_data[$v['anchor_id']]['photo'];
					$live_room_datas[$k]['anchor_name'] = $live_anchor_ids_data[$v['anchor_id']]['name'];				
					$live_room_datas[$k]['anchor_sex'] = $live_anchor_ids_data[$v['anchor_id']]['sex'];
					$live_room_datas[$k]['anchor_type'] = $live_anchor_ids_data[$v['anchor_id']]['type'];
					$live_room_datas[$k]['attrname'] = $category_live_dictionary_data[$v['attr_id']];					
				}
				$live_room_datas[$k]['addtime'] = date("Y-m-d",$live_room_datas[$k]['addtime']);
				unset($live_room_datas[$k]['peopleby']);
			}
		}		
		if(empty($live_room_datas)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"无数据",'4001');				
		}		
        $returnData = array();		
        $returnData['info'] =$live_room_datas;			
        $this->__outmsg($returnData);
    }	
		
	
	
	
	
    /**
     * 获取推荐列表数据,视频和直播同时显示
     */
    public function recommend_video_room() {
		$nowtime = time();
        $page = intval($this->input->post('page', true)); //翻页	
        $page = empty($page) ? 1 : $page;	
        $page_size = 20;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from
        $sql_page = " LIMIT {$from},{$page_size}";
		$sql_str = '(select anchor_id,room_id,0 as video_id, room_name as name,0 as read_num,peoples as watching_num,pic as cover,starttime as addtime,peoples as peopleby,3 as type,room_dest as dest_name,room_dest_id as dest_id,1 as isroom,status,sort,0 as video_height,0 as video_width,like_num,attr_id from live_room  where live_status=1 and status in(1,2)  and  createtime>'.($nowtime - $this->room_timeout).'  )union (select anchor_id,room_id,id as video_id,name,people as read_num,0 as watching_num,pic as cover,addtime,people as peopleby,type,dest_name,dest_id,0 as isroom,status,sort,video_height,video_width,like_num,attr_id from live_video where video<>"" and status in(1,3) ) order by isroom desc,status desc,sort asc,watching_num desc,peopleby desc,addtime desc '.$sql_page;
		$live_room_data = $this->live_db->query($sql_str)->result_array();			
		$num_live_room_data = count($live_room_data);
		$anchor_ids = array();
		$attr_id = array();
		if($num_live_room_data>0){
			foreach($live_room_data as $v){
				$v['anchor_id'] && $anchor_ids[$v['anchor_id']] = $v['anchor_id'];
				$attr_id[$v['attr_id']] = $v['attr_id'];				
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
		//获取标签
		$category_live_dictionary_data = array();
		if(!empty($attr_id)){
			$sql_str = "select dict_id as categoryid,description as categoryname from live_dictionary where dict_id in(".implode(",",$attr_id).") ";
			$category_live_dictionary_datas = $this->live_db->query($sql_str)->result_array();
			foreach($category_live_dictionary_datas as $v){
				$category_live_dictionary_data[$v['categoryid']]=$v['categoryname'];
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
					$live_room_data[$k]['attrname'] = $category_live_dictionary_data[$v['attr_id']];					
				}
				$live_room_data[$k]['addtime'] = date("Y-m-d",$live_room_data[$k]['addtime']);
				unset($live_room_data[$k]['peopleby']);
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
     * 获取关注列表数据，按分类来
     */
    public function attention_video_room_cat() {
		$nowtime = time();
		$this->user_id = 45233;
		if(empty($this->user_id)){//用户没有登录
			$returnData = array();	
			$this->__outlivemsg($returnData,"无数据",'4001');			
		}
        $page = intval($this->input->post('page', true)); //翻页
        $type = intval($this->input->post('videoType', true)); //1表示直播及历史直播视频，10表示短视频
		$categoryid = intval($this->input->get_post('categoryid', true)); //属性id
		$where1 = $where2 = '';
		if($categoryid){
			$where1 .= ' and attr_id='.$categoryid.' ';
			$where2 .= ' and attr_id='.$categoryid.' ';			
		}else{
			$where1 = $where2 = ' and attr_id not in('.$this->notin_attrids.')';			
		}
        $page = empty($page) ? 1 : $page;	
        $page_size = 20;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from
        $sql_page = " LIMIT {$from},{$page_size}";
		$live_room_data = array();
		if($type==1){//1表示直播
			$sql_str = 'select lr.* from live_anchor_fans as laf left join ((select anchor_id,room_id,0 as video_id, room_name as name,0 as read_num,peoples as watching_num,pic as cover,starttime as addtime,peoples as peopleby,3 as type,room_dest as dest_name,room_dest_id as dest_id,0 as video_height,0 as video_width,like_num,attr_id from live_room  where live_status=1 and status in(1,2)  and  createtime>'.($nowtime - $this->room_timeout).' '.$where1.' )union (select anchor_id,room_id,id as video_id,name,people as read_num,0 as watching_num,pic as cover,addtime,people as peopleby,type,dest_name,dest_id,video_height,video_width,like_num,attr_id from live_video where  video<>"" and pic<>"" and status in(1,3)  and type=1 '.$where2.')) as lr on(laf.anchor_id=lr.anchor_id) where laf.status=1 and laf.user_id='.$this->live_anchor_info['anchor_id'].' order by lr.addtime desc,lr.peopleby desc '.$sql_page;
			$live_room_data = $this->live_db->query($sql_str)->result_array();						
		}else if($type==10){//10表示短视频
			$sql_str = 'select lr.* from live_anchor_fans as laf left join (select anchor_id,room_id,id as video_id,name,people as read_num,0 as watching_num,pic as cover,addtime,people as peopleby,type,dest_name,dest_id,video_height,video_width,like_num,attr_id from live_video where  video<>"" and pic<>"" and status in(1,3)  and type=2 '.$where2.') as lr on(laf.anchor_id=lr.anchor_id) where laf.status=1 and laf.user_id='.$this->live_anchor_info['anchor_id'].' order by lr.addtime desc,lr.peopleby desc '.$sql_page;
			$live_room_data = $this->live_db->query($sql_str)->result_array();				
		}			
		$num_live_room_data = count($live_room_data);
		$anchor_ids = array();
		$attr_id = array();
		if($num_live_room_data>0){
			foreach($live_room_data as $k=> $v){
				if($v['anchor_id']){
					$anchor_ids[$v['anchor_id']] = $v['anchor_id'];
					$attr_id[$v['attr_id']] = $v['attr_id'];
				}else{
					unset($live_room_data[$k]);
				}
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
		//获取标签
		$category_live_dictionary_data = array();
		if(!empty($attr_id)){
			$sql_str = "select dict_id as categoryid,description as categoryname from live_dictionary where dict_id in(".implode(",",$attr_id).") ";
			$category_live_dictionary_datas = $this->live_db->query($sql_str)->result_array();
			foreach($category_live_dictionary_datas as $v){
				$category_live_dictionary_data[$v['categoryid']]=$v['categoryname'];
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
					$live_room_data[$k]['attrname'] = $category_live_dictionary_data[$v['attr_id']];					
				}
				$live_room_data[$k]['addtime'] = date("Y-m-d",$live_room_data[$k]['addtime']);
				unset($live_room_data[$k]['peopleby']);
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
     * 获取关注列表数据
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
		$sql_str = 'select lr.* from live_anchor_fans as laf left join ((select anchor_id,room_id,0 as video_id, room_name as name,0 as read_num,peoples as watching_num,pic as cover,starttime as addtime,peoples as peopleby,3 as type,room_dest as dest_name,room_dest_id as dest_id,0 as video_height,0 as video_width,like_num,attr_id from live_room  where live_status=1 and status in(1,2)  and  createtime>'.($nowtime - $this->room_timeout).' )union (select anchor_id,room_id,id as video_id,name,people as read_num,0 as watching_num,pic as cover,addtime,people as peopleby,type,dest_name,dest_id,video_height,video_width,like_num,attr_id from live_video where  video<>"" and status in(1,3) )) as lr on(laf.anchor_id=lr.anchor_id) where laf.status=1 and laf.user_id='.$this->live_anchor_info['anchor_id'].' order by lr.addtime desc,lr.peopleby desc '.$sql_page;
		$live_room_data = $this->live_db->query($sql_str)->result_array();			
		$num_live_room_data = count($live_room_data);
		$anchor_ids = array();
		$attr_id = array();
		if($num_live_room_data>0){
			foreach($live_room_data as $k=> $v){
				if($v['anchor_id']){
					$anchor_ids[$v['anchor_id']] = $v['anchor_id'];
					$attr_id[$v['attr_id']] = $v['attr_id'];
				}else{
					unset($live_room_data[$k]);
				}
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
		//获取标签
		//获取标签
		$category_live_dictionary_data = array();
		if(!empty($attr_id)){
			$sql_str = "select dict_id as categoryid,description as categoryname from live_dictionary where dict_id in(".implode(",",$attr_id).") ";
			$category_live_dictionary_datas = $this->live_db->query($sql_str)->result_array();
			foreach($category_live_dictionary_datas as $v){
				$category_live_dictionary_data[$v['categoryid']]=$v['categoryname'];
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
					$live_room_data[$k]['attrname'] = $category_live_dictionary_data[$v['attr_id']];		
				}
				$live_room_data[$k]['addtime'] = date("Y-m-d",$live_room_data[$k]['addtime']);
				unset($live_room_data[$k]['peopleby']);
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
     * 获取搜索列表数据，按分类来
     */
    public function search_video_room_cat() {
		$nowtime = time();		
        $keyworld = $this->input->get_post('keyworld', true); //		
        $categoryid = intval($this->input->get_post('categoryid', true)); //
        $anchortype = intval($this->input->post('anchortype', true)); //
        $destid = intval($this->input->post('destid', true)); //
        $destname = $this->input->post('destname', true); //
        $lineid = $this->input->post('lineid', true); //线路id
        $type = intval($this->input->get_post('videoType', true)); //1表示直播及历史直播视频，10表示短视频,20表示只有直播			
        $page = intval($this->input->post('page', true)); //翻页	
        $page = empty($page) ? 1 : $page;	
        $page_size = 20;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from
        $sql_page = " LIMIT {$from},{$page_size}";
		$where1 = '';
		$where2 = '';		
		if($keyworld){
			$where1 .= ' and (room_name like"%'.$keyworld.'%" or room_dest like"%'.$keyworld.'%" )';
			$where2 .= ' and (name like"%'.$keyworld.'%" or dest_name like"%'.$keyworld.'%" )';			
		}
		if($categoryid){
			$where1 .= ' and attr_id='.$categoryid.' ';
			$where2 .= ' and attr_id='.$categoryid.' ';			
		}else{
			$where1 .= ' and attr_id not in('.$this->notin_attrids.')';
			$where2 .= ' and attr_id not in('.$this->notin_attrids.')';			
		}		
		if($anchortype){
			$where1 .= ' and user_type='.$anchortype.' ';
			$where2 .= ' and user_type='.$anchortype.' ';			
		}
		/*if($destid){
			$where1 .= ' and room_dest_id='.$destid.' ';
			$where2 .= ' and dest_id='.$destid.' ';			
		}*/
		if($destname){
			$where1 .= ' and room_dest like"%'.$destname.'%" ';
			$where2 .= ' and dest_name like"%'.$destname.'%" ';			
		}
		if($lineid){
			//$where1 .= ' and line_ids="'.$lineid.'" ';
			//$where2 .= ' and line_ids="'.$lineid.'" ';	
			$where1 = ' and FIND_IN_SET('.$lineid.', line_ids) ';
			$where2 = ' and FIND_IN_SET('.$lineid.', line_ids) ';			
		}
		$live_room_data = array();		
		if($type==1){//1表示直播
			$sql_str = '(select anchor_id,room_id,0 as video_id, room_name as name,0 as read_num,peoples as watching_num,pic as cover,starttime as addtime,peoples as peopleby,3 as type,room_dest as dest_name,room_dest_id as dest_id,1 as isroom,0 as video_height,0 as video_width,like_num,attr_id from live_room  where live_status=1 and status in(1,2) '.$where1.'  and  createtime>'.($nowtime - $this->room_timeout).' )union (select anchor_id,room_id,id as video_id,name,people as read_num,0 as watching_num,pic as cover,addtime,people as peopleby,type,dest_name,dest_id,0 as isroom,video_height,video_width,like_num,attr_id from live_video where video<>"" and pic<>"" '.$where2.' and status in(1,3)  and type=1 ) order by isroom desc,watching_num desc,peopleby desc,addtime desc '.$sql_page;
			$live_room_data = $this->live_db->query($sql_str)->result_array();			
		}else if($type==10){//10表示短视频
			$sql_str = 'select anchor_id,room_id,id as video_id,name,people as read_num,0 as watching_num,pic as cover,addtime,people as peopleby,type,dest_name,dest_id,video_height,video_width,like_num,attr_id from live_video where video<>"" and pic<>"" and status in(1,3) and type=2 '.$where2.' order by status desc,sort desc,watching_num desc,peopleby desc,addtime desc '.$sql_page;
			$live_room_data = $this->live_db->query($sql_str)->result_array();				
		}else if($type==20){//20表示只有直播
			$sql_str = 'select anchor_id,room_id,0 as video_id, room_name as name,0 as read_num,peoples as watching_num,pic as cover,starttime as addtime,peoples as peopleby,3 as type,room_dest as dest_name,room_dest_id as dest_id,1 as isroom,0 as video_height,0 as video_width,like_num,attr_id from live_room  where live_status=1 and status in(1,2) '.$where1.'  and  createtime>'.($nowtime - $this->room_timeout).'  order by isroom desc,watching_num desc,peopleby desc,addtime desc '.$sql_page;
			$live_room_data = $this->live_db->query($sql_str)->result_array();				
		}
		$num_live_room_data = count($live_room_data);
		$anchor_ids = array();
		$attr_id = array();
		if($num_live_room_data>0){
			foreach($live_room_data as $v){
				$anchor_ids[$v['anchor_id']] = $v['anchor_id'];
				$attr_id[$v['attr_id']] = $v['attr_id'];
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
		//获取标签
		$category_live_dictionary_data = array();
		if(!empty($attr_id)){
			$sql_str = "select dict_id as categoryid,description as categoryname from live_dictionary where dict_id in(".implode(",",$attr_id).") ";
			$category_live_dictionary_datas = $this->live_db->query($sql_str)->result_array();
			foreach($category_live_dictionary_datas as $v){
				$category_live_dictionary_data[$v['categoryid']]=$v['categoryname'];
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
					$live_room_data[$k]['attrname'] = $category_live_dictionary_data[$v['attr_id']];					
				}
				$live_room_data[$k]['addtime'] = date("Y-m-d",$live_room_data[$k]['addtime']);
				unset($live_room_data[$k]['peopleby']);
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
     */
    public function search_video_room() {
		$nowtime = time();		
        $keyworld = $this->input->post('keyworld', true); //		
        $categoryid = intval($this->input->post('categoryid', true)); //
        $anchortype = intval($this->input->post('anchortype', true)); //
        $destid = intval($this->input->post('destid', true)); //
        $destname = $this->input->post('destname', true); //
        $lineid = $this->input->post('lineid', true); //线路id
		
        $page = intval($this->input->post('page', true)); //翻页	
        $page = empty($page) ? 1 : $page;	
        $page_size = 20;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from
        $sql_page = " LIMIT {$from},{$page_size}";
		$where1 = '';
		$where2 = '';		
		if($keyworld){
			$where1 .= ' and (room_name like"%'.$keyworld.'%" or room_dest like"%'.$keyworld.'%" )';
			$where2 .= ' and (name like"%'.$keyworld.'%" or dest_name like"%'.$keyworld.'%" )';			
		}
		if($categoryid){
			$where1 .= ' and attr_id='.$categoryid.' ';
			$where2 .= ' and attr_id='.$categoryid.' ';			
		}else{
			$where1 .= ' and attr_id not in('.$this->notin_attrids.')';
			$where2 .= ' and attr_id not in('.$this->notin_attrids.')';			
		}		
		if($anchortype){
			$where1 .= ' and user_type='.$anchortype.' ';
			$where2 .= ' and user_type='.$anchortype.' ';			
		}
		/*if($destid){
			$where1 .= ' and room_dest_id='.$destid.' ';
			$where2 .= ' and dest_id='.$destid.' ';			
		}*/
		if($destname){
			$where1 .= ' and room_dest like"%'.$destname.'%" ';
			$where2 .= ' and dest_name like"%'.$destname.'%" ';			
		}
		if($lineid){
			//$where1 .= ' and line_ids="'.$lineid.'" ';
			//$where2 .= ' and line_ids="'.$lineid.'" ';
			$where1 = ' and FIND_IN_SET('.$lineid.', line_ids) ';
			$where2 = ' and FIND_IN_SET('.$lineid.', line_ids) ';			
		}		
		$sql_str = '(select anchor_id,room_id,0 as video_id, room_name as name,0 as read_num,peoples as watching_num,pic as cover,starttime as addtime,peoples as peopleby,3 as type,room_dest as dest_name,room_dest_id as dest_id,1 as isroom,0 as video_height,0 as video_width,like_num,attr_id from live_room  where live_status=1 and status in(1,2) '.$where1.'  and  createtime>'.($nowtime - $this->room_timeout).' )union (select anchor_id,room_id,id as video_id,name,people as read_num,0 as watching_num,pic as cover,addtime,people as peopleby,type,dest_name,dest_id,0 as isroom,video_height,video_width,like_num,attr_id from live_video where video<>"" and pic<>"" '.$where2.' and status in(1,3) ) order by isroom desc,watching_num desc,peopleby desc,addtime desc '.$sql_page;
		$live_room_data = $this->live_db->query($sql_str)->result_array();			
		$num_live_room_data = count($live_room_data);
		$anchor_ids = array();
		$attr_id = array();
		if($num_live_room_data>0){
			foreach($live_room_data as $v){
				$anchor_ids[$v['anchor_id']] = $v['anchor_id'];
				$attr_id[$v['attr_id']] = $v['attr_id'];
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
		//获取标签
		$category_live_dictionary_data = array();
		if(!empty($attr_id)){
			$sql_str = "select dict_id as categoryid,description as categoryname from live_dictionary where dict_id in(".implode(",",$attr_id).") ";
			$category_live_dictionary_datas = $this->live_db->query($sql_str)->result_array();
			foreach($category_live_dictionary_datas as $v){
				$category_live_dictionary_data[$v['categoryid']]=$v['categoryname'];
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
					$live_room_data[$k]['attrname'] = $category_live_dictionary_data[$v['attr_id']];	
				}
				$live_room_data[$k]['addtime'] = date("Y-m-d",$live_room_data[$k]['addtime']);
				unset($live_room_data[$k]['peopleby']);
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
		$query_sql = "SELECT * FROM (SELECT DISTINCT d.id AS destid, d.kindname as destname
                            FROM cfg_round_trip AS t
                            LEFT JOIN u_dest_cfg AS d ON d.id=t.neighbor_id
                            WHERE (t.startplaceid = {$cityid} OR (t.startplaceid in (SELECT startplace_child_id FROM u_startplace_child WHERE startplace_id = {$cityid})) OR t.startplaceid = 391)
                            AND t.isopen=1 AND d.level = 3 ORDER BY d.displayorder DESC) AS alias  ";       // 去掉limit 10  魏勇编辑
		
		
		/*$query_sql=" SELECT rt.neighbor_id as destid,dest.kindname as destname";
		$query_sql.=" FROM	bangu.cfg_round_trip AS rt ";
		$query_sql.=" LEFT JOIN bangu.u_dest_cfg AS dest ON rt.neighbor_id = dest.id ";
		$query_sql.=" where rt.isopen =1 and rt.startplaceid={$cityid}  ";
		$query_sql.=" limit 4";*/
		$round_city=$this->db ->query($query_sql) ->result_array(); 		
		//国内游
		$query_sql = "(SELECT * 
                            FROM (
                            SELECT distinct cd.dest_id AS destid, ud.kindname as destname
                            FROM cfgm_hot_dest as cd left join u_dest_cfg as ud on ud.id=cd.dest_id
                            WHERE (cd.startplaceid = {$cityid} OR (cd.startplaceid in (SELECT startplace_child_id FROM u_startplace_child WHERE startplace_id = {$cityid})) or cd.startplaceid = 391) 
                            AND cd.is_show='1' and cd.status=1 AND cd.dest_type = 2 ORDER BY cd.showorder desc) AS hot )
                            UNION
                            (SELECT *
                            FROM (
                            SELECT DISTINCT  ud.id AS destid, ud.kindname as destname
                            FROM u_dest_cfg AS ud
                            LEFT JOIN u_dest_line_num as udln on ud.id = udln.dest_id
                            WHERE (udln.startplace_id = {$cityid} OR (udln.startplace_id in (SELECT startplace_child_id FROM u_startplace_child WHERE startplace_id = {$cityid})) or udln.startplace_id = 391) AND ud.id NOT IN    
                            (SELECT dest_id FROM cfgm_hot_dest) 
                            AND ud.level = 3 
                            AND ud.pid IN (SELECT id FROM u_dest_cfg WHERE pid = 2) 
                            AND ud.isopen = 1
                            ORDER BY ud.displayorder DESC) AS common ) ";           // 去掉limit 10 魏勇编辑
		/*$query_sql=" SELECT fdest.id as destid, fdest.kindname as destname ";
		$query_sql.=" FROM	bangu.u_dest_cfg AS pdest ";
		$query_sql.="  LEFT JOIN bangu.u_dest_cfg AS fdest ON pdest.id = fdest.pid ";
		$query_sql.=" WHERE pdest.pid = 2 AND fdest.isopen = 1 AND fdest.ishot = 1 ";
		$query_sql.=" ORDER BY fdest.displayorder ASC ";
		$query_sql.=" limit 4";	*/
		$country_city=$this->db ->query($query_sql) ->result_array(); 
		//出境游
		$query_sql = "(SELECT * 
                            FROM (
                            SELECT distinct cd.dest_id AS destid, ud.kindname as destname
                            FROM cfgm_hot_dest as cd left join u_dest_cfg as ud on ud.id=cd.dest_id
                            WHERE (cd.startplaceid = {$cityid} OR (cd.startplaceid in (SELECT startplace_child_id FROM u_startplace_child WHERE startplace_id = {$cityid})) or cd.startplaceid = 391) 
                            AND cd.is_show='1' and cd.status=1 AND cd.dest_type = 1 ORDER BY cd.showorder desc, line_num desc) AS hot )
                            UNION
                            (SELECT *
                            FROM (
                            SELECT DISTINCT  ud.id  AS destid, ud.kindname as destname
                            FROM u_dest_cfg AS ud
                            LEFT JOIN u_dest_line_num as udln on ud.id = udln.dest_id
                            WHERE (udln.startplace_id = {$cityid} OR (udln.startplace_id in (SELECT startplace_child_id FROM u_startplace_child WHERE startplace_id = {$cityid})) or udln.startplace_id = 391) AND ud.id NOT IN    
                            (SELECT dest_id FROM cfgm_hot_dest) 
                            AND ud.level = 3 
                            AND ud.pid IN (SELECT id FROM u_dest_cfg WHERE pid = 1) 
                            AND ud.isopen = 1
                            ORDER BY ud.displayorder DESC) AS common ) ";       // 去掉limit 10 魏勇编辑
		/*$query_sql="  SELECT pdest.id as destid,pdest.kindname as destname ";
		$query_sql.=" FROM	bangu.u_dest_cfg AS pdest ";
		$query_sql.="  where pdest.ishot=1 and pdest.isopen=1 and pdest.pid=1 ";
		$query_sql.=" ORDER BY pdest.displayorder ASC ";
		$query_sql.=" limit 4";	*/	
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
						//if($live_anchor_data['type']!=3){	//不是管家
							unset($category_live_dictionary_data[$key]);
						//}					
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
        $destname = $this->input->post('destname', true); //定位目的地名			
        $lineid = $this->input->post('lineid', true); //关联线路,多个用逗号
/*		
        $categoryid = 1;		
        $roomname = '111';
        $cover = 'ww';		
        $destid = '12';	
        $lineid = '222';		
*/
		if(empty($categoryid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"请选择直播类型!",'3020');			
		}
		if(empty($cover)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"请定上传封面图!",'3021');			
		}		
		/*if(empty($destid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"请定位你的目的地!",'3022');			
		}*/		
		if(mb_strlen($roomname,'utf8')>30 || empty($roomname) ){
			$returnData = array();	
			$this->__outlivemsg($returnData,'房间名称不能为空且最多30个文字','3023');				
		}
			
		$room_dest = ' ';//开播所属目的地		
		if($destid){
			$arr = $this->db->query("select id,kindname from u_dest_cfg where id=" . $destid . "")->row_array();			
			if(!empty($arr)){
				$room_dest =$arr['kindname'];
			}else{
				$room_dest =$destname;
				/*
				$arr = $this->db->query("select id,name from u_area where id=" . $destid . "")->row_array();
				if(!empty($arr)){
					$room_dest =$arr['name'];
				}*/				
			}
		}else{
			$room_dest =$destname;
		}

		
		$line_ids='';
		if(isset($lineid) && !empty($lineid) ){
			$lineId = trim($lineid,',');
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

		$live_anchor_data =  $this->live_anchor_info;
		/*$live_anchor_data = array(
			'type'=>'1',
			'anchor_id'=>'170',
			'name'=>'tt'
		);*/		
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
/*
		//没有专属房间,使用公用房间分配
		$sql = 'SELECT room_id,roomid,anchor_password FROM live_room WHERE anchor_id= '.$live_anchor_data['anchor_id'].' and live_status in(1,3) and status in(1,2) and  createtime>'.($nowtime - $this->room_timeout).' ';
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
*/
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
				"room_number"		=>'11',
				"anchor_id"=>$live_anchor_data['anchor_id'],
				"user_type"=>$live_anchor_data['type'],
				"attr_id"=>$categoryid,
				"line_ids"=>$line_ids,
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
     */	
    public function check_anchor_info() {
		$this->anchor_verification();//检查是否为主播
		$live_anchor_data =  $this->live_anchor_info;
		$nowtime = time();
		$room = array();
		//没有专属房间,使用公用房间分配
		$sql = 'SELECT room_id,roomid,anchor_password FROM live_room WHERE anchor_id= '.$live_anchor_data['anchor_id'].' and live_status in(1) and status in(1,2) and  createtime>'.($nowtime - $this->room_timeout).' ';
		$live_room_data =  $this->live_db->query($sql )->row_array();		
		if(!empty($live_room_data)){//您已经有房间正在直播
			$room = array(
				'room_id'=>$live_room_data['room_id'],
				'roomid'=>$live_room_data['roomid'],
				'anchor_password'=>$live_room_data['anchor_password'],
				'nickname'=>$live_anchor_data['name'],	
			);			
		}
		$returnData = array(
			'anchor_id'=>$live_anchor_data['anchor_id'],
			'room'=> $room,
		);		
		if(!empty($room)){
			//$this->__outlivemsg($returnData,'有房间','3001');	
			$this->__outlivemsg($returnData);			
		}else{
			$this->__outlivemsg($returnData);			
		}
    }	
	
	
    /**
     * 获取主播详细页信息
     */	
    public function get_anchor_home() {
        $anchorid = intval($this->input->post('anchorid', true)); //直播房间id
		if(empty($anchorid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}
		$userid = 0;
		if(!empty($this->user_id)){	
			$userid = $this->user_id;
		}		
		$sql = 'SELECT * FROM live_anchor WHERE anchor_id= '.$anchorid;
		$live_anchor_data =  $this->live_db->query($sql)->row_array();
		if(empty($live_anchor_data)){//
			$returnData = array();	
			$this->__outlivemsg($returnData,"用户不存在",'4001');			
		}		
		//获取标签
		$sql_str = "select attr_id from live_anchor_attr where anchor_id=".$anchorid." ";
		$live_anchor_attr_data = $this->live_db->query($sql_str)->result_array();
		$attr_id = array();
		if(!empty($live_anchor_attr_data)){
			foreach($live_anchor_attr_data as $v){
				$attr_id[$v['attr_id']] = $v['attr_id'];
			}
		}
		$category_live_dictionary_data = array();
		if(!empty($attr_id)){
			$sql_str = "select dict_id as categoryid,description as categoryname from live_dictionary where dict_id in(".implode(",",$attr_id).") ";
			$category_live_dictionary_data = $this->live_db->query($sql_str)->result_array();			
		}
		$area_name = '';
		$comment=$live_anchor_data['comment'];
/*		
		$areas = array();
		(isset($live_anchor_data['province']) && !empty($live_anchor_data['province'])) && $areas[$live_anchor_data['province']] = $live_anchor_data['province'];
		(isset($live_anchor_data['city']) && !empty($live_anchor_data['city'])) && $areas[$live_anchor_data['city']] = $live_anchor_data['city'];		
		if(!empty($areas)){
			$areas_ts = array();
			$areas_arrs = $this->db->query("select id,name from u_area where id in(" . implode(",",$areas) . ")")->result_array();
			if(!empty($areas_arrs)){
				foreach($areas_arrs as $v){
					$areas_ts[$v['id']] = $v['name'];
				}				
			}
			$area_name = $areas_ts[$live_anchor_data['province']].' '.$areas_ts[$live_anchor_data['city']];
		}
*/
		$hobbies = $foods = $dests = array();
		if($live_anchor_data['user_type']==1){//管家
			$sql = 'SELECT * FROM u_expert_more_about WHERE expert_id= '.$live_anchor_data['user_id'];
			$u_expert_more_about_data =  $this->db->query($sql)->row_array();			
			// 故乡
			$areas = array();
			(isset($u_expert_more_about_data['province']) && !empty($u_expert_more_about_data['province'])) && $areas[$u_expert_more_about_data['province']] = $u_expert_more_about_data['province'];
			(isset($u_expert_more_about_data['city']) && !empty($u_expert_more_about_data['city'])) && $areas[$u_expert_more_about_data['city']] = $u_expert_more_about_data['city'];		
			if(!empty($areas)){
				$areas_ts = array();
				$areas_arrs = $this->db->query("select id,name from u_area where id in(" . implode(",",$areas) . ")")->result_array();
				if(!empty($areas_arrs)){
					foreach($areas_arrs as $v){
						$areas_ts[$v['id']] = $v['name'];
					}				
				}
				$area_name = $areas_ts[$u_expert_more_about_data['province']].' '.$areas_ts[$u_expert_more_about_data['city']];
			}		
			// 个人爱好
			if(!empty($u_expert_more_about_data['hobby'])){
				$hobbies = explode("#",$u_expert_more_about_data['hobby']);
			}
			// 喜欢美食
			if(!empty($u_expert_more_about_data['like_food'])){
				$foods = explode("#",$u_expert_more_about_data['like_food']);
			}			
			// 去过地方
			if(!empty($u_expert_more_about_data['pass_way'])){
				$dests = explode("#",$u_expert_more_about_data['pass_way']);
			}
		}else{//普通用户
			// 个人签名
			$talk = $this->db->query("SELECT talk FROM u_member WHERE mid =".$live_anchor_data['user_id'])->row_array();
			$comment = $talk['talk'];
			$sql = 'SELECT * FROM u_member_attr WHERE member_id= '.$live_anchor_data['user_id'];
			$u_member_attr_data =  $this->db->query($sql)->row_array();				
			// 故乡
			$areas = array();
			(isset($u_member_attr_data['province']) && !empty($u_member_attr_data['province'])) && $areas[$u_member_attr_data['province']] = $u_member_attr_data['province'];
			(isset($u_member_attr_data['city']) && !empty($u_member_attr_data['city'])) && $areas[$u_member_attr_data['city']] = $u_member_attr_data['city'];		
			if(!empty($areas)){
				$areas_ts = array();
				$areas_arrs = $this->db->query("select id,name from u_area where id in(" . implode(",",$areas) . ")")->result_array();
				if(!empty($areas_arrs)){
					foreach($areas_arrs as $v){
						$areas_ts[$v['id']] = $v['name'];
					}				
				}
				$area_name = $areas_ts[$u_member_attr_data['province']].' '.$areas_ts[$u_member_attr_data['city']];
			}		
			// 个人爱好
			if(!empty($u_member_attr_data['hobby1'])){
				$hobbies = explode("/",$u_member_attr_data['hobby1']);
			}
			// 喜欢美食
			if(!empty($u_member_attr_data['food1'])){
				$foods = explode("/",$u_member_attr_data['food1']);
			}			
			// 去过地方
			if(!empty($u_member_attr_data['dest1'])){
				$dests = explode("/",$u_member_attr_data['dest1']);
			}					
		}
		
		$fans = 0;//表示未关注
		$isme = 0;//表示不是自己的主播
		$like = 0;//表示未点赞		
		if(!empty($this->user_id)){//普通用户登录检查是否关注主播
			if(  $anchorid && $anchorid != $this->live_anchor_info['anchor_id'] ){//不是自己，且是主播
				$sql_str = "select id,status from live_anchor_fans where anchor_id=".$anchorid." and user_id=".$this->live_anchor_info['anchor_id'].' limit 1';
				$live_anchor_fans_data = $this->live_db->query($sql_str)->row_array();
				if(!empty($live_anchor_fans_data) && $live_anchor_fans_data['status']==1){
					$fans = 1;//表示关注
				}
				
				$sql_str = "select * from live_anchor_like where anchor_id=".$this->live_anchor_info['anchor_id']." and like_id=".$anchorid.' and like_type=1';
				$live_anchor_like_data = $this->live_db->query($sql_str)->row_array();//点赞类型,1主播点赞,2视频点赞，3评论点赞	,4直播点赞				
				if(!empty($live_anchor_like_data) && $live_anchor_like_data['status']==1){
					$like = 1;//表示点赞
				}				
			}else if($anchorid && $anchorid == $this->live_anchor_info['anchor_id']){
				$isme = 1;//表示是自己的主播
			}			
		}
		//$share_name='您需要的不是攻略，而是这个人';	
		//$share_content='帮游1+1，'.$live_anchor_data['name'].'一对一为您服务哦';	
		if($userid && $this->live_anchor_info['user_type']==1){//判断是否为管家身份
			$share_name='您需要的不是攻略，而是我。'.$live_anchor_data['name'].'给您拜年了！';	
			$share_content='帮游1+1，'.$live_anchor_data['name'].'为您一对一服务哦，完美旅程需要设计';	
		}else{
			$share_name='新的一年对自己好点儿！新年新旅行，推荐TA给您！';	
			$share_content='帮游1+1，'.$live_anchor_data['name'].'为您一对一服务哦，完美旅程需要设计';			
		}	
		$returnData = array(
			'name'=>$live_anchor_data['name'],
			'comment'=>$comment,
			'bg'=>trim(base_url(''),'/').$live_anchor_data['live_anchor'],
			'tag'=>$category_live_dictionary_data,			
			'area_name'=>$area_name,
			'photo'=>trim(base_url(''),'/').$live_anchor_data['photo'],
			//"share_url"=>$this->share_url.'anchor_share_index/?anchorid='.$anchorid.'&userid='.$userid,
			"share_url"=>$this->share_url.'anchor_share_index/?anchorid='.$anchorid,
			"share_name"=>$share_name,				
			"share_pic"=>trim(base_url(''),'/').$live_anchor_data['photo'],
			"share_content"=>$share_content,			
			'hobbies'=>$hobbies,
			'foods'=>$foods,
			'dests'=>$dests,
			'fans'=>$fans,
			'isme'=>$isme,
			'like'=>$like,			
		);	
		$this->__outlivemsg($returnData);
    }
	
    /**
     * 获取主播自己播放的信息
     */	
    public function get_anchor_home_video() {
        $anchorid = intval($this->input->post('anchorid', true)); //直播房间id
		if(empty($anchorid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}		
		$sql = 'SELECT * FROM live_anchor WHERE anchor_id= '.$anchorid;
		$live_anchor_data =  $this->live_db->query($sql)->row_array();
		$nowtime = time();		
		if(empty($live_anchor_data)){//
			$returnData = array();	
			$this->__outlivemsg($returnData,"用户不存在",'4001');			
		}
		$nowtime = time();
        $page = intval($this->input->post('page', true)); //翻页	
        $page = empty($page) ? 1 : $page;	
        $page_size = 8;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from
        $sql_page = " LIMIT {$from},{$page_size}";
		$sql_str = '(select anchor_id,room_id,0 as video_id, room_name as name,0 as read_num,peoples as watching_num,pic as cover,starttime as addtime,peoples as peopleby,3 as type,room_dest as dest_name,room_dest_id as dest_id,1 as isroom from live_room  where live_status=1 and status in(1,2)  and  createtime>'.($nowtime - $this->room_timeout).' and anchor_id='.$anchorid.' )union (select anchor_id,room_id,id as video_id,name,people as read_num,0 as watching_num,pic as cover,addtime,people as peopleby,type,dest_name,dest_id,0 as isroom from live_video where video<>"" and status in(1,3)  and anchor_id='.$anchorid.' ) order by isroom desc,peopleby desc,addtime desc '.$sql_page;
		$live_room_data = $this->live_db->query($sql_str)->result_array();			
		$num_live_room_data = count($live_room_data);

		if($num_live_room_data>0){
			foreach($live_room_data as $k=> $v){
				if(empty($v['cover'])){
					$live_room_data[$k]['cover'] = $live_anchor_data['video_pic'];					
				}
				if(strpos($live_room_data[$k]['cover'],'http://')!==0){
					$live_room_data[$k]['cover'] = trim(base_url(''),'/').$live_room_data[$k]['cover'];							
				}
				$live_room_data[$k]['avatar'] = trim(base_url(''),'/').$live_anchor_data['photo'];
				$live_room_data[$k]['anchor_name'] = $live_anchor_data['name'];				
				$live_room_data[$k]['anchor_sex'] = $live_anchor_data['sex'];
				$live_room_data[$k]['anchor_type'] = $live_anchor_data['type'];					
				unset($live_room_data[$k]['peopleby']);
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
     * 分别获取主播自己播放的信息
     */
    public function get_anchor_home_video_cat() {	
        $anchorid = intval($this->input->post('anchorid', true)); //直播房间id
        $type = intval($this->input->post('videoType', true)); //1表示直播及历史直播视频，10表示短视频			
		if(empty($anchorid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}		
		$sql = 'SELECT * FROM live_anchor WHERE anchor_id= '.$anchorid;
		$live_anchor_data =  $this->live_db->query($sql)->row_array();
		$nowtime = time();		
		if(empty($live_anchor_data)){//
			$returnData = array();	
			$this->__outlivemsg($returnData,"用户不存在",'4001');			
		}
		$nowtime = time();
        $page = intval($this->input->post('page', true)); //翻页	
        $page = empty($page) ? 1 : $page;	
        $page_size = 8;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from
        $sql_page = " LIMIT {$from},{$page_size}";
		$live_room_data = array();
		if($type==1){//1表示直播
			$sql_str = '(select anchor_id,room_id,0 as video_id, room_name as name,0 as read_num,peoples as watching_num,pic as cover,starttime as addtime,peoples as peopleby,3 as type,room_dest as dest_name,room_dest_id as dest_id,1 as isroom,status,sort,0 as video_height,0 as video_width from live_room  where live_status=1 and status in(1,2)  and  createtime>'.($nowtime - $this->room_timeout).' and anchor_id='.$anchorid.'  )union (select anchor_id,room_id,id as video_id,name,people as read_num,0 as watching_num,pic as cover,addtime,people as peopleby,type,dest_name,dest_id,0 as isroom,status,sort,video_height,video_width from live_video where video<>"" and status in(1,3)  and type=1  and anchor_id='.$anchorid.') order by isroom desc,status desc,sort desc,watching_num desc,peopleby desc,addtime desc '.$sql_page;	
			$live_room_data = $this->live_db->query($sql_str)->result_array();						
		}else if($type==10){//10表示短视频
			$sql_str = 'select anchor_id,room_id,id as video_id,name,people as read_num,0 as watching_num,pic as cover,addtime,people as peopleby,type,dest_name,dest_id,video_height,video_width from live_video where video<>"" and status in(1,3) and type=2  and anchor_id='.$anchorid.' order by status desc,sort desc,watching_num desc,peopleby desc,addtime desc '.$sql_page;
			$live_room_data = $this->live_db->query($sql_str)->result_array();				
		}		
		$num_live_room_data = count($live_room_data);
		if($num_live_room_data>0){
			foreach($live_room_data as $k=> $v){
				if(empty($v['cover'])){
					$live_room_data[$k]['cover'] = $live_anchor_data['video_pic'];					
				}
				if(strpos($live_room_data[$k]['cover'],'http://')!==0){
					$live_room_data[$k]['cover'] = trim(base_url(''),'/').$live_room_data[$k]['cover'];							
				}
				$live_room_data[$k]['avatar'] = trim(base_url(''),'/').$live_anchor_data['photo'];
				$live_room_data[$k]['anchor_name'] = $live_anchor_data['name'];				
				$live_room_data[$k]['anchor_sex'] = $live_anchor_data['sex'];
				$live_room_data[$k]['anchor_type'] = $live_anchor_data['type'];					
				unset($live_room_data[$k]['peopleby']);
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
     * 按分类获取自己的视频
     */	
    public function get_my_video_cat() {
        $type = intval($this->input->get_post('videoType', true)); //1表示直播视频，10表示短视频 ，30表示服务视频	
        //$categoryid = intval($this->input->get_post('categoryid', true)); //
		if($type==30){
			$where = ' and attr_id in('.$this->notin_attrids.')';//服务视频	
		}else{
			$where = ' and attr_id not in('.$this->notin_attrids.')';		
		}
		if(empty($this->user_id)){//用户没有登录
			$returnData = array();	
			$this->__outlivemsg($returnData,'您还没有登录','1001');				
		}			
		$live_anchor_data =  $this->live_anchor_info;
		$anchorid = $live_anchor_data['anchor_id'];
		$userid = 0;
		if(!empty($this->user_id)){	
			$userid = $this->user_id;
		}
		$nowtime = time();
        $page = intval($this->input->post('page', true)); //翻页
        $page_size = intval($this->input->post('pagesize', true)); //翻页		
        $page = empty($page) ? 1 : $page;
        $page_size = empty($page_size) ? 8 : $page_size;//每页显示记录数		 
        $from = ($page - 1) * $page_size; //from
        $sql_page = " LIMIT {$from},{$page_size}";
		$live_room_data = array();
		if($type==1){//1表示直播
			$sql_str = 'select anchor_id,room_id,id as video_id,name,people as read_num,0 as watching_num,pic as cover,addtime,people as peopleby,type,dest_name,dest_id,video_height,video_width,like_num,attr_id,line_ids from live_video where  status in(1,3) and type=1 and anchor_id='.$anchorid.' '.$where.'  order by addtime desc '.$sql_page;
			$live_room_data = $this->live_db->query($sql_str)->result_array();				
		}else if($type==10){//10表示短视频
			$sql_str = 'select anchor_id,room_id,id as video_id,name,people as read_num,0 as watching_num,pic as cover,addtime,people as peopleby,type,dest_name,dest_id,video_height,video_width,like_num,attr_id,line_ids from live_video where  status in(1,3) and type=2 and anchor_id='.$anchorid.' '.$where.' order by addtime desc '.$sql_page;
			$live_room_data = $this->live_db->query($sql_str)->result_array();				
		}else if($type==30){//30表示服务
			$sql_str = 'select anchor_id,room_id,id as video_id,name,people as read_num,0 as watching_num,pic as cover,addtime,people as peopleby,type,dest_name,dest_id,video_height,video_width,like_num,attr_id,line_ids from live_video where  status in(1,3)  and anchor_id='.$anchorid.' '.$where.' order by addtime desc '.$sql_page;
			$live_room_data = $this->live_db->query($sql_str)->result_array();			
		}
		$num_live_room_data = count($live_room_data);

		if($num_live_room_data>0){
			$attr_id = array();
			if(!empty($live_room_data)){
				foreach($live_room_data as $v){
					$attr_id[$v['attr_id']] = $v['attr_id'];
				}
			}			
			//获取标签
			$category_live_dictionary_data = array();
			if(!empty($attr_id)){
				$sql_str = "select dict_id as categoryid,description as categoryname from live_dictionary where dict_id in(".implode(",",$attr_id).") ";
				$category_live_dictionary_datas = $this->live_db->query($sql_str)->result_array();
				foreach($category_live_dictionary_datas as $v){
					$category_live_dictionary_data[$v['categoryid']]=$v['categoryname'];
				}	
			}	
		
			foreach($live_room_data as $k=> $v){
/*				
				if($v['type']==1){//直播视频
					$share_name ='与世界同步，这个直播太好玩了';	
					$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
					$share_content ='【'.$v['name'].'】，正在直播中';				
				}else{
					$share_name ='这个视频碉堡了，快戳进来';	
					$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
					$share_content ='视频详情+更多有趣小视频，尽在这里！';					
				}
*/				
				if($userid && $this->live_anchor_info['user_type']==1){//判断是否为管家身份
					if($v['type']==1){//直播视频
						if($v['attr_id']==6){//服务直播
							//$share_name =''.$live_anchor_data['name'].'祝您新年大吉，万事如意，正直播【'.$v['name'].'】';
							$share_name ='新年大吉，万事如意，管家'.$live_anchor_data['name'].'正直播...';							
							$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
							$share_content ='帮游1+1，完美旅程需要设计';
						}else{
							$share_name ='了解您的旅游，咨询我/'.$live_anchor_data['name'].'正为您直播【祝您新年发发发】';	
							$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
							$share_content ='帮游1+1，帮你打造完美旅游体验';						
						}				
					}else{
						$share_name ='快看我用这个有趣的视频给您拜年啦，戳进来';	
						$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
						$share_content ='更多你没看过的，尽在这里！';					
					}						
				}else{
					if($v['type']==1){//直播视频
						if($v['attr_id']==6){//服务直播
							//$share_name =''.$live_anchor_data['name'].'祝您新年大吉，万事如意，正直播【'.$v['name'].'】';
							$share_name ='新年大吉，万事如意，管家'.$live_anchor_data['name'].'正直播...';		
							$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
							$share_content ='帮游1+1，完美旅程需要设计';						
						}else{
							$share_name ='新的一年与世界同步，分享一个好玩的直播给您拜年啦';	
							$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
							$share_content ='达人正在'.$v['dest_name'].'直播，不看后悔……';						
						}				
					}else{
						$share_name ='快看我用这个有趣的视频给您拜年啦，戳进来';	
						$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
						$share_content ='更多你没看过的，尽在这里！';					
					}		
				}	

				if(empty($v['cover'])){
					$live_room_data[$k]['cover'] = $live_anchor_data['video_pic'];					
				}
				if(strpos($live_room_data[$k]['cover'],'http://')!==0){
					$live_room_data[$k]['cover'] = trim(base_url(''),'/').$live_room_data[$k]['cover'];							
				}
				$live_room_data[$k]['avatar'] = trim(base_url(''),'/').$live_anchor_data['photo'];
				$live_room_data[$k]['anchor_name'] = $live_anchor_data['name'];				
				$live_room_data[$k]['anchor_sex'] = $live_anchor_data['sex'];
				$live_room_data[$k]['anchor_type'] = $live_anchor_data['type'];
				$live_room_data[$k]['addtime'] = date("Y-m-d",$v['addtime']);				
				$live_room_data[$k]['share_url'] = $this->share_url.'video_share/?videoid='.$v['video_id'].'&userid='.$userid;
				$live_room_data[$k]["share_name"] =$share_name;	
				//$live_room_data[$k]["share_pic"] =trim(base_url(''),'/').$v['pic'];
				$live_room_data[$k]["share_pic"] =$share_pic;				
				$live_room_data[$k]["share_content"] =$share_content;	
				$live_room_data[$k]['attrname'] = $category_live_dictionary_data[$v['attr_id']];				
				unset($live_room_data[$k]['peopleby']);
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
     * 获取自己的视频
     */	
    public function get_my_video() {
		if(empty($this->user_id)){//用户没有登录
			$returnData = array();	
			$this->__outlivemsg($returnData,'您还没有登录','1001');				
		}			
		$live_anchor_data =  $this->live_anchor_info;
		$anchorid = $live_anchor_data['anchor_id'];
		$userid = 0;
		if(!empty($this->user_id)){	
			$userid = $this->user_id;
		}
		$nowtime = time();
        $page = intval($this->input->post('page', true)); //翻页
        $page_size = intval($this->input->post('pagesize', true)); //翻页		
        $page = empty($page) ? 1 : $page;
        $page_size = empty($page_size) ? 8 : $page_size;//每页显示记录数		 
        $from = ($page - 1) * $page_size; //from
        $sql_page = " LIMIT {$from},{$page_size}";
		$sql_str = 'select anchor_id,room_id,id as video_id,name,people as read_num,pic as cover,addtime,people as peopleby,type,dest_name,dest_id from live_video where status in(1,3) and anchor_id='.$anchorid.'  order by addtime desc '.$sql_page;
		$live_room_data = $this->live_db->query($sql_str)->result_array();			
		$num_live_room_data = count($live_room_data);

		if($num_live_room_data>0){
			foreach($live_room_data as $k=> $v){
				/*
				if($v['type']==1){//直播视频
					$share_name ='与世界同步，这个直播太好玩了';	
					$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
					$share_content ='【'.$v['name'].'】，正在直播中';				
				}else{
					$share_name ='这个视频碉堡了，快戳进来';	
					$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
					$share_content ='视频详情+更多有趣小视频，尽在这里！';					
				}				
				*/
				
				if($userid && $this->live_anchor_info['user_type']==1){//判断是否为管家身份
					if($v['type']==1){//直播视频
						if($v['attr_id']==6){//服务直播
							//$share_name =''.$live_anchor_data['name'].'祝您新年大吉，万事如意，正直播【'.$v['name'].'】';
							$share_name ='新年大吉，万事如意，管家'.$live_anchor_data['name'].'正直播...';	
							$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
							$share_content ='帮游1+1，完美旅程需要设计';
						}else{
							$share_name ='了解您的旅游，咨询我/'.$live_anchor_data['name'].'正为您直播【祝您新年发发发】';	
							$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
							$share_content ='帮游1+1，帮你打造完美旅游体验';						
						}				
					}else{
						$share_name ='快看我用这个有趣的视频给您拜年啦，戳进来';	
						$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
						$share_content ='更多你没看过的，尽在这里！';					
					}						
				}else{
					if($v['type']==1){//直播视频
						if($v['attr_id']==6){//服务直播
							//$share_name =''.$live_anchor_data['name'].'祝您新年大吉，万事如意，正直播【'.$v['name'].'】';
							$share_name ='新年大吉，万事如意，管家'.$live_anchor_data['name'].'正直播...';	
							$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
							$share_content ='帮游1+1，完美旅程需要设计';						
						}else{
							$share_name ='新的一年与世界同步，分享一个好玩的直播给您拜年啦';	
							$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
							$share_content ='达人正在'.$v['dest_name'].'直播，不看后悔……';						
						}				
					}else{
						$share_name ='快看我用这个有趣的视频给您拜年啦，戳进来';	
						$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
						$share_content ='更多你没看过的，尽在这里！';					
					}		
				}					
				if(empty($v['cover'])){
					$live_room_data[$k]['cover'] = $live_anchor_data['video_pic'];					
				}
				if(strpos($live_room_data[$k]['cover'],'http://')!==0){
					$live_room_data[$k]['cover'] = trim(base_url(''),'/').$live_room_data[$k]['cover'];							
				}
				$live_room_data[$k]['avatar'] = trim(base_url(''),'/').$live_anchor_data['photo'];
				$live_room_data[$k]['anchor_name'] = $live_anchor_data['name'];				
				$live_room_data[$k]['anchor_sex'] = $live_anchor_data['sex'];
				$live_room_data[$k]['anchor_type'] = $live_anchor_data['type'];
				$live_room_data[$k]['addtime'] = date("Y-m-d",$v['addtime']);				
				$live_room_data[$k]['share_url'] = $this->share_url.'video_share/?videoid='.$v['video_id'].'&userid='.$userid;
				$live_room_data[$k]["share_name"] =$share_name;	
				//$live_room_data[$k]["share_pic"] =trim(base_url(''),'/').$v['pic'];
				$live_room_data[$k]["share_pic"] =$share_pic;				
				$live_room_data[$k]["share_content"] =$share_content;				
				unset($live_room_data[$k]['peopleby']);
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
     * 删除自己的视频
     */
    public function del_my_video() {
        $video_id = $this->input->post('videoid', true); //主播id
        if(empty($video_id)){
			$returnData = array();	
			$this->__outlivemsg($returnData,'参数错误','3031');			
		}		
		if(empty($this->user_id)){//用户没有登录
			$returnData = array();	
			$this->__outlivemsg($returnData,'您还没有登录','1001');				
		}
		$live_anchor_data =  $this->live_anchor_info;
		
		$anchor_id = $live_anchor_data['anchor_id'];
		$sql_str = "select id,status from live_video where anchor_id=".$anchor_id." and id=".$video_id;
		$live_anchor_fans_data = $this->live_db->query($sql_str)->row_array();	
		if(!empty($live_anchor_fans_data)){
			$this->live_db->query("update live_video set `status`=0 where id = ".$live_anchor_fans_data['id']."");
			$returnData = array();
			$this->__outlivemsg($returnData);			
		}else{
			$returnData = array();	
			$this->__outlivemsg($returnData,'操作失败','3031');				
		}

    }	
	
    /**
     * 修改自己视频的关联线路
     */
    public function edit_my_video_lines() {
        $video_id = $this->input->post('videoid', true); //视频id
        $linesid = $this->input->post('linesid', true); //线路id,多个用逗号隔开	
        if(empty($video_id)){
			$returnData = array();	
			$this->__outlivemsg($returnData,'参数错误','3031');			
		}		
		if(empty($this->user_id)){//用户没有登录
			$returnData = array();	
			$this->__outlivemsg($returnData,'您还没有登录','1001');				
		}
		
		$line_ids='';
		if(isset($linesid) && !empty($linesid) ){
			$lineId = trim($linesid,',');
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

		$live_anchor_data =  $this->live_anchor_info;
		$anchor_id = $live_anchor_data['anchor_id'];
		$sql_str = "select id,status from live_video where anchor_id=".$anchor_id." and id=".$video_id;
		$live_anchor_fans_data = $this->live_db->query($sql_str)->row_array();	
		if(!empty($live_anchor_fans_data)){
			$this->live_db->query("update live_video set `line_ids`='".$line_ids."' where id = ".$live_anchor_fans_data['id']."");
			$returnData = array();
			$this->__outlivemsg($returnData);			
		}else{
			$returnData = array();	
			$this->__outlivemsg($returnData,'操作失败','3031');				
		}

    }	
	
    /**
     * 获取主播信息
     */	
    public function get_anchor_info() {
        $anchorid = intval($this->input->post('anchorid', true)); //直播房间id
		if(empty($anchorid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}		
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
     * 获取房间的统计信息
     */	
    public function get_room_count_infos() {
        $roomid = intval($this->input->post('roomid', true)); //直播房间id
		if(empty($roomid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}		
		$sql_str = "select peoples from live_room where room_id=".$roomid."";
		$live_room_data = $this->live_db->query($sql_str)->row_array();			
		if(empty($live_room_data)){
			$returnData = array();	
			$this->__outlivemsg($returnData,'房间不存在','3000');			
		}
		$sql_str = 'select count(*) as total from (select user_id from live_room_chat where room_id='.$roomid.'  GROUP BY user_id order by null ) as a';
		$live_room_chat_total = $this->live_db->query($sql_str)->row_array();			

		$sql_str = 'select count(*) as total from (select user_id from live_gift_record where room_id='.$roomid.' GROUP BY user_id order by null ) as a';
		$live_gift_record_total = $this->live_db->query($sql_str)->row_array();			
		
		$returnData = array(
			'peoples'=>$live_room_data['peoples'],
			'chat'=>$live_room_chat_total['total'],
			'gift'=>$live_gift_record_total['total'],			
		);	
		$this->__outlivemsg($returnData);
    }	
	
	
    /**
     * 获取房间的所有统计信息,获取直播房间的关注总数及打赏总数
     */	
    public function get_room_all_count_infos() {
        $roomid = intval($this->input->get_post('roomid', true)); //直播房间id
        $datatype = intval($this->input->get_post('datatype', true)); //数据类型		
		if(empty($roomid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}		
		$sql_str = "select peoples,umoney,anchor_id,createtime,starttime,status,type,live_status from live_room where room_id=".$roomid."";
		$live_room_data = $this->live_db->query($sql_str)->row_array();
		if($datatype==1){
			if(!empty($live_room_data)){
				$returnData['info'] = array(
					'umoney'=>$live_room_data['umoney'],	
				);					
			}else{
				$returnData['info'] = array(
					'umoney'=>'0',				
				);				
			}
			$this->__outlivemsg($returnData);
		}
		/*if(empty($live_room_data)){
			$returnData = array();	
			$this->__outlivemsg($returnData,'房间不存在','3000');			
		}*/
		if(!empty($live_room_data)){
			$sql_str = "select count(id)as num from live_anchor_fans where status=1 and anchor_id=".$live_room_data['anchor_id'];
			$live_anchor_fans_data = $this->live_db->query($sql_str)->row_array();
			
			$sql_str = 'select count(*) as total from (select user_id from live_room_chat where room_id='.$roomid.'  GROUP BY user_id order by null ) as a';
			$live_room_chat_total = $this->live_db->query($sql_str)->row_array();			

			$sql_str = 'select count(*) as total from (select user_id from live_gift_record where room_id='.$roomid.' GROUP BY user_id order by null ) as a';
			$live_gift_record_total = $this->live_db->query($sql_str)->row_array();
			//判断直播是否结束
			$isover = 0;//表示不在直播
			$nowtime = time();		
			if( $live_room_data['status']==1 && $live_room_data['live_status']==1 && $live_room_data['createtime']>($nowtime - $this->room_timeout) ){//表示正在直播
				$isover = 1;//正在直播							
			}else if($live_room_data['status']==1 && $live_room_data['live_status']==3 && $live_room_data['createtime']>($nowtime - $this->room_timeout)){//
				$isover = 3;//正被占用房间但还没开始直播
			}
			//房间直播状态 0空闲 1正在直播 2正在录播 3正被占用房间但还没开始直播
			$returnData['info'] = array(
				'umoney'=>$live_room_data['umoney'],
				'attention'=>$live_anchor_fans_data['num'],
				'peoples'=>$live_room_data['peoples'],
				'chat'=>$live_room_chat_total['total'],
				'gift'=>$live_gift_record_total['total'],
				'isover'=>$isover,	
			);			
		}else{
			$returnData['info'] = array(
				'umoney'=>'0',
				'attention'=>'0',
				'peoples'=>'0',
				'chat'=>'0',
				'gift'=>'0',
				'isover'=>'0',				
			);				
		}		
		$this->__outlivemsg($returnData);
    }	
	
    /**
     * 获取主播进入房间的信息
     */
    public function get_anchor_go_room_info() {
        $roomid = intval($this->input->post('roomid', true)); //直播房间id
		if(empty($roomid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}		
		$sql = 'SELECT roomid,anchor_password,anchor_id FROM live_room WHERE room_id= '.$roomid.' ';
		$live_room_data =  $this->live_db->query($sql )->row_array();			
		$sql_str = "select name,is_anchor,refuse_reason,status from live_anchor where anchor_id =".$live_room_data['anchor_id']." ";
		$live_anchor_data = $this->live_db->query($sql_str)->row_array();
        if(empty($live_anchor_data) || (!empty($live_anchor_data) && $live_anchor_data['status']==0)){
			$returnData = array();	
			$this->__outlivemsg($returnData,'您还不是主播，请申请主播','3000');			
		}
		if($live_anchor_data['status']==1){
			$returnData = array();	
			$this->__outlivemsg($returnData,"您还不是主播，正在审核中",'3000');				
		}
		if($live_anchor_data['status']==3){
			$returnData = array();	
			$this->__outlivemsg($returnData,"您还不是主播，审核不通过，原因是：".$live_anchor_data['refuse_reason'],'3000');				
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
     */
    public function get_line_by_destid1() {
		$cityid = $this->input->post('cityid', true);
        $destid = $this->input->post('destid', true); //目的地id
        $keyworld = $this->input->post('keyworld', true); //关键字
		if(empty($cityid)){
			$cityid = $this->default_cityid;
		}
        $page = intval($this->input->post('page', true)); //翻页		
        $page = empty($page) ? 1 : $page;	
        $page_size = 20;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from
        $sql_page = " LIMIT {$from},{$page_size}";	
		$where = 'l.status = 2 and l.producttype =0 and  s.id ='.$cityid;
		if($destid){		
			$where .= ' and FIND_IN_SET('.$destid.', l.overcity)';			
		}
		if($keyworld){
			$where .= ' and l.linename like"%'.$keyworld.'%"';
		}
		$sql_str = 'select l.id as lineid,l.linename as line_name,l.mainpic,l.shownum,l.collectnum,l.bookcount,l.satisfyscore,l.lineprice, l.overcity as dest_id
			from u_line l 
			LEFT JOIN u_line_startplace AS ls ON l.id=ls.line_id
								left join u_startplace as s on s.id=ls.startplace_id
								left join u_expert as e on e.id=l.recommend_expert  WHERE '.$where .$sql_page;	
		//$sql_str = "select l.id as lineid,l.linename as line_name,l.mainpic,l.shownum,l.collectnum,l.bookcount,l.satisfyscore,l.lineprice,ld.dest_id  from u_line as l left join u_line_dest as ld on(l.id = ld.line_id ".$where1." )  where ".$where." order by l.id desc {$sql_page} ";
		//$sql_str = 'select l.id as lineid,l.linename as line_name,l.mainpic,l.shownum,l.collectnum,l.bookcount,l.satisfyscore,l.lineprice,d.id as dest_id from u_line l LEFT JOIN u_dest_cfg d ON FIND_IN_SET(d.id,l.overcity) where '.$where .$sql_page;
		$live_room_chat_data = $this->db->query($sql_str)->result_array();
		if(!empty($live_room_chat_data)){
			foreach($live_room_chat_data as $k=> $v){
				$live_room_chat_data[$k]['satisfyscore'] = intval($v['satisfyscore']);			
			}
		}		
		if(!empty($live_room_chat_data)){
			$returnData = array();	
			$returnData['info'] = $live_room_chat_data;		
			$this->__outlivemsg($returnData);			
		}else{
			$returnData = array();	
			$this->__outlivemsg($returnData,"无数据",'4001');				
		}

    }	

    /**
     * 根据定位目的地选择关联线路数据
     */
    public function get_line_by_destid() {
        $destid = $this->input->get_post('destid', true); //目的地id
        $keyworld = $this->input->get_post('keyworld', true); //关键字
        $page = intval($this->input->post('page', true)); //翻页		
        $page = empty($page) ? 1 : $page;	
        $page_size = 20;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from
        $sql_page = " LIMIT {$from},{$page_size}";	
		$where = 'l.line_status=1 and l.status=2  and l.producttype = 0 and l.line_kind = 1 ';
		if($destid){
			$where .= ' and d.id='.$destid .' ';
		}
		if($keyworld){
			$where .= ' and l.linename like"%'.$keyworld.'%"';
		}
		//$sql_str = "select l.id as lineid,l.linename as line_name,l.mainpic,l.shownum,l.collectnum,l.bookcount,l.satisfyscore,l.lineprice,ld.dest_id  from u_line as l left join u_line_dest as ld on(l.id = ld.line_id ".$where1." )  where ".$where." order by l.id desc {$sql_page} ";
		$sql_str = 'select l.id as lineid,l.linename as line_name,l.mainpic,l.shownum,l.collectnum,l.bookcount,l.satisfyscore,l.lineprice,d.id as dest_id from u_line l LEFT JOIN u_dest_cfg d ON FIND_IN_SET(d.id,l.overcity) where '.$where .$sql_page;
		$live_room_chat_data = $this->db->query($sql_str)->result_array();
		if(!empty($live_room_chat_data)){
			foreach($live_room_chat_data as $k=> $v){
				$live_room_chat_data[$k]['satisfyscore'] = intval($v['satisfyscore']);			
			}
		}		
		if(!empty($live_room_chat_data)){
			$returnData = array();	
			$returnData['info'] = $live_room_chat_data;		
			$this->__outlivemsg($returnData);			
		}else{
			$returnData = array();	
			$this->__outlivemsg($returnData,"无数据",'4001');				
		}

    }
	
    /**
     * 根据定位目的地选择关联线路数据
     */
    public function get_line_by_videoid() {
        $videoid = intval($this->input->get_post('videoid', true)); //视频id
		if(empty($videoid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}		
		$sql_str = "select * from live_video where id=".$videoid." ";
		$live_video_data = $this->live_db->query($sql_str)->row_array();
		if(empty($live_video_data)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"视频不存在!",'3021');			
		}		
		$destid = $live_video_data['dest_id'];
		$line_ids = trim($live_video_data['line_ids'],',');		
        $sql_page = " LIMIT 5";	
		$where = 'l.line_status=1 and l.status=2  and l.producttype = 0 and l.line_kind = 1 ';
		if($destid){
			$where .= ' and d.id in('.$destid .') ';
		}
		$sql_str = 'select l.id as lineid,l.linename as line_name,l.mainpic,l.shownum,l.collectnum,l.bookcount,l.satisfyscore,l.lineprice,d.id as dest_id from u_line l LEFT JOIN u_dest_cfg d ON FIND_IN_SET(d.id,l.overcity) where '.$where .' order by l.bookcount desc '.$sql_page;
		$live_room_chat_data = $this->db->query($sql_str)->result_array();
		if(!empty($live_room_chat_data)){
			foreach($live_room_chat_data as $k=> $v){
				$live_room_chat_data[$k]['satisfyscore'] = intval($v['satisfyscore']);			
			}
		}
		$line_data = array();
		if($line_ids){
			$sql_str = 'select l.id as lineid,l.linename as line_name,l.mainpic,l.shownum,l.collectnum,l.bookcount,l.satisfyscore,l.lineprice,d.id as dest_id from u_line l LEFT JOIN u_dest_cfg d ON FIND_IN_SET(d.id,l.overcity) where l.line_status=1 and l.status=2  and l.producttype = 0 and l.line_kind = 1 and l.id in('.$line_ids .') ';
			$line_data = $this->db->query($sql_str)->result_array();
			if(!empty($line_data)){
				foreach($line_data as $k=> $v){
					$line_data[$k]['satisfyscore'] = intval($v['satisfyscore']);			
				}
			}			
		}
		if(!empty($live_room_chat_data)|| !empty($line_data)){
			$returnData = array();	
			$returnData['tuiline'] = $live_room_chat_data;
			$returnData['line'] = $line_data;			
			$this->__outlivemsg($returnData);			
		}else{
			$returnData = array();	
			$this->__outlivemsg($returnData,"无数据",'4001');				
		}

    }	
	
	

    /**
     * 获取滚动评论区数据
     */
    public function get_current_room_chat() {
        $roomid = intval($this->input->get_post('roomid', true)); //直播房间id	
		if(empty($roomid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}		
        $currenttime = intval($this->input->get_post('currenttime', true)); //用户进入房间的当时时间，根据这个时间来判断还没有加载的聊天记录
        if(empty($currenttime)) $currenttime = time();
		$sql_str = "select nickname,user_id,content,addtime from live_room_chat where room_id=".$roomid."  and addtime>'".date("Y-m-d H:i:s",$currenttime)."' limit 20 ";
		$live_room_chat_data = $this->live_db->query($sql_str)->result_array();
		$anchor_ids = array();
		if(!empty($live_room_chat_data)){
			foreach ($live_room_chat_data as $key => $value) {
				$sortfiled[$key] = $value['addtime'];//根据addtime字段排序
				$anchor_ids[$value['user_id']] = $value['user_id'];
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
		
		$live_anchor_ids_data = array();		
		if(!empty($anchor_ids)){ 
			$sql_str = "select anchor_id,user_id,name,nickname,user_type,video_pic,sex,photo,type from live_anchor where anchor_id in(".trim(implode(",",$anchor_ids),',').") ";
			$live_anchor_data = $this->live_db->query($sql_str)->result_array();
			foreach($live_anchor_data as $v){
				$live_anchor_ids_data[$v['anchor_id']] = $v;
			}			
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
				if(isset($live_anchor_ids_data[$v['user_id']])){								
					$live_room_chat_data[$k]['anchor_avatar'] = trim(base_url(''),'/').$live_anchor_ids_data[$v['user_id']]['photo'];
					$live_room_chat_data[$k]['anchor_name'] = $live_anchor_ids_data[$v['user_id']]['name'];
					$live_room_chat_data[$k]['anchor_nickname'] = $live_anchor_ids_data[$v['user_id']]['nickname'];					
					$live_room_chat_data[$k]['anchor_sex'] = $live_anchor_ids_data[$v['user_id']]['sex'];
					$live_room_chat_data[$k]['anchor_type'] = $live_anchor_ids_data[$v['user_id']]['type'];		
				}				
			}
			if(!empty($giftids)){
				$sql_str = "select gift_id,gift_name,pic,worth,unit,style from live_gift where gift_id in(". implode(",",$giftids).")";
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
				$live_room_chat_data[$k]['worth'] = $live_gift_data_byid[$v]['worth'];				
				$live_room_chat_data[$k]['unit'] = $live_gift_data_byid[$v]['unit'];
				$live_room_chat_data[$k]['style'] = $live_gift_data_byid[$v]['style'];
				$live_room_chat_data[$k]['gift_num'] = 1;
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
     */
    public function get_current_giving_gifts() {
        $roomid = $this->input->post('roomid', true); //直播房间id
		if(empty($roomid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}		
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
				$return_gift_record[$key]['icon']=trim(base_url(''),'/').$live_gift_data_byid[$value['gift_id']]['pic'];			
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
     */
    public function send_room_chat_info() {	
		if(empty($this->user_id)){//用户没有登录
			$returnData = array();	
			$this->__outlivemsg($returnData,'您还没有登录','1001');				
		}
        $content = $this->input->post('content', true); //聊天内容		
		if(mb_strlen($content,'utf8')>20 || mb_strlen($content,'utf8')<1){
			$returnData = array();	
			$this->__outlivemsg($returnData,'聊天内容至少1个文字，最多20个文字','2002');				
		}
		$live_anchor_data =  $this->live_anchor_info;		
		$anchor_id = $live_anchor_data['anchor_id'];		
		$nowtime = time();
		$sql_str = "select addtime from live_room_chat where user_id=".$anchor_id." order by id desc ";
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
			"user_id" 		=>$anchor_id,
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
     */
    public function send_video_comment_info() {
		if(empty($this->user_id)){//用户没有登录
			$returnData = array();	
			$this->__outlivemsg($returnData,'您还没有登录','1001');				
		}
		$live_anchor_data =  $this->live_anchor_info;		
		$anchor_id = $live_anchor_data['anchor_id'];		
		
        $content = $this->input->post('content', true); //聊天内容
		if(mb_strlen($content,'utf8')>100 || mb_strlen($content,'utf8')<1){
			$returnData = array();	
			$this->__outlivemsg($returnData,'聊天内容至少1个文字，最多100个文字','2002');				
		}
		$nowtime = time();
		$sql_str = "select addtime from live_video_comment where user_id=".$anchor_id." order by id desc ";
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
			"user_id" 		=>$anchor_id,
			"nickname"	=>$this->user_info['nickname'],
			"content"	=>$content,
			"addtime"	 	=>date("Y-m-d H:i:s"),						
		);
		$this->live_db->insert('live_video_comment', $insert_data);		
        $returnData = array('info'=>$insert_data);
        $this->__outlivemsg($returnData);
    }	
	
	
    /**
     * 获取视频评论数据
     */
    public function get_video_comment_list() {
        $videoid = intval($this->input->get_post('videoid', true)); //直播房间id
        $nocomid = $this->input->get_post('nocomid', true); //不用查询的评论id,多个用逗号隔开	
        $page = intval($this->input->get_post('page', true)); //翻页		
		if(empty($videoid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}
		$tuinum = 5;//推荐数,参与分页
        $page = empty($page) ? 1 : $page;	
		$page_size = 10;  //每页显示记录数
		$from = ($page - 1) * $page_size; //from
		$sql_page = " LIMIT {$from},{$page_size}";		
		$tui_live_video_comment_data = array();
		$live_video_comment_data = array();
		if($page==1){
			$sql_str = "select * from live_video_comment where video_id=".$videoid."  order by like_num desc,id desc limit {$tuinum} ";
			$tui_live_video_comment_data = $this->live_db->query($sql_str)->result_array();
			if(empty($tui_live_video_comment_data)){
				$returnData = array();	
				$this->__outlivemsg($returnData,"无数据",'4001');				
			}
			$tui_count = count($tui_live_video_comment_data);
			if($tui_count==$tuinum){
				$comment_ids = array();
				foreach($tui_live_video_comment_data as $k => $v){
					$comment_ids[$v['id']]= $v['id'];
				}
				$where = '';
				if(!empty($comment_ids)){
					$where = " and id not in(".implode(",",$comment_ids).")";
					$nocomid = implode(",",$comment_ids);
				}				
				$page_size = $page_size -$tuinum;
				$sql_page = " LIMIT {$from},{$page_size}";
				$sql_str = "select * from live_video_comment where video_id=".$videoid." ".$where." order by id desc {$sql_page} ";
				$live_video_comment_data = $this->live_db->query($sql_str)->result_array();	
				$live_video_comment_data = array_merge($tui_live_video_comment_data,$live_video_comment_data);
			}else{
				$live_video_comment_data = $tui_live_video_comment_data;
			}
		}else{
			$nocom_ids='';
			if(!empty($nocomid) ){
				$lineid_arr = explode(",",$nocomid);
				if(!empty($lineid_arr)){
					foreach($lineid_arr as $k=>$v){
						$v = trim($v);
						if(empty($v) || !is_numeric($v) ){
							unset($lineid_arr[$k]);						
						}						
					}					
				}
				if(!empty($lineid_arr)){			
					$nocom_ids=implode(",",$lineid_arr);
				}
			}
			$where = '';
			if(!empty($nocom_ids)){
				$where = " and id not in(".$nocom_ids.")";
				$from = (($page - 1) * $page_size)-$tuinum; //from
				$sql_page = " LIMIT {$from},{$page_size}";					
			}	
			$sql_str = "select * from live_video_comment where video_id=".$videoid.$where." order by id desc {$sql_page} ";
			$live_video_comment_data = $this->live_db->query($sql_str)->result_array();			
		}
		if(empty($live_video_comment_data)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"无数据",'4001');				
		}		
		if(!empty($live_video_comment_data)){
			$this->load->library ( 'SensitiveWordFilter/SensitiveWordFilter' );//过滤敏感词
			$user_ids = array();
			$user_photo = array();
			$comment_ids = array();
			$comment_likes = array();
			foreach($live_video_comment_data as $k => $v){
				$user_ids[$v['user_id']]= $v['user_id'];
				$comment_ids[$v['id']]= $v['id'];
			}
			if(!empty($user_ids)){
				$sql = 'SELECT anchor_id,photo FROM live_anchor WHERE anchor_id in('.implode(',',$user_ids).')';
				$live_anchor =  $this->live_db->query($sql )->result_array();	
				foreach($live_anchor as $v){
					$user_photo[$v['anchor_id']]= trim(base_url(''),'/').$v['photo'];
				}			
			}
			if(!empty($comment_ids) && !empty($this->user_id)){
				$sql = "select * from live_anchor_like where anchor_id=".$this->live_anchor_info['anchor_id'].' and like_id in('.implode(',',$comment_ids).') and like_type=3 and status=1 ';
				$live_anchor_like =  $this->live_db->query($sql )->result_array();	
				foreach($live_anchor_like as $v){
					$comment_likes[$v['like_id']] = 1;//表示点赞			
				}			
			}			
			foreach($live_video_comment_data as $k => $v){
				isset($user_photo[$v['user_id']])?$live_video_comment_data[$k]['photo'] = $user_photo[$v['user_id']]:$live_video_comment_data[$k]['photo'] = '';
				$live_video_comment_data[$k]['content'] = $this->sensitivewordfilter->delFilterSign($v['content']);//过滤敏感词	
				if(isset($comment_likes[$v['id']])){
					$live_video_comment_data[$k]['islike'] = 1;
				}else{
					$live_video_comment_data[$k]['islike'] = 0;
				}	
			}			
		}
		$sql_str = "select count(id) as num from live_video_comment where video_id=".$videoid." ";
		$live_video_comment_count_data = $this->live_db->query($sql_str)->row_array();		
		$count = 0;
		if(!empty($live_video_comment_count_data)){$count = $live_video_comment_count_data['num'];} 
        $returnData = array();
		$returnData['info'] = $live_video_comment_data;
		$returnData['nocomid'] = $nocomid;		
		$returnData['count'] = $count;		
        $this->__outlivemsg($returnData);
    }	
	
	
    /**
     * 获取直播信息数据
     */
    public function get_room_infos() {
        $roomid = intval($this->input->post('roomid', true)); //直播房间id
        $cityid = intval($this->input->get_post('cityid', true)); //开始城市id		
		if(empty($roomid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}	
		$userid = 0;
		if(!empty($this->user_id)){	
			$userid = $this->user_id;
		}		
        $returnData = array();			
		$sql_str = "select peoples,starttime,umoney,room_name,pic,anchor_id,createtime,room_code,audience_password,roomid,line_ids,room_dest_id,room_dest,attr_id,type from live_room where room_id=".$roomid." ";
		$live_room_data = $this->live_db->query($sql_str)->row_array();	
		$returnData['anchor'] = array();
		$returnData['room'] = array();		
		$returnData['fans'] = 0;//表示未关注
		$returnData['like'] = 0;//表示未点赞		
		$this->live_db->query("update live_room set `peoples`=peoples+1 where room_id = ".$roomid."");	
		$live_anchor_data = array();	
		if(isset($live_room_data['anchor_id']) && $live_room_data['anchor_id']>0){
			$sql = 'SELECT * FROM live_anchor WHERE anchor_id= '.$live_room_data['anchor_id'];
			$live_anchor_data =  $this->live_db->query($sql)->row_array();	
			$returnData['anchor'] = array(
				'anchorid'=>$live_anchor_data['anchor_id'],
				'name'=>$live_anchor_data['name'],
				'photo'=>trim(base_url(''),'/').$live_anchor_data['photo'],
				'type'=>$live_anchor_data['user_type'],	
				'userid'=>$live_anchor_data['user_id'],					
			);
		}
		if(!empty($live_room_data)){
			$usetime = $this->room_timeout;
			if($this->user_type==1){//判断是管家
				$usetime = 0;
			}
			
/*				

			$share_name ='与世界同步，这个直播太好玩了';	
			$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
			$share_content ='【'.$live_room_data['room_name'].'】，正在直播中';				

*/				

			if($userid && $this->live_anchor_info['user_type']==1){//判断是否为管家身份
				if($live_room_data['attr_id']==6){//服务直播
					$share_name ='新年大吉，万事如意，管家'.$live_anchor_data['name'].'正直播...';	
					$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
					$share_content ='帮游1+1，完美旅程需要设计';
				}else{
					$share_name ='了解您的旅游，咨询我/'.$live_anchor_data['name'].'正为您直播【祝您新年发发发】';	
					$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
					$share_content ='帮游1+1，帮你打造完美旅游体验';						
				}					
			}else{
				if($live_room_data['attr_id']==6){//服务直播
					//$share_name =''.$live_anchor_data['name'].'祝您新年大吉，万事如意，正直播【'.$live_room_data['room_name'].'】';
					$share_name ='新年大吉，万事如意，管家'.$live_anchor_data['name'].'正直播...';					
					$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
					$share_content ='帮游1+1，完美旅程需要设计';						
				}else{
					$share_name ='新的一年与世界同步，分享一个好玩的直播给您拜年啦';	
					$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
					$share_content ='达人正在'.$live_room_data['room_dest'].'直播，不看后悔……';						
				}							
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
				"lineids"=>$live_room_data['line_ids'],
				"destid"=>$live_room_data['room_dest_id'],
				"destname"=>$live_room_data['room_dest'],
				"like_num"=>$live_room_data['like_num'],				
				//"share_url"=>$this->share_url.'room_share/?roomid='.$roomid.'&userid='.$userid,
				"share_url"=>$this->share_url.'room_share/?roomid='.$roomid,				
				"share_name"=>$share_name,	
				//"share_pic"=>trim(base_url(''),'/').$live_room_data['pic'],
				"share_pic"=>$share_pic,
				"share_content"=>$share_content,					
			);


			//关联线路
			$lineId = trim($live_room_data['line_ids'],',');
			$lineid_arr1 = explode(",",$lineId);
			$lineid_arr = array();
			if(!empty($lineid_arr1)){
				foreach($lineid_arr1 as $v){
					if($v){
						$lineid_arr[trim($v,'L')] = trim($v,'L');
					}
				}					
			}			
			if(!empty($lineid_arr)){
				$tstr = '';
				if($cityid){
					$tstr = ' and u.id='.$cityid.' ';
				}				
				$sql= "SELECT distinct
								a.id,a.mainpic,a.linename,a.linetitle,ud.kindname as overcity_name,
								u.cityname AS startplace
					  FROM
								u_line as a
								left join u_line_startplace as ls on a.id=ls.line_id
								LEFT JOIN u_startplace as u  on ls.startplace_id=u.id
								left join u_dest_cfg as ud on (FIND_IN_SET(ud.id,a.overcity2) >0)
					  WHERE
								a.id in(".implode(",",$lineid_arr).") ".$tstr." and a.line_status=1 and a.status=2  and a.producttype = 0 and a.line_kind = 1 group by a.id";					
				$returnData['line']=$this->db->query($sql)->result_array(); //线路基本信息+目的地城市+出发城市					
			}else{
				$returnData['line'] = array();
			}
			$destid = $live_room_data['room_dest_id'];
			$tuiline= array();
			$where = '';
			if($destid){
				$where = ' and d.id in('.$destid .')';
				$sql_str = 'select distinct l.id as lineid,l.linename as line_name,l.mainpic,l.shownum,l.collectnum,l.bookcount,l.satisfyscore,l.lineprice,d.id as dest_id from u_line l LEFT JOIN u_dest_cfg d ON FIND_IN_SET(d.id,l.overcity) where l.line_status=1 and l.status=2  and l.producttype = 0 and l.line_kind = 1 '.$where .'  group by l.id order by l.bookcount desc LIMIT 5 ';
				$tuiline = $this->db->query($sql_str)->result_array();				
			}	
			$tui_count = count($tuiline);
			if($tui_count<5){
				$sql_str = 'select distinct l.id as lineid,l.linename as line_name,l.mainpic,l.shownum,l.collectnum,l.bookcount,l.satisfyscore,l.lineprice,d.id as dest_id from u_line l LEFT JOIN u_dest_cfg d ON FIND_IN_SET(d.id,l.overcity) where l.line_status=1 and l.status=2  and l.producttype = 0 and l.line_kind = 1  group by l.id  order by l.bookcount desc  LIMIT '.(5-$tui_count);
				$tuiline_1 = $this->db->query($sql_str)->result_array();
				foreach($tuiline_1 as $k=> $v){
					$tuiline[]=$v;			
				}					
			}	
			if(!empty($tuiline)){
				foreach($tuiline as $k=> $v){
					$tuiline[$k]['satisfyscore'] = intval($v['satisfyscore']);			
				}
				$returnData['tuiline'] = $tuiline;
			}else{
				$returnData['tuiline'] = array();
			}			
		}

		if(!empty($this->user_id)){//普通用户登录检查是否关注主播
			if(  $live_room_data['anchor_id'] && $live_room_data['anchor_id'] != $this->live_anchor_info['anchor_id'] ){//不是自己，且是主播
				$sql_str = "select id,status from live_anchor_fans where anchor_id=".$live_room_data['anchor_id']." and user_id=".$this->live_anchor_info['anchor_id'].' limit 1';
				$live_anchor_fans_data = $this->live_db->query($sql_str)->row_array();
				if(!empty($live_anchor_fans_data) && $live_anchor_fans_data['status']==1){
					$returnData['fans'] = 1;//表示关注
				}
				$sql_str = "select * from live_anchor_like where anchor_id=".$this->live_anchor_info['anchor_id']." and like_id=".$roomid.' and like_type=4';
				$live_anchor_like_data = $this->live_db->query($sql_str)->row_array();//点赞类型,1主播点赞,2视频点赞，3评论点赞	,4直播点赞				
				if(!empty($live_anchor_like_data) && $live_anchor_like_data['status']==1){
					$returnData['like'] = 1;//表示点赞
				}
				
			}			
		}		
        $this->__outlivemsg($returnData);
    }

	
    /**
     * 获取视频信息数据
     */
    public function get_video_infos() {
        $videoid = intval($this->input->get_post('videoid', true)); //直播房间id
        $cityid = intval($this->input->get_post('cityid', true)); //开始城市id		
		if(empty($videoid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}		
        $returnData = array();			
		$sql_str = "select * from live_video where id=".$videoid." ";
		$live_video_data = $this->live_db->query($sql_str)->row_array();
		$returnData['anchor'] = array();
        $returnData['video'] = array();
		$returnData['fans'] = 0;//表示未关注	
		$returnData['attention'] = 0;//关注数
		$returnData['isme'] = 0;//表示不是自己的主播
		$returnData['like'] = 0;//表示未点赞
		$userid = 0;
		if(!empty($this->user_id)){	
			$userid = $this->user_id;
		}
		$live_anchor_data = array();	
		if(!empty($live_video_data)){
			if($live_video_data['anchor_id']){
				$sql = 'SELECT * FROM live_anchor WHERE anchor_id= '.$live_video_data['anchor_id'];
				$live_anchor_data =  $this->live_db->query($sql)->row_array();	
				$returnData['anchor'] = array(
					'anchorid'=>$live_anchor_data['anchor_id'],
					'name'=>$live_anchor_data['name'],
					'photo'=>trim(base_url(''),'/').$live_anchor_data['photo'],
					'type'=>$live_anchor_data['user_type'],
					'userid'=>$live_anchor_data['user_id'],					
				);
				$sql_str = "select count(id)as num from live_anchor_fans where status=1 and anchor_id=".$live_video_data['anchor_id'];
				$live_anchor_fans_data = $this->live_db->query($sql_str)->row_array();			
				if(!empty($live_anchor_fans_data)){
					$returnData['attention'] = $live_anchor_fans_data['num'];				
				}				
			}
			$attr_id = array();	
			$attr_id[$live_video_data['attr_id']] = $live_video_data['attr_id'];
			//获取标签
			$attrname = '';
			if(!empty($attr_id)){
				$sql_str = "select dict_id as categoryid,description as categoryname from live_dictionary where dict_id in(".implode(",",$attr_id).") ";
				$category_live_dictionary_data = $this->live_db->query($sql_str)->row_array();
				$attrname = $category_live_dictionary_data['categoryname'];				
			}
			/*
			if($live_video_data['type']==1){//直播视频
				$share_name ='与世界同步，这个直播太好玩了';	
				$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
				$share_content ='【'.$live_video_data['name'].'】，正在直播中';				
			}else{
				$share_name ='这个视频碉堡了，快戳进来';	
				$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
				$share_content ='视频详情+更多有趣小视频，尽在这里！';					
			}
			*/
			
			if($userid && $this->live_anchor_info['user_type']==1){//判断是否为管家身份
				if($live_video_data['type']==1){//直播视频
					if($live_video_data['attr_id']==6){//服务直播
						//$share_name =''.$live_anchor_data['name'].'祝您新年大吉，万事如意，正直播【'.$live_video_data['name'].'】';	
						$share_name ='新年大吉，万事如意，管家'.$live_anchor_data['name'].'正直播...';
						$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
						$share_content ='帮游1+1，完美旅程需要设计';
					}else{
						$share_name ='了解您的旅游，咨询我/'.$live_anchor_data['name'].'正为您直播【祝您新年发发发】';	
						$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
						$share_content ='帮游1+1，帮你打造完美旅游体验';						
					}				
				}else{
					$share_name ='快看我用这个有趣的视频给您拜年啦，戳进来';	
					$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
					$share_content ='更多你没看过的，尽在这里！';					
				}						
			}else{
				if($live_video_data['type']==1){//直播视频
					if($live_video_data['attr_id']==6){//服务直播
						//$share_name =''.$live_anchor_data['name'].'祝您新年大吉，万事如意，正直播【'.$live_video_data['name'].'】';	
						$share_name ='新年大吉，万事如意，管家'.$live_anchor_data['name'].'正直播...';
						$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
						$share_content ='帮游1+1，完美旅程需要设计';						
					}else{
						$share_name ='新的一年与世界同步，分享一个好玩的直播给您拜年啦';	
						$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
						$share_content ='达人正在'.$live_video_data['dest_name'].'直播，不看后悔……';						
					}				
				}else{
					$share_name ='快看我用这个有趣的视频给您拜年啦，戳进来';	
					$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
					$share_content ='更多你没看过的，尽在这里！';					
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
				"dest_name"=>$live_video_data['dest_name'],
				"dest_id"=>$live_video_data['dest_id'],
				'attrname' => $attrname,
				"videoheight"=>$live_video_data['video_height'],
				"videowidth"=>$live_video_data['video_width'],
				"screenpic"=>$live_video_data['screen_pic'],
				"like_num"=>$live_video_data['like_num'],				
				"share_url"=>$this->share_url.'video_share/?videoid='.$videoid.'&userid='.$userid.'&cityid='.$cityid,
				"share_name"=>$share_name,	
				//"share_pic"=>trim(base_url(''),'/').$live_video_data['pic'],
				"share_pic"=>$share_pic,
				"share_content"=>$share_content,					
			);
			//关联线路
			$lineId = trim($live_video_data['line_ids'],',');
			$lineid_arr1 = explode(",",$lineId);
			$lineid_arr = array();
			if(!empty($lineid_arr1)){
				foreach($lineid_arr1 as $v){
					if($v){
						$lineid_arr[trim($v,'L')] = trim($v,'L');
					}
				}					
			}			
			if(!empty($lineid_arr)){
				$tstr = '';
				if($cityid){
					$tstr = ' and u.id='.$cityid.' ';
				}
				$sql= "SELECT distinct
								a.id,a.mainpic,a.linename,a.linetitle,ud.kindname as overcity_name,
								u.cityname AS startplace
					  FROM
								u_line as a
								left join u_line_startplace as ls on a.id=ls.line_id
								LEFT JOIN u_startplace as u  on ls.startplace_id=u.id
								left join u_dest_cfg as ud on (FIND_IN_SET(ud.id,a.overcity2) >0)
					  WHERE
								a.id in(".implode(",",$lineid_arr).") ".$tstr." and a.line_status=1 and a.status=2  and a.producttype = 0 and a.line_kind = 1 group by a.id";		
				/*
				$sql="
					  SELECT
								a.id,a.mainpic,a.linename,a.linetitle,(select GROUP_CONCAT(kindname) from u_dest_cfg where FIND_IN_SET(id,a.overcity2) >0 )as overcity_name,
								GROUP_CONCAT(u.cityname)AS startplace
					  FROM
								u_line as a
								left join u_line_startplace as ls on a.id=ls.line_id
								LEFT JOIN u_startplace as u  on ls.startplace_id=u.id
					  WHERE
								a.id in(".implode(",",$lineid_arr).")";
				*/				
				$returnData['line']=$this->db->query($sql)->result_array(); //线路基本信息+目的地城市+出发城市					
			}else{
				$returnData['line'] = array();
			}
			$destid = $live_video_data['dest_id'];
			$tuiline= array();
			$where = '';
			if($destid){
				$where = ' and d.id in('.$destid .')';
				$sql_str = 'select distinct l.id as lineid,l.linename as line_name,l.mainpic,l.shownum,l.collectnum,l.bookcount,l.satisfyscore,l.lineprice,d.id as dest_id from u_line l LEFT JOIN u_dest_cfg d ON FIND_IN_SET(d.id,l.overcity) where l.line_status=1 and l.status=2  and l.producttype = 0 and l.line_kind = 1 '.$where .'  group by l.id order by l.bookcount desc LIMIT 5 ';
				$tuiline = $this->db->query($sql_str)->result_array();				
			}	
			$tui_count = count($tuiline);
			if($tui_count<5){
				$sql_str = 'select distinct l.id as lineid,l.linename as line_name,l.mainpic,l.shownum,l.collectnum,l.bookcount,l.satisfyscore,l.lineprice,d.id as dest_id from u_line l LEFT JOIN u_dest_cfg d ON FIND_IN_SET(d.id,l.overcity) where l.line_status=1 and l.status=2  and l.producttype = 0 and l.line_kind = 1  group by l.id  order by l.bookcount desc  LIMIT '.(5-$tui_count);
				$tuiline_1 = $this->db->query($sql_str)->result_array();
				foreach($tuiline_1 as $k=> $v){
					$tuiline[]=$v;			
				}					
			}	
			if(!empty($tuiline)){
				foreach($tuiline as $k=> $v){
					$tuiline[$k]['satisfyscore'] = intval($v['satisfyscore']);			
				}
				$returnData['tuiline'] = $tuiline;
			}else{
				$returnData['tuiline'] = array();
			}
			if(!empty($this->user_id)){//普通用户登录检查是否关注主播
				if(  $live_anchor_data['anchor_id'] && $live_anchor_data['anchor_id'] != $this->live_anchor_info['anchor_id'] ){//不是自己，且是主播
					$sql_str = "select id,status from live_anchor_fans where anchor_id=".$live_anchor_data['anchor_id']." and user_id=".$this->live_anchor_info['anchor_id'].' limit 1';
					$live_anchor_fans_data = $this->live_db->query($sql_str)->row_array();
					if(!empty($live_anchor_fans_data) && $live_anchor_fans_data['status']==1){
						$returnData['fans'] = 1;//表示关注
					}
					$sql_str = "select * from live_anchor_like where anchor_id=".$this->live_anchor_info['anchor_id']." and like_id=".$videoid.' and like_type=2';
					$live_anchor_like_data = $this->live_db->query($sql_str)->row_array();//点赞类型,1主播点赞,2视频点赞，3评论点赞	,4直播点赞				
					if(!empty($live_anchor_like_data) && $live_anchor_like_data['status']==1){
						$returnData['like'] = 1;//表示点赞
					}					
				}else if($live_anchor_data['anchor_id'] && $live_anchor_data['anchor_id'] == $this->live_anchor_info['anchor_id'] ){
					$returnData['isme'] = 1;//表示是自己的主播
				}			
			}			
		}
        $this->__outlivemsg($returnData);
    }	
	
	
	//视频分享接口
	public function video_share() {
        $videoid = intval($this->input->get('videoid', true)); //视频id
        $userid = intval ( $this->input->get ( 'userid', true ) );	 //推荐人id	
        $cityid = intval($this->input->get_post('cityid', true)); //开始城市id			
		$sql_str = "select * from live_video where id=".$videoid." ";
		$live_video_data_one = $this->live_db->query($sql_str)->row_array();
		$nowtime = time();		
		if(empty($live_video_data_one)){
			$returnData = array();	
			//$this->__outlivemsg($returnData,"房间不存在",'2002');				
		}
		$this->live_db->query("update live_video set `people`=people+1 where id = ".$videoid."");
		$u_expert_info = array();	
		if($userid){//判断是管家
			$sql = 'SELECT * FROM u_expert WHERE id= '.$userid;
			$u_expert_info =  $this->db->query($sql )->row_array();					
		}		
		$anchorid = $live_video_data_one['anchor_id'];
		$sql = 'SELECT * FROM live_anchor WHERE anchor_id= '.$anchorid;
		$live_anchor_data =  $this->live_db->query($sql)->row_array();		
		
		$nowtime = time();
        $sql_page = " LIMIT 4";
		$sql_str = '(select anchor_id,room_id,0 as video_id, room_name as name,0 as read_num,peoples as watching_num,pic as cover,starttime as addtime,peoples as peopleby,3 as type,room_dest as dest_name,room_dest_id as dest_id,1 as isroom,status,sort,like_num,attr_id from live_room  where live_status=1 and status in(1,2)  and  createtime>'.($nowtime - $this->room_timeout).' limit 4 )union (select anchor_id,room_id,id as video_id,name,people as read_num,0 as watching_num,pic as cover,addtime,people as peopleby,type,dest_name,dest_id,0 as isroom,status,sort,like_num,attr_id from live_video where video<>"" and status in(1,3)  limit 4  ) order by isroom desc,status desc,sort desc,watching_num desc,peopleby desc,addtime desc '.$sql_page;
		$live_room_data = $this->live_db->query($sql_str)->result_array();			
		$num_live_room_data = count($live_room_data);

		if($num_live_room_data>0){
			$anchor_ids = array();
			$attr_id = array();
			if(!empty($live_room_data)){
				foreach($live_room_data as $v){
					$anchor_ids[$v['anchor_id']] = $v['anchor_id'];
					$attr_id[$v['attr_id']] = $v['attr_id'];
				}
			}	

			//获取标签
			$category_live_dictionary_data = array();
			if(!empty($attr_id)){
				$sql_str = "select dict_id as categoryid,description as categoryname from live_dictionary where dict_id in(".implode(",",$attr_id).") ";
				$category_live_dictionary_datas = $this->live_db->query($sql_str)->result_array();
				foreach($category_live_dictionary_datas as $v){
					$category_live_dictionary_data[$v['categoryid']]=$v['categoryname'];
				}	
			}	
			
			$live_anchor_ids_data = array();		
			if(!empty($anchor_ids)){ 
				$sql_str = "select anchor_id,user_id,name,user_type,video_pic,sex,photo,type from live_anchor where anchor_id in(".trim(implode(",",$anchor_ids),',').") ";
				$live_anchor_datas = $this->live_db->query($sql_str)->result_array();
				foreach($live_anchor_datas as $v){
					$live_anchor_ids_data[$v['anchor_id']] = $v;
				}			
			}			
			foreach($live_room_data as $k=> $v){
				if(empty($v['cover'])){
					$live_room_data[$k]['cover'] = $live_anchor_ids_data[$v['anchor_id']]['video_pic'];					
				}
				if(strpos($live_room_data[$k]['cover'],'http://')!==0){
					$live_room_data[$k]['cover'] = trim($this->web_url,'/').$live_room_data[$k]['cover'];							
				}
				$live_room_data[$k]['avatar'] = trim($this->web_url,'/').$live_anchor_ids_data[$v['anchor_id']]['photo'];
				$live_room_data[$k]['anchor_name'] = $live_anchor_ids_data[$v['anchor_id']]['name'];				
				$live_room_data[$k]['anchor_sex'] = $live_anchor_ids_data[$v['anchor_id']]['sex'];
				$live_room_data[$k]['anchor_type'] = $live_anchor_ids_data[$v['anchor_id']]['type'];
				$live_room_data[$k]['attrname'] = $category_live_dictionary_data[$v['attr_id']];				
				unset($live_room_data[$k]['addtime'],$live_room_data[$k]['peopleby']);
			}
		}
		
		//关联线路
		$lineId = trim($live_video_data_one['line_ids'],',');
		$lineid_arr1 = explode(",",$lineId);
		$lineid_arr = array();
		if(!empty($lineid_arr1)){
			foreach($lineid_arr1 as $v){
				if($v){
					$lineid_arr[trim($v,'L')] = trim($v,'L');
				}
			}					
		}
		$line = array();	
		if(!empty($lineid_arr)){
			$tstr = '';
			if($cityid){
				$tstr = ' and u.id='.$cityid.' ';
			}			
			$sql= "SELECT distinct
							a.id,a.mainpic,a.linename,a.linetitle,ud.kindname as overcity_name,
							u.cityname AS startplace
				  FROM
							u_line as a
							left join u_line_startplace as ls on a.id=ls.line_id
							LEFT JOIN u_startplace as u  on ls.startplace_id=u.id
							left join u_dest_cfg as ud on (FIND_IN_SET(ud.id,a.overcity2) >0)
				  WHERE
							a.id in(".implode(",",$lineid_arr).") ".$tstr." and a.line_status=1 and a.status=2  and a.producttype = 0 and a.line_kind = 1 group by a.id";						
			$line=$this->db->query($sql)->result_array(); //线路基本信息+目的地城市+出发城市					
		}	
		$destid = $live_video_data_one['dest_id'];
		$tuiline= array();
		$where = '';
		if($destid){
			$where = ' and d.id in('.$destid .')';
			$sql_str = 'select distinct l.id as lineid,l.linename as line_name,l.mainpic,l.shownum,l.collectnum,l.bookcount,l.satisfyscore,l.lineprice,d.id as dest_id from u_line l LEFT JOIN u_dest_cfg d ON FIND_IN_SET(d.id,l.overcity) where l.line_status=1 and l.status=2  and l.producttype = 0 and l.line_kind = 1 '.$where .'  group by l.id order by l.bookcount desc LIMIT 5 ';
			$tuiline = $this->db->query($sql_str)->result_array();				
		}	
		$tui_count = count($tuiline);
		if($tui_count<5){
			$sql_str = 'select distinct l.id as lineid,l.linename as line_name,l.mainpic,l.shownum,l.collectnum,l.bookcount,l.satisfyscore,l.lineprice,d.id as dest_id from u_line l LEFT JOIN u_dest_cfg d ON FIND_IN_SET(d.id,l.overcity) where l.line_status=1 and l.status=2  and l.producttype = 0 and l.line_kind = 1  group by l.id  order by l.bookcount desc  LIMIT '.(5-$tui_count);
			$tuiline_1 = $this->db->query($sql_str)->result_array();
			foreach($tuiline_1 as $k=> $v){
				$tuiline[]=$v;			
			}					
		}

		if(!empty($tuiline)){
			foreach($tuiline as $k=> $v){
				$tuiline[$k]['satisfyscore'] = intval($v['satisfyscore']);			
			}
		}
		
		
		if($userid && !empty($u_expert_info)){//判断是否为管家身份
			if($live_video_data_one['type']==1){//直播视频
				if($live_video_data_one['attr_id']==6){//服务直播
					//$share_name =''.$live_anchor_data['name'].'祝您新年大吉，万事如意，正直播【'.$live_video_data_one['name'].'】';	
					$share_name ='新年大吉，万事如意，管家'.$live_anchor_data['name'].'正直播...';
					$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
					$share_content ='帮游1+1，完美旅程需要设计';
				}else{
					$share_name ='了解您的旅游，咨询我/'.$live_anchor_data['name'].'正为您直播【祝您新年发发发】';	
					$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
					$share_content ='帮游1+1，帮你打造完美旅游体验';						
				}				
			}else{
				$share_name ='快看我用这个有趣的视频给您拜年啦，戳进来';	
				$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
				$share_content ='更多你没看过的，尽在这里！';					
			}						
		}else{
			if($live_video_data_one['type']==1){//直播视频
				if($live_video_data_one['attr_id']==6){//服务直播
					//$share_name =''.$live_anchor_data['name'].'祝您新年大吉，万事如意，正直播【'.$live_video_data_one['name'].'】';	
					$share_name ='新年大吉，万事如意，管家'.$live_anchor_data['name'].'正直播...';
					$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
					$share_content ='帮游1+1，完美旅程需要设计';						
				}else{
					$share_name ='新的一年与世界同步，分享一个好玩的直播给您拜年啦';	
					$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
					$share_content ='达人正在'.$live_video_data_one['dest_name'].'直播，不看后悔……';						
				}				
			}else{
				$share_name ='快看我用这个有趣的视频给您拜年啦，戳进来';	
				$share_pic ='http://www.1b1u.com/file/bijini_pic.jpg';
				$share_content ='更多你没看过的，尽在这里！';					
			}		
		}		
		
		//分享到朋友圈
		$signature=$this->wx_share();
		$returnData = array(
			'room_name'=>$live_video_data_one['name'],
			'peoples'=>$live_video_data_one['people'],
			'like_num'=>$live_video_data_one['like_num'],			
			'pic'=>trim($this->web_url,'/').$live_video_data_one['pic'],			
			'name'=>$live_anchor_data['name'],
			'comment'=>$live_anchor_data['comment'],
			'bg'=>$live_anchor_data['live_anchor'],
			'photo'=>trim($this->web_url,'/').$live_anchor_data['photo'],
			'video'=>$live_room_data,
			'videourl'=>$live_video_data_one['video'],
			'videotype'=>$live_video_data_one['type'],
			'videoattr_id'=>$live_video_data_one['attr_id'],			
			'signature'=>$signature,
			"dest_name"=>$live_video_data_one['dest_name'],
			"dest_id"=>$live_video_data_one['dest_id'],
			"line"=>$line,
			"tuiline"=>$tuiline,
			'web_url'=>$this->web_url,
			'chat_url'=>$this->chat_url,	
			'share_url'=>$this->share_url.'video_share/?videoid='.$videoid.'&userid='.$userid.'&cityid='.$cityid,
			"share_name"=>$share_name,	
			//"share_pic"=>trim(base_url(''),'/').$live_video_data['pic'],
			"share_pic"=>$share_pic,
			"share_content"=>$share_content,			
		);
		$returnData['u_expert_info'] = $u_expert_info;
		$returnData['userid']= $userid;		
        $this->__outlivemsg($returnData);
	}	
	

	
    /**
     * 获取直播房间的关注总数及打赏总数
     */
    public function get_room_umoney_fans() {
        $roomid = intval($this->input->post('roomid', true)); //直播房间id
		if(empty($roomid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}		
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
     */
    public function get_room_chat_list() {
        $roomid = intval($this->input->post('roomid', true)); //直播房间id
		if(empty($roomid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}		
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
     */
    public function go_into_room() {
        $roomid = intval($this->input->post('roomid', true)); //直播房间id
		if(empty($roomid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}		
		$this->anchor_verification();//检查是否为主播
		$live_anchor_data =  $this->live_anchor_info;
		$sql_str = "select createtime,status,type,live_status from live_room where room_id=".$roomid." and anchor_id=".$live_anchor_data['anchor_id'];
		$live_room_data = $this->live_db->query($sql_str)->row_array();	
		$nowtime = time();		
		if(empty($live_room_data)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"房间不存在",'2002');				
		}
		if( !(($live_room_data['status']==1 || $live_room_data['status']==2)  && ( in_array($live_room_data['live_status'],array(1,3)) || $live_room_data['createtime']>($nowtime - $this->room_timeout) ) )){//该房间已经过期
			$returnData = array();	
			$this->__outlivemsg($returnData,"该房间已经过期",'3003');						
		}		
		$this->live_db->query("update live_room set `live_status`=1,`starttime`={$nowtime} where room_id = ".$roomid."");		
        $returnData = array();
        $this->__outlivemsg($returnData);
    }

    /**
     * 直播过程中定时检测视频结束时间
     */
    public function check_room_sign_out_time() {
        $roomid = intval($this->input->post('roomid', true)); //直播房间id
		if(empty($roomid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}		
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
     */
    public function sign_out_room() {
        $roomid = intval($this->input->post('roomid', true)); //直播房间id
		if(empty($roomid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}		
		$this->anchor_verification();//检查是否为主播
		$live_anchor_data =  $this->live_anchor_info;
		$sql_str = "select createtime,status,type,live_status from live_room where room_id=".$roomid." and anchor_id=".$live_anchor_data['anchor_id'];
		$live_room_data = $this->live_db->query($sql_str)->row_array();	
		$nowtime = time();		
		if(empty($live_room_data)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"房间不存在",'2002');				
		}
		if( !(($live_room_data['status']==1 || $live_room_data['status']==2) && ( in_array($live_room_data['live_status'],array(1,3)) || $live_room_data['createtime']>($nowtime - $this->room_timeout) ) )){//该房间已经过期
			$returnData = array();	
			$this->__outlivemsg($returnData,"该房间已经过期",'3003');						
		}
		$this->live_db->query("update live_room set `live_status`=0,`endtime`={$nowtime} where room_id = ".$roomid."");	
        $returnData = array();
        $this->__outlivemsg($returnData);
    }

	
	
    /**
     * 使用房间直播来录制视频，任何用户都可以录制视频
     */
    public function create_video_room() {		
		if(empty($this->user_id)){//用户没有登录
			$returnData = array();	
			$this->__outlivemsg($returnData,'您还没有登录','1001');				
		}
        $categoryid = 0;//直播类型		
        $roomname = 'no'; //房间名称
        $cover = ' ';//视频封面		
        $destid = '0';//定位目的地	
        $lineid = '0';//关联线路		
		$room_dest = ' ';//开播所属目的地		
		$live_anchor_data =  $this->live_anchor_info;
		$nowtime = time();
		$room_id =0;//分配的房间id

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
				"live_status"=>2,
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
     * 使用房间直播来录制视频，修改直播内容
     */
    public function edit_video_room() {		
		if(empty($this->user_id)){//用户没有登录
			$returnData = array();	
			$this->__outlivemsg($returnData,'您还没有登录','1001');				
		}
        $room_id = intval($this->input->post('room_id', true)); //直播id	
        $categoryid = intval($this->input->post('categoryid', true)); //直播类型		
        $roomname = $this->input->post('roomname', true); //房间名称
        $cover = $this->input->post('cover', true); //视频封面		
        $destid = intval($this->input->post('destid', true)); //定位目的地	
        $destname = $this->input->post('destname', true); //定位目的地名			
        $lineid = $this->input->post('lineid', true); //关联线路
		
		if(empty($room_id)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"视频id错误!",'3019');			
		}
		$live_anchor_data =  $this->live_anchor_info;		
		$sql_str = "select room_id from live_room where room_id=".$room_id." and anchor_id=".$live_anchor_data['anchor_id'];
		$live_room_data = $this->live_db->query($sql_str)->row_array();	
		if(empty($live_room_data)){//自己只能修改自己的
			$returnData = array();	
			$this->__outlivemsg($returnData,"数据错误!",'3018');			
		}
		if(empty($categoryid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"请选择直播类型!",'3020');			
		}
		if(mb_strlen($roomname,'utf8')>30 || empty($roomname) ){
			$returnData = array();	
			$this->__outlivemsg($returnData,'视频名称不能为空且最多30个文字','3023');				
		}
			
		$room_dest = ' ';//开播所属目的地		
		if($destid){
			$arr = $this->db->query("select id,kindname from u_dest_cfg where id=" . $destid . "")->row_array();			
			if(!empty($arr)){
				$room_dest =$arr['kindname'];
			}else{
				$room_dest =$destname;
				/*
				$arr = $this->db->query("select id,name from u_area where id=" . $destid . "")->row_array();
				if(!empty($arr)){
					$room_dest =$arr['name'];
				}*/				
			}
		}else{
			$room_dest =$destname;
		}

		$data = array(
			"attr_id"=>$categoryid,
			"line_ids"=>$lineid,
			"room_name"=>$roomname,
			"pic"=>$cover,
			"room_dest_id"=>$destid,
			"room_dest"=>$room_dest,				
		);
	    //$status = $this->live_db->update_string('live_room', $data, array('room_id'=>$room_id));			
	    $status = $this->live_db->query("update live_room set `attr_id`='".$categoryid."',`line_ids`='".$lineid."',`room_name`='".$roomname."',`pic`='".$cover."',`room_dest_id`='".$destid."',`room_dest`='".$room_dest."' where room_id=".$room_id."");	
		if($status){//表示提交成功
			$returnData = array('video_id'=>$room_id);
			$this->__outlivemsg($returnData);			
		}else{//提交失败
			$returnData = array('room_id'=>0);	
			$this->__outlivemsg($returnData,'提交失败','3006');				
		}
    }	
	
	
	
    /**
     * 视频路径，视频标题，定位地理位置提交
     */
    public function send_video_infos() {		
		if(empty($this->user_id)){//用户没有登录
			$returnData = array();	
			$this->__outlivemsg($returnData,'您还没有登录','1001');				
		}		
        $videourl = $this->input->post('videourl', true); //视频路径
        $height = $this->input->post('height', true); //视频高
        $width = $this->input->post('width', true); //视频宽		
        $categoryid = intval($this->input->post('categoryid', true)); //直播类型		
        $name = $this->input->post('name', true); //标题
        $cover = $this->input->post('cover', true); //视频封面		
        $destid = intval($this->input->post('destid', true)); //定位目的地	
        $destname = $this->input->post('destname', true); //定位目的地名			
        $lineid = $this->input->post('lineid', true); //关联线路
		if(empty($categoryid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"请选择直播类型!",'3020');			
		}
		/*if(empty($cover)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"请定上传封面图!",'3021');			
		}	*/		
		if(mb_strlen($name,'utf8')>30 || empty($name) ){
			$returnData = array();	
			$this->__outlivemsg($returnData,'标题不能为空且最多30个文字','3023');				
		}
			
		$room_dest = ' ';//开播所属目的地		
		if($destid){
			$arr = $this->db->query("select id,kindname from u_dest_cfg where id=" . $destid . "")->row_array();			
			if(!empty($arr)){
				$room_dest =$arr['kindname'];
			}else{
				$room_dest =$destname;
				/*
				$arr = $this->db->query("select id,name from u_area where id=" . $destid . "")->row_array();
				if(!empty($arr)){
					$room_dest =$arr['name'];
				}*/				
			}
		}else{
			$room_dest =$destname;
		}

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
		$nowtime = time();
		$insert_data = array(
				"anchor_id"	=>$live_anchor_data['anchor_id'],
				"room_id"	 	=>'0',
				"room_code"			=>'',
				"video" 		=> $videourl,
				"name"	=>$name,
				"pic"	=>$cover,
				"addtime"	 	=>$nowtime,
				"starttime"			=>0,
				"endtime" 		=> 0,
				"time"	=>0,							
				"people"	=>0,
				"collect"	 	=>0,
				"record_id"			=>0,
				"attr_id"	=>$categoryid,	
				"type"	=>2,
				"line_ids"=>$lineid,				
				'user_type'=>$live_anchor_data['type'],
				'dest_name'=>$room_dest,
				'dest_id'=>$destid,
				"video_height"=>$height,
				"video_width"=>$width,					
		);	
		$this->live_db->insert('live_video', $insert_data);			
		$video_id=$this->live_db->insert_id();
        $returnData = array('video_id'=>$video_id);
        $this->__outlivemsg($returnData);
    }

    /**
     * 获取聊天信息列表及参与人数统计数据
     */
    public function get_room_chat_list_and_total() {
        $roomid = intval($this->input->post('roomid', true)); //直播房间id
		if(empty($roomid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}		
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
		$sql_str = 'select count(*) as total from (select user_id from live_room_chat where room_id='.$roomid.'  GROUP BY user_id order by null ) as a';
		$live_room_chat_total = $this->live_db->query($sql_str)->row_array();	
		
        $returnData = array();
        $returnData['info'] = $live_room_chat_data;
        $returnData['total'] = $live_room_chat_total;			
        $this->__outlivemsg($returnData);
    }

    /**
     * 获取贡献列表及打赏人数统计数据
     */
    public function get_room_giving_gifts_list_and_total() {
        $roomid = intval($this->input->post('roomid', true)); //直播房间id
		if(empty($roomid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}		
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
		$sql_str = "select * from (select gift_id,user_id,sum(worth) as worth,addtime,max(addtime)as maxtime from live_gift_record where room_id=".$roomid." group by user_id order by null) as a  order by worth desc,maxtime desc limit 5 ";
		//$sql_str = "select gift_id,user_id,max(worth) as worth,addtime from live_gift_record where room_id=".$roomid." group by user_id order by null limit 5 ";
		$live_gift_record_data = $this->live_db->query($sql_str)->result_array();
		$user_ids = array();
		$user_nick = array();
		foreach($live_gift_record_data as $k => $v){
			$user_ids[$v['user_id']]= $v['user_id'];
		}
		if(!empty($user_ids)){
			$sql = 'SELECT anchor_id,name FROM live_anchor WHERE anchor_id in('.implode(',',$user_ids).')';
			$u_member =  $this->live_db->query($sql )->result_array();	
			foreach($u_member as $v){
				$user_nick[$v['anchor_id']]= $v['name'];
			}			
		}

		foreach($live_gift_record_data as $k => $v){
			$live_gift_record_data[$k]['icon'] = $live_gift_data_byid[$v['gift_id']]['pic'];
			$live_gift_record_data[$k]['nickname'] = $user_nick[$v['user_id']];
			unset($live_gift_record_data[$k]['gift_id'],$live_gift_record_data[$k]['addtime']);
		}		
		$sql_str = 'select count(*) as total from (select user_id from live_gift_record where room_id='.$roomid.' GROUP BY user_id order by null ) as a';
		$live_gift_record_total = $this->live_db->query($sql_str)->row_array();		

        $returnData = array();
        $returnData['info'] = $live_gift_record_data;
        $returnData['total'] = $live_gift_record_total;			
        $this->__outlivemsg($returnData);
    }

    /**
     * 获取关联线路数据
     */
    public function get_line_by_room_or_video() {
        $returnData = array();
        $this->__outlivemsg($returnData);
    }

	
    /**
     * 点赞及取消点赞
CREATE TABLE `live_anchor_like` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `anchor_id` int(4) NOT NULL DEFAULT '0' COMMENT '主播id',
  `like_id` int(11) NOT NULL DEFAULT '0' COMMENT '点赞对象id',  
  `like_type` int(4) NOT NULL DEFAULT '0' COMMENT '点赞对象类型,1主播点赞,2视频点赞，3评论点赞	,4直播点赞	',
  `addtime` datetime DEFAULT NULL,
  `status` int(4) NOT NULL DEFAULT '0' COMMENT '点赞状态 0否1是',
  PRIMARY KEY (`id`),
  KEY `index1` (`anchor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;	 
	 
     */
	 //用户不登录可以点赞
    public function like_do() {
        $likeid = $this->input->get_post('likeid', true); //点赞目标
        $liketype = $this->input->get_post('liketype', true); //点赞类型,1主播点赞,2视频点赞，3评论点赞	,4直播点赞	
		if(empty($likeid) || empty($liketype)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}
		$num =1;
		$like_data = array();
		if($liketype==1){//主播点赞
			$this->live_db->query("update live_anchor set `like_num`=like_num+1 where anchor_id = ".$likeid."");
			$sql_str = "select like_num from live_anchor where anchor_id=".$likeid;
			$like_data = $this->live_db->query($sql_str)->row_array();
		}else if($liketype==2){//视频点赞
			$this->live_db->query("update live_video set `like_num`=like_num+1 where id = ".$likeid."");
			$sql_str = "select like_num from live_video where id=".$likeid;
			$like_data = $this->live_db->query($sql_str)->row_array();			
		}else if($liketype==3){//评论点赞	
			$this->live_db->query("update live_video_comment set `like_num`=like_num+1 where id = ".$likeid."");
			$sql_str = "select like_num from live_video_comment where id=".$likeid;
			$like_data = $this->live_db->query($sql_str)->row_array();			
		}else if($liketype==4){//直播点赞	
			$this->live_db->query("update live_room set `like_num`=like_num+1 where room_id = ".$likeid."");
			$sql_str = "select like_num from live_room where room_id=".$likeid;
			$like_data = $this->live_db->query($sql_str)->row_array();			
		}
		/*if(in_array($liketype,array(1,2,3,4))){
			$insert_data=array(
				'anchor_id'=>0,
				'like_id'=>$likeid,
				'like_type'=>$liketype,				
				'addtime'=>date('Y-m-d H:i:s',time()),
				'status'=>1,
			);
			$this->live_db->insert('live_anchor_like', $insert_data);			
		}*/
		if(!empty($like_data)){
			$num =$like_data['like_num'];
		}
		$returnData = array(
			'code'=>'1',
			'num'=>$num,
		);			
        $this->__outlivemsg($returnData);
    }	
	//用户登录后点赞
    public function like_do_my() {
        $likeid = $this->input->post('likeid', true); //点赞目标
        $liketype = $this->input->post('liketype', true); //点赞类型,1主播点赞,2视频点赞，3评论点赞	,4直播点赞	
		if(empty($likeid) || empty($liketype)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}
		if(empty($this->user_id)){//用户没有登录
			$returnData = array();	
			$this->__outlivemsg($returnData,'您还没有登录','1001');				
		}
		$live_anchor_data =  $this->live_anchor_info;		
		$anchor_id = $live_anchor_data['anchor_id'];//使用自己的主播id
	
		$sql_str = "select * from live_anchor_like where anchor_id=".$anchor_id." and like_id=".$likeid.' and like_type='.$liketype;
		$live_anchor_like_data = $this->live_db->query($sql_str)->row_array();//点赞类型,1主播点赞,2视频点赞，3评论点赞	,4直播点赞	
		if(!empty($live_anchor_like_data)){
			/*if($live_anchor_like_data['status']==1){//取消点赞
				$this->live_db->query("update live_anchor_like set `status`=0 where id = ".$live_anchor_like_data['id']."");				
				$returnData = array(
					'code'=>'0',
				);					
			}else{
				$this->live_db->query("update live_anchor_like set `status`=1 where id = ".$live_anchor_like_data['id']."");				
				$returnData = array(
					'code'=>'1',
				);				
			}*/
		}else{//表示未点赞，要进行点赞
			$insert_data=array(
				'anchor_id'=>$anchor_id,
				'like_id'=>$likeid,
				'like_type'=>$liketype,				
				'addtime'=>date('Y-m-d H:i:s',time()),
				'status'=>1,
			);
			$this->live_db->insert('live_anchor_like', $insert_data);
			if($liketype==1){//主播点赞
				$this->live_db->query("update live_anchor set `like_num`=like_num+1 where anchor_id = ".$likeid."");
			}else if($liketype==2){//视频点赞
				$this->live_db->query("update live_video set `like_num`=like_num+1 where id = ".$likeid."");
			}else if($liketype==3){//评论点赞	
				$this->live_db->query("update live_video_comment set `like_num`=like_num+1 where id = ".$likeid."");
			}else if($liketype==4){//直播点赞	
				$this->live_db->query("update live_room set `like_num`=like_num+1 where room_id = ".$likeid."");				
			}
			$returnData = array(
				'code'=>'1',
			);			
		}
        $this->__outlivemsg($returnData);
    }	
	
	
    /**
     * 关注及取消关注
     */
    public function attention_anchor() {
        $anchor_id = $this->input->post('anchor_id', true); //主播id
		if(empty($anchor_id)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}
		if(empty($this->user_id)){//用户没有登录
			$returnData = array();	
			$this->__outlivemsg($returnData,'您还没有登录','1001');				
		}
		$live_anchor_data =  $this->live_anchor_info;		
		$user_id = $live_anchor_data['anchor_id'];//使用自己的主播id
        if(empty($anchor_id) || empty($user_id) ){
			$returnData = array();	
			$this->__outlivemsg($returnData,'参数错误','2001');			
		}
        if( $anchor_id == $user_id ){
			$returnData = array();	
			$this->__outlivemsg($returnData,'自己不能关注自己','2002');			
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
     */
    public function giving_gifts_to_anchor() {
		if(empty($this->user_id)){//用户没有登录
			$returnData = array();	
			$this->__outlivemsg($returnData,'您还没有登录','1001');				
		}
		$me_live_anchor_data =  $this->live_anchor_info;		
		$anchor_id = $me_live_anchor_data['anchor_id'];//使用自己的主播id
		
        $roomid = $this->input->post('roomid', true); //直播房间id
        $giftid = $this->input->post('giftid', true); //礼物id
		if(empty($roomid) || empty($giftid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}
		$sql_str = "select anchor_id,room_code from live_room where room_id=".$roomid."";
		$live_room_data = $this->live_db->query($sql_str)->row_array();	
		
		$sql_str = "select gift_id,gift_name as name,pic as icon,worth,unit from live_gift where status=1 and gift_id=".$giftid;
		$live_gift_data = $this->live_db->query($sql_str)->row_array();
		
		$sql_str = "select umoney from live_anchor where anchor_id = ".$anchor_id."";
		$live_anchor_data = $this->live_db->query($sql_str)->row_array();
		if($live_anchor_data['umoney'] < $live_gift_data['worth']){
			$returnData = array();	
			$this->__outlivemsg($returnData,'U币数不足','3021');				
		}
		$this->live_db->trans_begin();//事务
		$this->live_db->query("update live_anchor set `umoney`=umoney-".$live_gift_data['worth']." where anchor_id = ".$anchor_id."");//送礼物的人减钱	
		$this->live_db->query("update live_anchor set `umoney`=umoney+".$live_gift_data['worth']." where anchor_id = ".$live_room_data['anchor_id']."");//主播加钱
		$this->live_db->query("update live_room set `umoney`=umoney+".$live_gift_data['worth']." where anchor_id = ".$live_room_data['anchor_id']."");//主播直播间加钱	
		
		$insert_data = array(
			"gift_id"	 	=>$giftid,
			"anchor_id"			=>$live_room_data['anchor_id'],		
			"room_id"	 	=>$roomid,
			"room_code"			=>$live_room_data['room_code'],
			"user_id" 		=>$anchor_id,
			"num"	=>1,
			"worth" 		=>$live_gift_data['worth'],			
			"addtime"	 	=>date("Y-m-d H:i:s"),	
			"pic"	=>$live_gift_data['icon'],			
		);
		$this->live_db->insert('live_gift_record', $insert_data);	
		
		$insert_data = array(
			"room_id"	 	=>$roomid,
			"room_code"			=>$live_room_data['room_code'],
			"user_id" 		=>$anchor_id,
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
        $returnData = array('ymoney'=>$live_anchor_data['umoney']-$live_gift_data['worth']);
        $this->__outlivemsg($returnData);
    }

    /**
     * 获取礼物列表数据
     */
    public function get_gifts_list() {
		$sql_str = "select gift_id,gift_name as name,pic as icon,worth,unit from live_gift where status=1 order by showorder asc ";
		$live_gift_data = $this->live_db->query($sql_str)->result_array();	
		if(count($live_gift_data)>0){
			foreach($live_gift_data as $k=> $v){
				$live_gift_data[$k]['icon'] = trim(base_url(''),'/').$live_gift_data[$k]['icon'];							
			}
		}
		$returnData = array();
		$returnData['umoney'] = 0;
		if(!empty($this->user_id)){
			$sql_str = "select umoney from live_anchor where user_id = ".$this->user_id."";
			$live_anchor_data = $this->live_db->query($sql_str)->row_array();
			$returnData['umoney'] = $live_anchor_data['umoney'];			
		}
        $returnData['info'] = $live_gift_data;		
        $this->__outlivemsg($returnData);
    }

    /**
     * 获取App首页推荐数据
     */
    public function get_app_index_infos() {
        $returnData = array();
        $this->__outlivemsg($returnData);
    }
	
    //视频截图
	public function set_video_to_pic(){
		exec ("ffmpeg -i  F:\phpStudy\WWW\otc\php\trunk\bangu/15.mp4  -y -f image2 -ss 2  F:\phpStudy\WWW\otc\php\trunk\bangu/15.mp4.jpg");
		//	exec ("ffmpeg -i /usr/local/apache/htdocs/bangu/file/live/video/14817667199380.mp4  -f image2 -ss 2 -vf 'transpose=1' -vframes 1 /usr/local/apache/htdocs/bangu/file/1test.jpg");		
					
        exit('success');
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
	
	
	//观看直播人数机器变更,每4s访问一次
	/*
	第6s增加4-6人
	10s	5-10
	30s	15-30
	50s	20-40
	80s	10-20
	*/
	public function timed_task_visitor_room_people(){
		$nowtime = time();		
		$sql_str = 'select room_id,peoples,starttime,createtime from live_room  where live_status=1 and status in(1,2)  and  createtime>'.($nowtime - $this->room_timeout).' ';
		$live_room_data = $this->live_db->query($sql_str)->result_array();
		foreach($live_room_data as $v){
			$time = $v['starttime'];
			if(empty($time)){
				$time = $v['createtime'];
			}
			$tt = $nowtime-$time;//秒为单位
			if($tt>86){
				continue;
			}
			$pnum = 1;
			if($tt<=8){
				$pnum = rand(4,6);
			}else if($tt<=15 and $tt>8){
				$pnum = rand(5,10);
			}else if($tt<=35 and $tt>25){
				$pnum = rand(5,10);				
			}else if($tt<=55 and $tt>45){
				$pnum = rand(5,10);				
			}else if($tt<=85 and $tt>75){
				$pnum = rand(5,20);				
			}
			$this->live_db->query("update live_room set `peoples`=peoples+".$pnum." where room_id = ".$v['room_id']."");			
		}
        exit('success');
	}	
	
	
    //定时监测不在直播的房间进行下线及上线,5秒一次
	public function timed_task_update_room_online(){
		$nowtime = time();
		$starttime = ($nowtime-($this->room_timeout*3))*1000;
		self::getAccessToken();
		$param = array(
		  "startDate"=>$starttime,
		  //"endDate"=>1445307594916,
		  //"searchRoomId"=> 10023, //查询条件,房间id
		  //"roomName"=>"aaa主播室", //查询条件,房间名
		  //"creator"=>"李四", //查询条件,创建者
		  "type"=>0, //查询类型,0-未删除 1-全部（包含未删除和已经删除的） 2-直播中 3-已删除，默认0
		  //"index"=>0,
		  "count"=>500
		);
		$returnData = self::curlUtils($param,"GetRooms");	
		$total = $returnData['total'];
		if(!empty($returnData['entities'])){
			foreach($returnData['entities'] as $v){
				if($v['status']==0){// "status":0 //房间状态，0-正常 1-已删除 2-正在直播
					$sql = 'SELECT room_id,createtime,starttime,status,type,live_status FROM live_room WHERE roomid='.$v['roomId'].' ';
					$live_room_data =  $this->live_db->query($sql )->row_array();//房间正在使用
					if(!empty($live_room_data) && $live_room_data['createtime'] && $live_room_data['createtime']>($nowtime - $this->room_timeout) ){//还在时间范围内
						if($live_room_data['live_status']==1){//表示正在直播的
							$this->live_db->query("update live_room set `live_status`=3,`endtime`={$nowtime} where room_id = ".$live_room_data['room_id']."");
						}
					}
				}else if($v['status']==2){
					$sql = 'SELECT room_id,createtime,starttime,status,type,live_status FROM live_room WHERE roomid='.$v['roomId'].' ';
					$live_room_data =  $this->live_db->query($sql )->row_array();//房间正在使用
					if(!empty($live_room_data) && $live_room_data['createtime'] && $live_room_data['createtime']>($nowtime - $this->room_timeout) ){//还在时间范围内
						if($live_room_data['live_status']==3){//表示正在直播的
							$this->live_db->query("update live_room set `live_status`=1,`endtime`={$nowtime} where room_id = ".$live_room_data['room_id']."");
						}
					}					
				}
			}				
		}
        exit('success');
	}	
	
	
    //获取最新的录播列表并且插入到历史视频中
	public function timed_task_get_new_video(){
		$nowtime = time();
		//获取最大的开始时间
		$sql = 'SELECT starttime FROM live_video WHERE type in(1,2) order by starttime desc limit 1';
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
					$sql = 'SELECT room_id,anchor_id,room_name,peoples,line_ids,user_type,attr_id,room_dest,room_dest_id,pic,live_status FROM live_room WHERE roomid='.$v['roomId'].'';
					$live_room_data =  $this->live_db->query($sql )->row_array();
					if(!empty($live_room_data) /*&& $live_room_data['room_name']!='no'*/ ){
						$sql_str = "select record_id from live_video where room_id=".$live_room_data['room_id'];
						$live_video_data = $this->live_db->query($sql_str)->row_array();
						if(empty($live_video_data) || (!empty($live_video_data) && empty($live_video_data['record_id'])) 
							|| (!empty($live_video_data) && !empty($live_video_data['record_id']) && $live_video_data['record_id'] !=$v['recordingId'])
							){//判断是否已经插入过此视频,一个直播可以录制多个视频也能同步
							$pic = $live_room_data['pic'];
							if(empty($pic))$pic = $v['recFirstFrameUrl'];
							/*if(strpos($pic,'http://') || strpos($pic,'https://')){
								$path = $pic;
							}else{
								$path = "../bangu/".trim($pic,'/');
							}*/
							$path = $v['recFirstFrameUrl'];
							list($src_w,$src_h)=getimagesize($path);// 获取原图尺寸
							
							$type =1;//表示直播视频
							if($live_room_data['live_status']==2)$type =2;//表示短视频
							$video_url = $v['firstHlsUrl'];
							if(!strpos($v['firstHlsUrl'],'.mp4') && !empty($v['downUrl'])){
								$video_url = $v['downUrl'];
							}							
							$insert_data = array(
									"anchor_id"	=>$live_room_data['anchor_id'],
									"room_id"	 	=>$live_room_data['room_id'],
									"room_code"			=>'',
									"video" 		=> $video_url,
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
									"type"	=>$type,
									"line_ids"	=>$live_room_data['line_ids'],
									'user_type'=>$live_room_data['user_type'],
									'dest_name'=>$live_room_data['room_dest'],
									'dest_id'=>$live_room_data['room_dest_id'],
									'status'=>1,
									'video_height'=>$src_h,
									'video_width'=>$src_w,
									'screen_pic'=>$path,		
							);	
							$this->live_db->insert('live_video', $insert_data);
                                                        // 将相关信息插入动态表
                                                        $query = $this->live_db->get_where('social_dynamics', array("member_id"	=>$live_room_data['anchor_id'], 'type'=>3), 1, 1);
                                                        if ($query->num_rows() < 1){
                                                            $dyn_data = array(
                                                            "member_id"	=>$live_room_data['anchor_id'],
                                                            'type'      =>3);
                                                        $this->live_db->insert('social_dynamics', $dyn_data); 
                                                    }
                                                       
						}	
					}
				}
			}				
		}
        exit('success');
	}
	
	
    //同步某些还没有同步的视频列表,1天同步一次
	public function timed_task_get_all_no_tong_video(){
		$sql = "select count(room_id) as total  from (select r.roomid,r.room_id,  if(v.record_id>0,v.record_id,0) as record_id from live_room as r left join live_video v on( r.room_id=v.room_id )) as a where record_id=0";
		$live_video_count_data =  $this->live_db->query($sql )->row_array();
		if(empty($live_video_count_data)){
			exit('no data');
		}
		$page_size = 100;//每次查出100条
		if($live_video_count_data['total']>$page_size){
			$num = ceil($live_video_count_data['total']/$page_size);
		}else{
			$num = 1;
		}
		for($page=1;$page<=$num;$page++){
			$from = ($page - 1) * $page_size; //from
			//查询未同步到的视频
			$sql = "select *  from (select r.roomid,r.room_id,  if(v.record_id>0,v.record_id,0) as record_id from live_room as r left join live_video v on( r.room_id=v.room_id )) as a where record_id=0  LIMIT {$from},{$page_size}";
			$live_video_all_data =  $this->live_db->query($sql )->result_array();	
			foreach($live_video_all_data as $v){
				$roomid = $live_video_all_data['roomid'];
				if($roomid){
					$nowtime = time();
					//通过接口获取录播列表数据
					self::getAccessToken();
					$param = array(
						"queryRoomId"=>$roomid,// 主播室id
						//"index"=>0,// 查询起始位置
						//"count"=>50,// 查询个数
						//"endRecordingTime"=>50,// 结束时间戳*1000=1480499880000
						//"startRecordingTime"=>$max_starttime,// 开播时间戳*1000=1478080680000							
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
									$sql_str = "select record_id from live_video where room_id=".$live_room_data['room_id'];
									$live_video_data = $this->live_db->query($sql_str)->row_array();
									if(empty($live_video_data) || (!empty($live_video_data) && empty($live_video_data['record_id']))
									|| (!empty($live_video_data) && !empty($live_video_data['record_id']) && $live_video_data['record_id'] !=$v['recordingId'])	
									){//判断是否已经插入过此视频
										$pic = $live_room_data['pic'];
										if(empty($pic))$pic = $v['recFirstFrameUrl'];

										/*if(strpos($pic,'http://') || strpos($pic,'https://')){
											$path = $pic;
										}else{
											$path = "../bangu/".trim($pic,'/');
										}*/
										$path = $v['recFirstFrameUrl'];
										list($src_w,$src_h)=getimagesize($path);// 获取原图尺寸										
										$video_url = $v['firstHlsUrl'];
										if(!strpos($v['firstHlsUrl'],'.mp4') && !empty($v['downUrl'])){
											$video_url = $v['downUrl'];
										}										
										$insert_data = array(
												"anchor_id"	=>$live_room_data['anchor_id'],
												"room_id"	 	=>$live_room_data['room_id'],
												"room_code"			=>'',
												"video" 		=> $video_url,
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
												'video_height'=>$src_h,
												'video_width'=>$src_w,
												'screen_pic'=>$path,												
										);	
										$this->live_db->insert('live_video', $insert_data);	
									}
								}
							}
						}				
					}					
					
				}
			}
			
			
		}
        exit('success');
	}	

	//临时用来同步本地视频高宽
	public function tmp_edit_video_wh_local(){
		//$local = 'https://pubtest.1b1u.com';
		$local = 'http://www.1b1u.com';
		//$videoid = $this->input->get("videoid",true);
		//$sql_str = "select * from live_video where id=".$videoid;
		//$sql_str = "select * from live_video where record_id=0 and video_height=0 and video like '%".$local."%'  limit 1";
		$sql_str = "select * from live_video where tmp_edit=0 and video like '%".$local."%'  limit 1";
		//$sql_str = "select * from live_video where record_id>0 and video_height=0 limit 1";
		$live_video_data = $this->live_db->query($sql_str)->row_array();
		if(!empty($live_video_data) && !empty($live_video_data['video'])){
			$videoid = $live_video_data['id'];
			$urls = str_replace($local,dirname(BASEPATH),$live_video_data['video']);
			//旋转视频裁剪
			//exec ("ffmpeg -i ".escapeshellarg($urls)."  -f image2 -ss 2 -vf 'transpose=1' -vframes 1 ".$urls.'.jpg'."");
			//不旋转视频裁剪
			exec("ffmpeg -i  ".escapeshellarg($urls)."  -y -f image2 -ss 2  ".$urls.'.jpg'."");			
			//裁剪图片开始
			$src_img = $urls.'.jpg';
			$src_img1 = $live_video_data['video'].'.jpg';
			//宽高比 35:22
			list($src_w,$src_h)=getimagesize($src_img);  // 获取原图尺寸
			if(!empty($src_w) && !empty($src_h)){
				$this->live_db->query("update live_video set `video_height`='".$src_h."',`video_width`='".$src_w."',`screen_pic`='".$src_img1."',`tmp_edit`='1' where id = ".$videoid."");						
			}
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
			<body><span id="jumpTo">5</span>秒后自动跳转到'.$local.'/api/v2_3_15/live_desk/tmp_edit_video_wh_local,当前id='.$videoid.'
			<script type="text/javascript">countDown(5,\''.$local.'/api/v2_3_15/live_desk/tmp_edit_video_wh_local\');</script> 
			</body>
			</html>';		
			exit();			
		}else{
			exit('end');
		}

	}	
	
	//临时用来同步第三方视频高宽
	public function tmp_edit_video_wh(){
		//$local = 'https://pubtest.1b1u.com';		
		$local = 'http://www.1b1u.com';		
		//$videoid = $this->input->get("videoid",true);
		//$sql_str = "select * from live_video where id=".$videoid;
		//$sql_str = "select * from live_video where record_id>0 and video_height=0 and id not in(182) limit 1";

		$sql_str = "select * from live_video where record_id>0 and tmp_edit=0 and id not in(182,366,368,369,370,489)  limit 1";
		//$sql_str = "select * from live_video where record_id>0 and tmp_edit=0  limit 1";
		//$sql_str = "select * from live_video where record_id>0 and video_height=0 limit 1";
		$live_video_data = $this->live_db->query($sql_str)->row_array();
		if(!empty($live_video_data) && !empty($live_video_data['record_id'])){
			$videoid = $live_video_data['id'];
			self::getAccessToken();
			$param = array(
				"recordingId"=>$live_video_data['record_id'],
				);
			$returnData = self::curlUtils($param,"GetRecording");
			$is = true;
			if(!empty($returnData['entity'])){
				if($returnData['entity']['status']==2){//正常的视频
					$path = $returnData['entity']['recFirstFrameUrl'];
					if($path){
						list($src_w,$src_h)=getimagesize($path);//获取原图尺寸						
						$this->live_db->query("update live_video set `video_height`='".$src_h."',`video_width`='".$src_w."',`screen_pic`='".$path."',`tmp_edit`='1' where id = ".$videoid."");						
						$is = false;
					}
				}
			}
			/*
			if($is){
				if(strpos($live_video_data['video'],'http://gotye-video-out.oss-cn-shanghai.aliyuncs.com')===0){
					$urls = str_replace('http://gotye-video-out.oss-cn-shanghai.aliyuncs.com',dirname(BASEPATH).'/file/live',$live_video_data['video']);
					
					//旋转视频裁剪
					//exec ("ffmpeg -i ".escapeshellarg($urls)."  -f image2 -ss 2 -vf 'transpose=1' -vframes 1 ".$urls.'.jpg'."");
					//不旋转视频裁剪
					exec("ffmpeg -i  ".$live_video_data['video']."  -y -f image2 -ss 2  ".$urls.'.jpg'."");			
					//裁剪图片开始
					$src_img = $urls.'.jpg';
					$src_img1 = $local.'/file/live'.str_replace('http://gotye-video-out.oss-cn-shanghai.aliyuncs.com','',$live_video_data['video']).'.jpg';
					//宽高比 35:22
					list($src_w,$src_h)=getimagesize($src_img);  // 获取原图尺寸
					if(!empty($src_w) && !empty($src_h)){
						$this->live_db->query("update live_video set `video_height`='".$src_h."',`video_width`='".$src_w."',`screen_pic`='".$src_img1."',`tmp_edit`='1' where id = ".$videoid."");						
					}					
				}
					
			}
		*/
			
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

		<body><span id="jumpTo">5</span>秒后自动跳转到'.$local.'/api/v2_3_15/live_desk/tmp_edit_video_wh,当前id='.$videoid.'
		<script type="text/javascript">countDown(5,\''.$local.'/api/v2_3_15/live_desk/tmp_edit_video_wh\');</script> 
		</body>
		</html>';	
			exit();			
		}else{
			exit('end');
		}

	}	

    //临时用来同步某些视频
	public function tmp_add_new_video(){
		header( "content-type:text/html;charset=utf-8" );
		$roomid = $this->input->get('roomid', true); //直播房间id
		$nowtime = time();
		//通过接口获取录播列表数据
		self::getAccessToken();
		$param = array(
			"queryRoomId"=>$roomid,// 主播室id
			//"index"=>0,// 查询起始位置
			//"count"=>50,// 查询个数
			//"endRecordingTime"=>50,// 结束时间戳*1000=1480499880000
			//"startRecordingTime"=>$max_starttime,// 开播时间戳*1000=1478080680000							
		);
		$returnData = self::curlUtils($param,"GetRecordings");
		$total = $returnData['total'];
		$is= 0;
		if(!empty($returnData['entities'])){
			foreach($returnData['entities'] as $v){
				if($v['status']==2){//正常的视频
					$recStartTime = $v['recStartTime']/1000;
					$recEndTime = $v['recEndTime']/1000;
					$sql = 'SELECT room_id,anchor_id,room_name,peoples,line_ids,user_type,attr_id,room_dest,room_dest_id,pic FROM live_room WHERE roomid='.$v['roomId'].'';
					$live_room_data =  $this->live_db->query($sql )->row_array();
					if(!empty($live_room_data)){
						$sql_str = "select record_id from live_video where room_id=".$live_room_data['room_id'];
						$live_video_data = $this->live_db->query($sql_str)->row_array();
						if(empty($live_video_data) || (!empty($live_video_data) && empty($live_video_data['record_id']))
							|| (!empty($live_video_data) && !empty($live_video_data['record_id']) && $live_video_data['record_id'] !=$v['recordingId'])							
						){//判断是否已经插入过此视频
							$pic = $live_room_data['pic'];
							if(empty($pic))$pic = $v['recFirstFrameUrl'];
							/*if(strpos($pic,'http://') || strpos($pic,'https://')){
								$path = $pic;
							}else{
								$path = "../bangu/".trim($pic,'/');
							}*/
							$path = $v['recFirstFrameUrl'];
							list($src_w,$src_h)=getimagesize($path);//获取原图尺寸	
							$video_url = $v['firstHlsUrl'];
							if(!strpos($v['firstHlsUrl'],'.mp4') && !empty($v['downUrl'])){
								$video_url = $v['downUrl'];
							}	
							$insert_data = array(
									"anchor_id"	=>$live_room_data['anchor_id'],
									"room_id"	 	=>$live_room_data['room_id'],
									"room_code"			=>'',
									"video" 		=> $video_url,
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
									'video_height'=>$src_h,
									'video_width'=>$src_w,
									'screen_pic'=>$path,	
							);	
							$this->live_db->insert('live_video', $insert_data);
							$is= 1;	
						}else{
							$is= 2;	
						}
					}else{
						$is= 3;
					}
				}
			}				
		}
		if($is == 1){
			echo '<font color=red>success</font>';			
		}else if($is == 2){
			echo '<font color=red>已经同步过了</font>';	
		}else if($is == 3){
			echo '<font color=red>本系统表中房间不存在</font>';				
		}else{
			echo '<font color=red>失败</font>';
			echo '<br/>';		
			echo '第三方（亲加）接口放回数据：';
			print_r($returnData);			
		}
		exit;
	}	
	
	
	
	//观众进入房间观看直播的时候
	function visitor_in_room(){
		$roomid = intval($this->input->post("roomid",true));
		if(empty($roomid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}
		$this->live_db->query("update live_room set `peoples`=peoples+1 where room_id = ".$roomid."");	
        $returnData = array();
        $this->__outlivemsg($returnData);
	}

	//观众退出房间观看的时候
	function visitor_out_room(){
		$roomid = intval($this->input->post("roomid",true));
		if(empty($roomid)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}
		$sql = 'SELECT peoples FROM live_room WHERE room_id='.$roomid.'';
		$live_room_data =  $this->live_db->query($sql )->row_array();		
		if(!empty($live_room_data) && $live_room_data['peoples']>1){
			$this->live_db->query("update live_room set `peoples`=peoples-1 where room_id = ".$roomid."");			
		}
		$user_id = $this->user_id;
		if( !empty($live_room_data) && !empty($user_id)){//判断退出房间的人是否为主播自己
			$live_anchor_data =  $this->live_anchor_info;
			if($live_room_data['anchor_id'] == $live_anchor_data['anchor_id']){//表示是主播自己
				$nowtime = time();
				$this->live_db->query("update live_room set `live_status`=0,`endtime`={$nowtime} where room_id = ".$roomid."");	
			}
		}
        $returnData = array();
        $this->__outlivemsg($returnData);
	}	
	
	//观看视频的数量
	function visitor_in_video(){
		$video_id = intval($this->input->post("videoid",true));
		if(empty($video_id)){
			$returnData = array();	
			$this->__outlivemsg($returnData,"参数错误!",'3020');			
		}		
		$this->live_db->query("update live_video set `people`=people+1 where id = ".$video_id."");	
        $returnData = array();
        $this->__outlivemsg($returnData);
	}
	

    public function errorlog() {
        $ret = $this->input->post('ret', true);
        $error = $this->input->post('err', true);	
		$msg = $ret . ' '.$error ;
		$_date_fmt	= 'Y-m-d H:i:s';
		$filepath = APPPATH.'logs/city/log-'.date('Y-m-d').'.php';
		$message  = '';
		if ( ! file_exists($filepath))
		{
			$message .= "<"."?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?".">\n\n";
		}

		if ( ! $fp = @fopen($filepath, FOPEN_WRITE_CREATE))
		{
			return FALSE;
		}
		$message .= 'info '.date($_date_fmt). ' --> '.$msg."\n";
		flock($fp, LOCK_EX);
		fwrite($fp, $message);
		flock($fp, LOCK_UN);
		fclose($fp);
		@chmod($filepath, FILE_WRITE_MODE);
        $returnData = array();
        $this->__outlivemsg($returnData);
    }	
	
	public function live_GetRoomsLiveInfo(){
		$room_id = $this->input->get("room_id",true);	
		self::getAccessToken();
		$param = array(
			"roomIds"=>$room_id,
			);
		$returnData = self::curlUtils($param,"GetRoomsLiveInfo");
        $this->__outlivemsg($returnData);		
	}	

	public function live_GetRecording(){
		$recordingId = $this->input->get("recordingId",true);	
		self::getAccessToken();
		$param = array(
			"recordingId"=>$recordingId,
			);
		$returnData = self::curlUtils($param,"GetRecording");
        $this->__outlivemsg($returnData);		
	}	

	public function live_SetRecordingTime(){
		$room_id = $this->input->get("room_id",true);	
		self::getAccessToken();
		$param = array(
		  "roomId"=>$room_id, // app认证时必须
		  //"timeError"=>60, //误差时间范围，单位秒，默认为:(endDate-startDate)/10/1000
		  //"startDate"=>1447043464367, // 开始录制时间, 单位：毫秒
		  //"endDate"=>1447043644367 //结束录制时间, 单位：毫秒
		);
		$returnData = self::curlUtils($param,"SetRecordingTime");
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

    //生成客户端地址
	public function live_GetRooms(){	
		self::getAccessToken();
		$param = array(
		  //"startDate"=>1445307593635,
		  //"endDate"=>1445307594916,
		  //"searchRoomId"=> 10023, //查询条件,房间id
		  //"roomName"=>"aaa主播室", //查询条件,房间名
		  //"creator"=>"李四", //查询条件,创建者
		  //"type"=>0, //查询类型,0-未删除 1-全部（包含未删除和已经删除的） 2-直播中 3-已删除，默认0
		  //"index"=>0,
		  //"count"=>10
		);
		$returnData = self::curlUtils($param,"GetRooms");
        $this->__outlivemsg($returnData);
	}	


	//批量创建房间
	public function live_creat_room_p(){

		for($i=1;$i<100;$i++){
			$room_num = $i;//房间号不能超过四位数
			/*$sql = 'SELECT * FROM live_room WHERE room_number= '.$room_num.' ';
			$check_num_res =  $this->live_db->query($sql )->row_array();				
			
			if(!empty($check_num_res)){//房间号已经存在重新设置
				exit('error');
			}*/
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
					"status"				=>2,
					"type"					=>$_POST['room_type'],
					"starttime"				=>$return_result['entity']['dateCreate'],
					"room_number"		=>$room_num
					);
				$this->live_db->insert('live_room', $room_data);
				$room_id = $this->live_db->insert_id();					
			}
			echo $room_id.'-';
			sleep(5);
			//print_r($return_result);			
		}

		
		exit('succ');
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
					"status"				=>2,
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

    //设置主播室的推流状态,也就是可以用来关闭主播,"state":1 //1-开始推流 0-结束推流
	public function live_SetPubStreamState(){		
		self::getAccessToken();
		$param = array(
			"roomId"=>'230815',// 主播室id
			"state"=>0,//1-开始推流 0-结束推流		
		);
		$returnData = self::curlUtils($param,"SetPubStreamState");
		print_r($returnData);
        $this->__outlivemsg($returnData);
	}	
	
    //录播列表获取
	public function live_GetRecordings(){
		$room_id = $this->input->get_post("room_id",true);		
		self::getAccessToken();
		$param = array(
			"queryRoomId"=>$room_id,// 主播室id
			//"index"=>0,// 查询起始位置
			//"count"=>50,// 查询个数			
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
	
	
	/**
	 *
	 * @param unknown $code
	 * @return 数组：{ "access_token":"ACCESS_TOKEN",
	 *         "expires_in":7200,
	 *         "refresh_token":"REFRESH_TOKEN",
	 *         "openid":"OPENID",
	 *         "scope":"SCOPE"
	 *         }
	 */
	private function get_access_token() {
		$appid = $this->APPID;
		$secret = $this->SECRET;
		// 获取 access_token
		// https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET
		$url = "https://api.weixin.qq.com/cgi-bin/token?appid=" . $appid . "&secret=" . $secret. "&grant_type=client_credential";
		// https: // api.weixin.qq.com/sns/oauth2/refresh_token?appid=APPID&grant_type=refresh_token&refresh_token=REFRESH_TOKEN  client_credential&appid=APPID&secret=APPSECRET
		// // 初始化
		$ch = curl_init ();
		// // 设置选项，包括URL
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		// 　　 curl_setopt ( $ch, CURLOPT_HEADER, false );
		// // 执行并获取HTML文档内容
		$output = curl_exec ( $ch );
		curl_close ( $ch );
		$access_token_array = json_decode ( $output, 1 );
		return $access_token_array;
	}	
	
	
	/**
	 * 分享到微信朋友、朋友圈、qq、qq空间
	 * 返回:$signature['appid'] = APPID;
	 *     $signature['signature'] = $val;
	 *	   $signature['time'] = $time;
	 *	   $signature['nonceStr'] = $nonceStr;
	 *	   $signature['url'] = $url;
	 * */
	public function wx_share()
	{
		// 1、获取access token
		$sess_token=$this->session->userdata('token');//session
		if($sess_token){
			$access_token_array['access_token']=$sess_token;
		}else{
			$access_token_array=$this->get_access_token();
		}
		if(!empty($access_token_array)){
			$this->session->set_userdata(array('token'=>$access_token_array['access_token']));
			
			// 2、获取ticket
			$sess_ticket=$this->session->userdata('ticket');//session
			$user_url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$access_token_array['access_token']."&type=jsapi";
			$ch = curl_init ();
			curl_setopt ( $ch, CURLOPT_URL, $user_url );
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			$output = curl_exec ( $ch );
			curl_close ( $ch );
			if($sess_ticket)
			{
				$result_array['ticket']=$sess_ticket;
			}
			else
			{
				$result_array = json_decode ( $output, 1 );
			}
			$this->session->set_userdata(array('ticket'=>$result_array['ticket']));
			// 3、设置 string
			$time = time();
			$nonceStr = "e4b00e34-3c6f-421a-b032-69a1769d9b6c";
			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
			$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$str = "jsapi_ticket=".$result_array['ticket']."&noncestr=".$nonceStr."&timestamp=".$time."&url=".$url;
			// 4、根据string获得证书signature
			$val=sha1($str);
			// 5、返回结果
			$signature['appid'] = $this->APPID;
			$signature['signature'] = $val;
			$signature['time'] = $time;
			$signature['nonceStr'] = $nonceStr;
			$signature['url'] = $url;			
		}else{
			$signature =array();			
		}
		return $signature;
	}		
	
	
	
	/**
	 * 析构方法
	 * */
	function __destruct()
	{			

	}
	
	
}

/* End of file webservices.php */
/* Location: ./application/controllers/webservices.php */