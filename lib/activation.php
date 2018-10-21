<?php 
	if ( ! defined( 'ABSPATH' ) ) 
		exit('No Such File');

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	global $wpdb;

	$subscribers = $wpdb->prefix . 'sub_subscribers';
	$create_subscribers_table = "CREATE TABLE IF NOT EXISTS $subscribers  (
	  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	  `email` varchar(100)
	)ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
	dbDelta($create_subscribers_table);

