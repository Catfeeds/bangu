<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Expert_upgrade_model extends MY_Model {

	function __construct() {
		parent::__construct ( 'u_expert_upgrade' );
	}
	/**
	 * @method 用于平台的管家升级管理
	 * @author jiakairong
	 * @since  2016-03-16
	 * @param array $whereArr
	 */
	public function getUpgradeData(array $whereArr = array() ,$findInSet = '')
	{
		$sql = 'select l.linename AS line_title,l.agent_rate_int,s.company_name AS supplier_name,e.realname AS expert_name,eu.grade_after,eu.grade_before,eu.status,eu.id as upgrade_id,eu.expert_id,eu.line_id,eu.apply_remark,eu.refuse_remark from (SELECT * FROM u_expert_upgrade AS en ORDER BY en.addtime DESC) AS eu left join u_line as l on eu.line_id = l.id left join u_line_startplace as ls on ls.line_id = l.id left join u_startplace as sp on sp.id=ls.startplace_id left join u_expert as e on eu.expert_id = e.id left join u_supplier as s on l.supplier_id = s.id';
		return $this ->getCommonData($sql ,$whereArr ,'eu.id desc' ,'group by eu.line_id,eu.expert_id',$findInSet);
	}
	
	public function getUpgradeDetail($upgradeId)
	{
		$sql = 'select eu.*,l.linename as line_title,l.agent_rate_int as money,s.company_name as supplier_name,e.realname as expert_name from u_expert_upgrade as eu left join u_line as l on eu.line_id = l.id left join u_supplier as s on s.id = l.supplier_id left join u_expert as e on e.id= eu.expert_id where eu.id ='.$upgradeId;
		return $this ->db ->query($sql) ->result_array();
	}
}