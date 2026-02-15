<?php

declare(strict_types=1);

namespace Drupal\orienteer\Entity;

use Drupal\Core\Entity\Attribute\ContentEntityType;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\ContentEntityDeleteForm;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\Form\DeleteMultipleForm;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\orienteer\Form\VisitForm;
use Drupal\orienteer\Routing\VisitHtmlRouteProvider;
use Drupal\orienteer\VisitAccessControlHandler;
use Drupal\orienteer\VisitInterface;
use Drupal\orienteer\VisitListBuilder;
use Drupal\user\EntityOwnerTrait;
use Drupal\views\EntityViewsData;

/**
 * Defines the visit entity class.
 */
#[ContentEntityType(
  id: 'orienteer_visit',
  label: new TranslatableMarkup('Visit'),
  label_collection: new TranslatableMarkup('Visits'),
  label_singular: new TranslatableMarkup('visit'),
  label_plural: new TranslatableMarkup('visits'),
  entity_keys: [
    'id' => 'id',
    'label' => 'id',
    'owner' => 'uid',
    'uuid' => 'uuid',
  ],
  handlers: [
    'list_builder' => VisitListBuilder::class,
    'views_data' => EntityViewsData::class,
    'access' => VisitAccessControlHandler::class,
    'form' => [
      'add' => VisitForm::class,
      'edit' => VisitForm::class,
      'delete' => ContentEntityDeleteForm::class,
      'delete-multiple-confirm' => DeleteMultipleForm::class,
    ],
    'route_provider' => [
      'html' => VisitHtmlRouteProvider::class,
    ],
  ],
  links: [
    'collection' => '/admin/content/visit',
    'add-form' => '/visit/add',
    'canonical' => '/visit/{orienteer_visit}',
    'edit-form' => '/visit/{orienteer_visit}',
    'delete-form' => '/visit/{orienteer_visit}/delete',
    'delete-multiple-form' => '/admin/content/visit/delete-multiple',
  ],
  admin_permission: 'administer orienteer_visit',
  base_table: 'orienteer_visit',
  label_count: [
    'singular' => '@count visits',
    'plural' => '@count visits',
  ],
)]
class Visit extends ContentEntityBase implements VisitInterface {

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

    $fields['event'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Event this visit relates to'))
      ->setSetting('target_type', 'orienteer_visit')
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => 60,
          'placeholder' => '',
        ],
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'inline',
        'type' => 'entity_reference_label',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['location'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Location (normally, calculated)'))
      ->setSetting('target_type', 'orienteer_location')
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => 60,
          'placeholder' => '',
        ],
        'weight' => 1,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'entity_reference_label',
        'weight' => 1,
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
      ->setDescription(t('The time that the visit was created.'))
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
      ->setDescription(t('The time that the visit was last edited.'));

    return $fields;
  }

}
