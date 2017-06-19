<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class B_single_affiliated_model extends MY_Model {

	public function __construct() {
		parent::__construct ( 'b_single_affiliated' );
	}
    
	/*
	 * 单项产品详情
	 * */
	public function single_detail($id)
	{
		$sql="
				select 
						sa.*,d.kindname as dest_name,l.linecode,l.overcity2,l.status,l.supplier_id,l.linename,l.book_notice,ra.server_name,s.company_name,
				        lsp.number,lsp.day,lsp.adultprice,lsp.adultprofit,lsp.childprice,lsp.childprofit,lsp.childnobedprice,
				        lsp.childnobedprofit,lsp.oldprice,lsp.oldprofit,
				        ba.type,ba.object,ba.agent_rate,ba.adult as adult_agent,ba.old as old_agent,ba.child as child_agent,ba.childnobed as childnobed_agent,
				        (select us.cityname from u_line_startplace as ls left join u_startplace as us on us.id=ls.startplace_id where ls.line_id=sa.line_id) as startplace,
				        (select startplace_id from u_line_startplace where line_id=sa.line_id) as startplace_id,ba.id as single_agent_id
				from 
					    b_single_affiliated as sa
				        left join u_line as l on l.id=sa.line_id
				        left join u_line_suit_price as lsp on lsp.lineid=sa.line_id
				        left join b_single_agent as ba on ba.line_id=sa.line_id
				        left join u_supplier as s on s.id=l.supplier_id
				        left join b_server_range as ra on ra.id=sa.server_range
				        left join u_dest_base as d on d.id=l.overcity2
				where 
					    sa.id='{$id}'
			 ";
		$output=$this->db->query($sql)->row_array();
		return $output;
	}
	
	
}