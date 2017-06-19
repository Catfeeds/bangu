<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class B_contract_launch_model extends MY_Model {
	public $table="b_contract_launch";
	
	public function __construct() {
		parent::__construct ( 'b_contract_launch' );
	}
	
	public function getChapterData($unionId) {
		$sql = 'select * from b_contract_chapter where union_id ='.$unionId;
		return $this ->db ->query($sql) ->row_array();
	}
	
	/**
	 * @method 通过管家申请合同
	 * @author jkr
	 * @param unknown $id
	 */
	public function throughApplyContract($employee ,$applyData)
	{
		$this->db->trans_start();
		//获取合同编号
		$sql = 'select * from b_contract_templet where type='.$applyData['type'].' for update';
		$templetData = $this ->db ->query($sql) ->row_array();
		
		if (empty($templetData)) {
			//没有合同模板
			$this->db->trans_complete();
			return false;
		}
		
		
		//写入合同表
		$sql = 'insert into b_contract_launch(type,contract_code,apply_id,union_id,status) values';
		$i = 0;
		$code = $templetData['code'];
		for($i ;$i< $applyData['num'] ;$i++)
		{
			$contract_code = $templetData['prefix'].($code+$i);
			$sql .= "({$applyData['type']},'$contract_code',{$applyData['id']} ,{$employee['union_id']} ,0),";
		}
		$this ->db ->query(rtrim($sql ,','));
		
		//更新合同模板编号
		//$endCode = $applyData['num']+1;
		$sql = 'update b_contract_templet set code = code+'.$applyData['num'].' where type='.$applyData['type'];
		$this ->db ->query($sql);
		
		//更新领取表
		$dataArr = array(
				'status' =>1,
				'modtime' =>date('Y-m-d H:i:s' ,time()),
				'employee_id' =>$employee['id'],
				'employee_name' =>$employee['realname'],
				'start_code' =>$templetData['prefix'].$templetData['code'],
				'end_code' =>$templetData['prefix'].($templetData['code']+$applyData['num']-1)
		);
		$this ->db ->where('id' ,$applyData['id']) ->update('b_contract_apply' ,$dataArr);
		
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	
	public function getApplyContractRow($id)
	{
		$sql = 'select * from b_contract_apply where id ='.$id;
		return $this ->db ->query($sql) ->row_array();
	}
	
	/**
	 * @method 获取管家申请合同数据
	 * @author jkr
	 * @param array $whereArr
	 * @param string $orderBy
	 */
	public function getContractApplyT33(array $whereArr=array() ,$orderBy = 'id desc')
	{
		$sql = 'select * from b_contract_apply ';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}
	
	/**
	 * @method 获取未使用合同数据
	 * @author jkr
	 * @param array $whereArr
	 * @param string $orderBy
	 */
	public function getContractApplyData(array $whereArr=array() ,$orderBy = 'cl.id desc')
	{
		$sql = 'select ca.*,cl.contract_code,cl.id as launch_id,cl.expert_id as launch_expert_id,cl.expert_name as launch_expert_name from b_contract_launch as cl left join b_contract_apply as ca on cl.apply_id = ca.id';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}
	
	
	public function getContractFile($contractId)
	{
		$sql = 'select * from b_contract_file where contract_launch_id ='.$contractId;
		return $this ->db ->query($sql) ->row_array();
	}
	
	/**
	 * @method 获取国内合同详细
	 * @author jkr
	 * @param unknown $code
	 * @param unknown $type
	 */
	public function getDomesticContract($code)
	{
		$sql = 'select * from b_domestic_contract where contract_code="'.$code.'"';
		return $this ->db ->query($sql) ->row_array();
	}
	
	/**
	 * @method 获取出境合同详细
	 * @author jkr
	 * @param unknown $code
	 * @param unknown $type
	 */
	public function getAbroadContract($code)
	{
		$sql = 'select * from b_abroad_contract where contract_code="'.$code.'"';
		return $this ->db ->query($sql) ->row_array();
	}
	
	/**
	 * @method 获取合同数据
	 * @author jkr
	 * @param array $whereArr
	 * @param string $orderBy
	 */
	public function getContractData(array $whereArr=array() ,$orderBy = 'id desc')
	{
		$sql = 'select * from b_contract_launch ';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy);
	}
	
	/**
	 * @method 管家发起合同
	 * @author jkr
	 */
	public function insertContract($contractData ,$contractArr ,$dataArr ,$fileArr)
	{
		$this->db->trans_start();
		
		//更新合同
		$this ->db ->where('id' ,$contractData['id']) ->update('b_contract_launch' ,$contractArr);
		
		if ($contractData['type'] == 1) {
			$this ->db ->insert('b_abroad_contract' ,$dataArr);
		} else {
			$this ->db ->insert('b_domestic_contract' ,$dataArr);
		}
		
		$this ->db ->insert('b_contract_file' ,$fileArr);
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	/**
	 * @method 用户签名更新
	 * @author jkr
	 */
	public function updateContractUser($contractId ,$contractArr ,$dataArr)
	{
		$this->db->trans_start();
		
		$this ->db ->where('id' ,$contractId) ->update('b_contract_launch' ,$contractArr);
		
		$this ->db ->where('contract_launch_id' ,$contractId) ->update('b_contract_file' ,$dataArr);
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
}