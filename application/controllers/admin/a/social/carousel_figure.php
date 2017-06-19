<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2017-02-17
 * @author		zhangyunfa
 * @method 		社区轮播图
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Carousel_figure extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model('admin/a/cfgm_social_roll_pic_model','social_roll_pic_model');
	}

	public function index()
	{
		$this->view ( 'admin/a/social/carousel_figure');
	}
	
	public function getRollPicData()
	{
		$page = $this->input->post('page', true);
		$pageSize = $this->input->post('pageSize', TRUE);
		$page = $page ? (int)$page : 1;
		$pageSize = $pageSize ? (int)$pageSize : 10;
		$from = ($page - 1) * $pageSize;
		$limit = " LIMIT {$from}, {$pageSize}";
		$sql = "select * from cfgm_social_roll_pic where type=1 and kind<>9 order by kind desc,id desc";
		$sqls = $sql.$limit;
		$query = $this->db->query($sqls);
		$data = $query->result_array();
		$num = $this->db->query("SELECT COUNT(*) AS num FROM (".$sql.") va", array())->result();
		$count = $num[0]->num;
		foreach ($data as $key=>$val){
			$val['activity_name']='';
			$val['action_name']='';
			$val['activity_pic']='';
			$val['activity_describe']='';
			$val['share_url']='';
			$val['url']='';
			$val['param']='';
			if ($val['link_type']==2){
				$link_data=json_decode($val['link_param'],true);
				$val['activity_name']=$link_data['activity_name'];
				$val['action_name']=$link_data['action_name'];
				$val['activity_pic']=$link_data['activity_pic'];
				$val['activity_describe']=$link_data['activity_describe'];
				$val['share_url']=$link_data['share_url'];
				$val['url']=$link_data['url'];
				unset($val['link_param']);
			}
			if ($val['link_type']==1 || $val['link_type']==3){
				$val['param']=$val['link_param'];
				unset($val['link_param']);
			}

			$data[$key]=$val;
		}
		$roll_data['count']=$count;
		$roll_data['data']=$data;
		echo json_encode($roll_data);
	}
	//增加
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		
		$dataArr = $this ->commonFunc($postArr, 'add');
		$status = $this ->social_roll_pic_model ->insert($dataArr);
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'添加失败');
		}
		else
		{
			$this->callback->setJsonCode ( 2000 ,'添加成功');
		}
	}
	//编辑
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
		$dataArr = $this ->commonFunc($postArr, 'edit');
		$status = $this ->social_roll_pic_model ->update($dataArr ,array('id' =>intval($postArr['id'])));
		//echo $this ->db ->last_query();
		if (empty($status) && $status!=0)
		{
			$this->callback->setJsonCode ( 4000 ,'编辑失败');
		}
		else
		{
			$this->callback->setJsonCode ( 2000 ,'编辑成功');
		}
	}
	//添加编辑时公用
	public function commonFunc($postArr ,$type)
	{
		$showorder = intval($postArr['showorder']);
		
        if (0 == trim($postArr['kind']))
        {
            $this->callback->setJsonCode('4000', '请选择分类');
        }
        if (empty($postArr['pic']))
        {
        	$this->callback->setJsonCode ( '4000' ,'请上传轮播图');
        }
        $data= array(
        	'link_param'=>'',
        	'link'=>0,
			'pic' =>$postArr['pic'],
			'is_modify' =>intval($postArr['is_modify']),
			'is_show' =>intval($postArr['is_show']),
			'remark' =>trim($postArr['remark']),
			'showorder' =>empty($showorder) ? 999 : $showorder,
			'name' =>$postArr['name'],
            'kind' => trim($postArr['kind']),    
			'type'=>1,  //类型 1为轮播图 2为板块图    
        	'jump_url'=>''    
			);
        if (!empty($postArr['link'])){
        	if ($postArr['link']==14){
        		if (empty($postArr['activity_name'])) $this->callback->setJsonCode ( '4000' ,'请填写活动名称');
        		if (empty($postArr['action_name'])) $this->callback->setJsonCode ( '4000' ,'请填写模块名称');
        		if (empty($postArr['activity_pic'])) $this->callback->setJsonCode ( '4000' ,'请上传活动图片');
        		if (empty($postArr['activity_describe'])) $this->callback->setJsonCode ( '4000' ,'请填写活动描述');
        		if (empty($postArr['share_url'])) $this->callback->setJsonCode ( '4000' ,'请填写分享的地址');
        		if (empty($postArr['url'])) $this->callback->setJsonCode ( '4000' ,'请填写活动的地址');
        		$data['link_type']=2;
        		$param_data=array(
        				'activity_name'=>$postArr['activity_name'],
        				'action_name'=>$postArr['action_name'],
        				'activity_pic'=>$postArr['activity_pic'],
        				'activity_describe'=>$postArr['activity_describe'],
        				'share_url'=>$postArr['share_url'],
        				'url'=>$postArr['url']
        		);
        		$data['link_param']=json_encode($param_data);
        	}else if ($postArr['link']==15){
        		if (empty($postArr['jump_url'])) $this->callback->setJsonCode ( '4000' ,'请填写跳转页面url');
        		$data['link_type']=3;
        		$data['jump_url']=$postArr['jump_url'];
        	}else if ($postArr['link']==16){
        		if (empty($postArr['jump_url'])) $this->callback->setJsonCode ( '4000' ,'请填写跳转页面url');
        		$data['link_type']=4;
        		$data['jump_url']=$postArr['jump_url'];
        	}else
        	{
        		$data['link_type']=1;
        		$data['link_param']=$postArr['link_param'];

        	}        	
        	$data['link']=intval($postArr['link']);
        }
		return $data;
	}
	//获取某条数据
	public function getDetailJson ()
	{
		$id = intval($this ->input ->post('id'));
		$data=$this ->social_roll_pic_model ->row(array('id' =>$id));
		$data['activity_name']='';
		$data['action_name']='';
		$data['activity_pic']='';
		$data['activity_describe']='';
		$data['share_url']='';
		$data['url']='';
		$data['param']='';
		if ($data['link_type']==2){
			$link_data=json_decode($data['link_param'],true);
			$data['activity_name']=$link_data['activity_name'];
			$data['action_name']=$link_data['action_name'];
			$data['activity_pic']=$link_data['activity_pic'];
			$data['activity_describe']=$link_data['activity_describe'];
			$data['share_url']=$link_data['share_url'];
			$data['url']=$link_data['url'];
			unset($data['link_param']);
		}
		if ($data['link_type']==1 || $data['link_type']==3){
			$data['param']=$data['link_param'];
			unset($data['link_param']);
		}
		echo json_encode($data);
	}
	//删除特价线路
	function delHotLine()
	{
		$id = intval($this->input->post("id"));
		$status = $this ->social_roll_pic_model ->delete(array('id'=>$id));
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'删除失败');
		} 
		else
		{
			$this->callback->setJsonCode ( 2000 ,'删除成功');
		}
	}
}