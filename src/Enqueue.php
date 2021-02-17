<?php

namespace HelsingborgStad;

/**
 * Class Enqueue
 * @package HelsingborgStad
 */
class Enqueue
{
    /**
     * Enqueue Google reCAPTCHA
     */
    public static function script()
    {
        if (defined('G_RECAPTCHA_KEY') && defined('G_RECAPTCHA_SECRET')) {

            wp_enqueue_script('municipio-google-recaptcha',
                'https://www.google.com/recaptcha/api.js?render=' . G_RECAPTCHA_KEY);

            wp_add_inline_script('municipio-google-recaptcha', "
            
                  var interval = setInterval(function(){
                  if(window.grecaptcha){
                    grecaptcha.ready(function() {
                        grecaptcha.execute('" . G_RECAPTCHA_KEY . "', {action: 'homepage'}).then(function(token) {
                            document.querySelector('.g-recaptcha-response').value = token;
                        });
                    });
                    clearInterval(interval);
                  }
                }, 100);
            ");
        }
    }
}