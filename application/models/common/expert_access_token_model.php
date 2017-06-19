<?php
/**
 * @method 接入token验证模型
 * @since  2015-06-19
 * @author hejun
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Expert_access_token_model extends MY_Model {


    function __construct() {
        parent::__construct('u_expert_access_token');
    }
}