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

add_action('plugins_loaded', 'init_etisalat_gateway');
function init_etisalat_gateway() {
    class WC_Etisalat_Gateway extends WC_Payment_Gateway {
        public function __construct() {
            $this->id = 'etisalat-gateway';
            $this->has_fields = true;
            $this->method_title = 'Online Payment (Etisalat)';
            $this->method_description = 'Powered by Etisalat, a secure and fast method to complete your transaction with multiple methods including: Apple Pay, Visa / Mastercard, Samsung Pay, etc.';
            $this->api_uri_live = "https://ipg.comtrust.ae:2443/";
            $this->api_uri_testing = 'https://demo-ipg.ctdev.comtrust.ae:2443/';
            $this->error_log_dir = dirname(__FILE__) . '/etisalat-gateway_logs.txt';
            
            $this->supports = array(
                'products',
                'refunds'
            );
        }
    }
}