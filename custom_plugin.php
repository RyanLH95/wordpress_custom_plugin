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
        add_action('admin_menu', array($this, 'admin_page'));
    }
 }

 function adminPage() {
    add_options_page('Word Count Settings', 'Word Count', 'manage options', 'word-count-settings-page', 5);
 }

 add_filter( 'auto_update_plugin', '__return_true' );