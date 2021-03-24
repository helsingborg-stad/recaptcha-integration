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
                'https://www.google.com/recaptcha/api.js?onload=setToken&render=' . G_RECAPTCHA_KEY, 20, 'dev', true
            );

            // Inline script for captcha
            wp_add_inline_script('municipio-google-recaptcha', "
                function setToken() {
                    if (window.grecaptcha) {
                        grecaptcha.ready(function () {
                            grecaptcha.execute('" . G_RECAPTCHA_KEY . "', {action: 'homepage'}).then(function (token) {
                                var captcha = document.getElementsByClassName('g-recaptcha-response');
                                for (var i = 0; i < captcha.length; i++) {
                                    captcha[i].value = token;
                                }
                            });
                        });
                    }
                }
                
                setInterval(function () {
                    setToken();
                }, 60000);
            ");
        }
    }
}