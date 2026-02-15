<?php

declare(strict_types=1);

namespace Drupal\orienteer;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of location type entities.
 *
 * @see \Drupal\orienteer\Entity\LocationType
 */
final class LocationTypeListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['label'] = $this->t('Label');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    $row['label'] = $entity->label();
    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function render(): array {
    $build = parent::render();

    $build['table']['#empty'] = $this->t(
      'No location types available. <a href=":link">Add location type</a>.',
      [':link' => Url::fromRoute('entity.orienteer_location_type.add_form')->toString()],
    );

    return $build;
  }

}
