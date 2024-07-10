<?php
/*
 * Plugin Name: Etisalat Payment Gateway.
 * Plugin URI: https://ipg.comtrust.ae/MerchantEx/login/login.
 * Description: Integrate the Etisalat Payment Gateway with WooCommerce using the Integration API.
 * Author: Osama Alhennawi
 * Author URI: https://github.com/osam7a
 * Version: 0.1.0
 */

ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');

add_filter('woocommerce_payment_gateways', 'add_etisalat_gateway');

function add_etisalat_gateway($gateways)
{
    $gateways[] = 'WC_Etisalat_Gateway';
    return $gateways;
}