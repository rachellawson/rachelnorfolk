<?php

namespace Drupal\rachelnorfolk_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides an example block.
 *
 * @Block(
 *   id = "rachelnorfolk_blocks_links",
 *   admin_label = @Translation("Links Block"),
 *   category = @Translation("rachelnorfolk blocks")
 * )
 */
class LinksBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return ['label_display' => FALSE];
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#theme' => 'links_block',
      '#data' => [
        'LinkedIn' => 'https://www.linkedin.com/in/rachel-norfolk',
        'Mastodon' => 'https://norfolk.social/@rachel',
      ],
    ];
  }

}
