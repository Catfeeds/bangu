<?php
/**
* @copyright	深圳海外国际旅行社有限公司
* @version		1.0
* @since		2015年7月16日18:00:11
* @author		何俊
*/
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Expert_model extends MY_Model {
	public function __construct() {
		parent::__construct('u_expert');
	}

	 //目的查询表
	 public function select_dest_data($where){
	 	$this->db->select('*');
	 	if(!empty($where)){
	 		$this->db->where($where);
	 	}
	 	$this->db->order_by('displayorder');
		$result =  $this->db->get('u_dest_base')->result_array();
	 	array_walk($result, array($this, '_fetch_list'));
	 	return $result;
	 }
      //管家信息
      public function get_expert_list($id){

      	$this->db->select('*,a.name as cityname');
      	$this->db->from('u_expert as e');
      	$this->db->join('u_area AS a','e.city=a.id','left');
      	$this->db->where(array('e.id'=>$id));
      	$query =$this->db->get();
      	$rows= $query->row_array();
      	return $rows;
      }
      /**
       * 插入管家资料桥接关联表 
       * @param array $post_array  管家基础信息
       * @param array $certificateArr 荣誉证书
       * @param array $expert_resume  从业简历
       * @param string $expert_id   管家ID
       * @return bool
       */
      function update_expert($post_array,$certificateArr,$expert_resume,$expertId,$expert_dest,$visit){
      		$this->db->trans_start();
      		
      		$certificateid=array();
      		$resumeid=array();
      		//判断是否已经提交过资料
      		$expertsql=$this->db->query('select id,b_expert_id from bridge_expert_map where status=0 and expert_id='.$expertId.' ORDER BY addtime DESC');
      		$expertdata=$expertsql->row_array();
      		//管家从业
      		$resume_sql=$this->db->query('select company_name,job,starttime,endtime,description,status from u_expert_resume where expert_id='.$expertId);
      		$resume= $resume_sql->result_array();
      		
      		if(empty($expertdata['b_expert_id'])){   //添加
      			 		
          		//插入管家信息表
          		$this->db->insert('bridge_expert',$post_array);
          		$expert_id=$this->db->insert_id();
		
          		//添加管家填写的从业简历
          		if(!empty($expert_resume['starttime'])){ 
          			foreach ($expert_resume['starttime'] as $k=>$v){
          				$insert_expert_resume['starttime']=$expert_resume['starttime'][$k];
          				$insert_expert_resume['endtime']=$expert_resume['endtime'][$k];
          				$insert_expert_resume['company_name']=$expert_resume['company_name'][$k];
          				$insert_expert_resume['job']=$expert_resume['job'][$k];
          				$insert_expert_resume['description']=$expert_resume['description'][$k];
          				$insert_expert_resume['expert_id']=$expert_id;
          				$this->db->insert('bridge_expert_resume',$insert_expert_resume);
          				$resumeid[]=$this->db->insert_id();
          			}	
          		}
      			
      			//资料修改添加的管家证书
      			if(!empty($certificateArr['certificate'])){
      				foreach ($certificateArr['certificate'] as $k=>$v){
      					$update['certificate']=$certificateArr['certificate'][$k];
      					$update['certificatepic']=$certificateArr['certificatepic'][$k];
      					$update['status']=1;
      					$update['expert_id']=$expert_id;
      					$this->db->insert('bridge_expert_certificate',$update);
      					$certificateid[]=$this->db->insert_id();
      				}
      			}

                //擅长目的地
                if(!empty($expert_dest)){ 
                     $expert_destArr=explode(',', $expert_dest) ;
                     foreach ($expert_destArr as $key => $value) {
                        if(!empty($value)){
                              $destinsert['expert_id']=$expert_id;
                              $destinsert['dest_id']=$value;
                              $this->db->insert('bridge_expert_good_dest',$destinsert);
                         }
                     }
                }
               //上门服务
                if(!empty($visit)){
                     $visitArr=explode(',', $visit) ;
                     foreach ($visitArr as $key => $value) {
                         if(!empty($value)){
                             $visitinsert['expert_id']=$expert_id;
                             $visitinsert['service_id']=$value;
                             $this->db->insert('bridge_expert_visit_service',$visitinsert);
                         }
                     }         
                }

      			//管家审核资料桥接关联表
      			if(!empty($certificateid)){
      				$cerid=implode(',', $certificateid);
      				$insert['b_expert_certificate_ids']=$cerid;
      			}
      			if(!empty($resumeid)){
      				$resid=implode(',', $resumeid);
      				$insert['b_expert_resume_ids']=$resid;
      			}
      			$insert['expert_id']=$expertId;
      			$insert['addtime']=date('Y-m-d H:i:s');
      			$insert['b_expert_id']=$expert_id;
      			$insert['status']=0;
      			$this->db->insert('bridge_expert_map',$insert);
			
      		}else {  //在原有的数据中添加
      		
      			$this->db->where('id', $expertdata['b_expert_id'])->update('bridge_expert', $post_array);
      			$this->db->delete('bridge_expert_certificate', array('expert_id' => $expertdata['b_expert_id'])); 
      			$this->db->delete('bridge_expert_resume', array('expert_id' => $expertdata['b_expert_id']));
      		    //资料修改添加的管家证书
      			if(!empty($certificateArr['certificate'])){
      				foreach ($certificateArr['certificate'] as $k=>$v){
      				        $update['certificate']=$certificateArr['certificate'][$k];
      				        $update['certificatepic']=$certificateArr['certificatepic'][$k];
      				        $update['status']=1;
      				        $update['expert_id']=$expertdata['b_expert_id'];
      				        $this->db->insert('bridge_expert_certificate',$update);
      				        $certificateid[]=$this->db->insert_id();
      				}
      			}
      			//管家审核资料桥接关联表
      			if(!empty($certificateid)){
      				$cerid=implode(',', $certificateid);
      				$insert['b_expert_certificate_ids']=$cerid;
      			}else{
      				$insert['b_expert_certificate_ids']='';
      			}

      			//添加管家填写的从业简历
      			if(!empty($expert_resume['starttime'])){
      				foreach ($expert_resume['starttime'] as $k=>$v){
      					$insert_expert_resume['starttime']=$expert_resume['starttime'][$k];
      					$insert_expert_resume['endtime']=$expert_resume['endtime'][$k];
      					$insert_expert_resume['company_name']=$expert_resume['company_name'][$k];
      					$insert_expert_resume['job']=$expert_resume['job'][$k];
      					$insert_expert_resume['description']=$expert_resume['description'][$k];
      					$insert_expert_resume['expert_id']=$expertdata['b_expert_id'];
      					$this->db->insert('bridge_expert_resume	',$insert_expert_resume);
      					$resumeid[]=$this->db->insert_id();
      				}
      			}

               //管家目的地
                if(!empty($expert_dest)){   
                    $expert_destArr=explode(',', $expert_dest) ;
                    $deststr=array();
                    $destData=$this->db->select('id,dest_id')->where(array('expert_id'=>$expertdata['b_expert_id']))->get('bridge_expert_good_dest')->result_array();
                    if(!empty($destData)){
                        foreach ($destData as $k=>$v){  //没选中的就删除
                            if(!empty($v['dest_id'])){
                                  $deststr[]=$v['dest_id'];
                                  if(!in_array($v['dest_id'],$expert_destArr)){
                                      $this->db->where(array('expert_id'=>$expertdata['b_expert_id'],'dest_id'=>$v['dest_id']))->delete('bridge_expert_good_dest');
                                  }
                            }
                        }           
                    }
                    foreach ($expert_destArr as $k=>$v){
                        if(!empty($v)){
                               if(!in_array($v,$deststr)){  //不存在该出发地就插入
                                    $this->insert_data('bridge_expert_good_dest',array('expert_id'=>$expertdata['b_expert_id'],'dest_id'=>$v));//插入表
                               }
                         }
                    } 
                }

                //上门服务
               if(!empty($visit)){   
                        $visitArr=explode(',', $visit) ;
                        $visitstr=array();
                        $visitData=$this->db->select('id,service_id')->where(array('expert_id'=>$expertdata['b_expert_id']))->get('bridge_expert_visit_service')->result_array();
                        if(!empty($visitData)){
                            foreach ($visitData as $k=>$v){  //没选中的就删除
                                if(!empty($v['service_id'])){
                                      $visitstr[]=$v['service_id'];
                                      if(!in_array($v['service_id'],$visitArr)){
                                         $this->db->where(array('expert_id'=>$expertdata['b_expert_id'],'service_id'=>$v['service_id']))->delete('bridge_expert_visit_service');
                                      }
                                }
                            }           
                        }
                        foreach ($visitArr as $k=>$v){
                            if(!empty($v)){
                                   if(!in_array($v,$visitstr)){  //不存在该出发地就插入
                                        $this->insert_data('bridge_expert_visit_service',array('expert_id'=>$expertdata['b_expert_id'],'service_id'=>$v));//插入表
                                   }
                             }
                        } 
                }

      			//管家审核资料桥接关联表
      			if(!empty($resumeid)){
      				$resid=implode(',', $resumeid);
      				$insert['b_expert_resume_ids']=$resid;
      			}else{
      				$insert['b_expert_resume_ids']='';
      			}	
      				
      			$insert['addtime']=date('Y-m-d H:i:s');
      			$insert['status']=0;
      			$this->db->where('b_expert_id', $expertdata['b_expert_id'])->update('bridge_expert_map', $insert);
      		}
      		
      		$this->db->trans_complete();
      		if ($this->db->trans_status() === FALSE)
      		{
      			return false;
      		}else{
      			return true;
      		}
      }
      
      /**
       * 管家资料
       * @param array $post_array  管家基础信息
       * @param array $certificateArr 荣誉证书
       * @param array $expert_resume  从业简历
       * @param string $expert_id   管家ID
       * @return bool
       */
      function update_expert_data($post_array,$certificateArr,$expert_resume,$expertId,$expert_dest,$visit){
            $this->db->trans_start();
            
            $this->db->delete('u_expert_certificate', array('expert_id' =>$expertId));
            $this->db->delete('u_expert_resume', array('expert_id' => $expertId));
            
            //管家主表
            $this->db->where('id', $expertId)->update('u_expert', $post_array);

            //资料修改添加的管家证书
            if(!empty($certificateArr['certificate'])){
                foreach ($certificateArr['certificate'] as $k=>$v){
                    $update['certificate']=$certificateArr['certificate'][$k];
                    $update['certificatepic']=$certificateArr['certificatepic'][$k];
                    $update['status']=1;
                    $update['expert_id']=$expertId;
                    $this->db->insert('u_expert_certificate',$update);
                    $certificateid[]=$this->db->insert_id();
                }
            }
            
            
            //管家填写的从业简历
            if(!empty($expert_resume['starttime'])){
                foreach ($expert_resume['starttime'] as $k=>$v){
                    $insert_expert_resume['starttime']=$expert_resume['starttime'][$k];
                    $insert_expert_resume['endtime']=$expert_resume['endtime'][$k];
                    $insert_expert_resume['company_name']=$expert_resume['company_name'][$k];
                    $insert_expert_resume['job']=$expert_resume['job'][$k];
                    $insert_expert_resume['description']=$expert_resume['description'][$k];
                    $insert_expert_resume['expert_id']=$expertId;
                    $this->db->insert('u_expert_resume	',$insert_expert_resume);
                    $resumeid[]=$this->db->insert_id();
                }
            }
            
            //管家目的地
            if(!empty($expert_dest)){
                $expert_destArr=explode(',', $expert_dest) ;
                $deststr=array();
                $destData=$this->db->select('id,dest_id')->where(array('expert_id'=>$expertId))->get('u_expert_good_dest')->result_array();
                if(!empty($destData)){
                    foreach ($destData as $k=>$v){  //没选中的就删除
                        if(!empty($v['dest_id'])){
                            $deststr[]=$v['dest_id'];
                            if(!in_array($v['dest_id'],$expert_destArr)){
                                $this->db->where(array('expert_id'=>$expertId,'dest_id'=>$v['dest_id']))->delete('u_expert_good_dest');
                            }
                        }
                    }
                }
                foreach ($expert_destArr as $k=>$v){
                    if(!empty($v)){
                        if(!in_array($v,$deststr)){  //不存在该出发地就插入
                            $this->insert_data('u_expert_good_dest',array('expert_id'=>$expertId,'dest_id'=>$v));//插入表
                        }
                    }
                }
            }
            
            //上门服务
            if(!empty($visit)){
                $visitArr=explode(',', $visit) ;
                $visitstr=array();
                $visitData=$this->db->select('id,service_id')->where(array('expert_id'=>$expertId))->get('u_expert_visit_service')->result_array();
                if(!empty($visitData)){
                    foreach ($visitData as $k=>$v){  //没选中的就删除
                        if(!empty($v['service_id'])){
                            $visitstr[]=$v['service_id'];
                            if(!in_array($v['service_id'],$visitArr)){
                                $this->db->where(array('expert_id'=>$expertId,'service_id'=>$v['service_id']))->delete('u_expert_visit_service');
                            }
                        }
                    }
                }
                foreach ($visitArr as $k=>$v){
                    if(!empty($v)){
                        if(!in_array($v,$visitstr)){  //不存在该出发地就插入
                            $this->insert_data('u_expert_visit_service',array('expert_id'=>$expertId,'service_id'=>$v));//插入表
                        }
                    }
                }
            }
            
            $this->db->trans_complete();
      		if ($this->db->trans_status() === FALSE)
      		{
      			return false;
      		}else{
      			return true;
      		}
      }
      
      
    //上门服务
	public function getLineattr($ids = null){
		
		if(null!=$ids){
			$sql = 'SELECT id,name,pid FROM u_area WHERE id!=0 ';
			$sql.=" AND id IN (";
			$i=0;
			foreach($ids as $v){
				if($i>0){
					$sql.=',';
				}
				$sql.=$v;
				$i++;
			}
			$sql.=" ) ORDER BY displayorder ";
			$query = $this->db->query($sql,$ids);
			$rows = $query->result_array();
		}
		return $rows;
	}
	//目的地
	public function getDestattr($ids = null){
	
		if(null!=$ids){
			$sql = 'SELECT id,kindname as name,pid FROM u_dest_base WHERE id!=0 ';
			$sql.=" AND id IN (";
			$i=0;
			foreach($ids as $v){
				if($i>0){
					$sql.=',';
				}
				$sql.=$v;
				$i++;
			}
			$sql.=" ) ORDER BY displayorder ";
			$query = $this->db->query($sql,$ids);
			$rows = $query->result_array();
		}
		return $rows;
	}
	  /**
	  * 获取目的地
	  * @param string $ids 数组IDS
	  * @return string
	  */
	 public function getDestinationsID($ids = null){
	 	if(null!=$ids){
	 		$sql = 'SELECT id,kindname as kname FROM u_dest_base WHERE id!=0 ';
	 		$sql.=" AND id IN (";
	 		$i=0;
	 		foreach($ids as $v){
	 			if($i>0){
	 				$sql.=',';
	 			}
	 			$sql.=$v;
	 			$i++;
	 		}
	 		$sql.=" )";
	 		$query = $this->db->query($sql,$ids);
	 		$rows = $query->result_array();
	 	}
	 	return $rows;
	 }

	  /**
	 * 回调函数
	 * @param unknown $value
	 * @param unknown $key
	 */
	protected function _fetch_list(&$value, $key) {
		$value['kindname'] = mb_substr($value['kindname'], 0,4,'utf-8');
	}
	
	 /**
	 * 查询数
	 * */
	public function get_alldate($table,$where){
		$this->db->select('*');
		if(!empty($where)){
			$this->db->where($where);
		}
		 
		return  $this->db->get($table)->result_array();
	}
	//修改
	public function update_rowdata($table,$object,$where){
		$this->db->where($where);
		return $this->db->update($table, $object);
	}
	//插入表
	public function insert_data($table,$data){
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}
	
	/**
	 * b端管家（经理）的所在部门和子部门
	 * */
	public function expert_depart($depart_id)
	{
		$sql="select * from b_depart where id='{$depart_id}' and status=1"; //当前营业部
		$result1=$this->db->query($sql)->result_array();
		$sql="select * from b_depart where pid='{$depart_id}'  and status=1"; //子营业部
		$result2=$this->db->query($sql)->result_array();
		
		return array_merge($result1,$result2);
		
		
	}
}