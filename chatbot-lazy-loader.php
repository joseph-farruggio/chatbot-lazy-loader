<?php
/**
 * Plugin Name:     Chatbot Lazy Loader
 * Plugin URI:      
 * Description:     Eliminate the negative impact chatbots hae on your page speed
 * Author:          Joey Farruggio
 * Author URI:      https://joeyfarruggio.com
 * Text Domain:     chatbot-lazy-loader
 * Domain Path:     /languages
 * Version:         1.0
 *
 * @package         Chatbot_Lazy_Loader
 */

// Your code starts here.
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'cb_lazy_loader_attach_theme_options' );
function cb_lazy_loader_attach_theme_options() {
  Container::make( 'theme_options', __( 'Chatbot Lazy Loader' ) )
      ->add_fields( array(
      /**
       * Provider Selectoin
       */
      Field::make( 'select', 'cb_lazy_loader_chat_provider', __( 'Choose a chatbot provider' ) )
        ->set_options( array(
            'drift' => 'Drift',
            'intercom' => 'Intercom',
            'messenger' => 'Messenger',
            'indemandly' => 'Indemandly',
            'crisp' => 'Crisp'
      ) ),
      
      /**
       * Drift Key
       */
      Field::make( 'text', 'cb_lazy_loader_drift_key', 'Drift Key' )->set_required( true )->set_conditional_logic( array(
        'relation' => 'AND', // Optional, defaults to "AND"
        array(
          'field' => 'cb_lazy_loader_chat_provider',
          'value' => 'drift', // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
          'compare' => '=', // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN
        )
      )),
      
      /**
       * Intercom ID
       */
      Field::make( 'text', 'cb_lazy_loader_intercom_id', 'Intercom ID' )->set_required( true )->set_conditional_logic( array(
        'relation' => 'AND', // Optional, defaults to "AND"
        array(
          'field' => 'cb_lazy_loader_chat_provider',
          'value' => 'intercom', // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
          'compare' => '=', // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN
        )
      )),

      /**
       * Facebook instructions
       */
      Field::make( 'html', 'facebook' )
        ->set_html( '
          <h2 style="padding-left: 0;">Instructions</h2>
          <p>First you need to enable the Messenger chat plugin. From your Facebook page:</p> <ol><li>Go to Page Settings > Messaging</li><li>Click "Add Messenger to your website"</li><li>White list your domain, but don&apos;t worry about copying the JavaScript code</li></ol>
          <p>Next you need to copy your Facebook page ID. If you need help finding it, you can use this tool: <a href="https://findmyfbid.com/" target="_blank">findmyfbid.com</a>' )
        ->set_conditional_logic( array(
          'relation' => 'AND', // Optional, defaults to "AND"
          array(
            'field' => 'cb_lazy_loader_chat_provider',
            'value' => 'messenger', // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
            'compare' => '=', // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN
          )
      )),

      /**
       * Facebook Page ID
       */
      Field::make( 'text', 'cb_lazy_loader_messenger_id', 'Facebook Page ID' )->set_required( true )->set_conditional_logic( array(
        'relation' => 'AND', // Optional, defaults to "AND"
        array(
          'field' => 'cb_lazy_loader_chat_provider',
          'value' => 'messenger', // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
          'compare' => '=', // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN
        )
      )),
 
      /**
       * Indemandly instructions
       */
      Field::make( 'html', 'cb_lazy_loader_indemandly' )
        ->set_html( '
          <h2 style="padding-left: 0;">Instructions</h2>
          <p>You will need your username assigned to you by Indemandly. You can find your username on the <a href="https://indemandly.com/business" target="_blank">business page</a> of your Indemandly account.</p>' )
        ->set_conditional_logic( array(
          'relation' => 'AND', // Optional, defaults to "AND"
          array(
            'field' => 'cb_lazy_loader_chat_provider',
            'value' => 'indemandly', // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
            'compare' => '=', // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN
          )
        )
      ),

      /**
       * Indemandly User Name
       */
      Field::make( 'text', 'cb_lazy_loader_indemandly_username', 'Username' )
        ->set_required( true )
        ->set_classes( 'indemandly-username' )
        ->set_width( 50 )
        ->set_conditional_logic( array(
          'relation' => 'AND', // Optional, defaults to "AND"
          array(
            'field' => 'cb_lazy_loader_chat_provider',
            'value' => 'indemandly', // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
            'compare' => '=', // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN
          )
        )
      ),

      /**
       * Crisp Website ID
       */
      Field::make( 'text', 'cb_lazy_loader_crisp_website_id', 'Website ID' )
        ->set_required( true )
        ->set_conditional_logic( array(
          'relation' => 'AND', // Optional, defaults to "AND"
          array(
            'field' => 'cb_lazy_loader_chat_provider',
            'value' => 'crisp', // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
            'compare' => '=', // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN
          )
        )
      ),

      /**
       * Enable placeholder button
       */
      Field::make( 'checkbox', 'cb_lazy_loader_show_button', __( 'Show placholder button' ) )
        ->set_help_text( 'Show a placeholder button until the chatbot button is loaded.' )
        ->set_conditional_logic( 
          array(
            'relation' => 'AND', // Optional, defaults to "AND"
            array(
              'field' => 'cb_lazy_loader_chat_provider',
              'value' => array(
                'drift',
                'intercom',
                'indemandly',
                'crisp'
              ), // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
              'compare' => 'IN', // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN
            )
          )
      ),
      
      /**
       * Set placeholder button's color
       */
      Field::make( 'color', 'cb_lazy_loader_button_color', 'Button Color' )
        ->set_required( true )
        ->set_conditional_logic( 
        array(
          'relation' => 'AND', // Optional, defaults to "AND"
          array(
            'field' => 'cb_lazy_loader_show_button',
            'value' => true, // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
            'compare' => '=', // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN
          ),
          array(
            'field' => 'cb_lazy_loader_chat_provider',
            'value' => array(
              'drift',
              'intercom',
              'indemandly'
            ), // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
            'compare' => 'IN', // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN
          )
        )
      ),
  ) );
}

add_action( 'after_setup_theme', 'cb_lazy_loader_crb_load' );
function cb_lazy_loader_crb_load() {
  require_once( plugin_dir_path( __FILE__ ) . 'vendor/autoload.php' );
  \Carbon_Fields\Carbon_Fields::boot();
}

// Admin specific CSS to customize Carbon Field form input
function cb_lazy_loader_admin_script( $hook ) {
  wp_enqueue_style( 'custom-carbon-fields', plugin_dir_url( __FILE__ ) . 'dist/css/admin.min.css');
}
add_action( 'admin_enqueue_scripts', 'cb_lazy_loader_admin_script' );

// Drift selected
if ( get_option('_cb_lazy_loader_chat_provider') === 'drift' ) {

  // Ensure key is set
  if ( get_option('_cb_lazy_loader_drift_key') != null ) {

    // Enqueue Drift specific CSS and JS
    function cb_lazy_loader_enqueue_script() {   	
      wp_enqueue_style( 'drift-button', plugin_dir_url( __FILE__ ) . 'dist/css/drift-button.min.css');
  
      wp_enqueue_script( 'optimized_drift', plugin_dir_url( __FILE__ ) . 'dist/js/drift-init.min.js', array(), null, true);
      wp_localize_script( 'optimized_drift', 'drift_settings', array(
        'drift_key' => get_option('_cb_lazy_loader_drift_key'),
        'button_color' => get_option('_cb_lazy_loader_button_color'),
      ) );
    }
    add_action('wp_enqueue_scripts', 'cb_lazy_loader_enqueue_script');
  
    // Create placeholder button
    if (get_option('_cb_lazy_loader_show_button') === "yes") {
      function cb_lazy_loader_insert_button() {
        echo '<button onmouseenter="LoadChatWidget()" onClick="OpenChatWidget()" id="drift-button" class="drift-button"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M4.583 14.894l-3.256 3.78c-.7.813-1.26.598-1.25-.46a10689.413 10689.413 0 0 1 .035-4.775V4.816a3.89 3.89 0 0 1 3.88-3.89h12.064a3.885 3.885 0 0 1 3.882 3.89v6.185a3.89 3.89 0 0 1-3.882 3.89H4.583z" fill="#FFF" fill-rule="evenodd"></path></svg></button>';
      }
      add_action('wp_footer', 'cb_lazy_loader_insert_button');
    }
  }
}

// Intercom selected
if ( get_option('_cb_lazy_loader_chat_provider') === 'intercom' ) {
  
  // Ensure ID is set
  if ( get_option('_cb_lazy_loader_intercom_id') != null ) {

    // Enqueue Intercom specific CSS and JS
    function cb_lazy_loader_enqueue_scripts() {   	
      wp_enqueue_style( 'intercom-button', plugin_dir_url( __FILE__ ) . 'dist/css/intercom-button.min.css');
      wp_enqueue_script( 'optimized_intercom', plugin_dir_url( __FILE__ ) . 'dist/js/intercom-init.min.js', array(), null, true);
      wp_localize_script( 'optimized_intercom', 'intercom_settings', array(
        'intercom_id' => get_option('_cb_lazy_loader_intercom_id'),
        'button_color' => get_option('_cb_lazy_loader_button_color'),
      ) );
    }
    add_action('wp_enqueue_scripts', 'cb_lazy_loader_enqueue_scripts');

    // Create placeholder button
    if (get_option('_cb_lazy_loader_show_button') === "yes") {
      function cb_lazy_loader_insert_button() {
        echo '<button onmouseenter="LoadChatWidget()" id="intercom-button" class="intercom-button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 32"><path d="M28 32s-4.714-1.855-8.527-3.34H3.437C1.54 28.66 0 27.026 0 25.013V3.644C0 1.633 1.54 0 3.437 0h21.125c1.898 0 3.437 1.632 3.437 3.645v18.404H28V32zm-4.139-11.982a.88.88 0 00-1.292-.105c-.03.026-3.015 2.681-8.57 2.681-5.486 0-8.517-2.636-8.571-2.684a.88.88 0 00-1.29.107 1.01 1.01 0 00-.219.708.992.992 0 00.318.664c.142.128 3.537 3.15 9.762 3.15 6.226 0 9.621-3.022 9.763-3.15a.992.992 0 00.317-.664 1.01 1.01 0 00-.218-.707z"></path></svg></button>';
      }
      add_action('wp_footer', 'cb_lazy_loader_insert_button');
    }
  }
}

// Messenger selected
if ( get_option('_cb_lazy_loader_chat_provider') === 'messenger' ) {

  // Ensure ID is set
  if ( get_option('_cb_lazy_loader_messenger_id') != null ) {

    // Enqueue Messenger specific CSS and JS
    function cb_lazy_loader_enqueue_scripts() {  
      wp_enqueue_style( 'messenger-button', plugin_dir_url( __FILE__ ) . 'dist/css/messenger-button.min.css'); 	
      wp_enqueue_script( 'optimized_messenger', plugin_dir_url( __FILE__ ) . 'dist/js/messenger-init.min.js', array(), null, true);
    }
    add_action('wp_enqueue_scripts', 'cb_lazy_loader_enqueue_scripts');

    function cb_lazy_loader_insert_button() {
      // Create the Messenger markup
      echo "<div id='fb-root'></div>";
      echo "<div class='fb-customerchat' attribution=setup_tool page_id='". get_option('_cb_lazy_loader_messenger_id') ."'></div>";
      
      // Create the placeholder button
      if (get_option('_cb_lazy_loader_show_button') === "yes") {
        echo '<button onmouseenter="LoadChatWidget()" onClick="OpenChatWidget()" id="messenger-button" class="messenger-button"><svg width="60px" height="60px" viewBox="0 0 60 60"><svg x="0" y="0" width="60px" height="60px"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g><circle fill="#0084FF" cx="30" cy="30" r="30"></circle><svg x="10" y="10"><g transform="translate(0.000000, -10.000000)" fill="#FFFFFF"><g id="logo" transform="translate(0.000000, 10.000000)"><path d="M20,0 C31.2666,0 40,8.2528 40,19.4 C40,30.5472 31.2666,38.8 20,38.8 C17.9763,38.8 16.0348,38.5327 14.2106,38.0311 C13.856,37.9335 13.4789,37.9612 13.1424,38.1098 L9.1727,39.8621 C8.1343,40.3205 6.9621,39.5819 6.9273,38.4474 L6.8184,34.8894 C6.805,34.4513 6.6078,34.0414 6.2811,33.7492 C2.3896,30.2691 0,25.2307 0,19.4 C0,8.2528 8.7334,0 20,0 Z M7.99009,25.07344 C7.42629,25.96794 8.52579,26.97594 9.36809,26.33674 L15.67879,21.54734 C16.10569,21.22334 16.69559,21.22164 17.12429,21.54314 L21.79709,25.04774 C23.19919,26.09944 25.20039,25.73014 26.13499,24.24744 L32.00999,14.92654 C32.57369,14.03204 31.47419,13.02404 30.63189,13.66324 L24.32119,18.45264 C23.89429,18.77664 23.30439,18.77834 22.87569,18.45674 L18.20299,14.95224 C16.80079,13.90064 14.79959,14.26984 13.86509,15.75264 L7.99009,25.07344 Z"></path></g></g></svg></g></g></svg></svg></button>';
      }
    }
    add_action('wp_footer', 'cb_lazy_loader_insert_button');
  }
}

// Indemandly selected
if ( get_option('_cb_lazy_loader_chat_provider') === 'indemandly' ) {

  // Ensure the user name is set
  if ( get_option('_cb_lazy_loader_indemandly_username') != null ) {
  
    // Enqueue Indemandly specific CSS and JS
    function cb_lazy_loader_enqueue_scripts() {  
      wp_enqueue_style( 'custom-carbon-fields', plugin_dir_url( __FILE__ ) . 'dist/css/indemandly-button.min.css');
      wp_enqueue_script( 'optimized_indemandly', plugin_dir_url( __FILE__ ) . 'dist/js/indemandly-init.min.js', array(), null, true);
      wp_localize_script( 'optimized_indemandly', 'indemandly_settings', array(
        'indemandly_username' => get_option('_cb_lazy_loader_indemandly_username'),
        'button_color' => get_option('_cb_lazy_loader_button_color'),
      ) );
    }
    add_action('wp_enqueue_scripts', 'cb_lazy_loader_enqueue_scripts');
  
    // Create the placeholder button
    if (get_option('_cb_lazy_loader_show_button') === "yes") {
      function cb_lazy_loader_insert_button() {
        echo '<button onmouseenter="LoadChatWidget()" onClick="OpenChatWidget()" id="indemandly-button" class="indemandly-button"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg></button>';
      }
      add_action('wp_footer', 'cb_lazy_loader_insert_button');
    }
  }
}

// Crisp selected
if ( get_option('_cb_lazy_loader_chat_provider') === 'crisp' ) {

  // Ensure key is set
  if ( get_option('_cb_lazy_loader_crisp_website_id') != null ) {

    // Enqueue Drift specific CSS and JS
    function cb_lazy_loader_enqueue_script() {   	
      wp_enqueue_style( 'crisp-button', plugin_dir_url( __FILE__ ) . 'dist/css/crisp-button.min.css');
  
      wp_enqueue_script( 'optimized_crisp', plugin_dir_url( __FILE__ ) . 'dist/js/crisp-init.min.js', array(), null, true);
      wp_localize_script( 'optimized_crisp', 'crisp_settings', array(
        'crisp_id' => get_option('_cb_lazy_loader_crisp_website_id')
      ) );
    }
    add_action('wp_enqueue_scripts', 'cb_lazy_loader_enqueue_script');
  
    // Create placeholder button
    if (get_option('_cb_lazy_loader_show_button') === "yes") {
      function cb_lazy_loader_insert_button() {
        echo '<button onmouseenter="LoadChatWidget()" onClick="OpenChatWidget()" id="crisp-button" class="crisp-button"><span></span></button>';
      }
      add_action('wp_footer', 'cb_lazy_loader_insert_button');
    }
  }
}