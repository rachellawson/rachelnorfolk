<?php

/**
 * @file
 * Platform.sh example settings.php file for Drupal 8.
 */

// Default Drupal settings.
//
// These are already explained with detailed comments in Drupal's
// default.settings.php file.
//
// See https://api.drupal.org/api/drupal/sites!default!default.settings.php/8
$databases = [];
$config_directories = [];
$settings['update_free_access'] = FALSE;
$settings['container_yamls'][] = $app_root . '/' . $site_path . '/services.yml';
$settings['file_scan_ignore_directories'] = [
  'node_modules',
  'bower_components',
];

// The hash_salt should be a unique random value for each application.
// If left unset, the settings.platformsh.php file will attempt to provide one.
// You can also provide a specific value here if you prefer and it will be used
// instead. In most cases it's best to leave this blank on Platform.sh. You
// can configure a separate hash_salt in your settings.local.php file for
// local development.
// $settings['hash_salt'] = 'change_me';
// Note that hash_salt should not be in a file in git.

// Set up a config sync directory.
//
// This is defined inside the read-only "config" directory, deployed via Git.
$settings['config_sync_directory'] = '../config/sync';

// Automatic Platform.sh settings.
if (file_exists($app_root . '/' . $site_path . '/settings.platformsh.php')) {
  include $app_root . '/' . $site_path . '/settings.platformsh.php';
}

// Local settings. These come last so that they can override anything.
if (file_exists($app_root . '/' . $site_path . '/settings.local.php')) {
  include $app_root . '/' . $site_path . '/settings.local.php';
}

// Automatically generated include for settings managed by ddev.
if (file_exists($app_root . '/' . $site_path . '/settings.ddev.php') && getenv('IS_DDEV_PROJECT') == 'true') {
  include $app_root . '/' . $site_path . '/settings.ddev.php';
}

// Exclude any config that needs excluding.
$settings['config_exclude_modules'] = ['openid_connect', 'stage_file_proxy', 'upgrade_status', 'leaflet_more_maps'];

// String overrides.
$settings['locale_custom_strings_en'][''] = array(
  '<a href=":login">Log in</a> to post comments' => '<a href=":login">Log in with GitHub or Google</a> to post comments. Or, if you came across this post via Mastodon, just reply there!',
);

// Include settings required for Redis cache.
if ((file_exists(__DIR__ . '/settings.ddev.redis.php') && getenv('IS_DDEV_PROJECT') == 'true')) {
  include __DIR__ . '/settings.ddev.redis.php';
}
