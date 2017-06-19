<?php

/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月26日10:50:53
 * @author		汪晓烽
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Supplier_model extends MY_Model {

	private $table_name = 'u_supplier';

	function __construct() {
		parent::__construct ( $this->table_name );
	}

}