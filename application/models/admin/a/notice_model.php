<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Notice_model extends MY_Model {

	private $table_name = 'u_notice';

	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method 获取消息数据
	 * @since  2016-01-15
	 * @author jiakairong
	 * @param array $whereArr
	 */
	public function getNoticeData(array $whereArr)
	{
		$whereStr = '';
		foreach($whereArr as $key =>$val)
		{
			$whereStr .= ' '.$key.'"'.$val.'" and';
		}
		$whereStr = empty($whereStr) ? '' : ' where '.rtrim($whereStr ,'and');
		$sql = 'select n.*,a.realname from u_notice as n left join u_admin as a on a.id=n.admin_id'.$whereStr;
		$data['count'] = $this ->getCount($sql, array());
		$data['data'] = $this ->db ->query($sql.' order by n.id desc '.$this ->getLimitStr()) ->result_array();
		return $data;
	}
}