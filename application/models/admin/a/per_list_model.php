<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Per_list_model extends MY_Model {
	
	private $table_name = 'u_admin';
	function __construct() {
		parent::__construct ( $this->table_name );
	}
}