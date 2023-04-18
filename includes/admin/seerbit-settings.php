<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

return array(
    'enabled'         => array(
        'title'       => __('Enable/Disable', 'seerbit-payment'),
        'label'       => __('Enable SeerBit', 'seerbit-payment'),
        'type'        => 'select',
        'default'     => 'no',
        'desc_tip'    => true,
        'options'     => array(
            'yes'       => __('Yes', 'seerbit-payment'),
            'no' => __('No', 'seerbit-payment')
        ),
    ),
    'title'            => array(
        'title'       => __('Title', 'seerbit-payment'),
        'type'        => 'text',
        'default'     => __('SeerBit', 'seerbit-payment'),
        'desc_tip'    => true,
    ),
    'description'    => array(
        'title'       => __('Description', 'seerbit-payment'),
        'type'        => 'textarea',
        'default'     => __('Seamless payment with Card, Online Banking, Transfer, Mobile Money, USSD', 'seerbit-payment'),
        'desc_tip'    => true,
    ),
    'public_key'     => array(
        'title'       => __('Public Key', 'seerbit-payment'),
        'type'        => 'text',
        'default'     => '',
    ),
    'secret_key'      => array(
        'title'       => __('Secret Key', 'seerbit-payment'),
        'type'        => 'text',
        'default'     => '',
    ),
    'meta_products'   => array(
        'title'       => __('Product(s) Orders', 'seerbit-payment'),
        'label'       => __('Send Product(s) Ordered', 'seerbit-payment'),
        'type'        => 'select',
        'description' => __('If checked, the product(s) paid for  will be sent to SeerBit', 'seerbit-payment'),
        'default'     => 'yes',
        'desc_tip'    => true,
        'options'     => array(
            'true'       => __('Yes', 'seerbit-payment'),
            'false' => __('No', 'seerbit-payment')
        ),
    ),
    'auto_complete'                         => array(
        'title'       => __( 'Auto Complete', 'seerbit-payment' ),
        'label'       => __( 'Auto Complete successful order', 'seerbit-payment' ),
        'type'        => 'checkbox',
        'description' => __( 'If checked, automatically update order status to Completed after a successful payment.', 'seerbit-payment' ),
        'default'     => 'no',
        'desc_tip'    => true,
    ),
);