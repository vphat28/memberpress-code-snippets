<?php
function capture_notify_urls_and_fwd() {
    $ipn_url = 'https://example.local/mepr/notify/ro5w4a-4kg/ipn';
    $old_url = 'swpm_process_ipn=1';
  
    if(isset($_POST) && !empty($_POST) && strpos($_SERVER['REQUEST_URI'], $old_url) !== false) {

        wp_remote_post($ipn_url, array('body' => stripslashes_deep($_POST), 'sslverify' => false));

        header("status: 200", true);

        die("Notify URL Delivered");

    }

}
add_action('init', 'capture_notify_urls_and_fwd', 3);
