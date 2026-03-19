<?php
/**
 * Shortcode class for rendering plugin content
 *
 * @package PJJob_Invest
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shortcode class
 */
class PJJob_Invest_Shortcode {
	/**
	 * Render dashboard shortcode
	 *
	 * @param array  $atts Shortcode attributes
	 * @param string $content Shortcode content
	 *
	 * @return string Rendered content
	 */
	public static function render_dashboard( $atts = array(), $content = null ) {
		wp_enqueue_style( 'pjjob-invest-public-css' );
		wp_enqueue_script( 'chart-js' );
		wp_enqueue_script( 'pjjob-invest-public-js' );

		$assets_manager = new PJJob_Invest_Assets_Manager();
		$dashboard_data = $assets_manager->get_dashboard_data();

		ob_start();
		include PJJOB_INVEST_PLUGIN_DIR . 'public/templates/dashboard.php';
		$output = ob_get_clean();

		return $output;
	}

	/**
	 * Render form shortcode
	 *
	 * @param array  $atts Shortcode attributes
	 * @param string $content Shortcode content
	 *
	 * @return string Rendered content
	 */
	public static function render_form( $atts = array(), $content = null ) {
		wp_enqueue_style( 'pjjob-invest-public-css' );
		wp_enqueue_script( 'pjjob-invest-public-js' );

		wp_localize_script(
			'pjjob-invest-public-js',
			'pjjobInvestData',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'pjjob_invest_nonce' ),
			)
		);

		ob_start();
		include PJJOB_INVEST_PLUGIN_DIR . 'public/templates/form.php';
		$output = ob_get_clean();

		return $output;
	}
}
