<?php

declare(strict_types=1);

namespace Drupal\osmand_tracking;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining an osmand track point entity type.
 */
interface OsmAndTrackPointInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
