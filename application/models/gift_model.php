<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Gift_model extends MY_Model {
	
	function __construct() {
		parent::__construct ( 'luck_gift' );
	}
	
	public function get_giftlist($whereArr ,$page=1 ,$num=10 ) {
			$this->db->select('lm.member_id,lm.status as lstatus,lg.status as lgstatus,l.linename,l.linetitle,lm.line_id,lg.*');
			$this->db->from('luck_gift_member as lm');
			$this->db->join('luck_gift as lg', 'lg.id=lm.gift_id', 'left');
			$this->db->join('u_line as l', 'l.id=lm.line_id', 'left');
			$this->db->where($whereArr);
			if ($page > 0) {
				$offset = ($page-1) * $num;
				$this->db->limit($num, $offset);
			}
		
			$this->db->order_by('lm.addtime',"desc");
			return $this->db->get()->result_array();
	}
}
