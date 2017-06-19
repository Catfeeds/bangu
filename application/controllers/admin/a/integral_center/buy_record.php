<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2017-01-17
 * @author		zyf
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Buy_record extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
	}
	
	public function index()
	{
		$this->view('admin/a/integral_center/buy_record');
	}
	
	/**
	 * 购买记录
	 * @author zyf
	 * @since 2017-01-17
	 * @param null
	 * @return json
	 */
	public function list_buy_record()
	{
		$postArr = $this->security->xss_clean($_POST);
		$where='';
		if (!empty($postArr['order_id'])){
			$where.=" b.order_id='".trim($postArr['order_id'])."' and";
		}
		if (!empty($postArr['p_type'])){
			$where.=" b.attr_type='".$postArr['p_type']."' and";
		}
		if (!empty($postArr['p_name'])){
			$where.=" b.p_name='".trim($postArr['p_name'])."' and";
		}
		if (!empty($postArr['addressee'])){
			$where.=" a.addressee='".trim($postArr['addressee'])."' and";
		}
		if (!empty($postArr['s_mobile'])){
			$where.=" a.number='".trim($postArr['s_mobile'])."' and";
		}
		if (!empty($postArr['status'])){
			$where.=" b.status='".$postArr['status']."' and";
		}
		$where= empty($where) ? '' :' where '.rtrim($where ,'and');
		$page = isset($postArr['page']) ? intval($postArr['page']) : 1;
		$page = empty($page) ? 1 : $page;
		$pageSize = isset($postArr['pageSize']) ? intval($postArr['pageSize']) : 10;
		$pageSize = empty($pageSize) ? 10 : $pageSize;
		$str= ' limit '.($page-1)*$pageSize.','.$pageSize;
		$sql = "SELECT a.addressee,a.number,a.pro_name,a.city_name,a.address,b.attr_type,b.log_id,u.nickname,b.order_id,b.p_name,b.p_pic,b.price,b.integral_price,b.num,(b.integral_price*b.num) AS sum_integral,(b.price*b.num) AS sum_price, FROM_UNIXTIME(b.buy_time) AS buy_time
				FROM u_member_buy_record AS b
				LEFT JOIN u_member AS u ON u.mid=b.m_id
				LEFT JOIN u_member_area AS a ON b.address_id=a.id ".$where ."
				ORDER BY b.buy_time DESC ";
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
	 * 修改订单状态
	 * @author zyf
	 * @since 2017-01-17
	 * @param null
	 * @return json
	 */
	public function edit_status()
	{
		$log_id=intval($this->input->post('log_id',true));
		$status=intval($this->input->post('p_status',true));
		if ($status == 1)
		{
			$status=2;
		}else if($status == 2)
		{
			$status=3;
		}else 
		{
			$this->callback->setJsonCode ( 4000 ,'参数错误');
		}
		$data=array('status'=>$status);
		$where=array('log_id'=>$log_id);
		$ret = $this->db->update('u_member_buy_record',$data,$where);
		if($ret){
			$this->callback->setJsonCode ( 2000 ,'修改成功');
		}else {
			$this->callback->setJsonCode ( 4000 ,'修改失败,请重新尝试');
		}
	}
	
	
	/**
	 * 删除商品数据
	 * @author zyf
	 * @since 2017-01-16
	 * @param null
	 * @return json
	 */
	public function del()
	{
		$p_id=intval($this->input->post('p_id',true));
		$ret = $this->db->where('p_id', $p_id)->delete('u_member_buy_record');
		if($ret){
			$this->callback->setJsonCode ( 2000 ,'删除成功');
		}else {
			$this->callback->setJsonCode ( 4000 ,'删除失败,请重新尝试');
		}
	}
}