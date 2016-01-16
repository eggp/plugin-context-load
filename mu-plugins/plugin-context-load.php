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
	if(defined("DOING_CRON"))
	{
		return get_option("plugin_context_load/cron_plugins",false);
	}
	else if(defined("XMLRPC_REQUEST"))
	{
		return get_option("plugin_context_load/xmlrpc_plugins",false);
	}
	else if(defined("DOING_AJAX"))
	{
		if(is_user_logged_in())
		{
			return get_option("plugin_context_load/loggedin_user_ajax_plugins",false);
		}
		else
		{
			return get_option("plugin_context_load/not_loggedin_user_ajax_plugins",false);
		}
	}
	else if(is_admin())
	{
		return get_option("plugin_context_load/admin_plugins",false);
	}
	return get_option("plugin_context_load/frontend_plugins",false);
}
