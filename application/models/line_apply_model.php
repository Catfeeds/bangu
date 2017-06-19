<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Line_apply_model extends MY_Model {

	function __construct() {
		parent::__construct ( 'u_line_apply' );
	}
	
	/**
	 * 获取管家申请的线路
	 * @param unknown $whereArr
	 */
	public function getApplyData($whereArr)
	{
		$sql = 'select la.line_id,la.status,la.id from u_line_apply as la left join u_line as l on l.id=la.line_id '.$this->getWhereStr($whereArr);
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 用于平台的管家售卖权管理
	 * @author jiakairong
	 * @since  2016-03-16
	 * @param array $whereArr
	 */
	public function getLineApplyData(array $whereArr = array() ,$findInSet = '')
	{
		$sql = 'select l.linename,l.agent_rate_int,s.company_name AS supplier_name,e.realname AS expert_name,la.id as apply_id,la.expert_id,la.grade,group_concat(sp.cityname) as cityname,eg.title as grade_name from u_line_apply as la left join u_line as l on la.line_id = l.id left join u_line_startplace as ls on ls.line_id = l.id left join u_startplace as sp on sp.id = ls.startplace_id left join u_expert as e on la.expert_id = e.id left join u_supplier as s on l.supplier_id = s.id left join u_expert_grade as eg on eg.grade = la.grade';
		return $this ->getCommonData($sql ,$whereArr ,'la.id desc' ,'group by la.id',$findInSet);
	}
	/**
	 * @method 获取详细
	 * @since  2016-03-16
	 * @param unknown $applyId
	 */
	public function getApplyDetail($applyId)
	{
		$sql = 'select la.*,l.linename,s.company_name,e.realname,eg.title as grade_name from u_line_apply as la left join u_line as l on l.id=la.line_id left join u_supplier as s on s.id=l.supplier_id left join u_expert as e on e.id=la.expert_id left join u_expert_grade as eg on eg.grade = la.grade where la.id ='.$applyId;
		return $this ->db ->query($sql) ->result_array();
	}
}