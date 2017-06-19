<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年7月20日18:00:11
 * @author		汪晓烽
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Line_grade_model extends MY_Model {

	/**
	 * 获取路线售卖级别集合
	 */
	public function get_line_grade_list($whereArr, $page = 1, $num = 10,$expert_id) {
/*		SELECT
	l.id,l.linecode AS '线路编号',l.linename AS '线路标题',l.lineprice AS '售价',
	l.agent_rate AS '佣金比例',l.satisfyscore AS '满意度',l.comment_count AS '评论数',
	l.peoplecount AS '销量人数',eg.title AS '级别',s.company_name AS '供应商名称'
	FROM u_line AS l LEFT JOIN u_line_apply AS la ON l.id=la.line_id
	LEFT JOIN u_supplier AS s ON l.supplier_id=s.id
	LEFT JOIN u_expert_grade AS eg ON la.grade=eg.grade
	WHERE la.expert_id=1 AND l.supplier_id=30 AND FIND_IN_SET(10249,l.overcity)>0 AND l.linename LIKE '%1%'
*/
		$whereStr = "";
		if (!empty($whereArr) && is_array($whereArr)) {
			foreach($whereArr as $key =>$val) {
				if ($key == 'l.overcity') {
					foreach ($val as $k => $v) {
						$whereStr .= "find_in_set($v,l.overcity)>0 OR ";
					}
					$whereStr = rtrim($whereStr,' OR ');
				}
			}
			unset($whereArr['l.overcity']);
		}

		$whereArr['la.expert_id'] = $expert_id;
		$whereArr['la.status']=2;
		$this->db->select("	l.id,
					l.linecode AS linecode,
					l.linename AS linename,
					l.lineprice AS lineprice,
					l.agent_rate AS agent_rate,
					l.satisfyscore AS satisfyscore,
					l.comment_count AS comment_count,
					l.peoplecount AS peoplecount,
					eg.title AS grade,
					s.company_name AS company_name,
					s.mobile AS mobile
					");
		$this->db->from(' u_line AS l ');
		$this->db->join('u_line_apply AS la', 'l.id=la.line_id', 'left');
		$this->db->join('u_supplier AS s', 'l.supplier_id=s.id', 'left');
		$this->db->join('u_expert_grade AS eg', 'la.grade=eg.grade', 'left');
		$this->db->order_by('la.addtime','DESC');
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
		}
		if(!empty($whereStr)){
			$this->db->where($whereStr);
		}

		$this->db->where($whereArr);
		$query = $this->db->get();
		 $result = $query->result_array();
		 array_walk($result, array($this, '_fetch_list'));
		return $result;
	}

	function get_supplier(){
		$this->db->select("id,company_name");
		$this->db->where(array('status'=>2));
		$this->db->from('u_supplier');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_destinations(){
                   $this->db->select('id,kindname');
                   $this->db->from('u_dest_base');
                   $result=$this->db->get()->result_array();
                   return $result;
          }

          /**
	 * 回调函数
	 * @param unknown $value
	 * @param unknown $key
	 */
	protected function _fetch_list(&$value, $key) {
			$value['agent_rate']=(empty($value['agent_rate'])||$value['agent_rate']==0) ? 0 : ($value['agent_rate']*100).'%';
			$value['satisfyscore']=(empty($value['satisfyscore'])||$value['satisfyscore']==0) ? 0 : ($value['satisfyscore']*100).'%';
			if(empty($value['comment_count'])){
				$value['comment_count']=0;
			}
			if(empty($value['peoplecount'])){
				$value['peoplecount']=0;
			}
	}
}