<?php

declare(strict_types=1);

namespace Drupal\osmand_tracking\Entity;

use Drupal\Core\Entity\Attribute\ContentEntityType;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\ContentEntityDeleteForm;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\Form\DeleteMultipleForm;
use Drupal\Core\Entity\Routing\AdminHtmlRouteProvider;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\osmand_tracking\Form\OsmAndTrackPointForm;
use Drupal\osmand_tracking\OsmAndTrackPointAccessControlHandler;
use Drupal\osmand_tracking\OsmAndTrackPointInterface;
use Drupal\osmand_tracking\OsmAndTrackPointListBuilder;
use Drupal\user\EntityOwnerTrait;
use Drupal\views\EntityViewsData;

/**
 * Defines the osmand track point entity class.
 */
#[ContentEntityType(
  id: 'osmand_track_point',
  label: new TranslatableMarkup('OsmAnd Track Point'),
  label_collection: new TranslatableMarkup('OsmAnd Track Points'),
  label_singular: new TranslatableMarkup('osmand track point'),
  label_plural: new TranslatableMarkup('osmand track points'),
  entity_keys: [
    'id' => 'id',
    'label' => 'id',
    'owner' => 'uid',
    'uuid' => 'uuid',
  ],
  handlers: [
    'list_builder' => OsmAndTrackPointListBuilder::class,
    'views_data' => EntityViewsData::class,
    'access' => OsmAndTrackPointAccessControlHandler::class,
    'form' => [
      'add' => OsmAndTrackPointForm::class,
      'edit' => OsmAndTrackPointForm::class,
      'delete' => ContentEntityDeleteForm::class,
      'delete-multiple-confirm' => DeleteMultipleForm::class,
    ],
    'route_provider' => [
      'html' => AdminHtmlRouteProvider::class,
    ],
  ],
  links: [
    'collection' => '/admin/content/osmand-track-point',
    'add-form' => '/osmand-track-point/add',
    'canonical' => '/osmand-track-point/{osmand_track_point}',
    'edit-form' => '/osmand-track-point/{osmand_track_point}/edit',
    'delete-form' => '/osmand-track-point/{osmand_track_point}/delete',
    'delete-multiple-form' => '/admin/content/osmand-track-point/delete-multiple',
  ],
  admin_permission: 'administer osmand_track_point',
  base_table: 'osmand_track_point',
  label_count: [
    'singular' => '@count OsmAnd track points',
    'plural' => '@count OsmAnd track points',
  ],
)]
class OsmAndTrackPoint extends ContentEntityBase implements OsmAndTrackPointInterface {

  use EntityChangedTrait;
  use EntityOwnerTrait;

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage): void {
    parent::preSave($storage);
    if (!$this->getOwnerId()) {
      // If no owner has been set explicitly, make the anonymous user the owner.
      $this->setOwnerId(0);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type): array {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['location'] = BaseFieldDefinition::create('geofield')
      ->setRevisionable(TRUE)
      ->setLabel(t('Location'))
      ->setSetting('backend', 'geofield_backend_default')
      ->setDisplayOptions('form', [
        'type' => 'geofield_latlon',
        'settings' => [
          'html5_geolocation' => FALSE,
        ],
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'geofield_latlon',
        'label' => 'above',
        'settings' => [
          'output_format' => 'decimal',
        ],
        'weight' => -4,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Author'))
      ->setSetting('target_type', 'user')
      ->setDefaultValueCallback(self::class . '::getDefaultEntityOwner')
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => 60,
          'placeholder' => '',
        ],
        'weight' => 15,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'author',
        'weight' => 15,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Authored on'))
      ->setDescription(t('The time that the osmand track point was created.'))
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'datetime_timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the osmand track point was last edited.'));

    return $fields;
  }

}
