# recaptcha-integration

Google ReCAPTCHA v3 integration for Municipio and plugins

## Install with Composer

``` composer require helsingborg-stad/recaptcha-integration ```

## Howto:
Start with the essentials required to use the package.

### Markup for Front End (HTML):
Add hidden input to your form. Google will populate the input with a hashed string.

```html
<input type="hidden" class="g-recaptcha-response" id="g-recaptcha-response"
       name="g-recaptcha-response" value=""/>
```
### Keys for Back End (PHP):

Register your sites domain and get the keys you need on Googles reCAPTCHA website.
https://developers.google.com/recaptcha

Note: This package is for version 3.
Once submitted, Google will provide you with the following two information.

- #### Site key
- #### Secret key

Add keys to your config or functions.php file. Replace: 
*YOUR-RECAPTCHA-SITE-KEY* and *YOUR-RECAPTCHA-SECRET-KEY*

```php
<?php

    define('G_RECAPTCHA_KEY', 'YOUR-RECAPTCHA-SITE-KEY');
    define('G_RECAPTCHA_SECRET', 'YOUR-RECAPTCHA-SECRET-KEY');

?>
```

## Basic Wordpress example if you use functions.php
Add the following code snippets to your functions.php file.

```php
<?php

    use \HelsingborgStad\RecaptchaIntegration as Captcha;
    
?>    
```

### Google reCaptcha v3 JavaScript.
This php code will include all necessary JavaScript.

```php
<?php

    add_action('wp_enqueue_scripts', 'getScripts', 999);
    
    function getScripts(){
        Captcha::initScripts();
    }

?>    
```

### PHP Function to validate :

This function will run the captcha validation before posting. In this example it runs before comments are posted.

```php
<?php 

    add_action('pre_comment_on_post', 'reCaptchaValidation');
    
    function reCaptchaValidation() {
        
        if (is_user_logged_in()) {
            return;
        }

        Captcha::initCaptcha();
    }

?>    
```

Thats it...

## Class based examples for Wordpress
If you prefer PHP classes, this is a simple example.
### Front end

```php
<?php

    namespace YourTheme\YourCommentLogicNameSpace;
    use \HelsingborgStad\RecaptchaIntegration as Captcha;
    
   /**
    * Class CommentsFrontEnd
    * @package YourTheme\YourCommentLogicNameSpace
    */
    class CommentsFrontEnd
    {
       /**
        * CommentFrontEnd constructor.
        */
        public function __construct()
        {
            add_action('wp_enqueue_scripts', array($this, 'getScripts'), 999);
        } 
        
       /**
        * Enqueue Google Captcha javaScripts
        */
        public static function getScripts(){
            Captcha::initScripts();
        }
    }    
        
?>    
```
### Back End
```php
<?php

    namespace YourTheme\YourCommentLogicNameSpace;
    use \HelsingborgStad\RecaptchaIntegration as Captcha;

   /**
    * Class CommentsBackEnd
    * @package YourTheme\YourCommentLogicNameSpace
    */
    class CommentsBackEnd
    {
        /**
         * CommentsBackEnd constructor.
         */
        public function __construct()
        {
            add_action('pre_comment_on_post', array($this, 'reCaptchaValidation'));
        }
        
        /**
         * Validate reCaptcha
         */
        public function reCaptchaValidation()
        {
            if (is_user_logged_in()) {
                return;
            }
    
            Captcha::initCaptcha();
        }
    }    
?>    
```

## More about how Google reCaptcha work.
https://en.wikipedia.org/wiki/ReCAPTCHA

https://developers.google.com/recaptcha/docs/v3

That's all folks :-)
