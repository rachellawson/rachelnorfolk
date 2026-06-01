<?php

declare(strict_types=1);

namespace Drupal\osmand_tracking\Controller;

use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Returns responses for OsmAnd Tracking routes.
 */
final class OsmAndReceiver extends ControllerBase {

  /**
   * The controller constructor.
   */
  public function __construct() {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new self(
      $container->get('entity_type.manager'),
      $container->get('geofield.wkt_generator'),
    );
  }

  /**
   * @param $secret
   * @param AccountInterface $user
   * @param $lat
   * @param $lon
   * @param $alt
   * @param $timestamp
   * @param Request $request
   * @return array
   */
  public function content($secret, AccountInterface $user, Request $request) : array {

    // Look, if it doesn't match our site secret, why are we even bothering?
    if ($secret !== $this->config('osmand_tracking.settings')->get('secret')) {
      return [
        '#type' => 'markup',
        '#markup' => 'Invalid secret. Contact your site administrator.',
      ];
    }

    // Some values can be wonky in the path part of a url.
    $query = $request->query->all();

    // Make a suitable geofield from lat/lon.
    $location_wkt = \Drupal::service('geofield.wkt_generator')->wktBuildPoint([$query['lat'], $query['lon']]);
    $location_point = [
      'value' => $location_wkt,
    ];

    // Add a new osmand point entity for this data.
    $point = $this->entityTypeManager()->getStorage('osmand_track_point')->create([
      'location' => $location_point,
      'author' => $user,
      'created' => $query['timestamp'],
    ]);

    $point->save();

    return [
      '#markup' => $this->t('Hello, @user, I see you at @lat, @lon at @alt m, some time around @timestamp. The secret is @secret.',
        [
          '@user' => $user->getDisplayName(),
          '@lat' => $query['lat'],
          '@lon' => $query['lon'],
          '@alt' => $query['alt'],
          '@timestamp' => $query['timestamp'],
          '@secret' => $secret,
        ]),
    ];
  }

}
