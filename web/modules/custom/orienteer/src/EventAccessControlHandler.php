<?php

declare(strict_types=1);

namespace Drupal\orienteer;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Defines the access control handler for the event entity type.
 *
 * phpcs:disable Drupal.Arrays.Array.LongLineDeclaration
 *
 * @see https://www.drupal.org/project/coder/issues/3185082
 */
final class EventAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account): AccessResult {
    if ($account->hasPermission($this->entityType->getAdminPermission())) {
      return AccessResult::allowed()->cachePerPermissions();
    }

    return match($operation) {
      'view' => AccessResult::allowedIfHasPermission($account, 'view orienteer_event'),
      'update' => AccessResult::allowedIfHasPermission($account, 'edit orienteer_event'),
      'delete' => AccessResult::allowedIfHasPermission($account, 'delete orienteer_event'),
      'delete revision' => AccessResult::allowedIfHasPermission($account, 'delete orienteer_event revision'),
      'view all revisions', 'view revision' => AccessResult::allowedIfHasPermissions($account, ['view orienteer_event revision', 'view orienteer_event']),
      'revert' => AccessResult::allowedIfHasPermissions($account, ['revert orienteer_event revision', 'edit orienteer_event']),
      default => AccessResult::neutral(),
    };
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL): AccessResult {
    return AccessResult::allowedIfHasPermissions($account, ['create orienteer_event', 'administer orienteer_event'], 'OR');
  }

}
