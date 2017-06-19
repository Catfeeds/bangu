<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Expert_grade_model extends MY_Model {
	
	function __construct() {
		parent::__construct ( 'u_expert_grade' );
	}
	
}