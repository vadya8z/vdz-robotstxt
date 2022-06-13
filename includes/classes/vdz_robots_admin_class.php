<?php
/**
 *
 *  * @ author ( Zikiy Vadim )
 *  * @ site http://online-services.org.ua
 *  * @ name
 *  * @ copyright Copyright (C) 2016 All rights reserved.
 */

class vdzRobotsAdmin {
	const ROBOTSTXT_FILE_NAME = 'robots.txt';
	private static $instance;

	public $robots_file_exist = false;

	private function __construct() {
		if ( is_admin() ) {
			// Ссылка настроек в списке плагинов
			$this->add_settings_link();
			// Добавляем меню только по хуку 'admin_menu' т.к. ранее не вызывается ф-ция current_user_can
			add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
		}
	}

	public static function getInstance() {
		if ( empty( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	// Добавляем допалнительную ссылку настроек на страницу всех плагинов
	public function add_settings_link() {
		add_filter( 'plugin_action_links_' . plugin_basename( VDZ_ROBOTS_FILE ), array( $this, 'settings_link' ) );
	}
	public function settings_link( $links ) {
		$settings_link = '<a href="' . get_admin_url() . 'options-general.php?page=' . VDZ_ROBOTS_DOMAIN . '">' . __( 'Settings' ) . '</a>';
		array_unshift( $links, $settings_link );
		return $links;
	}

	// Добавляем страницу настроек
	public function add_settings_page() {
		add_options_page(
			__( 'VDZ Robots.txt Settings page', VDZ_ROBOTS_DOMAIN ), // Название страницы
			__( 'VDZ Robots.txt ', VDZ_ROBOTS_DOMAIN ), // Название меню
			'manage_options', // Права
			VDZ_ROBOTS_DOMAIN, // Слаг
			array( $this, 'settings_page_view' ) // Ф-ция или класс отвечающий за отображение страницы
		);

		// Вызываем ф-ции для регистрации настроек плагина
		add_action( 'admin_init', array( $this, 'register_setting' ) );
	}
	public function settings_page_view() {
		$sp = new FlightView( VDZ_ROBOTS_DIR . 'templates/' );
		echo $sp->render(
			'admin_settings',
			array(
				'real_robotstxt_content'    => $this->get_real_robotstxt_content(),
				'robots_file_exist'         => $this->robots_file_exist,
				'permalink_structure_empty' => ( '' == get_option( 'permalink_structure' ) ) ? true : false,
			)
		);
	}

	// Find Robots File and get content
	public function get_real_robotstxt_content() {
		$url_to_robots_file = get_home_url( null, self::ROBOTSTXT_FILE_NAME );

		$robotstxt_content = '';
		if ( file_exists( ABSPATH . self::ROBOTSTXT_FILE_NAME ) ) {
			$this->robots_file_exist = true;
			$robotstxt_content      .= file_get_contents( ABSPATH . self::ROBOTSTXT_FILE_NAME );
		} else {
			// При простой структуре генерации ссылок - не возможно создать виртуальный файл
			if ( '' != get_option( 'permalink_structure' ) ) {
				// Все OK, делаем что нибудь с данными $request['body']
				$robotstxt_content .= file_get_contents( $url_to_robots_file );
			} else {
				$robotstxt_content .= '';
			}
		}
		return $robotstxt_content;
	}

	// Регистрация настроек для плагина и формы
	public function register_setting() {
		// настройки для плагина
		register_setting( 'vdz_robots_plugin_settings_group', 'vdz_robots_plugin_settings', array( $this, 'vdz_robots_plugin_settings_sanitize' ) );
	}
	// Обработка полей формы перед сохранением в базу
	public function vdz_robots_plugin_settings_sanitize( $input ) {
		 // $input['vdz_robots_content'] = wp_kses_post($input['vdz_robots_content']);
		// Очищаем от пробелов что бы пустое поле было действительно пустым и не перекрывало генерацию стандартного файла
		$input['vdz_robots_content'] = trim( wp_kses_post( $input['vdz_robots_content'] ) );
		$input['vdz_robots_public']  = (int) $input['vdz_robots_public'];
		// Обновляем общую опцию WP
		update_option( 'blog_public', $input['vdz_robots_public'] );
		// Добавляем вывод сообщения при успешном сохранении
		add_settings_error( 'vdz_robots_plugin_settings', 'settings_updated', __( 'Robots.txt UPDATED', VDZ_ROBOTS_DOMAIN ), 'updated' );

		return $input;
	}

}
vdzRobotsAdmin::getInstance();



