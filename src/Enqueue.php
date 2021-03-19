<?php

namespace HelsingborgStad;

/**
 * Class Enqueue
 * @package HelsingborgStad
 */
class Enqueue extends RecaptchaIntegration
{
    /**
     * Enqueue constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Enqueue Google reCAPTCHA
     */
    /**
     * Enqueue Google reCAPTCHA
     */
    public static function script()
    {
        if (defined('G_RECAPTCHA_KEY') && defined('G_RECAPTCHA_SECRET')) {

            wp_enqueue_script('municipio-google-recaptcha',
                'https://www.google.com/recaptcha/api.js?render=' . G_RECAPTCHA_KEY, 20, 'dev', true
            );

            wp_add_inline_script('municipio-google-recaptcha', "
            
                function validateClient(e, formId) {
                    e.preventDefault();
                    
                    if (window.grecaptcha) {
                        grecaptcha.ready(function () {
                            grecaptcha.execute('" . G_RECAPTCHA_KEY . "', {action: 'submit'}).then(function (token) {
                                document.getElementById(formId).querySelector('.g-recaptcha-response').value = token;
                                document.forms[formId].submit();
                            });
                        });
                    }
                }
            
                var checkFormAttributes = document.querySelectorAll('form');
                for (var i = 0; i < document.getElementsByTagName('form').length; i++) {
                    var formId = checkFormAttributes[i].getAttribute('id');
                    if (document.getElementById(formId).getAttribute('method').toLowerCase() === 'post') {
                        if (document.getElementById(formId).getElementsByClassName('protectedByCaptcha')[0]){
                            document.getElementById(formId).setAttribute('onsubmit', 'validateClient(event, formId);');
                        }
                    }
                }
            ");
        }
    }
}