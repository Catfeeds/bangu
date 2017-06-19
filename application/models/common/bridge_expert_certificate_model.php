<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Bridge_expert_certificate_model extends MY_Model {
	
	private $table_name = 'bridge_expert_certificate';

	public function __construct() {
		parent::__construct ( $this->table_name );
	}
}