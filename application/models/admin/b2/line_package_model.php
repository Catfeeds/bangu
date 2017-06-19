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

class Line_package_model extends MY_Model {

	/**
	 * 获取抱团路线集合
	 */
	public function get_package_list($whereArr, $page = 1, $num = 10)
	{
		if ($page > 0)
		{
			$offset = ($page-1) * $num;
			//$sql = 'select s.id  AS sid,l.id AS l_id,l.status,l.linecode,l.linename,l.lineprice,l.agent_rate_int AS agent_rate,l.agent_rate_child AS agent_rate_child,s.company_name from u_line_apply as la left join u_line as l on l.id=la.line_id left join u_supplier as s on s.id=l.supplier_id left join u_enquiry as e on l.id=e.line_id ';
			$sql='select s.id as sid,l.id as l_id,l.status,l.linecode,l.linename,l.lineprice,l.agent_rate_int as agent_rate,';
			$sql.='l.agent_rate_child as agent_rate_child,l.modtime,s.company_name,s.link_mobile,s.linkman,GROUP_CONCAT(pl.`cityname`) as startcity ';
			$sql.='from u_line_apply as la left join u_line as l on l.id = la.line_id ';
			$sql.='left join u_supplier as s on s.id = l.supplier_id left join u_line_startplace as lst  on l.`id` = lst.`line_id` ';
			$sql.='left join u_startplace as pl on pl.id = lst.`startplace_id` left join u_enquiry as e on l.id = e.line_id ';
			$sql .= $this ->getWhereStr($whereArr).'group by l.id order by l.id desc limit '.$offset.','.$num;
			return $this ->db ->query($sql) ->result_array();
		}
		else
		{
			$sql = 'select count(*) as num  from u_line_apply as la left join u_line as l on l.id = la.line_id left join u_supplier as s on s.id = l.supplier_id left join u_line_startplace as lst  on l.`id` = lst.`line_id` left join u_startplace as pl on pl.id = lst.`startplace_id` left join u_enquiry as e on l.id = e.line_id ';
			$sql .= $this ->getWhereStr($whereArr);
			$result = $this ->db ->query($sql) ->row_array();
			return $result['num'];
		}
		
		
		if($page > 0){
			$res_str = " s.id as sid,l.id as l_id,l.status,l.linecode,l.linename,l.lineprice,l.agent_rate_int as agent_rate, ";
			$res_str .= " l.agent_rate_child as agent_rate_child,l.modtime,s.company_name,s.link_mobile,s.linkman,GROUP_CONCAT(pl.`cityname`) as startcity ";
	
        }else{
            $res_str = 'count(*) AS num';
        }
		$this->db->select($res_str);
		$this->db->from('u_line_apply as la');
		$this->db->join('u_line as l','l.id = la.line_id ', 'left');
		$this->db->join('u_supplier as s ', 's.id = l.supplier_id ', 'left');
		$this->db->join('u_line_startplace as lst', 'l.`id` = lst.`line_id`', 'left');
		$this->db->join('u_startplace as pl', 'pl.id = lst.`startplace_id`', 'left');
		$this->db->join('u_enquiry as e', 'l.id = e.line_id', 'left');
		$whereArr['l.producttype'] = 1;
		$whereArr['la.line_id >'] = 0;
		
		$this->db->where($whereArr);
		
		//$this->db->order_by('id desc');
		$this->db->order_by('l.id','DESC');
		if ($page > 0) {
			$offset = ($page-1) * $num;
			$this->db->limit($num, $offset);
			$query = $this->db->get();
			return $query->result_array();
		}else{
			$query = $this->db->get();
			$ret_arr = $query->result_array();
			return $ret_arr[0]['num'];
		}
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
}