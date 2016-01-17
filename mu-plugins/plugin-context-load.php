<?php
/**
 * Created by PhpStorm.
 * User: eggp
 * Date: 2016. 01. 16.
 * Time: 11:07
 */

add_filter("pre_option_active_plugins","plugin_context_load_active_plugins_filter");
function plugin_context_load_active_plugins_filter($plugins = array())
{
	remove_filter("pre_option_active_plugins","plugin_context_load_active_plugins_filter");
	$load_plugins = array();
	if(defined("DOING_CRON"))
	{
		$load_plugins = get_option("plugin_context_load/cron_plugins",false);
	}
	else if(defined("XMLRPC_REQUEST"))
	{
		$load_plugins =get_option("plugin_context_load/xmlrpc_plugins",false);
	}
	else if(defined("DOING_AJAX"))
	{
		if(is_user_logged_in())
		{
			$load_plugins =get_option("plugin_context_load/loggedin_user_ajax_plugins",false);
		}
		else
		{
			$load_plugins =get_option("plugin_context_load/not_loggedin_user_ajax_plugins",false);
		}
	}
	else if(is_admin())
	{
		$load_plugins =get_option("plugin_context_load/admin_plugins",false);
	}
	if(count($load_plugins) == 0)
	{
		return get_option("plugin_context_load/frontend_plugins",false);
	}
	else
	{
		return $load_plugins;
	}
}
