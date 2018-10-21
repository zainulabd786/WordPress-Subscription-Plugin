<?php
/*
Plugin Name: Subscribe
Plugin URI: https://edensolutions.co.in/
Description: A simple wordpress widget plugin that lets your readers to subscribe to your blog and recieve blog updates through email.
Version: 1.0
Author: Zainul Abideen
Author URI: https://edensolutions.co.in
License: GPLv2 or later
Text Domain: sub
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
}

define( 'PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

include_once(PLUGIN_DIR."/includes/admin/widget-class.php");
include_once(PLUGIN_DIR."/lib/ajax_works.php");

function enqueue_scripts(){
	wp_enqueue_style('custom_plugin_styles', '/wp-content/plugins/subscribe/css/styles.css');

	wp_enqueue_style( 'bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css', array() ); //bootstrap CSS
    wp_enqueue_script( 'bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js', array('jquery'), null, true ); //bootstrap js

    wp_enqueue_script( 'sub_subscribe', '/wp-content/plugins/subscribe/js/subscribe.js', array('jquery'),null ,true );

    $ajax_url = admin_url( 'admin-ajax.php' );
	// localize script
	wp_localize_script( 'sub_subscribe', 'ajax_url', $ajax_url );
}
add_action( 'wp_enqueue_scripts', 'enqueue_scripts' );

function subscribe_activation() {
   include_once(PLUGIN_DIR."/lib/activation.php");
}
register_activation_hook( __FILE__, 'subscribe_activation' );

function check_email($mail_id){
	global $wpdb;

	$subscribers = $wpdb->prefix . 'sub_subscribers';
	$result = $wpdb->get_results("SELECT email FROM $subscribers WHERE email='$mail_id' ");

	($wpdb->num_rows > 0) ? $resp = false : $resp = true;

	return $resp;
}
add_filter("check_if_mail_exist", "check_email");

function number_of_subscribers(){
	global $wpdb;

	$subscribers = $wpdb->prefix . 'sub_subscribers';
	$result = $wpdb->get_results("SELECT COUNT(email) AS subscribers FROM $subscribers");

	echo $result[0]->subscribers;

	//wp_die();
}
add_action("number_of_subscribers", "number_of_subscribers");

function send_mails_on_publish( $new_status, $old_status, $post ) {
	global $wpdb;
    if ( 'publish' !== $new_status or 'publish' === $old_status or 'post' !== get_post_type( $post ) ) return;

    
    $emails = array ();

    $subscribers_table = $wpdb->prefix."sub_subscribers";

    $subscribers = $wpdb->get_results("SELECT * FROM $subscribers_table");

    foreach ( $subscribers as $subscriber ) $emails[] = $subscriber->email;

    $body = sprintf( 'Hey there is a new entry!
        See <%s>',
        get_permalink( $post )
    );


    wp_mail( $emails, 'New entry!', $body );
}
add_action( 'transition_post_status', 'send_mails_on_publish', 10, 3 );



