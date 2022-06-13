<?php
/**
 *
 *  * @ author ( Zikiy Vadim )
 *  * @ site http://online-services.org.ua
 *  * @ name
 *  * @ copyright Copyright (C) 2016 All rights reserved.
 */

// For backend
if ( is_admin() ) {
	if ( ! class_exists( 'FlightView' ) ) {
		// Add VIEW Class
		require_once VDZ_ROBOTS_DIR . 'includes/classes/FlightView.php';
	}

	// API
	require_once VDZ_ROBOTS_DIR . 'includes/api.php';

	// Активация деактивация плагина
	require_once VDZ_ROBOTS_DIR . 'includes/vdz_robots_control.php';

	// All admin assets
	require_once VDZ_ROBOTS_DIR . 'includes/vdz_robots_assets.php';

	// Класс админки vdz_robots
	require_once VDZ_ROBOTS_DIR . 'includes/classes/vdz_robots_admin_class.php';

}

// Класс для robots.txt
require_once VDZ_ROBOTS_DIR . 'includes/classes/vdz_robots_txt_class.php';





