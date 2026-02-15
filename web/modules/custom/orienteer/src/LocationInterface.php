<?php

declare(strict_types=1);

namespace Drupal\orienteer;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a location entity type.
 */
interface LocationInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
