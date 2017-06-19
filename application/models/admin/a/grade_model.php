<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class grade_model extends MY_Model {

	private $table_name = 'u_expert';
	function __construct() {
		parent::__construct ( $this->table_name );
	}

	//获取资讯数据
	function get_expert_data($param,$page,$type=''){
		$query_sql='';
		$query_sql.=' SELECT e.`realname`,`e`.`city`,`e`.`idcard`,`e`.`nickname`,`e`.`email`,`e`.`mobile`,`e`.`id`, ';
		$query_sql.=' `cd`.`name` AS cd_name,`pd`.`name` AS pd_name,`cid`.`name` AS cid_name,`rd`.`name` AS rd_name,`e`.`addtime` ';
		$query_sql.=' FROM	(`u_expert` AS e)  ';
		$query_sql.=' LEFT JOIN `u_area` AS cd ON `cd`.`id` = `e`.`country` ';
		$query_sql.=' LEFT JOIN `u_area` AS pd ON `pd`.`id` = `e`.`province`';
		$query_sql.=' LEFT JOIN `u_area` AS cid ON `cid`.`id` = `e`.`city`';
		$query_sql.=' LEFT JOIN `u_area` AS rd ON `rd`.`id` = `e`.`region`';
		$query_sql.=' WHERE	e.`status` = 2';
		if($param!=null){
		
			if(null!=array_key_exists('title', $param)){
				$query_sql.=" and (e.realname  like ?  or e.nickname like '%{$param['title']}%')";
				$param['title'] = '%'.trim($param['title']).'%';
			}
			if(null!=array_key_exists('mobile', $param)){
				$query_sql.=' and e.mobile = ? ';
				$param['mobile'] = trim($param['mobile']);
			}
		}
		if(!empty($type)){
			if($type==1){
				$query_sql.=' and e.supplier_id  > 0 ';
			}elseif ($type==2){
				$query_sql.=' and (e.supplier_id  = 0 or e.supplier_id  = "")';
			}
		}
		$query_sql.=' ORDER BY	`e`.`modtime` DESC';
		return $this->queryPageJson( $query_sql , $param ,$page);
	}
	//某条管家信息
	function get_expert_row($id){
		$query_sql='';
		$query_sql.=' SELECT e.`realname`,`e`.`city`,`e`.`nickname`,`e`.`email`,`e`.`mobile`,`e`.`id`,`cd`.`name` AS cd_name,e.expert_dest, ';
		$query_sql.=' `pd`.`name` AS pd_name,`cid`.`name` AS cid_name,`rd`.`name` AS rd_name,`e`.`addtime`, e.small_photo,e.grade, ';
		$query_sql.=' e.satisfaction_rate,e.people_count,e.order_amount,e.total_score   FROM (`u_expert` AS e) ';
		$query_sql.=' LEFT JOIN `u_area` AS cd ON `cd`.`id` = `e`.`country` ';
		$query_sql.=' LEFT JOIN `u_area` AS pd ON `pd`.`id` = `e`.`province`';
		$query_sql.=' LEFT JOIN `u_area` AS cid ON `cid`.`id` = `e`.`city`';
		$query_sql.=' LEFT JOIN `u_area` AS rd ON `rd`.`id` = `e`.`region`';
		$query_sql.=' WHERE	`status` = 2 and e.id='.$id;
		return $this ->db ->query($query_sql) ->row_array();
	}
	//管家的线路申请
	function get_line_apply($param,$page,$dest=''){
		$query_sql='';
		$query_sql.=' SELECT la.*, CAST(l.satisfyscore * 100  AS  DECIMAL(8,2)) satisfyscore,l.bookcount,l.peoplecount,l.all_score,l.avg_score,l.linename,l.linecode,s.realname,l.id as lineid,(lc.count) as linecount  ';
		$query_sql.=' FROM	u_line_apply AS la ';
		$query_sql.=' LEFT JOIN u_line AS l on l.id=la.line_id ';
		$query_sql.=' LEFT JOIN u_supplier AS s on l.supplier_id=s.id ';
		$query_sql.=' LEFT JOIN  u_expert_line_count as lc on lc.line_id=la.line_id and lc.expert_id = la.expert_id ';
		$query_sql.=' WHERE	la.status = 2 and l.status=2 and l.producttype=0';
		if($param!=null){		
			if(null!=array_key_exists('expert_id', $param)){
				$query_sql.=' and la.expert_id = ? ';
				$param['expert_id'] = $param['expert_id'];
			}
		 	if(null!=array_key_exists('linecode', $param)){
				$query_sql.=' and l.linecode  = ? ';
				$param['linecode'] = $param['linecode'];
			}
		 	if(null!=array_key_exists('linename', $param)){
				$query_sql.=' and l.linename  like ? ';
				$param['linename'] = '%'.$param['linename'].'%';
			} 
		   //擅长线路的搜索
			if(!empty($dest)){
				$overcityData='';
				$destArr=explode(',', $dest);
				foreach ($destArr as $k=>$v){
					if(!empty($v)){
						$overcityData[]='FIND_IN_SET('.$v.',l.overcity)>0 ';
					}
				}
				if(!empty($overcityData)){
					$overcitystr=implode(' or ', $overcityData);
					$query_sql.=' and ('.$overcitystr.') ';
				}	
			}			 
		}
		$query_sql.=' ORDER BY	`la`.`modtime` DESC';
		return $this->queryPageJson( $query_sql , $param ,$page);
	}
	//管家申请线路的销售数量的修改
	function update_expert_line($dataArr,$line_id,$expertid,$admin_id){
		$this->db->trans_start();
		if(!empty($dataArr)){
			$lcount=$this ->db ->query('select count from u_expert_line_count where  expert_id='.$expertid.' and line_id='.$line_id) ->row_array(); 
			$lineInfo=$this ->db ->query('select peoplecount,linename from u_line where id='.$line_id) ->row_array();	//线路的销量	
			$lineApply=$this ->db ->query('SELECT ap.line_id,ap.expert_id from u_line_apply as ap LEFT JOIN u_expert as e  on ap.expert_id=e.id  where  ap.expert_id='.$expertid.' and ap.line_id='.$line_id) ->result_array();
			$linebookcount=$dataArr['peoplecount'];
			//修改线路的销量
			$line_count= ($linebookcount-$lcount['count'])+$lineInfo['peoplecount'];	
			if($line_count>0){
				$this->db->where(array('id'=>$line_id))->update('u_line', array('peoplecount'=>$line_count));
			}
			
			if(!empty($lineApply)){  //添加管家对应的销量表
				foreach ($lineApply as $k=>$v){
					$count=0;
					$count=$count+$linebookcount;
					$lineCount=$this ->db ->query('select id from u_expert_line_count where line_id='.$v['line_id'].' and expert_id='.$v['expert_id'])->row_array();
					$lineappArr['expert_id']=$v['expert_id'];
					$lineappArr['line_id']=$v['line_id'];
					$lineappArr['count']=$count;
					$lineappArr['admin_name']=$this->realname;
					$lineappArr['addtime']=date('Y-m-d H:i:s');
					if(!empty($lineCount)){  //修改
						$this->db->where(array('id'=>$lineCount['id']))->update('u_expert_line_count', $lineappArr);
						
					}else{  //插入
						$this->db->insert('u_expert_line_count',$lineappArr);
					}
				}
			}

		 //	 if($linebookcount>0){  //大于零时就改变
		 	 	$order=$this ->db ->query('select count(id) as ordercount from u_member_order where status>4 and expert_id='.$expertid) ->row_array(); //订单数
		 	// 	echo $this->db->last_query();	
		 	 	$count=$this ->db ->query('select sum(count) as count from u_expert_line_count where  expert_id='.$expertid) ->row_array();
		 	 	$sum=$order['ordercount']+$count['count'];
				$query = $this->db->query("update u_expert set people_count={$sum} where id=".$expertid);
		//	}   
		    
			//插入评分修改记录
			$realname=$this->realname;	
			$insertArr['admin_id']=$admin_id;
			$insertArr['addtime']=date('Y-m-d H:i:s');
			$insertArr['content']="管理员({$realname})将线路({$lineInfo['linename']})的销量{$linebookcount['peoplecount']}改为{$dataArr['peoplecount']}";
			$this->db->insert('u_score_update_record',$insertArr);
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			echo false;
		}else{
			return true;
		}
	}
	//修改管家指标
	function update_expert_target($dataArr,$sati_intervene,$id){
		$this->db->trans_start();
		$expert=$this ->db ->query('select satisfaction_rate,people_count,order_amount,total_score,realname from u_expert where id='.$id) ->row_array();
		$expert_affil=$this ->db ->query('select sati_intervene from u_expert_affiliated where expert_id='.$id) ->row_array();
	
		$realname=$this->realname;
		$str="管理员({$realname})将管家({$expert['realname']})的";
	    $satisfaction_rate=$expert['satisfaction_rate']+$sati_intervene;
	    
	    //管家满意度增值
	    if(empty($expert_affil)){
	    	$affilArr['expert_id']=$id;
	    	$affilArr['sati_intervene']=$sati_intervene;
	    	$this->db->insert('u_expert_affiliated',$affilArr);
	    		
	    }else{
	    	$this->db->where(array('expert_id'=>$id))->update('u_expert_affiliated',array('sati_intervene'=>$sati_intervene));
	    }
	    
	    if(empty($expert_affil['sati_intervene'])){
	    	$expert_affil['sati_intervene']=0;
	    }
	    if($expert['satisfaction_rate']!=$satisfaction_rate){
			$expert['satisfaction_rate']=($expert['satisfaction_rate']+$expert_affil['sati_intervene'])*100;
			$satisfaction_rate=$satisfaction_rate*100;
			$str=$str."满意度为{$expert['satisfaction_rate']}%改成{$satisfaction_rate}%  ";
			$re=1;
		}
		if($expert['people_count']!=$dataArr['people_count']){
			$str=$str."销量为{$expert['people_count']}改成{$dataArr['people_count']}  ";
			$re=1;
		}
		if($expert['order_amount']!=$dataArr['order_amount']){
			$str=$str."成交额为{$expert['order_amount']}改成{$dataArr['order_amount']}  ";
			$re=1;
		}
		if($expert['total_score']!=$dataArr['total_score']){
			$str=$str."总积分为{$expert['order_amount']}改成{$dataArr['order_amount']}  ";
			$re=1;
		}
          
		$this->db->where(array('id'=>$id))->update('u_expert', $dataArr);
		$this->db->affected_rows();
		
	 	if($re>0){
			$realname=$this->realname;
			$insertArr['admin_id']=$this->admin_id;
			$insertArr['addtime']=date('Y-m-d H:i:s');
			$insertArr['content']=$str;
			$this->db->insert('u_score_update_record',$insertArr);
		} 
				
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			echo false;
		}else{
			return true;
		}
	}
	//保存批量修改的销量，管家级别
	function save_expertline($lineApplyid,$lineid,$bookcount,$grade,$expertid){
		$this->db->trans_start();
		
		if($bookcount!=''){  //管家销量的表
			if(!empty($lineid)){
				foreach ($lineid as $k=>$v){
					//管家对应线路销量表
					$lcount=$this ->db ->query('select count from u_expert_line_count where  expert_id='.$expertid.' and line_id='.$v) ->row_array();
					//查询线路的名称，销量
					$lineInfo=$this ->db ->query('select linename,bookcount,peoplecount from u_line where id='.$v) ->row_array(); 
					$lineApply=$this ->db ->query('SELECT ap.line_id,ap.expert_id from u_line_apply as ap LEFT JOIN u_expert as e  on ap.expert_id=e.id  where ap.expert_id='.$expertid.' and ap.line_id='.$v) ->result_array();
					$linebookcount=$bookcount;
					
					//修改线路的销量
					$line_count=( $bookcount-$lcount['count'])+$lineInfo['peoplecount'];
					if($line_count>0){
						$this->db->where(array('id'=>$v))->update('u_line', array('peoplecount'=>$line_count));
					}
					
					if($linebookcount!=''){
						if(!empty($lineApply)){  //添加管家对应的销量表
							foreach ($lineApply as $key=>$val){
								$count=0;
								$count=$count+$linebookcount;
								$lineCount=$this ->db ->query('select id,count from u_expert_line_count where line_id='.$val['line_id'].' and expert_id='.$val['expert_id']) ->row_array();
								$lineappArr['expert_id']=$val['expert_id'];
								$lineappArr['line_id']=$val['line_id'];
								$lineappArr['count']=$count;
								$lineappArr['admin_name']=$this->realname;
								$lineappArr['addtime']=date('Y-m-d H:i:s');
								if(!empty($lineCount)){  //修改
									$this->db->where(array('id'=>$lineCount['id']))->update('u_expert_line_count', $lineappArr);
								}else{  //插入
									$this->db->insert('u_expert_line_count',$lineappArr);	
								}							
							}
						}
					}
				
					$realname=$this->realname;
					$insertArr['admin_id']=$this->admin_id;
					$insertArr['addtime']=date('Y-m-d H:i:s');
					$insertArr['content']="管理员({$realname})将线路({$line['linename']})的销量{$line['bookcount']}改成{$bookcount}";;
					$this->db->insert('u_score_update_record',$insertArr);  //插入记录表
					
				   // if($linebookcount>0){  //大于零时就改变
				    	$count=$this ->db ->query('select sum(count) as count from u_expert_line_count where  expert_id='.$expertid) ->row_array();
				    	$order=$this ->db ->query('select count(id) as ordercount from u_member_order where status>4 and expert_id='.$expertid) ->row_array();
				    	$sum=$order['ordercount']+$count['count'];
						$query = $this->db->query("update u_expert set people_count={$sum} where id=".$expertid);
				//	} 
		
				}
			}
		}
		if(!empty($grade)){  //管家申请的级别
			foreach ($lineApplyid as $k=>$v){
              //  var_dump($lineApply);
				$expert=$this ->db ->query('select la.*,e.realname,l.linename from  u_line_apply as la LEFT JOIN u_expert as e on la.expert_id=e.id  LEFT JOIN u_line as l on l.id=la.line_id where la.id='.$v) ->row_array(); //管家信息
				if($expert['grade']!=$grade){
					$gradename=$this->get_expert_grade($expert['grade']);
					
					$this->db->where(array('id'=>$v))->update('u_line_apply', array('grade'=>$grade)); //修改管家级别
					$expertGrade=$this->get_expert_grade($grade);;
					
					$realname=$this->realname;
					$insertArr['admin_id']=$this->admin_id;
					$insertArr['addtime']=date('Y-m-d H:i:s');
					$insertArr['content']="管理员({$realname})将申请线路({$expert['linename']})的{$gradename}({$expert['realname']})改成{$expertGrade}";;
					$this->db->insert('u_score_update_record',$insertArr);  //插入记录表
				}
			}
		}
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			echo false;
		}else{
			return true;
		}
	}
	function get_expert_grade($expert){
		$expertGrade='';
		if(!empty($expert)){
			if($expert==1){
				$expertGrade='管家';
			}else if($expert==2){
				$expertGrade='初级专家';
			}else if($expert==3){
				$expertGrade='中级专家';
			}else if($expert==4){
				$expertGrade='高级专家';
			}else{
				$expertGrade='管家';
			}
		}
		return $expertGrade;
	}
	//管家
	function get_grade_data($table_name,$whereArr){
		$this->db->select ( "*" );
		$this->db->from ( $table_name );
		$this->db->where ( $whereArr );
		return $this->db->get () ->row_array ();
	}
}
