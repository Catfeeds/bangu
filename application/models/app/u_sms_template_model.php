<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_sms_template_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct ( 'u_sms_template' );
	}
	
}