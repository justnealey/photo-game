<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function get_topics_from_database($difficulty) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'photo_game_topics';
    $query = $wpdb->prepare("SELECT topic FROM $table_name WHERE difficulty = %s", $difficulty);
    $results = $wpdb->get_col($query);
    unset($query); // Clear memory
    return $results;
}
