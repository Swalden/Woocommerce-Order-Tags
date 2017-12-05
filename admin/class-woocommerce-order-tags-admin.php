<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       placeholder
 * @since      1.0.0
 *
 * @package    Woocommerce_Order_Tags
 * @subpackage Woocommerce_Order_Tags/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woocommerce_Order_Tags
 * @subpackage Woocommerce_Order_Tags/admin
 * @author     Spencer Walden <spencer@chocolab.com.au>
 */
class Woocommerce_Order_Tags_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woocommerce_Order_Tags_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_Order_Tags_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woocommerce-order-tags-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woocommerce_Order_Tags_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_Order_Tags_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woocommerce-order-tags-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	   * Bootstraps the class and hooks required actions & filters.
	   *
	   */
	  public static function init() {
	      add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
	      add_action( 'woocommerce_settings_tabs_settings_tab_demo', __CLASS__ . '::settings_tab' );
	      add_action( 'woocommerce_update_options_settings_tab_demo', __CLASS__ . '::update_settings' );
	  }
	  
	  
	  /**
	   * Add a new settings tab to the WooCommerce settings tabs array.
	   *
	   * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
	   * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
	   */
	  public static function add_settings_tab( $settings_tabs ) {
	      $settings_tabs['settings_tab_demo'] = __( 'Order Tags', 'woocommerce-settings-tab-demo' );
	      return $settings_tabs;
	  }
	  /**
	   * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
	   *
	   * @uses woocommerce_admin_fields()
	   * @uses self::get_settings()
	   */
	  public static function settings_tab() {
	      woocommerce_admin_fields( self::get_settings() );
	  }
	  /**
	   * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
	   *
	   * @uses woocommerce_update_options()
	   * @uses self::get_settings()
	   */
	  public static function update_settings() {
	      woocommerce_update_options( self::get_settings() );
	  }
	  /**
	   * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
	   *
	   * @return array Array of settings for @see woocommerce_admin_fields() function.
	   */
	  public static function get_settings() {
	      $settings = array(
	          'section_title' => array(
	              'name'     => __( 'Order Tags', 'woocommerce-settings-tab-demo' ),
	              'type'     => 'title',
	              'desc'     => '',
	              'id'       => 'wc_settings_tab_demo_section_title'
	          ),
	          'name' => array(
	              'name' => __( 'Name', 'woocommerce-settings-tab-demo' ),
	              'type' => 'text',
	              'desc' => __( 'Name for your custom order status', 'woocommerce-settings-tab-demo' ),
	              'id'   => 'wc_settings_tab_demo_title'
	          ),
	          'slug' => array(
	              'name' => __( 'Slug', 'woocommerce-settings-tab-demo' ),
	              'type' => 'text',
	              'desc' => __( 'Slug for your custom order status', 'woocommerce-settings-tab-demo' ),
	              'id'   => 'wc_settings_tab_demo_title'
	          ),
	          'description' => array(
	              'name' => __( 'Description', 'woocommerce-settings-tab-demo' ),
	              'type' => 'textarea',
	              'desc' => __( 'This is a paragraph describing the setting. Lorem ipsum yadda yadda yadda. Lorem ipsum yadda yadda yadda. Lorem ipsum yadda yadda yadda. Lorem ipsum yadda yadda yadda.', 'woocommerce-settings-tab-demo' ),
	              'id'   => 'wc_settings_tab_demo_description'
	          ),
	          'section_end' => array(
	               'type' => 'sectionend',
	               'id' => 'wc_settings_tab_demo_section_end'
	          )
	      );
	      return apply_filters( 'wc_settings_tab_demo_settings', $settings );
	  }

}

Woocommerce_Order_Tags_Admin::init();
