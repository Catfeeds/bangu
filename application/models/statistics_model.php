<?php
/**
 *
 * @copyright 深圳海外国际旅行社有限公司
 *           
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Statistics_model extends MY_Model {
	private $table_name = 'm_sourceOverview';
	public function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	public function add($insertData) {
		$this->db->trans_start ();
		$this->db->insert ( 'm_sourceOverview', $insertData );
		$suit_id = $this->db->insert_id ();
		$this->db->trans_complete ();
		// 		if ($this->db->trans_status () === FALSE) {
		// 			echo false;
		// 		} else {
		// 			return $suit_id;
		// 		}
	}
	
	public function chk($sid) {
		$sql = 'SELECT `uuid` FROM m_sourceOverview WHERE uuid=?';
		$param['uuid']=$sid;
    	return $this->db->query($sql,$param) ->row_array();
	}
}