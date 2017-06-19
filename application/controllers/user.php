<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 用户中心重定向
 * @author Hejun
 *
 */
class User extends UC_Controller {

	public function index()
	{
		redirect('order_from/order/line_order');
	}
}
