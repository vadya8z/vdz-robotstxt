<?php
/*
Plugin Name: VDZ Robots.txt
Plugin URI:  http://online-services.org.ua
Description: Simple Robots.txt Editor in admin
Version:     1.3.20
Author:      VadimZ
Author URI:  http://online-services.org.ua#vdz-robots
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/


define( 'VDZ_ROBOTS_VERSION', '1.3.20' );
define( 'VDZ_ROBOTS_DOMAIN', 'vdz_robots' );

define( 'VDZ_ROBOTS_DIR', plugin_dir_path( __FILE__ ) );
define( 'VDZ_ROBOTS_URL', plugin_dir_url( __FILE__ ) );
define( 'VDZ_ROBOTS_FILE', __FILE__ );
define( 'VDZ_ROBOTS_API', 'vdz_info_robots' );

// Init plagin
require_once VDZ_ROBOTS_DIR . 'includes/vdz_robots_construct.php';
require_once 'updated_plugin_admin_notices.php';

// Код деактивации плагина
register_deactivation_hook( __FILE__, function () {
	$plugin_name = preg_replace( '|\/(.*)|', '', plugin_basename( __FILE__ ));
	$response = wp_remote_get( "http://api.online-services.org.ua/off/{$plugin_name}" );
	if ( ! is_wp_error( $response ) && isset( $response['body'] ) && ( json_decode( $response['body'] ) !== null ) ) {
		//TODO Вывод сообщения для пользователя
	}
} );
//Сообщение при отключении плагина
add_action( 'admin_init', function (){
	if(is_admin()){
		$plugin_data = get_plugin_data(__FILE__);
		$plugin_slug    = isset( $plugin_data['slug'] ) ? $plugin_data['slug'] : sanitize_title( $plugin_data['Name'] );
		$plugin_id_attr = $plugin_slug;
		$plugin_name = isset($plugin_data['Name']) ? $plugin_data['Name'] : ' us';
		$plugin_dir_name = preg_replace( '|\/(.*)|', '', plugin_basename( __FILE__ ));
		$handle = 'admin_'.$plugin_dir_name;
		wp_register_script( $handle, '', null, false, true );
		wp_enqueue_script( $handle );
		$msg = '';
		if ( function_exists( 'get_locale' ) && in_array( get_locale(), array( 'uk', 'ru_RU' ), true ) ) {
			$msg .= "Спасибо, что были с нами! ({$plugin_name}) Хорошего дня!";
		}else{
			$msg .= "Thanks for your time with us! ({$plugin_name}) Have a nice day!";
		}
		if(substr_count( $_SERVER['REQUEST_URI'], 'plugins.php')){
			wp_add_inline_script( $handle, "if(document.getElementById('deactivate-".esc_attr($plugin_id_attr)."')){document.getElementById('deactivate-".esc_attr($plugin_id_attr)."').onclick=function (e){alert('".esc_attr( $msg )."');}}" );
		}
	}
} );



// Добавляем допалнительную ссылку настроек на страницу всех плагинов
// function vdz_robots_settings_link($links) {
// $settings_link = '<a href="' . get_admin_url() . 'options-general.php?page='.VDZ_ROBOTS_DOMAIN.'">'.__('Settings').'</a>';
// array_unshift($links, $settings_link);
// return $links;
// }
// add_filter('plugin_action_links_'.plugin_basename(VDZ_ROBOTS_FILE), 'vdz_robots_settings_link' );


