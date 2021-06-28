<?php
/**
 * Core: Plugin Bootstrap
 *
 * @package     AffiliateWP Affiliate Info
 * @subpackage  Core
 * @copyright   Copyright (c) 2021, Sandhills Development, LLC
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'AffiliateWP_Affiliate_Info' ) ) {

	/**
	 * Main plugin bootstrap class.
	 *
	 * @since 1.0
	 */
	final class AffiliateWP_Affiliate_Info {

		/**
		 * Holds the instance
		 *
		 * Ensures that only one instance of AffiliateWP_Affiliate_Info exists in memory at any one
		 * time and it also prevents needing to define globals all over the place.
		 *
		 * TL;DR This is a static property property that holds the singleton instance.
		 *
		 * @since 1.0
		 * @var   \AffiliateWP_Affiliate_Info
		 * @static
		 */
		private static $instance;

		/**
		 * Plugin loader file.
		 *
		 * @since 1.1
		 * @var   string
		 */
		private $file = '';

		/**
		 * The version number of AffiliateWP
		 *
		 * @since 1.0
		 */
		private $version = '1.0.5';

		/**
		 * Functions
		 *
		 * @since 1.0
		 */
		public $functions;

		/**
		 * Main AffiliateWP_Affiliate_Info Instance
		 *
		 * Insures that only one instance of AffiliateWP_Affiliate_Info exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @since 1.0
		 * @static
		 *
		 * @param string $file Path to the main plugin file.
		 * @return \AffiliateWP_Affiliate_Info The one true bootstrap instance.
		 */
		public static function instance( $file = '' ) {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof AffiliateWP_Affiliate_Info ) ) {

				self::$instance = new AffiliateWP_Affiliate_Info;
				self::$instance->file = $file;

				self::$instance->setup_constants();
				self::$instance->includes();
				self::$instance->hooks();

				self::$instance->functions 	= new AffiliateWP_Affiliate_Info_Functions;

			}

			return self::$instance;
		}

		/**
		 * Throw error on object clone
		 *
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 *
		 * @since 1.0
		 * @access protected
		 * @return void
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'affiliatewp-affiliate-info' ), '1.0' );
		}

		/**
		 * Disable unserializing of the class
		 *
		 * @since 1.0
		 * @access protected
		 * @return void
		 */
		public function __wakeup() {
			// Unserializing instances of the class is forbidden
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'affiliatewp-affiliate-info' ), '1.0' );
		}

		/**
		 * Constructor Function
		 *
		 * @since 1.0
		 * @access private
		 */
		private function __construct() {
			self::$instance = $this;
		}

		/**
		 * Reset the instance of the class
		 *
		 * @since 1.0
		 * @access public
		 * @static
		 */
		public static function reset() {
			self::$instance = null;
		}

		/**
		 * Setup plugin constants
		 *
		 * @access private
		 * @since 1.0
		 * @return void
		 */
		private function setup_constants() {
			// Plugin version
			if ( ! defined( 'AFFWP_AFFILIATE_INFO_VERSION' ) ) {
				define( 'AFFWP_AFFILIATE_INFO_VERSION', $this->version );
			}

			// Plugin Folder Path
			if ( ! defined( 'AFFWP_AFFILIATE_INFO_PLUGIN_DIR' ) ) {
				define( 'AFFWP_AFFILIATE_INFO_PLUGIN_DIR', plugin_dir_path( $this->file ) );
			}

			// Plugin Folder URL
			if ( ! defined( 'AFFWP_AFFILIATE_INFO_PLUGIN_URL' ) ) {
				define( 'AFFWP_AFFILIATE_INFO_PLUGIN_URL', plugin_dir_url( $this->file ) );
			}

			// Plugin Root File
			if ( ! defined( 'AFFWP_AFFILIATE_INFO_PLUGIN_FILE' ) ) {
				define( 'AFFWP_AFFILIATE_INFO_PLUGIN_FILE', $this->file );
			}
		}

		/**
		 * Include necessary files
		 *
		 * @access      private
		 * @since       1.0.0
		 * @return      void
		 */
		private function includes() {
			require_once AFFWP_AFFILIATE_INFO_PLUGIN_DIR . 'includes/class-shortcodes.php';
			require_once AFFWP_AFFILIATE_INFO_PLUGIN_DIR . 'includes/class-functions.php';
		}

		/**
		 * Setup the default hooks and actions
		 *
		 * @since 1.0
		 *
		 * @return void
		 */
		private function hooks() {
			// plugin meta
			add_filter( 'plugin_row_meta', array( $this, 'plugin_meta' ), null, 2 );
		}

		/**
		 * Modify plugin metalinks
		 *
		 * @access      public
		 * @since       1.0.0
		 * @param       array $links The current links array
		 * @param       string $file A specific plugin table entry
		 * @return      array $links The modified links array
		 */
		public function plugin_meta( $links, $file ) {
		    if ( $file == plugin_basename( $this->file ) ) {
		        $plugins_link = array(
		            '<a title="' . __( 'Get more add-ons for AffiliateWP', 'affiliatewp-affiliate-info' ) . '" href="https://affiliatewp.com/addons/" target="_blank">' . __( 'More add-ons', 'affiliatewp-affiliate-info' ) . '</a>'
		        );

		        $links = array_merge( $links, $plugins_link );
		    }

		    return $links;
		}

	}

	/**
	 * The main function responsible for returning the one true AffiliateWP_Affiliate_Info
	 * Instance to functions everywhere.
	 *
	 * Use this function like you would a global variable, except without needing
	 * to declare the global.
	 *
	 * Example: <?php $affwp_affiliate_info = affiliatewp_affiliate_info(); ?>
	 *
	 * @since 1.0.0
	 * @return object The one true AffiliateWP_Affiliate_Info Instance
	 */
	function affiliatewp_affiliate_info() {
        return AffiliateWP_Affiliate_Info::instance();
	}

}
