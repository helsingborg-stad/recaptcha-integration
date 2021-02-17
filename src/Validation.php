<?php

namespace RecaptchaIntegration;

/**
 * Class Validation
 * @package RecaptchaIntegration
 */
class Validation
{

    /** Get google verification
     * @param $response
     * @return mixed Response body from google
     */
    public static function getGoogleVerification($response)
    {
        if (defined('G_RECAPTCHA_SECRET') && $response) {
            $verify = wp_remote_get('https://www.google.com/recaptcha/api/siteverify?secret=' . G_RECAPTCHA_SECRET
                . '&response=' . $response);
            return json_decode($verify["body"]);
        }
    }


    /**
     * Validate reCaptcha response against google servers before save
     * @return mixed
     */
    public static function validateGoogleResponse(): bool
    {
        $response = isset($_POST['g-recaptcha-response']) ? esc_attr($_POST['g-recaptcha-response']) : '';
        $validate = self::getGoogleVerification($response);

        if ($validate->score >= 0.5) {
            return $validate->success;
        }

        wp_die(sprintf('<strong>%s</strong>:&nbsp;%s', __('Error', 'municipio'),
            __('reCaptcha validation failed', 'municipio')));
    }

}