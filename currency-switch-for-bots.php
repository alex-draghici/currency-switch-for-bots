<?php
/*
Plugin Name: Woocommerce WPML Currency Switch for Bots
Description: Switches currency for Google bots using wcml_geolocation_get_user_country hook from WooCommerce Multilingual & Multicurrency plugin.
Version: 1.0.0
Plugin URI: https://alexdraghici.dev/
Author: Alexandru Draghici
Author URI: https://alexdraghici.dev/
*/

if (!defined('ABSPATH')) {
    exit;
}

if (!in_array('woocommerce-multilingual/wpml-woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    exit;
}

add_filter('wcml_geolocation_get_user_country', 'switch_currency_for_google_bot');

/**
 * Switches the currency to a default country currency when a Google Bot is detected.
 *
 * @param string $country The default country code.
 * @return string Modified country code.
 */
function switch_currency_for_google_bot(string $country): string
{
    if (is_google_bot()) {
        return 'COUNTRY-ISO-CODE';
    }
    return $country;
}

/**
 * @return bool
 */
function is_google_bot(): bool
{
    $user_agent = \strtolower($_SERVER['HTTP_USER_AGENT']);
    return \str_contains($user_agent, 'googlebot');
}
