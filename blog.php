<?php

header('Content-Type: application/json charset=utf-8');
require_once(dirname(__FILE__) . '/wp-load.php');
global $wpdb;

$operation = trim(strtolower($_GET['post']));

switch ($operation) {
    case 'latest':
        getLatestPosts($wpdb);
        break;
}

/**
 * getLatestPosts : Get Latest Posts
 *
 * @param str $wpdb    wpdb
 * @param str $lang    lang
 * @param str $country country
 *
 * @return array
 */
function getLatestPosts($wpdb)
{
    $query = "SELECT p.post_date,
              p.post_content,
              p.post_title,
              p.post_name
              FROM $wpdb->posts p where p.post_status = 'publish' order by p.post_date desc";
    $results= $wpdb->get_results($query);
    if (count($results) > 0) {
        $status = true;
    } else {
        $status = false;
    }
    $blog = array(
        'status' => $status,
        'msg' => 'Blog Posts',
        'data' => $results
    );

    echo json_encode($blog);
}
