<?php
/**
 *
 *  * @ author ( Zikiy Vadim )
 *  * @ site http://online-services.org.ua
 *  * @ name
 *  * @ copyright Copyright (C) 2016 All rights reserved.
 */

if ( ! defined( 'VDZ_ROBOTS_VERSION' ) ) {
	exit;
}
// ДОбавляем скрипты и стили только для странциы настройки нашего плагина
if ( substr_count( $_SERVER['REQUEST_URI'], 'page=vdz_robots' ) ) {
	add_action( 'admin_head', 'vdz_robots_style' );
	add_action( 'admin_footer', 'vdz_robots_js' );
}


// Add styles
function vdz_robots_style() {
	wp_register_style( 'bootstrap', VDZ_ROBOTS_URL . 'vdz_assets/bootstrap/css/bootstrap.min.css', array(), VDZ_ROBOTS_VERSION );
	wp_enqueue_style( 'bootstrap' );
	wp_register_style( 'bootstrap_theme', VDZ_ROBOTS_URL . 'vdz_assets/bootstrap/css/bootstrap-theme.min.css', array(), VDZ_ROBOTS_VERSION );
	wp_enqueue_style( 'bootstrap_theme' );
	wp_register_style( 'vdz_robots', VDZ_ROBOTS_URL . 'vdz_assets/css/vdz_robots.css', array(), VDZ_ROBOTS_VERSION );
	wp_enqueue_style( 'vdz_robots' );
}
// Add scripts
function vdz_robots_js() {
	wp_register_script( 'vdz_robots', VDZ_ROBOTS_URL . 'vdz_assets/bootstrap/js/bootstrap.min.js', 'jquery', VDZ_ROBOTS_VERSION );
	wp_enqueue_script( 'vdz_robots' );
	wp_register_script( 'vdz_robots', VDZ_ROBOTS_URL . 'vdz_assets/js/vdz_robots.js', 'jquery', VDZ_ROBOTS_VERSION );
	wp_enqueue_script( 'vdz_robots' );
}


