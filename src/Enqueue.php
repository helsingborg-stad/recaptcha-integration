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
     * @return void
     */
    public static function script()
    {
        if (defined('G_RECAPTCHA_KEY') && defined('G_RECAPTCHA_SECRET')) {

            // Google script
            wp_enqueue_script('municipio-google-recaptcha',
                'https://www.google.com/recaptcha/api.js?render=' . G_RECAPTCHA_KEY, 20, 'dev', true
            );

            // Inline script for captcha
            wp_add_inline_script('municipio-google-recaptcha', "
               
                function validateClient(formId) {
                    if (window.grecaptcha) {
                        grecaptcha.ready(function () {
                            grecaptcha.execute('" . G_RECAPTCHA_KEY . "', {action: 'submit'}).then(function (token) {
                                if (document.getElementById(formId).querySelector('.g-recaptcha-response')) {
                                    document.getElementById(formId).querySelector('.g-recaptcha-response').value = token;
                                }
                                document.forms[formId].submit();
                            });
                        });
                    }
                }
                
                var forms = document.querySelectorAll('form');
                for (var i = 0; i < forms.length; i++) {
                    var formId = forms[i].getAttribute('id');
                    addEventListener('submit', function(e){
                        e.preventDefault();
                        validateClient(formId);
                    });
                }
            ");
        }
    }
}