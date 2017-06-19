<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Line_one_model extends MY_Model {

	private $table_name = 'u_line';
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	/**
	 * @method 获取线路的最小价格
	 * @author jiakairong
	 * @since  2015-06-15
	 */
	public function get_line_min_price ($whereArr) {
		$this->db->select ('adultprice,id');
		$this->db->from ( 'u_line_suit_price as lsp');
		$this->db->join ( 'u_line_suit as ls', 'ls.id=lsp.suitid', 'left' );
		
		$this->db->where ( $whereArr );
		$this->db->order_by("lsp.adultprice", "desc");
		$this->db->limit( '1,0' );
		$query = $this->db->get ();
		return $query->result_array ();
	}
}