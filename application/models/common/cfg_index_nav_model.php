<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Cfg_index_nav_model extends MY_Model {

	private $table_name = 'cfg_index_nav';

	public function __construct() {
		parent::__construct ( $this->table_name );
	}
}