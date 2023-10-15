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

 }

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