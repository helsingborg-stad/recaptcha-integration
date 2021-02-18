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

## More about how Google reCaptcha v3 work.

- The end user requests a web page.
- The web app or server returns the requested page, which includes reCAPTCHA v3 code.
- Next, the user fills in the form and clicks on the submit button.
- Before submitting the form data to the server, the reCAPTCHA v3 code on the client makes an AJAX call to the Google server and obtains a token. The important thing here is that we have to pass the action attribute with an appropriate value during the AJAX call. You should pass the value which identifies your form. This is the value which you'll use for verification on the server side, along with other parameters.
- The token obtained in the previous step is submitted along with the other form data. In most cases, we append two hidden variables to the form, token and action, before the form is submitted.
- Once the form is submitted, we have to perform the verification step to decide if the form is submitted by a human. As a first step, we’ll make a POST request to verify the response token. The POST request passes the token along with the Google secret to the Google server.
- The response is a JSON object, and we’ll use it to decide if the form is submitted by a human. The format of the JSON object is shown in the following snippet.

That's all folks :-)
