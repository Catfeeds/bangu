<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Anchor_model extends APP_Model
{
	private $table_name = 'live_anchor';

	function __construct(){
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * 更新主播数据
	 * @param unknown $dataArr
	 * @param unknown $id
	 */
	public function updateAnchor($dataArr ,$id)
	{
		return $this ->db ->where('anchor_id' ,$id) ->update('live_anchor' ,$dataArr);
	}
	
	/**
	 * @method 获取主播ID
	 * @param unknown $user_id
	 * @param unknown $user_type
	 */
	public function getAnchorId($user_id ,$user_type)
	{
		$sql = 'select anchor_id,umoney,name from live_anchor where user_id = '.$user_id .' and user_type = '.$user_type;
		return $this ->db ->query($sql) ->row_array();
	}
	
	/**
	 * @method 获取用户的U币
	 * @author jkr
	 * @param unknown $user_id
	 */
	public function getUserUMoney($anchor_id){
		$sql = 'select umoney,name,anchor_id from live_anchor where anchor_id ='.$anchor_id;
		return $this ->db ->query($sql) ->row_array();
	}
	/**
	 * @method 用户购买礼物
	 * @author jkr
	 * @param unknown $umoney
	 */
	public function userBuyGift($anchor_id ,$buyGift)
	{
		$this->db->trans_start();
		//更新用户的U币余额
		$sql = 'update live_anchor set umoney = umoney -'.$buyGift['worth'].' where anchor_id='.$anchor_id;
		$this ->db ->query($sql);
		//写入用户购买礼物记录
		$this ->db ->insert('live_gift_record' ,$buyGift);

		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	/**
	 * @method 用户充值
	 * @author jkr
	 * @param intval $user_id 用户ID
	 * @param intval $umoney 充值金额兑换的U币数量
	 * @param array  $recordArr 充值记录信息
	 */
	public function userRecharge($user_id ,$umoney ,$recordArr)
	{
		$this->db->trans_start();
		//更新用户u币余额
		$sql = 'update live_anchor set umoney = umoney +'.$umoney.' where anchor_id='.$user_id;
		$this ->db ->query($sql);
		//写入充值记录
		$this ->db ->insert('live_recharge' ,$recordArr);

		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	/**
	 * @method 获取直播用户数据，用于平台管理
	 * @param array $whereArr
	 * @author xml
	 */
	public function get_anchor($param,$page)
	{
		$query_sql=" SELECT la.*,ar.name as countryname,pr.name as provincename,ci.name as cityname ";
		$query_sql.=" FROM live_anchor AS la";
		$query_sql.=" LEFT JOIN bangu.u_area AS ar ON ar.id = la.country";
		$query_sql.=" LEFT JOIN bangu.u_area AS pr ON pr.id = la.province";
		$query_sql.=" LEFT JOIN bangu.u_area AS ci ON ci.id = la.city where la.anchor_id>0 ";

		if($param!=null){
			if(null!=array_key_exists('status', $param)){
				$query_sql.=' and la.status = ? ';
				$param['status'] = trim($param['status']);
			}
			if(null!=array_key_exists('realname', $param)){
				$query_sql.=' AND la.realname LIKE ? ';
				$param['realname'] = '%'.trim($param['realname']).'%';
			}
			if(null!=array_key_exists('name', $param)){
				$query_sql.=' AND la.name LIKE ? ';
				$param['name'] = '%'.trim($param['name']).'%';
			}
			if(null!=array_key_exists('mobile', $param)){
				$query_sql.=' AND la.mobile LIKE ? ';
				$param['mobile'] = '%'.trim($param['mobile']).'%';
			}
			if(null!=array_key_exists('city', $param)){
				$query_sql.=' AND la.city = ? ';
				$param['city'] = trim($param['city']);
			}
			/*if($param['type']>0){
				$query_sql.=' AND la.type = ? ';
				$param['type'] = trim($param['type']);
			}*/
		}
		$query_sql.=" order by  la.addtime desc";
		return $this->queryPageJson( $query_sql , $param ,$page);

	}
	/**
	 * @method 获取单条主播用户数据  用于平台管理
	 * @param $id
	 * @author xml
	 */
	public function get_anchor_detail($id){
		$query_sql=" SELECT la.*,ar.name as countryname,pr.name as provincename,ci.name as cityname ";
		$query_sql.=" FROM live_anchor AS la";
		$query_sql.=" LEFT JOIN bangu.u_area AS ar ON ar.id = la.country";
		$query_sql.=" LEFT JOIN bangu.u_area AS pr ON pr.id = la.province";
		$query_sql.=" LEFT JOIN bangu.u_area AS ci ON ci.id = la.city";
		$query_sql.=" where la.anchor_id={$id}";
		return $this ->db ->query($query_sql) ->row_array();
	}
	
	/**
	 * @method 获取用户id
	 * @param $id
	 * @author zyf
	 */
	public function get_userid($id){
		$user_data=$this->db->query("SELECT user_id from live_anchor where anchor_id={$id} and user_type=0")->row_array();
		if (!empty($user_data)){
			return $user_data['user_id'];
		}else{
			return 0;
		}
	}
	/**
	 *  @method修改主播用户数据     用于平台管理
	 *  @param $dataArr:(array)更新的数据
	 *  $whereArr:(array)更新的条件
	 * @return:更新的数据条数
	 */
	function update($dataArr, $whereArr)
	{
		$this->db->where($whereArr);
		$this->db->update('live_anchor', $dataArr);
		return $this->db->affected_rows();
	}
           /**
           *@method 主播标签
           */
           function get_anchor_attr_data(){
           	$attrArr='';
           	$query_sql='select description,dict_id from `live_dictionary` where dict_code="DICT_CONSTELLATION" or dict_code="DICT_BLOOD" or  dict_code="DICT_DECADE" or dict_code="DICT_EXPERT_ATTR" ';
		$attr_pid=$this ->db ->query($query_sql) ->result_array();
		if(!empty($attr_pid)){
	                    foreach ($attr_pid as $key => $value) {
	                    	      $sql='select  dict_id,description from  live_dictionary where pid= '.$value['dict_id'];
	                    	      $attrData=$this ->db ->query($sql) ->result_array();
	                    	      $attrArr[$key]['dict_id']=$value['dict_id'];
	                    	      $attrArr[$key]['description']=$value['description'];
	                    	      $attrArr[$key]['data']=$attrData;
	                    }
		}
		return $attrArr;

	}


	/**
	*@method 查询数据表
	*@param  $table:数据表,$where:查询条件
	*@return Array
	*/
	function select_table($table,$where){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		$query = $this->db->get();
		return $query->result_array();
	}

	/**
	*@method  查询主播信息  ---直播页面
	*@param  $table:数据表,$where:查询条件
	*@return Array
	*/
	function  sel_abchor_msg($where){
                      $this->db->select('anchor_id,user_id,status,user_type,name,photo,fans,description,comment,realname,addtime,live_status');
		$this->db->from('live_anchor');
		$this->db->where($where);
		$query = $this->db->get();
		return $query->row_array();
	}
	/**
	*@method  保存,注册主播  ---主播页面
	*@param  $table:数据表,$where:查询条件
	*@return Array
	*/
	function save_anchor_data($data,$anchor_pic='',$anchor_attr=''){
		$this->db->trans_begin(); //事务开启
		$query_sql=" select anchor_id from live_anchor where user_id={$data['user_id']} and user_type={$data['user_type']}";
		$anchor=$this ->db ->query($query_sql) ->row_array();

                    	if(!empty($anchor)){   //存着就编辑
                               	$anchor_id=$anchor['anchor_id'];
                               	$wh=array(
                               		'user_id'=>$data['user_id'],
                               		'user_type'=>$data['user_type']
                               	);
                               	$this->db->where($wh)->update('live_anchor', $data);

                    		//主播图片
		/*	if(!empty($anchor_pic)){
				//$picArr=explode(',', $anchor_pic);
				$picArr=$anchor_pic;
				foreach ($picArr as $key => $value) {
					if(!empty($value)){
						$picdata=array(
							'anchor_id'=>$anchor['anchor_id'],
							'pic'=>$value,
							'addtime'=>date('Y-m-d H:i:s',time()),
						);
						$this->db->insert("live_anchor_pic",$picdata);
					}
				}
			}*/
	         	       //我的标签
	                 	if(!empty($anchor_attr)){
	                                //$attrArr=explode(',', $anchor_attr) ;
	                 		$attrArr=$anchor_attr;
	                                	$attrstr=array();
	                                	$attrData=$this->db->select('anchor_id,attr_id')->where(array('anchor_id'=>$anchor_id))->get('live_anchor_attr')->result_array();
	                               	 if(!empty($attrData)){
	                                            foreach ($attrData as $k=>$v){  //没选中的就删除
	                                                        if(!empty($v['attr_id'])){
	                                                              $attrstr[]=$v['attr_id'];
	                                                              if(!in_array($v['attr_id'],$attrArr)){
	                                                                          $this->db->where(array('anchor_id'=>$anchor_id,'attr_id'=>$v['attr_id']))->delete('live_anchor_attr');
	                                                              }
	                                                        }
	                                            }
	                                	}
	                                	foreach ($attrArr as $k=>$v){
	                                            if(!empty($v)){
	                                                   if(!in_array($v,$attrstr)){  //不存在该标签就插入
	                                                        $this->db->insert('live_anchor_attr',array('anchor_id'=>$anchor_id,'attr_id'=>$v));//插入表
	                                                   }
	                                             }
	                               	 }
	                     	}
	                     //我的图片
	                     	if(!empty($anchor_pic)){
	                     		$picArr=$anchor_pic;
	                                	$picstr=array();
	                               	$picData=$this->db->select('anchor_id,pic')->where(array('anchor_id'=>$anchor_id))->get('live_anchor_pic')->result_array();
	                                	if(!empty($picData)){
	                                            	foreach ($picData as $k=>$v){  //没选中的就删除
	                                                        	if(!empty($v['pic'])){
		                                                            $picstr[]=$v['pic'];
		                                                            if(!in_array($v['pic'],$picArr)){
		                                                                          $this->db->where(array('anchor_id'=>$anchor_id,'pic'=>$v['pic']))->delete('live_anchor_pic');
		                                                            }
	                                                       	 }
	                                            	}
	                               	}
	                               	foreach ($picArr as $k=>$v){
	                                            	if(!empty($v)){
		                                                $time=date("Y-m-d H:i:s",time());
		                                                if(!in_array($v,$picstr)){  //不存在该标签就插入
		                                                        $this->db->insert('live_anchor_pic',array('anchor_id'=>$anchor_id,'pic'=>$v,'addtime'=>$time));//插入表
		                                                }
	                                             	}
	                                	}
	                     }

	                      //标签
/*			if(!empty($anchor_attr)){
				//$attrArr=explode(',', $anchor_attr);
				$attrArr=$anchor_attr;
				foreach ($attrArr as $key => $value) {
					if(!empty($value)){
						$attrdata=array(
							'anchor_id'=>$anchor['anchor_id'],
							'attr_id'=>$value,
						);
						$this->db->insert("live_anchor_attr",$picdata);
					}
				}
			}*/


                    }else{  //不存在就插入

			//插入主播主表
			$this->db->insert("live_anchor",$data);
			$anchor_id=$this->db->insert_id();

			//主播图片
			if(!empty($anchor_pic)){
				//$picArr=explode(',', $anchor_pic);
				$picArr=$anchor_pic;
				foreach ($picArr as $key => $value) {
					if(!empty($value)){
						$picdata=array(
							'anchor_id'=>$anchor_id,
							'pic'=>$value,
							'addtime'=>date('Y-m-d H:i:s',time()),
						);
						$this->db->insert("live_anchor_pic",$picdata);
					}
				}
			}

	                      //标签
			if(!empty($anchor_attr)){
				//$attrArr=explode(',', $anchor_attr);
				$attrArr=$anchor_attr;
				foreach ($attrArr as $key => $value) {
					if(!empty($value)){
						$attrdata=array(
							'anchor_id'=>$anchor_id,
							'attr_id'=>$value,
						);
						$this->db->insert("live_anchor_attr",$picdata);
					}
				}
			}

                    }

		$this->db->trans_complete();//事务结束
		if ($this->db->trans_status () === TRUE) {
			$this->db->trans_commit ();
			return $anchor_id;
		} else {
			$this->db->trans_rollback (); // 事务回滚
			echo false;
		}

	}

           /**
           *
           */
           function insert_liveAnchor($data){
           		$this->db->trans_begin(); //事务开启

           		//插入主播主表
		$this->db->insert("live_anchor",$data);
		$anchor_id=$this->db->insert_id();

		$this->db->trans_complete();//事务结束
		if ($this->db->trans_status () === TRUE) {
			$this->db->trans_commit ();
			return $anchor_id;
		} else {
			$this->db->trans_rollback (); // 事务回滚
			echo false;
		}
           }
	/**
	*@method  保存,编辑主播  ---我的资料
	*@param  $param
	*@return Array
	*/
           function save_edit_anchor($update,$anchor_pic,$anchor_attr,$anchor_id){
           	$this->db->trans_begin(); //事务开启

           	//修改主播资料
           	$this->db->where('anchor_id', $anchor_id)->update('live_anchor', $update);

           	//我的标签
                 	if(!empty($anchor_attr)){
                                //$attrArr=explode(',', $anchor_attr) ;
                 		$attrArr=$anchor_attr;
                                $attrstr=array();
                                $attrData=$this->db->select('anchor_id,attr_id')->where(array('anchor_id'=>$anchor_id))->get('live_anchor_attr')->result_array();
                                if(!empty($attrData)){
                                            foreach ($attrData as $k=>$v){  //没选中的就删除
                                                        if(!empty($v['attr_id'])){
                                                              $attrstr[]=$v['attr_id'];
                                                              if(!in_array($v['attr_id'],$attrArr)){
                                                                          $this->db->where(array('anchor_id'=>$anchor_id,'attr_id'=>$v['attr_id']))->delete('live_anchor_attr');
                                                              }
                                                        }
                                            }
                                }
                                foreach ($attrArr as $k=>$v){
                                            if(!empty($v)){
                                                   if(!in_array($v,$attrstr)){  //不存在该标签就插入
                                                        $this->insert_data('live_anchor_attr',array('anchor_id'=>$anchor_id,'attr_id'=>$v));//插入表
                                                   }
                                             }
                                }
                     }

                     //我的图片
                     	if(!empty($anchor_pic)){
                             //   $picArr=explode(',', $anchor_pic) ;
                     		$picArr=$anchor_pic;
                                $picstr=array();
                                $picData=$this->db->select('anchor_id,pic')->where(array('anchor_id'=>$anchor_id))->get('live_anchor_pic')->result_array();
                                if(!empty($picData)){
                                            foreach ($picData as $k=>$v){  //没选中的就删除
                                                        if(!empty($v['pic'])){
                                                              $picstr[]=$v['pic'];
                                                              if(!in_array($v['pic'],$picArr)){
                                                                          $this->db->where(array('anchor_id'=>$anchor_id,'pic'=>$v['pic']))->delete('live_anchor_pic');
                                                              }
                                                        }
                                            }
                                }
                                foreach ($picArr as $k=>$v){
                                            if(!empty($v)){
                                                   if(!in_array($v,$picstr)){  //不存在该标签就插入
                                                        $this->insert_data('live_anchor_pic',array('anchor_id'=>$anchor_id,'pic'=>$v));//插入表
                                                   }
                                             }
                                }
                     }

           	$this->db->trans_complete();//事务结束
		if ($this->db->trans_status () === TRUE) {
			$this->db->trans_commit ();
			echo true;
		} else {
			$this->db->trans_rollback (); // 事务回滚
			echo false;
		}

           }

}