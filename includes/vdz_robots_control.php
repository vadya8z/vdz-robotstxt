<?php
/**
 *
 *  * @ author ( Zikiy Vadim )
 *  * @ site http://online-services.org.ua
 *  * @ name
 *  * @ copyright Copyright (C) 2016 All rights reserved.
 */


register_activation_hook( VDZ_ROBOTS_FILE, 'vdz_robots_activate_plugin' );
function vdz_robots_activate_plugin() {

	global $wp_version;
	if ( version_compare( $wp_version, '3.8', '<' ) ) {
		// Деактивируем плагин
		deactivate_plugins( plugin_basename( VDZ_ROBOTS_FILE ) );
		wp_die( 'This plugin required WordPress version 3.8 or higher' );
	}

	$default_robots_txt_content = "User-agent: * \nDisallow: /wp-admin/\nAllow: /wp-admin/admin-ajax.php\n";

	// Add options array to options table
	add_option(
		'vdz_robots_plugin_settings',
		array(
			'vdz_robots_content' => $default_robots_txt_content,
			'vdz_robots_public'  => get_option( 'blog_public' ),
		)
	);

	do_action( VDZ_ROBOTS_API, 'on', plugin_basename( __FILE__ ) );
}


