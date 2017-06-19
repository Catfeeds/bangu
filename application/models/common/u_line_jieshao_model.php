<?php
/**
 * 网站配置模型
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_line_jieshao_model extends MY_Model {
	
	/**
	 * 模型表名称
	 * @var String
	 */
	private $table_name = 'u_line_jieshao';
	
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ( $this->table_name );
	}
	/**
	 * @method 获取线路行程
	 * @author jiakairong
	 */
	public function getLineJieShao($whereArr) {
		$this ->db ->select('lj.*,ljp.pic');
		$this ->db ->from($this->table.' as lj');
		$this ->db ->join('u_line_jieshao_pic as ljp' ,'ljp.jieshao_id = lj.id' ,'left');
		$this ->db ->where($whereArr);
		$this ->db ->order_by('lj.day asc');
		return $this ->db ->get() -> result_array();
	}
}