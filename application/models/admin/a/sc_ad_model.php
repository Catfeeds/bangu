<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年01月15日11:35:53
 * @author		汪晓烽
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Sc_ad_model extends MY_Model {

	private $table_name = 'sc_fix_desc';

	function __construct() {
		parent::__construct ($this->table_name );
	}
}