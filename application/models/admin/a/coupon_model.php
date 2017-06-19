<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年6月23日09:28
 * @author		jiakairong
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Coupon_model extends MY_Model {

	private $table_name = 'cou_coupon';
	
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method 获取所有状态线路列表
	 * @author 贾开荣
	 * @since 2015-06-12
	 * @param array $whereArr 查询条件
	 * @param number $page 当前页
	 * @param number $num  每页条数
	 * @param array $like like搜索条件
	 * @param intval $is_page 是否需要分页(一般用户统计总条数)
	 */
	
	public function get_coupon_data($whereArr, $page = 1, $num = 10 ,$is_page = 1 , $like= array() ) {
		$this->db->select ("*");
		$this->db->from ( $this->table_name);
	
		$this->db->where ( $whereArr );
		if (!empty($like) && is_array($like))
		{
			foreach($like as $key =>$val)
			{
				$this ->db ->like($key,$val);
			}
		}

		$this ->db ->order_by('id' ,'desc');
		if ($is_page == 1) {
			$num = empty ( $num ) ? 10 : $num;
			$offset = (empty ( $page ) ? 0 : ($page - 1)) * $num;
			$this->db->limit ( $num, $offset );
		}
	
		$query = $this->db->get ();
		return $query->result_array ();
	}
	/**
	 * @method 优惠券配置列表
	 * @author xml
	 * @param  $param  搜索参数
	 */
	public function member_coupon($param,$page){
		$query_sql='';
		$query_sql.=' SELECT cp.name,cp.use_range,cp.min_price,cp.coupon_price,cp.starttime,cp.endtime,cp.id as coupon_id,m.nickname as truename ';
		$query_sql.=' from  cou_coupon as cp ';
		$query_sql.=' LEFT JOIN cou_member_coupon as mc on cp.id=mc.coupon_id ';
		$query_sql.=' LEFT JOIN u_member as m on m.mid=mc.member_id where cp.id>0 ';
 		if($param!=null){
			if(null!=array_key_exists('coupon_name', $param)){
				$query_sql.=' and cp.name like ? ';
				$param['coupon_name'] = $param['coupon_name'];
			}
			if(null!=array_key_exists('member_name', $param)){
				$query_sql.=' AND m.nickname  like ? ';
				$param['member_name'] = '%'.$param['member_name'].'%';
			}
		} 
		$query_sql.=' ORDER BY mc.id desc';
		return $this->queryPageJson( $query_sql , $param ,$page);
	}
	//所有的优惠券
	function get_coupon_alldata(){
	    $this->db->select(' id,name');
		$this->db->from('cou_coupon');
		$query =$this->db->get();
		return $query->result_array();
	}
	//添加会员优惠券
	function insert_mcoupon($coupon_id,$coupon,$memberid){	
		$this->db->trans_start();
		if(!empty($coupon)){
			foreach ($coupon as $k=>$v){
				if($v>0){  
					for($i=$v;$i>0;$i--){  //遍历每张的数量
							$insert=array(
							'coupon_id'=>$coupon_id[$k],
							'member_id'=>$memberid,
							'status'=>0,
							);
						$this->db->insert('cou_member_coupon',$insert);
					} 
				}
			}
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}else{
			return true;
		}
	}
	/*会员信息*/
	function get_memberid($moblie){
		$this->db->select('*');
		$this->db->from('u_member');
		$query_sql=$this->db->where($moblie);
		return $this->db->query($query_sql)->row_array();	
	}
}