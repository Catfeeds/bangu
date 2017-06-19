<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class u_member_points_log_model extends MY_Model {
	
	private $table_name = 'u_member_points_log';

	public function __construct() {
		parent::__construct ( $this->table_name );
	}
	
}