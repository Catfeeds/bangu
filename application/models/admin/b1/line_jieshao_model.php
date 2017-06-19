<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Line_jieshao_model extends MY_Model {
	function __construct() {
		parent::__construct ( 'u_line_jieshao' );
	}
	function get_line_jieshao($where){

		$query = $this->db->query('select j.*,p.pic,l.line_beizhu  from u_line_jieshao as j LEFT JOIN u_line_jieshao_pic as p on j.id=p.jieshao_id LEFT JOIN u_line AS l ON l.id = j.lineid  where l.lineday>=j.day and  j.lineid= '.$where.' order by j.day asc ');
		$rows = $query->result_array();
		return $rows;

	}
}