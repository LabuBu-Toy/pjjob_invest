<?php
/**
 * Assets manager class
 *
 * @package PJJob_Invest
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Assets manager class
 */
class PJJob_Invest_Assets_Manager {
	/**
	 * Database instance
	 *
	 * @var PJJob_Invest_Database
	 */
	private $database;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->database = new PJJob_Invest_Database();
	}

	/**
	 * Add a new asset
	 *
	 * @param string $asset_name Asset name
	 * @param float  $holding_amount Holding amount
	 * @param string $category Category
	 * @param string $created_date Date created
	 *
	 * @return bool Success status
	 */
	public function add_asset( $asset_name, $holding_amount, $category, $created_date ) {
		// Validate inputs
		if ( empty( $asset_name ) || $holding_amount <= 0 || empty( $category ) || empty( $created_date ) ) {
			return false;
		}

		// Insert asset
		$result = $this->database->insert_asset(
			sanitize_text_field( $asset_name ),
			floatval( $holding_amount ),
			sanitize_text_field( $category ),
			sanitize_text_field( $created_date )
		);

		if ( $result ) {
			// Clear transients to refresh dashboard data
			delete_transient( 'pjjob_invest_assets_total' );
			delete_transient( 'pjjob_invest_assets_by_category' );
			return true;
		}

		return false;
	}

	/**
	 * Get all assets
	 *
	 * @return array Assets
	 */
	public function get_all_assets() {
		return $this->database->get_all_assets();
	}

	/**
	 * Get total assets value
	 *
	 * @return float Total value
	 */
	public function get_total_assets() {
		return $this->database->get_total_assets();
	}

	/**
	 * Get categories with totals
	 *
	 * @return array Categories data
	 */
	public function get_categories_with_totals() {
		return $this->database->get_categories_with_totals();
	}

	/**
	 * Get assets by category
	 *
	 * @param string $category Category name
	 *
	 * @return array Assets
	 */
	public function get_assets_by_category( $category ) {
		return $this->database->get_assets_by_category( $category );
	}

	/**
	 * Delete an asset
	 *
	 * @param int $asset_id Asset ID
	 *
	 * @return bool Success status
	 */
	public function delete_asset( $asset_id ) {
		$result = $this->database->delete_asset( $asset_id );

		if ( $result ) {
			// Clear transients
			delete_transient( 'pjjob_invest_assets_total' );
			delete_transient( 'pjjob_invest_assets_by_category' );
		}

		return $result;
	}

	/**
	 * Prepare dashboard data
	 *
	 * @return array Dashboard data
	 */
	public function get_dashboard_data() {
		$total_assets      = $this->get_total_assets();
		$categories_data   = $this->get_categories_with_totals();
		$all_assets        = $this->get_all_assets();

		$assets_by_month = $this->calculate_assets_by_month( $all_assets );

		return array(
			'total_assets'   => $total_assets,
			'categories'     => $categories_data,
			'assets_list'    => $all_assets,
			'monthly_data'   => $assets_by_month,
		);
	}

	/**
	 * Calculate total assets by month
	 *
	 * @param array $assets Assets list
	 *
	 * @return array Monthly data
	 */
	private function calculate_assets_by_month( $assets ) {
		$monthly_data = array();

		foreach ( $assets as $asset ) {
			$month = date( 'Y-m', strtotime( $asset['created_date'] ) );
			if ( ! isset( $monthly_data[ $month ] ) ) {
				$monthly_data[ $month ] = 0;
			}
			$monthly_data[ $month ] += floatval( $asset['holding_amount'] );
		}

		ksort( $monthly_data );

		return $monthly_data;
	}
}
