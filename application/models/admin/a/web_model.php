<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Web_model extends MY_Model {
	
	private $table_name = 'cfg_web';

	function __construct() {
		parent::__construct ( $this->table_name );
	}
}