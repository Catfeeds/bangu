<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Cou_member_action_model extends MY_Model
{
	private $table_name = 'cou_member_action';

	public function __construct()
	{
		parent::__construct ( $this->table_name );
	}
	
}