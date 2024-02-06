<?php

/**
 * @file
 * Settings file to connect to a local mysql.
 * Copied into position on GitHub CI runs.
 */

$databases['default']['default']['database'] = "db";
$databases['default']['default']['username'] = "user";
$databases['default']['default']['password'] = "";
$databases['default']['default']['host'] = "localhost";
$databases['default']['default']['port'] = "30123";
$databases['default']['default']['driver'] = "mysql";


// This will prevent Drupal from setting read-only permissions on sites/default.
$settings['skip_permissions_hardening'] = TRUE;

// This will ensure the site can only be accessed through the intended host
// names. Additional host patterns can be added for custom configurations.
$settings['trusted_host_patterns'] = ['.*'];

// Don't use Symfony's APCLoader. ddev includes APCu; Composer's APCu loader has
// better performance.
$settings['class_loader_auto_detect'] = FALSE;

// Set $settings['config_sync_directory'] if not set in settings.php.
if (empty($settings['config_sync_directory'])) {
  $settings['config_sync_directory'] = 'sites/default/files/sync';
}

// Enable verbose logging for errors.
// https://www.drupal.org/forum/support/post-installation/2018-07-18/enable-drupal-8-backend-errorlogdebugging-mode
$config['system.logging']['error_level'] = 'verbose';
