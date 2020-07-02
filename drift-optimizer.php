<?php
/**
 * Plugin Name:     Drift Optimizer
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     drift-optimizer
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Drift_Optimizer
 */

// Your code starts here.
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
function crb_attach_theme_options() {
  Container::make( 'theme_options', __( 'Drift Settings' ) )
      ->add_fields( array(
          Field::make( 'text', 'drift_key', 'Drift Key' ),
          // Field::make( 'select', 'drift_method', __( 'Drift load options' ) )
          //   ->set_options( array(
          //       'delay' => 'Load after 5 seconds',
          //       'scroll' => 'Load after scroll',
          //       'dummy' => 'Load after user clicks on Drift icon'
          //   ) ),
          // Field::make( 'color', 'drift_button_color', 'Button Color' )
          //   ->set_conditional_logic( array(
          //       'relation' => 'AND', // Optional, defaults to "AND"
          //       array(
          //           'field' => 'drift_method',
          //           'value' => 'dummy', // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
          //           'compare' => '=', // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN
          //       )
          // ) ),
          Field::make( 'color', 'drift_button_color', 'Button Color' )
      ) );
}

add_action( 'after_setup_theme', 'crb_load' );
function crb_load() {
    require_once( plugin_dir_path( __FILE__ ) . 'vendor/autoload.php' );
    \Carbon_Fields\Carbon_Fields::boot();
}

if ( get_option('_drift_key') != null ) {
	function optimize_drift_enqueue_script() {   	
		wp_enqueue_script( 'optimized_drift', plugin_dir_url( __FILE__ ) . 'dist/js/drift-init.min.js', array(), null, true);
		wp_localize_script( 'optimized_drift', 'drift_settings', array(
			'drift_key' => get_option('_drift_key'),
			'drift_method' => get_option('_drift_method'),
		) );
	}
  add_action('wp_enqueue_scripts', 'optimize_drift_enqueue_script');
}

function optimize_drift_enqueue_style() {   	
  wp_enqueue_style( 'drift-button', plugin_dir_url( __FILE__ ) . 'dist/css/drift-button.min.css');
  
  wp_localize_script( 'optimized_drift', 'drift_button_settings', array(
    'drift_color' => get_option('_drift_button_color'),
  ) );
}
add_action('wp_enqueue_scripts', 'optimize_drift_enqueue_style');

function insert_my_footer() {
  echo '<button onmouseenter="LoadDriftWidget()" onClick="openDriftWidget()" id="drift-init" class="drift-init"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M4.583 14.894l-3.256 3.78c-.7.813-1.26.598-1.25-.46a10689.413 10689.413 0 0 1 .035-4.775V4.816a3.89 3.89 0 0 1 3.88-3.89h12.064a3.885 3.885 0 0 1 3.882 3.89v6.185a3.89 3.89 0 0 1-3.882 3.89H4.583z" fill="#FFF" fill-rule="evenodd"></path></svg></button>';
}

add_action('wp_footer', 'insert_my_footer');