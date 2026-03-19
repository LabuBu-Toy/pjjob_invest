<?php
/**
 * Database management class
 *
 * @package PJJob_Invest
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Database class for managing asset data
 */
class PJJob_Invest_Database {
	/**
	 * Table name
	 *
	 * @var string
	 */
	private $table_name;

	/**
	 * Constructor
	 */
	public function __construct() {
		global $wpdb;
		$this->table_name = $wpdb->prefix . 'pjjob_invest_assets';
	}

	/**
	 * Get the table name
	 *
	 * @return string
	 */
	public function get_table_name() {
		return $this->table_name;
	}

	/**
	 * Insert a new asset
	 *
	 * @param string $asset_name Asset name
	 * @param float  $holding_amount Holding amount
	 * @param string $category Category
	 * @param string $created_date Date created
	 *
	 * @return int|false Insert ID or false on failure
	 */
	public function insert_asset( $asset_name, $holding_amount, $category, $created_date ) {
		global $wpdb;

		$data = array(
			'asset_name'     => $asset_name,
			'holding_amount' => $holding_amount,
			'category'       => $category,
			'created_date'   => $created_date,
		);

		$format = array( '%s', '%f', '%s', '%s' );

		$result = $wpdb->insert( $this->table_name, $data, $format );

		if ( $result ) {
			return $wpdb->insert_id;
		}

		return false;
	}

	/**
	 * Get all active assets
	 *
	 * @return array Assets
	 */
	public function get_all_assets() {
		global $wpdb;

		$sql = $wpdb->prepare(
			"SELECT * FROM {$this->table_name} WHERE deleted_date IS NULL ORDER BY created_date DESC"
		);

		return $wpdb->get_results( $sql, ARRAY_A );
	}

	/**
	 * Get assets by category
	 *
	 * @param string $category Category name
	 *
	 * @return array Assets in category
	 */
	public function get_assets_by_category( $category ) {
		global $wpdb;

		$sql = $wpdb->prepare(
			"SELECT * FROM {$this->table_name} WHERE category = %s AND deleted_date IS NULL ORDER BY created_date DESC",
			$category
		);

		return $wpdb->get_results( $sql, ARRAY_A );
	}

	/**
	 * Get total asset value
	 *
	 * @return float Total value
	 */
	public function get_total_assets() {
		global $wpdb;

		$sql = $wpdb->prepare(
			"SELECT SUM(holding_amount) as total FROM {$this->table_name} WHERE deleted_date IS NULL"
		);

		$result = $wpdb->get_row( $sql, ARRAY_A );

		return $result['total'] ? floatval( $result['total'] ) : 0;
	}

	/**
	 * Get assets by category with totals
	 *
	 * @return array Categories with totals
	 */
	public function get_categories_with_totals() {
		global $wpdb;

		$sql = $wpdb->prepare(
			"SELECT category, SUM(holding_amount) as total, COUNT(asset_id) as count FROM {$this->table_name} WHERE deleted_date IS NULL GROUP BY category ORDER BY total DESC"
		);

		return $wpdb->get_results( $sql, ARRAY_A );
	}

	/**
	 * Update asset (soft delete)
	 *
	 * @param int $asset_id Asset ID
	 *
	 * @return bool Success status
	 */
	public function delete_asset( $asset_id ) {
		global $wpdb;

		$data   = array( 'deleted_date' => current_time( 'mysql' ) );
		$where  = array( 'asset_id' => $asset_id );
		$format = array( '%s' );
		$where_format = array( '%d' );

		return $wpdb->update( $this->table_name, $data, $where, $format, $where_format ) !== false;
	}

	/**
	 * Get single asset
	 *
	 * @param int $asset_id Asset ID
	 *
	 * @return array|null Asset data or null
	 */
	public function get_asset( $asset_id ) {
		global $wpdb;

		$sql = $wpdb->prepare(
			"SELECT * FROM {$this->table_name} WHERE asset_id = %d AND deleted_date IS NULL",
			$asset_id
		);

		return $wpdb->get_row( $sql, ARRAY_A );
	}
}
