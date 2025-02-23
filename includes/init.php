<?php
function custom_login_cookie_expiration($expiration)
{
    return 30 * DAY_IN_SECONDS;
}
add_filter('auth_cookie_expiration', 'custom_login_cookie_expiration');

add_action('wp', function () {
    mrsms_cookie();
});

/**
 * Prints scripts or data before the closing body tag on the front end.
 *
 */
add_action('wp_footer', function (): void {
    echo ' <div class="overlay" id="overlay"><div class="loader"></div></div>    ';
});
