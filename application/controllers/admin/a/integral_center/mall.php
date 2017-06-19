<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2017-01-16
 * @author		zyf
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Mall extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
	}
	
	public function index()
	{
		$data['data']=$this->db->query("select id,name from u_member_integral_column")->result_array();
		$this->view('admin/a/integral_center/mall',$data);
	}
	
	
	/**
	 * 获取商品数据
	 * @author zyf
	 * @since 2017-01-16
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
		$sql = "SELECT c.name,u.p_id,u.p_name,u.p_show_pic,u.p_pic,u.p_integral_price,u.p_price,u.p_market_price,u.use_integral,u.deductible_price,u.p_content,u.stock,u.p_attr_type,u.p_describe,u.p_type,u.p_sold, FROM_UNIXTIME(u.p_time) AS p_time,u.p_sort
				FROM u_member_integral_product as u
				LEFT JOIN u_member_integral_column as c
				ON u.p_type=c.id
				WHERE u.p_if_not={$postArr['status']}
				ORDER BY u.p_time DESC";
		$sqls=$sql.$str;
		$product_data=$this->db->query($sql)->result_array();
		$num = $this->db->query("SELECT COUNT(*) AS num FROM (".$sql.") va", array())->result();
		$count = $num[0]->num;
		$data['data']=$product_data;
		$data['count']= $count;
		echo json_encode($data);
	}
	
	/**
	 * 添加商品数据
	 * @author zyf
	 * @since 2017-01-16
	 * @param null
	 * @return json
	 */
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		$data = $this->common_data($postArr,'add');	
		$result=$this->db->insert('u_member_integral_product',$data);
		if($result){
			$this->callback->setJsonCode ( 2000 ,'添加成功');
		}else {
			$this->callback->setJsonCode ( 4000 ,'添加失败,请重新尝试');
		}	
	}
	
	/**
	 * 获取商品编辑数据
	 * @author zyf
	 * @since 2017-01-16
	 * @param null
	 * @return json
	 */
	public function get_edit_data()
	{
		$p_id=intval($this->input->post('p_id',true));
// 		$p_id=1;
		if (empty($p_id)) $this->callback->setJsonCode ( 4000 ,'id不能为空');
		$where=array('p_id'=>$p_id);
		$this->db->select('p_id,p_name,p_show_pic,p_pic,p_integral_price,p_price,p_market_price,use_integral,deductible_price,p_content,p_describe,p_sold,p_type,p_attr_type,p_sort,stock');
		$this->db->where($where);
		$data=$this->db->get('u_member_integral_product')->row_array();
		echo json_encode($data);
// 		echo $this->db->last_query();
	}
	
	
	/**
	 * 修改商品数据
	 * @author zyf
	 * @since 2017-01-16
	 * @param null
	 * @return json
	 */
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
		$data = $this->common_data($postArr,'edit');
		$where=array('p_id'=>intval($postArr['id']));
		$result=$this->db->update('u_member_integral_product',$data,$where);
		if($result){
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
		$ret = $this->db->where('p_id', $p_id)->delete('u_member_integral_product');
		if($ret){
			$this->callback->setJsonCode ( 2000 ,'删除成功');
		}else {
			$this->callback->setJsonCode ( 4000 ,'删除失败,请重新尝试');
		}
	}
	
	/**
	 * 公共处理方法
	 * @author zyf
	 * @since 2017-01-19
	 * @param $postArr post到的数据
	 * @return array
	 */
	public function common_data($postArr,$controlls)
	{
		if (empty($postArr['p_name']) || mb_strlen($postArr['p_name'],'utf8')>18)    $this->callback->setJsonCode ( 4000 ,'请填写18个字以内的产品标题');
		if (empty($postArr['p_show_pic']))    $this->callback->setJsonCode ( 4000 ,'请上传产品封面图');
		if (empty($postArr['p_pic1']))    $this->callback->setJsonCode ( 4000 ,'请上传产品详情图1');
		if (!empty($postArr['p_content']))
		{
			if (mb_strlen($postArr['p_content'],'utf8')>10) $this->callback->setJsonCode ( 4000 ,'备注不能超过10个字');
		}
		if(empty($postArr['p_describe']))	$this->callback->setJsonCode ( 4000 ,'请填写产品描述');
		if (empty($postArr['p_attr_type']))   $this->callback->setJsonCode ( 4000 ,'请选择产品类型');
		if ($postArr['p_attr_type']==1){
			if (empty($postArr['p_price']))    $this->callback->setJsonCode ( 4000 ,'请填写产品原价');
			if (empty($postArr['p_market_price']))    $this->callback->setJsonCode ( 4000 ,'请填写市场价');
			if (empty($postArr['use_integral']))    $this->callback->setJsonCode ( 4000 ,'请填写使用多少积分');
			if (empty($postArr['deductible_price']))    $this->callback->setJsonCode ( 4000 ,'请填写抵扣多少元');	
			if($postArr['p_price']>$postArr['p_market_price']) $this->callback->setJsonCode ( 4000 ,'产品价不能大于市场价哦');
			if($postArr['deductible_price']>$postArr['p_price']) $this->callback->setJsonCode ( 4000 ,'产品价不能低于抵扣价哦');
			$postArr['p_integral_price']=$postArr['p_price']-$postArr['deductible_price']; //积分价格
		}elseif($postArr['p_attr_type']==2){
			if (empty($postArr['p_integral_price']))    $this->callback->setJsonCode ( 4000 ,'请填写积分价格');
		}else {
			$this->callback->setJsonCode ( 4000 ,'参数非法');
		}
		if ($controlls == 'add'){
			if (empty($postArr['stock'])) $this->callback->setJsonCode ( 4000 ,'库存不能为空或0');
			$stock=intval($postArr['stock']);//库存
		}else{
			$stock=empty($postArr['stock'])?0:intval($postArr['stock']);//库存
		}
		
		if (empty($postArr['p_type']))   $this->callback->setJsonCode ( 4000 ,'请选择所属栏目');
		$p_sold=empty($postArr['p_sold'])?mt_rand(10,20):intval($postArr['p_sold']); //已售
		$sort=empty($postArr['order'])?999:intval($postArr['order']);  //排序
		$pic_data=array(
				$postArr['p_pic1'],
				$postArr['p_pic2'],
				$postArr['p_pic3'],
				$postArr['p_pic4'],
				$postArr['p_pic5'],
		);
		$pic_data = implode(',',array_filter($pic_data));
		$data=array(
				'p_name'=>$postArr['p_name'],
				'p_show_pic'=>$postArr['p_show_pic'],
				'p_pic'=>$pic_data,
				'p_integral_price'=>$postArr['p_integral_price'],
				'p_content'=>$postArr['p_content'],
				'p_describe'=>$postArr['p_describe'],
				'p_sold'=>$p_sold,
				'p_time'=>time(),
				'p_type'=>intval($postArr['p_type']),
				'p_sort'=>$sort,
				'stock'=>$stock,
				'p_price'=>intval($postArr['p_price']),
				'p_market_price'=>intval($postArr['p_market_price']),
				'use_integral'=>intval($postArr['use_integral']),
				'deductible_price'=>intval($postArr['deductible_price']),
				'p_attr_type'=>intval($postArr['p_attr_type']),
		);
		return $data;
	}
	
	
	/**
	 * 修改商品状态
	 * @author zyf
	 * @since 2017-01-17
	 * @param null
	 * @return json
	 */
	public function edit_status()
	{
		$p_id=intval($this->input->post('p_id',true));
		$status=intval($this->input->post('p_status',true));
		if ($status == 1)
		{
			$status=2;
		}else if($status == 2)
		{
			$status=1;
		}else
		{
			$this->callback->setJsonCode ( 4000 ,'参数错误');
		}
		$data=array('p_if_not'=>$status);
		$where=array('p_id'=>$p_id);
		$ret = $this->db->update('u_member_integral_product',$data,$where);
		if($ret){
			if ($status == 1){
				$this->callback->setJsonCode ( 2000 ,'上架成功');
			}else if($status == 2){
				$this->callback->setJsonCode ( 2000 ,'下架成功');
			}			
		}else {
			if ($status == 1){
				$this->callback->setJsonCode ( 4000 ,'上架失败,请重新尝试');
			}else if($status == 2){
				$this->callback->setJsonCode ( 4000 ,'下架失败,请重新尝试');
			}
			
		}
	}
}