<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Bridge_expert_resume_model extends MY_Model {
	
	private $table_name = 'bridge_expert_resume';

	public function __construct() {
		parent::__construct ( $this->table_name );
	}
}