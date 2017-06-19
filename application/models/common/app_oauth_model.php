<?php
/**
 * 外部应用：用户服务授权(models)
 * models/app_oauth_model.php
 * ============================================================
 * app_oauth_model
 * ============================================================
 * 作者：何俊 （junhey@qq.com）v1.0.0
 * 时间：2015-08-11
 */
class App_oauth_model extends MY_Model
{
	/**
	 *	构造函数
	 */
	function __construct()
	{
		parent::__construct('u_app_oauth');
	}

}
?>
