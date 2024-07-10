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

            $this->init_form_fields();
            $this->init_settings();

            $this->init_settings();
            $this->customer_id = $this->get_option('customer_id');
            $this->title = $this->get_option('title');
            $this->description = $this->get_option('description');
            $this->enabled = $this->get_option('enabled');
            $this->testmode = 'yes' === $this->get_option('testmode');
            $this->username = $this->get_option('username');
            $this->password = $this->get_option('password');
            $this->payment_failed = $this->get_option('payment_failed');
        }

        public function gateway_log($message, $show_date=false) {
            if ($show_date) {
                error_log(date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL, 3, $this->error_log_dir);
            } else {
                error_log($message . PHP_EOL, 3, $this->error_log_dir);
            }
        }

        public function init_form_fields() {
            $this->form_fields = array(
                'enabled' => array(
                    'title' => 'Enable/Disable',
                    'type' => 'checkbox',
                    'label' => 'Enable Etisalat Payment Gateway?',
                    'default' => 'no'
                ),
                'customer_id' => array(
                    'title' => 'Customer ID',
                    'type' => 'text',
                    'description' => 'Your EPG Account Customer ID found in the settings page.'
                ),
                'title' => array(
                    'title' => 'Title',
                    'type' => 'text',
                    'description' => 'This controls the title which the user sees during checkout.',
                    'default' => 'Online Payment (Etisalat)',
                    'desc_tip' => true
                ),
                'description' => array(
                    'title' => 'Description',
                    'type' => 'textarea',
                    'description' => 'This controls the description which the user sees during checkout.',
                    'default' => 'Powered by Etisalat, a secure and fast method to complete your transaction with multiple methods including: Apple Pay, Visa / Mastercard, Samsung Pay, etc.'
                ),
                'testmode' => array(
                    'title' => 'Test Mode',
                    'type' => 'checkbox',
                    'label' => 'Enable Test Mode',
                    'default' => 'yes',
                    'description' => 'Place the payment gateway in test mode using the test API keys.'
                ),
                'username' => array(
                    'title' => 'Username',
                    'type' => 'text',
                    'description' => 'Enter the username for the Etisalat Payment Gateway.'
                ),
                'password' => array(
                    'title' => 'Password',
                    'type' => 'password',
                    'description' => 'Enter the password for the Etisalat Payment Gateway.'
                ),
                'payment_failed' => array(
                    'title' => 'Payment Failed Page URL',
                    'type' => 'text',
                    'description' => 'URL for the page which user will be redirected to after a failed payment.'
                )
            );
        }
    }
}