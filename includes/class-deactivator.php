<?php
/**
 * Fired during plugin deactivation
 *
 * @package PJJob_Invest
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Deactivator class
 */
class PJJob_Invest_Deactivator {
	/**
	 * Deactivate the plugin
	 *
	 * @return void
	 */
	public static function deactivate() {
		// Clear scheduled cron events if any
		// Preserve data on deactivation
	}
}
