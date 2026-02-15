<?php

declare(strict_types=1);

namespace Drupal\orienteer\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;
use Drupal\Core\Entity\Attribute\ConfigEntityType;
use Drupal\Core\Entity\EntityDeleteForm;
use Drupal\Core\Entity\Routing\AdminHtmlRouteProvider;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\orienteer\Form\LocationTypeForm;
use Drupal\orienteer\LocationTypeListBuilder;

/**
 * Defines the Location type configuration entity.
 */
#[ConfigEntityType(
  id: 'orienteer_location_type',
  label: new TranslatableMarkup('Location type'),
  label_collection: new TranslatableMarkup('Location types'),
  label_singular: new TranslatableMarkup('location type'),
  label_plural: new TranslatableMarkup('locations types'),
  config_prefix: 'orienteer_location_type',
  entity_keys: [
    'id' => 'id',
    'label' => 'label',
    'uuid' => 'uuid',
  ],
  handlers: [
    'list_builder' => LocationTypeListBuilder::class,
    'route_provider' => [
      'html' => AdminHtmlRouteProvider::class,
    ],
    'form' => [
      'add' => LocationTypeForm::class,
      'edit' => LocationTypeForm::class,
      'delete' => EntityDeleteForm::class,
    ],
  ],
  links: [
    'add-form' => '/admin/structure/orienteer_location_types/add',
    'edit-form' => '/admin/structure/orienteer_location_types/manage/{orienteer_location_type}',
    'delete-form' => '/admin/structure/orienteer_location_types/manage/{orienteer_location_type}/delete',
    'collection' => '/admin/structure/orienteer_location_types',
  ],
  admin_permission: 'administer orienteer_location types',
  bundle_of: 'orienteer_location',
  label_count: [
    'singular' => '@count location type',
    'plural' => '@count locations types',
  ],
  config_export: [
    'id',
    'label',
    'uuid',
  ],
)]
final class LocationType extends ConfigEntityBundleBase {

  /**
   * The machine name of this location type.
   */
  protected string $id;

  /**
   * The human-readable name of the location type.
   */
  protected string $label;

}
