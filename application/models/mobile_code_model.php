<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Mobile_code_model extends MY_Model {
	
	function __construct() {
		parent::__construct ( 'u_mobile_code' );
	}
}