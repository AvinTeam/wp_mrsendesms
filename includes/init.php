<?php
function custom_login_cookie_expiration($expiration)
{
    return 30 * DAY_IN_SECONDS;
}
add_filter('auth_cookie_expiration', 'custom_login_cookie_expiration');
