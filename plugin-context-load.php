<?php

/*
Plugin Name: Plugin Context Load
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A brief description of the Plugin.
Version: 1.0
Author: eggp
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/

if ( is_admin() ) {
	add_action( 'admin_menu', 'plugin_context_load_add_admin_pages' );

	function plugin_context_load_add_admin_pages() {
		add_menu_page( 'Plugin context load',
				'Plugin context load',
				'manage_options',
				'plugin-context-load',
				'plugin_context_load_admin_form' );
	}

	function plugin_context_load_admin_form() {
		// TODO onmagat vegye ki a listabol es mindig legyen benne mentesnel!
		$plugins = get_plugins();
		$admin_plugins = get_option( "plugin_context_load/admin_plugins", array());
		$front_end_plugins = get_option( "plugin_context_load/front_end_plugins", array() );

		?>
		<form method="post" action="admin-post.php" enctype="application/x-www-form-urlencoded">
			<table>
				<thead>
				<tr>
					<th>Név</th>
					<th>Admin</th>
					<th>Front page</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ( $plugins as $path => $plugin ): ?>
					<tr>
						<td>
							<?php echo $plugin['Name']; ?>
						</td>
						<td>
							<input type="checkbox" name="cron_plugins[]" value="<?php echo $path; ?>"
									<?php echo ((array_search($path,$admin_plugins) !== false)?"checked='checked'":""); ?>/>
						</td>
						<td>
							<input type="checkbox" name="xmlrpc_plugins[]" value="<?php echo $path; ?>"
									<?php echo ((array_search($path,$admin_plugins) !== false)?"checked='checked'":""); ?>/>
						</td>
						<td>
							<input type="checkbox" name="loggedin_user_ajax_plugins[]" value="<?php echo $path; ?>"
									<?php echo ((array_search($path,$admin_plugins) !== false)?"checked='checked'":""); ?>/>
						</td>
						<td>
							<input type="checkbox" name="not_loggedin_user_ajax_plugins[]" value="<?php echo $path; ?>"
									<?php echo ((array_search($path,$admin_plugins) !== false)?"checked='checked'":""); ?>/>
						</td>
						<td>
							<input type="checkbox" name="admin_plugins[]" value="<?php echo $path; ?>"
									<?php echo ((array_search($path,$admin_plugins) !== false)?"checked='checked'":""); ?>/>
						</td>
						<td>
							<input type="checkbox" name="front_end_plugins[]" value="<?php echo $path; ?>"
									<?php echo ((array_search($path,$front_end_plugins) !== false)?"checked='checked'":""); ?>/>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
				<tfoot>
				<tr>
					<td colspan="3">
						<?php wp_nonce_field("3rijesetjf","4oitjoei4tr"); ?>
						<input type="hidden" name="action" value="plugin_context_load_save_admin_form" />
						<input type="submit" value="mentés"/>
					</td>
				</tr>
				</tfoot>
			</table>
		</form>
		<?php
	}

	add_action( 'admin_post_plugin_context_load_save_admin_form', 'plugin_context_load_save_admin_form' );
	function plugin_context_load_save_admin_form()
	{
		if ( !current_user_can( 'manage_options' ) )
		{
			wp_die( 'You are not allowed to be on this page.' );
		}
		// Check that nonce field
		check_admin_referer( '3rijesetjf' ,'4oitjoei4tr');

		if(isset($_POST['admin_plugins']) && isset($_POST['front_end_plugins'])) {
			update_option( "plugin_context_load/cron_plugins", $_POST['cron_plugins'] );
			update_option( "plugin_context_load/xmlrpc_plugins", $_POST['xmlrpc_plugins'] );
			update_option( "plugin_context_load/loggedin_user_ajax_plugins", $_POST['loggedin_user_ajax_plugins'] );
			update_option( "plugin_context_load/not_loggedin_user_ajax_plugins", $_POST['not_loggedin_user_ajax_plugins'] );
			update_option( "plugin_context_load/admin_plugins", $_POST['admin_plugins'] );
			update_option( "plugin_context_load/front_end_plugins", $_POST['front_end_plugins'] );
		}

		wp_redirect(  admin_url( 'admin.php?page=plugin-context-load' ) );
		exit;
	}
}