<?php

if (!defined('WP_MEPR_DEBUG')) {
  define('WP_MEPR_DEBUG', true);
}

add_action('mepr_paypal_commerce_ipn_listener_preprocess', function () {
  file_put_contents(WP_CONTENT_DIR.'/paypal-connect.log', 'New IPN '.print_r($_POST, true).PHP_EOL, FILE_APPEND);
});