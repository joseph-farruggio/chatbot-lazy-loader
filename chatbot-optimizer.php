<?php
/**
 * Plugin Name:     Chatbot Optimizer
 * Plugin URI:      https://joeyfarruggio.com
 * Description:     Eliminate the impact of chatbots on your page speed
 * Author:          Joey Farruggio
 * Author URI:      https://joeyfarruggio.com
 * Text Domain:     chatbot-optimizer
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Chatbot_Optimizer
 */

// Your code starts here.
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
function crb_attach_theme_options() {
  Container::make( 'theme_options', __( 'Drift Settings' ) )
      ->add_fields( array(
          Field::make( 'select', 'chat_provider', __( 'Choose a chat provider' ) )
            ->set_options( array(
                'drift' => 'Drift',
                'intercom' => 'Intercom',
            ) ),
          
          Field::make( 'text', 'drift_key', 'Drift Key' )->set_required( true )->set_conditional_logic( array(
            'relation' => 'AND', // Optional, defaults to "AND"
            array(
              'field' => 'chat_provider',
              'value' => 'drift', // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
              'compare' => '=', // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN
            )
          )),

          Field::make( 'text', 'intercom_id', 'Intercom ID' )->set_required( true )->set_conditional_logic( array(
            'relation' => 'AND', // Optional, defaults to "AND"
            array(
              'field' => 'chat_provider',
              'value' => 'intercom', // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
              'compare' => '=', // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN
            )
          )),

          Field::make( 'color', 'chat_button_color', 'Button Color' )->set_required( true )->set_conditional_logic( array(
            'relation' => 'OR', // Optional, defaults to "AND"
            array(
              'field' => 'chat_provider',
              'value' => 'drift', // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
              'compare' => '=', // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN
            ),
            array(
              'field' => 'chat_provider',
              'value' => 'intercom', // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
              'compare' => '=', // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN
            )
          )),
      ) );
}

add_action( 'after_setup_theme', 'crb_load' );
function crb_load() {
    require_once( plugin_dir_path( __FILE__ ) . 'vendor/autoload.php' );
    \Carbon_Fields\Carbon_Fields::boot();
}

// Drift selected
if ( get_option('_chat_provider') === 'drift' ) {

  if ( get_option('_drift_key') != null ) {
    function optimize_drift_enqueue_script() {   	
      wp_enqueue_style( 'drift-button', plugin_dir_url( __FILE__ ) . 'dist/css/drift-button.min.css');
  
      wp_enqueue_script( 'optimized_drift', plugin_dir_url( __FILE__ ) . 'dist/js/drift-init.min.js', array(), null, true);
      wp_localize_script( 'optimized_drift', 'drift_settings', array(
        'drift_key' => get_option('_drift_key'),
        'button_color' => get_option('_chat_button_color'),
      ) );
    }
    add_action('wp_enqueue_scripts', 'optimize_drift_enqueue_script');
  }
  
  function insert_my_footer() {
    echo '<button onmouseenter="LoadChatWidget()" onClick="openChatWidget()" id="drift-init" class="drift-init"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M4.583 14.894l-3.256 3.78c-.7.813-1.26.598-1.25-.46a10689.413 10689.413 0 0 1 .035-4.775V4.816a3.89 3.89 0 0 1 3.88-3.89h12.064a3.885 3.885 0 0 1 3.882 3.89v6.185a3.89 3.89 0 0 1-3.882 3.89H4.583z" fill="#FFF" fill-rule="evenodd"></path></svg></button>';
  }
  add_action('wp_footer', 'insert_my_footer');

}


// Intercom selected
if ( get_option('_chat_provider') === 'intercom' ) {
  if ( get_option('_intercom_id') != null ) {
    function optimize_intercom_enqueue_script() {   	
      wp_enqueue_style( 'intercom-button', plugin_dir_url( __FILE__ ) . 'dist/css/intercom-button.min.css');
      wp_enqueue_script( 'optimized_intercom', plugin_dir_url( __FILE__ ) . 'dist/js/intercom-init.min.js', array(), null, true);
      wp_localize_script( 'optimized_intercom', 'intercom_settings', array(
        'intercom_id' => get_option('_intercom_id'),
        'button_color' => get_option('_chat_button_color'),
      ) );
    }
    add_action('wp_enqueue_scripts', 'optimize_intercom_enqueue_script');

    function insert_my_footer() {
      echo '<button onmouseenter="LoadChatWidget()" id="intercom-button" class="intercom-button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 32"><path d="M28 32s-4.714-1.855-8.527-3.34H3.437C1.54 28.66 0 27.026 0 25.013V3.644C0 1.633 1.54 0 3.437 0h21.125c1.898 0 3.437 1.632 3.437 3.645v18.404H28V32zm-4.139-11.982a.88.88 0 00-1.292-.105c-.03.026-3.015 2.681-8.57 2.681-5.486 0-8.517-2.636-8.571-2.684a.88.88 0 00-1.29.107 1.01 1.01 0 00-.219.708.992.992 0 00.318.664c.142.128 3.537 3.15 9.762 3.15 6.226 0 9.621-3.022 9.763-3.15a.992.992 0 00.317-.664 1.01 1.01 0 00-.218-.707z"></path></svg></button>';
    }
    add_action('wp_footer', 'insert_my_footer');
  }
}