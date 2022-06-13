<?php
/**
 *
 *  * @ author ( Zikiy Vadim )
 *  * @ site http://online-services.org.ua
 *  * @ name
 *  * @ copyright Copyright (C) 2016 All rights reserved.
 */

class vdzRobotsTxt {

	private static $instance;

	public static function getInstance() {
		if ( empty( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct() {
		 // Включен блог для поисковиков + структура генерации URL - без GET параметровы ЧПУшная
		// При простой структуре генерации ссылок - не возможно создать виртуальный файл
		if ( get_option( 'blog_public' ) && ( '' != get_option( 'permalink_structure' ) ) ) {
			// если у нас пустое поле - работает стандартный генератор файла
			$vdz_robots_plugin_settings = get_option( 'vdz_robots_plugin_settings' );
			$vdz_robots_content         = isset( $vdz_robots_plugin_settings['vdz_robots_content'] ) ? $vdz_robots_plugin_settings['vdz_robots_content'] : '';
			// Очищаем от обычных пробелов, если вдруг сохранили пустое поле с ними - очищаю при сохранении
			// $vdz_robots_content = trim($vdz_robots_content);
			if ( ! empty( $vdz_robots_content ) ) {
				remove_action( 'do_robots', 'do_robots' );
				add_action( 'do_robots', array( $this, 'do_robots' ) );
			}
		}
	}

	// Ф-ция генерации файла Robots.txt
	public function do_robots() {
		header( 'Content-Type: text/plain; charset=utf-8' );
		$output                     = '';
		$vdz_robots_plugin_settings = get_option( 'vdz_robots_plugin_settings' );
		if ( isset( $vdz_robots_plugin_settings['vdz_robots_content'] ) && ! empty( $vdz_robots_plugin_settings['vdz_robots_content'] ) ) {
			$output .= $vdz_robots_plugin_settings['vdz_robots_content'];
		}
		// $output .= "\n\n#Created by VDZ Robots.txt plugin\n";
		echo $output;
		exit;
	}

}
vdzRobotsTxt::getInstance();
