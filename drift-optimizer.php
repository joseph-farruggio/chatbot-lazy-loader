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
          Field::make( 'select', 'drift_method', __( 'Drift load options' ) )
            ->set_options( array(
                'delay' => 'Load after 5 seconds',
                'scroll' => 'Load after scroll'
            ) )
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