<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2017-03-10
 * @author		zyf
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Draw extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
	}
	
	public function index()
	{
		$this->view('admin/a/integral_center/draw');
	}
	
	
	/**
	 * 获取奖品数据
	 * @author zyf
	 * @since 2017-03-20
	 * @param null
	 * @return json
	 */
	public function get_data()
	{
		$postArr = $this->security->xss_clean($_POST);
		$page = isset($postArr['page']) ? intval($postArr['page']) : 1;
		$page = empty($page) ? 1 : $page;
		$pageSize = isset($postArr['pageSize']) ? intval($postArr['pageSize']) : 10;
		$pageSize = empty($pageSize) ? 10 : $pageSize;
		$str= ' limit '.($page-1)*$pageSize.','.$pageSize;
		$sql = "select url,p_type,p_id,p_title,showorder,is_modify,is_show,p_pic,win_probability,FROM_UNIXTIME(add_time) as add_time from cfgm_member_prize order by add_time desc";
		$sqls=$sql.$str;
		$product_data=$this->db->query($sqls)->result_array();
		$num = $this->db->query("SELECT COUNT(*) AS num FROM (".$sql.") va", array())->result();
		$count = $num[0]->num;
		$data['data']=$product_data;
		$data['count']= $count;
		echo json_encode($data);
	}
	
	/**
	 * 添加奖品数据
	 * @author zyf
	 * @since 2017-03-20
	 * @param null
	 * @return json
	 */
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);		
		$data = $this->common_data($postArr,'add');
		$result=$this->db->insert('cfgm_member_prize',$data);
		if($result){
			$this->callback->setJsonCode ( 2000 ,'添加成功');
		}else {
			$this->callback->setJsonCode ( 4000 ,'添加失败,请重新尝试');
		}	
	}
	
	/**
	 * 获取奖品数据
	 * @author zyf
	 * @since 2017-03-20
	 * @param null
	 * @return json
	 */
	public function get_edit_data()
	{
		$id=intval($this->input->post('p_id',true));
		if (empty($id)) $this->callback->setJsonCode ( 4000 ,'id不能为空');
		$where=array('p_id'=>$id);
		$this->db->select('url,p_type,p_id,p_title,showorder,is_modify,is_show,p_pic,win_probability');
		$this->db->where($where);
		$data=$this->db->get('cfgm_member_prize')->row_array();
		echo json_encode($data);
	}
	
	
	/**
	 * 修改奖品数据
	 * @author zyf
	 * @since 2017-03-20
	 * @param null
	 * @return json
	 */
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
		$data = $this->common_data($postArr,'edit');
		$where=array('p_id'=>intval($postArr['p_id']));
		$result=$this->db->update('cfgm_member_prize',$data,$where);
		if($result){
			$this->callback->setJsonCode ( 2000 ,'修改成功');
		}else {
			$this->callback->setJsonCode ( 4000 ,'修改失败,请重新尝试');
		}
	}
	
	/**
	 * 删除奖品数据
	 * @author zyf
	 * @since 2017-03-20
	 * @param null
	 * @return json
	 */
	public function del()
	{
		$id=intval($this->input->post('p_id',true));
		$ret = $this->db->where('p_id', $id)->delete('cfgm_member_prize');
		if($ret){
			$this->callback->setJsonCode ( 2000 ,'删除成功');
		}else {
			$this->callback->setJsonCode ( 4000 ,'删除失败,请重新尝试');
		}
	}
	
	/**
	 * 公共处理方法
	 * @author zyf
	 * @since 2017-03-20
	 * @param $postArr post到的数据
	 * @return array
	 */
	public function common_data($postArr,$controlls)
	{
		if (empty($postArr['p_title']))    $this->callback->setJsonCode ( 4000 ,'请填写奖品名称');
		if (empty($postArr['p_pic']))    $this->callback->setJsonCode ( 4000 ,'请上传奖品图片');
		if (!is_numeric($postArr['win_probability'])) $this->callback->setJsonCode ( 4000 ,'中奖概率请填写数字');
		if (empty($postArr['p_type']))    $this->callback->setJsonCode ( 4000 ,'请选择分类');
		$showorder=empty($postArr['order'])?999:intval($postArr['order']);//排序
		$win_data=$this->db->query("select win_probability from cfgm_member_prize")->result_array();
		$num=count($win_data);
		$total_num=0;
		foreach ($win_data as $key=>$val)
		{
			$total_num+=array_sum($val);
		}
		$win_num=$total_num+$postArr['win_probability'];//概率总和
		if ($controlls == 'add'){
			if ($num==12) $this->callback->setJsonCode ( 4000 ,'已有12个奖品，无法添加');
			if ($num==11 && $win_num==0)  $this->callback->setJsonCode ( 4000 ,'所有奖品的概率不能都为0%哦');
			if ($num==11 && $win_num==1200)  $this->callback->setJsonCode ( 4000 ,'所有奖品的概率不能都为100%哦');
		}else{
			if ($num==12 && $win_num==0)  $this->callback->setJsonCode ( 4000 ,'所有奖品的概率不能都为0%哦');
			if ($num==12 && $win_num==1200)  $this->callback->setJsonCode ( 4000 ,'所有奖品的概率不能都为100%哦');
		}
		$data=array(
				'p_title'=>$postArr['p_title'],
				'p_pic'=>$postArr['p_pic'],
				'win_probability'=>intval($postArr['win_probability']),
				'p_type'=>intval($postArr['p_type']),
				'is_modify' =>intval($postArr['is_modify']),
				'is_show' =>intval($postArr['is_show']),
				'showorder'=>$showorder,
				'add_time'=>time(),
				'url'=>$postArr['url']  //跳转地址
		);
		return $data;
	}
	
}