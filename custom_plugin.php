<?php
/**
 * Plugin Name: Custom Plugin
 * Plugin URI: N/A
 * Description: Designed to create a new settings page for word counts as well as self updating when making changes.
 * Version: 1.0
 * Author: Ryan Henry
 */

 class WordCountAndTimePlugin {
    // this function will be the base for pushing content onto the page
    function __construct() {
        add_action('admin_menu', array($this, 'adminPage'));
        add_action('admin_init', array($this, 'settings'));
    }
 }

 // This function is responsible for adding custom setting to database
 function settings() {
   add_settings_field('wcp_location', 'Display Location', array($this, 'locationHTML'), 'word-count-settings-page', 'wcp_first_section', array('theName' => 'wcp_location')); // create 5 arguments
   register_setting('wordcountplugin', 'wcp_location', array('sanitize_callback' => array($this, 'sanitizeLocation'), 'default' => '0'));
 }

 function locationHTML() { ?>
   <select name="wcp_location">
     <option value="0"<?php selected(get_option('wcp_location'), '0') ?>>Beginning of post</option>
     <option value="1"<?php selected(get_option('wcp_location'), '1') ?>>End of post</option>
   </select>
 <?php }

 function adminPage() { // first argument is for title of page, second is name of settings,
    add_options_page('Word Count Settings', 'Word Count', 'manage options', 'word-count-settings-page', array($this, pluginHTML));
 }

 function pluginHTML() { ?>
    <div name="wrap">
      <h1>Word Count Settings</h1>
    </div>
 <?php }
 
 // to create a new instance of class above
 $WordCountAndTimePlugin = new WordCountAndTimePlugin();

 add_filter( 'auto_update_plugin', '__return_true' );