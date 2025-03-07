<?php
/**
 * Mr send sms
 *
 * Plugin Name: ارسال پیامک
 * Plugin URI:  http://avinmedia.ir/
 * Description: ارسال پیامک با پنل های tsms و قاصدک
 * Version:     1.0.15
 * Author:      Mohammadreza Rashidpour Aghamahali
 * Author URI:  https://www.mrrashidpour.com/
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Requires at least: 6.6
 * Requires PHP: 8.1
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation. You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 */

(defined('ABSPATH')) || exit;

preg_match('/Version:\s*(.+)/i', file_get_contents(__FILE__), $versionMatches);

$version = $versionMatches[ 1 ] ?? 0;

define('MRSMS_VERSION', $version);

define('MRSMS_FILE', __FILE__);
define('MRSMS_PATH', plugin_dir_path(__FILE__));
define('MRSMS_INCLUDES', MRSMS_PATH . 'includes/');
define('MRSMS_CLASS', MRSMS_PATH . 'classes/');
define('MRSMS_CORE', MRSMS_PATH . 'core/');
define('MRSMS_VIEWS', MRSMS_PATH . 'views/');

define('MRSMS_URL', plugin_dir_url(__FILE__));
define('MRSMS_SHORT_CODE_STYLE', MRSMS_VIEWS . 'style/');
define('MRSMS_ASSETS', MRSMS_URL . 'assets/');
define('MRSMS_CSS', MRSMS_ASSETS . 'css/');
define('MRSMS_JS', MRSMS_ASSETS . 'js/');
define('MRSMS_IMAGE', MRSMS_ASSETS . 'images/');

require_once MRSMS_CLASS . 'SMSOption.php';
require_once MRSMS_CLASS . 'SendSMS.php';

require_once MRSMS_INCLUDES . 'init.php';
require_once MRSMS_INCLUDES . 'styles.php';
require_once MRSMS_INCLUDES . 'ajax.php';
require_once MRSMS_INCLUDES . 'function.php';

if (is_admin()) {

    require_once MRSMS_INCLUDES . '/menu.php';
    require_once MRSMS_INCLUDES . '/edit_user_table.php';
    require_once MRSMS_INCLUDES . '/user_filed.php';

}