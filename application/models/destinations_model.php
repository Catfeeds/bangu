<?php
/**
 * @method 目的地
 * @since  2015-07-24
 * @author 贾开荣
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Destinations_model extends MY_Model {


    function __construct() {
        parent::__construct('u_dest_base');
    }
    /**
     * @method 增加目的地的线路数量
     * @param unknown $destIds
     */
    public function increaseNum($destIds)
    {
    	$sql = 'update u_dest_base set line_num = line_num+1 where id in ('.$destIds.')';
    	return $this ->db ->query($sql);
    }
    /**
     * @method 减少目的地的线路数量
     * @param unknown $destIds
     */
    public function reduceNum($destIds)
    {
    	$sql = 'update u_dest_base set line_num = line_num-1 where id in ('.$destIds.')';
    	return $this ->db ->query($sql);
    }
    
    public function getDestData(array $whereArr=array() , $fields = '*')
    {
    	$sql = 'select '.$fields.' from u_dest_base ';
    	return $this ->queryCommon($sql ,$whereArr);
    }
    
    /**
     * @method 通过一组id获取数据
     * @author jiakairong
     * @since  2015-11-14
     * @param unknown $ids
     */
    public function getDestInData($ids) {
    	$sql = 'select id,kindname as name,pid from u_dest_base where id in ('.$ids.') and level=3';
    	return $this ->db ->query($sql) ->result_array();
    }
    /**
     * @method 通过目的地id（多个）获取目的地
     * @param unknown $destids
     */
    public function getDestIn($destids) {
    	$sql = 'select * from u_dest_base where id in ('.$destids.')';
    	return $this ->db ->query($sql) ->result_array();
    }
    /**
     * @method 通过名称获取数据,用于线路列表
     * @author jiakairong
     * @since  2015-11-14
     * @param unknown $ids
     */
    public function getDestNameData($name) 
    {
    	$sql = 'select id from u_dest_base where kindname = "'.$name.'"';
    	return $this ->db ->query($sql) ->result_array();
    }
    
    /**
     * @method 获取自己以及其上级
     * @param unknown $id
     */
    public function getDestPdata($id)
    {
    	$sql = 'select d.kindname,(select p.kindname from u_dest_base as p where p.id=d.pid) as pname from u_dest_base as d where d.id='.$id;
    	return $this ->db ->query($sql) ->result_array();
    }
}
