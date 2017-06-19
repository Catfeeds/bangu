<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Article_attr_model extends MY_Model {
	
	private $table_name = 'u_article_attr';

	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method 获取显示在首页的数量
	 * @author jiakairong
	 */
	public function getIshomeCount() {
		$sql = 'select count(*) as count from u_article_attr where ishome = 1';
		$count = $this ->db ->query($sql)->result_array();
		if (empty($count)) {
			return 0;
		} else {
			return $count[0]['count'];
		}
	}
	/**
	 * @method 获取分类下的文章数量
	 * @author jiakairong
	 */
	public function getAttrArticleCount($attrid) {
		$sql = 'select count(*) as count from u_article where attrid='.$attrid;
		$count = $this ->db ->query($sql)->result_array();
		if (empty($count)) {
			return 0;
		} else {
			return $count[0]['count'];
		}
	}
}