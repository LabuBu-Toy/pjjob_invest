<?php
/**
 * Admin pages class
 *
 * @package PJJob_Invest
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin pages class
 */
class PJJob_Invest_Admin_Pages {

	/**
	 * Display dashboard page
	 *
	 * @return void
	 */
	public static function display_dashboard() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'pjjob-invest' ) );
		}

		wp_enqueue_style( 'pjjob-invest-admin-css' );
		wp_enqueue_script( 'chart-js' );
		wp_enqueue_script( 'pjjob-invest-admin-js' );

		$assets_manager = new PJJob_Invest_Assets_Manager();
		$dashboard_data = $assets_manager->get_dashboard_data();

		include PJJOB_INVEST_PLUGIN_DIR . 'admin/templates/dashboard.php';
	}

	/**
	 * Display add asset page
	 *
	 * @return void
	 */
	public static function display_add_asset() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'pjjob-invest' ) );
		}

		wp_enqueue_style( 'pjjob-invest-admin-css' );
		wp_enqueue_script( 'pjjob-invest-admin-js' );

		wp_localize_script(
			'pjjob-invest-admin-js',
			'pjjobInvestAdmin',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'pjjob_invest_nonce' ),
			)
		);

		include PJJOB_INVEST_PLUGIN_DIR . 'admin/templates/add-asset.php';
	}
}
