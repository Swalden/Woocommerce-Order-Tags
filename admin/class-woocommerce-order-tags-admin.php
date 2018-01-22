<?php

/**
 * The admin-specific functionality of the plugin.
 */

// Debug helper to be removed later
function print_c( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

class Woocommerce_Order_Tags_Admin {

	private $plugin_name;
	private $version;

	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woocommerce-order-tags-admin.css', array(), $this->version, 'all' );
	}

	public function enqueue_scripts() {		
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woocommerce-order-tags-admin.js', array( 'jquery' ), $this->version, false );
	}

	public function add_plugin_admin_menu() {
		add_options_page( 'Woocommerce Tags', 'Woocommerce Tags', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
    	);
	}

	public function add_action_links( $links ) {
	    /*
	    *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
	    */
	   $settings_link = array(
	    '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
	   );
	   return array_merge(  $settings_link, $links );

	}

	public function woocommerce_tags_settings_init(  ) { 
		register_setting( 'pluginPage', 'woocommerce_tags_settings' );
	}



	public function woocommerce_tags_bulk_menu( $bulk_actions ) {
		$options = get_option( 'woocommerce_tags_settings' );
		if(!empty($options) && $options[0][0]['name'] !== "") {

			foreach($options as $option) {
				foreach($option as $o) {
					$bulk_actions[$o['name']] = __( "Tag ".$o['name'], 'wordpress' );
				}
				foreach($option as $o) {
					$bulk_actions["Remove Tag " . $o['name']] = __( "Remove Tag ".$o['name'], 'wordpress' );
				}
			}
		}
		
		return $bulk_actions;
	}

	public function woocommerce_tags_bulk_action_handler( $redirect_to, $action, $post_ids ) {
		foreach( $post_ids as $post_id ) {
			print_c($action);
			if(strpos($action, 'Remove Tag') !== false) {
				$current_meta = implode(get_post_meta($post_id, 'woocommerce_tag_key'));
				if(strpos($action, $current_meta) !== false) {
					delete_post_meta($post_id, 'woocommerce_tag_key');
				}
			}
			elseif( ! add_post_meta($post_id, 'woocommerce_tag_key', $action, true)) {
				update_post_meta($post_id, 'woocommerce_tag_key', $action);
			}
		}
		return $redirect_to;
	}

	public function woocommerce_tags_order_column( $columns ) {
		$action_column = $columns['order_actions'];
		unset($columns['order_actions']);
		$columns['order_tags'] = '<span>'.__( 'Tag','woocommerce').'</span>';
		$columns['order_actions'] = $action_column;
		return $columns;
	}

	public function woocommerce_tags_list_column_content( $column, $post_id )
	{

	    $tag = get_post_meta( $post_id, 'woocommerce_tag_key', true );
	    if( empty($tag)) $tag = '';
	    switch ( $column )
	    {
	        case 'order_tags' :
	            echo '<span>'.$tag.'</span>'; // display the data
	            break;
	    }
	}

	public function woocommerce_tags_column_sort( $columns ) {
		$custom = array(
			'order_tags'    => 'woocommerce_tag_key'
		);
		return wp_parse_args( $custom, $columns );
	}

	public function woocommerce_tags_platform_search_fields( $meta_keys ){
	    $meta_keys[] = 'woocommerce_tag_key';
	    return $meta_keys;
	}

	public function woocommerce_tags_order_filters( $post_type ) {

		$options = get_option( 'woocommerce_tags_settings' );
		// add is set to get filter to work then launch plugin?
	
		  // Check this is the products screen
		  if( $post_type == 'shop_order' ) {

		    // Add your filter input here. Make sure the input name matches the $_GET value you are checking above.
		    echo '<select name="tags_filter">';

		    echo '<option value>Filter Tags</option>';
		    foreach($options as $option) {
		    	foreach($option as $o) {
			    echo '<option value="' . $o['slug'] . '">' . $o['name'] . '</option>';
			}
		  	}

		    echo '</select>';

		  }

		
	}



	public function woocommerce_tags_apply_order_filters( $query ) {
		global $pagenow;

		// Ensure it is an edit.php admin page, the filter exists and has a value, and that it's the products page
		if ( $query->is_admin && $pagenow == 'edit.php' && isset( $_GET['my_filter'] ) && $_GET['my_filter'] != '' && $_GET['post_type'] == 'shop_order' ) {

		  // Create meta query array and add to WP_Query
		  $meta_key_query = array(
		    array(
		      'key'     => 'woocommerce_tag_key',
		      'value'   => esc_attr( $_GET['tags_filter'] ),
		    )
		  );
		  $query->set( 'meta_query', $meta_key_query );

		}
	}

	
	public function display_plugin_setup_page() {
		add_settings_section(
			'woocommerce_tags_pluginPage_section',        
			__( 'Your section description', 'wordpress' ), 
			'woocommerce_tags_settings_section_callback', 
			'pluginPage'
		);

		add_settings_field( 
			'woocommerce_tags_fields', 
			__( 'Settings field description', 'wordpress' ), 
			'woocommerce_tags_field_render', 
			'pluginPage', 
			'woocommerce_tags_pluginPage_section' 
		);



		function woocommerce_tags_field_render(  ) { 

			include 'partials/woocommerce-order-tags-admin-display.php';

		};


		


		function woocommerce_tags_settings_section_callback(  ) { 

			echo __( 'This section description', 'wordpress' );

		}
    	?>
    		<form action='options.php' method='post' id="wooTagsOptions">

    			<h2>Woocommerce Tags</h2>

    			<?php
    			settings_fields( 'pluginPage' );
    			do_settings_sections( 'pluginPage' );
    			submit_button();
    			?>

    		</form>
    		<?php

	}

}




