<?php

namespace HelsingborgStad;

/**
 * Class Validation
 * @package HelsingborgStad
 */
class Validation
{

    /** Get google verification
     * @param $response - Googles Recaptcha Hash from front-end
     * @return mixed Response body from Google
     */
    public static function getGoogleVerification($response)
    {
        if (defined('G_RECAPTCHA_SECRET') && $response) {
            $verify = wp_remote_get(
                'https://www.google.com/recaptcha/api/siteverify?secret='.G_RECAPTCHA_SECRET.'&response='.$response
            );

            return json_decode($verify["body"]);
        }
    }

    /**
     * Validate reCaptcha response against google servers before save
     * If the validation score is 0.0 it's probably a bogus visitor or a bot.
     * As google state: (1.0 is very likely a good interaction, 0.0 is very likely a bot)
     * @return mixed If score is set to 0.5, we assume the visitor is one of the good ones.
     */
    public static function validateGoogleResponse(): bool
    {
        $response = isset($_POST['g-recaptcha-response']) ? esc_attr($_POST['g-recaptcha-response']) : '';
        $validate = self::getGoogleVerification($response);

        if ($validate->score >= 0.5 && $validate->success) {
            return $validate->success;
        }

        wp_die(sprintf('<strong>%s</strong>:&nbsp;%s', __('Error', 'municipio'),
            __('reCaptcha validation failed', 'municipio')));
    }

}