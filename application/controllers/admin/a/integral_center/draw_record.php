<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2017-01-17
 * @author		zyf
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Draw_record extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
	}
	
	public function index()
	{
		$this->view('admin/a/integral_center/draw_record');
	}
	
	/**
	 * 抽奖记录
	 * @author zyf
	 * @since 2017-03-20
	 * @param null
	 * @return json
	 */
	public function list_draw_record()
	{
		$postArr = $this->security->xss_clean($_POST);
		$where='';
		if (!empty($postArr['mobile'])){
			$where.=" u.mobile='".$postArr['mobile']."' and";
		}
		if (!empty($postArr['p_type'])){
			$where.=" b.p_type='".$postArr['p_type']."' and";
		}
		if ($postArr['status']==1){
			$where.=" b.if_send=0 and";
		}else{
			$where.=" b.if_send=1 and";
		}
		if (!empty($postArr['p_name'])){
			$where.=" b.p_title='".$postArr['p_name']."' and";
		}
		if (!empty($postArr['addressee'])){
			$where.=" m.addressee='".$postArr['addressee']."' and";
		}
		if (!empty($postArr['s_mobile'])){
			$where.=" m.number='".$postArr['s_mobile']."' and";
		}
		$where= empty($where) ? '' :' where '.rtrim($where ,'and');
		$page = isset($postArr['page']) ? intval($postArr['page']) : 1;
		$page = empty($page) ? 1 : $page;
		$pageSize = isset($postArr['pageSize']) ? intval($postArr['pageSize']) : 10;
		$pageSize = empty($pageSize) ? 10 : $pageSize;
		$str= ' limit '.($page-1)*$pageSize.','.$pageSize;
		$sql = "SELECT m.addressee,m.number,m.pro_name,m.city_name,m.address,b.p_id,u.nickname,u.mobile,b.p_title,b.p_pic,b.p_type,b.if_send,b.id, FROM_UNIXTIME(b.get_time) AS get_time
				FROM u_member_prize_record AS b
				LEFT JOIN u_member AS u ON u.mid=b.u_id 
				LEFT JOIN u_member_area AS m ON m.id=b.address_id ".$where ." 
				ORDER BY b.get_time DESC ";
		$sqls=$sql.$str;
		$product_data=$this->db->query($sqls)->result_array();
// 		echo $this->db->last_query(); exit();
		$num = $this->db->query("SELECT COUNT(*) AS num FROM (".$sql.") va", array())->result();
		$count = $num[0]->num;
		$data['data']=$product_data;
		$data['count']= $count;
		echo json_encode($data);
	}
	
	/**
	 * 修改奖品状态
	 * @author zyf
	 * @since 2017-04-07
	 * @param null
	 * @return json
	 */
	public function edit_status()
	{
		$log_id=intval($this->input->post('id',true));
		$status=intval($this->input->post('p_status',true));
		if ($status == 1)
		{
			$if_send=1;
		}else
		{
			$this->callback->setJsonCode ( 4000 ,'参数错误');
		}
		$data=array('if_send'=>$if_send);
		$where=array('id'=>$log_id);
		$ret = $this->db->update('u_member_prize_record',$data,$where);
		if($ret){
			$this->callback->setJsonCode ( 2000 ,'修改成功');
		}else {
			$this->callback->setJsonCode ( 4000 ,'修改失败,请重新尝试');
		}
	}
	
}