<?php
/**
 * 目的地模型
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Destination extends UB2_Controller {

	public function __construct() {
		parent::__construct();

		$this->load_model('admin/b2/destination_model', 'destination');
	}
	
	public function index() {
		
		$res = $this->destination->test();
		var_dump($res);
	}
}