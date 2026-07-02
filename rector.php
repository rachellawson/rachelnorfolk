<?php

/**
 * @file
 * Provides config for the rector tool to automatically update deprecated code.
 *
 * Usage: vendor/bin/rector process.
 */

declare(strict_types=1);

use DrupalRector\Set\DrupalSetProvider;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
  ->withPaths([
    __DIR__ . '/web/modules/custom',
  ])
  ->withSetProviders(DrupalSetProvider::class)
  ->withComposerBased(twig: TRUE, phpunit: TRUE, symfony: TRUE, drupal: TRUE);
