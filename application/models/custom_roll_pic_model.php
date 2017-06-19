<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Custom_roll_pic_model extends MY_Model {
	
	function __construct() {
		parent::__construct ( 'cfg_custom_roll_pic' );
	}
	
}