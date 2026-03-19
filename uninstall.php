<?php
/**
 * Fired when the plugin is uninstalled
 *
 * @package PJJob_Invest
 */

// Exit if accessed directly
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Delete custom database table
global $wpdb;
$table_name = $wpdb->prefix . 'pjjob_invest_assets';
$wpdb->query( "DROP TABLE IF EXISTS {$table_name}" );

// Delete plugin options
delete_option( 'pjjob_invest_version' );
delete_option( 'pjjob_invest_settings' );

// Delete transients
delete_transient( 'pjjob_invest_assets_total' );
delete_transient( 'pjjob_invest_assets_by_category' );
