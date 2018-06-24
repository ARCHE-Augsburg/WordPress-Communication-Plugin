<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 * @author     Your Name <email@example.com>
 */
class aacp_Core {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Plugin_Name_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.3';
		}
		$this->plugin_name = 'ARCHE-Augsburg-Communication-Plugin';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Plugin_Name_Loader. Orchestrates the hooks of the plugin.
	 * - Plugin_Name_i18n. Defines internationalization functionality.
	 * - Plugin_Name_Admin. Defines all hooks for the admin area.
	 * - Plugin_Name_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-aacp-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-aacp-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-aacp-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-aacp-public.php';
		
		/**
		 * The class responsible for the backend ui of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-aacp-backend.php';
		
		/**
		 * The class responsible for the cron job stuff.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-aacp-cronjobmanager.php';

		/**
		 * The class responsible for configuration.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-aacp-configuration.php';
		
		/**
		 * The file holding constants.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/constants.php';

		/**
		 * The class responsible for managing file exports.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'lib/exports/class-aacp-file-export-manager.php';

		/**
		 * The class responsible for actual rendering the file.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'lib/exports/class-aacp-file-renderer.php';
		
		/**
		 * The class responsible for ical synchronization.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'lib/ical/aacp-ical-syncronizer.php';
		
		/**
		 * The class responsible for mailchimp integration.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'lib/mailchimp/aacp-class-mailchimpintegration.php';
		
		/**
		 * The class responsible for sermon file validation.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'lib/podcast/aacp-file-validator.php';

		$this->loader = new aacp_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Plugin_Name_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new aacp_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new aacp_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new aacp_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		// Admin menu
		$backend = new aacp_Backend();
		$this->loader->add_action( 'admin_menu', $backend, 'get_aacp_backend' );
		
		// Ical synchronization
		$ical_synchronizer = new aacp_IcalSynchronizer();
		$this->loader->add_action( 'wp_ajax_icalsync', $ical_synchronizer, 'synchronize_calendar' );
		
		// File exports
		$file_export_manager = new aacp_FileExportManager();
		$this->loader->add_action( 'wp_ajax_newsletterexport', $file_export_manager, 'export_print_newsletter' );
		$this->loader->add_action( 'service_presentation_export_job', $file_export_manager, 'export_service_presentation' );
		
		// Podcast file validation
		$file_validator = new aacp_FileValidator();
		
		// Mailchimp integration
		$mailchimp_integration = new aacp_MailchimpIntegration();
		$this->loader->add_action( 'publish_events', $mailchimp_integration, 'upload_image_to_mailchimp' );
		
		// Development configuration
		//$configuration = new aacp_Configuration();
		//$this->loader->add_filter( 'cron_schedules', $configuration, 'cron_add_every_minute_interval' );
		//$this->loader->add_filter( 'cron_request', $configuration, 'http_basic_cron_request' );
		
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Plugin_Name_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
