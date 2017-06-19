<?php
/**
 * @method 周边游
 * @since  2015-07-24
 * @author 贾开荣
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Round_trip_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct('cfg_round_trip');
    }
    public function getRoundTripDest($cityId)
    {
    	$sql = 'select d.kindname as name,d.id as dest_id from cfg_round_trip as cfg left join u_dest_base as d on d.id = cfg.neighbor_id where cfg.isopen = 1 and d.isopen = 1 and cfg.startplaceid ='.$cityId;
    	return $this ->db ->query($sql) ->result_array();
    }
}
