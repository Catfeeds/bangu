<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Member_model extends MY_Model {
	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ( 'u_member' );
	}

	/**
	 * @method 用户注册
	 * @param unknown $memberArr  用户注册信息
	 */
	public function memberRegister($memberArr)
	{
		$this->db->trans_start();

		$this ->db ->insert('u_member' ,$memberArr);
		$mid = $this ->db ->insert_id();
		//写入积分变化表
		if ($memberArr['jifen'] >0)
		{
			$memberLogArr = array(
					'member_id' =>$mid,
					'point_before' =>0,
					'point_after' =>$memberArr['jifen'],
					'point' =>$memberArr['jifen'],
					'content' =>'注册赠送积分',
					'addtime' =>$memberArr['logintime']
			);
			$this ->db ->insert('u_member_point_log' ,$memberLogArr);
		}

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			return false;
		} else {
			return $mid;
		}
	}

	/**
	 * @method 通过手机获取数据，一般用于验证手机号是否存在
	 * @author jiakairong
	 * @param unknown $mobile 手机号
	 */
	public function uniqueMobile($mobile) {
		$sql = 'select mid from u_member where mobile="'.$mobile.'" or loginname ="'.$mobile.'"';
		return $this ->db ->query($sql) ->result_array();
	}

	/**
	 * @method 用户登录获取信息
	 * @param string $loginname 登录名
	 * @author jiakairong
	 */
	public function getMemberLogin($loginname) {
		$sql = "select mid,loginname,truename,pwd,logintime,nickname from u_member where loginname='{$loginname}' or mobile='{$loginname}' or email='{$loginname}'";
		return $this ->db ->query($sql) ->result_array();
	}

		/**
		 * get member messager
		 *
		 * */
		function get_member_message($table,$where){

			 $this->db->select('mid,loginname,job,nickname ,sex ,email ,mobile ,truename ,cardid ,address ,postcode ,litpic,pwd,talk,label,jifen');
			 $this->db->where($where);
			 return  $this->db->get($table)->row_array();
		}


		/**
		 * updata member messager
		 *
		*/
		function updata_member_message($id,$data){
			$this->db->where('mid', $id);
			return $this->db->update('u_member', $data);
		}

		/**
		 * get order meassge
		 *
		*/
		public  function get_order_message($where,$whereArr, $page = 1, $num = 10){

			$this->db->select('mo.id,c.id as cid,l.overcity,mo.ordersn,mo.productautoid as line_id,mo.productname ,c.expert_content,c.pictures,c.score1,c.score2,c.score3,c.reply,c.reply1,c.reply2,c.isanonymous,c.avgscore1,c.avgscore2,'.
			'c.score4,c.score5,c.score6,c.level,c.avgscore1,c.avgscore2,mo.status,c.content ,c.addtime ,mo.memberid,c.level,( SELECT COUNT(com.id) FROM u_comment_complain AS com	WHERE c.id = com.comment_id )as "opare" ');
			$this->db->from('u_comment as c');
			$this->db->join('u_member_order as mo', 'c.orderid = mo.id', 'left');
			$this->db->join('u_line as l', 'mo.productautoid= l.id', 'left');
			//$this->db->where('mo.memberid ',$id);
			$this->db->where($whereArr);
			if ($page > 0) {
				$offset = ($page-1) * $num;
				$this->db->limit($num, $offset);
			}
			if(!empty($where)){
		    	$this->db->where($where);
			}
			$this->db->order_by('c.addtime desc');
			return $this->db->get()->result_array();

		}
		/**
		 *
		 */
		function get_order_travel($whereArr, $page = 1, $num = 10){
			$this->db->select(' mo.id as orderid,mo.productname,l.overcity,mo.expert_id, mo.ordersn,mo.productautoid,(mo.dingnum+mo.childnum+mo.oldnum+mo.childnobednum) as membernum ,mo.order_price,mo.usedate,c.id as cid');
			$this->db->from('u_member_order as mo');
			$this->db->join('u_line as l', 'mo.productautoid= l.id', 'left');
			$this->db->join('u_comment as c', 'c.orderid=mo.id and c.status=1', 'left');
			$this->db->where('(c.id is null) and mo.status>4');
			$this->db->where($whereArr);
			if ($page > 0) {
				$offset = ($page-1) * $num;
				$this->db->limit($num, $offset);
			}
			$this->db->order_by('mo.addtime desc');
			return $this->db->get()->result_array();
		}

		/**
	     *根据咨询表中产品id匹配线路表中线路id得到该线路名称,
	      *查询相关用户id的咨询信息
	    */
		public function get_line_message($whereArr, $page = 1, $num = 10){
			$this->db->select('l.id as line_id,q.id,l.linename ,q.addtime ,q.content ,q.replycontent ,q.status');
			$this->db->from('u_line_question as q');
			$this->db->join('u_line as l', 'q.productid = l.id', 'left');
			$this->db->where($whereArr);
			if ($page > 0) {
				$offset = ($page-1) * $num;
				$this->db->limit($num, $offset);
			}

			$this->db->order_by('q.addtime',"desc");
			return $this->db->get()->result_array();
		}
		/**
		 *
		*complain_type 是实体类型0 用户,1 B2 ,2 B1 ,3 平台
		*c.member_id 是用户id,用于指定某个用户的相关投诉
		*c.status 0 未处理,1 已处理
		*/
		public function get_line_complaint($whereArr, $page = 1, $num = 10){
			$this->db->select('c.id,c.addtime,c.complain_type,l.overcity,e.realname,c.supplier_reply,mo.productautoid as lineid,c.reason,mo.productname,mo.expert_name,c.status,c.mobile,c.remark,mo.ordersn,c.attachment ');
			$this->db->from(' u_complain as c');
			$this->db->join('u_member_order as mo', 'c.order_id = mo.id', 'left');
			$this->db->join('u_expert as e', 'e.id = mo.expert_id', 'left');
				$this->db->join('u_line as l', 'mo.productautoid = l.id', 'left');
			$this->db->where($whereArr);
			if ($page > 0) {
				$offset = ($page-1) * $num;
				$this->db->limit($num, $offset);
			}
			$this->db->order_by('c.addtime desc');
			return $this->db->get()->result_array();


		}
		/**
		 * 获取一条数据
		 * */
		function get_alldata($table,$where,$order=''){
			$this->db->select('*');
			$this->db->where($where);
			if(!empty($order)){
				$this->db->order_by($order.' desc');
			}
			
			return  $this->db->get($table)->row_array();
		}
		/**
		 * select all table
		 * */
		function get_data($table,$where,$order=''){
			$this->db->select('*');
			$this->db->where($where);
			if(!empty($order)){
			  $this->db->order_by($order.' asc');
			}
			return  $this->db->get($table)->result_array();
		}
		/**
		 * updata all table
		 *
		 * */
	   function updata_alldata($table,$where,$data){
	      	$this->db->where($where);
	       return	$this->db->update($table, $data);
	   }
	   /**
	    * insert table
	    *
	    * */
	   function insert_data($table,$data){
	    	$this->db->insert($table, $data);
	    	return $this->db->insert_id();
	   }
	   /**
	    * 我的咨询-未回复/已回复
	    */
	   function get_advice($where,$id){

		   	$this->db->select('count(qu.memberid) as num');
		   	$this->db->from('u_line_question as qu');
		   	$this->db->join('u_line as l', 'qu.productid=l.id', 'left');
		   	$this->db->where($where);
		  // 	$this->db->where('qu.memberid',$id);
		   	$this->db->group_by("qu.memberid");

		   	return $this->db->get()->result_array();
	   }

	   /**
	    * 我的投诉-0待处理/1已处理
	    */
	   function get_complaint($status,$id){
		   	$this->db->select('count(c.member_id) as num');
		   	$this->db->from('u_complain as c');
		   	$this->db->join('u_member_order as mo', 'c.order_id = mo.id', 'left');
		   	$this->db->where('c.status',$status);
		   	$this->db->where('c.member_id',$id);
		   	$this->db->group_by("c.member_id");
		   	return $this->db->get()->result_array();

	   }
	   /**
	    * 点评的状态
	    *
	    */
	   function on_comment($status,$id){
		   	if($status==0){ //未点评
		   		$sql ='';
	      			$sql .= "SELECT COUNT(mo.id) as num FROM (`u_member_order` AS mo) ";
	      			$sql .= " LEFT JOIN `u_line` AS l ON `mo`.`productautoid` = `l`.`id`";
	      			$sql .= " LEFT JOIN `u_comment` AS c ON `c`.`orderid` = `mo`.`id` AND c. STATUS = 1  ";
	      			$sql .= " WHERE 	(c.id IS NULL) AND mo. STATUS > 4 AND `mo`.`memberid` = {$id}";
	      			$data = $this->db->query($sql)->row_array();
	      			return      $data;
		   	}else{ //已点评
				$query_sql ='';
	      			$query_sql .= "SELECT count(c.id) AS num FROM (`u_comment` AS c) ";
	      			$query_sql .= " LEFT JOIN u_member_order AS me ON c.orderid = me.id ";
	      			$query_sql .= " WHERE c. STATUS = 1 AND me.memberid ={$id}  GROUP BY me.memberid ";
	      			$query = $this->db->query($query_sql)->row_array();
	      			return      $query;
	      
		   	}
	   }

	   /**
	    * 保存追评的数据
	    *
	    */
	   function save_gocomment($id,$content){
	  	 	$query_sql ='';
	      	$query_sql .= "UPDATE u_comment SET content=CONCAT(content,'".$content."') WHERE id=$id";
	      	$query = $this->db->query($query_sql);
	      	return $query;

	   }
      /**
       *@method 保存评论
       *@param $data
       * */
	   function save_commentData($data,$integral,$lineid,$userid,$expert_id){
		   	$this->db->trans_start();
		   	//会员信息
		   	$member=$this->get_alldata('u_member',array('mid'=>$userid));
	
		   	//获取线路的始发地
		   	$line= $this->get_alldata('u_line',array('id'=>$lineid));
		   //	$data['starcityid']=$line['startcity'];
		   	//插入评论表
		   	$commontid=$this->insert_data('u_comment',$data);
		   	//评论送积分
		   	$membersql = "UPDATE u_member SET jifen = jifen+$integral WHERE mid= {$userid}";
		   	$this->db->query($membersql);
		   	//插入积分记录表
		   	$jifenArr['member_id']=$userid;
		   	$jifenArr['point_before']=$member['jifen'];
		   	$jifenArr['point_after']=$member['jifen']+$integral;
		   	$jifenArr['point']=$integral;
		   	$jifenArr['content']='评论赠送积分';
		   	$jifenArr['addtime']=date('Y-m-d H:i:s',time());
		   	$this->db->insert('u_member_point_log',$jifenArr);
	
		   	//修改订单状态
		   	$ordersql = "UPDATE u_member_order SET status =6 WHERE id= {$data['orderid']}";
		   	$this->db->query($ordersql);
		    	//订单日志
		    	$log_data['order_id'] = $data['orderid'];
		    	$log_data['op_type'] = 0;
		    	$log_data['userid'] = $userid;
		   	$log_data['content'] = '用户点评';
		   	$log_data['order_status']=6;
		   	$log_data['addtime'] = date('Y-m-d H:i:s');
		   	$this->db->insert('u_member_order_log',$log_data);
		    
		  	//修改评论数量
		    	$query = $this->db->query('update u_line set comment_count=comment_count+1 where id='.$lineid);
		    
		    	//修改管家评论线路的数量
		    	$query_sql = $this->db->query('update u_expert set comment_count=comment_count+1 where id='.$expert_id);
		    
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
			    	return false;
			}else{
			    	return $commontid;
			}

	   }
	   /*我的定制单 制作中*/
	   function get_custom($where,$page = 1, $num = 10){
		   	$this->load->library('session');
		   	$userid=$this->session->userdata('c_userid');
		   	$query_sql ='SELECT ey.line_id AS line_id,l.status AS line_status,l.overcity,c.estimatedate,';	   
		   	$query_sql .='m.mid,c.id,c.startdate,(SELECT st.cityname  FROM u_startplace AS st  WHERE st.id=c.startplace) AS startplace,';
		   	$query_sql .='c.endplace,c.budget,c.days,c.people,c.total_people,c.service_range,c.childnum,COUNT(ca.id) AS "design_expert",';
		   	//$query_sql .='SUM(CASE WHEN ca.replytime IS NOT NULL THEN 1 ELSE 0 END ) AS "replies",';
		   	$query_sql .='SUM(ca.id) AS "replies", ';
		   	$query_sql .='CASE WHEN c.`status` =3 THEN "4" WHEN c.`status` = -3 THEN  "-3" ';
		   	$query_sql .=' WHEN c.`status` =- 2 THEN "-2" WHEN TIMESTAMPDIFF(HOUR, c.addtime, NOW()) > 24 AND c. STATUS = 0 THEN "0" ';
		   	$query_sql .=' WHEN COUNT(ca.id)=0 THEN "1" WHEN SUM(CASE WHEN ca.id IS NOT NULL AND ca.isuse = 1 THEN 1 ELSE 0 END )>0 THEN "2"';
		   	$query_sql .=' WHEN COUNT(ca.id)>0 THEN "3" END "status" ';
		   	$query_sql .=' FROM `u_customize` AS c';
		   	$query_sql .=' INNER JOIN `u_member` AS m ON `c`.`member_id` = `m`.`mid`';
		   	$query_sql .=' LEFT JOIN u_customize_answer AS ca ON ca.customize_id=c.id ';
		   	$query_sql .=' LEFT JOIN u_enquiry ey ON ey.expert_id=ca.expert_id AND ey.customize_id=c.id AND ey.line_id>0';
		   	$query_sql .=' LEFT JOIN u_line AS l ON ey.line_id = l.id ';
		   	$query_sql .=' WHERE `m`.`mid` ='.$userid.' GROUP BY id ORDER BY c.id DESC ';
		   	if ($page > 0) {
		   		$offset = ($page-1) * $num;
		   		//$this->db->limit($num, $offset);
		   		$query_sql .='limit ' .$offset.','.$num;
		   	}
		   	$query = $this->db->query($query_sql)->result_array();
		   	return $query;


	   }

	   /*我的咨询 已确认*/
	   function get_consult_data($id,$page = 1, $num = 10){
		   $query_sql ='';
		   $query_sql .= "SELECT lq.id,l.linename,e.realname,l.overcity,e.nickname,eg.title,lq.addtime,lq.content,lq.replycontent,l.id as line_id ,e.realname,eg.title,e.id as expert_id ";
		   $query_sql .="FROM	u_line_question AS lq  ";
		   $query_sql .= " LEFT JOIN  u_line AS l ON lq.productid = l.id ";
		   $query_sql .=" LEFT JOIN  u_member AS m ON lq.memberid = m.mid ";
		   $query_sql .=" LEFT JOIN  u_expert AS e ON lq.reply_id = e.id ";
		   $query_sql .="LEFT JOIN  u_expert_grade AS eg ON e.grade = eg.grade ";
		   $query_sql .="WHERE m.mid =".$id." AND ISNULL(lq.replytime) = 0 ";
		   if ($page > 0) {
		   	$offset = ($page-1) * $num;
		   	$query_sql .=' limit ' .$offset.','.$num;
		   }
		   $query = $this->db->query($query_sql)->result_array();
		   return $query;
	   }
	   //*我的咨询 回复*/
	   function get_noconsult_data($id,$page = 1, $num = 10){
		   	$query_sql ='';
		   	$query_sql .= "SELECT lq.id,l.linename,l.overcity,e.realname,e.nickname,eg.title,lq.addtime,lq.content,lq.replycontent,l.id as line_id,e.id as expert_id ";
		   	$query_sql .="FROM u_line_question AS lq ";
		   	$query_sql .= "LEFT JOIN u_line AS l ON lq.productid = l.id ";
		   	$query_sql .="LEFT JOIN u_member AS m ON lq.memberid = m.mid ";
		   	$query_sql .="LEFT JOIN u_expert AS e ON lq.reply_id = e.id ";
		   	$query_sql .="LEFT JOIN u_expert_grade AS eg ON e.grade = eg.grade ";
		   	$query_sql .="WHERE	m.mid =".$id." AND ISNULL(lq.replytime) > 0  ";
		   	if ($page > 0) {
		   		$offset = ($page-1) * $num;
		   		$query_sql .=' limit ' .$offset.','.$num;
		   	}
		   	$query = $this->db->query($query_sql)->result_array();
		   	return $query;
	   }
	   /*指定管家的信息*/
	   function get_expert_custom($where){
		   	$this->db->select('e.realname,e.mobile,e.weixin');
		   	$this->db->from('u_customize_answer as c');
		   	$this->db->join('u_expert as e', 'c.expert_id=e.id', 'left');
		   	$this->db->where($where);
		   	return $this->db->get()->row_array();
	   }
	   /*查看方案*/
	   function get_scheme_data($id){
	    	$query_sql ='';
	   		$query_sql .= "SELECT ca.expert_id as expert_id,ca.id,ca.title AS ca_title,ca.price_description,c.id as cid,e.id as eid,e.realname,ca.addtime ,ca.isuse,ISNULL(ca.replytime) as reply,e.small_photo,";
	   		$query_sql .= "ca.plan_design as  solution ";
	   		$query_sql .= "FROM u_customize_answer AS ca ";
	   		$query_sql .= "LEFT JOIN u_customize AS c ON ca.customize_id = c.id  ";
	   		$query_sql .= "LEFT JOIN u_expert AS e ON ca.expert_id = e.id WHERE c.id =".$id." ";
	   		$query_sql .=" ORDER BY ca.addtime desc";
	   	//	$query_sql .= "left join u_customize_answer as ca on cg.customize_id = ca.id where c.id=";
	   		$query = $this->db->query($query_sql)->result_array();
	   		return $query;
	   }
	   /* 行程设计 */
	   function get_route_data($id){
		   	$query_sql ='';
		   	$query_sql .= "select ans.plan_design,day,ans.title,cj.title as cjtitle,jieshao,cjp.pic,ans.attachment,ans.childprice as childpirce,ans.childnobedprice,ans.price,ans.price_description,ans.oldprice, ";
		   	$query_sql .=" cj.breakfirsthas,cj.breakfirst,cj.transport,cj.hotel,cj.lunchhas,cj.lunch,cj.supperhas,cj.supper,ans.id as caid,ans.customize_id as id,ans.expert_id,ans.isuse,ISNULL(ans.replytime) AS reply ";
		   	$query_sql .= " from u_customize_answer AS ans ";
		   	$query_sql .= " Left Join u_customize_jieshao as cj  on cj.customize_answer_id=ans.id ";
		   	$query_sql .= " left join u_customize_jieshao_pic as cjp on cj.id = customize_jieshao_id  ";
		   	$query_sql .= "where ans.id =".$id;
		   	$query = $this->db->query($query_sql)->result_array();
		   	return $query;
	   }
	  /*查看方案*/
	  function get_reply_scheme($id){
		  	$query_sql ='';
		  	$query_sql .= "SELECT c.linkname,c.linkphone,c.estimatedate,c.another_choose,c.linkphone,c.linkweixin,c.id,c.startdate,c.endplace,c.days ,c.trip_way as description,c.people,th.name as theme,c.catering,m.truename,m.mobile,m.weixin, ";
		  	$query_sql .= "c.isshopping as 'isshopping',c.total_people,c.oldman,c.childnobednum,c.childnum,c.roomnum,c.room_require,cu.expert_id AS expert_id,cu.id as caid, ";
		  	$query_sql .= "c.budget ,s.cityname as startplace,c.service_range,c.other_service,c.hotelstar as hotel, e.extra,cu.isuse,c.status,c.is_assign,ISNULL(cu.replytime) AS reply ";
		  	$query_sql .= "FROM u_customize AS c ";
		  	$query_sql .= "LEFT JOIN u_enquiry AS e ON c.id = e.customize_id ";
		  	$query_sql .= "LEFT JOIN u_dictionary AS d ON c.hotelstar = d.dict_id ";
		  	$query_sql .= "LEFT JOIN u_dictionary AS dc ON c.trip_way = dc.dict_id ";
		  	$query_sql .= "LEFT JOIN u_dictionary AS dt ON c.isshopping = dt.dict_id ";
		  	$query_sql .= "LEFT JOIN u_customize_answer as cu ON cu.customize_id=c.id ";
		  	$query_sql .= "LEFT JOIN u_theme as th on th.id=c.theme ";
		  	$query_sql .= "LEFT JOIN u_member as m on m.mid=c.member_id ";
		  	$query_sql .= "LEFT JOIN u_startplace as s on s.id=c.startplace ";
		  	$query_sql .= "WHERE c.id =".$id;
		  	$query = $this->db->query($query_sql)->row_array();
		  	return $query;
	  }
	  /*客户需求*/
	  function get_user_need($id){
	  	   $query_sql ='';
	  	   $query_sql .='SELECT c.linkname,c.linkphone,c.estimatedate,c.another_choose,c.linkweixin,c.id,c.roomnum,c.expert_id,c.startdate,c.status,c.service_range,c.childnum,c.other_service,c.budget,(SELECT st.cityname  FROM u_startplace AS st  WHERE st.id=c.startplace) AS startplace,c.endplace,c.days,c.trip_way as description,c.people,c.childnum,c.childnobednum,c.oldman,c.total_people,th.name as theme, c.hotelstar as hotel,c.room_require, ';
	  	   $query_sql .= "c.isshopping as 'isshopping',c.catering ,m.truename,m.mobile,m.weixin ";
	  	   $query_sql .=' FROM  `u_customize` as c ';
	  	   $query_sql .=' LEFT JOIN u_dictionary AS d ON c.hotelstar = d.dict_id ';
	  	   $query_sql .=' LEFT JOIN u_dictionary AS dc ON c.trip_way = dc.dict_id ';
	  	   $query_sql .=' LEFT JOIN u_theme as th on th.id=c.theme ';//
	  	   $query_sql .=' LEFT JOIN u_dictionary AS dt ON c.isshopping = dt.dict_id ';
	  	   $query_sql .=' LEFT JOIN u_member as m on m.mid=c.member_id ';
	  	   $query_sql .=' WHERE c.id ='.$id;
	  	   $query = $this->db->query($query_sql)->result_array();
	  	   return $query;
	  }

	  /*业务通知*/
	  function system_message($where,$page = 1, $num = 10){

		  	$this->db->select('id,m.title, m.addtime ,m.admin_id,m.modtime,m.read');
		  	$this->db->from('u_message AS m');
		  	$this->db->where('m.msg_type ',0);
		  	$this->db->where($where);
		  	if ($page > 0) {
		  		$offset = ($page-1) * $num;
		  		$this->db->limit($num, $offset);
		  	}
		   $this->db->order_by('m.addtime','desc');
		  	return $this->db->get()->result_array();

	  }


	  /*系统通知*/
	  function system_notice($where,$page = 1, $num = 10){
	  	//启用session
	  	$this->load->library('session');
	  	$userid=$this->session->userdata('c_userid');
	  	//$this->db->select('n.id ,n.title,n.addtime,n.notice_type,a.username');
	  	$this->db->select('	m.id,m.title,m.addtime,m.notice_type,m.id IN (SELECT nr.notice_id FROM	u_notice_read AS nr	WHERE	nr.notice_type = 0	AND nr.userid = '.$userid.') AS "isread"');
	  	$this->db->from(' u_notice AS m');

	  	//	$this->db->join('u_admin as a ', 'n.admin_id=a.id', 'left');
	  	$this->db->where('m.notice_type ',0);
	  	if(!empty($where)){
	  		$this->db->where($where);
	  	}

	  	if ($page > 0) {
	  		$offset = ($page-1) * $num;
	  		$this->db->limit($num, $offset);
	  	}
	  	$this->db->order_by('m.addtime', 'desc');
	  	return $this->db->get()->result_array();
	  }

     /* 我的分享*/
	  function get_myshare($where,$page = 1, $num = 10){
		  	$this->db->select('ls.id,ls.content,ls.addtime,( SELECT	COUNT(*) FROM u_line_collect AS lc	WHERE	lc.line_id = l.id ) AS "Hits",
		  			ls.praise_count AS "praise",(SELECT	COUNT(*) FROM u_line_share_pic AS lsp WHERE	lsp.line_share_id = ls.id) AS "pic"');
		  	$this->db->from(' u_line_share AS ls');
		  	$this->db->join('u_line AS l ', 'ls.line_id = l.id', 'left');

		  	if(!empty($where)){
		  		$this->db->where($where);
		  	}

		  	if ($page > 0) {
		  		$offset = ($page-1) * $num;
		  		$this->db->limit($num, $offset);
		  	}
		  	$this->db->order_by('ls.addtime desc');
		  	return $this->db->get()->result_array();
	  }

	  /*我的分享  人气*/
	  function get_hits($member_id){
	  	$query_sql ='';
	  	$query_sql .= "SELECT SUM(a.sum) as hits_num ";
	  	$query_sql .= "FROM (SELECT (SELECT COUNT(*) FROM u_line_collect AS lc	WHERE	lc.line_id = l.id)  ";
	  	$query_sql .= "AS 'sum' FROM u_line_share AS ls LEFT JOIN u_line AS l ON ls.line_id = l.id 	WHERE  ls.member_id = ".$member_id." ) AS a ";
	  	$query = $this->db->query($query_sql)->result_array();
	  	return $query;
	  }

	  /*统计赞*/
	  function get_praise($member_id){
	  	$query_sql ='';
	  	$query_sql .= "SELECT SUM(ls.praise_count) as praise_num FROM u_line_share AS ls WHERE ls.member_id=".$member_id;
	  	$query = $this->db->query($query_sql)->result_array();
	  	return $query;
	  }

	  /*我的收藏*/
	  function get_collect_data($member_id,$page = 1, $num = 10){
	  	$query_sql ='';
	  	$query_sql .= "select c.id,c.line_id,c.addtime,l.linename,l.nickname,l.overcity from u_line_collect as c LEFT JOIN u_line as l on c.line_id=l.id where c.member_id=".$member_id." order by c.addtime desc";
	  	if ($page > 0) {
	  		$offset = ($page-1) * $num;
	  		$query_sql .=' limit ' .$offset.','.$num;
	  	}
	  	$query = $this->db->query($query_sql)->result_array();
	  	return $query;
	  }
	  /*管家的收藏*/
	  function get_expert_collect($member_id,$page = 1, $num = 10){
	  	$query_sql ='';
	  	$query_sql .= "SELECT ec.id,e.id as expert_id ,e.realname,e.nickname,ec.addtime,e.grade,e.satisfaction_rate,e.online , (SELECT COUNT(id)  from u_member_order where `status`>=5 and expert_id=ec.expert_id ) as 'ordersum' FROM u_expert_collect AS ec ";
	  	$query_sql .="LEFT JOIN u_member AS m ON ec.member_id = m.mid LEFT JOIN u_expert AS e ON ec.expert_id = e.id ";
	  	$query_sql .="WHERE m.mid =".$member_id;
	  	if ($page > 0) {
	  		$offset = ($page-1) * $num;
	  		$query_sql .=' limit ' .$offset.','.$num;
	  	}
	  	$query = $this->db->query($query_sql)->result_array();
	  	return $query;
	  }
	  /*会员定制团线路*/
	  function get_member_group($member_id,$page = 1, $num = 10){
	  	$query_sql ='';
	  	$query_sql .= "SELECT	cr.id,l.linename,l.overcity,l.id as lineid,e.realname,e.nickname,cr.addtime,e.grade,e.mobile,e.id as expert_id FROM u_customize_recommend_line AS cr ";
	  	$query_sql .=" LEFT JOIN u_line AS l on cr.line_id=l.id  LEFT JOIN u_expert as e on e.id=cr.expert_id ";
	  	$query_sql .="WHERE cr.member_id =".$member_id;
	  	if ($page > 0) {
	  		$offset = ($page-1) * $num;
	  		$query_sql .=' limit ' .$offset.','.$num;
	  	}
	  	$query = $this->db->query($query_sql)->result_array();
	  	return $query;
	  }
	 /*我的发票*/
	  function get_invoice_data($id,$page = 1, $num = 10){
	  	$query_sql ='';
	  	$query_sql .= 'SELECT mo.id as order_id,mo.ordersn,mo.productname,mo.productautoid,`mi`.`id`,`mi`.`invoice_name`,`mi`.`invoice_detail`,`mo`.`total_price`,`mi`.`telephone`,`mi`.`address`,mi.member_id,mi.receiver ';
	  	$query_sql .='FROM(`u_member_order_invoice` AS moi) ';
	  	$query_sql .='LEFT JOIN `u_member_invoice` AS mi ON `moi`.`invoice_id` = `mi`.`id` ';
	  	$query_sql .='LEFT JOIN `u_member_order` AS mo ON `moi`.`order_id` = `mo`.`id` ';
	  	$query_sql .='WHERE `mo`.`memberid` ='.$id;
  		if ($page > 0) {
	   		$offset = ($page-1) * $num;
	   		$query_sql .=' limit ' .$offset.','.$num;
	   	}
	  	$query = $this->db->query($query_sql)->result_array();
	  	return $query;
	  }
	  /*消息总和*/
	  function get_meaasge_count($id){
	  	$query_sql ='';
	  	$query_sql .= "select id from u_message as m where `m`.`msg_type` = 0 and m.read=0 and m.receipt_id=".$id;
	  	$query = $this->db->query($query_sql)->result_array();
	  	return $query;
	  }
	  /*系统通知的总和*/
	  function get_notice_count($id){
	  	$query_sql ='';
	  	$query_sql .= 'SELECT `m`.`id` FROM	(`u_notice` AS m) ';
	  	$query_sql .= 'LEFT JOIN u_notice_read as n on m.id=n.notice_id ';
	  	$query_sql .= 'WHERE	`m`.`notice_type` like  "%0%" and `read`=0 AND n.userid='.$id;
	  	$query = $this->db->query($query_sql)->result_array();
	  	return $query;
	  }
	  /*定制单*/
	  function get_custom_data($where){
	  	$this->db->select('c.id as customize_id,ca.expert_id,s.realname as srealname,c.hotelstar,eg.supplier_id,c.question,e.realname,e.grade,ca.plan_design,c.id,c.startplace,c.startdate,c.days,c.people,c.budget,d.description,t.name,c.service_range ,c.linkname ,c.linkphone,c.endplace,c.childnum,ey.childpirce,ey.price,ey.childnobedprice ');
	  	$this->db->from('u_customize AS c');
	  	$this->db->join('u_customize_answer AS ca ', 'c.id = ca.customize_id', 'left');
	  	$this->db->join('u_enquiry AS ey ','c.id = ey.customize_id', 'left');
	  	$this->db->join('u_enquiry_grab AS eg  ',' ey.id = eg.enquiry_id', 'left');
	  	$this->db->join('u_expert AS e ','ca.expert_id = e.id', 'left');
	  	$this->db->join('u_supplier AS s ','eg.supplier_id = s.id', 'left');
	  	$this->db->join('u_dictionary AS d','c.trip_way = d.dict_id', 'left');
	  	$this->db->join('u_theme AS t','c.theme = t.id', 'left');
	  	$this->db->join('u_member AS m','c.member_id = m.mid', 'left');
	  	$this->db->where($where);

	  	return $this->db->get()->result_array();
	  }
	  /*定制单金额*/
	  function get_custom_budget($id){
	  	$query_sql ='';
	  	$query_sql .= 'SELECT  (c.people*e.price+e.childpirce*c.childnum) as sum,e.price,e.childpirce,e.childnobedprice,c.people,c.childnum ';
	  	$query_sql .= 'from u_customize_answer as e ';
	  	$query_sql .= 'LEFT JOIN u_customize as c ON e.customize_id=c.id where e.customize_id='.$id.' and e.isuse=1 ';
	  	$query = $this->db->query($query_sql)->row_array();
	  	return $query;
	  }
	  /*积分记录*/
	  function get_point_log($id,$page = 1, $num = 10){
	  	$query_sql ='';
	  	$query_sql .= 'SELECT	m.jifen,point.point_before,point.point_before,point.point_after,point.point,point.content,point.addtime,point.member_id ';
	  	$query_sql .= 'FROM	u_member_point_log AS point ';
	  	$query_sql .= 'LEFT JOIN u_member AS m on	m.mid = point.member_id where point.member_id='.$id;
	  	$query_sql .=' order by point.addtime desc,point.id desc';
	  	if ($page > 0) {
	  		$offset = ($page-1) * $num;
	  		$query_sql .=' limit ' .$offset.','.$num;
	  	}

	  	$query = $this->db->query($query_sql)->result_array();
	  	return $query;
	  }
	  /*订单信息*/
	  function get_order_num($id){
	  	$query_sql ='';
	  	$query_sql .= "SELECT (SELECT COUNT(id) FROM u_member_order AS mor  WHERE m.mid=mor.memberid AND  mor.status=1 ) AS 'liuwei', ";
	  	$query_sql .= "	(SELECT COUNT(id) FROM u_member_order AS mor  WHERE m.mid=mor.memberid AND  mor.status=4 AND mor.ispay=2) AS 'queren', ";
	  	$query_sql .= " (SELECT COUNT(id) FROM u_member_order AS mor  WHERE m.mid=mor.memberid AND mor.status = -4 AND mor.ispay=4) AS 'tuikuan',	";
	  	$query_sql .= " (SELECT COUNT(id) FROM u_member_order AS mor  WHERE m.mid=mor.memberid AND  mor.ispay=0  AND mor.status =-4 ) AS 'quxiao'	,";
	  	$query_sql .= " (SELECT count(mor.id) FROM u_member_order AS mor where mor.id not in ( select tn.order_id from travel_note as tn where";
	  	$query_sql .="   tn.usertype = 0 AND tn.status= 1 and tn.is_show=1) AND mor.status>4 and m.mid=mor.memberid ) AS 'travel',";
	  //	$query_sql .= " (select COUNT(mo.id)  from u_member_order as mo where  mo.memberid=m.mid  and mo.`status`=5 ) AS 'pinlun'	, ";
	  //	$query_sql .= " (SELECT COUNT(la.id) FROM u_order_detail AS la LEFT JOIN u_member_order AS mor ON mor.id=la.order_id  WHERE m.mid=mor.memberid and la.`status`=-1 ) AS 'jujue',";
	  	$query_sql .= " (SELECT count(c.id) FROM (`u_complain` AS c) LEFT JOIN `u_member_order` AS mo ON `c`.`order_id` = `mo`.`id` WHERE `c`.`member_id` = m.mid  AND `c`.`status` = 1) as 'tousu'";
	  	$query_sql .= 'FROM u_member AS m  WHERE m.mid='.$id;
	  	$query = $this->db->query($query_sql)->row_array();
	  	return $query;
	 // 	echo $query_sql;
	  }
	  /*收款总数*/
	  function get_order_refund($userid){
                      $sql=" SELECT COUNT(id) as sum from u_member_order WHERE status>0 and ispay=2 and  memberid={$userid} ";
                      $query = $this->db->query($sql)->row_array();
	  	return $query;
	  }
	  function get_order_refuse($id){
	  	$query_sql = " SELECT la.id FROM u_order_detail AS la LEFT JOIN u_member_order AS mor ON mor.id=la.order_id  WHERE mor.memberid=".$id." and la.`status`=-1 GROUP BY mor.id ";
	  	$query = $this->db->query($query_sql)->result_array();
	  	return $query;
	  }
	  /*产品的提问*/
	  function get_line_consult($id){
	  	$query_sql ='';
	  	$query_sql .= "SELECT	COUNT(*) as num FROM	u_line_question AS lq";
	  	$query_sql .= "	WHERE lq.productid > 0 AND ISNULL(lq.replytime) = 0 AND lq.isread = 0 AND lq.memberid = ".$id;
	  	$query = $this->db->query($query_sql)->row_array();
	  	return $query;
	  }
	  /*被指定的管家的提问*/
	  function get_expert_consult($id){
	  	$query_sql ='';
	  	$query_sql .= "SELECT	COUNT(*) as num FROM	u_line_question AS lq";
	  	$query_sql .= "	WHERE lq.productid = 0 AND ISNULL(lq.replytime) = 0 AND lq.isread = 0 AND lq.memberid = ".$id;
	  	$query = $this->db->query($query_sql)->row_array();
	  	return $query;
	  }
	  /*定制信息的回答*/
	  function get_custom_consult($id){
	  	$query_sql ='';
	  	$query_sql .= "SELECT	COUNT(*) as num FROM	u_customize_answer AS ca";
	  	$query_sql .= " LEFT JOIN u_customize AS c ON ca.customize_id = c.id ";
	  	$query_sql .= "	WHERE c.user_type = 0 AND ca.isread = 0 AND c.member_id =".$id;
	  	$query = $this->db->query($query_sql)->row_array();
	  	return $query;
	  }
	  /*业务信息*/
	  function get_notice_consult($id){
	  	$query_sql ='';
	  	$query_sql .= " SELECT COUNT(*) as num FROM u_message AS m";
	  	$query_sql .= "	WHERE	m.msg_type = 0 AND m.READ = 0 AND m.receipt_id = ".$id;
	  	$query = $this->db->query($query_sql)->row_array();
	  	return $query;
	  }
	  /**
	   * 获取目的地
	   * @param string $ids 数组IDS
	   * @return string
	   */
	  public function getDestinationsID($ids = null){
	  	if(null!=$ids){
	  		$sql = 'SELECT id,kindname as name FROM u_dest_base WHERE id!=0 and level>2 ';
	  		$sql.=" AND id IN (";
	  		$i=0;
	  		foreach($ids as $v){
	  			if(!empty($v)){
		  			if($i>0){
		  				$sql.=',';
		  			}
		  			$sql.=$v;
		  			$i++;
	  			}
	  		}
	  		$sql.=" )";
	  		$query = $this->db->query($sql,$ids);
	  		$rows = $query->result_array();
	  	}
	  	return $rows;
	  }

}