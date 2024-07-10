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
ini_set('error_log', dirname(__FILE__) . '/etisalat-gateway_logs.txt');

add_filter('woocommerce_payment_gateways', 'add_etisalat_gateway');
add_filter( 'http_request_timeout', function( $timeout ) { return 10 ;});
function add_etisalat_gateway($gateways)
{
    $gateways[] = 'WC_Etisalat_Gateway';
    return $gateways;
}

add_action('plugins_loaded', 'init_etisalat_gateway');
function init_etisalat_gateway() {
    class WC_Etisalat_Gateway extends WC_Payment_Gateway {
        public $api_uri_testing, $api_uri_live;
        public $api_headers;
        public $testmode;
        public $payment_failed;
        public $customer_id;
        public $error_log_dir;
        
        private $username, $password;

        public function __construct() {
            $this->id = 'etisalat-gateway';
            $this->has_fields = true;
            $this->method_title = 'Online Payment (Etisalat)';
            $this->method_description = 'Powered by Etisalat, a secure and fast method to complete your transaction with multiple methods including: Apple Pay, Visa / Mastercard, Samsung Pay, etc.';
            $this->api_uri_live = "https://ipg.comtrust.ae:2443/";
            $this->api_uri_testing = 'https://demo-ipg.ctdev.comtrust.ae:2443/';
            $this->api_headers = array(
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                "Access-Control-Allow-Origin" => "*",
                "Access-Control-Allow-Methods" => "POST",
                "Access-Control-Allow-Credentials" => "true",
                "Access-Control-Allow-Headers" => "Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"
            );
            $this->error_log_dir = dirname(__FILE__) . '/etisalat-gateway_logs.txt';
            
            $this->supports = array(
                'products',
                'refunds'
            );

            $this->init_form_fields();

            $this->init_settings();
            $this->customer_id = $this->get_option('customer_id');
            $this->title = $this->get_option('title');
            $this->description = $this->get_option('description');
            $this->enabled = $this->get_option('enabled');
            $this->testmode = 'yes' === $this->get_option('testmode');
            $this->username = $this->get_option('username');
            $this->password = $this->get_option('password');
            $this->payment_failed = $this->get_option('payment_failed');

            add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
            add_action('woocommerce_api_epg-callback', array( $this, 'webhook' ));
            
            add_action('wp_enqueue_scripts', array($this, 'payment_scripts'));
        }

        public function gateway_log($message, $show_date=true) {
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

        public function process_payment($order_id) {
            $this->gateway_log("");
            $this->gateway_log("[Processing payment for order ID:" . $order_id . "]", false);
            $order = wc_get_order($order_id);
            $callback_url = get_option('siteurl') . '/wc-api/epg-callback?order_id=' . $order_id;
            $username = $this->testmode ? "Demo_fY9c" : $this->username;
            $password = $this->testmode ? "Comtrust@20182018" : $this->password;
            $uri = $this->testmode ? $this->api_uri_testing : $this->api_uri_live;

            $customer_id = $this->testmode ? "Demo Merchant" : $this->customer_id;
            $order_total = $order->get_total();
            $order_id = $order->get_id();
            $item_count = $order->get_item_count();

            $this->gateway_log("Test Mode: " . $this->testmode);
            $this->gateway_log("URL: " . $uri);
            $this->gateway_log("Username: " . $username . ", Password: " . substr($password, 0, 3) . "****");
            $this->gateway_log("Customer ID: " . $customer_id);
            $this->gateway_log("Order Total: " . $order_total);
            $this->gateway_log("Item Count: " . $item_count);

            // Make request to URL with data:
            /*
            {
                "Registration": {
                    "Customer": <customer_id>,
                    "Channel": "Web",
                    "Amount": <order_total>,
                    "Currency": "AED",
                    "OrderID": <order_id>,
                    "OrderName": "Order #<order_id>",
                    "OrderInfo": "N items from our Online Store",
                    "TransactionHint": "CPT:Y;VCC:Y;",
                    "ReturnPath": <callback_url>,
                    "Username": <username>,
                    "Password": <password>
                }
            }
            */
            $registration_body = array(
                'Registration' => array(
                    'Customer' => $customer_id,
                    'Channel' => 'Web',
                    'Amount' => $order_total,
                    'Currency' => 'AED',
                    'OrderID' => $order_id,
                    'OrderName' => "Order #$order_id",
                    'OrderInfo' => "$item_count items from our Online Store",
                    'TransactionHint' => 'CPT:Y;VCC:Y;',
                    'ReturnPath' => $callback_url,
                    'UserName' => $username,
                    'Password' => $password
                )
            );
            $this->gateway_log("POST (Registration) $uri -> " . json_encode(array_slice($registration_body, 0, -1)), false);
            $response = wp_remote_post($uri, array(
                'headers' => $this->api_headers,
                'body' => json_encode($registration_body)
            ));
            if (is_wp_error($response)) {
                $error_message = $response->get_error_message();
                wc_add_notice('Error: ' . $error_message, 'error');
                $this->gateway_log("");
                $this->gateway_log("Error: " . $error_message, false);
                return;
            }

            $response_body = wp_remote_retrieve_body($response);
            $response_data = json_decode($response_body, true);
            if ($response_data['Transaction']['ResponseCode'] !== '0') {
                wc_add_notice('Error: ' . $response_data['Transaction']['ResponseDescription'], 'error');
                $this->gateway_log("");
                $this->gateway_log("ERROR: " . $response_data['Transaction']['ResponseDescription'], false);
                return;
            }

            $paymentPage = $response_data['Transaction']['PaymentPage'];

            $this->gateway_log("Response Code: " . $response_data['Transaction']['ResponseCode']);
            $this->gateway_log("Response Data: " . json_encode($response_data));
            $this->gateway_log("Registration Successful, redirecting to $paymentPage", false);

            return array(
                'result' => 'success',
                'redirect' => $paymentPage
            );
        }

        public function payment_scripts() {
        }

        public function webhook() {
            $this->gateway_log("Finalization webhook called, Order ID: " . $_GET['order_id']);
            $transaction_id = $_POST['TransactionID'];
            $order = wc_get_order($_GET['order_id']);

            $uri = $this->testmode ? $this->api_uri_testing : $this->api_uri_live;
            $username = $this->testmode ? "Demo_fY9c" : $this->username;
            $password = $this->testmode ? "Comtrust@20182018" : $this->password;
            $customer_id = $this->testmode ? "Demo Merchant" : $this->customer_id;
            
            $this->gateway_log("Transaction ID: " . $transaction_id . ", Customer ID: " . $customer_id);

            // Make request to Finalization URL with data:
            /*
            {
                "Finalization": {
                    "Customer": <customer_id>,
                    "TransactionID": <transaction_id>,
                    "Username": <username>,
                    "Password": <password>
                }
            }
            */
            $finalization_body = array(
                'Finalization' => array(
                    'Customer' => $customer_id,
                    'TransactionID' => $transaction_id,
                    'UserName' => $username,
                    'Password' => $password
                )
            );
            $this->gateway_log("POST (Finalization) $uri -> " . json_encode(array_slice($finalization_body, 0, -1)), false);
            $response = wp_remote_post($uri, array(
                'headers' => $this->api_headers,
                'body' => json_encode($finalization_body)
            ));
            if (is_wp_error($response)) {
                $error_message = $response->get_error_message();
                $this->gateway_log("");
                $this->gateway_log("Error: " . $error_message, false);
                return;
            }
            $response_data = json_decode(wp_remote_retrieve_body($response), true);
            $this->gateway_log("Response Data: " . json_encode($response_data), false);   

            $thankyou = get_option('siteurl') . '/checkout/order-received/' . $_GET['order_id'];
            $checkout_url = get_option('siteurl') . '/checkout/';
            $response_code = $response_data['Transaction']['ResponseCode'];
            $response_description = $response_data['Transaction']['ResponseDescription'];
            $this->gateway_log("Response Code: " . $response_code);
            $this->gateway_log("Thank You Page: " . $thankyou, false);
            if ($response_code === '0') {
                $order->payment_complete();
                $order->add_order_note('Payment completed successfully.');
                $order->save();
                $this->gateway_log("Payment is successful", false);
                header('Location: ' . $thankyou);
                exit;
            } else if ($response_code == '51' || $response_code == '91') {
                $order->update_status('on-hold', 'Payment is pending.');
                $order->add_order_note('Payment is pending.');
                $order->save();
            } else {
                $order->update_status('failed', 'Payment failed.');
                $order->add_order_note("Payment failed. Reason ($response_code): $response_description");
                $order->save();
            }
            $this->gateway_log("Payment failed ($response_code)", false);
            header('Location: ' . $this->payment_failed);
            exit;
        }            
    }
}