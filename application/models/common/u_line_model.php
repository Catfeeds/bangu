<?php
/**
 * 线路模型
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_line_model extends MY_Model {

	private $table_name = 'u_line';

	public function __construct() {
		parent::__construct ( $this->table_name );
	}

	/**
	 * @method 线路数据，用于平台的线路选择
	 * @author jiakairong
	 */
	public function getCommonLineData($whereArr ,$page=1 ,$num=10) {
		$whereStr = '';
		$limieStr = '';
		if (is_array($whereArr)) {
			foreach($whereArr as $key=>$val) {
				if ($key == 'keyword') {
					$whereStr .= " (l.linename like '%{$val}%' or s.company_name like '%{$val}%') and";
				} elseif ($key == 'l.overcity') {
					$whereStr .= "  find_in_set ({$val} , {$key}) > 0 and";
				} else {
					$whereStr .= " $key=$val and";
				}
			}
			$whereStr = rtrim($whereStr ,'and');
		}
		$limieStr = ' limit '.($page - 1) * $num.','.$num;

		$sql = 'select l.linename,sp.cityname,s.company_name,l.mainpic,l.id as lineid,l.overcity from u_line as l left join u_supplier as s on s.id=l.supplier_id left join u_startplace as sp on sp.id=l.startcity where '.$whereStr.$limieStr;
		return $this ->db ->query($sql) ->result_array();
	}

	/**
	 * @method 获取线路信息，现用于c端下订单
	 * @param unknown $where
	 */
	public function getLineInfo($where) {
		$this ->db ->select('l.id,l.linename,s.cityname,l.linetitle,l.overcity,l.lineday,l.book_notice,l.feeinclude,l.status,l.feenotinclude,l.visa_content,l.agent_rate,l.agent_rate_int,l.agent_rate_child,l.mainpic,l.confirm_time,supplier_id,l.safe_alert,l.special_appointment,l.line_beizhu,l.line_kind,aff.deposit');
		$this ->db ->from('u_line as l');
		$this ->db ->join('u_startplace as s','l.startcity=s.id' ,'left');
		//开完会再来修改
		$this ->db ->join('u_line_affiliated as aff','aff.line_id=l.id' ,'left');
		$this ->db ->where($where);
		return $this->db->get () ->result_array();
	}
}