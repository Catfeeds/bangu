<?php 
/****
 * 深圳海外国际旅行社
* 艾瑞可
* 2015-3-18
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_admin extends CI_Controller {

	function __construct(){
		parent::__construct();
		//$this->load->helper("url");
		$this->load->database();
		$this->load->helper('url');
		mysql_query("set names utf8;");
	}
	public function index()
	{
		//$query=$this->db->query('select * from u_line as l  join u_supplier as u on l.supplier_id=u.id');
		$this->db->select('u_supplier.linkman,u_supplier.city,u_line.approve_status,u_supplier.id');
		$this->db->from('u_line');
		$this->db->join('u_supplier','u_supplier.id=u_line.supplier_id');
		$query=$this->db->get();
		foreach($query->result() as $row){
		//print_r($row);
			$data['approve_status']=$row->approve_status;
			$data['linkman']=$row->linkman;
			$data['city']=$row->city;
			$id=$row->id;
			
		
		}
		
		$count=$this->db->query("select * from u_line where supplier_id=$id group by supplier_id");
		$counts=$count->num_rows();
		//print_r($count);
		$data_view = array('data' => $data,
					'date' => $counts,
				);
	//	print_r($data_view);
		//print_r($data_view['date']['num_rows']);
		$this->load->view('admin/b1/header.html');
		$this->load->view('admin/b1/user_admin_list',$data_view);
		$this->load->view('admin/b1/footer.html');
		
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */