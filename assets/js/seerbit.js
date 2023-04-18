jQuery(function ($) {
    var processing = false;
    jQuery('#seerbit-payment-button').click(function () {
        return paywithSeerbitWoo();
    });

    var onComplete = function (response, closeModal) {
        if (response.code === "00") {
            processing = true
            $( 'body' ).block( {
                message: null,
                overlayCSS: {
                    background: "#fff",
                    opacity: 0.8
                },
                css: {
                    cursor: "wait"
                }
            } );
            closeModal()
        }else{
            processing = false
        }
    };

    var onCloseCheckout = ()=>{
        processing = false
    }

    function paywithSeerbitWoo() {

        // if (wc_params.phone_number && wc_params.phone_number.length > 11){
        //     alert('Invalid Phone number. A maximum of 11 characters is required.')
        // }
        if (processing) {
            processing = false;
            return true;
        }

        var data = {
            email: wc_params.customer_email,
            public_key: wc_params.public_key,
            tranref: wc_params.tranref,
            full_name: wc_params.customer_name,
            mobile_no: wc_params.phone_number.substr(0,10),
            callbackurl: window.location.href,
            country: wc_params.country,
            currency: wc_params.currency,
            amount: wc_params.amount,
        }

        window.SeerbitPay(data,onComplete, onCloseCheckout)

        // $.ajax({
        //     url: wc_params.endpoint,
        //     type: 'POST',
        //     dataType: 'json',
        //     contentType: 'application/json',
        //     headers: {
        //         'Authorization': `Bearer ${token}`,
        //     },
        //     data: JSON.stringify(data),
        //     success: function (response) {
        //         window.location.href = response.data.payments.redirectLink;
        //     }
        // });

    }
});