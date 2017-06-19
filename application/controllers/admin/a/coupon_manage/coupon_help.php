<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2017-03-10
 * @author		zyf
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Coupon_Help extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
	}
	
	public function index()
	{
		$this->view('admin/a/coupon_manage/coupon_help');
	}
	
	
	/**
	 * 获取优惠劵帮助数据
	 * @author zyf
	 * @since 2017-03-10
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
		$sql = "select id,title,content,showorder,is_modify,is_show,FROM_UNIXTIME(add_time) as add_time from u_coupon_help";
		$sqls=$sql.$str;
		$product_data=$this->db->query($sqls)->result_array();
		$num = $this->db->query("SELECT COUNT(*) AS num FROM (".$sql.") va", array())->result();
		$count = $num[0]->num;
		$data['data']=$product_data;
		$data['count']= $count;
		echo json_encode($data);
	}
	
	/**
	 * 添加优惠劵帮助信息数据
	 * @author zyf
	 * @since 2017-03-10
	 * @param null
	 * @return json
	 */
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);		
		$data = $this->common_data($postArr);
		$result=$this->db->insert('u_coupon_help',$data);
		if($result){
			$this->callback->setJsonCode ( 2000 ,'添加成功');
		}else {
			$this->callback->setJsonCode ( 4000 ,'添加失败,请重新尝试');
		}	
	}
	
	/**
	 * 获取优惠劵帮助信息数据
	 * @author zyf
	 * @since 2017-03-10
	 * @param null
	 * @return json
	 */
	public function get_edit_data()
	{
		$id=intval($this->input->post('id',true));
		if (empty($id)) $this->callback->setJsonCode ( 4000 ,'id不能为空');
		$where=array('id'=>$id);
		$this->db->select('id,title,content,showorder,is_modify,is_show');
		$this->db->where($where);
		$data=$this->db->get('u_coupon_help')->row_array();
		echo json_encode($data);
	}
	
	
	/**
	 * 修改优惠劵帮助信息数据
	 * @author zyf
	 * @since 2017-03-10
	 * @param null
	 * @return json
	 */
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
		$data = $this->common_data($postArr);
		$where=array('id'=>intval($postArr['id']));
		$result=$this->db->update('u_coupon_help',$data,$where);
		if($result){
			$this->callback->setJsonCode ( 2000 ,'修改成功');
		}else {
			$this->callback->setJsonCode ( 4000 ,'修改失败,请重新尝试');
		}
	}
	
	/**
	 * 删除优惠劵帮助信息数据
	 * @author zyf
	 * @since 2017-03-10
	 * @param null
	 * @return json
	 */
	public function del()
	{
		$id=intval($this->input->post('id',true));
		$ret = $this->db->where('id', $id)->delete('u_coupon_help');
		if($ret){
			$this->callback->setJsonCode ( 2000 ,'删除成功');
		}else {
			$this->callback->setJsonCode ( 4000 ,'删除失败,请重新尝试');
		}
	}
	
	/**
	 * 公共处理方法
	 * @author zyf
	 * @since 2017-03-10
	 * @param $postArr post到的数据
	 * @return array
	 */
	public function common_data($postArr)
	{
		if (empty($postArr['title']))    $this->callback->setJsonCode ( 4000 ,'请填写优惠劵标题');
		if (empty($postArr['content']))    $this->callback->setJsonCode ( 4000 ,'请填写优惠劵内容');
		if(mb_strlen($postArr['title'],'utf8')>30) $this->__errormsg("优惠劵标题不能超过30个字符");
		if(mb_strlen($postArr['content'],'utf8')>100) $this->__errormsg("优惠劵内容不能超过100个字符");
		$showorder=empty($postArr['order'])?999:intval($postArr['order']);//排序
		$data=array(
				'title'=>$postArr['title'],
				'content'=>$postArr['content'],
				'is_modify' =>intval($postArr['is_modify']),
				'is_show' =>intval($postArr['is_show']),
				'showorder'=>$showorder,
				'add_time'=>time()
		);
		return $data;
	}
}