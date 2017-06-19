<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Expert_grade_model extends MY_Model {
	private $table_name = 'u_expert_grade';
	
	function __construct() {
		parent::__construct ( $this->table_name );
	}
}