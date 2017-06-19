<?php
/**
 * 管家申请线路售卖权模型
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_line_apply_model extends MY_Model {
	
	private $table_name = 'u_line_apply';
	
	public function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method 获取线路的申请管家,现用于前台下单，线路详情，订单页管家筛选
	 * @param unknown $whereArr
	 * @param number $page
	 * @param number $num
	 * @param string $order_by
	 */
	public function getLineExpert(array $whereArr ,$page = 1,$num = 10 ,$order_by = 'la.id desc') {
		$whereStr = '';
		foreach($whereArr as $key=>$val)
		{
			if (empty($val)) continue;
			if ($key == 'e.nickname')
			{
				$whereStr .= ' '.$key.' like "%'.$val.'%" and';
			}
			if ($key == 'is_kf')
			{
				$whereStr .= ' e.is_kf !="'.$val.'" and';
			}
			else 
			{
				$whereStr .= ' '.$key.'="'.$val.'" and';
			}
		}
		$whereStr = rtrim($whereStr ,'and');
		$limitStr = ' limit '.($page-1)*$num.','.$num;
		$sql = 'select e.id as eid,e.small_photo,e.expert_type,e.realname,e.nickname,e.mobile,la.status,la.grade,e.depart_id,e.agent_id,e.supplier_id from u_line_apply as la left join u_expert as e on e.id = la.expert_id left join u_line as l on l.id = la.line_id where '.$whereStr.' and la.grade >= l.sell_grade group by e.id';
		
		$data['count'] = $this ->getCount($sql ,array());
		$sql = $sql.' order by '.$order_by.$limitStr;
		$data['list'] = $this ->db ->query($sql) ->result_array();
		return $data;
	}
	
}