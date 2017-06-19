<?php
/*
 * do one sql one model by zhy at 2016年2月18日 15:13:16
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Wx_activity_model extends MY_Model {
	private $table_name = 'wx_activity';
	
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	
}