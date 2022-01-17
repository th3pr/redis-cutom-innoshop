<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'Redis_Product_Cache' ) ) :

	/**
	 * Main Redis_Product_Cache Class.
	 *
	 * @package		REDISPRODU
	 * @subpackage	Classes/Redis_Product_Cache
	 * @since		1.0.0
	 * @author		Mohamed Ahmed Bahnsawy
	 */
	final class Redis_Product_Cache {

		/**
		 * The real instance
		 *
		 * @access	private
		 * @since	1.0.0
		 * @var		object|Redis_Product_Cache
		 */
		private static $instance;

		/**
		 * REDISPRODU helpers object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Redis_Product_Cache_Helpers
		 */
		public $helpers;

		/**
		 * REDISPRODU settings object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Redis_Product_Cache_Settings
		 */
		public $settings;

		/**
		 * Throw error on object clone.
		 *
		 * Cloning instances of the class is forbidden.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to clone this class.', 'redis-product-cache' ), '1.0.0' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to unserialize this class.', 'redis-product-cache' ), '1.0.0' );
		}

		/**
		 * Main Redis_Product_Cache Instance.
		 *
		 * Insures that only one instance of Redis_Product_Cache exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @access		public
		 * @since		1.0.0
		 * @static
		 * @return		object|Redis_Product_Cache	The one true Redis_Product_Cache
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Redis_Product_Cache ) ) {
				self::$instance					= new Redis_Product_Cache;
				self::$instance->base_hooks();
				self::$instance->includes();
				self::$instance->helpers		= new Redis_Product_Cache_Helpers();
				self::$instance->settings		= new Redis_Product_Cache_Settings();

				//Fire the plugin logic
				new Redis_Product_Cache_Run();

				/**
				 * Fire a custom action to allow dependencies
				 * after the successful plugin setup
				 */
				do_action( 'REDISPRODU/plugin_loaded' );
			}

			return self::$instance;
		}

		/**
		 * Include required files.
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function includes() {
			require_once REDISPRODU_PLUGIN_DIR . 'core/includes/classes/class-redis-product-cache-helpers.php';
			require_once REDISPRODU_PLUGIN_DIR . 'core/includes/classes/class-redis-product-cache-settings.php';

			require_once REDISPRODU_PLUGIN_DIR . 'core/includes/classes/class-redis-product-cache-run.php';
		}

		/**
		 * Add base hooks for the core functionality
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function base_hooks() {
			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @access  public
		 * @since   1.0.0
		 * @return  void
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'redis-product-cache', FALSE, dirname( plugin_basename( REDISPRODU_PLUGIN_FILE ) ) . '/languages/' );
		}

	}

endif; // End if class_exists check.