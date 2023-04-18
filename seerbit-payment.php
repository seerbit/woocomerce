<?php
/*
Plugin Name: SeerBit payment gateway plugin For WooCommerce
Description: Start accepting payments on your WooCommerce store using SeerBit for WooCommerce plugin.
Tags: SeerBit payment, SeerBit, payment, payment gateway, online payments, pay now, buy now, e-commerce, gateway, Nigeria, Africa, Ghana
Author: SeerBit
Version: 1.3.8
Author URI: https://seerbit.com
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Requires at least:
Tested up to: 6.1.1
Stable tag: 1.3.8
*/

if (!defined('ABSPATH')) {
	exit;
}
define( 'WC_SEERBIT_FILE', __FILE__ );
define( 'WC_SEERBIT_URL', untrailingslashit( plugins_url( '/', __FILE__ ) ) );
define( 'WC_SEERBIT_VERSION', '1.3.8' );


/**
 * Initialize Seerbit WooCommerce payment gateway.
 */
function seerbit_payment_init()
{
//	load_plugin_textdomain('seerbit-payment', false, plugin_basename(dirname(__FILE__)) . '/languages');
	if (class_exists('WC_Payment_Gateway_CC')) {
		require_once dirname(__FILE__) . '/includes/class-wc-gateway-seerbit.php';
	}
	add_filter('woocommerce_payment_gateways', 'wc_add_seerbit_gateway', 99);
	add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'seerbit_payment_plugin_action_links');
}
add_action('plugins_loaded', 'seerbit_payment_init', 99);
add_action("admin_enqueue_scripts", "loadseerbitpluginstyle");


function loadseerbitpluginstyle()
{
	wp_enqueue_style('seerbit_style_semantic', plugins_url('assets/css/style.css', __FILE__));
}
/**
 * Add Settings link to the plugin entry in the plugins menu.
 *
 * @param array $links Plugin action links.
 *
 * @return array
 **/
function seerbit_payment_plugin_action_links($links)
{
	$settings_link = array(
		'settings' => '<a href="' . admin_url('admin.php?page=wc-settings&tab=checkout&section=seerbit') . '" title="' . __('View SeerBit WooCommerce Settings', 'seerbit-payment') . '">' . __('Settings', 'seerbit-payment') . '</a>',
	);
	return array_merge($settings_link, $links);
}

/**
 * Add Seerbit Gateway to WooCommerce.
 *
 * @param array $methods WooCommerce payment gateways methods.
 *
 * @return array
 */
function wc_add_seerbit_gateway($methods)
{
    if ( ! class_exists( 'WC_Payment_Gateway' ) )
    {
        add_action( 'admin_notices', 'seerbit_payment_wc_missing_notice' );
        return;
    }
	if (class_exists('WC_Payment_Gateway_CC')) 
	{
		$methods[] = 'WC_Gateway_Seerbit';
	}

	return $methods;
}

/**
 * Display a notice if WooCommerce is not installed
 */
function seerbit_payment_wc_missing_notice()
{
	echo '<div class="error"><p><strong>' . sprintf(__('SeerBit requires WooCommerce to be installed and active. Click %s to install WooCommerce.', 'seerbit-payment'), '<a href="' . admin_url('plugin-install.php?tab=plugin-information&plugin=woocommerce&TB_iframe=true&width=772&height=539') . '" class="thickbox open-plugin-details-modal">here</a>') . '</strong></p></div>';
}
