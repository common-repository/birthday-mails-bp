<?php
/*
Plugin Name: Birthday mails bp
Plugin URI: http://www.Vibethemes.com
Description: A simple WordPress plugin to modify WPLMS template
Version: 1.0
Author: alexhal
Author URI: http://www.poolgab.com
License: GPL2
*/
/*
Copyright 2014  VibeThemes  (email : vibethemes@gmail.com)

Birthday mails bp program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

Birthday mails bp program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Birthday mails bp program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


include_once 'classes/bmbp_class.php';
if (function_exists('bp_is_active') && bp_is_active( 'xprofile' ) ){
    register_activation_hook(__FILE__, array('Bmbp_Class', 'activate'));
    register_deactivation_hook(__FILE__, array('Bmbp_Class', 'deactivate'));
}
include_once('classes/settings_class.php');
add_action('bp_init','init_my_plugin');
function init_my_plugin(){
  if (function_exists('bp_is_active') && bp_is_active( 'xprofile' ) ){
    if(class_exists('Bmbp_Class')){ 
   
        // instantiate the plugin class
        $bmbp_obj = new Bmbp_Class();
    }
  } 
}



function bmbp_enqueue_scripts(){
    wp_enqueue_script( 'birthday-mail-css', plugins_url( 'js/custom.js' , __FILE__ ));
}

add_action('wp_footer','bmbp_enqueue_scripts');
add_action('wp_head','bmbp_enqueue_style');


/**
 * Objective: Register & Enqueue your Custom scripts
 * Developer notes:
 * Hook you custom scripts required for the plugin here.
 */
function bmbp_enqueue_style(){
    wp_enqueue_style( 'wplms-customizer-css', plugins_url( 'css/custom.css' , __FILE__ ));
}
add_action( 'plugins_loaded', 'birthday_mails_bp_language_setup' );
function birthday_mails_bp_language_setup(){
    $locale = apply_filters("plugin_locale", get_locale(), 'bmbp');
    
    $lang_dir = dirname( __FILE__ ) . '/languages/';
    $mofile        = sprintf( '%1$s-%2$s.mo', 'bmbp', $locale );
    $mofile_local  = $lang_dir . $mofile;
    $mofile_global = WP_LANG_DIR . '/plugins/' . $mofile;

    if ( file_exists( $mofile_global ) ) {
        load_textdomain( 'bmbp', $mofile_global );
    } else {
        load_textdomain( 'bmbp', $mofile_local );
    }   
}