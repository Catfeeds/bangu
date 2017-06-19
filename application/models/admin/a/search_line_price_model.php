<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Search_line_price_model extends MY_Model {
	
	function __construct() {
		parent::__construct ( 'cfg_search_line_price' );
	}
	
}