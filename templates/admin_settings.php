<?php
/**
 *
 *  * @ author ( Zikiy Vadim )
 *  * @ site http://online-services.org.ua
 *  * @ name
 *  * @ copyright Copyright (C) 2016 All rights reserved.
 */
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h1><?php echo __( 'VDZ Robots.txt settings page', VDZ_ROBOTS_DOMAIN ); ?></h1>
		</div>

		<?php if ( $robots_file_exist ) : ?>
			<div class="col-sm-12">
				<div class="bg-danger">
					<h3><?php echo __( 'Warning your file Robots.txt - realy exist.', VDZ_ROBOTS_DOMAIN ); ?></h3>
					<p><?php echo __( 'Remove real file and put content from him to virtual Robots.txt content field', VDZ_ROBOTS_DOMAIN ); ?></p>
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $permalink_structure_empty ) : ?>
			<div class="col-sm-12">
				<div class="bg-danger">
					<h3><?php echo sprintf( __( 'Change your %s. For Plain settings - impossible to create a virtual Robots.txt file', VDZ_ROBOTS_DOMAIN ), '<a href="' . get_admin_url() . 'options-permalink.php" target="_blank">' . __( 'Permalink Settings' ) . '</a>' ); ?></h3>
				</div>
			</div>
		<?php endif; ?>

	</div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-6 col-xs-12">
			<h3>
				<?php echo __( 'NEW / Virtual file Robots.txt', VDZ_ROBOTS_DOMAIN ); ?>
			</h3>

			<form action="options.php" method="POST">

				<?php
				// Выводи идентификаторы группы полей + wp_nonce для нашего действия
				settings_fields( 'vdz_robots_plugin_settings_group' );
				// Получаем данные из базы
				$vdz_robots_plugin_settings = get_option( 'vdz_robots_plugin_settings' );
				?>
				<textarea class="form-control" name="vdz_robots_plugin_settings[vdz_robots_content]" rows="20"
						  placeholder="<?php echo __( 'Put your Robots.txt content HERE', VDZ_ROBOTS_DOMAIN ); ?>"><?php echo ( isset( $vdz_robots_plugin_settings['vdz_robots_content'] ) ? $vdz_robots_plugin_settings['vdz_robots_content'] : '' ); ?></textarea>
				<div>
					<?php if ( isset( $vdz_robots_plugin_settings['vdz_robots_public'] ) ) : ?>
					<h3><?php echo __( 'Search Engine Visibility', VDZ_ROBOTS_DOMAIN ); ?></h3>
					<p><?php echo __( 'Discourage search engines from indexing this site', VDZ_ROBOTS_DOMAIN ); ?></p>
					<div id="robots_public" class="btn-group" data-toggle="buttons">
						<label class="btn btn-primary <?php echo ( ! empty( $vdz_robots_plugin_settings['vdz_robots_public'] ) ? 'active' : '' ); ?>">
							<input type="radio" name="vdz_robots_plugin_settings[vdz_robots_public]" autocomplete="off" <?php echo ( ! empty( $vdz_robots_plugin_settings['vdz_robots_public'] ) ? 'checked' : '' ); ?> value="1">ON
						</label>
						<label class="btn btn-primary <?php echo ( empty( $vdz_robots_plugin_settings['vdz_robots_public'] ) ? 'active' : '' ); ?>">
							<input type="radio" name="vdz_robots_plugin_settings[vdz_robots_public]" <?php echo ( empty( $vdz_robots_plugin_settings['vdz_robots_public'] ) ? 'checked' : '' ); ?> value="0">OFF
						</label>
					</div>
					<?php endif; ?>
				</div>

				<hr/>


				<button type="submit" class="button-primary button">
					<?php echo __( 'Save NEW Robots.txt', VDZ_ROBOTS_DOMAIN ); ?>
				</button>


			</form>
		</div>
		<div class="col-sm-6 col-xs-12">
			<h3><?php echo sprintf( __( 'Now used %s content', VDZ_ROBOTS_DOMAIN ), '<a href="' . get_site_url() . '/robots.txt" target="_blank">Robots.txt</a>' ); ?></h3>
			<textarea class="form-control" rows="20" disabled><?php echo $real_robotstxt_content; ?></textarea>
			<div class="text-right">
				<br/>
				<?php
				$plugin_data = get_plugin_data( VDZ_ROBOTS_FILE );
				?>
				<?php if ( isset( $plugin_data['AuthorURI'] ) && ! empty( $plugin_data['AuthorURI'] ) && isset( $plugin_data['AuthorName'] ) && ! empty( $plugin_data['AuthorName'] ) ) : ?>
					<a href="<?php echo esc_url( $plugin_data['AuthorURI'] ); ?>" target="_blank"><?php echo $plugin_data['AuthorName']; ?></a>
				<?php endif; ?>
			</div>
		</div>
	</div>

</div>
