<?php

namespace HelsingborgStad;

/**
 * Class RecaptchaIntegration
 * @package HelsingborgStad
 */
class RecaptchaIntegration
{
    /**
     * RecaptchaIntegration constructor.
     */
    public function __construct()
    {
        if (function_exists('add_action')) {
            add_action('admin_notices', array($this, 'recaptchaConstants'));
        }
    }

    /**
     * Enqueues the google script
     */
    public static function initScripts()
    {
        Enqueue::script();
    }

    /**
     * Initializes the validation
     */
    public static function initCaptcha()
    {
        Validation::validateGoogleResponse();
    }

    /**
     * Publish  admin notice if Google reCaptcha constants is missing
     */
    public static function recaptchaConstants()
    {
        if (defined('G_RECAPTCHA_KEY') && defined('G_RECAPTCHA_SECRET')) {
            return;
        }

        $class = 'notice notice-warning';
        $message = __('Municipio: constant \'G_RECAPTCHA_KEY\' or \'G_RECAPTCHA_SECRET\' is not defined.', 'municipio');
        printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
    }

}