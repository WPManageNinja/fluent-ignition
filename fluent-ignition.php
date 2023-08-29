<?php
/*
Plugin Name:  Fluent Ignition - Error Handling for Devs
Plugin URI:   https://wpmanageninja.com
Description:  [Require PHP 8.1] - A beautiful error page for WordPress Errors. Only for local development. DO NOT USE IN PRODUCTION.
Version:      1.0.0
Author:       techjewel
Author URI:   https://wpmanageninja.com
License:      GPLv2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

if ((defined('WP_DEBUG') && WP_DEBUG) || (defined('WP_DEVELOPMENT_MODE') && WP_DEVELOPMENT_MODE)) {
    // run if php version is greater than 8.1 or larger
    if (version_compare(phpversion(), '7.4.0', '>=')) {

        $theme = 'light';
        if (defined('FLUENT_IGNITION_THEME')) {
            $theme = FLUENT_IGNITION_THEME;
        }

        require_once __DIR__ . '/vendor/autoload.php';
        \Spatie\Ignition\Ignition::make()
            ->applicationPath(ABSPATH)
            ->setTheme($theme)
            ->setEditor('phpstorm')//vscode
            ->register();

    } else {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-error"><p>Fluent Ignition requires PHP version 8.1 or greater. Your current PHP version is ' . phpversion() . '</p></div>';
        });
    }
}




add_filter('pre_update_option_active_plugins', function ($plugins) {
    $index = array_search('fluent-ignition/fluent-ignition.php', $plugins);
    if ($index !== false) {
        if ($index === 0) {
            return $plugins;
        }
        unset($plugins[$index]);
        array_unshift($plugins, 'fluent-ignition/fluent-ignition.php');
    }
    return $plugins;
});

// on plugin activation
register_activation_hook(__FILE__, function () {
    add_filter('pre_update_option_active_plugins', function ($plugins) {
        $index = array_search('fluent-ignition/fluent-ignition.php', $plugins);
        if ($index !== false) {
            if ($index === 0) {
                return $plugins;
            }
            unset($plugins[$index]);
            array_unshift($plugins, 'fluent-ignition/fluent-ignition.php');
        }
        return $plugins;
    });
});
