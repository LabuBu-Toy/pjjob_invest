<?php
/**
 * Fired during plugin activation
 *
 * @package PJJob_Invest
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Activator class
 */
class PJJob_Invest_Activator {
	/**
	 * Create database tables on plugin activation
	 *
	 * @return void
	 */
	public static function activate() {
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();
		$table_name      = $wpdb->prefix . 'pjjob_invest_assets';

		$sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
			asset_id BIGINT(20) NOT NULL AUTO_INCREMENT,
			asset_name VARCHAR(255) NOT NULL,
			holding_amount DECIMAL(15, 2) NOT NULL,
			created_date DATETIME NOT NULL,
			deleted_date DATETIME DEFAULT NULL,
			category VARCHAR(100),
			PRIMARY KEY (asset_id),
			KEY category (category)
		) {$charset_collate};";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );

		// Store plugin version
		update_option( 'pjjob_invest_version', PJJOB_INVEST_VERSION );
	}
}
