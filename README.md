# recaptcha-integration
Google ReCAPTCHA v3 integration for Municipio and plugins

## Install with Composer
``` composer require helsingborg-stad/recaptcha-integration ```

### Example howto integrate with Wordpress:

#### HTML:
Add hidden input to form.
Google will populate the input with a hashed string.

```
<input type="hidden" class="g-recaptcha-response"
id="g-recaptcha-response" name="g-recaptcha-response" value="" />
```

#### PHP config:
Get your reCaptcha secret keys and register your site domain at following address:
https://developers.google.com/recaptcha

Add keys to your config/functions file:
```
<?php

define('G_RECAPTCHA_KEY', 'YOUR-RECAPTCHA-SITE-KEY');
define('G_RECAPTCHA_SECRET', 'YOUR-RECAPTCHA-SECRET-KEY');

?>
```

#### PHP Function: initScripts()
Includes the google reCaptcha javaScripts to the front end.
```
<?php

    use \HelsingborgStad\RecaptchaIntegration as Captcha;
    
    add_action('wp_enqueue_scripts', 'getScripts', 999);
    
    function getScripts(){
        Captcha::initScripts();
    }

?>    
```

#### PHP Function: initCaptcha()
This function run the captcha validation before posting.
In this example it runs before comments are posted.

```
<?php 

    use \HelsingborgStad\RecaptchaIntegration as Captcha;
    
    add_action('pre_comment_on_post', 'reCaptchaValidation');
    
    function reCaptchaValidation() {
        
        if (is_user_logged_in()) {
            return;
        }

        Captcha::initCaptcha();
    }

?>    
```

#### More Code examples
Example how we use the package:
https://github.com/helsingborg-stad/Municipio/blob/3.0/develop/library/Comment/CommentsFilters.php

That's all folk :-)