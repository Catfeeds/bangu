<?php
/**
 * 管家模型
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Travel_note_praise_model extends MY_Model {

	/**
	 * 模型表名称
	 * @var String
	 */
	private $table_name = 'travel_note_praise';

	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ( $this->table_name );
	}
}