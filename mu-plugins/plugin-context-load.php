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
	if(is_admin())
	{
		return get_option("plugin_context_load/admin_plugins",false);
	}
	return get_option("plugin_context_load/frontend_plugins",false);
}
