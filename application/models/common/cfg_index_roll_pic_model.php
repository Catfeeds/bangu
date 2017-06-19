<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Cfg_index_roll_pic_model extends MY_Model {

	private $table_name = 'cfg_index_roll_pic';

	public function __construct() {
		parent::__construct ( $this->table_name );
	}
}