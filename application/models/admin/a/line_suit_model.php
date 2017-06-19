<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Line_suit_model extends MY_Model {

	private $table_name = 'u_line_suit';
	
	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ( $this->table_name );
	}
}