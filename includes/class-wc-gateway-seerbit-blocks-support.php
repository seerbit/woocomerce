<?php

use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;
use Automattic\WooCommerce\StoreApi\Payments\PaymentContext;
use Automattic\WooCommerce\StoreApi\Payments\PaymentResult;

final class WC_Gateway_SeerBit_Blocks_Support extends AbstractPaymentMethodType {

	/**
	 * Payment method name/id/slug.
	 *
	 * @var string
	 */
	protected $name = 'seerbit';

    /**
     * Settings from the WP options table
     *
     * @var WC_Payment_Gateway
     */
  private $gateway;

	/**
	 * Initializes the payment method type.
	 */
	public function initialize() {
		$this->settings = get_option( 'woocommerce_seerbit_settings', array() );
        if ( version_compare( WC_VERSION, '6.9.1', '<' ) ) {
            // For backwards compatibility.
            if ( ! class_exists( 'WC_Gateway_Seerbit' ) ) {
                require_once dirname( WC_SEERBIT_FILE ) . '/includes/class-wc-gateway-seerbit.php';
            }
            $this->gateway = new WC_Gateway_Seerbit();
        } else {
            $gateways      = WC()->payment_gateways->payment_gateways();
            $this->gateway = $gateways[ $this->name ];
        }
	}

	/**
	 * Returns if this payment method should be active. If false, the scripts will not be enqueued.
	 *
	 * @return boolean
	 */
    public function is_active(): bool {
        if ( version_compare( WC_VERSION, '6.9.0', '>' ) ) {
            $gateways = WC()->payment_gateways->payment_gateways();

            if ( ! isset( $gateways[ $this->name ] ) ) {
                return false;
            }
        }

        return $this->gateway->is_available();
    }

    /**
     * Returns an array of supported features.
     *
     * @return string[]
     */
    public function get_supported_features(): array {
        return $this->gateway->supports;
    }


    /**
     * Returns an array of key=>value pairs of data made available to the payment methods script.
     *
     * @return array
     */
    public function get_payment_method_data(): array {
        return array(
            'supports'    => array_filter( $this->get_supported_features(), array( $this->gateway, 'supports' ) ),
            'isAdmin'     => is_admin(),
            'asset_url'   => plugins_url( 'assets', WC_SEERBIT_FILE ),
            'title'       => $this->settings['title'],
            'description' => $this->settings['description'],
        );
    }



  public function get_payment_method_script_handles()
  {
      wp_register_script(
          'seerbit',
          'https://checkout.seerbitapi.com/api/v2/seerbit.js',
          array(),
          WC_SEERBIT_VERSION,
          true
      );

      $asset_path   = dirname( WC_SEERBIT_FILE ) . '/build/index.asset.php';
      $version      = WC_SEERBIT_VERSION;
      $dependencies = array();

      if ( file_exists( $asset_path ) ) {
          $asset        = require $asset_path;
          $version      = is_array( $asset ) && isset( $asset['version'] )
              ? $asset['version']
              : $version;
          $dependencies = is_array( $asset ) && isset( $asset['dependencies'] )
              ? $asset['dependencies']
              : $dependencies;
      }


      wp_register_script(
          'wc-seerbit-blocks',
          WC_SEERBIT_URL . '/build/index.js',
          array_merge( array( 'seerbit' ), $dependencies ),
          $version,
          true
      );

      wp_set_script_translations(
          'wc-seerbit-blocks',
          'seerbit-payment'
      );


      return array(
          'wc-seerbit-blocks',
      );
  }
}
