<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Activity_ticke_model extends MY_Model {


    function __construct() {
        parent::__construct('activity_ticket');
    }
    	public function get_activity()
	{
		$sql = 'select count(id) as sum from activity_ticket ';
		$data=$this ->db ->query($sql) ->row_array();

		$sql0="select count(id) as usersum from activity_ticket where isuse=1";
		$data0=$this ->db ->query($sql0) ->row_array();

		if(!empty($data)){
			$re['sum']=$data['sum'];
		}else{
			$re['sum']=0;	
		}

		if(!empty($data0)){
			$re['usersum']=$data0['usersum'];
		}else{
			$re['usersum']=0;
		}
		return $re;
	}
	//入场人数
	function get_member_data($param,$page=1 ,$num=10){
		$sql="select id,name,mobile,isuse,code_pic from activity_ticket";
		//$sql.=" where upo.payable_id={$id}";
		if ($param != null) {	
			/*if (null != array_key_exists ( 'u_starttime', $param )) {
				$param['u_starttime'] = trim($param['u_starttime']);
				$sql .= '  AND mom.usedate >= "'.$param['u_starttime'].'" ';	
			}*/			
		}
		$data['count'] = $this ->getCount($sql, array());
		$limieStr = ' limit '.($page - 1) * $num.','.$num;
		$sql .=' ORDER BY id asc '.$limieStr;
		$data['data'] =$this ->db ->query($sql) ->result_array();
		return  $data;
	}
}