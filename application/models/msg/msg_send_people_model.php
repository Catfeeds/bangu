<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Msg_send_people_model extends MY_Model {
	protected  $table= 'msg_send_people';

	public function __construct()
	{
		parent::__construct ( $this->table );
		$this->db = $this->load->database ( 'msg' ,true);
	}
	
}