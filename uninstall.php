<?php 
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
global $wpdb;

$table = $wpdb->prefix."sub_subscribers";

$wpdb->query("DROP TABLE IF EXISTS $table");