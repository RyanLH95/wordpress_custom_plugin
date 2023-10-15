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
        add_filter('the_content', array($this, 'ifWrap'));
    }

    function ifWrap($content) {
      if (is_main_query() AND is_single() AND 
        (
          get_option('wcp_wordcount', '1') OR 
          get_option('wcp_charactercount', '1') OR 
          get_option('wcp_readtime', '1')
        )) {
          // if condition is met
          return $this->createHTML($content); // Or you can use '
      } // if condition is not met
      return $content;
    }

 // This function is responsible for adding custom setting to database
    function settings() {
      add_settings_section('wcp_first_section', null, null, 'word-count-settings-page');

      add_settings_field('wcp_location', 'Display Location', array($this, 'locationHTML'), 'word-count-settings-page', 'wcp_first_section', array('theName' => 'wcp_location')); // create 5 arguments
      register_setting('wordcountplugin', 'wcp_location', array('sanitize_callback' => array($this, 'sanitizeLocation'), 'default' => '0'));
      
      add_settings_field('wcp_headline', 'Headline Text', array($this, 'headlineHTML'), 'word-count-settings-page', 'wcp_first_section', array('theName' => 'wcp_headline')); // create 5 arguments
      register_setting('wordcountplugin', 'wcp_headline', array('sanitize_callback' => 'sanitize_text_field', 'default' => 'Post Statistics'));

      add_settings_field('wcp_wordcount', 'Word Count', array($this, 'wordcountHTML'), 'word-count-settings-page', 'wcp_first_section', array('theName' => 'wcp_wordcount')); // create 5 arguments
      register_setting('wordcountplugin', 'wcp_headline', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));

      add_settings_field('wcp_charactercount', 'Character Count', array($this, 'charactercountHTML'), 'word-count-settings-page', 'wcp_first_section', array('theName' => 'wcp_charactercount')); // create 5 arguments
      register_setting('wordcountplugin', 'wcp_charactercount', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));

      add_settings_field('wcp_readtime', 'Read Time', array($this, 'readtimeHTML'), 'word-count-settings-page', 'wcp_first_section', array('theName' => 'wcp_readtime')); // create 5 arguments
      register_setting('wordcountplugin', 'wcp_readtime', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));
   }

   /*
   For the wordcount, charactercount and readtime HTML functions, you can use the following code:

    function wordcountHTML() { ?>
      <input type="checkbox" name="wcp_wordcount" value="1" <?php checked(get_option(wcp_wordcount, '1'))>
    <?php }

    function charactercountHTML() { ?>
      <input type="checkbox" name="wcp_charactercount" value="1" <?php checked(get_option(wcp_charactercount, '1'))>
    <?php }

    function readtimeHTML() { ?>
      <input type="checkbox" name="wcp_readtime" value="1" <?php checked(get_option(wcp_readtime, '1'))>
    <?php }

    for cleaner and easier reading code however, use code below
   */
   function checkboxHTML($args) { ?>
      <input type="checkbox" name="<?php echo $args['theName'] ?>" value="1" <?php checked(get_options($args['theName']), '1') ?>>
    <?php }
   
   // function for displaying the name of headline for word count, character count and read time
   function headlineHTML() { ?>
     <input type="text" name="wcp_headline" value="<?php echo esc_attr(get_option('wcp_headline')) ?>">
   <?php }

   function locationHTML() { ?>
     <select name="wcp_location">
       <option value="0"<?php selected(get_option('wcp_location'), '0') ?>>Beginning of post</option>
       <option value="1"<?php selected(get_option('wcp_location'), '1') ?>>End of post</option>
     </select>
     <?php }

   function adminPage() {
     add_options_page('Word Count Settings', 'Word Count', 'manage_options', 'word-count-settings-page', array($this, 'pluginHTML'));
   }
   
   // to include actual HTML for structure of page
   function pluginHTML() { ?>
      <div name="wrap">
        <h1>Word Count Settings</h1>
        <form action="options.php" method="POST"></form>
        <?php
          settings_fields('wordcountplugin');
          do_settings_sections('word-count-settings-page');
          submit_button();
        ?>
      </div>
   <?php }
 }

 // to create a new instance of class above
 $WordCountAndTimePlugin = new WordCountAndTimePlugin();

 add_filter( 'auto_update_plugin', '__return_true' );

 