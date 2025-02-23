<?php
function custom_login_cookie_expiration($expiration)
{
    return 30 * DAY_IN_SECONDS;
}
add_filter('auth_cookie_expiration', 'custom_login_cookie_expiration');

add_action('wp', function () {
    if (! isset($_COOKIE[ "setcookie_mrsms_nonce" ])) {

        setcookie("setcookie_mrsms_nonce", wp_generate_password(15), time() + 1800, "/");

    }
});

/**
 * Prints scripts or data before the closing body tag on the front end.
 *
 */
add_action('wp_footer', function (): void {
    echo ' <div class="overlay" id="overlay"><div class="loader"></div></div>    ';
});