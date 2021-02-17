<?php

namespace RecaptchaIntegration;

/**
 * Class RecaptchaIntegration
 * @package RecaptchaIntegration
 */
class RecaptchaIntegration
{
    /**
     * RecaptchaIntegration constructor.
     * Enqueues the google script
     */
    public function __construct()
    {
        Enqueue::script();
    }

    /**
     * Initializes the validation
     */
    public static function initCaptcha(){
        Validation::validateGoogleResponse();
    }

    /**
     * Add admin notice if Google reCaptcha constants is missing
     */
    public static function recaptchaConstants()
    {
        if (defined('G_RECAPTCHA_KEY') && defined('G_RECAPTCHA_SECRET')) {
            return;
        }

        $class = 'c-notice c-notice--warning';
        $message = __('Municipio: constant \'G_RECAPTCHA_KEY\' or \'G_RECAPTCHA_SECRET\' is not defined.', 'municipio');
        printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
    }

}