<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		20170104
 * @author		zyf
 * @method 		手机端视频上传
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Mobile_video extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->live_db = $this->load->database ( "live", TRUE );
	}
	public function index()
	{
		$sql = "SELECT dict_id,description FROM live_dictionary WHERE `pid`=1 and `enable`=0";
		$data['dict_data'] = $this->live_db->query($sql)->result_array();
		$this->view ( 'admin/a/cfg_mobile/mobile_video',$data);
	}
	//添加视频
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);	
		if (empty($postArr['dict_id']))    $this->callback->setJsonCode ( 4000 ,'请选择视频标签');
		if (empty($postArr['city']) || empty($postArr['city_name']) || $postArr['city_name']=="请选择")    $this->callback->setJsonCode ( 4000 ,'请选择目的地');
		if (empty($postArr['expertId']))    $this->callback->setJsonCode ( 4000 ,'请选择管家');
		//if (empty($postArr['lineId']))    $this->callback->setJsonCode ( 4000 ,'请选择关联线路');
		if(mb_strlen($postArr['video_name'],'utf8')>8 || mb_strlen($postArr['video_name'],'utf8')<1)	$this->callback->setJsonCode ( 4000 ,'请填写八个字以内的视频名称');
		if (empty($postArr['video']))    $this->callback->setJsonCode ( 4000 ,'请上传视频');
		if (empty($postArr['pic']))    $this->callback->setJsonCode ( 4000 ,'请上传封面');
		$postArr['sort'] = intval($postArr['sort']);
		$postArr['dest_id'] = intval($postArr['city']);
		$postArr['id'] = intval($postArr['id']);
		$sort=empty($postArr['sort'])?999:$postArr['sort'];
		$postArr['lineId'] = intval($postArr['lineId']);
		$postArr['expertId'] = intval($postArr['expertId']);
		$sql = "select anchor_id from live_anchor where user_type=1 and user_id=".$postArr['expertId'];
		$id=$this->live_db->query($sql)->row_array();
		if (!empty($id))
		{
			$anchor_id = $id['anchor_id'];
		}
		else 
		{
			$anchor_id = $this->insert_live_anchor($postArr['expertId']); //插入主播数据
			if (!$anchor_id) $this->callback->setJsonCode ( 4000 ,'获取主播失败,请重新尝试');
		}
		$postArr['lineId'] .=',';
		$wherearr=array(
			'anchor_id'=>$anchor_id,	//主播id
			'video'=>$postArr['video'], 		//视频路径
			'screen_pic'=>$postArr['img_url'],   //封面路径
			'name'=>$postArr['video_name'],		//视频名称
			'pic'=>$postArr['pic'],				//视频封面
			'attr_id'=>$postArr['dict_id'],		//视频标签
			'type'=>$postArr['id'],				//视频类型(1直播2短视频)
			'dest_id'=>$postArr['dest_id'],		//目的地
			'line_ids'=>$postArr['lineId'],		//关联线路
			'user_type'=>3,						//0普通用户1达人2领队3管家
			'status'=>1,						//状态1正常0下架2删除3首页推荐				
			'dest_name'=>$postArr['city_name'],	//所属目的地
			'sort'=>$sort,						//排序
			'addtime'=>time(),					//视频保存时间
			'room_id'=>'-1',					//后台标识
			'room_code'=>'',
			'time'=>0,
			'people'=>0,
			'collect'=>0,
			'record_id'=>0,
			'video_height'=>$postArr['src_h'],
			'video_width'=>$postArr['src_w']				
		);
		$result=$this->live_db->insert('live_video',$wherearr);
		if($result){
			$this->callback->setJsonCode ( 2000 ,'添加成功');
		}else {
			$this->callback->setJsonCode ( 4000 ,'添加失败,请重新尝试');
		}
	}
	
	/**
	 *@method:插入用户信息
	 * @author: zyf
	 * @param: $user_id:用户id；$user_type:用户类型 0:用户 ,1:管家
	 */
	private function  insert_live_anchor($user_id){
		$data = array();
		$user_id = intval($user_id);
		$sql = 'SELECT nickname,small_photo,country,mobile,sex,country,province,city FROM u_expert WHERE id= '.$user_id;
		$user =  $this->db->query($sql )->row_array();
		if($user_id >0 && !empty($user))	//管家注册主播
		{ 
			$data['name']=$user['nickname']; //真实姓名
			$data['photo']=$user['small_photo']; //头像图片
			$data['country']=$user['country']; //国家id
			$data['type']=3; //0普通用户1达人2领队3管家
			//添加的数据
			$data['user_id']=$user_id;
			$data['user_type']=1; //注册类型
			$data['status']=2;//主播状态
			$data['mobile']=$user['mobile']; //手机号
			$data['sex']=$user['sex']; //性别
			$data['country']=($data['country']?$data['country']:0); //国家
			$data['province']=($user['province']?$user['province']:0); //省份id
			$data['city']=($user['city']?$user['city']:0); //城市id
			$this->live_db->insert("live_anchor",$data);
			$anchor_id=$this->live_db->insert_id();
			return $anchor_id;
		}
		else 
		{
			return 0;
		}
	}
	//获取视频
	public function getVideoData()
	{
		$postArr = $this->security->xss_clean($_POST);
		$page = isset($postArr['page']) ? intval($postArr['page']) : 1;
		$page = empty($page) ? 1 : $page;
		$pageSize = isset($postArr['pageSize']) ? intval($postArr['pageSize']) : 10;
		$pageSize = empty($pageSize) ? 10 : $pageSize;
		$str= ' limit '.($page-1)*$pageSize.','.$pageSize;
		$sql = "select a.user_id,l.line_ids,l.name,l.pic,FROM_UNIXTIME(l.addtime) as addtime,d.description,l.dest_name,l.sort,l.video
				from  live_video as l
				left join live_dictionary as d on l.attr_id=d.dict_id
				left join live_anchor as a on l.anchor_id=a.anchor_id
				where l.room_id='-1' and a.user_type=1 and l.type=".$postArr['status']." order by l.addtime desc";
		$sqls=$sql.$str;
		$live_data=$this->live_db->query($sqls)->result_array();
		if (empty($live_data))
		{
			$data['data'] = '';
			$data['count']=0;
			echo json_encode($data);exit();
		}
		$expert_where = array();
		$line_where = array();
		foreach ((array)$live_data as $key=>$val){
			$val['user_id'] && $expert_where[$val['user_id']] = $val['user_id'];
			$val['line_ids'] = rtrim($val['line_ids'],',');
			$val['line_ids'] && $line_where[$val['line_ids']] = $val['line_ids'];
		}
		$lines = trim(ltrim(implode(",",$line_where),'L'),',');
		if (empty($lines))
		{
			$line_data = array(array('id'=>0,'linename'=>''));
		}
		else 
		{
			$line_sql="select id,linename from u_line where id in (".$lines.')';
			$line_data = $this->db->query($line_sql)->result_array();
		}
		$expert_sql="select id,realname from u_expert where id in (".trim(implode(",",$expert_where),',').')';
		$expert_data = $this->db->query($expert_sql)->result_array();	
		foreach ((array)$live_data as $k=>$v)
		{
			foreach ((array)$line_data as $kl=>$vl)
			{
				if ($vl['id'] == trim(ltrim($v['line_ids'],'L'),','))
				{
					$v['linename'] = $vl['linename'];
				}
			}
			foreach ((array)$expert_data as $ek=>$el)
			{
				if ($el['id'] == $v['user_id'])
				{
					$v['realname'] = $el['realname'];
				}
			}
			$live_data[$k]=$v;
		}
		$num = $this->live_db->query("SELECT COUNT(*) AS num FROM (".$sql.") va", array())->result();
		$count = $num[0]->num;
		$data['data']=$live_data;
		$data['count']= $count;	
		echo json_encode($data);
	}

}