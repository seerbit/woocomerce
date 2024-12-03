(() => {
	'use strict';

	// Access the WooCommerce and WordPress registries
	const wcBlocksRegistry = window.wc.wcBlocksRegistry;
	const wpElement = window.wp.element;
	const wpI18n = window.wp.i18n;
	const wpHtmlEntities = window.wp.htmlEntities;

	// Payment method identifier
	const paymentMethodId = 'seerbit';

	// WooCommerce settings object
	const wcSettings = window.wc.wcSettings;

	// Function to retrieve SeerBit configuration data
	const getSeerBitData = () => {
		const seerbitData = wcSettings.getSetting('seerbit_data', null);
		if (!seerbitData) {
			throw new Error('SeerBit initialization data is not available');
		}
		return seerbitData;
	};

	// Component to display the payment method description
	const PaymentDescription = () => {
		const description = getSeerBitData()?.description;
		return wpElement.createElement(
			'div',
			null,
			wpHtmlEntities.decodeEntities(
				description ||
				wpI18n.__(
					'You may be redirected to a secure page to complete your payment.',
					'seerbit-payment'
				)
			)
		);
	};

	// Asset URL from SeerBit data
	const assetUrl = getSeerBitData()?.asset_url || null;

	// Payment method object
	const seerbitPaymentMethod = {
		name: paymentMethodId,
		label: wpElement.createElement(
			'div',
			{
				style: {
					display: 'flex',
					flexDirection: 'row',
					rowGap: '.5em',
					alignItems: 'center',
				},
			},
			wpElement.createElement('img', {
				src: `${assetUrl}/img/seerbit.png`,
				alt: wpHtmlEntities.decodeEntities(
					getSeerBitData()?.title || wpI18n.__('SeerBit', 'seerbit-payment')
				),
			}),
			wpElement.createElement(
				'b',
				null,
				wpElement.createElement('h4', null, 'SeerBit')
			)
		),
		placeOrderButtonLabel: wpI18n.__('Proceed to SeerBit', 'seerbit-payment'),
		ariaLabel: wpHtmlEntities.decodeEntities(
			getSeerBitData()?.title || wpI18n.__('Payment via SeerBit', 'seerbit-payment')
		),
		canMakePayment: () => true,
		content: wpElement.createElement(PaymentDescription, null),
		edit: wpElement.createElement(PaymentDescription, null),
		paymentMethodId: paymentMethodId,
		supports: {
			features: getSeerBitData()?.supports || [],
		},
	};

	// Register the payment method with WooCommerce
	wcBlocksRegistry.registerPaymentMethod(seerbitPaymentMethod);
})();
