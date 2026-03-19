<?php
/**
 * Plugin Name: PJJob Invest
 * Plugin URI: https://example.com/pjjob-invest
 * Description: A WordPress plugin to manage and track your investment assets with visual analytics
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: pjjob-invest
 * Domain Path: /languages
 *
 * @package PJJob_Invest
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define plugin constants
define( 'PJJOB_INVEST_VERSION', '1.0.0' );
define( 'PJJOB_INVEST_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PJJOB_INVEST_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'PJJOB_INVEST_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

/**
 * PJJob Invest Plugin Main Class
 */
class PJJob_Invest {
	/**
	 * Instance variable
	 *
	 * @var PJJob_Invest|null
	 */
	private static $instance = null;

	/**
	 * Get instance
	 *
	 * @return PJJob_Invest
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->init_hooks();
	}

	/**
	 * Initialize hooks
	 *
	 * @return void
	 */
	private function init_hooks() {
		// Activation hook
		register_activation_hook( __FILE__, array( $this, 'activate' ) );

		// Deactivation hook
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

		// Load text domain for translations
		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );

		// Load plugin files
		add_action( 'plugins_loaded', array( $this, 'load_plugin_files' ) );

		// Admin init
		add_action( 'admin_init', array( $this, 'admin_init' ) );

		// Admin menu
		add_action( 'admin_menu', array( $this, 'register_admin_menu' ) );

		// Front-end init
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_assets' ) );

		// Register shortcodes
		add_action( 'init', array( $this, 'register_shortcodes' ) );

		// Register AJAX handlers
		add_action( 'wp_ajax_pjjob_invest_add_asset', array( $this, 'handle_add_asset' ) );
		add_action( 'wp_ajax_nopriv_pjjob_invest_add_asset', array( $this, 'handle_add_asset' ) );
	}

	/**
	 * Plugin activation
	 *
	 * @return void
	 */
	public function activate() {
		require_once PJJOB_INVEST_PLUGIN_DIR . 'includes/class-activator.php';
		PJJob_Invest_Activator::activate();
	}

	/**
	 * Plugin deactivation
	 *
	 * @return void
	 */
	public function deactivate() {
		require_once PJJOB_INVEST_PLUGIN_DIR . 'includes/class-deactivator.php';
		PJJob_Invest_Deactivator::deactivate();
	}

	/**
	 * Load plugin text domain
	 *
	 * @return void
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'pjjob-invest',
			false,
			dirname( PJJOB_INVEST_PLUGIN_BASENAME ) . '/languages/'
		);
	}

	/**
	 * Load required plugin files
	 *
	 * @return void
	 */
	public function load_plugin_files() {
		// Load database class
		require_once PJJOB_INVEST_PLUGIN_DIR . 'includes/class-database.php';

		// Load assets manager class
		require_once PJJOB_INVEST_PLUGIN_DIR . 'includes/class-assets-manager.php';

		// Load shortcode class
		require_once PJJOB_INVEST_PLUGIN_DIR . 'includes/class-shortcode.php';

		// Load admin pages
		if ( is_admin() ) {
			require_once PJJOB_INVEST_PLUGIN_DIR . 'admin/class-admin-pages.php';
		}
	}

	/**
	 * Admin init
	 *
	 * @return void
	 */
	public function admin_init() {
		wp_register_script(
			'pjjob-invest-admin-js',
			PJJOB_INVEST_PLUGIN_URL . 'admin/js/admin.js',
			array( 'jquery' ),
			PJJOB_INVEST_VERSION,
			true
		);

		wp_register_style(
			'pjjob-invest-admin-css',
			PJJOB_INVEST_PLUGIN_URL . 'admin/css/admin.css',
			array(),
			PJJOB_INVEST_VERSION
		);
	}

	/**
	 * Register admin menu
	 *
	 * @return void
	 */
	public function register_admin_menu() {
		add_menu_page(
			__( 'PJJob Invest', 'pjjob-invest' ),
			__( 'Invest', 'pjjob-invest' ),
			'manage_options',
			'pjjob-invest',
			array( 'PJJob_Invest_Admin_Pages', 'display_dashboard' ),
			'dashicons-chart-line',
			25
		);

		add_submenu_page(
			'pjjob-invest',
			__( 'Dashboard', 'pjjob-invest' ),
			__( 'Dashboard', 'pjjob-invest' ),
			'manage_options',
			'pjjob-invest',
			array( 'PJJob_Invest_Admin_Pages', 'display_dashboard' )
		);

		add_submenu_page(
			'pjjob-invest',
			__( 'Add Asset', 'pjjob-invest' ),
			__( 'Add Asset', 'pjjob-invest' ),
			'manage_options',
			'pjjob-invest-add',
			array( 'PJJob_Invest_Admin_Pages', 'display_add_asset' )
		);
	}

	/**
	 * Enqueue public assets
	 *
	 * @return void
	 */
	public function enqueue_public_assets() {
		wp_register_style(
			'pjjob-invest-public-css',
			PJJOB_INVEST_PLUGIN_URL . 'public/css/public.css',
			array(),
			PJJOB_INVEST_VERSION
		);

		wp_register_script(
			'chart-js',
			'https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js',
			array(),
			'3.9.1',
			true
		);

		wp_register_script(
			'pjjob-invest-public-js',
			PJJOB_INVEST_PLUGIN_URL . 'public/js/public.js',
			array( 'jquery' ),
			PJJOB_INVEST_VERSION,
			true
		);
	}

	/**
	 * Register shortcodes
	 *
	 * @return void
	 */
	public function register_shortcodes() {
		add_shortcode( 'pjjob_invest_dashboard', array( 'PJJob_Invest_Shortcode', 'render_dashboard' ) );
		add_shortcode( 'pjjob_invest_form', array( 'PJJob_Invest_Shortcode', 'render_form' ) );
	}

	/**
	 * Handle add asset AJAX request
	 *
	 * @return void
	 */
	public function handle_add_asset() {
		check_ajax_referer( 'pjjob_invest_nonce', 'nonce' );

		if ( ! isset( $_POST['asset_name'], $_POST['holding_amount'], $_POST['category'], $_POST['created_date'] ) ) {
			wp_send_json_error( array( 'message' => __( 'Missing required fields', 'pjjob-invest' ) ) );
		}

		$asset_name     = sanitize_text_field( $_POST['asset_name'] );
		$holding_amount = floatval( $_POST['holding_amount'] );
		$category       = sanitize_text_field( $_POST['category'] );
		$created_date   = sanitize_text_field( $_POST['created_date'] );

		$assets_manager = new PJJob_Invest_Assets_Manager();
		$result         = $assets_manager->add_asset( $asset_name, $holding_amount, $category, $created_date );

		if ( $result ) {
			wp_send_json_success( array( 'message' => __( 'Asset added successfully', 'pjjob-invest' ) ) );
		} else {
			wp_send_json_error( array( 'message' => __( 'Failed to add asset', 'pjjob-invest' ) ) );
		}
	}
}

// Initialize the plugin
function pjjob_invest_init() {
	PJJob_Invest::get_instance();
}
add_action( 'plugins_loaded', 'pjjob_invest_init' );
